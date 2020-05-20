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

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

//Init
$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
$userController = new userController();

if(strlen($username) > 0 && strlen($password) > 0) {

    if(strpos($username, '@')) {
        $userLogged = $userController->Login(['userEmail' => $username, 'userPwd' => $password]);
    } else {
        $userLogged = $userController->Login(['userNickname' => $username, 'userPwd' => $password]);
    }

    if($userLogged !== null) {
        $_SESSION['userLogged'] = $userLogged;
        $_SESSION['isLogged'] = true;

        echo '{ "ReturnCode": 0, "Message": "Login done"}';
        exit();
    }

    echo '{ "ReturnCode": 2, "Message": "Wrong username or password"}';
}
?>