<div>
<div class="card">
            <h5 class="card-header"></h5>
            <div class="pt-0 pb-2 d-flex justify-content-between align-items-center mx-50 row">
                <div class="col-md-4 user_role">
                    <div class="input-group input-group-merge">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i data-feather="search"></i></span>
                        </div>
                        <input wire:model="search" type="text" id="fname-icon" class="form-control" name="fname-icon" placeholder="Search" />
                    </div>
                </div>
                <div class="col-md-2 user_role">
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
       

             <div class="col-md-3">
                 <a href="{!! route('customer.create') !!}" class="btn btn-primary btn-sm"><i class="fa fa-user-plus"></i> Add a Customer</a>
                 <a href="{{ route('user-import') }}" class="btn btn-info btn-sm"><i class="fa fa-file-upload"></i> Import </a>
             </div>
             
            </div>
        </div>




    <!-- <div class="mb-1 row">
        <div class="col-md-10">
            <label for="">Search by name, route, region</label>
            <input type="text" wire:model="search" class="form-control"
                placeholder="Enter customer name, email address or phone number">
        </div>
        <div class="col-md-2">
            <label for="">Items Per</label>
            <select wire:model="perPage" class="form-control">`
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
    </div> -->

     <div class="card card-default">
        <div class="card-body">
            <div class="pt-0 card-datatable">
            <table class="table table-striped table-bordered zero-configuration table-responsive">
                    <thead>
                        <!-- <th width="1%">#</th> -->
                        <th>Name</th>
                        <th>number</th>
                        <th width="15%">Address</th>
                        <th>Zone/Region</th>
                        
                        <th>Route</th>
                        <th>Created By</th>
                        <!-- <th>Status</th> -->
                        <th>Action</th>
                        <!-- <th>Order</th>
                        <th width="15%">Edit</th>
                        <th width="15%">Action</th> -->
                    </thead>
                    <tbody>
                        @foreach ($contacts as $count => $contact)
                            <!-- <td>{!! $count + 1 !!}</td> -->
                            <td>
                                {!! $contact->customer_name !!} <br>
                                @if ($contact->approval === 'Approved')
                                <span class="badge badge-pill badge-light-success mr-1">Approved</span>
                                @else
                                    <span class="badge badge-pill badge-light-warning mr-1">Pending</span>
                                @endif
                            </td>
                            <td>{!! $contact->phone_number !!}</td>
                            <td>
                                {{ $contact->address }}
                            </td>
                            <td>
                                @if ($contact->Area && $contact->Area->Subregion && $contact->Area->Subregion->Region)
                                    {!! $contact->Area->Subregion->Region->name !!}
                                    @if ($contact->Area->Subregion->name)
                                    , <br><i>{!! $contact->Area->Subregion->name !!}</i>
                                    @endif
                                @endif
                            </td>

                         
                            <td>
                                {!! $contact->Area->name ?? '' !!}
                            </td>
                            <td>
                                {!! $contact->Creator->name ?? '' !!}
                            </td>

                            <!-- <td>
                            @if ($contact->approval === 'Approved')
                                <span class="badge badge-pill badge-light-success mr-1">Approved</span>
                            @else
                                <span class="badge badge-pill badge-light-warning mr-1">Pending</span>
                            @endif
                            </td> -->
                            
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm dropdown-toggle show-arrow " data-toggle="dropdown" style="background-color: #089000; color:white" >
                                    <i data-feather="eye"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('make.orders', ['id' => $contact->id]) }}">
                                            <i data-feather="eye" class="mr-50"></i>
                                            <span>Order</span>
                                        </a>
                                        <a class="dropdown-item" href="{{ route('customer.edit', $contact->id) }}">
                                            <i data-feather='edit' class="mr-50"></i>
                                            <span>Edit</span>
                                        </a>
                                        @if ($contact->approval === 'Approved')
                                            <a wire:click.prevent="deactivate({{ $contact->id }})"
                                                onclick="confirm('Are you sure you want to DEACTIVATE this user?')||event.stopImmediatePropagation()"
                                                class="dropdown-item">
                                                <i data-feather='check-circle' class="mr-50"></i>
                                                <span>Disapprove</span>
                                            </a>
                                        @else
                                            <a wire:click.prevent="activate({{ $contact->id }})"
                                                onclick="confirm('Are you sure you want to ACTIVATE this customer?')||event.stopImmediatePropagation()"
                                                class="dropdown-item">
                                                <i data-feather='x-circle' class="mr-50"></i>
                                                <span>Approve</span>
                                            </a>
                                        @endif
                                        <!-- <a class="dropdown-item" wire:click.prevent="destroy({{ $contact->id }})"
                                            onclick="confirm('Are you sure you want to Delete the User?')||event.stopImmediatePropagation()">
                                            <i data-feather="trash" class="mr-50"></i>
                                            <span>Delete</span>
                                        </a> -->
                                    </div>
                                </div>
                            </td> 





<!-- 
                            <td>
                                <a href="{{ route('make.orders', ['id' => $contact->id]) }}"
                                    class="btn btn-sm btn-secondary">Order</a>
                            </td>
                            <td>
                                <a href="{{ route('customer.edit', $contact->id) }}"
                                    class="btn btn-sm btn-primary">Edit</a>
                            </td>
                            <td>
                                @if ($contact->approval === 'Approved')
                                    <button wire:click.prevent="deactivate({{ $contact->id }})"
                                        onclick="confirm('Are you sure you want to DEACTIVATE this customer?')||event.stopImmediatePropagation()"
                                        type="button" class="btn btn-success btn-sm">Approved</button>
                                @else
                                    <button wire:click.prevent="activate({{ $contact->id }})"
                                        onclick="confirm('Are you sure you want to ACTIVATE this customer?')||event.stopImmediatePropagation()"
                                        type="button" class="btn btn-danger btn-sm">Pending</button>
                                @endif
                            </td> -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-1">
                    {{ $contacts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<br>