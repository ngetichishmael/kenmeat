
@extends('layouts.app3')
{{-- page header --}}
@section('title', 'Customer Comments')

{{-- content section --}}
@section('content')
    <!-- begin breadcrumb -->
    <div class="mb-2 row">
        <div class="col-md-9">
            <h2 class="page-header"> Customer Comments</h2>
        </div>
    
    </div>
    <!-- end breadcrumb -->
    @livewire('comment.dashboard')
@endsection
{{-- page scripts --}}
@section('script')
@endsection
