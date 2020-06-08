<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  createItinerary.
*     Brief               :  api to create itinerary used for ajax call.
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
$country = filter_input(INPUT_POST, "country", FILTER_SANITIZE_STRING);
$description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);
$duration = filter_input(INPUT_POST, "duration", FILTER_SANITIZE_STRING);
$distance = filter_input(INPUT_POST, "distance", FILTER_VALIDATE_FLOAT);
$waypoints = json_decode($_POST['waypoints']);
$idUser = FSessionManager::GetUserLogged()->Id;

if(isset($_FILES["media"])){
    $photos = $_FILES["media"];
}
//Array for all images uploaded encoded in base 64
$srcPhotos = [];
// if all field aren't empty
if (strlen($title) > 2 && strlen($description) > 0 && strlen($duration) > 0) { 
    if($distance < 999 || $distance > 1) {     
    // if user add photos to his itinerary
    if(!isset($photos) || !is_uploaded_file($photos['tmp_name'][0])){
        if(FItineraryManager::GetInstance()->Create($title, $description, $duration, $distance, $country, $waypoints,$idUser)) { 
            echo '{ "ReturnCode": 40, "Message": "Create itinerary done"}';
            exit();
        }
        echo '{ "ReturnCode": 41, "Message": "Create itinerary fail"}';
        exit();
    }
    else{
        for($i = 0;$i<count($photos['tmp_name']);$i++){
            $data = file_get_contents($photos['tmp_name'][$i]);
            //Get MIME type 
            //Need to uncomment the line : extension=fileinfo in php.ini
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($photos['tmp_name'][$i]);
            array_push($srcPhotos, 'data:'.$mime.';base64,'.base64_encode($data)); 
        }             
        if(FItineraryManager::GetInstance()->Create($title, $description, $duration, $distance, $country, $waypoints,$idUser, $srcPhotos)) { 
            echo '{ "ReturnCode": 40, "Message": "Create itinerary done"}';
            exit();
        }
        echo '{ "ReturnCode": 41, "Message": "Create itinerary fail"}';
        exit();
    }
    }
    echo '{ "ReturnCode": 42, "Message": "Distance not valid"}';
    exit();
}

?>