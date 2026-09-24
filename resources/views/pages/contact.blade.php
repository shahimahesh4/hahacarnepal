@extends('layouts.app')

@section('title', 'Contact Customer Care & Support | Hahakar Nepal')
@section('meta_description', 'Get in touch with Hahakar Nepal team for rental inquiries, fleet partnerships, route consultation, or reservation support.')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-b from-[#0b1329] to-[#0f172a] border-b border-white/10 text-white py-12 sm:py-16">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-bold uppercase tracking-wider mb-3">
            <span>🇳🇵</span> 24/7 Roadside & Customer Desk
        </span>
        <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white mb-3">We're Here to Help</h1>
        <p class="text-slate-300 max-w-xl mx-auto text-sm leading-relaxed">
            Need assistance with a direct car reservation, verified driver dispatch, or partner onboarding? Send us a message anytime.
        </p>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Contact Info Sidecard -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-3xl shadow-xl border border-slate-200/80 p-6 sm:p-8 space-y-6 text-slate-800">
                <div>
                    <h3 class="font-black text-slate-900 text-lg mb-1">Direct Assistance</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        For immediate vehicle breakdowns or urgent dispatch updates, contact our dispatch helpline directly.
                    </p>
                </div>

                <div class="space-y-4 pt-4 border-t border-slate-100 text-xs">
                    <div class="flex items-start gap-3.5">
                        <span class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl shrink-0 border border-emerald-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </span>
                        <div>
                            <div class="font-bold text-slate-900 text-sm">24/7 Helpline</div>
                            <div class="text-emerald-700 font-bold text-sm mt-0.5">{{ \App\Models\Setting::get('support_phone', '+977 9801-HAHAKAR') }}</div>
                            <div class="text-slate-500 text-[11px] mt-0.5">Kathmandu & Pokhara Support</div>
                        </div>
                    </div>

                    <div class="flex items-start gap-3.5">
                        <span class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl shrink-0 border border-emerald-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </span>
                        <div>
                            <div class="font-bold text-slate-900 text-sm">Email Care Desk</div>
                            <div class="text-slate-700 font-semibold text-xs mt-0.5">{{ \App\Models\Setting::get('support_email', 'support@hahakar.com') }}</div>
                            <div class="text-slate-500 text-[11px] mt-0.5">Response within 2-4 hours</div>
                        </div>
                    </div>

                    <div class="flex items-start gap-3.5">
                        <span class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl shrink-0 border border-emerald-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </span>
                        <div>
                            <div class="font-bold text-slate-900 text-sm">Main Office</div>
                            <div class="text-slate-700 font-medium text-xs mt-0.5">Lazimpat, Kathmandu, Nepal</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form Component -->
        <div class="lg:col-span-2">
            <livewire:contact-form />
        </div>
    </div>
</div>
@endsection
