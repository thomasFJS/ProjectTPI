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
 * Class FSessionManager, to manage session
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
    public static function SetUserLogged(FUser $user) : bool{
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
     * @brief Get the user logged in session or if user isn't logged,get a FUser object for unregistered user
     * 
     * @return TUser $_SESSION['userLogged] the user 
     */
    public static function GetUserLogged() : ?FUser{
        if(isset($_SESSION['userLogged'])){
            return $_SESSION['userLogged'];
        }else{
            //Id 0 for visitor account
            return new FUser(0, "John@Doe.com", "Visitor", "John", "Doe", "", "","","2","1");
        }
        
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
    /**
     * @brief Set a filter for itinerary display
     * 
     * @param array All the filter to apply
     * 
     * @return bool true if filter's set, else false
     */
    public static function SetItineraryFilter(array $filters){
        if($filters != null){
            $_SESSION['filters'] = $filters;
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    /**
     * @brief Get the filter for itinerary display
     * 
     * @return array All the filter to apply
     */
    public static function GetItineraryFilter(){
        if(isset($_SESSION['filters'])){
            return $_SESSION['filters'];
        }else{
            return FALSE;
        }
    }
    /**
     * @brief Unset the itinerary filters
     * 
     * @return bool true if unset done, else false
     */
    public static function UnsetItineraryFilter(){
        if(isset($_SESSION['filters'])){
            unset($_SESSION['filters']);
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
}
?>