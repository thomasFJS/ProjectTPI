<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  databaseController.
*     Brief               :  database controller.
*     Date                :  04.09.2019.
*/
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/config/config.php';
/**
 * Class TDatabase
 */
class TDatabaseController {
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
     * @return $db
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
     /**
     * @brief	Passes on any static calls to this class onto the singleton PDO instance
     * 
     * @param 	$chrMethod		called method
     * @param 	$arrArguments	method's parameters
     * 
     * @return 	$mix			method's return value
     */
    final public static function __callStatic($chrMethod, $arrArguments) {
        $pdo = self::getInstance();
        return call_user_func_array(array($pdo, $chrMethod), $arrArguments);
    }
}
?>