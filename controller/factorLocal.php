<?php
class factorLocal extends apiLocal
{


    public $Airline_IATA;
    public $time_remmaining;
    public $RequestNumber;
    public $RequestNumberPosted;
    public $IdMember;
    public $IsLogin;
    public $CounterId;
    public $Source_ID;
    public $direction;
    public $factor_number;


    public function __construct ()
    {



        parent::__construct ();

        $this->IsLogin = Session::IsLogin ();

//        if (isset($_SESSION['PostData']) && !empty($_SESSION['PostData']) && ($_SESSION['PostData'] == $_POST['PostData'])) {
//                $controller = Load::controller('passengersDetailLocal');
//                $controller->set_session();
        //for departure flight
        

        if (isset($_POST['RequestNumber_dept']) && $_POST['RequestNumber_dept'] != '') {

            $this->RequestNumber['dept'] = $_POST['RequestNumber_dept'];
            $this->Source_ID['dept'] = (isset($_POST['Source_ID_dept']) && !empty($_POST['Source_ID_dept'])) ? $_POST['Source_ID_dept'] : '';
            $this->direction['dept'] = 'dept';
            $this->RequestNumberPosted = $_POST['RequestNumber_dept'];
            $this->factor_number = $_POST['factor_number_Flight'] ;
        }
        //for return flight in twoways
        if (isset($_POST['RequestNumber_return']) && $_POST['RequestNumber_return'] != '') {
            $this->RequestNumber['return'] = $_POST['RequestNumber_return'];
            $this->direction['return'] = 'return';
            $this->RequestNumberPosted = $_POST['RequestNumber_return'];
            $this->factor_number = $_POST['factor_number_Flight'] ;
        }
        if (isset($_POST['Source_ID_return']) && $_POST['Source_ID_return'] != '') {
            $this->Source_ID['return'] = $_POST['Source_ID_return'];
        }
        if (isset($_POST['RequestNumber_TwoWay']) && $_POST['RequestNumber_TwoWay'] != '') {
            $this->RequestNumber['TwoWay'] = $_POST['RequestNumber_TwoWay'];
            $this->direction['TwoWay'] = 'TwoWay';
            $this->Source_ID['TwoWay'] = $_POST['Source_ID_TwoWay'];
            $this->RequestNumberPosted = $_POST['RequestNumber_TwoWay'];
            $this->factor_number = $_POST['factor_number_Flight'] ;

        }

        if (isset($_POST['RequestNumber_multi_destination']) && $_POST['RequestNumber_multi_destination'] != '') {
            $this->RequestNumber['multi_destination'] = $_POST['RequestNumber_multi_destination'];
            $this->direction['multi_destination'] = 'multi_destination';
            $this->Source_ID['multi_destination'] = $_POST['Source_ID_TwoWay'];
            $this->RequestNumberPosted = $_POST['RequestNumber_multi_destination'];
            $this->factor_number = $_POST['factor_number_Flight'] ;

        }
        $this->time_remmaining = !empty($_POST['time_remmaining']) ? $_POST['time_remmaining'] : '00:00';
        $this->IdMember = !empty($_POST['IdMember']) ? $_POST['IdMember'] : '';

//        } else {
//
//            $root = SERVER_HTTP . CLIENT_MAIN_DOMAIN;
//            header("Location: {$root}");
//            exit();
//        }
    }

    public function getSpecific ($factorNumber){

        /** @var bookshow $BookShowController */
        $BookShowController = Load::controller('bookshow');
       $FlightBooked = $BookShowController->infoBookByFactorNumber($factorNumber);


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

           if ($Flight['direction']=='multi_destination') {
               $FlightBook['multi_destination'][] = $Flight;
               $this->direction = 'multi_destination' ;
           }
       }

       return $FlightBook ;
    }

    public function CreditCustomer ()
    {
        $Model = Load::library ('Model');

        if ($this->IsLogin) {

            Load::autoload ('Model');
            $creditModel = new Model();
            $SqlMember = "SELECT * FROM members_tb WHERE id='{$_SESSION["userId"]}'";

            $member = $Model->load ($SqlMember);

            $agencyID = $member['fk_agency_id'];

            $sql_charge = "SELECT sum(credit) AS total_charge FROM credit_detail_tb WHERE type='increase' AND fk_agency_id='{$agencyID}'";
            $charge = $creditModel->load ($sql_charge);
            $total_charge = $charge['total_charge'];

            $sql_buy = "SELECT sum(credit) AS total_buy FROM credit_detail_tb WHERE type='decrease' AND fk_agency_id='{$agencyID}'";
            $buy = $creditModel->load ($sql_buy);
            $total_buy = $buy['total_buy'];

            $total_transaction = $total_charge - $total_buy;
            return $total_transaction;
        }
    }

    #region CalculateDiscountOnePerson
    public  function CalculatePriceOnePerson($RequestNumber, $nationalCode)
    {

        //yes means nesesary calculate  price changes
        $modelBase = Load::library('ModelBase');

        $Sql = "SELECT * FROM report_tb WHERE (request_number='{$RequestNumber}' OR factor_number='{$RequestNumber}') AND (passenger_national_code='{$nationalCode}' OR passportNumber='{$nationalCode}')";

        $result = $modelBase->select($Sql);


        $amount = 0;

        foreach ($result as $key=>$rec)
        {

            if (strtolower($rec['flight_type']) == 'system') {

                $isCounter = Load::controller( 'login' )->isCounter();
                $isSafar360 = functions::isSafar360();

                // اگر میخواهید تخفیف برای منبع درست کار کند مانند شرط زیر برای منبع مورد نظر هم یک شرط بزارید-

                if ( ($rec['IsInternal'] == '1' && $rec['api_id'] != '14') || ($rec['api_id'] != '10' && $rec['api_id'] != '15' && $rec['api_id'] != '17' && $rec['api_id'] != '14' && $rec['api_id'] != '8' && $rec['api_id'] != '43' && $rec['api_id'] != '21') ) {



                    if ( $rec['percent_discount'] > 0 ) {
                        if ( $rec['pid_private'] == '0' ) {

                            if (isset($rec['adt_price']) && $rec['adt_price'] != '0') {
                                $amount += $rec['adt_price'] - ($rec['system_flight_commission'] * ($rec['percent_discount'] / 100));
                            }
                            if (isset($rec['chd_price']) && $rec['chd_price'] != '0') {
                                $amount += $rec['chd_price'] - ($rec['system_flight_commission'] * ($rec['percent_discount'] / 100));
                            }
                            if (isset($rec['inf_price']) && $rec['inf_price'] != '0') {
                                $amount += $rec['inf_price'] - ($rec['system_flight_commission'] * ($rec['percent_discount'] / 100));
                            }

                        } elseif ( $rec['pid_private'] == '1' ) {
                            if ($isCounter || $isSafar360) {
                                $amount += ($rec['adt_price'] - $rec['adt_com']) - ( $rec['adt_com'] * ( $rec['percent_discount'] / 100 ) );
                                $amount += ($rec['chd_price'] - $rec['chd_com']) - ( $rec['chd_com'] * ( $rec['percent_discount'] / 100 ) );
                                $amount += ($rec['inf_price'] - $rec['inf_com']) - ( $rec['inf_com'] * ( $rec['percent_discount'] / 100 ) );
                            } else {
                                $amount += $rec['adt_price'] - ( $rec['adt_com'] * ( $rec['percent_discount'] / 100 ) );
                                $amount += $rec['chd_price'] - ( $rec['chd_com'] * ( $rec['percent_discount'] / 100 ) );
                                $amount += $rec['inf_price'] - ( $rec['inf_com'] * ( $rec['percent_discount'] / 100 ) );
                            }

                        }
                    }
                    else {
                        if ($rec['pid_private'] == '0') {
                            $amount += $rec['adt_price'] + $rec['chd_price'] + $rec['inf_price'];
                        } elseif ($rec['pid_private'] == '1') {
                            if ($isCounter || $isSafar360) {
                                $amount += ($rec['adt_price'] - $rec['adt_com']) + ($rec['chd_price'] - $rec['chd_com']) + ($rec['inf_price'] - $rec['inf_com']);
                            } else {
                                $amount += $rec['adt_price'] + $rec['chd_price'] + $rec['inf_price'];
                            }
                        }
                    }
                }
                else {
                    if ( $rec['IsInternal'] == '0' || $rec['api_id'] == '14') {

                        $airlineModel = Load::getModel('airlineModel');
                        $airlineForCom = $airlineModel->get(['abbreviation','foreignAirline','amadeusStatus'], true)->where('abbreviation', $rec['airline_iata'])->all();
                        if (!isset($airlineForCom[0]['foreignAirline'])) {
                            $foreignAirline = null;
                        }
                        if ($airlineForCom[0]['foreignAirline'] == 'active' || $airlineForCom[0]['foreignAirline'] == null || empty($airlineForCom[0]['foreignAirline']) ) {
                            $foreignAirline = true;
                        } else {
                            $foreignAirline = false;
                        }

                        if (!$foreignAirline) {
                            if ( $rec['pid_private'] == '0' ) {

                                if (isset($rec['adt_price']) && $rec['adt_price'] > 0) {
                                    $amount += $rec['adt_price'] - ($rec['system_flight_commission'] * ($rec['percent_discount'] / 100));
                                }
                                if (isset($rec['chd_price']) && $rec['chd_price'] > 0) {
                                    $amount += $rec['chd_price'] - ($rec['system_flight_commission'] * ($rec['percent_discount'] / 100));
                                }
                                if (isset($rec['inf_price']) && $rec['inf_price'] > 0) {
                                    $amount += $rec['inf_price'] - ($rec['system_flight_commission'] * ($rec['percent_discount'] / 100));
                                }

                            }
                            elseif ( $rec['pid_private'] == '1' ) {

                                if ($isCounter || $isSafar360) {
                                    $amount += ($rec['adt_price'] - $rec['adt_com']) - ( $rec['adt_com'] * ( $rec['percent_discount'] / 100 ) );
                                    $amount += ($rec['chd_price'] - $rec['chd_com']) - ( $rec['chd_com'] * ( $rec['percent_discount'] / 100 ) );
                                    $amount += ($rec['inf_price'] - $rec['inf_com']) - ( $rec['inf_com'] * ( $rec['percent_discount'] / 100 ) );
                                } else {
                                    $amount += $rec['adt_price'] - ( $rec['adt_com'] * ( $rec['percent_discount'] / 100 ) );
                                    $amount += $rec['chd_price'] - ( $rec['chd_com'] * ( $rec['percent_discount'] / 100 ) );
                                    $amount += $rec['inf_price'] - ( $rec['inf_com'] * ( $rec['percent_discount'] / 100 ) );
                                }
                            }
                        }
                        else {

                            $everyAmount = $rec['api_commission'] + $rec['adt_price'] + $rec['chd_price'] + $rec['inf_price'];






                            if ( $rec['price_change'] > 0 && $rec['price_change_type'] == 'percent' ) {

                                if($rec['IsInternal'] == '1' &&  $rec['api_id'] == '14'){
                                    $everyAmountFake = $rec['api_commission'] + $rec['adt_fare'] + $rec['chd_fare'] + $rec['inf_fare'];
                                }
                                else{
                                    $everyAmountFake = $rec['api_commission'] + $rec['adt_price'] + $rec['chd_price'] + $rec['inf_price'];

                                }

                                $ChangeAmount    = $everyAmountFake * ( $rec['price_change'] / 100 );



                                $everyAmount     += $ChangeAmount;

                                $amount          += $everyAmount - ( ( $ChangeAmount * $rec['percent_discount'] ) / 100 );


                            }
                            else if ( $rec['price_change'] > 0 && $rec['price_change_type'] == 'cost' ) {
                                $ChangeAmount = $rec['price_change'];
                                $everyAmount  += $ChangeAmount;
                                $amount       += $everyAmount - ( ( $ChangeAmount * $rec['percent_discount'] ) / 100 );
                            }
                            else {
                                $amount += $everyAmount;
                            }
                        }
                    }
                }
            }
            else {
                $everyAmount = $rec['api_commission'] + $rec['adt_price'] + $rec['chd_price'] + $rec['inf_price'];

                if ($rec['price_change'] > 0 && $rec['price_change_type'] == 'cost') {
                    $everyAmount += $rec['irantech_commission'];
                    $ChangeAmount = $rec['price_change'];
                    $everyAmount += $ChangeAmount;
                    if ($rec['passenger_age'] == 'Adt' || $rec['passenger_age'] == 'Chd') {
                        $amount += $everyAmount - (($ChangeAmount * $rec['percent_discount']) / 100);
                    } else if ($rec['passenger_age'] == 'Inf') {
                        $amount += $everyAmount;
                    }
                }
                elseif ($rec['price_change'] > 0 && $rec['price_change_type'] == 'percent') {
                    $ChangeAmount = $everyAmount * ($rec['price_change'] / 100);
                    $everyAmount += $ChangeAmount;
                    $everyAmount += $rec['irantech_commission'];
                    if ($rec['passenger_age'] == 'Adt' || $rec['passenger_age'] == 'Chd') {
                        $amount += $everyAmount - (($ChangeAmount * $rec['percent_discount']) / 100);
                    } else if ($rec['passenger_age'] == 'Inf') {
                        $amount += $everyAmount;
                    }
                }
                else {
                    if ($rec['passenger_age'] == 'Adt' || $rec['passenger_age'] == 'Chd') {
                        $ChangeAmount = 0;
                        $everyAmount += $rec['irantech_commission'];
                        $amount += $everyAmount - (($ChangeAmount * $rec['percent_discount']) / 100);
                    } else if ($rec['passenger_age'] == 'Inf') {
                        $everyAmount += $rec['irantech_commission'];
                        $amount += $everyAmount;
                    }
                }
            }
        }



        return  (SOFTWARE_LANG !='fa') ? $amount : round($amount);
    }
    #endregion
    //region detailRoutesOfBook
    public function detailRoutesOfBook($RequestNumber,$direction)
    {
        $Model = Load::library('Model');
        $Sql="SELECT * FROM book_routes_tb WHERE RequestNumber='{$RequestNumber}'";
        $resultDetailTicket = $Model->select($Sql,'assoc');


        foreach ($resultDetailTicket as $res)
        {
            if($direction=='TwoWay') {
                if ($res['TypeRoute'] == 'Dept') {
                    $detailForeign['dept'] [] = $res;
                }
                if ($res['TypeRoute'] == 'Return') {
                    $detailForeign ['return'][] = $res;
                }
            }else{
                $detailForeign['oneTrip'][] = $res;
            }

        }

        return $detailForeign;
    }
    //endregion
    

}

?>
