<?php
/*
*     Auteur              :  Fujise Thomas.
*     Projet              :  game.
*     Page                :  Index.
*     Description         :  Page d'accueil.
*     Date début projet   :  04.09.2019.
*/
//requirements
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/controller/userController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/controller/sessionController.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//If user isn't logged in
if(TSessionController::getUserLogged() == null){
    header("Location: index.php");
    exit();
}
$userLogged = TSessionController::getUserLogged();
?>
<!DOCTYPE html>
<html lang="FR" dir="ltr">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
