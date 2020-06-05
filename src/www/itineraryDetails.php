<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjectTPI.
*     Page                :  Login.
*     Brief               :  Login page.
*     Date                :  02.06.2020.
*/

require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FUserManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FSessionManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FCodeManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FPhotoManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/model/FUser.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FItineraryManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/view/FItineraryView.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FRateManager.php';



if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$itinerary = FItineraryManager::GetInstance()->GetById($_GET['id']);
?>
<!DOCTYPE html>
<html lang="FR" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login</title>
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
        if (FUserManager::getInstance()->isAllowed($_SESSION['userLogged'])) {
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
              <div class="card-header">Itinerary details</div>
                <div class="card-body">
                    <form name="profil">
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="title">Title :</label>                                       
                                        <input type="text" class="form-control" id="title" placeholder="Title" name="title" value="<?= $itinerary->Title?>" required>
                                        <p id="errorTitle" class="errormsg">Title already exist</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label for="description">Description :</label>
                                        <textarea class="form-control" id="userBio" rows="3"><?= $itinerary->Description?></textarea>                                  
                                    </div>                                   
                                </div>
                            </div>
                            <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="itineraryCountry">Country :</label>
                                    <select name="itineraryCountry" id="itineraryCountry" size="1" class="custom-select">
                                    <?php 
                                        $countryManager = new FCodeManager();
                                        foreach ($countryManager::GetInstance()->getAllCountry() as $country) {
                                            if($itinerary->Country == $country->Code){
                                                echo "<option id=". $country->Code ." selected> " . $country->Name . "</option>";
                                            }
                                            else{
                                                echo "<option id=". $country->Code ."> " . $country->Name . "</option>";
                                            }
                                        }
                                    ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="distance">Distance (KM) :</label>
                                    <input class="form-control" id="distance" type="number" value="<?= $itinerary->Distance?>" data-decimals="1" min="1" max="999" step="0.1"/> 
                                    <p id="errorDistance" class="errormsg">Distance not valid</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <div class="md-form md-outline">
                                        <label for="duration">Duration (Hours:Minutes):</label>
                                        <input type="time" id="duration" class="form-control" placeholder="Select time" value="<?= $itinerary->Duration ?>">                    
                                    </div>
                                </div>
                                <?php if($itinerary->User == FSessionManager::GetUserLogged()->Id) : ?>
                                <div class="col">
                                    <label for="itineraryImages">Photos :</label>                                                         
                                    <input type="file" class="form-control-file" name="itineraryImages" id="itineraryImages">
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group">
                        <div id="carouselControls" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <?= FItineraryView::DisplayPhotosItineraries(FPhotoManager::GetInstance()->GetAllById($itinerary->Id))?>
                                </div>
                                <a class="carousel-control-prev" href="#carouselControls" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselControls" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="mapItinerary">The itinerary :</label>
                                    <div id="mapItinerary" class="img-fluid rounderd mb-5" style="width: 100%; height: 630px;"></div>
                                        
                                </div>
                            </div>
                        </div>
                        <?php if($itinerary->User == FSessionManager::GetUserLogged()->Id) : ?>
                        <div class="form-group">
                            <div class="row">
                            <p id="errorUpdate" class="errormsg">Update fail, Please try again</p>                        
                                <div class="col">
                                    <button type="button" id="cancel" class="form-control btn btn-outline-danger" >Cancel</button>     
                                </div>
                                <div class="col">
                                    <button type="submit"  id="save" class="form-control btn btn-outline-primary" name="formProfil">Save itinerary</button>
                                </div>
                            </div>
                        </div>
                        <?php elseif(!FRateManager::GetInstance()->HasAlreadyRate($itinerary->Id, FSessionManager::GetUserLogged()->Id)) : ?>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="rating">Rating (0-10) :</label>
                                    <input class="form-control" id="rating" type="number" value="<?= $itinerary->Rating?>" data-decimals="0" min="1" max="10" step="1"/> 
                                </div>
                                <div class="col">
                                    
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
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
<script src="./assets/js/detailsItinerary.js"></script>
</body>
</html>



