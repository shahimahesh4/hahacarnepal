<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OutboundClickResource\Pages;
use App\Models\OutboundClick;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OutboundClickResource extends Resource
{
    protected static ?string $model = OutboundClick::class;
    protected static ?string $navigationIcon = 'heroicon-o-cursor-arrow-rays';
    protected static ?string $navigationGroup = 'Attribution & Revenue';
    protected static ?int $navigationSort = 1;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('uuid')
                    ->limit(8)
                    ->label('Click ID'),
                Tables\Columns\TextColumn::make('provider.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('offer.vehicle_name')
                    ->limit(20)
                    ->label('Vehicle'),
                Tables\Columns\TextColumn::make('sub_id')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('utm_source')
                    ->searchable(),
                Tables\Columns\TextColumn::make('device_type')
                    ->badge(),
                Tables\Columns\TextColumn::make('clicked_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('clicked_at', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOutboundClicks::route('/'),
        ];
    }
}
