<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  countryController.
*     Brief               :  country controller.
*     Date                :  20.05.2020.
*/
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/model/tCountry.php';
/**
 * Class TDatabase
 */
class TCountryController extends TDatabaseController{
    /**
     * @brief Class constructor, init all field from table `countries`
     */
    function __construct(){
        $this->tableName = "countries";
        $this->fieldCode = "country_code";
        $this->fieldName = "country_name";
    }

    public function getAllCountry() {
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