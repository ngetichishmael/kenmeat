<!-- resources/views/livewire/customers/print.blade.php -->
<table>
    <thead>
        <tr>
            <th>Customer Name</th>
            <th>Phone Number</th>
            <th>Address</th>
            <th>Region</th>
            <th>Subregion</th>
            <th>Area</th>
            <th>Created By</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($contacts as $contact)
        <tr>
            <td>
                {!! $contact->customer_name !!}
                @if ($contact->approval === 'Approved')
                    {{-- Add any custom content here if needed --}}
                @endif
            </td>
            <td>{!! $contact->phone_number !!}</td>
            <td>{{ $contact->address }}</td>
            <td>
                @if ($contact->Area && $contact->Area->Subregion && $contact->Area->Subregion->Region)
                    {!! $contact->Area->Subregion->Region->name !!}
                    @if ($contact->Area->Subregion->name)
                        , <br><i>{!! $contact->Area->Subregion->name !!}</i>
                    @endif
                @endif
            </td>
            <td>{!! $contact->Area->name ?? '' !!}</td>
            <td>{!! $contact->Creator->name ?? '' !!}</td>
            <td>{!! $contact->Creator->created_at ?? '' !!}</td>
        </tr>
        @endforeach
    </tbody>
</table>
