<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  FUser.
*     Brief               :  Country's model.
*     Date                :  28.05.2020.
*     Version             :  1.0.
*/

/**
 * Represents an country.
 */
class FCountry{
    /**
     * @brief Class constructor, create an country with iso2 code and name
     * 
     * @param string $NameParam country's name
     * @param string $CodeParam country's iso2 code
     */
    public function __construct(string $NameParam = "", string $CodeParam = "")
    {
        $this->Name = $NameParam;
        $this->Code = $CodeParam;
    } 

    public $Name;

    public $Code;
}
?>