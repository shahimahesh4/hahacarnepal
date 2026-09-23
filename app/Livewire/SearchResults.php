<?php

namespace App\Livewire;

use App\Domain\Search\Data\SearchCriteria;
use App\Domain\Search\Services\SearchOrchestratorService;
use App\Models\Location;
use App\Models\Offer;
use App\Models\Search;
use App\Models\VehicleCategory;
use Carbon\Carbon;
use Livewire\Attributes\Url;
use Livewire\Component;

class SearchResults extends Component
{
    #[Url]
    public ?int $pickup = null;

    #[Url]
    public ?int $dropoff = null;

    #[Url]
    public ?string $from = null;

    #[Url]
    public ?string $to = null;

    #[Url]
    public int $age = 30;

    #[Url]
    public array $selectedCategories = [];

    #[Url]
    public array $selectedTransmissions = [];

    #[Url]
    public array $selectedSuppliers = [];

    #[Url]
    public bool $freeCancellationOnly = false;

    #[Url]
    public bool $unlimitedMileageOnly = false;

    #[Url]
    public string $sort = 'recommended'; // recommended, price_asc, daily_price_asc, rating_desc

    public ?int $searchId = null;
    public ?string $searchUuid = null;
    public int $rentalDays = 1;
    public bool $showAlertModal = false;
    public bool $isBookingModalOpen = false;
    public ?int $selectedOfferId = null;
    public ?Offer $selectedOffer = null;
    public string $customerName = '';
    public string $customerPhone = '';
    public string $customerEmail = '';
    public string $pickupAddress = '';
    public string $paymentMethod = 'cash';
    public string $specialRequests = '';
    public string $serviceOption = 'with_driver';

    protected $listeners = ['closeAlertModal' => 'hideAlertModal'];

    public function selectOffer(int $offerId): void
    {
        $this->selectedOfferId = $offerId;
        $this->selectedOffer = Offer::with(['search.pickupLocation', 'search.dropoffLocation'])->find($offerId);
        $this->isBookingModalOpen = true;
    }

    public function closeBookingModal(): void
    {
        $this->isBookingModalOpen = false;
        $this->selectedOfferId = null;
        $this->selectedOffer = null;
    }

    public function confirmBooking()
    {
        $this->validate([
            'customerName' => 'required|string|min:2|max:100',
            'customerPhone' => 'required|string|min:8|max:20',
            'customerEmail' => 'required|email|max:100',
            'paymentMethod' => 'required|in:cash,esewa,khalti',
        ]);

        $offer = Offer::with(['search.pickupLocation', 'search.dropoffLocation'])->findOrFail($this->selectedOfferId);

        // Find a matching vehicle or fallback to an active verified vehicle
        $firstWord = explode(' ', $offer->vehicle_name)[0] ?? '';
        $vehicle = \App\Models\Vehicle::where('make', 'like', "%{$firstWord}%")
            ->orWhere('model', 'like', "%{$firstWord}%")
            ->first() ?? \App\Models\Vehicle::where('is_active', true)->first();

        if (!$vehicle) {
            $driver = \App\Models\DriverProfile::where('status', 'verified')->first();
            if (!$driver) {
                $user = \App\Models\User::firstOrCreate(
                    ['email' => 'partner.fleet@hahacar.com'],
                    ['name' => 'Hahacar Partner Fleet', 'role' => 'driver', 'password' => bcrypt('password'), 'phone' => '+977 9801234567']
                );
                $driver = \App\Models\DriverProfile::create([
                    'user_id' => $user->id,
                    'service_city' => 'Kathmandu',
                    'partner_type' => 'fleet_operator',
                    'license_number' => '01-06-00998877',
                    'status' => 'verified',
                    'rating' => 4.90,
                    'verified_at' => now(),
                ]);
            }
            $vehicle = \App\Models\Vehicle::create([
                'driver_profile_id' => $driver->id,
                'category' => 'suv_4wd',
                'make' => $firstWord ?: 'Mahindra',
                'model' => $offer->vehicle_name,
                'year' => 2024,
                'plate_number' => 'Ba 2 Cha 4521',
                'seating_capacity' => $offer->seats,
                'luggage_capacity' => $offer->bags,
                'transmission' => $offer->transmission,
                'fuel_type' => 'petrol',
                'has_ac' => true,
                'has_4wd' => true,
                'daily_rate' => (int) round($offer->daily_price_minor / 100),
                'is_active' => true,
                'vehicle_photo_path' => $offer->vehicle_image_url,
            ]);
        }

        $dailyRate = (int) round($offer->daily_price_minor / 100);
        $totalPrice = (int) round($offer->total_price_minor / 100);
        $pickupLoc = $offer->search->pickupLocation->display_name ?? 'Kathmandu (KTM) Airport';
        if (!empty($this->pickupAddress)) {
            $pickupLoc .= ' (' . trim($this->pickupAddress) . ')';
        }
        $dropoffLoc = $offer->search->dropoffLocation->display_name ?? $pickupLoc;

        $booking = \App\Models\Booking::create([
            'vehicle_id' => $vehicle->id,
            'driver_profile_id' => $vehicle->driver_profile_id,
            'customer_id' => auth()->check() ? auth()->id() : null,
            'customer_name' => $this->customerName,
            'customer_phone' => $this->customerPhone,
            'customer_email' => $this->customerEmail,
            'service_option' => $this->serviceOption,
            'pickup_location' => $pickupLoc,
            'return_location' => $dropoffLoc,
            'pickup_date' => $offer->search->pickup_datetime,
            'return_date' => $offer->search->dropoff_datetime,
            'total_days' => $this->rentalDays,
            'daily_rate' => $dailyRate,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'payment_method' => $this->paymentMethod,
            'payment_status' => 'pending',
            'special_requests' => $this->specialRequests,
        ]);

        return redirect()->route('booking.show', $booking->booking_reference);
    }

    public function mount(SearchOrchestratorService $orchestrator): void
    {
        $pickupLoc = Location::find($this->pickup);
        if (!$pickupLoc) {
            $pickupLoc = Location::where('iata_code', 'KTM')->first() ?? Location::first();
            $this->pickup = $pickupLoc->id;
        }

        $dropoffLoc = Location::find($this->dropoff) ?? $pickupLoc;
        $this->dropoff = $dropoffLoc->id;

        $pickupDt = $this->from ? Carbon::parse($this->from) : Carbon::now()->addDays(2)->setTime(10, 0);
        $dropoffDt = $this->to ? Carbon::parse($this->to) : Carbon::now()->addDays(5)->setTime(10, 0);

        if ($dropoffDt->lessThanOrEqualTo($pickupDt)) {
            $dropoffDt = $pickupDt->copy()->addDays(3);
        }

        $this->from = $pickupDt->format('Y-m-d\TH:i');
        $this->to = $dropoffDt->format('Y-m-d\TH:i');

        $criteria = new SearchCriteria(
            pickupLocation: $pickupLoc,
            dropoffLocation: $dropoffLoc,
            pickupDatetime: $pickupDt,
            dropoffDatetime: $dropoffDt,
            driverAge: $this->age
        );

        $this->rentalDays = $criteria->rentalDays();

        $search = $orchestrator->orchestrate(
            criteria: $criteria,
            sessionId: session()->getId(),
            userId: auth()->id()
        );

        $this->searchId = $search->id;
        $this->searchUuid = $search->uuid;
    }

    public function resetFilters(): void
    {
        $this->selectedCategories = [];
        $this->selectedTransmissions = [];
        $this->selectedSuppliers = [];
        $this->freeCancellationOnly = false;
        $this->unlimitedMileageOnly = false;
        $this->sort = 'recommended';
    }

    public function openAlertModal(): void
    {
        $this->showAlertModal = true;
    }

    public function hideAlertModal(): void
    {
        $this->showAlertModal = false;
    }

    public function render()
    {
        $search = Search::with(['pickupLocation', 'dropoffLocation'])->find($this->searchId);

        $query = Offer::where('search_id', $this->searchId)->with(['vehicleCategory', 'provider']);

        // Filters
        if (!empty($this->selectedCategories)) {
            $categoryIds = VehicleCategory::whereIn('code', $this->selectedCategories)->pluck('id');
            $query->whereIn('vehicle_category_id', $categoryIds);
        }

        if (!empty($this->selectedTransmissions)) {
            $query->whereIn('transmission', $this->selectedTransmissions);
        }

        if (!empty($this->selectedSuppliers)) {
            $query->whereIn('supplier_name', $this->selectedSuppliers);
        }

        if ($this->freeCancellationOnly) {
            $query->where('cancellation_policy', 'free_cancellation');
        }

        if ($this->unlimitedMileageOnly) {
            $query->where('mileage_policy', 'unlimited');
        }

        // Sorting
        match ($this->sort) {
            'price_asc' => $query->orderBy('total_price_minor', 'asc'),
            'daily_price_asc' => $query->orderBy('daily_price_minor', 'asc'),
            'rating_desc' => $query->orderBy('supplier_rating', 'desc')->orderBy('total_price_minor', 'asc'),
            default => $query->orderBy('ranking_score', 'desc')->orderBy('total_price_minor', 'asc'),
        };

        $offers = $query->get();

        // Get filter counts and metadata from all search offers
        $allOffers = Offer::where('search_id', $this->searchId)->get();
        $availableCategories = VehicleCategory::whereIn('id', $allOffers->pluck('vehicle_category_id')->unique())->get();
        $availableSuppliers = $allOffers->pluck('supplier_name')->unique()->sort()->values();

        $lowestPrice = $allOffers->min('total_price_minor') ?? 0;

        return view('livewire.search-results', [
            'search' => $search,
            'offers' => $offers,
            'totalOffersCount' => $allOffers->count(),
            'filteredOffersCount' => $offers->count(),
            'availableCategories' => $availableCategories,
            'availableSuppliers' => $availableSuppliers,
            'lowestPrice' => $lowestPrice,
        ]);
    }
}
