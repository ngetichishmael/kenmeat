@extends('layouts.app3')
{{-- page header --}}
@section('title','Leads Target')

{{-- content section --}}
@section('content')
   <!-- begin breadcrumb -->
   <div class="row mb-2">
      <div class="col-md-8">
         <h2 class="page-header"></i> Stock Level </h2>
      </div>
   </div>
   <!-- end breadcrumb -->
   <!-- begin page-header -->

   <!-- end page-header -->
   @include('partials._messages')

   @livewire('stock-level.dashboard')

@endsection
