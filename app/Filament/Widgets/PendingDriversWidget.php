<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\DriverResource;
use App\Models\DriverProfile;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PendingDriversWidget extends BaseWidget
{
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Driver Partners Awaiting Verification (KYC Queue)';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                DriverProfile::query()->where('status', 'pending')->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Driver / Fleet Owner')
                    ->weight('bold')
                    ->description(fn (DriverProfile $record): string => $record->user->email ?? ''),

                Tables\Columns\TextColumn::make('user.phone')
                    ->label('Phone / WhatsApp')
                    ->copyable()
                    ->default(fn (DriverProfile $record) => $record->user->phone ?? 'N/A'),

                Tables\Columns\TextColumn::make('province')
                    ->label('Province')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('service_city')
                    ->label('Service Hub')
                    ->searchable(),

                Tables\Columns\TextColumn::make('license_number')
                    ->label('License Number')
                    ->copyable()
                    ->default('Pending'),

                Tables\Columns\BadgeColumn::make('partner_type')
                    ->label('Role')
                    ->colors([
                        'primary' => 'driver',
                        'success' => 'fleet_owner',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registered')
                    ->since(),
            ])
            ->actions([
                Tables\Actions\Action::make('verify')
                    ->label('Verify Partner')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Approve Driver Partner')
                    ->modalDescription('Are you sure you want to verify this partner? They will immediately become eligible to accept passenger reservations on Hahakar Nepal.')
                    ->action(function (DriverProfile $record) {
                        $record->update([
                            'status' => 'verified',
                            'verified_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Driver Partner Verified!')
                            ->body("{$record->user->name} is now approved and active.")
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('review')
                    ->label('Review KYC')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->color('primary')
                    ->url(fn (DriverProfile $record): string => DriverResource::getUrl('edit', ['record' => $record])),
            ])
            ->emptyStateHeading('KYC Queue Clear')
            ->emptyStateDescription('All registered driver partners and fleet owners have been verified.')
            ->emptyStateIcon('heroicon-o-check-badge')
            ->paginated(false);
    }
}
