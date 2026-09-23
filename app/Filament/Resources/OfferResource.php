<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfferResource\Pages;
use App\Models\Offer;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OfferResource extends Resource
{
    protected static ?string $model = Offer::class;
    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationGroup = 'Search & Deals';
    protected static ?int $navigationSort = 2;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('vehicle_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('vehicleCategory.name')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('supplier_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_price_formatted')
                    ->label('Total Price')
                    ->sortable('total_price_minor'),
                Tables\Columns\TextColumn::make('daily_price_formatted')
                    ->label('Daily Price')
                    ->sortable('daily_price_minor'),
                Tables\Columns\TextColumn::make('ranking_score')
                    ->label('Score')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_sponsored')
                    ->boolean()
                    ->label('Sponsored'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOffers::route('/'),
        ];
    }
}
