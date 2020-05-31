<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  FCommentManager.
*     Brief               :  comment manager.
*     Date                :  04.09.2019.
*/

//Requirements
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FDatabaseManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FUserManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/model/FComment.php';

/**
 * Comment's manager
 */
class FWaypointManager extends FDatabaseManager{

    private static $instance;
    /**
     * @brief Class constructor, init all field from table `COMMENTS`
     */
    function __construct() {
        $this->tableName = "COMMENTS";
        $this->fieldComment = "COMMENT";
        $this->fieldDate = "COMMENT_DATE";
        $this->fieldUser = "USERS_ID";
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
     * @brief Get all comment from an itinerary with his unique's id
     * 
     * @param int $itineraryId Itinerary's unique id
     * 
     * @return array Array with all comments
     */
    public function GetAllById(int $itineraryId) {
        $result = array();

        $query = <<<EX
            SELECT `{$this->fieldComment}`,`{$this->fieldDate}`,`{$this->fiedlUser}`
            FROM `{$this->tableName}`
            WHERE `{$this->fieldItinerary}` = :itineraryId
            ORDER BY `{$this->fieldDate}`
        EX;

        try{
            $req = $this::getDb()->prepare($query);
            $req->bindParam(':itineraryId', $itineraryId, PDO::PARAM_INT);
            $req->execute();

            while($row=$req->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)){
                $comment = new FComment($row[$this->fieldComment], $row[$this->fieldDate], FUserManager::GetInstance()->GetById($row[$this->fieldUser]));
                array_push($result, $comment);
            }
        }catch(PDOException $e){
            return FALSE;
        }
        return count($result) > 0 ? $result : FALSE;
    }

}
?>