<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  cancelFilter.
*     Brief               :  api to cancel the itinerary filter.
*     Date                :  04.06.2020.
*/

//requirements
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FSessionManager.php';

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

FSessionManager::UnsetItineraryFilter();

?>