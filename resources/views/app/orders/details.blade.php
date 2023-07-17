@extends('layouts.app3')


{{-- page header --}}
@section('title', 'Order Details')

{{-- content section --}}
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-12 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-start mb-0">Order Details</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/sokoflowadmin">Home</a></li>
                            <li class="breadcrumb-item"><a href="{!! route('orders.index') !!}">Orders</a></li>
                            <li class="breadcrumb-item active">{!! $order->order_code !!}</li>
                            <li class="breadcrumb-item active">Details</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('partials._messages')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div>
                                <span class="text-sm text-grey-m2 align-middle">To:</span>
                                <span class="text-600 text-110 text-blue align-middle">  {{ $test->customer_name ?? '' }}</span>
                            </div>
                            <div class="text-grey-m2">
                                <div class="my-1">
                                    Address, <span class="text-blue">{!! $test->address ?? '' !!}</span>
                                </div>
                                <div class="my-1"><i class="fa fa-phone fa-flip-horizontal text-secondary"></i> <b
                                        class="text-600">(+254){!! $test->phone_number ?? '' !!}</b></div>
                            </div>
                        </div>
                        <!-- /.col -->

                        <div class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">
                            <hr class="d-sm-none" />
                            <div class="text-grey-m2">
                                <div class="mt-1">Invoice </div>

                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span
                                        class="text-600 text-90">ID:</span> #{!! $order->id !!}</div>

                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span
                                        class="text-600 text-90">Issue Date:</span> {!! $order->created_at !!}</div>

                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span
                                        class="text-600 text-90">Status:</span> <span
                                        class="badge badge-warning badge-pill px-25 text-black-50">{!! $order->order_status !!}</span>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>

                    <div class="">


                        <div class="table-responsive">
                            <table class="table table-striped table-borderless border-0 border-b-2 brc-default-l1">
                                <thead>
                                    <tr class="text-black">
                                        <th class="opacity-2">#</th>
                                        <th>Description</th>
                                        <th>Qty</th>
                                        <th>Unit Price</th>
                                        <th width="140">Amount</th>
                                    </tr>
                                </thead>

                                <tbody class="text-95 text-secondary-d3">
                                    @foreach ($items as $count => $item)
                                        <tr>
                                            <td>{!! $count + 1 !!}</td>
                                            <td>{!! $item->product_name !!}</td>
                                            <td>{!! $item->quantity !!}</td>
                                            <td class="text-95">ksh{!! $item->selling_price !!}</td>
                                            <td class="text-secondary-d2">ksh{!! $item->selling_price * $item->quantity !!}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0">
                                Extra note such as company or payment information...
                            </div>

                            <div class="col-12 col-sm-5 text-grey text-90 order-first order-sm-last">
                                <div class="row my-2">
                                    <div class="col-7 text-right">
                                        SubTotal
                                    </div>
                                    <div class="col-5">
                                        <span class="text-120 text-secondary-d1">Ksh {!! $sub->sum('sub_total') !!}</span>
                                    </div>
                                </div>

                                <div class="row my-2">
                                    <div class="col-7 text-right">
                                        Tax (10%)
                                    </div>
                                    <div class="col-5">
                                        <span class="text-110 text-secondary-d1">{!! $item->taxrate !!}%</span>
                                    </div>
                                </div>

                                <div class="row my-2 align-items-center bgc-primary-l3 p-2">
                                    <div class="col-7 text-right">
                                        Total Amount
                                    </div>
                                    <div class="col-5">
                                        <span class="text-150 text-success-d3 opacity-2">Ksh {!! $total->sum('total_amount') !!}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <center><a href="{!! route('orders.delivery.allocation', $order->order_code) !!}" class="btn btn-block btn-warning mb-2">Allocate Delivery</a></center>
            @if ($payment)
                <div class="card">
                    <div class="card-header">Order Payments</div>
                    <div class="card-body">
                        <h6>
                            <b>Amount:</b> {!! $payment->amount !!} <br>
                            <b>Payment Date:</b> {!! $payment->payment_date !!}<br>
                            <b>Payment Method:</b> {!! $payment->payment_method !!}<br>
                        </h6>
                        <hr>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-header">Order Payments</div>
                    <div class="card-body">
                        <h6>
                            <b>Amount:</b> N/A <br>
                            <b>Payment Date:</b> N/A <br>
                            <b>Payment Method:</b> N/A <br>
                        </h6>
                        <hr>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
{{-- page scripts --}}
@section('script')

@endsection
