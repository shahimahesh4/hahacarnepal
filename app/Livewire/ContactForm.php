<?php

namespace App\Livewire;

use App\Models\ContactMessage;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class ContactForm extends Component
{
    public string $name = '';
    public string $email = '';
    public string $subject = '';
    public string $message = '';
    public bool $privacyConsent = false;
    public bool $submitted = false;

    protected $rules = [
        'name' => 'required|string|min:2|max:100',
        'email' => 'required|email|max:255',
        'subject' => 'required|string|min:3|max:200',
        'message' => 'required|string|min:10|max:3000',
        'privacyConsent' => 'accepted',
    ];

    public function submit(): void
    {
        $throttleKey = 'contact-submit:' . request()->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->addError('email', "You are submitting messages too quickly. Please wait {$seconds} seconds.");
            return;
        }

        $this->validate();

        RateLimiter::hit($throttleKey, 120);

        ContactMessage::create([
            'name' => trim($this->name),
            'email' => strtolower(trim($this->email)),
            'subject' => trim($this->subject),
            'message' => trim($this->message),
            'status' => 'new',
            'priority' => 'normal',
        ]);

        $this->reset(['name', 'email', 'subject', 'message', 'privacyConsent']);
        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
