<?php

namespace App\Livewire;

use App\Models\DriverProfile;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Hash;
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
    public string $serviceCity = 'Kathmandu';
    public string $partnerType = 'individual_driver';

    // Step 2: Documents
    public string $licenseNumber = '';
    public $licensePhoto = null;
    public $bluebookPhoto = null;

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
                'serviceCity' => 'required|string',
                'partnerType' => 'required|in:individual_driver,vehicle_owner,fleet_operator',
            ]);
            $this->step = 2;
        } elseif ($this->step === 2) {
            $this->validate([
                'licenseNumber' => 'required|string|min:5',
                'licensePhoto' => 'nullable|image|max:5120',
                'bluebookPhoto' => 'nullable|image|max:5120',
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
        $this->validate([
            'vehicleMake' => 'required|string|max:50',
            'vehicleModel' => 'required|string|max:50',
            'plateNumber' => 'required|string|max:30|unique:vehicles,plate_number',
            'dailyRate' => 'required|numeric|min:500',
            'vehiclePhoto' => 'nullable|image|max:5120',
        ]);

        $licensePath = null;
        if ($this->licensePhoto) {
            $licensePath = $this->licensePhoto->store('uploads/licenses', 'public');
        }

        $bluebookPath = null;
        if ($this->bluebookPhoto) {
            $bluebookPath = $this->bluebookPhoto->store('uploads/bluebooks', 'public');
        }

        $vehiclePhotoPath = null;
        if ($this->vehiclePhoto) {
            $vehiclePhotoPath = $this->vehiclePhoto->store('uploads/vehicles', 'public');
        }

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
            'role' => 'driver',
            'status' => 'active',
        ]);

        $profile = DriverProfile::create([
            'user_id' => $user->id,
            'partner_type' => $this->partnerType,
            'status' => 'pending', // Pending Admin Verification
            'service_city' => $this->serviceCity,
            'service_area' => 'Nepal',
            'license_number' => $this->licenseNumber,
            'license_photo_path' => $licensePath,
            'bluebook_photo_path' => $bluebookPath,
            'rating' => 5.00,
            'total_bookings' => 0,
        ]);

        Vehicle::create([
            'driver_profile_id' => $profile->id,
            'category' => $this->vehicleCategory,
            'make' => $this->vehicleMake,
            'model' => $this->vehicleModel,
            'year' => $this->vehicleYear,
            'plate_number' => $this->plateNumber,
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
