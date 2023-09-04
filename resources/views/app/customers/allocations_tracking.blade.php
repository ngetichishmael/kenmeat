@extends('layouts.app3')
{{-- page header --}}
@section('title', 'Customer Allocation')
{{-- page styles --}}
@section('stylesheets')

@endsection


{{-- content section --}}
@section('content')
   <!-- begin breadcrumb -->
   <div class="row mb-2">
      <div class="col-md-8">
         <h2 class="page-header">Customers Allocation Tracking</h2>
      </div>
   </div>
   <!-- end breadcrumb -->

   @livewire('customers.allocations-tracking', ['customerid'=>$customerid])
@endsection
{{-- page scripts --}}
@section('script')

@endsection
