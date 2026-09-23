<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6">
    <!-- Top Return Link -->
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('home') }}" wire:navigate class="inline-flex items-center gap-2 text-sm text-slate-400 hover:text-white transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Back to Home</span>
        </a>

        <button
            type="button"
            onclick="window.print()"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-white text-xs font-semibold border border-white/10 transition print:hidden"
        >
            <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            <span>Print / Save Voucher</span>
        </button>
    </div>

    <!-- Digital Voucher Card -->
    <div class="rounded-3xl bg-slate-900 border border-white/10 overflow-hidden shadow-2xl backdrop-blur-xl">
        <!-- Voucher Header Banner -->
        <div class="p-6 md:p-8 bg-gradient-to-r from-emerald-950 via-slate-900 to-slate-900 border-b border-white/10">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-600 text-slate-950 font-black text-base shadow-lg shadow-emerald-500/30">H</span>
                        <span class="font-extrabold text-xl tracking-tight text-white">HAHACAR<span class="text-emerald-400">.COM</span></span>
                        <span class="text-xs px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 font-semibold border border-emerald-500/30">NEPAL</span>
                    </div>
                    <h1 class="text-2xl font-black text-white">Booking Confirmation Voucher</h1>
                    <p class="text-xs text-slate-400 mt-1">Thank you, {{ $booking->customer_name }}. Your reservation has been recorded in our system.</p>
                </div>

                <div class="text-right">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Reference Number</span>
                    <span class="text-2xl font-black font-mono tracking-wider text-emerald-400">{{ $booking->booking_reference }}</span>
                    <div class="mt-2">
                        @if ($booking->status === 'confirmed')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                Confirmed by Partner
                            </span>
                        @elseif ($booking->status === 'pending')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-amber-500/20 text-amber-300 border border-amber-500/30">
                                <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                                Awaiting Partner Confirmation
                            </span>
                        @elseif ($booking->status === 'active')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-blue-500/20 text-blue-300 border border-blue-500/30">
                                Active / On Trip
                            </span>
                        @elseif ($booking->status === 'completed')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-slate-700 text-slate-300">
                                Trip Completed
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-red-500/20 text-red-300 border border-red-500/30">
                                Cancelled
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Body Details -->
        <div class="p-6 md:p-8 space-y-8">
            <!-- Vehicle & Partner Summary -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 rounded-2xl bg-slate-950/60 border border-white/5">
                <!-- Vehicle -->
                <div class="flex items-start gap-4">
                    <img
                        src="{{ $booking->vehicle->vehicle_photo_path ?? 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=400&q=80' }}"
                        alt="{{ $booking->vehicle->title }}"
                        class="w-28 h-20 rounded-2xl object-contain bg-slate-900/90 p-1.5 border border-white/10 shrink-0"
                    />
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-400">Reserved Vehicle</span>
                        <h3 class="text-lg font-bold text-white">{{ $booking->vehicle->title }}</h3>
                        <p class="text-xs text-slate-400 mt-0.5">
                            Plate: <span class="text-white font-mono">{{ $booking->vehicle->plate_number }}</span> • {{ $booking->vehicle->category_label }}
                        </p>
                        <div class="mt-2 inline-flex items-center gap-2 text-xs text-emerald-300">
                            <span class="px-2 py-0.5 rounded bg-emerald-500/20 font-semibold text-[10px]">
                                {{ $booking->service_option === 'with_driver' ? '👔 CHAUFFEUR INCLUDED' : '🔑 SELF-DRIVE' }}
                            </span>
                            @if ($booking->vehicle->has_4wd)
                                <span class="px-2 py-0.5 rounded bg-amber-500/20 text-amber-300 font-semibold text-[10px]">4WD</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Driver / Partner -->
                <div class="flex flex-col justify-between border-t md:border-t-0 md:border-l border-white/10 pt-4 md:pt-0 md:pl-6">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Assigned Partner / Driver</span>
                        <div class="flex items-center gap-2 mt-1">
                            <h4 class="text-base font-bold text-white">{{ $booking->driverProfile->user->name ?? 'Verified Partner' }}</h4>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                Verified ★ {{ $booking->driverProfile->rating }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-400 mt-1">Operating base: {{ $booking->driverProfile->service_city }}</p>
                    </div>

                    <div class="mt-3">
                        <a
                            href="tel:{{ $booking->driverProfile->user->phone ?? '' }}"
                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-300 font-semibold text-xs transition"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span>Call Partner: {{ $booking->driverProfile->user->phone ?? 'Contact Ops' }}</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Route & Schedule Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Pickup Details -->
                <div class="p-5 rounded-2xl bg-slate-950/40 border border-white/5">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400 flex items-center gap-1.5 mb-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                        Pickup Schedule & Location
                    </span>
                    <div class="text-sm font-bold text-white">{{ $booking->pickup_location }}</div>
                    <div class="text-xs text-emerald-400 font-semibold mt-1">
                        {{ $booking->pickup_date->format('l, F j, Y \a\t g:i A') }}
                    </div>
                </div>

                <!-- Return Details -->
                <div class="p-5 rounded-2xl bg-slate-950/40 border border-white/5">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400 flex items-center gap-1.5 mb-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-teal-400"></span>
                        Return Schedule & Location
                    </span>
                    <div class="text-sm font-bold text-white">{{ $booking->return_location }}</div>
                    <div class="text-xs text-teal-400 font-semibold mt-1">
                        {{ $booking->return_date->format('l, F j, Y \a\t g:i A') }}
                    </div>
                </div>
            </div>

            <!-- Customer & Billing Summary -->
            <div class="p-6 rounded-2xl bg-slate-950/40 border border-white/5">
                <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Fare & Billing Breakdown</h4>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between text-slate-400">
                        <span>Daily Rate</span>
                        <span class="text-white">{{ $booking->formatted_daily_rate }} / day</span>
                    </div>
                    <div class="flex justify-between text-slate-400">
                        <span>Rental Duration</span>
                        <span class="text-white">{{ $booking->total_days }} {{ Str::plural('Day', $booking->total_days) }}</span>
                    </div>
                    <div class="flex justify-between text-slate-400">
                        <span>Payment Method</span>
                        <span class="text-white uppercase font-semibold">{{ $booking->payment_method === 'cash' ? 'Cash on Pickup' : $booking->payment_method }}</span>
                    </div>
                    <div class="pt-3 border-t border-white/10 flex justify-between items-center">
                        <span class="text-base font-bold text-white">Total Amount Due</span>
                        <span class="text-2xl font-black text-emerald-400">{{ $booking->formatted_total_price }}</span>
                    </div>
                </div>
            </div>

            @if (!empty($booking->special_requests))
                <div class="p-4 rounded-xl bg-slate-800/40 border border-white/5 text-xs text-slate-300">
                    <span class="font-bold text-white block mb-0.5">Special Requests:</span>
                    {{ $booking->special_requests }}
                </div>
            @endif

            <!-- Cancellation Option -->
            @if ($booking->status === 'pending')
                <div class="pt-4 flex items-center justify-between border-t border-white/5">
                    <span class="text-xs text-slate-400">Need to cancel this reservation?</span>
                    <button
                        type="button"
                        wire:click="cancelBooking"
                        wire:confirm="Are you sure you want to cancel this booking?"
                        class="text-xs text-red-400 hover:text-red-300 font-semibold hover:underline"
                    >
                        Cancel Booking
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>
