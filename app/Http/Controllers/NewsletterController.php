<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsletterController extends Controller
{
    public function unsubscribe(Request $request): View
    {
        $rawEmail = $request->query('email');
        $token = $request->query('token');
        
        $email = urldecode((string)$rawEmail);
        $expectedToken = substr(hash('sha256', $email . config('app.key')), 0, 32);

        $valid = hash_equals($expectedToken, (string)$token);

        if ($valid && $email) {
            Subscriber::where('email', strtolower(trim($email)))->update([
                'status' => 'unsubscribed',
            ]);
        }

        return view('pages.unsubscribed', [
            'email' => $email,
            'valid' => $valid,
        ]);
    }
}
