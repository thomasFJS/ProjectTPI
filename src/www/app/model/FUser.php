<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  FUser.
*     Brief               :  User's model.
*     Date                :  28.05.2020.
*     Version             :  1.0.
*/

/**
 * Represents an user.
 */
class FUser{
    
    /**
     * @brief Class constructor, create an user with specified details
     * 
     * @param int $IdParam user's id
     * @param string $EmailParam user's email
     * @param string $NicknameParam user's nickname
     * @param string $NameParam user's name
     * @param string $SurnameParam user's surname
     * @param string $BioParam user's bio
     * @param string $AvatarParam user's avatar
     * @param string $CountryParam user's country
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
        $this->Country = $CountryParam;
        $this->Status = $StatusParam;
        $this->Role = $RoleParam;
    } 

    /**
     * @var int User's unique id
     */
    public int $Id;
    /**
     * @var string User's email
     */
    public string $Email;

    /**
     * @var string User's nickname
     */
    public string $Nickname;

    /**
     * @var string User's name
     */
    public string $Name;

    /**
     * @var string User's surname
     */
    public string $Surname;

    /**
     * @var string User's bio
     */
    public string $Bio;

    /**
     * @var string User's avatar encoded in base 64
     */
    public string $Avatar;

    /**
     * @var string User's residence country
     */
    public string $Country;

    /**
     * @var int User's account status code
     */
    public int $Status;

    /**
     * @var int User's account role code
     */
    public int $Role;

}
?>