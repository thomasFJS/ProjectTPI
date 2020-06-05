<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjectTPI.
*     Page                :  Register.
*     Brief               :  Register page.
*     Date                :  02.06.2020.
*/

require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FDatabaseManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FCodeManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FUserManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FSessionManager.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="FR" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Register</title>
    <!-- Font Awesome icons (free version)-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="./assets/css/styles.css" rel="stylesheet">
    <!-- Fonts CSS-->
    <link rel="stylesheet" href="./assets/css/heading.css">
    <link rel="stylesheet" href="./assets/css/body.css">
</head>
<body>
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
  <section class="page-section mb-0" id="formRegister">
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
                                    <input type="text" class="form-control" id="nicknameUser" placeholder="Nickname" name="nicknameUser" required>
                                    <p id="errorNickname" class="errormsg">This nickname has been already registered</p>
                                </div>
                            </div>                       
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="emailUser">Email :</label>
                                    <input type="email" class="form-control" id="emailUser" placeholder="Email" name="emailUser" required>
                                    <p id="errorEmail" class="errormsg">This email has been already registered</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="password">Password :</label>
                                    <input type="password" class="form-control" id="password" placeholder="******" name="password" required>
                                </div>
                                <div class="col">
                                    <label for="verifyPassword">Confirm Password :</label>
                                    <input type="password" class="form-control" id="verifyPassword" placeholder="******" name="verifyPassword" required>
                                </div>
                            </div>
                            <p id="errorParam" class="errormsg">Register fail, please try again</p>
                            <p id="errorDifferentPassword" class="errormsg">Both password don't match</p>
                            <p id="errorPasswordMatch" class="errormsg">Your password don't match the requirements</p>
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
            <!-- Footer Social Icons-->
            <div class="col-lg-4 mb-5 mb-lg-0">
                <h4 class="mb-4">AROUND THE WEB</h4><a class="btn btn-outline-light btn-social mx-1" href="https://www.facebook.com/StartBootstrap"><i class="fab fa-fw fa-facebook-f"></i></a><a class="btn btn-outline-light btn-social mx-1" href="https://www.twitter.com/sbootstrap"><i class="fab fa-fw fa-twitter"></i></a><a class="btn btn-outline-light btn-social mx-1" href="https://www.linkedin.com/in/startbootstrap"><i class="fab fa-fw fa-linkedin-in"></i></a><a class="btn btn-outline-light btn-social mx-1" href="https://www.dribble.com/startbootstrap"><i class="fab fa-fw fa-dribbble"></i></a>
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
<!-- Ajax call to send forms field -->
<script src="./assets/js/register.js"></script>
</body>
</html>

