<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  getMyItineraries.
*     Brief               :  Api to get only the itineraries created by the user logged.
*     Date                :  02.06.2020.
*/
/* Requirements */
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FItineraryManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FSessionManager.php';

/* Set document type to text/javascript */
header("Content-type: text/javascript");

/* Encode the array with all itineraries as json. */
echo json_encode(FItineraryManager::GetInstance()->GetAllByUserId(FSessionManager::getUserLogged()->Id));
?>