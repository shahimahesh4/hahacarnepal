<?php

namespace App\Mail;

use App\Models\NewsletterCampaign;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterCampaignMail extends Mailable
{
    use Queueable, SerializesModels;

    public NewsletterCampaign $campaign;
    public string $recipientEmail;
    public ?string $unsubscribeUrl;

    public function __construct(NewsletterCampaign $campaign, string $recipientEmail)
    {
        $this->campaign = $campaign;
        $this->recipientEmail = $recipientEmail;
        $this->unsubscribeUrl = route('newsletter.unsubscribe', [
            'email' => urlencode($recipientEmail),
            'token' => substr(hash('sha256', $recipientEmail . config('app.key')), 0, 32),
        ]);
    }

    public function envelope(): Envelope
    {
        $senderName = Setting::get('site_name', 'Hahakar Nepal');
        $senderEmail = Setting::get('support_email', 'support@hahakar.com');

        return new Envelope(
            from: new Address($senderEmail, $senderName),
            subject: $this->campaign->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.campaign',
            with: [
                'campaign' => $this->campaign,
                'previewText' => $this->campaign->preview_text ?? $this->campaign->headline ?? 'Hahakar Nepal Travel Update',
                'unsubscribeUrl' => $this->unsubscribeUrl,
                'subject' => $this->campaign->subject,
            ],
        );
    }
}
