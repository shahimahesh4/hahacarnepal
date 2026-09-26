<?php

namespace App\Livewire;

use App\Models\DriverProfile;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;
use Livewire\WithFileUploads;

class PartnerRegistration extends Component
{
    use WithFileUploads;

    public int $step = 1;
    public bool $isSubmitted = false;

    // Step 1: Personal Info
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $password = '';
    public string $province = 'Bagmati Province';
    public string $serviceCity = 'Kathmandu';
    public string $address = '';
    public string $partnerType = 'individual_driver';

    // Step 2: Documents
    public string $licenseNumber = '';
    public $licensePhoto = null;
    public $bluebookPhoto = null;
    public $citizenshipPhoto = null;
    public $passportPhoto = null;

    // Step 3: Vehicle Info
    public string $vehicleCategory = 'suv_4wd';
    public string $vehicleMake = 'Mahindra';
    public string $vehicleModel = 'Scorpio 4WD';
    public int $vehicleYear = 2023;
    public string $plateNumber = '';
    public int $seatingCapacity = 7;
    public int $luggageCapacity = 4;
    public string $transmission = 'manual';
    public string $fuelType = 'diesel';
    public bool $has4wd = true;
    public bool $hasAc = true;
    public int $dailyRate = 4500;
    public bool $providesDriver = true;
    public bool $allowsSelfDrive = true;
    public $vehiclePhoto = null;

    public function nextStep(): void
    {
        if ($this->step === 1) {
            $this->validate([
                'name' => 'required|string|min:2|max:100',
                'email' => 'required|email|max:100|unique:users,email',
                'phone' => 'required|string|min:8|max:20',
                'password' => 'required|string|min:6',
                'province' => 'required|string|max:100',
                'serviceCity' => 'required|string|max:100',
                'address' => 'nullable|string|max:255',
                'partnerType' => 'required|in:individual_driver,vehicle_owner,fleet_operator',
            ]);
            $this->step = 2;
        } elseif ($this->step === 2) {
            $this->validate([
                'licenseNumber' => 'required|string|min:4|max:50',
                'licensePhoto' => 'nullable|file|mimes:jpeg,png,webp,jpg,pdf|max:5120',
                'bluebookPhoto' => 'nullable|file|mimes:jpeg,png,webp,jpg,pdf|max:5120',
                'citizenshipPhoto' => 'nullable|file|mimes:jpeg,png,webp,jpg,pdf|max:5120',
                'passportPhoto' => 'nullable|file|mimes:jpeg,png,webp,jpg,pdf|max:5120',
            ]);
            $this->step = 3;
        }
    }

    public function previousStep(): void
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function submitApplication(): void
    {
        $throttleKey = 'partner-register:' . request()->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->addError('plateNumber', "Too many registration attempts. Please wait {$seconds} seconds.");
            return;
        }

        $this->validate([
            // Step 1 re-validation
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'phone' => 'required|string|min:8|max:20',
            'password' => 'required|string|min:6',
            'province' => 'required|string|max:100',
            'serviceCity' => 'required|string|max:100',
            'partnerType' => 'required|in:individual_driver,vehicle_owner,fleet_operator',
            // Step 2 re-validation
            'licenseNumber' => 'required|string|min:4|max:50',
            'licensePhoto' => 'nullable|file|mimes:jpeg,png,webp,jpg,pdf|max:5120',
            'bluebookPhoto' => 'nullable|file|mimes:jpeg,png,webp,jpg,pdf|max:5120',
            'citizenshipPhoto' => 'nullable|file|mimes:jpeg,png,webp,jpg,pdf|max:5120',
            'passportPhoto' => 'nullable|file|mimes:jpeg,png,webp,jpg,pdf|max:5120',
            // Step 3 validation
            'vehicleMake' => 'required|string|max:50',
            'vehicleModel' => 'required|string|max:50',
            'vehicleYear' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'plateNumber' => 'required|string|max:30|unique:vehicles,plate_number',
            'dailyRate' => 'required|numeric|min:500',
            'vehiclePhoto' => 'nullable|file|mimes:jpeg,png,webp,jpg|max:5120',
        ]);

        RateLimiter::hit($throttleKey, 600);

        $licensePath = null;
        if ($this->licensePhoto) {
            $licensePath = $this->licensePhoto->store('uploads/licenses', 'public');
        }

        $bluebookPath = null;
        if ($this->bluebookPhoto) {
            $bluebookPath = $this->bluebookPhoto->store('uploads/bluebooks', 'public');
        }

        $citizenshipPath = null;
        if ($this->citizenshipPhoto) {
            $citizenshipPath = $this->citizenshipPhoto->store('uploads/citizenships', 'public');
        }

        $passportPath = null;
        if ($this->passportPhoto) {
            $passportPath = $this->passportPhoto->store('uploads/passports', 'public');
        }

        $vehiclePhotoPath = null;
        if ($this->vehiclePhoto) {
            $vehiclePhotoPath = $this->vehiclePhoto->store('uploads/vehicles', 'public');
        }

        $user = User::create([
            'name' => trim($this->name),
            'email' => strtolower(trim($this->email)),
            'phone' => trim($this->phone),
            'password' => Hash::make($this->password),
            'role' => 'driver',
            'status' => 'active',
        ]);

        $profile = DriverProfile::create([
            'user_id' => $user->id,
            'partner_type' => $this->partnerType,
            'status' => 'pending', // Pending Admin Verification
            'province' => $this->province,
            'service_city' => $this->serviceCity,
            'current_address' => $this->address ? trim($this->address) : null,
            'service_area' => 'Nepal',
            'license_number' => trim($this->licenseNumber),
            'license_photo_path' => $licensePath,
            'bluebook_photo_path' => $bluebookPath,
            'citizenship_photo_path' => $citizenshipPath,
            'passport_photo_path' => $passportPath,
            'rating' => 5.00,
            'total_bookings' => 0,
        ]);

        Vehicle::create([
            'driver_profile_id' => $profile->id,
            'category' => $this->vehicleCategory,
            'make' => trim($this->vehicleMake),
            'model' => trim($this->vehicleModel),
            'year' => $this->vehicleYear,
            'plate_number' => trim($this->plateNumber),
            'seating_capacity' => $this->seatingCapacity,
            'luggage_capacity' => $this->luggageCapacity,
            'transmission' => $this->transmission,
            'fuel_type' => $this->fuelType,
            'has_ac' => $this->hasAc,
            'has_4wd' => $this->has4wd,
            'daily_rate' => $this->dailyRate,
            'provides_driver' => $this->providesDriver,
            'allows_self_drive' => $this->allowsSelfDrive,
            'vehicle_photo_path' => $vehiclePhotoPath,
            'is_active' => true,
        ]);

        $this->isSubmitted = true;
    }

    public function render()
    {
        return view('livewire.partner-registration');
    }
}
