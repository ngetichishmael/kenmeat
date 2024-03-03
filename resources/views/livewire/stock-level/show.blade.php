@extends('layouts.app3')

{{-- page header --}}
@section('title', 'Order Details')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" href="{{ asset('css/base/pages/app-invoice.css') }}">
@endsection

@section('content')
<div class="card">
    <h5 class="card-header">Customer Information</h5>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6><strong>Customer Name:</strong> {{ $formResponse->customer->customer_name ?? '' }}</h6>
                <h6><strong>Contact Person:</strong> {{ $formResponse->customer->contact_person ?? '' }}</h6>
                <h6><strong>Email:</strong> {{ $formResponse->customer->email ?? '' }}</h6>
                <!-- Add more customer information fields as needed -->
            </div>
            <div class="col-md-6">
                <h6><strong>Address:</strong> {{ $formResponse->customer->address ?? '' }}</h6>
                <h6><strong>City:</strong> {{ $formResponse->customer->city ?? '' }}</h6>
                <h6><strong>Country:</strong> {{ $formResponse->customer->country ?? '' }}</h6>
                <!-- Add more customer information fields as needed -->
            </div>
        </div>
    </div>
</div>




    <div class="card card-default">
       <h5 class="card-header"> Stock Level</h5>
        <div class="card-body">
            <div class="card-datatable">
                <table class="table table-striped table-bordered zero-configuration table-responsive">
                    <thead>
                        <tr>
                            <th width="1%">#</th>
                            <th>Product</th>
                            <th>Stock Level</th>
                            <th>Expiration Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($formResponse->availableProducts as $key => $product)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $product->product->product_name ?? '' }}</td>
                                <td>{{ $product->stock_level }}</td>
                                <td>{{ $product->expiration_date }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No stock levels available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="text-center mt-3">
                <a href="{{ route('StockLevel') }}" class="btn btn-primary">Back</a>
            </div>
            
        </div>
    </div>
    <br>

    @endsection

    @section('vendor-script')
        <script src="{{ asset('vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
        <script src="{{ asset('vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
    @endsection

    @section('page-script')
        <script src="{{ asset('js/scripts/pages/app-invoice.js') }}"></script>
    @endsection
