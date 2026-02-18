<?php
//if ($_SERVER['REMOTE_ADDR'] == '84.241.4.20') {
//    error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');
//}

class trainPassengersDetail extends trainResult
{
    public $trainId ;
    public $reSearchAddress;
    public $passengers;
    public $services = array();
    public $servicesReturn = array();
    public $requestNumber ;
    public $requestNumberReturn ;


    public function __construct()
    {
        parent::__construct();
    }

    public function getTrain(){
        if(isset($_POST['serviceIdBib']) || isset($_POST['ServiceCode'])) {
            $this->trainId = isset($_POST['serviceIdBib']) ? $_POST['serviceIdBib'] : $_POST['ServiceCode'];

            $temprory = $this->getModel('temporaryTrainModel')->get()->where('ServiceCode',$this->trainId)->all();

            $date_research_address = isset($temprory[1]) ? functions::ConvertToJalali($temprory[0]['MoveDate']).'&'.functions::ConvertToJalali($temprory[1]['MoveDate']) : functions::ConvertToJalali($temprory[0]['MoveDate']) ;

            $this->reSearchAddress = ROOT_ADDRESS . '/trainResult/' . $temprory[0]['Dep_Code'].'-'.$temprory[0]['Arr_Code']. '/' . $date_research_address . '/' . $temprory[0]['PassengerNum'] . '/' . $temprory[0]['Adult']. '-' .$temprory[0]['Child']. '-' .$temprory[0]['Infant'].'/' .$_POST['IsCoupe'];

            $this->services['SCP'] = $temprory[0]['CircularPeriod'];
            $this->services['TrainNo'] = $temprory[0]['TrainNumber'];
            $this->services['Scps'] = $temprory[0]['CircularNumberSerial'];
            $this->services['WagonTypeCode'] = $temprory[0]['WagonType'];
            $this->services['MovDateTimeTrain'] = $temprory[0]['MoveDate'];
//            $this->services[5] = $temprory[0]['ServiceSessionId'];
            $this->requestNumber = $temprory[0]['code'] ;
            if (!empty($temprory[1])) {
                $this->servicesReturn['SCP'] = $temprory[1]['CircularPeriod'];
                $this->servicesReturn['TrainNo'] = $temprory[1]['TrainNumber'];
                $this->servicesReturn['Scps'] = $temprory[1]['CircularNumberSerial'];
                $this->servicesReturn['WagonTypeCode'] = $temprory[1]['WagonType'];
                $this->servicesReturn['MovDateTimeTrain'] = $temprory[1]['MoveDate'];
//                $this->servicesReturn[5] = $temprory[1]['ServiceSessionId'];
                $this->requestNumberReturn =  $temprory[1]['code'];
            }

            return $temprory;
        }
        return false;
    }

    public function getCustomers() {
        $this->passengers = $this->getController('passengers')->getAll();

    }


    public function SetTimeLimit() {

        $time = strtotime('10:00');
        return $new_time = date("H:i", strtotime('+' . ((1 - 1) * 90) . ' minutes', $time));

    }

    public function type_user($brithday)
    {

        $date_two = date("Y-m-d", strtotime("-2 year"));
        $date_twelve = date("Y-m-d", strtotime("-12 year"));


        if (strcmp($brithday, $date_two) > 0) {
            return "Inf";
        } elseif (strcmp($brithday, $date_two) <= 0 && strcmp($brithday, $date_twelve) > 0) {
            return "Chd";
        } else {
            return "Adt";
        }
    }


    public function checkExists($data,$gds_switch,$type_service) {
        return $this->getController('apiCodeExist')->checkExists($data,$gds_switch,$type_service);
    }


    public function insertCode($data_insert) {
        return $this->getController('apiCodeExist')->insertCode($data_insert);
    }

    public function getCompanyTrainPhoto($data_train,$code_train=null) {
        return $this->getController('baseCompanyBus')->getCompanyTrainPhoto($data_train,$code_train);
    }

    public function getCompanyTrainById($code_train) {
        return $this->getController('baseCompanyBus')->getCompanyTrainById($code_train);
    }

    public function getMember() {
        return $this->getController('members')->getMember();
    }

    public function getViewPriceTicket($params) {

        $temprory_results = $this->getModel('temporaryTrainModel')->get()->where('ServiceCode',$params['service_code'])->all();
        $final_result= array();

        $temprory_result['IsExclusiveCompartment'] = ($params['is_coupe'] == 1) ? 1 : 0 ;
        foreach ($temprory_results as $key =>  $temprory_result) {
            $temprory_result['passenger_count'] = 0;
            $temprory_result['passenger_count'] = intval($temprory_result['Adult'] + $temprory_result['Child'] + $temprory_result['Infant']);

 	          $final_result['adult'][] = $this->viewPriceTrain($temprory_result,1);
//            if(in_array("1" , $params['nationality_list'])){
               $final_result['nonIranian'][] = $this->viewPriceTrain($temprory_result,9, 'Adult');
//            }


            if($temprory_result['Child'] > 0 ){
                $final_result['child'][] = $this->viewPriceTrain($temprory_result,2);
            }

            if($temprory_result['Infant'] > 0 ){
                $final_result['infant'][] = $this->viewPriceTrain($temprory_result,6);
            }

            if($params['is_coupe'] == 1 ){
                $seat_count_selected =  $temprory_result['passenger_count'] ;
                $temprory_result['passenger_count'] = ((ceil($temprory_result['passenger_count']/$temprory_result['CompartmentCapicity']) * $temprory_result['CompartmentCapicity'])-($seat_count_selected)) ;

                $price_coupe = $this->viewPriceTrain($temprory_result,5);
                $final_result['coupe']['total'][]=  ($price_coupe['Prices']['BasePrice']['Amount'] * $temprory_result['passenger_count']);
                $final_result['coupe']['price_base_coupe'][]=  ($price_coupe['Prices']['BasePrice']['Amount'] );
            }

            functions::insertLog(__METHOD__ . ' starts hear - one by one' . json_encode($final_result ,256), 'log_train_not_iranian');

        }


        /*if(Session::IsLogin()){

            $type_train = ($temprory_results[0]['is_specifice'] == 'yes') ? 'PrivateTrain': 'Train';
            $compare_date= functions::compareDateTrain($temprory_results[0]['MoveDate'],$temprory_results[0]['ExitDate']);
            $discount_dept = $this->CalculateDiscount($type_train,$temprory_results[0]['Owner'],$temprory_results[0]['Cost'],$temprory_results[0]['TrainNumber'],functions::ConvertToJalali($compare_date));

            if(!empty($discount_dept)){
                $final_result['discount'][0] = $discount_dept['costOff'] ;
            }

            if(isset($final_result['adult'][1])){
                $type_train = ($temprory_results[1]['is_specifice'] == 'yes') ? 'PrivateTrain': 'Train';
                $compare_date= functions::compareDateTrain($temprory_results[1]['MoveDate'],$temprory_results[1]['ExitDate']);
                $discount_return = $this->CalculateDiscount($type_train,$temprory_results[1]['Owner'],$temprory_results[1]['Cost'],$temprory_results[1]['TrainNumber'],functions::ConvertToJalali($compare_date));
                if(!empty($discount_return)){
                    $final_result['discount'][1] = $discount_return['costOff'] ;
                }

            }

        }*/
        functions::insertLog(__METHOD__ . ' starts hear - ' . json_encode($final_result ,256), 'log_train_not_iranian');

        return functions::withSuccess($final_result,200,'request done') ;

    }

    private function viewPriceTrain($data,$type, $typePassenger = null) {
        functions::insertLog(__METHOD__ . ' starts hear - ' . json_encode([$typePassenger , $type],256), 'log_train_not_iranian');

        $type_passenger='';
        $type_key_passenger='';
        if($type==1 || ($type == 9 && $typePassenger == 'Adult')){
            $type_key_passenger = 'A' ;
            $type_passenger = 'Adult';
        }elseif($type==2 || ($type == 9 && $typePassenger == 'Child')){
            $type_key_passenger = 'C' ;
            $type_passenger = 'Child';
        }elseif($type==6|| ($type == 9 && $typePassenger == 'Infant')){
            $type_key_passenger = 'I' ;
            $type_passenger = 'Infant';
        }

        return $this->ViewPriceTicket(['UniqueId'=>$data['UniqueId'],'RequestNumber'=>$data['code'],'TariffCode'=>$type,'PassengersCount'=>$data['passenger_count'],$type_key_passenger=>$data[$type_passenger]]);
    }

    public function getServiceTrain($params) {
        $temprory_results = $this->getModel('temporaryTrainModel')->get()->where('ServiceCode',$params['service_code'])->all();
        $pIs_exclusive = $params['is_coupe'] =='1' ? 1 : 0 ;
        $result_services = array();
        foreach ($temprory_results as $temprory_result) {
            $array_data_service = ['UniqueId'=>$temprory_result['UniqueId'],'RequestNumber'=>$temprory_result['code'],'IsExclusiveCompartment'=> $pIs_exclusive];
            $services = $this->getTrainService($array_data_service);
            if(!empty($services))
            {
                $result_services[] = $services ;

            }
        }

        return functions::withSuccess($result_services,200,'request service done')  ;

    }

    public function getFreePassengerServices($params) {

        $temprory_results = $this->getModel('temporaryTrainModel')->get()->where('ServiceCode',$params['service_code'])->all();

        $pIs_exclusive = $params['is_coupe'] =='1' ? 1 : 0 ;
        $result_services = array();
        foreach ($temprory_results as $temprory_result) {
            $array_data_service = ['UniqueId'=>$temprory_result['UniqueId'],'RequestNumber'=>$temprory_result['code'],'IsExclusiveCompartment'=> $pIs_exclusive];
            $services = $this->getFreeServices($array_data_service);
            if(!empty($services))
            {
                $result_services[] = $services ;

            }
        }

        return functions::withSuccess($result_services,200,'request service done')  ;

    }
    public function getLockSeat($params) {
        $temprory_results = $this->getModel('temporaryTrainModel')->get()->where('ServiceCode',$params['service_code'])->all();
        functions::insertLog(__METHOD__ . ' PARAMS GET LOCK - ' . json_encode($params,256), 'log_train_LockSeat');
        functions::insertLog(__METHOD__ . ' Temprory_results - ' . json_encode($temprory_results,256), 'log_train_LockSeat');
        $result_lock_seat = array();
        foreach ($temprory_results as $key=>$temprory_result) {

            $seat_count = (intval($temprory_result['Adult'] + $temprory_result['Child'] + $temprory_result['Infant'])) ;

            if( $params['is_coupe'] =='1'){
                $seat_count += (((ceil($seat_count/$temprory_result['CompartmentCapicity']) * $temprory_result['CompartmentCapicity'])-($seat_count)));
            }
            $pIs_exclusive = $params['is_coupe'] =='1' ? 1 : 0 ;
            $data_lock_seat = ['UniqueId'=>$temprory_result['UniqueId'],'RequestNumber'=>$temprory_result['code'],'TypePassenger'=>$temprory_result['PassengerNum'],'SellMaster'=>'-1','IsExclusiveCompartment'=> $pIs_exclusive,'SeatCount'=>$seat_count];
            if($key==1){
                $data_lock_seat = ['UniqueId'=>$temprory_result['UniqueId'],'RequestNumber'=>$temprory_result['code'],'TypePassenger'=>$temprory_result['PassengerNum'],'SellMaster'=>$result_lock_seat[0]['Result']['SellSerial'],'IsExclusiveCompartment'=> $pIs_exclusive,'SeatCount'=>$seat_count];

            }
            functions::insertLog(__METHOD__ . ' BEFOR MAIN  LOCK - ' . json_encode($data_lock_seat,256), 'log_train_LockSeat');
            $result_lock_seat[] = $this->LockSeat($data_lock_seat);
        }

        if($params['is_json']){
            return functions::withSuccess($result_lock_seat,200,'request service done')  ;
        }

        return $result_lock_seat ;
    }


}
