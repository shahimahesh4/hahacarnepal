<?php

namespace App\Livewire;

use App\Models\User;
use App\Services\OtpService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class CustomerRegister extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $acceptTerms = true;

    // OTP Verification State
    public bool $showOtpStep = false;
    public string $otpCode = '';
    public string $otpIdentifier = '';
    public string $otpType = 'email';
    public string $otpStatusMessage = '';
    public array $pendingUserData = [];

    public function mount(): void
    {
        if (Auth::check()) {
            redirect()->route('customer.dashboard');
        }
    }

    public function register()
    {
        $throttleKey = 'customer-register:' . request()->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->addError('email', "Too many registration attempts. Please wait {$seconds} seconds.");
            return;
        }

        $this->validate([
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'phone' => 'required|string|min:9|max:20',
            'password' => 'required|string|min:6|confirmed',
            'acceptTerms' => 'accepted',
        ], [
            'acceptTerms.accepted' => 'Please accept the terms and conditions to register.',
        ]);

        RateLimiter::hit($throttleKey, 300);

        $cleanEmail = strtolower(trim($this->email));
        $cleanPhone = trim($this->phone);
        $cleanName = trim($this->name);

        // Check if OTP verification is enabled in backend admin settings
        if (OtpService::isOtpRequired('register')) {
            $this->pendingUserData = [
                'name' => $cleanName,
                'email' => $cleanEmail,
                'phone' => $cleanPhone,
                'password' => Hash::make($this->password),
                'role' => 'user',
                'status' => 'active',
            ];

            // Determine channel (Email preferred if enabled, else Phone)
            $this->otpType = OtpService::isEmailOtpEnabled() ? 'email' : 'phone';
            $this->otpIdentifier = $this->otpType === 'email' ? $cleanEmail : $cleanPhone;

            // Generate and send OTP
            OtpService::generateAndSendOtp(
                identifier: $this->otpIdentifier,
                type: $this->otpType,
                action: 'register',
                userId: null,
                recipientName: $cleanName,
                meta: ['name' => $cleanName, 'phone' => $cleanPhone]
            );

            // Also send SMS if both channels are enabled
            if (OtpService::isEmailOtpEnabled() && OtpService::isPhoneOtpEnabled()) {
                OtpService::generateAndSendOtp(
                    identifier: $cleanPhone,
                    type: 'phone',
                    action: 'register',
                    userId: null,
                    recipientName: $cleanName
                );
            }

            $this->showOtpStep = true;
            $channelDesc = $this->otpType === 'email' ? "email address ({$cleanEmail})" : "phone number ({$cleanPhone})";
            $this->otpStatusMessage = "A 6-digit verification code has been dispatched to your {$channelDesc}.";
            return;
        }

        // Standard direct registration when OTP is disabled (default)
        $user = User::create([
            'name' => $cleanName,
            'email' => $cleanEmail,
            'phone' => $cleanPhone,
            'password' => Hash::make($this->password),
            'role' => 'user',
            'status' => 'active',
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
        ]);

        Auth::login($user);

        return redirect()->route('customer.dashboard')->with('success', 'Welcome to Hahakar Nepal! Your customer account has been created.');
    }

    public function verifyRegisterOtp()
    {
        $this->validate([
            'otpCode' => 'required|string|size:6',
        ], [
            'otpCode.required' => 'Please enter the 6-digit verification code.',
            'otpCode.size' => 'The verification code must be exactly 6 digits.',
        ]);

        if (empty($this->pendingUserData)) {
            $this->addError('otpCode', 'Session expired. Please fill in the registration form again.');
            $this->showOtpStep = false;
            return;
        }

        $result = OtpService::verifyOtp($this->otpIdentifier, 'register', $this->otpCode);

        if (!$result['success']) {
            $this->addError('otpCode', $result['message']);
            return;
        }

        // Create verified user
        $userData = $this->pendingUserData;
        $userData['email_verified_at'] = now();
        $userData['phone_verified_at'] = now();

        $user = User::create($userData);

        Auth::login($user);

        return redirect()->route('customer.dashboard')->with('success', 'Email and account verified successfully! Welcome to Hahakar Nepal.');
    }

    public function resendRegisterOtp(): void
    {
        $throttleKey = 'resend-otp:' . request()->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->addError('otpCode', "Please wait {$seconds} seconds before requesting another code.");
            return;
        }

        RateLimiter::hit($throttleKey, 60);

        if (empty($this->otpIdentifier)) {
            $this->addError('otpCode', 'Invalid request. Please restart registration.');
            return;
        }

        OtpService::generateAndSendOtp(
            identifier: $this->otpIdentifier,
            type: $this->otpType,
            action: 'register',
            userId: null,
            recipientName: $this->pendingUserData['name'] ?? null
        );

        $this->otpCode = '';
        $this->otpStatusMessage = "A fresh 6-digit verification code has been re-dispatched to {$this->otpIdentifier}.";
    }

    public function backToRegisterForm(): void
    {
        $this->showOtpStep = false;
        $this->otpCode = '';
        $this->otpStatusMessage = '';
    }

    public function render()
    {
        return view('livewire.customer-register');
    }
}
