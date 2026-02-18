<?php
/**
 * Created by PhpStorm.
 * User: AbbasPC
 * Date: 2/4/2019
 * Time: 1:30 PM
 */
require '../../../config/bootstrap.php';
//require LIBRARY_DIR . 'Load.php';
require CONFIG_DIR . 'config.php';
spl_autoload_register(array('Load', 'autoload'));
/**
 * Class TicketDetailApp
 * @property TicketDetailApp $TicketDetailApp
 */
class TicketDetailApp
{
    public $direction;
    public function __construct()
    {
        
    }

    public function ShowTicketDetailApp($UniqId,$TypeZone)
    {

        $model = Load::model('temporary_local');
        $records = $model->get($UniqId);

        return $records;
    }


    public function ShowDetailTicketBook ($RequestNumber)
    {
        $Ticket = functions::info_flight_client ($RequestNumber);

        return $Ticket;
    }

    public function TicketHistory()
    {
        $UserController = Load::controller('user');
        $UserBuy = $UserController->UserBuy('App');

        return $UserBuy;
    }

    public function DetailRoutes($id)
    {
        $Model = Load::library('Model');
        $sql = "SELECT * FROM book_routes_tb WHERE RequestNumber='{$id}'" ;
        $resultDetailTicket = $Model->select($sql);
        return $resultDetailTicket;
    }


    public function DetailRoutesTemporary($id)
    {
        $Model = Load::library('Model');
         $sql = "SELECT * FROM temporary_routes_tb WHERE TemporaryId='{$id}'" ;
        $resultDetailTicket = $Model->select($sql);
        return $resultDetailTicket;
    }

    public function infoBookByFactorNumber($factorNumber){
        $Model = Load::library('Model');
        $sql = "SELECT * FROM book_local_tb WHERE factor_number='{$factorNumber}'";
        $FlightBooked = $Model->select($sql);

        foreach ($FlightBooked as $key=>$Flight){
            if($Flight['direction']=='dept'){
                $FlightBook['dept'][] = $Flight;
                $this->direction = 'dept' ;
            }
            if ($Flight['direction']=='return') {
                $FlightBook['return'][] = $Flight;
                $this->direction = 'return' ;
            }
            if ($Flight['direction']=='TwoWay') {
                $FlightBook['TwoWay'][] = $Flight;
                $this->direction = 'TwoWay' ;
            }
        }
        return $FlightBook;
    }

}