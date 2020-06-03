$(document).ready(() => {
    InitMap();
    $('.errormsg').hide();
    $('#placeItinerary').click(CheckItinerary);   
});

/**
 * @brief Check if field are good
 * 
 * @param {*} event 
 */
function CheckItinerary(event) {
    if (event) {
        event.preventDefault();
    }
    // init
    let title = $("#title").val();
    let country = $("#startCountry option:selected").text();
    let description = $("#description").val();
    let duration = $("#duration").val();

    if (title.length == 0) {
        $("#title").css("border-color", "red");
        $("#title").focus();
        return;
    } else {
        $("#title").css("border-color", "");
    }
    
    if (description.length == 0) {
        $("#description").css("border-color", "red");
        $("#description").focus();
        return;
    } else {
        $("#description").css("border-color", "");
    }

    if (duration.length == 0) {
        $("#duration").css("border-color", "red");
        $("#duration").focus();
        return;
    } else {
        $("#duration").css("border-color", "");
    }
    InitMap();
}
function InitMap(){
    L.mapquest.key = 'xTHtqDgrfGDrRKxzBKyFtDdkqRS4Uu8V';
    var waypoints = [];
    var map = L.mapquest.map('mapItinerary', {
        center: [46.165320, 6.072530],
        layers: L.mapquest.tileLayer('map'),
        zoom: 13,
        zoomControl: false
      });
      
      L.control.zoom({
        position: 'topright'
      }).addTo(map);

      L.mapquest.directionsControl({
        routeSummary: {
          enabled: false
        },
        narrativeControl: {
          enabled: true,
          compactResults: false
        }
      }).addTo(map);

      map.on('moveend', function(event) {
        let marker = event.target;
        for (let prop in marker._layers) {
          if (!marker._layers.hasOwnProperty(prop)) continue;
            
          //console.log(marker._layers[prop].locations);
          if(marker._layers[prop].locations != undefined){
              for(let i = 0;i<marker._layers[prop].locations.length;i++){
                waypoints[i] = marker._layers[prop].locations[i];
              }
              console.log(waypoints);
          }
          // locationIndex- I am assuming 0 for start marker and 1 for end marker.
          if (marker._layers[prop].locationIndex === 1) {
            let latLong = marker._layers[prop]._latlng;
            //console.log(latLong)
          }
        }
      });
    
}
function eventRaised(event)
{
    var lat = event.ll.getLatitude();
    var lng = event.ll.getLongitude();
    alert(lat+' '+lng);
}