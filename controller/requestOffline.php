<?php


class requestOffline extends clientAuth
{
    /** @var  $targetBookModel bool|mixed|Model|ModelBase*/
    protected $targetBookModel;
    /** @var  $targetReservationController reservationTour */



    protected $requestOfflineModel;


    public function __construct() {
        parent::__construct();
        $this->requestOfflineModel=$this->getModel('requestOfflineModel');
    }

    /**
     * @param array $requestOfflineList
     * @return array
     */
    public function addRequestOfflineIndexes(array $requestOfflineList) {

        $result = [];

        foreach ($requestOfflineList as $key => $requestOffline){

            $result[$key] = $requestOffline ;
            $result[$key]['requested_data'] = $this->getRequsetOfflineData($requestOffline);
            $time_date = functions::ConvertToDateJalaliInt($requestOffline['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);
        }
        return $result;
    }

    /**
     * @param $request_offline_id
     * @return array
     */
    public function getRequsetOfflineData($requestOffline) {
        $position = $this->getController('positions');
        $request_data = json_decode($requestOffline['requested_data'], true) ;
        $data = [];
        switch ($request_data['service']) {
            case 'Flight' :
                $data['origin']['key'] = functions::Xmlinformation('Origin');
                $data['origin']['value'] = isset($position->ListPositionFlight()[$request_data['origin']]['name']) ? $position->ListPositionFlight()[$request_data['origin']]['name'] : '';
                $data['destination']['key'] = functions::Xmlinformation('Destination');
                $data['destination']['value'] =  isset($position->ListPositionFlight()[$request_data['destination']]['name']) ? $position->ListPositionFlight()[$request_data['destination']]['name'] : '';
                $data['departure_date']['key']   = functions::Xmlinformation('Datetravelwent');
                $data['departure_date']['value'] = str_replace("-","/",$request_data['departureDate']);
                if($data['return_date']) {
                    $data['return_date']['key']   = functions::Xmlinformation('Datewentback');
                    $data['return_date']['value']   = str_replace("-","/",$request_data['arrivalDate']);
                }

                $data['adult']['key']   = functions::Xmlinformation('Adult');
                $data['adult']['value']   = $request_data['adult'];
                $data['child']['key']   = functions::Xmlinformation('Child');
                $data['child']['value']   = $request_data['child'];
                $data['infant']['key']   = functions::Xmlinformation('Baby');
                $data['infant']['value']   = $request_data['infant'];

                break;

            case 'Bus' :
                $data['origin']['key'] = functions::Xmlinformation('Origin');
                $data['origin']['value'] = isset($position->ListPositionBus()[$request_data['origin']]['name']) ? $position->ListPositionBus()[$request_data['origin']]['name'] : '' ;
                $data['destination']['key'] = functions::Xmlinformation('Destination');
                $data['destination']['value'] =  isset($position->ListPositionBus()[$request_data['destination']]['name']) ? $position->ListPositionBus()[$request_data['destination']]['name'] : '';
                $data['date']['key']   = functions::Xmlinformation('Datetravelwent');
                $data['date']['value']   = str_replace("-","/",$request_data['date']);

                break;
        }
        return  $data;

    }

    public function create($params) {

        if(!is_array($params['infoRequestOffline'])) {
        $request_data = json_decode($params['infoRequestOffline'], true);
        }

        $result_insert_request = $this->requestOfflineModel->insertWithBind([
            'service_name' => $request_data['service'],
            'full_name' => $params['fullName'],
            'mobile' => $params['mobile'],
            'description' => $params['description'],
            'requested_data' => $params['infoRequestOffline'],
        ]);

        if($result_insert_request)
        {
            $Message['messageRequest'] = 'درخواست شما با موفقیت ارسال شد';
            $Message['messageStatus'] = 'Success';


            $smsController = Load::controller('smsServices');
            $objSms = $smsController->initService('0');
            if($objSms) {
                // sms to admin
                $sms = "یک درخواست رزرو ".  functions::Xmlinformation($request_data['service']) ." به شرح زیر ارسال شده است".PHP_EOL."نام مسافر:".$params['fullName'] . PHP_EOL."شماره تلفن مسافر:".$params['mobile'].PHP_EOL;
                $smsArray = array(
                    'smsMessage' => $sms,
                    'cellNumber' => CLIENT_MOBILE
                );
                $smsController->sendSMS($smsArray);
                // sms to user
                $sms = "".  $params['fullName'] ." عزیز درخواست شما با موفقیت ثبت شد. در صورت موجود شدن با شما تماس خواهیم گرفت.";
                $sms = "مسافر محترم ".  $params['fullName'] ."،" . PHP_EOL .
                    "درخواست لیست انتظار شما با موفقیت ثبت شد. درصورت اعلام ظرفیت باشما تماس خواهیم گرفت."  . PHP_EOL .
                    CLIENT_NAME . PHP_EOL .
                    "WWW.VERSAGASHT.COM";
                $smsArray = array(
                    'smsMessage' => $sms,
                    'cellNumber' => $params['mobile']
                );
                $smsController->sendSMS($smsArray);
            }


        }else{
            $Message['messageRequest'] = 'خطا در ثبت درخواست';
            $Message['messageStatus'] = 'Error';
        }

        return functions::clearJsonHiddenCharacters(json_encode($Message));

    }

    public function getRequestList() {
        $request_offline_list =  $this->requestOfflineModel->get()->where('deleted_at', null, 'IS')->orderBy('created_at')->all(false);
        $result['data'] = $this->addRequestOfflineIndexes($request_offline_list);

        return $result ;
    }


    public function DeleteRequestOffline($formData = []) {

        if (!isset($formData['id'])) {
            return self::returnJson(false, 'مطلب مورد نظر یافت نشد', null, 404);
        }

        $delete = [
            'deleted_at' => date('Y-m-d H:i:s', time()),
        ];

        if ($this->requestOfflineModel->updateWithBind($delete, "id='{$formData['id']}'")) {
            return self::returnJson(true, 'این درخواست با موفقیت حذف شد');
        }

        return self::returnJson(false, 'خطا در حذف این درخواست', null, 400);
    }

    public function requestOfflineSelectedToggle($param) {
        $request_offline_id = $param['request_id'];
        $final_massage = 'به لیست خوانده شده ها اضافه شد';

        $update_result = $this->requestOfflineModel->updateWithBind([
            'read_at' => date('Y-m-d H:i:s', time())
        ], [
            'id' => $request_offline_id
        ]);
        if ($update_result) {
            return self::returnJson(true, $final_massage);
        }
        return self::returnJson(false, 'خطا در  این درخواست', null, 400);

    }
    public function checkAccess ($service){
        $fullCapacityController = Load::controller('fullCapacity');
        switch ($service['service']) {
            case 'internal-flight' :
                $check_service = 'internalFlightWaitingList' ;
                break;
            case 'international-flight' :
                $check_service = 'internationalFlightWaitingList' ;
                break;
        }
        $fullCapacity =  $fullCapacityController->getFullCapacitySite(1);
        $check_access = functions::checkClientConfigurationAccess($check_service);
        $check_access_result['result']['data'] = $check_access;
        $check_access_result['result']['fullCapacity'] = $fullCapacity;
        $check_access_result['result']['status'] = 'success';
        return functions::clearJsonHiddenCharacters(json_encode($check_access_result));
    }


    public function returnJson($success = true, $message = '', $data = null, $statusCode = 200) {
        http_response_code($statusCode);
        $return = json_encode([
            'success' => $success,
            'message' => $message,
            'code' => $statusCode,
            'data' => $data
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        return $return;
    }
}