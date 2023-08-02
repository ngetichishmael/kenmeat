<div>
    <style>
        #map-container {
            display: flex;
            background-color: #ffffff;
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
    <style>
    /* Style for the customer list */
    #customer-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    /* Style for each customer item */
    .customer-item {
        padding: 5px;
        padding-left: 10px;
        border-bottom: 1px solid #ccc;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .customer-item:hover {
        background-color: #f2f2f2;
    }

    /* Style for the customer list container */
    #customer-list-container {
        max-height: 800px; /* Adjust this value to set the maximum height of the customer list */
        max-width: 200px;
        overflow-y: auto;
    }

    #toggleButton {
        float: right;
        margin-top: 5px;
    }

    #customer-counter {
        float: right;
        margin-top: 12px;
        margin-right: 10px;
        font-size: 14px;
    }
</style>
    <!-- <button id="toggleButton" class="btn btn-primary">Toggle List</button> -->
    <!-- Add a date picker or any other method to set the date -->
    <!-- <input id="datePicker" type="date" wire:change="setDate($event.target.value)"> -->


    <div class="card">
        <h5 class="card-header">Search Filter</h5>
        <div id="map-container">
            <div id="customer-list-container" style="none">
                <div style="position: relative; background-color: transparent;" class="ml-2">
                    <div class="form-group" style="padding:8px">
                         <input wire:model="search" id="search-input" class="form-control form-control-sm" type="text" placeholder="Search customer" />

                        <!-- <span id="customer-counter"></span> -->
                    </div>

                    <br>

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

                </div>
                <div id="customer-counter">Total: {{ count($markersByTitle) }}</div>
            </div>
            <div wire:ignore id="map" style="width: 100%; height: 800px;"></div>
        </div>


    </div>
    <script defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap">
    </script>
    <!-- JavaScript code -->
    @include('livewire.maps.agents.scripts')
</div>
