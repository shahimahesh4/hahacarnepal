<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class DirectVehicleBooking extends Component
{
    public string $pickupLocation = 'Tribhuvan International Airport (KTM)';
    public string $returnLocation = 'Tribhuvan International Airport (KTM)';
    public bool $sameDropoff = true;
    public string $serviceOption = 'with_driver'; // 'with_driver', 'self_drive'
    public string $pickupDate = '';
    public string $pickupTime = '10:00';
    public string $returnDate = '';
    public string $returnTime = '18:00';
    public string $selectedCategory = 'all';
    public bool $filter4wd = false;
    public string $filterTransmission = 'all';

    public string $pricingType = 'daily'; // 'daily', 'distance'
    public int $estimatedDistanceKm = 100;
    public bool $hasSearched = false;
    public string $searchMessage = '';

    // Booking Modal
    public ?int $selectedVehicleId = null;
    public bool $isBookingModalOpen = false;
    public string $customerName = '';
    public string $customerPhone = '';
    public string $customerEmail = '';
    public string $pickupAddress = '';
    public string $specialRequests = '';
    public string $paymentMethod = 'cash';

    public array $popularLocations = [
        'Tribhuvan International Airport (KTM)',
        'Thamel Tourist Hub, Kathmandu',
        'Kalanki Bus Terminal, Kathmandu',
        'Lalitpur Patan Durbar Area',
        'Pokhara International Airport (PKR)',
        'Lakeside, Pokhara',
        'Bharatpur Airport (BHR), Chitwan',
        'Sauraha Tourist Center, Chitwan',
        'Gautam Buddha International Airport (BWA), Lumbini',
        'Biratnagar Airport (BIR)',
        'Nepalgunj Airport (KEP)',
    ];

    public function mount(): void
    {
        $this->pickupDate = Carbon::now()->addDay()->format('Y-m-d');
        $this->returnDate = Carbon::now()->addDays(4)->format('Y-m-d');
        $this->recalculateDistance();
    }

    public function updatedPickupLocation(): void
    {
        $this->recalculateDistance();
    }

    public function updatedReturnLocation(): void
    {
        $this->recalculateDistance();
    }

    public function updatedSameDropoff(): void
    {
        $this->recalculateDistance();
    }

    public function setPricingType(string $type): void
    {
        $this->pricingType = $type;
    }

    public function setDistance(int $km): void
    {
        $this->estimatedDistanceKm = max(10, $km);
    }

    public function incrementDistance(int $amount = 25): void
    {
        $this->estimatedDistanceKm = min(2000, $this->estimatedDistanceKm + $amount);
    }

    public function decrementDistance(int $amount = 25): void
    {
        $this->estimatedDistanceKm = max(10, $this->estimatedDistanceKm - $amount);
    }

    public function searchFleet(): void
    {
        $this->recalculateDistance();
        $this->hasSearched = true;
        $mode = $this->serviceOption === 'with_driver' ? 'With-Driver' : 'Self-Drive';
        $duration = $this->pricingType === 'daily' ? "{$this->totalDays} Days" : "{$this->estimatedDistanceKm} KM";
        $this->searchMessage = "Showing verified {$mode} fleet for {$this->pickupLocation} ({$duration})";
        $this->dispatch('scroll-to-fleet');
    }

    protected function recalculateDistance(): void
    {
        $dropoff = $this->sameDropoff ? $this->pickupLocation : $this->returnLocation;
        $this->estimatedDistanceKm = \App\Domain\Pricing\Services\NepalDistanceService::estimateDistanceKm(
            $this->pickupLocation,
            $dropoff
        );
    }

    public function getTotalDaysProperty(): int
    {
        try {
            $start = Carbon::parse($this->pickupDate);
            $end = Carbon::parse($this->returnDate);
            $days = $start->diffInDays($end);
            return max(1, (int) $days);
        } catch (\Exception $e) {
            return 1;
        }
    }

    public function selectVehicle(int $vehicleId): void
    {
        $this->selectedVehicleId = $vehicleId;
        $this->isBookingModalOpen = true;
    }

    public function closeModal(): void
    {
        $this->isBookingModalOpen = false;
    }

    public function confirmBooking()
    {
        $throttleKey = 'direct-booking:' . request()->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->addError('customerEmail', "Too many booking submissions. Please wait {$seconds} seconds.");
            return;
        }

        $this->validate([
            'customerName' => 'required|string|min:2|max:100',
            'customerPhone' => 'required|string|min:8|max:20',
            'customerEmail' => 'required|email|max:100',
            'paymentMethod' => 'required|in:cash,esewa,khalti',
        ]);

        RateLimiter::hit($throttleKey, 120);

        $vehicle = Vehicle::with('driverProfile')->findOrFail($this->selectedVehicleId);
        $totalDays = $this->totalDays;
        
        $ratePerKm = $vehicle->effective_rate_per_km;
        $totalPrice = \App\Domain\Pricing\Services\NepalDistanceService::calculateTripPrice(
            $this->pricingType,
            $vehicle->daily_rate,
            $totalDays,
            $ratePerKm,
            $this->estimatedDistanceKm
        );

        $pickupLoc = $this->pickupLocation;
        if (!empty($this->pickupAddress)) {
            $pickupLoc .= ' (' . trim($this->pickupAddress) . ')';
        }

        $dropoffLoc = $this->sameDropoff ? $this->pickupLocation : $this->returnLocation;

        $booking = Booking::create([
            'vehicle_id' => $vehicle->id,
            'driver_profile_id' => $vehicle->driver_profile_id,
            'customer_id' => auth()->check() ? auth()->id() : null,
            'customer_name' => trim($this->customerName),
            'customer_phone' => trim($this->customerPhone),
            'customer_email' => strtolower(trim($this->customerEmail)),
            'service_option' => $this->serviceOption,
            'pricing_type' => $this->pricingType,
            'estimated_distance_km' => $this->pricingType === 'distance' ? $this->estimatedDistanceKm : null,
            'rate_per_km' => $ratePerKm,
            'fuel_type' => $vehicle->fuel_type,
            'pickup_location' => $pickupLoc,
            'return_location' => $dropoffLoc,
            'pickup_date' => Carbon::parse("{$this->pickupDate} {$this->pickupTime}"),
            'return_date' => Carbon::parse("{$this->returnDate} {$this->returnTime}"),
            'total_days' => $totalDays,
            'daily_rate' => $vehicle->daily_rate,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'payment_method' => $this->paymentMethod,
            'payment_status' => 'pending',
            'special_requests' => $this->specialRequests,
        ]);

        return redirect()->route('booking.show', $booking->booking_reference);
    }

    public function render()
    {
        $query = Vehicle::query()
            ->with(['driverProfile.user'])
            ->where('is_active', true)
            ->whereHas('driverProfile', function ($q) {
                $q->where('status', 'verified');
            });

        if ($this->serviceOption === 'with_driver') {
            $query->where('provides_driver', true);
        } else {
            $query->where('allows_self_drive', true);
        }

        if ($this->selectedCategory !== 'all') {
            $query->where('category', $this->selectedCategory);
        }

        if ($this->filter4wd) {
            $query->where('has_4wd', true);
        }

        if ($this->filterTransmission !== 'all') {
            $query->where('transmission', $this->filterTransmission);
        }

        $selectedCity = \App\Domain\Pricing\Services\NepalDistanceService::extractCity($this->pickupLocation);

        $vehicles = $query->get()->sortBy(function ($vehicle) use ($selectedCity) {
            $vehCity = strtolower($vehicle->driverProfile->service_city ?? '');
            $isExactMatch = str_contains($vehCity, $selectedCity) || str_contains($selectedCity, $vehCity);
            return $isExactMatch ? 0 : 1;
        })->values();

        $selectedVehicle = $this->selectedVehicleId ? Vehicle::with('driverProfile.user')->find($this->selectedVehicleId) : null;

        return view('livewire.direct-vehicle-booking', [
            'vehicles' => $vehicles,
            'selectedVehicle' => $selectedVehicle,
            'totalDays' => $this->totalDays,
            'currentCity' => ucfirst($selectedCity),
            'locationMode' => \App\Models\Setting::get('location_provider_mode', 'manual'),
            'googleMapsApiKey' => \App\Models\Setting::get('google_maps_api_key', ''),
            'googleMapsCountry' => \App\Models\Setting::get('google_maps_default_country', 'np'),
            'siteName' => \App\Models\Setting::get('site_name', 'Hahakar Nepal'),
            'currency' => \App\Models\Setting::get('default_currency', 'NPR'),
            'enableCash' => (bool) \App\Models\Setting::get('enable_cash_on_pickup', true),
            'enableEsewa' => (bool) \App\Models\Setting::get('enable_esewa', true),
            'enableKhalti' => (bool) \App\Models\Setting::get('enable_khalti', true),
            'ratePetrol' => \App\Domain\Pricing\Services\NepalDistanceService::getRatePerKmForFuelType('petrol'),
            'rateDiesel' => \App\Domain\Pricing\Services\NepalDistanceService::getRatePerKmForFuelType('diesel'),
            'rateElectric' => \App\Domain\Pricing\Services\NepalDistanceService::getRatePerKmForFuelType('electric'),
            'rateHybrid' => \App\Domain\Pricing\Services\NepalDistanceService::getRatePerKmForFuelType('hybrid'),
        ]);
    }
}
