<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  dbConnect.
*     Brief               :  Model pour les pays.
*     Date                :  04.09.2019.
*/

/**
 * Class conteneur qui permet de récupérer les éléments de la bd
 */
class TCountry{
    /**
    * @brief Constructeur appelé à la création de l'objet
    */
    public function __construct($NameParam, $CodeParam)
    {
        $this->Name = $NameParam;
        $this->Code = $CodeParam;
    } 

    public $Name;
    public $Code;
}
?>