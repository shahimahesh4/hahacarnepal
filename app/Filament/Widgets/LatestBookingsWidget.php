<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\BookingResource;
use App\Models\Booking;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestBookingsWidget extends BaseWidget
{
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Recent Direct Reservations';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Booking::query()->latest()->limit(6)
            )
            ->columns([
                Tables\Columns\TextColumn::make('booking_reference')
                    ->label('Reference')
                    ->searchable()
                    ->weight('bold')
                    ->copyable()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Customer')
                    ->description(fn (Booking $record): string => $record->customer_phone ?? '')
                    ->searchable(),

                Tables\Columns\TextColumn::make('vehicle.model')
                    ->label('Vehicle')
                    ->default(fn (Booking $record) => $record->vehicle ? "{$record->vehicle->make} {$record->vehicle->model}" : 'Fleet Assigned')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('pickup_date')
                    ->label('Trip Dates')
                    ->dateTime('M d, Y')
                    ->description(fn (Booking $record): string => $record->return_date ? 'Until ' . $record->return_date->format('M d, Y') . " ({$record->total_days}d)" : ''),

                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total (NPR)')
                    ->money('NPR')
                    ->weight('bold')
                    ->color('success'),

                Tables\Columns\BadgeColumn::make('payment_method')
                    ->label('Payment')
                    ->colors([
                        'success' => 'esewa',
                        'info' => 'khalti',
                        'warning' => 'cash_on_pickup',
                    ]),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'confirmed',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('confirm')
                    ->label('Confirm')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Booking $record) => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->action(function (Booking $record) {
                        $record->update(['status' => 'confirmed']);
                        Notification::make()->title('Booking Confirmed')->success()->send();
                    }),

                Tables\Actions\Action::make('view')
                    ->label('Manage')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn (Booking $record): string => BookingResource::getUrl('edit', ['record' => $record])),
            ])
            ->emptyStateHeading('No Direct Bookings Yet')
            ->emptyStateDescription('When customers book vehicles directly through the website, they will appear here.')
            ->paginated(false);
    }
}
