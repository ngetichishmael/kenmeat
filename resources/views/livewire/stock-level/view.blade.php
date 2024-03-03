<!-- resources/views/livewire/stock-level/view.blade.php -->
<div>
    <h2>Stock Levels</h2>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Stock Level</th>
                <!-- Add other columns as needed -->
            </tr>
        </thead>
        <tbody>
            @foreach($stockLevels as $level)
                <tr>
                    <td>{{ optional($level->product)->name }}</td>
                    <td>{{ $level->stock_level }}</td>
                    <!-- Add other columns as needed -->
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
