@extends('layouts.app')

@section('title', $page->meta_title ?? ($page->title . ' - Hahakar Nepal'))
@section('meta_description', $page->meta_description ?? 'Learn more about Hahakar Nepal policies, terms, and rental guidelines.')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-b from-[#0b1329] to-[#0f172a] border-b border-white/10 text-white py-12 sm:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-bold uppercase tracking-wider mb-4">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
            <span>Hahakar Legal & Policy Center</span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white mb-3">{{ $page->title }}</h1>
        <div class="text-xs text-slate-400 flex flex-wrap items-center gap-3">
            <span>📅 Last updated: <strong class="text-slate-200">{{ $page->updated_at->format('M d, Y') }}</strong></span>
            <span>•</span>
            <span class="text-emerald-400 font-semibold">✓ Officially Verified for Nepal Operations</span>
        </div>
    </div>
</div>

<!-- Content Container -->
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14">
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200/80 p-8 sm:p-12 md:p-14 text-slate-800 leading-relaxed">
        <article class="prose prose-hahakar max-w-none">
            {!! Str::markdown($page->content) !!}
        </article>

        <div class="mt-12 pt-8 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
            <div>
                Have questions about this policy? <a wire:navigate href="{{ route('contact.index') }}" class="font-bold text-emerald-600 hover:text-emerald-700 underline">Contact Support Care</a>
            </div>
            <a wire:navigate href="{{ route('home') }}" class="inline-flex items-center gap-1 font-bold text-slate-700 hover:text-emerald-600 transition">
                <span>← Back to Home</span>
            </a>
        </div>
    </div>
</div>
@endsection
