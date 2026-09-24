@extends('layouts.app')

@section('title', 'Direct Vehicle Booking & Rental in Nepal - Hahakar')
@section('meta_description', 'Book verified vehicles in Nepal directly. Scorpio 4WD, Toyota Hilux, Creta, Swift, and HiAce tourist vans with professional chauffeur or self-drive.')

@section('content')
<div class="relative bg-gradient-to-b from-[#0a1128] via-[#0f172a] to-[#1e293b] text-white py-12 md:py-20 overflow-hidden min-h-screen">
    <!-- Ambient Background Glows -->
    <div class="absolute inset-0 opacity-25 pointer-events-none">
        <div class="absolute -top-40 -right-40 w-[550px] h-[550px] bg-emerald-500 rounded-full blur-[150px]"></div>
        <div class="absolute top-96 -left-40 w-[450px] h-[450px] bg-teal-500 rounded-full blur-[140px]"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Hero Header -->
        <div class="text-center max-w-3xl mx-auto mb-12">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-black uppercase tracking-wider bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 mb-4 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Direct Fleet & Chauffeur Booking</span>
                <span class="text-slate-400">•</span>
                <span>Nepal Only</span>
            </div>
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-[1.1]">
                Direct Vehicle Booking in Nepal <br class="hidden sm:inline">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-cyan-300">With Chauffeur or Self-Drive</span>
            </h1>
            <p class="mt-4 text-sm sm:text-base text-slate-300 max-w-2xl mx-auto leading-relaxed">
                Choose between a <strong>Professional Chauffeur (With Driver)</strong> for scenic mountain tours or a <strong>Self-Drive Rental</strong>. Transparent fixed rates in Nepalese Rupees (<strong class="text-white">Rs.</strong>) with zero hidden counter fees.
            </p>

            <!-- Trust Highlights Pill Bar -->
            <div class="mt-6 flex flex-wrap items-center justify-center gap-4 sm:gap-8 text-xs font-bold text-slate-300">
                <div class="flex items-center gap-2">
                    <span class="w-4 h-4 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-[10px]">✓</span>
                    <span>100% Verified Bluebook & Licenses</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-4 h-4 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-[10px]">✓</span>
                    <span>Pay Cash on Pickup or eSewa</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-4 h-4 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-[10px]">✓</span>
                    <span>Instant Digital Voucher</span>
                </div>
            </div>
        </div>

        <!-- Livewire Booking Component -->
        <livewire:direct-vehicle-booking />
    </div>
</div>
@endsection
