<div class="max-w-6xl mx-auto py-10 px-4 sm:px-6">
    @if (!$isAuthenticated)
        <!-- Partner Login Box -->
        <div class="max-w-md mx-auto rounded-3xl bg-slate-900 border border-white/10 p-8 shadow-2xl backdrop-blur-xl">
            <div class="text-center mb-6">
                <span class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-600 text-slate-950 font-black text-xl mb-3 shadow-lg shadow-emerald-500/25">H</span>
                <h1 class="text-2xl font-black text-white">Partner Driver Portal</h1>
                <p class="text-xs text-slate-400 mt-1">Manage your vehicle listings and customer bookings</p>
            </div>

            <form wire:submit.prevent="login" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Email Address</label>
                    <input
                        type="email"
                        wire:model="email"
                        placeholder="bikash@hahacar.com"
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none"
                    />
                    @error('email') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Password</label>
                    <input
                        type="password"
                        wire:model="password"
                        placeholder="••••••••"
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none"
                    />
                    @error('password') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                </div>

                <button
                    type="submit"
                    class="w-full py-3 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-slate-950 font-bold text-sm shadow-lg shadow-emerald-500/25 hover:from-emerald-400 hover:to-teal-400 transition"
                >
                    Log In to Partner Portal
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-white/10 text-center">
                <p class="text-xs text-slate-400">
                    Want to list your car or drive?
                    <a href="{{ route('partner.register') }}" class="text-emerald-400 font-bold hover:underline">Register your vehicle</a>
                </p>
            </div>
        </div>
    @else
        <!-- Authenticated Partner Dashboard -->
        <div class="space-y-8">
            <!-- Header Banner -->
            <div class="p-6 md:p-8 rounded-3xl bg-slate-900 border border-white/10 shadow-xl flex flex-wrap items-center justify-between gap-6">
                <div>
                    <div class="flex items-center gap-3">
                        <h1 class="text-2xl md:text-3xl font-black text-white">{{ $profile->user->name }}</h1>
                        @if ($profile->status === 'verified')
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold uppercase bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span>Verified Partner</span>
                            </span>
                        @elseif ($profile->status === 'pending')
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold uppercase bg-amber-500/20 text-amber-300 border border-amber-500/30">
                                <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                                <span>Pending Admin Verification</span>
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold uppercase bg-red-500/20 text-red-300 border border-red-500/30">
                                {{ ucfirst($profile->status) }}
                            </span>
                        @endif
                    </div>
                    <p class="text-xs text-slate-400 mt-1">
                        Operating Base: <span class="text-slate-200 font-semibold">{{ $profile->service_city }}</span> • Phone: {{ $profile->user->phone }}
                    </p>
                </div>

                <div class="flex items-center gap-4">
                    <button
                        type="button"
                        wire:click="logout"
                        class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 text-xs font-semibold hover:bg-slate-700 transition"
                    >
                        Log Out
                    </button>
                </div>
            </div>

            <!-- Pending Review Notice if not verified -->
            @if ($profile->status === 'pending')
                <div class="p-4 rounded-2xl bg-amber-500/10 border border-amber-500/30 flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div class="text-xs text-amber-200">
                        <strong class="font-bold">Documents Under Admin Review:</strong> Your driving license and vehicle bluebook documents are currently being checked by our compliance team. Once verified, your vehicles will be visible for customer bookings on Hahacar.com.
                    </div>
                </div>
            @endif

            <!-- KPI Metric Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-6 rounded-3xl bg-slate-900 border border-white/10">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Bookings</span>
                    <div class="text-3xl font-black text-white mt-1">{{ $profile->total_bookings }}</div>
                    <span class="text-[11px] text-emerald-400 mt-1 block">Completed trips</span>
                </div>

                <div class="p-6 rounded-3xl bg-slate-900 border border-white/10">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Partner Rating</span>
                    <div class="text-3xl font-black text-white mt-1 flex items-center gap-1">
                        <span>{{ $profile->rating }}</span>
                        <span class="text-amber-400 text-2xl">★</span>
                    </div>
                    <span class="text-[11px] text-slate-400 mt-1 block">Based on customer reviews</span>
                </div>

                <div class="p-6 rounded-3xl bg-slate-900 border border-white/10">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Registered Vehicles</span>
                    <div class="text-3xl font-black text-white mt-1">{{ $profile->vehicles->count() }}</div>
                    <span class="text-[11px] text-slate-400 mt-1 block">Active in fleet</span>
                </div>
            </div>

            <!-- Customer Bookings Section -->
            <div class="rounded-3xl bg-slate-900 border border-white/10 p-6 md:p-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-white">Customer Booking Requests</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Manage customer reservations assigned to your fleet</p>
                    </div>
                </div>

                <div class="space-y-4">
                    @forelse ($profile->bookings->sortByDesc('created_at') as $booking)
                        <div class="p-5 rounded-2xl bg-slate-950/60 border border-white/5 flex flex-wrap items-center justify-between gap-4">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="font-mono font-bold text-emerald-400 text-sm">{{ $booking->booking_reference }}</span>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $booking->status === 'confirmed' ? 'bg-emerald-500/20 text-emerald-300' : 'bg-amber-500/20 text-amber-300' }}">
                                        {{ $booking->status }}
                                    </span>
                                </div>
                                <div class="text-sm font-bold text-white mt-1">
                                    {{ $booking->customer_name }} • <a href="tel:{{ $booking->customer_phone }}" class="text-emerald-400 hover:underline">{{ $booking->customer_phone }}</a>
                                </div>
                                <div class="text-xs text-slate-400 mt-0.5">
                                    Route: {{ $booking->pickup_location }} ➔ {{ $booking->return_location }}
                                </div>
                                <div class="text-xs text-slate-400 mt-0.5">
                                    Vehicle: <strong class="text-slate-200">{{ $booking->vehicle->title }}</strong> • {{ $booking->total_days }} days ({{ $booking->pickup_date->format('M d') }} - {{ $booking->return_date->format('M d') }})
                                </div>
                            </div>

                            <div class="text-right">
                                <div class="text-lg font-black text-white">{{ $booking->formatted_total_price }}</div>
                                <div class="text-[10px] text-slate-400 uppercase">{{ $booking->payment_method === 'cash' ? 'Cash on Pickup' : $booking->payment_method }}</div>

                                <div class="mt-3 flex items-center gap-2">
                                    @if ($booking->status === 'pending')
                                        <button
                                            type="button"
                                            wire:click="confirmBooking({{ $booking->id }})"
                                            class="px-3 py-1.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs shadow transition"
                                        >
                                            Confirm Booking
                                        </button>
                                    @elseif ($booking->status === 'confirmed')
                                        <button
                                            type="button"
                                            wire:click="completeBooking({{ $booking->id }})"
                                            class="px-3 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs transition"
                                        >
                                            Mark Completed
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-xs text-slate-400">
                            No customer bookings received yet. As soon as a customer books your vehicle, it will appear here.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- My Registered Vehicles Section -->
            <div class="rounded-3xl bg-slate-900 border border-white/10 p-6 md:p-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-white">My Registered Vehicles</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Your vehicles listed on Hahacar Nepal</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($profile->vehicles as $veh)
                        <div class="p-5 rounded-2xl bg-slate-950/60 border border-white/5 flex gap-4">
                            <img
                                src="{{ $veh->vehicle_photo_path ?? 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=400&q=80' }}"
                                alt="{{ $veh->title }}"
                                class="w-24 h-20 rounded-xl object-cover"
                            />
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-white text-base truncate">{{ $veh->title }}</h3>
                                <div class="text-xs text-slate-400">Plate: {{ $veh->plate_number }} • {{ $veh->category_label }}</div>
                                <div class="text-xs text-emerald-400 font-bold mt-1">{{ $veh->formatted_daily_rate }} / day</div>
                                <div class="mt-2 flex items-center gap-2">
                                    <button
                                        type="button"
                                        wire:click="toggleVehicleActive({{ $veh->id }})"
                                        class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase {{ $veh->is_active ? 'bg-emerald-500/20 text-emerald-300' : 'bg-slate-800 text-slate-400' }}"
                                    >
                                        {{ $veh->is_active ? 'Active for Booking' : 'Paused' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
