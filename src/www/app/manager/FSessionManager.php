<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  FSessionManager.
*     Brief               :  session manager.
*     Date                :  21.05.2020.
*/
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/model/FUser.php';
/**
 * Class FSessionManager
 */
class FSessionManager {
    /**
     * @brief Class constructor
     */
    function __construct(){}
    /**
     * @brief Set the user logged in session
     * 
     * @param TUser $user the user logged 
     * 
     * @return bool true if the user is set, else false;
     */
    public static function SetUserLogged(TUser $user) : bool{
        if($user !== null)
        {
            $_SESSION['userLogged'] = $user;
            return true;
        }
        else{
            return false;
        }       
    }
    /**
     * @brief Get the user logged in session
     * 
     * @return TUser $_SESSION['userLogged] the user 
     */
    public static function GetUserLogged() : ?TUser{
        return $_SESSION['userLogged'];
    }
    /**
     * @brief Clear session 
     * 
     * @return bool true if session clear success, else false
     */
    public static function Reset() : bool{
        if(ini_get("session.use_cookies")){
            setcookie(session_name(), '', 0);
        }       
        session_destroy();

        return session_destroy() ? true : false;
    }
}
?>