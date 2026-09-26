<?php

namespace App\Livewire;

use App\Models\User;
use App\Services\OtpService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Component;

class CustomerLogin extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = true;

    // OTP Verification State
    public bool $showOtpStep = false;
    public string $otpCode = '';
    public string $otpIdentifier = '';
    public string $otpType = 'email';
    public string $otpStatusMessage = '';
    public ?int $pendingUserId = null;
    public bool $pendingRemember = true;

    // Forgot Password Modal State
    public bool $showForgotModal = false;
    public string $forgotEmail = '';
    public string $forgotStatusMessage = '';

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

    public function openForgotModal(): void
    {
        $this->showForgotModal = true;
        $this->forgotStatusMessage = '';
        $this->forgotEmail = $this->email;
    }

    public function closeForgotModal(): void
    {
        $this->showForgotModal = false;
        $this->forgotStatusMessage = '';
    }

    public function requestPasswordReset(): void
    {
        $throttleKey = 'password-reset:' . request()->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->addError('forgotEmail', "Too many reset requests. Please wait {$seconds} seconds.");
            return;
        }
        RateLimiter::hit($throttleKey, 120);

        $this->validate([
            'forgotEmail' => 'required|email',
        ]);

        $this->forgotStatusMessage = "Password reset link and OTP instructions have been dispatched to {$this->forgotEmail}. For instant 24/7 help, call Hahakar Nepal Support at " . \App\Models\Setting::get('support_phone', '+977 9801-HAHAKAR') . ".";
    }

    public function login()
    {
        $this->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $cleanIdentifier = strtolower(trim($this->email));
        $throttleKey = Str::transliterate($cleanIdentifier . '|' . request()->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->addError('email', "Too many login attempts. Please try again in {$seconds} seconds.");
            return;
        }

        // Find user by email or phone
        $user = User::where('email', $cleanIdentifier)
            ->orWhere('phone', $cleanIdentifier)
            ->first();

        if (!$user || !Hash::check($this->password, $user->password)) {
            RateLimiter::hit($throttleKey, 60);
            $this->addError('email', 'Invalid email or password. Please verify your credentials.');
            return;
        }

        // Check if OTP is enabled for login in backend admin settings
        if (OtpService::isOtpRequired('login')) {
            RateLimiter::clear($throttleKey);

            $this->pendingUserId = $user->id;
            $this->pendingRemember = $this->remember;
            $this->otpType = OtpService::isEmailOtpEnabled() ? 'email' : 'phone';
            $this->otpIdentifier = $this->otpType === 'email' ? $user->email : ($user->phone ?: $user->email);

            // Generate and send OTP
            OtpService::generateAndSendOtp(
                identifier: $this->otpIdentifier,
                type: $this->otpType,
                action: 'login',
                userId: $user->id,
                recipientName: $user->name
            );

            // Also dispatch phone OTP if both channels are enabled and user has phone
            if (OtpService::isEmailOtpEnabled() && OtpService::isPhoneOtpEnabled() && !empty($user->phone)) {
                OtpService::generateAndSendOtp(
                    identifier: $user->phone,
                    type: 'phone',
                    action: 'login',
                    userId: $user->id,
                    recipientName: $user->name
                );
            }

            $this->showOtpStep = true;
            $maskedTarget = $this->otpType === 'email'
                ? $this->maskEmail($user->email)
                : $this->maskPhone($user->phone ?: $user->email);

            $this->otpStatusMessage = "A 6-digit security login code has been sent to {$maskedTarget}.";
            return;
        }

        // Direct standard login if OTP is disabled (default)
        if (Auth::attempt(['email' => $user->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::clear($throttleKey);
            session()->regenerate();
            $user = Auth::user();

            if ($user->isPartner()) {
                return redirect()->intended(route('partner.dashboard'));
            }

            return redirect()->intended(route('customer.dashboard'));
        }

        RateLimiter::hit($throttleKey, 60);
        $this->addError('email', 'Invalid email or password. Please verify your credentials.');
    }

    public function verifyLoginOtp()
    {
        $this->validate([
            'otpCode' => 'required|string|size:6',
        ], [
            'otpCode.required' => 'Please enter the 6-digit login verification code.',
            'otpCode.size' => 'The verification code must be exactly 6 digits.',
        ]);

        if (!$this->pendingUserId) {
            $this->addError('otpCode', 'Session expired. Please sign in again.');
            $this->showOtpStep = false;
            return;
        }

        $result = OtpService::verifyOtp($this->otpIdentifier, 'login', $this->otpCode);

        if (!$result['success']) {
            $this->addError('otpCode', $result['message']);
            return;
        }

        // Login user
        Auth::loginUsingId($this->pendingUserId, $this->pendingRemember);
        session()->regenerate();

        $user = Auth::user();

        if ($user->isPartner()) {
            return redirect()->intended(route('partner.dashboard'));
        }

        return redirect()->intended(route('customer.dashboard'));
    }

    public function resendLoginOtp(): void
    {
        $throttleKey = 'resend-login-otp:' . request()->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->addError('otpCode', "Please wait {$seconds} seconds before requesting a new code.");
            return;
        }

        RateLimiter::hit($throttleKey, 60);

        if (!$this->pendingUserId || empty($this->otpIdentifier)) {
            $this->addError('otpCode', 'Session expired. Please sign in again.');
            $this->showOtpStep = false;
            return;
        }

        $user = User::find($this->pendingUserId);

        OtpService::generateAndSendOtp(
            identifier: $this->otpIdentifier,
            type: $this->otpType,
            action: 'login',
            userId: $this->pendingUserId,
            recipientName: $user ? $user->name : null
        );

        $this->otpCode = '';
        $this->otpStatusMessage = "A fresh 6-digit login code has been re-dispatched to {$this->otpIdentifier}.";
    }

    public function backToLoginForm(): void
    {
        $this->showOtpStep = false;
        $this->otpCode = '';
        $this->otpStatusMessage = '';
        $this->pendingUserId = null;
    }

    protected function maskEmail(string $email): string
    {
        $parts = explode('@', $email);
        if (count($parts) !== 2) return $email;
        $name = $parts[0];
        $domain = $parts[1];
        $maskedName = substr($name, 0, 2) . str_repeat('*', max(1, strlen($name) - 3)) . substr($name, -1);
        return $maskedName . '@' . $domain;
    }

    protected function maskPhone(string $phone): string
    {
        $len = strlen($phone);
        if ($len <= 4) return $phone;
        return substr($phone, 0, 3) . str_repeat('*', $len - 6) . substr($phone, -3);
    }

    public function render()
    {
        return view('livewire.customer-login');
    }
}
