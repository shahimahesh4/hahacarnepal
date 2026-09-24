@extends('layouts.app')

@section('title', 'Price Alert Unsubscribed | Hahakar')

@section('content')
<div class="max-w-xl mx-auto px-4 py-16 text-center">
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8 sm:p-12">
        <div class="w-16 h-16 bg-slate-100 text-slate-600 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <h1 class="text-2xl font-bold text-slate-900 mb-2">You Have Been Unsubscribed</h1>
        <p class="text-sm text-slate-600 leading-relaxed mb-6">
            You will no longer receive price drop notifications for this search. You can still set up new alerts anytime you search on Hahakar.
        </p>
        <a href="{{ route('home') }}" wire:navigate class="inline-block bg-slate-900 hover:bg-slate-800 text-white font-semibold py-3 px-6 rounded-xl text-sm transition">
            Back to Home
        </a>
    </div>
</div>
@endsection
