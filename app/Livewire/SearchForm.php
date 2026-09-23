<?php

namespace App\Livewire;

use App\Models\Location;
use Carbon\Carbon;
use Livewire\Component;

class SearchForm extends Component
{
    public ?int $pickupLocationId = null;
    public ?int $dropoffLocationId = null;
    public bool $differentDropoff = false;
    public string $pickupDate = '';
    public string $pickupTime = '10:00';
    public string $dropoffDate = '';
    public string $dropoffTime = '10:00';
    public int $driverAge = 30;

    public string $pickupQuery = '';
    public string $dropoffQuery = '';
    public bool $showPickupDropdown = false;
    public bool $showDropoffDropdown = false;

    public function mount(
        ?int $pickup = null,
        ?int $dropoff = null,
        ?string $from = null,
        ?string $to = null,
        ?int $age = 30
    ): void {
        // Default to KTM (Kathmandu) or first location if none provided
        $defaultLoc = Location::where('iata_code', 'KTM')->first() ?? Location::first();

        if ($pickup) {
            $this->pickupLocationId = $pickup;
            $loc = Location::find($pickup);
            if ($loc) {
                $this->pickupQuery = $loc->display_name;
            }
        } elseif ($defaultLoc) {
            $this->pickupLocationId = $defaultLoc->id;
            $this->pickupQuery = $defaultLoc->display_name;
        }

        if ($dropoff && $dropoff !== $this->pickupLocationId) {
            $this->differentDropoff = true;
            $this->dropoffLocationId = $dropoff;
            $dropLoc = Location::find($dropoff);
            if ($dropLoc) {
                $this->dropoffQuery = $dropLoc->display_name;
            }
        } else {
            $this->dropoffLocationId = $this->pickupLocationId;
            $this->dropoffQuery = $this->pickupQuery;
        }

        $now = Carbon::now();
        $this->pickupDate = $from ? Carbon::parse($from)->format('Y-m-d') : $now->copy()->addDays(2)->format('Y-m-d');
        $this->pickupTime = $from ? Carbon::parse($from)->format('H:i') : '10:00';
        $this->dropoffDate = $to ? Carbon::parse($to)->format('Y-m-d') : $now->copy()->addDays(5)->format('Y-m-d');
        $this->dropoffTime = $to ? Carbon::parse($to)->format('H:i') : '10:00';
        $this->driverAge = $age ?? 30;
    }

    public function selectPickup(int $id, string $name): void
    {
        $this->pickupLocationId = $id;
        $this->pickupQuery = $name;
        $this->showPickupDropdown = false;

        if (!$this->differentDropoff) {
            $this->dropoffLocationId = $id;
            $this->dropoffQuery = $name;
        }
    }

    public function selectDropoff(int $id, string $name): void
    {
        $this->dropoffLocationId = $id;
        $this->dropoffQuery = $name;
        $this->showDropoffDropdown = false;
    }

    public function toggleDifferentDropoff(): void
    {
        $this->differentDropoff = !$this->differentDropoff;
        if (!$this->differentDropoff) {
            $this->dropoffLocationId = $this->pickupLocationId;
            $this->dropoffQuery = $this->pickupQuery;
        }
    }

    public function search()
    {
        $this->validate([
            'pickupLocationId' => 'required|exists:locations,id',
            'dropoffLocationId' => 'required|exists:locations,id',
            'pickupDate' => 'required|date|after_or_equal:today',
            'pickupTime' => 'required',
            'dropoffDate' => 'required|date|after_or_equal:pickupDate',
            'dropoffTime' => 'required',
            'driverAge' => 'required|integer|min:18|max:99',
        ]);

        $pickupDt = Carbon::parse("{$this->pickupDate} {$this->pickupTime}");
        $dropoffDt = Carbon::parse("{$this->dropoffDate} {$this->dropoffTime}");

        if ($dropoffDt->lessThanOrEqualTo($pickupDt)) {
            $this->addError('dropoffDate', 'Drop-off date and time must be after pick-up date and time.');
            return;
        }

        return redirect()->route('search.index', [
            'pickup' => $this->pickupLocationId,
            'dropoff' => $this->differentDropoff ? $this->dropoffLocationId : $this->pickupLocationId,
            'from' => $pickupDt->format('Y-m-d\TH:i'),
            'to' => $dropoffDt->format('Y-m-d\TH:i'),
            'age' => $this->driverAge,
        ]);
    }

    public function render()
    {
        $pickupLocations = [];
        if (strlen($this->pickupQuery) >= 1) {
            $pickupLocations = Location::where('is_active', true)
                ->where(function ($q) {
                    $q->where('name', 'like', "%{$this->pickupQuery}%")
                      ->orWhere('city', 'like', "%{$this->pickupQuery}%")
                      ->orWhere('iata_code', 'like', "%{$this->pickupQuery}%");
                })
                ->limit(6)
                ->get();
        }

        $dropoffLocations = [];
        if (strlen($this->dropoffQuery) >= 1 && $this->differentDropoff) {
            $dropoffLocations = Location::where('is_active', true)
                ->where(function ($q) {
                    $q->where('name', 'like', "%{$this->dropoffQuery}%")
                      ->orWhere('city', 'like', "%{$this->dropoffQuery}%")
                      ->orWhere('iata_code', 'like', "%{$this->dropoffQuery}%");
                })
                ->limit(6)
                ->get();
        }

        return view('livewire.search-form', [
            'pickupLocations' => $pickupLocations,
            'dropoffLocations' => $dropoffLocations,
        ]);
    }
}
