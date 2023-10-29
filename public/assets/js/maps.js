
let map, activeInfoWindow, markers = [];
let markerPositions = [];
let markerCluster = [];
const colors = ['red', 'blue', 'green', 'yellow', 'purple'];
window.addEventListener("DOMContentLoaded", function () {
   let styleEl = document.createElement("style");
   let css = `
        *{
         box-sizing:border-box;
         margin:0;
         padding:0;
        }
        #app{
         position:relative;
         background-color:#eee;
         height:100vh;
         width:100vw;
        }
        .search-bar-container{
         position:absolute;
         left:10px;
         display:flex;
         flex-direction:column;
         align-items:center;
         min-width:250px;
         z-index:1000;
        }
        .input-wrapper{
         background-color:white;
         width:100%;
         border-radius:10px;
         height:2.5rem;
         padding: 0 15px;
         box-shadow: 0px 0px 8px #ddd;
         display:flex;
         align-items:center;
        }
         .input-wrapper input{
            background-color:transparent;
            border:none;
            height:100%;
            font-size:1.25rem;
            width:100%;
            margin-left:5px;
        }
        .input-wrapper input:focus{
         outline:none;
        }
        .input-wrapper #searchIcon{
         color:blue;
        }
        #map{
         position:absolute;
         height:100vh;
         width:75vw;
        }
        .result-list{
         width:100%;
         background-color:white;
         display:flex;
         flex-direction:column;
         box-shadow: 0px 0px 8px #ddd;
         border-radius:10px;
         margin-top:1rem;
         max-height:300px;
         overflow-y:scroll;
        }
        .result-list .search-result{
         padding:5px 10px;
        }
        .result-list .search-result:hover {
         background-color:#77db77;
        }
    `;
   styleEl.appendChild(document.createTextNode(css));
   document.head.appendChild(styleEl);
   userList();
});
function userList() {
   const nameList = this.document.getElementById('nameList');
   fetch('api/get/users/names')
      .then(response => response.json())
      .then(data => {
         const names = data.data;
         names.forEach(element => {
            createUserList(element, nameList);
         });

      })
      .catch(error => {
         console.error('Error fetching data:', error);
      });
}
function createUserList(element, nameList) {
   const listItem = document.createElement("div");
   listItem.setAttribute('usercode', element.user_code);
   listItem.className = "search-result";
   listItem.textContent = element.name;
   message = element.last_checking === "" ?
      `${element.name} has not checked in`
      : `${element.name} Last Checking at: ${element.last_checking}`;
   listItem.title = message;
   listItem.addEventListener('click', () => {
      getUserLocations(element.user_code);
   });
   nameList.appendChild(listItem);
}
function filterNames() {
   const input = document.getElementById('searchInput');
   const filter = input.value.toUpperCase();
   const ul = document.getElementById("nameList");
   const li = ul.getElementsByClassName('search-result');

   for (let i = 0; i < li.length; i++) {
      const txtValue = li[i].textContent || li[i].innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
         li[i].style.display = "";
      } else {
         li[i].style.display = "none";
      }
   }
}
function findUser(user_code) {
   console.log(user_code);
}
function initMap() {
   map = new google.maps.Map(document.getElementById("map"), {
      center: {
         lat: -1.292066,
         lng: 36.821945
      },
      zoom: 6,
   });

   initMarkers();
}
function initMarkers() {
   markerCluster = new MarkerClusterer(map, [], {
      imagePath: "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m",
   });
   const pinImage = new google.maps.MarkerImage(
      image.src,
      null,
      null,
      null,
      new google.maps.Size(40, 52));
   fetch('api/get/current/user/locations')
      .then(response => response.json())
      .then(data => {
         addMarkers(data, pinImage);
      })
      .catch(error => {
         console.error('Error fetching data:', error);
      });
}
function addMarkers(data, pinImage) {
   const userData = data.data;
   userData.forEach(user => {
      const marker = new google.maps.Marker({
         position: user.position,
         icon: pinImage,
         map: map,
         label: user.name
      });
      markers.push(marker);
      marker.addListener('click', () => {
         infoWindow(user, marker);
      });
      markerCluster.addMarker(marker);
   });
}
function infoWindow(user, marker) {
   if (activeInfoWindow) {
      activeInfoWindow.close();
   }
   fetch(`api/get/current/user/location/${user.id}`)
      .then(response => response.json())
      .then(data => {
         const currentLocation = data.data;
         const infowindow = infoWindowDetails(user, currentLocation);
         infowindow.open({
            anchor: marker,
            shouldFocus: false,
            map
         });
         activeInfoWindow = infowindow;
      })
      .catch(error => {
         console.error('Error fetching data:', error);
      });
}
function infoWindowDetails(user, currentLocation) {
   const infowindow = new google.maps.InfoWindow({
      content: `
         <div id="content">
            <div id="siteNotice"></div>
            <center><img src="${smallIcon}" alt="avatar" height="50" /></center>
            <h1 class="firstHeading">${user.name}</h1>
            <div id="bodyContent">
               <p><b>Location: ${currentLocation.current_gps}</b></p>
               <p><b>Name: ${user.name}</b></p>
               <p><b>Battery Level: ${currentLocation.current_battery_percentage} %</b></p>
               <p><b>Android Version: ${currentLocation.android_version}</b></p>
               <p><b>IMEI: ${currentLocation.IMEI}</b></p>
               <p><b>Time: ${getFormattedDate(currentLocation.created_at)}</b></p>
               <p><b>More info: </b><a href="/users/${user.user_code}/edit">${user.name}</a></p>
            </div>
         </div>
      `
   });
   return infowindow;
}

function getFormattedDate(dateString) {
   const date = new Date(dateString);
   const year = date.getFullYear();
   const month = String(date.getMonth() + 1).padStart(2, '0');
   const day = String(date.getDate()).padStart(2, '0');
   const hours = String(date.getHours()).padStart(2, '0');
   const minutes = String(date.getMinutes()).padStart(2, '0');
   const seconds = String(date.getSeconds()).padStart(2, '0');
   const formattedDate = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
   return formattedDate;
}
function getUserLocations(user_code) {
   markers.forEach(marker => marker.setMap(null));
   markerCluster.clearMarkers();
   markers = [];
   markerPositions = [];
   fetch(`api/get/current/user/locations/${encodeURIComponent(user_code)}`).
      then(response => response.json())
      .then(data => {
         const locations = data.data;
         mapOutUser(locations, markers, markerPositions);
      })
      .catch(error => {
         console.error('Error fetching data:', error);
      });
}
function mapOutUser(locations, markers, markerPositions) {
   locations.forEach((location, index) => {
      const marker = iconMarker(location, index)
      markers.push(marker);
      markerPositions.push(marker.position);
      addWayPoints(markerPositions);
      map.panTo(marker.position);
      map.setZoom(15);
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
function iconMarker(location, index) {
   return new google.maps.Marker({
      position: {
         lat: location.position.lat,
         lng: location.position.lng
      },
      map: map,
      size: 500,
      label: `${location.name}: ${index}`,
      icon: getIcon(colors[index % colors.length].toLowerCase()),
   });
}
function addWayPoints(markerPositions) {
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

      directionsService.route(request, function (result, status) {
         if (status === google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(result);
         }
      });
   }
}
function infoWindowLocation(location) {
   const infowindow = new google.maps.InfoWindow({
      content: `
         <div id="content">
            <div id="siteNotice"></div>
            <center><img src="${smallIcon}" alt="avatar" height="50" /></center>
            <h1 class="firstHeading">${location.name}</h1>
            <div id="bodyContent">
               <p><b>Location: ${currentLocation.current_gps}</b></p>
               <p><b>Name: ${user.name}</b></p>
               <p><b>Battery Level: ${currentLocation.current_battery_percentage} %</b></p>
               <p><b>Android Version: ${currentLocation.android_version}</b></p>
               <p><b>IMEI: ${currentLocation.IMEI}</b></p>
               <p><b>Time: ${getFormattedDate(currentLocation.created_at)}</b></p>
               <p><b>More info: </b><a href="/users/${user.user_code}/edit">${user.name}</a></p>
            </div>
         </div>
      `
   });
   return infowindow;
}
