@extends('layouts.app3')
{{-- page header --}}
@section('title', 'Activity Logs')
{{-- page styles --}}
@section('stylesheets')

@endsection


{{-- content section --}}
@section('content')
    <!-- Dashboard Ecommerce Starts -->
    @livewire('checkins.dashboard')
    <!-- Dashboard Ecommerce ends -->
@endsection
{{-- page scripts --}}
@section('script')

@endsection

