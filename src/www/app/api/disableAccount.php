<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  disableAccount.
*     Brief               :  api to disable the account used for ajax call.
*     Date                :  04.06.2020.
*/

//requirements
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FUserManager.php';

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

$nickname = filter_input(INPUT_POST, "nickname", FILTER_SANITIZE_STRING);

if(FUserManager::GetInstance()->DisableAccount($nickname)){
    echo '{ "ReturnCode": 80, "Message": "Account disabled"}';
    exit();
}else{
    echo '{ "ReturnCode": 81, "Message": "Disable account fail"}';
    exit();
}

?>