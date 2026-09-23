<?php

namespace App\Http\Controllers;

use App\Domain\Attribution\Services\RedirectAttributionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function __invoke(string $offer, Request $request, RedirectAttributionService $service): RedirectResponse
    {
        $targetUrl = $service->processRedirect($offer, $request);

        return redirect()->away($targetUrl, 302, [
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
        ]);
    }
}
