@extends('layouts.app') 

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Customer Returns</h5>

            {{-- Display Customer Information --}}
            <div class="mb-3">
                <strong>Customer Name:</strong> {{ $customer->customer_name ?? ''}}
            </div>

            {{-- Display Product Returns --}}
            <table class="table table-striped table-bordered zero-configuration table-responsive">
                <thead>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Date</th>
                </thead>
                <tbody>
                    @forelse ($returns as $key => $return)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $return->product->product_name ?? '' }}</td>
                            <td>{{ $return->quantity }}</td>
                    
                            <td>
                                @if ($return->status === 'Returned')
                                    <span class="badge badge-pill badge-light-success mr-1"> Returned </span>
                                @else
                                    <span class="badge badge-pill badge-light-warning mr-1"> Not Returned </span>
                                @endif
                            </td>


                            <td>{{ $return->created_at }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No product returns available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="text-center mt-3">
                <a href="{{ route('Returns') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
@endsection
