<?php

namespace Tests\Feature;

use App\Livewire\DirectVehicleBooking;
use App\Models\Booking;
use App\Models\DriverProfile;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DirectVehicleBookingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create([
            'role' => 'driver',
            'phone' => '+977 9841234567',
        ]);

        $profile = DriverProfile::create([
            'user_id' => $user->id,
            'partner_type' => 'individual_driver',
            'status' => 'verified',
            'service_city' => 'Kathmandu',
            'rating' => 4.95,
            'total_bookings' => 12,
            'verified_at' => now(),
        ]);

        Vehicle::create([
            'driver_profile_id' => $profile->id,
            'category' => 'suv_4wd',
            'make' => 'Mahindra',
            'model' => 'Scorpio 4WD S11',
            'year' => 2024,
            'plate_number' => 'Ba 2 Cha 4521',
            'seating_capacity' => 7,
            'luggage_capacity' => 4,
            'transmission' => 'manual',
            'fuel_type' => 'diesel',
            'has_ac' => true,
            'has_4wd' => true,
            'daily_rate' => 4500,
            'provides_driver' => true,
            'allows_self_drive' => true,
            'is_active' => true,
        ]);
    }

    public function test_book_page_loads_successfully(): void
    {
        $response = $this->get('/book');
        $response->assertStatus(200);
        $response->assertSee('Direct Vehicle Booking in Nepal');
        $response->assertSee('Mahindra Scorpio 4WD S11');
    }

    public function test_customer_can_book_vehicle_directly(): void
    {
        $vehicle = Vehicle::first();

        Livewire::test(DirectVehicleBooking::class)
            ->set('selectedVehicleId', $vehicle->id)
            ->set('customerName', 'Aayush Shrestha')
            ->set('customerPhone', '+977 9811223344')
            ->set('customerEmail', 'aayush@example.com')
            ->set('pickupAddress', 'Hotel Yak & Yeti, Durbar Marg')
            ->set('paymentMethod', 'cash')
            ->call('confirmBooking')
            ->assertRedirect();

        $this->assertDatabaseHas('bookings', [
            'vehicle_id' => $vehicle->id,
            'customer_name' => 'Aayush Shrestha',
            'customer_phone' => '+977 9811223344',
            'status' => 'pending',
            'payment_method' => 'cash',
        ]);

        $booking = Booking::where('customer_phone', '+977 9811223344')->first();
        $this->assertNotNull($booking);
        $this->assertStringStartsWith('HHK-BK-', $booking->booking_reference);

        $voucherResponse = $this->get("/booking/{$booking->booking_reference}");
        $voucherResponse->assertStatus(200);
        $voucherResponse->assertSee($booking->booking_reference);
        $voucherResponse->assertSee('Aayush Shrestha');
        $voucherResponse->assertSee('Mahindra Scorpio 4WD S11');
    }
}
