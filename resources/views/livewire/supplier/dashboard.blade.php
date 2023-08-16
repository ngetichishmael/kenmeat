<div>
    <div class="card">
        <h5 class="card-header"></h5>
        <div class="pt-0 pb-2 d-flex justify-content-between align-items-center mx-50 row">
            <div class="col-md-4 user_role">
                <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i data-feather="search"></i></span>
                    </div>
                    <input type="text" id="fname-icon" class="form-control" name="fname-icon" placeholder="Search" />
                </div>
            </div>
            <div class="col-md-2 user_role">
                <div class="form-group">
                    <label for="selectSmall">Per Page</label>
                    <select class="form-control form-control-sm" id="selectSmall">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <div class="demo-inline-spacing">
                    <a href="{!! route('supplier.create') !!}" class="btn btn-outline-secondary">Add Supplier</a>
                    <button type="button" class="btn btn-icon btn-outline-success" wire:click="export"
                        wire:loading.attr="disabled" data-toggle="tooltip" data-placement="top" title="Export Excel">
                        <img src="{{ asset('assets/img/excel.png') }}" alt="Export Excel" width="25" height="15"
                            data-toggle="tooltip" data-placement="top" title="Export Excel">Export
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-default">
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width="1%">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone number</th>
                        <th>Date added</th>
                        <th width="18%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($suppliers as $count => $supplier)
                    <tr>
                        <td>{!! $count + 1 !!}</td>
                        <td>{!! $supplier->name !!}</td>
                        <td>{!! $supplier->email !!}</td>
                        <td>{!! $supplier->phone_number !!}</td>
                        <td>{!! date('d F, Y', strtotime($supplier->created_at)) !!}</td>

                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn btn-sm dropdown-toggle show-arrow"
                                    data-toggle="dropdown" style="background-color: #089000; color:white">
                                    <i data-feather="settings"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('supplier.edit', $supplier->id) }}">
                                        <i data-feather='edit' class="mr-50"></i>
                                        <span>Edit</span>
                                    </a>
                                    <a class="dropdown-item"
                                        href="{!! route('supplier.destroy', $supplier->id) !!}"
                                        onclick="confirm('Are you sure you want to Delete the supplier?') || event.stopImmediatePropagation()">
                                        <i data-feather="trash" class="mr-50"></i>
                                        <span>Delete</span>
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-1">{!! $suppliers->links() !!}</div>
        </div>
    </div>
    <br>
</div>
