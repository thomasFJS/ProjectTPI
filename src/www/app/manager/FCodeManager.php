<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  FCodeManager.
*     Brief               :  code manager.
*     Date                :  20.05.2020.
*/
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/model/tCountry.php';
/**
 * Class FCodeManager
 */
class FCodeManager extends TDatabaseController{
    /**
     * @brief Class constructor, init all field from table `COUNTRIE`
     */
    function __construct(){
        $this->tableName = "COUNTRIES";
        $this->fieldCode = "ISO2";
        $this->fieldName = "NAME";
    }
    /**
     * @brief Get all country in the database
     * 
     */
    public static function getAllCountry() {
        $result = array();
        $query = <<<EX
            SELECT `{$this->fieldName}`, `{$this->fieldCode}`
            FROM `{$this->tableName}`
            ORDER BY `{$this->fieldName}`
        EX;

        try {
            $req = $this::getDb()->prepare($query);
            $req->execute();

            while($row=$req->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)){
                $country = new TCountry($row[$this->fieldName], $row[$this->fieldCode]);
                array_push($result, $country);
            }

            return count($result) > 0 ? $result : null;           
        } catch(PDOException $e) {
            echo "Can't read the database" . $e->getMessage();

            return null;
        }
    }  
}
?>