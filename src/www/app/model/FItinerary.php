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
     * @param string $StatusParam itinerary's country
     * @param int $StatusParam user's status code
     * @param int $RoleParam user's role code
     */
    public function __construct(int $IdParam = "", string $EmailParam = "", string $NicknameParam = "", string $NameParam = "", string $SurnameParam = "", string $BioParam = "", string $AvatarParam = "", string $CountryParam = "", int $StatusParam = "", int $RoleParam = "")
    {
        $this->Id = $IdParam;
        $this->Email = $EmailParam;
        $this->Nickname = $NicknameParam;
        $this->Name = $NameParam;
        $this->Surname = $SurnameParam;
        $this->Bio = $BioParam;
        $this->Avatar = $AvatarParam;
        $this->Country = $CountryParam
        $this->Status = $StatusParam;
        $this->Role = $RoleParam;
    } 

    public int $Id;

    public string $Email;

    public string $Nickname;

    public string $Name;

    public string $Surname;

    public string $Bio;

    public string $Avatar;

    public string $Country;

    public int $Status;

    public int $Role;

}
?>