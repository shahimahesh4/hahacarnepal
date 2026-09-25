<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Bookings & Operations';
    protected static ?string $navigationLabel = 'Direct Bookings';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Reservation Reference & Assignment')
                    ->schema([
                        Forms\Components\TextInput::make('booking_reference')
                            ->required()
                            ->disabled()
                            ->dehydrated(fn ($state) => filled($state)),
                        Forms\Components\Select::make('vehicle_id')
                            ->relationship('vehicle', 'plate_number')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->make} {$record->model} ({$record->plate_number})")
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('driver_profile_id')
                            ->relationship('driverProfile.user', 'name')
                            ->label('Assigned Driver / Partner')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('service_option')
                            ->options([
                                'with_driver' => 'With Driver (Chauffeur)',
                                'self_drive' => 'Self-Drive Rental',
                            ])
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Customer Information')
                    ->schema([
                        Forms\Components\TextInput::make('customer_name')
                            ->required(),
                        Forms\Components\TextInput::make('customer_phone')
                            ->required(),
                        Forms\Components\TextInput::make('customer_email')
                            ->email()
                            ->required(),
                    ])->columns(3),

                Forms\Components\Section::make('Schedule & Locations')
                    ->schema([
                        Forms\Components\TextInput::make('pickup_location')
                            ->required(),
                        Forms\Components\TextInput::make('return_location')
                            ->required(),
                        Forms\Components\DateTimePicker::make('pickup_date')
                            ->required(),
                        Forms\Components\DateTimePicker::make('return_date')
                            ->required(),
                        Forms\Components\TextInput::make('total_days')
                            ->numeric()
                            ->default(1),
                    ])->columns(3),

                Forms\Components\Section::make('Billing & Status')
                    ->schema([
                        Forms\Components\TextInput::make('daily_rate')
                            ->numeric()
                            ->prefix('Rs.')
                            ->required(),
                        Forms\Components\TextInput::make('total_price')
                            ->numeric()
                            ->prefix('Rs.')
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending Confirmation',
                                'confirmed' => 'Confirmed',
                                'active' => 'Active / On Trip',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required(),
                        Forms\Components\Select::make('payment_method')
                            ->options([
                                'cash' => 'Cash on Pickup',
                                'esewa' => 'eSewa Nepal',
                                'khalti' => 'Khalti Digital Wallet',
                            ])
                            ->default('cash'),
                        Forms\Components\Select::make('payment_status')
                            ->options([
                                'pending' => 'Pending Payment',
                                'paid' => 'Paid',
                            ])
                            ->default('pending'),
                        Forms\Components\Textarea::make('special_requests')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('booking_reference')
                    ->label('Reference')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable(),
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Customer')
                    ->description(fn (Booking $record): string => $record->customer_phone)
                    ->searchable(),
                Tables\Columns\TextColumn::make('vehicle.title')
                    ->label('Vehicle')
                    ->description(fn (Booking $record): string => $record->vehicle ? $record->vehicle->plate_number : '-')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pickup_location')
                    ->label('Route')
                    ->description(fn (Booking $record): string => 'to ' . $record->return_location)
                    ->limit(25),
                Tables\Columns\TextColumn::make('pickup_date')
                    ->label('Pickup Date')
                    ->dateTime('M d, Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total Price (NPR)')
                    ->formatStateUsing(fn ($state) => 'Rs. ' . number_format($state))
                    ->description(function (Booking $record) {
                        $driverPct = (float) \App\Models\Setting::get('driver_payout_percentage', 85);
                        $adminPct = (float) \App\Models\Setting::get('admin_commission_percentage', 15);
                        $driverAmt = round($record->total_price * ($driverPct / 100));
                        $adminAmt = round($record->total_price * ($adminPct / 100));
                        return "Driver ({$driverPct}%): Rs. " . number_format($driverAmt) . " | Admin ({$adminPct}%): Rs. " . number_format($adminAmt);
                    })
                    ->weight('bold')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'confirmed',
                        'primary' => 'active',
                        'gray' => 'completed',
                        'danger' => 'cancelled',
                    ]),
                Tables\Columns\BadgeColumn::make('payment_status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'active' => 'Active',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
                Tables\Filters\SelectFilter::make('payment_status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('confirm')
                    ->label('Confirm')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Booking $record): bool => $record->status === 'pending')
                    ->action(function (Booking $record) {
                        $record->update(['status' => 'confirmed']);
                        Notification::make()
                            ->title('Booking Confirmed')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('complete')
                    ->label('Complete')
                    ->icon('heroicon-o-check-circle')
                    ->color('primary')
                    ->requiresConfirmation()
                    ->visible(fn (Booking $record): bool => in_array($record->status, ['confirmed', 'active']))
                    ->action(function (Booking $record) {
                        $record->update(['status' => 'completed']);
                        Notification::make()
                            ->title('Booking Marked Completed')
                            ->success()
                            ->send();
                    }),
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
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
