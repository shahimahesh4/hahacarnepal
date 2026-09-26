<?php

namespace Tests\Feature;

use App\Models\Faq;
use App\Models\Location;
use App\Models\Page;
use App\Models\Setting;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BrokenLinksAndAssetsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_all_public_get_routes_respond_with_200(): void
    {
        $publicRoutes = [
            '/',
            '/book-vehicle',
            '/search',
            '/customer/login',
            '/customer/register',
            '/partner/register',
            '/partner/dashboard',
            '/contact',
            '/faq',
            '/how-it-works',
            '/about',
            '/terms',
            '/privacy',
            '/cookies',
            '/affiliate-disclosure',
        ];

        foreach ($publicRoutes as $url) {
            $start = microtime(true);
            $response = $this->get($url);
            $duration = (microtime(true) - $start) * 1000;

            $this->assertEquals(200, $response->status(), "URL [{$url}] returned status {$response->status()} instead of 200");
            $this->assertLessThan(1500, $duration, "Page {$url} took {$duration}ms which exceeds 1500ms");
        }
    }

    public function test_redirect_routes_function_properly(): void
    {
        $response = $this->get('/book');
        $response->assertRedirect('/book-vehicle');
    }

    public function test_all_referenced_images_exist_in_public_directory(): void
    {
        $expectedImages = [
            'favicon.ico',
            'logo.png',
            'images/logo.png',
            'images/destinations/kathmandu.jpg',
            'images/destinations/pokhara.jpg',
            'images/destinations/chitwan.jpg',
            'images/destinations/lumbini.jpg',
            'images/destinations/biratnagar.jpg',
            'images/destinations/nepalgunj.jpg',
            'images/vehicles/scorpio.jpg',
            'images/vehicles/hiace.jpg',
            'images/vehicles/swift.jpg',
            'images/vehicles/creta.jpg',
            'images/vehicles/byd_atto3.jpg',
            'images/vehicles/prado.jpg',
            'images/vehicles/hilux.jpg',
            'images/vehicles/bolero.jpg',
            'images/vehicles/force_traveller.jpg',
            'images/vehicles/dzire.jpg',
        ];

        foreach ($expectedImages as $image) {
            $path = public_path($image);
            $this->assertFileExists($path, "Missing asset image: {$image}");
        }
    }

    public function test_all_cms_pages_load_with_correct_status_and_content(): void
    {
        $pages = Page::where('is_published', true)->get();
        $this->assertNotEmpty($pages, 'No published CMS pages found in database');

        foreach ($pages as $page) {
            $response = $this->get("/{$page->slug}");
            $response->assertStatus(200);
            $response->assertSee($page->title);
        }
    }

    public function test_admin_panel_routes_load_and_have_no_broken_assets(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@hahakar.com'],
            ['name' => 'System Admin', 'role' => 'admin', 'status' => 'active', 'password' => bcrypt('password')]
        );

        $this->actingAs($admin);

        $adminUrls = [
            '/stnapanel',
            '/stnapanel/bookings',
            '/stnapanel/drivers',
            '/stnapanel/vehicles',
            '/stnapanel/locations',
            '/stnapanel/faqs',
            '/stnapanel/pages',
            '/stnapanel/settings',
            '/stnapanel/manage-website-settings',
            '/stnapanel/subscribers',
            '/stnapanel/newsletter-campaigns',
            '/stnapanel/contact-messages',
        ];

        foreach ($adminUrls as $url) {
            $response = $this->get($url);
            $response->assertStatus(200);
        }
    }
}
