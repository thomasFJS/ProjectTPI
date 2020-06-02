<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  FWaypointManager.
*     Brief               :  Waypoint manager.
*     Date                :  04.09.2019.
*/

//Requirements
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FDatabaseManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/model/FWaypoint.php';

/**
 * Waypoints's manager
 */
class FWaypointManager extends FDatabaseManager{

    private static $instance;
    /**
     * @brief Class constructor, init all field from table `WAYPOINTS`
     */
    function __construct() {
        $this->tableName = "WAYPOINTS";
        $this->fieldIndex = "INDEX";
        $this->fieldAddress = "ADDRESS";
        $this->fieldLongitude = "LONGITUDE";
        $this->fieldLatitude = "LATITUDE";    
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
     * @brief Get all waypoints from an itinerary with his unique's id
     * 
     * @param int $itineraryId itinerary's unique id
     * 
     * @return array Array with all waypoint from the itinerary
     */
    public function GetAllById(int $itineraryId) {
        $result = array();

        $query = <<<EX
            SELECT `{$this->fieldIndex}`,`{$this->fieldAddress}`,`{$this->fieldLongitude}`,`{$this->fieldLatitude}`
            FROM `{$this->tableName}`
            WHERE `{$this->fieldItinerary}` = :itineraryId
            ORDER BY `{$this->fieldIndex}`
        EX;

        try{
            $req = $this::getDb()->prepare($query);
            $req->bindParam(':itineraryId', $itineraryId, PDO::PARAM_INT);
            $req->execute();

            while($row=$req->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)){
                $waypoint = new FWaypoint($row[$this->fieldIndex], $row[$this->fieldAddress], $row[$this->fieldLongitude], $row[$this->fieldLatitude]);
                array_push($result, $waypoint);
            }
        }catch(PDOException $e){
            return FALSE;
        }
        return count($result) > 0 ? $result : FALSE;
    }
    /**
     * @brief Create new waypoints for itinerary
     * 
     * @param array Array<FWaypoint> with all waypoints to add
     * @param int $idItinerary itinerary's id
     * 
     * @return bool true if insert's done else false.
     */
    public function Create(array $waypoints, $idItinerary){
        $query = <<<EX
            INSERT INTO `{$this->tableName}` (`{$this->fieldIndex}`, `{$this->fieldAddress}`, `{$this->fieldLongitude}`, `{$this->fieldLatitude}`, `{$this->fieldItinerary}`)
            VALUES(:index, :address, :longitude, :latitude, :idItinerary)
        EX;

        try{
            $req = $this::getDb()->prepare($query);
            for($i = 0;$i<count($waypoints);$i++)
            {
                $req->bindParam(':index', $waypoints[$i]->Index, PDO::PARAM_INT);
                $req->bindParam(':address', $waypoints[$i]->Address, PDO::PARAM_STR);
                $req->bindParam(':longitude', $waypoints[$i]->Longitude, PDO::PARAM_STR);
                $req->bindParam(':latitude', $waypoints[$i]->Latitude, PDO::PARAM_STR);
                $req->bindParam(':idItinerary', $idItinerary, PDO::PARAM_INT);
                $req->execute();
            }
            
        }catch(PDOException $e){
            return FALSE;
        }
        //Done
        return TRUE;
    }

}
?>