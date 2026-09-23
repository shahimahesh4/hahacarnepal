<?php

namespace Tests\Feature;

use App\Domain\Alerts\Actions\CreatePriceAlertAction;
use App\Domain\Alerts\Actions\EvaluatePriceAlertsAction;
use App\Domain\Search\Data\SearchCriteria;
use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PriceAlertTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_price_alert_creation_and_confirmation(): void
    {
        $pickup = Location::where('iata_code', 'KTM')->first();
        $criteria = new SearchCriteria(
            pickupLocation: $pickup,
            dropoffLocation: $pickup,
            pickupDatetime: Carbon::now()->addDays(2),
            dropoffDatetime: Carbon::now()->addDays(5)
        );

        /** @var CreatePriceAlertAction $action */
        $action = app(CreatePriceAlertAction::class);
        $alert = $action->execute(
            email: 'traveler@example.com',
            criteria: $criteria,
            thresholdType: 'any_drop',
            currentBestPriceMinor: 15000
        );

        $this->assertEquals('pending_confirmation', $alert->status);
        $this->assertNotNull($alert->verify_token_hash);

        // Confirm alert and make due for check with higher last_best_price
        $alert->update([
            'status' => 'active',
            'verify_token_hash' => null,
            'last_best_price_minor' => 1500000, // Higher than mock NPR rates so price drop triggers
            'next_check_at' => Carbon::now()->subMinute(),
        ]);

        /** @var EvaluatePriceAlertsAction $evaluator */
        $evaluator = app(EvaluatePriceAlertsAction::class);
        $triggered = $evaluator->execute();

        $this->assertGreaterThanOrEqual(1, $triggered);
        $this->assertDatabaseHas('price_alert_runs', [
            'price_alert_id' => $alert->id,
            'decision' => 'triggered',
        ]);
    }
}
