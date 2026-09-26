<?php

namespace App\Livewire;

use App\Domain\Alerts\Actions\CreatePriceAlertAction;
use App\Domain\Search\Data\SearchCriteria;
use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class PriceAlertModal extends Component
{
    public int $pickupLocationId;
    public int $dropoffLocationId;
    public string $pickupDatetime;
    public string $dropoffDatetime;
    public ?int $currentBestPriceMinor = null;

    public string $email = '';
    public string $thresholdType = 'any_drop';
    public float $thresholdValue = 5.0;
    public string $frequency = 'daily';
    public bool $consent = false;
    public bool $submitted = false;

    protected $rules = [
        'email' => 'required|email|max:255',
        'thresholdType' => 'required|in:any_drop,percentage,fixed_amount',
        'thresholdValue' => 'nullable|numeric|min:1',
        'frequency' => 'required|in:daily,real_time',
        'consent' => 'accepted',
    ];

    public function mount(
        int $pickupLocationId,
        int $dropoffLocationId,
        string $pickupDatetime,
        string $dropoffDatetime,
        ?int $currentBestPriceMinor = null
    ): void {
        $this->pickupLocationId = $pickupLocationId;
        $this->dropoffLocationId = $dropoffLocationId;
        $this->pickupDatetime = $pickupDatetime;
        $this->dropoffDatetime = $dropoffDatetime;
        $this->currentBestPriceMinor = $currentBestPriceMinor;
    }

    public function createAlert(CreatePriceAlertAction $action): void
    {
        $throttleKey = 'price-alert:' . request()->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->addError('email', "Too many alert requests. Please wait {$seconds} seconds.");
            return;
        }

        $this->validate();

        RateLimiter::hit($throttleKey, 120);

        $pickupLoc = Location::findOrFail($this->pickupLocationId);
        $dropoffLoc = Location::findOrFail($this->dropoffLocationId);

        $criteria = new SearchCriteria(
            pickupLocation: $pickupLoc,
            dropoffLocation: $dropoffLoc,
            pickupDatetime: Carbon::parse($this->pickupDatetime),
            dropoffDatetime: Carbon::parse($this->dropoffDatetime)
        );

        $action->execute(
            email: strtolower(trim($this->email)),
            criteria: $criteria,
            thresholdType: $this->thresholdType,
            thresholdValue: (float) $this->thresholdValue,
            frequency: $this->frequency,
            currentBestPriceMinor: $this->currentBestPriceMinor,
            userId: auth()->id()
        );

        $this->submitted = true;
    }

    public function close(): void
    {
        $this->dispatch('closeAlertModal');
    }

    public function render()
    {
        $pickupLoc = Location::find($this->pickupLocationId);
        $dropoffLoc = Location::find($this->dropoffLocationId);

        return view('livewire.price-alert-modal', [
            'pickupLoc' => $pickupLoc,
            'dropoffLoc' => $dropoffLoc,
        ]);
    }
}
