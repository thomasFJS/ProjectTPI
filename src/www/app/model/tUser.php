<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  tUser.
*     Brief               :  Model pour utilisateur
*     Date                :  04.09.2019.
*/

/**
 * Class conteneur qui permet de récupérer les éléments de la bd
 */
class TUser{
    /**
    * @brief Constructeur appelé à la création de l'objet
    */
    public function __construct($NicknameParam = "", $EmailParam = "", $CountryParam = "",$BirthdayParam = "",$RoleParam = "", $LogoParam ="", $ActivationParam = 0, $StateParam = 1)
    {
        $this->Nickname = $NicknameParam;
        $this->Email = $EmailParam;
        $this->Country = $CountryParam;
        $this->Birthday = $BirthdayParam;
        $this->Activation = $ActivationParam;
        $this->State = $StateParam;
        $this->Role = $RoleParam;
        $this->Logo = $LogoParam;
    } 

    public $Nickname;

    public $Email;

    public $Country;

    public $Birthday;

    public $Activation;

    public $State;

    public $Role;

    public $Logo;
}
?>