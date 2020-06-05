$(document).ready(() => {
    $('#save').click(SaveItinerary);
    $('#sendComment').click(AddComment);
    $('#cancel').click(Cancel);
    $('.errormsg').hide();
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
              case ITINERARY_CREATE:
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
                    window.location = "./myItineraries.php";
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