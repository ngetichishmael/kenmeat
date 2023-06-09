@extends('layouts.app')
{{-- page header --}}
@section('title', 'Route Scheduling')
{{-- page styles --}}

{{-- content section --}}
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-12 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-start mb-0">Route Scheduling</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Route</a></li>
                            <li class="breadcrumb-item active">Scheduling</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    {!! Form::open([
                        'route' => 'routes.store',
                        'class' => 'row',
                        'enctype' => 'multipart/form-data',
                        'method' => 'post',
                    ]) !!}
                    {!! csrf_field() !!}
                    <div class="form-group col-md-12 mb-1">
                        @livewire('routes.customerselect')
                        {{-- <label for="">Routes</label>
                        {!! Form::select('name', $routes, null, ['class' => 'form-control select2']) !!} --}}
                    </div>
                    <div class="row mb-1">
                        <div class="form-group col-md-4">
                            <label for="">Start Date</label>
                            {!! Form::date('start_date', null, ['class' => 'form-control', 'required' => '']) !!}
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">End Date</label>
                            {!! Form::date('end_date', null, ['class' => 'form-control', 'required' => '']) !!}
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Status</label>
                            {!! Form::select('status', ['' => 'Choose status', 'Active' => 'Active', 'Close' => 'Close'], null, [
                                'class' => 'form-control',
                                'required' => '',
                            ]) !!}
                        </div>
                    </div>
                    {{-- <div class="form-group col-md-12 mb-1">
                        <label for="">Add Customer to Route</label>
                        {!! Form::select('customers[]', $customers, null, ['class' => 'form-control select2', 'multiple' => '']) !!}
                    </div> --}}
                    <div class="form-group col-md-6 mb-1">
                        <label for="">Account Type</label>
                       <select name="account_type" class="form-control select" id="account_type" required>
                          <option value="">Choose User Type</option>
                          @foreach ($account_types as $account)
                             <option value="{!! $account->account_type !!}">{!! $account->account_type !!}</option>
                          @endforeach
                       </select>
                    </div>
{{--                   <div class="form-group col-md-6 mb-1">--}}
{{--                        <label for="">Add sales people to Route</label>--}}
{{--                        {!! Form::select('sales_persons[]', $salesPeople, null, ['class' => 'form-control select2', 'name'=>"user",'id'=>"user",'multiple' => '']) !!}--}}
{{--                    </div>--}}
                   <div class="form-group col-md-6 mb-1">
                      <label for="">Add sales people to Route</label>
                      {!! Form::select('sales_persons[]', [], null, ['class' => 'form-control select2', 'name' => 'user', 'id' => 'user', 'multiple' => '']) !!}
                   </div>
{{--                   <div class="form-group col-md-4">--}}
{{--                      <label for="">Choose User</label>--}}
{{--                      <select name="user" class="form-control select2" id="user" required>--}}
{{--                         <option value=""></option>--}}
{{--                      </select>--}}
{{--                   </div>--}}

                    <div class="form-group mb-1">
                        <button class="btn" style="background-color: #B6121B;color:white" type="submit">Save Information</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
       $(document).ready(function() {
          $('#account_type').on('change', function() {
             var accountType = $(this).val();
             if (accountType) {
                $.ajax({
                   url: '{{ route('get.users') }}',
                   type: 'GET',
                   data: { account_type: accountType },
                   success: function(data) {
                      $('#user').empty();
                      $('#user').append('<option value="">Select Sales Person</option>');
                      data.users.forEach(function(user) {
                         $('#user').append('<option value="' + user.id + '">' + user.name + '</option>');
                      });
                   },
                   error: function() {
                      console.log('Error occurred during AJAX request.');
                   }
                });
             } else {
                $('#user').empty();
                $('#user').append('<option value="">Select Sales Person</option>');
             }
          });
       });
    </script>


@endsection
{{-- page scripts --}}
@section('scripts')

@endsection
