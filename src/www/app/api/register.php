<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  register.
*     Brief               :  api to register the user used for ajax call.
*     Date                :  19.05.2020.
*/

//requirements
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FUserManager.php';

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

//Init
$nickname = filter_input(INPUT_POST, "nickname", FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
$verifyPassword = filter_input(INPUT_POST, "verifyPassword", FILTER_SANITIZE_STRING);

// Regex with min 8 char, 1 maj and 1 number
$regex = "/^(?=\w{8,})(?=[^a-z]*[a-z])(?=[^A-Z]*[A-Z])(\w*\d)\w*/"; 

// if all field aren't empty
if (strlen($nickname) > 2 && strlen($email) > 0 && strlen($password) > 0 && strlen($verifyPassword) > 0) { 
    // if regex match with password
    if ((preg_match($regex, $password))) {
        // Both password match
        if ($password == $verifyPassword) {            
            // if account is register
            if(FUserManager::GetInstance()->Register($email, $nickname, $password)) { 
                echo '{ "ReturnCode": 0, "Message": "Register done"}';
                exit();
            }
            echo '{ "ReturnCode": 1, "Message": "Register fail"}';
            exit();
        }       
        echo '{ "ReturnCode": 2, "Message": "Different passwords"}';
        exit();
    }
    echo '{ "ReturnCode": 3, "Message": "Password dont match requirements"}';
    exit();
}

?>