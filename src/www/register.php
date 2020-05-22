<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjectTPI.
*     Page                :  Register page.
*     Brief               :  register page.
*     Date début projet   :  20.05.2020.
*/

require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/controller/databaseController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/controller/countryController.php';

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
    //Affiche une navbar selon si on est log ou non.
    if (isset($_SESSION['isLogged'])) {
        if (isAllowed("administrateur")) {
            include "./inc/navbar/navbarAdmin.php";
        }
        else {
            include "./inc/navbar/navbarLogged.php";
        }
    } 
    else {
        include "./inc/navbar/navbarNotLogged.php";
    }?>
    <div id="formInscription">
    <div class="container">
    <div class="row justify-content-center mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Register as new user</div>
                <div class="card-body">
                    <form enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="nickname">Nickname :</label>
                                    <?php if (isset($erreur["nickname"])): ?>
                                        <input type="text" class="form-control is-invalid" id="nicknameUser" placeholder="Error nickname" name="nicknameUser" required>
                                        <div class="invalid-feedback">Please enter a valid nickname</div>
                                    <?php else: ?>
                                        <input type="text" class="form-control" id="nicknameUser" placeholder="Nickname" name="nicknameUser" required value="<?php if(isset($nicknameUser)){echo $nicknameUser;}?>">
                                    <?php endif; ?>
                                </div>
                            </div>                       
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="emailUser">Email :</label>
                                    <?php if (isset($erreur["email"])): ?>
                                        <input type="email" class="form-control is-invalid" id="emailUser" placeholder="Email" name="emailUser" required>
                                        <div class="invalid-feedback"><?= $erreur["email"] ?></div>
                                    <?php else: ?>
                                        <input type="email" class="form-control" id="emailUser" placeholder="Email" name="emailUser" required value="<?php if(isset($emailUser)){echo $emailUser;}?>">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="password">Password :</label>
                                    <?php if (isset($erreur["password"])): ?>
                                        <input type="password" class="form-control is-invalid" id="password" placeholder="******" name="password" required>
                                        <div class="invalid-feedback"><?=  $erreur["password"] ?></div>
                                    <?php else: ?>
                                        <input type="password" class="form-control" id="password" placeholder="******" name="password" required>
                                    <?php endif; ?>
                                </div>
                                <div class="col">
                                    <label for="verifyPassword">Confirm Password :</label>
                                    <?php if (isset($erreur["password"])): ?>
                                        <input type="password" class="form-control is-invalid" id="verifyPassword" placeholder="******" name="verifyPassword" required>
                                        <div class="invalid-feedback"><?=  $erreur["password"] ?></div>
                                    <?php else: ?>
                                        <input type="password" class="form-control" id="verifyPassword" placeholder="******" name="verifyPassword" required>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="countryUser">Country :</label>
                                    <select name="country" id="country" size="1" class="custom-select">
                                    <?php 
                                        $countryController = new TCountryController();
                                        foreach ($countryController->getAllCountry() as $country) {
                                            echo "<option id=". $country->Code ."> " . $country->Name . "</option>";
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                <label for="start">Birthday :</label>

                                <input type="date" id="birthday" name="birthdayUser"
                                    value="2018-07-22" min="1900-01-01" max="2018-09-01" class="input-group form-control date">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="userLogo">Logo :</label>
                            <input type="file" class="form-control-file" name="userLogo" id="userLogo">
                        </div>
                        <div class="form-group">
                                <label for="">&nbsp;</label>
                                <button type="submit" class="form-control btn btn-outline-primary" id="registerUser" name="registerUser">Register</button>
                                <a href="./index.php">Already register? Log in</a>
                        </div> 
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/i18n/defaults-*.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="./assets/script/register.js"></script>
</body>
</html>

