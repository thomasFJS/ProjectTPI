<?php
//Requirements
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FUserManager.php';

//=========================================
// Tests
//=========================================



//Check Register function
$userWillRegister = FUserManager::getInstance()->Register("John@Doe.com", "JohnDoe59", "Super2012");
$userWontRegister = FUserManager::getInstance()->Register("John@Doe.com", "JohnDoe95", "Super2012");
$userWontRegister2 = FUserManager::getInstance()->Register("Doe@john.com", "JohnDoe59", "Super2012");
if($userWillRegister == TRUE && $userWontRegister == FALSE && $userWontRegister2 == FALSE){
    echo "Register  :   Work !";
}
else{
    echo "Register  :   Error !";
}

//Check Login function
$userWillLogin = FUserManager::getInstance()->Login(['userEmail' => "John@Doe.com", 'userPwd' => "Super2012"]);
$userWontLogin = FUserManager::getInstance()->Login(['userEmail' => "John@Doe.com", 'userPwd' => "Super"]);
if($userWillLogin != FALSE && $userWontLogin == FALSE){
    echo "Login  :   Work !";
    var_dump($userWillLogin);
}
else{
    echo "Login  :   Error !";
}

//Check GetHashPassword function
if(FUserManager::getInstance()->GetHashPassword("John@Doe.com") != FALSE){
    echo "GetHashPassword  :   Work !";
}
else{
    echo "GetHashPassword  :   Error !";
}

//Check IsAllowed function
$userIsAllowed = new FUser(1, "John@Doe.com", "JohnDoe59","John","Doe","dd", "sdsf", "CH", 2, 2);
$userIsntAllowed = new FUser(1, "John@Doe.com", "JohnDoe59","John","Doe","dd", "sdsf", "CH", 2, 1);
if(FUserManager::getInstance()->IsAllowed($userIsAllowed) == TRUE && FUserManager::getInstance()->IsAllowed($userIsntAllowed) == FALSE){
    echo "IsAllowed  :   Work !";
}
else{
    echo "IsAllowed  :   Error !";
}



?>