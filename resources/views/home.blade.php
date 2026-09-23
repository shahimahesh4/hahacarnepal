@extends('layouts.app')

@section('title', 'Hahacar - Nepal\'s #1 Car Rental Comparison & Direct Booking')
@section('meta_description', 'Compare car rental prices and book verified vehicles across Kathmandu, Pokhara, Chitwan, Lumbini, and Mustang. Scorpio 4WD, Toyota Hilux, Swift, and HiAce tourist vans with transparent NPR pricing.')

@section('content')
<!-- Hero Section with Himalayan Night Gradient -->
<section class="relative bg-gradient-to-b from-[#070d1e] via-[#0f172a] to-[#1e293b] text-white pt-12 pb-24 sm:pt-16 sm:pb-32 overflow-hidden">
    <!-- Ambient Background Glows -->
    <div class="absolute inset-0 opacity-30 pointer-events-none">
        <div class="absolute -top-40 -right-40 w-[550px] h-[550px] bg-emerald-500 rounded-full blur-[150px]"></div>
        <div class="absolute top-80 -left-40 w-[500px] h-[500px] bg-teal-500 rounded-full blur-[150px]"></div>
        <div class="absolute bottom-10 right-1/4 w-[350px] h-[350px] bg-cyan-600/30 rounded-full blur-[130px]"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Top Pill & Headline -->
        <div class="text-center max-w-3xl mx-auto mb-10 sm:mb-12">
            <div class="inline-flex items-center gap-2 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-black px-4 py-1.5 rounded-full uppercase tracking-wider mb-5 shadow-xs backdrop-blur-md">
                <span>🇳🇵</span> NEPAL'S LEADING CAR RENTAL & MOBILITY NETWORK
            </div>
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-[1.1] text-white mb-5">
                Compare Car Rentals in Nepal. <br class="hidden sm:inline">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-cyan-300">Travel Free, Save Big.</span>
            </h1>
            <p class="text-sm sm:text-base lg:text-lg text-slate-300 max-w-2xl mx-auto font-normal leading-relaxed">
                Scan live rates across verified Nepali fleets or book directly with verified drivers. From mountain-ready <strong class="text-white">4WD Mahindra Scorpios</strong> to city hatchbacks and tourist HiAces, travel with transparent NPR rates and zero hidden counter fees.
            </p>

            <!-- Key Platform Highlights -->
            <div class="mt-6 flex flex-wrap items-center justify-center gap-4 sm:gap-8 text-xs font-bold text-slate-300">
                <div class="flex items-center gap-2 bg-slate-900/60 border border-white/10 px-3.5 py-1.5 rounded-full backdrop-blur-md">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>50+ Verified Nepal Fleets</span>
                </div>
                <div class="flex items-center gap-2 bg-slate-900/60 border border-white/10 px-3.5 py-1.5 rounded-full backdrop-blur-md">
                    <span class="text-emerald-400">🛡️</span>
                    <span>Admin-Verified Drivers & Bluebooks</span>
                </div>
                <div class="flex items-center gap-2 bg-slate-900/60 border border-white/10 px-3.5 py-1.5 rounded-full backdrop-blur-md">
                    <span class="text-emerald-400">🏔️</span>
                    <span>4WD Highway & Mountain Specialists</span>
                </div>
            </div>
        </div>

        <!-- Mobility Switcher Cards (Direct Booking vs Metasearch) -->
        <div class="flex flex-wrap items-center justify-center gap-3.5 mb-8">
            <a wire:navigate href="{{ route('book.index') }}" class="group px-6 py-3 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black text-sm shadow-xl shadow-emerald-500/25 flex items-center gap-3 hover:scale-105 transition-all duration-200">
                <div class="w-7 h-7 rounded-xl bg-slate-950 text-emerald-400 flex items-center justify-center text-sm shadow-inner">
                    ⚡
                </div>
                <div class="text-left">
                    <div class="leading-none">Direct Vehicle Booking</div>
                    <div class="text-[10px] text-slate-900 font-bold opacity-80 mt-0.5">Chauffeur & Self-Drive Fleet</div>
                </div>
                <span class="ml-1 px-2 py-0.5 rounded-md bg-slate-950/20 text-slate-950 text-[10px] uppercase font-black">Popular</span>
            </a>

            <a wire:navigate href="{{ route('partner.register') }}" class="group px-5 py-3 rounded-2xl bg-slate-900/80 hover:bg-slate-800 text-white font-bold text-sm border border-white/10 hover:border-emerald-500/40 backdrop-blur-md transition-all duration-200 flex items-center gap-3">
                <div class="w-7 h-7 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-sm">
                    🚘
                </div>
                <div class="text-left">
                    <div class="leading-none">List Your Car / Drive</div>
                    <div class="text-[10px] text-emerald-400 font-extrabold uppercase mt-0.5">Earn Daily NPR</div>
                </div>
            </a>
        </div>

        <!-- Embedded Livewire Search Form -->
        <div class="max-w-4xl mx-auto">
            <livewire:search-form />
        </div>

        <!-- Trust Badges Bar -->
        <div class="mt-12 flex flex-wrap items-center justify-center gap-6 sm:gap-10 text-xs font-semibold text-slate-400">
            <div class="flex items-center gap-2">
                <span class="w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs font-bold">✓</span>
                <span>Free cancellation on most bookings</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs font-bold">✓</span>
                <span>100% Nepali licensed fleet operators</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs font-bold">✓</span>
                <span>Transparent NPR rates • Zero hidden counter fees</span>
            </div>
        </div>
    </div>
</section>

<!-- Popular Nepal Destinations Section -->
<section class="py-16 sm:py-24 bg-white border-b border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12">
            <div>
                <div class="inline-flex items-center gap-1.5 text-xs font-extrabold uppercase tracking-widest text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200/60 mb-2">
                    <span>🏔️</span> TOP NEPAL ROUTES & HUBS
                </div>
                <h2 class="text-2xl sm:text-4xl font-black text-slate-900 mt-1">Popular Rental Destinations</h2>
            </div>
            <p class="text-sm font-medium text-slate-500 mt-2 sm:mt-0">Select your destination for instant rates and verified vehicles</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Kathmandu Card -->
            <a wire:navigate href="{{ route('search.index', ['pickup' => 1]) }}" 
                class="group relative h-80 rounded-3xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 block border border-slate-200/60">
                <img src="https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=800&q=80" 
                    alt="Kathmandu Valley" 
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                <div class="absolute top-4 left-4 bg-slate-900/80 backdrop-blur-md px-3 py-1 rounded-full text-[11px] font-bold text-emerald-400 border border-emerald-500/30">
                    Elevation 1,400m
                </div>
                <div class="absolute top-4 right-4 bg-white/95 backdrop-blur-md px-3.5 py-1.5 rounded-full text-xs font-black text-slate-900 shadow-md">
                    From Rs. 2,800/day
                </div>
                <div class="absolute bottom-6 left-6 right-6">
                    <span class="text-xs font-bold text-emerald-400 uppercase tracking-wider">Capital & Heritage Valley</span>
                    <h3 class="text-2xl font-black text-white mt-0.5">Kathmandu (KTM)</h3>
                    <p class="text-xs text-slate-300 mt-1">Tribhuvan Airport, Thamel, Kalanki & Patan Hubs</p>
                    <div class="mt-3 flex items-center gap-2 text-[11px] text-emerald-300 font-semibold">
                        <span>Compare Deals ➔</span>
                    </div>
                </div>
            </a>

            <!-- Pokhara Card -->
            <a wire:navigate href="{{ route('search.index', ['pickup' => 4]) }}" 
                class="group relative h-80 rounded-3xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 block border border-slate-200/60">
                <img src="https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?auto=format&fit=crop&w=800&q=80" 
                    alt="Pokhara Phewa Lake" 
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                <div class="absolute top-4 left-4 bg-slate-900/80 backdrop-blur-md px-3 py-1 rounded-full text-[11px] font-bold text-emerald-400 border border-emerald-500/30">
                    Elevation 822m
                </div>
                <div class="absolute top-4 right-4 bg-white/95 backdrop-blur-md px-3.5 py-1.5 rounded-full text-xs font-black text-slate-900 shadow-md">
                    From Rs. 3,500/day
                </div>
                <div class="absolute bottom-6 left-6 right-6">
                    <span class="text-xs font-bold text-emerald-400 uppercase tracking-wider">Lakeside & Annapurna Gateway</span>
                    <h3 class="text-2xl font-black text-white mt-0.5">Pokhara (PKR)</h3>
                    <p class="text-xs text-slate-300 mt-1">Pokhara International Airport & Lakeside Centers</p>
                    <div class="mt-3 flex items-center gap-2 text-[11px] text-emerald-300 font-semibold">
                        <span>Compare Deals ➔</span>
                    </div>
                </div>
            </a>

            <!-- Chitwan Card -->
            <a wire:navigate href="{{ route('search.index', ['pickup' => 6]) }}" 
                class="group relative h-80 rounded-3xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 block border border-slate-200/60">
                <img src="https://images.unsplash.com/photo-1581852017103-68ac6550407b?auto=format&fit=crop&w=800&q=80" 
                    alt="Chitwan National Park" 
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                <div class="absolute top-4 left-4 bg-slate-900/80 backdrop-blur-md px-3 py-1 rounded-full text-[11px] font-bold text-emerald-400 border border-emerald-500/30">
                    Elevation 415m
                </div>
                <div class="absolute top-4 right-4 bg-white/95 backdrop-blur-md px-3.5 py-1.5 rounded-full text-xs font-black text-slate-900 shadow-md">
                    From Rs. 4,500/day
                </div>
                <div class="absolute bottom-6 left-6 right-6">
                    <span class="text-xs font-bold text-emerald-400 uppercase tracking-wider">Wildlife & Jungle Safaris</span>
                    <h3 class="text-2xl font-black text-white mt-0.5">Chitwan (BHR)</h3>
                    <p class="text-xs text-slate-300 mt-1">Bharatpur Airport & Sauraha Safari Center</p>
                    <div class="mt-3 flex items-center gap-2 text-[11px] text-emerald-300 font-semibold">
                        <span>Compare Deals ➔</span>
                    </div>
                </div>
            </a>

            <!-- Lumbini Card -->
            <a wire:navigate href="{{ route('search.index', ['pickup' => 8]) }}" 
                class="group relative h-80 rounded-3xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 block border border-slate-200/60">
                <img src="https://images.unsplash.com/photo-1605649487212-47bdab064df7?auto=format&fit=crop&w=800&q=80" 
                    alt="Lumbini Maya Devi" 
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                <div class="absolute top-4 left-4 bg-slate-900/80 backdrop-blur-md px-3 py-1 rounded-full text-[11px] font-bold text-emerald-400 border border-emerald-500/30">
                    Elevation 105m
                </div>
                <div class="absolute top-4 right-4 bg-white/95 backdrop-blur-md px-3.5 py-1.5 rounded-full text-xs font-black text-slate-900 shadow-md">
                    From Rs. 4,000/day
                </div>
                <div class="absolute bottom-6 left-6 right-6">
                    <span class="text-xs font-bold text-emerald-400 uppercase tracking-wider">Birthplace of Lord Buddha</span>
                    <h3 class="text-2xl font-black text-white mt-0.5">Lumbini (BWA)</h3>
                    <p class="text-xs text-slate-300 mt-1">Gautam Buddha International Airport & Sacred Garden</p>
                    <div class="mt-3 flex items-center gap-2 text-[11px] text-emerald-300 font-semibold">
                        <span>Compare Deals ➔</span>
                    </div>
                </div>
            </a>

            <!-- Biratnagar Card -->
            <a wire:navigate href="{{ route('search.index', ['pickup' => 9]) }}" 
                class="group relative h-80 rounded-3xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 block border border-slate-200/60">
                <img src="https://images.unsplash.com/photo-1517457373958-b7bdd4587205?auto=format&fit=crop&w=800&q=80" 
                    alt="Biratnagar Eastern Hub" 
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                <div class="absolute top-4 left-4 bg-slate-900/80 backdrop-blur-md px-3 py-1 rounded-full text-[11px] font-bold text-emerald-400 border border-emerald-500/30">
                    Elevation 72m
                </div>
                <div class="absolute top-4 right-4 bg-white/95 backdrop-blur-md px-3.5 py-1.5 rounded-full text-xs font-black text-slate-900 shadow-md">
                    From Rs. 3,800/day
                </div>
                <div class="absolute bottom-6 left-6 right-6">
                    <span class="text-xs font-bold text-emerald-400 uppercase tracking-wider">Eastern Nepal Commercial Hub</span>
                    <h3 class="text-2xl font-black text-white mt-0.5">Biratnagar (BIR)</h3>
                    <p class="text-xs text-slate-300 mt-1">Biratnagar Airport, Dharan & Ilam Tea Garden Gateways</p>
                    <div class="mt-3 flex items-center gap-2 text-[11px] text-emerald-300 font-semibold">
                        <span>Compare Deals ➔</span>
                    </div>
                </div>
            </a>

            <!-- Nepalgunj Card -->
            <a wire:navigate href="{{ route('search.index', ['pickup' => 10]) }}" 
                class="group relative h-80 rounded-3xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 block border border-slate-200/60">
                <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=800&q=80" 
                    alt="Western Nepal Mountains" 
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                <div class="absolute top-4 left-4 bg-slate-900/80 backdrop-blur-md px-3 py-1 rounded-full text-[11px] font-bold text-emerald-400 border border-emerald-500/30">
                    Elevation 150m
                </div>
                <div class="absolute top-4 right-4 bg-white/95 backdrop-blur-md px-3.5 py-1.5 rounded-full text-xs font-black text-slate-900 shadow-md">
                    From Rs. 4,500/day
                </div>
                <div class="absolute bottom-6 left-6 right-6">
                    <span class="text-xs font-bold text-emerald-400 uppercase tracking-wider">Western Nepal & Rara Lake Hub</span>
                    <h3 class="text-2xl font-black text-white mt-0.5">Nepalgunj (KEP)</h3>
                    <p class="text-xs text-slate-300 mt-1">Nepalgunj Airport, Bardia National Park & Karnali Gateways</p>
                    <div class="mt-3 flex items-center gap-2 text-[11px] text-emerald-300 font-semibold">
                        <span>Compare Deals ➔</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- Nepal Vehicle Fleet Guide -->
<section class="py-16 sm:py-24 bg-slate-50 border-b border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <div class="inline-flex items-center gap-1.5 text-xs font-extrabold uppercase tracking-widest text-emerald-600 bg-emerald-100/60 px-3 py-1 rounded-full border border-emerald-200 mb-2">
                <span>🚙</span> TAILORED FOR NEPAL TERRAIN
            </div>
            <h2 class="text-2xl sm:text-4xl font-black text-slate-900 mt-1">Popular Vehicle Categories in Nepal</h2>
            <p class="text-sm font-medium text-slate-600 mt-2">Whether tackling the steep turns of the Prithvi Highway or exploring city cafes, find your ideal ride.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Class 1: Mountain SUV -->
            <div class="group bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs hover:shadow-xl hover:border-emerald-300 transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="aspect-16/10 w-full flex items-center justify-center mb-4 bg-slate-50/90 rounded-2xl p-3 group-hover:bg-emerald-50/50 border border-slate-100 transition overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?auto=format&fit=crop&w=1200&h=750&q=85" alt="Scorpio 4WD" class="h-full w-full object-contain group-hover:scale-105 transition duration-300">
                    </div>
                    <span class="inline-block bg-emerald-100 text-emerald-800 text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase mb-2">🏔️ Nepal Favorite</span>
                    <h3 class="text-lg font-black text-slate-900">4WD SUVs & Scorpio</h3>
                    <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
                        Mahindra Scorpio 4WD, Toyota Hilux. Built for mountain passes, rough monsoon roads, and high ground clearance (210mm+).
                    </p>
                </div>
                <div class="mt-5 pt-4 border-t border-slate-100 space-y-3">
                    <div class="flex items-center justify-between text-xs font-bold text-slate-700">
                        <span>7 Seats • 4x4 Off-Road</span>
                        <span class="text-emerald-600 font-extrabold">From Rs. 4,500/day</span>
                    </div>
                    <a wire:navigate href="{{ route('book.index') }}" class="w-full py-2 px-3 rounded-xl bg-slate-900 hover:bg-emerald-600 text-white font-bold text-xs flex items-center justify-center gap-1 transition">
                        <span>Book 4WD SUV</span>
                        <span>➔</span>
                    </a>
                </div>
            </div>

            <!-- Class 2: City Economy -->
            <div class="group bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs hover:shadow-xl hover:border-emerald-300 transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="aspect-16/10 w-full flex items-center justify-center mb-4 bg-slate-50/90 rounded-2xl p-3 group-hover:bg-blue-50/50 border border-slate-100 transition overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1590362891988-f77804702088?auto=format&fit=crop&w=1200&h=750&q=85" alt="Suzuki Swift" class="h-full w-full object-contain group-hover:scale-105 transition duration-300">
                    </div>
                    <span class="inline-block bg-blue-100 text-blue-800 text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase mb-2">⚡ Fuel Saver</span>
                    <h3 class="text-lg font-black text-slate-900">Economy Hatchbacks</h3>
                    <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
                        Suzuki Swift, Hyundai Grand i10. Smooth navigation through Kathmandu and Pokhara city lanes with easy parking.
                    </p>
                </div>
                <div class="mt-5 pt-4 border-t border-slate-100 space-y-3">
                    <div class="flex items-center justify-between text-xs font-bold text-slate-700">
                        <span>5 Seats • Manual/Auto</span>
                        <span class="text-emerald-600 font-extrabold">From Rs. 2,500/day</span>
                    </div>
                    <a wire:navigate href="{{ route('book.index') }}" class="w-full py-2 px-3 rounded-xl bg-slate-900 hover:bg-emerald-600 text-white font-bold text-xs flex items-center justify-center gap-1 transition">
                        <span>Book City Hatchback</span>
                        <span>➔</span>
                    </a>
                </div>
            </div>

            <!-- Class 3: Tourist Vans -->
            <div class="group bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs hover:shadow-xl hover:border-emerald-300 transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="aspect-16/10 w-full flex items-center justify-center mb-4 bg-slate-50/90 rounded-2xl p-3 group-hover:bg-purple-50/50 border border-slate-100 transition overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1542282088-72c9c27ed0cd?auto=format&fit=crop&w=1200&h=750&q=85" alt="Toyota HiAce" class="h-full w-full object-contain group-hover:scale-105 transition duration-300">
                    </div>
                    <span class="inline-block bg-purple-100 text-purple-800 text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase mb-2">🚐 Group Tour</span>
                    <h3 class="text-lg font-black text-slate-900">HiAce Commuter Vans</h3>
                    <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
                        Toyota HiAce 12-14 seater. High-roof tourist van ideal for trekking expeditions, pilgrimages to Muktinath, and family groups.
                    </p>
                </div>
                <div class="mt-5 pt-4 border-t border-slate-100 space-y-3">
                    <div class="flex items-center justify-between text-xs font-bold text-slate-700">
                        <span>12-14 Seats • High Roof</span>
                        <span class="text-emerald-600 font-extrabold">From Rs. 6,500/day</span>
                    </div>
                    <a wire:navigate href="{{ route('book.index') }}" class="w-full py-2 px-3 rounded-xl bg-slate-900 hover:bg-emerald-600 text-white font-bold text-xs flex items-center justify-center gap-1 transition">
                        <span>Book HiAce Van</span>
                        <span>➔</span>
                    </a>
                </div>
            </div>

            <!-- Class 4: Premium Luxury -->
            <div class="group bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs hover:shadow-xl hover:border-emerald-300 transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="aspect-16/10 w-full flex items-center justify-center mb-4 bg-slate-50/90 rounded-2xl p-3 group-hover:bg-amber-50/50 border border-slate-100 transition overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1555215695-3004980ad54e?auto=format&fit=crop&w=1200&h=750&q=85" alt="Toyota Prado" class="h-full w-full object-contain group-hover:scale-105 transition duration-300">
                    </div>
                    <span class="inline-block bg-amber-100 text-amber-800 text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase mb-2">👑 VIP Luxury</span>
                    <h3 class="text-lg font-black text-slate-900">Luxury Prado / SUV</h3>
                    <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
                        Toyota Prado TX, Fortuner. Supreme comfort, executive styling, leather interior, and top-tier mountain capability.
                    </p>
                </div>
                <div class="mt-5 pt-4 border-t border-slate-100 space-y-3">
                    <div class="flex items-center justify-between text-xs font-bold text-slate-700">
                        <span>7 Seats • Luxury 4x4</span>
                        <span class="text-emerald-600 font-extrabold">From Rs. 14,000/day</span>
                    </div>
                    <a wire:navigate href="{{ route('book.index') }}" class="w-full py-2 px-3 rounded-xl bg-slate-900 hover:bg-emerald-600 text-white font-bold text-xs flex items-center justify-center gap-1 transition">
                        <span>Book Luxury SUV</span>
                        <span>➔</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How Hahacar Works -->
<section class="py-16 sm:py-24 bg-white border-b border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <div class="inline-flex items-center gap-1.5 text-xs font-extrabold uppercase tracking-widest text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200 mb-2">
                <span>🧭</span> EASY & TRANSPARENT
            </div>
            <h2 class="text-2xl sm:text-4xl font-black text-slate-900 mt-1">How Hahacar Works</h2>
            <p class="text-sm font-medium text-slate-600 mt-2">Connecting you directly to Nepal's top car rental fleets in 3 simple steps.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
            <!-- Step 1 -->
            <div class="bg-slate-50/90 rounded-3xl p-8 border border-slate-200/70 hover:border-emerald-300 hover:shadow-lg transition-all duration-300">
                <div class="w-14 h-14 bg-gradient-to-tr from-emerald-600 to-teal-500 text-white rounded-2xl flex items-center justify-center font-black text-2xl mb-6 shadow-md shadow-emerald-500/20">
                    1
                </div>
                <h3 class="text-xl font-black text-slate-900 mb-2">Choose Route & Dates</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Select your pickup airport or city hub (e.g. Kathmandu KTM Airport, Pokhara Lakeside, Chitwan). Choose with-chauffeur or self-drive mode.
                </p>
            </div>

            <!-- Step 2 -->
            <div class="bg-slate-50/90 rounded-3xl p-8 border border-slate-200/70 hover:border-emerald-300 hover:shadow-lg transition-all duration-300">
                <div class="w-14 h-14 bg-gradient-to-tr from-emerald-600 to-teal-500 text-white rounded-2xl flex items-center justify-center font-black text-2xl mb-6 shadow-md shadow-emerald-500/20">
                    2
                </div>
                <h3 class="text-xl font-black text-slate-900 mb-2">Inspect Clear Deals</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Compare transparent pricing in Nepalese Rupees (NPR). Review vehicle specs (4WD, seats, bags), driver ratings, and cancellation policies.
                </p>
            </div>

            <!-- Step 3 -->
            <div class="bg-slate-50/90 rounded-3xl p-8 border border-slate-200/70 hover:border-emerald-300 hover:shadow-lg transition-all duration-300">
                <div class="w-14 h-14 bg-gradient-to-tr from-emerald-600 to-teal-500 text-white rounded-2xl flex items-center justify-center font-black text-2xl mb-6 shadow-md shadow-emerald-500/20">
                    3
                </div>
                <h3 class="text-xl font-black text-slate-900 mb-2">Book Direct & Travel</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Receive an instant digital confirmation voucher. Handover vehicle at your chosen station or have the driver pick you up at the airport gate.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Drive with Hahacar & Partner Fleet Section -->
<section class="py-16 sm:py-24 bg-gradient-to-br from-slate-900 via-slate-950 to-emerald-950 text-white border-b border-white/10 relative overflow-hidden">
    <div class="absolute inset-0 opacity-20 pointer-events-none">
        <div class="absolute -bottom-20 -right-20 w-96 h-96 bg-emerald-500 rounded-full blur-[120px]"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <div class="lg:col-span-7 space-y-6">
                <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-500/10 text-emerald-400 border border-emerald-500/30">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Partner Driver & Vehicle Network
                </span>
                <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">
                    Own a Car or Drive in Nepal? <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-300">Partner & Earn with Hahacar.</span>
                </h2>
                <p class="text-sm sm:text-base text-slate-300 leading-relaxed max-w-xl">
                    Whether you have a <strong>Mahindra Scorpio 4WD</strong>, <strong>Toyota Hilux</strong>, <strong>Creta</strong>, <strong>Suzuki Swift</strong>, or a <strong>HiAce tourist van</strong>, you can list your vehicle on Hahacar. Our admin team verifies your license and vehicle bluebook, giving travelers complete confidence while you earn reliable daily rates.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                    <div class="p-4 rounded-2xl bg-white/5 border border-white/10">
                        <div class="text-emerald-400 font-bold text-base mb-1">1. Sign Up</div>
                        <div class="text-xs text-slate-400">Register profile and upload license + bluebook photo.</div>
                    </div>
                    <div class="p-4 rounded-2xl bg-white/5 border border-white/10">
                        <div class="text-emerald-400 font-bold text-base mb-1">2. Admin Review</div>
                        <div class="text-xs text-slate-400">Compliance team reviews and verifies your documents.</div>
                    </div>
                    <div class="p-4 rounded-2xl bg-white/5 border border-white/10">
                        <div class="text-emerald-400 font-bold text-base mb-1">3. Receive Bookings</div>
                        <div class="text-xs text-slate-400">Accept direct customer reservations in NPR (Rs.).</div>
                    </div>
                </div>

                <div class="pt-4 flex flex-wrap items-center gap-4">
                    <a
                        wire:navigate
                        href="{{ route('partner.register') }}"
                        class="px-8 py-3.5 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black text-sm shadow-xl shadow-emerald-500/25 transition duration-200"
                    >
                        List Your Vehicle Now ➔
                    </a>
                    <a
                        wire:navigate
                        href="{{ route('partner.dashboard') }}"
                        class="px-6 py-3.5 rounded-2xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-sm border border-white/10 transition duration-200"
                    >
                        Partner Portal Login
                    </a>
                </div>
            </div>

            <!-- Fleet Preview Card -->
            <div class="lg:col-span-5">
                <div class="rounded-3xl bg-slate-900/90 border border-white/15 p-6 backdrop-blur-xl shadow-2xl space-y-4">
                    <div class="flex items-center justify-between pb-4 border-b border-white/10">
                        <span class="text-xs font-bold text-slate-300 uppercase tracking-wider">Nepal Top Fleet Rates</span>
                        <span class="text-xs text-emerald-400 font-semibold">Verified Daily Earnings</span>
                    </div>

                    <div class="space-y-3">
                        <div class="p-3.5 rounded-2xl bg-slate-950/60 border border-white/5 flex items-center justify-between">
                            <div>
                                <div class="text-sm font-bold text-white">Mahindra Scorpio 4WD</div>
                                <div class="text-xs text-slate-400">7 Seats • Mountain Routes</div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-black text-emerald-400">Rs. 4,500 - 5,500</div>
                                <div class="text-[10px] text-slate-400">/ day</div>
                            </div>
                        </div>

                        <div class="p-3.5 rounded-2xl bg-slate-950/60 border border-white/5 flex items-center justify-between">
                            <div>
                                <div class="text-sm font-bold text-white">Toyota HiAce Tourist Commuter</div>
                                <div class="text-xs text-slate-400">14 Seats • Sightseeing & Tours</div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-black text-emerald-400">Rs. 6,500 - 8,000</div>
                                <div class="text-[10px] text-slate-400">/ day</div>
                            </div>
                        </div>

                        <div class="p-3.5 rounded-2xl bg-slate-950/60 border border-white/5 flex items-center justify-between">
                            <div>
                                <div class="text-sm font-bold text-white">Suzuki Swift / Hatchback</div>
                                <div class="text-xs text-slate-400">5 Seats • Kathmandu City Drive</div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-black text-emerald-400">Rs. 2,500 - 3,200</div>
                                <div class="text-[10px] text-slate-400">/ day</div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2 text-center text-xs text-slate-400">
                        Zero platform sign-up fees • Verified payment protection
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQs Section -->
<section class="py-16 sm:py-24 bg-slate-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-1.5 text-xs font-extrabold uppercase tracking-widest text-emerald-600 bg-emerald-100/60 px-3 py-1 rounded-full border border-emerald-200 mb-2">
                <span>💬</span> FREQUENTLY ASKED
            </div>
            <h2 class="text-2xl sm:text-4xl font-black text-slate-900 mt-1">Nepal Car Rental FAQs</h2>
            <p class="text-sm text-slate-600 mt-2">Everything you need to know about renting a car, hiring drivers, and road travel in Nepal.</p>
        </div>

        <div class="space-y-4">
            @php
                $homepageFaqs = \App\Models\Faq::where('is_published', true)->orderBy('sort_order')->take(5)->get();
            @endphp

            @foreach($homepageFaqs as $faq)
                <div class="bg-white border border-slate-200/80 rounded-2xl p-6 hover:border-emerald-300 hover:shadow-md transition shadow-2xs" x-data="{ open: false }">
                    <button type="button" @click="open = !open" class="w-full flex items-center justify-between text-left font-bold text-slate-900 text-base">
                        <span>{{ $faq->question }}</span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform duration-200" :class="{ 'rotate-180 text-emerald-600': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-transition class="mt-3 text-sm text-slate-600 leading-relaxed pt-3 border-t border-slate-100">
                        {{ $faq->answer }}
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <a wire:navigate href="{{ route('faq.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-emerald-700 hover:text-emerald-800 transition">
                <span>View all Nepal Car Rental FAQs</span>
                <span>→</span>
            </a>
        </div>
    </div>
</section>
@endsection
