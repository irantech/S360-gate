<?php

/**
 * Class routeFlight
 * @property routeFlight $routeFlight
 */
class routeFlight extends clientAuth
{

    public function __construct() {
        parent::__construct();

    }

    //region [getInfoAirportPortal]

    /**
     * @return array
     */
    public function getInfoAirportPortal() {
        return $this->flightPortalModel()->get()->all();
    }
    //endregion

    //region [flightPortalModel]

    /**
     * @return bool|mixed|flightPortalModel
     */
    public function flightPortalModel() {

        return Load::getModel('flightPortalModel');
    }
    //endregion

    #region flightRouteInternal
    public function flightRouteInternal($param) {

        if(isset($param['use_customer_db']) && $param['use_customer_db']){
            return $this->getModel('flightRouteCustomerModel')->getFlightRoutInternal($param);
        }
        return $this->getModel('flightRouteModel')->getFlightRoutInternal($param);
    }
    #endregion

    #region listRouteArrival
    public function listRouteArrival($data) {
        $code = is_array($data) ? $data['iata'] : $data ;

        if(isset($data['use_customer_db']) && $data['use_customer_db']) {
            $result = $this->getModel('flightRouteCustomerModel');
        }else {
            $result = $this->getModel('flightRouteModel');
        }
        $result = $result->get( [
            'Arrival_Code',
            'Arrival_City',
            'Arrival_CityEn',
            'Departure_Code',
            'Departure_City',
            'priorityArrival'
        ] )->where('Departure_Code', $code)->where('local_portal', '0');
//        if (!isset($data['is_group'])) {
//            $result = $result->groupBy('Departure_code');
//        }

        $result = $result->orderBy('priorityArrival=0,priorityArrival', 'ASC');

        if (isset($data['limit']) && $data['limit']) {
            $result = $result->limit(0, $data['limit']);
        }
        $results_arrival = $result->all();

        if(isset($data['is_json']) && $data['is_json']){
            if($results_arrival){
                return functions::withSuccess($results_arrival,200,'data fetched');
            }
            return functions::withSuccess($results_arrival,200,'خطا در گرفتن مقاصد پرواز');
        }
        return $results_arrival ;
    }
    #endregion

    #region SetPriorityParentDeparture

    public function SetPriorityParentDeparture($Param) {
        $Model = Load::library('Model');
        $Model->setTable('flight_route_tb');
        $p1 = $Param['PriorityOld'];
        $p2 = $Param['PriorityNew'];
        $Code = $Param['CodeDeparture'];

        $RoutesSql = "SELECT * FROM flight_route_tb WHERE Departure_Code <> '{$Code}' AND local_portal='0' GROUP BY  Departure_Code";
        $ResultRoutesSql = $Model->select($RoutesSql);


        $RoutesSql = "SELECT max(priorityDeparture) AS MAXPriority FROM flight_route_tb
                      WHERE EXISTS (SELECT * FROM flight_route_tb WHERE priorityDeparture ='{$p2}' AND local_portal='0')";
        $PriorityMax = $Model->load($RoutesSql);

        $flag = false;

        if ($p1 == 0) {
            //مقدار کد مور نظر آپدیت میشود

            $Condition = "Departure_Code='{$Code}'";
            $dataCodeUp['priorityDeparture'] = !empty($PriorityMax['MAXPriority']) ? ($PriorityMax['MAXPriority'] + 1) : $p2;
            $updatePriorityCode = $Model->update($dataCodeUp, $Condition);
            if ($updatePriorityCode) {
                $flag = true;
            }
        } elseif ($p1 < $p2) {// الویت را بیشتر میکنیم
            for ($j = 0; $j < count($ResultRoutesSql); $j++) {
                if ($ResultRoutesSql[$j]['priorityDeparture'] != 0) {
                    $dataUp['priorityDeparture'] = $ResultRoutesSql[$j]['priorityDeparture'] - 1;
                } else {
                    $dataUp['priorityDeparture'] = 0;
                }
                $Condition = "priorityDeparture>='{$p1}' AND priorityDeparture<='{$p2}' AND Departure_Code = '{$ResultRoutesSql[$j]['Departure_Code']}' AND priorityDeparture <> '0' AND local_portal='0'";
                $updatePriorityOtherCode = $Model->update($dataUp, $Condition);
            }
            //مقدار کد مور نظر آپدیت میشود
            $Condition = "Departure_Code='{$Code}'";
            $dataCodeUp['priorityDeparture'] = $p2;
            $updatePriorityCode = $Model->update($dataCodeUp, $Condition);

            if ($updatePriorityCode && $updatePriorityOtherCode) {
                $flag = true;
            }
        } elseif ($p1 > $p2) {// الویت را کمتر میکنیم
            for ($j = 0; $j < count($ResultRoutesSql); $j++) { // upd maghadir beyne p1 & p2
                if ($ResultRoutesSql[$j]['priorityDeparture'] != 0) {
                    $dataDown['priorityDeparture'] = $ResultRoutesSql[$j]['priorityDeparture'] + 1;
                } else {
                    $dataDown['priorityDeparture'] = 0;
                }
                $Condition = "priorityDeparture<='{$p1}' AND priorityDeparture>='{$p2}' AND Departure_Code = '{$ResultRoutesSql[$j]['Departure_Code']}' AND priorityDeparture <> '0' AND local_portal='0'";
                $updatePriorityOtherCode = $Model->update($dataDown, $Condition);
            }
            //مقدار کد مور نظر آپدیت میشود
            $dataDownCode['priorityDeparture'] = $p2;
            $Condition = "Departure_Code='{$Code}'";
            $updatePriorityCode = $Model->update($dataDownCode, $Condition);


            if ($updatePriorityCode && $updatePriorityOtherCode) {
                $flag = true;
            }
        }

        if ($flag) {
            return 'SuccessChangePriority:تغییر الویت با موفیقت انجام شد';
        } else {
            return 'ErrorChangePriority:خطا در تغییر الویت';
        }

    }

    #endregion

    #region SetPriorityArrival
    public function SetPriorityArrival($Param) {
        $Model = Load::library('Model');
        $Model->setTable('flight_route_tb');
        $p1 = $Param['PriorityOld'];
        $p2 = $Param['PriorityNew'];
        $CodeDeparture = $Param['CodeDeparture'];
        $CodeArrival = $Param['CodeArrival'];

        $RoutesSql = "SELECT * FROM flight_route_tb WHERE Departure_Code = '{$CodeDeparture}' AND priorityArrival <> '0' AND local_portal='0' ";
        $ResultRoutesArrivalSql = $Model->select($RoutesSql);


        $RoutesSql = "SELECT max(priorityArrival) AS MAXPriority FROM flight_route_tb
                      WHERE EXISTS (SELECT * FROM flight_route_tb WHERE Departure_Code='{$CodeDeparture}' AND  priorityArrival ='{$p2}' AND local_portal='0')";
        $PriorityMax = $Model->load($RoutesSql);

        $flag = false;

        if ($p1 == 0) {
            //مقدار کد مور نظر آپدیت میشود
            $Condition = "Departure_Code='{$CodeDeparture}' AND Arrival_Code='{$CodeArrival}'";
            $dataCodeUp['priorityArrival'] = !empty($PriorityMax['MAXPriority']) ? ($PriorityMax['MAXPriority'] + 1) : $p2;
            $updatePriorityCode = $Model->update($dataCodeUp, $Condition);
            if ($updatePriorityCode) {
                $flag = true;
            }
        } elseif ($p1 < $p2) {// الویت را بیشتر میکنیم
            foreach ($ResultRoutesArrivalSql as $route) {

                $dataUpArrival['priorityArrival'] = $route['priorityArrival'] - 1;
                $ConditionArrivalUp = "priorityArrival > '{$p1}' AND priorityArrival <= '{$p2}' AND Departure_Code = '{$CodeDeparture}'  AND Arrival_Code='{$route['Arrival_Code']}' AND local_portal='0'";
                $updatePriorityOtherCode = $Model->update($dataUpArrival, $ConditionArrivalUp);
            }
//            مقدار کد مور نظر آپدیت میشود
            $Condition = "Departure_Code='{$CodeDeparture}' AND Arrival_Code='{$CodeArrival}'";
            $dataCodeUp['priorityArrival'] = $p2;
            $updatePriorityCode = $Model->update($dataCodeUp, $Condition);

            if ($updatePriorityCode && $updatePriorityOtherCode) {
                $flag = true;
            }
        } else
            if ($p1 > $p2) {// الویت را کمتر میکنیم
                foreach ($ResultRoutesArrivalSql as $route) { // upd maghadir beyne p1 & p2
                    $dataDownArrival['priorityArrival'] = $route['priorityArrival'] + 1;

                    $Condition = " priorityArrival<'{$p1}' AND priorityArrival >= '{$p2}' AND Departure_Code = '{$CodeDeparture}'  AND Arrival_Code='{$route['Arrival_Code']}' AND local_portal='0'";
                    $updatePriorityOtherCode = $Model->update($dataDownArrival, $Condition);
                }
//            مقدار کد مور نظر آپدیت میشود
                $dataDownCode['priorityArrival'] = $p2;
                $Condition = "Departure_Code='{$CodeDeparture}' AND Arrival_Code='{$CodeArrival}'";
                $updatePriorityCode = $Model->update($dataDownCode, $Condition);
                if ($updatePriorityCode && $updatePriorityOtherCode) {
                    $flag = true;
                }
            }

        if ($flag) {
            return 'SuccessChangePriority:تغییر الویت با موفیقت انجام شد';
        } else {
            return 'ErrorChangePriority:خطا در تغییر الویت';
        }

    }

    #endregion

    #region list order route foreign
    public function ListOrderCityForeign() {
        return $this->getModel('defaultFlightPortalModel')->get()->all();
    }

    #endregion

    public function addOrderToRouteFlightForeign($params) {
        $info_airport = $this->getModel('flightPortalModel')->get()->where('DepartureCode', $params['iata_code'])->find();
        if (!empty($info_airport)) {
            $info_airport_client = $this->getModel('defaultFlightPortalModel')->get()->where('DepartureCode', $params['iata_code'])->find();
            if (empty($info_airport_client)) {
                $airport_exist_count = $this->getModel('defaultFlightPortalModel')->get()->all();
                if (count($airport_exist_count) < 12) {
                    $data_insert['DepartureCode'] = $info_airport['DepartureCode'];
                    $data_insert['DepartureCityEn'] = $info_airport['DepartureCityEn'];
                    $data_insert['DepartureCityFa'] = $info_airport['DepartureCityFa'];
                    $data_insert['AirportFa'] = $info_airport['AirportFa'];
                    $data_insert['AirportEn'] = $info_airport['AirportEn'];
                    $data_insert['CountryFa'] = $info_airport['CountryFa'];
                    $data_insert['CountryEn'] = $info_airport['CountryEn'];
                    $insert_route = $this->getModel('defaultFlightPortalModel')->insertWithBind($data_insert);
                    if ($insert_route) {
                        $data_message = ' اطلاعات با موفقیت ثبت شد';
                        return functions::withSuccess('', 200, $data_message);
                    } else {
                        $data_message = 'خطا در ثبت اطلاعات';
                    }
                } else {
                    $data_message = 'از 12 فرودگاه(شهر یا کشور) بیشتر اجازه ثبت ندارید';
                }

            } else {
                $data_message = 'اطلاعات قبلا ثبت شده است';
            }


        } else {
            $data_message = 'خطا در ازسال اطلاعات';
        }
        return functions::withSuccess('', 400, $data_message);


    }

    public function deleteSortRouteFlightForeign($param) {
        $Model = Load::library('Model');
        $SqlAirportClient = "SELECT * FROM flight_portal_tb WHERE id='{$param['idFlight']}'";
        $infoAirportClient = $Model->load($SqlAirportClient);

        if (!empty($infoAirportClient)) {
            $condition = "id='{$param['idFlight']}'";
            $Model->setTable('flight_portal_tb');
            $deleteRoute = $Model->delete($condition);

            if ($deleteRoute) {
                $data['result_status'] = "Success";
                $data['result_message'] = "حذف با موفقیت انجام شد";
            } else {
                $data['result_status'] = "Error";
                $data['result_message'] = "خطا در حذف اطلاعات";
            }
        } else {
            $data['result_status'] = "Error";
            $data['result_message'] = "خطا در شناسایی فرودگاه ،شهر یا کشور";
        }

        return json_encode($data);
    }

    public function searchListCityByIata($iata_city) {

        $parent_code = $iata_city . 'ALL';
        $order_by = "FIELD(DepartureCode,'{$iata_city}','{$parent_code}')";
        $result = $this->flightPortalModel()->get();
//        if(CLIENT_ID == '186') {
//            $result = $result->where('CountryEn' , 'Iraq' , '!=')->openParentheses();
//        }

        $result = $result->like('DepartureCode', $iata_city)
            ->like('DepartureCode', $parent_code)
            ->like('DepartureCityEn', $iata_city)
            ->like('DepartureCityFa', $iata_city)
            ->like('AirportFa', $iata_city)
            ->like('AirportEn', $iata_city)
            ->like('CountryFa', $iata_city)
            ->like('CountryEn', $iata_city)
            ->like('ParentCode', $iata_city);
//        if(CLIENT_ID == '186') {
//            $result = $result->closeParentheses();
//        }
        $result = $result->orderBy($order_by, 'DESC')->all();

        return array_map(function ($item) {
            if (is_null($item['DepartureCityAr']) || $item['DepartureCityAr'] == NULL) {
                $item['DepartureCityAr'] = $item['DepartureCityEn'];
            }
            if (is_null($item['AirportAr']) || $item['AirportAr'] == NULL) {
                $item['AirportAr'] = $item['AirportEn'];
            }
            if (is_null($item['CountryAr']) || $item['CountryAr'] == NULL) {
                $item['CountryAr'] = $item['CountryEn'];
            }
            return $item;
        }, $result);


    }

    public function cityForSearchInternational($data) {

        $airports = $this->searchListCityByIata($data['iata']);
        $array_sub_iata = array();
        $array_final_city= array();
        $array_final_city_complete= array();
        foreach ($airports as $airport) {
            if(empty($airport['ParentCode'])) {
                $array_final_city[$airport['DepartureCode']] = $airport;
                $array_sub_iata [] = $airport['DepartureCode'];
            }elseif(in_array($airport['ParentCode'],$array_sub_iata)){
                $array_final_city[$airport['ParentCode']]['sub'][] = $airport;
            }
        }

        foreach ($array_final_city as $item) {
            $array_final_city_complete[] = $item ;
        }


        if($array_final_city_complete){
            return functions::withSuccess($array_final_city_complete,200,'data fetched successfully');
        }

        return functions::withError('',404,'data is wrong');
    }

    public function cityForSearchPackage($data) {

        $iata_city=$data['iata'];
        $parent_code = $data['iata'] . 'ALL';
        $order_by = "FIELD(DepartureCode,'{$iata_city}','{$parent_code}')";
        $result = $this->flightPortalModel()->get()
            ->like('DepartureCode', $iata_city)
            ->like('DepartureCode', $parent_code)
            ->like('DepartureCityEn', $iata_city)
            ->like('DepartureCityFa', $iata_city)
            ->like('AirportFa', $iata_city)
            ->like('AirportEn', $iata_city)
            ->like('CountryFa', $iata_city)
            ->like('CountryEn', $iata_city)
            ->like('ParentCode', $iata_city)
            ->orderBy($order_by, 'DESC')
            ->all();
        $result=array_map(function ($item) {
            if (is_null($item['DepartureCityAr']) || $item['DepartureCityAr'] == NULL) {
                $item['DepartureCityAr'] = $item['DepartureCityEn'];
            }
            if (is_null($item['AirportAr']) || $item['AirportAr'] == NULL) {
                $item['AirportAr'] = $item['AirportEn'];
            }
            if (is_null($item['CountryAr']) || $item['CountryAr'] == NULL) {
                $item['CountryAr'] = $item['CountryEn'];
            }
            return $item;
        }, $result);
        $airports=$result;


        $array_sub_iata = array();
        $array_final_city= array();
        $array_final_city_complete= array();
        foreach ($airports as $airport) {
            if(empty($airport['ParentCode'])) {
                $array_final_city[$airport['DepartureCode']] = $airport;
                $array_sub_iata [] = $airport['DepartureCode'];
            }elseif(in_array($airport['ParentCode'],$array_sub_iata)){
                $array_final_city[$airport['ParentCode']]['sub'][] = $airport;
            }
        }

        foreach ($airports as $item) {
            $array_final_city_complete[] = $item ;
        }


        if($array_final_city_complete){
            return functions::withSuccess($array_final_city_complete,200,'data fetched successfully');
        }

        return functions::withError('',404,'data is wrong');
    }

    public function getRouteInternal($params) {
        return $this->getModel('flightRouteModel')->get()->where('Departure_Code',$params['origin'])->where('Arrival_Code',$params['destination'])->find();
    }


    public function defaultInternationalFlight($data) {

        $model = (isset($data['use_customer_db']) && $data['use_customer_db']) ? $this->getModel('defaultFlightPortalModel'): $this->getModel('flightPortalModal');

        $result = $model->get() ;

        if($data['destination_city']){
            $result = $result->whereIn('DepartureCode',$data['destination_city']) ;
        }
     
        return  $result->all();
    }

    public function getPopularInternationFlight($param){
        if (isset( $request['self_Db'] ) && $request['self_Db'] != true)  {
            $result = $this->flightPortalModel()->get( [
                'DepartureCode',
                'DepartureCityEn',
                'DepartureCityFa',
                'DepartureCityAr',
                'AirportFa',
                'AirportEn',
                'AirportAr',
                'CountryFa',
                'CountryEn',
                'CountryAr'
            ]);
            if (isset($param['limit']) && $param['limit']) {
                $result = $result->limit(0, $param['limit']);
            }
            $result = $result->all();
            foreach ($result as $key => $item) {
                $result[$key]['FlightType'] = 'External';
            }
            return $result;
        }else{
            $Model = Load::library( 'Model' );
            $clientSql = "SELECT DepartureCode,DepartureCityEn,DepartureCityFa , DepartureCityAr,AirportFa,AirportEn,AirportAr,CountryFa,CountryEn,CountryAr  FROM flight_portal_tb";
            $result = $Model->select( $clientSql );
            foreach ($result as $key => $item) {
                $result[$key]['FlightType'] = 'External';
            }
            return $result;
        }

    }

  
}



