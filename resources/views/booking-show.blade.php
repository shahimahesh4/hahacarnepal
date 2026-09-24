@extends('layouts.app')

@section('title', 'Reservation Voucher - Hahakar Nepal')

@section('content')
<div class="relative bg-gradient-to-b from-[#0a1128] via-[#0f172a] to-[#1e293b] text-white py-12 md:py-16 min-h-screen overflow-hidden">
    <!-- Ambient Background Glows -->
    <div class="absolute inset-0 opacity-20 pointer-events-none">
        <div class="absolute -top-40 -right-40 w-[500px] h-[500px] bg-emerald-500 rounded-full blur-[140px]"></div>
        <div class="absolute bottom-20 -left-40 w-[400px] h-[400px] bg-teal-500 rounded-full blur-[140px]"></div>
    </div>

    <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <livewire:booking-confirmation :reference="$reference" />
    </div>
</div>
@endsection
