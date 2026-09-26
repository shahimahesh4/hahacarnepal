@extends('emails.layouts.master')

@section('content')
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    
    <!-- Optional Badge Pill -->
    @if(!empty($campaign->badge_text))
    <tr>
        <td align="left" style="padding-bottom: 14px;">
            <span style="display: inline-block; background-color: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.4); color: #34d399; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; padding: 5px 14px; border-radius: 20px;">
                {{ $campaign->badge_text }}
            </span>
        </td>
    </tr>
    @endif

    <!-- Headline Title -->
    @if(!empty($campaign->headline))
    <tr>
        <td align="left" style="padding-bottom: 16px;">
            <h1 class="mobile-title" style="margin: 0; font-size: 26px; line-height: 34px; font-weight: 800; color: #ffffff; letter-spacing: -0.5px;">
                {{ $campaign->headline }}
            </h1>
        </td>
    </tr>
    @endif

    <!-- Hero Banner Image (Optional) -->
    @if(!empty($campaign->banner_image_url))
    <tr>
        <td align="center" style="padding-bottom: 24px;">
            <img src="{{ $campaign->banner_image_url }}" alt="{{ $campaign->headline ?? 'Hahakar Nepal' }}" width="528" class="fluid" style="display: block; width: 100%; max-width: 528px; border-radius: 14px; border: 1px solid #334155;">
        </td>
    </tr>
    @endif

    <!-- Email Content Body -->
    <tr>
        <td align="left" style="padding-bottom: 24px; font-size: 14px; line-height: 24px; color: #cbd5e1;">
            <div style="color: #cbd5e1; font-size: 14px; line-height: 1.7;">
                {!! $campaign->content !!}
            </div>
        </td>
    </tr>

    <!-- Featured Offer / Service Box (Optional) -->
    @if(!empty($campaign->featured_offer_title))
    <tr>
        <td style="padding-bottom: 28px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #070e24; border: 1.5px solid #059669; border-radius: 16px; overflow: hidden;">
                <tr>
                    <td style="padding: 20px 22px; background: linear-gradient(180deg, rgba(16,185,129,0.12) 0%, rgba(7,14,36,0) 100%);">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td valign="middle">
                                    @if(!empty($campaign->featured_offer_badge))
                                        <span style="display: inline-block; background-color: #059669; color: #ffffff; font-size: 10px; font-weight: 800; text-transform: uppercase; padding: 3px 8px; border-radius: 6px; margin-bottom: 6px;">
                                            {{ $campaign->featured_offer_badge }}
                                        </span>
                                    @endif
                                    <h3 style="margin: 0; font-size: 18px; font-weight: 800; color: #ffffff;">
                                        {{ $campaign->featured_offer_title }}
                                    </h3>
                                </td>
                                @if(!empty($campaign->featured_offer_price))
                                <td valign="middle" align="right">
                                    <span style="display: inline-block; background-color: #0f172a; border: 1px solid #334155; padding: 6px 12px; border-radius: 10px; font-size: 14px; font-weight: 800; color: #34d399;">
                                        {{ $campaign->featured_offer_price }}
                                    </span>
                                </td>
                                @endif
                            </tr>
                            @if(!empty($campaign->featured_offer_description))
                            <tr>
                                <td colspan="2" style="padding-top: 10px; font-size: 13px; line-height: 20px; color: #94a3b8;">
                                    {{ $campaign->featured_offer_description }}
                                </td>
                            </tr>
                            @endif
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    @endif

    <!-- Call to Action (CTA) Button -->
    @if(!empty($campaign->cta_text) && !empty($campaign->cta_url))
    <tr>
        <td align="center" style="padding-bottom: 12px;">
            <table border="0" cellpadding="0" cellspacing="0" style="margin: auto;">
                <tr>
                    <td align="center" style="border-radius: 12px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);">
                        <a href="{{ $campaign->cta_url }}" target="_blank" style="display: inline-block; padding: 14px 34px; font-family: sans-serif; font-size: 15px; font-weight: 800; color: #ffffff; text-decoration: none; border-radius: 12px; text-transform: none; letter-spacing: 0.3px;">
                            {{ $campaign->cta_text }} &rarr;
                        </a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    @endif

</table>
@endsection
