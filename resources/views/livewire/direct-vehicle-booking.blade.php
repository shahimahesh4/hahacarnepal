<div class="space-y-8">
    <!-- Service Option & Location Selection Card -->
    <div class="relative rounded-3xl bg-slate-900/95 border border-white/10 p-6 md:p-8 backdrop-blur-xl shadow-2xl shadow-black/50">
        <!-- Mode Tabs: With Driver vs Self-Drive -->
        <div class="flex flex-wrap items-center justify-between gap-4 pb-6 border-b border-white/10">
            <div class="inline-flex p-1.5 rounded-2xl bg-slate-950/90 border border-white/10 shadow-inner">
                <button
                    type="button"
                    wire:click="$set('serviceOption', 'with_driver')"
                    class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ $serviceOption === 'with_driver' ? 'bg-gradient-to-r from-emerald-500 to-teal-500 text-slate-950 font-bold shadow-lg shadow-emerald-500/25 scale-[1.02]' : 'text-slate-400 hover:text-white' }}"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>With Driver (Chauffeur)</span>
                    <span class="px-2 py-0.5 text-[10px] uppercase tracking-wider rounded-full bg-emerald-400/20 text-emerald-950 font-black">Popular</span>
                </button>
                <button
                    type="button"
                    wire:click="$set('serviceOption', 'self_drive')"
                    class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ $serviceOption === 'self_drive' ? 'bg-gradient-to-r from-emerald-500 to-teal-500 text-slate-950 font-bold shadow-lg shadow-emerald-500/25 scale-[1.02]' : 'text-slate-400 hover:text-white' }}"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                    <span>Self-Drive Rental</span>
                </button>
            </div>

            <div class="flex items-center gap-2 text-xs text-slate-400">
                <span class="inline-flex w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Verified Nepal Partner Fleet • Instant Confirmation in NPR</span>
            </div>
        </div>

        <!-- Search & Booking Controls -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-12 gap-4">
            <!-- Pickup Station -->
            <div class="md:col-span-4">
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5 flex items-center gap-1.5">
                    <span class="text-emerald-400">📍</span> Pickup Hub in Nepal
                </label>
                <div class="relative">
                    <select
                        wire:model.live="pickupLocation"
                        class="w-full pl-10 pr-8 py-3.5 rounded-2xl bg-slate-800/90 border border-white/10 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition cursor-pointer"
                    >
                        @foreach ($popularLocations as $loc)
                            <option value="{{ $loc }}">{{ $loc }}</option>
                        @endforeach
                    </select>
                    <div class="absolute left-3.5 top-3.5 text-emerald-400 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Return Station (if different) -->
            <div class="md:col-span-4">
                <div class="flex items-center justify-between mb-1.5">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 flex items-center gap-1.5">
                        <span class="text-amber-400">🔄</span> Return Location
                    </label>
                    <button
                        type="button"
                        wire:click="$toggle('sameDropoff')"
                        class="text-[11px] text-emerald-400 hover:underline font-semibold cursor-pointer"
                    >
                        {{ $sameDropoff ? '+ Different Drop-off' : 'Same as pickup' }}
                    </button>
                </div>
                @if ($sameDropoff)
                    <div class="w-full pl-4 pr-4 py-3.5 rounded-2xl bg-slate-800/40 border border-white/5 text-slate-400 text-sm flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Same as pickup ({{ Str::limit($pickupLocation, 28) }})</span>
                    </div>
                @else
                    <select
                        wire:model.live="returnLocation"
                        class="w-full pl-4 pr-8 py-3.5 rounded-2xl bg-slate-800/90 border border-white/10 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition cursor-pointer"
                    >
                        @foreach ($popularLocations as $loc)
                            <option value="{{ $loc }}">{{ $loc }}</option>
                        @endforeach
                    </select>
                @endif
            </div>

            <!-- Rental Duration & Dates -->
            <div class="md:col-span-4 grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Pickup Date</label>
                    <input
                        type="date"
                        wire:model.live="pickupDate"
                        min="{{ date('Y-m-d') }}"
                        class="w-full px-3 py-3 rounded-2xl bg-slate-800/90 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none cursor-pointer"
                    />
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Return Date</label>
                    <input
                        type="date"
                        wire:model.live="returnDate"
                        min="{{ $pickupDate }}"
                        class="w-full px-3 py-3 rounded-2xl bg-slate-800/90 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none cursor-pointer"
                    />
                </div>
            </div>
        </div>

        <!-- Quick Nepal Destination Chips -->
        <div class="mt-4 pt-4 border-t border-white/5 flex flex-wrap items-center gap-2">
            <span class="text-xs text-slate-400 font-bold">Quick Hubs:</span>
            @foreach (['✈️ KTM Airport' => 'Tribhuvan International Airport (KTM)', '🏔️ Pokhara PKR' => 'Pokhara International Airport (PKR)', '🛍️ Thamel' => 'Thamel Tourist Hub, Kathmandu', '⛵ Lakeside' => 'Lakeside, Pokhara', '🦏 Chitwan' => 'Sauraha Tourist Center, Chitwan'] as $chipLabel => $chipLoc)
                <button
                    type="button"
                    wire:click="$set('pickupLocation', '{{ $chipLoc }}')"
                    class="px-3 py-1 rounded-xl text-xs font-semibold bg-slate-800/80 hover:bg-emerald-500/20 text-slate-300 hover:text-emerald-300 border border-white/10 hover:border-emerald-500/30 transition cursor-pointer"
                >
                    {{ $chipLabel }}
                </button>
            @endforeach
            <div class="ml-auto text-xs text-emerald-400 font-bold bg-emerald-500/10 px-3 py-1 rounded-full border border-emerald-500/20">
                Duration: {{ $totalDays }} {{ Str::plural('Day', $totalDays) }}
            </div>
        </div>
    </div>

    <!-- Category Filter Tabs & Options -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-2">
            @php
                $categories = [
                    'all' => 'All Vehicles',
                    'suv_4wd' => '🏔️ 4WD SUVs',
                    'compact_suv' => '🚙 Compact SUVs',
                    'tourist_van' => '🚐 Tourist Vans (HiAce)',
                    'sedan' => '🚗 Sedans',
                    'hatchback' => '⚡ Hatchbacks',
                ];
            @endphp
            @foreach ($categories as $catKey => $catLabel)
                <button
                    type="button"
                    wire:click="$set('selectedCategory', '{{ $catKey }}')"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer {{ $selectedCategory === $catKey ? 'bg-emerald-500 text-slate-950 shadow-md shadow-emerald-500/20 scale-105' : 'bg-slate-900/80 text-slate-400 hover:text-white border border-white/10 hover:border-white/20' }}"
                >
                    {{ $catLabel }}
                </button>
            @endforeach
        </div>

        <div class="flex items-center gap-3">
            <label class="inline-flex items-center gap-2 text-xs font-bold text-slate-300 cursor-pointer bg-slate-900/60 px-3 py-2 rounded-xl border border-white/10 hover:border-emerald-500/30 transition">
                <input type="checkbox" wire:model.live="filter4wd" class="rounded bg-slate-800 border-white/20 text-emerald-500 focus:ring-0">
                <span>⛰️ 4WD Mountain Ready Only</span>
            </label>
        </div>
    </div>

    <!-- Vehicle Results Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($vehicles as $vehicle)
            <div class="group relative rounded-3xl bg-slate-900/80 border border-white/10 hover:border-emerald-500/50 p-5 transition-all duration-300 hover:shadow-2xl hover:shadow-emerald-500/10 hover:-translate-y-1 flex flex-col justify-between backdrop-blur-md">
                <div>
                    <!-- Vehicle Image & Badges -->
                    <div class="relative h-48 sm:h-52 w-full rounded-2xl overflow-hidden bg-gradient-to-b from-slate-900/80 via-slate-950/90 to-slate-950 border border-white/10 flex items-center justify-center p-3 mb-4">
                        <img
                            src="{{ $vehicle->vehicle_photo_path ?? 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=800&q=80' }}"
                            alt="{{ $vehicle->title }}"
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
                        </div>

                        <!-- Service Option Indicator -->
                        <div class="absolute bottom-3 left-3 text-xs text-white font-medium flex items-center gap-1.5">
                            @if ($serviceOption === 'with_driver')
                                <span class="px-2.5 py-1 rounded-md bg-emerald-500 text-slate-950 font-black text-[10px] tracking-wide shadow-sm">
                                    CHAUFFEUR INCLUDED
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
                            <h3 class="text-xl font-black text-white group-hover:text-emerald-300 transition-colors">
                                {{ $vehicle->title }}
                            </h3>
                            <p class="text-xs text-slate-400 flex items-center gap-1.5 mt-0.5">
                                <span class="font-mono bg-slate-800 px-1.5 py-0.5 rounded text-slate-300">Plate: {{ $vehicle->plate_number }}</span>
                                <span>•</span>
                                <span>Year {{ $vehicle->year }}</span>
                            </p>
                        </div>

                        @if ($vehicle->driverProfile)
                            <div class="text-right">
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
                    <div class="grid grid-cols-4 gap-2 py-3 border-y border-white/5 my-3 text-center bg-slate-950/40 rounded-xl">
                        <div>
                            <span class="block text-xs font-black text-white">{{ $vehicle->seating_capacity }}</span>
                            <span class="text-[10px] text-slate-400">Seats</span>
                        </div>
                        <div>
                            <span class="block text-xs font-black text-white">{{ $vehicle->luggage_capacity }}</span>
                            <span class="text-[10px] text-slate-400">Bags</span>
                        </div>
                        <div>
                            <span class="block text-xs font-black text-white uppercase">{{ $vehicle->transmission }}</span>
                            <span class="text-[10px] text-slate-400">Gear</span>
                        </div>
                        <div>
                            <span class="block text-xs font-black text-white uppercase">{{ $vehicle->fuel_type }}</span>
                            <span class="text-[10px] text-slate-400">Fuel</span>
                        </div>
                    </div>
                </div>

                <!-- Price & CTA Button -->
                <div class="pt-3 flex items-center justify-between border-t border-white/5">
                    <div>
                        <div class="text-[11px] text-slate-400 font-semibold">Daily Rate</div>
                        <div class="text-xl font-black text-white">
                            {{ $vehicle->formatted_daily_rate }}
                            <span class="text-xs font-normal text-slate-400">/day</span>
                        </div>
                        <div class="text-[11px] text-emerald-400 font-bold mt-0.5">
                            Total: Rs. {{ number_format($vehicle->daily_rate * $totalDays) }} ({{ $totalDays }} {{ Str::plural('day', $totalDays) }})
                        </div>
                    </div>

                    <button
                        type="button"
                        wire:click="selectVehicle({{ $vehicle->id }})"
                        class="px-5 py-3 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black text-sm shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 transition-all flex items-center gap-2 group-hover:scale-105 cursor-pointer"
                    >
                        <span>Book Now</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-3xl bg-slate-900/60 border border-white/10 p-12 text-center">
                <div class="w-16 h-16 rounded-full bg-slate-800 mx-auto flex items-center justify-center text-slate-500 mb-4">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">No vehicles match your filter</h3>
                <p class="text-sm text-slate-400 mb-4">Try selecting "All Vehicles" or toggling the 4WD filter off.</p>
                <button
                    type="button"
                    wire:click="$set('selectedCategory', 'all'); $set('filter4wd', false);"
                    class="px-5 py-2.5 rounded-xl bg-emerald-500/20 text-emerald-300 font-bold text-xs border border-emerald-500/30 hover:bg-emerald-500/30 transition cursor-pointer"
                >
                    Reset Filters
                </button>
            </div>
        @endforelse
    </div>

    <!-- Booking Confirmation Modal -->
    @if ($isBookingModalOpen && $selectedVehicle)
        <div class="fixed inset-0 z-50 overflow-y-auto bg-black/85 backdrop-blur-md flex items-center justify-center p-4">
            <div class="relative w-full max-w-2xl rounded-3xl bg-slate-900 border border-white/15 p-6 md:p-8 shadow-2xl">
                <!-- Close Button -->
                <button
                    type="button"
                    wire:click="closeModal"
                    class="absolute top-6 right-6 w-9 h-9 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white flex items-center justify-center transition cursor-pointer"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Modal Header -->
                <div class="mb-6">
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 mb-2">
                        Direct Reservation Voucher
                    </span>
                    <h2 class="text-2xl font-black text-white">Reserve Your Vehicle</h2>
                    <p class="text-xs text-slate-400 mt-1">Book directly with our verified local partner in Nepal. Pay on pickup.</p>
                </div>

                <!-- Vehicle Summary Card -->
                <div class="p-4 rounded-2xl bg-slate-950/80 border border-white/10 flex items-center gap-4 mb-6">
                    <img
                        src="{{ $selectedVehicle->vehicle_photo_path ?? 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=400&q=80' }}"
                        alt="{{ $selectedVehicle->title }}"
                        class="w-24 h-16 rounded-xl object-contain bg-slate-900/90 p-1 border border-white/10 shrink-0"
                    />
                    <div class="flex-1 min-w-0">
                        <div class="font-bold text-white truncate">{{ $selectedVehicle->title }}</div>
                        <div class="text-xs text-slate-400">
                            {{ $selectedVehicle->category_label }} • {{ $selectedVehicle->plate_number }}
                        </div>
                        <div class="text-xs text-emerald-400 font-semibold mt-0.5">
                            {{ $serviceOption === 'with_driver' ? '✓ Professional Chauffeur Included' : '✓ Self-Drive Rental' }}
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-slate-400">{{ $totalDays }} {{ Str::plural('Day', $totalDays) }}</div>
                        <div class="text-lg font-black text-white">Rs. {{ number_format($selectedVehicle->daily_rate * $totalDays) }}</div>
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
                                placeholder="e.g. Hotel Yak & Yeti or Airport Arrival Gate"
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
                                    <div class="text-[10px] text-slate-400">Pay directly to partner driver</div>
                                </div>
                            </label>
                            <label class="flex items-center gap-3 p-3 rounded-xl bg-slate-800/80 border border-white/10 cursor-pointer hover:border-emerald-500/40">
                                <input type="radio" wire:model="paymentMethod" value="esewa" class="text-emerald-500 focus:ring-0">
                                <div>
                                    <div class="text-xs font-bold text-white">eSewa / Digital Wallet</div>
                                    <div class="text-[10px] text-slate-400">Pay via QR upon car handover</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Special Requests -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1">Special Requests / Notes</label>
                        <textarea
                            wire:model="specialRequests"
                            rows="2"
                            placeholder="Luggage requirements, child seat, or mountain trekking schedule details..."
                            class="w-full px-4 py-2 rounded-xl bg-slate-800 border border-white/10 text-white text-xs focus:border-emerald-500 outline-none"
                        ></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4 flex items-center justify-between border-t border-white/10">
                        <div class="text-xs text-slate-400">
                            ✓ Free cancellation up to 24h before pickup
                        </div>
                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            class="px-6 py-3 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black text-sm shadow-xl shadow-emerald-500/25 transition flex items-center gap-2 cursor-pointer"
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
</div>
