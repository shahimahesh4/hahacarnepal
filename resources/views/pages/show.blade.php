@extends('layouts.app')

@section('title', $page->meta_title ?? ($page->title . ' - Hahacar'))
@section('meta_description', $page->meta_description ?? '')

@section('content')
<div class="bg-slate-900 text-white py-12 sm:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-white mb-2">{{ $page->title }}</h1>
        <div class="text-xs text-slate-400">Last updated: {{ $page->updated_at->format('M d, Y') }}</div>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 sm:p-12 prose prose-slate max-w-none prose-headings:font-bold prose-headings:text-slate-900 prose-a:text-emerald-600 leading-relaxed">
        {!! Str::markdown($page->content) !!}
    </div>
</div>
@endsection
