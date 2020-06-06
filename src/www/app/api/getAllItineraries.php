<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  getAllItineraries.
*     Brief               :  Api to get all itineraries store in database.
*     Date                :  02.06.2020.
*/
/* Requirements */
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FItineraryManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FSessionManager.php';


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
/* Set document type to text/javascript */
header("Content-type: text/javascript");

$country = filter_input(INPUT_POST, "countryFilter", FILTER_SANITIZE_STRING);
$rateMin = filter_input(INPUT_POST, "rateFilter", FILTER_SANITIZE_STRING);
$durationMin = filter_input(INPUT_POST, "durationMin", FILTER_SANITIZE_STRING);
$durationMax = filter_input(INPUT_POST, "durationMax", FILTER_SANITIZE_STRING);
$distanceMin = filter_input(INPUT_POST, "distanceMin", FILTER_VALIDATE_FLOAT);
$distanceMax = filter_input(INPUT_POST, "distanceMax", FILTER_VALIDATE_FLOAT);

if($country == null && $rateMin == null && $durationMin == null && $durationMax == null && $distanceMin == null && $distanceMax == null){
    /* Encode the array with all itineraries as json. */
    echo json_encode(FItineraryManager::GetInstance()->GetAll());
}
else{
    FSessionManager::SetItineraryFilter([
        'country' => $country, 
        'rateMin' => $rateMin,
        'durationMin' => $durationMin,
        'durationMax' => $durationMax,
        'distanceMin' => $distanceMin,
        'distanceMax' => $distanceMax
    ]);
    echo json_encode(FItineraryManager::GetInstance()->GetAllWithFilter(FSessionManager::GetItineraryFilter()));
}

?>