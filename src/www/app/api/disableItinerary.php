<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  disableItinerary.
*     Brief               :  api to disable the itinerary.
*     Date                :  04.06.2020.
*/

//requirements
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FItineraryManager.php';

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

$idItinerary = filter_input(INPUT_POST, "itineraryId", FILTER_SANITIZE_STRING);
$title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);

if(FItineraryManager::GetInstance()->DisableItinerary($idItinerary, $title)){
    echo '{ "ReturnCode": 90, "Message": "Itinerary disabled"}';
    exit();
}else{
    echo '{ "ReturnCode": 91, "Message": "Disable itinerary fail"}';
    exit();
}

?>