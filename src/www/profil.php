<?php
/*
*     Auteur              :  Fujise Thomas.
*     Projet              :  game.
*     Page                :  Index.
*     Description         :  Page d'accueil.
*     Date début projet   :  04.09.2019.
*/
require_once $_SERVER['DOCUMENT_ROOT'].'/Project/inc/dbConnect.php';
require_once $_SERVER['DOCUMENT_ROOT']. '/Project/inc/function.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="FR" dir="ltr">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <script src="https://api.mqcdn.com/sdk/mapquest-js/v1.3.2/mapquest.js"></script>
    <link type="text/css" rel="stylesheet" href="https://api.mqcdn.com/sdk/mapquest-js/v1.3.2/mapquest.css"/>
    <script type="text/javascript">
     window.onload = function() {
        L.mapquest.key = 'xTHtqDgrfGDrRKxzBKyFtDdkqRS4Uu8V';

        var map = L.mapquest.map('map', {
          center: [46.204391, 6.143158],
          layers: L.mapquest.tileLayer('map'),
          zoom: 13
        });

        L.mapquest.directions().route({
          start: 'Chemin des Curiades, Bernex, 1233',
          end: 'Chemin Gérard-De-Ternier, 1213, Lancy',
          waypoints: [ '46.196281, 6.151338 ', 'Rue de l\'encyclopedie, 1201, Genève']
        });
      }
    </script>
    <title>Home</title>
</head>
<body>
<?php
    //Show the good navbar depends if logged and if user is admin
    if (UserController::getInstance()->isLogged()) {
        if (UserController::getInstance()->isAllowed($_SESSION['userLogged'])) {
            include "./inc/navbar/navbarAdmin.php";
        }
        else {
            include "./inc/navbar/navbarLogged.php";
        }
    } 
    else {
        include "./inc/navbar/navbarNotLogged.php";
    }
?>
<div class="container">
    <div class="row justify-content-center mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Infos Itinéraire</div>
                    <div class="card-body">
                        <div class="form-group" style="border: 0; margin: 0;">
                            <div id="map" style="width: 100%; height: 530px;">
                            </div>
	                    </div>
                    </div>                   
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>


<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/i18n/defaults-*.min.js"></script>