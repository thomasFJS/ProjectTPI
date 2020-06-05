<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  logout.
*     Brief               :  logout page.
*     Date                :  05.06.2020.
*/
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FSessionManager.php';

if (session_status() == PHP_SESSION_NONE){
    session_start();
}
FSessionManager::Reset();

header("Location: index.php");
?>