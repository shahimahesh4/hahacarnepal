<?php

namespace Tests\Feature;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        $this->seed();
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_homepage_renders_dynamic_seo_and_social_meta_tags(): void
    {
        Setting::set('seo_meta_title', 'Nepal Car Rental - Hahakar', 'seo');
        Setting::set('seo_meta_description', 'Rent Scorpio 4WD and HiAce in Nepal.', 'seo');
        Setting::set('seo_robots', 'index, follow, max-image-preview:large', 'seo');
        Setting::set('seo_theme_color', '#070d1e', 'seo');
        Setting::set('seo_og_locale', 'en_NP', 'seo');
        Setting::set('seo_twitter_card', 'summary_large_image', 'seo');

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('<meta name="description" content="Rent Scorpio 4WD and HiAce in Nepal.">', false);
        $response->assertSee('<meta name="robots" content="index, follow, max-image-preview:large">', false);
        $response->assertSee('<meta name="theme-color" content="#070d1e">', false);
        $response->assertSee('rel="canonical"', false);
        $response->assertSee('property="og:type" content="website"', false);
        $response->assertSee('property="og:locale" content="en_NP"', false);
        $response->assertSee('name="twitter:card" content="summary_large_image"', false);
    }
}
