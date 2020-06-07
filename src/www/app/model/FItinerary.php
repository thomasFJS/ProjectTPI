<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  FItinerary.
*     Brief               :  Itinerary's model.
*     Date                :  28.05.2020.
*     Version             :  1.0.
*/

/**
 * Represents an itinerary.
 */
class FItinerary{
    
    /**
     * @brief Class constructor, create an itinerary with specified details
     * 
     * @param int $IdParam itinerary's id
     * @param string $TitleParam itinerary's title
     * @param string $RatingParam itinerary's average rating
     * @param string $DescriptionParam itinerary's description
     * @param string $DurationParam itinerary's duration
     * @param string $DistanceParam itinerary's distance
     * @param string $PreviewParam itinerary's preview image encoded in base 64
     * @param string $CountryParam itinerary's country
     * @param string $StatusParam itinerary's status
     * @param Array<FWaypoint> $WaypointsParam Array with all itinerary's waypoints.
     * @param Array<FComment> $CommentsParam Array with all itinerary's comments.
     * @param Array<FPhotos> $PhotosParam Array with all itinerary's photos.
     * @param int $UserParam Owner's id
     */
    public function __construct(int $IdParam , string $TitleParam = "", $RatingParam , string $DescriptionParam = "", string $DurationParam = "", string $DistanceParam = "", string $CountryParam = "", int $StatusParam , array $WaypointsParam, $CommentsParam, $PhotosParam, int $UserParam)
    {
        $this->Id = $IdParam;
        $this->Title = $TitleParam;
        $this->Rating = $RatingParam;
        $this->Description = $DescriptionParam;
        $this->Duration = $DurationParam;
        $this->Distance = $DistanceParam;
        $this->Country = $CountryParam;
        $this->Status = $StatusParam;
        $this->Waypoints = $WaypointsParam;
        $this->Comments = $CommentsParam;
        $this->Photos = $PhotosParam;
        $this->User = $UserParam;
    } 

    /**
    * @var int Itinerary's unique id
    */
    public $Id;

    /**
    * @var string Itineray's title
    */
    public $Title;

    /**
    * @var string Itinerary's rating
    */
    public $Rating;

    /**
    * @var string Itinerary's description
    */
    public $Description;

    /**
    * @var string Itinerary's duration
    */
    public $Duration;

    /**
    * @var string Itinerary's distance
    */
    public $Distance;
    /**
    * @var string Itinerary's country 
    */
    public $Country;

    /**
    * @var int Itinerary's status
    */
    public $Status;
    /**
    * @var array Array with all itinerary's waypoints
    */
    public $Waypoints;
    /**
    * @var array Array with all itinerary's comments
    */
    public $Comments;
    /**
     * @var array Array with all itinerary's photos
     */
    public $Photos;
    /**
     * @var int owner's id
     */
    public $User;
}
?>