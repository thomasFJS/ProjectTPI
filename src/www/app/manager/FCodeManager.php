<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  FCodeManager.
*     Brief               :  code manager.
*     Date                :  20.05.2020.
*/
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/model/FCountry.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FDatabaseManager.php';
/**
 * Class FCodeManager
 */
class FCodeManager extends FDatabaseManager{
    /**
     * @var static $instance the instance for the manager 
     * */
    private static $instance;
    /**
     * @brief Class constructor, init all field from table `COUNTRIES`
     */
    function __construct(){
        $this->tableCountries = "COUNTRIES";
        $this->fieldCode = "ISO2";
        $this->fieldName = "NAME";
    }
    /**
     * @brief Create the initial instance for the manager or get it
     * @return $instance
     */
    public static function GetInstance(){
        if(!self::$instance){
            self::$instance = new FCodeManager();
        }
        return self::$instance;
    }
    /**
     * @brief Get all country in the database
     * 
     */
    public function getAllCountry() {
        $result = array();
        $query = <<<EX
            SELECT `{$this->fieldName}`, `{$this->fieldCode}`
            FROM `{$this->tableCountries}`
            ORDER BY `{$this->fieldName}`
        EX;

        try {
            $req = $this::getDb()->prepare($query);
            $req->execute();

            while($row=$req->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)){
                $country = new FCountry($row[$this->fieldName], $row[$this->fieldCode]);
                array_push($result, $country);
            }

            return count($result) > 0 ? $result : FALSE;           
        } catch(PDOException $e) {
            echo "Can't read the database" . $e->getMessage();

            return FALSE;
        }
    }  
}
?>