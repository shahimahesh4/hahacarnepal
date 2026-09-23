<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\Vehicle;
use Carbon\Carbon;
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
        $this->validate([
            'customerName' => 'required|string|min:2|max:100',
            'customerPhone' => 'required|string|min:8|max:20',
            'customerEmail' => 'required|email|max:100',
            'paymentMethod' => 'required|in:cash,esewa,khalti',
        ]);

        $vehicle = Vehicle::with('driverProfile')->findOrFail($this->selectedVehicleId);
        $totalDays = $this->totalDays;
        $totalPrice = $vehicle->daily_rate * $totalDays;

        $pickupLoc = $this->pickupLocation;
        if (!empty($this->pickupAddress)) {
            $pickupLoc .= ' (' . trim($this->pickupAddress) . ')';
        }

        $dropoffLoc = $this->sameDropoff ? $this->pickupLocation : $this->returnLocation;

        $booking = Booking::create([
            'vehicle_id' => $vehicle->id,
            'driver_profile_id' => $vehicle->driver_profile_id,
            'customer_id' => auth()->check() ? auth()->id() : null,
            'customer_name' => $this->customerName,
            'customer_phone' => $this->customerPhone,
            'customer_email' => $this->customerEmail,
            'service_option' => $this->serviceOption,
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

        $vehicles = $query->orderBy('daily_rate')->get();

        $selectedVehicle = $this->selectedVehicleId ? Vehicle::with('driverProfile.user')->find($this->selectedVehicleId) : null;

        return view('livewire.direct-vehicle-booking', [
            'vehicles' => $vehicles,
            'selectedVehicle' => $selectedVehicle,
            'totalDays' => $this->totalDays,
        ]);
    }
}
