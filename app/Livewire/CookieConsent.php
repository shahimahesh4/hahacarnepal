<?php

namespace App\Livewire;

use Livewire\Component;

class CookieConsent extends Component
{
    public bool $visible = true;
    public bool $showCustomize = false;
    public bool $analytics = true;
    public bool $marketing = true;

    public function mount(): void
    {
        if (request()->cookie('hahakar_cookie_consent')) {
            $this->visible = false;
        }
    }

    public function acceptAll(): void
    {
        $this->savePreferences(true, true);
    }

    public function rejectOptional(): void
    {
        $this->savePreferences(false, false);
    }

    public function saveCustom(): void
    {
        $this->savePreferences($this->analytics, $this->marketing);
    }

    protected function savePreferences(bool $analytics, bool $marketing): void
    {
        $payload = json_encode([
            'necessary' => true,
            'analytics' => $analytics,
            'marketing' => $marketing,
            'timestamp' => now()->toIso8601String(),
        ]);

        cookie()->queue(cookie('hahakar_cookie_consent', $payload, 60 * 24 * 365));
        $this->visible = false;
    }

    public function render()
    {
        return view('livewire.cookie-consent');
    }
}
