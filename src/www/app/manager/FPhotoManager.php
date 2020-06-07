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
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/model/FPhoto.php';

/**
 * Photo's manager
 */
class FPhotoManager extends FDatabaseManager{

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
            self::$instance = new FPhotoManager();
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
    /**
     * @brief Create photos for itinerary
     * 
     * @param array $photos array with the images encoded in base 64
     * @param int itinerary's id 
     * 
     * @return bool true if the creation success, else false
     */
    public function Create(array $photos, int $itineraryId) {
        $query = <<<EX
            INSERT INTO `{$this->tableName}` (`{$this->fieldImage}`, `{$this->fieldItinerary}`)
            VALUES(:image, :idItinerary)
        EX;

        try{
            $req = $this::getDb()->prepare($query);
            for($i = 0;$i<count($photos);$i++)
            {
                $req->bindParam(':image', $photos[$i], PDO::PARAM_STR);
                $req->bindParam(':idItinerary', $itineraryId, PDO::PARAM_INT);
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