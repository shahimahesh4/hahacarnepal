<div class="space-y-8" x-data="{ init() { window.addEventListener('scroll-to-fleet', () => { document.getElementById('fleet-results')?.scrollIntoView({ behavior: 'smooth' }); }); } }">
    <!-- Service Option & Location Selection Card -->
    <div class="relative rounded-3xl bg-gradient-to-b from-[#0e172e] to-[#080e22] border border-slate-700/80 p-6 md:p-8 backdrop-blur-xl shadow-2xl shadow-black/50 ring-1 ring-white/5">
        <!-- Top Mode Controls: Service Mode + Pricing Type Switcher -->
        <div class="flex flex-wrap items-center justify-between gap-4 pb-6 border-b border-slate-800/80">
            <!-- Mode Tabs: With Driver vs Self-Drive -->
            <div class="inline-flex p-1.5 rounded-2xl bg-slate-950/90 border border-slate-800/90 shadow-inner">
                <button
                    type="button"
                    wire:click="$set('serviceOption', 'with_driver')"
                    class="flex items-center gap-2 px-4 sm:px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all duration-200 cursor-pointer {{ $serviceOption === 'with_driver' ? 'bg-gradient-to-r from-emerald-500 to-teal-500 text-slate-950 shadow-lg shadow-emerald-500/25 scale-[1.02]' : 'text-slate-400 hover:text-white' }}"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>With Driver</span>
                    <span class="hidden sm:inline-block px-2 py-0.5 text-[10px] uppercase tracking-wider rounded-full {{ $serviceOption === 'with_driver' ? 'bg-slate-950/25 text-slate-950' : 'bg-emerald-500/20 text-emerald-400' }} font-black">Popular</span>
                </button>
                <button
                    type="button"
                    wire:click="$set('serviceOption', 'self_drive')"
                    class="flex items-center gap-2 px-4 sm:px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all duration-200 cursor-pointer {{ $serviceOption === 'self_drive' ? 'bg-gradient-to-r from-emerald-500 to-teal-500 text-slate-950 shadow-lg shadow-emerald-500/25 scale-[1.02]' : 'text-slate-400 hover:text-white' }}"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                    <span>Self-Drive Rental</span>
                </button>
            </div>

            <!-- Pricing Mode Switcher: Daily vs Distance (KM) -->
            <div class="inline-flex p-1.5 rounded-2xl bg-slate-950/90 border border-slate-800/90 shadow-inner">
                <button
                    type="button"
                    wire:click="setPricingType('daily')"
                    class="flex items-center gap-2 px-3.5 sm:px-4 py-2.5 rounded-xl text-xs font-bold transition-all duration-200 cursor-pointer {{ $pricingType === 'daily' ? 'bg-emerald-500 text-slate-950 shadow-md shadow-emerald-500/25' : 'text-slate-400 hover:text-white' }}"
                >
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" stroke-width="2" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 2v4M8 2v4M3 10h18" />
                    </svg>
                    <span>Daily Rental</span>
                </button>
                <button
                    type="button"
                    wire:click="setPricingType('distance')"
                    class="flex items-center gap-2 px-3.5 sm:px-4 py-2.5 rounded-xl text-xs font-bold transition-all duration-200 cursor-pointer {{ $pricingType === 'distance' ? 'bg-emerald-500 text-slate-950 shadow-md shadow-emerald-500/25' : 'text-slate-400 hover:text-white' }}"
                >
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <span>Distance (Per KM)</span>
                    <span class="px-1.5 py-0.5 text-[9px] uppercase tracking-wider rounded-md {{ $pricingType === 'distance' ? 'bg-slate-950 text-emerald-400' : 'bg-emerald-500/20 text-emerald-400' }} font-black">EV Rs. {{ $rateElectric }}/km</span>
                </button>
            </div>
        </div>

        <!-- Search & Booking Controls Grid -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-12 gap-5 items-end">
            <!-- Pickup Station -->
            <div class="{{ $pricingType === 'daily' ? 'md:col-span-3' : 'md:col-span-4' }}">
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 flex items-center gap-1.5">
                        <span>Pickup Hub</span> <span class="text-emerald-400">*</span>
                    </label>
                    @if ($locationMode === 'google_maps' && !empty($googleMapsApiKey))
                        <span class="text-[9px] text-emerald-400 font-bold px-1.5 py-0.5 rounded bg-emerald-500/15 border border-emerald-500/30">Google Maps API</span>
                    @else
                        <span class="text-[9px] text-slate-400 font-bold px-1.5 py-0.5 rounded bg-slate-800 border border-slate-700">Hub Network</span>
                    @endif
                </div>

                @if ($locationMode === 'google_maps' && !empty($googleMapsApiKey))
                    <div
                        x-data="{
                            initPickup() {
                                if (typeof google === 'undefined' || !google.maps || !google.maps.places) return;
                                const autocomplete = new google.maps.places.Autocomplete(this.$refs.pickupInput, {
                                    componentRestrictions: { country: '{{ $googleMapsCountry ?: 'np' }}' },
                                    fields: ['formatted_address', 'name']
                                });
                                autocomplete.addListener('place_changed', () => {
                                    const place = autocomplete.getPlace();
                                    const val = place.formatted_address || place.name || this.$refs.pickupInput.value;
                                    @this.set('pickupLocation', val);
                                });
                            }
                        }"
                        x-init="initPickup()"
                        class="relative flex items-center"
                    >
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <input
                            x-ref="pickupInput"
                            type="text"
                            wire:model.lazy="pickupLocation"
                            placeholder="Type any address, hotel, or landmark in Nepal..."
                            class="w-full input-with-left-icon pl-14 pr-4 py-3.5 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition placeholder-slate-500"
                            style="padding-left: 56px !important;"
                        />
                    </div>
                @else
                    <div class="relative flex items-center">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <select
                            wire:model.live="pickupLocation"
                            class="w-full input-with-left-icon pl-14 pr-10 py-3.5 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none appearance-none transition cursor-pointer"
                            style="padding-left: 56px !important;"
                        >
                            @foreach ($popularLocations as $loc)
                                <option value="{{ $loc }}">{{ $loc }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Return Station (if different) -->
            <div class="{{ $pricingType === 'daily' ? 'md:col-span-3' : 'md:col-span-4' }}">
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 flex items-center gap-1.5">
                        <span>Return Location</span> <span class="text-emerald-400">*</span>
                    </label>
                    <button
                        type="button"
                        wire:click="$toggle('sameDropoff')"
                        class="text-[11px] text-emerald-400 hover:text-emerald-300 font-bold cursor-pointer transition hover:underline"
                    >
                        {{ $sameDropoff ? '+ Different Drop-off' : 'Same as pickup' }}
                    </button>
                </div>
                @if ($sameDropoff)
                    <div class="w-full pl-5 pr-4 py-3.5 rounded-2xl bg-slate-900/50 border border-slate-700/50 text-slate-400 text-sm flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="truncate">Same as pickup ({{ Str::limit($pickupLocation, 22) }})</span>
                    </div>
                @elseif ($locationMode === 'google_maps' && !empty($googleMapsApiKey))
                    <div
                        x-data="{
                            initReturn() {
                                if (typeof google === 'undefined' || !google.maps || !google.maps.places) return;
                                const autocomplete = new google.maps.places.Autocomplete(this.$refs.returnInput, {
                                    componentRestrictions: { country: '{{ $googleMapsCountry ?: 'np' }}' },
                                    fields: ['formatted_address', 'name']
                                });
                                autocomplete.addListener('place_changed', () => {
                                    const place = autocomplete.getPlace();
                                    const val = place.formatted_address || place.name || this.$refs.returnInput.value;
                                    @this.set('returnLocation', val);
                                });
                            }
                        }"
                        x-init="initReturn()"
                        class="relative flex items-center"
                    >
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <input
                            x-ref="returnInput"
                            type="text"
                            wire:model.lazy="returnLocation"
                            placeholder="Type return destination in Nepal..."
                            class="w-full input-with-left-icon pl-14 pr-4 py-3.5 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition placeholder-slate-500"
                            style="padding-left: 56px !important;"
                        />
                    </div>
                @else
                    <div class="relative flex items-center">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <select
                            wire:model.live="returnLocation"
                            class="w-full input-with-left-icon pl-14 pr-10 py-3.5 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none appearance-none transition cursor-pointer"
                            style="padding-left: 56px !important;"
                        >
                            @foreach ($popularLocations as $loc)
                                <option value="{{ $loc }}">{{ $loc }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Mode Dependent Input: Daily Dates OR Distance Input -->
            @if ($pricingType === 'daily')
                <!-- Rental Duration & Dates -->
                <div class="md:col-span-4 grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">Pickup Date</label>
                        <input
                            type="date"
                            wire:model.live="pickupDate"
                            min="{{ date('Y-m-d') }}"
                            class="w-full px-3.5 py-3.5 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none cursor-pointer transition"
                        />
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">Return Date</label>
                        <input
                            type="date"
                            wire:model.live="returnDate"
                            min="{{ $pickupDate }}"
                            class="w-full px-3.5 py-3.5 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none cursor-pointer transition"
                        />
                    </div>
                </div>
            @else
                <!-- Estimated Distance Controller (KM) -->
                <div class="md:col-span-2">
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-300">
                            Trip Distance
                        </label>
                        <span class="text-[10px] text-emerald-400 font-bold">Estimated</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <button
                            type="button"
                            wire:click="decrementDistance(25)"
                            class="w-10 h-12 rounded-2xl bg-slate-800 hover:bg-slate-700 text-white font-black text-base flex items-center justify-center border border-slate-700/80 transition cursor-pointer active:scale-95"
                            title="Subtract 25 km"
                        >
                            -
                        </button>
                        <div class="relative flex-1">
                            <input
                                type="number"
                                wire:model.live="estimatedDistanceKm"
                                min="10"
                                max="3000"
                                class="w-full px-2 py-3 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-center font-black text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none"
                            />
                            <span class="absolute right-2.5 top-3.5 text-[10px] text-slate-400 font-bold pointer-events-none">KM</span>
                        </div>
                        <button
                            type="button"
                            wire:click="incrementDistance(25)"
                            class="w-10 h-12 rounded-2xl bg-slate-800 hover:bg-slate-700 text-white font-black text-base flex items-center justify-center border border-slate-700/80 transition cursor-pointer active:scale-95"
                            title="Add 25 km"
                        >
                            +
                        </button>
                    </div>
                </div>
            @endif

            <!-- Search & Filter Submit Button -->
            <div class="{{ $pricingType === 'daily' ? 'md:col-span-2' : 'md:col-span-2' }}">
                <button
                    type="button"
                    wire:click="searchFleet"
                    wire:loading.attr="disabled"
                    class="w-full py-3.5 px-4 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 active:scale-[0.99] text-slate-950 font-black text-sm shadow-xl shadow-emerald-500/25 hover:shadow-emerald-500/35 transition-all flex items-center justify-center gap-2 cursor-pointer group"
                >
                    <span wire:loading.remove wire:target="searchFleet" class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-950 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <span>Search Fleet</span>
                    </span>
                    <span wire:loading wire:target="searchFleet" class="flex items-center gap-1.5 text-xs">
                        <svg class="animate-spin w-4 h-4 text-slate-950" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        <span>Searching...</span>
                    </span>
                </button>
            </div>
        </div>

        <!-- Interactive Quick Hubs & Distance Rate Info Bar -->
        <div class="mt-5 pt-5 border-t border-slate-800/80 flex flex-wrap items-center justify-between gap-3">
            <div class="flex flex-wrap items-center gap-2">
                <span class="text-xs text-slate-400 font-bold uppercase tracking-wider mr-1">Quick Hubs:</span>
                @foreach (['✈️ KTM Airport' => 'Tribhuvan International Airport (KTM)', '🏔️ Pokhara PKR' => 'Pokhara International Airport (PKR)', '🛍️ Thamel' => 'Thamel Tourist Hub, Kathmandu', '⛵ Lakeside' => 'Lakeside, Pokhara', '🦏 Chitwan' => 'Sauraha Tourist Center, Chitwan'] as $chipLabel => $chipLoc)
                    <button
                        type="button"
                        wire:click="$set('pickupLocation', '{{ $chipLoc }}'); searchFleet();"
                        class="px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-900/80 hover:bg-emerald-500/20 text-slate-300 hover:text-emerald-300 border border-slate-700/80 hover:border-emerald-500/30 transition cursor-pointer active:scale-95"
                    >
                        {{ $chipLabel }}
                    </button>
                @endforeach
            </div>

            <!-- Dynamic Pricing Indicator Pill -->
            @if ($pricingType === 'distance')
                <div class="flex flex-wrap items-center gap-2 text-xs">
                    <span class="text-slate-400 font-semibold">Fuel Base:</span>
                    <span class="px-2.5 py-1 rounded-lg bg-emerald-500/15 text-emerald-300 border border-emerald-500/30 font-bold">
                        ⚡ EV: Rs. {{ $rateElectric }}/km
                    </span>
                    <span class="px-2.5 py-1 rounded-lg bg-slate-900 text-slate-300 border border-slate-700 font-medium">
                        ⛽ Petrol: Rs. {{ $ratePetrol }}/km
                    </span>
                    <span class="px-2.5 py-1 rounded-lg bg-slate-900 text-slate-300 border border-slate-700 font-medium">
                        🛢️ Diesel: Rs. {{ $rateDiesel }}/km
                    </span>
                    <span class="px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 font-black">
                        Trip: {{ $estimatedDistanceKm }} km
                    </span>
                </div>
            @else
                <div class="text-xs text-emerald-400 font-bold bg-emerald-500/10 px-3.5 py-1.5 rounded-full border border-emerald-500/20">
                    Duration: {{ $totalDays }} {{ Str::plural('Day', $totalDays) }} Rental
                </div>
            @endif
        </div>
    </div>

    <!-- Live Search Results Header Banner -->
    <div id="fleet-results" class="scroll-mt-28 p-5 rounded-3xl bg-gradient-to-r from-slate-900/95 via-slate-900/90 to-slate-950/95 border border-emerald-500/30 backdrop-blur-md shadow-xl flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3.5">
            <span class="w-3 h-3 rounded-full bg-emerald-400 animate-pulse shrink-0"></span>
            <div>
                <div class="text-sm sm:text-base font-black text-white flex flex-wrap items-center gap-2">
                    <span>{{ $vehicles->count() }} Available {{ $serviceOption === 'with_driver' ? 'With-Driver' : 'Self-Drive' }} Vehicles</span>
                    <span class="px-2.5 py-0.5 rounded-md text-[10px] uppercase font-black bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                        {{ $currentCity }} Hub
                    </span>
                </div>
                <div class="text-xs text-slate-400 mt-1 flex flex-wrap items-center gap-1.5">
                    <span>Pickup: <strong class="text-slate-200">{{ $pickupLocation }}</strong></span>
                    @if (!$sameDropoff)
                        <span>→ Dropoff: <strong class="text-slate-200">{{ $returnLocation }}</strong></span>
                    @endif
                    <span>•</span>
                    <span class="text-emerald-400 font-bold">{{ $pricingType === 'daily' ? $totalDays . ' Days Rental' : $estimatedDistanceKm . ' KM Distance Trip' }}</span>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2">
            @if ($hasSearched)
                <span class="text-xs text-emerald-400 font-bold bg-emerald-500/10 px-3 py-1.5 rounded-xl border border-emerald-500/20 flex items-center gap-1">
                    <span>✓</span> Results Updated
                </span>
            @endif
        </div>
    </div>

    <!-- Category Filter Tabs & Options -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-2">
            @php
                $categories = [
                    'all' => 'All Vehicles',
                    'suv_4wd' => '🏔️ 4WD SUVs & Jeeps',
                    'tourist_van' => '🚐 Tourist Vans (HiAce)',
                    'compact_suv' => '🚙 Compact SUVs & EVs',
                    'sedan' => '🚗 Sedans',
                    'hatchback' => '⚡ City Hatchbacks',
                    'luxury_suv' => '👑 Luxury 4WD',
                ];
            @endphp
            @foreach ($categories as $catKey => $catLabel)
                <button
                    type="button"
                    wire:click="$set('selectedCategory', '{{ $catKey }}')"
                    class="px-4 py-2.5 rounded-2xl text-xs font-bold transition-all cursor-pointer {{ $selectedCategory === $catKey ? 'bg-gradient-to-r from-emerald-500 to-teal-500 text-slate-950 font-black shadow-lg shadow-emerald-500/25 scale-105' : 'bg-slate-900/80 text-slate-400 hover:text-white border border-slate-700/80 hover:border-slate-600' }}"
                >
                    {{ $catLabel }}
                </button>
            @endforeach
        </div>

        <div class="flex items-center gap-3">
            <label class="inline-flex items-center gap-2 text-xs font-bold text-slate-300 cursor-pointer bg-slate-900/80 px-3.5 py-2 rounded-2xl border border-slate-700/80 hover:border-emerald-500/30 transition">
                <input type="checkbox" wire:model.live="filter4wd" class="rounded border-slate-700 bg-slate-900 text-emerald-500 focus:ring-0">
                <span>⛰️ 4WD Mountain Ready Only</span>
            </label>
        </div>
    </div>

    <!-- Vehicle Results Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($vehicles as $vehicle)
            <div class="group relative rounded-3xl bg-gradient-to-b from-[#0e172e] to-[#070d1e] border border-slate-700/80 hover:border-emerald-500/50 p-5 transition-all duration-300 hover:shadow-2xl hover:shadow-emerald-500/10 hover:-translate-y-1 flex flex-col justify-between backdrop-blur-md ring-1 ring-white/5">
                <div>
                    <!-- Vehicle Image & Badges -->
                    <div class="relative h-48 sm:h-52 w-full rounded-2xl overflow-hidden bg-gradient-to-b from-slate-900/80 via-slate-950/90 to-slate-950 border border-slate-800 flex items-center justify-center p-3 mb-4">
                        <img
                            src="{{ $vehicle->photo_url }}"
                            alt="{{ $vehicle->title }}"
                            loading="lazy"
                            decoding="async"
                            class="h-full w-full object-contain group-hover:scale-105 transition-transform duration-500"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-transparent pointer-events-none"></div>

                        <!-- Top Badges -->
                        <div class="absolute top-3 left-3 flex flex-wrap gap-1.5">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-slate-900/90 text-emerald-400 border border-emerald-500/30 backdrop-blur-md">
                                {{ $vehicle->category_label }}
                            </span>
                            @if ($vehicle->has_4wd)
                                <span class="px-2 py-1 rounded-lg text-[10px] font-black uppercase bg-amber-500/20 text-amber-300 border border-amber-500/30 backdrop-blur-md">
                                    4WD / 4x4
                                </span>
                            @endif
                            <span class="px-2 py-1 rounded-lg text-[10px] font-black uppercase bg-slate-900/90 text-teal-300 border border-teal-500/30 backdrop-blur-md">
                                {{ $vehicle->fuel_badge }}
                            </span>
                        </div>

                        <!-- Service Option Indicator -->
                        <div class="absolute bottom-3 left-3 text-xs text-white font-medium flex items-center gap-1.5">
                            @if ($serviceOption === 'with_driver')
                                <span class="px-2.5 py-1 rounded-md bg-emerald-500 text-slate-950 font-black text-[10px] tracking-wide shadow-sm">
                                    DRIVER INCLUDED
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-md bg-blue-500 text-white font-black text-[10px] tracking-wide shadow-sm">
                                    SELF-DRIVE RENTAL
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Vehicle Header & Partner Info -->
                    <div class="flex items-start justify-between gap-2 mb-2">
                        <div>
                            <h3 class="text-lg sm:text-xl font-black text-white group-hover:text-emerald-300 transition-colors">
                                {{ $vehicle->title }}
                            </h3>
                            <p class="text-xs text-slate-400 flex items-center gap-1.5 mt-0.5">
                                @if ($vehicle->show_plate_number && !empty($vehicle->plate_number))
                                    <span class="font-mono bg-slate-800/90 border border-slate-700/60 px-1.5 py-0.5 rounded text-slate-300">Plate: {{ $vehicle->plate_number }}</span>
                                    <span>•</span>
                                @endif
                                <span>Year {{ $vehicle->year }}</span>
                            </p>
                        </div>

                        @if ($vehicle->driverProfile)
                            <div class="text-right shrink-0">
                                <div class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-xs font-bold">
                                    <span>{{ $vehicle->driverProfile->rating }}</span>
                                    <span class="text-amber-400">★</span>
                                </div>
                                <div class="text-[10px] text-slate-400 mt-1">
                                    {{ $vehicle->driverProfile->user->name ?? 'Verified Partner' }}
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Specs Bar -->
                    <div class="grid grid-cols-4 gap-2 py-3 border-y border-slate-800/80 my-3 text-center bg-slate-950/60 rounded-2xl">
                        <div>
                            <span class="block text-xs font-black text-white">{{ $vehicle->seating_capacity }}</span>
                            <span class="text-[10px] text-slate-400 font-semibold">Seats</span>
                        </div>
                        <div>
                            <span class="block text-xs font-black text-white">{{ $vehicle->luggage_capacity }}</span>
                            <span class="text-[10px] text-slate-400 font-semibold">Bags</span>
                        </div>
                        <div>
                            <span class="block text-xs font-black text-white uppercase">{{ $vehicle->transmission }}</span>
                            <span class="text-[10px] text-slate-400 font-semibold">Gear</span>
                        </div>
                        <div>
                            <span class="block text-xs font-black text-emerald-400 uppercase">{{ $vehicle->fuel_type }}</span>
                            <span class="text-[10px] text-slate-400 font-semibold">{{ $vehicle->formatted_rate_per_km }}</span>
                        </div>
                    </div>
                </div>

                <!-- Price & CTA Button -->
                <div class="pt-3 flex items-center justify-between border-t border-slate-800/80">
                    <div>
                        @if ($pricingType === 'distance')
                            <div class="text-[11px] text-slate-400 font-semibold">Distance Rate</div>
                            <div class="text-xl font-black text-emerald-400">
                                {{ $vehicle->formatted_rate_per_km }}
                            </div>
                            <div class="text-[11px] text-slate-300 font-bold mt-0.5">
                                Total: Rs. {{ number_format($vehicle->calculatePriceForDistance($estimatedDistanceKm)) }}
                            </div>
                        @else
                            <div class="text-[11px] text-slate-400 font-semibold">Daily Rate</div>
                            <div class="text-xl font-black text-white">
                                {{ $vehicle->formatted_daily_rate }}
                                <span class="text-xs font-normal text-slate-400">/day</span>
                            </div>
                            <div class="text-[11px] text-emerald-400 font-bold mt-0.5">
                                Total: Rs. {{ number_format($vehicle->daily_rate * $totalDays) }} ({{ $totalDays }} {{ Str::plural('day', $totalDays) }})
                            </div>
                        @endif
                    </div>

                    <button
                        type="button"
                        wire:click="selectVehicle({{ $vehicle->id }})"
                        class="px-5 py-3 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black text-sm shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 transition-all flex items-center gap-2 group-hover:scale-105 cursor-pointer active:scale-[0.99]"
                    >
                        <span>Book Now</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-3xl bg-slate-900/60 border border-slate-700/80 p-12 text-center">
                <div class="w-16 h-16 rounded-full bg-slate-800/90 mx-auto flex items-center justify-center text-slate-400 mb-4 border border-slate-700">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">No vehicles match your filter</h3>
                <p class="text-sm text-slate-400 mb-4">Try selecting "All Vehicles" or toggling the 4WD filter off.</p>
                <button
                    type="button"
                    wire:click="$set('selectedCategory', 'all'); $set('filter4wd', false);"
                    class="px-6 py-2.5 rounded-2xl bg-emerald-500/20 text-emerald-300 font-bold text-xs border border-emerald-500/30 hover:bg-emerald-500/30 transition cursor-pointer"
                >
                    Reset Filters
                </button>
            </div>
        @endforelse
    </div>

    <!-- Booking Confirmation Modal -->
    @if ($isBookingModalOpen && $selectedVehicle)
        <div class="fixed inset-0 z-50 overflow-y-auto bg-black/85 backdrop-blur-xl flex items-center justify-center p-4 sm:p-6">
            <div class="relative w-full max-w-2xl rounded-3xl bg-gradient-to-b from-[#0e172e] to-[#070d1e] border border-slate-700/80 p-6 sm:p-8 shadow-2xl overflow-hidden ring-1 ring-white/10">
                <!-- Ambient Glow inside modal -->
                <div class="absolute -top-12 -right-12 w-40 h-40 bg-emerald-500/15 rounded-full blur-3xl pointer-events-none"></div>

                <!-- Close Button -->
                <button
                    type="button"
                    wire:click="closeModal"
                    class="absolute top-6 right-6 w-9 h-9 rounded-full bg-slate-800/90 hover:bg-slate-700 text-slate-400 hover:text-white flex items-center justify-center transition border border-slate-700 cursor-pointer"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Modal Header -->
                <div class="mb-6">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 mb-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Direct Reservation Voucher</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black text-white">Reserve Your Vehicle</h2>
                    <p class="text-xs sm:text-sm text-slate-400 mt-1">Book directly with our verified local partner in Nepal. Pay on pickup.</p>
                </div>

                <!-- Vehicle Summary Card -->
                <div class="p-4 sm:p-5 rounded-2xl bg-slate-950/80 border border-slate-800 flex items-center gap-4 mb-6">
                    <img
                        src="{{ $selectedVehicle->photo_url }}"
                        alt="{{ $selectedVehicle->title }}"
                        class="w-24 h-16 rounded-xl object-contain bg-slate-900/90 p-1 border border-slate-700/80 shrink-0"
                    />
                    <div class="flex-1 min-w-0">
                        <div class="font-black text-white text-base truncate">{{ $selectedVehicle->title }}</div>
                        <div class="text-xs text-slate-400 mt-0.5">
                            {{ $selectedVehicle->category_label }}
                            @if ($selectedVehicle->show_plate_number && !empty($selectedVehicle->plate_number))
                                • <span class="font-mono text-slate-300">Plate: {{ $selectedVehicle->plate_number }}</span>
                            @endif
                            • {{ $selectedVehicle->fuel_badge }}
                        </div>
                        <div class="text-xs text-emerald-400 font-semibold mt-1">
                            {{ $serviceOption === 'with_driver' ? '✓ Professional Driver Included' : '✓ Self-Drive Rental' }}
                        </div>
                    </div>
                    <div class="text-right shrink-0">
                        @if ($pricingType === 'distance')
                            <div class="text-xs text-slate-400">{{ $estimatedDistanceKm }} km @ {{ $selectedVehicle->formatted_rate_per_km }}</div>
                            <div class="text-lg font-black text-emerald-400">Rs. {{ number_format($selectedVehicle->calculatePriceForDistance($estimatedDistanceKm)) }}</div>
                        @else
                            <div class="text-xs text-slate-400">{{ $totalDays }} {{ Str::plural('Day', $totalDays) }}</div>
                            <div class="text-lg font-black text-white">Rs. {{ number_format($selectedVehicle->daily_rate * $totalDays) }}</div>
                        @endif
                    </div>
                </div>

                <!-- Booking Form -->
                <form wire:submit.prevent="confirmBooking" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Customer Name -->
                        <div>
                            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">
                                Full Name <span class="text-emerald-400">*</span>
                            </label>
                            <div class="relative flex items-center">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <input
                                    type="text"
                                    wire:model="customerName"
                                    placeholder="e.g. Ramesh Shrestha"
                                    class="w-full input-with-left-icon pl-14 pr-4 py-3 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition placeholder-slate-500"
                                    style="padding-left: 56px !important;"
                                    required
                                />
                            </div>
                            @error('customerName') <span class="text-rose-400 text-xs mt-1.5 block font-semibold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Mobile / WhatsApp -->
                        <div>
                            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">
                                Mobile / WhatsApp Number <span class="text-emerald-400">*</span>
                            </label>
                            <div class="relative flex items-center">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <input
                                    type="text"
                                    wire:model="customerPhone"
                                    placeholder="+977 98XXXXXXXX"
                                    class="w-full input-with-left-icon pl-14 pr-4 py-3 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition placeholder-slate-500"
                                    style="padding-left: 56px !important;"
                                    required
                                />
                            </div>
                            @error('customerPhone') <span class="text-rose-400 text-xs mt-1.5 block font-semibold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Email Address -->
                        <div>
                            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">
                                Email Address <span class="text-emerald-400">*</span>
                            </label>
                            <div class="relative flex items-center">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                        <rect x="3" y="5" width="18" height="14" rx="2" stroke-width="1.75" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 7l9 6 9-6" />
                                    </svg>
                                </div>
                                <input
                                    type="email"
                                    wire:model="customerEmail"
                                    placeholder="name@domain.com"
                                    class="w-full input-with-left-icon pl-14 pr-4 py-3 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition placeholder-slate-500"
                                    style="padding-left: 56px !important;"
                                    required
                                />
                            </div>
                            @error('customerEmail') <span class="text-rose-400 text-xs mt-1.5 block font-semibold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Pickup Hotel / Landmark -->
                        <div>
                            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">
                                Pickup Hotel / Landmark
                            </label>
                            <div class="relative flex items-center">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <input
                                    type="text"
                                    wire:model="pickupAddress"
                                    placeholder="e.g. Hotel Yak & Yeti or Arrival Gate"
                                    class="w-full input-with-left-icon pl-14 pr-4 py-3 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition placeholder-slate-500"
                                    style="padding-left: 56px !important;"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Payment Option -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2.5">
                            Payment Preference in Nepal
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            @if ($enableCash)
                                <label class="flex items-center gap-3 p-3.5 rounded-2xl bg-slate-900/90 border cursor-pointer transition {{ $paymentMethod === 'cash' ? 'border-emerald-500 ring-2 ring-emerald-500/20 bg-emerald-500/5' : 'border-slate-700/80 hover:border-slate-600' }}">
                                    <input type="radio" wire:model="paymentMethod" value="cash" class="text-emerald-500 focus:ring-0 bg-slate-900 border-slate-700">
                                    <div>
                                        <div class="text-xs font-bold text-white">Cash on Pickup</div>
                                        <div class="text-[10px] text-slate-400">Pay upon handover</div>
                                    </div>
                                </label>
                            @endif
                            @if ($enableEsewa)
                                <label class="flex items-center gap-3 p-3.5 rounded-2xl bg-slate-900/90 border cursor-pointer transition {{ $paymentMethod === 'esewa' ? 'border-emerald-500 ring-2 ring-emerald-500/20 bg-emerald-500/5' : 'border-slate-700/80 hover:border-slate-600' }}">
                                    <input type="radio" wire:model="paymentMethod" value="esewa" class="text-emerald-500 focus:ring-0 bg-slate-900 border-slate-700">
                                    <div>
                                        <div class="text-xs font-bold text-emerald-400">eSewa QR</div>
                                        <div class="text-[10px] text-slate-400">Digital wallet / QR</div>
                                    </div>
                                </label>
                            @endif
                            @if ($enableKhalti)
                                <label class="flex items-center gap-3 p-3.5 rounded-2xl bg-slate-900/90 border cursor-pointer transition {{ $paymentMethod === 'khalti' ? 'border-purple-500 ring-2 ring-purple-500/20 bg-purple-500/5' : 'border-slate-700/80 hover:border-slate-600' }}">
                                    <input type="radio" wire:model="paymentMethod" value="khalti" class="text-purple-500 focus:ring-0 bg-slate-900 border-slate-700">
                                    <div>
                                        <div class="text-xs font-bold text-purple-400">Khalti Wallet</div>
                                        <div class="text-[10px] text-slate-400">Instant digital pay</div>
                                    </div>
                                </label>
                            @endif
                        </div>
                    </div>

                    <!-- Special Requests -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">
                            Special Requests / Flight Notes
                        </label>
                        <textarea
                            wire:model="specialRequests"
                            rows="2"
                            placeholder="Luggage requirements, child seat, flight number, or mountain trekking details..."
                            class="w-full px-4 py-3 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-xs focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition placeholder-slate-500"
                        ></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4 flex flex-wrap items-center justify-between gap-3 border-t border-slate-800/80">
                        <div class="text-xs text-slate-400 flex items-center gap-1.5">
                            <span class="text-emerald-400 font-bold">✓</span>
                            <span>Free cancellation up to 24h before pickup</span>
                        </div>
                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            class="px-8 py-3.5 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black text-sm shadow-xl shadow-emerald-500/25 hover:shadow-emerald-500/35 transition flex items-center gap-2 cursor-pointer active:scale-[0.99]"
                        >
                            <span wire:loading.remove>Confirm Reservation</span>
                            <span wire:loading>Processing...</span>
                            <svg wire:loading.remove class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if ($locationMode === 'google_maps' && !empty($googleMapsApiKey))
        <script src="https://maps.googleapis.com/maps/api/js?key={{ $googleMapsApiKey }}&libraries=places" async defer></script>
    @endif
</div>
