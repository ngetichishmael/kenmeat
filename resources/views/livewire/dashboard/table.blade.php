@php
use Carbon\Carbon;
@endphp

<div class="mt-0" >

<section class="app-user-list" id="vansalesSection">
            <div class="card">
                <h5 class="card-header">Sales</h5>
            
            </div>

            <div class="card">
                <div class="pt-0 card-datatable table-responsive">
                <table class="table">
    <thead class="thead-light">
        <tr>
            <th>ID</th>
            <th>Order Code</th>
            <th>Customer</th>
            <th>Sales Associates</th>
            <th>Amount (Ksh)</th>
            <th>Payment Status</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($salesTotal as $key => $sale)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $sale->order_code ?? ''}}</td>
                <td>{{ $sale->user()->pluck('name' ?? '')->implode('') }}</td>
                <td>{{ $sale->customer()->pluck('customer_name' ?? '')->implode('') }}</td>
                <td>{{ number_format($sale->price_total, 2, '.', ',') }}</td>
                <td>
    @if ($sale->payment_status === 'PAID')
        <span class="badge badge-pill badge-light-success mr-1"> Paid </span>
    @else
       
        <span class="badge badge-pill badge-light-warning mr-1">  {{ $sale->payment_status }} </span>
    @endif
</td>

                <td>{{ Carbon::parse($sale->updated_at)->format('d-m-Y h:iA') }}</td>
            </tr>
        @empty
            <x-emptyrow>
                6
            </x-emptyrow>
        @endforelse
    </tbody>
</table>

                  
                </div>
            </div>
        </section>

  
        <section class="app-user-list" id="visitsSection">
            <div class="card">
                <h5 class="card-header"> Recent Visits</h5>
            
            </div>

            <div class="card">
                <div class="pt-0 card-datatable table-responsive">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Sales Associates</th>
                            <th>Duration</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($visitsTotal as $key => $visit)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $visit->customer->customer_name ?? ''}}</td>
                                <td>{{ $visit->user->name ?? '' }}</td>
                                <td>
                                <div class="badge badge-pill badge-secondary">{{ $visit->duration }} ago </div>

                                </td>
                                <td>
                                    @if ($visit->stop_time === null)
                                    
                                        <span class="badge badge-pill badge-light-warning mr-1">Visit Active</span>
                                    @else
                                        <span class="badge badge-pill badge-light-success mr-1"> Complete</span>
                                    
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <x-emptyrow>
                                6
                            </x-emptyrow>
                        @endforelse
                    </tbody>
                </table>

                </div>
            </div>
        </section>
        <section class="app-user-list" id="activeUsersSection">
            <div class="card">
                <h5 class="card-header">Recent Users</h5>
             
            </div>
            {{-- @dd($activeUserTotal) --}}
            <div class="card">
                <div class="pt-0 card-datatable table-responsive">
                <table class="table">
    <thead class="thead-light">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Account Type</th>
            <th>Status</th>
            <!-- <th>Edit</th> -->
        </tr>
    </thead>
    <tbody>
        @forelse ($activeUserTotal as $key => $user)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $user->name ?? ''}}</td>
                <td>{{ $user->email ?? ''}}</td>
                <td>{{ $user->phone_number ?? ''}}</td>
                <td>
                    <span class="badge badge-pill badge-light-primary mr-1">{{ $user->account_type }}</span>
                </td>
                <td>
                    <span class="badge badge-pill badge-light-success mr-1">{{ $user->status }}</span>
                </td>
            </tr>
        @empty
            <x-emptyrow>
                6
            </x-emptyrow>
        @endforelse
    </tbody>
</table>

              
                </div>
            </div>
        </section>
        <!-- <section class="app-user-list" id="buyingCustomersSection">
            <div class="card">
                <h5 class="card-header">Buying Customers</h5>
            
            </div>

            <div class="card">
                <div class="pt-0 card-datatable table-responsive">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Order Code</th>
                                <th>Customer</th>
                                <th>Sales Associates</th>
                                <th>Balance </th>
                                <th>Payment Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($customersCountTotal as $key=>$sale)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $sale->order_code }}</td>
                                    <td>{{ $sale->User()->pluck('name')->implode('') }}</td>
                                    <td>{{ $sale->customer()->pluck('customer_name')->implode('') }}</td>
                                    <td>{{ $sale->balance }}</td>
                                    <td>{{ $sale->payment_status }}</td>
                                    <td>{{ $sale->updated_at }}</td>
                                </tr>
                            @empty
                                <x-emptyrow style="color: black;">
                                    6
                                </x-emptyrow>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $customersCountTotal->links() }}
                </div>
            </div>
        </section> -->

</div>
