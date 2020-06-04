<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  FItineraryManager.
*     Brief               :  itinerary manager.
*     Date                :  04.09.2019.
*/

//Requirements
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FDatabaseManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FMailerManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/model/FItinerary.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FWaypointsManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FCommentManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FPhotoManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/constants/constants.php';
/**
 * Itinerary's manager
 */
class FItineraryManager extends FDatabaseManager{

    private static $instance;
    /**
     * @brief Class constructor, init all field from table `ITINERARY`
     */
    function __construct() {
        $this->tableName = "ITINERARY";
        $this->fieldId = "ID";
        $this->fieldTitle = "TITLE";
        $this->fieldRating = "RATING";
        $this->fieldDescription = "DESCRIPTION";
        $this->fieldDuration = "DURATION";
        $this->fieldDistance = "DISTANCE";
        $this->fieldCountry = "COUNTRIES_ISO2";
        $this->fieldStatus = "STATUS_ID";
        $this->fieldUser = "USERS_ID";        
    }
    /**
     * @brief Create the initial instance for the manager or get it
     * @return $instance
     */
    public static function GetInstance(){
        if(!self::$instance){
            self::$instance = new FItineraryManager();
        }
        return self::$instance;
    }
    /**
     * @brief Get all itinerary 
     * 
     * @return array Array of FItinerary with all itinerary
     */
    public function GetAll(){
        $result = array();

        $query = <<<EX
            SELECT `{$this->fieldId}`, `{$this->fieldTitle}`, `{$this->fieldRating}`,`{$this->fieldDescription}`,`{$this->fieldDuration}`,`{$this->fieldDistance}`,`{$this->fieldCountry}`,`{$this->fieldStatus}`
            FROM `{$this->tableName}`
            ORDER BY `{$this->fieldRating}`
        EX;

        try{
            $req = $this::getDb()->prepare($query);
            $req->execute();

            while($row=$req->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)){           
                $itinerary = new FItinerary($row[$this->fieldId], $row[$this->fieldTitle], $row[$this->fieldRating], $row[$this->fieldDescription], $row[$this->fieldDuration], $row[$this->fieldDistance], 
                $row[$this->fieldCountry], $row[$this->fieldStatus],FWaypointManager::GetInstance()->GetAllById($row[$this->fieldId]),FCommentManager::GetInstance()->GetAllById($row[$this->fieldId]),
                FPhotoManager::GetInstance()->GetAllById($row[$this->fieldId]));
                array_push($result, $itinerary);
            }
        }catch(PDOException $e){
            return FALSE;
        }
        return count($result) > 0 ? $result : FALSE;
    }
        /**
     * @brief Get a FItinerary object for the itinerary with the id
     * 
     * @param int Itinerary's id
     * 
     * @return FItinerary Object FItinerary 
     */
    public function GetById(int $idItinerary){
        $query = <<<EX
            SELECT `{$this->fieldId}`, `{$this->fieldTitle}`, `{$this->fieldRating}`,`{$this->fieldDescription}`,`{$this->fieldDuration}`,`{$this->fieldDistance}`,`{$this->fieldCountry}`,`{$this->fieldStatus}`
            FROM `{$this->tableName}`
            WHERE `{$this->fieldId}` = :idItinerary
        EX;
        $itinerary = "";
        try{
            $req = $this::getDb()->prepare($query);
            $req->execute();
            
            while($row=$req->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)){           
                $itinerary = new FItinerary($row[$this->fieldId], $row[$this->fieldTitle], $row[$this->fieldRating], $row[$this->fieldDescription], $row[$this->fieldDuration], $row[$this->fieldDistance], 
                $row[$this->fieldCountry], $row[$this->fieldStatus],FWaypointManager::GetInstance()->GetAllById($row[$this->fieldId]),FCommentManager::GetInstance()->GetAllById($row[$this->fieldId]),
                FPhotoManager::GetInstance()->GetAllById($row[$this->fieldId]));               
            }
        }catch(PDOException $e){
            return FALSE;
        }
        return $itinerary != "" ? $itinerary : FALSE;
    }
    /**
     * @brief Create new itinerary
     * 
     * @param string $title Itinerary's title
     * @param string $description Itinerary's description
     * @param string $duration Itinerary's duration
     * @param double $distance Itinerary's distance
     * @param string $country Code iso2 for itinerary's started land
     * @param array $waypoints Array<FWaypoint> array with all itinerary's waypoints
     * @param array $photos Array<FPhoto> array with all itinerary's photos
     * @param int $idUser owner's id
     */
    public function Create($title, $description, $duration, $distance, $country,$waypoints, $idUser, $photos = []){
        $query = <<<EX
            INSERT INTO `{$this->tableName}`(`{$this->fieldTitle}`, `{$this->fieldDescription}`,`{$this->fieldDuration}`,`{$this->fieldDistance}`,`{$this->fieldCountry}`,`{$this->fieldStatus}`,`{$this->fieldUser}`)
            VALUES(:title, :description, :duration, :distance, :country, :status, :idUser)
        EX;

        try{
            //Set itinerary's default status
            $status = ITINERARY_STATUS_DEFAULT;

            $this::getDb()->beginTransaction();
            $req = $this::getDb()->prepare($query);
            $req->bindParam(':title', $title, PDO::PARAM_STR);
            $req->bindParam(':description', $description, PDO::PARAM_STR);
            $req->bindParam(':duration', $duration, PDO::PARAM_STR);
            $req->bindParam(':distance', $distance, PDO::PARAM_STR);
            $req->bindParam(':country', $country, PDO::PARAM_STR);
            $req->bindParam(':status', $status, PDO::PARAM_STR);
            $req->bindParam(':idUser', $idUser, PDO::PARAM_INT);
            $req->execute();
            if(!empty($photos)){
                FPhotoManager::GetInstance()->Create($photos, $this::getDb()->lastInsertId());
            }
            FWaypointManager::GetInstance()->Create($waypoints, $this::getDb()->lastInsertId());
            
            $this::getDb()->commit();
        }catch(PDOException $e){
            $this::getDb()->rollBack();
            return FALSE;
        }
        return TRUE;
    }
}
?>