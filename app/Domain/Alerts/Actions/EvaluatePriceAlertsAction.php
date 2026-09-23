<?php

namespace App\Domain\Alerts\Actions;

use App\Domain\Alerts\Notifications\PriceDropAlertNotification;
use App\Domain\Search\Data\SearchCriteria;
use App\Domain\Search\Services\SearchOrchestratorService;
use App\Models\PriceAlert;
use App\Models\PriceAlertRun;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class EvaluatePriceAlertsAction
{
    public function __construct(
        protected SearchOrchestratorService $searchOrchestrator
    ) {}

    public function execute(): int
    {
        $dueAlerts = PriceAlert::where('status', 'active')
            ->where('expires_at', '>', Carbon::now())
            ->where(function ($query) {
                $query->whereNull('next_check_at')
                    ->orWhere('next_check_at', '<=', Carbon::now());
            })
            ->with(['pickupLocation', 'dropoffLocation'])
            ->get();

        if ($dueAlerts->isEmpty()) {
            return 0;
        }

        // Group by criteria_hash to minimize provider queries
        $groupedAlerts = $dueAlerts->groupBy('criteria_hash');
        $triggeredCount = 0;

        foreach ($groupedAlerts as $criteriaHash => $alerts) {
            /** @var PriceAlert $firstAlert */
            $firstAlert = $alerts->first();

            $criteria = new SearchCriteria(
                pickupLocation: $firstAlert->pickupLocation,
                dropoffLocation: $firstAlert->dropoffLocation,
                pickupDatetime: $firstAlert->pickup_datetime,
                dropoffDatetime: $firstAlert->dropoff_datetime,
                currency: $firstAlert->currency
            );

            $startedAt = Carbon::now();

            try {
                $search = $this->searchOrchestrator->orchestrate($criteria);
                $lowestOffer = $search->offers->sortBy('total_price_minor')->first();

                if (!$lowestOffer) {
                    continue;
                }

                $newPriceMinor = $lowestOffer->total_price_minor;

                foreach ($alerts as $alert) {
                    $oldPriceMinor = $alert->last_best_price_minor ?? ($newPriceMinor + 1000);
                    $priceDropMinor = $oldPriceMinor - $newPriceMinor;

                    $qualifies = false;
                    if ($priceDropMinor > 0) {
                        $qualifies = match ($alert->threshold_type) {
                            'percentage' => (($priceDropMinor / $oldPriceMinor) * 100) >= $alert->threshold_value,
                            'fixed_amount' => ($priceDropMinor / 100) >= $alert->threshold_value,
                            default => true, // any_drop
                        };
                    }

                    // Check cooldown (at least 12 hours between notifications unless price dropped by > 15%)
                    $inCooldown = false;
                    if ($alert->last_notified_at && $alert->last_notified_at->diffInHours(now()) < 12) {
                        $inCooldown = true;
                    }

                    $decision = 'skipped_no_drop';

                    if ($qualifies && !$inCooldown) {
                        $decision = 'triggered';
                        $triggeredCount++;

                        // Dispatch notification
                        try {
                            Notification::route('mail', $alert->email)->notify(
                                new PriceDropAlertNotification(
                                    alert: $alert,
                                    oldPriceMinor: $oldPriceMinor,
                                    newPriceMinor: $newPriceMinor,
                                    bestOffer: $lowestOffer,
                                    plainManageToken: $alert->manage_token_hash ?? 'token'
                                )
                            );
                            $alert->update([
                                'last_notified_at' => Carbon::now(),
                            ]);
                        } catch (\Throwable $e) {
                            logger()->error("Failed sending price drop email to {$alert->email}: " . $e->getMessage());
                        }
                    } elseif ($qualifies && $inCooldown) {
                        $decision = 'skipped_cooldown';
                    }

                    // Record run log
                    PriceAlertRun::create([
                        'price_alert_id' => $alert->id,
                        'previous_price_minor' => $oldPriceMinor,
                        'new_price_minor' => $newPriceMinor,
                        'decision' => $decision,
                        'status' => 'success',
                        'started_at' => $startedAt,
                        'finished_at' => Carbon::now(),
                    ]);

                    // Update alert state and next check
                    $intervalHours = ($alert->frequency === 'real_time') ? 4 : 24;
                    $alert->update([
                        'last_best_price_minor' => min($oldPriceMinor, $newPriceMinor),
                        'last_checked_at' => Carbon::now(),
                        'next_check_at' => Carbon::now()->addHours($intervalHours),
                    ]);
                }
            } catch (\Throwable $e) {
                logger()->error("Error running alert evaluation for hash {$criteriaHash}: " . $e->getMessage());

                foreach ($alerts as $alert) {
                    PriceAlertRun::create([
                        'price_alert_id' => $alert->id,
                        'previous_price_minor' => $alert->last_best_price_minor,
                        'new_price_minor' => null,
                        'decision' => 'failed',
                        'status' => 'failed',
                        'error_details' => $e->getMessage(),
                        'started_at' => $startedAt,
                        'finished_at' => Carbon::now(),
                    ]);
                }
            }
        }

        return $triggeredCount;
    }
}
