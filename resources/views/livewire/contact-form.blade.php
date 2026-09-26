<div class="bg-white rounded-3xl shadow-xl border border-slate-200/80 p-8 sm:p-10 text-slate-900">
    @if($submitted)
        <div class="text-center py-10">
            <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-4 ring-8 ring-emerald-50">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h3 class="text-2xl font-black text-slate-900 mb-2">Message Received!</h3>
            <p class="text-slate-600 max-w-md mx-auto text-sm leading-relaxed mb-6">
                Thank you for reaching out to Hahakar Nepal. Our team will review your inquiry and get back to you promptly.
            </p>
            <button type="button" 
                wire:click="$set('submitted', false)"
                class="bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 px-6 rounded-2xl text-xs sm:text-sm transition cursor-pointer">
                Send Another Message
            </button>
        </div>
    @else
        <form wire:submit.prevent="submit" class="space-y-5">
            <div class="border-b border-slate-100 pb-4 mb-2">
                <h3 class="text-xl font-black text-slate-900">Send an Inquiry</h3>
                <p class="text-xs text-slate-500 mt-0.5">Fill in the details below and we will connect with you via email or phone.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Your Full Name</label>
                    <input type="text" 
                        wire:model="name"
                        placeholder="e.g. Ramesh Karki"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-2xl text-slate-900 placeholder:text-slate-400 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition text-sm">
                    @error('name') <span class="text-xs text-rose-600 font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Address</label>
                    <input type="email" 
                        wire:model="email"
                        placeholder="e.g. ramesh@example.com"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-2xl text-slate-900 placeholder:text-slate-400 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition text-sm">
                    @error('email') <span class="text-xs text-rose-600 font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Subject</label>
                <input type="text" 
                    wire:model="subject"
                    placeholder="e.g. Scorpio Rental to Pokhara, Partner Registration question..."
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-2xl text-slate-900 placeholder:text-slate-400 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition text-sm">
                @error('subject') <span class="text-xs text-rose-600 font-semibold mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Message / Requirements</label>
                <textarea wire:model="message" 
                    rows="4"
                    placeholder="Please specify your trip dates, preferred vehicle category, pickup location, or questions..."
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-2xl text-slate-900 placeholder:text-slate-400 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition text-sm"></textarea>
                @error('message') <span class="text-xs text-rose-600 font-semibold mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="pt-2">
                <label class="flex items-start gap-3 cursor-pointer text-xs text-slate-600">
                    <input type="checkbox" wire:model="privacyConsent" class="mt-0.5 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300">
                    <span>
                        I agree to the <a href="{{ route('pages.show', 'privacy') }}" target="_blank" class="text-emerald-700 font-bold underline">Privacy Policy</a> and authorize Hahakar Nepal to contact me regarding this inquiry.
                    </span>
                </label>
                @error('privacyConsent') <span class="text-xs text-rose-600 font-semibold mt-1 block">{{ $message }}</span> @enderror
            </div>

            <button type="submit" 
                class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-bold py-3.5 px-6 rounded-2xl shadow-lg shadow-emerald-600/25 hover:shadow-emerald-600/35 transition cursor-pointer text-sm">
                <span wire:loading.remove>Send Message</span>
                <span wire:loading>Sending inquiry...</span>
            </button>
        </form>
    @endif
</div>
