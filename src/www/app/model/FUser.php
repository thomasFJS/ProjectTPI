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