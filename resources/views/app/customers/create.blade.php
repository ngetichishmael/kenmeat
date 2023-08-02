
@extends('layouts.app3')
{{-- page header --}}
@section('title', 'Customer')

@section('vendor-style')
  <!-- Vendor css files -->
  <link rel="stylesheet" href="{{ asset('vendors/css/forms/wizard/bs-stepper.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/extensions/toastr.min.css') }}">


  <link rel="stylesheet" href="{{ asset('vendors/css/vendors.min.css') }}" />
<link rel="stylesheet" href="{{ asset('vendors/css/ui/prism.min.css') }}" />

<!-- Vendor css files -->
<link rel="stylesheet" href="{{ asset('vendors/css/forms/wizard/bs-stepper.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/css/extensions/toastr.min.css') }}">

<link rel="stylesheet" href="{{ asset('css/core.css') }}" />
<link rel="stylesheet" href="{{ asset('css/base/core/menu/menu-types/vertical-menu.css') }}" />
<!-- <link rel="stylesheet" href="{{ asset('css/base/core/colors/palette-gradient.css') }}"> -->

<!-- Page css files -->
<link rel="stylesheet" href="{{ asset('css/base/pages/app-ecommerce.css') }}">
<link rel="stylesheet" href="{{ asset('css/base/plugins/forms/pickers/form-pickadate.css') }}">
<link rel="stylesheet" href="{{ asset('css/base/plugins/forms/form-wizard.css') }}">
<link rel="stylesheet" href="{{ asset('css/base/plugins/extensions/ext-component-toastr.css') }}">
<link rel="stylesheet" href="{{ asset('css/base/plugins/forms/form-number-input.css') }}">

<link rel="stylesheet" href="{{ asset('css/overrides.css') }}">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">


@endsection

@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset('css/base/pages/app-ecommerce.css') }}">
  <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/pickers/form-pickadate.css') }}">
  <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/form-wizard.css') }}">
  <link rel="stylesheet" href="{{ asset('css/base/plugins/extensions/ext-component-toastr.css') }}">
  <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/form-number-input.css') }}">
@endsection



{{-- content section --}}
@section('content')
    <!-- begin breadcrumb -->
    <div class="row mb-2">
        <div class="col-md-8">
            <h2 class="page-header">New Customer</h2>
        </div>
        <div class="col-md-4">
            <center>
                 <!-- <a href="{!! route('customer.create') !!}" class="btn btn-primary btn-sm"><i class="fa fa-user-plus"></i> Add a
                    Customer</a>
                <a href="{{ route('user-import') }}" class="btn btn-info btn-sm"><i class="fa fa-file-upload"></i> Import
                    Customer</a>
               <a href="" class="btn btn-warning btn-sm"><i class="fal fa-file-download"></i> Export Customer</a> -->
            </center>
        </div>
    </div>
    <!-- end breadcrumb -->

    @livewire('customers.create-customer')
 
@endsection

@section('vendor-script')
  <!-- Vendor js files -->
  <script src="{{ asset('vendors/js/forms/wizard/bs-stepper.min.js') }}"></script>
  <script src="{{ asset('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js') }}"></script>
  <script src="{{ asset('vendors/js/extensions/toastr.min.js') }}"></script>
  <script src="{{ asset('js/scripts/pages/app-ecommerce-checkout.js') }}"></script>


  <script src="{{ asset('vendors/js/vendors.min.js') }}"></script>
<script src="{{ asset('vendors/js/ui/prism.min.js') }}"></script>

<!-- Vendor js files -->
<script src="{{ asset('vendors/js/forms/wizard/bs-stepper.min.js') }}"></script>
<script src="{{ asset('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js') }}"></script>
<script src="{{ asset('vendors/js/extensions/toastr.min.js') }}"></script>

<script src="{{ asset('js/core/app-menu.js') }}"></script>
<script src="{{ asset('js/core/app.js') }}"></script>
<script src="{{ asset('js/scripts/customizer.js') }}"></script>

<!-- Page js files -->
<script src="{{ asset('js/scripts/pages/app-ecommerce-checkout.js') }}"></script>

@endsection

