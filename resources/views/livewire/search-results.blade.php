<div x-data="{ mobileFiltersOpen: false }">
    <!-- Top Search Summary & Filter Bar -->
    <div class="bg-gradient-to-r from-[#0a1128] via-[#0f172a] to-[#1e293b] text-white py-4 sm:py-5 border-b border-slate-800 shadow-lg sticky top-16 sm:top-20 z-30 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center justify-between gap-3 sm:gap-4">
                <!-- Location & Route Summary -->
                <div class="flex items-center gap-3 sm:gap-4">
                    <a wire:navigate href="{{ route('home') }}" class="p-2 rounded-xl bg-white/10 hover:bg-white/20 text-slate-300 hover:text-white transition shrink-0" title="Back to Homepage">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    </a>
                    <div>
                        <div class="flex items-center gap-2 font-black text-base sm:text-xl tracking-tight">
                            <span>{{ $search->pickupLocation->city }}</span>
                            <span class="text-[10px] sm:text-xs font-bold text-emerald-400 bg-emerald-500/20 px-2 py-0.5 rounded-md">{{ $search->pickupLocation->iata_code ?? 'Hub' }}</span>
                            @if($search->pickup_location_id !== $search->dropoff_location_id)
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                <span>{{ $search->dropoffLocation->city }}</span>
                                <span class="text-[10px] sm:text-xs font-bold text-emerald-400 bg-emerald-500/20 px-2 py-0.5 rounded-md">{{ $search->dropoffLocation->iata_code ?? 'Hub' }}</span>
                            @endif
                        </div>
                        <div class="text-[11px] sm:text-xs text-slate-300 flex flex-wrap items-center gap-2 sm:gap-3 mt-0.5">
                            <span>📅 {{ $search->pickup_datetime->format('M d, H:i') }} → {{ $search->dropoff_datetime->format('M d, H:i') }}</span>
                            <span class="bg-slate-800 text-emerald-300 px-2 py-0.5 rounded-full font-bold text-[10px] sm:text-[11px]">⚡ {{ $rentalDays }} {{ Str::plural('Day', $rentalDays) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Price Alert & Mobile Filter Trigger -->
                <div class="flex items-center gap-2 sm:gap-3">
                    <!-- Mobile Filter Toggle Button -->
                    <button
                        type="button"
                        @click="mobileFiltersOpen = true"
                        class="lg:hidden inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs border border-white/10 transition cursor-pointer"
                    >
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                        <span>Filters ({{ count($selectedCategories) + count($selectedTransmissions) + ($freeCancellationOnly ? 1 : 0) }})</span>
                    </button>

                    <button type="button" 
                        wire:click="openAlertModal"
                        class="inline-flex items-center gap-1.5 sm:gap-2 bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white font-bold px-3 sm:px-4 py-2 rounded-xl text-xs shadow-md shadow-emerald-500/20 transition cursor-pointer">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <span class="hidden sm:inline">Price Drop</span> Alerts
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Filters Slide-Over / Drawer -->
    <div
        x-show="mobileFiltersOpen"
        x-cloak
        class="fixed inset-0 z-50 lg:hidden overflow-hidden"
    >
        <!-- Backdrop -->
        <div
            x-show="mobileFiltersOpen"
            x-transition:enter="transition-opacity ease-linear duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="mobileFiltersOpen = false"
            class="fixed inset-0 bg-black/70 backdrop-blur-xs"
        ></div>

        <!-- Sheet Panel -->
        <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
            <div
                x-show="mobileFiltersOpen"
                x-transition:enter="transform transition ease-in-out duration-300"
                x-transition:enter-start="translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition ease-in-out duration-300"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full"
                class="w-screen max-w-md bg-white p-6 shadow-2xl flex flex-col justify-between overflow-y-auto"
            >
                <div class="space-y-6">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <h2 class="font-black text-slate-900 text-lg flex items-center gap-2">
                            <span>⚡ Filter Deals</span>
                        </h2>
                        <button
                            type="button"
                            @click="mobileFiltersOpen = false"
                            class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-sm"
                        >
                            ✕
                        </button>
                    </div>

                    <!-- Vehicle Category Filter -->
                    <div>
                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-wider mb-3">Vehicle Class</h3>
                        <div class="space-y-2.5">
                            @foreach($availableCategories as $cat)
                                <label class="flex items-center justify-between text-sm text-slate-700 hover:text-slate-900 cursor-pointer">
                                    <div class="flex items-center gap-3">
                                        <input type="checkbox" 
                                            wire:model.live="selectedCategories" 
                                            value="{{ $cat->code }}"
                                            class="rounded-md text-emerald-600 focus:ring-emerald-500 border-slate-300 w-4 h-4">
                                        <span class="font-semibold text-slate-800">{{ $cat->name }}</span>
                                    </div>
                                    <span class="text-xs text-slate-400 font-mono">{{ $cat->sipp_code }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Transmission Filter -->
                    <div class="pt-5 border-t border-slate-100">
                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-wider mb-3">Transmission</h3>
                        <div class="space-y-2.5">
                            <label class="flex items-center gap-3 text-sm text-slate-700 cursor-pointer">
                                <input type="checkbox" wire:model.live="selectedTransmissions" value="automatic" class="rounded-md text-emerald-600 focus:ring-emerald-500 border-slate-300 w-4 h-4">
                                <span class="font-semibold text-slate-800">Automatic</span>
                            </label>
                            <label class="flex items-center gap-3 text-sm text-slate-700 cursor-pointer">
                                <input type="checkbox" wire:model.live="selectedTransmissions" value="manual" class="rounded-md text-emerald-600 focus:ring-emerald-500 border-slate-300 w-4 h-4">
                                <span class="font-semibold text-slate-800">Manual (Mountain-preferred)</span>
                            </label>
                        </div>
                    </div>

                    <!-- Rental Conditions -->
                    <div class="pt-5 border-t border-slate-100">
                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-wider mb-3">Rental Conditions</h3>
                        <div class="space-y-2.5">
                            <label class="flex items-center gap-3 text-sm text-slate-700 cursor-pointer">
                                <input type="checkbox" wire:model.live="freeCancellationOnly" class="rounded-md text-emerald-600 focus:ring-emerald-500 border-slate-300 w-4 h-4">
                                <span class="font-bold text-emerald-700">Free Cancellation</span>
                            </label>
                            <label class="flex items-center gap-3 text-sm text-slate-700 cursor-pointer">
                                <input type="checkbox" wire:model.live="unlimitedMileageOnly" class="rounded-md text-emerald-600 focus:ring-emerald-500 border-slate-300 w-4 h-4">
                                <span class="font-semibold text-slate-800">Unlimited Kilometers</span>
                            </label>
                        </div>
                    </div>

                    <!-- Suppliers Filter -->
                    <div class="pt-5 border-t border-slate-100">
                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-wider mb-3">Rental Operators in Nepal</h3>
                        <div class="space-y-2.5">
                            @foreach($availableSuppliers as $sup)
                                <label class="flex items-center gap-3 text-sm text-slate-700 cursor-pointer">
                                    <input type="checkbox" 
                                        wire:model.live="selectedSuppliers" 
                                        value="{{ $sup }}"
                                        class="rounded-md text-emerald-600 focus:ring-emerald-500 border-slate-300 w-4 h-4">
                                    <span class="font-medium text-slate-800">{{ $sup }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-200 mt-6 flex items-center gap-3">
                    <button
                        type="button"
                        wire:click="resetFilters"
                        class="flex-1 py-3 rounded-xl border border-slate-200 font-bold text-slate-700 text-xs text-center"
                    >
                        Reset
                    </button>
                    <button
                        type="button"
                        @click="mobileFiltersOpen = false"
                        class="flex-1 py-3 rounded-xl bg-emerald-600 text-white font-bold text-xs text-center shadow-md shadow-emerald-600/20"
                    >
                        Apply Filters
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Results Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 lg:gap-8 items-start">
            <!-- Desktop Sidebar Filters -->
            <div class="hidden lg:block lg:col-span-1 space-y-6">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 p-6 space-y-6">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <h2 class="font-black text-slate-900 text-base flex items-center gap-2">
                            <span>⚡ Filter Deals</span>
                        </h2>
                        <button type="button" 
                            wire:click="resetFilters"
                            class="text-xs font-bold text-emerald-600 hover:text-emerald-700 transition cursor-pointer">
                            Clear all
                        </button>
                    </div>

                    <!-- Vehicle Category Filter -->
                    <div>
                        <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-wider mb-3">Vehicle Class</h3>
                        <div class="space-y-2.5">
                            @foreach($availableCategories as $cat)
                                <label class="flex items-center justify-between text-sm text-slate-700 hover:text-slate-900 cursor-pointer group">
                                    <div class="flex items-center gap-3">
                                        <input type="checkbox" 
                                            wire:model.live="selectedCategories" 
                                            value="{{ $cat->code }}"
                                            class="rounded-md text-emerald-600 focus:ring-emerald-500 border-slate-300 w-4 h-4 transition">
                                        <span class="font-semibold text-slate-800 group-hover:text-emerald-700 transition">{{ $cat->name }}</span>
                                    </div>
                                    <span class="text-xs text-slate-400 font-mono">{{ $cat->sipp_code }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Transmission Filter -->
                    <div class="pt-5 border-t border-slate-100">
                        <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-wider mb-3">Transmission</h3>
                        <div class="space-y-2.5">
                            <label class="flex items-center gap-3 text-sm text-slate-700 hover:text-slate-900 cursor-pointer">
                                <input type="checkbox" wire:model.live="selectedTransmissions" value="automatic" class="rounded-md text-emerald-600 focus:ring-emerald-500 border-slate-300 w-4 h-4">
                                <span class="font-semibold text-slate-800">Automatic</span>
                            </label>
                            <label class="flex items-center gap-3 text-sm text-slate-700 hover:text-slate-900 cursor-pointer">
                                <input type="checkbox" wire:model.live="selectedTransmissions" value="manual" class="rounded-md text-emerald-600 focus:ring-emerald-500 border-slate-300 w-4 h-4">
                                <span class="font-semibold text-slate-800">Manual (Mountain-preferred)</span>
                            </label>
                        </div>
                    </div>

                    <!-- Rental Conditions -->
                    <div class="pt-5 border-t border-slate-100">
                        <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-wider mb-3">Rental Conditions</h3>
                        <div class="space-y-2.5">
                            <label class="flex items-center gap-3 text-sm text-slate-700 hover:text-slate-900 cursor-pointer">
                                <input type="checkbox" wire:model.live="freeCancellationOnly" class="rounded-md text-emerald-600 focus:ring-emerald-500 border-slate-300 w-4 h-4">
                                <span class="font-bold text-emerald-700">Free Cancellation</span>
                            </label>
                            <label class="flex items-center gap-3 text-sm text-slate-700 hover:text-slate-900 cursor-pointer">
                                <input type="checkbox" wire:model.live="unlimitedMileageOnly" class="rounded-md text-emerald-600 focus:ring-emerald-500 border-slate-300 w-4 h-4">
                                <span class="font-semibold text-slate-800">Unlimited Kilometers</span>
                            </label>
                        </div>
                    </div>

                    <!-- Suppliers Filter -->
                    <div class="pt-5 border-t border-slate-100">
                        <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-wider mb-3">Rental Operators in Nepal</h3>
                        <div class="space-y-2.5">
                            @foreach($availableSuppliers as $sup)
                                <label class="flex items-center gap-3 text-sm text-slate-700 hover:text-slate-900 cursor-pointer">
                                    <input type="checkbox" 
                                        wire:model.live="selectedSuppliers" 
                                        value="{{ $sup }}"
                                        class="rounded-md text-emerald-600 focus:ring-emerald-500 border-slate-300 w-4 h-4">
                                    <span class="font-medium text-slate-800">{{ $sup }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Price Alert Promotion Sidebar Card -->
                <div class="bg-gradient-to-br from-emerald-50 to-teal-50 border border-emerald-200/80 rounded-3xl p-6 text-center shadow-xs">
                    <div class="w-12 h-12 bg-white text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    </div>
                    <h4 class="font-black text-slate-900 text-sm mb-1">Waiting for rates to drop?</h4>
                    <p class="text-xs text-slate-600 mb-4 leading-relaxed">We scan rates across Nepal operators multiple times daily and notify you when prices drop.</p>
                    <button type="button" 
                        wire:click="openAlertModal"
                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-4 rounded-xl text-xs transition shadow-md shadow-emerald-600/20 cursor-pointer">
                        Set Free Price Alert
                    </button>
                </div>
            </div>

            <!-- Main Offers Feed -->
            <div class="lg:col-span-3 space-y-5">
                <!-- Sorting & Count Header -->
                <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 px-5 py-4 flex flex-wrap items-center justify-between gap-4">
                    <div class="text-sm font-semibold text-slate-700">
                        Found <strong class="text-slate-900 text-base font-black">{{ $filteredOffersCount }}</strong> vehicle offers in Nepal
                    </div>

                    <div class="flex items-center gap-2.5">
                        <label for="sortBy" class="text-xs font-black text-slate-400 uppercase tracking-wider">Sort by:</label>
                        <select id="sortBy" wire:model.live="sort" class="bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl px-3.5 py-1.5 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500 focus:outline-none transition cursor-pointer">
                            <option value="recommended">Recommended (Best Value)</option>
                            <option value="price_asc">Lowest Total Price (NPR)</option>
                            <option value="daily_price_asc">Lowest Daily Rate (NPR)</option>
                            <option value="rating_desc">Highest Operator Rating</option>
                        </select>
                    </div>
                </div>

                <!-- Offers Cards -->
                <div class="space-y-4">
                    @forelse($offers as $offer)
                        <div class="bg-white rounded-3xl shadow-xs hover:shadow-xl border border-slate-200/80 hover:border-emerald-300 transition-all duration-300 p-6 relative group">
                            @if($offer->is_sponsored)
                                <div class="absolute top-4 right-4 bg-amber-100 text-amber-900 border border-amber-200 text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider shadow-2xs">
                                    Featured Deal
                                </div>
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
                                <!-- Vehicle Image & Category -->
                                <div class="md:col-span-4 flex flex-col items-center justify-center text-center">
                                    <div class="w-full aspect-16/10 flex items-center justify-center bg-gradient-to-br from-slate-50 via-slate-100/60 to-slate-50 border border-slate-200/80 rounded-2xl p-3.5 mb-3 shadow-2xs overflow-hidden">
                                        <img src="{{ $offer->vehicle_image_url ? asset($offer->vehicle_image_url) : asset('images/vehicles/scorpio.jpg') }}" 
                                            alt="{{ $offer->vehicle_name }}" 
                                            class="h-full w-full object-contain group-hover:scale-105 transition-transform duration-300">
                                    </div>
                                    <span class="inline-block bg-slate-100 text-slate-700 text-xs font-bold px-3 py-1 rounded-full">
                                        {{ $offer->vehicleCategory->name ?? 'Standard' }} Class
                                    </span>
                                </div>

                                <!-- Vehicle Details & Rental Terms -->
                                <div class="md:col-span-5 space-y-3.5">
                                    <div>
                                        <h3 class="font-black text-slate-900 text-xl leading-tight">{{ $offer->vehicle_name }}</h3>
                                    </div>

                                    <!-- Specs Badges -->
                                    <div class="flex flex-wrap items-center gap-2 text-xs font-semibold text-slate-600">
                                        <span class="bg-slate-50 border border-slate-200 px-2.5 py-1 rounded-lg flex items-center gap-1">
                                            👤 {{ $offer->seats }} Seats
                                        </span>
                                        <span class="bg-slate-50 border border-slate-200 px-2.5 py-1 rounded-lg flex items-center gap-1">
                                            🧳 {{ $offer->bags }} Bags
                                        </span>
                                        <span class="bg-slate-50 border border-slate-200 px-2.5 py-1 rounded-lg flex items-center gap-1">
                                            🚪 {{ $offer->doors }} Doors
                                        </span>
                                        <span class="bg-slate-50 border border-slate-200 px-2.5 py-1 rounded-lg font-bold capitalize">
                                            ⚙️ {{ $offer->transmission }}
                                        </span>
                                        @if($offer->has_ac)
                                            <span class="bg-slate-50 border border-slate-200 px-2.5 py-1 rounded-lg">
                                                ❄️ A/C
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Operator & Location -->
                                    <div class="flex items-center gap-3 pt-1">
                                        <span class="font-extrabold text-xs text-slate-900 bg-slate-100 px-2.5 py-1 rounded-lg border border-slate-200">
                                            {{ $offer->supplier_name }}
                                        </span>
                                        <div class="flex items-center gap-1.5 text-xs font-bold">
                                            <span class="bg-emerald-600 text-white px-2 py-0.5 rounded-md text-[11px]">
                                                ★ {{ number_format($offer->supplier_rating, 1) }}
                                            </span>
                                            <span class="text-slate-600">Verified Operator</span>
                                        </div>
                                    </div>

                                    <!-- Included Policies -->
                                    <div class="space-y-1.5 text-xs pt-1">
                                        <div class="flex items-center gap-2 text-emerald-700 font-bold">
                                            <svg class="w-4 h-4 fill-current text-emerald-600" viewBox="0 0 20 20"><path d="M0 11l2-2 5 5L18 3l2 2L7 18z"/></svg>
                                            Free cancellation up to 48h before pickup
                                        </div>
                                        <div class="flex items-center gap-2 text-slate-600">
                                            <svg class="w-4 h-4 fill-current text-emerald-600" viewBox="0 0 20 20"><path d="M0 11l2-2 5 5L18 3l2 2L7 18z"/></svg>
                                            Unlimited kilometers • Full-to-full fuel policy
                                        </div>
                                        <div class="text-[11px] text-slate-500 font-medium">
                                            Refundable security deposit: <strong>{{ $offer->deposit_formatted }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pricing & Action Button -->
                                <div class="md:col-span-3 text-right flex flex-col justify-between h-full border-t md:border-t-0 md:border-l border-slate-100 pt-5 md:pt-0 md:pl-6 space-y-4">
                                    <div>
                                        <div class="text-xs font-medium text-slate-500">Total for {{ $rentalDays }} {{ Str::plural('Day', $rentalDays) }}</div>
                                        <div class="text-3xl font-black text-slate-900 tracking-tight mt-0.5">
                                            {{ $offer->total_price_formatted }}
                                        </div>
                                        <div class="text-xs text-emerald-700 font-bold mt-0.5">
                                            {{ $offer->daily_price_formatted }} / day
                                        </div>
                                        <div class="text-[11px] text-slate-400 mt-1 font-medium">All Nepal road taxes included</div>
                                    </div>

                                    <div class="w-full space-y-1.5">
                                        <!-- Direct Instant Booking Button -->
                                        <button type="button"
                                            wire:click="selectOffer({{ $offer->id }})"
                                            class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 active:from-emerald-700 active:to-teal-700 text-white font-extrabold py-3.5 px-4 rounded-2xl shadow-lg shadow-emerald-600/25 hover:shadow-xl hover:shadow-emerald-600/35 hover:scale-[1.02] transition-all cursor-pointer">
                                            <span>Book Now</span>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                        </button>
                                        <div class="flex items-center justify-center gap-1.5 text-[11px] text-emerald-700 px-1 font-bold text-center">
                                            <span>⚡ Instant Confirmation</span>
                                            <span>•</span>
                                            <span>Pay on Pickup</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-3xl border border-slate-200/80 p-12 text-center shadow-xs">
                            <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                                🚙
                            </div>
                            <h3 class="text-xl font-black text-slate-900 mb-1">No matching vehicles found</h3>
                            <p class="text-sm text-slate-500 max-w-md mx-auto mb-6 leading-relaxed">Try adjusting your filters or create a free price alert to be notified when rates matching your route become available.</p>
                            <button type="button" 
                                wire:click="resetFilters"
                                class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-6 rounded-xl text-xs transition shadow-sm cursor-pointer">
                                Reset All Filters
                            </button>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Direct Booking Confirmation Modal -->
    @if ($isBookingModalOpen && $selectedOffer)
        <div class="fixed inset-0 z-50 overflow-y-auto bg-black/80 backdrop-blur-md flex items-center justify-center p-4">
            <div class="relative w-full max-w-2xl rounded-3xl bg-slate-900 border border-white/15 p-6 md:p-8 shadow-2xl text-left">
                <!-- Close Button -->
                <button
                    type="button"
                    wire:click="closeBookingModal"
                    class="absolute top-6 right-6 w-9 h-9 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white flex items-center justify-center transition cursor-pointer"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Modal Header -->
                <div class="mb-6">
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 mb-2">
                        Instant Vehicle Reservation
                    </span>
                    <h2 class="text-2xl font-black text-white">Complete Your Booking</h2>
                    <p class="text-xs text-slate-400 mt-1">Direct booking in Nepal • No prepayment required • Pay on pickup</p>
                </div>

                <!-- Vehicle & Rate Summary Card -->
                <div class="p-4 rounded-2xl bg-slate-950/80 border border-white/10 flex items-center gap-4 mb-6">
                    <img
                        src="{{ $selectedOffer->vehicle_image_url ? asset($selectedOffer->vehicle_image_url) : asset('images/vehicles/scorpio.jpg') }}"
                        alt="{{ $selectedOffer->vehicle_name }}"
                        class="w-28 h-20 rounded-xl object-contain bg-slate-900/90 p-1.5 border border-white/10 shrink-0"
                    />
                    <div class="flex-1 min-w-0">
                        <div class="font-bold text-white text-base truncate">{{ $selectedOffer->vehicle_name }}</div>
                        <div class="text-xs text-slate-400">
                            Operator: <span class="text-emerald-400 font-semibold">{{ $selectedOffer->supplier_name }}</span> (★ {{ number_format($selectedOffer->supplier_rating, 1) }})
                        </div>
                        <div class="text-xs text-slate-300 mt-0.5">
                            {{ $rentalDays }} {{ Str::plural('Day', $rentalDays) }} • {{ $selectedOffer->seats }} Seats • {{ $selectedOffer->transmission }}
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-slate-400">Total Price</div>
                        <div class="text-xl font-black text-emerald-400">{{ $selectedOffer->total_price_formatted }}</div>
                    </div>
                </div>

                <!-- Service Option Toggle -->
                <div class="mb-6">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Service Mode</label>
                    <div class="grid grid-cols-2 gap-3">
                        <button
                            type="button"
                            wire:click="$set('serviceOption', 'with_driver')"
                            class="p-3 rounded-xl border text-left transition cursor-pointer {{ $serviceOption === 'with_driver' ? 'bg-emerald-500/20 border-emerald-500 text-white' : 'bg-slate-800/80 border-white/10 text-slate-400 hover:text-white' }}"
                        >
                            <div class="text-xs font-bold text-white flex items-center gap-1.5">
                                <span>👔 With Driver (Chauffeur)</span>
                            </div>
                            <div class="text-[10px] text-slate-400 mt-0.5">Professional Nepali driver included</div>
                        </button>
                        <button
                            type="button"
                            wire:click="$set('serviceOption', 'self_drive')"
                            class="p-3 rounded-xl border text-left transition cursor-pointer {{ $serviceOption === 'self_drive' ? 'bg-emerald-500/20 border-emerald-500 text-white' : 'bg-slate-800/80 border-white/10 text-slate-400 hover:text-white' }}"
                        >
                            <div class="text-xs font-bold text-white flex items-center gap-1.5">
                                <span>🔑 Self-Drive Rental</span>
                            </div>
                            <div class="text-[10px] text-slate-400 mt-0.5">Drive yourself across Nepal</div>
                        </button>
                    </div>
                </div>

                <!-- Booking Form -->
                <form wire:submit.prevent="confirmBooking" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Full Name *</label>
                            <input
                                type="text"
                                wire:model="customerName"
                                placeholder="e.g. Ramesh Shrestha"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none"
                            />
                            @error('customerName') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Mobile / WhatsApp Number *</label>
                            <input
                                type="text"
                                wire:model="customerPhone"
                                placeholder="+977 98XXXXXXXX"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none"
                            />
                            @error('customerPhone') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Email Address *</label>
                            <input
                                type="email"
                                wire:model="customerEmail"
                                placeholder="name@domain.com"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none"
                            />
                            @error('customerEmail') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Pickup Hotel / Landmark</label>
                            <input
                                type="text"
                                wire:model="pickupAddress"
                                placeholder="e.g. Tribhuvan Airport Gate or Hotel"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none"
                            />
                        </div>
                    </div>

                    <!-- Payment Option -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-2">Payment Preference in Nepal</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center gap-3 p-3 rounded-xl bg-slate-800/80 border border-white/10 cursor-pointer hover:border-emerald-500/40">
                                <input type="radio" wire:model="paymentMethod" value="cash" class="text-emerald-500 focus:ring-0">
                                <div>
                                    <div class="text-xs font-bold text-white">Cash on Pickup</div>
                                    <div class="text-[10px] text-slate-400">Pay directly upon vehicle handover</div>
                                </div>
                            </label>
                            <label class="flex items-center gap-3 p-3 rounded-xl bg-slate-800/80 border border-white/10 cursor-pointer hover:border-emerald-500/40">
                                <input type="radio" wire:model="paymentMethod" value="esewa" class="text-emerald-500 focus:ring-0">
                                <div>
                                    <div class="text-xs font-bold text-white">eSewa / Digital QR</div>
                                    <div class="text-[10px] text-slate-400">Scan QR upon car handover</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Special Requests -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1">Special Requests / Route Notes</label>
                        <textarea
                            wire:model="specialRequests"
                            rows="2"
                            placeholder="Flight number, extra luggage space, child seat, or mountain tour plan..."
                            class="w-full px-4 py-2 rounded-xl bg-slate-800 border border-white/10 text-white text-xs focus:border-emerald-500 outline-none"
                        ></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4 flex items-center justify-between border-t border-white/10">
                        <div class="text-xs text-slate-400">
                            ✓ Free cancellation up to 48h before pickup
                        </div>
                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            class="px-6 py-3.5 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black text-sm shadow-xl shadow-emerald-500/25 transition flex items-center gap-2 cursor-pointer"
                        >
                            <span wire:loading.remove>Confirm Reservation</span>
                            <span wire:loading>Processing...</span>
                            <svg wire:loading.remove class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Price Alert Modal Component -->
    @if($showAlertModal)
        <livewire:price-alert-modal 
            :pickupLocationId="$pickup"
            :dropoffLocationId="$dropoff"
            :pickupDatetime="$from"
            :dropoffDatetime="$to"
            :currentBestPriceMinor="$lowestPrice" />
    @endif
</div>
