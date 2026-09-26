@extends('emails.layouts.master')

@section('content')
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    
    <!-- Title -->
    <tr>
        <td align="left" style="padding-bottom: 8px;">
            <div style="display: inline-block; padding: 4px 10px; border-radius: 8px; background-color: rgba(16, 185, 129, 0.12); border: 1px solid rgba(16, 185, 129, 0.25); color: #10b981; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px;">
                🔒 Security Verification
            </div>
            <h1 class="mobile-title" style="margin: 0; font-size: 22px; line-height: 28px; font-weight: 800; color: #ffffff;">
                {{ $actionTitle ?? 'Confirm Your Identity' }}
            </h1>
        </td>
    </tr>

    <!-- Greeting -->
    <tr>
        <td align="left" style="padding-top: 12px; padding-bottom: 16px; font-size: 14px; line-height: 22px; color: #cbd5e1;">
            <p style="margin: 0 0 10px 0;">
                Namaste <strong>{{ $recipientName ?: 'Valued Customer' }}</strong>,
            </p>
            <p style="margin: 0;">
                Use the following 6-digit one-time security code (OTP) to securely complete your authentication on Hahakar Nepal.
            </p>
        </td>
    </tr>

    <!-- Big 6-Digit OTP Box -->
    <tr>
        <td align="center" style="padding: 16px 0 20px 0;">
            <table border="0" cellpadding="0" cellspacing="0" style="margin: auto; width: 100%; max-width: 380px;">
                <tr>
                    <td align="center" style="padding: 20px 24px; border-radius: 16px; background-color: #050b1a; border: 2px dashed #10b981; box-shadow: 0 8px 24px rgba(16, 185, 129, 0.15);">
                        <p style="margin: 0 0 6px 0; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: #94a3b8;">
                            Your One-Time Passcode
                        </p>
                        <div style="font-family: 'Courier New', Courier, monospace, sans-serif; font-size: 34px; font-weight: 900; letter-spacing: 8px; color: #34d399; margin: 6px 0; text-shadow: 0 0 12px rgba(52, 211, 153, 0.4);">
                            {{ $otpCode }}
                        </div>
                        <p style="margin: 6px 0 0 0; font-size: 11px; color: #f59e0b; font-weight: 600;">
                            ⏱️ Expires in {{ $expiryMinutes ?? 10 }} minutes
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- Advisory Warning -->
    <tr>
        <td align="left" style="padding-bottom: 20px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: rgba(245, 158, 11, 0.08); border-left: 3px solid #f59e0b; border-radius: 6px; padding: 12px 14px;">
                <tr>
                    <td style="font-size: 12px; line-height: 18px; color: #fde68a;">
                        <strong>Security Reminder:</strong> Never share this OTP code or your password with anyone. Hahakar Nepal team members or drivers will never ask for your verification code.
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- Metadata & Help -->
    <tr>
        <td align="left" style="padding-top: 8px; border-top: 1px solid rgba(255, 255, 255, 0.06); font-size: 11px; line-height: 18px; color: #64748b;">
            @if(!empty($ipAddress))
                <p style="margin: 0 0 4px 0;">
                    Request originated from IP: <code style="color: #94a3b8; background: #070d1e; padding: 2px 5px; border-radius: 4px;">{{ $ipAddress }}</code>
                </p>
            @endif
            <p style="margin: 0;">
                If you did not request this security code, please ignore this email or reach our 24/7 Nepal security desk immediately at <a href="mailto:{{ \App\Models\Setting::get('support_email', 'support@hahakar.com') }}" style="color: #10b981; text-decoration: underline;">{{ \App\Models\Setting::get('support_email', 'support@hahakar.com') }}</a>.
            </p>
        </td>
    </tr>

</table>
@endsection
