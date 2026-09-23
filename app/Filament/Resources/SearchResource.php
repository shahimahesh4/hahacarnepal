<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SearchResource\Pages;
use App\Models\Search;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SearchResource extends Resource
{
    protected static ?string $model = Search::class;
    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass';
    protected static ?string $navigationGroup = 'Search & Deals';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('uuid')
                    ->disabled(),
                Forms\Components\TextInput::make('criteria_hash')
                    ->disabled(),
                Forms\Components\Select::make('pickup_location_id')
                    ->relationship('pickupLocation', 'city')
                    ->disabled(),
                Forms\Components\Select::make('dropoff_location_id')
                    ->relationship('dropoffLocation', 'city')
                    ->disabled(),
                Forms\Components\DateTimePicker::make('pickup_datetime')
                    ->disabled(),
                Forms\Components\DateTimePicker::make('dropoff_datetime')
                    ->disabled(),
                Forms\Components\TextInput::make('driver_age')
                    ->disabled(),
                Forms\Components\TextInput::make('currency')
                    ->disabled(),
                Forms\Components\TextInput::make('result_count')
                    ->disabled(),
                Forms\Components\TextInput::make('duration_ms')
                    ->suffix('ms')
                    ->disabled(),
                Forms\Components\TextInput::make('status')
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('uuid')
                    ->limit(8)
                    ->copyable()
                    ->label('ID'),
                Tables\Columns\TextColumn::make('pickupLocation.city')
                    ->label('Pickup')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dropoffLocation.city')
                    ->label('Drop-off'),
                Tables\Columns\TextColumn::make('pickup_datetime')
                    ->dateTime('M d, H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('dropoff_datetime')
                    ->dateTime('M d, H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('result_count')
                    ->label('Offers')
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration_ms')
                    ->suffix(' ms')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'completed',
                        'warning' => 'pending',
                        'danger' => 'failed',
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
            'index' => Pages\ListSearches::route('/'),
        ];
    }
}
