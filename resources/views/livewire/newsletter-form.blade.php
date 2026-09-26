<div>
    @if($subscribed)
        <div class="bg-emerald-500/15 border border-emerald-500/30 text-emerald-300 p-4 rounded-2xl text-xs flex items-start gap-3 backdrop-blur-sm shadow-inner shadow-emerald-500/10">
            <div class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0 mt-0.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div>
                <p class="font-bold text-emerald-200">You're on the VIP list!</p>
                <p class="text-slate-300 mt-0.5 leading-relaxed">We'll send seasonal Nepal travel deals, festive promo codes, and highway route alerts directly to your inbox.</p>
            </div>
        </div>
    @else
        <form wire:submit.prevent="subscribe" class="space-y-2">
            <div class="relative flex flex-col sm:flex-row gap-2">
                <div class="relative grow">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <input 
                        type="email" 
                        wire:model="email" 
                        placeholder="Enter your email address" 
                        required
                        class="w-full bg-slate-900/90 border border-slate-700/80 hover:border-slate-600 focus:border-emerald-500 text-slate-100 placeholder-slate-400 pl-10 pr-4 py-2.5 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/30 transition shadow-inner">
                </div>
                <button 
                    type="submit" 
                    wire:loading.attr="disabled"
                    class="inline-flex items-center justify-center bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-bold px-4 py-2.5 rounded-xl text-xs transition shadow-md shadow-emerald-950/40 cursor-pointer disabled:opacity-60 whitespace-nowrap active:scale-95">
                    <span wire:loading.remove wire:target="subscribe">
                        Subscribe
                    </span>
                    <span wire:loading wire:target="subscribe" class="flex items-center gap-1.5">
                        <svg class="animate-spin w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span>Joining...</span>
                    </span>
                </button>
            </div>
            @error('email') 
                <span class="text-xs text-rose-400 font-medium flex items-center gap-1 mt-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $message }}
                </span> 
            @enderror
        </form>
    @endif
</div>

