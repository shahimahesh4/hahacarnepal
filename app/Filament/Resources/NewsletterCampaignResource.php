<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsletterCampaignResource\Pages;
use App\Mail\NewsletterCampaignMail;
use App\Models\NewsletterCampaign;
use App\Models\Subscriber;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\HtmlString;

class NewsletterCampaignResource extends Resource
{
    protected static ?string $model = NewsletterCampaign::class;
    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    protected static ?string $navigationGroup = 'Alerts & Engagement';
    protected static ?string $navigationLabel = 'Email Campaigns';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Campaign Builder')
                    ->tabs([
                        // Tab 1: Campaign Details & Subject
                        Forms\Components\Tabs\Tab::make('1. Campaign & Subject')
                            ->icon('heroicon-o-envelope')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Internal Campaign Name')
                                    ->placeholder('e.g. Dashain 2026 Scorpio 4WD 20% Off Promo')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('subject')
                                    ->label('Email Subject Line')
                                    ->placeholder('e.g. 🔥 Exclusive Festive Deal: 20% Off Scorpio 4WD & HiAce Rentals!')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('preview_text')
                                    ->label('Inbox Preheader Text (Snippet)')
                                    ->placeholder('e.g. Book verified Nepal 4WDs and tourist vans before festive slots fill up...')
                                    ->maxLength(255)
                                    ->helperText('Visible next to or below the subject line in Gmail/Apple Mail preview.')
                                    ->columnSpan(1),

                                Forms\Components\TextInput::make('badge_text')
                                    ->label('Header Badge Pill (Optional)')
                                    ->placeholder('e.g. Festive Offer, Nepal Travel Alert, Fleet News')
                                    ->maxLength(100)
                                    ->columnSpan(1),
                            ])->columns(2),

                        // Tab 2: Message & Visuals
                        Forms\Components\Tabs\Tab::make('2. Email Message')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Forms\Components\TextInput::make('headline')
                                    ->label('Email Main Heading')
                                    ->placeholder('e.g. Explore Nepal with Transparent NPR Rates & Verified Drivers')
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('banner_image_url')
                                    ->label('Hero Banner Image URL (Optional)')
                                    ->placeholder('https://images.unsplash.com/... or asset URL')
                                    ->url()
                                    ->maxLength(500)
                                    ->columnSpanFull(),

                                Forms\Components\RichEditor::make('content')
                                    ->label('Email Body Content')
                                    ->placeholder('Write your promotional announcement, travel tips, festive discounts, or route guidelines...')
                                    ->required()
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'underline',
                                        'strike',
                                        'link',
                                        'bulletList',
                                        'orderedList',
                                        'h2',
                                        'h3',
                                        'blockquote',
                                        'undo',
                                        'redo',
                                    ])
                                    ->columnSpanFull(),
                            ]),

                        // Tab 3: Featured Offer / Service Spotlight
                        Forms\Components\Tabs\Tab::make('3. Featured Offer / Service')
                            ->icon('heroicon-o-tag')
                            ->schema([
                                Forms\Components\Placeholder::make('offer_help')
                                    ->content('Highlight a specific vehicle model, seasonal route package, or special discount card inside the email.')
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('featured_offer_title')
                                    ->label('Offer / Vehicle Title')
                                    ->placeholder('e.g. Mahindra Scorpio 4WD (Mustang & Mountain Ready)')
                                    ->maxLength(255)
                                    ->columnSpan(1),

                                Forms\Components\TextInput::make('featured_offer_price')
                                    ->label('Price / Discount Display')
                                    ->placeholder('e.g. Rs. 7,500 / day (Was Rs. 9,000)')
                                    ->maxLength(100)
                                    ->columnSpan(1),

                                Forms\Components\TextInput::make('featured_offer_badge')
                                    ->label('Offer Tag')
                                    ->placeholder('e.g. 15% OFF, Best Seller, Chauffeur Included')
                                    ->maxLength(50)
                                    ->columnSpan(1),

                                Forms\Components\Textarea::make('featured_offer_description')
                                    ->label('Offer Details / Bullet Points')
                                    ->placeholder('e.g. Includes experienced mountain driver, fuel policy options, free cancellation up to 48 hrs, and 24/7 hotline support.')
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ])->columns(2),

                        // Tab 4: Call to Action Button
                        Forms\Components\Tabs\Tab::make('4. Call to Action')
                            ->icon('heroicon-o-cursor-arrow-rays')
                            ->schema([
                                Forms\Components\TextInput::make('cta_text')
                                    ->label('Button Text')
                                    ->default('Explore Nepal Rentals')
                                    ->placeholder('e.g. Book Scorpio 4WD Now, Claim Festive Offer')
                                    ->maxLength(100)
                                    ->columnSpan(1),

                                Forms\Components\TextInput::make('cta_url')
                                    ->label('Button Destination URL')
                                    ->default(config('app.url', 'https://hahakar.com'))
                                    ->placeholder('https://hahakar.com/book-vehicle')
                                    ->url()
                                    ->maxLength(500)
                                    ->columnSpan(1),
                            ])->columns(2),

                        // Tab 5: Audience & Delivery
                        Forms\Components\Tabs\Tab::make('5. Target Audience')
                            ->icon('heroicon-o-user-group')
                            ->schema([
                                Forms\Components\Select::make('target_audience')
                                    ->label('Who should receive this email?')
                                    ->options([
                                        'all_subscribers' => 'All Active Newsletter Subscribers',
                                        'all_users' => 'All Registered Users & Customers',
                                        'customers_only' => 'Registered Customers Only',
                                        'partners_only' => 'Partner Drivers & Fleet Hosts Only',
                                        'all_contacts' => 'Combined All Contacts (Subscribers + Users)',
                                        'manual_selection' => 'Manual Multi-Selection (Pick from list below)',
                                        'custom_emails' => 'Custom Email List (Paste custom emails)',
                                    ])
                                    ->default('all_subscribers')
                                    ->required()
                                    ->live()
                                    ->columnSpanFull(),

                                Forms\Components\Select::make('manual_recipients')
                                    ->label('Select Specific Subscribers or Users')
                                    ->multiple()
                                    ->searchable()
                                    ->options(function () {
                                        $subscribers = Subscriber::where('status', 'active')->pluck('email', 'email');
                                        $users = User::where('status', 'active')->pluck('email', 'email');
                                        return $subscribers->merge($users)->unique()->toArray();
                                    })
                                    ->visible(fn (Forms\Get $get) => $get('target_audience') === 'manual_selection')
                                    ->columnSpanFull(),

                                Forms\Components\Textarea::make('manual_recipients')
                                    ->label('Enter Custom Email Addresses')
                                    ->placeholder("traveler1@example.com\ntraveler2@gmail.com, partner3@yahoo.com")
                                    ->helperText('Separate multiple emails by commas, semicolons, or new lines.')
                                    ->rows(4)
                                    ->visible(fn (Forms\Get $get) => $get('target_audience') === 'custom_emails')
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Campaign Title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (NewsletterCampaign $record) => $record->subject),

                Tables\Columns\BadgeColumn::make('target_audience')
                    ->label('Audience')
                    ->colors([
                        'primary' => 'all_subscribers',
                        'success' => 'all_contacts',
                        'warning' => 'partners_only',
                        'info' => 'customers_only',
                    ])
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'all_subscribers' => 'Subscribers',
                        'all_users' => 'All Users',
                        'customers_only' => 'Customers',
                        'partners_only' => 'Partners',
                        'all_contacts' => 'All Contacts',
                        'manual_selection' => 'Manual Pick',
                        'custom_emails' => 'Custom List',
                        default => ucfirst($state),
                    }),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'gray' => 'draft',
                        'warning' => 'sending',
                        'success' => 'sent',
                        'danger' => 'failed',
                    ]),

                Tables\Columns\TextColumn::make('successful_sends')
                    ->label('Delivered / Total')
                    ->formatStateUsing(fn (NewsletterCampaign $record) => "{$record->successful_sends} / {$record->total_recipients}")
                    ->sortable(),

                Tables\Columns\TextColumn::make('sent_at')
                    ->label('Sent Date')
                    ->dateTime('M j, Y H:i')
                    ->sortable()
                    ->placeholder('Not sent yet'),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                // 1. Preview Action
                Tables\Actions\Action::make('preview')
                    ->label('Preview')
                    ->icon('heroicon-o-eye')
                    ->color('gray')
                    ->modalHeading(fn (NewsletterCampaign $record) => 'Preview: ' . $record->subject)
                    ->modalWidth('4xl')
                    ->modalContent(function (NewsletterCampaign $record) {
                        $html = view('emails.campaign', [
                            'campaign' => $record,
                            'previewText' => $record->preview_text ?? $record->headline,
                            'unsubscribeUrl' => '#',
                            'subject' => $record->subject,
                        ])->render();

                        return new HtmlString("<iframe srcdoc=\"" . htmlspecialchars($html) . "\" style=\"width: 100%; height: 600px; border: none; border-radius: 12px;\"></iframe>");
                    }),

                // 2. Send Test Email Action
                Tables\Actions\Action::make('sendTest')
                    ->label('Test Email')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('info')
                    ->form([
                        Forms\Components\TextInput::make('test_email')
                            ->label('Send Test Email To')
                            ->email()
                            ->required()
                            ->default(fn () => auth()->user()?->email ?? 'admin@hahakar.com'),
                    ])
                    ->action(function (NewsletterCampaign $record, array $data) {
                        try {
                            Mail::to($data['test_email'])->send(new NewsletterCampaignMail($record, $data['test_email']));

                            Notification::make()
                                ->title('Test Email Sent Successfully!')
                                ->body("Preview has been delivered to {$data['test_email']}.")
                                ->success()
                                ->send();
                        } catch (\Throwable $e) {
                            Notification::make()
                                ->title('Failed to Send Test Email')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),

                // 3. Broadcast Action
                Tables\Actions\Action::make('broadcast')
                    ->label('Send Campaign')
                    ->icon('heroicon-o-rocket-launch')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Broadcast Newsletter Campaign')
                    ->modalDescription(function (NewsletterCampaign $record) {
                        $recipients = $record->resolveRecipients();
                        $count = $recipients->count();
                        return "Are you sure you want to send this campaign to {$count} recipient(s)? This action cannot be undone.";
                    })
                    ->action(function (NewsletterCampaign $record) {
                        $recipients = $record->resolveRecipients();
                        $total = $recipients->count();

                        if ($total === 0) {
                            Notification::make()
                                ->title('No Recipients Found')
                                ->body('The selected target audience has 0 valid active email addresses.')
                                ->warning()
                                ->send();
                            return;
                        }

                        $record->update([
                            'status' => 'sending',
                            'total_recipients' => $total,
                            'successful_sends' => 0,
                            'failed_sends' => 0,
                        ]);

                        $successCount = 0;
                        $failCount = 0;

                        foreach ($recipients as $email) {
                            try {
                                Mail::to($email)->send(new NewsletterCampaignMail($record, $email));
                                $successCount++;
                            } catch (\Throwable $e) {
                                $failCount++;
                            }
                        }

                        $record->update([
                            'status' => 'sent',
                            'successful_sends' => $successCount,
                            'failed_sends' => $failCount,
                            'sent_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Campaign Broadcast Completed!')
                            ->body("Successfully delivered to {$successCount} recipient(s)." . ($failCount > 0 ? " ({$failCount} failed)" : ""))
                            ->success()
                            ->send();
                    }),

                // 4. Duplicate Campaign Action
                Tables\Actions\Action::make('duplicate')
                    ->label('Duplicate')
                    ->icon('heroicon-o-document-duplicate')
                    ->color('gray')
                    ->action(function (NewsletterCampaign $record) {
                        $clone = $record->replicate([
                            'status',
                            'total_recipients',
                            'successful_sends',
                            'failed_sends',
                            'sent_at',
                        ]);
                        $clone->title = $record->title . ' (Copy)';
                        $clone->status = 'draft';
                        $clone->save();

                        Notification::make()
                            ->title('Campaign Duplicated')
                            ->body("New draft created: {$clone->title}")
                            ->success()
                            ->send();
                    }),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNewsletterCampaigns::route('/'),
            'create' => Pages\CreateNewsletterCampaign::route('/create'),
            'edit' => Pages\EditNewsletterCampaign::route('/{record}/edit'),
        ];
    }
}
