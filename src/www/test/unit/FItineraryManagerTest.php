<?php
//Requirements
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FItineraryManager.php';

//=========================================
// Tests
//=========================================

//Check GetAll function
$allItinerary = FItinerary::GetInstance()->GetAll();
if($allItinerary != FALSE){
    echo "GetAll  :   Work !";
    var_dump($allItinerary);
}
else{
    echo "GetAll  :   Error !";
}
?>