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
                'title' => 'How Hahacar Works',
                'slug' => 'how-it-works',
                'content' => "## How Hahacar Works\n\nHahacar is a car rental metasearch comparison and referral platform. We do not own fleets or handle car pickups directly. Instead, we scan licensed car-rental suppliers (such as Enterprise, Hertz, Avis, Budget, Europcar, and Sixt) and online travel partners in real time to present you with clear, side-by-side comparisons.\n\n### 1. Search Real-Time Inventory\nEnter your pickup location, dates, times, and optional different drop-off. We instantly gather available vehicles, categories, and transparent pricing.\n\n### 2. Compare Unbiased Offers\nFilter by vehicle size, transmission, supplier rating, fuel rules, and deposit requirements. Our default Recommended sort weighs price, supplier quality, terms completeness, and flexibility.\n\n### 3. Book Direct with the Merchant of Record\nWhen you click 'View Deal', we securely connect you to the supplier or travel agency where you complete your reservation. The provider is the merchant of record and manages your payment, changes, and confirmation.",
                'meta_title' => 'How It Works - Transparent Car Rental Comparison | Hahacar',
                'meta_description' => 'Learn how Hahacar compares car rental rates from top suppliers to help you find and book the best deals.',
            ],
            [
                'title' => 'About Hahacar',
                'slug' => 'about',
                'content' => "## About Hahacar\n\nHahacar was founded with a singular purpose: to bring honesty, speed, and clarity to the global car rental market.\n\nToo often, travelers face confusing insurance upsells, ambiguous fuel policies, and unexpected fees at the rental counter. Hahacar cuts through the noise by normalizing terms, detailing deposit amounts, and showing all-inclusive pricing upfront.\n\n### Our Values\n- **Transparency First:** No hidden fees, no deceptive sorting.\n- **Independent Comparison:** Commercial partnerships never override customer sort preferences.\n- **Traveler Privacy:** We never sell personal data or spam users.",
                'meta_title' => 'About Hahacar - Our Mission & Story',
                'meta_description' => 'Discover Hahacar mission to make car rental search transparent, fast, and reliable worldwide.',
            ],
            [
                'title' => 'Terms & Conditions',
                'slug' => 'terms',
                'content' => "## Terms & Conditions\n\n*Effective Date: September 2026*\n\n### 1. Platform Nature\nHahacar is a comparison and referral service only. Hahacar is not a licensed rental operator, travel agent, or merchant of record for rental contracts.\n\n### 2. Pricing & Availability\nPrices and vehicle availability displayed on Hahacar are dynamic and provided by third-party inventory partners. While we strive for absolute accuracy, final prices and terms are established by the provider at checkout.\n\n### 3. Merchant Responsibility\nRental agreements, payments, cancellations, security deposits, and vehicle condition are strictly between the traveler and the selected rental partner.",
                'meta_title' => 'Terms of Service | Hahacar',
                'meta_description' => 'Read Hahacar Terms and Conditions for using our car rental comparison service.',
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy',
                'content' => "## Privacy Policy\n\n*Effective Date: September 2026*\n\nAt Hahacar, your privacy is paramount. This policy outlines how we handle information:\n\n### 1. Information We Collect\n- Search criteria (locations, dates, currency)\n- Anonymized device and referral data\n- Email addresses when you explicitly opt in to price alerts or newsletters\n\n### 2. How We Use Data\nWe use search data to query providers, compute rankings, and send requested price-drop alerts. We do not sell user data to data brokers.\n\n### 3. Your Rights\nYou can unsubscribe from price alerts at any time via the one-click link included in every alert email.",
                'meta_title' => 'Privacy Policy | Hahacar',
                'meta_description' => 'Read our comprehensive privacy policy and learn how Hahacar protects your personal information.',
            ],
            [
                'title' => 'Cookie Policy',
                'slug' => 'cookies',
                'content' => "## Cookie Policy\n\nWe use cookies and similar technologies to ensure our website functions correctly, understand site traffic, and optimize outbound partner referrals.\n\n### Types of Cookies We Use\n- **Necessary Cookies:** Essential for page navigation, search state, and security.\n- **Analytics Cookies:** Help us measure search performance and identify errors.\n- **Marketing & Attribution Cookies:** Record outbound partner clicks for referral attribution.\n\nYou can manage or revoke your cookie preferences at any time via our Cookie Preferences banner.",
                'meta_title' => 'Cookie Policy | Hahacar',
                'meta_description' => 'Learn how Hahacar uses cookies for site functionality, performance, and referral attribution.',
            ],
            [
                'title' => 'Affiliate Disclosure',
                'slug' => 'affiliate-disclosure',
                'content' => "## Affiliate & Referral Disclosure\n\nHahacar is an independent comparison website. When you click through our links to book a rental vehicle with a partner supplier or online travel agency, we may receive a commission or referral fee at no extra cost to you.\n\nThis commercial relationship does not influence our unbiased price sorting or hide competitor rates. Sponsored deals are always clearly labeled.",
                'meta_title' => 'Affiliate Disclosure | Hahacar',
                'meta_description' => 'Transparency statement regarding affiliate commissions and referral compensation on Hahacar.',
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
                'question' => 'How does Hahacar compare car rental prices?',
                'answer' => 'Hahacar connects directly to leading car-rental providers, online travel agencies, and local fleets. When you enter your destination and dates, our engine scans all providers simultaneously, normalizes vehicle categories and insurance terms, and displays results ranked by best value.',
                'sort_order' => 1,
            ],
            [
                'category' => 'General',
                'question' => 'Do I pay Hahacar or the car rental company?',
                'answer' => 'You pay the car rental provider directly. Hahacar is a comparison search engine. When you choose a deal, we redirect you to the official partner website to complete your reservation securely.',
                'sort_order' => 2,
            ],
            [
                'category' => 'Booking & Terms',
                'question' => 'Are taxes and fees included in the prices shown?',
                'answer' => 'Yes! Hahacar displays all mandatory taxes, airport surcharges, and location fees upfront in the total price, so you are never surprised at checkout.',
                'sort_order' => 3,
            ],
            [
                'category' => 'Booking & Terms',
                'question' => 'What documents do I need at the rental counter?',
                'answer' => 'Generally, the main driver needs a valid physical driver license (held for at least 1-2 years), an International Driving Permit (if traveling internationally), a passport or photo ID, and a credit card in the driver name for the security deposit.',
                'sort_order' => 4,
            ],
            [
                'category' => 'Price Alerts',
                'question' => 'How do Hahacar price alerts work?',
                'answer' => 'You can set up a price alert with your email on any search. Our system evaluates prices multiple times daily. If a qualifying rate drop occurs, we send you an immediate notification with direct booking links.',
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
            ['key' => 'site_name', 'value' => 'Hahacar', 'group' => 'general', 'description' => 'Public brand name'],
            ['key' => 'support_email', 'value' => 'support@hahacar.com', 'group' => 'contact', 'description' => 'Main customer support inbox'],
            ['key' => 'default_currency', 'value' => 'USD', 'group' => 'general', 'description' => 'Default platform currency'],
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
