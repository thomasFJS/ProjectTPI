<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  userController.
*     Brief               :  user controller.
*     Date                :  04.09.2019.
*/

//Requirements
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/controller/databaseController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/controller/mailerController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/model/tUser.php';

/**
 * User controller 
 */
class UserController extends TDatabaseController{

    private static $instance;
    /**
     * @brief Class constructor, init all field from table `player`
     */
    function __construct() {
        $this->tableName = "players";
        $this->fieldNickname = "nickname";
        $this->fieldEmail = "email";
        $this->fieldCountry = "country";
        $this->fieldBirthday = "birthday";
        $this->fieldActivation = "activation";
        $this->fieldRole = "role";
        $this->fieldPassword = "password";
        $this->fieldSalt = "salt";
        $this->fieldToken = "email_token";
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

        return $result !== false ? $result[$this->fieldSalt] : null;
    }
    /**
     * @brief Get User if login informations are correct
     * 
     * @param array $args Array with login informations.
     * 
     * @return User||null
     */
    public function Login(array $args): ?TUser {
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
            $salt = $this->GetSalt(['userEmail' => $userEmail]);
        } else if($userNickname !== null){
            $loginValue = $userNickname;
            $loginField = $this->fieldNickname;
            $salt = $this->GetSalt(['userNickname' => $userNickname]);         
        } else {
            return false;
        }

        if($userPwd === null){
            return false;
        }

        $pwd = hash("sha256", $userPwd . $salt);

        $query = <<<EX
            SELECT `{$this->fieldEmail}`, `{$this->fieldNickname}`, `{$this->fieldCountry}`,`{$this->fieldBirthday}`, `{$this->fieldRole}`
            FROM `{$this->tableName}`
            WHERE `{$loginField}` = :connectValue
            AND `{$this->fieldPassword}` = :userPwd
        EX;

        try {
            $req = $this::getDb()->prepare($query);
            $req->bindParam(':connectValue', $loginValue, PDO::PARAM_STR);
            $req->bindParam(':userPwd', $pwd, PDO::PARAM_STR);
            $req->execute();

            $result = $req->fetch(PDO::FETCH_ASSOC);

            return $result !== false > 0 ? new TUser($result[$this->fieldEmail], $result[$this->fieldNickname], $result[$this->fieldCountry], $result[$this->fieldBirthday], $result[$this->fieldRole]) : null;           
        } catch(PDOException $e) {
            echo "Error while login" . $e->getMessage();

            return null;
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
    public function RegisterNewUser(string $userEmail, string $userNickname, string $userPwd, string $userCountry, string $userBirthday) : bool {
        $query = <<<EX
            INSERT INTO `{$this->tableName}`({$this->fieldNickname}, {$this->fieldEmail}, {$this->fieldCountry}, {$this->fieldBirthday}, {$this->fieldActivation}, {$this->fieldSalt}, {$this->fieldPassword}, {$this->fieldRole}, {$this->fieldToken})
            VALUES(:userNickname, :userEmail, :userCountry, :userBirthday, :userActivation, :userSalt, :userPassword, :userRole, :token)
        EX;

        $salt = hash('sha256', microtime());
        $userPwd = hash('sha256', $userPwd . $salt);

        $token = hash('sha256', $userEmail . microtime()); //!!!! A demander
        //account not activate
        $activation = 0;
        //role 1 = user
        $userRole = 1;


        try {
            $this::getDb()->beginTransaction();

            $req = $this::getDb()->prepare($query);
            $req->bindParam(':userNickname', $userNickname, PDO::PARAM_STR);
            $req->bindParam(':userEmail', $userEmail, PDO::PARAM_STR);            
            $req->bindParam(':userPassword', $userPwd, PDO::PARAM_STR);
            $req->bindParam(':userSalt', $salt, PDO::PARAM_STR);
            $req->bindParam(':userCountry', $userCountry, PDO::PARAM_STR);
            $req->bindParam(':userBirthday', $userBirthday, PDO::PARAM_STR);
            $req->bindParam(':userActivation', $activation, PDO::PARAM_INT);
            $req->bindParam(':userRole', $userRole, PDO::PARAM_INT);
            $req->bindParam(':token', $token, \PDO::PARAM_STR);
            $req->execute();

            $this::getDb()->commit();
            TMailerController::sendMail(array($userEmail), $token);
            return true;
        } catch(PDOException $e){
            $this::getDb()->rollBack();
            echo 'Error while register a new user' .$e->getMessage();
            
            return false;
        }
    }
    /**
     * @brief Check if user is admin or not
     * 
     * @param TUser $user User to check
     * 
     * @return bool true if admin, false if user
     */
    public function IsAllowed(TUser $user) : bool {
        return $user->Role == 2 ? true : false;
    }
    /**
     * @brief Check if user is logged or not
     * 
     * @return bool true if user's logged, else false
     */
    public function IsLogged() : bool {
        return isset($_SESSION['isLogged']) ? true : false;
    }
    /**
     * @brief Create the initial instance for the controller or get it
     * @return $instance
     */
    public static function getInstance(){
        if(!self::$instance){
            self::$instance = new UserController();
        }
        return self::$instance;
    }

    public function VerifyToken(string $token) : bool{
        $query = <<<EX
            SELECT nickname 
            FROM players
            WHERE email_token = :token
        EX;
        $req = $this::getDb()->prepare($query);
        $req->bindParam(':token', $token, \PDO::PARAM_STR);
        $req->execute();

        return $req->rowCount() == 1 ? true : false;
    }

    public function ActivateAccount(string $token) : bool{
        try{
            $query = <<<EX
                UPDATE players 
                SET activation = 1
                WHERE email_token = :token
            EX;
            $req = $this::getDb()->prepare($query);
            $req->bindParam(':token', $token, \PDO::PARAM_STR);
            $req->execute();

            return true;
        } catch(PDOException $e){
            echo 'Error while activating a new user' .$e->getMessage();
            
            return false;
        }
    }

}
?>