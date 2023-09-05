<table id="data-table-default" class="table table-striped table-bordered" style="padding-left: 6%; padding-right: 5%;">
    <thead>
        <tr>
            <th width="1%">#</th>
            <th>Account Types</th>
            <th width="20%">Number of Users</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($groups as $group => $count)
            <tr>
                <td>{!! $counting++ !!}</td>
                <td>{!! $group !!}</td>
                <td>{{ $count }}</td>
                <td>
                    <div class="d-flex" style="gap:10px">
                        @if ($group == 'Admin')
                            <a href="{{ route('users.admin') }}" class="btn btn-success btn-sm">View</a>
                        @elseif($group == 'Account Manager')
                            <a href="{{ route('users.ac') }}" class="btn btn-success btn-sm">View</a>
                        @elseif($group == 'Manager')
                            <a href="{{ route('rsm') }}" class="btn btn-success btn-sm">View </a>
                        @elseif($group == 'Sales')
                            <a href="{{ route('tsr') }}" class="btn btn-success btn-sm">View </a>
                        @elseif($group == 'HR')
                            <a href="{{ route('hr') }}" class="btn btn-success btn-sm">View </a>
                        @elseif($group == 'Merchandiser')
                            <a href="{{ route('Merchandizer') }}" class="btn btn-success btn-sm">View</a>
                        @elseif($group == 'GT Sales')
                            <a href="{{ route('GTSales') }}" class="btn btn-success btn-sm">View</a>
                        @elseif($group == 'Horeca Sales')
                            <a href="{{ route('HorecaSales') }}" class="btn btn-success btn-sm">View</a>
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
