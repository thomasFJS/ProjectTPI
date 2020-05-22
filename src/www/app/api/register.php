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

if(isset($_FILES["media"])){
    $userLogo = $_FILES["media"];
}
$srcLogo = "";

// Regex with min 8 char, 1 maj and 1 number
$regex = "/^(?=\w{8,})(?=[^a-z]*[a-z])(?=[^A-Z]*[A-Z])(\w*\d)\w*/"; 

// if all field aren't empty
if (strlen($nickname) > 2 && strlen($email) > 0 && strlen($password) > 0 && strlen($verifyPassword) > 0) { 
    // if regex match with password
    if ((preg_match($regex, $password))) {
        // Both password match
        if ($password == $verifyPassword) { 
            if (!isset($userLogo) || !is_uploaded_file($userLogo['tmp_name'][0])) {
                $srcLogo = "s";
            } 
            else{
                $data = file_get_contents($userLogo['tmp_name'][0]);
                //Get MIME type 
                //Need to uncomment the line : extension=fileinfo in php.ini
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mime = $finfo->file($userLogo['tmp_name'][0]);
                $srcLogo = 'data:'.$mime.';base64,'.base64_encode($data);
            }
            // if account is register
            if(UserController::getInstance()->RegisterNewUser($email, $nickname, $password, $country, $birthday, $srcLogo)) { 
                echo '{ "ReturnCode": 0, "Message": "Register done"}';
                /*echo json_encode([
                    'ReturnCode' => 0,
                    'Message' => "Register done"
                ]);*/
                exit();
            }
            echo '{ "ReturnCode": 3, "Message": "Register fail"}';
            /*echo json_encode([
                'ReturnCode' => 3,
                'Message' => "Register fail"
            ]);*/
            exit();
        }       
       // echo '{ "ReturnCode": 4, "Message": "Different passwords"}';
        echo json_encode([
            'ReturnCode' => 4,
            'Message' => "Different passwords"
        ]);
        exit();
    }
    //echo '{ "ReturnCode": 5, "Message": "Password dont match requirements"}';
    echo json_encode([
        'ReturnCode' => 5,
        'Message' => "Password dont match requirements"
    ]);
    exit();
}

?>