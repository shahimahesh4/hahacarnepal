<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageWebsiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Website Settings';
    protected static ?string $title = 'Website Settings';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.manage-website-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            // General / Store & Branding
            'site_logo' => Setting::get('site_logo', null),
            'site_favicon' => Setting::get('site_favicon', null),
            'site_name' => Setting::get('site_name', 'Hahakar Nepal'),
            'support_email' => Setting::get('support_email', 'support@hahakar.com'),
            'support_phone' => Setting::get('support_phone', '+977 9801-HAHAKAR'),
            'store_address' => Setting::get('store_address', 'Thamel Tourist Center, Kathmandu, Bagmati Province, Nepal'),
            'default_currency' => Setting::get('default_currency', 'NPR'),

            // Homepage Content & Hero Section
            'hero_headline_line1' => Setting::get('hero_headline_line1', 'Book & Compare Car Rentals in Nepal.'),
            'hero_headline_line2' => Setting::get('hero_headline_line2', 'Best Rates Guaranteed across Nepal'),
            'hero_pill1_text' => Setting::get('hero_pill1_text', 'Verified Nepal Fleets'),
            'hero_pill2_text' => Setting::get('hero_pill2_text', 'Verified Drivers & Bluebooks'),
            'hero_pill3_text' => Setting::get('hero_pill3_text', '4WD Mountain & Highway Ready'),
            'hubs_section_title' => Setting::get('hubs_section_title', 'Popular Nepal Car Rental Hubs'),
            'hubs_section_subtitle' => Setting::get('hubs_section_subtitle', 'Direct vehicle dispatch with verified local drivers or self-drive across major tourist and business hubs.'),
            'fleet_section_title' => Setting::get('fleet_section_title', 'Nepal Vehicle Fleet & Rate Guide'),
            'fleet_section_subtitle' => Setting::get('fleet_section_subtitle', 'From mountain 4WDs to economical city hatchbacks and luxury tourist vans.'),
            'trust_section_title' => Setting::get('trust_section_title', 'Why Rent with Hahakar Nepal'),
            'trust_section_subtitle' => Setting::get('trust_section_subtitle', 'Built specifically for Nepal roads, high-altitude terrain, and transparent local pricing.'),
            'partner_cta_title' => Setting::get('partner_cta_title', 'Are You a Vehicle Owner or Tour Driver in Nepal?'),
            'partner_cta_desc' => Setting::get('partner_cta_desc', 'List your Scorpio, HiAce, Hilux, or city hatchback with Hahakar. Receive direct booking requests, verified passenger dispatch, and keep the majority of trip revenues.'),
            'partner_cta_button_text' => Setting::get('partner_cta_button_text', 'Register Your Vehicle & Drive'),
            'faq_section_title' => Setting::get('faq_section_title', 'Nepal Car Rental FAQs'),
            'faq_section_subtitle' => Setting::get('faq_section_subtitle', 'Everything you need to know about renting a car, hiring drivers, and road travel in Nepal.'),

            // Header & Navigation
            'header_cta_login_text' => Setting::get('header_cta_login_text', 'Login'),
            'header_cta_register_text' => Setting::get('header_cta_register_text', 'Register'),
            'header_show_book_vehicle' => (bool) Setting::get('header_show_book_vehicle', true),
            'header_show_compare_rates' => (bool) Setting::get('header_show_compare_rates', true),
            'header_show_list_car' => (bool) Setting::get('header_show_list_car', true),
            'header_show_partner_portal' => (bool) Setting::get('header_show_partner_portal', true),
            'header_show_contact' => (bool) Setting::get('header_show_contact', true),

            // Book Vehicle Page
            'book_page_title_line1' => Setting::get('book_page_title_line1', 'Direct Vehicle Booking in Nepal'),
            'book_page_title_line2' => Setting::get('book_page_title_line2', 'With Chauffeur or Self-Drive'),
            'book_trust_pill1' => Setting::get('book_trust_pill1', '100% Verified Bluebook & Licenses'),
            'book_trust_pill2' => Setting::get('book_trust_pill2', 'Pay Cash on Pickup or eSewa'),
            'book_trust_pill3' => Setting::get('book_trust_pill3', 'Instant Digital Voucher'),

            // Footer & Branding
            'footer_about_text' => Setting::get('footer_about_text', 'Hahakar is Nepal\'s dedicated car rental metasearch & direct booking engine. We compare live rates and provide verified vehicles (Mahindra Scorpio 4WD, Toyota Hilux, HiAce vans, and city cars) across Kathmandu, Pokhara, Chitwan, Lumbini, and Mustang.'),
            'footer_disclaimer_text' => Setting::get('footer_disclaimer_text', 'Nepal Mobility Network: Hahakar Nepal provides direct booking for verified fleet partners and rate comparison across operators. All bookings feature transparent pricing in Nepalese Rupees (NPR) with zero hidden counter fees.'),
            'footer_copyright_text' => Setting::get('footer_copyright_text', 'Hahakar Nepal. All rights reserved.'),
            'footer_powered_by_name' => Setting::get('footer_powered_by_name', 'Colors Nepal'),
            'footer_newsletter_title' => Setting::get('footer_newsletter_title', 'Nepal Travel Alerts'),
            'footer_newsletter_desc' => Setting::get('footer_newsletter_desc', 'Subscribe for seasonal Nepal holiday deals, trekking route vehicle discounts, and flash sales.'),
            'social_facebook' => Setting::get('social_facebook', 'https://facebook.com/hahakarnepal'),
            'social_instagram' => Setting::get('social_instagram', 'https://instagram.com/hahakarnepal'),
            'social_whatsapp' => Setting::get('social_whatsapp', 'https://wa.me/9779801424252'),
            'social_tiktok' => Setting::get('social_tiktok', 'https://tiktok.com/@hahakarnepal'),

            // Revenue Split & Commission
            'driver_payout_percentage' => Setting::get('driver_payout_percentage', '85'),
            'admin_commission_percentage' => Setting::get('admin_commission_percentage', '15'),

            // SEO & Social Meta Configuration
            'seo_meta_title' => Setting::get('seo_meta_title', 'Hahakar - Nepal\'s #1 Car Rental Comparison & Direct Booking'),
            'seo_meta_description' => Setting::get('seo_meta_description', 'Compare car rental prices & book verified vehicles across Kathmandu, Pokhara, Chitwan, Lumbini, and all of Nepal. Scorpio 4WD, Toyota Hilux, Creta, Swift, and HiAce tourist vans with transparent NPR rates.'),
            'seo_meta_keywords' => Setting::get('seo_meta_keywords', 'car rental nepal, scorpio rental kathmandu, self drive car pokhara, hiace rental nepal, rent a car nepal, cheap car hire kathmandu, ev car rental nepal'),
            'seo_robots' => Setting::get('seo_robots', 'index, follow, max-image-preview:large'),
            'seo_theme_color' => Setting::get('seo_theme_color', '#070d1e'),
            'seo_og_locale' => Setting::get('seo_og_locale', 'en_NP'),
            'seo_og_image' => Setting::get('seo_og_image', '/images/vehicles/scorpio.jpg'),
            'seo_twitter_card' => Setting::get('seo_twitter_card', 'summary_large_image'),

            // Distance & Fuel Rates
            'rate_per_km_electric' => Setting::get('rate_per_km_electric', '70'),
            'rate_per_km_petrol' => Setting::get('rate_per_km_petrol', '250'),
            'rate_per_km_diesel' => Setting::get('rate_per_km_diesel', '250'),
            'rate_per_km_hybrid' => Setting::get('rate_per_km_hybrid', '160'),
            'minimum_trip_fare' => Setting::get('minimum_trip_fare', '1000'),

            // Location Provider & Google Maps API
            'location_provider_mode' => Setting::get('location_provider_mode', 'manual'),
            'google_maps_api_key' => Setting::get('google_maps_api_key', ''),
            'google_maps_default_country' => Setting::get('google_maps_default_country', 'np'),

            // Communications & Alerts
            'alert_cooldown_hours' => Setting::get('alert_cooldown_hours', '12'),
            'price_drop_min_percentage' => Setting::get('price_drop_min_percentage', '5'),
            'enable_email_alerts' => (bool) Setting::get('enable_email_alerts', true),

            // Ranking & System
            'ranking_weight_price' => Setting::get('ranking_weight_price', '0.45'),
            'ranking_weight_supplier' => Setting::get('ranking_weight_supplier', '0.15'),
            'ranking_weight_terms' => Setting::get('ranking_weight_terms', '0.15'),
            'ranking_weight_cancellation' => Setting::get('ranking_weight_cancellation', '0.10'),
            'ranking_weight_freshness' => Setting::get('ranking_weight_freshness', '0.10'),
            'ranking_weight_commercial' => Setting::get('ranking_weight_commercial', '0.05'),

            // Integrations & Payments
            'enable_cash_on_pickup' => (bool) Setting::get('enable_cash_on_pickup', true),
            'enable_esewa' => (bool) Setting::get('enable_esewa', true),
            'enable_khalti' => (bool) Setting::get('enable_khalti', true),

            // Security & OTP Verification (Disabled by default)
            'enable_email_otp' => (bool) Setting::get('enable_email_otp', false),
            'enable_phone_otp' => (bool) Setting::get('enable_phone_otp', false),
            'otp_trigger_mode' => Setting::get('otp_trigger_mode', 'both'),
            'otp_expiry_minutes' => Setting::get('otp_expiry_minutes', '10'),
            'otp_max_attempts' => Setting::get('otp_max_attempts', '5'),
            'sms_gateway_provider' => Setting::get('sms_gateway_provider', 'log_mock'),
            'sparrow_sms_token' => Setting::get('sparrow_sms_token', ''),
            'sparrow_sms_from' => Setting::get('sparrow_sms_from', 'HahakarCar'),
            'aakash_sms_auth_token' => Setting::get('aakash_sms_auth_token', ''),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('SettingsTabs')
                    ->tabs([
                        // Tab 1: Store / General
                        Tab::make('Store')
                            ->icon('heroicon-o-building-storefront')
                            ->schema([
                                Section::make('Brand Identity (Logo & Favicon)')
                                    ->description('Upload your official website brand logo and browser favicon.')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                FileUpload::make('site_logo')
                                                    ->label('Website Brand Logo')
                                                    ->image()
                                                    ->disk('public')
                                                    ->directory('settings')
                                                    ->visibility('public')
                                                    ->imagePreviewHeight('80')
                                                    ->maxSize(3072)
                                                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp', 'image/svg+xml'])
                                                    ->helperText('Recommended: Transparent PNG or SVG (approx height 60-120px). Uses default logo if empty.'),

                                                FileUpload::make('site_favicon')
                                                    ->label('Browser Favicon')
                                                    ->image()
                                                    ->disk('public')
                                                    ->directory('settings')
                                                    ->visibility('public')
                                                    ->imagePreviewHeight('60')
                                                    ->maxSize(1024)
                                                    ->acceptedFileTypes(['image/png', 'image/x-icon', 'image/vnd.microsoft.icon', 'image/svg+xml', 'image/jpeg', 'image/webp'])
                                                    ->helperText('Square 32x32, 64x64, or PNG/ICO icon displayed in browser tabs.'),
                                            ]),
                                    ]),

                                Section::make('General Configuration')
                                    ->description('Primary contact and identity details for the vehicle rental platform.')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('site_name')
                                                    ->label('Store / Website Name')
                                                    ->required()
                                                    ->placeholder('e.g. Hahakar Nepal'),

                                                TextInput::make('support_email')
                                                    ->label('Store / Support Email')
                                                    ->email()
                                                    ->required()
                                                    ->placeholder('e.g. support@hahakar.com'),
                                            ]),

                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('support_phone')
                                                    ->label('Store Phone / WhatsApp')
                                                    ->required()
                                                    ->placeholder('+977 98XXXXXXXX'),

                                                TextInput::make('default_currency')
                                                    ->label('Default Currency')
                                                    ->required()
                                                    ->placeholder('NPR'),
                                            ]),

                                        Textarea::make('store_address')
                                                    ->label('Store / Office Address')
                                                    ->rows(3)
                                                    ->placeholder('Physical office location in Nepal...')
                                                    ->columnSpanFull(),
                                    ]),
                            ]),

                        // Tab 2: Homepage & Body Sections
                        Tab::make('Homepage & Body')
                            ->icon('heroicon-o-home')
                            ->schema([
                                Section::make('Hero Headline & Platform Highlights')
                                    ->description('Configure the main text at the top of the homepage.')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('hero_headline_line1')
                                                    ->label('Hero Title (Line 1)')
                                                    ->required()
                                                    ->default('Book & Compare Car Rentals in Nepal.'),

                                                TextInput::make('hero_headline_line2')
                                                    ->label('Hero Subtitle / Gradient Text (Line 2)')
                                                    ->required()
                                                    ->default('Best Rates Guaranteed across Nepal'),
                                            ]),

                                        Grid::make(3)
                                            ->schema([
                                                TextInput::make('hero_pill1_text')
                                                    ->label('Hero Highlight Pill 1')
                                                    ->default('Verified Nepal Fleets'),

                                                TextInput::make('hero_pill2_text')
                                                    ->label('Hero Highlight Pill 2')
                                                    ->default('Verified Drivers & Bluebooks'),

                                                TextInput::make('hero_pill3_text')
                                                    ->label('Hero Highlight Pill 3')
                                                    ->default('4WD Mountain & Highway Ready'),
                                            ]),
                                    ]),

                                Section::make('Homepage Section Headings')
                                    ->description('Customize titles and descriptions for all major body sections on the homepage.')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('hubs_section_title')
                                                    ->label('Rental Hubs Section Title')
                                                    ->default('Popular Nepal Car Rental Hubs'),

                                                TextInput::make('hubs_section_subtitle')
                                                    ->label('Rental Hubs Subtitle')
                                                    ->default('Direct vehicle dispatch with verified local drivers or self-drive across major tourist and business hubs.'),
                                            ]),

                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('fleet_section_title')
                                                    ->label('Fleet Categories Section Title')
                                                    ->default('Nepal Vehicle Fleet & Rate Guide'),

                                                TextInput::make('fleet_section_subtitle')
                                                    ->label('Fleet Categories Subtitle')
                                                    ->default('From mountain 4WDs to economical city hatchbacks and luxury tourist vans.'),
                                            ]),

                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('trust_section_title')
                                                    ->label('Why Choose Us Section Title')
                                                    ->default('Why Rent with Hahakar Nepal'),

                                                TextInput::make('trust_section_subtitle')
                                                    ->label('Why Choose Us Subtitle')
                                                    ->default('Built specifically for Nepal roads, high-altitude terrain, and transparent local pricing.'),
                                            ]),

                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('faq_section_title')
                                                    ->label('FAQ Section Title')
                                                    ->default('Nepal Car Rental FAQs'),

                                                TextInput::make('faq_section_subtitle')
                                                    ->label('FAQ Section Subtitle')
                                                    ->default('Everything you need to know about renting a car, hiring drivers, and road travel in Nepal.'),
                                            ]),
                                    ]),

                                Section::make('Driver & Partner Onboarding CTA Section')
                                    ->description('Banner encouraging drivers and car owners to register on the platform.')
                                    ->schema([
                                        TextInput::make('partner_cta_title')
                                            ->label('CTA Title')
                                            ->default('Are You a Vehicle Owner or Tour Driver in Nepal?'),

                                        Textarea::make('partner_cta_desc')
                                            ->label('CTA Description')
                                            ->rows(2)
                                            ->default('List your Scorpio, HiAce, Hilux, or city hatchback with Hahakar. Receive direct booking requests, verified passenger dispatch, and keep the majority of trip revenues.'),

                                        TextInput::make('partner_cta_button_text')
                                            ->label('CTA Button Text')
                                            ->default('Register Your Vehicle & Drive'),
                                    ]),
                            ]),

                        // Tab 3: Header & Navigation
                        Tab::make('Header & Nav')
                            ->icon('heroicon-o-bars-3')
                            ->schema([
                                Section::make('Navigation Links & Actions')
                                    ->description('Control top menu links visibility and call-to-action button labels.')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('header_cta_login_text')
                                                    ->label('Login Button Label')
                                                    ->default('Login'),

                                                TextInput::make('header_cta_register_text')
                                                    ->label('Register Button Label')
                                                    ->default('Register'),
                                            ]),

                                        Grid::make(3)
                                            ->schema([
                                                Toggle::make('header_show_book_vehicle')
                                                    ->label('Show "Book a Vehicle"')
                                                    ->default(true),

                                                Toggle::make('header_show_compare_rates')
                                                    ->label('Show "Compare Rates"')
                                                    ->default(true),

                                                Toggle::make('header_show_list_car')
                                                    ->label('Show "List Your Car"')
                                                    ->default(true),

                                                Toggle::make('header_show_partner_portal')
                                                    ->label('Show "Partner Portal"')
                                                    ->default(true),

                                                Toggle::make('header_show_contact')
                                                    ->label('Show "Contact"')
                                                    ->default(true),
                                            ]),
                                    ]),
                            ]),

                        // Tab 4: Book Vehicle Page
                        Tab::make('Book Page')
                            ->icon('heroicon-o-calendar-days')
                            ->schema([
                                Section::make('Book Vehicle Hero Configuration')
                                    ->description('Customize the title and trust badges on /book-vehicle page.')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('book_page_title_line1')
                                                    ->label('Title Line 1')
                                                    ->default('Direct Vehicle Booking in Nepal'),

                                                TextInput::make('book_page_title_line2')
                                                    ->label('Title Line 2 (Gradient)')
                                                    ->default('With Chauffeur or Self-Drive'),
                                            ]),

                                        Grid::make(3)
                                            ->schema([
                                                TextInput::make('book_trust_pill1')
                                                    ->label('Trust Pill 1')
                                                    ->default('100% Verified Bluebook & Licenses'),

                                                TextInput::make('book_trust_pill2')
                                                    ->label('Trust Pill 2')
                                                    ->default('Pay Cash on Pickup or eSewa'),

                                                TextInput::make('book_trust_pill3')
                                                    ->label('Trust Pill 3')
                                                    ->default('Instant Digital Voucher'),
                                            ]),
                                    ]),
                            ]),

                        // Tab 5: Footer & Branding
                        Tab::make('Footer & Social')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Section::make('Footer Branding & Disclaimers')
                                    ->description('Manage footer descriptions, copyright, and legal transparency statements.')
                                    ->schema([
                                        Textarea::make('footer_about_text')
                                            ->label('About Brand Short Paragraph')
                                            ->rows(3)
                                            ->default('Hahakar is Nepal\'s dedicated car rental metasearch & direct booking engine. We compare live rates and provide verified vehicles across Kathmandu, Pokhara, Chitwan, Lumbini, and Mustang.'),

                                        Textarea::make('footer_disclaimer_text')
                                            ->label('Legal Mobility Disclaimer')
                                            ->rows(3)
                                            ->default('Nepal Mobility Network: Hahakar Nepal provides direct booking for verified fleet partners and rate comparison across operators. All bookings feature transparent pricing in Nepalese Rupees (NPR) with zero hidden counter fees.'),

                                        TextInput::make('footer_copyright_text')
                                            ->label('Copyright Notice')
                                            ->default('Hahakar Nepal. All rights reserved.'),

                                        TextInput::make('footer_powered_by_name')
                                            ->label('Powered By Credit')
                                            ->default('Colors Nepal'),
                                    ]),

                                Section::make('Travel Alerts Newsletter')
                                    ->schema([
                                        TextInput::make('footer_newsletter_title')
                                            ->label('Newsletter Title')
                                            ->default('Nepal Travel Alerts'),

                                        Textarea::make('footer_newsletter_desc')
                                            ->label('Newsletter Description')
                                            ->rows(2)
                                            ->default('Subscribe for seasonal Nepal holiday deals, trekking route vehicle discounts, and flash sales.'),
                                    ]),

                                Section::make('Official Social Media Profiles')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('social_facebook')
                                                    ->label('Facebook Page URL')
                                                    ->placeholder('https://facebook.com/...'),

                                                TextInput::make('social_instagram')
                                                    ->label('Instagram URL')
                                                    ->placeholder('https://instagram.com/...'),

                                                TextInput::make('social_whatsapp')
                                                    ->label('WhatsApp Direct Link')
                                                    ->placeholder('https://wa.me/...'),

                                                TextInput::make('social_tiktok')
                                                    ->label('TikTok URL')
                                                    ->placeholder('https://tiktok.com/...'),
                                            ]),
                                    ]),
                            ]),

                        // Tab 6: Revenue Split & Commission
                        Tab::make('Revenue & Commission')
                            ->icon('heroicon-o-banknotes')
                            ->schema([
                                Section::make('Driver & Platform Owner Revenue Share')
                                    ->description('Configure the percentage split between verified Partner Drivers and the Platform Owner on all completed reservations.')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('driver_payout_percentage')
                                                    ->label('🚘 Driver / Partner Payout Share (%)')
                                                    ->numeric()
                                                    ->minValue(0)
                                                    ->maxValue(100)
                                                    ->suffix('%')
                                                    ->default(85)
                                                    ->helperText('Percentage of total reservation fee disbursed directly to partner driver (e.g., 85%).')
                                                    ->required(),

                                                TextInput::make('admin_commission_percentage')
                                                    ->label('🏢 Admin / Platform Owner Commission (%)')
                                                    ->numeric()
                                                    ->minValue(0)
                                                    ->maxValue(100)
                                                    ->suffix('%')
                                                    ->default(15)
                                                    ->helperText('Percentage of total reservation fee retained by Hahakar as platform commission (e.g., 15%).')
                                                    ->required(),
                                            ]),

                                        Section::make('💡 Live Calculation Example')
                                            ->description('Calculation breakdown on a standard Rs. 10,000 reservation:')
                                            ->schema([
                                                Grid::make(3)
                                                    ->schema([
                                                        TextInput::make('calc_example_total')
                                                            ->label('Total Customer Payment')
                                                            ->default('Rs. 10,000 (100%)')
                                                            ->disabled()
                                                            ->dehydrated(false),

                                                        TextInput::make('calc_example_driver')
                                                            ->label('Driver Payout Share')
                                                            ->default('Rs. 8,500 (85%)')
                                                            ->disabled()
                                                            ->dehydrated(false),

                                                        TextInput::make('calc_example_admin')
                                                            ->label('Admin Owner Commission')
                                                            ->default('Rs. 1,500 (15%)')
                                                            ->disabled()
                                                            ->dehydrated(false),
                                                    ]),
                                            ])
                                            ->collapsible(),
                                    ]),
                            ]),

                        // Tab 3: SEO & Social Meta
                        Tab::make('SEO & Social Meta')
                            ->icon('heroicon-o-globe-alt')
                            ->schema([
                                Section::make('Search Engine Optimization (SEO)')
                                    ->description('Global meta tags, indexing directives, and search snippet controls for Google, Bing, and search crawlers.')
                                    ->schema([
                                        TextInput::make('seo_meta_title')
                                            ->label('Default Meta Title')
                                            ->required()
                                            ->placeholder('Hahakar - Nepal\'s #1 Car Rental Comparison & Direct Booking')
                                            ->helperText('Primary title displayed in Google search results and browser tabs.'),

                                        Textarea::make('seo_meta_description')
                                            ->label('Default Meta Description')
                                            ->rows(3)
                                            ->required()
                                            ->placeholder('Compare car rental prices & book verified vehicles across Nepal...')
                                            ->helperText('Search snippet summary (optimal length: 150-160 characters).'),

                                        TextInput::make('seo_meta_keywords')
                                            ->label('Meta Keywords (Comma separated)')
                                            ->placeholder('car rental nepal, scorpio rental kathmandu, self drive pokhara, hiace hire')
                                            ->helperText('Comma-separated list of keywords for regional and crawler indexing.'),

                                        Grid::make(2)
                                            ->schema([
                                                Select::make('seo_robots')
                                                    ->label('Robots Indexing Directive')
                                                    ->options([
                                                        'index, follow, max-image-preview:large' => 'Index, Follow (Recommended - Max Image Preview)',
                                                        'index, follow' => 'Index, Follow',
                                                        'noindex, follow' => 'NoIndex, Follow (Private/Staging with crawler links)',
                                                        'noindex, nofollow' => 'NoIndex, NoFollow (Completely Private)',
                                                    ])
                                                    ->required()
                                                    ->default('index, follow, max-image-preview:large'),

                                                TextInput::make('seo_theme_color')
                                                    ->label('Mobile Browser Theme Color (HEX)')
                                                    ->placeholder('#070d1e')
                                                    ->default('#070d1e')
                                                    ->helperText('Status bar / address bar color on mobile browsers (e.g., #070d1e, #059669).'),
                                            ]),
                                    ]),

                                Section::make('Social Sharing Meta (Open Graph & Twitter Card)')
                                    ->description('Configure rich card previews when links are shared on WhatsApp, Facebook, LinkedIn, Twitter/X, and Telegram.')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Select::make('seo_twitter_card')
                                                    ->label('Twitter Card Format')
                                                    ->options([
                                                        'summary_large_image' => 'Large Image Card (Recommended)',
                                                        'summary' => 'Standard Compact Summary',
                                                    ])
                                                    ->required()
                                                    ->default('summary_large_image'),

                                                TextInput::make('seo_og_locale')
                                                    ->label('Open Graph Locale')
                                                    ->placeholder('en_NP')
                                                    ->default('en_NP')
                                                    ->helperText('Language and regional locale (e.g., en_NP, ne_NP, en_US).'),
                                            ]),

                                        TextInput::make('seo_og_image')
                                            ->label('Default Social Share Image URL / Relative Path')
                                            ->placeholder('/images/vehicles/scorpio.jpg')
                                            ->default('/images/vehicles/scorpio.jpg')
                                            ->helperText('Representative hero image for Facebook / WhatsApp / Twitter social previews.')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        // Tab 4: Distance & Fuel Rates
                        Tab::make('Distance & Fuel')
                            ->icon('heroicon-o-truck')
                            ->schema([
                                Section::make('Fuel-Based Distance Pricing')
                                    ->description('Configure dynamic price per kilometer (Rs./km) according to vehicle fuel type.')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('rate_per_km_electric')
                                                    ->label('⚡ Electric EV Rate per KM')
                                                    ->numeric()
                                                    ->prefix('Rs.')
                                                    ->suffix('/ km')
                                                    ->helperText('Default rate for BYD Atto 3 and electric fleet.')
                                                    ->required(),

                                                TextInput::make('rate_per_km_petrol')
                                                    ->label('⛽ Petrol Vehicle Rate per KM')
                                                    ->numeric()
                                                    ->prefix('Rs.')
                                                    ->suffix('/ km')
                                                    ->helperText('Default rate for Swift, Creta, Dzire petrol cars.')
                                                    ->required(),
                                            ]),

                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('rate_per_km_diesel')
                                                    ->label('🛢️ Diesel Vehicle Rate per KM')
                                                    ->numeric()
                                                    ->prefix('Rs.')
                                                    ->suffix('/ km')
                                                    ->helperText('Default rate for Scorpio 4WD, Hilux, HiAce vans.')
                                                    ->required(),

                                                TextInput::make('rate_per_km_hybrid')
                                                    ->label('🔋 Hybrid Vehicle Rate per KM')
                                                    ->numeric()
                                                    ->prefix('Rs.')
                                                    ->suffix('/ km')
                                                    ->helperText('Default rate for hybrid electric vehicles.')
                                                    ->required(),
                                            ]),

                                        TextInput::make('minimum_trip_fare')
                                            ->label('Minimum Trip Base Fare')
                                            ->numeric()
                                            ->prefix('Rs.')
                                            ->helperText('Minimum charge for short local distance trips.')
                                            ->required(),
                                    ]),
                            ]),

                        // Tab 3: Communications & Alerts
                        Tab::make('Communications')
                            ->icon('heroicon-o-chat-bubble-left-right')
                            ->schema([
                                Section::make('Nepal Travel Price Alerts')
                                    ->description('Configure subscriber notification thresholds and email cooldowns.')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('alert_cooldown_hours')
                                                    ->label('Alert Cooldown (Hours)')
                                                    ->numeric()
                                                    ->suffix('hours')
                                                    ->helperText('Minimum hours between alerts for identical route criteria.')
                                                    ->required(),

                                                TextInput::make('price_drop_min_percentage')
                                                    ->label('Price Drop Minimum %')
                                                    ->numeric()
                                                    ->suffix('%')
                                                    ->helperText('Minimum percentage price drop required to trigger alert email.')
                                                    ->required(),
                                            ]),

                                        Toggle::make('enable_email_alerts')
                                            ->label('Enable Automated Price Drop Notifications')
                                            ->helperText('When enabled, emails will be queued to subscribers upon price drops.')
                                            ->default(true),
                                    ]),
                            ]),

                        // Tab 4: System & Ranking
                        Tab::make('System')
                            ->icon('heroicon-o-cog-8-tooth')
                            ->schema([
                                Section::make('Metasearch Ranking Algorithm Weights')
                                    ->description('Multi-factor ranking weights for supplier offer ranking (sum to 1.0).')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                TextInput::make('ranking_weight_price')
                                                    ->label('Price Weight')
                                                    ->numeric()
                                                    ->required(),

                                                TextInput::make('ranking_weight_supplier')
                                                    ->label('Supplier Rating Weight')
                                                    ->numeric()
                                                    ->required(),

                                                TextInput::make('ranking_weight_terms')
                                                    ->label('Terms Completeness Weight')
                                                    ->numeric()
                                                    ->required(),
                                            ]),

                                        Grid::make(3)
                                            ->schema([
                                                TextInput::make('ranking_weight_cancellation')
                                                    ->label('Free Cancellation Weight')
                                                    ->numeric()
                                                    ->required(),

                                                TextInput::make('ranking_weight_freshness')
                                                    ->label('Data Freshness Weight')
                                                    ->numeric()
                                                    ->required(),

                                                TextInput::make('ranking_weight_commercial')
                                                    ->label('Commercial Boost Cap')
                                                    ->numeric()
                                                    ->required(),
                                            ]),
                                    ]),
                            ]),

                        // Tab 5: Integrations & Payments
                        Tab::make('Integrations')
                            ->icon('heroicon-o-credit-card')
                            ->schema([
                                Section::make('Location Service & Maps Provider')
                                    ->description('Choose whether pickup/dropoff locations and distance calculations are handled manually or automatically via Google Maps API.')
                                    ->schema([
                                        Radio::make('location_provider_mode')
                                            ->label('Location Source Mode')
                                            ->options([
                                                'manual' => '📍 Manual Locations (Use Curated Nepal Cities & Fixed Distance Matrix)',
                                                'google_maps' => '🗺️ Google Maps API (Auto Google Places Autocomplete & Real-Time Distance Matrix)',
                                            ])
                                            ->descriptions([
                                                'manual' => 'Recommended for offline/fixed operations or when you want to use the curated list of Nepal cities, airports, and pre-seeded highway distances.',
                                                'google_maps' => 'Enables live Google Places search suggestions across Nepal and real-time driving route kilometer calculations.',
                                            ])
                                            ->default('manual')
                                            ->live()
                                            ->required(),

                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('google_maps_api_key')
                                                    ->label('Google Maps API Key')
                                                    ->placeholder('AIzaSy...')
                                                    ->password()
                                                    ->revealable()
                                                    ->helperText('Required when Google Maps API mode is selected. Must have Places API, Maps JS API & Distance Matrix API enabled.')
                                                    ->visible(fn ($get) => $get('location_provider_mode') === 'google_maps'),

                                                TextInput::make('google_maps_default_country')
                                                    ->label('Places Search Country Restriction')
                                                    ->default('np')
                                                    ->placeholder('np')
                                                    ->helperText('ISO 3166-1 alpha-2 code to restrict location searches (e.g. "np" for Nepal).')
                                                    ->visible(fn ($get) => $get('location_provider_mode') === 'google_maps'),
                                            ]),
                                    ]),

                                Section::make('Nepal Payment Preferences')
                                    ->description('Configure accepted payment options for direct customer bookings.')
                                    ->schema([
                                        Toggle::make('enable_cash_on_pickup')
                                            ->label('Accept Cash on Handover / Pickup')
                                            ->helperText('Customers pay directly to the partner driver upon vehicle handover.')
                                            ->default(true),

                                        Toggle::make('enable_esewa')
                                            ->label('Accept eSewa Digital Wallet / QR')
                                            ->helperText('Show eSewa QR payment option on reservation confirmation.')
                                            ->default(true),

                                        Toggle::make('enable_khalti')
                                            ->label('Accept Khalti Digital Wallet')
                                            ->helperText('Show Khalti wallet option on reservation confirmation.')
                                            ->default(true),
                                    ]),
                            ]),

                        // Tab: Security & OTP Verification
                        Tab::make('Security & OTP')
                            ->icon('heroicon-o-shield-check')
                            ->schema([
                                Section::make('Authentication OTP Controls')
                                    ->description('Enable or disable one-time passcode (OTP) verification for customer and partner accounts during sign in and account registration. By default, toggles are disabled.')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Toggle::make('enable_email_otp')
                                                    ->label('📧 Enable Email OTP Verification')
                                                    ->helperText('When enabled, dispatches a secure 6-digit verification code to the user\'s email address. Disabled by default.')
                                                    ->default(false),

                                                Toggle::make('enable_phone_otp')
                                                    ->label('📱 Enable Phone / SMS OTP Verification')
                                                    ->helperText('When enabled, dispatches a secure 6-digit SMS verification code to the user\'s phone number. Disabled by default.')
                                                    ->default(false),
                                            ]),

                                        Radio::make('otp_trigger_mode')
                                            ->label('OTP Enforcement Trigger')
                                            ->options([
                                                'both' => '🔐 Enforce OTP on both Signup & Login (Maximum Account Security)',
                                                'register_only' => '📝 Enforce OTP on New Account Registration Only',
                                                'login_only' => '🔑 Enforce OTP on User Sign In / Login Only',
                                            ])
                                            ->descriptions([
                                                'both' => 'Requires OTP verification when signing up as a new customer and each time logging into an existing account.',
                                                'register_only' => 'Only verifies email/phone ownership during the initial account creation.',
                                                'login_only' => 'Requires OTP confirmation during sign in sessions.',
                                            ])
                                            ->default('both')
                                            ->required(),

                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('otp_expiry_minutes')
                                                    ->label('OTP Code Validity')
                                                    ->numeric()
                                                    ->suffix('minutes')
                                                    ->default(10)
                                                    ->helperText('Time duration before an issued OTP code expires.')
                                                    ->required(),

                                                TextInput::make('otp_max_attempts')
                                                    ->label('Max Failed Verification Attempts')
                                                    ->numeric()
                                                    ->default(5)
                                                    ->helperText('Maximum incorrect attempts allowed before code is invalidated.')
                                                    ->required(),
                                            ]),
                                    ]),

                                Section::make('Nepal SMS Gateway Configuration')
                                    ->description('Configure mobile SMS provider for phone OTP delivery across Nepal (Ncell, Nepal Telecom / NTC).')
                                    ->schema([
                                        Select::make('sms_gateway_provider')
                                            ->label('SMS Gateway Provider')
                                            ->options([
                                                'log_mock' => '🧪 System Logger / Mock (Nepal Sandbox Mode - Zero Cost)',
                                                'sparrow_sms' => '🇳🇵 Sparrow SMS (Nepal Enterprise API)',
                                                'aakash_sms' => '🇳🇵 Aakash SMS (Nepal Enterprise API)',
                                            ])
                                            ->default('log_mock')
                                            ->live()
                                            ->required(),

                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('sparrow_sms_token')
                                                    ->label('Sparrow SMS API Token')
                                                    ->placeholder('Sparrow API Token...')
                                                    ->password()
                                                    ->revealable()
                                                    ->visible(fn ($get) => $get('sms_gateway_provider') === 'sparrow_sms'),

                                                TextInput::make('sparrow_sms_from')
                                                    ->label('Sparrow Sender Identity')
                                                    ->default('HahakarCar')
                                                    ->visible(fn ($get) => $get('sms_gateway_provider') === 'sparrow_sms'),

                                                TextInput::make('aakash_sms_auth_token')
                                                    ->label('Aakash SMS Auth Token')
                                                    ->placeholder('Aakash Auth Token...')
                                                    ->password()
                                                    ->revealable()
                                                    ->visible(fn ($get) => $get('sms_gateway_provider') === 'aakash_sms'),
                                            ]),
                                    ]),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        // 1. General & Branding
        Setting::set('site_logo', $state['site_logo'] ?? '', 'branding', 'Website brand logo path');
        Setting::set('site_favicon', $state['site_favicon'] ?? '', 'branding', 'Website browser favicon path');
        Setting::set('site_name', $state['site_name'], 'general', 'Public brand name');
        Setting::set('support_email', $state['support_email'], 'contact', 'Main support email inbox');
        Setting::set('support_phone', $state['support_phone'], 'contact', 'Customer support phone / WhatsApp');
        Setting::set('store_address', $state['store_address'], 'contact', 'Store physical office address in Nepal');
        Setting::set('default_currency', $state['default_currency'], 'general', 'Default platform currency');

        // 2. Homepage & Body Sections
        Setting::set('hero_headline_line1', $state['hero_headline_line1'] ?? '', 'homepage', 'Hero Title Line 1');
        Setting::set('hero_headline_line2', $state['hero_headline_line2'] ?? '', 'homepage', 'Hero Title Line 2');
        Setting::set('hero_pill1_text', $state['hero_pill1_text'] ?? '', 'homepage', 'Hero Highlight Pill 1');
        Setting::set('hero_pill2_text', $state['hero_pill2_text'] ?? '', 'homepage', 'Hero Highlight Pill 2');
        Setting::set('hero_pill3_text', $state['hero_pill3_text'] ?? '', 'homepage', 'Hero Highlight Pill 3');
        Setting::set('hubs_section_title', $state['hubs_section_title'] ?? '', 'homepage', 'Rental Hubs Section Title');
        Setting::set('hubs_section_subtitle', $state['hubs_section_subtitle'] ?? '', 'homepage', 'Rental Hubs Subtitle');
        Setting::set('fleet_section_title', $state['fleet_section_title'] ?? '', 'homepage', 'Fleet Categories Section Title');
        Setting::set('fleet_section_subtitle', $state['fleet_section_subtitle'] ?? '', 'homepage', 'Fleet Categories Subtitle');
        Setting::set('trust_section_title', $state['trust_section_title'] ?? '', 'homepage', 'Why Choose Us Section Title');
        Setting::set('trust_section_subtitle', $state['trust_section_subtitle'] ?? '', 'homepage', 'Why Choose Us Subtitle');
        Setting::set('partner_cta_title', $state['partner_cta_title'] ?? '', 'homepage', 'Driver/Partner CTA Title');
        Setting::set('partner_cta_desc', $state['partner_cta_desc'] ?? '', 'homepage', 'Driver/Partner CTA Description');
        Setting::set('partner_cta_button_text', $state['partner_cta_button_text'] ?? '', 'homepage', 'Driver/Partner CTA Button Text');
        Setting::set('faq_section_title', $state['faq_section_title'] ?? '', 'homepage', 'FAQ Section Title');
        Setting::set('faq_section_subtitle', $state['faq_section_subtitle'] ?? '', 'homepage', 'FAQ Section Subtitle');

        // 3. Header & Navigation
        Setting::set('header_cta_login_text', $state['header_cta_login_text'] ?? 'Login', 'header', 'Login CTA button text');
        Setting::set('header_cta_register_text', $state['header_cta_register_text'] ?? 'Register', 'header', 'Register CTA button text');
        Setting::set('header_show_book_vehicle', $state['header_show_book_vehicle'] ? '1' : '0', 'header', 'Show Book a Vehicle link');
        Setting::set('header_show_compare_rates', $state['header_show_compare_rates'] ? '1' : '0', 'header', 'Show Compare Rates link');
        Setting::set('header_show_list_car', $state['header_show_list_car'] ? '1' : '0', 'header', 'Show List Your Car link');
        Setting::set('header_show_partner_portal', $state['header_show_partner_portal'] ? '1' : '0', 'header', 'Show Partner Portal link');
        Setting::set('header_show_contact', $state['header_show_contact'] ? '1' : '0', 'header', 'Show Contact link');

        // 4. Book Vehicle Page
        Setting::set('book_page_title_line1', $state['book_page_title_line1'] ?? '', 'book_page', 'Book Page Title Line 1');
        Setting::set('book_page_title_line2', $state['book_page_title_line2'] ?? '', 'book_page', 'Book Page Title Line 2');
        Setting::set('book_trust_pill1', $state['book_trust_pill1'] ?? '', 'book_page', 'Book Page Trust Pill 1');
        Setting::set('book_trust_pill2', $state['book_trust_pill2'] ?? '', 'book_page', 'Book Page Trust Pill 2');
        Setting::set('book_trust_pill3', $state['book_trust_pill3'] ?? '', 'book_page', 'Book Page Trust Pill 3');

        // 5. Footer & Branding
        Setting::set('footer_about_text', $state['footer_about_text'] ?? '', 'footer', 'Footer About Description');
        Setting::set('footer_disclaimer_text', $state['footer_disclaimer_text'] ?? '', 'footer', 'Footer Legal Disclaimer');
        Setting::set('footer_copyright_text', $state['footer_copyright_text'] ?? '', 'footer', 'Footer Copyright Notice');
        Setting::set('footer_powered_by_name', $state['footer_powered_by_name'] ?? 'Colors Nepal', 'footer', 'Footer Powered By Credit');
        Setting::set('footer_newsletter_title', $state['footer_newsletter_title'] ?? '', 'footer', 'Footer Newsletter Title');
        Setting::set('footer_newsletter_desc', $state['footer_newsletter_desc'] ?? '', 'footer', 'Footer Newsletter Description');
        Setting::set('social_facebook', $state['social_facebook'] ?? '', 'footer', 'Facebook Page URL');
        Setting::set('social_instagram', $state['social_instagram'] ?? '', 'footer', 'Instagram Profile URL');
        Setting::set('social_whatsapp', $state['social_whatsapp'] ?? '', 'footer', 'WhatsApp Direct Link');
        Setting::set('social_tiktok', $state['social_tiktok'] ?? '', 'footer', 'TikTok Profile URL');

        // 2. Revenue Split & Commission
        Setting::set('driver_payout_percentage', $state['driver_payout_percentage'] ?? '85', 'commission', 'Driver payout percentage (0-100%)');
        Setting::set('admin_commission_percentage', $state['admin_commission_percentage'] ?? '15', 'commission', 'Admin platform owner commission percentage (0-100%)');

        // 3. SEO & Social Meta
        Setting::set('seo_meta_title', $state['seo_meta_title'] ?? '', 'seo', 'Default website meta title');
        Setting::set('seo_meta_description', $state['seo_meta_description'] ?? '', 'seo', 'Default website meta description');
        Setting::set('seo_meta_keywords', $state['seo_meta_keywords'] ?? '', 'seo', 'Default website meta keywords');
        Setting::set('seo_robots', $state['seo_robots'] ?? 'index, follow, max-image-preview:large', 'seo', 'Robots indexing directive');
        Setting::set('seo_theme_color', $state['seo_theme_color'] ?? '#070d1e', 'seo', 'Mobile browser theme color');
        Setting::set('seo_twitter_card', $state['seo_twitter_card'] ?? 'summary_large_image', 'seo', 'Twitter card preview format');
        Setting::set('seo_og_locale', $state['seo_og_locale'] ?? 'en_NP', 'seo', 'Open Graph regional locale');
        Setting::set('seo_og_image', $state['seo_og_image'] ?? '/images/vehicles/scorpio.jpg', 'seo', 'Default Open Graph and Twitter share image path');

        // 4. Distance & Fuel
        Setting::set('rate_per_km_electric', $state['rate_per_km_electric'], 'distance_pricing', 'Rate per km for Electric EVs (Rs./km)');
        Setting::set('rate_per_km_petrol', $state['rate_per_km_petrol'], 'distance_pricing', 'Rate per km for Petrol vehicles (Rs./km)');
        Setting::set('rate_per_km_diesel', $state['rate_per_km_diesel'], 'distance_pricing', 'Rate per km for Diesel vehicles (Rs./km)');
        Setting::set('rate_per_km_hybrid', $state['rate_per_km_hybrid'], 'distance_pricing', 'Rate per km for Hybrid vehicles (Rs./km)');
        Setting::set('minimum_trip_fare', $state['minimum_trip_fare'], 'distance_pricing', 'Minimum distance trip base fare (Rs.)');

        // 3. Location & Google Maps
        Setting::set('location_provider_mode', $state['location_provider_mode'] ?? 'manual', 'integrations', 'Location provider mode: manual or google_maps');
        Setting::set('google_maps_api_key', $state['google_maps_api_key'] ?? '', 'integrations', 'Google Maps API Key');
        Setting::set('google_maps_default_country', $state['google_maps_default_country'] ?? 'np', 'integrations', 'Google Places default country code');

        // 4. Communications
        Setting::set('alert_cooldown_hours', $state['alert_cooldown_hours'], 'alerts', 'Hours between alert notifications');
        Setting::set('price_drop_min_percentage', $state['price_drop_min_percentage'], 'alerts', 'Minimum price drop %');
        Setting::set('enable_email_alerts', $state['enable_email_alerts'] ? '1' : '0', 'alerts', 'Enable automated emails');

        // 5. Ranking
        Setting::set('ranking_weight_price', $state['ranking_weight_price'], 'ranking', 'Price weight');
        Setting::set('ranking_weight_supplier', $state['ranking_weight_supplier'], 'ranking', 'Supplier rating weight');
        Setting::set('ranking_weight_terms', $state['ranking_weight_terms'], 'ranking', 'Terms weight');
        Setting::set('ranking_weight_cancellation', $state['ranking_weight_cancellation'], 'ranking', 'Cancellation weight');
        Setting::set('ranking_weight_freshness', $state['ranking_weight_freshness'], 'ranking', 'Freshness weight');
        Setting::set('ranking_weight_commercial', $state['ranking_weight_commercial'], 'ranking', 'Commercial weight');

        // 6. Integrations & Payments
        Setting::set('enable_cash_on_pickup', $state['enable_cash_on_pickup'] ? '1' : '0', 'payments', 'Accept cash on pickup');
        Setting::set('enable_esewa', $state['enable_esewa'] ? '1' : '0', 'payments', 'Accept eSewa');
        Setting::set('enable_khalti', $state['enable_khalti'] ? '1' : '0', 'payments', 'Accept Khalti');

        // 7. Security & OTP Verification
        Setting::set('enable_email_otp', $state['enable_email_otp'] ? '1' : '0', 'security', 'Enable email OTP verification');
        Setting::set('enable_phone_otp', $state['enable_phone_otp'] ? '1' : '0', 'security', 'Enable phone SMS OTP verification');
        Setting::set('otp_trigger_mode', $state['otp_trigger_mode'] ?? 'both', 'security', 'OTP trigger mode');
        Setting::set('otp_expiry_minutes', $state['otp_expiry_minutes'] ?? '10', 'security', 'OTP expiry in minutes');
        Setting::set('otp_max_attempts', $state['otp_max_attempts'] ?? '5', 'security', 'Max OTP entry attempts');
        Setting::set('sms_gateway_provider', $state['sms_gateway_provider'] ?? 'log_mock', 'security', 'SMS gateway provider');
        Setting::set('sparrow_sms_token', $state['sparrow_sms_token'] ?? '', 'security', 'Sparrow SMS API token');
        Setting::set('sparrow_sms_from', $state['sparrow_sms_from'] ?? 'HahakarCar', 'security', 'Sparrow SMS sender');
        Setting::set('aakash_sms_auth_token', $state['aakash_sms_auth_token'] ?? '', 'security', 'Aakash SMS auth token');

        Notification::make()
            ->title('Settings Saved')
            ->body('Website configurations, security, and OTP settings have been successfully updated.')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Changes')
                ->submit('save'),
        ];
    }
}
