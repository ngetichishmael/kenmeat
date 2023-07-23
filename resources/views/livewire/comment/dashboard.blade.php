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
             
            </div>
        </div>


    <!-- <div class="mb-1 row">
        <div class="col-md-10">
            <label for="">Search</label>
            <input type="text" wire:model="search" class="form-control"
                placeholder="Enter customer name, Sales Agents, Date">
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
            <table class="table table-striped table-bordered">
                <thead>
                    <th width="1%">#</th>
                    <th>Customer Name</th>
                    <th>Sales Agent</th>
                    <th>Date</th>
                    <th>Comment</th>
                </thead>
                <tbody>
                    @foreach ($comments as $count => $comment)
                        <td>{{ $count + 1 }}</td>
                        <td>{{ $comment->Customer->customer_name ?? ''}}</td>
                        <td>{{ $comment->User->name ?? ''}}</td>
                        <td>{{ $comment->date }}</td>
                        <td>{{ $comment->comment }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-1">
                {{ $comments->links() }}
            </div>

        </div>
    </div>
</div>
