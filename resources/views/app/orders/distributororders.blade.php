@extends('layouts.app3')
{{-- page header --}}
@section('title','Vansales Pending Orders')

{{-- content section --}}
@section('content')
   <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
         <div class="row breadcrumbs-top">
            <div class="col-12">
               <h2 class="content-header-title float-start mb-0">Vansales Orders </h2>
               <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="#">Home</a></li>
                     <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Vansales Orders</a></li>
                     <li class="breadcrumb-item active">List</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
   </div>
   @include('partials._messages')
   @livewire('orders.distributororders')
@endsection
{{-- page scripts --}}
@section('script')

@endsection
