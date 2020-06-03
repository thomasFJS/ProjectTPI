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
<!-- Ajax call to send forms field -->
<script src="./assets/js/register.js"></script>
</body>
</html>

