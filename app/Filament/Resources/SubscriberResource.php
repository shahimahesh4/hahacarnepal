<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscriberResource\Pages;
use App\Mail\DirectNotificationMail;
use App\Models\Subscriber;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;

class SubscriberResource extends Resource
{
    protected static ?string $model = Subscriber::class;
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationGroup = 'Alerts & Engagement';
    protected static ?int $navigationSort = 2;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('semibold'),
                Tables\Columns\TextColumn::make('source')
                    ->badge(),
                Tables\Columns\TextColumn::make('locale')
                    ->badge(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'active',
                        'warning' => 'pending',
                        'danger' => 'unsubscribed',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                // Single Direct Email Action
                Tables\Actions\Action::make('sendEmail')
                    ->label('Send Email')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('emerald')
                    ->form([
                        Forms\Components\TextInput::make('subject')
                            ->label('Email Subject')
                            ->placeholder('e.g. Exclusive Nepal Rental Discount for You')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('headline')
                            ->label('Heading (Optional)')
                            ->placeholder('e.g. Special Offer from Hahakar Nepal')
                            ->maxLength(255),

                        Forms\Components\Textarea::make('message')
                            ->label('Email Message')
                            ->placeholder('Write your message here...')
                            ->rows(5)
                            ->required(),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('cta_text')
                                    ->label('Button Text (Optional)')
                                    ->placeholder('e.g. View Rental Deals'),

                                Forms\Components\TextInput::make('cta_url')
                                    ->label('Button URL (Optional)')
                                    ->url()
                                    ->placeholder('https://hahakar.com/book-vehicle'),
                            ]),
                    ])
                    ->action(function (Subscriber $record, array $data) {
                        try {
                            Mail::to($record->email)->send(new DirectNotificationMail(
                                emailSubject: $data['subject'],
                                messageBody: $data['message'],
                                headline: $data['headline'] ?? null,
                                ctaText: $data['cta_text'] ?? null,
                                ctaUrl: $data['cta_url'] ?? null,
                                recipientEmail: $record->email
                            ));

                            Notification::make()
                                ->title('Email Sent Successfully!')
                                ->body("Direct message delivered to {$record->email}.")
                                ->success()
                                ->send();
                        } catch (\Throwable $e) {
                            Notification::make()
                                ->title('Delivery Failed')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),

                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Bulk Send Action to Selected Subscribers
                Tables\Actions\BulkAction::make('sendBulkEmail')
                    ->label('Send Email to Selected')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('emerald')
                    ->form([
                        Forms\Components\TextInput::make('subject')
                            ->label('Email Subject')
                            ->placeholder('e.g. Special Nepal Holiday Rental Deals')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('headline')
                            ->label('Heading (Optional)')
                            ->placeholder('e.g. Exclusive Travel Deals for Hahakar Subscribers')
                            ->maxLength(255),

                        Forms\Components\Textarea::make('message')
                            ->label('Email Message')
                            ->placeholder('Write your announcement or discount details here...')
                            ->rows(5)
                            ->required(),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('cta_text')
                                    ->label('Button Text (Optional)')
                                    ->default('Explore Nepal Rentals')
                                    ->placeholder('e.g. Book Vehicle Now'),

                                Forms\Components\TextInput::make('cta_url')
                                    ->label('Button URL (Optional)')
                                    ->default(config('app.url', 'https://hahakar.com'))
                                    ->url(),
                            ]),
                    ])
                    ->action(function (Collection $records, array $data) {
                        $sentCount = 0;
                        $failCount = 0;

                        foreach ($records as $subscriber) {
                            if ($subscriber->status === 'unsubscribed') {
                                continue;
                            }

                            try {
                                Mail::to($subscriber->email)->send(new DirectNotificationMail(
                                    emailSubject: $data['subject'],
                                    messageBody: $data['message'],
                                    headline: $data['headline'] ?? null,
                                    ctaText: $data['cta_text'] ?? null,
                                    ctaUrl: $data['cta_url'] ?? null,
                                    recipientEmail: $subscriber->email
                                ));
                                $sentCount++;
                            } catch (\Throwable $e) {
                                $failCount++;
                            }
                        }

                        Notification::make()
                            ->title('Bulk Emails Processed!')
                            ->body("Sent to {$sentCount} subscriber(s)." . ($failCount > 0 ? " ({$failCount} failed)" : ""))
                            ->success()
                            ->send();
                    })
                    ->deselectRecordsAfterCompletion(),

                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscribers::route('/'),
        ];
    }
}

