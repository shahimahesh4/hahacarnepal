@extends('layouts.app')

@section('title', 'Compare Car Rental Offers | Hahacar')

@section('content')
    <livewire:search-results 
        :pickup="request('pickup')"
        :dropoff="request('dropoff')"
        :from="request('from')"
        :to="request('to')"
        :age="request('age', 30)" />
@endsection
