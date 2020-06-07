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
            <h2 class="page-section-heading text-secondary mb-0 d-inline-block">YOUR ITINERARY</h2>
        </div>
        <!-- Icon Divider-->
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <!-- Portfolio Grid Items-->
        <div class="row justify-content-center">
            <!-- Portfolio Items-->
            <?php echo FItineraryView::DisplayItineraries(FItineraryManager::GetInstance()->GetAllByUserId(FSessionManager::getUserLogged()->Id));?>
        </div>
    </div>
</section>
<section class="page-section bg-primary text-white mb-0" id="about">
    <div class="container">
        <!-- About Section Heading-->
        <div class="text-center">
            <h2 class="page-section-heading d-inline-block text-white">ABOUT</h2>
        </div>
        <!-- Icon Divider-->
        <div class="divider-custom divider-light">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <!-- About Section Content-->
        <div class="row">
            <div class="col-lg-4 ml-auto">
                <p class="pre-wrap lead">Freelancer is a free bootstrap theme created by Start Bootstrap. The download includes the complete source files including HTML, CSS, and JavaScript as well as optional SASS stylesheets for easy customization.</p>
            </div>
            <div class="col-lg-4 mr-auto">
                <p class="pre-wrap lead">You can create your own custom avatar for the masthead, change the icon in the dividers, and add your email address to the contact form to make it fully functional!</p>
            </div>
        </div>
    </div>
</section>
<section class="page-section" id="contact">
    <div class="container">
        <!-- Contact Section Heading-->
        <div class="text-center">
            <h2 class="page-section-heading text-secondary d-inline-block mb-0">CONTACT</h2>
        </div>
        <!-- Icon Divider-->
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <!-- Contact Section Content-->
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="d-flex flex-column align-items-center">
                    <div class="icon-contact mb-3"><i class="fas fa-mobile-alt"></i></div>
                    <div class="text-muted">Phone</div>
                    <div class="lead font-weight-bold">(555) 555-5555</div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="d-flex flex-column align-items-center">
                    <div class="icon-contact mb-3"><i class="far fa-envelope"></i></div>
                    <div class="text-muted">Email</div><a class="lead font-weight-bold" href="mailto:name@example.com">name@example.com</a>
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
<!-- Display maps on itineraries card with mapquest-->
<script src="./assets/js/home.js"></script>
</body>
</html>