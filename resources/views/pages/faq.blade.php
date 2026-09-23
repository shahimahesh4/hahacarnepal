@extends('layouts.app')

@section('title', 'Help & Frequently Asked Questions | Hahacar')
@section('meta_description', 'Find answers to common questions about car rental bookings, insurance, cancellation, and price alerts on Hahacar.')

@section('content')
<div class="bg-slate-900 text-white py-12 sm:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="text-emerald-400 text-xs font-bold uppercase tracking-wider">Help Center</span>
        <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white mt-1 mb-3">Frequently Asked Questions</h1>
        <p class="text-slate-300 max-w-xl mx-auto text-sm">
            Everything you need to know about comparing car rentals, merchant policies, and saving money.
        </p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="space-y-6">
        @php
            $groupedFaqs = \App\Models\Faq::where('is_published', true)->orderBy('sort_order')->get()->groupBy('category');
        @endphp

        @foreach($groupedFaqs as $category => $faqs)
            <div class="bg-white rounded-2xl shadow-xs border border-slate-200 p-6 sm:p-8">
                <h2 class="text-lg font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    {{ $category }} Questions
                </h2>

                <div class="space-y-4">
                    @foreach($faqs as $faq)
                        <div class="border border-slate-100 rounded-xl p-5 hover:border-slate-200 transition" x-data="{ open: false }">
                            <button type="button" @click="open = !open" class="w-full flex items-center justify-between text-left font-bold text-slate-900 text-sm">
                                <span>{{ $faq->question }}</span>
                                <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="open" x-transition class="mt-3 text-xs text-slate-600 leading-relaxed pt-3 border-t border-slate-100">
                                {{ $faq->answer }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-12 bg-emerald-50 border border-emerald-100 rounded-2xl p-8 text-center">
        <h3 class="font-bold text-slate-900 text-base mb-1">Still have a question?</h3>
        <p class="text-xs text-slate-600 max-w-md mx-auto mb-4">Our support team is ready to help you navigate rental policies or assist with platform questions.</p>
        <a href="{{ route('contact.index') }}" wire:navigate class="inline-flex bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-6 rounded-xl text-xs transition">
            Contact Support Desk
        </a>
    </div>
</div>
@endsection
