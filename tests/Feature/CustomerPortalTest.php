<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\DriverProfile;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CustomerPortalTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_register_and_is_redirected_to_dashboard(): void
    {
        Livewire::test('customer-register')
            ->set('name', 'Sita Sharma')
            ->set('email', 'sita@example.com')
            ->set('phone', '9841234567')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->call('register')
            ->assertRedirect(route('customer.dashboard'));

        $this->assertDatabaseHas('users', [
            'email' => 'sita@example.com',
            'name' => 'Sita Sharma',
            'role' => 'user',
        ]);

        $this->assertAuthenticated();
    }

    public function test_customer_can_login_via_livewire_component(): void
    {
        $user = User::factory()->create([
            'email' => 'ram@example.com',
            'password' => bcrypt('secret123'),
            'role' => 'user',
        ]);

        Livewire::test('customer-login')
            ->set('email', 'ram@example.com')
            ->set('password', 'secret123')
            ->call('login')
            ->assertRedirect(route('customer.dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_customer_dashboard_displays_their_bookings_and_allows_cancellation(): void
    {
        $user = User::factory()->create([
            'email' => 'ram@example.com',
            'role' => 'user',
        ]);

        $driver = User::factory()->create(['role' => 'driver']);
        $profile = DriverProfile::create([
            'user_id' => $driver->id,
            'partner_type' => 'individual_driver',
            'status' => 'verified',
            'service_city' => 'Kathmandu',
            'license_number' => 'DL-9999-NP',
        ]);

        $vehicle = Vehicle::create([
            'driver_profile_id' => $profile->id,
            'category' => 'suv',
            'make' => 'Mahindra',
            'model' => 'Scorpio',
            'year' => 2023,
            'plate_number' => 'BA 12 PA 9999',
            'seating_capacity' => 7,
            'luggage_capacity' => 4,
            'transmission' => 'manual',
            'fuel_type' => 'diesel',
            'daily_rate' => 7500,
            'rate_per_km' => 250,
            'is_active' => true,
        ]);

        $this->actingAs($user);

        $booking = Booking::create([
            'vehicle_id' => $vehicle->id,
            'driver_profile_id' => $profile->id,
            'customer_id' => $user->id,
            'customer_name' => 'Ram Shrestha',
            'customer_email' => 'ram@example.com',
            'customer_phone' => '9800000000',
            'pickup_location' => 'Tribhuvan International Airport, Kathmandu',
            'return_location' => 'Lakeside, Pokhara',
            'pickup_date' => now()->addDays(2),
            'return_date' => now()->addDays(3),
            'total_days' => 1,
            'daily_rate' => 7500,
            'total_price' => 7500,
            'status' => 'pending',
            'payment_method' => 'cash',
            'payment_status' => 'pending',
        ]);

        Livewire::test('customer-dashboard')
            ->assertSee($booking->booking_reference)
            ->assertSee('Lakeside, Pokhara')
            ->call('cancelBooking', $booking->id);

        $this->assertEquals('cancelled', $booking->fresh()->status);
    }

    public function test_partner_dashboard_allows_trip_confirmation(): void
    {
        $partnerUser = User::factory()->create([
            'name' => 'Gopal Gurung',
            'email' => 'driver@hahakar.com',
            'role' => 'driver',
        ]);

        $profile = DriverProfile::create([
            'user_id' => $partnerUser->id,
            'partner_type' => 'rental_company',
            'status' => 'verified',
            'service_city' => 'Pokhara',
            'license_number' => 'DL-5555-NP',
        ]);

        $vehicle = Vehicle::create([
            'driver_profile_id' => $profile->id,
            'category' => 'suv',
            'make' => 'Mahindra',
            'model' => 'Scorpio 4x4',
            'year' => 2024,
            'plate_number' => 'GA 1 PA 4444',
            'seating_capacity' => 7,
            'luggage_capacity' => 4,
            'transmission' => 'manual',
            'fuel_type' => 'diesel',
            'daily_rate' => 8000,
            'rate_per_km' => 250,
            'is_active' => true,
        ]);

        $booking = Booking::create([
            'vehicle_id' => $vehicle->id,
            'driver_profile_id' => $profile->id,
            'customer_name' => 'Hari Thapa',
            'customer_email' => 'hari@example.com',
            'customer_phone' => '9841000000',
            'pickup_location' => 'Kathmandu',
            'return_location' => 'Pokhara',
            'pickup_date' => now()->addDays(1),
            'return_date' => now()->addDays(2),
            'total_days' => 1,
            'daily_rate' => 8000,
            'total_price' => 8000,
            'status' => 'pending',
            'payment_method' => 'cash',
            'payment_status' => 'pending',
        ]);

        $this->actingAs($partnerUser);

        Livewire::test('partner-dashboard')
            ->assertSee($booking->booking_reference)
            ->call('confirmBooking', $booking->id);

        $this->assertEquals('confirmed', $booking->fresh()->status);
    }

    public function test_customer_can_view_and_pause_price_alerts(): void
    {
        $user = User::factory()->create([
            'email' => 'alerts@example.com',
            'role' => 'user',
        ]);

        $loc1 = \App\Models\Location::create([
            'name' => 'Kathmandu Hub',
            'slug' => 'kathmandu-hub',
            'city' => 'Kathmandu',
            'country' => 'Nepal',
            'country_code' => 'NP',
            'is_active' => true,
        ]);

        $loc2 = \App\Models\Location::create([
            'name' => 'Pokhara Hub',
            'slug' => 'pokhara-hub',
            'city' => 'Pokhara',
            'country' => 'Nepal',
            'country_code' => 'NP',
            'is_active' => true,
        ]);

        $alert = \App\Models\PriceAlert::create([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'email' => 'alerts@example.com',
            'user_id' => $user->id,
            'pickup_location_id' => $loc1->id,
            'dropoff_location_id' => $loc2->id,
            'pickup_datetime' => now()->addDays(5),
            'dropoff_datetime' => now()->addDays(8),
            'criteria_hash' => md5('test'),
            'currency' => 'NPR',
            'threshold_type' => 'target_price',
            'threshold_value' => 5000,
            'frequency' => 'daily',
            'status' => 'active',
        ]);

        $this->actingAs($user);

        Livewire::test('customer-dashboard')
            ->set('activeTab', 'alerts')
            ->assertSee('Kathmandu Hub ➔ Pokhara Hub')
            ->assertSee('Rs. 5,000')
            ->call('unsubscribeAlert', $alert->id);

        $this->assertEquals('cancelled', $alert->fresh()->status);
    }
}
