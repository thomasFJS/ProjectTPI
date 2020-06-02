window.onload = function() {
    L.mapquest.key = 'xTHtqDgrfGDrRKxzBKyFtDdkqRS4Uu8V';

    

    L.mapquest.directions().route({
      start: 'Chemin des Curiades, Bernex, 1233',
      end: 'Chemin Gérard-De-Ternier, 1213, Lancy',
      waypoints: [ '46.196281, 6.151338 ', 'Rue de l\'encyclopedie, 1201, Genève']
    });
  }
  $(document).ready(function(){
    /* call the php that has the php array which is json_encoded */
    $.getJSON('./app/api/getItineraries.php', function(data) {
            /* data will hold the php array as a javascript object */
            $.each(data, function(key, val) {
                var maps['map' + val.Id.ToStri] = L.mapquest.map('map' + '', {
                    center: [46.204391, 6.143158],
                    layers: L.mapquest.tileLayer('map'),
                    zoom: 13
              
                  });
                $('ul').append('<li id="' + key + '">' + val.first_name + ' ' + val.last_name + ' ' + val.email + ' ' + val.age + '</li>');
            });
    });

});