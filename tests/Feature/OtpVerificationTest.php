<?php

namespace Tests\Feature;

use App\Models\OtpVerification;
use App\Models\Setting;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class OtpVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_by_default_otp_is_disabled_in_backend(): void
    {
        $this->assertFalse(OtpService::isEmailOtpEnabled());
        $this->assertFalse(OtpService::isPhoneOtpEnabled());
        $this->assertFalse(OtpService::isOtpRequired('login'));
        $this->assertFalse(OtpService::isOtpRequired('register'));
    }

    public function test_customer_can_register_directly_when_otp_is_disabled(): void
    {
        Setting::set('enable_email_otp', '0');
        Setting::set('enable_phone_otp', '0');

        Livewire::test(\App\Livewire\CustomerRegister::class)
            ->set('name', 'Pooja Sharma')
            ->set('email', 'pooja@example.com')
            ->set('phone', '9841234567')
            ->set('password', 'secret1234')
            ->set('password_confirmation', 'secret1234')
            ->set('acceptTerms', true)
            ->call('register')
            ->assertRedirect(route('customer.dashboard'));

        $this->assertDatabaseHas('users', [
            'email' => 'pooja@example.com',
            'phone' => '9841234567',
            'role' => 'user',
        ]);
        $this->assertAuthenticated();
    }

    public function test_customer_registration_triggers_otp_when_email_otp_is_enabled(): void
    {
        Mail::fake();

        Setting::set('enable_email_otp', '1');
        Setting::set('otp_trigger_mode', 'both');

        $component = Livewire::test(\App\Livewire\CustomerRegister::class)
            ->set('name', 'Bikash Adhikari')
            ->set('email', 'bikash@example.com')
            ->set('phone', '9841999888')
            ->set('password', 'Nepal@1234')
            ->set('password_confirmation', 'Nepal@1234')
            ->set('acceptTerms', true)
            ->call('register')
            ->assertSet('showOtpStep', true)
            ->assertSee('Enter 6-Digit OTP');

        $this->assertDatabaseMissing('users', [
            'email' => 'bikash@example.com',
        ]);

        $otp = OtpVerification::where('identifier', 'bikash@example.com')
            ->where('action', 'register')
            ->first();

        $this->assertNotNull($otp);
        $this->assertEquals(6, strlen($otp->otp_code));

        // Attempt invalid OTP
        $component->set('otpCode', '000000')
            ->call('verifyRegisterOtp')
            ->assertHasErrors(['otpCode']);

        // Submit correct OTP
        $component->set('otpCode', $otp->otp_code)
            ->call('verifyRegisterOtp')
            ->assertRedirect(route('customer.dashboard'));

        $this->assertDatabaseHas('users', [
            'email' => 'bikash@example.com',
        ]);
        $this->assertAuthenticated();
    }

    public function test_customer_login_triggers_otp_when_enabled(): void
    {
        Mail::fake();

        $user = User::create([
            'name' => 'Suman Thapa',
            'email' => 'suman@example.com',
            'phone' => '9801122334',
            'password' => Hash::make('mypassword123'),
            'role' => 'user',
            'status' => 'active',
        ]);

        Setting::set('enable_email_otp', '1');
        Setting::set('otp_trigger_mode', 'login_only');

        $component = Livewire::test(\App\Livewire\CustomerLogin::class)
            ->set('email', 'suman@example.com')
            ->set('password', 'mypassword123')
            ->call('login')
            ->assertSet('showOtpStep', true)
            ->assertSee('Enter Security Code');

        $this->assertGuest();

        $otp = OtpVerification::where('identifier', 'suman@example.com')
            ->where('action', 'login')
            ->first();

        $this->assertNotNull($otp);

        // Submit correct OTP
        $component->set('otpCode', $otp->otp_code)
            ->call('verifyLoginOtp')
            ->assertRedirect(route('customer.dashboard'));

        $this->assertAuthenticatedAs($user);
    }
}
