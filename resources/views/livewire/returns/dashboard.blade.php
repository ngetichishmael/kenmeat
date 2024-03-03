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
        </div>
    </div>

    <div class="card card-default">
        <div class="card-body">
            <div class="card-datatable">
                <table class="table table-striped table-bordered zero-configuration table-responsive">
                    <thead>
                        <th width="1%">#</th>
                        <th>Customer</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @forelse ($returns as $key => $return)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $return->customer->customer_name ?? '' }}</td>
                                <td>{{ $return->created_at }}</td>
                                <td>
                                    <a href="{{ route('returns.customer', ['customerId' => $return->customer_id]) }}" class="btn btn-sm" style="color:white;background-color:rgb(202, 50, 50)">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No returns available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{ $returns->links() }}
    </div>
    <br>
</div>
