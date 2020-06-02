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
        var mapInit = {};
        var waypointsArray = [];
        /* data will hold the php array as a javascript object */
        $.each(data, function(key, val) {
            maps['map' + val.Id] = L.mapquest.map('map' + val.Id, {
                center: [val.waypoints.Latitude, val.waypoints.Longitude],
                layers: L.mapquest.tileLayer('map' + val.Id),
                zoom: 13
            });
            mapInit = {     
                start: val.waypoints[0].Address,
                end: val.waypoints[val.waypoints.length - 1].Address            
            };
            /*Add waypoints in array */
            for(let i = 0; i< val.waypoints.length ; i++){
                waypointsArray.push(val.waypoints[i].Latitude + ', ' + val.waypoints[i].Longitude);
            }
            mapInit.push({waypoints: waypointsArray});
            L.mapquest.directions().route(mapInit);
            //$('ul').append('<li id="' + key + '">' + val.first_name + ' ' + val.last_name + ' ' + val.email + ' ' + val.age + '</li>');
        });
    });

});