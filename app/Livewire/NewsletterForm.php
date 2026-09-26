<?php

namespace App\Livewire;

use App\Models\Subscriber;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class NewsletterForm extends Component
{
    public string $email = '';
    public bool $subscribed = false;

    protected $rules = [
        'email' => 'required|email|max:255',
    ];

    public function subscribe(): void
    {
        $throttleKey = 'newsletter-subscribe:' . request()->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->addError('email', "Too many subscription attempts. Please wait {$seconds} seconds.");
            return;
        }

        $this->validate();

        RateLimiter::hit($throttleKey, 60);

        Subscriber::updateOrCreate(
            ['email' => strtolower(trim($this->email))],
            [
                'locale' => app()->getLocale(),
                'source' => 'footer',
                'status' => 'active',
                'verified_at' => now(),
            ]
        );

        $this->reset('email');
        $this->subscribed = true;
    }

    public function render()
    {
        return view('livewire.newsletter-form');
    }
}
