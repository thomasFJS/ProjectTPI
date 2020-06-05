<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FUserManager.php';

$token = $_GET['token'];
$email = $_GET['email'];
if(FUserManager::getInstance()->ActivateAccount($token, $email)){    
    echo "Your account has been activated";
    //Go on index.php after 3s
    header( "Refresh:3; url=./index.php", true, 303);
}
else{
    echo "Your link doesn't work";
}
?>