<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  FWaypoint.
*     Brief               :  Waypoint's model.
*     Date                :  28.05.2020.
*     Version             :  1.0.
*/

/**
 * Represents an waypoint.
 */
class FWaypoint{
    
    /**
     * @brief Class constructor, create an waypoint with specified details
     * 
     * @param int $IndexParam waypoint's index
     * @param string $AddressParam waypoint's address
     * @param string $LongitudeParam waypoints's longitude
     * @param string $LatitudeParam waypoints's latitude
     */
    public function __construct(int $IndexParam = "", string $AddressParam = "", string $LongitudeParam = "", string $LatitudeParam = "")
    {
        $this->Index = $IndexParam;
        $this->Address = $AddressParam;
        $this->Longitude = $LongitudeParam;
        $this->Latitude = $LatitudeParam;
    } 

    public int $Index;

    public string $Address;

    public string $Longitude;

    public string $Latitude;

}
?>