<div>
    <div>
        <div class="mb-2 row">
            <div class="col-md-6">
                <label for="">Search</label>
                <input wire:model.debounce.300ms="search" type="text" class="form-control"
                    placeholder="Section, Username, Activity, Action">
            </div>

            <div class="col-md-3">
                <label for="">Items Per</label>
                <select wire:model="perPage" class="form-control">
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>

            <div class="col-md-3">
                <label for="">Start Date</label>
                <input wire:model="startDate" type="date" class="form-control">
            </div>

            <div class="col-md-3">
                <label for="">End Date</label>
                <input wire:model="endDate" type="date" class="form-control">
            </div>

            <div class="col-md-3">
                <label for="select-country">Users</label>
                <select wire:model="userCode" class="form-control">
                    <option value="">Select User</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->user_code }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="select-country">Activities Export</label>
                <button type="button" class="form-control btn btn-icon btn-outline-success" wire:click="export"
                    wire:loading.attr="disabled" data-toggle="tooltip" data-placement="top" title="Export Excel">
                    Export
                </button>
            </div>
        </div>
    </div>

    <div class="card card-default">
        <div class="card-body">
            <table class="table table-striped table-bordered" style="font-size: small">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Source</th>
                        <th>Section</th>
                        <th>User Name</th>
                        <th>Activity</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($activities as $key => $activity)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $activity->source }}</td>
                            <td>{{ $activity->section }}</td>
                            <td>{{ $activity->user->name ?? 'NA' }}</td>
                            <td>{{ Str::limit($activity->activity, 20) ?? '' }}</td>
                            <td>{!! $activity->created_at ?? now() !!}</td>
                            <td>
                                <a href="{{ route('activity.show', $activity->id) }}" style="color:#629be7">
                                    <i data-feather="eye"></i>&nbsp; View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center;"> No Record Found </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-1">{{ $activities->links() }}</div>
        </div>
    </div>
</div>
