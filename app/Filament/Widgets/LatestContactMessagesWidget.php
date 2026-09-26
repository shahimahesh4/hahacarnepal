<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ContactMessageResource;
use App\Models\ContactMessage;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestContactMessagesWidget extends BaseWidget
{
    protected static ?int $sort = 6;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Recent Customer Inquiries & Support Desk';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ContactMessage::query()->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Customer')
                    ->weight('bold')
                    ->description(fn (ContactMessage $record): string => $record->email ?? ''),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone')
                    ->copyable()
                    ->default(fn (ContactMessage $record) => $record->phone ?: 'N/A'),

                Tables\Columns\TextColumn::make('subject')
                    ->label('Subject / Inquiry')
                    ->limit(50)
                    ->weight('medium'),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'danger' => 'new',
                        'warning' => 'in_progress',
                        'success' => 'resolved',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Received')
                    ->since(),
            ])
            ->actions([
                Tables\Actions\Action::make('resolve')
                    ->label('Mark Resolved')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn (ContactMessage $record) => $record->status !== 'resolved')
                    ->action(function (ContactMessage $record) {
                        $record->update(['status' => 'resolved']);
                        Notification::make()
                            ->title('Inquiry Resolved')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('open')
                    ->label('View Ticket')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn (ContactMessage $record): string => ContactMessageResource::getUrl('edit', ['record' => $record])),
            ])
            ->emptyStateHeading('Support Inbox Clear')
            ->emptyStateDescription('No pending customer messages or support requests.')
            ->emptyStateIcon('heroicon-o-inbox')
            ->paginated(false);
    }
}
