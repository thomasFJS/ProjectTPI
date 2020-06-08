<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  deleteItinerary.
*     Brief               :  api to disable the account used for ajax call.
*     Date                :  04.06.2020.
*/

//requirements
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FItineraryManager.php';

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

$idItinerary = filter_input(INPUT_POST, "itineraryId", FILTER_SANITIZE_STRING);

if(FItineraryManager::GetInstance()->Delete($idItinerary)){
    echo '{ "ReturnCode": 100, "Message": "Itinerary deleted"}';
    exit();
}else{
    echo '{ "ReturnCode": 101, "Message": "Itinerary delete fail"}';
    exit();
}

?>