<?php

namespace Tests\Feature;

use App\Livewire\PartnerRegistration;
use App\Models\DriverProfile;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PartnerRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_partner_registration_page_loads(): void
    {
        $response = $this->get('/partner/register');
        $response->assertStatus(200);
        $response->assertSee('Register Your Vehicle & Drive', false);
    }

    public function test_driver_partner_can_register_with_pending_status(): void
    {
        Livewire::test(PartnerRegistration::class)
            // Step 1
            ->set('name', 'Prakash Tamang')
            ->set('email', 'prakash@example.com')
            ->set('phone', '+977 9866112233')
            ->set('password', 'secret123')
            ->set('serviceCity', 'Pokhara')
            ->set('partnerType', 'vehicle_owner')
            ->call('nextStep')
            ->assertSet('step', 2)

            // Step 2
            ->set('licenseNumber', '04-06-00998877')
            ->call('nextStep')
            ->assertSet('step', 3)

            // Step 3
            ->set('vehicleMake', 'Toyota')
            ->set('vehicleModel', 'Hilux 4x4')
            ->set('plateNumber', 'Ga 2 Cha 8899')
            ->set('dailyRate', 6000)
            ->call('submitApplication')
            ->assertSet('isSubmitted', true);

        // Verify User was created
        $user = User::where('email', 'prakash@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('driver', $user->role);

        // Verify DriverProfile was created in pending status
        $profile = DriverProfile::where('user_id', $user->id)->first();
        $this->assertNotNull($profile);
        $this->assertEquals('pending', $profile->status);
        $this->assertEquals('Pokhara', $profile->service_city);
        $this->assertEquals('04-06-00998877', $profile->license_number);

        // Verify Vehicle was created
        $vehicle = Vehicle::where('driver_profile_id', $profile->id)->first();
        $this->assertNotNull($vehicle);
        $this->assertEquals('Toyota', $vehicle->make);
        $this->assertEquals('Hilux 4x4', $vehicle->model);
        $this->assertEquals(6000, $vehicle->daily_rate);
    }
}
