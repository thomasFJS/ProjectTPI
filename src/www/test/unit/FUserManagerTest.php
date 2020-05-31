<?php
//Requirements
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FUserManager.php';

//=========================================
// Tests
//=========================================


//Check Register function
$userWillRegister = FUserManager::GetInstance()->Register("John@Doe.com", "JohnDoe59", "Super2012");
$userWontRegister = FUserManager::GetInstance()->Register("John@Doe.com", "JohnDoe95", "Super2012");
$userWontRegister2 = FUserManager::GetInstance()->Register("Doe@john.com", "JohnDoe59", "Super2012");
if($userWillRegister == TRUE && $userWontRegister == FALSE && $userWontRegister2 == FALSE){
    echo "Register  :   Work !";
}
else{
    echo "Register  :   Error !";
}

//Check Login function
$userWillLogin = FUserManager::GetInstance()->Login(['userEmail' => "John@Doe.com", 'userPwd' => "Super2012"]);
$userWontLogin = FUserManager::GetInstance()->Login(['userEmail' => "John@Doe.com", 'userPwd' => "Super"]);
if($userWillLogin != FALSE && $userWontLogin == FALSE){
    echo "Login  :   Work !";
    var_dump($userWillLogin);
}
else{
    echo "Login  :   Error !";
}

//Check GetHashPassword function
if(FUserManager::GetInstance()->GetHashPassword("John@Doe.com") != FALSE){
    echo "GetHashPassword  :   Work !";
}
else{
    echo "GetHashPassword  :   Error !";
}

//Check IsAllowed function
$userIsAllowed = new FUser(1, "John@Doe.com", "JohnDoe59","John","Doe","dd", "sdsf", "CH", 2, 2);
$userIsntAllowed = new FUser(1, "John@Doe.com", "JohnDoe59","John","Doe","dd", "sdsf", "CH", 2, 1);
if(FUserManager::GetInstance()->IsAllowed($userIsAllowed) == TRUE && FUserManager::GetInstance()->IsAllowed($userIsntAllowed) == FALSE){
    echo "IsAllowed  :   Work !";
}
else{
    echo "IsAllowed  :   Error !";
}

//Check ActivateAccount function
if(FUserManager::GetInstance()->ActivateAccount('f42e0b9cddb7e52702dc3e02b242f212312b171e5b733e98c46ac70fbb64bd86', "John@Doe.com")){
    echo "ActivateAccount  :   Work !";
}
else{
    echo "ActivateAccount  :   Error !";
}

//Check VerifyActivation function
if(FUserManager::GetInstance()->VerifyActivation("JohnDoe59") == TRUE && FUserManager::getInstance()->VerifyActivation("David") == FALSE){
    echo "VerifyActivation  :   Work !";
}
else{
    echo "VerifyActivation  :   Error !";
}

?>