<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  getUser.
*     Brief               :  api to recover the user.
*     Date                :  04.09.2019.
*/

//requirements
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/app/controller/userController.php';

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);

//set controller
$userController = new UserController();

if($id !== false && $id !== null){
    $user = $userController->getUserById($id);
}