<div class="bg-white rounded-3xl shadow-2xl shadow-slate-900/10 border border-slate-200/80 p-6 sm:p-8 backdrop-blur-md">
    <form wire:submit.prevent="search" class="space-y-6">
        <!-- Return location toggle & Driver age selector -->
        <div class="flex flex-wrap items-center justify-between gap-4 pb-4 border-b border-slate-100 text-xs sm:text-sm">
            <div class="flex items-center gap-3">
                <button type="button" 
                    wire:click="toggleDifferentDropoff"
                    class="inline-flex items-center gap-2.5 text-slate-700 hover:text-emerald-600 font-semibold transition cursor-pointer select-none">
                    <span class="w-5 h-5 rounded-md border flex items-center justify-center transition {{ $differentDropoff ? 'bg-emerald-600 border-emerald-600 text-white shadow-xs' : 'border-slate-300 bg-slate-50' }}">
                        @if($differentDropoff)
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20"><path d="M0 11l2-2 5 5L18 3l2 2L7 18z"/></svg>
                        @endif
                    </span>
                    Return vehicle to a different location
                </button>
            </div>

            <div class="flex items-center gap-2">
                <label for="driverAge" class="text-slate-500 font-medium">Driver Age:</label>
                <div class="relative">
                    <select id="driverAge" wire:model.live="driverAge" class="bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-800 rounded-lg px-3 py-1 text-xs font-bold focus:ring-2 focus:ring-emerald-500 focus:outline-none transition cursor-pointer">
                        <option value="21">18 - 24 years</option>
                        <option value="30">25 - 69 years (Standard)</option>
                        <option value="72">70+ years</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Location Fields Grid -->
        <div class="grid grid-cols-1 {{ $differentDropoff ? 'md:grid-cols-2' : '' }} gap-4">
            <!-- Pickup Location Input -->
            <div class="relative" x-data="{ open: false }">
                <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Pick-up Location in Nepal
                </label>
                <div class="relative flex items-center">
                    <div class="absolute left-3.5 text-emerald-600 pointer-events-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <input type="text" 
                        wire:model.live.debounce.200ms="pickupQuery"
                        @focus="open = true"
                        @click.outside="open = false"
                        placeholder="Search airport, city, or hub (e.g. Kathmandu, Pokhara, Chitwan)..."
                        class="w-full pl-11 pr-4 py-3.5 bg-slate-50 hover:bg-slate-100/70 focus:bg-white border border-slate-200 focus:border-emerald-500 rounded-2xl font-semibold text-slate-800 placeholder-slate-400 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none transition shadow-2xs">
                </div>

                <!-- Autocomplete Dropdown -->
                <div x-show="open" 
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="absolute z-50 left-0 right-0 mt-2 bg-white rounded-2xl shadow-2xl border border-slate-200 py-2 max-h-72 overflow-y-auto">
                    <div class="px-4 py-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                        Available Rental Hubs in Nepal
                    </div>
                    @forelse($pickupLocations as $loc)
                        <button type="button" 
                            wire:click="selectPickup({{ $loc->id }}, '{{ addslashes($loc->display_name) }}')"
                            @click="open = false"
                            class="w-full px-4 py-2.5 text-left hover:bg-emerald-50/70 flex items-center justify-between group transition">
                            <div class="flex items-center gap-3">
                                <span class="p-2 bg-slate-100 rounded-xl group-hover:bg-emerald-100 text-slate-600 group-hover:text-emerald-700 transition">
                                    @if($loc->type === 'airport')
                                        ✈️
                                    @else
                                        📍
                                    @endif
                                </span>
                                <div>
                                    <div class="font-bold text-slate-900 text-sm group-hover:text-emerald-900">{{ $loc->city }}</div>
                                    <div class="text-xs text-slate-500">{{ $loc->name }}</div>
                                </div>
                            </div>
                            @if($loc->iata_code)
                                <span class="text-xs font-black bg-slate-100 group-hover:bg-emerald-200 text-slate-700 group-hover:text-emerald-900 px-2.5 py-1 rounded-lg">
                                    {{ $loc->iata_code }}
                                </span>
                            @endif
                        </button>
                    @empty
                        <div class="px-4 py-3 text-xs text-slate-500">Type to search for airports or cities across Nepal</div>
                    @endforelse
                </div>
                @error('pickupLocationId') <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Dropoff Location Input (if different) -->
            @if($differentDropoff)
                <div class="relative" x-data="{ openDrop: false }">
                    <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span> Drop-off Location in Nepal
                    </label>
                    <div class="relative flex items-center">
                        <div class="absolute left-3.5 text-amber-600 pointer-events-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <input type="text" 
                            wire:model.live.debounce.200ms="dropoffQuery"
                            @focus="openDrop = true"
                            @click.outside="openDrop = false"
                            placeholder="Return destination in Nepal..."
                            class="w-full pl-11 pr-4 py-3.5 bg-slate-50 hover:bg-slate-100/70 focus:bg-white border border-slate-200 focus:border-amber-500 rounded-2xl font-semibold text-slate-800 placeholder-slate-400 focus:ring-4 focus:ring-amber-500/10 focus:outline-none transition shadow-2xs">
                    </div>

                    <div x-show="openDrop" 
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="absolute z-50 left-0 right-0 mt-2 bg-white rounded-2xl shadow-2xl border border-slate-200 py-2 max-h-72 overflow-y-auto">
                        @forelse($dropoffLocations as $loc)
                            <button type="button" 
                                wire:click="selectDropoff({{ $loc->id }}, '{{ addslashes($loc->display_name) }}')"
                                @click="openDrop = false"
                                class="w-full px-4 py-2.5 text-left hover:bg-amber-50/70 flex items-center justify-between group transition">
                                <div class="flex items-center gap-3">
                                    <span class="p-2 bg-slate-100 rounded-xl group-hover:bg-amber-100 text-slate-600 group-hover:text-amber-700 transition">
                                        @if($loc->type === 'airport') ✈️ @else 📍 @endif
                                    </span>
                                    <div>
                                        <div class="font-bold text-slate-900 text-sm group-hover:text-amber-900">{{ $loc->city }}</div>
                                        <div class="text-xs text-slate-500">{{ $loc->name }}</div>
                                    </div>
                                </div>
                                @if($loc->iata_code)
                                    <span class="text-xs font-black bg-slate-100 group-hover:bg-amber-200 text-slate-700 group-hover:text-amber-900 px-2.5 py-1 rounded-lg">
                                        {{ $loc->iata_code }}
                                    </span>
                                @endif
                            </button>
                        @empty
                            <div class="px-4 py-3 text-xs text-slate-500">Type to search for return location</div>
                        @endforelse
                    </div>
                    @error('dropoffLocationId') <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>
            @endif
        </div>

        <!-- Quick Destination Pills -->
        <div class="flex flex-wrap items-center gap-2 pt-1 text-xs text-slate-500">
            <span class="font-bold text-slate-400">Popular:</span>
            <button type="button" wire:click="selectPickup(1, 'Kathmandu (KTM) - Tribhuvan International Airport')" class="bg-slate-100 hover:bg-emerald-50 hover:text-emerald-700 px-2.5 py-1 rounded-lg transition font-medium cursor-pointer">
                ✈️ KTM Airport
            </button>
            <button type="button" wire:click="selectPickup(4, 'Pokhara (PKR) - Pokhara International Airport')" class="bg-slate-100 hover:bg-emerald-50 hover:text-emerald-700 px-2.5 py-1 rounded-lg transition font-medium cursor-pointer">
                🏔️ Pokhara PKR
            </button>
            <button type="button" wire:click="selectPickup(6, 'Chitwan (BHR) - Bharatpur Airport (Chitwan)')" class="bg-slate-100 hover:bg-emerald-50 hover:text-emerald-700 px-2.5 py-1 rounded-lg transition font-medium cursor-pointer">
                🦏 Chitwan BHR
            </button>
            <button type="button" wire:click="selectPickup(2, 'Kathmandu (THM) - Thamel Tourist Hub')" class="bg-slate-100 hover:bg-emerald-50 hover:text-emerald-700 px-2.5 py-1 rounded-lg transition font-medium cursor-pointer">
                🛍️ Thamel
            </button>
            <button type="button" wire:click="selectPickup(5, 'Pokhara (LKS) - Lakeside Tourist Hub')" class="bg-slate-100 hover:bg-emerald-50 hover:text-emerald-700 px-2.5 py-1 rounded-lg transition font-medium cursor-pointer">
                ⛵ Lakeside
            </button>
        </div>

        <!-- Date and Time Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 pt-2">
            <!-- Pickup Date -->
            <div class="bg-slate-50/80 border border-slate-200 rounded-2xl p-3 focus-within:border-emerald-500 focus-within:ring-2 focus-within:ring-emerald-500/10 transition">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Pick-up Date</label>
                <input type="date" 
                    wire:model.live="pickupDate" 
                    min="{{ date('Y-m-d') }}"
                    class="w-full bg-transparent font-bold text-slate-800 text-sm focus:outline-none cursor-pointer">
                @error('pickupDate') <span class="text-[11px] text-rose-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Pickup Time -->
            <div class="bg-slate-50/80 border border-slate-200 rounded-2xl p-3 focus-within:border-emerald-500 focus-within:ring-2 focus-within:ring-emerald-500/10 transition">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Pick-up Time</label>
                <select wire:model.live="pickupTime" class="w-full bg-transparent font-bold text-slate-800 text-sm focus:outline-none cursor-pointer">
                    @for($h = 0; $h < 24; $h++)
                        @php $val1 = sprintf('%02d:00', $h); $val2 = sprintf('%02d:30', $h); @endphp
                        <option value="{{ $val1 }}">{{ $val1 }}</option>
                        <option value="{{ $val2 }}">{{ $val2 }}</option>
                    @endfor
                </select>
            </div>

            <!-- Dropoff Date -->
            <div class="bg-slate-50/80 border border-slate-200 rounded-2xl p-3 focus-within:border-emerald-500 focus-within:ring-2 focus-within:ring-emerald-500/10 transition">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Drop-off Date</label>
                <input type="date" 
                    wire:model.live="dropoffDate" 
                    min="{{ $pickupDate ?: date('Y-m-d') }}"
                    class="w-full bg-transparent font-bold text-slate-800 text-sm focus:outline-none cursor-pointer">
                @error('dropoffDate') <span class="text-[11px] text-rose-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Dropoff Time -->
            <div class="bg-slate-50/80 border border-slate-200 rounded-2xl p-3 focus-within:border-emerald-500 focus-within:ring-2 focus-within:ring-emerald-500/10 transition">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Drop-off Time</label>
                <select wire:model.live="dropoffTime" class="w-full bg-transparent font-bold text-slate-800 text-sm focus:outline-none cursor-pointer">
                    @for($h = 0; $h < 24; $h++)
                        @php $val1 = sprintf('%02d:00', $h); $val2 = sprintf('%02d:30', $h); @endphp
                        <option value="{{ $val1 }}">{{ $val1 }}</option>
                        <option value="{{ $val2 }}">{{ $val2 }}</option>
                    @endfor
                </select>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" 
                class="w-full bg-gradient-to-r from-emerald-600 via-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 active:from-emerald-700 active:to-teal-700 text-white font-extrabold text-lg py-4 px-8 rounded-2xl shadow-xl shadow-emerald-600/25 hover:shadow-2xl hover:shadow-emerald-600/35 transition-all duration-200 flex items-center justify-center gap-3 cursor-pointer group">
                <span wire:loading.remove wire:target="search" class="flex items-center gap-2">
                    <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Compare Best Rental Deals in Nepal
                    <span class="text-emerald-200 transition-transform group-hover:translate-x-1">→</span>
                </span>
                <span wire:loading wire:target="search" class="inline-flex items-center gap-2">
                    <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Scanning Nepal Operators & Fleets...
                </span>
            </button>
        </div>
    </form>
</div>
