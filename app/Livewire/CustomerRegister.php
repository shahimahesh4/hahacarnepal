<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class CustomerRegister extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $acceptTerms = true;

    public function mount(): void
    {
        if (Auth::check()) {
            redirect()->route('customer.dashboard');
        }
    }

    public function register()
    {
        $this->validate([
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'phone' => 'required|string|min:9|max:20',
            'password' => 'required|string|min:6|confirmed',
            'acceptTerms' => 'accepted',
        ], [
            'acceptTerms.accepted' => 'Please accept the terms and conditions to register.',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => strtolower(trim($this->email)),
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
            'role' => 'user',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        Auth::login($user);

        return redirect()->route('customer.dashboard')->with('success', 'Welcome to Hahakar Nepal! Your customer account has been created.');
    }

    public function render()
    {
        return view('livewire.customer-register');
    }
}
