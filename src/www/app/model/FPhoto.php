<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  FPhoto.
*     Brief               :  Photo's model.
*     Date                :  28.05.2020.
*     Version             :  1.0.
*/

/**
 * Represents an photo.
 */
class FPhoto{
    /**
     * @brief Class constructor, create an photo
     * 
     * @param string $ImageParam photo's image encoded in base 64
     */
    public function __construct(string $ImageParam = "")
    {
        $this->Image = $ImageParam;
    } 

    /**
     * @var string image encoded in base 64
     */
    public string $Image;
}
?>