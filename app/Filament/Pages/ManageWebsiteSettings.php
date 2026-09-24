<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
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
            // General / Store
            'site_name' => Setting::get('site_name', 'Hahakar Nepal'),
            'support_email' => Setting::get('support_email', 'support@hahakar.com'),
            'support_phone' => Setting::get('support_phone', '+977 9801-HAHAKAR'),
            'store_address' => Setting::get('store_address', 'Thamel Tourist Center, Kathmandu, Bagmati Province, Nepal'),
            'default_currency' => Setting::get('default_currency', 'NPR'),

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

                        // Tab 2: Distance & Fuel Rates
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
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        // 1. General
        Setting::set('site_name', $state['site_name'], 'general', 'Public brand name');
        Setting::set('support_email', $state['support_email'], 'contact', 'Main support email inbox');
        Setting::set('support_phone', $state['support_phone'], 'contact', 'Customer support phone / WhatsApp');
        Setting::set('store_address', $state['store_address'], 'contact', 'Store physical office address in Nepal');
        Setting::set('default_currency', $state['default_currency'], 'general', 'Default platform currency');

        // 2. Distance & Fuel
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

        Notification::make()
            ->title('Settings Saved')
            ->body('Website configurations and fuel rates have been successfully updated.')
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
