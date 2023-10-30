@extends('layouts.app')
{{-- page header --}}
@section('title', 'Sales Agents')
@section('styles')
    {{ asset('assets/css/maps.css') }}
@endsection
{{-- content section --}}
@section('content')

    @livewire('maps.agents.dashboard')
    <br>
@endsection
