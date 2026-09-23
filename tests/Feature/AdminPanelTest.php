<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_admin_can_access_filament_dashboard(): void
    {
        $admin = User::where('email', 'admin@hahacar.com')->first();

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('Hahacar Operations');
    }

    public function test_admin_can_view_providers_list(): void
    {
        $admin = User::where('email', 'admin@hahacar.com')->first();

        $response = $this->actingAs($admin)->get('/admin/providers');
        $response->assertStatus(200);
        $response->assertSee('Hahacar Global Rental Network');
    }
}
