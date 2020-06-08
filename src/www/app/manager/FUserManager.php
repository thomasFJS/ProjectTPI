<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  FUserManager.
*     Brief               :  user manager.
*     Date                :  04.09.2019.
*/

//Requirements
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FDatabaseManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FMailerManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/model/FUser.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/constants/constants.php';

/**
 * User's manager, manager for table users in db
 */
class FUserManager extends FDatabaseManager{

    /**
     * @var static $instance the instance for the manager 
     * */
    private static $instance;
    /**
     * @brief Class constructor, init all field from table `USERS`
     */
    function __construct() {
        $this->tableName = "USERS";
        $this->fieldId = "ID";
        $this->fieldEmail = "EMAIL";
        $this->fieldNickname = "NICKNAME";
        $this->fieldPassword = "PASSWORD";
        $this->fieldToken = "TOKEN";
        $this->fieldName = "NAME";
        $this->fieldSurname = "SURNAME";
        $this->fieldBio = "BIO";
        $this->fieldAvatar = "AVATAR";        
        $this->fieldStatus = "STATUS_ID";     
        $this->fieldRole = "ROLES_ID";
        $this->fieldCountry = "COUNTRIES_ISO2";
    }
    /**
     * @brief Get User if login informations are correct
     * 
     * @param array $args Array with login informations.
     * 
     * @return FUser||FALSE
     */
    public function Login(array $args) {
        $args += [
            'userEmail' => null,
            'userNickname' => null,
            'userPwd' => null
        ];

        // Extract the keys of the array has variables
        extract($args);

        $loginField = "";
        $loginValue = "";
        $salt = "";
        if($userEmail !== null){
            $loginValue = $userEmail;
            $loginField = $this->fieldEmail;
   
        } else if($userNickname !== null){
            $loginValue = $userNickname;
            $loginField = $this->fieldNickname;
        
        } else {
            return false;
        }

        if($userPwd === null){
            return false;
        }

        //$pwd = hash("sha256", $userPwd . $salt);

        if(password_verify($userPwd, $this::GetHashPassword($loginValue))){

        $query = <<<EX
            SELECT `{$this->fieldId}`, `{$this->fieldEmail}`, `{$this->fieldNickname}`, `{$this->fieldName}`,`{$this->fieldSurname}`, `{$this->fieldBio}`, `{$this->fieldAvatar}`, `{$this->fieldCountry}`, `{$this->fieldStatus}`, `{$this->fieldRole}`
            FROM `{$this->tableName}`
            WHERE `{$loginField}` = :connectValue
        EX;

        try {
            $req = $this::getDb()->prepare($query);
            $req->bindParam(':connectValue', $loginValue, PDO::PARAM_STR);
            $req->execute();

            $result = $req->fetch(PDO::FETCH_ASSOC);

            return $result !== false > 0 ? new FUser($result[$this->fieldId], $result[$this->fieldEmail],  $result[$this->fieldNickname], $result[$this->fieldName], $result[$this->fieldSurname], $result[$this->fieldBio], $result[$this->fieldAvatar], $result[$this->fieldCountry], $result[$this->fieldStatus], $result[$this->fieldRole]) : FALSE;           
        } catch(PDOException $e) {
            return FALSE;
        }
        }
        else{
            return FALSE;
        }
    }
    /**
     * @brief Register new user
     * 
     * @param string $userEmail Email
     * @param string $userNickname Nickname
     * @param string $userPwd Password
     * @param string $userCountry Country
     * @param string $userBirthday Birthday
     * 
     * @return bool register state 
     */
    public function Register(string $userEmail, string $userNickname, string $userPwd) : bool {
        $query = <<<EX
            INSERT INTO `{$this->tableName}`(`{$this->fieldNickname}`, `{$this->fieldEmail}`, `{$this->fieldPassword}`, `{$this->fieldAvatar}`, `{$this->fieldStatus}`, `{$this->fieldRole}`, `{$this->fieldToken}`)
            VALUES(:userNickname, :userEmail, :userPassword, :userAvatar, :userStatus, :userRole, :token)
        EX;

        $userPwd = password_hash($userPwd, PASSWORD_DEFAULT);

        $token = hash('sha256', $userEmail . microtime());
        //account not activate
        $userStatus = 1;
        //role 1 = user
        $userRole = 1;

        $defaultAvatar = DEFAULT_USER_LOGO;

        try {
            $req = $this::getDb()->prepare($query);
            $req->bindParam(':userNickname', $userNickname, PDO::PARAM_STR);
            $req->bindParam(':userEmail', $userEmail, PDO::PARAM_STR);            
            $req->bindParam(':userPassword', $userPwd, PDO::PARAM_STR);
            $req->bindParam(':userAvatar', $defaultAvatar, PDO::PARAM_STR);
            $req->bindParam(':userStatus', $userStatus, PDO::PARAM_INT);
            $req->bindParam(':userRole', $userRole, PDO::PARAM_INT);
            $req->bindParam(':token', $token, \PDO::PARAM_STR);
            $req->execute();

            FMailerManager::sendMail("Account Activation", array($userEmail), FMailerManager::getActivationMail($token,$userEmail));
            
        } catch(PDOException $e){     
            return FALSE;
        }
        //Done
        return TRUE;
    }
    /**
     * @brief Get hash password 
     * 
     * @param int $idUser user's id
     * 
     * @return string hash password
     */
    public function GetHashPassword(string $loginValue) : string {
        $query = <<<EX
            SELECT `{$this->fieldPassword}` 
            FROM `{$this->tableName}` 
            WHERE EMAIL = :userEmail 
            OR NICKNAME = :userNickname;
        EX;
        try{
        $req = $this::getDb()->prepare($query);
        $req->bindParam(':userEmail', $loginValue, PDO::PARAM_STR);
        $req->bindParam(':userNickname', $loginValue, PDO::PARAM_STR);
        $req->execute();
        $result = $req->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e){       
            return FALSE;
        }
        //Done
        return $result ==! FALSE ? $result['PASSWORD'] : FALSE;
    }
    /**
     * @brief Check if user is admin or not
     * 
     * @param TUser $user User to check
     * 
     * @return bool true if admin, false if user
     */
    public function IsAllowed(FUser $user) : bool {
        return $user->Role == 2 ? TRUE : FALSE;
    }
    /**
     * @brief Check if user is logged or not
     * 
     * @return bool true if user's logged, else false
     */
    public function IsLogged() : bool {
        return isset($_SESSION['userLogged']) ? TRUE : FALSE;
    }
    /**
     * @brief Create the initial instance for the controller or get it
     * @return $instance
     */
    public static function GetInstance(){
        if(!self::$instance){
            self::$instance = new FUserManager();
        }
        return self::$instance;
    }
    /**
     * @brief Activate account with the token
     * 
     * @param string $token activation token
     * 
     * @return bool true if account's activation success, else false
     */
    public function ActivateAccount(string $token, string $userEmail) : bool{
        try{
            $query = <<<EX
                UPDATE `{$this->tableName}` 
                SET `{$this->fieldStatus}`  = 2
                WHERE `{$this->fieldToken}` = :token 
                AND `{$this->fieldEmail}` = :userEmail
            EX;
            $req = $this::getDb()->prepare($query);
            $req->bindParam(':token', $token, \PDO::PARAM_STR);
            $req->bindParam(':userEmail', $userEmail, \PDO::PARAM_STR);
            $req->execute();

        } catch(PDOException $e){           
            return FALSE;
        }
        //Done
        return TRUE;
    }
    /**
     * @brief Verify if account is activated
     * 
     * @param string $nickname user's nickname
     * 
     * @return bool true if account's activated, else false
     */
    public function VerifyActivation(string $nickname){
        $query = <<<EX
            SELECT `{$this->fieldStatus}`
            FROM `{$this->tableName}` 
            WHERE `{$this->fieldNickname}` = :nickname
        EX;
        try{
            $req = $this::getDb()->prepare($query);
            $req->bindParam(':nickname', $nickname, PDO::PARAM_STR);
            $req->execute();

            $result = $req->fetch();
            //return status code
            return $result[0];
        }catch(PDOException $e){
            return FALSE;
        }      
    }
    /**
     * @brief Get user by id
     * 
     * @param int $idUser user's unique id
     * 
     * @return FUser The user with the id
     */
    public function GetById(int $idUser){
        $query = <<<EX
            SELECT `{$this->fieldId}`, `{$this->fieldEmail}`, `{$this->fieldNickname}`, `{$this->fieldName}`,`{$this->fieldSurname}`, `{$this->fieldBio}`, `{$this->fieldAvatar}`, `{$this->fieldCountry}`, `{$this->fieldStatus}`, `{$this->fieldRole}`
            FROM `{$this->tableName}`
            WHERE `{$this->fieldId}` = :idUser
        EX;

        try{
            $req = $this::getDb()->prepare($query);
            $req->bindParam(':idUser', $idUser, PDO::PARAM_INT);
            $req->execute();

            $result = $req->fetch(PDO::FETCH_ASSOC);  
            return $result != false > 0 ? new FUser($result[$this->fieldId], $result[$this->fieldEmail],  $result[$this->fieldNickname], $result[$this->fieldName], $result[$this->fieldSurname], $result[$this->fieldBio], $result[$this->fieldAvatar], $result[$this->fieldCountry], $result[$this->fieldStatus], $result[$this->fieldRole]) : FALSE;            
        }catch(PDOException $e){
            return FALSE;
        }
        
    }
    /**
     * @brief Get user by nickname
     * 
     * @param string $nickname user's unique nickname
     * 
     * @return FUser The user with the nickname
     */
    public function GetByNickname(string $nickname){
        $query = <<<EX
            SELECT `{$this->fieldId}`, `{$this->fieldEmail}`, `{$this->fieldNickname}`, `{$this->fieldName}`,`{$this->fieldSurname}`, `{$this->fieldBio}`, `{$this->fieldAvatar}`, `{$this->fieldCountry}`, `{$this->fieldStatus}`, `{$this->fieldRole}`
            FROM `{$this->tableName}`
            WHERE `{$this->fieldNickname}` = :nickname
        EX;

        try{
            $req = $this::getDb()->prepare($query);
            $req->bindParam(':nickname', $nickname, PDO::PARAM_STR);
            $req->execute();

            $result = $req->fetch(PDO::FETCH_ASSOC);  
            return $result != false > 0 ? new FUser($result[$this->fieldId], $result[$this->fieldEmail],  $result[$this->fieldNickname], $result[$this->fieldName], $result[$this->fieldSurname], $result[$this->fieldBio], $result[$this->fieldAvatar], $result[$this->fieldCountry], $result[$this->fieldStatus], $result[$this->fieldRole]) : FALSE;            
        }catch(PDOException $e){
            return FALSE;
        }
        
    }
    /**
     * @brief Get all users
     * 
     * @return array Array of FUser with all users
     */
    public function GetAll(){
        $result = array();

        $query = <<<EX
            SELECT `{$this->fieldId}`, `{$this->fieldEmail}`, `{$this->fieldNickname}`, `{$this->fieldName}`,`{$this->fieldSurname}`, `{$this->fieldBio}`, `{$this->fieldAvatar}`, `{$this->fieldCountry}`, `{$this->fieldStatus}`, `{$this->fieldRole}`
            FROM `{$this->tableName}`
        EX;

        try{
            $req = $this::getDb()->prepare($query);
            $req->execute();

            while($row=$req->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)){           
                $users = new FUser($row[$this->fieldId], $row[$this->fieldEmail],  $row[$this->fieldNickname], $row[$this->fieldName], $row[$this->fieldSurname], $row[$this->fieldBio], $row[$this->fieldAvatar], $row[$this->fieldCountry], $row[$this->fieldStatus], $row[$this->fieldRole]);
                array_push($result, $users);
            }
        }catch(PDOException $e){
            return FALSE;
        }
        return count($result) > 0 ? $result : FALSE;
    } 
    /**
     * @brief Update user's infos
     * 
     * @param int $IdUser user's id
     * @param string $nickname user's nickname
     * @param string $name user's name
     * @param string $surname user's surname
     * @param string $bio user's bio
     * @param string $country user's residence country code
     */
    public function UpdateInfos($idUser, $nickname, $name, $surname, $bio, $country, $avatar){
        $query = <<<EX
            UPDATE `{$this->tableName}`
            SET `{$this->fieldNickname}` = :nickname, `{$this->fieldName}` = :name, `{$this->fieldSurname}` = :surname, `{$this->fieldBio}` = :bio, `{$this->fieldCountry}` = :country, `{$this->fieldAvatar}` = :avatar
            WHERE `{$this->fieldId}` = :idUser
        EX;

        try{
            if(empty($avatar)){
                $avatar = DEFAULT_USER_LOGO;
            }
            $req = $this::getDb()->prepare($query);
            $req->bindParam(':nickname', $nickname, PDO::PARAM_STR);
            $req->bindParam(':name', $name, PDO::PARAM_STR);
            $req->bindParam(':surname', $surname, PDO::PARAM_STR);
            $req->bindParam(':bio', $bio, PDO::PARAM_STR);
            $req->bindParam(':country', $country, PDO::PARAM_STR);
            $req->bindParam(':avatar', $avatar, PDO::PARAM_STR);
            $req->bindParam(':idUser', $idUser, PDO::PARAM_INT);
            $req->execute();          
        } catch(PDOException $e){
            return FALSE;
        }
        return TRUE;
    }
    /**
     * @brief Disable account by nickname 
     * 
     * @param string $nickname user's nickname
     * 
     * @return bool true if disable success, else false
     */
    public function DisableAccount($nickname){
        $query = <<<EX
            UPDATE `{$this->tableName}`
            SET `{$this->fieldStatus}` = 3
            WHERE `{$this->fieldNickname}` = :nickname 
        EX;
        try{
            $req = $this::getDb()->prepare($query);
            $req->bindParam(':nickname', $nickname, PDO::PARAM_STR);
            $req->execute();

            FMailerManager::sendMail("Your account has been disabled", array($this::GetByNickname($nickname)->Email), FMailerManager::getDisableAccountMail());
        } catch(PDOException $e){
        return FALSE;
        }
        return TRUE;
    }

}
?>