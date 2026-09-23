<?php

namespace Tests\Feature;

use App\Domain\Search\Data\SearchCriteria;
use App\Domain\Search\Services\SearchOrchestratorService;
use App\Models\Location;
use App\Models\OutboundClick;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OutboundRedirectTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_signed_redirect_records_click_and_redirects(): void
    {
        $pickup = Location::where('iata_code', 'KTM')->first();
        $criteria = new SearchCriteria(
            pickupLocation: $pickup,
            dropoffLocation: $pickup,
            pickupDatetime: Carbon::now()->addDays(2),
            dropoffDatetime: Carbon::now()->addDays(5)
        );

        /** @var SearchOrchestratorService $orchestrator */
        $orchestrator = app(SearchOrchestratorService::class);
        $search = $orchestrator->orchestrate($criteria);
        $offer = $search->offers->first();

        $response = $this->get(route('go.redirect', ['offer' => $offer->uuid]), [
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0 Safari/537.36',
        ]);

        $response->assertStatus(302);
        $cacheControl = $response->headers->get('Cache-Control');
        $this->assertStringContainsString('no-store', $cacheControl);
        $this->assertStringContainsString('no-cache', $cacheControl);

        $this->assertDatabaseHas('outbound_clicks', [
            'offer_id' => $offer->id,
            'search_id' => $search->id,
        ]);

        $click = OutboundClick::where('offer_id', $offer->id)->first();
        $this->assertNotNull($click->ip_hash);
        $this->assertEquals('desktop', $click->device_type);
    }
}
