<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CustomerLogin extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = true;

    public function mount(): void
    {
        if (Auth::check()) {
            if (Auth::user()->isPartner()) {
                redirect()->route('partner.dashboard');
            } else {
                redirect()->route('customer.dashboard');
            }
        }
    }

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();
            $user = Auth::user();

            if ($user->isPartner()) {
                return redirect()->intended(route('partner.dashboard'));
            }

            return redirect()->intended(route('customer.dashboard'));
        }

        $this->addError('email', 'Invalid email or password. Please verify your credentials.');
    }

    public function render()
    {
        return view('livewire.customer-login');
    }
}
