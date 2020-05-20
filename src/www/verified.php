<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/controller/userController.php';

$token = $_GET['token'];
if(UserController::getInstance()->ActivateAccount($token)){    
    echo "Votre compte a bien été activé";
}
else{
    echo "Votre lien n'est pas correct";
}
?>