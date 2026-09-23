<div class="max-w-3xl mx-auto py-12 px-4 sm:px-6">
    @if ($isSubmitted)
        <!-- Success / Pending Review Card -->
        <div class="rounded-3xl bg-slate-900 border border-emerald-500/30 p-8 md:p-12 text-center shadow-2xl backdrop-blur-xl">
            <div class="w-20 h-20 rounded-full bg-emerald-500/20 border border-emerald-500/40 mx-auto flex items-center justify-center text-emerald-400 mb-6">
                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-amber-500/20 text-amber-300 border border-amber-500/30 mb-3 inline-block">
                Pending Admin Verification
            </span>

            <h2 class="text-3xl font-black text-white mb-3">Application Submitted Successfully!</h2>
            <p class="text-sm text-slate-300 max-w-lg mx-auto mb-6">
                Thank you, <strong class="text-white">{{ $name }}</strong>. Your driver profile and vehicle (<span class="text-emerald-400">{{ $vehicleMake }} {{ $vehicleModel }}</span>) have been submitted to our operations team.
            </p>

            <div class="p-6 rounded-2xl bg-slate-950/60 border border-white/5 max-w-md mx-auto text-left text-xs text-slate-400 space-y-2 mb-8">
                <div class="flex items-center gap-2 text-white font-semibold">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>What happens next:</span>
                </div>
                <p>1. Our compliance team verifies your driving license and vehicle bluebook.</p>
                <p>2. Verification usually completes within <strong>2 to 4 hours</strong>.</p>
                <p>3. Once approved, your car is listed on Hahacar.com for direct customer bookings in {{ $serviceCity }}.</p>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-4">
                <a
                    href="{{ route('home') }}"
                    class="px-6 py-3 rounded-2xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-sm shadow-lg shadow-emerald-500/25 transition"
                >
                    Return to Homepage
                </a>
            </div>
        </div>
    @else
        <!-- Multi-Step Registration Form -->
        <div class="rounded-3xl bg-slate-900 border border-white/10 p-6 md:p-10 shadow-2xl backdrop-blur-xl">
            <!-- Header -->
            <div class="text-center mb-8">
                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 mb-3">
                    Partner With Hahacar Nepal
                </span>
                <h1 class="text-3xl font-black text-white">Register Your Vehicle & Drive</h1>
                <p class="text-sm text-slate-400 mt-1 max-w-md mx-auto">
                    List your Scorpio, Hilux, Creta, Swift, or tourist van. Earn directly from tourists and local travelers across Nepal.
                </p>
            </div>

            <!-- Step Progress Indicator -->
            <div class="grid grid-cols-3 gap-2 mb-8 pb-6 border-b border-white/10 text-center">
                <div class="{{ $step >= 1 ? 'text-emerald-400' : 'text-slate-500' }}">
                    <div class="text-xs font-bold mb-1">Step 1</div>
                    <div class="text-xs font-semibold">Personal Info</div>
                    <div class="h-1 rounded-full mt-2 {{ $step >= 1 ? 'bg-emerald-500' : 'bg-slate-800' }}"></div>
                </div>
                <div class="{{ $step >= 2 ? 'text-emerald-400' : 'text-slate-500' }}">
                    <div class="text-xs font-bold mb-1">Step 2</div>
                    <div class="text-xs font-semibold">Documents</div>
                    <div class="h-1 rounded-full mt-2 {{ $step >= 2 ? 'bg-emerald-500' : 'bg-slate-800' }}"></div>
                </div>
                <div class="{{ $step >= 3 ? 'text-emerald-400' : 'text-slate-500' }}">
                    <div class="text-xs font-bold mb-1">Step 3</div>
                    <div class="text-xs font-semibold">Vehicle Profile</div>
                    <div class="h-1 rounded-full mt-2 {{ $step >= 3 ? 'bg-emerald-500' : 'bg-slate-800' }}"></div>
                </div>
            </div>

            <!-- STEP 1: Personal Info -->
            @if ($step === 1)
                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-white mb-2">1. Your Profile & Contact Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Full Legal Name *</label>
                            <input
                                type="text"
                                wire:model="name"
                                placeholder="e.g. Bikash Gurung"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none"
                            />
                            @error('name') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Mobile / WhatsApp Number *</label>
                            <input
                                type="text"
                                wire:model="phone"
                                placeholder="+977 98XXXXXXXX"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none"
                            />
                            @error('phone') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Email Address *</label>
                            <input
                                type="email"
                                wire:model="email"
                                placeholder="driver@domain.com"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none"
                            />
                            @error('email') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Password *</label>
                            <input
                                type="password"
                                wire:model="password"
                                placeholder="Choose a secure password"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none"
                            />
                            @error('password') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Primary Operating City *</label>
                            <select
                                wire:model="serviceCity"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none"
                            >
                                <option value="Kathmandu">Kathmandu (Bagmati)</option>
                                <option value="Pokhara">Pokhara (Gandaki)</option>
                                <option value="Chitwan">Chitwan (Narayani)</option>
                                <option value="Lumbini">Lumbini / Bhairahawa</option>
                                <option value="Biratnagar">Biratnagar (Eastern)</option>
                                <option value="Nepalgunj">Nepalgunj (Western)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Partner Type *</label>
                            <select
                                wire:model="partnerType"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none"
                            >
                                <option value="individual_driver">Individual Driver / Chauffeur</option>
                                <option value="vehicle_owner">Private Vehicle Owner</option>
                                <option value="fleet_operator">Rental Fleet Operator</option>
                            </select>
                        </div>
                    </div>

                    <div class="pt-6 flex justify-end">
                        <button
                            type="button"
                            wire:click="nextStep"
                            class="px-6 py-3 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-bold text-sm shadow-lg shadow-emerald-500/25 transition flex items-center gap-2"
                        >
                            <span>Next: Upload Documents</span>
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            <!-- STEP 2: Documents -->
            @if ($step === 2)
                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-white mb-2">2. Verification Documents (Required for Admin Approval)</h3>
                    <p class="text-xs text-slate-400 mb-4">
                        To maintain trust and safety across Nepal, our admin team verifies your Driving License and Vehicle Bluebook before listing your vehicle.
                    </p>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1">Nepali Driving License Number *</label>
                        <input
                            type="text"
                            wire:model="licenseNumber"
                            placeholder="e.g. 01-06-00459812"
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none"
                        />
                        @error('licenseNumber') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- License Upload -->
                        <div class="p-4 rounded-2xl bg-slate-950/60 border border-white/10">
                            <label class="block text-xs font-bold text-white mb-1">Driving License Photo</label>
                            <p class="text-[11px] text-slate-400 mb-3">Clear photo of the front of your license</p>
                            <input
                                type="file"
                                wire:model="licensePhoto"
                                accept="image/*"
                                class="text-xs text-slate-400 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-500/20 file:text-emerald-300 hover:file:bg-emerald-500/30"
                            />
                            @if ($licensePhoto)
                                <div class="mt-2 text-xs text-emerald-400">✓ File selected</div>
                            @endif
                            @error('licensePhoto') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Bluebook Upload -->
                        <div class="p-4 rounded-2xl bg-slate-950/60 border border-white/10">
                            <label class="block text-xs font-bold text-white mb-1">Vehicle Bluebook Photo</label>
                            <p class="text-[11px] text-slate-400 mb-3">Registration page showing vehicle details</p>
                            <input
                                type="file"
                                wire:model="bluebookPhoto"
                                accept="image/*"
                                class="text-xs text-slate-400 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-500/20 file:text-emerald-300 hover:file:bg-emerald-500/30"
                            />
                            @if ($bluebookPhoto)
                                <div class="mt-2 text-xs text-emerald-400">✓ File selected</div>
                            @endif
                            @error('bluebookPhoto') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="pt-6 flex items-center justify-between">
                        <button
                            type="button"
                            wire:click="previousStep"
                            class="px-5 py-2.5 rounded-xl bg-slate-800 text-slate-300 text-xs font-semibold hover:bg-slate-700 transition"
                        >
                            ← Back
                        </button>

                        <button
                            type="button"
                            wire:click="nextStep"
                            class="px-6 py-3 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-bold text-sm shadow-lg shadow-emerald-500/25 transition flex items-center gap-2"
                        >
                            <span>Next: Vehicle Profile</span>
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            <!-- STEP 3: Vehicle Info -->
            @if ($step === 3)
                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-white mb-2">3. Vehicle Profile & Pricing</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Vehicle Category *</label>
                            <select
                                wire:model="vehicleCategory"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none"
                            >
                                <option value="suv_4wd">4WD Mountain SUV (Scorpio / Hilux)</option>
                                <option value="compact_suv">Compact SUV (Creta / Vitara)</option>
                                <option value="tourist_van">Tourist Commuter Van (HiAce)</option>
                                <option value="sedan">Comfort Sedan</option>
                                <option value="hatchback">City Hatchback (Swift / i10)</option>
                                <option value="luxury_suv">Premium Luxury 4WD (Prado)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Plate / Registration Number *</label>
                            <input
                                type="text"
                                wire:model="plateNumber"
                                placeholder="e.g. Ba 2 Cha 4521"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none"
                            />
                            @error('plateNumber') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Vehicle Make *</label>
                            <input
                                type="text"
                                wire:model="vehicleMake"
                                placeholder="e.g. Mahindra, Toyota"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none"
                            />
                            @error('vehicleMake') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Model & Trim *</label>
                            <input
                                type="text"
                                wire:model="vehicleModel"
                                placeholder="e.g. Scorpio 4WD S11"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none"
                            />
                            @error('vehicleModel') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Year</label>
                            <input
                                type="number"
                                wire:model="vehicleYear"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none"
                            />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Passenger Seats</label>
                            <input
                                type="number"
                                wire:model="seatingCapacity"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none"
                            />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Transmission</label>
                            <select
                                wire:model="transmission"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none"
                            >
                                <option value="manual">Manual</option>
                                <option value="automatic">Automatic</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Fuel Type</label>
                            <select
                                wire:model="fuelType"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-white/10 text-white text-sm focus:border-emerald-500 outline-none"
                            >
                                <option value="diesel">Diesel</option>
                                <option value="petrol">Petrol</option>
                                <option value="electric">Electric (EV)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Pricing in NPR -->
                    <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20">
                        <label class="block text-xs font-bold text-emerald-300 mb-1">Your Daily Rental Rate (NPR Rs.) *</label>
                        <p class="text-[11px] text-slate-400 mb-2">Customers will pay this rate per 24 hours of rental</p>
                        <div class="relative">
                            <span class="absolute left-4 top-2.5 text-emerald-400 font-bold text-sm">Rs.</span>
                            <input
                                type="number"
                                wire:model="dailyRate"
                                placeholder="4500"
                                class="w-full pl-12 pr-4 py-2.5 rounded-xl bg-slate-900 border border-white/10 text-white font-bold text-sm focus:border-emerald-500 outline-none"
                            />
                        </div>
                        @error('dailyRate') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Photo Upload -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1">Vehicle Photo (Exterior)</label>
                        <input
                            type="file"
                            wire:model="vehiclePhoto"
                            accept="image/*"
                            class="text-xs text-slate-400 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-500/20 file:text-emerald-300 hover:file:bg-emerald-500/30"
                        />
                    </div>

                    <!-- Service Options Toggles -->
                    <div class="grid grid-cols-2 gap-4 pt-2">
                        <label class="flex items-center gap-2 text-xs text-slate-300 cursor-pointer">
                            <input type="checkbox" wire:model="providesDriver" class="rounded bg-slate-800 border-white/20 text-emerald-500">
                            <span>Available with Driver (Chauffeur)</span>
                        </label>
                        <label class="flex items-center gap-2 text-xs text-slate-300 cursor-pointer">
                            <input type="checkbox" wire:model="allowsSelfDrive" class="rounded bg-slate-800 border-white/20 text-emerald-500">
                            <span>Available for Self-Drive</span>
                        </label>
                    </div>

                    <div class="pt-6 flex items-center justify-between">
                        <button
                            type="button"
                            wire:click="previousStep"
                            class="px-5 py-2.5 rounded-xl bg-slate-800 text-slate-300 text-xs font-semibold hover:bg-slate-700 transition"
                        >
                            ← Back
                        </button>

                        <button
                            type="button"
                            wire:click="submitApplication"
                            wire:loading.attr="disabled"
                            class="px-8 py-3 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black text-sm shadow-xl shadow-emerald-500/30 transition flex items-center gap-2"
                        >
                            <span wire:loading.remove>Submit Application for Verification</span>
                            <span wire:loading>Submitting Documents...</span>
                        </button>
                    </div>
                </div>
            @endif
        </div>
    @endif
</div>
