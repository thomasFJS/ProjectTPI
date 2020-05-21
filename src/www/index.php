<?php
/*
*     Auteur              :  Fujise Thomas.
*     Projet              :  game.
*     Page                :  Index.
*     Description         :  Page d'accueil.
*     Date début projet   :  04.09.2019.
*/

require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/controller/userController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/controller/sessionController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/model/tUser.php';

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
    <title>Accueil</title>
</head>
<body>
<?php
    
    //Show the good navbar depends if logged and if user is admin
    if (UserController::getInstance()->isLogged()) {
        if (UserController::getInstance()->isAllowed(TSessionController::getUserLogged())) {
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

</body>
</html>

<script src="./assets/script/script.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/i18n/defaults-*.min.js"></script>