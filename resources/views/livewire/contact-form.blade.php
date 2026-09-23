<div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-8">
    @if($submitted)
        <div class="text-center py-8">
            <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h3 class="text-2xl font-bold text-slate-900 mb-2">Message Sent!</h3>
            <p class="text-slate-600 max-w-md mx-auto text-sm leading-relaxed mb-6">
                Thank you for contacting Hahacar. Our customer care desk has received your ticket and will respond to your email within 24 business hours.
            </p>
            <button type="button" 
                wire:click="$set('submitted', false)"
                class="bg-slate-900 hover:bg-slate-800 text-white font-semibold py-2.5 px-6 rounded-xl text-sm transition">
                Send Another Message
            </button>
        </div>
    @else
        <form wire:submit.prevent="submit" class="space-y-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Your Name</label>
                    <input type="text" 
                        wire:model="name"
                        placeholder="John Doe"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    @error('name') <span class="text-xs text-rose-500 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Address</label>
                    <input type="email" 
                        wire:model="email"
                        placeholder="john@example.com"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    @error('email') <span class="text-xs text-rose-500 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Subject</label>
                <input type="text" 
                    wire:model="subject"
                    placeholder="e.g. Question about car comparison, provider inquiry..."
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                @error('subject') <span class="text-xs text-rose-500 font-medium mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Message</label>
                <textarea wire:model="message" 
                    rows="5"
                    placeholder="Please describe how we can help you..."
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:ring-2 focus:ring-emerald-500 focus:outline-none"></textarea>
                @error('message') <span class="text-xs text-rose-500 font-medium mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="flex items-start gap-2.5 cursor-pointer text-xs text-slate-600">
                    <input type="checkbox" wire:model="privacyConsent" class="mt-0.5 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300">
                    <span>
                        I acknowledge that Hahacar compares car rental rates and redirects to booking partners. For existing partner reservations, modifications must be directed to the merchant of record.
                    </span>
                </label>
                @error('privacyConsent') <span class="text-xs text-rose-500 font-medium mt-1 block">{{ $message }}</span> @enderror
            </div>

            <button type="submit" 
                class="w-full bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold py-3.5 px-6 rounded-xl shadow-md hover:shadow-lg transition cursor-pointer flex items-center justify-center gap-2">
                <span wire:loading.remove wire:target="submit">Send Message</span>
                <span wire:loading wire:target="submit">Sending...</span>
            </button>
        </form>
    @endif
</div>
