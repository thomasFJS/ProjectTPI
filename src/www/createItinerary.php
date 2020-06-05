<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjectTPI.
*     Page                :  CreateItinerary.
*     Brief               :  Page for create an itinerary.
*     Date                :  03.06.2020.
*/

/*Requirements  */
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FCodeManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FSessionManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FItineraryManager.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//If user isn't logged in
if(FSessionManager::getUserLogged() == null){
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="FR" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Create your itinerary</title>
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
<section class="page-section mb-0">
    <div class="container">
    <div class="row justify-content-center mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Create your itinerary</div>
                <div class="card-body">
                    <form enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="title">Title :</label>                                       
                                        <input type="text" class="form-control" id="title" placeholder="Title" name="title" required>
                                        <p id="errorTitle" class="errormsg">Title already used</p>
                                </div>                               
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="startCountry">Country :</label>
                                    <select name="startcountry" id="startCountry" size="1" class="custom-select">
                                    <?php 
                                        $countryManager = new FCodeManager();
                                        foreach ($countryManager::GetInstance()->getAllCountry() as $country) {
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
                                    <label for="description">Description :</label>                                       
                                    <textarea class="form-control" id="description" rows="3"></textarea>
                                </div>                               
                            </div>
                        </div>
                        <div class="form-group">
                        <div class="md-form md-outline">
                            <label for="duration">Duration (Hours:Minutes):</label>
                            <input type="time" id="duration" class="form-control" placeholder="Select time">                    
                        </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="distance">Distance (KM) :</label>
                                    <input class="form-control" id="distance" type="number" value="100" data-decimals="1" min="1" max="999" step="0.1"/> 
                                    <p id="errorDistance" class="errormsg">Distance not valid</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="mapItinerary">Place your itinerary :</label>
                                    <div id="mapItinerary" class="img-fluid rounderd mb-5" style="width: 100%; height: 630px;"></div>
                                        
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="itineraryImages">Images :</label>
                            <input type="file" class="form-control-file" name="itineraryImages" id="itineraryImages" multiple>
                        </div>
                        <div class="form-group">
                            <label for="">&nbsp;</label>
                            <button type="submit"  id="createItinerary" class="form-control btn btn-outline-primary"  name="createItinerary" >Create</button>
                            <button type="button" id="cancel"class="form-control btn btn-outline-danger">Cancel</button>                           
                            <p id="errorCreate" class="errormsg">Itinerary creation fail</p>
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
<!-- Display maps on itineraries card with mapquest-->
<script src="./assets/js/createItinerary.js"></script>
</body>
</html>