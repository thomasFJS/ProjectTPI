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
     * @param string $CountryParam itinerary's country
     * @param string $StatusParam itinerary's status
     * @param Array<FWaypoint> $WaypointsParam Array with all itinerary's waypoints.
     * @param Array<FComment> $CommentsParam Array with all itinerary's comments.
     */
    public function __construct(int $IdParam = "", string $TitleParam = "", string $RatingParam = "", string $DescriptionParam = "", string $DurationParam = "", string $DistanceParam = "", string $CountryParam = "", int $StatusParam = "", array $WaypointsParam, array $CommentsParam)
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
    } 

    /**
    * @var int Itinerary's unique id
    */
    public int $Id;

    /**
    * @var string Itineray's title
    */
    public string $Title;

    /**
    * @var string Itinerary's rating
    */
    public string $Rating;

    /**
    * @var string Itinerary's description
    */
    public string $Description;

    /**
    * @var string Itinerary's duration
    */
    public string $Duration;

    /**
    * @var string Itinerary's distance
    */
    public string $Distance;

    /**
    * @var string Itinerary's country 
    */
    public string $Country;

    /**
    * @var int Itinerary's status
    */
    public int $Status;
    /**
    * @var array Array with all itinerary's waypoints
    */
    public array $Waypoints;
    /**
    * @var array Array with all itinerary's comments
    */
    public array $Comments;
}
?>