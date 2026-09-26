<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\PriceAlert;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class CustomerDashboard extends Component
{
    public ?User $user = null;
    public string $activeTab = 'bookings'; // 'bookings', 'profile', 'alerts'

    // Selected Booking Modal
    public ?Booking $selectedBooking = null;
    public bool $isDetailsModalOpen = false;

    // Profile Edit
    public string $profileName = '';
    public string $profilePhone = '';
    public string $currentPassword = '';
    public string $newPassword = '';
    public string $newPassword_confirmation = '';
    public string $profileSuccessMessage = '';

    // Cancellation
    public ?int $cancellingBookingId = null;
    public string $cancellationReason = '';

    public function mount(): void
    {
        if (!Auth::check()) {
            redirect()->route('customer.login');
            return;
        }

        $this->user = Auth::user();
        $this->profileName = $this->user->name;
        $this->profilePhone = $this->user->phone ?? '';
    }

    public function setActiveTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    protected function ensureUser(): ?User
    {
        if (!Auth::check()) {
            redirect()->route('customer.login');
            return null;
        }
        $this->user = Auth::user();
        return $this->user;
    }

    public function viewBooking(int $bookingId): void
    {
        $user = $this->ensureUser();
        if (!$user) return;

        $this->selectedBooking = Booking::with(['vehicle', 'driverProfile.user'])
            ->where(function ($q) use ($user) {
                $q->where('customer_id', $user->id)
                  ->orWhere('customer_email', $user->email);
            })
            ->findOrFail($bookingId);

        $this->isDetailsModalOpen = true;
    }

    public function closeDetailsModal(): void
    {
        $this->isDetailsModalOpen = false;
        $this->selectedBooking = null;
    }

    public function cancelBooking(int $bookingId): void
    {
        $user = $this->ensureUser();
        if (!$user) return;

        $booking = Booking::where(function ($q) use ($user) {
            $q->where('customer_id', $user->id)
              ->orWhere('customer_email', $user->email);
        })
        ->where('status', 'pending')
        ->findOrFail($bookingId);

        $booking->update([
            'status' => 'cancelled',
            'cancellation_reason' => 'Cancelled by customer from portal',
        ]);

        if ($this->selectedBooking && $this->selectedBooking->id === $bookingId) {
            $this->selectedBooking->status = 'cancelled';
        }

        session()->flash('message', 'Booking #' . $booking->booking_reference . ' has been cancelled.');
    }

    public function updateProfile(): void
    {
        $user = $this->ensureUser();
        if (!$user) return;

        $this->validate([
            'profileName' => 'required|string|min:2|max:100',
            'profilePhone' => 'required|string|min:8|max:20',
        ]);

        $user->update([
            'name' => trim($this->profileName),
            'phone' => trim($this->profilePhone),
        ]);

        $this->profileSuccessMessage = 'Profile information updated successfully!';
    }

    public function updatePassword(): void
    {
        $user = $this->ensureUser();
        if (!$user) return;

        $throttleKey = 'customer-password-update:' . $user->id;
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->addError('currentPassword', "Too many attempts. Please try again in {$seconds} seconds.");
            return;
        }

        $this->validate([
            'currentPassword' => 'required',
            'newPassword' => 'required|string|min:6|confirmed',
        ]);

        if (!Hash::check($this->currentPassword, $user->password)) {
            RateLimiter::hit($throttleKey, 300);
            $this->addError('currentPassword', 'The current password provided is incorrect.');
            return;
        }

        RateLimiter::clear($throttleKey);

        $user->update([
            'password' => Hash::make($this->newPassword),
        ]);

        $this->reset(['currentPassword', 'newPassword', 'newPassword_confirmation']);
        $this->profileSuccessMessage = 'Password updated successfully!';
    }

    public function unsubscribeAlert(int $alertId): void
    {
        $user = $this->ensureUser();
        if (!$user) return;

        $alert = PriceAlert::where(function ($q) use ($user) {
            $q->where('email', $user->email)
              ->orWhere('user_id', $user->id);
        })->find($alertId);

        if ($alert) {
            $alert->update(['status' => 'cancelled']);
            session()->flash('alertMessage', 'Price alert subscription paused.');
        }
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('home');
    }

    public function render()
    {
        $bookings = Booking::with(['vehicle', 'driverProfile.user'])
            ->where(function ($q) {
                $q->where('customer_id', $this->user->id)
                  ->orWhere('customer_email', $this->user->email);
            })
            ->latest()
            ->get();

        $alerts = PriceAlert::with(['pickupLocation', 'dropoffLocation'])
            ->where(function ($q) {
                $q->where('email', $this->user->email)
                  ->orWhere('user_id', $this->user->id);
            })
            ->where('status', 'active')
            ->latest()
            ->get();

        $totalSpent = $bookings->where('status', 'completed')->sum('total_price');
        $activeTrips = $bookings->whereIn('status', ['pending', 'confirmed'])->count();
        $completedTrips = $bookings->where('status', 'completed')->count();

        return view('livewire.customer-dashboard', [
            'bookings' => $bookings,
            'alerts' => $alerts,
            'totalSpent' => $totalSpent,
            'activeTrips' => $activeTrips,
            'completedTrips' => $completedTrips,
        ]);
    }
}
