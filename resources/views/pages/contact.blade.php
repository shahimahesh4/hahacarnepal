@extends('layouts.app')

@section('title', 'Contact Support & Inquiries | Hahacar')
@section('meta_description', 'Get in touch with the Hahacar team for search assistance, provider partnerships, or general platform inquiries.')

@section('content')
<div class="bg-slate-900 text-white py-12 sm:py-16">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="text-emerald-400 text-xs font-bold uppercase tracking-wider">Customer Support & Care</span>
        <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white mt-1 mb-3">How Can We Help You?</h1>
        <p class="text-slate-300 max-w-xl mx-auto text-sm">
            Have questions about our price comparison, price alerts, or affiliate partnerships? We're here to assist.
        </p>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 mb-16">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Contact Info Sidecard -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-6 space-y-6">
                <div>
                    <h3 class="font-bold text-slate-900 text-base mb-1">Support Boundaries</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Hahacar is a metasearch engine. For changes to an existing reservation, cancellations, or refunds, please contact your booking partner directly.
                    </p>
                </div>

                <div class="space-y-4 pt-4 border-t border-slate-100 text-xs text-slate-600">
                    <div class="flex items-start gap-3">
                        <span class="p-2 bg-emerald-50 text-emerald-600 rounded-lg shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </span>
                        <div>
                            <div class="font-bold text-slate-800">Email Us</div>
                            <div class="text-slate-500">support@hahacar.com</div>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <span class="p-2 bg-emerald-50 text-emerald-600 rounded-lg shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </span>
                        <div>
                            <div class="font-bold text-slate-800">Support Hours</div>
                            <div class="text-slate-500">Monday - Friday (9am - 6pm UTC)</div>
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
