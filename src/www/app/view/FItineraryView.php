<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  FHomeView.
*     Brief               :  home view.
*     Date                :  02.06.2020.
*/
//Requirements
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FUserManager.php';

/**
 * Represents home page view.
 */
class FItineraryView{
    /**
     * @brief Class constructor
     */
    function __construct(){}
    /**
     * @brief Display all itineraries
     * 
     * @param array $itineraries all itineraries to display
     * 
     * @return string code html to display 
     */
    /*public static function DisplayItineraries($itineraries) : string{
        $result = '';
        if($itineraries == FALSE)
        {
            $result .= <<<EX
            <div class="lead font-weight-bold">You don't create itinerary yet</div>
            EX;
        }
        else{
            for($i = 0;$i<count($itineraries);$i++){
                $result .= <<<EX
                <div class="col-md-6 col-lg-4 mb-5">
                <div class="portfolio-item mx-auto card" data-toggle="modal" data-target="#portfolioModal{$itineraries[$i]->Id}">
                    <img id="map{$itineraries[$i]->Id}" class="card-img-top" style="width: 100%; height: 200px;">
                    <div class="card-body">                       
                        <a href="./itineraryDetails.php?id={$itineraries[$i]->Id}" ><h5 class="card-title">{$itineraries[$i]->Title}</h5></a>
                        <p class="card-text">{$itineraries[$i]->Description}</p>
                        <a href="#" id="info{$itineraries[$i]->Id}" class="btn btn-primary">More infos</a>
                    </div>
                </div>
                </div>
                EX;
            }
        }
        return $result;
    }*/
    /**
* @brief Display all itineraries
*
* @param array $itineraries all itineraries to display
*
* @return string code html to display
*/
public static function DisplayItineraries($itineraries) : string{
    $result = '';
    if($itineraries == FALSE)
    {
    $result .= <<<EX
    <div class="lead font-weight-bold">You don't create itinerary yet</div>
    EX;
    }
    else{
    for($i = 0;$i<count($itineraries);$i++){
    $result .= self::DisplayItinerary($itineraries[$i]);
    }
    }
    return $result;
    }
    
    /**
    * @brief Display one itinerariy
    *
    * @param FItinary $itineraries all itineraries to display
    *
    * @return string code html to display
    */
    private static function DisplayItinerary($itinerary) : string{
    $result = '';
    if($itinerary == FALSE)
    {
    $result .= <<<EX
    <div class="lead font-weight-bold">No itinerary available here, maybe create on ?</div>
    EX;
    }
    else{
    $result .= <<<EX
    <div class="col-md-6 col-lg-4 mb-5">
    <div class="portfolio-item mx-auto card" data-toggle="modal" data-target="#portfolioModal{$itinerary->Id}">
    <div id="map{$itinerary->Id}" class="card-img-top" style="width: 100%; height: 200px;"></div>
    <div class="card-body">
    <a href="./itineraryDetails.php?id={$itinerary->Id}" ><h5 class="card-title">{$itinerary->Title}</h5></a>
    <p class="card-text">{$itinerary->Description}</p>
    <a href="#" id="info{$itinerary->Id}" class="btn btn-primary">More infos</a>
    </div>
    </div>
    </div>
    EX;
    }
    return $result;
    }
    /**
     * @brief Display all photos uploaded for a itinerary
     * 
     * @param array $photos All the photos to display
     * 
     * @return string code html to display
     */
    public static function DisplayPhotosItineraries($photos){
        $result = '';
        if($photos != FALSE){
            for($i = 0;$i<count($photos);$i++){
                if($i > 0){
                    $result .= <<<EX
                    <div class="carousel-item active">
                        <img class="d-block w-100" height="450px" src="{$photos[$i]->Image}" alt="Photo from itinerary">
                    </div>
                EX;
                }else{
                    $result .= <<<EX
                        <div class="carousel-item">
                            <img class="d-block w-100" width="400px" height="450px" src="{$photos[$i]->Image}" alt="Photo from itinerary">
                        </div>
                    EX;
                }
            }
        }
        return $result;
    }
    /**
     * @brief Display all comments added for a itinerary
     * 
     * @param array $comments All the comments to display
     * 
     * @return string code html to display
     */
    public static function DisplayCommentsItineraries($comments){
        $result = '';
        if($comments != FALSE){
            for($i = 0;$i<count($comments);$i++){    
                $result .= <<<EX
                    <div class="d-flex flex-row comment-row m-t-0">
                        <div class="p-2"><img src="{$comments[$i]->User->Avatar}" alt="user" width="50" class="rounded-circle"></div>
                        <div class="comment-text w-100">
                            <h6 class="font-medium">{$comments[$i]->User->Nickname}</h6> <span class="m-b-15 d-block">{$comments[$i]->Comment}</span>
                            <div class="comment-footer"> <span class="text-muted float-right">{$comments[$i]->PostedAt}</span> 
                        </div>
                    </div> 
                EX;
            }
        }
        return $result;
    }
}

?>