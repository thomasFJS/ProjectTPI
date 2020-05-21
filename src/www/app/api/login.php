<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  login.
*     Brief               :  api to log the user.
*     Date                :  19.05.2020.
*/

//requirements
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/controller/userController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/controller/sessionController.php';

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

//Init
$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

if(strlen($username) > 0 && strlen($password) > 0) {

    if(strpos($username, '@')) {
        $userLogged = userController::getInstance()->Login(['userEmail' => $username, 'userPwd' => $password]);
    } else {
        $userLogged = userController::getInstance()->Login(['userNickname' => $username, 'userPwd' => $password]);
    }

    if($userLogged !== null) {
        if(!userController::getInstance()->VerifyActivation($userLogged->Nickname)){
            echo '{ "ReturnCode": 3, "Message": "Account not activate."}';
            exit();
        }
        TSessionController::setUserLogged($userLogged);
        $_SESSION['isLogged'] = true;

        echo '{ "ReturnCode": 0, "Message": "Login done"}';
        exit();
    }

    echo '{ "ReturnCode": 2, "Message": "Wrong username or password"}';
}
?>