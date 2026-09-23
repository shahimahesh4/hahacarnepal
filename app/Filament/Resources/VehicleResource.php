<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VehicleResource\Pages;
use App\Models\Vehicle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationGroup = 'Partner Fleet & Drivers';
    protected static ?string $navigationLabel = 'Fleet & Vehicles';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Vehicle Identity & Owner')
                    ->schema([
                        Forms\Components\Select::make('driver_profile_id')
                            ->relationship('driverProfile.user', 'name')
                            ->label('Owner / Partner Driver')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('category')
                            ->options([
                                'suv_4wd' => '4WD Mountain SUV (Scorpio / Hilux)',
                                'compact_suv' => 'Compact SUV (Creta / Vitara)',
                                'tourist_van' => 'Tourist Commuter Van (HiAce)',
                                'sedan' => 'Comfort Sedan',
                                'hatchback' => 'City Hatchback (Swift / i10)',
                                'luxury_suv' => 'Premium Luxury 4WD (Prado)',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('make')
                            ->required()
                            ->placeholder('e.g. Mahindra, Toyota, Hyundai'),
                        Forms\Components\TextInput::make('model')
                            ->required()
                            ->placeholder('e.g. Scorpio 4WD S11, Hilux, Swift'),
                        Forms\Components\TextInput::make('year')
                            ->numeric()
                            ->default(2023),
                        Forms\Components\TextInput::make('plate_number')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->placeholder('e.g. Ba 2 Cha 4521'),
                    ])->columns(2),

                Forms\Components\Section::make('Specifications & Features')
                    ->schema([
                        Forms\Components\TextInput::make('seating_capacity')
                            ->numeric()
                            ->default(5)
                            ->suffix('Seats'),
                        Forms\Components\TextInput::make('luggage_capacity')
                            ->numeric()
                            ->default(2)
                            ->suffix('Bags'),
                        Forms\Components\Select::make('transmission')
                            ->options([
                                'manual' => 'Manual',
                                'automatic' => 'Automatic',
                            ])
                            ->default('manual')
                            ->required(),
                        Forms\Components\Select::make('fuel_type')
                            ->options([
                                'diesel' => 'Diesel',
                                'petrol' => 'Petrol',
                                'electric' => 'Electric (EV)',
                                'hybrid' => 'Hybrid',
                            ])
                            ->default('diesel')
                            ->required(),
                        Forms\Components\Toggle::make('has_ac')
                            ->label('Air Conditioning (A/C)')
                            ->default(true),
                        Forms\Components\Toggle::make('has_4wd')
                            ->label('Four-Wheel Drive (4WD/4x4)')
                            ->default(false),
                    ])->columns(3),

                Forms\Components\Section::make('Pricing & Service Options')
                    ->schema([
                        Forms\Components\TextInput::make('daily_rate')
                            ->label('Daily Rental Rate')
                            ->numeric()
                            ->prefix('Rs.')
                            ->required()
                            ->helperText('Standard daily rate in Nepalese Rupees (NPR)'),
                        Forms\Components\Toggle::make('provides_driver')
                            ->label('With Driver (Chauffeur)')
                            ->default(true),
                        Forms\Components\Toggle::make('allows_self_drive')
                            ->label('Allows Self-Drive')
                            ->default(true),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active for Booking')
                            ->default(true),
                    ])->columns(2),

                Forms\Components\Section::make('Vehicle Photos')
                    ->schema([
                        Forms\Components\FileUpload::make('vehicle_photo_path')
                            ->label('Vehicle Exterior Photo')
                            ->image()
                            ->directory('uploads/vehicles'),
                        Forms\Components\FileUpload::make('bluebook_photo_path')
                            ->label('Vehicle Bluebook Photo')
                            ->image()
                            ->directory('uploads/bluebooks'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('vehicle_photo_path')
                    ->label('Photo')
                    ->circular(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Vehicle')
                    ->searchable(['make', 'model'])
                    ->sortable(['make'])
                    ->weight('bold'),
                Tables\Columns\BadgeColumn::make('category')
                    ->label('Category')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'suv_4wd' => '4WD SUV',
                        'compact_suv' => 'Compact SUV',
                        'tourist_van' => 'Tourist Van',
                        'sedan' => 'Sedan',
                        'hatchback' => 'Hatchback',
                        'luxury_suv' => 'Luxury 4WD',
                        default => ucfirst($state),
                    })
                    ->colors([
                        'success' => 'suv_4wd',
                        'warning' => 'tourist_van',
                        'info' => 'compact_suv',
                        'primary' => 'luxury_suv',
                    ]),
                Tables\Columns\TextColumn::make('plate_number')
                    ->label('Plate No.')
                    ->searchable(),
                Tables\Columns\TextColumn::make('driverProfile.user.name')
                    ->label('Owner / Partner')
                    ->searchable(),
                Tables\Columns\TextColumn::make('daily_rate')
                    ->label('Daily Rate')
                    ->formatStateUsing(fn ($state) => 'Rs. ' . number_format($state))
                    ->sortable(),
                Tables\Columns\IconColumn::make('has_4wd')
                    ->label('4WD')
                    ->boolean(),
                Tables\Columns\IconColumn::make('provides_driver')
                    ->label('Chauffeur')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'suv_4wd' => '4WD Mountain SUV',
                        'compact_suv' => 'Compact SUV',
                        'tourist_van' => 'Tourist Van',
                        'sedan' => 'Sedan',
                        'hatchback' => 'Hatchback',
                        'luxury_suv' => 'Luxury 4WD',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVehicles::route('/'),
            'create' => Pages\CreateVehicle::route('/create'),
            'edit' => Pages\EditVehicle::route('/{record}/edit'),
        ];
    }
}
