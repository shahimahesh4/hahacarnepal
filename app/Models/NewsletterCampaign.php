<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class NewsletterCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subject',
        'preview_text',
        'badge_text',
        'headline',
        'banner_image_url',
        'content',
        'featured_offer_title',
        'featured_offer_price',
        'featured_offer_badge',
        'featured_offer_description',
        'cta_text',
        'cta_url',
        'target_audience',
        'manual_recipients',
        'status',
        'total_recipients',
        'successful_sends',
        'failed_sends',
        'sent_at',
    ];

    protected function casts(): array
    {
        return [
            'manual_recipients' => 'array',
            'sent_at' => 'datetime',
            'total_recipients' => 'integer',
            'successful_sends' => 'integer',
            'failed_sends' => 'integer',
        ];
    }

    /**
     * Resolve unique recipient email addresses based on target_audience setting.
     *
     * @return Collection<int, string>
     */
    public function resolveRecipients(): Collection
    {
        $emails = collect();

        switch ($this->target_audience) {
            case 'all_subscribers':
                $emails = Subscriber::where('status', 'active')->pluck('email');
                break;

            case 'all_users':
                $emails = User::where('status', 'active')->pluck('email');
                break;

            case 'customers_only':
                $emails = User::where('status', 'active')
                    ->where('role', 'customer')
                    ->pluck('email');
                break;

            case 'partners_only':
                $emails = User::where('status', 'active')
                    ->whereIn('role', ['driver', 'partner'])
                    ->pluck('email');
                break;

            case 'all_contacts':
                $subscriberEmails = Subscriber::where('status', 'active')->pluck('email');
                $userEmails = User::where('status', 'active')->pluck('email');
                $emails = $subscriberEmails->merge($userEmails);
                break;

            case 'manual_selection':
            case 'custom_emails':
                if (is_array($this->manual_recipients)) {
                    $emails = collect($this->manual_recipients);
                } elseif (is_string($this->manual_recipients)) {
                    $cleaned = preg_split('/[\r\n,;]+/', $this->manual_recipients);
                    $emails = collect($cleaned)->map(fn ($e) => trim($e))->filter();
                }
                break;

            default:
                $emails = Subscriber::where('status', 'active')->pluck('email');
                break;
        }

        return $emails
            ->map(fn ($e) => strtolower(trim((string)$e)))
            ->filter(fn ($e) => filter_var($e, FILTER_VALIDATE_EMAIL))
            ->unique()
            ->values();
    }
}
