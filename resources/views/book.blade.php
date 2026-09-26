@extends('layouts.app')

@section('title', 'Direct Vehicle Booking & Rental in Nepal - Hahakar')
@section('meta_description', 'Book verified vehicles in Nepal directly. Scorpio 4WD, Toyota Hilux, Creta, Swift, and HiAce tourist vans with professional chauffeur or self-drive.')

@section('content')
<div class="relative bg-gradient-to-b from-[#070d1e] via-[#0b1329] to-[#0f172a] text-white py-12 md:py-16 overflow-hidden min-h-screen">
    <!-- Ambient Background Glows -->
    <div class="absolute inset-0 opacity-20 pointer-events-none">
        <div class="absolute -top-40 -right-40 w-[550px] h-[550px] bg-emerald-500 rounded-full blur-[160px]"></div>
        <div class="absolute top-96 -left-40 w-[450px] h-[450px] bg-teal-500 rounded-full blur-[150px]"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Hero Header -->
        <div class="text-center max-w-4xl mx-auto mb-10 sm:mb-12">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-bold uppercase tracking-wider mb-4 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Verified Direct Fleet & Driver Network</span>
            </div>

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight">
                <span class="block">{{ \App\Models\Setting::get('book_page_title_line1', 'Direct Vehicle Booking in Nepal') }}</span>
                <span class="block mt-1 sm:mt-2 text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-cyan-300">{{ \App\Models\Setting::get('book_page_title_line2', 'With Driver or Self-Drive') }}</span>
            </h1>

            <p class="mt-3 text-xs sm:text-sm text-slate-400 max-w-2xl mx-auto leading-relaxed">
                Choose from verified 4WD SUVs, tourist vans, sedans, and EVs across Kathmandu, Pokhara, Chitwan, and all Nepal hubs.
            </p>

            <!-- Trust Highlights Pill Bar -->
            <div class="mt-6 flex flex-wrap items-center justify-center gap-3 sm:gap-4 text-xs font-semibold text-slate-300">
                <div class="flex items-center gap-2 px-3.5 py-2 rounded-2xl bg-slate-900/80 border border-slate-700/80 shadow-sm backdrop-blur-md">
                    <span class="w-4 h-4 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-[10px] font-bold">✓</span>
                    <span>{{ \App\Models\Setting::get('book_trust_pill1', '100% Verified Bluebook & Licenses') }}</span>
                </div>
                <div class="flex items-center gap-2 px-3.5 py-2 rounded-2xl bg-slate-900/80 border border-slate-700/80 shadow-sm backdrop-blur-md">
                    <span class="w-4 h-4 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-[10px] font-bold">✓</span>
                    <span>{{ \App\Models\Setting::get('book_trust_pill2', 'Pay Cash on Pickup or eSewa') }}</span>
                </div>
                <div class="flex items-center gap-2 px-3.5 py-2 rounded-2xl bg-slate-900/80 border border-slate-700/80 shadow-sm backdrop-blur-md">
                    <span class="w-4 h-4 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-[10px] font-bold">✓</span>
                    <span>{{ \App\Models\Setting::get('book_trust_pill3', 'Instant Digital Voucher') }}</span>
                </div>
            </div>
        </div>

        <!-- Livewire Booking Component -->
        <livewire:direct-vehicle-booking />
    </div>
</div>
@endsection
