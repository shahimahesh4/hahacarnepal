<?php

namespace App\Livewire;

use App\Models\ContactMessage;
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
        'name' => 'required|string|max:100',
        'email' => 'required|email|max:255',
        'subject' => 'required|string|max:200',
        'message' => 'required|string|min:10|max:3000',
        'privacyConsent' => 'accepted',
    ];

    public function submit(): void
    {
        $this->validate();

        ContactMessage::create([
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
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
