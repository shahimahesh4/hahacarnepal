<div class="min-h-[calc(100vh-14rem)] flex items-center justify-center py-6 sm:py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-6 bg-[#0b1329] border border-slate-700/80 p-6 sm:p-8 rounded-3xl shadow-2xl backdrop-blur-xl relative overflow-hidden">
        <!-- Ambient Glow -->
        <div class="absolute top-0 right-0 w-36 h-36 bg-emerald-500/15 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-36 h-36 bg-teal-500/10 rounded-full blur-2xl pointer-events-none"></div>

        @if($showOtpStep)
            <!-- OTP Verification Step -->
            <div class="text-center relative">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[11px] font-bold tracking-wider uppercase mb-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>2-Step Verification</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Enter Security Code</h1>
                <p class="mt-1.5 text-xs sm:text-sm text-slate-400 leading-relaxed">
                    {{ $otpStatusMessage ?: 'Please enter the 6-digit code sent to verify your identity.' }}
                </p>
            </div>

            <form wire:submit.prevent="verifyLoginOtp" class="mt-6 space-y-5">
                <div>
                    <label for="otpCode" class="block text-center text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">
                        6-Digit Login Code
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
                    <span wire:loading.remove>Verify & Sign In</span>
                    <span wire:loading>Verifying Code...</span>
                    <svg wire:loading.remove class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </form>

            <div class="pt-4 border-t border-slate-800 flex items-center justify-between text-xs">
                <button
                    type="button"
                    wire:click="resendLoginOtp"
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
                    wire:click="backToLoginForm"
                    class="text-slate-400 hover:text-slate-200 font-semibold transition cursor-pointer hover:underline"
                >
                    ← Switch Account
                </button>
            </div>

        @else
            <!-- Standard Login Form -->
            <div class="text-center relative">
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Customer Sign In</h1>
                <p class="mt-1 text-xs sm:text-sm text-slate-400">Access your Nepal car rentals, vouchers & trip history</p>
            </div>

            <form wire:submit.prevent="login" class="mt-6 space-y-4">
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">Email address or Phone</label>
                    <div class="relative flex items-center">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <rect x="3" y="5" width="18" height="14" rx="2" stroke-width="1.75" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 7l9 6 9-6" />
                            </svg>
                        </div>
                        <input
                            id="email"
                            type="text"
                            wire:model="email"
                            placeholder="you@example.com or 98XXXXXXXX"
                            class="w-full input-with-left-icon pl-14 pr-4 py-3 rounded-2xl bg-slate-900/90 border border-slate-700/80 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition placeholder-slate-500"
                            style="padding-left: 56px !important;"
                            required
                        />
                    </div>
                    @error('email') <span class="text-xs text-rose-400 font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div x-data="{ showPassword: false }">
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-bold text-slate-300 uppercase tracking-wider">Password</label>
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
                            id="password"
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
                            <!-- Eye open icon -->
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <!-- Eye slash icon -->
                            <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </button>
                    </div>
                    @error('password') <span class="text-xs text-rose-400 font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center gap-2 text-slate-400 cursor-pointer">
                        <input type="checkbox" wire:model="remember" class="rounded bg-slate-900 border-slate-700 text-emerald-500 focus:ring-0">
                        <span>Remember this device</span>
                    </label>
                </div>

                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black text-sm shadow-xl shadow-emerald-500/25 hover:shadow-emerald-500/35 transition cursor-pointer flex items-center justify-center gap-2 active:scale-[0.99]"
                >
                    <span wire:loading.remove>Sign In to Account</span>
                    <span wire:loading>Signing in...</span>
                    <svg wire:loading.remove class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </form>

            <div class="pt-5 border-t border-slate-800 text-center space-y-1.5">
                <p class="text-xs text-slate-400">
                    Don't have an account?
                    <a wire:navigate href="{{ route('customer.register') }}" class="text-emerald-400 font-bold hover:underline">Create free account</a>
                </p>
                <p class="text-xs text-slate-500">
                    Are you a vehicle owner or driver?
                    <a wire:navigate href="{{ route('partner.dashboard') }}" class="text-slate-300 font-semibold hover:text-emerald-400 transition">Partner Driver Login →</a>
                </p>
            </div>
        @endif
    </div>

    <!-- Forgot Password Modal for Customer -->
    @if ($showForgotModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md">
            <div class="bg-[#0b1329] border border-slate-700/90 rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl relative">
                <button
                    type="button"
                    wire:click="closeForgotModal"
                    class="absolute top-5 right-5 text-slate-400 hover:text-white transition cursor-pointer"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>

                <div class="text-center mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center mx-auto mb-3 border border-emerald-500/20">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-black text-white">Reset Customer Password</h3>
                    <p class="text-xs text-slate-400 mt-1">Enter your registered email address to receive password reset instructions.</p>
                </div>

                @if ($forgotStatusMessage)
                    <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs leading-relaxed mb-4">
                        {{ $forgotStatusMessage }}
                    </div>
                @else
                    <form wire:submit.prevent="requestPasswordReset" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">Registered Email</label>
                            <input
                                type="email"
                                wire:model="forgotEmail"
                                placeholder="yourname@gmail.com"
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
                        class="text-xs font-bold text-slate-400 hover:text-slate-200 transition cursor-pointer"
                    >
                        ← Back to Sign In
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
