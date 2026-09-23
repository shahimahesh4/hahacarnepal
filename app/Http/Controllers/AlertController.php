<?php

namespace App\Http\Controllers;

use App\Models\PriceAlert;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AlertController extends Controller
{
    public function confirm(string $token): View
    {
        $tokenHash = hash('sha256', $token);
        $alert = PriceAlert::where('verify_token_hash', $tokenHash)
            ->with(['pickupLocation', 'dropoffLocation'])
            ->first();

        if (!$alert) {
            return view('alerts.confirm', ['success' => false, 'alert' => null]);
        }

        $alert->update([
            'status' => 'active',
            'verified_at' => Carbon::now(),
            'verify_token_hash' => null, // One-time token
        ]);

        return view('alerts.confirm', ['success' => true, 'alert' => $alert]);
    }

    public function unsubscribe(string $token): View
    {
        $tokenHash = hash('sha256', $token);
        $alert = PriceAlert::where('manage_token_hash', $tokenHash)->first();

        if ($alert) {
            $alert->update([
                'status' => 'unsubscribed',
            ]);
        }

        return view('alerts.unsubscribe');
    }
}
