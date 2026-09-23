<div class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full p-6 sm:p-8 relative border border-slate-100 animate-in fade-in zoom-in-95 duration-200">
        <!-- Close Button -->
        <button type="button" 
            wire:click="close"
            class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 p-1.5 rounded-full hover:bg-slate-100 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>

        @if($submitted)
            <!-- Success State -->
            <div class="text-center py-6">
                <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-2">Check Your Inbox!</h3>
                <p class="text-slate-600 text-sm leading-relaxed mb-6">
                    We sent a verification link to <strong class="text-slate-900">{{ $email }}</strong>. Please click the link to confirm your alert and start tracking prices.
                </p>
                <button type="button" 
                    wire:click="close"
                    class="w-full bg-slate-900 hover:bg-slate-800 text-white font-semibold py-3 px-6 rounded-xl transition">
                    Done
                </button>
            </div>
        @else
            <!-- Subscription Form -->
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <span class="p-2.5 bg-emerald-50 text-emerald-600 rounded-2xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    </span>
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">Never Miss a Price Drop</h3>
                        <p class="text-xs text-slate-500">Free rate monitoring for {{ $pickupLoc?->city }}</p>
                    </div>
                </div>

                <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 mb-5 text-xs text-slate-600">
                    <div class="font-semibold text-slate-800 mb-1">Alert Scope:</div>
                    <div>📍 {{ $pickupLoc?->display_name }}</div>
                    <div>📅 {{ date('M d, Y', strtotime($pickupDatetime)) }} → {{ date('M d, Y', strtotime($dropoffDatetime)) }}</div>
                    @if($currentBestPriceMinor)
                        <div class="mt-1 text-emerald-700 font-bold">Current lowest rate: Rs. {{ number_format($currentBestPriceMinor / 100) }}</div>
                    @endif
                </div>

                <form wire:submit.prevent="createAlert" class="space-y-4">
                    <!-- Email input -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Your Email Address</label>
                        <input type="email" 
                            wire:model.defer="email"
                            placeholder="you@example.com"
                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl font-medium text-slate-800 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        @error('email') <span class="text-xs text-rose-500 font-medium mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Threshold options -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Notify me when:</label>
                        <div class="grid grid-cols-3 gap-2">
                            <label class="border rounded-xl p-2.5 text-center cursor-pointer transition {{ $thresholdType === 'any_drop' ? 'border-emerald-600 bg-emerald-50/50 text-emerald-800 font-bold' : 'border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                                <input type="radio" wire:model.live="thresholdType" value="any_drop" class="sr-only">
                                <div class="text-xs">Any Drop</div>
                            </label>
                            <label class="border rounded-xl p-2.5 text-center cursor-pointer transition {{ $thresholdType === 'percentage' ? 'border-emerald-600 bg-emerald-50/50 text-emerald-800 font-bold' : 'border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                                <input type="radio" wire:model.live="thresholdType" value="percentage" class="sr-only">
                                <div class="text-xs">≥ 5% Drop</div>
                            </label>
                            <label class="border rounded-xl p-2.5 text-center cursor-pointer transition {{ $thresholdType === 'fixed_amount' ? 'border-emerald-600 bg-emerald-50/50 text-emerald-800 font-bold' : 'border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                                <input type="radio" wire:model.live="thresholdType" value="fixed_amount" class="sr-only">
                                <div class="text-xs">≥ Rs. 500 Savings</div>
                            </label>
                        </div>
                    </div>

                    <!-- Frequency -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Frequency</label>
                        <select wire:model="frequency" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                            <option value="daily">Daily Summary (Recommended)</option>
                            <option value="real_time">Real-Time (Instant when rate drops)</option>
                        </select>
                    </div>

                    <!-- Explicit Consent Checkbox -->
                    <div class="pt-2">
                        <label class="flex items-start gap-2.5 cursor-pointer text-xs text-slate-600">
                            <input type="checkbox" wire:model="consent" class="mt-0.5 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300">
                            <span>
                                I agree to receive price drop notifications for this rental trip. I can unsubscribe anytime with 1 click. View our <a href="{{ route('pages.show', 'privacy') }}" target="_blank" class="text-emerald-600 underline">Privacy Policy</a>.
                            </span>
                        </label>
                        @error('consent') <span class="text-xs text-rose-500 font-medium mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Submit -->
                    <div class="pt-3">
                        <button type="submit" 
                            class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3.5 px-6 rounded-xl shadow-lg shadow-emerald-600/20 transition flex items-center justify-center gap-2 cursor-pointer">
                            <span wire:loading.remove wire:target="createAlert">Activate Free Price Alert</span>
                            <span wire:loading wire:target="createAlert">Creating Alert...</span>
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>
