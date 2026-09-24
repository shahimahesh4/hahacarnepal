<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    @if (!$isAuthenticated)
        <!-- Partner Login Box -->
        <div class="max-w-md mx-auto rounded-3xl bg-[#0b1329] border border-white/10 p-8 sm:p-10 shadow-2xl backdrop-blur-xl relative overflow-hidden">
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>

            <div class="text-center mb-8 relative">
                <a wire:navigate href="{{ route('home') }}" class="inline-block mb-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Hahakar Nepal" class="h-14 w-auto mx-auto object-contain bg-white rounded-2xl px-3 py-1.5 shadow-md">
                </a>
                <h1 class="text-2xl sm:text-3xl font-black text-white">Partner Driver Portal</h1>
                <p class="text-xs sm:text-sm text-slate-400 mt-1">Manage your vehicle listings, trip dispatch & earnings</p>
            </div>

            <form wire:submit.prevent="login" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Registered Email</label>
                    <input
                        type="email"
                        wire:model="email"
                        placeholder="bikash@hahakar.com"
                        class="w-full px-4 py-3 rounded-2xl bg-slate-900 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none"
                        required
                    />
                    @error('email') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Password</label>
                    <input
                        type="password"
                        wire:model="password"
                        placeholder="••••••••"
                        class="w-full px-4 py-3 rounded-2xl bg-slate-900 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none"
                        required
                    />
                    @error('password') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 text-slate-950 font-black text-sm shadow-xl shadow-emerald-500/25 hover:from-emerald-400 hover:to-teal-400 transition cursor-pointer flex items-center justify-center gap-2"
                >
                    <span wire:loading.remove>Log In to Partner Portal</span>
                    <span wire:loading>Signing in...</span>
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-white/10 text-center space-y-2">
                <p class="text-xs text-slate-400">
                    Want to list your vehicle or drive in Nepal?
                    <a wire:navigate href="{{ route('partner.register') }}" class="text-emerald-400 font-bold hover:underline">Register your vehicle</a>
                </p>
                <p class="text-xs text-slate-500">
                    Looking for customer booking?
                    <a wire:navigate href="{{ route('customer.login') }}" class="text-slate-300 font-semibold hover:text-emerald-400">Customer Sign In →</a>
                </p>
            </div>
        </div>
    @else
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
                        class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black text-xs shadow-lg shadow-emerald-500/25 transition cursor-pointer flex items-center gap-1.5"
                    >
                        <span>+</span>
                        <span>Add New Vehicle</span>
                    </button>
                    <button
                        type="button"
                        wire:click="logout"
                        class="px-4 py-2.5 rounded-xl bg-slate-900 border border-white/10 text-slate-300 hover:text-white text-xs font-bold hover:bg-slate-800 transition cursor-pointer"
                    >
                        Log Out
                    </button>
                </div>
            </div>

            <!-- Flash Notices -->
            @if (session()->has('bookingMessage'))
                <div class="p-4 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-300 text-xs font-bold flex items-center justify-between">
                    <span>{{ session('bookingMessage') }}</span>
                </div>
            @endif

            @if ($vehicleSuccessMessage)
                <div class="p-4 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-300 text-xs font-bold flex items-center justify-between">
                    <span>{{ $vehicleSuccessMessage }}</span>
                </div>
            @endif

            <!-- Pending Review Notice if not verified -->
            @if ($profile->status === 'pending')
                <div class="p-4 rounded-2xl bg-amber-500/10 border border-amber-500/30 flex items-start gap-3">
                    <span class="text-amber-400 text-lg">⚠️</span>
                    <div class="text-xs text-amber-200 leading-relaxed">
                        <strong class="font-bold">Documents Under Verification:</strong> Your driving license and vehicle bluebook documents are currently being checked by our compliance team. Once verified, your vehicles will automatically be live for customer bookings.
                    </div>
                </div>
            @endif

            <!-- KPI Metric Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-5">
                <div class="p-6 rounded-3xl bg-[#0b1329] border border-white/10 shadow-xl">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Revenue Earned</span>
                    <div class="text-2xl sm:text-3xl font-black text-white mt-1">Rs. {{ number_format($totalEarnings) }}</div>
                    <span class="text-[11px] text-emerald-400 mt-1 block">From completed trips</span>
                </div>

                <div class="p-6 rounded-3xl bg-[#0b1329] border border-white/10 shadow-xl">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Pending Requests</span>
                    <div class="text-2xl sm:text-3xl font-black text-white mt-1">{{ $pendingBookingsCount }}</div>
                    <span class="text-[11px] text-amber-400 mt-1 block">Awaiting your confirmation</span>
                </div>

                <div class="p-6 rounded-3xl bg-[#0b1329] border border-white/10 shadow-xl">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Active Fleet Vehicles</span>
                    <div class="text-2xl sm:text-3xl font-black text-white mt-1">{{ $activeVehiclesCount }} / {{ $profile->vehicles->count() }}</div>
                    <span class="text-[11px] text-slate-400 mt-1 block">Listed on platform</span>
                </div>

                <div class="p-6 rounded-3xl bg-[#0b1329] border border-white/10 shadow-xl">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Partner Rating</span>
                    <div class="text-2xl sm:text-3xl font-black text-white mt-1 flex items-center gap-1">
                        <span>{{ $profile->rating ?? '5.0' }}</span>
                        <span class="text-amber-400 text-2xl">★</span>
                    </div>
                    <span class="text-[11px] text-slate-400 mt-1 block">{{ $profile->total_bookings }} total trips</span>
                </div>
            </div>

            <!-- Customer Bookings Section -->
            <div class="rounded-3xl bg-[#0b1329] border border-white/10 p-6 md:p-8 shadow-xl">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-white">Trip Reservations & Dispatch Queue</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Manage customer booking requests assigned to your vehicles</p>
                    </div>
                </div>

                <div class="space-y-4">
                    @forelse ($profile->bookings->sortByDesc('created_at') as $booking)
                        <div class="p-5 rounded-2xl bg-slate-900 border border-white/5 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="font-mono font-bold text-emerald-400 text-sm">{{ $booking->booking_reference }}</span>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase
                                        {{ $booking->status === 'confirmed' ? 'bg-emerald-500/20 text-emerald-300' : '' }}
                                        {{ $booking->status === 'pending' ? 'bg-amber-500/20 text-amber-300' : '' }}
                                        {{ $booking->status === 'completed' ? 'bg-blue-500/20 text-blue-300' : '' }}
                                        {{ $booking->status === 'cancelled' ? 'bg-rose-500/20 text-rose-300' : '' }}
                                    ">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                    <span class="text-[11px] text-slate-400">• {{ $booking->service_option === 'with_driver' ? 'Chauffeur Driven' : 'Self-Drive' }}</span>
                                </div>

                                <div class="text-sm font-bold text-white">
                                    Customer: {{ $booking->customer_name }} •
                                    <a href="tel:{{ $booking->customer_phone }}" class="text-emerald-400 hover:underline">{{ $booking->customer_phone }}</a>
                                </div>

                                <div class="text-xs text-slate-400">
                                    Route: {{ $booking->pickup_location }} ➔ {{ $booking->return_location }}
                                </div>

                                <div class="text-xs text-slate-400">
                                    Vehicle: <strong class="text-slate-200">{{ $booking->vehicle ? $booking->vehicle->title : 'Vehicle' }}</strong> •
                                    {{ $booking->total_days }} days ({{ $booking->pickup_date->format('M d') }} - {{ $booking->return_date->format('M d') }})
                                </div>
                            </div>

                            <div class="flex flex-col md:items-end w-full md:w-auto pt-3 md:pt-0 border-t md:border-t-0 border-white/5">
                                <div class="text-xl font-black text-white">{{ $booking->formatted_total_price }}</div>
                                <div class="text-[10px] text-slate-400 uppercase font-semibold">
                                    {{ $booking->payment_method === 'cash' ? 'Cash on Handover' : ucfirst($booking->payment_method) }}
                                </div>

                                <div class="mt-3 flex items-center gap-2">
                                    @if ($booking->status === 'pending')
                                        <button
                                            type="button"
                                            wire:click="confirmBooking({{ $booking->id }})"
                                            class="px-3.5 py-1.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs shadow transition cursor-pointer"
                                        >
                                            Accept Booking
                                        </button>
                                        <button
                                            type="button"
                                            wire:click="declineBooking({{ $booking->id }})"
                                            class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-rose-900/50 text-rose-300 font-bold text-xs border border-white/10 transition cursor-pointer"
                                        >
                                            Decline
                                        </button>
                                    @elseif ($booking->status === 'confirmed')
                                        <button
                                            type="button"
                                            wire:click="completeBooking({{ $booking->id }})"
                                            class="px-4 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs shadow transition cursor-pointer"
                                        >
                                            Mark Trip Completed
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 text-xs text-slate-400">
                            No reservations received yet. Incoming trips booked for your vehicles will show up here in real time.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- My Registered Vehicles Section -->
            <div class="rounded-3xl bg-[#0b1329] border border-white/10 p-6 md:p-8 shadow-xl">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-white">My Registered Vehicles ({{ $profile->vehicles->count() }})</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Manage your active vehicle listings on Hahakar Nepal</p>
                    </div>
                    <button
                        type="button"
                        wire:click="openAddVehicleModal"
                        class="px-4 py-2 rounded-xl bg-emerald-500 text-slate-950 font-bold text-xs shadow hover:bg-emerald-400 transition cursor-pointer"
                    >
                        + Add Vehicle
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($profile->vehicles as $veh)
                        <div class="p-5 rounded-2xl bg-slate-900 border border-white/5 flex gap-4 items-start">
                            <img
                                src="{{ $veh->vehicle_photo_path ? asset($veh->vehicle_photo_path) : asset('images/vehicles/scorpio.jpg') }}"
                                alt="{{ $veh->title }}"
                                class="w-28 h-20 rounded-2xl object-contain bg-slate-950 p-1.5 border border-white/10 shrink-0"
                            />
                            <div class="flex-1 min-w-0 space-y-1">
                                <h3 class="font-bold text-white text-base truncate">{{ $veh->title }}</h3>
                                <div class="text-xs text-slate-400">
                                    Plate: <strong class="text-slate-200">{{ $veh->plate_number }}</strong> • {{ $veh->fuel_type_label ?? ucfirst($veh->fuel_type) }}
                                </div>
                                <div class="text-xs text-emerald-400 font-bold">
                                    {{ $veh->formatted_daily_rate }} / day • {{ $veh->has_4wd ? '4WD Mountain Ready' : '2WD' }}
                                </div>
                                <div class="pt-2 flex items-center gap-2">
                                    <button
                                        type="button"
                                        wire:click="toggleVehicleActive({{ $veh->id }})"
                                        class="px-3 py-1 rounded-lg text-[10px] font-bold uppercase transition cursor-pointer {{ $veh->is_active ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-slate-800 text-slate-400 border border-white/5' }}"
                                    >
                                        {{ $veh->is_active ? '✓ Active for Booking' : '⏸ Paused' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Partner Profile Update Section -->
            <div class="rounded-3xl bg-[#0b1329] border border-white/10 p-6 md:p-8 shadow-xl space-y-6">
                <div>
                    <h2 class="text-lg font-bold text-white">Partner Profile Information</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Keep your operating hub and phone number up to date</p>
                </div>

                @if ($profileSuccessMessage)
                    <div class="p-3 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 text-xs font-bold">
                        {{ $profileSuccessMessage }}
                    </div>
                @endif

                <form wire:submit.prevent="updatePartnerProfile" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Full Name</label>
                        <input
                            type="text"
                            wire:model="partnerName"
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none"
                            required
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Phone Number</label>
                        <input
                            type="text"
                            wire:model="partnerPhone"
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none"
                            required
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Primary Service City</label>
                        <select
                            wire:model="partnerCity"
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none"
                        >
                            <option value="Kathmandu">Kathmandu</option>
                            <option value="Pokhara">Pokhara</option>
                            <option value="Chitwan">Chitwan</option>
                            <option value="Lumbini">Lumbini</option>
                            <option value="Biratnagar">Biratnagar</option>
                            <option value="Nepalgunj">Nepalgunj</option>
                            <option value="Mustang">Mustang</option>
                        </select>
                    </div>

                    <div class="md:col-span-3 pt-2">
                        <button
                            type="submit"
                            class="px-5 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs shadow-lg transition cursor-pointer"
                        >
                            Update Partner Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Add Vehicle Modal -->
        @if ($isAddVehicleModalOpen)
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md">
                <div class="w-full max-w-xl bg-[#0b1329] border border-white/10 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6 max-h-[90vh] overflow-y-auto">
                    <div class="flex items-center justify-between border-b border-white/10 pb-4">
                        <h2 class="text-xl font-bold text-white">Add Vehicle to Fleet</h2>
                        <button
                            type="button"
                            wire:click="closeAddVehicleModal"
                            class="w-8 h-8 rounded-full bg-slate-800 text-slate-300 flex items-center justify-center cursor-pointer"
                        >
                            ✕
                        </button>
                    </div>

                    <form wire:submit.prevent="saveVehicle" class="space-y-4">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Make *</label>
                                <input
                                    type="text"
                                    wire:model="vehMake"
                                    placeholder="e.g. Mahindra / Toyota / BYD"
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-900 border border-white/10 text-white text-xs focus:border-emerald-500 outline-none"
                                    required
                                />
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Model *</label>
                                <input
                                    type="text"
                                    wire:model="vehModel"
                                    placeholder="e.g. Scorpio 4WD / HiAce / Atto 3"
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-900 border border-white/10 text-white text-xs focus:border-emerald-500 outline-none"
                                    required
                                />
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Category *</label>
                                <select
                                    wire:model="vehCategory"
                                    class="w-full px-3 py-2.5 rounded-xl bg-slate-900 border border-white/10 text-white text-xs focus:border-emerald-500 outline-none"
                                >
                                    <option value="suv_4wd">4WD SUV</option>
                                    <option value="van">Tourist Van (HiAce)</option>
                                    <option value="sedan">Sedan</option>
                                    <option value="hatchback">Hatchback</option>
                                    <option value="ev">Electric EV</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Fuel Type *</label>
                                <select
                                    wire:model="vehFuelType"
                                    class="w-full px-3 py-2.5 rounded-xl bg-slate-900 border border-white/10 text-white text-xs focus:border-emerald-500 outline-none"
                                >
                                    <option value="diesel">Diesel</option>
                                    <option value="petrol">Petrol</option>
                                    <option value="electric">Electric EV</option>
                                    <option value="hybrid">Hybrid</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Year *</label>
                                <input
                                    type="number"
                                    wire:model="vehYear"
                                    class="w-full px-3 py-2.5 rounded-xl bg-slate-900 border border-white/10 text-white text-xs focus:border-emerald-500 outline-none"
                                    required
                                />
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Plate Number *</label>
                                <input
                                    type="text"
                                    wire:model="vehPlateNumber"
                                    placeholder="e.g. Ba 2 Cha 9900"
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-900 border border-white/10 text-white text-xs focus:border-emerald-500 outline-none"
                                    required
                                />
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Daily Rate (NPR) *</label>
                                <input
                                    type="number"
                                    wire:model="vehDailyRate"
                                    placeholder="4500"
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-900 border border-white/10 text-white text-xs focus:border-emerald-500 outline-none"
                                    required
                                />
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-4 pt-2 text-xs text-slate-300">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" wire:model="vehHas4wd" class="rounded bg-slate-900 text-emerald-500">
                                <span>4WD Mountain Capability</span>
                            </label>

                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" wire:model="vehProvidesDriver" class="rounded bg-slate-900 text-emerald-500">
                                <span>Provides Driver</span>
                            </label>

                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" wire:model="vehAllowsSelfDrive" class="rounded bg-slate-900 text-emerald-500">
                                <span>Allows Self-Drive</span>
                            </label>
                        </div>

                        <div class="pt-4 flex items-center justify-end gap-3 border-t border-white/10">
                            <button
                                type="button"
                                wire:click="closeAddVehicleModal"
                                class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 text-xs font-bold cursor-pointer"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                class="px-5 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs shadow-lg transition cursor-pointer"
                            >
                                Register Vehicle
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    @endif
</div>
