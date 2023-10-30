<div>
    <div id="app">
        <div class="search-bar-container">
            <div class="input-wrapper">
                <span id="searchIcon" class="material-symbols-outlined">search</span>
                <input id="searchInput" type="text" placeholder="Search for Sales Agent" autofocus
                    onkeyup="filterNames()" />
            </div>
            <div id="nameList" class="result-list"></div>
        </div>
        <div id="map"></div>
    </div>
    <script>
        const imageUrl = "{{ asset('app-assets/images/pin.png') }}";
        const smallIcon = "{{ asset('app-assets/images/logo.png') }}";
        const image = new Image();
        image.src = imageUrl;
        const imageIcon = new Image();
        imageIcon.src = smallIcon;
    </script>
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">
    </script>
    <script defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap">
    </script>
    <script src="{{ asset('assets/js/maps.js') }}"></script>
</div>
