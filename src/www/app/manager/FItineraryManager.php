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
        $this->fieldPreview = "PREVIEW";
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
            SELECT `{$this->fieldId}`, `{$this->fieldTitle}`, `{$this->fieldRating}`,`{$this->fieldDescription}`,`{$this->fieldDuration}`,`{$this->fieldDistance}`, `{$this->fieldPreview}`,`{$this->fieldCountry}`,`{$this->fieldStatus}`,`{$this->fieldUser}`
            FROM `{$this->tableName}`
            ORDER BY `{$this->fieldRating}`
        EX;

        try{
            $req = $this::getDb()->prepare($query);
            $req->execute();

            while($row=$req->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)){           
                $itinerary = new FItinerary($row[$this->fieldId], $row[$this->fieldTitle], $row[$this->fieldRating], $row[$this->fieldDescription], $row[$this->fieldDuration], $row[$this->fieldDistance], $row[$this->fieldPreview], 
                $row[$this->fieldCountry], $row[$this->fieldStatus],FWaypointManager::GetInstance()->GetAllById($row[$this->fieldId]),FCommentManager::GetInstance()->GetAllById($row[$this->fieldId]),
                FPhotoManager::GetInstance()->GetAllById($row[$this->fieldId]), $row[$this->fieldUser]);
                array_push($result, $itinerary);
            }
        }catch(PDOException $e){
            return FALSE;
        }
        return count($result) > 0 ? $result : FALSE;
    }
    /**
     * @brief Get all itinerary from an user
     * 
     * @return array Array of FItinerary with all itinerary
     */
    public function GetAllByUserId(int $idUser){
        $result = array();

        $query = <<<EX
            SELECT `{$this->fieldId}`, `{$this->fieldTitle}`, `{$this->fieldRating}`,`{$this->fieldDescription}`,`{$this->fieldDuration}`,`{$this->fieldDistance}`,`{$this->fieldPreview}`,`{$this->fieldCountry}`,`{$this->fieldStatus}`,`{$this->fieldUser}` 
            FROM `{$this->tableName}`
            WHERE `{$this->fieldUser}` = :idUser
        EX;

        try{
            $req = $this::getDb()->prepare($query);
            $req->bindParam(":idUser", $idUser, PDO::PARAM_INT);
            $req->execute();

            while($row=$req->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)){           
                $itinerary = new FItinerary($row[$this->fieldId], $row[$this->fieldTitle], $row[$this->fieldRating], $row[$this->fieldDescription], $row[$this->fieldDuration], $row[$this->fieldDistance], $row[$this->fieldPreview],
                $row[$this->fieldCountry], $row[$this->fieldStatus],FWaypointManager::GetInstance()->GetAllById($row[$this->fieldId]),FCommentManager::GetInstance()->GetAllById($row[$this->fieldId]),
                FPhotoManager::GetInstance()->GetAllById($row[$this->fieldId]), $row[$this->fieldUser]);
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
            SELECT `{$this->fieldId}`, `{$this->fieldTitle}`, `{$this->fieldRating}`,`{$this->fieldDescription}`,`{$this->fieldDuration}`,`{$this->fieldDistance}`,`{$this->fieldPreview}`,`{$this->fieldCountry}`,`{$this->fieldStatus}`, `{$this->fieldUser}`
            FROM `{$this->tableName}`
            WHERE `{$this->fieldId}` = :idItinerary
        EX;
        $itinerary = "";
        try{
            $req = $this::getDb()->prepare($query);
            $req->bindParam(":idItinerary", $idItinerary, PDO::PARAM_INT);
            $req->execute();
            
            while($row=$req->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)){           
                $itinerary = new FItinerary($row[$this->fieldId], $row[$this->fieldTitle], $row[$this->fieldRating], $row[$this->fieldDescription], $row[$this->fieldDuration], $row[$this->fieldDistance], $row[$this->fieldPreview],
                $row[$this->fieldCountry], $row[$this->fieldStatus],FWaypointManager::GetInstance()->GetAllById($row[$this->fieldId]),FCommentManager::GetInstance()->GetAllById($row[$this->fieldId]),
                FPhotoManager::GetInstance()->GetAllById($row[$this->fieldId]), $row[$this->fieldUser]);               
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
     * @param string $preview Itinerary's preview
     * @param string $country Code iso2 for itinerary's started land
     * @param array $waypoints Array<FWaypoint> array with all itinerary's waypoints
     * @param array $photos Array<FPhoto> array with all itinerary's photos
     * @param int $idUser owner's id
     */
    public function Create($title, $description, $duration, $distance, $preview, $country,$waypoints, $idUser, $photos = []){
        $query = <<<EX
            INSERT INTO `{$this->tableName}`(`{$this->fieldTitle}`, `{$this->fieldDescription}`,`{$this->fieldDuration}`,`{$this->fieldDistance}`,`{$this->fieldPreview}`,`{$this->fieldCountry}`,`{$this->fieldStatus}`,`{$this->fieldUser}`)
            VALUES(:title, :description, :duration, :distance, :preview, :country, :status, :idUser)
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
            $req->bindParam(':preview', $preview, PDO::PARAM_STR);
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
    /**
     * @brief Update itinerary's details
     * 
     * @param int $IdUser owner's id
     * @param int $idItinerary itinerary's id
     * @param string $title itinerary's title
     * @param string $country itinerary's country
     * @param string $description itinerary's description
     * @param string $duration itinerary's duration
     * @param string $distance itinerary's distance
     * @param array $waypoints Array<FWaypoint> array with all itinerary's waypoints
     * @param array $photos Array<FPhoto> array with all itinerary's photos
     */
    public function Update($idUser,$idItinerary, $title, $description, $duration, $distance,$preview, $country,$waypoints, $photos = []){
        $query = <<<EX
            UPDATE `{$this->tableName}`
            SET `{$this->fieldTitle}` = :title, `{$this->fieldDescription}` = :description, `{$this->fieldDuration}` = :duration, `{$this->fieldDistance}` = :distance,`{$this->fieldPreview}` = :preview, `{$this->fieldCountry}` = :country
            WHERE `{$this->fieldId}` = :idItinerary 
            AND `{$this->fieldUser}` = :idUser
        EX;

        try{
            $this::getDb()->beginTransaction();
            $req = $this::getDb()->prepare($query);
            $req->bindParam(':title', $title, PDO::PARAM_STR);
            $req->bindParam(':description', $description, PDO::PARAM_STR);
            $req->bindParam(':distance', $distance, PDO::PARAM_STR);
            $req->bindParam(':duration', $duration, PDO::PARAM_STR);
            $req->bindParam(':preview', $preview, PDO::PARAM_STR);
            $req->bindParam(':country', $country, PDO::PARAM_STR);
            $req->bindParam(':idItinerary', $idItinerary, PDO::PARAM_INT);
            $req->bindParam(':idUser', $idUser, PDO::PARAM_INT);
            $req->execute(); 
            if(!empty($photos)){
                FPhotoManager::GetInstance()->Create($photos, $idItinerary);
            }
            $this::getDb()->commit();         
        } catch(PDOException $e){
            $this::getDb()->rollBack();
            return FALSE;
        }
        return TRUE;
    }
    /**
     * @brief Get the itinerary by his title (title is unique)
     * 
     * @param string $title title of the itinerary
     * 
     * @return FItinerary The itinerary
     */
    public function GetByTitle($title){
        $query = <<<EX
            SELECT `{$this->fieldId}`, `{$this->fieldTitle}`, `{$this->fieldRating}`,`{$this->fieldDescription}`,`{$this->fieldDuration}`,`{$this->fieldDistance}`,`{$this->fieldPreview}`,`{$this->fieldCountry}`,`{$this->fieldStatus}`, `{$this->fieldUser}`
            FROM `{$this->tableName}`
            WHERE `{$this->fieldTitle}` = :title
        EX;
        $itinerary = "";
        try{
            $req = $this::getDb()->prepare($query);
            $req->bindParam(":title", $title, PDO::PARAM_STR);
            $req->execute();
            
            while($row=$req->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)){           
                $itinerary = new FItinerary($row[$this->fieldId], $row[$this->fieldTitle], $row[$this->fieldRating], $row[$this->fieldDescription], $row[$this->fieldDuration], $row[$this->fieldDistance], $row[$this->fieldPreview],
                $row[$this->fieldCountry], $row[$this->fieldStatus],FWaypointManager::GetInstance()->GetAllById($row[$this->fieldId]),FCommentManager::GetInstance()->GetAllById($row[$this->fieldId]),
                FPhotoManager::GetInstance()->GetAllById($row[$this->fieldId]), $row[$this->fieldUser]);               
            }
        }catch(PDOException $e){
            return FALSE;
        }
        return $itinerary != "" ? $itinerary : FALSE;
    }
}
?>