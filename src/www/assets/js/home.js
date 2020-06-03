/**
 *     Author              :  Fujise Thomas.
 *     Project             :  ProjetTPI.
 *     Page                :  Home.js
 *     Brief               :  Display maps on itinerary card on home page.
 *     Date                :  02.06.2020.
 */

$(document).ready(function(){
    
    L.mapquest.key = 'xTHtqDgrfGDrRKxzBKyFtDdkqRS4Uu8V';
    /* call the php that has the php array which is json_encoded */
    $.getJSON('./app/api/getItineraries.php', function(data) {
        var maps = [];
        var mapInit = [];
        var waypointsArray = [];
        /* data will hold the php array as a javascript object */
        $.each(data, function(key, val) {
            maps['map' + val.Id] = L.mapquest.map('map' + val.Id, {
                center: [val.Waypoints[0].Latitude, val.Waypoints[0].Longitude],
                layers: L.mapquest.tileLayer('map'),
                zoom: 13
            });
            mapInit.push({     
                start: val.Waypoints[0].Address,
                end: val.Waypoints[val.Waypoints.length - 1].Address                                                          
            });

            /*Add waypoints in array */
            for(let i = 1; i< val.Waypoints.length-1 ; i++){
                waypointsArray.push(val.Waypoints[i].Latitude + ', ' + val.Waypoints[i].Longitude);
            }
            mapInit[0].waypoints = waypointsArray;
            console.log(mapInit[0]);
            L.mapquest.directions().route(mapInit[0]);
          
        });
    });

});
