<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\DriverProfile;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PartnerDashboard extends Component
{
    public ?DriverProfile $profile = null;
    public string $email = '';
    public string $password = '';
    public bool $isAuthenticated = false;

    public function mount(): void
    {
        if (Auth::check() && Auth::user()->isPartner()) {
            $this->profile = Auth::user()->driverProfile()->with(['vehicles', 'bookings.vehicle'])->first();
            $this->isAuthenticated = true;
        }
    }

    public function login(): void
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            $user = Auth::user();
            if ($user->isPartner()) {
                $this->profile = $user->driverProfile()->with(['vehicles', 'bookings.vehicle'])->first();
                $this->isAuthenticated = true;
                return;
            }
            Auth::logout();
            $this->addError('email', 'This account is not registered as a partner driver.');
            return;
        }

        $this->addError('email', 'Invalid credentials provided.');
    }

    public function logout(): void
    {
        Auth::logout();
        $this->profile = null;
        $this->isAuthenticated = false;
    }

    public function confirmBooking(int $bookingId): void
    {
        $booking = Booking::where('driver_profile_id', $this->profile->id)->findOrFail($bookingId);
        $booking->update(['status' => 'confirmed']);
        $this->profile->load('bookings.vehicle');
    }

    public function completeBooking(int $bookingId): void
    {
        $booking = Booking::where('driver_profile_id', $this->profile->id)->findOrFail($bookingId);
        $booking->update(['status' => 'completed']);
        $this->profile->increment('total_bookings');
        $this->profile->load('bookings.vehicle');
    }

    public function toggleVehicleActive(int $vehicleId): void
    {
        $vehicle = Vehicle::where('driver_profile_id', $this->profile->id)->findOrFail($vehicleId);
        $vehicle->update(['is_active' => !$vehicle->is_active]);
        $this->profile->load('vehicles');
    }

    public function render()
    {
        return view('livewire.partner-dashboard');
    }
}
