<div>
    @if($visible)
        <div class="fixed bottom-0 inset-x-0 z-50 p-4 sm:p-6 bg-slate-900/95 backdrop-blur-md text-white border-t border-slate-800 shadow-2xl">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="space-y-2 max-w-3xl">
                    <div class="font-bold text-base flex items-center gap-2">
                        <span>🍪 Your Privacy Choices</span>
                    </div>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        We use necessary cookies for site security and search functionality. With your consent, we also use analytics and attribution cookies to measure partner referrals and optimize deal recommendations. You can change your preferences at any time.
                    </p>

                    @if($showCustomize)
                        <div class="pt-3 grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <label class="flex items-center gap-2 text-xs bg-slate-800/80 p-2.5 rounded-lg border border-slate-700">
                                <input type="checkbox" checked disabled class="rounded text-emerald-500">
                                <span class="font-bold text-slate-200">Strictly Necessary (Always Active)</span>
                            </label>
                            <label class="flex items-center gap-2 text-xs bg-slate-800/80 p-2.5 rounded-lg border border-slate-700 cursor-pointer">
                                <input type="checkbox" wire:model="analytics" class="rounded text-emerald-500">
                                <span class="text-slate-200">Analytics & Performance</span>
                            </label>
                            <label class="flex items-center gap-2 text-xs bg-slate-800/80 p-2.5 rounded-lg border border-slate-700 cursor-pointer">
                                <input type="checkbox" wire:model="marketing" class="rounded text-emerald-500">
                                <span class="text-slate-200">Attribution & Referral</span>
                            </label>
                        </div>
                    @endif
                </div>

                <div class="flex flex-wrap items-center gap-2.5 shrink-0 w-full md:w-auto">
                    @if($showCustomize)
                        <button type="button" 
                            wire:click="saveCustom"
                            class="bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-2.5 px-5 rounded-xl text-xs transition cursor-pointer">
                            Save Preferences
                        </button>
                    @else
                        <button type="button" 
                            wire:click="acceptAll"
                            class="bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-2.5 px-5 rounded-xl text-xs transition cursor-pointer">
                            Accept All
                        </button>
                        <button type="button" 
                            wire:click="rejectOptional"
                            class="bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold py-2.5 px-4 rounded-xl text-xs transition cursor-pointer">
                            Reject Optional
                        </button>
                        <button type="button" 
                            wire:click="$set('showCustomize', true)"
                            class="text-xs text-slate-400 hover:text-white underline px-2 py-1 transition cursor-pointer">
                            Customize
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
