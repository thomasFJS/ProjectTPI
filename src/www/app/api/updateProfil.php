<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  updateProfil.
*     Brief               :  api to update the profil.
*     Date                :  04.06.2020.
*/

//requirements
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FUserManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FSessionManager.php';

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

//Init
$nickname = filter_input(INPUT_POST, "nickname", FILTER_SANITIZE_STRING);
$name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
$surname = filter_input(INPUT_POST, "surname", FILTER_SANITIZE_STRING);
$userBio = filter_input(INPUT_POST, "userBio", FILTER_SANITIZE_STRING);
$country = filter_input(INPUT_POST, "country", FILTER_SANITIZE_STRING);

$idUser = FSessionManager::GetUserLogged()->Id;

if(isset($_FILES["media"])){
    $avatar = $_FILES["media"];
}
//Get current user's avatar
$srcAvatar = FSessionManager::GetUserLogged()->Avatar;
// if the required field isn't't empty
if (strlen($nickname) > 2) {    
    // if user don't add avatar
    if(!isset($avatar) || !is_uploaded_file($avatar['tmp_name'][0])){
        if(FUserManager::GetInstance()->UpdateInfos($idUser, $nickname, $name, $surname, $userBio, $country, $srcAvatar)) { 
            FSessionManager::SetUserLogged(FUserManager::GetInstance()->GetById($idUser));
            echo '{ "ReturnCode": 30, "Message": "Infos updated"}';
            exit();
        }
        echo '{ "ReturnCode": 31, "Message": "Update fail"}';
        exit();
    }
    else{
        $data = file_get_contents($avatar['tmp_name'][0]);
        //Get MIME type 
        //Need to uncomment the line : extension=fileinfo in php.ini
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($avatar['tmp_name'][0]);
        $srcAvatar = 'data:'.$mime.';base64,'.base64_encode($data); 
        if(FUserManager::GetInstance()->UpdateInfos($idUser, $nickname, $name, $surname, $userBio, $country, $srcAvatar)) { 
            FSessionManager::SetUserLogged(FUserManager::GetInstance()->GetById($idUser));
            echo '{ "ReturnCode": 30, "Message": "Infos updated"}';
            exit();
        }
        echo '{ "ReturnCode": 31, "Message": "Update fail"}';
        exit();
    }
    
}

?>