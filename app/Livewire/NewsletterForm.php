<?php

namespace App\Livewire;

use App\Models\Subscriber;
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
        $this->validate();

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
