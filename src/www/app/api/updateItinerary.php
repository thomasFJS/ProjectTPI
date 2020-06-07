<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  updateItinerary.
*     Brief               :  api to update an itinerary.
*     Date                :  05.06.2020.
*/

//requirements
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FItineraryManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FSessionManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FWaypointsManager.php';

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

//Init
$id = filter_input(INPUT_POST, "itineraryId", FILTER_SANITIZE_NUMBER_INT);
$title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
$country = filter_input(INPUT_POST, "country", FILTER_SANITIZE_STRING);
$description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);
$duration = filter_input(INPUT_POST, "duration", FILTER_SANITIZE_STRING);
$distance = filter_input(INPUT_POST, "distance", FILTER_VALIDATE_FLOAT);
$waypoints = json_decode($_POST['waypoints']);

$idUser = FSessionManager::GetUserLogged()->Id;
$idItinerary = FItineraryManager::GetInstance()->GetById($id)->Id;


if(isset($_FILES["media"])){
    $photos = $_FILES["media"];
}
//Array for all images uploaded encoded in base 64
$srcPhotos = [];
// if all field aren't empty
if (strlen($title) > 2 && strlen($description) > 0 && strlen($duration) > 0) { 
    if($distance < 999 || $distance > 1) {     
    // if user add photos to his itinerary
    if(!isset($photos) || !is_uploaded_file($userLogo['tmp_name'][0])){
        if(FItineraryManager::GetInstance()->Update($idUser, $idItinerary, $title, $description, $duration, $distance, $country, $waypoints)) { 
            echo '{ "ReturnCode": 70, "Message": "Itinerary updated"}';
            exit();
        }
        echo '{ "ReturnCode": 71, "Message": "Itinerary update fail"}';
        exit();
    }
    else{
        for($i = 0;$i<count($userLogo['tmp_name']);$i++){
            $data = file_get_contents($userLogo['tmp_name'][i]);
            //Get MIME type 
            //Need to uncomment the line : extension=fileinfo in php.ini
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($userLogo['tmp_name'][i]);
            array_push($srcPhotos, 'data:'.$mime.';base64,'.base64_encode($data)); 
        }             
        if(FItineraryManager::GetInstance()->Update($idUser, $idItinerary, $title, $description, $duration, $distance, $country,$waypoints, $srcPhotos)) { 
            echo '{ "ReturnCode": 70, "Message": "Itinerary updated"}';
            exit();
        }
        echo '{ "ReturnCode": 71, "Message": "Itinerary update fail"}';
        exit();
    }
    }
    echo '{ "ReturnCode": 42, "Message": "Distance not valid"}';
    exit();
}

?>