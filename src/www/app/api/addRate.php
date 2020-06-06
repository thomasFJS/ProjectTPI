<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  addRate.
*     Brief               :  api to add a rate to an itinerary.
*     Date                :  04.06.2020.
*/

//requirements
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FItineraryManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FSessionManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FRateManager.php';

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

//Init
$title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
$rate = filter_input(INPUT_POST, "rate", FILTER_SANITIZE_STRING);
$idUser = FSessionManager::GetUserLogged()->Id;
$idItinerary = FItineraryManager::GetInstance()->GetByTitle($title)->Id;
// if all field aren't empty
if (strlen($title) > 2 && strlen($rate) > 0) {   
    if($rate < 10 && $rate > 0){    
        if(FRateManager::GetInstance()->AddToItinerary($idItinerary, $idUser, $rate)) { 
            echo '{ "ReturnCode": 60, "Message": "Rate added"}';
            exit();
        }
        echo '{ "ReturnCode": 61, "Message": "Rate add fail"}';
        exit();
    }
    echo '{ "ReturnCode": 62, "Message": "Rate not valid"}';
    exit();
}

?>