@extends('layouts.app')

@section('title', 'Email Preferences | ' . \App\Models\Setting::get('site_name', 'Hahakar Nepal'))

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-slate-900/90 border border-slate-800 rounded-3xl p-8 sm:p-10 text-center shadow-2xl backdrop-blur-md">
        
        <div class="w-16 h-16 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center mx-auto mb-6">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>

        @if($valid)
            <h1 class="text-xl sm:text-2xl font-extrabold text-white mb-2">Unsubscribed Successfully</h1>
            <p class="text-xs sm:text-sm text-slate-400 leading-relaxed mb-6">
                You have been unsubscribed from Hahakar Nepal promotional alerts and newsletter offers for <span class="text-slate-200 font-semibold">{{ $email }}</span>.
            </p>
            <p class="text-xs text-slate-500 mb-8">
                You will still receive critical booking receipts and driver dispatch confirmations for active reservations.
            </p>
        @else
            <h1 class="text-xl sm:text-2xl font-extrabold text-white mb-2">Email Preferences</h1>
            <p class="text-xs sm:text-sm text-slate-400 leading-relaxed mb-6">
                If you wish to change your notification preferences, please contact our support desk or update your preferences from your dashboard.
            </p>
        @endif

        <div class="space-y-3">
            <a wire:navigate href="{{ route('home') }}" class="w-full inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-3 px-6 rounded-xl text-xs sm:text-sm transition shadow-lg shadow-emerald-950/40">
                <span>Return to Homepage</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
            <a wire:navigate href="{{ route('contact.index') }}" class="w-full inline-flex items-center justify-center text-xs text-slate-400 hover:text-slate-200 transition py-2">
                Need Help? Contact Support Desk
            </a>
        </div>

    </div>
</div>
@endsection
