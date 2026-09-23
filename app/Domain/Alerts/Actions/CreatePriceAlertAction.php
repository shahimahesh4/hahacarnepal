<?php

namespace App\Domain\Alerts\Actions;

use App\Domain\Alerts\Notifications\PriceAlertConfirmationNotification;
use App\Domain\Search\Data\SearchCriteria;
use App\Models\PriceAlert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class CreatePriceAlertAction
{
    public function execute(
        string $email,
        SearchCriteria $criteria,
        string $thresholdType = 'any_drop',
        float $thresholdValue = 0.0,
        string $frequency = 'daily',
        ?int $currentBestPriceMinor = null,
        ?int $userId = null
    ): PriceAlert {
        $plainVerifyToken = Str::random(40);
        $plainManageToken = Str::random(40);

        $alert = PriceAlert::updateOrCreate(
            [
                'email' => strtolower(trim($email)),
                'criteria_hash' => $criteria->hash(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'user_id' => $userId,
                'pickup_location_id' => $criteria->pickupLocation->id,
                'dropoff_location_id' => $criteria->dropoffLocation->id,
                'pickup_datetime' => $criteria->pickupDatetime,
                'dropoff_datetime' => $criteria->dropoffDatetime,
                'currency' => $criteria->currency,
                'threshold_type' => $thresholdType,
                'threshold_value' => $thresholdValue,
                'frequency' => $frequency,
                'last_best_price_minor' => $currentBestPriceMinor,
                'status' => 'pending_confirmation',
                'verify_token_hash' => hash('sha256', $plainVerifyToken),
                'manage_token_hash' => hash('sha256', $plainManageToken),
                'consent_version' => 'v1.0',
                'consented_at' => Carbon::now(),
                'next_check_at' => Carbon::now()->addHours(6),
                'expires_at' => $criteria->pickupDatetime,
            ]
        );

        // Send double opt-in confirmation notification
        try {
            Notification::route('mail', $alert->email)->notify(
                new PriceAlertConfirmationNotification($alert, $plainVerifyToken)
            );
        } catch (\Throwable $e) {
            // Log mail failure in background
            logger()->warning('Failed to dispatch alert confirmation email: ' . $e->getMessage());
        }

        return $alert;
    }
}
