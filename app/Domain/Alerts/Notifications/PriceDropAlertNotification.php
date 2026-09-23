<?php

namespace App\Domain\Alerts\Notifications;

use App\Models\Offer;
use App\Models\PriceAlert;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PriceDropAlertNotification extends Notification
{
    use Queueable;

    public function __construct(
        public PriceAlert $alert,
        public int $oldPriceMinor,
        public int $newPriceMinor,
        public Offer $bestOffer,
        public string $plainManageToken
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $pickup = $this->alert->pickupLocation->city;
        $savedMinor = $this->oldPriceMinor - $this->newPriceMinor;
        $savedFormatted = '$' . number_format($savedMinor / 100, 2);
        $newPriceFormatted = '$' . number_format($this->newPriceMinor / 100, 2);
        $oldPriceFormatted = '$' . number_format($this->oldPriceMinor / 100, 2);

        $resultsUrl = route('search.index', [
            'pickup' => $this->alert->pickup_location_id,
            'dropoff' => $this->alert->dropoff_location_id,
            'from' => $this->alert->pickup_datetime->format('Y-m-d\TH:i'),
            'to' => $this->alert->dropoff_datetime->format('Y-m-d\TH:i'),
        ]);

        $unsubscribeUrl = route('alerts.unsubscribe', ['token' => $this->plainManageToken]);

        return (new MailMessage)
            ->subject("🎉 Price Drop Alert! Save {$savedFormatted} on your car rental in {$pickup}")
            ->greeting("Great news!")
            ->line("The rental price for your upcoming trip in **{$pickup}** has dropped from ~~{$oldPriceFormatted}~~ to **{$newPriceFormatted}** (Save {$savedFormatted}).")
            ->line("**Featured Offer:** {$this->bestOffer->vehicle_name} ({$this->bestOffer->supplier_name})")
            ->line("**Daily Rate:** {$this->bestOffer->daily_price_formatted}/day • **Includes:** Free cancellation, unlimited mileage")
            ->action('View Deal & Lock In Price', $resultsUrl)
            ->line("Rental prices fluctuate frequently. Rates are subject to availability.")
            ->salutation("Best regards,\nThe Hahacar Team\n\n[Unsubscribe from this alert]({$unsubscribeUrl})");
    }
}
