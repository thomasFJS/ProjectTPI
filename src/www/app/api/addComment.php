<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  addComment.
*     Brief               :  api to add a comment to an itinerary used for ajax call.
*     Date                :  04.06.2020.
*/

//requirements
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FItineraryManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FSessionManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FCommentManager.php';

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

//Init
$title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
$comment = filter_input(INPUT_POST, "comment", FILTER_SANITIZE_STRING);
$idUser = FSessionManager::GetUserLogged()->Id;
$idItinerary = FItineraryManager::GetInstance()->GetByTitle($title)->Id;
// if all field aren't empty
if (strlen($title) > 2 && strlen($comment) > 0) {       
    if(FCommentManager::GetInstance()->AddToItinerary($idItinerary, $idUser, $comment)) { 
        echo '{ "ReturnCode": 50, "Message": "Comment added"}';
        exit();
    }
    echo '{ "ReturnCode": 51, "Message": "Add comment fail"}';
    exit();
}

?>