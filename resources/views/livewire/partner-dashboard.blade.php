<div>
    @if (!$isAuthenticated)
        <!-- Partner Login Box -->
        <div class="min-h-[calc(100vh-14rem)] flex items-center justify-center py-6 sm:py-8 px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full mx-auto rounded-3xl bg-[#0b1329] border border-slate-700/80 p-6 sm:p-8 shadow-2xl backdrop-blur-xl relative overflow-hidden">
                <!-- Subtle Glow Effect -->
                <div class="absolute -top-12 -right-12 w-36 h-36 bg-emerald-500/15 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute -bottom-12 -left-12 w-36 h-36 bg-teal-500/10 rounded-full blur-2xl pointer-events-none"></div>

                <div class="text-center mb-6 relative">
                    <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Partner Driver Portal</h1>
                    <p class="text-xs sm:text-sm text-slate-400 mt-1">Manage your vehicle listings, trip dispatch & earnings</p>
                </div>

            <form wire:submit.prevent="login" class="space-y-5">
                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">Email address</label>
                    <div class="relative flex items-center">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <rect x="3" y="5" width="18" height="14" rx="2" stroke-width="1.75" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 7l9 6 9-6" />
                            </svg>
                        </div>
                        <input
                            type="email"
                            wire:model="email"
                            placeholder="you@example.com"
                            class="w-full input-with-left-icon pl-14 pr-4 py-3 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition placeholder-slate-500"
                            style="padding-left: 56px !important;"
                            required
                        />
                    </div>
                    @error('email') <span class="text-rose-400 text-xs mt-1 block font-semibold">{{ $message }}</span> @enderror
                </div>

                <div x-data="{ showPassword: false }">
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">Password</label>
                        <button
                            type="button"
                            wire:click="openForgotModal"
                            class="text-xs text-emerald-400 hover:text-emerald-300 font-semibold transition hover:underline cursor-pointer"
                        >
                            Forgot password?
                        </button>
                    </div>
                    <div class="relative flex items-center">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <rect x="5" y="11" width="14" height="10" rx="2" stroke-width="1.75" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 11V7a4 4 0 118 0v4" />
                                <circle cx="12" cy="16" r="1" fill="currentColor" />
                            </svg>
                        </div>
                        <input
                            :type="showPassword ? 'text' : 'password'"
                            wire:model="password"
                            placeholder="Enter your password"
                            class="w-full input-with-both-icons pl-14 pr-14 py-3 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition placeholder-slate-500"
                            style="padding-left: 56px !important; padding-right: 56px !important;"
                            required
                        />
                        <button
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-5 flex items-center z-10 text-slate-400 hover:text-slate-200 transition focus:outline-none cursor-pointer"
                            tabindex="-1"
                            aria-label="Toggle password visibility"
                        >
                            <!-- Eye icon (closed/hidden state) -->
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <!-- Eye slash icon (open/revealed state) -->
                            <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </button>
                    </div>
                    @error('password') <span class="text-rose-400 text-xs mt-1 block font-semibold">{{ $message }}</span> @enderror
                </div>

                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black text-sm shadow-xl shadow-emerald-500/25 hover:shadow-emerald-500/35 transition cursor-pointer flex items-center justify-center gap-2 active:scale-[0.99]"
                >
                    <span wire:loading.remove>Log In to Partner Portal</span>
                    <span wire:loading>Authenticating...</span>
                    <svg wire:loading.remove class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-slate-800 text-center space-y-2">
                <p class="text-xs text-slate-400">
                    Want to list your vehicle or drive in Nepal?
                    <a wire:navigate href="{{ route('partner.register') }}" class="text-emerald-400 font-bold hover:underline">Register your vehicle</a>
                </p>
                <p class="text-xs text-slate-500">
                    Looking for customer booking?
                    <a wire:navigate href="{{ route('customer.login') }}" class="text-slate-300 font-semibold hover:text-emerald-400 transition">Customer Sign In →</a>
                </p>
            </div>
        </div>

        <!-- Forgot Password Modal for Partner -->
        @if ($showForgotModal)
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md">
                <div class="bg-[#0b1329] border border-slate-700/90 rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl relative">
                    <button
                        type="button"
                        wire:click="closeForgotModal"
                        class="absolute top-5 right-5 text-slate-400 hover:text-white transition"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>

                    <div class="text-center mb-6">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center mx-auto mb-3 border border-emerald-500/20">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-black text-white">Reset Partner Password</h3>
                        <p class="text-xs text-slate-400 mt-1">Enter your registered driver/partner email to receive password reset instructions.</p>
                    </div>

                    @if ($forgotStatusMessage)
                        <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs leading-relaxed mb-4">
                            {{ $forgotStatusMessage }}
                        </div>
                    @else
                        <form wire:submit.prevent="requestPasswordReset" class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">Registered Partner Email</label>
                                <input
                                    type="email"
                                    wire:model="forgotEmail"
                                    placeholder="bikash@hahakar.com"
                                    class="w-full px-4 py-3 rounded-2xl bg-slate-900 border border-slate-700 text-white text-sm focus:border-emerald-500 outline-none transition"
                                    required
                                />
                                @error('forgotEmail') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <button
                                type="submit"
                                wire:loading.attr="disabled"
                                class="w-full py-3 rounded-2xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-xs transition cursor-pointer flex items-center justify-center gap-2"
                            >
                                <span wire:loading.remove>Send Reset Instructions</span>
                                <span wire:loading>Sending...</span>
                            </button>
                        </form>
                    @endif

                    <div class="mt-6 pt-4 border-t border-slate-800 text-center">
                        <button
                            type="button"
                            wire:click="closeForgotModal"
                            class="text-xs font-bold text-slate-400 hover:text-slate-200 transition"
                        >
                            ← Back to Partner Sign In
                        </button>
                    </div>
                </div>
            </div>
        @endif
        </div>
    @else
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <!-- Authenticated Partner Dashboard -->
            <div class="space-y-8">
            <!-- Header Banner -->
            <div class="p-6 md:p-8 rounded-3xl bg-[#0b1329] border border-white/10 shadow-2xl flex flex-wrap items-center justify-between gap-6 relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-48 h-48 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-500 text-slate-950 font-black text-xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
                            {{ strtoupper(substr($profile->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h1 class="text-2xl md:text-3xl font-black text-white">{{ $profile->user->name }}</h1>
                                @if ($profile->status === 'verified')
                                    <span class="inline-flex items-center gap-1 px-3 py-0.5 rounded-full text-xs font-bold uppercase bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                        ✓ Verified Partner
                                    </span>
                                @elseif ($profile->status === 'pending')
                                    <span class="inline-flex items-center gap-1 px-3 py-0.5 rounded-full text-xs font-bold uppercase bg-amber-500/20 text-amber-300 border border-amber-500/30">
                                        ⏳ Pending Verification
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-0.5 rounded-full text-xs font-bold uppercase bg-rose-500/20 text-rose-300 border border-rose-500/30">
                                        {{ ucfirst($profile->status) }}
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs text-slate-400 mt-1">
                                Operating City: <strong class="text-slate-200">{{ $profile->service_city }}</strong> • Phone: {{ $profile->user->phone }} • License: {{ $profile->license_number }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 relative">
                    <button
                        type="button"
                        wire:click="openAddVehicleModal"
                        class="px-4 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 text-slate-950 font-bold text-xs sm:text-sm hover:from-emerald-400 hover:to-teal-400 shadow-lg shadow-emerald-500/25 transition cursor-pointer flex items-center gap-1.5"
                    >
                        <span>+</span>
                        <span>Add New Vehicle</span>
                    </button>
                    <button
                        type="button"
                        wire:click="logout"
                        class="px-4 py-2.5 rounded-2xl bg-slate-900 border border-white/10 text-slate-300 hover:text-white font-bold text-xs hover:bg-slate-800 transition cursor-pointer"
                    >
                        Log Out
                    </button>
                </div>
            </div>

            <!-- Global Alert Messages -->
            @if (session()->has('bookingMessage'))
                <div class="p-4 rounded-2xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 text-sm font-bold flex items-center gap-2">
                    <span>✓</span>
                    <span>{{ session('bookingMessage') }}</span>
                </div>
            @endif

            @if ($vehicleSuccessMessage)
                <div class="p-4 rounded-2xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 text-sm font-bold flex items-center gap-2">
                    <span>✓</span>
                    <span>{{ $vehicleSuccessMessage }}</span>
                </div>
            @endif

            <!-- Tabbed Navigation Bar -->
            <div class="flex items-center gap-2 sm:gap-3 border-b border-white/10 pb-4 overflow-x-auto">
                <button
                    type="button"
                    wire:click="setActiveTab('trips')"
                    class="px-5 py-2.5 rounded-2xl text-xs sm:text-sm font-bold transition-all cursor-pointer shrink-0 {{ $activeTab === 'trips' ? 'bg-emerald-500 text-slate-950 shadow-lg shadow-emerald-500/20' : 'bg-slate-900 text-slate-400 hover:text-white border border-white/5' }}"
                >
                    🚗 Trips & Fleet ({{ $profile->vehicles->count() }})
                </button>

                <button
                    type="button"
                    wire:click="setActiveTab('earnings')"
                    class="px-5 py-2.5 rounded-2xl text-xs sm:text-sm font-bold transition-all cursor-pointer shrink-0 {{ $activeTab === 'earnings' ? 'bg-emerald-500 text-slate-950 shadow-lg shadow-emerald-500/20' : 'bg-slate-900 text-slate-400 hover:text-white border border-white/5' }}"
                >
                    💰 Earnings & Revenue Breakdown
                </button>

                <button
                    type="button"
                    wire:click="setActiveTab('profile')"
                    class="px-5 py-2.5 rounded-2xl text-xs sm:text-sm font-bold transition-all cursor-pointer shrink-0 {{ $activeTab === 'profile' ? 'bg-emerald-500 text-slate-950 shadow-lg shadow-emerald-500/20' : 'bg-slate-900 text-slate-400 hover:text-white border border-white/5' }}"
                >
                    👤 Profile Settings
                </button>
            </div>

            <!-- TAB 1: TRIPS & FLEET -->
            @if ($activeTab === 'trips')
                <!-- KPI Quick Summary -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div class="p-6 rounded-3xl bg-[#0b1329] border border-white/10 shadow-xl">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 flex items-center gap-1.5">
                            <span class="text-emerald-400">🚘</span> Active Fleet Vehicles
                        </span>
                        <div class="text-3xl font-black text-white mt-2">{{ $activeVehiclesCount }}</div>
                        <span class="text-[11px] text-emerald-400 mt-1 block">Listed & Available in {{ $profile->service_city }}</span>
                    </div>

                    <div class="p-6 rounded-3xl bg-[#0b1329] border border-white/10 shadow-xl">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 flex items-center gap-1.5">
                            <span class="text-amber-400">⏳</span> Pending Trip Requests
                        </span>
                        <div class="text-3xl font-black text-white mt-2">{{ $pendingBookingsCount }}</div>
                        <span class="text-[11px] text-amber-400 mt-1 block">Awaiting your confirmation</span>
                    </div>

                    <div class="p-6 rounded-3xl bg-[#0b1329] border border-white/10 shadow-xl">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 flex items-center gap-1.5">
                            <span class="text-teal-400">✓</span> Total Completed Trips
                        </span>
                        <div class="text-3xl font-black text-white mt-2">{{ $completedTripsCount }}</div>
                        <span class="text-[11px] text-slate-400 mt-1 block">Driver Rating: {{ number_format($profile->rating ?? 5.0, 1) }} ⭐</span>
                    </div>
                </div>

                <!-- Pending Trip Dispatch Cards -->
                @if ($pendingBookingsCount > 0)
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-black text-white flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-amber-400 animate-ping"></span>
                                <span>Immediate Trip Dispatches ({{ $pendingBookingsCount }})</span>
                            </h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach ($bookingsWithSplit->where('status', 'pending') as $booking)
                                <div class="p-6 rounded-3xl bg-slate-900 border border-amber-500/30 shadow-xl space-y-4">
                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <span class="font-mono font-bold text-amber-400 text-xs">{{ $booking->booking_reference }}</span>
                                            <h3 class="text-base font-bold text-white mt-0.5">{{ $booking->customer_name }}</h3>
                                            <p class="text-xs text-slate-400">📞 {{ $booking->customer_phone }}</p>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-lg font-black text-white">Rs. {{ number_format($booking->total_price) }}</div>
                                            <span class="text-[10px] text-emerald-400 font-bold">Your Share ({{ $driverPct }}%): Rs. {{ number_format($booking->driver_amount) }}</span>
                                        </div>
                                    </div>

                                    <div class="p-3 rounded-xl bg-slate-950/60 text-xs text-slate-300 space-y-1">
                                        <div>📍 <strong>Route:</strong> {{ $booking->pickup_location }} ➔ {{ $booking->return_location }}</div>
                                        <div>📅 <strong>Pickup Date:</strong> {{ $booking->pickup_date->format('M d, Y H:i') }} ({{ $booking->total_days }} Day)</div>
                                        <div>🚘 <strong>Vehicle:</strong> {{ $booking->vehicle ? $booking->vehicle->make . ' ' . $booking->vehicle->model : 'Assigned Fleet' }}</div>
                                    </div>

                                    <div class="flex items-center gap-2 pt-2">
                                        <button
                                            type="button"
                                            wire:click="confirmBooking({{ $booking->id }})"
                                            class="flex-1 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs transition cursor-pointer"
                                        >
                                            Accept & Confirm Trip
                                        </button>
                                        <button
                                            type="button"
                                            wire:click="declineBooking({{ $booking->id }})"
                                            class="px-4 py-2.5 rounded-xl bg-rose-500/20 text-rose-300 hover:bg-rose-500/30 border border-rose-500/30 font-bold text-xs transition cursor-pointer"
                                        >
                                            Decline
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Fleet Listings -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-black text-white">Your Listed Vehicles ({{ $profile->vehicles->count() }})</h2>
                        <button
                            type="button"
                            wire:click="openAddVehicleModal"
                            class="text-xs font-bold text-emerald-400 hover:text-emerald-300 underline cursor-pointer"
                        >
                            + Register Another Car
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse ($profile->vehicles as $veh)
                            <div class="p-6 rounded-3xl bg-[#0b1329] border border-white/10 shadow-xl space-y-4 hover:border-emerald-500/30 transition">
                                <div class="flex items-start justify-between gap-4">
                                    <img
                                        src="{{ $veh->photo_url }}"
                                        alt="{{ $veh->make }} {{ $veh->model }}"
                                        class="w-24 h-20 rounded-2xl object-contain bg-slate-900 p-1 border border-white/10 shrink-0"
                                    />
                                    <div class="text-right">
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $veh->is_active ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-slate-800 text-slate-400' }}">
                                            {{ $veh->is_active ? 'Active' : 'Paused' }}
                                        </span>
                                        <div class="text-base font-black text-white mt-2">Rs. {{ number_format($veh->daily_rate) }}<span class="text-xs font-normal text-slate-400">/day</span></div>
                                    </div>
                                </div>

                                <div>
                                    <h3 class="text-base font-bold text-white">{{ $veh->make }} {{ $veh->model }} ({{ $veh->year }})</h3>
                                    <p class="text-xs text-slate-400 font-mono mt-0.5">Plate: {{ $veh->plate_number }}</p>
                                    <div class="flex flex-wrap gap-1.5 mt-2 text-[11px] text-slate-300">
                                        <span class="px-2 py-0.5 rounded-md bg-slate-900 border border-white/5">{{ ucfirst($veh->fuel_type) }}</span>
                                        <span class="px-2 py-0.5 rounded-md bg-slate-900 border border-white/5">{{ ucfirst($veh->transmission) }}</span>
                                        <span class="px-2 py-0.5 rounded-md bg-slate-900 border border-white/5">{{ $veh->seats }} Seats</span>
                                    </div>
                                </div>

                                <div class="pt-3 border-t border-white/10 flex items-center justify-between">
                                    <button
                                        type="button"
                                        wire:click="toggleVehicleActive({{ $veh->id }})"
                                        class="text-xs font-bold text-slate-300 hover:text-white transition cursor-pointer"
                                    >
                                        {{ $veh->is_active ? 'Pause Listing' : 'Activate Listing' }}
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full p-8 rounded-3xl bg-[#0b1329] border border-white/10 text-center text-slate-400">
                                No vehicles registered yet. Click "Add New Vehicle" to list your first car.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Active / Confirmed Trips -->
                <div class="space-y-4">
                    <h2 class="text-lg font-black text-white">Active & Completed Reservations</h2>
                    <div class="space-y-3">
                        @forelse ($bookingsWithSplit->where('status', '!=', 'pending') as $booking)
                            <div class="p-5 rounded-2xl bg-[#0b1329] border border-white/10 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-mono font-bold text-emerald-400 text-xs">{{ $booking->booking_reference }}</span>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $booking->status === 'completed' ? 'bg-teal-500/20 text-teal-300' : 'bg-emerald-500/20 text-emerald-300' }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </div>
                                    <div class="text-sm font-bold text-white mt-1">{{ $booking->customer_name }} ({{ $booking->customer_phone }})</div>
                                    <div class="text-xs text-slate-400">📍 {{ $booking->pickup_location }} ➔ {{ $booking->return_location }} • {{ $booking->pickup_date->format('M d, Y') }}</div>
                                </div>

                                <div class="flex flex-col md:items-end gap-2 w-full md:w-auto">
                                    <div class="text-base font-black text-white">
                                        Rs. {{ number_format($booking->total_price) }}
                                        <span class="text-xs font-semibold text-emerald-400 block">Driver Share: Rs. {{ number_format($booking->driver_amount) }}</span>
                                    </div>

                                    @if ($booking->status === 'confirmed')
                                        <button
                                            type="button"
                                            wire:click="completeBooking({{ $booking->id }})"
                                            class="px-4 py-1.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs transition cursor-pointer"
                                        >
                                            Mark Trip Completed ✓
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="p-6 rounded-2xl bg-[#0b1329] border border-white/10 text-center text-xs text-slate-400">
                                No active or completed trip history yet.
                            </div>
                        @endforelse
                    </div>
                </div>
            @endif

            <!-- TAB 2: EARNINGS & REVENUE BREAKDOWN (SEPARATE TAB) -->
            @if ($activeTab === 'earnings')
                <div class="space-y-8">
                    <!-- Revenue Split Overview Header -->
                    <div class="p-6 md:p-8 rounded-3xl bg-gradient-to-r from-[#0b1329] via-[#0f1d3a] to-[#0b1329] border border-emerald-500/30 shadow-2xl space-y-4">
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div>
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 inline-block mb-2">
                                    Nepal Revenue Share Model
                                </span>
                                <h2 class="text-2xl font-black text-white">Revenue & Commission Calculation</h2>
                                <p class="text-xs sm:text-sm text-slate-300 mt-1">
                                    Transparent split per reservation: <strong class="text-emerald-400">{{ $driverPct }}% to Partner Driver</strong> and <strong class="text-amber-400">{{ $adminPct }}% to Platform Owner</strong>.
                                </p>
                            </div>
                            <div class="px-4 py-2 rounded-2xl bg-slate-950/80 border border-white/10 text-right">
                                <div class="text-[11px] text-slate-400 uppercase font-semibold">Active Split Rate</div>
                                <div class="text-lg font-black text-white">{{ $driverPct }}% / {{ $adminPct }}%</div>
                            </div>
                        </div>

                        <!-- Progress Bar Visual Distribution -->
                        <div class="space-y-2 pt-2">
                            <div class="h-4 rounded-full bg-slate-900 border border-white/10 overflow-hidden flex shadow-inner">
                                <div class="bg-gradient-to-r from-emerald-500 to-teal-400 h-full flex items-center justify-center text-[10px] font-black text-slate-950" style="width: {{ $driverPct }}%">
                                    Driver {{ $driverPct }}%
                                </div>
                                <div class="bg-gradient-to-r from-amber-500 to-amber-600 h-full flex items-center justify-center text-[10px] font-black text-slate-950" style="width: {{ $adminPct }}%">
                                    Admin {{ $adminPct }}%
                                </div>
                            </div>
                            <div class="flex items-center justify-between text-xs text-slate-400 font-medium px-1">
                                <span>🚘 Partner Driver Payout Share ({{ $driverPct }}%)</span>
                                <span>🏢 Platform Maintenance & Support ({{ $adminPct }}%)</span>
                            </div>
                        </div>
                    </div>

                    <!-- 3 KPI Cards: Total Amount, Amount to Driver, Amount to Admin Owner -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Total Gross Amount -->
                        <div class="p-6 rounded-3xl bg-[#0b1329] border border-white/10 shadow-xl relative overflow-hidden">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Completed Fare</span>
                                <span class="text-xs px-2 py-0.5 rounded-full bg-slate-800 text-slate-300 font-bold">100% Gross</span>
                            </div>
                            <div class="text-3xl sm:text-4xl font-black text-white mt-3">
                                Rs. {{ number_format($totalGrossEarnings) }}
                            </div>
                            <p class="text-xs text-slate-400 mt-2">Total gross revenue from {{ $completedTripsCount }} completed trips</p>
                        </div>

                        <!-- Amount to Driver -->
                        <div class="p-6 rounded-3xl bg-[#0b1329] border border-emerald-500/40 shadow-xl relative overflow-hidden ring-1 ring-emerald-500/30">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold uppercase tracking-wider text-emerald-400">Amount to Driver</span>
                                <span class="text-xs px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 font-bold border border-emerald-500/30">{{ $driverPct }}% Net</span>
                            </div>
                            <div class="text-3xl sm:text-4xl font-black text-emerald-400 mt-3">
                                Rs. {{ number_format($driverNetEarnings) }}
                            </div>
                            <p class="text-xs text-emerald-400/80 mt-2">Direct earnings disbursed to your partner wallet/account</p>
                        </div>

                        <!-- Amount to Admin Owner -->
                        <div class="p-6 rounded-3xl bg-[#0b1329] border border-amber-500/30 shadow-xl relative overflow-hidden">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold uppercase tracking-wider text-amber-400">Amount to Admin Owner</span>
                                <span class="text-xs px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-300 font-bold border border-amber-500/30">{{ $adminPct }}% Fee</span>
                            </div>
                            <div class="text-3xl sm:text-4xl font-black text-amber-400 mt-3">
                                Rs. {{ number_format($adminCommissionTotal) }}
                            </div>
                            <p class="text-xs text-amber-400/80 mt-2">Platform booking processing & 24/7 customer support fee</p>
                        </div>
                    </div>

                    <!-- Comprehensive Trip-by-Trip Financial Calculation Table -->
                    <div class="p-6 sm:p-8 rounded-3xl bg-[#0b1329] border border-white/10 shadow-xl space-y-6">
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div>
                                <h3 class="text-lg font-black text-white">Itemized Calculation Ledger</h3>
                                <p class="text-xs text-slate-400 mt-0.5">Exact split calculation for every reservation across your fleet</p>
                            </div>
                            <div class="text-xs text-slate-400 font-medium">
                                Showing {{ $bookingsWithSplit->count() }} Total Trip Records
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs border-collapse">
                                <thead>
                                    <tr class="border-b border-white/10 text-slate-400 uppercase text-[11px] font-bold">
                                        <th class="py-3 px-3">Booking Ref & Date</th>
                                        <th class="py-3 px-3">Vehicle & Route</th>
                                        <th class="py-3 px-3 text-right">Total Amount (100%)</th>
                                        <th class="py-3 px-3 text-right text-emerald-400">Driver Share ({{ $driverPct }}%)</th>
                                        <th class="py-3 px-3 text-right text-amber-400">Admin Owner ({{ $adminPct }}%)</th>
                                        <th class="py-3 px-3 text-center">Payment & Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/5 text-slate-300">
                                    @forelse ($bookingsWithSplit as $b)
                                        <tr class="hover:bg-slate-900/50 transition">
                                            <td class="py-3.5 px-3">
                                                <div class="font-mono font-bold text-white">{{ $b->booking_reference }}</div>
                                                <div class="text-[10px] text-slate-400">{{ $b->pickup_date->format('M d, Y') }}</div>
                                            </td>
                                            <td class="py-3.5 px-3">
                                                <div class="font-bold text-white">{{ $b->vehicle ? $b->vehicle->make . ' ' . $b->vehicle->model : 'Assigned Car' }}</div>
                                                <div class="text-[11px] text-slate-400 truncate max-w-xs">{{ $b->pickup_location }} ➔ {{ $b->return_location }}</div>
                                            </td>
                                            <td class="py-3.5 px-3 text-right font-black text-white">
                                                Rs. {{ number_format($b->total_price) }}
                                            </td>
                                            <td class="py-3.5 px-3 text-right font-black text-emerald-400">
                                                Rs. {{ number_format($b->driver_amount) }}
                                            </td>
                                            <td class="py-3.5 px-3 text-right font-black text-amber-400">
                                                Rs. {{ number_format($b->admin_amount) }}
                                            </td>
                                            <td class="py-3.5 px-3 text-center">
                                                <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $b->status === 'completed' ? 'bg-teal-500/20 text-teal-300 border border-teal-500/30' : ($b->status === 'confirmed' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : ($b->status === 'cancelled' ? 'bg-rose-500/20 text-rose-300' : 'bg-amber-500/20 text-amber-300')) }}">
                                                    {{ ucfirst($b->status) }}
                                                </span>
                                                <div class="text-[10px] text-slate-400 mt-0.5">{{ ucfirst($b->payment_method ?? 'cash') }}</div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="py-8 text-center text-slate-400 text-xs">
                                                No reservations found to calculate revenue split.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- TAB 3: PARTNER PROFILE -->
            @if ($activeTab === 'profile')
                <div class="max-w-2xl mx-auto p-6 sm:p-8 rounded-3xl bg-[#0b1329] border border-white/10 shadow-xl space-y-6">
                    <div>
                        <h2 class="text-xl font-bold text-white">Partner & Driver Profile</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Manage your personal details and base service city across Nepal</p>
                    </div>

                    @if ($profileSuccessMessage)
                        <div class="p-3 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 text-xs font-bold">
                            {{ $profileSuccessMessage }}
                        </div>
                    @endif

                    <form wire:submit.prevent="updatePartnerProfile" class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Driver / Contact Name</label>
                            <input
                                type="text"
                                wire:model="partnerName"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none"
                                required
                            />
                            @error('partnerName') <span class="text-xs text-rose-400 font-semibold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Phone / WhatsApp Number</label>
                            <input
                                type="text"
                                wire:model="partnerPhone"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none"
                                required
                            />
                            @error('partnerPhone') <span class="text-xs text-rose-400 font-semibold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Primary Service City</label>
                            <select
                                wire:model="partnerCity"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none"
                            >
                                <option value="Kathmandu">Kathmandu Valley</option>
                                <option value="Pokhara">Pokhara & Gandaki</option>
                                <option value="Chitwan">Chitwan & Sauraha</option>
                                <option value="Lumbini">Lumbini (Bhairahawa)</option>
                                <option value="Biratnagar">Biratnagar & Koshi</option>
                                <option value="Nepalgunj">Nepalgunj & West</option>
                            </select>
                            @error('partnerCity') <span class="text-xs text-rose-400 font-semibold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Email (Account Login)</label>
                            <input
                                type="email"
                                value="{{ $profile->user->email }}"
                                disabled
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-900/50 border border-white/5 text-slate-500 text-sm cursor-not-allowed"
                            />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Verified Driving License Number</label>
                            <input
                                type="text"
                                value="{{ $profile->license_number }}"
                                disabled
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-900/50 border border-white/5 text-slate-500 text-sm cursor-not-allowed font-mono"
                            />
                        </div>

                        <button
                            type="submit"
                            class="w-full py-3 rounded-2xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs sm:text-sm shadow-md shadow-emerald-500/20 transition cursor-pointer"
                        >
                            Save Profile Changes
                        </button>
                    </form>
                </div>
            @endif
        </div>
    @endif

    <!-- Add New Vehicle Modal -->
    @if ($isAddVehicleModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm overflow-y-auto">
            <div class="w-full max-w-xl rounded-3xl bg-[#0b1329] border border-white/15 p-6 sm:p-8 shadow-2xl relative my-8">
                <div class="flex items-center justify-between pb-4 border-b border-white/10">
                    <div>
                        <h2 class="text-xl font-bold text-white">Add New Vehicle to Fleet</h2>
                        <p class="text-xs text-slate-400">Register your car for immediate booking dispatch</p>
                    </div>
                    <button type="button" wire:click="closeAddVehicleModal" class="w-8 h-8 rounded-full bg-slate-800 text-slate-400 hover:text-white flex items-center justify-center cursor-pointer">
                        ✕
                    </button>
                </div>

                <form wire:submit.prevent="saveVehicle" class="space-y-4 mt-4">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Make / Brand</label>
                            <input type="text" wire:model="vehMake" placeholder="Mahindra, Toyota, Suzuki" class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-white/10 text-white text-xs" required />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Model Name</label>
                            <input type="text" wire:model="vehModel" placeholder="Scorpio 4WD, Hilux, Swift" class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-white/10 text-white text-xs" required />
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Year</label>
                            <input type="number" wire:model="vehYear" class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-white/10 text-white text-xs" required />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Fuel Type</label>
                            <select wire:model="vehFuelType" class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-white/10 text-white text-xs">
                                <option value="diesel">Diesel</option>
                                <option value="petrol">Petrol</option>
                                <option value="electric">Electric (EV)</option>
                                <option value="hybrid">Hybrid</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Transmission</label>
                            <select wire:model="vehTransmission" class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-white/10 text-white text-xs">
                                <option value="manual">Manual</option>
                                <option value="automatic">Automatic</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Category</label>
                            <select wire:model="vehCategory" class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-white/10 text-white text-xs">
                                <option value="suv_4wd">SUV / 4WD</option>
                                <option value="tourist_van">Tourist Van (HiAce)</option>
                                <option value="compact_suv">Compact SUV (Creta)</option>
                                <option value="hatchback">Hatchback (Swift)</option>
                                <option value="sedan">Sedan (Dzire)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Seating Capacity</label>
                            <input type="number" wire:model="vehSeats" class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-white/10 text-white text-xs" required />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Daily Rate (Rs.)</label>
                            <input type="number" wire:model="vehDailyRate" class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-white/10 text-white text-xs" required />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1">Nepal Plate Number</label>
                        <input type="text" wire:model="vehPlateNumber" placeholder="e.g. Ba 2 Cha 4521" class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-white/10 text-white text-xs" required />
                    </div>

                    <div class="flex items-center gap-4 pt-2 text-xs text-slate-300">
                        <label class="flex items-center gap-1.5 cursor-pointer">
                            <input type="checkbox" wire:model="vehHas4wd" class="rounded text-emerald-500" />
                            <span>Has 4WD</span>
                        </label>
                        <label class="flex items-center gap-1.5 cursor-pointer">
                            <input type="checkbox" wire:model="vehProvidesDriver" class="rounded text-emerald-500" />
                            <span>Provides Driver</span>
                        </label>
                        <label class="flex items-center gap-1.5 cursor-pointer">
                            <input type="checkbox" wire:model="vehAllowsSelfDrive" class="rounded text-emerald-500" />
                            <span>Allows Self-Drive</span>
                        </label>
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-white/10">
                        <button type="button" wire:click="closeAddVehicleModal" class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 hover:text-white text-xs font-bold cursor-pointer">
                            Cancel
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 text-xs font-black shadow-md transition cursor-pointer">
                            Save Vehicle
                        </button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    @endif
</div>
