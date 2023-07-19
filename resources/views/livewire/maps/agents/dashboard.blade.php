<div>
    <style>
        #map-container {
            display: flex;
            background-color: transparent;
        }

        #customer-list-container {
            position: relative;
            width: 200px;
            background-color: transparent;
        }

        #customer-list {
            list-style: none;
            padding: 0;
            margin: 0;
            width: 250px;
            background-color: transparent;
            overflow-y: auto;
        }

        .hidden {
            display: none;
        }


        #customer-counter {
            position: absolute;
            top: 0;
            right: 0;
            background-color: #ccc;
            color: #333;
            padding: 4px 8px;
            font-size: 12px;
        }

        #search-input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }


        #map {
            flex: 1;
            width: 100%;
            height: 800px;
        }
    </style>
    <button id="toggleButton" class="btn btn-primary">Toggle List</button>
    <!-- Add a date picker or any other method to set the date -->
    <input id="datePicker" type="date" wire:change="setDate($event.target.value)">


    <div id="map-container">
        <div id="customer-list-container" style="display: block;">
            <input id="search-input" type="text" placeholder="Search">
            <ul id="customer-list">
                @foreach ($markersByTitle as $title => $markers)
                    {{-- <li class="customer-title">
                        <strong>{{ $title }}</strong>
                    </li> --}}
                    @foreach ($markers as $marker)
                        <li class="customer-item" data-latitude="{{ $marker['lat'] }}"
                            data-longitude="{{ $marker['lng'] }}" data-userCode="{{ $marker['user_code'] }}"
                            wire:click="plotMarkers('{{ $marker['user_code'] }}')">
                            <strong>{{ $marker['title'] }}</strong>
                        </li>
                    @endforeach
                @endforeach
            </ul>
            <div id="customer-counter">Total: {{ count($markersByTitle) }}</div>
        </div>
        <div wire:ignore id="map" style="width:100%; height:800px"></div>
    </div>
    <script defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap">
    </script>
    <!-- JavaScript code -->
    @include('livewire.maps.agents.scripts')
</div>
