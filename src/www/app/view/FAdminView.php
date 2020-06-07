<?php
/*
*     Author              :  Fujise Thomas.
*     Project             :  ProjetTPI.
*     Page                :  FAdminView.
*     Brief               :  home view.
*     Date                :  02.06.2020.
*/
//Requirements
require_once $_SERVER['DOCUMENT_ROOT'].'/ProjectTPI/src/www/app/manager/FUserManager.php';

/**
 * Represents admin panel page view.
 */
class FAdminView{
    /**
     * @brief Class constructor
     */
    function __construct(){}
    /**
     * @brief Display all users registered 
     * 
     * @param array $users all users to display
     * 
     * @return string code html to display 
     */
    public static function DisplayUsers($users) : string{
        $result = '';
        $status = '';
        $action = '';
        if($users == FALSE)
        {
            $result .= <<<EX
            <div class="lead font-weight-bold">You don't create itinerary yet</div>
            EX;
        }
        else{
            for($i = 0;$i<count($users);$i++){
                switch($users[$i]->Status){
                    case 1:
                        $status = "Not activate";
                        $action = '<a href="#" class="btn btn-danger" data-type="disable" data-nickname="' . $users[$i]->Nickname .'" data-target="#modalDisable" data-toggle="modal">Disable</a>';
                        break;
                    case 2:
                        $status = "Activated";
                        $action = '<a href="#" class="btn btn-danger" data-type="disable" data-nickname="' . $users[$i]->Nickname .'" data-target="#modalDisable" data-toggle="modal">Disable</a>';

                        break;
                    case 3:
                        $status = "Blocked";
                        $action = '<a href="#" class="btn btn-success" data-type="disable" data-nickname="' . $users[$i]->Nickname .'" data-target="#modalDisable" data-toggle="modal">Enable</a>';
                        break;
                }
                $result .= <<<EX
                    <tr>
                        <td>{$users[$i]->Nickname}</td>
                        <td>{$users[$i]->Email}</td>
                        <td>{$users[$i]->Name}</td>
                        <td>{$users[$i]->Surname}</td>
                        <td>{$users[$i]->Country}</td>
                        <td>{$status}</td>
                        <td>{$action}</td>              
                    </tr>
                EX;
            }
        }
        return $result;
    }

}

?>