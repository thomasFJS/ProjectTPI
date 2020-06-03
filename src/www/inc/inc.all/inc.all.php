<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjectTPI.
*     Page                :  Inc.All.
*     Brief               :  Page to include where you need manager or model.
*     Date                :  03.06.2020.
*/

/*Manager */
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FItineraryManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FUserManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FDatabaseManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FWaypointsManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FSessionManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FPhotoManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FMailerManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FCommentManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FCodeManager.php';

/*Model */
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/model/FComment.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/model/FCountry.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/model/FItinerary.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/model/FPhoto.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/model/FUser.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/model/FWaypoint.php';
?>