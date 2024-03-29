@php
    use Illuminate\Support\Str;
@endphp
<div>
<div class="card">
            <h5 class="card-header"></h5>
            <div class="pt-0 pb-2 d-flex justify-content-between align-items-center mx-50 row">
                <div class="col-md-3 user_role">
                    <div class="input-group input-group-merge">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i data-feather="search"></i></span>
                        </div>
                        <input wire:model="search" type="text" id="fname-icon" class="form-control" name="fname-icon" placeholder="Search" />
                    </div>
                </div>
                <div class="col-md-1 user_role">
                    <div class="form-group">
                        <label for="selectSmall">Per Page</label>
                        <select wire:model="perPage" class="form-control form-control-sm" id="selectSmall">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
           <div class="form-group">
               <label for="validationTooltip01">Start Date</label>
               <input wire:model="start" name="startDate" type="date" class="form-control" id="validationTooltip01"
                   placeholder="YYYY-MM-DD HH:MM" required />
           </div>
       </div>
       <div class="col-md-2">
           <div class="form-group">
               <label for="validationTooltip01">End Date</label>
               <input wire:model="end" name="startDate" type="date" class="form-control" id="validationTooltip01"
                   placeholder="YYYY-MM-DD HH:MM" required />
           </div>
       </div>

       <div class="col-md-2">
            <button type="button" class="btn btn-icon btn-outline-success" wire:click="export"
                wire:loading.attr="disabled" data-toggle="tooltip" data-placement="top" title="Export Excel">
                <img src="{{ asset('assets/img/excel.png') }}"alt="Export Excel" width="25" height="15"
                    data-toggle="tooltip" data-placement="top" title="Export Excel">Export
            </button>
        </div>
             
            </div>
        </div>


    <div class="card card-default">
        <div class="card-body">
            <div class="card-datatable">
                <table class="table table-striped table-bordered zero-configuration table-responsive">
                    <thead>
                        <th width="1%">#OrderID</th>
                        <th>Customer</th>
                        <th>Sales Person</th>
                        <th>Amount (Ksh.)</th>
                        <th>Payment</th> 
                        <th>Date</th>
                      
                        <th>Actions</th>
                    </thead>
                    <tbody>
                    @forelse ($pendingorders as $count => $order)
                            <tr>
                                <td>{{ $order->order_code }}</td>
                                <td title="{{ $order->Customer->customer_name ?? null }}">
                                    {{ Str::limit($order->Customer->customer_name ?? null, 30) }}</td>
                                <td title="{{ $order->User->name ?? null }}">
                                    {{ Str::limit($order->User->name ?? null, 20) }}</td>
                                <td>{{ number_format($order->price_total) }}</td>
                                <td>
                                    @if ($order->payment_status === 'PAID')
                                        <span class="badge badge-pill badge-light-success mr-1">{{ $order->payment_status ?? '' }}</span>
                                    @else
                                        <span class="badge badge-pill badge-light-warning mr-1">{{ $order->payment_status ?? '' }}</span>
                                    @endif
                                </td>
                                <td>{{ $order->created_at->format('Y-m-d h:i A') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-sm dropdown-toggle show-arrow" data-toggle="dropdown"
                                            style="background-color: #089000; color:white">
                                            <i data-feather="settings"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{!! route('orders.details', $order->order_code) !!}">
                                                <i data-feather="eye" class="mr-50"></i>
                                                <span>View</span>
                                            </a>

                                            @if ($order->order_status === 'CANCELLED')
                                                <a wire:click.prevent="activate({{ $order->id }})"
                                                    onclick="confirm('Are you sure you want to REINSTATE this Order by id {{ $order->order_code }}?')||event.stopImmediatePropagation()"
                                                    class="dropdown-item">
                                                    <i data-feather='check-circle' class="mr-50"></i>
                                                    <span>Reinstate</span>
                                                </a>
                                            @else
                                                <a wire:click.prevent="deactivate({{ $order->id }})"
                                                    onclick="confirm('Are you sure you want to CANCEL this Order {{ $order->order_code }}?')||event.stopImmediatePropagation()"
                                                    class="dropdown-item">
                                                    <i data-feather='x-circle' class="mr-50"></i>
                                                    <span>Cancel</span>
                                                </a>
                                            @endif

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No pending orders available.</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
            {!! $pendingorders->links() !!}
        </div>
    </div>
    <br>
    @section('scripts')
    @endsection
