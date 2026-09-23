<?php

namespace App\Domain\Alerts\Notifications;

use App\Models\PriceAlert;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PriceAlertConfirmationNotification extends Notification
{
    use Queueable;

    public function __construct(
        public PriceAlert $alert,
        public string $plainVerifyToken
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $confirmUrl = route('alerts.confirm', ['token' => $this->plainVerifyToken]);
        $pickup = $this->alert->pickupLocation->city . ' (' . ($this->alert->pickupLocation->iata_code ?? $this->alert->pickupLocation->name) . ')';
        $dates = $this->alert->pickup_datetime->format('M d, Y') . ' to ' . $this->alert->dropoff_datetime->format('M d, Y');

        return (new MailMessage)
            ->subject("Confirm Your Hahacar Price Alert: {$pickup}")
            ->greeting("Hello!")
            ->line("You requested a price alert on Hahacar for car rentals in **{$pickup}** from **{$dates}**.")
            ->line("Please confirm your subscription by clicking the button below:")
            ->action('Confirm Price Alert', $confirmUrl)
            ->line("We will monitor rates across car-rental providers and email you as soon as prices drop.")
            ->line("If you did not request this alert, you can safely disregard this email.");
    }
}
