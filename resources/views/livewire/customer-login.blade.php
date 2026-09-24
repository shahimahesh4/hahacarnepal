<div class="min-h-[75vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-[#0b1329] border border-white/10 p-8 sm:p-10 rounded-3xl shadow-2xl backdrop-blur-xl relative overflow-hidden">
        <!-- Ambient Glow -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="text-center relative">
            <a wire:navigate href="{{ route('home') }}" class="inline-block mb-4">
                <img src="{{ asset('images/logo.png') }}" alt="Hahakar Nepal" class="h-14 w-auto mx-auto object-contain bg-white rounded-2xl px-3 py-1.5 shadow-md">
            </a>
            <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Customer Sign In</h1>
            <p class="mt-2 text-xs sm:text-sm text-slate-400">Access your Nepal car rentals, vouchers & trip history</p>
        </div>

        <form wire:submit.prevent="login" class="mt-8 space-y-5">
            <div>
                <label for="email" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Email Address</label>
                <div class="relative">
                    <input
                        id="email"
                        type="email"
                        wire:model="email"
                        placeholder="yourname@gmail.com"
                        class="w-full pl-10 pr-4 py-3 rounded-2xl bg-slate-900 border border-white/10 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition"
                        required
                    />
                    <div class="absolute left-3.5 top-3.5 text-slate-500 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                        </svg>
                    </div>
                </div>
                @error('email') <span class="text-xs text-rose-400 font-semibold mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Password</label>
                <div class="relative">
                    <input
                        id="password"
                        type="password"
                        wire:model="password"
                        placeholder="••••••••"
                        class="w-full pl-10 pr-4 py-3 rounded-2xl bg-slate-900 border border-white/10 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition"
                        required
                    />
                    <div class="absolute left-3.5 top-3.5 text-slate-500 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
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
                class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black text-sm shadow-xl shadow-emerald-500/25 transition cursor-pointer flex items-center justify-center gap-2"
            >
                <span wire:loading.remove>Sign In to Account</span>
                <span wire:loading>Signing in...</span>
                <svg wire:loading.remove class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </form>

        <div class="pt-6 border-t border-white/10 text-center space-y-3">
            <p class="text-xs text-slate-400">
                Don't have an account?
                <a wire:navigate href="{{ route('customer.register') }}" class="text-emerald-400 font-bold hover:underline">Create free account</a>
            </p>
            <p class="text-xs text-slate-500">
                Are you a vehicle owner or driver?
                <a wire:navigate href="{{ route('partner.dashboard') }}" class="text-slate-300 font-semibold hover:text-emerald-400">Partner Driver Login →</a>
            </p>
        </div>
    </div>
</div>
