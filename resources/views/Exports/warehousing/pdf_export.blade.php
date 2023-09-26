<!DOCTYPE html>
<html>
<head>
    <title>Warehouse PDF Export</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        td {
            font-size: 10px; /* Adjust the font size as needed */
        }

        /* Add custom styling for the table */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }

        th {
            font-size: 11px; /* Adjust the font size as needed */
            background-color: #f2f2f2;
        }

        /* Add custom styling for the header */
        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .subheader {
            text-align: center;
            margin-bottom: 8px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px; /* Adjust the font size as needed */
        }

        /* Add any other custom CSS styles here */

    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('app-assets/images/logo.png'))) }}" alt="Logo" width="100" height="40">
        </div>
    </div>
    <div class="subheader">
        <p>
            Warehouses
        </p>
    </div>
    <hr>

    <div class="body">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Region</th>
                    <th>Sub Region</th>
                    <th>Products Count</th>
                    <th>Status</th>
                    <!-- Add more table headers as needed -->
                </tr>
            </thead>
            <tbody>
                @forelse ($warehouses as $warehouse)
                    <tr>
                        <td>{{ $warehouse->name }}</td>
                        <td>{{ $warehouse->region->name }}</td>
                        <td>{{ $warehouse->subregion->name }}</td>
                        <td>{{ $warehouse->product_information_count }}</td>
                        <td>
                            @if ($warehouse->status === 'Active')
                                <span class="badge badge-pill badge-light-success">Active</span>
                            @else
                                <span class="badge badge-pill badge-light-warning">Disabled</span>
                            @endif
                        </td>
                        <!-- Add more table cells as needed -->
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No warehouses found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <hr>
    <div class="footer">
        &copy; {{ date('Y') }} Kenmeat. All rights reserved.
    </div>
</body>
</html>
