<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Number</th>
            <th>Address</th>
            <th>Zone/Region</th>
            <th>Route</th>
        </tr>
    </thead>
    <tbody>
        @foreach($customers as $customer)
            <tr>
                <td>{{ $customer->customer_name }}</td>
                <td>{{ $customer->phone_number }}</td>
                <td>{{ $customer->address }}</td>
                <td>
                    @if ($customer->Area && $customer->Area->Subregion && $customer->Area->Subregion->Region)
                        {{ $customer->Area->Subregion->Region->name }}
                        @if ($customer->Area->Subregion->name)
                            , <br><i>{{ $customer->Area->Subregion->name }}</i>
                        @endif
                    @endif
                </td>
                <td>
                    {{ $customer->Area->name ?? '' }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
