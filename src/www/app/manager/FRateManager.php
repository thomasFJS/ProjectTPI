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
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FItineraryManager.php';
/**
 * Class FRateManager, manager for table rating in db
 */
class FRateManager extends FDatabaseManager{
    /**
     * @var static $instance the instance for the manager 
     * */
    private static $instance;
    /**
     * @brief Class constructor, init all field from table `RATING`
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
    /**
     * @brief Add a rate to an itinerary
     * 
     * @param int $idItinerary itinerary's id
     * @param int $idUser user's id
     * @param string $rate the rate the user enter
     * 
     * @return bool true if insert success, else false
     */
    public function AddToItinerary(int $idItinerary, int $idUser, string $rate){
        $query = <<<EX
            INSERT INTO `{$this->tableName}` (`{$this->fieldRate}`,`{$this->fieldItinerary}`,`{$this->fieldUser}`)
            VALUES (:rate, :idItinerary, :idUser)
        EX;
        try{
            $req = $this::getDb()->prepare($query);
            $req->bindParam(':rate', $rate, PDO::PARAM_INT);   
            $req->bindParam(':idItinerary', $idItinerary, PDO::PARAM_INT);
            $req->bindParam(':idUser', $idUser, PDO::PARAM_INT);
            $req->execute();
            
            FItineraryManager::GetInstance()->UpdateRating(str_replace(',', '.', $this::GetAvgByItinerary($idItinerary)),$idItinerary);
        }catch(PDOException $e){
            return FALSE;
        }
        //Done
        return TRUE;
    }
    /**
     * @brief Get the average rate of an itinerary
     * 
     * @param int $idItinerary itinerary's id
     * 
     * @return double the average
     */
    public function GetAvgByItinerary(int $idItinerary){
        $query = <<<EX
            SELECT AVG(`{$this->fieldRate}`)
            FROM `{$this->tableName}`
            WHERE `{$this->fieldItinerary}` = :idItinerary
        EX;

        try{
            $req = $this::getDb()->prepare($query);
            $req->bindParam(':idItinerary', $idItinerary, PDO::PARAM_INT);
            $req->execute();
            
            $result = number_format($req->fetch(PDO::FETCH_ASSOC)['AVG(`'.$this->fieldRate.'`)'],2,',','');
        }catch(PDOException $e){
            return FALSE;
        }
        //Done
        return $result;
    }
    /**
     * @brief Get the number of rate on an itinerary
     * 
     * @param int $idItinerary itinerary's id
     * 
     * @return int the number
     */
    public function GetNbByItinerary(int $idItinerary){
        $query = <<<EX
            SELECT `{$this->fieldRate}`
            FROM `{$this->tableName}`
            WHERE `{$this->fieldItinerary}` = :idItinerary
        EX;

        try{
            $req = $this::getDb()->prepare($query);
            $req->bindParam(':idItinerary', $idItinerary, PDO::PARAM_INT);
            $req->execute();
            
            $result = $req->rowCount();
        }catch(PDOException $e){
            return FALSE;
        }
        //Done
        return $result;
    }
}
?>