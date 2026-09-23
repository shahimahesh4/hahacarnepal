<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PriceAlertResource\Pages;
use App\Models\PriceAlert;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PriceAlertResource extends Resource
{
    protected static ?string $model = PriceAlert::class;
    protected static ?string $navigationIcon = 'heroicon-o-bell-alert';
    protected static ?string $navigationGroup = 'Alerts & Engagement';
    protected static ?int $navigationSort = 1;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pickupLocation.city')
                    ->label('Destination')
                    ->searchable(),
                Tables\Columns\TextColumn::make('threshold_type')
                    ->badge(),
                Tables\Columns\TextColumn::make('threshold_value')
                    ->label('Value'),
                Tables\Columns\TextColumn::make('last_best_price_formatted')
                    ->label('Last Best Rate'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'active',
                        'warning' => 'pending_confirmation',
                        'gray' => 'paused',
                        'danger' => 'unsubscribed',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPriceAlerts::route('/'),
        ];
    }
}
