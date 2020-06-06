$(document).ready(() => {
    InitMap();
    $('.errormsg').hide();
    $('#createItinerary').click(CreateItinerary);   
    $('#cancel').click(Cancel);   
});
/* @var array Array with all waypoints's info */
var waypoints = [];

var formData;
/**
 * @brief Create an itinerary on form submit
 * 
 * @param {*} event 
 * 
 * @return void
 */
function CreateItinerary(event) {
    if (event) {
        event.preventDefault();
    }
    // init
    let title = $("#title").val();
    let country = $("#startCountry option:selected").attr("id");
    let description = $("#description").val();
    let duration = $("#duration").val();
    let distance = $("#distance").val();
    let itineraryImages = $("#itineraryImages").prop('files').length > 0 ? $('#itineraryImages').prop('files')[0] : null;
    
    let fWaypointsArray = [];
    //Array with fWaypoint format 
    for(let i = 0; i<=waypoints.length-1;i++){
      fWaypointsArray.push({
        "Index" : i+1, 
        "Address" : waypoints[i].street + ", "+ waypoints[i].adminArea5 + ", " + waypoints[i].adminArea3 + " " + waypoints[i].postalCode + " " + waypoints[i].adminArea1, 
        "Longitude" : waypoints[i].latLng.lng,
        "Latitude" : waypoints[i].latLng.lat
      });
    }
    //Create data to send
    formData = new FormData();
    formData.append("title", title);
    formData.append("country", country);
    formData.append("description", description);
    formData.append("duration", duration);
    formData.append("distance", distance);
    formData.append("media[]", itineraryImages);
    formData.append("waypoints", JSON.stringify(fWaypointsArray));
    

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

    if(distance.length == 0){
      $("#distance").css("border-color", "red");
      $("#distance").focus();
      return;
    } else{
      $("#distance").css("border-color", "");
    }

    if(waypoints.length < 2){
      $("#mapItinerary").css("border-color", "red");
      alert("Veuillez placer votre itinéraire");
      return;
    } else{
      $("#mapItinerary").css("border-color", "");
    }
    
    const cnv = document.querySelector('#canvasPreview');
    const ctx = cnv.getContext('2d');
    const dv = document.querySelector('#mapItinerary');
    const html = dv.innerHTML;
    var map = document.getElementById("mapItinerary").getBoundingClientRect();
    render_html_to_canvas(html, ctx, map.x, map.y, 800, 630);
    
    setTimeout(ajaxCreateItinerary, 5000, formData);
}
/**
 * @brief Ajax call to send all the formData 
 * 
 * @param {*} formData Form data with all field value
 * 
 * @return void
 */
function ajaxCreateItinerary(formData)
{
  const cnv = document.querySelector('#canvasPreview');
  var dataURL = cnv.toDataURL();
  formData.append("itineraryPreview", dataURL);

  $.ajax({
    method: 'POST',
    url: './app/api/createItinerary.php',
    data: formData,
    dataType: 'json',
    contentType: false,
    processData: false,

    success: function(data){
        switch(data.ReturnCode){
            case ITINERARY_CREATE :
                window.location = "./myItineraries.php";
                break;
            case ITINERARY_CREATE_FAIL: 
                $('#errorCreate').show().delay(3000).fadeOut(1000);
            break;
            case ITINERARY_DISTANCE_NOT_VALID:
                $('#errorDistance').show().delay(3000).fadeOut(1000);
                break;
            default:
                alert("-");
                break;
        }
    },

    error: function (jqXHR){
        error = "Error :";
        switch(jqXHR.status){
            case INVALID_JSON : 
                error = error + jqXHR.status + "invalid json";
            break;
            case FILE_NOT_FOUND :
                error = error + jqXHR.status + "Can't find login.php";
            break;
        }
        alert(error);
    }
});

}

/**
 * @brief Init the map where the user can place his itinerary
 * 
 * @return void
 */
function InitMap(){
    L.mapquest.key = 'xTHtqDgrfGDrRKxzBKyFtDdkqRS4Uu8V';
    
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

      //When marker moove
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
/**
 * @brief Cancel the form 
 * 
 * @param {*} event 
 * 
 * @return void
 */
function Cancel(event){
  if (event) {
    event.preventDefault();
  }
  window.location = "./index.php";
}