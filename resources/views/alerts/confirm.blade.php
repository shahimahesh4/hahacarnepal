@extends('layouts.app')

@section('title', 'Price Alert Confirmed | Hahakar')

@section('content')
<div class="max-w-xl mx-auto px-4 py-16 text-center">
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8 sm:p-12">
        @if($success)
            <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 mb-2">Price Alert Activated!</h1>
            <p class="text-sm text-slate-600 leading-relaxed mb-6">
                Your price alert for <strong class="text-slate-800">{{ $alert->pickupLocation->city }}</strong> is now active. We will monitor rates across car rental providers and email you at <strong class="text-slate-800">{{ $alert->email }}</strong> whenever prices drop.
            </p>

            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 text-xs text-slate-600 mb-6 text-left space-y-1">
                <div>📍 <strong>Pickup:</strong> {{ $alert->pickupLocation->display_name }}</div>
                <div>📅 <strong>Dates:</strong> {{ $alert->pickup_datetime->format('M d, Y') }} → {{ $alert->dropoff_datetime->format('M d, Y') }}</div>
                <div>🔔 <strong>Trigger:</strong> {{ ucwords(str_replace('_', ' ', $alert->threshold_type)) }}</div>
            </div>

            <a href="{{ route('search.index', ['pickup' => $alert->pickup_location_id, 'from' => $alert->pickup_datetime->format('Y-m-d\TH:i'), 'to' => $alert->dropoff_datetime->format('Y-m-d\TH:i')]) }}" 
                wire:navigate
                class="inline-block w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3.5 px-6 rounded-xl transition">
                View Current Deals
            </a>
        @else
            <div class="w-16 h-16 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </div>
            <h1 class="text-2xl font-bold text-slate-900 mb-2">Invalid or Expired Link</h1>
            <p class="text-sm text-slate-600 leading-relaxed mb-6">
                This confirmation token has expired or is no longer valid. You can create a new price alert on any search page.
            </p>
            <a href="{{ route('home') }}" wire:navigate class="inline-block bg-slate-900 hover:bg-slate-800 text-white font-semibold py-3 px-6 rounded-xl text-sm transition">
                Return to Search
            </a>
        @endif
    </div>
</div>
@endsection
