<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  createItinerary.
*     Brief               :  api to create itinerary.
*     Date                :  04.06.2020.
*/

//requirements
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FItineraryManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FSessionManager.php';

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

//Init
$title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
$country = filter_input(INPUT_POST, "country", FILTER_SANITIZE_EMAIL);
$description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);
$duration = filter_input(INPUT_POST, "duration", FILTER_SANITIZE_STRING);
$distance = filter_input(INPUT_POST, "distance", FILTER_VALIDATE_FLOAT);
$waypoints = json_decode($_POST['waypoints']);
$idUser = FSessionManager::GetUserLogged()->Id;

if(isset($_FILES["media"])){
    $photos = $_FILES["media"];
}

// if all field aren't empty
if (strlen($title) > 2 && strlen($description) > 0 && strlen($duration) > 0) { 
    if($distance < 999 || $distance > 1) {     
    // if user add photos to his itinerary
    if(isset($photos)){
        if(FItineraryManager::GetInstance()->Create($title, $description, $duration, $distance, $country, $waypoints,$idUser, $photos)) { 
            echo '{ "ReturnCode": 0, "Message": "Create itinerary done"}';
            exit();
        }
        echo '{ "ReturnCode": 2, "Message": "Create itinerary fail"}';
        exit();
    }
    else{
        if(FItineraryManager::GetInstance()->Create($title, $description, $duration, $distance, $country, $waypoints,$idUser)) { 
            echo '{ "ReturnCode": 0, "Message": "Create itinerary done"}';
            exit();
        }
        echo '{ "ReturnCode": 2, "Message": "Create itinerary fail"}';
        exit();
    }
    }
    echo '{ "ReturnCode": 3, "Message": "Distance not valid"}';
    exit();
}

?>