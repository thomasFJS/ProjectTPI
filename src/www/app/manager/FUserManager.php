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

/**
 * User's manager
 */
class FUserManager extends FDatabaseManager{

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
     * @brief Get salt from field 
     * How to use :
     *      "$this->GetSalt(['userEmail' => "john.doe@gmail.com"])" => to get the salt with email
     *      "$this->GetSalt(['userNickname' => "JohnDoe"])" => to get the salt with nickname
     *
     * @param array $args Array with the field you want to use in salt
     *
     * @return string||null
     */
    private function GetSalt(array $args): ?string {
        $args += [
            'userEmail' => null,
            'userNickname' => null
        ];
        
        // Extract the keys of the array has variables
        extract($args); 

        $field = "";
        $value = "";
        if ($userEmail !== null) {
            $field = $this->fieldEmail;
            $value = $userEmail;
        } else if ($userNickname !== null) {
            $field = $this->fieldNickname;
            $value = $userNickname;
        }

        $query = <<<EX
            SELECT `{$this->fieldSalt}`
            FROM {$this->tableName}
            WHERE {$field} = :value
        EX;
        
        $req = $this::getDb()->prepare($query);
        $req->bindParam(':value', $value);
        $req->execute();

        $result = $req->fetch(PDO::FETCH_ASSOC);

        return $result !== FALSE ? $result[$this->fieldSalt] : null;
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
            INSERT INTO `{$this->tableName}`(`{$this->fieldNickname}`, `{$this->fieldEmail}`, `{$this->fieldPassword}`, `{$this->fieldStatus}`, `{$this->fieldRole}`, `{$this->fieldToken}`)
            VALUES(:userNickname, :userEmail, :userPassword, :userStatus, :userRole, :token)
        EX;

        $userPwd = password_hash($userPwd, PASSWORD_DEFAULT);

        $token = hash('sha256', $userEmail . microtime());
        //account not activate
        $userStatus = 1;
        //role 1 = user
        $userRole = 1;

        try {
            $req = $this::getDb()->prepare($query);
            $req->bindParam(':userNickname', $userNickname, PDO::PARAM_STR);
            $req->bindParam(':userEmail', $userEmail, PDO::PARAM_STR);            
            $req->bindParam(':userPassword', $userPwd, PDO::PARAM_STR);
            $req->bindParam(':userStatus', $userStatus, PDO::PARAM_INT);
            $req->bindParam(':userRole', $userRole, PDO::PARAM_INT);
            $req->bindParam(':token', $token, \PDO::PARAM_STR);
            $req->execute();

            FMailerManager::sendMail("Account Activation", array($userEmail), FMailerManager::getActivationMail($token));
            
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
    public function VerifyActivation(string $nickname) : bool{
        $query = <<<EX
            SELECT `{$this->fieldStatus}`
            FROM `{$this->tableName}` 
            WHERE `{$this->fieldNickname}` = :nickname
        EX;

        $req = $this::getDb()->prepare($query);
        $req->bindParam(':nickname', $nickname, PDO::PARAM_STR);
        $req->execute();

        $result = $req->fetch();
        //return true if account's activated (2)
        return $result[0] == 2 ? TRUE : FALSE;
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
}
?>