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
    $("#itineraryFilterCancel").click(cancelFilter);
    L.mapquest.key = 'xTHtqDgrfGDrRKxzBKyFtDdkqRS4Uu8V';
    //Show maps after refresh when user use the filter   
    $('body').bind('beforeunload',function(){
        DisplayMaps();
     });
    DisplayMaps();
});
function DisplayMaps(){
    /* call the php that has the php array which is json_encoded */
    $.getJSON('./app/api/getAllItineraries.php', function(data) {
        var waypointsArray = [];
        var mapInit = [];
        /* data will hold the php array as a javascript object */
       $.each(data, function(key, val) {
            if($('#map'+val.Id).length){
                let map = L.mapquest.map('map' + val.Id, {
                    center: [val.Waypoints[0].Latitude, val.Waypoints[0].Longitude],
                    layers: L.mapquest.tileLayer('map'),
                    zoom: 8
                });
                L.marker([val.Waypoints[0].Latitude, val.Waypoints[0].Longitude], {
                    icon: L.mapquest.icons.marker({
                        primaryColor: '#03fc39',
                        secondaryColor: '#03fc39',
                        shadow: true,
                        size: 'md',
                        symbol: 'S'
                    })
                }).addTo(map);
                L.marker([val.Waypoints[val.Waypoints.length - 1].Latitude, val.Waypoints[val.Waypoints.length - 1].Longitude], {
                    icon: L.mapquest.icons.marker({
                        primaryColor: '#fc5203',
                        secondaryColor: '#fc5203',
                        shadow: true,
                        size: 'md',
                        symbol: 'E'
                    })
                }).addTo(map);
                for(let i = 1; i< val.Waypoints.length-1 ; i++){
                    L.marker([val.Waypoints[i].Latitude, val.Waypoints[i].Longitude], {
                        icon: L.mapquest.icons.marker({
                            primaryColor: '#2803fc',
                            secondaryColor: '#2803fc',
                            shadow: true,
                            size: 'md',
                            symbol: 'W'
                        })
                  }).addTo(map);
                }
                map.fitBounds([
                    [val.Waypoints[0].Latitude, val.Waypoints[0].Longitude],
                    [val.Waypoints[val.Waypoints.length - 1].Latitude, val.Waypoints[val.Waypoints.length - 1].Longitude]
                ]);
                if(waypointsArray.length > 0){
                    mapInit[0].waypoints = waypointsArray;
                }
                maps.push(map);
            
                /*mapInit.push({     
                    start: val.Waypoints[0].Address,
                    end: val.Waypoints[val.Waypoints.length - 1].Address                                                          
                });*/
            }

            /*Add waypoints in array */
            /*for(let i = 1; i< val.Waypoints.length-1 ; i++){
                waypointsArray.push(val.Waypoints[i].Latitude + ', ' + val.Waypoints[i].Longitude);
            }
            if(waypointsArray.length > 0){
                mapInit[0].waypoints = waypointsArray;
            }*/
            //console.log(mapInit[key]);
            //console.log(L.mapquest.directions().route(mapInit[0]));           
            //maps[key].directions().route(mapInit[key]).addTo(map);
            //waypointsArray = [];
            //mapInit = [];
        });
    });

}
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

function cancelFilter(event){
    if(event){
        event.preventDefault();
    }

    $.ajax({
        method: 'POST',
        url: './app/api/cancelFilter.php',
    
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