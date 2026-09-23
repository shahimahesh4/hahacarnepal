<?php

namespace Tests\Feature;

use App\Models\DriverProfile;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPartnerVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_verify_pending_driver_partner(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@hahacar.com',
            'role' => 'admin',
            'status' => 'active',
        ]);

        $driver = User::factory()->create([
            'name' => 'Kiran Thapa',
            'email' => 'kiran@example.com',
            'role' => 'driver',
            'status' => 'active',
            'phone' => '+977 9841001122',
        ]);

        $profile = DriverProfile::create([
            'user_id' => $driver->id,
            'partner_type' => 'individual_driver',
            'status' => 'pending', // Pending
            'service_city' => 'Kathmandu',
            'license_number' => '01-06-00123456',
            'rating' => 5.00,
            'total_bookings' => 0,
        ]);

        Vehicle::create([
            'driver_profile_id' => $profile->id,
            'category' => 'suv_4wd',
            'make' => 'Mahindra',
            'model' => 'Scorpio 4WD',
            'year' => 2023,
            'plate_number' => 'Ba 2 Cha 9900',
            'daily_rate' => 4500,
            'provides_driver' => true,
            'allows_self_drive' => true,
            'is_active' => true,
        ]);

        $this->actingAs($admin);

        // Access admin drivers list
        $response = $this->get('/admin/drivers');
        $response->assertStatus(200);
        $response->assertSee('Kiran Thapa');

        // Admin verification update
        $profile->update([
            'status' => 'verified',
            'verified_at' => now(),
        ]);

        $this->assertDatabaseHas('driver_profiles', [
            'id' => $profile->id,
            'status' => 'verified',
        ]);

        // Now vehicle should be visible on public direct booking page
        $bookResponse = $this->get('/book');
        $bookResponse->assertStatus(200);
        $bookResponse->assertSee('Mahindra Scorpio 4WD');
    }
}
