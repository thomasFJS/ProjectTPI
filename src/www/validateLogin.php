<?php
require_once("./inc/dbConnect.php");
require_once("./inc/function.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
    
    // Crée les variables
    $emailUser = FILTER_INPUT(INPUT_POST,"email",FILTER_VALIDATE_EMAIL);
    $password = FILTER_INPUT(INPUT_POST,"password",FILTER_SANITIZE_STRING);
    $erreur = [];

    // Vérifie si le champ email est bien une email
    if (!$emailUser)
    {
        $erreur["email"] = ".";
    }

    // Vérifie si le champ password n'est pas vide ou faux.
    if (!$password)
    {
        $erreur["password"] = ".";
    }

    // Continue si il n'y a aucune érreur.
    if (count($erreur) == 0)
    {
        $password = sha1($emailUser.$password);
        // Vérifie si les entrés sont justes.
        if (verifyUser($emailUser,$password))
        {
            //Vérifie si le compte est activé
            if(!verifyActivation($emailUser)){
                echo '{ "ReturnCode": 3, "Message": "Account not activate."}';
                exit();
            }
            // Connecte l'utilisateur
            //connectUser($emailUser);
            //header("Location: index.php");
            echo '{ "ReturnCode": 0, "Message": "Good email and password."}';
            exit();
        }
        else
        {
            echo '{ "ReturnCode": 2, "Message": "Wrong email or password."}';
            exit();
        }
    }
    echo '{ "ReturnCode": 1, "Message": "Missing value or wrong."}';
?>