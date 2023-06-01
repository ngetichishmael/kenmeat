<div>
    <div class="card">
        <h5 class="card-header">Search Filter</h5>
        <div class="pt-0 pb-2 d-flex justify-content-between align-items-center mx-50">
            <div class="col-md-4 user_role">
                <div class="form-group">

                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">

                </div>
            </div>
            <div class="col-md-2">
            </div>
            <div class="col-md-3">
            </div>
        </div>
    </div>
    <div id="map" style="width:100%; height:800px"></div>
</div>


<script defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap">
</script>


<!-- JavaScript code -->
<script>
  let map, activeInfoWindow, markers = [];

  function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
      center: { lat: -1.292066, lng: 36.821945 },
      zoom: 12,
      mapTypeId: '{{ $typeMap }}'
    });
    map.addListener("click", mapClicked);

    initMarkers();
  }

  function initMarkers() {
    const initialMarkers = <?php echo json_encode($initialMarkers); ?>;
    const pinImage = new google.maps.MarkerImage("{{ asset('app-assets/images/pin.png') }}", null, null, null, new google.maps.Size(40, 52));

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
              <p><b>Customer Name: </b>${markerData.title}</p>
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
        markerClicked(marker, index);
      });

      marker.addListener("dragend", event => {
        markerDragEnd(event, index);
      });
    });
  }

  function mapClicked(event) {
    console.log(map);
    console.log(event.latLng.lat(), event.latLng.lng());
  }

  function markerClicked(marker, index) {
    console.log(map);
    console.log(marker.position.lat());
    console.log(marker.position.lng());
  }

  function markerDragEnd(event, index) {
    console.log(map);
    console.log(event.latLng.lat());
    console.log(event.latLng.lng());
  }
</script>

