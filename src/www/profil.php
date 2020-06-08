<?php
/*
*     Auteur              :  Fujise Thomas.
*     Projet              :  ProjectTPI.
*     Page                :  Profil.
*     Description         :  Profil page.
*     Date début projet   :  04.06.2020.
*/
//requirements
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FUserManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FSessionManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FCodeManager.php';


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//If user isn't logged in
if(FSessionManager::getUserLogged() == null){
    header("Location: index.php");
    exit();
}
$userLogged = FSessionManager::getUserLogged();
?>
<!DOCTYPE html>
<html lang="FR" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Profil</title>
    <!-- Font Awesome icons (free version)-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="./assets/css/styles.css" rel="stylesheet">
    <!-- Fonts CSS-->
    <link rel="stylesheet" href="./assets/css/heading.css">
    <link rel="stylesheet" href="./assets/css/body.css">
    <!-- Maquest CSS and JS Load-->
    <link type="text/css" rel="stylesheet" href="https://api.mqcdn.com/sdk/mapquest-js/v1.3.2/mapquest.css"/>
    <script src="https://api.mqcdn.com/sdk/mapquest-js/v1.3.2/mapquest.js"></script>  
    
</head>
<body id="page-top">
<?php
    
    //Show the good navbar depends if logged and if user is admin
    if (FUserManager::getInstance()->isLogged()) {
        if (FUserManager::getInstance()->isAllowed(FSessionManager::getUserLogged())) {
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
<section class="page-section mb-0" id="formLogin">
    <div class="container">
    <div class="row justify-content-center mt-4">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">Profil</div>
                <div class="card-body">
                    <form name="profil">
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="nickname">Nickname :</label>                                       
                                        <input type="text" class="form-control" id="nickname" placeholder="Nickname" name="nickname" value="<?= $userLogged->Nickname?>" required>
                                        <p id="errorNickname" class="errormsg">Nickname already exist</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label for="name">Name :</label>
                                        <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="<?= $userLogged->Name?>">                                  
                                    </div>
                                    <div class="col">
                                        <label for="surname">Surname :</label>
                                        <input type="text" class="form-control" id="surname" placeholder="Surame" name="surname" value="<?= $userLogged->Surname?>">                                  
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                    <label for="userBio">Bio :</label>                                       
                                    <textarea class="form-control" id="userBio" rows="3" value="<?= $userLogged->Bio?>"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="userCountry">Country :</label>
                                    <select name="userCountry" id="userCountry" size="1" class="custom-select">
                                    <?php 
                                        $countryManager = new FCodeManager();
                                        foreach ($countryManager::GetInstance()->getAllCountry() as $country) {
                                            if($userLogged->Country == $country->Code){
                                                echo "<option id=". $country->Code ." selected> " . $country->Name . "</option>";
                                            }
                                            else{
                                                echo "<option id=". $country->Code ."> " . $country->Name . "</option>";
                                            }
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="avatar">Avatar :</label>
                                    <img src="<?=$userLogged->Avatar?>" alt="Your avatar" width="50px" height="50px" />
                                    
                                    <input type="file" class="form-control-file" name="avatar" id="avatar">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                            <p id="errorUpdate" class="errormsg">Update fail, Please try again</p>                        
                                <div class="col">
                                    <button type="button" id="cancel" class="form-control btn btn-outline-danger" >Cancel</button>     
                                </div>
                                <div class="col">
                                    <button type="submit"  id="save" class="form-control btn btn-outline-primary" name="formProfil">Save infos</button>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
    </div>
    </section>
    <footer class="footer text-center">
    <div class="container">
        <div class="row">
            <!-- Footer Location-->
            <div class="col-lg-4 mb-5 mb-lg-0">
                <h4 class="mb-4">LOCATION</h4>
                <p class="pre-wrap lead mb-0">CFPT Informatique
Chemin Gérard-De-Ternier 10
1213 Lancy</p>
            </div>
            <!-- Footer Middle Section-->
            <div class="col-lg-4 mb-5 mb-lg-0">
                
            </div>
            <!-- Footer About Text-->
            <div class="col-lg-4">
                <h4 class="mb-4">ABOUT TRAVLER</h4>
                <p class="pre-wrap lead mb-0">Travler is a project made by Thomas Fujise for his CFC work in the CFPT</p>
            </div>
        </div>
    </div>
</footer>
<!-- Copyright Section-->
<section class="copyright py-4 text-center text-white">
    <div class="container"><small class="pre-wrap">Copyright © Travler 2020</small></div>
</section>
<!-- Scroll to Top Button (Only visible on small and extra-small screen sizes)-->
<div class="scroll-to-top d-lg-none position-fixed"><a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top"><i class="fa fa-chevron-up"></i></a></div>
<!-- Bootstrap core JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<!-- Third party plugin JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<!-- Core theme JS-->
<script src="./assets/js/script.js"></script>
<!-- Include constants-->
<script src="./constants/constants.js"></script>
<!-- Display maps on itineraries card with mapquest-->
<script src="./assets/js/profil.js"></script>
</body>
</html>
