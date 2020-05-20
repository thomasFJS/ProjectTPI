<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  register.
*     Brief               :  api to register the user.
*     Date                :  19.05.2020.
*/

//requirements
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/controller/userController.php';

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

//Init
$nickname = filter_input(INPUT_POST, "nickname", FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$country = filter_input(INPUT_POST, "country", FILTER_SANITIZE_STRING);
$birthday = filter_input(INPUT_POST, "birthday", FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
$verifyPassword = filter_input(INPUT_POST, "verifyPassword", FILTER_SANITIZE_STRING);
$userController = new UserController();

// Regex with min 8 char, 1 maj and 1 number
$regex = "/^(?=\w{8,})(?=[^a-z]*[a-z])(?=[^A-Z]*[A-Z])(\w*\d)\w*/"; 

// if all field aren't empty
if (strlen($nickname) > 2 && strlen($email) > 0 && strlen($password) > 0 && strlen($verifyPassword) > 0) { 
    // if regex match with password
    if ((preg_match($regex, $password))) {
        // Both password match
        if ($password == $verifyPassword) { 
            // if account is register
            if($userController->RegisterNewUser($email, $nickname, $password, $country, $birthday)) { 
                //echo '{ "ReturnCode": 0, "Message": "Register done"}';
                echo json_encode([
                    'ReturnCode' => 0,
                    'Message' => "Register done"
                ]);
                exit();
            }
            //echo '{ "ReturnCode": 3, "Message": "Register fail"}';
            echo json_encode([
                'ReturnCode' => 3,
                'Message' => "Register fail"
            ]);
        }       
       // echo '{ "ReturnCode": 4, "Message": "Different passwords"}';
        echo json_encode([
            'ReturnCode' => 4,
            'Message' => "Different passwords"
        ]);
    }
    //echo '{ "ReturnCode": 5, "Message": "Password dont match requirements"}';
    echo json_encode([
        'ReturnCode' => 5,
        'Message' => "Password dont match requirements"
    ]);
}

?>