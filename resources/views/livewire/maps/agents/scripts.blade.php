    <script>
        const baseUrl = "{{ url('/') }}";
        let selectedDate = null;
        let map, activeInfoWindow, markers = [];
        let markerPositions = [];

        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        // Define the numbers array
        const numbers = [];
        for (let i = 1; i <= 25; i++) {
            numbers.push(i.toString());
        }
        const colors = ['red', 'blue', 'green', 'yellow', 'purple'];

        // Define the colors array
        //   const colors = [];
        //   for (let i = 0; i < 25; i++) {
        //       colors.push(getRandomColor());
        //   }

        // Create an array of objects with number-label and color properties
        const data = [];
        for (let i = 0; i < 25; i++) {
            data.push({
                number: numbers[i].toString(), // Convert the number to a string for the label
                color: colors[i],
            });
        }
        // Define the numbers and colors arrays
        //   const numbers = ['1', '2', '3', '4', '5']; // Add more numbers as needed
        //   const colors = ['red', 'blue', 'green', 'yellow', 'purple']; // Add more colors as needed


        // Set the default value of selectedDate to today's date
        document.addEventListener('DOMContentLoaded', function(event) {
            const today = new Date().toISOString().slice(0, 10);
            document.getElementById('datePicker').value = today;
            selectedDate = today;
        });

        const toggleButton = document.getElementById('toggleButton');
        const customerListContainer = document.getElementById('customer-list-container');

        const stand = toggleButton.addEventListener('click', function() {
            const displayStyle = customerListContainer.style.display;
            customerListContainer.style.display = (displayStyle === 'none') ? 'block' : 'none';
            console.log(displayStyle);
        });

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: {
                    lat: -1.292066,
                    lng: 36.821945
                },
                zoom: 12,
                mapTypeId: '{{ $typeMap }}'
            });

            initMarkers();
        }

        function initMarkers() {
            const initialMarkers = <?php echo json_encode($initialMarkers); ?>;
            const pinImage = new google.maps.MarkerImage("{{ asset('app-assets/images/pin.png') }}", null,
                null, null,
                new google.maps.Size(40, 52));

            initialMarkers.forEach((markerData, index) => {
                const marker = new google.maps.Marker({
                    position: markerData.position,
                    icon: pinImage,
                    map: map,
                    label: markerData.PlotNumber
                });
                markers.push(marker);

                const infowindow = new google.maps.InfoWindow({
                    content: `
                    <div id="content">
                     <div id="siteNotice"> </div>
                     <img src="{{ asset('app-assets/images/logo2.jpeg') }}" alt="avatar" height="50" />
                     <h1 id="firstHeading" class="firstHeading">${markerData.title}</h1>
                     <div id="bodyContent">
                        <p><b>Location: </b>${markerData.position.lat}, ${markerData.position.lng}</p>
                        <p><b>Name: </b>${markerData.title}</p>
                        <p><b>Battery Level: </b>${markerData.battery}</p>
                        <p><b>Android Version: </b>${markerData.android_version}</p>
                        <p><b>IMEI: </b>${markerData.IMEI}</p>
                        <p><b>Time: </b>${markerData.description}</p>
                        <p><b>More info: </b><a href="{{ URL('/users/${markerData.user_code}/edit') }}">${markerData.title}</a></p>
                        </div>
                     </div>
                     `
                });

                marker.addListener("click", () => {
                    if (activeInfoWindow) {
                        activeInfoWindow.close();
                    }
                    infowindow.open({
                        anchor: marker,
                        shouldFocus: false,
                        map
                    });
                    activeInfoWindow = infowindow;
                });


            });
        }

        function getIcon(color) {
            return {
                url: `https://maps.google.com/mapfiles/ms/icons/${color}-dot.png`,
                scaledSize: new google.maps.Size(50, 50),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(0, 0)
            };
        }

        function initMarker(data) {
            // Close any existing active info window
            if (activeInfoWindow) {
                activeInfoWindow.close();
            }

            // Remove existing markers and routes from the map
            markers.forEach(marker => marker.setMap(null));
            markers = [];
            markerPositions = []; // Clear the markerPositions array

            // Plot new markers on the map and create info window for each marker
            data.forEach((markerData, index) => {
                const marker = new google.maps.Marker({
                    position: {
                        lat: markerData.lat,
                        lng: markerData.lng
                    },
                    map: map,
                    size: 500,
                    label: numbers[index % numbers.length],
                    icon: getIcon(colors[index % colors.length].toLowerCase()),
                });
                markers.push(marker);

                // Update the markerPositions array with the new marker position
                markerPositions.push(marker.position);

                const infowindow = new google.maps.InfoWindow({
                    content: `
                <div id="content">
                  <div id="siteNotice"> </div>
                <img src="{{ asset('app-assets/images/logo2.jpeg') }}" alt="avatar" height="50" />
                <h1 id="firstHeading" class="firstHeading">${markerData.title}</h1>
                <div id="bodyContent">
                  <p><b>Location: </b>${markerData.lat}, ${markerData.lng}</p>
                  <p><b>Name: </b>${markerData.title}</p>
                  <p><b>Battery Level: </b>${markerData.battery}</p>
                  <p><b>Android Version: </b>${markerData.android_version}</p>
                  <p><b>IMEI: </b>${markerData.IMEI}</p>
                  <p><b>Time: </b>${markerData.description}</p>
                  <p><b>More info: </b>
                     <a href="{{ URL('/users/${markerData.user_code}/edit') }}">${markerData.title}</a>
                  </p>
               </div>
               </div>
            `
                });

                marker.addListener("click", () => {
                    if (activeInfoWindow) {
                        activeInfoWindow.close();
                    }
                    infowindow.open({
                        anchor: marker,
                        shouldFocus: false,
                        map
                    });
                    activeInfoWindow = infowindow;
                    map.panTo(marker.position);
                    map.setZoom(15);
                });
            });

            // Draw routes for markers if we have more than one marker
            if (markerPositions.length > 1) {
                const directionsService = new google.maps.DirectionsService();
                const directionsDisplay = new google.maps.DirectionsRenderer({
                    suppressMarkers: true,
                    preserveViewport: true,
                    map: map
                });

                const waypoints = markerPositions.slice(1, -1).map(position => ({
                    location: position,
                    stopover: true
                }));

                const request = {
                    origin: markerPositions[0],
                    destination: markerPositions[markerPositions.length - 1],
                    waypoints: waypoints,
                    travelMode: google.maps.TravelMode.DRIVING
                };

                directionsService.route(request, function(result, status) {
                    if (status === google.maps.DirectionsStatus.OK) {
                        directionsDisplay.setDirections(result);
                    }
                });
            }
        }
        //   const userCode = item.getAttribute('data-userCode');
        // JavaScript event listener to handle clicks on user list items
        document.addEventListener('livewire:load', function() {
            // Handle clicks on user list items
            const customerItems = document.querySelectorAll('.customer-item');
            customerItems.forEach(item => {
                item.addEventListener('click', function() {
                    const latitude = parseFloat(item.getAttribute('data-latitude'));
                    const longitude = parseFloat(item.getAttribute('data-longitude'));
                    map.setCenter({
                        lat: latitude,
                        lng: longitude
                    });
                    map.setZoom(10);

                    // Fetch marker data for the selected userCode
                    const userCode = item.getAttribute('data-userCode');
                    fetch(
                            `${baseUrl}/api/getMarkers/${encodeURIComponent(userCode)}/${encodeURIComponent(selectedDate)}`
                        )
                        .then(response => response.json())
                        .then(data => {
                            initMarker(data);
                        })
                        .catch(error => {
                            console.error('Error fetching data:', error);
                        });
                });
            });
        });
    </script>
