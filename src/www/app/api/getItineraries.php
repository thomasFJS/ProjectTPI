<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  getItineraries.
*     Brief               :  Api to get all itineraries store in database.
*     Date                :  02.06.2020.
*/
/* Requirements */
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FItineraryManager.php';

/* Set document type to text/javascript */
header("Content-type: text/javascript");

/* Encode the array with all itineraries as json. */
echo json_encode(FItineraryManager::GetInstance()->GetAll());
?>