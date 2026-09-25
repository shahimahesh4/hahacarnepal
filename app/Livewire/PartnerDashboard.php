<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\DriverProfile;
use App\Models\Setting;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PartnerDashboard extends Component
{
    public ?DriverProfile $profile = null;
    public string $email = '';
    public string $password = '';
    public bool $isAuthenticated = false;

    // Active Navigation Tab
    public string $activeTab = 'trips'; // 'trips', 'earnings', 'profile'

    // Add Vehicle Modal Form
    public bool $isAddVehicleModalOpen = false;
    public string $vehMake = 'Mahindra';
    public string $vehModel = 'Scorpio 4WD';
    public int $vehYear = 2023;
    public string $vehCategory = 'suv_4wd';
    public string $vehFuelType = 'diesel';
    public string $vehTransmission = 'manual';
    public int $vehSeats = 7;
    public string $vehPlateNumber = '';
    public int $vehDailyRate = 4500;
    public bool $vehHas4wd = true;
    public bool $vehProvidesDriver = true;
    public bool $vehAllowsSelfDrive = true;
    public string $vehicleSuccessMessage = '';

    // Partner Profile Edit
    public string $partnerName = '';
    public string $partnerPhone = '';
    public string $partnerCity = '';
    public string $profileSuccessMessage = '';

    public function mount(): void
    {
        if (Auth::check() && Auth::user()->isPartner()) {
            $this->loadPartnerProfile();
        }
    }

    public function setActiveTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    protected function loadPartnerProfile(): void
    {
        $this->profile = Auth::user()->driverProfile()->with(['vehicles', 'bookings.vehicle'])->first();
        if ($this->profile) {
            $this->isAuthenticated = true;
            $this->partnerName = Auth::user()->name;
            $this->partnerPhone = Auth::user()->phone ?? '';
            $this->partnerCity = $this->profile->service_city ?? 'Kathmandu';
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
                $this->loadPartnerProfile();
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

    public function openAddVehicleModal(): void
    {
        $this->isAddVehicleModalOpen = true;
    }

    public function closeAddVehicleModal(): void
    {
        $this->isAddVehicleModalOpen = false;
    }

    public function saveVehicle(): void
    {
        $this->validate([
            'vehMake' => 'required|string|max:50',
            'vehModel' => 'required|string|max:50',
            'vehYear' => 'required|integer|min:2010|max:' . (date('Y') + 1),
            'vehCategory' => 'required|string',
            'vehFuelType' => 'required|in:petrol,diesel,electric,hybrid',
            'vehPlateNumber' => 'required|string|max:30',
            'vehDailyRate' => 'required|integer|min:1000',
        ]);

        // Auto map representative photo
        $photoMap = [
            'scorpio' => 'images/vehicles/scorpio.jpg',
            'hilux' => 'images/vehicles/hilux.jpg',
            'hiace' => 'images/vehicles/hiace.jpg',
            'swift' => 'images/vehicles/swift.jpg',
            'creta' => 'images/vehicles/creta.jpg',
            'byd' => 'images/vehicles/byd_atto3.jpg',
            'dzire' => 'images/vehicles/dzire.jpg',
            'bolero' => 'images/vehicles/bolero.jpg',
            'prado' => 'images/vehicles/prado.jpg',
            'traveller' => 'images/vehicles/force_traveller.jpg',
        ];

        $modelLower = strtolower($this->vehModel . ' ' . $this->vehMake);
        $photo = 'images/vehicles/scorpio.jpg';
        foreach ($photoMap as $key => $path) {
            if (str_contains($modelLower, $key)) {
                $photo = $path;
                break;
            }
        }

        Vehicle::create([
            'driver_profile_id' => $this->profile->id,
            'category' => $this->vehCategory,
            'fuel_type' => $this->vehFuelType,
            'transmission' => $this->vehTransmission,
            'make' => $this->vehMake,
            'model' => $this->vehModel,
            'year' => $this->vehYear,
            'seats' => $this->vehSeats,
            'plate_number' => $this->vehPlateNumber,
            'daily_rate' => $this->vehDailyRate,
            'has_4wd' => $this->vehHas4wd,
            'has_ac' => true,
            'provides_driver' => $this->vehProvidesDriver,
            'allows_self_drive' => $this->vehAllowsSelfDrive,
            'vehicle_photo_path' => $photo,
            'is_active' => true,
        ]);

        $this->profile->load('vehicles');
        $this->isAddVehicleModalOpen = false;
        $this->vehicleSuccessMessage = 'New vehicle successfully registered to your fleet!';
    }

    public function confirmBooking(int $bookingId): void
    {
        $booking = Booking::where('driver_profile_id', $this->profile->id)->findOrFail($bookingId);
        $booking->update(['status' => 'confirmed']);
        $this->profile->load('bookings.vehicle');
        session()->flash('bookingMessage', 'Reservation #' . $booking->booking_reference . ' accepted & confirmed!');
    }

    public function declineBooking(int $bookingId): void
    {
        $booking = Booking::where('driver_profile_id', $this->profile->id)->findOrFail($bookingId);
        $booking->update([
            'status' => 'cancelled',
            'cancellation_reason' => 'Declined by partner driver',
        ]);
        $this->profile->load('bookings.vehicle');
        session()->flash('bookingMessage', 'Reservation #' . $booking->booking_reference . ' declined.');
    }

    public function completeBooking(int $bookingId): void
    {
        $booking = Booking::where('driver_profile_id', $this->profile->id)->findOrFail($bookingId);
        $booking->update([
            'status' => 'completed',
            'payment_status' => 'paid',
        ]);
        $this->profile->increment('total_bookings');
        $this->profile->load('bookings.vehicle');
        session()->flash('bookingMessage', 'Trip #' . $booking->booking_reference . ' marked as completed!');
    }

    public function toggleVehicleActive(int $vehicleId): void
    {
        $vehicle = Vehicle::where('driver_profile_id', $this->profile->id)->findOrFail($vehicleId);
        $vehicle->update(['is_active' => !$vehicle->is_active]);
        $this->profile->load('vehicles');
    }

    public function updatePartnerProfile(): void
    {
        $this->validate([
            'partnerName' => 'required|string|min:2|max:100',
            'partnerPhone' => 'required|string|min:8|max:20',
            'partnerCity' => 'required|string|min:2|max:50',
        ]);

        Auth::user()->update([
            'name' => $this->partnerName,
            'phone' => $this->partnerPhone,
        ]);

        $this->profile->update([
            'service_city' => $this->partnerCity,
        ]);

        $this->profileSuccessMessage = 'Partner profile details updated successfully!';
    }

    public function render()
    {
        $driverPct = (float) Setting::get('driver_payout_percentage', 85);
        $adminPct = (float) Setting::get('admin_commission_percentage', 15);

        $totalGrossEarnings = 0;
        $driverNetEarnings = 0;
        $adminCommissionTotal = 0;
        $pendingBookingsCount = 0;
        $activeVehiclesCount = 0;
        $completedTripsCount = 0;

        $bookingsWithSplit = collect();

        if ($this->profile) {
            $bookings = $this->profile->bookings()->with('vehicle')->latest()->get();
            $completedBookings = $bookings->where('status', 'completed');

            $totalGrossEarnings = $completedBookings->sum('total_price');
            $driverNetEarnings = round($totalGrossEarnings * ($driverPct / 100));
            $adminCommissionTotal = round($totalGrossEarnings * ($adminPct / 100));

            $pendingBookingsCount = $bookings->where('status', 'pending')->count();
            $completedTripsCount = $completedBookings->count();
            $activeVehiclesCount = $this->profile->vehicles()->where('is_active', true)->count();

            $bookingsWithSplit = $bookings->map(function ($b) use ($driverPct, $adminPct) {
                $b->driver_amount = round($b->total_price * ($driverPct / 100));
                $b->admin_amount = round($b->total_price * ($adminPct / 100));
                return $b;
            });
        }

        return view('livewire.partner-dashboard', [
            'driverPct' => $driverPct,
            'adminPct' => $adminPct,
            'totalGrossEarnings' => $totalGrossEarnings,
            'driverNetEarnings' => $driverNetEarnings,
            'adminCommissionTotal' => $adminCommissionTotal,
            'pendingBookingsCount' => $pendingBookingsCount,
            'activeVehiclesCount' => $activeVehiclesCount,
            'completedTripsCount' => $completedTripsCount,
            'bookingsWithSplit' => $bookingsWithSplit,
        ]);
    }
}
