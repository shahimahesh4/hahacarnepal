<div>
    @if($subscribed)
        <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 p-3.5 rounded-xl text-xs flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>You're subscribed! We will send you exclusive travel discounts and car-rental deals.</span>
        </div>
    @else
        <form wire:submit.prevent="subscribe" class="flex flex-col sm:flex-row gap-2">
            <input type="email" 
                wire:model="email" 
                placeholder="Enter your email" 
                class="bg-slate-800 border border-slate-700 text-white placeholder-slate-400 px-4 py-2.5 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 grow">
            <button type="submit" 
                class="bg-emerald-600 hover:bg-emerald-500 text-white font-bold px-5 py-2.5 rounded-xl text-sm transition shadow-sm cursor-pointer whitespace-nowrap">
                Subscribe
            </button>
        </form>
        @error('email') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
    @endif
</div>
