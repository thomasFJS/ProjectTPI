<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  login.
*     Brief               :  api to log the user.
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

    if($userLogged !== null) {
        if(!FUserManager::GetInstance()->VerifyActivation($userLogged->Nickname)){
            echo '{ "ReturnCode": 3, "Message": "Account not activate."}';
            exit();
        }
        FSessionManager::setUserLogged($userLogged);
        $_SESSION['isLogged'] = true;

        echo '{ "ReturnCode": 0, "Message": "Login done"}';
        exit();
    }

    echo '{ "ReturnCode": 2, "Message": "Wrong username or password"}';
}
?>