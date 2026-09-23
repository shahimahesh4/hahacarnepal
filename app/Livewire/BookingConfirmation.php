<?php

namespace App\Livewire;

use App\Models\Booking;
use Livewire\Component;

class BookingConfirmation extends Component
{
    public string $reference;
    public ?Booking $booking = null;

    public function mount(string $reference): void
    {
        $this->reference = $reference;
        $this->booking = Booking::with(['vehicle.driverProfile.user', 'driverProfile.user'])
            ->where('booking_reference', $reference)
            ->firstOrFail();
    }

    public function cancelBooking(): void
    {
        if ($this->booking && $this->booking->status === 'pending') {
            $this->booking->update([
                'status' => 'cancelled',
                'cancellation_reason' => 'Cancelled by customer',
            ]);
            $this->booking->refresh();
        }
    }

    public function render()
    {
        return view('livewire.booking-confirmation');
    }
}
