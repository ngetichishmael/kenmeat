@extends('layouts.app3')
{{-- page header --}}
@section('title', 'Merchandiser Reports')
{{-- page styles --}}
@section('stylesheets')

@endsection


{{-- content section --}}
@section('content')
   <div class="mb-2 row">
        <div class="col-md-9">
            <h2 class="page-header"> Merchandiser Reports </h2>
        </div>
    
    </div>
    <!-- Dashboard Ecommerce Starts -->
    @livewire('merchandiser.dashboard')
    <!-- Dashboard Ecommerce ends -->
@endsection
{{-- page scripts --}}
@section('script')

@endsection

