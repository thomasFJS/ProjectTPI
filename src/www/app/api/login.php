<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  login.
*     Brief               :  api to log the user used for ajax call.
*     Date                :  19.05.2020.
*/

//requirements
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FUserManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FSessionManager.php';

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

//Init
$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

if(strlen($username) > 0 && strlen($password) > 0) {

    if(strpos($username, '@')) {
        $userLogged = FUserManager::GetInstance()->Login(['userEmail' => $username, 'userPwd' => $password]);
    } else {
        $userLogged = FUserManager::GetInstance()->Login(['userNickname' => $username, 'userPwd' => $password]);
    }

    if($userLogged !== false) {
        if(FUserManager::GetInstance()->VerifyActivation($userLogged->Nickname)==1){
            echo '{ "ReturnCode": 11, "Message": "Account not activate."}';
            exit();
        }
        elseif(FUserManager::GetInstance()->VerifyActivation($userLogged->Nickname)==3){
            echo '{ "ReturnCode": 13, "Message": "Account blocked."}';
            exit();
        }
        FSessionManager::setUserLogged($userLogged);
        $_SESSION['isLogged'] = true;

        echo '{ "ReturnCode": 10, "Message": "Login done"}';
        exit();
    }

    echo '{ "ReturnCode": 12, "Message": "Wrong username or password"}';
}
?>