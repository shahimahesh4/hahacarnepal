<?php

namespace Tests\Feature;

use App\Domain\Search\Data\SearchCriteria;
use App\Domain\Search\Services\SearchOrchestratorService;
use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_home_page_loads_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Compare Car Rentals');
    }

    public function test_search_orchestrator_returns_ranked_offers(): void
    {
        $pickup = Location::where('iata_code', 'KTM')->first();
        $dropoff = $pickup;

        $criteria = new SearchCriteria(
            pickupLocation: $pickup,
            dropoffLocation: $dropoff,
            pickupDatetime: Carbon::now()->addDays(2),
            dropoffDatetime: Carbon::now()->addDays(5)
        );

        /** @var SearchOrchestratorService $orchestrator */
        $orchestrator = app(SearchOrchestratorService::class);
        $search = $orchestrator->orchestrate($criteria);

        $this->assertNotNull($search);
        $this->assertEquals('completed', $search->status);
        $this->assertGreaterThan(0, $search->offers->count());

        $firstOffer = $search->offers->first();
        $this->assertNotEmpty($firstOffer->vehicle_name);
        $this->assertGreaterThan(0, $firstOffer->total_price_minor);
        $this->assertNotNull($firstOffer->ranking_score);
    }

    public function test_search_results_page_renders_with_offers(): void
    {
        $pickup = Location::where('iata_code', 'KTM')->first();

        $response = $this->get(route('search.index', [
            'pickup' => $pickup->id,
            'from' => Carbon::now()->addDays(2)->format('Y-m-d\TH:i'),
            'to' => Carbon::now()->addDays(5)->format('Y-m-d\TH:i'),
        ]));

        $response->assertStatus(200);
        $response->assertSee('Compare Car Rental Offers');
        $response->assertSee('Instant Confirmation');
        $response->assertSee('Book Now');
    }

    public function test_user_can_book_directly_from_search_results(): void
    {
        $pickup = Location::where('iata_code', 'KTM')->first();
        
        $search = app(SearchOrchestratorService::class)->orchestrate(
            new SearchCriteria(
                pickupLocation: $pickup,
                dropoffLocation: $pickup,
                pickupDatetime: Carbon::now()->addDays(2),
                dropoffDatetime: Carbon::now()->addDays(5)
            )
        );

        $offer = $search->offers->first();

        \Livewire\Livewire::test(\App\Livewire\SearchResults::class, [
            'pickup' => $pickup->id,
            'dropoff' => $pickup->id,
            'from' => Carbon::now()->addDays(2)->format('Y-m-d\TH:i'),
            'to' => Carbon::now()->addDays(5)->format('Y-m-d\TH:i'),
        ])
            ->call('selectOffer', $offer->id)
            ->assertSet('isBookingModalOpen', true)
            ->set('customerName', 'Binod Chaudhary')
            ->set('customerPhone', '+977 9801122334')
            ->set('customerEmail', 'binod@chaudhary.com')
            ->set('paymentMethod', 'cash')
            ->call('confirmBooking')
            ->assertRedirect();

        $this->assertDatabaseHas('bookings', [
            'customer_name' => 'Binod Chaudhary',
            'customer_phone' => '+977 9801122334',
            'payment_method' => 'cash',
        ]);
    }
}
