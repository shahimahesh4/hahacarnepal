<?php

namespace App\Services;

use App\Mail\OtpVerificationMail;
use App\Models\OtpVerification;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class OtpService
{
    /**
     * Check if Email OTP is enabled in backend settings.
     */
    public static function isEmailOtpEnabled(): bool
    {
        return (bool) Setting::get('enable_email_otp', false);
    }

    /**
     * Check if Phone / SMS OTP is enabled in backend settings.
     */
    public static function isPhoneOtpEnabled(): bool
    {
        return (bool) Setting::get('enable_phone_otp', false);
    }

    /**
     * Check if any OTP verification is globally active.
     */
    public static function isAnyOtpEnabled(): bool
    {
        return static::isEmailOtpEnabled() || static::isPhoneOtpEnabled();
    }

    /**
     * Check if OTP is required for a specific action ('register' or 'login').
     */
    public static function isOtpRequired(string $action): bool
    {
        if (!static::isAnyOtpEnabled()) {
            return false;
        }

        $mode = Setting::get('otp_trigger_mode', 'both');

        if ($mode === 'both') {
            return true;
        }

        if ($action === 'register' && $mode === 'register_only') {
            return true;
        }

        if ($action === 'login' && $mode === 'login_only') {
            return true;
        }

        return false;
    }

    /**
     * Get OTP expiration minutes from settings.
     */
    public static function getExpiryMinutes(): int
    {
        return (int) Setting::get('otp_expiry_minutes', 10);
    }

    /**
     * Get max failed attempts allowed per OTP.
     */
    public static function getMaxAttempts(): int
    {
        return (int) Setting::get('otp_max_attempts', 5);
    }

    /**
     * Generate, store, and dispatch an OTP code.
     */
    public static function generateAndSendOtp(
        string $identifier,
        string $type,
        string $action,
        ?int $userId = null,
        ?string $recipientName = null,
        ?array $meta = null
    ): OtpVerification {
        $cleanIdentifier = strtolower(trim($identifier));
        $expiryMinutes = static::getExpiryMinutes();
        $code = sprintf('%06d', random_int(100000, 999999));

        // Invalidate any previously issued pending OTPs for this identifier and action
        OtpVerification::where('identifier', $cleanIdentifier)
            ->where('action', $action)
            ->whereNull('verified_at')
            ->delete();

        $otp = OtpVerification::create([
            'user_id' => $userId,
            'identifier' => $cleanIdentifier,
            'type' => $type,
            'action' => $action,
            'otp_code' => $code,
            'expires_at' => now()->addMinutes($expiryMinutes),
            'attempts' => 0,
            'ip_address' => request()->ip(),
            'meta' => $meta,
        ]);

        // Dispatch based on channel type
        if ($type === 'email') {
            static::sendEmailOtp(
                email: $cleanIdentifier,
                code: $code,
                action: $action,
                name: $recipientName,
                expiryMinutes: $expiryMinutes,
                ip: request()->ip()
            );
        } elseif ($type === 'phone') {
            static::sendSmsOtp(
                phone: $cleanIdentifier,
                code: $code,
                action: $action
            );
        }

        return $otp;
    }

    /**
     * Send OTP via Email using brand template.
     */
    public static function sendEmailOtp(
        string $email,
        string $code,
        string $action,
        ?string $name = null,
        int $expiryMinutes = 10,
        ?string $ip = null
    ): bool {
        $actionTitle = match ($action) {
            'login' => 'Sign In Security Code',
            'register' => 'Complete Account Registration',
            'password_reset' => 'Password Reset Authorization',
            default => 'One-Time Verification Code',
        };

        try {
            Mail::to($email)->send(
                new OtpVerificationMail(
                    otpCode: $code,
                    actionTitle: $actionTitle,
                    recipientName: $name,
                    expiryMinutes: $expiryMinutes,
                    ipAddress: $ip
                )
            );
            return true;
        } catch (\Throwable $e) {
            Log::error("Failed to send OTP Email to {$email}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Send OTP via SMS (Nepal SMS Gateways or Mock Logger).
     */
    public static function sendSmsOtp(string $phone, string $code, string $action): bool
    {
        $gateway = Setting::get('sms_gateway_provider', 'log_mock');
        $siteName = Setting::get('site_name', 'Hahakar Nepal');
        $textMessage = "Your {$siteName} verification code is: {$code}. Valid for " . static::getExpiryMinutes() . " mins. Do not share this code.";

        if ($gateway === 'sparrow_sms') {
            $token = Setting::get('sparrow_sms_token', '');
            $from = Setting::get('sparrow_sms_from', 'HahakarCar');

            if (!empty($token)) {
                try {
                    $response = Http::timeout(6)->asForm()->post('http://api.sparrowsms.com/v2/sms/', [
                        'token' => $token,
                        'from' => $from,
                        'to' => $phone,
                        'text' => $textMessage,
                    ]);

                    if ($response->successful()) {
                        Log::info("SparrowSMS sent to {$phone}");
                        return true;
                    }
                    Log::warning("SparrowSMS error: " . $response->body());
                } catch (\Throwable $e) {
                    Log::error("SparrowSMS connection error: " . $e->getMessage());
                }
            }
        } elseif ($gateway === 'aakash_sms') {
            $authToken = Setting::get('aakash_sms_auth_token', '');

            if (!empty($authToken)) {
                try {
                    $response = Http::timeout(6)->asForm()->post('https://sms.aakashsms.com/sms/v3/send', [
                        'auth_token' => $authToken,
                        'to' => $phone,
                        'text' => $textMessage,
                    ]);

                    if ($response->successful()) {
                        Log::info("AakashSMS sent to {$phone}");
                        return true;
                    }
                    Log::warning("AakashSMS error: " . $response->body());
                } catch (\Throwable $e) {
                    Log::error("AakashSMS connection error: " . $e->getMessage());
                }
            }
        }

        // Default: Mock Logger (Nepal Sandbox & Development mode)
        Log::info("================ [SMS OTP DISPATCH] ================");
        Log::info("Recipient: {$phone}");
        Log::info("Action: {$action}");
        Log::info("Message: {$textMessage}");
        Log::info("====================================================");

        return true;
    }

    /**
     * Verify an entered OTP code against the database.
     */
    public static function verifyOtp(string $identifier, string $action, string $code): array
    {
        $cleanIdentifier = strtolower(trim($identifier));
        $maxAttempts = static::getMaxAttempts();

        $otp = OtpVerification::where('identifier', $cleanIdentifier)
            ->where('action', $action)
            ->whereNull('verified_at')
            ->latest()
            ->first();

        if (!$otp) {
            return [
                'success' => false,
                'message' => 'No active OTP verification session found. Please request a new code.',
                'otp' => null,
            ];
        }

        if ($otp->isExpired()) {
            return [
                'success' => false,
                'message' => 'The verification code has expired. Please request a new code.',
                'otp' => null,
            ];
        }

        if ($otp->hasExceededMaxAttempts($maxAttempts)) {
            return [
                'success' => false,
                'message' => 'Too many failed verification attempts. This code is invalidated. Please request a new code.',
                'otp' => null,
            ];
        }

        if ($otp->otp_code !== trim($code)) {
            $otp->increment('attempts');
            $remaining = max(0, $maxAttempts - $otp->attempts);

            return [
                'success' => false,
                'message' => $remaining > 0
                    ? "Invalid verification code. {$remaining} attempt(s) remaining."
                    : 'Too many incorrect attempts. This code has been locked. Please request a new one.',
                'otp' => null,
            ];
        }

        // Code is valid! Mark as verified
        $otp->update([
            'verified_at' => now(),
        ]);

        return [
            'success' => true,
            'message' => 'Code verified successfully.',
            'otp' => $otp,
        ];
    }
}
