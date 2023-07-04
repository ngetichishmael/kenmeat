@extends('layouts.app2')

@section('title', 'Customer Support')

@section('stylesheets')
    <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/css/plugins/charts/chart-apex.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/css/pages/dashboard-ecommerce.min.css') !!}">
    <link rel="stylesheet" href="{{ asset('fonts/font-awesome/css/font-awesome.min.css') }}">

@endsection

@section('content')

@livewire('chats.dashboard')

@endsection

@section('scripts')
    <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/vendors/js/charts/apexcharts.min.js') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/js/scripts/pages/dashboard-ecommerce.min.js') !!}">
@endsection

