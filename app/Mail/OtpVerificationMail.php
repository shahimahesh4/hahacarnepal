<?php

namespace App\Mail;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $otpCode;
    public string $actionTitle;
    public ?string $recipientName;
    public int $expiryMinutes;
    public ?string $ipAddress;

    public function __construct(
        string $otpCode,
        string $actionTitle = 'Account Security Verification',
        ?string $recipientName = null,
        int $expiryMinutes = 10,
        ?string $ipAddress = null
    ) {
        $this->otpCode = $otpCode;
        $this->actionTitle = $actionTitle;
        $this->recipientName = $recipientName;
        $this->expiryMinutes = $expiryMinutes;
        $this->ipAddress = $ipAddress;
    }

    public function envelope(): Envelope
    {
        $senderName = Setting::get('site_name', 'Hahakar Nepal');
        $senderEmail = Setting::get('support_email', 'support@hahakar.com');

        return new Envelope(
            from: new Address($senderEmail, $senderName),
            subject: "{$this->otpCode} is your Hahakar Nepal security code",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.otp',
            with: [
                'otpCode' => $this->otpCode,
                'actionTitle' => $this->actionTitle,
                'recipientName' => $this->recipientName,
                'expiryMinutes' => $this->expiryMinutes,
                'ipAddress' => $this->ipAddress,
                'previewText' => "Your single-use verification code is {$this->otpCode}. Valid for {$this->expiryMinutes} minutes.",
            ],
        );
    }
}
