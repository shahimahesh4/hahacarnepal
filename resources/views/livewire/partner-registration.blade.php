<div class="max-w-4xl mx-auto py-8 sm:py-12 px-4 sm:px-6 lg:px-8">
    @if ($isSubmitted)
        <!-- Success / Pending Review Card -->
        <div class="rounded-3xl bg-[#0b1329] border border-emerald-500/30 p-8 sm:p-12 text-center shadow-2xl backdrop-blur-xl relative overflow-hidden">
            <div class="absolute -top-12 -right-12 w-48 h-48 bg-emerald-500/15 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-12 -left-12 w-48 h-48 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative">
                <div class="w-20 h-20 rounded-3xl bg-emerald-500/15 border border-emerald-500/30 mx-auto flex items-center justify-center text-emerald-400 mb-6 shadow-xl shadow-emerald-500/10">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <span class="px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-amber-500/15 text-amber-300 border border-amber-500/30 mb-4 inline-block">
                    ⏳ Pending Admin Verification
                </span>

                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white mb-3 tracking-tight">Application Submitted Successfully!</h2>
                <p class="text-sm text-slate-300 max-w-lg mx-auto mb-8 leading-relaxed">
                    Thank you, <strong class="text-white">{{ $name }}</strong>. Your driver profile and vehicle (<span class="text-emerald-400 font-semibold">{{ $vehicleMake }} {{ $vehicleModel }}</span>) have been submitted to our operations team.
                </p>

                <div class="p-6 rounded-2xl bg-slate-900/90 border border-slate-700/80 max-w-lg mx-auto text-left text-xs text-slate-400 space-y-3 mb-8 shadow-inner">
                    <div class="flex items-center gap-2 text-white font-bold text-sm border-b border-slate-800 pb-2.5">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span>What happens next:</span>
                    </div>
                    <p class="flex items-start gap-2">
                        <span class="text-emerald-400 font-bold">1.</span>
                        <span>Our compliance team verifies your Nepali Driving License and Vehicle Bluebook.</span>
                    </p>
                    <p class="flex items-start gap-2">
                        <span class="text-emerald-400 font-bold">2.</span>
                        <span>Verification is typically completed within <strong class="text-white">2 to 4 hours</strong>.</span>
                    </p>
                    <p class="flex items-start gap-2">
                        <span class="text-emerald-400 font-bold">3.</span>
                        <span>Once approved, your vehicle will be listed live on Hahakar for travelers in <strong class="text-white">{{ $serviceCity }}</strong>.</span>
                    </p>
                </div>

                <div class="flex flex-wrap items-center justify-center gap-4">
                    <a
                        wire:navigate
                        href="{{ route('home') }}"
                        class="px-8 py-3.5 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black text-sm shadow-xl shadow-emerald-500/25 transition active:scale-[0.99]"
                    >
                        Return to Homepage
                    </a>
                </div>
            </div>
        </div>
    @else
        <!-- Multi-Step Registration Form Card -->
        <div class="rounded-3xl bg-[#0b1329] border border-slate-700/80 p-6 sm:p-10 shadow-2xl backdrop-blur-xl relative overflow-hidden">
            <!-- Subtle Ambient Glow -->
            <div class="absolute -top-16 -right-16 w-56 h-56 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-16 -left-16 w-56 h-56 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Header -->
            <div class="text-center mb-8 relative">
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 mb-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    Partner With Hahakar Nepal
                </span>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white tracking-tight">Register Your Vehicle & Drive</h1>
                <p class="text-xs sm:text-sm text-slate-400 mt-2 max-w-lg mx-auto leading-relaxed">
                    List your Scorpio, Hilux, Creta, Swift, or tourist van. Earn directly from tourists and local travelers across Nepal.
                </p>
            </div>

            <!-- Step Progress Indicator -->
            <div class="mb-8 pb-6 border-b border-slate-800/80">
                <div class="grid grid-cols-3 gap-2 sm:gap-4 text-center relative">
                    <!-- Step 1 Tab -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center gap-2 mb-1.5">
                            <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-black {{ $step >= 1 ? 'bg-emerald-500 text-slate-950 shadow-md shadow-emerald-500/30' : 'bg-slate-800 text-slate-400' }}">
                                @if ($step > 1) ✓ @else 1 @endif
                            </span>
                            <span class="text-xs font-bold hidden sm:inline {{ $step >= 1 ? 'text-white' : 'text-slate-500' }}">Personal Info</span>
                        </div>
                        <span class="text-[11px] font-semibold sm:hidden {{ $step >= 1 ? 'text-white' : 'text-slate-500' }}">Personal</span>
                        <div class="w-full h-1.5 rounded-full mt-2 transition-all duration-300 {{ $step >= 1 ? 'bg-gradient-to-r from-emerald-500 to-teal-500' : 'bg-slate-800' }}"></div>
                    </div>

                    <!-- Step 2 Tab -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center gap-2 mb-1.5">
                            <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-black {{ $step >= 2 ? 'bg-emerald-500 text-slate-950 shadow-md shadow-emerald-500/30' : 'bg-slate-800 text-slate-400' }}">
                                @if ($step > 2) ✓ @else 2 @endif
                            </span>
                            <span class="text-xs font-bold hidden sm:inline {{ $step >= 2 ? 'text-white' : 'text-slate-500' }}">Documents</span>
                        </div>
                        <span class="text-[11px] font-semibold sm:hidden {{ $step >= 2 ? 'text-white' : 'text-slate-500' }}">Documents</span>
                        <div class="w-full h-1.5 rounded-full mt-2 transition-all duration-300 {{ $step >= 2 ? 'bg-gradient-to-r from-emerald-500 to-teal-500' : 'bg-slate-800' }}"></div>
                    </div>

                    <!-- Step 3 Tab -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center gap-2 mb-1.5">
                            <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-black {{ $step >= 3 ? 'bg-emerald-500 text-slate-950 shadow-md shadow-emerald-500/30' : 'bg-slate-800 text-slate-400' }}">
                                3
                            </span>
                            <span class="text-xs font-bold hidden sm:inline {{ $step >= 3 ? 'text-white' : 'text-slate-500' }}">Vehicle Profile</span>
                        </div>
                        <span class="text-[11px] font-semibold sm:hidden {{ $step >= 3 ? 'text-white' : 'text-slate-500' }}">Vehicle</span>
                        <div class="w-full h-1.5 rounded-full mt-2 transition-all duration-300 {{ $step >= 3 ? 'bg-gradient-to-r from-emerald-500 to-teal-500' : 'bg-slate-800' }}"></div>
                    </div>
                </div>
            </div>

            <!-- STEP 1: Personal Info -->
            @if ($step === 1)
                <div class="space-y-6">
                    <div class="flex items-center justify-between pb-2 border-b border-slate-800/60">
                        <h3 class="text-base sm:text-lg font-bold text-white flex items-center gap-2">
                            <span class="w-7 h-7 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs font-bold">1</span>
                            <span>Your Profile & Contact Information</span>
                        </h3>
                        <span class="text-xs text-slate-400 hidden sm:inline">All fields marked with <span class="text-emerald-400">*</span> are required</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Full Name -->
                        <div>
                            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">
                                Full Legal Name <span class="text-emerald-400">*</span>
                            </label>
                            <div class="relative flex items-center">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <input
                                    type="text"
                                    wire:model="name"
                                    placeholder="e.g. Bikash Gurung"
                                    class="w-full input-with-left-icon pl-14 pr-4 py-3.5 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition placeholder-slate-500"
                                    style="padding-left: 56px !important;"
                                    required
                                />
                            </div>
                            @error('name') <span class="text-rose-400 text-xs mt-1.5 block font-semibold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Phone / WhatsApp -->
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
                                    wire:model="phone"
                                    placeholder="+977 98XXXXXXXX"
                                    class="w-full input-with-left-icon pl-14 pr-4 py-3.5 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition placeholder-slate-500"
                                    style="padding-left: 56px !important;"
                                    required
                                />
                            </div>
                            @error('phone') <span class="text-rose-400 text-xs mt-1.5 block font-semibold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Email -->
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
                                    wire:model="email"
                                    placeholder="driver@domain.com"
                                    class="w-full input-with-left-icon pl-14 pr-4 py-3.5 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition placeholder-slate-500"
                                    style="padding-left: 56px !important;"
                                    required
                                />
                            </div>
                            @error('email') <span class="text-rose-400 text-xs mt-1.5 block font-semibold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Password -->
                        <div x-data="{ showPass: false }">
                            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">
                                Password <span class="text-emerald-400">*</span>
                            </label>
                            <div class="relative flex items-center">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                        <rect x="5" y="11" width="14" height="10" rx="2" stroke-width="1.75" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 11V7a4 4 0 118 0v4" />
                                        <circle cx="12" cy="16" r="1" fill="currentColor" />
                                    </svg>
                                </div>
                                <input
                                    :type="showPass ? 'text' : 'password'"
                                    wire:model="password"
                                    placeholder="Create account password"
                                    class="w-full input-with-both-icons pl-14 pr-14 py-3.5 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition placeholder-slate-500"
                                    style="padding-left: 56px !important; padding-right: 56px !important;"
                                    required
                                />
                                <button
                                    type="button"
                                    @click="showPass = !showPass"
                                    class="absolute inset-y-0 right-0 pr-5 flex items-center z-10 text-slate-400 hover:text-slate-200 transition focus:outline-none cursor-pointer"
                                    tabindex="-1"
                                    aria-label="Toggle password visibility"
                                >
                                    <svg x-show="!showPass" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <svg x-show="showPass" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                </button>
                            </div>
                            @error('password') <span class="text-rose-400 text-xs mt-1.5 block font-semibold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Province -->
                        <div>
                            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">
                                Province <span class="text-emerald-400">*</span>
                            </label>
                            <div class="relative flex items-center">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                    </svg>
                                </div>
                                <select
                                    wire:model="province"
                                    class="w-full input-with-left-icon pl-14 pr-10 py-3.5 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none appearance-none transition cursor-pointer"
                                    style="padding-left: 56px !important;"
                                    required
                                >
                                    <option value="Bagmati Province">Bagmati Province</option>
                                    <option value="Gandaki Province">Gandaki Province</option>
                                    <option value="Koshi Province">Koshi Province</option>
                                    <option value="Madhesh Province">Madhesh Province</option>
                                    <option value="Lumbini Province">Lumbini Province</option>
                                    <option value="Karnali Province">Karnali Province</option>
                                    <option value="Sudurpashchim Province">Sudurpashchim Province</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                            @error('province') <span class="text-rose-400 text-xs mt-1.5 block font-semibold">{{ $message }}</span> @enderror
                        </div>

                        <!-- City -->
                        <div>
                            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">
                                City / Operating Hub <span class="text-emerald-400">*</span>
                            </label>
                            <div class="relative flex items-center">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <select
                                    wire:model="serviceCity"
                                    class="w-full input-with-left-icon pl-14 pr-10 py-3.5 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none appearance-none transition cursor-pointer"
                                    style="padding-left: 56px !important;"
                                    required
                                >
                                    <option value="Kathmandu">Kathmandu</option>
                                    <option value="Pokhara">Pokhara</option>
                                    <option value="Lalitpur">Lalitpur (Patan)</option>
                                    <option value="Bhaktapur">Bhaktapur</option>
                                    <option value="Bharatpur">Bharatpur / Chitwan</option>
                                    <option value="Biratnagar">Biratnagar</option>
                                    <option value="Birgunj">Birgunj</option>
                                    <option value="Butwal">Butwal</option>
                                    <option value="Bhairahawa">Bhairahawa / Lumbini</option>
                                    <option value="Dharan">Dharan</option>
                                    <option value="Nepalgunj">Nepalgunj</option>
                                    <option value="Hetauda">Hetauda</option>
                                    <option value="Dhangadhi">Dhangadhi</option>
                                    <option value="Janakpur">Janakpur</option>
                                    <option value="Itahari">Itahari</option>
                                    <option value="Birtamod">Birtamod</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                            @error('serviceCity') <span class="text-rose-400 text-xs mt-1.5 block font-semibold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- City Address -->
                        <div>
                            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">
                                Street / Local Address <span class="text-emerald-400">*</span>
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
                                    wire:model="address"
                                    placeholder="e.g. Ward No. 4, Baluwatar / Lakeside"
                                    class="w-full input-with-left-icon pl-14 pr-4 py-3.5 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition placeholder-slate-500"
                                    style="padding-left: 56px !important;"
                                />
                            </div>
                            @error('address') <span class="text-rose-400 text-xs mt-1.5 block font-semibold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Partner Type -->
                        <div>
                            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">
                                Partner Type <span class="text-emerald-400">*</span>
                            </label>
                            <div class="relative flex items-center">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <select
                                    wire:model="partnerType"
                                    class="w-full input-with-left-icon pl-14 pr-10 py-3.5 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none appearance-none transition cursor-pointer"
                                    style="padding-left: 56px !important;"
                                >
                                    <option value="individual_driver">Individual Driver / Chauffeur</option>
                                    <option value="vehicle_owner">Private Vehicle Owner</option>
                                    <option value="fleet_operator">Rental Fleet Operator</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                            @error('partnerType') <span class="text-rose-400 text-xs mt-1.5 block font-semibold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-800/80 flex items-center justify-between">
                        <p class="text-xs text-slate-500">
                            Already registered?
                            <a wire:navigate href="{{ route('partner.dashboard') }}" class="text-emerald-400 font-bold hover:underline">Sign in to Portal</a>
                        </p>
                        <button
                            type="button"
                            wire:click="nextStep"
                            class="px-8 py-3.5 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black text-sm shadow-xl shadow-emerald-500/25 transition flex items-center gap-2 active:scale-[0.99] cursor-pointer"
                        >
                            <span>Next: Upload Documents</span>
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            <!-- STEP 2: Documents -->
            @if ($step === 2)
                <div class="space-y-6">
                    <div class="flex items-center justify-between pb-2 border-b border-slate-800/60">
                        <h3 class="text-base sm:text-lg font-bold text-white flex items-center gap-2">
                            <span class="w-7 h-7 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs font-bold">2</span>
                            <span>Verification Documents (Required for Admin Approval)</span>
                        </h3>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-900/60 border border-emerald-500/20 flex items-start gap-3">
                        <div class="w-8 h-8 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            To ensure high safety and trust across Nepal, our admin team reviews your Driving License, Vehicle Bluebook, Citizenship / National ID, and Passport Photo. Approved partners receive priority trip dispatch.
                        </p>
                    </div>

                    <!-- License Number -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">
                            Nepali Driving License Number <span class="text-emerald-400">*</span>
                        </label>
                        <div class="relative flex items-center">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                    <rect x="3" y="4" width="18" height="16" rx="2" stroke-width="1.75" />
                                    <circle cx="9" cy="10" r="2" stroke-width="1.75" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 8h2m-2 4h2m-6 4h6" />
                                </svg>
                            </div>
                            <input
                                type="text"
                                wire:model="licenseNumber"
                                placeholder="e.g. 01-06-00459812"
                                class="w-full input-with-left-icon pl-14 pr-4 py-3.5 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition placeholder-slate-500"
                                style="padding-left: 56px !important;"
                                required
                            />
                        </div>
                        @error('licenseNumber') <span class="text-rose-400 text-xs mt-1.5 block font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- License Upload Card -->
                        <div class="p-5 rounded-2xl bg-slate-900/90 border border-slate-700/80 hover:border-slate-600 transition">
                            <div class="flex items-center gap-2.5 mb-2">
                                <div class="w-8 h-8 rounded-xl bg-slate-800 text-emerald-400 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-white uppercase tracking-wider">Driving License Photo</label>
                                    <p class="text-[11px] text-slate-400">Clear photo of the front page</p>
                                </div>
                            </div>
                            <div class="mt-3">
                                <input
                                    type="file"
                                    wire:model="licensePhoto"
                                    accept="image/*"
                                    class="w-full text-xs text-slate-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-500/20 file:text-emerald-300 hover:file:bg-emerald-500/30 file:cursor-pointer cursor-pointer"
                                />
                                @if ($licensePhoto)
                                    <div class="mt-2.5 flex items-center gap-1.5 text-xs text-emerald-400 font-semibold bg-emerald-500/10 px-3 py-1.5 rounded-xl border border-emerald-500/20">
                                        <span>✓ File selected ready for upload</span>
                                    </div>
                                @endif
                                @error('licensePhoto') <span class="text-rose-400 text-xs mt-1.5 block font-semibold">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Bluebook Upload Card -->
                        <div class="p-5 rounded-2xl bg-slate-900/90 border border-slate-700/80 hover:border-slate-600 transition">
                            <div class="flex items-center gap-2.5 mb-2">
                                <div class="w-8 h-8 rounded-xl bg-slate-800 text-emerald-400 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-white uppercase tracking-wider">Vehicle Bluebook Photo</label>
                                    <p class="text-[11px] text-slate-400">Registration page showing specs & ownership</p>
                                </div>
                            </div>
                            <div class="mt-3">
                                <input
                                    type="file"
                                    wire:model="bluebookPhoto"
                                    accept="image/*"
                                    class="w-full text-xs text-slate-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-500/20 file:text-emerald-300 hover:file:bg-emerald-500/30 file:cursor-pointer cursor-pointer"
                                />
                                @if ($bluebookPhoto)
                                    <div class="mt-2.5 flex items-center gap-1.5 text-xs text-emerald-400 font-semibold bg-emerald-500/10 px-3 py-1.5 rounded-xl border border-emerald-500/20">
                                        <span>✓ File selected ready for upload</span>
                                    </div>
                                @endif
                                @error('bluebookPhoto') <span class="text-rose-400 text-xs mt-1.5 block font-semibold">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Citizenship / National ID Card Upload Card -->
                        <div class="p-5 rounded-2xl bg-slate-900/90 border border-slate-700/80 hover:border-slate-600 transition">
                            <div class="flex items-center gap-2.5 mb-2">
                                <div class="w-8 h-8 rounded-xl bg-slate-800 text-emerald-400 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                    </svg>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-white uppercase tracking-wider">Citizenship / National ID</label>
                                    <p class="text-[11px] text-slate-400">Clear photo of front & back / NID card</p>
                                </div>
                            </div>
                            <div class="mt-3">
                                <input
                                    type="file"
                                    wire:model="citizenshipPhoto"
                                    accept="image/*"
                                    class="w-full text-xs text-slate-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-500/20 file:text-emerald-300 hover:file:bg-emerald-500/30 file:cursor-pointer cursor-pointer"
                                />
                                @if ($citizenshipPhoto)
                                    <div class="mt-2.5 flex items-center gap-1.5 text-xs text-emerald-400 font-semibold bg-emerald-500/10 px-3 py-1.5 rounded-xl border border-emerald-500/20">
                                        <span>✓ File selected ready for upload</span>
                                    </div>
                                @endif
                                @error('citizenshipPhoto') <span class="text-rose-400 text-xs mt-1.5 block font-semibold">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Passport Size Photo Upload Card -->
                        <div class="p-5 rounded-2xl bg-slate-900/90 border border-slate-700/80 hover:border-slate-600 transition">
                            <div class="flex items-center gap-2.5 mb-2">
                                <div class="w-8 h-8 rounded-xl bg-slate-800 text-emerald-400 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-white uppercase tracking-wider">Passport Size Photo (PP)</label>
                                    <p class="text-[11px] text-slate-400">Recent official passport size portrait photo</p>
                                </div>
                            </div>
                            <div class="mt-3">
                                <input
                                    type="file"
                                    wire:model="passportPhoto"
                                    accept="image/*"
                                    class="w-full text-xs text-slate-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-500/20 file:text-emerald-300 hover:file:bg-emerald-500/30 file:cursor-pointer cursor-pointer"
                                />
                                @if ($passportPhoto)
                                    <div class="mt-2.5 flex items-center gap-1.5 text-xs text-emerald-400 font-semibold bg-emerald-500/10 px-3 py-1.5 rounded-xl border border-emerald-500/20">
                                        <span>✓ File selected ready for upload</span>
                                    </div>
                                @endif
                                @error('passportPhoto') <span class="text-rose-400 text-xs mt-1.5 block font-semibold">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-800/80 flex items-center justify-between">
                        <button
                            type="button"
                            wire:click="previousStep"
                            class="px-6 py-3 rounded-2xl bg-slate-800/90 hover:bg-slate-700 text-slate-300 hover:text-white text-xs font-bold transition flex items-center gap-2 cursor-pointer"
                        >
                            <span>← Back to Step 1</span>
                        </button>

                        <button
                            type="button"
                            wire:click="nextStep"
                            class="px-8 py-3.5 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black text-sm shadow-xl shadow-emerald-500/25 transition flex items-center gap-2 active:scale-[0.99] cursor-pointer"
                        >
                            <span>Next: Vehicle Profile</span>
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            <!-- STEP 3: Vehicle Info -->
            @if ($step === 3)
                <div class="space-y-6">
                    <div class="flex items-center justify-between pb-2 border-b border-slate-800/60">
                        <h3 class="text-base sm:text-lg font-bold text-white flex items-center gap-2">
                            <span class="w-7 h-7 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs font-bold">3</span>
                            <span>Vehicle Profile & Daily Pricing</span>
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Vehicle Category -->
                        <div>
                            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">
                                Vehicle Category <span class="text-emerald-400">*</span>
                            </label>
                            <div class="relative flex items-center">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h8m-8 4h8m-4 4h4M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z" />
                                    </svg>
                                </div>
                                <select
                                    wire:model="vehicleCategory"
                                    class="w-full input-with-left-icon pl-14 pr-10 py-3.5 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none appearance-none transition cursor-pointer"
                                    style="padding-left: 56px !important;"
                                >
                                    <option value="suv_4wd">4WD Mountain SUV (Scorpio / Hilux)</option>
                                    <option value="compact_suv">Compact SUV (Creta / Vitara)</option>
                                    <option value="tourist_van">Tourist Commuter Van (HiAce)</option>
                                    <option value="sedan">Comfort Sedan</option>
                                    <option value="hatchback">City Hatchback (Swift / i10)</option>
                                    <option value="luxury_suv">Premium Luxury 4WD (Prado)</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Plate Number -->
                        <div>
                            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">
                                Plate / Registration Number <span class="text-emerald-400">*</span>
                            </label>
                            <div class="relative flex items-center">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                        <rect x="3" y="6" width="18" height="12" rx="2" stroke-width="1.75" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M7 12h10" />
                                    </svg>
                                </div>
                                <input
                                    type="text"
                                    wire:model="plateNumber"
                                    placeholder="e.g. Ba 2 Cha 4521"
                                    class="w-full input-with-left-icon pl-14 pr-4 py-3.5 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition placeholder-slate-500 font-mono font-semibold"
                                    style="padding-left: 56px !important;"
                                    required
                                />
                            </div>
                            @error('plateNumber') <span class="text-rose-400 text-xs mt-1.5 block font-semibold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                        <!-- Make -->
                        <div>
                            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">
                                Vehicle Make <span class="text-emerald-400">*</span>
                            </label>
                            <input
                                type="text"
                                wire:model="vehicleMake"
                                placeholder="e.g. Mahindra, Toyota"
                                class="w-full px-4 py-3.5 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition placeholder-slate-500"
                                required
                            />
                            @error('vehicleMake') <span class="text-rose-400 text-xs mt-1.5 block font-semibold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Model -->
                        <div>
                            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">
                                Model & Trim <span class="text-emerald-400">*</span>
                            </label>
                            <input
                                type="text"
                                wire:model="vehicleModel"
                                placeholder="e.g. Scorpio 4WD S11"
                                class="w-full px-4 py-3.5 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition placeholder-slate-500"
                                required
                            />
                            @error('vehicleModel') <span class="text-rose-400 text-xs mt-1.5 block font-semibold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Year -->
                        <div>
                            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Year</label>
                            <input
                                type="number"
                                wire:model="vehicleYear"
                                class="w-full px-4 py-3.5 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition placeholder-slate-500"
                            />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                        <!-- Seats -->
                        <div>
                            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Passenger Seats</label>
                            <input
                                type="number"
                                wire:model="seatingCapacity"
                                class="w-full px-4 py-3.5 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition"
                            />
                        </div>

                        <!-- Transmission -->
                        <div>
                            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Transmission</label>
                            <select
                                wire:model="transmission"
                                class="w-full px-4 py-3.5 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 outline-none"
                            >
                                <option value="manual">Manual</option>
                                <option value="automatic">Automatic</option>
                            </select>
                        </div>

                        <!-- Fuel -->
                        <div>
                            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Fuel Type</label>
                            <select
                                wire:model="fuelType"
                                class="w-full px-4 py-3.5 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 outline-none"
                            >
                                <option value="diesel">Diesel</option>
                                <option value="petrol">Petrol</option>
                                <option value="electric">Electric (EV)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Pricing Card -->
                    <div class="p-6 rounded-3xl bg-gradient-to-br from-emerald-500/10 via-slate-900/90 to-slate-900/90 border border-emerald-500/30">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <label class="block text-xs font-bold text-emerald-300 uppercase tracking-wider mb-1">
                                    Your Daily Rental Rate (NPR Rs.) <span class="text-emerald-400">*</span>
                                </label>
                                <p class="text-xs text-slate-400">Fixed payout per 24 hours of vehicle rental across Nepal</p>
                            </div>
                            <div class="relative min-w-[200px]">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-emerald-400 font-black text-sm">
                                    NPR Rs.
                                </span>
                                <input
                                    type="number"
                                    wire:model="dailyRate"
                                    placeholder="4500"
                                    class="w-full pl-24 pr-4 py-3.5 rounded-2xl bg-slate-950/80 border border-emerald-500/40 text-white font-black text-lg focus:border-emerald-400 focus:ring-2 focus:ring-emerald-500/20 outline-none transition"
                                    required
                                />
                            </div>
                        </div>
                        @error('dailyRate') <span class="text-rose-400 text-xs mt-2 block font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <!-- Vehicle Exterior Photo -->
                    <div class="p-5 rounded-2xl bg-slate-900/90 border border-slate-700/80">
                        <div class="flex items-center gap-2.5 mb-2">
                            <div class="w-8 h-8 rounded-xl bg-slate-800 text-emerald-400 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-white uppercase tracking-wider">Vehicle Exterior Photo</label>
                                <p class="text-[11px] text-slate-400">Clean outdoor picture of the vehicle</p>
                            </div>
                        </div>
                        <input
                            type="file"
                            wire:model="vehiclePhoto"
                            accept="image/*"
                            class="w-full mt-2 text-xs text-slate-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-500/20 file:text-emerald-300 hover:file:bg-emerald-500/30 file:cursor-pointer cursor-pointer"
                        />
                        @if ($vehiclePhoto)
                            <div class="mt-2.5 flex items-center gap-1.5 text-xs text-emerald-400 font-semibold bg-emerald-500/10 px-3 py-1.5 rounded-xl border border-emerald-500/20">
                                <span>✓ Photo selected ready for upload</span>
                            </div>
                        @endif
                    </div>

                    <!-- Service Options Toggles -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                        <label class="flex items-center gap-3 p-4 rounded-2xl bg-slate-900/90 border border-slate-700/80 hover:border-slate-600 transition cursor-pointer">
                            <input type="checkbox" wire:model="providesDriver" class="w-4 h-4 rounded bg-slate-950 border-slate-700 text-emerald-500 focus:ring-0">
                            <div>
                                <div class="text-xs font-bold text-white">Provides Driver (Chauffeur)</div>
                                <div class="text-[11px] text-slate-400">You or your driver will drive the vehicle</div>
                            </div>
                        </label>

                        <label class="flex items-center gap-3 p-4 rounded-2xl bg-slate-900/90 border border-slate-700/80 hover:border-slate-600 transition cursor-pointer">
                            <input type="checkbox" wire:model="allowsSelfDrive" class="w-4 h-4 rounded bg-slate-950 border-slate-700 text-emerald-500 focus:ring-0">
                            <div>
                                <div class="text-xs font-bold text-white">Allows Self-Drive</div>
                                <div class="text-[11px] text-slate-400">Verified tourists can self-drive the vehicle</div>
                            </div>
                        </label>
                    </div>

                    <div class="pt-6 border-t border-slate-800/80 flex items-center justify-between">
                        <button
                            type="button"
                            wire:click="previousStep"
                            class="px-6 py-3 rounded-2xl bg-slate-800/90 hover:bg-slate-700 text-slate-300 hover:text-white text-xs font-bold transition flex items-center gap-2 cursor-pointer"
                        >
                            <span>← Back to Step 2</span>
                        </button>

                        <button
                            type="button"
                            wire:click="submitApplication"
                            wire:loading.attr="disabled"
                            class="px-8 py-3.5 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black text-sm shadow-xl shadow-emerald-500/30 transition flex items-center gap-2 active:scale-[0.99] cursor-pointer"
                        >
                            <span wire:loading.remove>Submit Application for Verification</span>
                            <span wire:loading>Submitting Application...</span>
                            <svg wire:loading.remove class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endif
        </div>
    @endif
</div>
