<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  getItineraryById.
*     Brief               :  Api to get the FItinerary object with itinerary id
*     Date                :  03.06.2020.
*/
/* Requirements */
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FItineraryManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FSessionManager.php';

/* Set document type to text/javascript */
header("Content-type: text/javascript");
$id = $_GET['id'];

/* Encode the object FItinerary as json. */
echo json_encode(FItineraryManager::GetInstance()->GetById($id));
?>