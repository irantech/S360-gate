<?php

/**
 * Class priceChanges
 * @property priceChanges $priceChanges
 */
class priceChanges extends baseController
{

    #region [Variables]
    public $list = array();     //array that include list of flight price changes
    #endregion

    #region [__construct]
    public function __construct(){


    }
    #endregion

    //region [flightPriceChangeModel]
    /**
     * @return bool|mixed|flightPriceChangesModel
     */
    public function flightPriceChangesModel()
    {
        return Load::getModel('flightPriceChangesModel');
    }
    //endregion

    //region [listPriceChangeByLocality]

    /**
     * @param $type
     * @return array
     */
    public function listPriceChangeByLocality($type)
    {
        return $this->getModel('flightPriceChangesModel')->get()->where('locality', $type)->all();
    }
    //endregion

    /**
     * @return array
     */
    public function listPriceChanges()
    {
        return $this->getModel('flightPriceChangesModel')->get()->all();
    }

    #region [updatePrice]


    /**
     * todo: after use function listPriceChanges, this function will deleting
     */
    public function getAll()
    {

        Load::autoload('Model');
        $Model = new Model();

        $query = "SELECT * FROM flight_price_changes_tb";
        $result = $Model->select($query);
        foreach ($result as $record) {
            $airline = $record['airline_iata'];
            $counter = $record['counter_id'];
            $locality = $record['locality'];
            $this->list[$locality][$airline][$counter] = $record;

        }

    }
    #endregion

    #region [getAll: get all flight price changes records]

    /**
     * @param $data_price_change
     * @return mixed
     */
    public function getChangePriceByCounterAndAirline($data_price_change)
    {

        return $this->getModel('flightPriceChangesModel')->get()->where('counter_id', $data_price_change['counter_id'])->
        where('airline_iata', $data_price_change['airline_iata'])->where('locality', $data_price_change['locality'])->where('flight_type', $data_price_change['flight_type'])->find();

    }
    #endregion

    #region [setPriceForAll: get one record of flight price changes by counter_id and airline_iata]

    /**
     * @param $input
     * @return success
     */
    public function setPriceForAll($input)
    {

        $counterType = Load::controller('counterType');
        $counterType->getAll('all');

        $airline = Load::controller('airline');
        $airline->getAll();

        foreach ($airline->list as $eachAirline) {
            foreach ($counterType->list as $eachCounter) {

                $data['counterID'] = $eachCounter['id'];
                $data['airlineIata'] = $eachAirline['abbreviation'];
                $data['price'] = $input['priceChangesAll'];
                $data['changeType'] = $input['changeTypeAll'];
                $data['locality'] = $input['locality'];
                $data['isAll'] = 'yes';
                $resultSet = $this->updatePrice($data);

            }
        }

        if ($resultSet) {
            $dataHistory = array(
                'price' => $input['priceChangesAll'],
                'changeType' => $input['changeTypeAll'],
                'airline_iata' => 'ALL',
                'counter_id' => '0',
                'locality' => $input['locality'],
                'creation_date' => date('Y-m-d H:i:s')
            );
            $Model = new Model();
            $Model->setTable('flight_price_changes_history_tb');
            $Model->insertLocal($dataHistory);
        }

        return $resultSet;

    }
    #endregion

    #region [resetAll: reset all priceChanges values]

    public function resetAll($locality)
    {

        $Model = new Model();
        $Model->setTable('flight_price_changes_tb');

        $data['price'] = 0;
        $data['changeType'] = 'cost';
        $condition = "locality = '{$locality}'";
        $res = $Model->update($data, $condition);

        if ($res) {
            $dataHistory = array(
                'price' => 0,
                'changeType' => 'cost',
                'airline_iata' => 'ALL',
                'counter_id' => '0',
                'locality' => $locality,
                'creation_date' => date('Y-m-d H:i:s')
            );
            $Model->setTable('flight_price_changes_history_tb');
            $Model->insertLocal($dataHistory);

            return 'success : تغییرات با موفقیت انجام شد';
        } else {
            return 'error : خطا در تغییرات';
        }

    }
    #endregion

    #region [getAllHistory: get all history of flight price changes records]
    /**
     * get all price changes history
     * @return array of flight price changes history
     *
     */
    public function getHistoryByAirline($Airline, $Locality)
    {

        Load::autoload('Model');
        $Model = new Model();

        if ($Locality == 'international') {
            $condition = " AND locality = 'international' ";
        } else {
            $condition = " AND locality = 'local' ";
        }

        $query = "SELECT * FROM flight_price_changes_history_tb WHERE (airline_iata = '{$Airline}' OR airline_iata = 'ALL') {$condition} ORDER BY creation_date DESC";
        return $Model->select($query);

    }
    #endregion

    #region [getHistoryAirlines: get airlines which exist in history of flight price changes]

    /**
     * @return array
     * @throws Exception
     */
    public function getHistoryAirlines(){
        return $this->getModel('flightPriceChangesHistoryModel')->get()->groupBy('airline_iata')->all();
    }
    #endregion

    public function getAllHistoryChangePriceSpecificAirline($airline_iata){
        return $this->getModel('flightPriceChangesHistoryModel')->get()->where('airline_iata',$airline_iata)->all();
    }

    #region [addOrUpdatePriceChanges]
    public function addOrUpdatePriceChanges($data_change_price)
    {
        if ($data_change_price['airline_iata'] == 'all' && $data_change_price['counter_type'] == 'all') {
            return $this->insertAllAirlineAndAllCounter($data_change_price);
        }elseif($data_change_price['airline_iata'] == 'all' && $data_change_price['counter_type'] != 'all'){
            return $this->insertAllAirlineAndSpecificCounter($data_change_price);
        }elseif($data_change_price['airline_iata'] != 'all' && $data_change_price['counter_type'] == 'all'){
            return $this->insertSpecificAirlineAndAllCounter($data_change_price);
        }else{
            return $this->insertOneSpecificChangePrice($data_change_price);
        }
    }
    #endregion

    #region [insertOrUpdateAllAirlineAndCounter]
    private function insertAllAirlineAndAllCounter($data_change_price)
    {

        $airlines = $this->getController('airline')->airLineList();
        $counters = $this->getController('counterType')->listCounterType();
        $condition = "flight_type='{$data_change_price['flight_type']}' AND locality='{$data_change_price['locality']}'";
        $delete_table_type = $this->getModel('flightPriceChangesModel')->delete($condition);

        if (is_bool($delete_table_type)) {
            $status_final_result = false;
            $count_insert_change_price= 0;
            $date = date("Y-m-d H:i:s",time());
            $sql_insert_change_price = " INSERT INTO flight_price_changes_tb VALUES";
            foreach ($airlines as $eachAirline) {
                foreach ($counters as $eachCounter) {
                    if ($data_change_price['flight_type'] == 'system' && $data_change_price['locality'] != 'local' && $eachAirline['foreignAirline'] == 'inactive' && $data_change_price['price'] != '0') {
                        continue;
                    }
                    $count_insert_change_price++;
                    $sql_insert_change_price .= "( '', '" . $data_change_price['flight_type'] . "','" . $data_change_price['price'] . "','" . $data_change_price['change_type'] . "','" . $eachAirline['abbreviation'] . "','" . $eachCounter['id'] . "','" . $data_change_price['locality'] . "','" . $date . "','" . $date . "'),";
                    if ($count_insert_change_price % 100 == 0) {
                        $sql_insert_change_price = substr($sql_insert_change_price, 0, -1);
                        functions::insertLog($sql_insert_change_price,'log_change_price');
                        $res = $this->getModel('flightPriceChangesModel')->execQuery($sql_insert_change_price);
                        $sql_insert_change_price="";
                        $sql_insert_change_price = " INSERT INTO flight_price_changes_tb VALUES";
                        if($res){
                            $status_final_result = true ;
                        }
                    }



                }

            }

            //ثبت تعداد رکورد کمتر از 100 تا اینجا اتفاق میفتد
            if ($sql_insert_change_price != '' && $count_insert_change_price > 0) {

                $sql_insert_change_price = substr($sql_insert_change_price, 0, -1);
                functions::insertLog($sql_insert_change_price,'log_change_price');
                $res = $this->getModel('flightPriceChangesModel')->execQuery($sql_insert_change_price);
                if($res){
                    $status_final_result = true ;
                }
            }
            if ($status_final_result) {
                $dataHistory = array(
                    'price' => $data_change_price['price'],
                    'change_type' => $data_change_price['change_type'],
                    'flight_type' => $data_change_price['flight_type'],
                    'airline_iata' => 'ALL',
                    'counter_id' => '0',
                    'locality' => $data_change_price['locality'],
                    'creation_date' => date('Y-m-d H:i:s')
                );

                $this->getModel('flightPriceChangesHistoryModel')->insertLocal($dataHistory);
                return functions::withSuccess(array(), 200, 'ثبت اطلاعات با موفقیت انجام شد');
            }

            return functions::withError(array(), 200, 'خطا در ثبت یا تغییرا اطلاعات');
        }


    }
    #endregion

    #region [insertAllAirlineAndSpecificCounter]
    /**
     * @param $data_change_price
     * @return bool|mixed|string
     */
    private function insertAllAirlineAndSpecificCounter($data_change_price){

        $airlines = $this->getController('airline')->airLineList();
        $condition = "flight_type='{$data_change_price['flight_type']}' AND locality='{$data_change_price['locality']}' AND counter_id='{$data_change_price['counter_type']}'";
        $delete_table_type = $this->getModel('flightPriceChangesModel')->delete($condition);
        if (is_bool($delete_table_type)) {
            $status_final_result = false;
            $count_insert_change_price= 0;
            $date = date("Y-m-d H:i:s",time());
            $sql_insert_change_price = " INSERT INTO flight_price_changes_tb VALUES";
            foreach ($airlines as $eachAirline) {
                if ($data_change_price['flight_type'] == 'system' && $data_change_price['locality'] != 'local' && $eachAirline['foreignAirline'] == 'inactive' && $data_change_price['price'] != '0') {
                    continue;
                }
                $count_insert_change_price++;
                $sql_insert_change_price .= "( '', '" . $data_change_price['flight_type'] . "','" . $data_change_price['price'] . "','" . $data_change_price['change_type'] . "','" . $eachAirline['abbreviation'] . "','" . $data_change_price['counter_type'] . "','" . $data_change_price['locality'] . "','" . $date . "','" . $date . "'),";
                if ($count_insert_change_price % 100 == 0) {
                    $sql_insert_change_price = substr($sql_insert_change_price, 0, -1);
                    functions::insertLog($sql_insert_change_price, 'log_change_price');
                    $res = $this->getModel('flightPriceChangesModel')->execQuery($sql_insert_change_price);
                    $sql_insert_change_price = "";
                    $sql_insert_change_price = " INSERT INTO flight_price_changes_tb VALUES";
                    if ($res) {
                        $status_final_result = true;
                    }
                }

            }

            //ثبت تعداد رکورد کمتر از 100 تا اینجا اتفاق میفتد
            if ($sql_insert_change_price != '' && $count_insert_change_price > 0) {

                $sql_insert_change_price = substr($sql_insert_change_price, 0, -1);
                functions::insertLog($sql_insert_change_price,'log_change_price');
                $res = $this->getModel('flightPriceChangesModel')->execQuery($sql_insert_change_price);
                if($res){
                    $status_final_result = true ;
                }
            }
            if ($status_final_result) {
                $dataHistory = array(
                    'price' => $data_change_price['price'],
                    'change_type' => $data_change_price['change_type'],
                    'flight_type' => $data_change_price['flight_type'],
                    'airline_iata' => 'ALL',
                    'counter_id' => $data_change_price['counter_type'],
                    'locality' => $data_change_price['locality'],
                    'creation_date' => date('Y-m-d H:i:s')
                );

                $this->getModel('flightPriceChangesHistoryModel')->insertLocal($dataHistory);
                return functions::withSuccess(array(), 200, 'ثبت اطلاعات با موفقیت انجام شد');
            }

            return functions::withError(array(), 200, 'خطا در ثبت یا تغییرا اطلاعات');
        }
    }
    #endregion

    #region [insertSpecificAirlineAndAllCounter]
    private function insertSpecificAirlineAndAllCounter($data_change_price){
        $airline = $this->getController('airline')->getByAbb($data_change_price['airline_iata']);
        $counters = $this->getController('counterType')->listCounterType();
        $condition = "flight_type='{$data_change_price['flight_type']}' AND locality='{$data_change_price['locality']}' AND airline_iata='{$data_change_price['airline_iata']}'";
        $delete_table_type = $this->getModel('flightPriceChangesModel')->delete($condition);

        if (is_bool($delete_table_type)) {
            $status_final_result = false;
            foreach ($counters as $eachCounter) {
                if ($data_change_price['flight_type'] == 'system' && $data_change_price['locality'] != 'local' && $airline['foreignAirline'] == 'inactive' && $data_change_price['price'] != '0') {
                    return functions::withError(array(), 200, 'افزایش قیمت بر روی پرواز های سیستمی که توسط ایرلاین های داخلی انجام میشود ، ممکن نیست');
                }
                unset($data_change_price['counter_type']);
                $data_change_price['counter_id'] = $eachCounter['id'];
                $result_insert_specific_airline_all_counter = $this->getModel('flightPriceChangesModel')->insertWithBind($data_change_price);
                if($result_insert_specific_airline_all_counter){
                    $status_final_result = true ;
                }
            }
        }
        if ($status_final_result) {
            $dataHistory = array(
                'price' => $data_change_price['price'],
                'change_type' => $data_change_price['change_type'],
                'flight_type' => $data_change_price['flight_type'],
                'airline_iata' => $data_change_price['airline_iata'],
                'counter_id' => '0',
                'locality' => $data_change_price['locality'],
                'creation_date' => date('Y-m-d H:i:s')
            );

            $this->getModel('flightPriceChangesHistoryModel')->insertLocal($dataHistory);
            return functions::withSuccess(array(), 200, 'ثبت اطلاعات با موفقیت انجام شد');
        }

        return functions::withError(array(), 200, 'خطا در ثبت یا تغییرا اطلاعات');
    }
    #endregion

    //region [insertOneSpecificChangePrice]
    private function insertOneSpecificChangePrice($data_change_price)
    {
        $airline = $this->getController('airline')->getByAbb($data_change_price['airline_iata']);
        $condition = "flight_type='{$data_change_price['flight_type']}' AND locality='{$data_change_price['locality']}' AND counter_id='{$data_change_price['counter_type']}' AND airline_iata='{$data_change_price['airline_iata']}'  ";
        $delete_table_type = $this->getModel('flightPriceChangesModel')->delete($condition);
        $status_final_result = false ;
        if (is_bool($delete_table_type)) {
            if ($data_change_price['flight_type'] == 'system' && $data_change_price['locality'] != 'local' && $airline['foreignAirline'] == 'inactive' && $data_change_price['price'] != '0') {
                return functions::withError(array(), 200, 'افزایش قیمت بر روی پرواز های سیستمی که توسط ایرلاین های داخلی انجام میشود ، ممکن نیست');
            }
            $data_change_price['counter_id'] = $data_change_price['counter_type'];
            unset($data_change_price['counter_type']);
            $status_final_result = $this->getModel('flightPriceChangesModel')->insertLocal($data_change_price);
        }

        if ($status_final_result) {
            $dataHistory = array(
                'price' => $data_change_price['price'],
                'change_type' => $data_change_price['change_type'],
                'flight_type' => $data_change_price['flight_type'],
                'airline_iata' => $data_change_price['airline_iata'],
                'counter_id' => $data_change_price['counter_id'],
                'locality' => $data_change_price['locality'],
                'creation_date' => date('Y-m-d H:i:s')
            );

            $this->getModel('flightPriceChangesHistoryModel')->insertLocal($dataHistory);
            return functions::withSuccess(array(), 200, 'ثبت اطلاعات با موفقیت انجام شد');
        }

        return functions::withError(array(), 200, 'خطا در ثبت یا تغییرا اطلاعات');
    }

    //endregion

    //region [setPriceChangesFlight]
    public function setPriceChangesFlight($data ,$data_info = null ,$agencyBenefitSystemFlight = null) {


        $flight_type = strtolower($data['FlightType']);
        $source_id = $data['sourceId'];
        $is_internal = $data['isInternal'];
        $airline_iata = strtoupper($data['airlineIata']);

        $locality = ($is_internal) ? 'local': 'international';
        $get_counter_type_id = (Session::IsLogin() ? Session::getCounterTypeId() : '5');
        $data_check_status_airline = array(
            'selected_config'=> $data_info['list_config_airline'][$flight_type][$airline_iata],
            'source_id'=> $source_id
        );


        $check_private = $this->getController('configFlight')
            ->checkStatusConfigAirline($data_check_status_airline) ;

        $calculate_price_change= [];
        if(!empty($data_info['price_change_list'])){
            $info_price_change = $data_info['price_change_list'][$airline_iata][$flight_type][$locality][$get_counter_type_id] ;


            $calculate_price_change = array(
                'change_type'=>$info_price_change['change_type'],
                'price'=>$info_price_change['price'],
            );

        }

        $type_ticket = $check_private; //this line later will deleting
        $type_service = functions::TypeService($flight_type, $data['typeZone'], $type_ticket, $check_private, $airline_iata);

        $arraySourceIncreasePriceFlightSystem = functions::sourceIncreasePriceFlightSystem();
        $discount['off_percent'] = 0;
        if(!empty($data_info['discount_list'])){
            $discount['off_percent'] = $data_info['discount_list'][$get_counter_type_id][$type_service]['off_percent'];
        }

        $add_on_price = 0;
        $it_commission = 0;
        $change_price = false ;

        $price['adult']['TotalPrice'] = $data['price']['adult']['TotalPrice'];
        $price['adult']['TotalPriceWithDiscount'] = 0;
        $price['adult']['BasePrice'] = $data['price']['adult']['BasePrice'];
        $price['adult']['TaxPrice'] = $data['price']['adult']['TaxPrice'];
        $price['child']['TotalPrice'] = $data['price']['child']['TotalPrice'];
        $price['child']['TotalPriceWithDiscount'] = 0;
        $price['child']['BasePrice'] = $data['price']['child']['BasePrice'];
        $price['child']['TaxPrice'] = $data['price']['child']['TaxPrice'];
        $price['infant']['TotalPrice'] = $data['price']['infant']['TotalPrice'];
        $price['infant']['TotalPriceWithDiscount'] = 0;
        $price['infant']['BasePrice'] = $data['price']['infant']['BasePrice'];
        $price['infant']['TaxPrice'] = $data['price']['infant']['TaxPrice'];
        $price['hasDiscount'] = 'No';



        foreach ($data['price'] as $key => $price_type) {


            $price[$key]['has_discount'] = 'No';
            $price[$key]['type_currency'] = $data_info['data_translate']['rial'];
            $price_type['TotalPrice'] = functions::ShowPriceTicket($flight_type, $price[$key]['TotalPrice'], $data['sourceId']);
            $price_type['BasePrice'] = functions:: ShowPriceTicket($flight_type, $price[$key]['BasePrice'], $data['sourceId']);


            /* روکشی فقط برای چارتری ها(داخلی و حارجی) وسیستمی  خارجی ها اعمال میشود به جز خارجی هایی که از چارتر724 خوانده میشوند یعنی سرور 7 با sourceId=8 و سرور 16 با sourceId=16 و سرور 12 با sourceId=12 و  سیستمی های داخلی پروایدر پرتو*/
            if (isset($calculate_price_change['price']) && $calculate_price_change['price'] > 0 && ($flight_type == 'charter' || ($data['typeZone'] == 'Portal' && $data['sourceId']!='8' && $data['sourceId']!='16' && $data['sourceId']!='12' ) || in_array($source_id,$arraySourceIncreasePriceFlightSystem)) && $price_type['TotalPrice'] > 0) {


                //فقط و فقط اشتراکی خارجی پرتو-این شزط فقط و فقط برای همین موضوع است
                if($check_private=='public' && $data['sourceId'] =='14' && $data['typeZone'] == 'Portal'){
                    $price_type['TotalPrice'] += ($price_type['TotalPrice'] * (IT_COMMISSION/100) );
                }

                if ($calculate_price_change['change_type'] == 'cost') {
                    $change_price = true;
                    $add_on_price = $calculate_price_change['price'];
                }
                elseif ($calculate_price_change['change_type'] == 'percent') {
                    $change_price = true ;
                    if(in_array($source_id,$arraySourceIncreasePriceFlightSystem) && $data['typeZone'] == 'Local' && $flight_type =='system'){
                        $add_on_price = (($price_type['BasePrice'] * $calculate_price_change['price']) / 100);

                    }else{
                        $add_on_price = (($price_type['TotalPrice'] * $calculate_price_change['price']) / 100);

                    }
                }

                $price[$key]['TotalPrice'] = $price_type['TotalPrice'];


                $price[$key]['TotalPrice'] += $add_on_price;


                if($data['typeZone'] == 'Local'){
                    $it_commission = $this->getController( 'irantechCommission' )->getFlightCommission( $type_service, $source_id );

                    $price[$key]['TotalPrice'] += $it_commission ;
                }
            }
            else {


                $price[$key]['TotalPrice'] = $price_type['TotalPrice'];

                // این تیکه کد مربوط به سیاست قدیمی قیمت گذاری پرواز ها میباشد ، کامنت شد به جاش سیستم جدید که به صورت داینامیک هست نوشته شده است 1404/07/08

                //فقط و فقط اشتراکی خارجی پرتو-این شزط فقط و فقط برای همین موضوع است
//                if($check_private=='public' && $data['sourceId'] =='14' && $data['typeZone'] == 'Portal'){
//
//                    $price[$key]['TotalPrice'] += ($price[$key]['TotalPrice'] * (IT_COMMISSION/100) );
//                }
//                سیستمی های داخلی فلایتو 3 درصد FARE افزایش دارند
//                if($flight_type == 'system' && $data['sourceId'] =='17' && $data['typeZone'] == 'Local'){
//                    $price[$key]['TotalPrice'] += (($price_type['BasePrice'] * 3) / 100);
//                }
            }



            if ($discount['off_percent'] > 0) {

                if($price_type['TotalPrice'] > 0)
                {

                    if ((!empty($calculate_price_change) && $flight_type == 'charter') || (($data['typeZone'] == 'Portal' && $change_price ) || in_array($source_id,$arraySourceIncreasePriceFlightSystem))) {
                        $price['hasDiscount'] = 'yes';


                        $price[$key]['TotalPriceWithDiscount'] = round($price[$key]['TotalPrice'] - (($add_on_price * $discount['off_percent']) / 100));
                    }else if(empty($calculate_price_change) && $flight_type == 'charter' && $discount['off_percent'] > 0 && (($data['typeZone'] == 'Portal' && $change_price ) || ($data['typeZone'] != 'Portal'))) {
                        $price[$key]['has_discount'] = 'no';
                    } else if ($check_private == 'public' && $flight_type == 'system') {
                        $price['hasDiscount'] = 'yes';
                        $price[$key]['TotalPriceWithDiscount'] = round($price[$key]['TotalPrice'] - ($agencyBenefitSystemFlight[$key] * ($discount['off_percent'] / 100)));
                    } else if ($check_private == 'private' && $flight_type == 'system') {
                        $price['hasDiscount'] = 'yes';
                        $price[$key]['TotalPriceWithDiscount'] = round($price[$key]['TotalPrice'] - ($agencyBenefitSystemFlight[$key] * ($discount['off_percent'] / 100)));
                    }
                }

            }
            $origin_price_total_after_change = $price[$key]['TotalPrice'];
            $origin_price_discount_total_after_change = $price[$key]['TotalPriceWithDiscount'];


            if (SOFTWARE_LANG != 'fa' ) {

                $price['hasDiscount'] = 'yes';

                $base_price_currency       = functions::CurrencyCalculate($price[$key]['BasePrice'],$data_info['info_currency']['CurrencyCode'],$data_info['info_currency']['EqAmount'],$data_info['info_currency']['CurrencyTitleEn']);
                $total_price_currency      = functions::CurrencyCalculate($price[$key]['TotalPrice'],$data_info['info_currency']['CurrencyCode'],$data_info['info_currency']['EqAmount'],$data_info['info_currency']['CurrencyTitleEn']);
                $total_price_with_discount = functions::CurrencyCalculate($price[$key]['TotalPriceWithDiscount'],$data_info['info_currency']['CurrencyCode'],$data_info['info_currency']['EqAmount'],$data_info['info_currency']['CurrencyTitleEn']);

                $price[$key]['BasePrice'] = $base_price_currency['AmountCurrency'];
                $price[$key]['TotalPrice'] = $total_price_currency['AmountCurrency'];
                $price[$key]['TotalPriceWithDiscount'] = $total_price_with_discount['AmountCurrency'];
                $price[$key]['type_currency'] = $total_price_currency['TypeCurrency'];
            }
            $price[$key]['price_with_out_currency'] = $origin_price_total_after_change;
            $price[$key]['price_discount_with_out_currency'] = $origin_price_discount_total_after_change;
            $price[$key]['markup_amount'] = $add_on_price;

        }

        return $price;

    }
    //endregion

    //region [flightPriceChangeList]
    public function flightPriceChangeList($type)
    {
        $list_price_change = $this->listPriceChangeByLocality($type);
        $list_finally = array();
        foreach ($list_price_change as $item) {
            $list_finally[$item['airline_iata']][$item['flight_type']][$item['locality']][$item['counter_id']] = $item;
        }

        return $list_finally ;
    }
    //endregion

    //region [listFlightPriceChangesAdmin]
    public function listFlightPriceChangesAdmin($params){
        $airlines = $this->getController('airline')->airLineList();
        $counters = $this->getController('counterType')->listCounterType();

        $final_airline = array();
        foreach ($airlines as $airline) {
            $final_airline[$airline['abbreviation']] = $airline ;
        }

        $final_counter= array();
        foreach ($counters as $counter) {
            $final_counter[$counter['id']] = $counter ;
        }

        $list_main_price_changes = $this->listPriceChanges();

        $array_list_price_changes = array();
        $final_list_price_changes = array();
        $result = array();
        $data = array();

        foreach ($list_main_price_changes as $key=>$list_price_change) {
            $array_list_price_changes['id'] = $key + 1;
            $array_list_price_changes['id_row'] = $list_price_change['id'];
            $array_list_price_changes['airline_name'] = $final_airline[$list_price_change['airline_iata']]['name_fa'];
            $array_list_price_changes['counter_type'] = $final_counter[$list_price_change['counter_id']]['name'];
            $array_list_price_changes['locality'] = ($list_price_change['locality']=='local') ? 'داخلی': 'خارجی';
            $array_list_price_changes['flight_type'] = ($list_price_change['flight_type']=='charter') ? 'چارتری': 'سیستمی';
            $array_list_price_changes['change_type'] = ($list_price_change['change_type']=='cost') ? 'ریالی': 'درصدی';
            $array_list_price_changes['price'] = ($list_price_change['change_type']=='cost') ? number_format($list_price_change['price']) : $list_price_change['price'];
            $array_list_price_changes['action'] = '';
            $final_list_price_changes[] = $array_list_price_changes ;
        }
        if (isset($params['search']['value']) && !empty($params['search']['value'])) {
            foreach ($final_list_price_changes as $key => $val) {
                $input = preg_quote($params['search']['value'], '~'); // don't forget to quote input string!
                $temporary_result = preg_grep('~' . $input . '~', $val);
                if(!empty($temporary_result)){
                    $result[] = $val ;
                }
            }

            $final_list_price_changes = $list_main_price_changes = $result;
        }


        if (isset($params['length']) && isset($params['start'])) {
            $final_list_price_changes = array_slice($final_list_price_changes, $params['start'], $params['length'], true);

        }
        foreach (array_values($final_list_price_changes) as $k => $val) {
            $data[] = $val;
        }

        $json = array(
            'recordsTotal' => count($list_main_price_changes),
            'recordsFiltered' => count($list_main_price_changes),
            'data' => $data,

        );
        return  json_encode($json,256);
    }
    //endregion

    //region [deleteSpecificPriceChange]
    public function deleteSpecificPriceChange($params){
        $condition = "id='{$params['id']}'";
        $model = $this->getModel('flightPriceChangesModel') ;
        $specific_price_change = $model->get()->where('id',$params['id'])->find();
        $delete_specific_price_change = $model->delete($condition);

        if(!empty($specific_price_change)){
            if(is_bool($delete_specific_price_change)){
                $dataHistory = array(
                    'price' => $specific_price_change['price'],
                    'change_type' => $specific_price_change['change_type'],
                    'flight_type' => $specific_price_change['flight_type'],
                    'airline_iata' => $specific_price_change['airline_iata'],
                    'counter_id' => $specific_price_change['counter_type'],
                    'locality' => $specific_price_change['locality'],
                    'creation_date' => date('Y-m-d H:i:s')
                );

                $this->getModel('flightPriceChangesHistoryModel')->insertLocal($dataHistory);
                return functions::withSuccess($delete_specific_price_change,200,'حذف با موفقیت انجام شد');
            }
            return functions::withError($delete_specific_price_change,404,'خطا در حذف');
        }

        return functions::withError($delete_specific_price_change,404,'خطا در حذف');

    }
    //endregion

    //region [historyChangePrice]
    /**
     * @param $params
     * @return false|string
     */

    public function historyChangePrice($params){
        $airlines = $this->getController('airline')->airLineList();
        $counters = $this->getController('counterType')->listCounterType();

        $final_airline = array();
        foreach ($airlines as $airline) {
            $final_airline[$airline['abbreviation']] = $airline ;
        }

        $final_counter= array();
        foreach ($counters as $counter) {
            $final_counter[$counter['id']] = $counter ;
        }

        $list_main_price_changes = $this->getAllHistoryChangePriceSpecificAirline($params['airline_iata']);

        $array_list_price_changes = array();
        $final_list_price_changes = array();
        $result = array();
        $data = array();

        foreach ($list_main_price_changes as $key=>$list_price_change) {
            $array_list_price_changes['id'] = $key + 1;
            $array_list_price_changes['counter_type'] = ($list_price_change['counter_id']=='0')? 'همه' : $final_counter[$list_price_change['counter_id']]['name'];
            $array_list_price_changes['flight_type'] = (($list_price_change['flight_type']=='charter') ? 'چارتری': 'سیستمی') .'-'.(($list_price_change['locality']=='local') ? 'داخلی': 'خارجی') ;
            $array_list_price_changes['change_type'] = ($list_price_change['change_type']=='cost') ? 'ریالی': 'درصدی';
            $array_list_price_changes['price'] = ($list_price_change['change_type']=='cost') ? number_format($list_price_change['price']) : $list_price_change['price'];
            $final_list_price_changes[] = $array_list_price_changes ;
        }


        if (isset($params['search']['value']) && !empty($params['search']['value'])) {
            foreach ($final_list_price_changes as $key => $val) {
                $input = preg_quote($params['search']['value'], '~'); // don't forget to quote input string!
                $temporary_result = preg_grep('~' . $input . '~', $val);
                if(!empty($temporary_result)){
                    $result[] = $val ;
                }
            }

            $final_list_price_changes = $list_main_price_changes = $result ;
        }


        if (isset($params['length']) && isset($params['start'])) {
            $final_list_price_changes = array_slice($final_list_price_changes, $params['start'], $params['length'], true);

        }
        foreach (array_values($final_list_price_changes) as $k => $val) {
            $data[] = $val;
        }

        $json = array(
            'recordsTotal' => count($list_main_price_changes),
            'recordsFiltered' => count($list_main_price_changes),
            'data' => $data,

        );
        return  json_encode($json,256);

    }
    //endregion

    public function resetChangePrice(){

        $data_update['price'] = '0';
        $condition = "id > 1";
        $result_reset = $this->getModel('flightPriceChangesModel')->update($data_update,$condition);
        if($result_reset){
            $dataHistory = array(
                'price' => '0',
                'change_type' => 'ALL',
                'flight_type' => 'ALL',
                'airline_iata' =>'ALL',
                'counter_id' =>'ALL',
                'locality' => 'All',
                'creation_date' => date('Y-m-d H:i:s')
            );

            $this->getModel('flightPriceChangesHistoryModel')->insertLocal($dataHistory);
            return functions::withSuccess('',200,'ریست تغییر قیمت با موفقیت انجام شد');
        }
        return functions::withError('',404,'خطا در ریست تغییر قیمت');
    }



}

?>
