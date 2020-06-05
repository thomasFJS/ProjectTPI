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
class FCommentManager extends FDatabaseManager{

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
            self::$instance = new FCommentManager();
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
            SELECT `{$this->fieldComment}`,`{$this->fieldDate}`,`{$this->fieldUser}`
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
    /**
     * @brief Add a comment to an itinerary
     * 
     * @param int $idItinerary itinerary's id
     * @param int $idUser user's id
     * @param string $comment the comment the user post
     * 
     * @return bool true if insert success, else false
     */
    public function AddToItinerary(int $idItinerary, int $idUser, string $comment){
        $query = <<<EX
            INSERT INTO `{$this->tableName}` (`{$this->fieldComment}`,`{$this->fieldDate}`,`{$this->fieldUser}`,`{$this->fieldItinerary}`)
            VALUES (:comment, :date, :idUser, :idItinerary)
        EX;
        try{
            $date = date("Y-m-d H:i:s");
            $req = $this::getDb()->prepare($query);
            $req->bindParam(':comment', $comment, PDO::PARAM_STR);
            $req->bindParam(':date', $date, PDO::PARAM_STR);
            $req->bindParam(':idUser', $idUser, PDO::PARAM_INT);
            $req->bindParam(':idItinerary', $idItinerary, PDO::PARAM_INT);
            $req->execute();
        }catch(PDOException $e){
            return FALSE;
        }
        //Done
        return TRUE;
    }

}
?>