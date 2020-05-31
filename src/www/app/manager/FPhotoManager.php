<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  FPhotoManager.
*     Brief               :  photo manager.
*     Date                :  04.09.2019.
*/

//Requirements
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FDatabaseManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/model/FWaypoint.php';

/**
 * Photo's manager
 */
class FWaypointManager extends FDatabaseManager{

    private static $instance;
    /**
     * @brief Class constructor, init all field from table `PHOTOS`
     */
    function __construct() {
        $this->tableName = "PHOTOS";
        $this->fieldId = "ID";  
        $this->fieldImage = "IMAGE"; 
        $this->fieldItinerary = "ITINERARY_ID"; 
    }
    /**
     * @brief Create the initial instance for the manager or get it
     * @return $instance
     */
    public static function GetInstance(){
        if(!self::$instance){
            self::$instance = new FWaypointManager();
        }
        return self::$instance;
    }
    /**
     * @brief Get all photo from an itinerary with his unique's id
     * 
     * @param int $itineraryId Itinerary's unique id
     * 
     * @return array Array with all photos 
     */
    public function GetAllById(int $itineraryId) {
        $result = array();

        $query = <<<EX
            SELECT `{$this->fieldImage}`
            FROM `{$this->tableName}`
            WHERE `{$this->fieldItinerary}` = :itineraryId
        EX;

        try{
            $req = $this::getDb()->prepare($query);
            $req->bindParam(':itineraryId', $itineraryId, PDO::PARAM_INT);
            $req->execute();

            while($row=$req->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)){
                $photo = new FPhoto($row[$this->fieldImage]);
                array_push($result, $photo);
            }
        }catch(PDOException $e){
            return FALSE;
        }
        return count($result) > 0 ? $result : FALSE;
    }

}
?>