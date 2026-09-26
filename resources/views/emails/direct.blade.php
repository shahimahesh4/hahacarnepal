@extends('emails.layouts.master')

@section('content')
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    
    @if(!empty($headline))
    <tr>
        <td align="left" style="padding-bottom: 16px;">
            <h1 class="mobile-title" style="margin: 0; font-size: 24px; line-height: 32px; font-weight: 800; color: #ffffff;">
                {{ $headline }}
            </h1>
        </td>
    </tr>
    @endif

    <tr>
        <td align="left" style="padding-bottom: 24px; font-size: 14px; line-height: 24px; color: #cbd5e1;">
            <div style="color: #cbd5e1; font-size: 14px; line-height: 1.7;">
                {!! nl2br(e($messageBody ?? $content ?? '')) !!}
            </div>
        </td>
    </tr>

    @if(!empty($ctaText) && !empty($ctaUrl))
    <tr>
        <td align="center" style="padding-bottom: 12px; padding-top: 8px;">
            <table border="0" cellpadding="0" cellspacing="0" style="margin: auto;">
                <tr>
                    <td align="center" style="border-radius: 12px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);">
                        <a href="{{ $ctaUrl }}" target="_blank" style="display: inline-block; padding: 14px 32px; font-family: sans-serif; font-size: 14px; font-weight: 800; color: #ffffff; text-decoration: none; border-radius: 12px;">
                            {{ $ctaText }} &rarr;
                        </a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    @endif

</table>
@endsection
