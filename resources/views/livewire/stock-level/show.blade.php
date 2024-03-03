@extends('layouts.app3')

@section('title', 'Stock Level Details')

@section('content')
    <section class="invoice-preview-wrapper">
        <div class="row invoice-preview">
            <div class="col-12">
                <div class="card invoice-preview-card">
                    <div class="card-body invoice-padding pb-0">
                        <!-- Header starts -->
                        <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
                            <div>
                                <h4 class="invoice-title">Stock Level Details</h4>
                            </div>
                        </div>
                        <!-- Header ends -->
                    </div>

                    <hr class="invoice-spacing" />

                    <!-- Stock Level Information starts -->
                    <div class="card-body invoice-padding pt-0">
                        <div class="row invoice-spacing">
                            <div class="col-md-8 p-0">
                                <h6 class="mb-2">Product Information:</h6>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>Product Name:</td>
                                            <td>{{ $stockLevel->product->product_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Stock Level:</td>
                                            <td>{{ $stockLevel->stock_level }}</td>
                                        </tr>
                                        <!-- Add more details as needed -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-4 p-0 mt-md-0 mt-2">
                                <h6 class="mb-2">Date Recorded:</h6>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>Date:</td>
                                            <td>{{ $stockLevel->created_at->format('Y-m-d h:i A') }}</td>
                                        </tr>
                                        <!-- Add more details as needed -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Stock Level Information ends -->

                    <hr class="invoice-spacing" />

                    <!-- Additional Information starts -->
                    <div class="card-body invoice-padding pt-0">
                        <div class="row">
                            <!-- Add additional information about stock levels -->
                        </div>
                    </div>
                    <!-- Additional Information ends -->
                </div>
            </div>
        </div>
    </section>
@endsection
