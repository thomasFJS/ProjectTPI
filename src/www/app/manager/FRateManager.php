<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  FRateManager.
*     Brief               :  rate manager.
*     Date                :  05.06.2020.
*/
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FDatabaseManager.php';
/**
 * Class FCodeManager
 */
class FRateManager extends FDatabaseManager{
    /**
     * @var static $instance the instance for the manager 
     * */
    private static $instance;
    /**
     * @brief Class constructor, init all field from table `COUNTRIES`
     */
    function __construct(){
        $this->tableName = "RATING";
        $this->fieldRate = "RATE";
        $this->fieldItinerary = "ITINERARY_ID";
        $this->fieldUser = "USERS_ID";
    }
    /**
     * @brief Create the initial instance for the manager or get it
     * @return $instance
     */
    public static function GetInstance(){
        if(!self::$instance){
            self::$instance = new FRateManager();
        }
        return self::$instance;
    }
    /**
     * @brief Check if user has already rate an itinerary
     * 
     * @param int $idItinerary itinerary's id
     * @param int $idUser user's id
     * 
     * @return bool true if he already rate, else false
     */
    public function HasAlreadyRate($idItinerary, $idUser){
        $query = <<<EX
            SELECT `{$this->fieldRate}`
            FROM `{$this->tableName}`
            WHERE `{$this->fieldItinerary}` = :idItinerary 
            AND `{$this->fieldUser}` = :idUser
        EX;

        try {
            $req = $this::getDb()->prepare($query);
            $req->bindParam(":idItinerary", $idItinerary, PDO::PARAM_INT);
            $req->bindParam(":idUser", $idUser, PDO::PARAM_INT);
            $req->execute();

            if($req->rowCount() > 0){
                return TRUE;
            }
            else{
                return FALSE;
            }       
        } catch(PDOException $e) {
            return FALSE;
        }
    }
}
?>