<?php

/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjectTPI.
*     Page                :  help.
*     Brief               :  User guide.
*     Date                :  09.06.2020.
*/

 /**
  * @brief Help user to use the website
  */

require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectTPI/src/www//inc/inc.all/inc.all.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Help</title>
    <!-- Font Awesome icons (free version)-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="./assets/css/styles.css" rel="stylesheet">
    <!-- Fonts CSS-->
    <link rel="stylesheet" href="./assets/css/heading.css">
    <link rel="stylesheet" href="./assets/css/body.css">
    
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
<section>
    <div class="container">
    <div class="text-center">
            <h2 class="page-section-heading text-secondary mb-0 d-inline-block">Manuel utilisateur</h2>
        </div>
        <!-- Icon Divider-->
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <div class="list-group mb-5">
            <a href="#filter" class="list-group-item list-group-item-action">Filtres</a>
            <a href="#loginRegister" class="list-group-item list-group-item-action">Connexion / Inscription</a>
            <a href="#ratingComment" class="list-group-item list-group-item-action">Commentaire et notation d'un itinéraire</a>
            <a href="#createItinerary" class="list-group-item list-group-item-action">Création d'un itinéraire</a>
            <a href="#updateItinerary" class="list-group-item list-group-item-action">Modification d'un itinéraire</a>
            <a href="#profile" class="list-group-item list-group-item-action">Page de profil</a>
        </div>
        <h2 id="filter">Filtres</h2>
        <p>
            Un formulaire est disponible en haut de <a href="./index.php" target="_blank">la page d'accueil</a> et de <a href="./myItineraries.php" target="_blank">la page "Mes itinéraires"</a> afin de pouvoir filtrer les itinéraires. Lorsque l'on applique un filtre, il est appliqué sur tous les itinéraires affichés sur la page d'accueil. Il est également possible d'appliquer plusieurs filtres en même temps, un itinéraire sera affiché s'il rempli tous les critères du filtre.
        </p>
        <p>Il est possible de filtrer les itinéraires par :
            <ul>
                <li>Pays</li>
                <li>Note</li>
                <li>Distance Min</li>
                <li>Distance Max</li>
                <li>Durée Min</li>
                <li>Durée Max</li>
            </ul>
        </p>
        <p>Pour utiliser les filtres il vous suffit d'entrer les valeurs désirés dans les champs désignés et d'appuyer sur le bouton "Filter" pour appliquer le filtre.</p>
        <p>Pour annuler le filtre qui est appliqué, vous devez appuyer sur le bouton "Cancel filter" et l'affichage des itinéraires sera remit par défaut</p>
        <h2 id="loginRegister">Connexion / Inscription</h2>
        <p>
            Pour se connecter, il faut se rendre sur <a href="login.php" target="_blank">la page de connexion</a> et renseigner les champs du formulaire de connexion. Il faut ensuite appuyer sur le bouton "Sign in" afin de se connecter à l'application.
            </br>
            Si vous ne possédez pas encore de compte, il faut cliquer sur le bouton "Register" de la barre de navigation. Vous arriverez sur <a href="./register.php" target="_blank">la page d'inscription</a>. 
            </br>Il vous faudra alors renseigner les champs :
            <ul>
                <li><b>Nickname</b>: pour votre pseudo qui doit être unique</li>
                <li><b>Email</b>: pour votre adresse email</li>
                <li><b>Password</b> : pour votre mot de passe</li>
                <li><b>Confirm Password</b> : pour la confirmation de votre mot de passe</li>
            </ul>
            </br>
            Une fois les champs renseigné et le bouton "Register" pressé, vous recevrez un mail d'activation à l'email renseigné. Il vous faudra alors cliquer sur le lien reçu par mail pour confirmer votre compte et pouvoir vous connecter.
        </p>
        <h2 id="ratingComment">Commentaire et notation d'un itinéraire</h2>
        <p>
            Lorsque l'on clique sur le titre d'un itinéraire dans <a href="./index.php" target="_blank">la page d'accueil</a>, on se retrouve sur la page de détails d'un itinéraire.
            </br>
            Sur cette page, si l'utilisateur visionne un itinéraire dont il n'est pas propriétaire, il peut noter et commenter l'itinéraire. 
            </br>
            </p>
        <p>
            Pour noter un itinéraire, vous devez entrez la note que vous souhaitez attribuer dans le champ "Rate" en dessous de la map ou est affiché l'itinéraire (<b>Attention: vous ne pouvez noter qu'une note par itinéraire</b>) et appuyer sur le bouton "Rate".
            Une fois le bouton appuyé, la note est ajoutée à la moyenne de l'itinéraire.
        </p>
        <p>
            Pour commenter un itinéraire, vous devez renseigner le champs "Comment", en dessous du champs de notation, avec le commentaire que vous voulez publier. Il vous suffira de cliquer sur le bouton "Comment" pour publier le commentaire. Le propriétaire de l'itinéraire recevra un mail lorsque votre commentaire sera posté
        </p>
        <h2 id="createItinerary">Création d'un itinéraire</h2>
        <p>
            Pour créer un itinéraire, il faut posséder un compte et être connecté avec. En cliquant sur le bouton "Create itinerary" sur la barre de navigation vous arriverez sur <a href="createItinerary.php" target="_blank">la page de création</a>, tous les champs sont obligatoires sauf les éventuelles photos que vous pouvez ajouter.
        </p>
        <p>
            Les différents champs doivent être renseigné pour la création de votre itinéraire :
            <ul>
                <li>
                    <b>Titre</b> : Le titre de votre itinéraire (<b>Attention</b>: il doit être unique)
                </li>
                <li>
                    <b>Pays</b> : Séléctionner le pays de départ de votre itinéraire
                </li>
                <li>
                    <b>Description</b> : Donner une description a votre itinéraire
                </li>
                <li>
                    <b>Durée</b> : La durée de votre itinéraire.
                </li>
                <li>
                    <b>Distance</b> : La distance totale de l'itinéraire.
                </li>
                <li>
                    <b>Placer les points de votre itinéraire sur la carte</b>
                </lI>
            </ul>
        </p>
        <p>
            Une fois les champs ci-dessus renseigné, vous pouvez cliquer sur le bouton "Create" en-dessous et votre itinéraire sera créé si le titre que vous avez saisit n'est pas déjà utilisé.
        </p>
        <h2 id="updateItinerary">Modification d'un itinéraire</h2>
        <p>
            Pour pouvoir modifier un itinéraire, il faut aller sur la page de détail d'un itinéraire que vous avez créé (Vous pouvez voir les itinéraires que vous avez créé sur <a href="./myItineraries.php" target="_blank">la page "Mes itinéraires"</a>).
            Une fois sur la page détail d'un itinéraire, vous pourrez modifier les différentes informations de votre itinéraire en changeant le champs et en cliquant sur le bouton "Save infos".
            Une fois le bouton "Save infos" cliqué les informations sont sauvegardés et votre itinéraire est mis à jour.    
        </p>
        <p>
            Vous pouvez également rajouter des photos a votre itinéraire en les ajoutant dans le champs "Photos".
        </p>
        <h2 id="profile">Page de profil</h2>
        <p>
            Pour accéder à votre profil, il faut cliquer sur le lien "Profil" de la barre de navigation qui vous redirigera sur <a href="./profil.php" target="_blank">votre page profil</a>.
        </p>
        <p>
            Toutes les informations de votre compte sont affichés dans les champs prévus pour. Vous pouvez modifier les détails de votre compte en changeant les champs et en cliquant sur le bouton "Save infos".
            </br>
            Une fois le bouton "Save infos" cliqué, les informations que vous avez renseigné ainsi que l'avatar de votre compte (si vous en avez ajouté un) sont sauvegardés et mis a jour dans la base de données.
        </p>
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