<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class CmsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Pages
        $pages = [
            [
                'title' => 'How Hahakar Works',
                'slug' => 'how-it-works',
                'content' => "## How Hahakar Works\n\nHahakar is Nepal's premier vehicle rental comparison and direct booking network. We connect travelers directly with verified local drivers, vehicle owners, and licensed Nepali fleet operators (such as Himalayan Car Rental, Kathmandu Wheels, Pokhara Drive Co., Everest Tour Fleet, and Annapurna Safari Fleets).\n\n### 1. Search Nepal Inventory\nSelect your pickup hub (Kathmandu, Pokhara, Chitwan, Lumbini, Biratnagar, or Nepalgunj), dates, and preferred service mode (With Driver / Self-Drive).\n\n### 2. Compare Verified Vehicles\nFilter by vehicle type (4WD Scorpio, Hilux, Creta, Swift, HiAce Tourist Van, EV), transmission, luggage space, and seating capacity with transparent NPR rates.\n\n### 3. Book Direct with Instant Confirmation\nConfirm your reservation without upfront payment. Receive your digital voucher and pay directly upon vehicle handover.",
                'meta_title' => 'How It Works - Nepal Car Rental & Direct Booking | Hahakar',
                'meta_description' => 'Learn how Hahakar connects you with verified Nepal car rental fleets and drivers with transparent NPR pricing.',
            ],
            [
                'title' => 'About Hahakar',
                'slug' => 'about',
                'content' => "## About Hahakar Nepal\n\nHahakar was founded to bring transparency, safety, and reliability to vehicle rentals and road travel across Nepal.\n\nFrom high-clearance 4WD Scorpio expeditions to Muktinath and Mustang, to city hatchbacks in Kathmandu and tourist HiAce vans in Pokhara, we verify every driver license and vehicle bluebook.\n\n### Our Values\n- **100% Verified Fleets:** All vehicles and partner drivers are verified by our compliance team.\n- **Transparent NPR Rates:** All road taxes and fees included upfront. No surprise counter charges.\n- **Direct Mobility:** Instant reservations with digital confirmation vouchers.",
                'meta_title' => 'About Hahakar - Nepal\'s Mobility Network',
                'meta_description' => 'Discover Hahakar Nepal mission to provide safe, verified, and transparent vehicle rentals across Nepal.',
            ],
            [
                'title' => 'Terms & Conditions',
                'slug' => 'terms',
                'content' => "## Terms & Conditions\n\n*Effective Date: September 2026*\n\n### 1. Service Scope\nHahakar provides direct booking coordination and metasearch comparison for verified vehicle operators and drivers in Nepal.\n\n### 2. Pricing in Nepalese Rupees (NPR)\nAll prices are displayed in Nepalese Rupees (Rs. / NPR) and include applicable road taxes and standard inclusions.\n\n### 3. Driver Requirements\nFor self-drive rentals, drivers must present a valid physical Driving License (held for at least 1 year) and citizenship or passport ID upon vehicle pickup.",
                'meta_title' => 'Terms of Service | Hahakar Nepal',
                'meta_description' => 'Read Hahakar Nepal Terms and Conditions for vehicle rental and chauffeur services.',
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy',
                'content' => "## Privacy Policy\n\n*Effective Date: September 2026*\n\nAt Hahakar, your privacy is protected. We collect only necessary details (name, contact number, pickup location) required to coordinate your vehicle booking with verified partner drivers.\n\n### Data Protection\nWe do not sell personal data to third parties. Contact details are strictly shared with your assigned driver or operator for pickup coordination.",
                'meta_title' => 'Privacy Policy | Hahakar Nepal',
                'meta_description' => 'Read our privacy policy and learn how Hahakar Nepal protects your personal information.',
            ],
            [
                'title' => 'Cookie Policy',
                'slug' => 'cookies',
                'content' => "## Cookie Policy\n\nWe use essential cookies to maintain your search session, booking progress, and preferred pickup location preferences.",
                'meta_title' => 'Cookie Policy | Hahakar Nepal',
                'meta_description' => 'Learn how Hahakar uses cookies for site navigation and session preferences.',
            ],
        ];

        foreach ($pages as $p) {
            Page::updateOrCreate(
                ['slug' => $p['slug']],
                array_merge($p, ['is_published' => true, 'published_at' => now()])
            );
        }

        // 2. FAQs
        $faqs = [
            [
                'category' => 'General',
                'question' => 'What types of vehicles are available for rent in Nepal?',
                'answer' => 'We offer vehicles suited for all Nepal terrain: 4WD Mountain SUVs (Mahindra Scorpio, Toyota Hilux), Tourist Vans (Toyota HiAce 14-seater, Force Traveller), Compact SUVs (Hyundai Creta), City Hatchbacks (Suzuki Swift, Grand i10), Electric Vehicles (BYD Atto 3 EV), and Premium 4WDs (Toyota Prado).',
                'sort_order' => 1,
            ],
            [
                'category' => 'Booking & Chauffeur',
                'question' => 'Can I hire a car with an experienced local driver?',
                'answer' => 'Yes! You can choose "With Driver (Chauffeur)" for any vehicle. Our verified drivers are experienced with Nepal mountain highways, Prithvi Highway turns, and high-altitude routes like Mustang and Pokhara.',
                'sort_order' => 2,
            ],
            [
                'category' => 'Self-Drive',
                'question' => 'What documents are required for Self-Drive car rental in Nepal?',
                'answer' => 'For self-drive rentals, you need a valid physical Nepali Driving License or International Driving Permit (IDP), plus a copy of your Citizenship card or Passport.',
                'sort_order' => 3,
            ],
            [
                'category' => 'Pricing & Payment',
                'question' => 'How and when do I pay for my vehicle booking?',
                'answer' => 'You can book directly with zero prepayment! Pay in Nepalese Rupees (NPR) via Cash or digital wallet (eSewa / QR) directly upon vehicle handover or pickup.',
                'sort_order' => 4,
            ],
            [
                'category' => 'Cancellation',
                'question' => 'What is the cancellation policy?',
                'answer' => 'Most bookings on Hahakar feature free cancellation up to 24-48 hours before your scheduled pickup time.',
                'sort_order' => 5,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['question' => $faq['question']],
                array_merge($faq, ['is_published' => true])
            );
        }

        // 3. Settings
        $settings = [
            ['key' => 'site_name', 'value' => 'Hahakar Nepal', 'group' => 'general', 'description' => 'Public brand name'],
            ['key' => 'support_email', 'value' => 'support@hahakar.com', 'group' => 'contact', 'description' => 'Main customer support inbox'],
            ['key' => 'default_currency', 'value' => 'NPR', 'group' => 'general', 'description' => 'Default platform currency'],
            ['key' => 'rate_per_km_petrol', 'value' => '250', 'group' => 'distance_pricing', 'description' => 'Default rate per km for Petrol vehicles (Rs./km)'],
            ['key' => 'rate_per_km_diesel', 'value' => '250', 'group' => 'distance_pricing', 'description' => 'Default rate per km for Diesel vehicles (Rs./km)'],
            ['key' => 'rate_per_km_electric', 'value' => '70', 'group' => 'distance_pricing', 'description' => 'Default rate per km for Electric EVs (Rs./km)'],
            ['key' => 'rate_per_km_hybrid', 'value' => '160', 'group' => 'distance_pricing', 'description' => 'Default rate per km for Hybrid vehicles (Rs./km)'],
            ['key' => 'alert_cooldown_hours', 'value' => '12', 'group' => 'alerts', 'description' => 'Minimum hours between alert notifications for same criteria'],
            ['key' => 'ranking_weight_price', 'value' => '0.45', 'group' => 'ranking', 'description' => 'Ranking weight for total price'],
            ['key' => 'ranking_weight_terms', 'value' => '0.15', 'group' => 'ranking', 'description' => 'Ranking weight for terms completeness'],
            ['key' => 'ranking_weight_supplier', 'value' => '0.15', 'group' => 'ranking', 'description' => 'Ranking weight for supplier star rating'],
            ['key' => 'ranking_weight_cancellation', 'value' => '0.10', 'group' => 'ranking', 'description' => 'Ranking weight for free cancellation'],
            ['key' => 'ranking_weight_freshness', 'value' => '0.10', 'group' => 'ranking', 'description' => 'Ranking weight for data freshness'],
            ['key' => 'ranking_weight_commercial', 'value' => '0.05', 'group' => 'ranking', 'description' => 'Ranking weight for commercial boost (capped)'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
