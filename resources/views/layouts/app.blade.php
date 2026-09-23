<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50 antialiased selection:bg-emerald-500 selection:text-white">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Hahacar - Nepal\'s #1 Car Rental & Mobility Platform')</title>
    <meta name="description" content="@yield('meta_description', 'Compare car rental rates & book verified vehicles across Kathmandu, Pokhara, Chitwan, Lumbini, and all of Nepal. Scorpio 4WD, Hilux, Swift, and HiAce tourist vans with transparent NPR pricing.')">

    <!-- Premium Typography: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        body { font-family: 'Plus Jakarta Sans', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
    </style>
</head>
<body class="min-h-full flex flex-col font-sans text-slate-800 bg-[#f8fafc]">
    <!-- Top Nepal Support & Live Status Bar -->
    <div class="bg-[#070d1e] text-slate-300 text-xs border-b border-white/5 py-2 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-3 text-[11px] sm:text-xs">
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-1.5 font-bold text-emerald-400">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    🇳🇵 Nepal Mobility Network
                </span>
                <span class="hidden md:inline text-slate-600">•</span>
                <span class="hidden md:inline text-slate-400">Kathmandu • Pokhara • Chitwan • Lumbini • Biratnagar</span>
            </div>
            <div class="flex items-center gap-4 text-slate-400">
                <a href="tel:+9779801424222" class="hover:text-emerald-400 transition flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <span class="font-bold text-slate-200">+977 9801-HAHACAR</span> (24/7 Roadside)
                </a>
                <span class="text-slate-600">•</span>
                <a wire:navigate href="{{ route('partner.register') }}" class="text-emerald-400 hover:text-emerald-300 font-bold transition flex items-center gap-1">
                    <span>Drive & Earn</span>
                    <span>→</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Navbar with Glassmorphism & Responsive Mobile Menu -->
    <header x-data="{ mobileMenuOpen: false }" @click.away="mobileMenuOpen = false" class="bg-white/95 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-40 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                <!-- Brand Logo -->
                <div class="flex items-center gap-6 lg:gap-10">
                    <a wire:navigate href="{{ route('home') }}" class="flex items-center gap-2.5 sm:gap-3 group">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center font-black text-xl shadow-md shadow-emerald-600/25 group-hover:scale-105 group-hover:shadow-emerald-600/40 transition duration-200 shrink-0">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.85 7h10.29l1.04 3H5.81l1.04-3zM19 17H5v-4.66l.12-.34h13.77l.11.34V17z"/><circle cx="7.5" cy="14.5" r="1.5"/><circle cx="16.5" cy="14.5" r="1.5"/></svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xl sm:text-2xl font-black tracking-tight text-slate-900 leading-none">
                                Haha<span class="text-emerald-600">car</span><span class="text-xs text-emerald-500 font-bold ml-1">.np</span>
                            </span>
                            <span class="text-[9px] font-bold text-slate-400 tracking-wider uppercase mt-1">
                                Nepal Mobility Platform
                            </span>
                        </div>
                    </a>

                    <!-- Desktop Navigation Links -->
                    <nav class="hidden md:flex items-center gap-5 lg:gap-6 text-sm font-semibold text-slate-600">
                        <a wire:navigate href="{{ route('book.index') }}" class="text-emerald-700 hover:text-emerald-600 transition flex items-center gap-1.5 font-bold">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Book Vehicle
                            <span class="px-2 py-0.5 text-[10px] uppercase font-bold rounded-full bg-emerald-500/20 text-emerald-700">Direct</span>
                        </a>
                        <a wire:navigate href="{{ route('home') }}" class="hover:text-emerald-600 transition flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            Compare Rates
                        </a>
                        <a wire:navigate href="{{ route('partner.register') }}" class="hover:text-emerald-600 transition flex items-center gap-1">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                            List Your Car
                        </a>
                        <a wire:navigate href="{{ route('partner.dashboard') }}" class="hover:text-emerald-600 transition">Partner Portal</a>
                        <a wire:navigate href="{{ route('contact.index') }}" class="hover:text-emerald-600 transition">Contact</a>
                    </nav>
                </div>

                <!-- Right Side Actions & Mobile Hamburger -->
                <div class="flex items-center gap-2 sm:gap-4">
                    <!-- Direct Book Button (Desktop & Mobile) -->
                    <a wire:navigate href="{{ route('book.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 sm:px-4 sm:py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-bold text-xs sm:text-sm shadow-md shadow-emerald-600/20 hover:shadow-emerald-600/30 hover:scale-105 transition duration-200">
                        <svg class="w-4 h-4 text-emerald-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Book Car</span>
                    </a>

                    <!-- Mobile Hamburger Button -->
                    <button
                        type="button"
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        aria-label="Toggle Navigation Menu"
                        class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 hover:text-slate-900 border border-slate-200 transition focus:outline-none focus:ring-2 focus:ring-emerald-500 active:scale-95"
                    >
                        <!-- Hamburger Icon (when closed) -->
                        <svg x-show="!mobileMenuOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <!-- Close Icon (when open) -->
                        <svg x-show="mobileMenuOpen" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Drawer Navigation (Collapsible) -->
        <div
            x-show="mobileMenuOpen"
            x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="md:hidden bg-white/98 backdrop-blur-xl border-b border-slate-200 shadow-xl px-4 pt-3 pb-6 space-y-3"
        >
            <div class="space-y-1">
                <a
                    wire:navigate
                    href="{{ route('book.index') }}"
                    @click="mobileMenuOpen = false"
                    class="flex items-center justify-between p-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 font-bold text-sm transition"
                >
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <div class="text-sm font-black text-emerald-950">Direct Vehicle Booking</div>
                            <div class="text-[11px] font-normal text-emerald-700">Chauffeur & Self-Drive across Nepal</div>
                        </div>
                    </div>
                    <span class="px-2 py-0.5 rounded-full bg-emerald-200 text-emerald-900 text-[10px] uppercase font-black">Direct</span>
                </a>

                <a
                    wire:navigate
                    href="{{ route('home') }}"
                    @click="mobileMenuOpen = false"
                    class="flex items-center gap-3 p-3 rounded-2xl hover:bg-slate-100 text-slate-800 font-semibold text-sm transition"
                >
                    <div class="w-8 h-8 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-slate-900">Compare Rental Rates</div>
                        <div class="text-[11px] font-normal text-slate-500">Scan Nepal's operators for best prices</div>
                    </div>
                </a>

                <a
                    wire:navigate
                    href="{{ route('partner.register') }}"
                    @click="mobileMenuOpen = false"
                    class="flex items-center justify-between p-3 rounded-2xl hover:bg-slate-100 text-slate-800 font-semibold text-sm transition"
                >
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-slate-100 text-emerald-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-slate-900">List Your Car / Drive</div>
                            <div class="text-[11px] font-normal text-slate-500">Register Scorpio, HiAce, Swift & earn</div>
                        </div>
                    </div>
                    <span class="text-[10px] text-emerald-700 font-extrabold uppercase bg-emerald-100 px-2 py-0.5 rounded-full">Partner</span>
                </a>

                <a
                    wire:navigate
                    href="{{ route('partner.dashboard') }}"
                    @click="mobileMenuOpen = false"
                    class="flex items-center gap-3 p-3 rounded-2xl hover:bg-slate-100 text-slate-800 font-semibold text-sm transition"
                >
                    <div class="w-8 h-8 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-slate-900">Partner Driver Portal</div>
                        <div class="text-[11px] font-normal text-slate-500">Driver login & booking management</div>
                    </div>
                </a>

                <a
                    wire:navigate
                    href="{{ route('pages.show', 'how-it-works') }}"
                    @click="mobileMenuOpen = false"
                    class="flex items-center gap-3 p-3 rounded-2xl hover:bg-slate-100 text-slate-800 font-semibold text-sm transition"
                >
                    <div class="w-8 h-8 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="text-sm font-bold text-slate-900">How It Works</div>
                </a>

                <a
                    wire:navigate
                    href="{{ route('faq.index') }}"
                    @click="mobileMenuOpen = false"
                    class="flex items-center gap-3 p-3 rounded-2xl hover:bg-slate-100 text-slate-800 font-semibold text-sm transition"
                >
                    <div class="w-8 h-8 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="text-sm font-bold text-slate-900">FAQs & Support</div>
                </a>

                <a
                    wire:navigate
                    href="{{ route('contact.index') }}"
                    @click="mobileMenuOpen = false"
                    class="flex items-center gap-3 p-3 rounded-2xl hover:bg-slate-100 text-slate-800 font-semibold text-sm transition"
                >
                    <div class="w-8 h-8 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <div class="text-sm font-bold text-slate-900">Contact Care</div>
                </a>
            </div>

            <!-- Footer of Mobile Drawer -->
            <div class="pt-3 border-t border-slate-200/80 flex items-center justify-between text-xs font-semibold text-slate-600 px-2">
                <div class="flex items-center gap-1.5">
                    <span>🇳🇵</span>
                    <span>Nepal (NPR - Rs.)</span>
                </div>
                <a href="{{ url('/admin') }}" class="text-emerald-700 hover:underline font-bold flex items-center gap-1">
                    <span>Admin Portal</span>
                    <span>→</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-[#0b1329] text-slate-400 text-sm border-t border-slate-800/80 mt-20 relative overflow-hidden">
        <!-- Subtle Top Glow -->
        <div class="absolute top-0 inset-x-0 h-px bg-gradient-to-r from-transparent via-emerald-500/50 to-transparent"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 lg:gap-12 pb-12 border-b border-slate-800/70">
                <!-- Brand & Mission -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center font-bold shadow-md shadow-emerald-500/20">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.85 7h10.29l1.04 3H5.81l1.04-3zM19 17H5v-4.66l.12-.34h13.77l.11.34V17z"/><circle cx="7.5" cy="14.5" r="1.5"/><circle cx="16.5" cy="14.5" r="1.5"/></svg>
                        </div>
                        <span class="text-xl font-black text-white tracking-tight">Haha<span class="text-emerald-400">car</span><span class="text-xs text-emerald-500 font-bold ml-0.5">.np</span></span>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Hahacar is Nepal's dedicated car rental metasearch & direct booking engine. We compare live rates and provide verified vehicles (Mahindra Scorpio 4WD, Toyota Hilux, HiAce vans, and city cars) across Kathmandu, Pokhara, Chitwan, Lumbini, and Mustang.
                    </p>
                    <div class="flex items-center gap-3 text-xs text-slate-400">
                        <span class="inline-flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> 100% Nepali Fleet</span>
                        <span>•</span>
                        <span>Kathmandu, Nepal</span>
                    </div>
                </div>

                <!-- Popular Rental Hubs & Direct Fleet -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-200 mb-4 flex items-center gap-1.5">
                        <span class="text-emerald-400">🚗</span> Fleet & Booking
                    </h4>
                    <ul class="space-y-2.5 text-xs">
                        <li><a wire:navigate href="{{ route('book.index') }}" class="text-emerald-400 font-bold hover:underline">Direct Vehicle Booking</a></li>
                        <li><a wire:navigate href="{{ route('partner.register') }}" class="hover:text-emerald-400 transition">List Your Vehicle / Drive</a></li>
                        <li><a wire:navigate href="{{ route('partner.dashboard') }}" class="hover:text-emerald-400 transition">Partner Driver Portal</a></li>
                        <li><a wire:navigate href="{{ route('search.index') }}" class="hover:text-emerald-400 transition">Metasearch Comparison</a></li>
                        <li><a wire:navigate href="{{ route('search.index', ['pickup' => 1]) }}" class="hover:text-emerald-400 transition">Tribhuvan Airport (KTM)</a></li>
                        <li><a wire:navigate href="{{ route('search.index', ['pickup' => 4]) }}" class="hover:text-emerald-400 transition">Pokhara Lakeside (PKR)</a></li>
                    </ul>
                </div>

                <!-- Trust & Legal -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-200 mb-4 flex items-center gap-1.5">
                        <span class="text-emerald-400">🛡️</span> Transparency & Trust
                    </h4>
                    <ul class="space-y-2.5 text-xs">
                        <li><a wire:navigate href="{{ route('pages.show', 'how-it-works') }}" class="hover:text-emerald-400 transition">How Platform Works</a></li>
                        <li><a wire:navigate href="{{ route('pages.show', 'terms') }}" class="hover:text-emerald-400 transition">Terms & Conditions</a></li>
                        <li><a wire:navigate href="{{ route('pages.show', 'privacy') }}" class="hover:text-emerald-400 transition">Privacy & Data Rights</a></li>
                        <li><a wire:navigate href="{{ route('pages.show', 'affiliate-disclosure') }}" class="hover:text-emerald-400 transition">Partner & Operator Disclosure</a></li>
                        <li><a wire:navigate href="{{ route('contact.index') }}" class="hover:text-emerald-400 transition">Support & Roadside Desk</a></li>
                    </ul>
                </div>

                <!-- Price Drop Alerts & Payment Badges -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-200 mb-4 flex items-center gap-1.5">
                        <span class="text-emerald-400">🔔</span> Nepal Travel Alerts
                    </h4>
                    <p class="text-xs text-slate-400 leading-relaxed mb-4">
                        Subscribe for seasonal Nepal holiday deals, trekking route vehicle discounts, and flash sales.
                    </p>
                    <livewire:newsletter-form />

                    <div class="mt-5 pt-4 border-t border-slate-800">
                        <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2">Accepted Nepal Payment Methods</span>
                        <div class="flex flex-wrap items-center gap-2 text-[11px] font-semibold text-slate-300">
                            <span class="px-2 py-1 rounded bg-slate-900 border border-slate-700 text-emerald-400 font-bold">eSewa</span>
                            <span class="px-2 py-1 rounded bg-slate-900 border border-slate-700 text-purple-400 font-bold">Khalti</span>
                            <span class="px-2 py-1 rounded bg-slate-900 border border-slate-700 text-blue-400 font-bold">Fonepay</span>
                            <span class="px-2 py-1 rounded bg-slate-900 border border-slate-700 text-slate-300">Cash on Pickup</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Merchant of Record & Safety Badges -->
            <div class="pt-8 flex flex-col md:flex-row items-center justify-between gap-4 text-[11px] text-slate-500">
                <p class="max-w-2xl text-center md:text-left leading-relaxed">
                    <strong class="text-slate-400">Nepal Mobility Network:</strong> Hahacar Nepal provides direct booking for verified fleet partners and rate comparison across operators. All bookings feature transparent pricing in Nepalese Rupees (NPR) with zero hidden counter fees.
                </p>
                <div class="text-center md:text-right shrink-0">
                    © {{ date('Y') }} Hahacar Nepal. All rights reserved.
                </div>
            </div>
        </div>
    </footer>

    <!-- Cookie Consent Banner -->
    <livewire:cookie-consent />

    @livewireScripts
</body>
</html>
