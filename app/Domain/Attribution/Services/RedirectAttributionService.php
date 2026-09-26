<?php

namespace App\Domain\Attribution\Services;

use App\Domain\Providers\Adapters\MockCarRentalProvider;
use App\Domain\Providers\DTOs\AttributionData;
use App\Models\Offer;
use App\Models\OutboundClick;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RedirectAttributionService
{
    public function __construct(
        protected ProviderDomainValidator $domainValidator
    ) {}

    public function processRedirect(string $offerUuid, Request $request): string
    {
        $offer = Offer::where('uuid', $offerUuid)
            ->with(['search.pickupLocation', 'search.dropoffLocation', 'provider.activeCredential'])
            ->firstOrFail();

        // Sub-ID and attribution capture
        $subId = $request->query('sub_id') ?? 'hahakar_' . Str::random(8);
        $utmSource = $request->query('utm_source') ?? $request->cookie('utm_source');
        $utmMedium = $request->query('utm_medium') ?? $request->cookie('utm_medium');
        $utmCampaign = $request->query('utm_campaign') ?? $request->cookie('utm_campaign');

        $attribution = new AttributionData(
            subId: $subId,
            utmSource: $utmSource,
            utmMedium: $utmMedium,
            utmCampaign: $utmCampaign,
            sessionId: $request->session()->getId(),
            referrer: $request->header('referer')
        );

        // Resolve adapter to build outbound redirect URL
        $provider = $offer->provider;
        $adapterClass = $provider->adapter_class ?? MockCarRentalProvider::class;
        if (!class_exists($adapterClass)) {
            $adapterClass = MockCarRentalProvider::class;
        }

        /** @var \App\Domain\Providers\Contracts\CarRentalProvider $adapter */
        $adapter = new $adapterClass($provider);
        $targetUrl = $adapter->buildRedirectUrl($offer, $attribution);

        // Security check against allowed domains
        if (!$this->domainValidator->isAllowed($targetUrl, $provider)) {
            abort(403, 'Target destination domain is not authorized for this provider.');
        }

        // Anonymize IP and User-Agent
        $ip = $request->ip() ?? '127.0.0.1';
        $ipHash = hash_hmac('sha256', $ip, config('app.key'));
        $userAgentHash = hash('sha256', $request->userAgent() ?? '');

        // Detect device type
        $userAgent = strtolower($request->userAgent() ?? '');
        $deviceType = 'desktop';
        if (str_contains($userAgent, 'tablet') || str_contains($userAgent, 'ipad')) {
            $deviceType = 'tablet';
        } elseif (str_contains($userAgent, 'mobile') || str_contains($userAgent, 'android') || str_contains($userAgent, 'iphone')) {
            $deviceType = 'mobile';
        }

        // Record Outbound Click
        OutboundClick::create([
            'uuid' => (string) Str::uuid(),
            'search_id' => $offer->search_id,
            'offer_id' => $offer->id,
            'provider_id' => $offer->provider_id,
            'session_id' => $request->session()->getId(),
            'user_id' => auth()->id(),
            'sub_id' => $subId,
            'utm_source' => $utmSource,
            'utm_medium' => $utmMedium,
            'utm_campaign' => $utmCampaign,
            'referrer' => $request->header('referer'),
            'device_type' => $deviceType,
            'ip_hash' => $ipHash,
            'user_agent_hash' => $userAgentHash,
            'target_url' => $targetUrl,
            'clicked_at' => Carbon::now(),
        ]);

        return $targetUrl;
    }
}
