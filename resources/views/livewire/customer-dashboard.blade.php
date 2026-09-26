<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 space-y-8">
    <!-- Top Welcome Banner -->
    <div class="p-6 md:p-8 rounded-3xl bg-[#0b1329] border border-white/10 shadow-2xl flex flex-wrap items-center justify-between gap-6 relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-48 h-48 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-500 text-slate-950 font-black text-xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-black text-white">{{ $user->name }}</h1>
                    <p class="text-xs text-slate-400 mt-0.5">
                        {{ $user->email }} • Member since {{ $user->created_at->format('M Y') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3 relative">
            <a wire:navigate href="{{ route('book.index') }}" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black text-xs shadow-lg shadow-emerald-500/25 transition flex items-center gap-2">
                <span>🚗</span>
                <span>Book a Vehicle</span>
            </a>
            <button
                type="button"
                wire:click="logout"
                class="px-4 py-2.5 rounded-xl bg-slate-900 border border-white/10 text-slate-300 hover:text-white text-xs font-bold hover:bg-slate-800 transition cursor-pointer"
            >
                Log Out
            </button>
        </div>
    </div>

    <!-- Alert / Flash Messages -->
    @if (session()->has('message'))
        <div class="p-4 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-300 text-xs font-bold flex items-center justify-between">
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <!-- Metric KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="p-6 rounded-3xl bg-[#0b1329] border border-white/10 shadow-xl">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 flex items-center gap-1.5">
                <span class="text-emerald-400">📅</span> Active / Upcoming Trips
            </span>
            <div class="text-3xl font-black text-white mt-2">{{ $activeTrips }}</div>
            <span class="text-[11px] text-emerald-400 mt-1 block">Pending & Confirmed</span>
        </div>

        <div class="p-6 rounded-3xl bg-[#0b1329] border border-white/10 shadow-xl">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 flex items-center gap-1.5">
                <span class="text-teal-400">✓</span> Completed Trips
            </span>
            <div class="text-3xl font-black text-white mt-2">{{ $completedTrips }}</div>
            <span class="text-[11px] text-slate-400 mt-1 block">Successfully fulfilled in Nepal</span>
        </div>

        <div class="p-6 rounded-3xl bg-[#0b1329] border border-white/10 shadow-xl">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 flex items-center gap-1.5">
                <span class="text-amber-400">💳</span> Total Completed Spend
            </span>
            <div class="text-3xl font-black text-white mt-2">Rs. {{ number_format($totalSpent) }}</div>
            <span class="text-[11px] text-slate-400 mt-1 block">Transparent NPR pricing</span>
        </div>
    </div>

    <!-- Tabbed Navigation -->
    <div class="flex items-center gap-2 border-b border-white/10 pb-4">
        <button
            type="button"
            wire:click="setActiveTab('bookings')"
            class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all cursor-pointer {{ $activeTab === 'bookings' ? 'bg-emerald-500 text-slate-950 shadow-md shadow-emerald-500/20' : 'text-slate-400 hover:text-white bg-slate-900/50' }}"
        >
            🚗 My Reservations ({{ $bookings->count() }})
        </button>

        <button
            type="button"
            wire:click="setActiveTab('alerts')"
            class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all cursor-pointer {{ $activeTab === 'alerts' ? 'bg-emerald-500 text-slate-950 shadow-md shadow-emerald-500/20' : 'text-slate-400 hover:text-white bg-slate-900/50' }}"
        >
            🔔 Price Alerts ({{ $alerts->count() }})
        </button>

        <button
            type="button"
            wire:click="setActiveTab('profile')"
            class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all cursor-pointer {{ $activeTab === 'profile' ? 'bg-emerald-500 text-slate-950 shadow-md shadow-emerald-500/20' : 'text-slate-400 hover:text-white bg-slate-900/50' }}"
        >
            👤 Profile & Security
        </button>
    </div>

    <!-- Tab 1: Bookings List -->
    @if ($activeTab === 'bookings')
        <div class="space-y-4">
            @forelse ($bookings as $booking)
                <div class="p-6 rounded-3xl bg-[#0b1329] border border-white/10 shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-6 hover:border-emerald-500/30 transition">
                    <div class="flex items-start gap-4">
                        <img
                            src="{{ $booking->vehicle ? $booking->vehicle->photo_url : asset('images/vehicles/scorpio.jpg') }}"
                            alt="{{ $booking->vehicle ? $booking->vehicle->title : 'Vehicle' }}"
                            class="w-24 h-20 rounded-2xl object-contain bg-slate-900 p-1 border border-white/10 shrink-0"
                        />
                        <div class="space-y-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="font-mono font-bold text-emerald-400 text-sm">{{ $booking->booking_reference }}</span>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                                    {{ $booking->status === 'confirmed' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : '' }}
                                    {{ $booking->status === 'pending' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : '' }}
                                    {{ $booking->status === 'completed' ? 'bg-blue-500/20 text-blue-300 border border-blue-500/30' : '' }}
                                    {{ $booking->status === 'cancelled' ? 'bg-rose-500/20 text-rose-300 border border-rose-500/30' : '' }}
                                ">
                                    {{ ucfirst($booking->status) }}
                                </span>
                                <span class="text-[11px] text-slate-400 font-semibold">• {{ $booking->service_option === 'with_driver' ? 'Chauffeur' : 'Self-Drive' }}</span>
                                <span class="text-[11px] text-emerald-400 font-semibold">• {{ $booking->fuel_badge }}</span>
                            </div>

                            <h3 class="text-base font-bold text-white">
                                {{ $booking->vehicle ? $booking->vehicle->title : 'Vehicle Rental' }}
                            </h3>

                            <div class="text-xs text-slate-400 flex flex-wrap items-center gap-3">
                                <span>📍 {{ Str::limit($booking->pickup_location, 30) }} ➔ {{ Str::limit($booking->return_location, 30) }}</span>
                                <span>•</span>
                                <span>📅 {{ $booking->pickup_date->format('M d, Y H:i') }} ({{ $booking->total_days }} {{ Str::plural('Day', $booking->total_days) }})</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col md:items-end w-full md:w-auto pt-4 md:pt-0 border-t md:border-t-0 border-white/10 shrink-0">
                        <div class="text-xl font-black text-white">{{ $booking->formatted_total_price }}</div>
                        <div class="text-[10px] text-slate-400 uppercase font-semibold">
                            Payment: {{ $booking->payment_method === 'cash' ? 'Cash on Handover' : ucfirst($booking->payment_method) }}
                        </div>

                        <div class="mt-3 flex items-center gap-2">
                            <button
                                type="button"
                                wire:click="viewBooking({{ $booking->id }})"
                                class="px-3.5 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs border border-white/10 transition cursor-pointer"
                            >
                                View Voucher
                            </button>
                            <a
                                href="{{ route('booking.show', $booking->booking_reference) }}"
                                target="_blank"
                                class="px-3.5 py-1.5 rounded-xl bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-300 font-bold text-xs border border-emerald-500/30 transition"
                            >
                                Live Link ↗
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center rounded-3xl bg-[#0b1329] border border-white/10 space-y-4">
                    <span class="text-4xl">🚗</span>
                    <h3 class="text-lg font-bold text-white">No Bookings Found</h3>
                    <p class="text-xs text-slate-400 max-w-sm mx-auto">You haven't made any vehicle reservations yet. Browse Nepal's verified fleets to get started.</p>
                    <a wire:navigate href="{{ route('book.index') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-emerald-500 text-slate-950 font-bold text-xs shadow-lg shadow-emerald-500/25">
                        Book Vehicle Now
                    </a>
                </div>
            @endforelse
        </div>
    @endif

    <!-- Tab 2: Price Drop Alerts -->
    @if ($activeTab === 'alerts')
        <div class="p-6 md:p-8 rounded-3xl bg-[#0b1329] border border-white/10 shadow-xl space-y-6">
            <div>
                <h2 class="text-xl font-bold text-white">Your Nepal Travel Price Alerts</h2>
                <p class="text-xs text-slate-400 mt-1">We monitor route rates from verified operators and notify you when prices drop</p>
            </div>

            @if (session()->has('alertMessage'))
                <div class="p-3 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 text-xs font-bold">
                    {{ session('alertMessage') }}
                </div>
            @endif

            <div class="space-y-3">
                @forelse ($alerts as $alert)
                    <div class="p-4 rounded-2xl bg-slate-900 border border-white/5 flex items-center justify-between">
                        <div>
                            <div class="text-sm font-bold text-white">
                                {{ $alert->pickupLocation ? $alert->pickupLocation->name : 'Any Location' }} ➔ {{ $alert->dropoffLocation ? $alert->dropoffLocation->name : 'Any Location' }}
                            </div>
                            <div class="text-xs text-slate-400 mt-0.5">
                                Target Rate: {{ $alert->threshold_value ? 'Rs. ' . number_format($alert->threshold_value) : ($alert->last_best_price_formatted ?? 'Best Rate') }} • Created {{ $alert->created_at->diffForHumans() }}
                            </div>
                        </div>
                        <button
                            type="button"
                            wire:click="unsubscribeAlert({{ $alert->id }})"
                            class="px-3 py-1 rounded-xl bg-rose-500/20 text-rose-300 hover:bg-rose-500/30 border border-rose-500/30 text-xs font-bold transition cursor-pointer"
                        >
                            Pause Alert
                        </button>
                    </div>
                @empty
                    <div class="text-center py-8 text-xs text-slate-400">
                        No active price alerts. You can subscribe to alerts while searching rates on the aggregator search page.
                    </div>
                @endforelse
            </div>
        </div>
    @endif

    <!-- Tab 3: Profile & Security -->
    @if ($activeTab === 'profile')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Profile Info Form -->
            <div class="p-6 md:p-8 rounded-3xl bg-[#0b1329] border border-white/10 shadow-xl space-y-6">
                <div>
                    <h2 class="text-lg font-bold text-white">Profile Information</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Update your personal contact details for future reservations</p>
                </div>

                @if ($profileSuccessMessage)
                    <div class="p-3 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 text-xs font-bold">
                        {{ $profileSuccessMessage }}
                    </div>
                @endif

                <form wire:submit.prevent="updateProfile" class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Full Name</label>
                        <input
                            type="text"
                            wire:model="profileName"
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none"
                            required
                        />
                        @error('profileName') <span class="text-xs text-rose-400 font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Phone / WhatsApp Number</label>
                        <input
                            type="text"
                            wire:model="profilePhone"
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none"
                            required
                        />
                        @error('profilePhone') <span class="text-xs text-rose-400 font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Email Address</label>
                        <input
                            type="email"
                            value="{{ $user->email }}"
                            disabled
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-900/50 border border-white/5 text-slate-500 text-sm cursor-not-allowed"
                        />
                    </div>

                    <button
                        type="submit"
                        class="px-5 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs shadow-lg shadow-emerald-500/25 transition cursor-pointer"
                    >
                        Save Profile Changes
                    </button>
                </form>
            </div>

            <!-- Password Update Form -->
            <div class="p-6 md:p-8 rounded-3xl bg-[#0b1329] border border-white/10 shadow-xl space-y-6">
                <div>
                    <h2 class="text-lg font-bold text-white">Security & Password</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Ensure your account is using a long, secure password</p>
                </div>

                <form wire:submit.prevent="updatePassword" class="space-y-4" x-data="{ showCurrent: false, showNew: false, showConfirm: false }">
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Current Password</label>
                        <div class="relative flex items-center">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                    <rect x="5" y="11" width="14" height="10" rx="2" stroke-width="1.75" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 11V7a4 4 0 118 0v4" />
                                    <circle cx="12" cy="16" r="1" fill="currentColor" />
                                </svg>
                            </div>
                            <input
                                :type="showCurrent ? 'text' : 'password'"
                                wire:model="currentPassword"
                                placeholder="Enter current password"
                                class="w-full input-with-both-icons pl-14 pr-14 py-2.5 rounded-xl bg-slate-900 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none placeholder-slate-500"
                                style="padding-left: 56px !important; padding-right: 56px !important;"
                                required
                            />
                            <button
                                type="button"
                                @click="showCurrent = !showCurrent"
                                class="absolute inset-y-0 right-0 pr-5 flex items-center z-10 text-slate-400 hover:text-slate-200 transition focus:outline-none cursor-pointer"
                                tabindex="-1"
                                aria-label="Toggle password visibility"
                            >
                                <svg x-show="!showCurrent" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <svg x-show="showCurrent" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                        @error('currentPassword') <span class="text-xs text-rose-400 font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">New Password</label>
                        <div class="relative flex items-center">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                    <rect x="5" y="11" width="14" height="10" rx="2" stroke-width="1.75" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 11V7a4 4 0 118 0v4" />
                                    <circle cx="12" cy="16" r="1" fill="currentColor" />
                                </svg>
                            </div>
                            <input
                                :type="showNew ? 'text' : 'password'"
                                wire:model="newPassword"
                                placeholder="Enter new password"
                                class="w-full input-with-both-icons pl-14 pr-14 py-2.5 rounded-xl bg-slate-900 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none placeholder-slate-500"
                                style="padding-left: 56px !important; padding-right: 56px !important;"
                                required
                            />
                            <button
                                type="button"
                                @click="showNew = !showNew"
                                class="absolute inset-y-0 right-0 pr-5 flex items-center z-10 text-slate-400 hover:text-slate-200 transition focus:outline-none cursor-pointer"
                                tabindex="-1"
                                aria-label="Toggle password visibility"
                            >
                                <svg x-show="!showNew" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <svg x-show="showNew" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                        @error('newPassword') <span class="text-xs text-rose-400 font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Confirm New Password</label>
                        <div class="relative flex items-center">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                    <rect x="5" y="11" width="14" height="10" rx="2" stroke-width="1.75" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 11V7a4 4 0 118 0v4" />
                                    <circle cx="12" cy="16" r="1" fill="currentColor" />
                                </svg>
                            </div>
                            <input
                                :type="showConfirm ? 'text' : 'password'"
                                wire:model="newPassword_confirmation"
                                placeholder="Confirm new password"
                                class="w-full input-with-both-icons pl-14 pr-14 py-2.5 rounded-xl bg-slate-900 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none placeholder-slate-500"
                                style="padding-left: 56px !important; padding-right: 56px !important;"
                                required
                            />
                            <button
                                type="button"
                                @click="showConfirm = !showConfirm"
                                class="absolute inset-y-0 right-0 pr-5 flex items-center z-10 text-slate-400 hover:text-slate-200 transition focus:outline-none cursor-pointer"
                                tabindex="-1"
                                aria-label="Toggle password confirmation visibility"
                            >
                                <svg x-show="!showConfirm" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <svg x-show="showConfirm" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs border border-white/10 transition cursor-pointer"
                    >
                        Update Password
                    </button>
                </form>
            </div>
        </div>
    @endif

    <!-- Booking Details Modal -->
    @if ($isDetailsModalOpen && $selectedBooking)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md">
            <div class="w-full max-w-2xl bg-[#0b1329] border border-white/10 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6 max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between border-b border-white/10 pb-4">
                    <div>
                        <div class="text-xs text-emerald-400 font-mono font-bold">{{ $selectedBooking->booking_reference }}</div>
                        <h2 class="text-xl font-bold text-white">Rental Confirmation Voucher</h2>
                    </div>
                    <button
                        type="button"
                        wire:click="closeDetailsModal"
                        class="w-8 h-8 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-300 flex items-center justify-center transition cursor-pointer"
                    >
                        ✕
                    </button>
                </div>

                <!-- Vehicle Info Banner -->
                <div class="p-4 rounded-2xl bg-slate-900 border border-white/5 flex gap-4 items-center">
                    <img
                        src="{{ $selectedBooking->vehicle ? $selectedBooking->vehicle->photo_url : asset('images/vehicles/scorpio.jpg') }}"
                        alt="Vehicle"
                        class="w-24 h-18 rounded-xl object-contain bg-slate-950 p-1 border border-white/10"
                    />
                    <div>
                        <h3 class="font-bold text-white text-base">{{ $selectedBooking->vehicle ? $selectedBooking->vehicle->title : 'Vehicle' }}</h3>
                        <div class="text-xs text-slate-400">Plate: {{ $selectedBooking->vehicle ? $selectedBooking->vehicle->plate_number : 'Assigned upon arrival' }} • {{ $selectedBooking->fuel_badge }}</div>
                        <div class="text-xs text-emerald-400 font-bold mt-1">Status: {{ ucfirst($selectedBooking->status) }}</div>
                    </div>
                </div>

                <!-- Trip Details Grid -->
                <div class="grid grid-cols-2 gap-4 text-xs">
                    <div class="p-3.5 rounded-2xl bg-slate-900/60 border border-white/5">
                        <span class="text-slate-400 font-semibold block">Pickup Location</span>
                        <strong class="text-white mt-1 block">{{ $selectedBooking->pickup_location }}</strong>
                        <span class="text-[11px] text-slate-400 mt-1 block">{{ $selectedBooking->pickup_date->format('M d, Y • h:i A') }}</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-900/60 border border-white/5">
                        <span class="text-slate-400 font-semibold block">Return Location</span>
                        <strong class="text-white mt-1 block">{{ $selectedBooking->return_location }}</strong>
                        <span class="text-[11px] text-slate-400 mt-1 block">{{ $selectedBooking->return_date->format('M d, Y • h:i A') }}</span>
                    </div>
                </div>

                <!-- Driver & Contact Details -->
                @if ($selectedBooking->driverProfile && $selectedBooking->driverProfile->user)
                    <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-xs">
                        <span class="font-bold text-emerald-400 block mb-1">Assigned Partner Driver</span>
                        <div class="text-white font-bold">{{ $selectedBooking->driverProfile->user->name }}</div>
                        <div class="text-slate-300 mt-0.5">Phone / WhatsApp: <a href="tel:{{ $selectedBooking->driverProfile->user->phone }}" class="text-emerald-400 font-bold underline">{{ $selectedBooking->driverProfile->user->phone }}</a></div>
                    </div>
                @endif

                <!-- Payment Summary -->
                <div class="p-4 rounded-2xl bg-slate-900 border border-white/10 flex items-center justify-between">
                    <div>
                        <span class="text-xs text-slate-400 font-semibold">Total Trip Fare (NPR)</span>
                        <div class="text-2xl font-black text-white">{{ $selectedBooking->formatted_total_price }}</div>
                        <span class="text-[10px] text-slate-400 uppercase">{{ $selectedBooking->payment_method === 'cash' ? 'Cash on Handover' : $selectedBooking->payment_method }}</span>
                    </div>

                    <div class="flex items-center gap-2">
                        @if ($selectedBooking->isPending())
                            <button
                                type="button"
                                wire:click="cancelBooking({{ $selectedBooking->id }})"
                                class="px-3 py-2 rounded-xl bg-rose-500/20 text-rose-300 hover:bg-rose-500/30 border border-rose-500/30 text-xs font-bold transition cursor-pointer"
                            >
                                Cancel Booking
                            </button>
                        @endif
                        <button
                            type="button"
                            wire:click="closeDetailsModal"
                            class="px-4 py-2 rounded-xl bg-emerald-500 text-slate-950 font-bold text-xs shadow transition cursor-pointer"
                        >
                            Done
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
