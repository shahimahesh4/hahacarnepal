<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DriverResource\Pages;
use App\Models\DriverProfile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DriverResource extends Resource
{
    protected static ?string $model = DriverProfile::class;
    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?string $navigationGroup = 'Partner Fleet & Drivers';
    protected static ?string $navigationLabel = 'Partners & Drivers';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Partner Details')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('partner_type')
                            ->options([
                                'individual_driver' => 'Individual Driver / Chauffeur',
                                'vehicle_owner' => 'Private Vehicle Owner',
                                'fleet_operator' => 'Fleet / Rental Operator',
                            ])
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending Verification',
                                'verified' => 'Verified & Active',
                                'rejected' => 'Rejected',
                                'suspended' => 'Suspended',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('service_city')
                            ->required()
                            ->placeholder('e.g. Kathmandu, Pokhara, Chitwan'),
                        Forms\Components\TextInput::make('service_area')
                            ->placeholder('e.g. Bagmati Province, All Nepal'),
                        Forms\Components\TextInput::make('license_number')
                            ->placeholder('Nepali Driving License No.'),
                    ])->columns(2),

                Forms\Components\Section::make('Verification Documents')
                    ->schema([
                        Forms\Components\FileUpload::make('license_photo_path')
                            ->label('Driving License Photo')
                            ->image()
                            ->directory('uploads/licenses'),
                        Forms\Components\FileUpload::make('bluebook_photo_path')
                            ->label('Vehicle Bluebook (Registration) Photo')
                            ->image()
                            ->directory('uploads/bluebooks'),
                        Forms\Components\FileUpload::make('citizenship_photo_path')
                            ->label('Citizenship / NID Photo')
                            ->image()
                            ->directory('uploads/citizenships'),
                    ])->columns(3),

                Forms\Components\Section::make('Performance & Admin Notes')
                    ->schema([
                        Forms\Components\TextInput::make('rating')
                            ->numeric()
                            ->default(5.00),
                        Forms\Components\TextInput::make('total_bookings')
                            ->numeric()
                            ->default(0),
                        Forms\Components\Textarea::make('admin_notes')
                            ->placeholder('Internal review notes or rejection reason')
                            ->rows(3),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Partner Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('user.phone')
                    ->label('Phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('service_city')
                    ->label('City')
                    ->sortable()
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('partner_type')
                    ->label('Type')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'individual_driver' => 'Driver',
                        'vehicle_owner' => 'Owner',
                        'fleet_operator' => 'Fleet Operator',
                        default => ucfirst($state),
                    }),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'verified',
                        'danger' => 'rejected',
                        'gray' => 'suspended',
                    ]),
                Tables\Columns\TextColumn::make('vehicles_count')
                    ->counts('vehicles')
                    ->label('Vehicles'),
                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->suffix(' ★')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending Review',
                        'verified' => 'Verified',
                        'rejected' => 'Rejected',
                        'suspended' => 'Suspended',
                    ]),
                Tables\Filters\SelectFilter::make('service_city')
                    ->options([
                        'Kathmandu' => 'Kathmandu',
                        'Pokhara' => 'Pokhara',
                        'Chitwan' => 'Chitwan',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('verify')
                    ->label('Approve & Verify')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (DriverProfile $record): bool => $record->status !== 'verified')
                    ->action(function (DriverProfile $record) {
                        $record->update([
                            'status' => 'verified',
                            'verified_at' => now(),
                        ]);
                        Notification::make()
                            ->title('Partner Profile Verified')
                            ->body("Partner {$record->user->name} has been verified and their vehicles are now active.")
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->form([
                        Forms\Components\Textarea::make('reason')
                            ->label('Rejection Reason')
                            ->required(),
                    ])
                    ->visible(fn (DriverProfile $record): bool => $record->status === 'pending')
                    ->action(function (DriverProfile $record, array $data) {
                        $record->update([
                            'status' => 'rejected',
                            'admin_notes' => $data['reason'],
                        ]);
                        Notification::make()
                            ->title('Application Rejected')
                            ->warning()
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
            'index' => Pages\ListDrivers::route('/'),
            'create' => Pages\CreateDriver::route('/create'),
            'edit' => Pages\EditDriver::route('/{record}/edit'),
        ];
    }
}
