<?php
/*
*     Auteur              :  Fujise Thomas.
*     Projet              :  game.
*     Page                :  Formulaire de Connexion.
*     Description         :  Page de connexion.
*     Date début projet   :  04.09.2019.
*/

require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/controller/userController.php';
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
    <link rel="stylesheet" href="./assets/style/style.css">
    <title>Accueil</title>
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
    <div id="formLogin">
    <div class="container">
    <div class="row justify-content-center mt-4">
        <div class="col-md-12">
            <div class="card">
                <?php if (isset($erreur["login"])): ?>
                    <div class="card-header bg-danger text-light">Wrong email or password</div>
                <?php else: ?>
                    <div class="card-header">Login</div>
                <?php endif; ?>
                <div class="card-body">
                    <form name="login">
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="username">Username :</label>                                       
                                        <input type="text" class="form-control" id="username" placeholder="Username" name="username" required>
                                        <p id="errorLogin" class="errormsg">Wrong username or password</p>
                                        <p id="errorActivation" class="errormsg">Account not activate</p>
                                </div>
                                <div class="col">
                                    <label for="password">Password :</label>
                                        <input type="password" class="form-control" id="password" placeholder="******" name="password" required>
                                        <p id="errorParam" class="errormsg">Error with the server</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">&nbsp;</label>
                            <button type="submit"  id="login" class="form-control btn btn-outline-primary" name="formLogin">Sign in</button>
                            <a href="./inscription.php">Not register yet ?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/i18n/defaults-*.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="./assets/script/login.js"></script>
</body>
</html>



