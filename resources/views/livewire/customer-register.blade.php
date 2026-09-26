<div class="min-h-[calc(100vh-14rem)] flex items-center justify-center py-8 sm:py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-6 bg-gradient-to-b from-[#0e172e] to-[#070d1e] border border-slate-700/80 p-6 sm:p-8 rounded-3xl shadow-2xl backdrop-blur-xl relative overflow-hidden ring-1 ring-white/5">
        <!-- Ambient Glow -->
        <div class="absolute -top-12 -right-12 w-44 h-44 bg-emerald-500/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-12 -left-12 w-44 h-44 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

        @if($showOtpStep)
            <!-- OTP Verification View -->
            <div class="text-center relative">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[11px] font-bold tracking-wider uppercase mb-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Security Verification</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Enter 6-Digit OTP</h1>
                <p class="mt-1.5 text-xs sm:text-sm text-slate-400 leading-relaxed">
                    {{ $otpStatusMessage ?: 'Please enter the 6-digit code sent to verify your identity.' }}
                </p>
            </div>

            <form wire:submit.prevent="verifyRegisterOtp" class="mt-6 space-y-5">
                <div>
                    <label for="otpCode" class="block text-center text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">
                        Verification Code
                    </label>
                    <div class="relative">
                        <input
                            id="otpCode"
                            type="text"
                            inputmode="numeric"
                            maxlength="6"
                            wire:model="otpCode"
                            placeholder="• • • • • •"
                            autofocus
                            class="w-full py-4 text-center text-2xl font-black tracking-[0.5em] rounded-2xl bg-slate-900/95 border border-emerald-500/40 text-emerald-400 focus:border-emerald-400 focus:ring-4 focus:ring-emerald-500/20 outline-none transition placeholder-slate-600 font-mono shadow-inner"
                            required
                        />
                    </div>
                    @error('otpCode')
                        <span class="text-xs text-rose-400 font-semibold mt-2 block text-center">{{ $message }}</span>
                    @enderror
                </div>

                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black text-sm shadow-xl shadow-emerald-500/25 hover:shadow-emerald-500/35 transition cursor-pointer flex items-center justify-center gap-2 active:scale-[0.99]"
                >
                    <span wire:loading.remove>Verify & Complete Registration</span>
                    <span wire:loading>Verifying Code...</span>
                    <svg wire:loading.remove class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </button>
            </form>

            <div class="pt-4 border-t border-slate-800/80 flex items-center justify-between text-xs">
                <button
                    type="button"
                    wire:click="resendRegisterOtp"
                    wire:loading.attr="disabled"
                    class="text-emerald-400 hover:text-emerald-300 font-bold transition flex items-center gap-1.5 cursor-pointer hover:underline"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span>Resend Code</span>
                </button>

                <button
                    type="button"
                    wire:click="backToRegisterForm"
                    class="text-slate-400 hover:text-slate-200 font-semibold transition cursor-pointer hover:underline"
                >
                    ← Edit Information
                </button>
            </div>

        @else
            <!-- Standard Registration Form -->
            <div class="text-center relative">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[11px] font-bold tracking-wider uppercase mb-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Customer Portal</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Create Customer Account</h1>
                <p class="mt-1.5 text-xs sm:text-sm text-slate-400">Join Nepal's #1 Car Rental & Mobility Network</p>
            </div>

            <form wire:submit.prevent="register" class="mt-6 space-y-4">
                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">
                        Full Name <span class="text-emerald-400">*</span>
                    </label>
                    <div class="relative flex items-center">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input
                            id="name"
                            type="text"
                            wire:model="name"
                            placeholder="e.g. Ramesh Shrestha"
                            class="w-full input-with-left-icon pl-14 pr-4 py-3 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition placeholder-slate-500"
                            style="padding-left: 56px !important;"
                            required
                        />
                    </div>
                    @error('name') <span class="text-xs text-rose-400 font-semibold mt-1.5 block">{{ $message }}</span> @enderror
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">
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
                            id="email"
                            type="email"
                            wire:model="email"
                            placeholder="you@example.com"
                            class="w-full input-with-left-icon pl-14 pr-4 py-3 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition placeholder-slate-500"
                            style="padding-left: 56px !important;"
                            required
                        />
                    </div>
                    @error('email') <span class="text-xs text-rose-400 font-semibold mt-1.5 block">{{ $message }}</span> @enderror
                </div>

                <!-- Phone / WhatsApp -->
                <div>
                    <label for="phone" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">
                        Phone / WhatsApp Number <span class="text-emerald-400">*</span>
                    </label>
                    <div class="relative flex items-center">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <input
                            id="phone"
                            type="text"
                            wire:model="phone"
                            placeholder="+977 98XXXXXXXX"
                            class="w-full input-with-left-icon pl-14 pr-4 py-3 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition placeholder-slate-500"
                            style="padding-left: 56px !important;"
                            required
                        />
                    </div>
                    @error('phone') <span class="text-xs text-rose-400 font-semibold mt-1.5 block">{{ $message }}</span> @enderror
                </div>

                <!-- Password Fields -->
                <div class="space-y-4" x-data="{ showPass: false, showConfirm: false }">
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">
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
                                id="password"
                                :type="showPass ? 'text' : 'password'"
                                wire:model="password"
                                placeholder="Create account password"
                                class="w-full input-with-both-icons pl-14 pr-14 py-3 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition placeholder-slate-500"
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
                        @error('password') <span class="text-xs text-rose-400 font-semibold mt-1.5 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">
                            Confirm Password <span class="text-emerald-400">*</span>
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
                                id="password_confirmation"
                                :type="showConfirm ? 'text' : 'password'"
                                wire:model="password_confirmation"
                                placeholder="Re-enter your password"
                                class="w-full input-with-both-icons pl-14 pr-14 py-3 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition placeholder-slate-500"
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
                        @error('password_confirmation') <span class="text-xs text-rose-400 font-semibold mt-1.5 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Terms & Conditions -->
                <div class="pt-1">
                    <label class="flex items-start gap-2.5 text-xs text-slate-300 cursor-pointer select-none">
                        <input
                            type="checkbox"
                            wire:model="acceptTerms"
                            class="mt-0.5 w-4 h-4 rounded border-slate-700 bg-slate-900 text-emerald-500 focus:ring-emerald-500/20 focus:ring-offset-0 focus:ring-1 cursor-pointer"
                            required
                        >
                        <span class="leading-relaxed text-slate-400">
                            I agree to the <a href="{{ route('pages.show', 'terms') }}" target="_blank" class="text-emerald-400 font-semibold hover:underline">Terms of Service</a> & <a href="{{ route('pages.show', 'privacy') }}" target="_blank" class="text-emerald-400 font-semibold hover:underline">Privacy Policy</a>
                        </span>
                    </label>
                    @error('acceptTerms') <span class="text-xs text-rose-400 font-semibold mt-1.5 block">{{ $message }}</span> @enderror
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black text-sm shadow-xl shadow-emerald-500/25 hover:shadow-emerald-500/35 transition cursor-pointer flex items-center justify-center gap-2 active:scale-[0.99]"
                >
                    <span wire:loading.remove>Create Customer Account</span>
                    <span wire:loading>Processing Registration...</span>
                    <svg wire:loading.remove class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </form>

            <div class="pt-5 border-t border-slate-800/80 text-center space-y-2">
                <p class="text-xs text-slate-400">
                    Already have an account?
                    <a wire:navigate href="{{ route('customer.login') }}" class="text-emerald-400 font-bold hover:underline">Sign in here</a>
                </p>
                <p class="text-xs text-slate-500">
                    Want to list vehicles or drive?
                    <a wire:navigate href="{{ route('partner.register') }}" class="text-slate-300 font-semibold hover:text-emerald-400 transition">Register as Partner Driver →</a>
                </p>
            </div>
        @endif
    </div>
</div>
