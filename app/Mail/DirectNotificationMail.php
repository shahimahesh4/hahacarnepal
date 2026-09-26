<?php

namespace App\Mail;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DirectNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $emailSubject;
    public ?string $headline;
    public string $messageBody;
    public ?string $ctaText;
    public ?string $ctaUrl;
    public ?string $recipientEmail;
    public ?string $unsubscribeUrl;

    public function __construct(
        string $emailSubject,
        string $messageBody,
        ?string $headline = null,
        ?string $ctaText = null,
        ?string $ctaUrl = null,
        ?string $recipientEmail = null
    ) {
        $this->emailSubject = $emailSubject;
        $this->messageBody = $messageBody;
        $this->headline = $headline;
        $this->ctaText = $ctaText;
        $this->ctaUrl = $ctaUrl;
        $this->recipientEmail = $recipientEmail;

        if ($recipientEmail) {
            $this->unsubscribeUrl = route('newsletter.unsubscribe', [
                'email' => urlencode($recipientEmail),
                'token' => substr(hash('sha256', $recipientEmail . config('app.key')), 0, 32),
            ]);
        } else {
            $this->unsubscribeUrl = null;
        }
    }

    public function envelope(): Envelope
    {
        $senderName = Setting::get('site_name', 'Hahakar Nepal');
        $senderEmail = Setting::get('support_email', 'support@hahakar.com');

        return new Envelope(
            from: new Address($senderEmail, $senderName),
            subject: $this->emailSubject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.direct',
            with: [
                'subject' => $this->emailSubject,
                'headline' => $this->headline,
                'messageBody' => $this->messageBody,
                'ctaText' => $this->ctaText,
                'ctaUrl' => $this->ctaUrl,
                'previewText' => $this->headline ?? substr($this->messageBody, 0, 100),
                'unsubscribeUrl' => $this->unsubscribeUrl,
            ],
        );
    }
}
