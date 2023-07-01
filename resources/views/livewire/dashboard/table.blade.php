<div class="mt-0" >

<section class="app-user-list" id="vansalesSection">
            <div class="card">
                <h5 class="card-header">Total Vansales</h5>
            
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
                            @forelse ($vansalesTotal as $key=>$sale)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $sale->order_code }}</td>
                                    <td>{{ $sale->user()->pluck('name')->implode('') }}</td>
                                    <td>{{ $sale->customer()->pluck('customer_name')->implode('') }}</td>
                                    <td>{{ $sale->balance }}</td>
                                    <td>{{ $sale->payment_status }}</td>
                                    <td>{{ $sale->updated_at }}</td>
                                </tr>
                            @empty
                                <x-emptyrow>
                                    6
                                </x-emptyrow>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $vansalesTotal->links() }}
                </div>
            </div>
        </section>
        <section class="app-user-list" id="preorderSection">
            <div class="card">
                <h5 class="card-header">Pre Order</h5>
             
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
                            @forelse ($preorderTotal as $key=>$sale)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $sale->order_code }}</td>
                                    <td>{{ $sale->user()->pluck('name')->implode('') }}</td>
                                    <td>{{ $sale->customer()->pluck('customer_name')->implode('') }}</td>
                                    <td>{{ $sale->balance }}</td>
                                    <td>{{ $sale->payment_status }}</td>
                                    <td>{{ $sale->updated_at }}</td>
                                </tr>
                            @empty
                                <x-emptyrow>
                                    6
                                </x-emptyrow>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $preorderTotal->links() }}
                </div>
            </div>
        </section>
        <section class="app-user-list" id="orderFulfillmentSection">
            <div class="card">
                <h5 class="card-header">Order Fulfilment</h5>
            
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
                            @forelse ($orderfullmentTotal as $key=>$sale)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $sale->order_code }}</td>
                                    <td>{{ $sale->user()->pluck('name')->implode('') }}</td>
                                    <td>{{ $sale->customer()->pluck('customer_name')->implode('') }}</td>
                                    <td>{{ $sale->balance }}</td>
                                    <td>{{ $sale->payment_status }}</td>
                                    <td>{{ $sale->updated_at }}</td>
                                </tr>
                            @empty
                                <x-emptyrow>
                                    6
                                </x-emptyrow>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $orderfullmentTotal->links() }}
                </div>
            </div>
        </section>
        <section class="app-user-list" id="activeUsersSection">
            <div class="card">
                <h5 class="card-header">Active Users</h5>
             
            </div>
            {{-- @dd($activeUserTotal) --}}
            <div class="card">
                <div class="pt-0 card-datatable table-responsive">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Sales Associates</th>
                                <th>Email</th>
                                <th>Status</th>
                                <!-- <th>Edit</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($activeUserTotal as $key=>$user)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $user->user()->pluck('name')->implode('') }}</td>
                                    <td>{{ $user->user()->pluck('email')->implode('') }}</td>
                                    <td>{{ $user->user()->pluck('status')->implode('') }}</td>
                                    <!-- <td>
                                        <a href="{{ route('user.edit', $user->user_code) }}"
                                            class="btn btn-primary btn-sm">Edit</a>
                                    </td> -->
                                </tr>
                            @empty
                                <x-emptyrow>
                                    6
                                </x-emptyrow>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $activeUserTotal->links() }}
                </div>
            </div>
        </section>
        <section class="app-user-list" id="visitsSection">
            <div class="card">
                <h5 class="card-header">Visits</h5>
            
            </div>

            <div class="card">
                <div class="pt-0 card-datatable table-responsive">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Sales Associates</th>
                                <th>Status</th>
                                <!-- <th>Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($visitsTotal as $key=>$user)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $user->customer()->pluck('customer_name')->implode('') }}</td>
                                    <td>{{ $user->user()->pluck('name')->implode('') }}</td>
                                    <td>{{ $user->user()->pluck('status')->implode('') }}</td>
                                    <!-- <td>
                                        <a href="{{ route('customer.edit', $user->customer_id) }}"
                                            class="btn btn-sm btn-primary">Edit</a>
                                    </td> -->
                                </tr>
                            @empty
                                <x-emptyrow>
                                    6
                                </x-emptyrow>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $visitsTotal->links() }}
                </div>
            </div>
        </section>
        <section class="app-user-list" id="buyingCustomersSection">
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
        </section>

</div>
