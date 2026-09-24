<div class="min-h-[75vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-[#0b1329] border border-white/10 p-8 sm:p-10 rounded-3xl shadow-2xl backdrop-blur-xl relative overflow-hidden">
        <!-- Ambient Glow -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="text-center relative">
            <a wire:navigate href="{{ route('home') }}" class="inline-block mb-4">
                <img src="{{ asset('images/logo.png') }}" alt="Hahakar Nepal" class="h-14 w-auto mx-auto object-contain bg-white rounded-2xl px-3 py-1.5 shadow-md">
            </a>
            <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Create Customer Account</h1>
            <p class="mt-2 text-xs sm:text-sm text-slate-400">Join Nepal's #1 Car Rental & Mobility Network</p>
        </div>

        <form wire:submit.prevent="register" class="mt-8 space-y-4">
            <div>
                <label for="name" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Full Name *</label>
                <input
                    id="name"
                    type="text"
                    wire:model="name"
                    placeholder="e.g. Ramesh Shrestha"
                    class="w-full px-4 py-3 rounded-2xl bg-slate-900 border border-white/10 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition"
                    required
                />
                @error('name') <span class="text-xs text-rose-400 font-semibold mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="email" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Email Address *</label>
                <input
                    id="email"
                    type="email"
                    wire:model="email"
                    placeholder="yourname@gmail.com"
                    class="w-full px-4 py-3 rounded-2xl bg-slate-900 border border-white/10 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition"
                    required
                />
                @error('email') <span class="text-xs text-rose-400 font-semibold mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="phone" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Phone / WhatsApp Number *</label>
                <div class="relative">
                    <input
                        id="phone"
                        type="text"
                        wire:model="phone"
                        placeholder="+977 98XXXXXXXX"
                        class="w-full px-4 py-3 rounded-2xl bg-slate-900 border border-white/10 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition"
                        required
                    />
                </div>
                @error('phone') <span class="text-xs text-rose-400 font-semibold mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Password *</label>
                    <input
                        id="password"
                        type="password"
                        wire:model="password"
                        placeholder="••••••••"
                        class="w-full px-4 py-3 rounded-2xl bg-slate-900 border border-white/10 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition"
                        required
                    />
                    @error('password') <span class="text-xs text-rose-400 font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Confirm *</label>
                    <input
                        id="password_confirmation"
                        type="password"
                        wire:model="password_confirmation"
                        placeholder="••••••••"
                        class="w-full px-4 py-3 rounded-2xl bg-slate-900 border border-white/10 text-white text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition"
                        required
                    />
                </div>
            </div>

            <div class="pt-2">
                <label class="flex items-start gap-2.5 text-xs text-slate-400 cursor-pointer">
                    <input type="checkbox" wire:model="acceptTerms" class="mt-0.5 rounded bg-slate-900 border-slate-700 text-emerald-500 focus:ring-0">
                    <span>I agree to the <a href="{{ route('pages.show', 'terms') }}" target="_blank" class="text-emerald-400 underline">Terms of Service</a> & <a href="{{ route('pages.show', 'privacy') }}" target="_blank" class="text-emerald-400 underline">Privacy Policy</a></span>
                </label>
                @error('acceptTerms') <span class="text-xs text-rose-400 font-semibold mt-1 block">{{ $message }}</span> @enderror
            </div>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black text-sm shadow-xl shadow-emerald-500/25 transition cursor-pointer flex items-center justify-center gap-2"
            >
                <span wire:loading.remove>Create Customer Account</span>
                <span wire:loading>Creating Account...</span>
                <svg wire:loading.remove class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </form>

        <div class="pt-6 border-t border-white/10 text-center space-y-3">
            <p class="text-xs text-slate-400">
                Already have an account?
                <a wire:navigate href="{{ route('customer.login') }}" class="text-emerald-400 font-bold hover:underline">Sign in here</a>
            </p>
            <p class="text-xs text-slate-500">
                Want to list vehicles or drive?
                <a wire:navigate href="{{ route('partner.register') }}" class="text-slate-300 font-semibold hover:text-emerald-400">Register as Partner Driver →</a>
            </p>
        </div>
    </div>
</div>
