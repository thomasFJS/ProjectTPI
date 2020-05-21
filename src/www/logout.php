<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  logout.
*     Brief               :  logout page.
*     Date                :  04.09.2019.
*/
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/controller/sessionController.php';

if (session_status() == PHP_SESSION_NONE){
    session_start();
}
TSessionController::ResetSession();

header("Location: index.php");
?>