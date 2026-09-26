<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50 antialiased selection:bg-emerald-500 selection:text-white">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $siteName = \App\Models\Setting::get('site_name', 'Hahakar Nepal');
        $siteLogo = \App\Models\Setting::getLogoUrl();
        $siteFavicon = \App\Models\Setting::getFaviconUrl();
        $defaultTitle = \App\Models\Setting::get('seo_meta_title', 'Hahakar - Nepal\'s #1 Car Rental Comparison & Direct Booking');
        $defaultDescription = \App\Models\Setting::get('seo_meta_description', 'Compare car rental prices & book verified vehicles across Kathmandu, Pokhara, Chitwan, Lumbini, and all of Nepal. Scorpio 4WD, Toyota Hilux, Creta, Swift, and HiAce tourist vans with transparent NPR rates.');
        $metaKeywords = \App\Models\Setting::get('seo_meta_keywords', 'car rental nepal, scorpio rental kathmandu, self drive car pokhara, hiace rental nepal, rent a car nepal, cheap car hire kathmandu');
        $robotsDirective = \App\Models\Setting::get('seo_robots', 'index, follow, max-image-preview:large');
        $themeColor = \App\Models\Setting::get('seo_theme_color', '#070d1e');
        $ogLocale = \App\Models\Setting::get('seo_og_locale', 'en_NP');
        $twitterCard = \App\Models\Setting::get('seo_twitter_card', 'summary_large_image');
        $defaultOgImage = \App\Models\Setting::get('seo_og_image', '/images/vehicles/scorpio.jpg');

        $rawTitle = trim($__env->yieldContent('title', ''));
        $pageTitle = html_entity_decode($rawTitle !== '' ? $rawTitle : $defaultTitle, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $rawDescription = trim($__env->yieldContent('meta_description', ''));
        $pageDescription = html_entity_decode($rawDescription !== '' ? $rawDescription : $defaultDescription, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $pageCanonical = trim($__env->yieldContent('canonical', url()->current()));
        $pageOgType = trim($__env->yieldContent('og_type', 'website'));
        $rawOgImage = trim($__env->yieldContent('og_image', $defaultOgImage));
        $pageOgImage = str_starts_with($rawOgImage, 'http') ? $rawOgImage : url($rawOgImage);
    @endphp

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">
    <meta name="keywords" content="{{ $metaKeywords }}">
    <meta name="robots" content="{{ $robotsDirective }}">
    <meta name="theme-color" content="{{ $themeColor }}">
    <link rel="canonical" href="{{ $pageCanonical }}">

    <!-- Favicons & Icons -->
    <link rel="icon" href="{{ $siteFavicon }}">
    <link rel="apple-touch-icon" href="{{ $siteFavicon }}">

    <!-- Open Graph (Facebook, WhatsApp, LinkedIn) -->
    <meta property="og:type" content="{{ $pageOgType }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:url" content="{{ $pageCanonical }}">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:locale" content="{{ $ogLocale }}">
    <meta property="og:image" content="{{ $pageOgImage }}">
    <meta property="og:image:alt" content="{{ $pageTitle }}">

    <!-- Twitter Card Meta -->
    <meta name="twitter:card" content="{{ $twitterCard }}">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDescription }}">
    <meta name="twitter:url" content="{{ $pageCanonical }}">
    <meta name="twitter:image" content="{{ $pageOgImage }}">
    <meta name="twitter:image:alt" content="{{ $pageTitle }}">

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
<body class="min-h-full flex flex-col font-sans text-slate-100 bg-[#070d1e]">
    <!-- Navbar with Glassmorphism & Responsive Mobile Menu -->
    <header x-data="{ mobileMenuOpen: false }" @click.away="mobileMenuOpen = false" class="bg-white/95 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-40 transition-all shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 sm:h-24 py-2">
                <!-- Brand Logo -->
                <div class="flex items-center gap-6 lg:gap-10">
                    <a wire:navigate href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                        <img src="{{ $siteLogo }}" alt="{{ $siteName }}" class="h-14 sm:h-18 lg:h-20 w-auto object-contain group-hover:scale-105 transition-transform duration-200">
                    </a>

                    <!-- Desktop Navigation Links -->
                    <nav class="hidden md:flex items-center gap-5 lg:gap-6 text-sm font-semibold text-slate-700">
                        <a wire:navigate href="{{ route('home') }}" class="hover:text-emerald-600 transition font-bold text-slate-900">
                            Home
                        </a>
                        @if (\App\Models\Setting::get('header_show_book_vehicle', true))
                            <a wire:navigate href="{{ route('book.index') }}" class="hover:text-emerald-600 transition font-semibold text-slate-700">
                                Book a Vehicle
                            </a>
                        @endif
                        @if (\App\Models\Setting::get('header_show_compare_rates', true))
                            <a wire:navigate href="{{ route('search.index') }}" class="hover:text-emerald-600 transition">
                                Compare Rates
                            </a>
                        @endif
                        @if (\App\Models\Setting::get('header_show_list_car', true))
                            <a wire:navigate href="{{ route('partner.register') }}" class="hover:text-emerald-600 transition">
                                List Your Car
                            </a>
                        @endif
                        @if (\App\Models\Setting::get('header_show_partner_portal', true))
                            <a wire:navigate href="{{ route('partner.dashboard') }}" class="hover:text-emerald-600 transition">Partner Portal</a>
                        @endif
                        @if (\App\Models\Setting::get('header_show_contact', true))
                            <a wire:navigate href="{{ route('contact.index') }}" class="hover:text-emerald-600 transition">Contact</a>
                        @endif
                    </nav>
                </div>

                <!-- Right Side Actions & Mobile Hamburger -->
                <div class="flex items-center gap-2 sm:gap-3">
                    @auth
                        @if (Auth::user()->isPartner())
                            <a wire:navigate href="{{ route('partner.dashboard') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 sm:px-4 sm:py-2.5 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 text-amber-900 border border-amber-300 font-bold text-xs sm:text-sm transition">
                                <span>🚘</span>
                                <span>Driver Portal</span>
                            </a>
                        @else
                            <a wire:navigate href="{{ route('customer.dashboard') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 sm:px-4 sm:py-2.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 font-bold text-xs sm:text-sm transition">
                                <span>👤</span>
                                <span>My Dashboard</span>
                            </a>
                        @endif
                        <a href="{{ route('customer.logout') }}" class="inline-flex items-center px-3 py-2 rounded-xl text-xs sm:text-sm font-bold text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition">
                            Log Out
                        </a>
                    @else
                        <!-- Login -->
                        <a wire:navigate href="{{ route('customer.login') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 sm:px-4 sm:py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs sm:text-sm border border-slate-200 transition duration-150 shadow-sm">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span>{{ \App\Models\Setting::get('header_cta_login_text', 'Login') }}</span>
                        </a>

                        <!-- Register -->
                        <a wire:navigate href="{{ route('customer.register') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 sm:px-4 sm:py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-bold text-xs sm:text-sm shadow-md shadow-emerald-600/20 hover:shadow-emerald-600/30 hover:scale-105 transition duration-200">
                            <svg class="w-4 h-4 text-emerald-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                            <span>{{ \App\Models\Setting::get('header_cta_register_text', 'Register') }}</span>
                        </a>
                    @endauth

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
                    href="{{ route('home') }}"
                    @click="mobileMenuOpen = false"
                    class="flex items-center gap-3 p-3 rounded-2xl bg-emerald-50/80 border border-emerald-200/80 text-emerald-900 font-bold text-sm transition"
                >
                    <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    </div>
                    <div>
                        <div class="text-sm font-black text-emerald-950">Home</div>
                        <div class="text-[11px] font-normal text-emerald-700">Explore car rentals across Nepal</div>
                    </div>
                </a>

                @if (\App\Models\Setting::get('header_show_book_vehicle', true))
                <a
                    wire:navigate
                    href="{{ route('book.index') }}"
                    @click="mobileMenuOpen = false"
                    class="flex items-center gap-3 p-3 rounded-2xl hover:bg-slate-100 text-slate-800 font-semibold text-sm transition"
                >
                    <div class="w-8 h-8 rounded-xl bg-slate-100 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-slate-900">Book a Vehicle</div>
                        <div class="text-[11px] font-normal text-slate-500">Chauffeur & Self-Drive across Nepal</div>
                    </div>
                </a>
                @endif

                @if (\App\Models\Setting::get('header_show_compare_rates', true))
                <a
                    wire:navigate
                    href="{{ route('search.index') }}"
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
                @endif

                @if (\App\Models\Setting::get('header_show_list_car', true))
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
                @endif

                @auth
                    @if (Auth::user()->isPartner())
                        <a
                            wire:navigate
                            href="{{ route('partner.dashboard') }}"
                            @click="mobileMenuOpen = false"
                            class="flex items-center justify-between p-3 rounded-2xl bg-amber-50 border border-amber-200 text-amber-950 font-semibold text-sm transition"
                        >
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center shrink-0">
                                    <span>🚘</span>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-slate-900">Partner Dashboard</div>
                                    <div class="text-[11px] font-normal text-slate-600">Manage cars, trips & earnings</div>
                                </div>
                            </div>
                            <span class="text-[10px] text-amber-800 font-extrabold uppercase bg-amber-200 px-2 py-0.5 rounded-full">Driver</span>
                        </a>
                    @else
                        <a
                            wire:navigate
                            href="{{ route('customer.dashboard') }}"
                            @click="mobileMenuOpen = false"
                            class="flex items-center justify-between p-3 rounded-2xl bg-emerald-50/80 border border-emerald-200 text-emerald-950 font-semibold text-sm transition"
                        >
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0">
                                    <span>👤</span>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-slate-900">My Customer Dashboard</div>
                                    <div class="text-[11px] font-normal text-slate-600">Track bookings & manage profile</div>
                                </div>
                            </div>
                            <span class="text-[10px] text-emerald-800 font-extrabold uppercase bg-emerald-200 px-2 py-0.5 rounded-full">Active</span>
                        </a>
                    @endif
                    <a
                        href="{{ route('customer.logout') }}"
                        class="flex items-center gap-3 p-3 rounded-2xl hover:bg-rose-50 text-rose-600 font-semibold text-sm transition"
                    >
                        <div class="w-8 h-8 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </div>
                        <div class="text-sm font-bold text-rose-600">Log Out ({{ Auth::user()->name }})</div>
                    </a>
                @else
                    <div class="grid grid-cols-2 gap-2 pt-1">
                        <a
                            wire:navigate
                            href="{{ route('customer.login') }}"
                            @click="mobileMenuOpen = false"
                            class="flex items-center justify-center gap-1.5 py-2.5 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs transition border border-slate-200"
                        >
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span>{{ \App\Models\Setting::get('header_cta_login_text', 'Login') }}</span>
                        </a>
                        <a
                            wire:navigate
                            href="{{ route('customer.register') }}"
                            @click="mobileMenuOpen = false"
                            class="flex items-center justify-center gap-1.5 py-2.5 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs transition shadow-sm shadow-emerald-600/20"
                        >
                            <span>{{ \App\Models\Setting::get('header_cta_register_text', 'Sign Up Free') }}</span>
                        </a>
                    </div>
                    @if (\App\Models\Setting::get('header_show_partner_portal', true))
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
                    @endif
                @endauth

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

                @if (\App\Models\Setting::get('header_show_contact', true))
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
                @endif
            </div>

            <!-- Footer of Mobile Drawer -->
            <div class="pt-3 border-t border-slate-200/80 flex items-center justify-between text-xs font-semibold text-slate-600 px-2">
                <div class="flex items-center gap-1.5">
                    <span>🇳🇵</span>
                    <span>Nepal (NPR - Rs.)</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-[#070d1e] text-slate-400 text-sm border-t border-slate-800/80 relative overflow-hidden">
        <!-- Subtle Top Glow & Ambient Gradient Mesh -->
        <div class="absolute top-0 inset-x-0 h-px bg-gradient-to-r from-transparent via-emerald-500/60 to-transparent"></div>
        <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-3/4 h-80 bg-emerald-500/5 blur-[120px] rounded-full pointer-events-none"></div>

        <!-- Pre-Footer: Trust & Value Pillars -->
        <div class="border-b border-slate-800/80 bg-slate-950/40 relative z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-10">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Pillar 1 -->
                    <div class="flex items-start gap-3.5 p-4 rounded-2xl bg-slate-900/50 border border-slate-800/80 hover:border-emerald-500/30 hover:bg-slate-900/80 transition group">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center shrink-0 group-hover:scale-110 group-hover:bg-emerald-500/20 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-100 uppercase tracking-wider">Verified Fleet</h4>
                            <p class="text-xs text-slate-400 mt-1 leading-relaxed">Scorpio 4WDs, HiAce vans & city cars inspected for Nepal's roads.</p>
                        </div>
                    </div>

                    <!-- Pillar 2 -->
                    <div class="flex items-start gap-3.5 p-4 rounded-2xl bg-slate-900/50 border border-slate-800/80 hover:border-emerald-500/30 hover:bg-slate-900/80 transition group">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center shrink-0 group-hover:scale-110 group-hover:bg-emerald-500/20 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-100 uppercase tracking-wider">Transparent Rates</h4>
                            <p class="text-xs text-slate-400 mt-1 leading-relaxed">Live price comparison in NPR with guaranteed zero hidden surcharges.</p>
                        </div>
                    </div>

                    <!-- Pillar 3 -->
                    <div class="flex items-start gap-3.5 p-4 rounded-2xl bg-slate-900/50 border border-slate-800/80 hover:border-emerald-500/30 hover:bg-slate-900/80 transition group">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center shrink-0 group-hover:scale-110 group-hover:bg-emerald-500/20 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-100 uppercase tracking-wider">Nationwide Hubs</h4>
                            <p class="text-xs text-slate-400 mt-1 leading-relaxed">Serving Kathmandu Airport (TIA), Pokhara, Chitwan, Lumbini & Mustang.</p>
                        </div>
                    </div>

                    <!-- Pillar 4 -->
                    <div class="flex items-start gap-3.5 p-4 rounded-2xl bg-slate-900/50 border border-slate-800/80 hover:border-emerald-500/30 hover:bg-slate-900/80 transition group">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center shrink-0 group-hover:scale-110 group-hover:bg-emerald-500/20 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-100 uppercase tracking-wider">24/7 Roadside Support</h4>
                            <p class="text-xs text-slate-400 mt-1 leading-relaxed">Dedicated WhatsApp desk & rapid trip coordination across Nepal.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Footer Navigation Grid -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-14 pb-12 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-8 pb-12 border-b border-slate-800/80">
                
                <!-- Col 1: Brand, Mission & Social Links (3 cols) -->
                <div class="lg:col-span-3 space-y-4">
                    <div class="flex items-center">
                        <a wire:navigate href="{{ route('home') }}" class="group inline-flex items-center bg-white/95 hover:bg-white px-3.5 py-1.5 rounded-2xl border border-white/20 shadow-md shadow-emerald-950/20 transition-transform duration-200 hover:scale-[1.02]">
                            <img src="{{ $siteLogo }}" alt="{{ $siteName }}" class="h-9 sm:h-11 w-auto object-contain">
                        </a>
                    </div>
                    
                    <p class="text-xs text-slate-400 leading-relaxed">
                        {{ \App\Models\Setting::get('footer_about_text', "Hahakar is Nepal's dedicated car rental metasearch & direct booking engine. We compare live rates and provide verified vehicles (Mahindra Scorpio 4WD, Toyota Hilux, HiAce vans, and city cars) across Kathmandu, Pokhara, Chitwan, Lumbini, and Mustang.") }}
                    </p>

                    <!-- Social Media Links -->
                    <div class="pt-1">
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2.5">Connect With Us</p>
                        <div class="flex items-center gap-2 flex-wrap">
                            @if ($fb = \App\Models\Setting::get('social_facebook', 'https://facebook.com/hahakarnepal'))
                                <a href="{{ $fb }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-xl bg-slate-900 border border-slate-800 hover:border-blue-500/50 hover:bg-[#1877F2] text-slate-400 hover:text-white flex items-center justify-center transition-all duration-200 hover:-translate-y-0.5 shadow-sm" title="Facebook">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </a>
                            @endif
                            @if ($insta = \App\Models\Setting::get('social_instagram', 'https://instagram.com/hahakarnepal'))
                                <a href="{{ $insta }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-xl bg-slate-900 border border-slate-800 hover:border-pink-500/50 hover:bg-gradient-to-tr hover:from-amber-500 hover:via-pink-500 hover:to-purple-600 text-slate-400 hover:text-white flex items-center justify-center transition-all duration-200 hover:-translate-y-0.5 shadow-sm" title="Instagram">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </a>
                            @endif
                            @if ($wa = \App\Models\Setting::get('social_whatsapp', 'https://wa.me/9779801424252'))
                                <a href="{{ $wa }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-xl bg-slate-900 border border-slate-800 hover:border-emerald-500/50 hover:bg-[#25D366] text-slate-400 hover:text-white flex items-center justify-center transition-all duration-200 hover:-translate-y-0.5 shadow-sm" title="WhatsApp">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.316 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.818-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                </a>
                            @endif
                            @if ($tt = \App\Models\Setting::get('social_tiktok', 'https://tiktok.com/@hahakarnepal'))
                                <a href="{{ $tt }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-xl bg-slate-900 border border-slate-800 hover:border-slate-500/50 hover:bg-black text-slate-400 hover:text-white flex items-center justify-center transition-all duration-200 hover:-translate-y-0.5 shadow-sm" title="TikTok">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.97v7.69c-.04 2.21-.92 4.39-2.52 5.9-1.64 1.55-3.95 2.37-6.23 2.23-2.28-.14-4.44-1.24-5.87-3.02-1.43-1.79-1.99-4.17-1.55-6.42.44-2.25 1.87-4.19 3.86-5.23 1.99-1.04 4.38-1.08 6.4-.11v4.13c-1.12-.51-2.42-.53-3.55-.07-1.13.46-1.99 1.48-2.3 2.69-.31 1.22-.04 2.53.72 3.51.76.99 1.98 1.55 3.23 1.5 1.25-.05 2.41-.72 3.08-1.78.68-1.05.85-2.38.83-3.62V.02z"/></svg>
                                </a>
                            @endif
                            @if ($yt = \App\Models\Setting::get('social_youtube'))
                                <a href="{{ $yt }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-xl bg-slate-900 border border-slate-800 hover:border-red-500/50 hover:bg-[#FF0000] text-slate-400 hover:text-white flex items-center justify-center transition-all duration-200 hover:-translate-y-0.5 shadow-sm" title="YouTube">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                </a>
                            @endif
                            @if ($li = \App\Models\Setting::get('social_linkedin'))
                                <a href="{{ $li }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-xl bg-slate-900 border border-slate-800 hover:border-blue-600/50 hover:bg-[#0A66C2] text-slate-400 hover:text-white flex items-center justify-center transition-all duration-200 hover:-translate-y-0.5 shadow-sm" title="LinkedIn">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Col 2: Fleet & Rentals (2 cols) -->
                <div class="lg:col-span-2">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-200 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        Fleet & Booking
                    </h4>
                    <ul class="space-y-2.5 text-xs">
                        <li>
                            <a wire:navigate href="{{ route('book.index') }}" class="group flex items-center gap-1.5 text-emerald-400 font-bold hover:text-emerald-300 transition">
                                <span class="group-hover:translate-x-1 transition-transform">Direct Booking</span>
                                <span class="text-[10px] px-1.5 py-0.5 rounded bg-emerald-500/20 text-emerald-300 font-bold">Instant</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate href="{{ route('search.index') }}" class="group flex items-center gap-1.5 hover:text-emerald-400 hover:translate-x-1 transition duration-150">
                                <svg class="w-3 h-3 text-slate-500 group-hover:text-emerald-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                <span>Compare Live Rates</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate href="{{ route('book.index') }}" class="group flex items-center gap-1.5 hover:text-emerald-400 hover:translate-x-1 transition duration-150">
                                <svg class="w-3 h-3 text-slate-500 group-hover:text-emerald-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                <span>Mahindra Scorpio 4WD</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate href="{{ route('book.index') }}" class="group flex items-center gap-1.5 hover:text-emerald-400 hover:translate-x-1 transition duration-150">
                                <svg class="w-3 h-3 text-slate-500 group-hover:text-emerald-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                <span>Toyota HiAce Vans</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate href="{{ route('book.index') }}" class="group flex items-center gap-1.5 hover:text-emerald-400 hover:translate-x-1 transition duration-150">
                                <svg class="w-3 h-3 text-slate-500 group-hover:text-emerald-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                <span>Electric & City Cars</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate href="{{ route('partner.register') }}" class="group flex items-center gap-1.5 hover:text-emerald-400 hover:translate-x-1 transition duration-150">
                                <svg class="w-3 h-3 text-slate-500 group-hover:text-emerald-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                <span>List Your Vehicle</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Col 3: Hubs & Routes (2 cols) -->
                <div class="lg:col-span-2">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-200 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        Hubs & Routes
                    </h4>
                    <ul class="space-y-2.5 text-xs">
                        <li>
                            <a wire:navigate href="{{ route('search.index', ['pickup' => 1]) }}" class="group flex items-center gap-1.5 hover:text-emerald-400 hover:translate-x-1 transition duration-150">
                                <svg class="w-3 h-3 text-slate-500 group-hover:text-emerald-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                <span>Kathmandu Airport (TIA)</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate href="{{ route('search.index', ['pickup' => 4]) }}" class="group flex items-center gap-1.5 hover:text-emerald-400 hover:translate-x-1 transition duration-150">
                                <svg class="w-3 h-3 text-slate-500 group-hover:text-emerald-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                <span>Pokhara Lakeside Hub</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate href="{{ route('search.index') }}" class="group flex items-center gap-1.5 hover:text-emerald-400 hover:translate-x-1 transition duration-150">
                                <svg class="w-3 h-3 text-slate-500 group-hover:text-emerald-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                <span>Chitwan Sauraha Safari</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate href="{{ route('search.index') }}" class="group flex items-center gap-1.5 hover:text-emerald-400 hover:translate-x-1 transition duration-150">
                                <svg class="w-3 h-3 text-slate-500 group-hover:text-emerald-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                <span>Lumbini Pilgrimage</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate href="{{ route('search.index') }}" class="group flex items-center gap-1.5 hover:text-emerald-400 hover:translate-x-1 transition duration-150">
                                <svg class="w-3 h-3 text-slate-500 group-hover:text-emerald-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                <span>Muktinath & Mustang 4WD</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate href="{{ route('partner.dashboard') }}" class="group flex items-center gap-1.5 hover:text-emerald-400 hover:translate-x-1 transition duration-150">
                                <svg class="w-3 h-3 text-slate-500 group-hover:text-emerald-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                <span>Partner Driver Portal</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Col 4: Company & Support (2 cols) -->
                <div class="lg:col-span-2">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-200 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        Company & Care
                    </h4>
                    <ul class="space-y-2.5 text-xs">
                        <li>
                            <a wire:navigate href="{{ route('pages.show', 'about') }}" class="group flex items-center gap-1.5 hover:text-emerald-400 hover:translate-x-1 transition duration-150 font-medium">
                                <svg class="w-3 h-3 text-slate-500 group-hover:text-emerald-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                <span>About Us</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate href="{{ route('faq.index') }}" class="group flex items-center gap-1.5 hover:text-emerald-400 hover:translate-x-1 transition duration-150">
                                <svg class="w-3 h-3 text-slate-500 group-hover:text-emerald-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                <span>Frequently Asked FAQs</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate href="{{ route('pages.show', 'how-it-works') }}" class="group flex items-center gap-1.5 hover:text-emerald-400 hover:translate-x-1 transition duration-150">
                                <svg class="w-3 h-3 text-slate-500 group-hover:text-emerald-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                <span>How Platform Works</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate href="{{ route('contact.index') }}" class="group flex items-center gap-1.5 hover:text-emerald-400 hover:translate-x-1 transition duration-150">
                                <svg class="w-3 h-3 text-slate-500 group-hover:text-emerald-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                <span>Support Desk</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate href="{{ route('pages.show', 'terms') }}" class="group flex items-center gap-1.5 hover:text-emerald-400 hover:translate-x-1 transition duration-150">
                                <svg class="w-3 h-3 text-slate-500 group-hover:text-emerald-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                <span>Terms & Conditions</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate href="{{ route('pages.show', 'privacy') }}" class="group flex items-center gap-1.5 hover:text-emerald-400 hover:translate-x-1 transition duration-150">
                                <svg class="w-3 h-3 text-slate-500 group-hover:text-emerald-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                <span>Privacy & Data Rights</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Col 5: Stay Connected & Newsletter (3 cols) -->
                <div class="lg:col-span-3 space-y-4">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-200 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        {{ \App\Models\Setting::get('footer_newsletter_title', 'Nepal Travel Alerts') }}
                    </h4>
                    
                    <p class="text-xs text-slate-400 leading-relaxed">
                        {{ \App\Models\Setting::get('footer_newsletter_desc', 'Subscribe for Nepal holiday discounts, highway route updates, and flash deals.') }}
                    </p>

                    <!-- Newsletter Form Component -->
                    <div class="pt-1">
                        <livewire:newsletter-form />
                    </div>

                    <div class="flex items-center gap-1.5 text-[11px] text-slate-500 pt-1">
                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <span>No spam. Unsubscribe anytime.</span>
                    </div>
                </div>

            </div>

            <!-- Middle Bar: 24/7 Direct Contact & Accepted Nepal Payment Methods -->
            <div class="py-8 border-b border-slate-800/80 flex flex-col lg:flex-row items-center justify-between gap-6">
                <!-- Direct Support Helpline -->
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 sm:gap-6 text-xs text-slate-300">
                    <span class="text-slate-400 font-semibold uppercase tracking-wider text-[11px]">24/7 Support:</span>
                    
                    @if ($phone = \App\Models\Setting::get('support_phone', '+977 9801212547'))
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}" class="inline-flex items-center gap-1.5 hover:text-emerald-400 transition font-semibold">
                            <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span>{{ $phone }}</span>
                        </a>
                    @endif

                    @if ($email = \App\Models\Setting::get('support_email', 'support@hahakar.com'))
                        <a href="mailto:{{ $email }}" class="inline-flex items-center gap-1.5 hover:text-emerald-400 transition font-semibold">
                            <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>{{ $email }}</span>
                        </a>
                    @endif

                    <div class="hidden sm:inline-flex items-center gap-1.5 text-slate-400">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Kathmandu & Pokhara, Nepal</span>
                    </div>
                </div>

                <!-- Accepted Payment Badges -->
                <div class="flex flex-wrap items-center justify-center gap-2">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mr-1">Accepted Payments:</span>
                    
                    <div class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-900 border border-slate-700/80 text-white font-extrabold text-[11px] shadow-xs">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                        <span class="text-blue-400">Fone</span><span class="text-red-400">pay</span>
                    </div>

                    @if(\App\Models\Setting::get('enable_esewa', true))
                        <div class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-emerald-950/40 border border-emerald-500/40 text-emerald-300 font-extrabold text-[11px] shadow-xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                            <span>eSewa</span>
                        </div>
                    @endif

                    @if(\App\Models\Setting::get('enable_khalti', true))
                        <div class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-purple-950/40 border border-purple-500/40 text-purple-300 font-extrabold text-[11px] shadow-xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-purple-400"></span>
                            <span>Khalti</span>
                        </div>
                    @endif

                    <div class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-900 border border-slate-700/80 text-sky-300 font-bold text-[11px] shadow-xs">
                        <span>connect</span><span class="font-extrabold text-white">IPS</span>
                    </div>

                    @if(\App\Models\Setting::get('enable_cash_on_pickup', true))
                        <div class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-900 border border-slate-700/80 text-slate-300 font-semibold text-[11px] shadow-xs">
                            <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            <span>Cash on Pickup</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Footer Bottom Bar: Copyright, Legal Links & Attribution -->
            <div class="pt-8 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-slate-400">
                <!-- Copyright -->
                <div class="text-center md:text-left font-medium">
                    © {{ date('Y') }} {{ \App\Models\Setting::get('footer_copyright_text', 'Hahakar Nepal. All rights reserved.') }}
                </div>

                <!-- Legal Sub-links -->
                <div class="flex items-center justify-center flex-wrap gap-4 text-[11px] font-medium text-slate-400">
                    <a wire:navigate href="{{ route('pages.show', 'terms') }}" class="hover:text-emerald-400 transition">Terms of Service</a>
                    <span class="text-slate-700">•</span>
                    <a wire:navigate href="{{ route('pages.show', 'privacy') }}" class="hover:text-emerald-400 transition">Privacy Policy</a>
                    <span class="text-slate-700">•</span>
                    <a wire:navigate href="{{ route('pages.show', 'cookies') }}" class="hover:text-emerald-400 transition">Cookie Policy</a>
                    <span class="text-slate-700">•</span>
                    <a wire:navigate href="{{ route('pages.show', 'affiliate-disclosure') }}" class="hover:text-emerald-400 transition">Operator Disclosure</a>
                </div>

                <!-- Attribution -->
                <div class="text-center md:text-right font-medium text-slate-400">
                    <span>Powered by <strong class="text-slate-200 font-bold">{{ \App\Models\Setting::get('footer_powered_by_name', 'Colors Nepal') }}</strong></span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Cookie Consent Banner -->
    <livewire:cookie-consent />

    @livewireScripts
</body>
</html>
