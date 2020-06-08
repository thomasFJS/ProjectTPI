<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjectTPI.
*     Page                :  Index.
*     Brief               :  Home page.
*     Date                :  02.06.2020.
*/

/*Requirements  */
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FUserManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FSessionManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/view/FItineraryView.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FItineraryManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FCodeManager.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(FSessionManager::GetItineraryFilter() != false){
    $itineraries = FItineraryManager::GetInstance()->GetAllWithFilter(FSessionManager::GetItineraryFilter());
}
else{
    $itineraries = FItineraryManager::GetInstance()->GetAll();
}
?>
<!DOCTYPE html>
<html lang="FR" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Home</title>
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
<header class="masthead bg-primary text-white text-center">
    <div class="container d-flex align-items-center flex-column">
        <!-- Masthead Heading-->
        <h1 class="masthead-heading mb-0">TRAVLER</h1>
        <!-- Icon Divider-->
        <div class="divider-custom divider-light">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <!-- Masthead Subheading-->
        <p class="pre-wrap masthead-subheading font-weight-light mb-0">` <i>YOUR ITINERARY FINDER</i> `</p>
    </div>
</header>
<section class="page-section portfolio" id="portfolio">
    <div class="container">
        <!-- Portfolio Section Heading-->
        <div class="text-center">
            <h2 class="page-section-heading text-secondary mb-0 d-inline-block">ITINERARY</h2>
        </div>
        <!-- Icon Divider-->
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <div class="container">
            <form name="itineraryFilter">
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <label for="countryFilter">Country :</label>
                            <select name="countryFilter" id="countryFilter" size="1" class="custom-select">
                             <option id="None" selected>None</option>
                             <?php 
                                $countryManager = new FCodeManager();
                                foreach ($countryManager::GetInstance()->getAllCountry() as $country) {
                                    echo "<option id=". $country->Code ."> " . $country->Name . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col">
                        <label for="rateFilter">Rate Min:</label>
                        <select name="rateFilter" id="rateFilter" size="1" class="custom-select">
                             <?php 
                                for ($i = 0;$i<=10;$i++) {
                                    echo '<option id="'.$i.'">' . $i . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col">
                            <div class="row">
                                <label for="distanceMinFilter">Distance Min (KM) :</label>
                                <input class="form-control" id="distanceMinFilter" type="number" value="0" data-decimals="0" min="1" max="999" step="1"/> 
                            </div>
                            <div class="row">
                                <label for="distanceMaxFilter">Distance Max (KM) :</label>
                                <input class="form-control" id="distanceMaxFilter" type="number" value="0" data-decimals="0" min="1" max="999" step="1"/> 
                            </div>
                        </div>
                        <div class="col">
                            <div class="row">
                                <label for="durationMinFilter">Duration Min (H) :</label>
                                <input type="time" id="durationMinFilter" class="form-control" placeholder="Select time">                       
                            </div>
                            <div class="row">
                            <label for="durationMaxFilter">Duration Max (H) :</label>
                                <input type="time" id="durationMaxFilter" class="form-control" placeholder="Select time"> 
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="submit"  id="itineraryFilterCancel" class="form-control btn btn-outline-danger"  name="itineraryFilter" >Cancel Filter</button>
                        </div>
                        <div class="col">
                            <button type="submit"  id="itineraryFilter" class="form-control btn btn-outline-primary"  name="itineraryFilter" >Filter</button>
                        </div>                
                    </div>
                </div>
            </form>
        </div>
        <!-- Portfolio Grid Items-->
        <div class="row justify-content-center">
            <!-- Portfolio Items-->
            <?php echo FItineraryView::DisplayItineraries($itineraries);?>
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
<!-- Include -->
<!-- Display maps on itineraries card with mapquest-->
<script src="./assets/js/home.js"></script>
</body>
</html>