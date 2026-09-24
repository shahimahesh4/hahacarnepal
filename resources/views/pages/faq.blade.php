@extends('layouts.app')

@section('title', 'Help & Frequently Asked Questions | Hahakar Nepal')
@section('meta_description', 'Find answers to common questions about car rental bookings, EV & 4x4 options, driver policies, insurance, and price alerts on Hahakar.')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-b from-[#0b1329] to-[#0f172a] border-b border-white/10 text-white py-12 sm:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-bold uppercase tracking-wider mb-3">
            <span>💡</span> Help & Support Center
        </span>
        <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white mb-3">Frequently Asked Questions</h1>
        <p class="text-slate-300 max-w-xl mx-auto text-sm leading-relaxed">
            Clear, transparent answers on Nepal car rentals, chauffeur policies, self-drive requirements, and payment methods.
        </p>
    </div>
</div>

<!-- FAQ Accordions -->
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14">
    <div class="space-y-6">
        @php
            $groupedFaqs = \App\Models\Faq::where('is_published', true)->orderBy('sort_order')->get()->groupBy('category');
        @endphp

        @forelse($groupedFaqs as $category => $faqs)
            <div class="bg-white rounded-3xl shadow-lg border border-slate-200/80 p-6 sm:p-8 text-slate-900">
                <h2 class="text-lg font-black text-slate-900 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2.5">
                    <span class="w-3 h-3 rounded-full bg-emerald-500 ring-4 ring-emerald-100"></span>
                    <span>{{ $category }} Inquiries</span>
                </h2>

                <div class="space-y-3">
                    @foreach($faqs as $faq)
                        <div class="border border-slate-200/80 rounded-2xl p-5 hover:border-emerald-300 transition bg-slate-50/50" x-data="{ open: false }">
                            <button type="button" @click="open = !open" class="w-full flex items-center justify-between text-left font-bold text-slate-900 text-sm sm:text-base gap-4 cursor-pointer">
                                <span>{{ $faq->question }}</span>
                                <div class="w-7 h-7 rounded-xl bg-white border border-slate-200 flex items-center justify-center shrink-0 text-slate-600 transition-transform duration-200" :class="{ 'rotate-180 bg-emerald-50 text-emerald-600 border-emerald-300': open }">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </button>
                            <div x-show="open" x-cloak x-transition class="mt-3.5 text-sm text-slate-700 leading-relaxed pt-3.5 border-t border-slate-200 font-medium">
                                {{ $faq->answer }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="bg-white rounded-3xl p-12 text-center text-slate-500 shadow-md">
                No FAQs published at this time. Please contact support.
            </div>
        @endforelse
    </div>

    <!-- Need Help Box -->
    <div class="mt-10 bg-gradient-to-r from-emerald-50 via-teal-50 to-emerald-50 border border-emerald-200 rounded-3xl p-8 text-center text-slate-900 shadow-sm">
        <h3 class="font-black text-slate-900 text-lg mb-1.5">Have a Specific Question?</h3>
        <p class="text-xs sm:text-sm text-slate-600 max-w-lg mx-auto mb-5 leading-relaxed">
            Our local 24/7 Kathmandu support desk is ready to help you with vehicle suggestions, driver assignments, or customized tour pricing.
        </p>
        <div class="flex flex-wrap items-center justify-center gap-3">
            <a href="{{ route('contact.index') }}" wire:navigate class="inline-flex items-center gap-1.5 bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-3 px-6 rounded-2xl text-xs sm:text-sm shadow-md shadow-emerald-600/20 transition">
                <span>💬 Contact Support Desk</span>
            </a>
            <a href="tel:{{ preg_replace('/[^0-9+]/', '', \App\Models\Setting::get('support_phone', '+977 9801-HAHAKAR')) }}" class="inline-flex items-center gap-1.5 bg-white hover:bg-slate-50 border border-slate-300 text-slate-800 font-bold py-3 px-6 rounded-2xl text-xs sm:text-sm transition">
                <span>📞 Call {{ \App\Models\Setting::get('support_phone', '+977 9801-HAHAKAR') }}</span>
            </a>
        </div>
    </div>
</div>
@endsection
