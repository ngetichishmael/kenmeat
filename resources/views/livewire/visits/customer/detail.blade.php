@extends('layouts.app3')


@section('content')
<section class="invoice-preview-wrapper">
      @include('partials._messages')
  <div class="row invoice-preview">
    <!-- Invoice -->
    <div class="col-xl-9 col-md-8 col-12">
      <div class="card invoice-preview-card">
        <div class="card-body invoice-padding pb-0">
          <!-- Header starts -->
          <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
            <div>
              <div class="logo-wrapper">

              </div>
              <p class="card-text mb-25"><b>Sale Associate</b> : {{ $visit->user->name ?? ''}}</p>
              <p class="card-text mb-25"><b>Customer</b> : {{ $visit->customer->customer_name ?? ''}}</p>
             
            </div>
            <div class="mt-md-0 mt-2">
              <h4 class="invoice-title">
                Checkin ID
                <span class="invoice-number">#{{ $visit->id ?? ''}}</span>
              </h4>
              <div class="invoice-date-wrapper">
                <p class="invoice-date-title">Date:</p>
                <p class="invoice-date"> {{ $visit->created_at->format('d-m-Y') }}</p>
              </div>
              <div class="invoice-date-wrapper">
                <p class="invoice-date-title">Start Time:</p>
                <p class="invoice-date"> {{ $visit->start_time ?? ''}}</p>
              </div>
              <div class="invoice-date-wrapper">
                <p class="invoice-date-title">End Time:</p>
                    @if ($visit->stop_time)
                      <p class="invoice-date"> {{ $visit->stop_time }} </p>
                    @else
                      <span class="badge badge-pill badge-light-info mr-1">Visit Active</span>
                    @endif
              </div>
            
            </div>
          </div>
          <!-- Header ends -->
        </div>

        <hr class="invoice-spacing" />

      

        <!-- Invoice Description starts -->
        <!-- <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th class="py-1">Description</th>
                <th class="py-1">Unit Price</th>
                <th class="py-1">Qty</th>
                <th class="py-1">Total</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($visit->formResponses as $response)
            <tr class="border-bottom">
                <td class="py-1">
                  <p class="card-text font-weight-bold mb-25">{{ $response->id ?? ''}} </p>
                  <p class="card-text text-nowrap">
                  {{ $response->region_or_route ?? ''}}
                  </p>
                </td>
                <td class="py-1">
                  <span class="font-weight-bold">{{ $response->region_or_route ?? ''}}</span>
                </td>
            
              </tr>
             @endforeach

     
            </tbody>
          </table>
        </div>

      

        <hr class="invoice-spacing" /> -->

        <!-- Invoice Note starts -->
        <div class="card-body invoice-padding pt-0">
          <div class="row">
            <div class="col-12">
              <span class="font-weight-bold">Note:</span>
              <span> </span
              >
            </div>
          </div>
        </div>
        <!-- Invoice Note ends -->
      </div>
    </div>
    <!-- /Invoice -->

    <!-- Invoice Actions -->
    <div class="col-xl-3 col-md-4 col-12 invoice-actions mt-md-0 mt-2">
      <div class="card">
        <div class="card-body">
     
          <button class="btn btn-outline-secondary btn-block btn-download-invoice mb-75">Download</button>
          <a class="btn btn-outline-secondary btn-block mb-75" href="#" target="_blank">
            Print
          </a>
   
        </div>
      </div>
    </div>
    <!-- /Invoice Actions -->
  </div>
</section>

@endsection

@section('vendor-script')
<script src="{{asset('vendors/js/forms/repeater/jquery.repeater.min.js')}}"></script>
<script src="{{asset('vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('js/scripts/pages/app-invoice.js')}}"></script>
@endsection



@section('vendor-style')
<link rel="stylesheet" href="{{asset('vendors/css/pickers/flatpickr/flatpickr.min.css')}}">
@endsection
@section('page-style')
<link rel="stylesheet" href="{{asset('css/base/plugins/forms/pickers/form-flat-pickr.css')}}">
<link rel="stylesheet" href="{{asset('css/base/pages/app-invoice.css')}}">
@endsection
