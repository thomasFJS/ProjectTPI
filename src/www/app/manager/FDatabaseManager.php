<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  FDatabaseManager.
*     Brief               :  Database's manager.
*     Date                :  28.05.2020.
*     Version             :  1.0.
*/
//Requirements
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/config/config.php';
/**
 * Class FDatabase
 */
class FDatabaseManager {
    /**
     * @var static $db the instance for the manager 
     * */
    private static $db ;
    /**
     * @brief Class constructor, create a new database connection if one doesn't exist.
     */
    private function __construct(){}
    /**
     * @brief Like the constructor, __clone is private so nobody can clone the instance.
     */
    private function __clone(){}
    /**
     * @brief Create the initial connection to the database or get the instance
     * 
     * @return PDO $db PDO instance
     */
    public static function getDb() {
        if(!self::$db){
            try{
                $connectString = DB_DBTYPE.':host='.DB_HOST.';dbname='.DB_NAME;
                self::$db = new PDO($connectString, DB_USER, DB_PASS, array('charset'=>'utf8'));
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }catch(PDOException $e){
                    echo "EDatabase Error: ".$e;
                }
        }
        return self::$db;
    }
}
?>