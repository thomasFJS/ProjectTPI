/**
 *     Author              :  Fujise Thomas.
 *     Project             :  ProjetTPI.
 *     Page                :  Home.js
 *     Brief               :  Display maps on itinerary card on home page.
 *     Date                :  02.06.2020.
 */
var maps = [];
$(document).ready(function(){

    $("#itineraryFilter").click(itineraryFilter);
    L.mapquest.key = 'xTHtqDgrfGDrRKxzBKyFtDdkqRS4Uu8V';
    /* call the php that has the php array which is json_encoded */
    $.getJSON('./app/api/getAllItineraries.php', function(data) {
    
        var mapInit = [];
        var waypointsArray = [];
        /* data will hold the php array as a javascript object */
       $.each(data, function(key, val) {
            $('#map' +val.Id).attr("src", val.Preview );
            /*maps.push(L.mapquest.map('map' + val.Id, {
                center: [val.Waypoints[0].Latitude, val.Waypoints[0].Longitude],
                layers: L.mapquest.tileLayer('map'),
                zoom: 13
            }));
            mapInit.push({     
                start: val.Waypoints[key].Address,
                end: val.Waypoints[val.Waypoints.length - 1].Address                                                          
            });*/

            /*Add waypoints in array */
            /*for(let i = 1; i< val.Waypoints.length-1 ; i++){
                waypointsArray.push(val.Waypoints[i].Latitude + ', ' + val.Waypoints[i].Longitude);
            }
            if(waypointsArray.length > 0){
                mapInit[0].waypoints = waypointsArray;
            }
            console.log(mapInit[0]);*/
            //console.log(L.mapquest.directions().route(mapInit[0]));           
            //L.mapquest.directions().route(mapInit[0]);
            waypointsArray = [];
            mapInit = [];
        });
    });

});
/**
 * @brief Filter to display itinerary in a specific order
 * 
 * @param {} event 
 * 
 * @return void
 */
function itineraryFilter(event){
    if(event){
        event.preventDefault();
    }

    let country = $("#countryFilter option:selected").attr("id");
    let rateMin = $("#rateFilter option:selected").val();
    let distanceMin = $("#distanceMinFilter").val();
    let distanceMax = $("#distanceMaxFilter").val();
    let durationMin = $("#durationMinFilter").val();
    let durationMax = $("#durationMaxFilter").val();

    var formData = new FormData();
    if (country != "None") {
        formData.append("countryFilter", country);
    } 
    if(rateMin != "0"){
        formData.append("rateFilter", rateMin);
    }
    if(distanceMin != 0){
        formData.append("distanceMin", distanceMin);
    }
    if(distanceMax != 0){
        formData.append("distanceMax", distanceMax);
    }
    if(durationMin != 0){
        formData.append("durationMin", durationMin);
    }
    if(durationMax != 0){
        formData.append("durationMax", durationMax);
    }

    if($.isEmptyObject(formData)){
        return;
    }

    $.ajax({
        method: 'POST',
        url: './app/api/getAllItineraries.php',
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
    
        success: function(data){
            location.reload();
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