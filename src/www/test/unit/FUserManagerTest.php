<?php
//Requirements
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FUserManager.php';

//=========================================
// Tests
//=========================================



//Check Register function
$userWillRegister = FUserManager::Register("John@Doe.com", "JohnDoe59", password_hash("Super2012"));
$userWontRegister = FUserManager::Register("John@Doe.com", "JohnDoe95", password_hash("Super2012"));
$userWontRegister2 = FUserManager::Register("Doe@john.com", "JohnDoe59", password_hash("Super2012"));
if($userWillRegister == TRUE && $userWontRegister == FALSE && $userWontRegister2 == FALSE){
    echo "Register  :   Work !";
}
else{
    echo "Register  :   Error !";
}

//Check Login function
$userWillLogin = FUserManager::Login("John@Doe.com", "Super2012");
$userWontLogin = FUserManager::Login("John@Doe.com","Super");
if($userWillLogin != FALSE && $userWontLogin == FALSE){
    echo "Login  :   Work !"
    var_dump($user);
}
else{
    echo "Login  :   Error !";
}

//Check GetHashPassword function
if(FUserManager::GetHashPassword(1) != FALSE){
    echo "GetHashPassword  :   Work !";
}
else{
    echo "GetHashPassword  :   Error !";
}

//Check IsAllowed function
$userIsAllowed = new FUser(1, "John@Doe.com", "JohnDoe59","John","Doe","dd", "sdsf", "CH", "2", "2");
$userIsntAllowed = new FUser(1, "John@Doe.com", "JohnDoe59","John","Doe","dd", "sdsf", "CH", "2", "1");
if(FUserManager::IsAllowed($userIsAllowed) == TRUE && FUserManager::IsAllowed($userIsntAllowed) == FALSE){
    echo "IsAllowed  :   Work !";
}
else{
    echo "IsAllowed  :   Error !";
}
?>