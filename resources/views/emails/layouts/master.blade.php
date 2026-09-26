<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">
    <title>{{ $subject ?? 'Hahakar Nepal Update' }}</title>
    <!--[if mso]>
    <xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml>
    <![endif]-->
    <style>
        /* Base Resets */
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        table { border-collapse: collapse !important; }
        body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; background-color: #070d1e; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }
        
        /* Mobile Styles */
        @media screen and (max-width: 600px) {
            .email-container { width: 100% !important; margin: auto !important; }
            .fluid { max-width: 100% !important; height: auto !important; margin-left: auto !important; margin-right: auto !important; }
            .stack-column, .stack-column-center { display: block !important; width: 100% !important; max-width: 100% !important; direction: ltr !important; }
            .stack-column-center { text-align: center !important; }
            .mobile-padding { padding-left: 20px !important; padding-right: 20px !important; }
            .mobile-title { font-size: 24px !important; line-height: 30px !important; }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; background-color: #070d1e;">

    <!-- Preheader preview text (visible in inbox summary, invisible in email body) -->
    <div style="display: none; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
        {{ $previewText ?? 'Explore verified car rentals and exclusive travel updates across Nepal.' }}
        &#847; &zwnj; &nbsp; &#8199; &shy; &#847; &zwnj; &nbsp; &#8199; &shy; &#847; &zwnj; &nbsp; &#8199; &shy;
    </div>

    <!-- Email Outer Container -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed; background-color: #070d1e;">
        <tr>
            <td align="center" style="padding: 25px 12px 40px 12px;">
                
                <!-- Main Card (600px max) -->
                <!--[if (gte mso 9)|(IE)]>
                <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
                <tr>
                <td align="center" valign="top" width="600">
                <![endif]-->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="email-container" style="max-width: 600px; background-color: #0b142c; border: 1px solid #1e293b; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.5);">
                    
                    <!-- Top Emerald Glow Bar -->
                    <tr>
                        <td height="4" style="background: linear-gradient(90deg, #10b981 0%, #06b6d4 100%); font-size: 4px; line-height: 4px;">&nbsp;</td>
                    </tr>

                    <!-- Header: Brand Logo & Tagline -->
                    <tr>
                        <td align="center" style="padding: 30px 24px 20px 24px; background-color: #080e22; border-bottom: 1px solid rgba(255,255,255,0.06);">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center">
                                        <a href="{{ config('app.url', 'https://hahakar.com') }}" target="_blank" style="text-decoration: none;">
                                            <span style="display: inline-block; background-color: #ffffff; padding: 8px 16px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.2);">
                                                <img src="{{ \App\Models\Setting::getLogoUrl() }}" alt="{{ \App\Models\Setting::get('site_name', 'Hahakar Nepal') }}" width="150" style="display: block; width: 150px; max-width: 150px; height: auto; font-family: sans-serif; font-size: 20px; font-weight: bold; color: #0f172a;">
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding-top: 10px;">
                                        <p style="margin: 0; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: #10b981;">
                                            Nepal's #1 Car Rental & Mobility Network
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Main Dynamic Content Slot -->
                    <tr>
                        <td class="mobile-padding" style="padding: 32px 36px 28px 36px;">
                            @yield('content')
                        </td>
                    </tr>

                    <!-- Trust Pillars Mini Bar -->
                    <tr>
                        <td style="padding: 0 24px 24px 24px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #070d1e; border: 1px solid rgba(255,255,255,0.05); border-radius: 14px; padding: 14px;">
                                <tr>
                                    <td class="stack-column-center" width="33.33%" align="center" style="padding: 6px;">
                                        <p style="margin: 0; font-size: 11px; font-weight: bold; color: #e2e8f0;">🛡️ 100% Verified</p>
                                        <p style="margin: 2px 0 0 0; font-size: 10px; color: #94a3b8;">Scorpio 4WD & Vans</p>
                                    </td>
                                    <td class="stack-column-center" width="33.33%" align="center" style="padding: 6px; border-left: 1px solid rgba(255,255,255,0.05); border-right: 1px solid rgba(255,255,255,0.05);">
                                        <p style="margin: 0; font-size: 11px; font-weight: bold; color: #e2e8f0;">💰 Transparent NPR</p>
                                        <p style="margin: 2px 0 0 0; font-size: 10px; color: #94a3b8;">Zero Hidden Fees</p>
                                    </td>
                                    <td class="stack-column-center" width="33.33%" align="center" style="padding: 6px;">
                                        <p style="margin: 0; font-size: 11px; font-weight: bold; color: #e2e8f0;">📞 24/7 Road Help</p>
                                        <p style="margin: 2px 0 0 0; font-size: 10px; color: #94a3b8;">+977 9801212547</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer: Contact & Legal -->
                    <tr>
                        <td align="center" style="padding: 24px 24px 30px 24px; background-color: #060b1a; border-top: 1px solid rgba(255,255,255,0.06); text-align: center;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center" style="font-size: 12px; color: #94a3b8; line-height: 18px;">
                                        <p style="margin: 0 0 8px 0; font-weight: 600; color: #cbd5e1;">
                                            Hahakar Nepal Pvt. Ltd.
                                        </p>
                                        <p style="margin: 0 0 12px 0; font-size: 11px; color: #64748b;">
                                            Thamel Tourist Center, Kathmandu & Pokhara Lakeside, Nepal
                                        </p>
                                        <p style="margin: 0 0 16px 0; font-size: 11px; color: #94a3b8;">
                                            Questions? Reach us at <a href="mailto:{{ \App\Models\Setting::get('support_email', 'support@hahakar.com') }}" style="color: #10b981; text-decoration: underline;">{{ \App\Models\Setting::get('support_email', 'support@hahakar.com') }}</a> or WhatsApp <a href="https://wa.me/9779801424252" style="color: #10b981; text-decoration: underline;">+977 9801424252</a>.
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding-top: 8px; border-top: 1px solid rgba(255,255,255,0.05); font-size: 10px; color: #475569; line-height: 16px;">
                                        <p style="margin: 0 0 6px 0;">
                                            You are receiving this email because you subscribed on <a href="{{ config('app.url', 'https://hahakar.com') }}" style="color: #64748b; text-decoration: underline;">Hahakar.com</a> or have an active customer/partner account.
                                        </p>
                                        <p style="margin: 0;">
                                            @if(isset($unsubscribeUrl) && $unsubscribeUrl)
                                                <a href="{{ $unsubscribeUrl }}" style="color: #94a3b8; text-decoration: underline; font-weight: 600;">Unsubscribe from travel alerts</a>
                                                &nbsp;&bull;&nbsp;
                                            @endif
                                            <a href="{{ route('pages.show', 'privacy') }}" style="color: #64748b; text-decoration: underline;">Privacy Policy</a>
                                            &nbsp;&bull;&nbsp;
                                            <a href="{{ route('pages.show', 'terms') }}" style="color: #64748b; text-decoration: underline;">Terms of Service</a>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>
                <!--[if (gte mso 9)|(IE)]>
                </td>
                </tr>
                </table>
                <![endif]-->

            </td>
        </tr>
    </table>

</body>
</html>
