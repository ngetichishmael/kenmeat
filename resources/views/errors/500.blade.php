
@php
    $pageConfigs = ['blankPage' => true];
@endphp

@extends('layouts/fullLayoutMaster')

@section('title', 'Error 404')

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/page-misc.css')) }}">
@endsection
@section('content')
<!-- Error page-->
<div class="misc-wrapper">

<a class="brand-logo" style="padding-left:150px;" href="javascript:void(0);">

<img src="{{ asset('app-assets/images/logo.png') }}" alt="MojaPass" style="width: 40px; height: 40px;">
</a>
  <div class="misc-inner p-2 p-sm-3">
    <div class="w-100 text-center">
      <h2 class="mb-1">500!!! Something went wrong 🕵🏻‍♀️</h2>
      <p class="mb-2">Oops! 😖 The requested URL was not found on this server.</p>
      <a class="btn btn-primary mb-2 btn-sm-block" href="{{url('/dashboard')}}">Back to home</a>
      <img class="img-fluid" src="{{asset('images/pages/error.svg')}}" alt="Error page" />
    
    </div>
  </div>
</div>
<!-- / Error page-->
@endsection