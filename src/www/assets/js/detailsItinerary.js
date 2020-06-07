$(document).ready(() => {
    InitMap();
    $('#save').click(SaveItinerary);
    $('#sendComment').click(AddComment);
    $('#rate').click(AddRate);
    $('#cancel').click(Cancel);
    $('.errormsg').hide();
    $('.succesmsg').hide();
    $('#btnModal').click(DisableItinerary);
    // Set modal settings
    $('#modalDisable').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)         
        var type = button.data('type')
        $('#modalDisable').modal('show')
        if (type == "delete") {
            var nickname = button.data('nickname') 
            var modal = $(this)
            modal.find('.modal-title').text('Are you sure you want to disable this itinerary')
            modal.find('.modal-body').text('Disable the itinerary : ' + $("#title").val())
            $('#btnModal').attr('name', 'deleteItinerary');
        }
    });
});
/* @var array Array with all waypoints's info */
var waypoints = [];

var formData;
/**
 * @brief Save itinerary's details change
 * 
 * @param {*} event 
 */
function SaveItinerary(event) {
    if (event) {
        event.preventDefault();
    }
    // init
    let itineraryId = $("#itineraryId").val();
    let title = $("#title").val();
    let description = $("#description").val();
    let country = $("#itineraryCountry option:selected").attr("id");  
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
    formData.append("itineraryId", itineraryId);
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
    
    $.ajax({
      method: 'POST',
      url: './app/api/updateItinerary.php',
      data: formData,
      dataType: 'json',
      contentType: false,
      processData: false,

      success: function(data){
          switch(data.ReturnCode){
              case ITINERARY_UPDATE:
                  window.location = "./myItineraries.php";
                  break;
              case ITINERARY_UPDATE_FAIL: 
                  $('#errorUpdate').show().delay(3000).fadeOut(1000);
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
              case INVALID_JSON: 
                  error = error + jqXHR.status + "invalid json";
              break;
              case FILE_NOT_FOUND:
                  error = error + jqXHR.status + "Can't find createItinerary.php";
              break;
          }
          alert(error);
      }
  });
}
/**
 * @brief Add a comment to an itinerary
 * 
 * @param {*} event 
 * 
 * @return void
 */
function AddComment(event) {
    if (event) {
        event.preventDefault();
    }
    //Send title to use php function "GetByTitle" after because title's unique
    let title = $("#title").val();

    let comment = $("#comment").val();

    formData = new FormData();
    formData.append("title", title);
    formData.append("comment", comment);

    if (comment.length == 0) {
        $("#comment").css("border-color", "red");
        $("#comment").focus();
        return;
    } else {
        $("#comment").css("border-color", "");
    }

    $.ajax({
        method: 'POST',
        url: './app/api/addComment.php',
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
  
        success: function(data){
            switch(data.ReturnCode){
                case COMMENT_ADDED:
                    $('#CommentAdded').show().delay(3000).fadeOut(1000);
                    break;
                case COMMENT_ADD_FAIL: 
                    $('#errorComment').show().delay(3000).fadeOut(1000);
                break;
                default:
                    alert("-");
                    break;
            }
        },
  
        error: function (jqXHR){
            error = "Error :";
            switch(jqXHR.status){
                case INVALID_JSON: 
                    error = error + jqXHR.status + "invalid json";
                break;
                case FILE_NOT_FOUND:
                    error = error + jqXHR.status + "Can't find createItinerary.php";
                break;
            }
            alert(error);
        }
    });
}
/**
 * @brief Add a rate to an itinerary
 * 
 * @param {*} event 
 * 
 * @return void
 */
function AddRate(event) {
    if (event) {
        event.preventDefault();
    }
     //Send title to use php function "GetByTitle" after because title's unique
    let title = $("#title").val();

    let rate = $("#rating").val();

    formData = new FormData();
    formData.append("title", title);
    formData.append("rate", rate);

    if (rate.length == 0) {
        $("#comment").css("border-color", "red");
        $("#comment").focus();
        return;
    } else {
        $("#comment").css("border-color", "");
    }

    $.ajax({
        method: 'POST',
        url: './app/api/addRate.php',
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
  
        success: function(data){
            switch(data.ReturnCode){
                case RATE_ADDED:
                    $('#RateAdded').show().delay(3000).fadeOut(1000);
                    break;
                case RATE_ADD_FAIL: 
                    $('#errorRate').show().delay(3000).fadeOut(1000);
                break;
                case RATE_NOT_VALID:
                    $('#errorRateValid').show().delay(3000).fadeOut(1000);
                    break;
                default:
                    alert("-");
                    break;
            }
        },
  
        error: function (jqXHR){
            error = "Error :";
            switch(jqXHR.status){
                case INVALID_JSON: 
                    error = error + jqXHR.status + "invalid json";
                break;
                case FILE_NOT_FOUND:
                    error = error + jqXHR.status + "Can't find createItinerary.php";
                break;
            }
            alert(error);
        }
    });
}
/**
 * @brief Init the map where the user can modify his itinerary
 * 
 * @return void
 */
function InitMap(){
    L.mapquest.key = 'xTHtqDgrfGDrRKxzBKyFtDdkqRS4Uu8V';
    
    $.getJSON('./app/api/getItineraryById.php?id=' + $('#itineraryId').val(), function(data) {
        var mapInit = [];
        var waypointsArray = [];
        var map = L.mapquest.map('mapItinerary', {
            center: [data.Waypoints[0].Latitude, data.Waypoints[0].Longitude],
            layers: L.mapquest.tileLayer('map'),
            zoom: 13,
            zoomControl: false
          });
          mapInit.push({     
            start: data.Waypoints[0].Address,
            end: data.Waypoints[data.Waypoints.length - 1].Address                                                          
          });
          /*Add waypoints in array */
          for(let i = 1; i< data.Waypoints.length-1 ; i++){
            waypointsArray.push(data.Waypoints[i].Latitude + ', ' + data.Waypoints[i].Longitude);
            }
        if(waypointsArray.length > 0){
            mapInit[0].waypoints = waypointsArray;
        }
          L.control.zoom({
            position: 'topright'
          }).addTo(map);
    
          L.mapquest.directionsControl({
            routeSummary: {
              enabled: false
            },
            narrativeControl: {
              enabled: false,
              compactResults: false
            },
            startInput:{
                compactResults: true,
                disabled: false,
                location: data.Waypoints[0].Address,
                placeholderText: 'Starting point or click on the map...',
                geolocation: {
                  enabled: true
                }
            },
            endInput:{
                compactResults: true,
                disabled: false,
                location: data.Waypoints[data.Waypoints.length - 1].Address,
                placeholderText: 'Destination',
                geolocation: {
                    enabled: true
                }
            }
          }).addTo(map);
            //console.log(L.mapquest.directions().route(mapInit[0]));           
            L.mapquest.directions().route(mapInit[0]);
    
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
    });
    
    
}
/**
 * @brief Disable the itinerary
 * 
 * @param {*} event 
 * 
 * @return void
 */
function DisableItinerary(event){
    if (event){
        event.preventDefault();
    }

    let idItinerary = $("#itineraryId").val();
    let title = $("#title").val();

    //Create data to send
    formData = new FormData();
    formData.append("itineraryId", idItinerary);
    formData.append("title", title);

    
    $.ajax({
        method: 'POST',
        url: './app/api/disableItinerary.php',
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
  
        success: function(data){
            switch(data.ReturnCode){
                case ITINERARY_DISABLED:
                    window.location = "./index.php";
                    break;
                case DISABLE_ITINERARY_FAIL: 
                    $('#errorDisable').show().delay(3000).fadeOut(1000);
                break;
                default:
                    alert("-");
                    break;
            }
        },
  
        error: function (jqXHR){
            error = "Error :";
            switch(jqXHR.status){
                case INVALID_JSON: 
                    error = error + jqXHR.status + "invalid json";
                break;
                case FILE_NOT_FOUND:
                    error = error + jqXHR.status + "Can't find createItinerary.php";
                break;
            }
            alert(error);
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