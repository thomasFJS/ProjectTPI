<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  logout.
*     Brief               :  logout page.
*     Date                :  04.09.2019.
*/


if (session_status() == PHP_SESSION_NONE){
    session_start();
}

$_SESSION = array();

if(ini_get("session.use_cookies")){
    setcookie(session_name(), '', 0);
}

session_destroy();
header("Location: index.php");
?>