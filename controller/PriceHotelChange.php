<?php

/**
 * Class PriceHotelChange
 * @property PriceHotelChange $PriceHotelChange
 */

class PriceHotelChange extends clientAuth
{

    public $id = '';
    public $list;
    public $edit;

    public function __construct(){
        parent::__construct();
    }

    public function AllCity()
    {
        return $this->getController('hotelCities')->getAllHotelCities();
    }

    public function getAllCounterType(){
        $counters = $this->getController('counterType')->listCounterType();
        $final_list_counters = array();
        foreach ($counters as $counter) {
            $final_list_counters[$counter['id']] = $counter;
       }
        return $final_list_counters;
    }

    public function PriceChangeList($type_application , $type_id = null){
        $result =  $this->getModel('priceHotelChangeModel')->get()->where('type_application',$type_application);
        if(!empty($type_id)) {
            $result = $result->where('reservation_hotel_id'  , $type_id) ;
        }
        return $result->orderBy('is_del')->orderBy('last_edit')->all();
    }

    public function InsertChangePriceHotel($info){
        $all_counter = $this->getAllCounterType();

        $Model = Load::library('Model');
        $start_date = str_replace('-', '/', $info['start_date']);
        $end_date = str_replace('-', '/', $info['end_date']);

         $sql = " SELECT counter_id FROM  price_hotel_change_tb WHERE 
                ((`start_date` between '{$start_date}' AND '{$end_date}' ) OR  (`end_date` between '{$start_date}' AND '{$end_date}'))
                  AND is_del='no' AND city_code='{$info['city_code']}' AND hotel_star='{$info['hotel_star']}' AND  type_application='{$info['type_application']}' ";
         if($info['type_application'] == 'marketplaceHotel') {
             $sql .= "AND  reservation_hotel_id='{$info['type_id']}'";
         }
        $price_changes = $Model->select($sql, 'assoc');

        foreach ($price_changes as $val) {
            $arrayPriceChanges[] = $val['counter_id'];
        }

        $if_market = false  ;
        if($info['type_application'] == 'marketplaceHotel') {
            $if_market = $this->checkMarketplaceService($info) ;
            if(!$if_market) {
                return 'error : هتلی با این مشخصات در سیستم مارکت پلیس یافت نشد';
            }
        }
        if ($info['start_date'] <= $info['end_date']) {
            $res = [];
            $info['countCounter'] = ($info['all_type_counter']=='yes') ? count($all_counter) :  $info['countCounter'] ;
            $start_i = ($info['all_type_counter']=='yes') ? 1 : 0 ;
            for ($i = $start_i; $i <= $info['countCounter']; $i++) {
                $check_counter = ($info['all_type_counter']=='yes') ? (!empty($arrayPriceChanges) && in_array($all_counter[$i]['id'], $arrayPriceChanges)) : (!empty($arrayPriceChanges) && in_array($info['counter_id' . $i], $arrayPriceChanges)) ;
                $check_price = ($info['all_type_counter']=='yes') ? ($info['price'] > 0) : (isset($info['price' . $i]) && $info['price' . $i] > 0 ) ;

//                var_dump($arrayPriceChanges);
//                var_dump($all_counter[$i]['id']);
//                var_dump( in_array($all_counter[$i]['id'], $arrayPriceChanges));
//                die();
                if ( $check_price && !$check_counter ) {
                    $data['creation_date'] = dateTimeSetting::jdate('Y/m/d', '', '', '', 'en');
                    $data['city_code'] = $info['city_code'];
                    $data['hotel_star'] = $info['hotel_star'];
                    $data['start_date'] = str_replace('-', '/', $info['start_date']);
                    $data['end_date'] = str_replace('-', '/', $info['end_date']);
                    $data['change_type'] = $info['change_type'];
                    $data['type_application'] = $info['type_application'];
                    $data['reservation_hotel_id'] = $info['type_id'];
                    $data['is_del'] = 'no';

                    $data['price'] = $info['all_type_counter']=='yes' ? $info['price'] :  $info['price' . $i];
                    $data['price_type'] = $info['all_type_counter']=='yes' ? $info['price_type'] : $info['price_type' . $i] ;
                    $data['counter_id'] =  $info['all_type_counter']=='yes' ? $all_counter[$i]['id'] : $info['counter_id' . $i];

                    $Model->setTable('price_hotel_change_tb');
                    $res[] = $Model->insertLocal($data);

                }

                $data = [];
            }

            if ((empty($res)) || (!empty($res) && in_array('0', $res))) {
                return 'error : خطا در  تغییرات';
            } else {
                return 'success :  تغییرات با موفقیت انجام شد';
            }

        } else {
            return 'error : تاریخ شروع از تاریخ پایان نمیتواند بزرگتر باشد';
        }

    }

    public function CityName($city_id,$is_internal = true)
    {
        $ModelBase = Load::library('ModelBase');

        $sql = " SELECT * FROM  hotel_cities_tb WHERE city_code='{$city_id}'";
        if(!$is_internal){
            $sql = " SELECT id,CONCAT(city_name_en, ' - ', city_name_fa) AS city_name FROM  external_hotel_city_tb WHERE id='{$city_id}'";
        }
        $city = $ModelBase->select($sql);

        foreach ($city as $val) {
            $city_name = $val['city_name'];
        }
        return $city_name;
    }

    public function DeleteChangePriceHotel($id){
        $data['is_del'] = 'yes';
        $condition = "id='{$id}'";
        $res = $this->getModel('priceHotelChangeModel')->update($data, $condition);
        if ($res) {
            return 'success : حذف تغییرات با موفقیت انجام شد';
        }
        return 'error : خطا در حذف تغییرات';
    }

    public function getExternalCities()
    {
        $ModelBase = Load::library('ModelBase');

        $sql = " SELECT * FROM external_hotel_city_tb";
        $city = $ModelBase->select($sql);

        return $city;
    }

    public function searchExternalCity($params = [])
    {
        $response = [];
        $results = $this->getModel('externalHotelCityModel')->get()->like('city_name_en', $params['search'])->like('city_name_fa', $params['search'])->limit(0, 10)->all();
        $response[] = array(
            'id'=>'all',
            'text'=>'همه'
        );
        foreach ($results as $result) {
            $response[] = ['id' => $result['id'], 'text' => $result['city_name_fa'].' - '. $result['city_name_en']];
        }
        return functions::toJson($response);
    }


    //region [updatePriceChangeHotel]

    /**
     * @param $params
     * @return bool|mixed|string
     * @author alizade
     * @date 9/4/2022
     * @time 10:35 AM
     */
    public function updatePriceChangeHotel($params){

        $get_info_data_price_change = $this->getSpecificChangePriceHotel($params['id']);
        if ($get_info_data_price_change) {
            $data['is_del'] = 'yes';
            $condition = "id='{$params['id']}'";
            $result_soft_delete = $this->getModel('priceHotelChangeModel')->update($data, $condition);
            if ($result_soft_delete) {
                $data_insert_price_change_hotel = array(
                    'city_code' => $get_info_data_price_change['city_code'],
                    'hotel_star' => $get_info_data_price_change['hotel_star'],
                    'price' => $params['price'],
                    'price_type' => $params['price_type'],
                    'counter_id' => $get_info_data_price_change['counter_id'],
                    'change_type' => $get_info_data_price_change['change_type'],
                    'start_date' => $get_info_data_price_change['start_date'],
                    'end_date' => $get_info_data_price_change['end_date'],
                    'type_application' => $get_info_data_price_change['type_application'],
                    'reservation_hotel_id' => $get_info_data_price_change['reservation_hotel_id'],
                    'is_del' => 'no',
                    'creation_date' => dateTimeSetting::jdate('Y/m/d', time(), '', '', 'en'),
                );

                $result_insert_price_change_hotel = $this->getModel('priceHotelChangeModel')->insertLocal($data_insert_price_change_hotel);

                if ($result_insert_price_change_hotel) {
                    return functions::withSuccess('', 200, 'تغییرات با موفقیت انجام شد');
                }
                return functions::withError('', 404, 'خطا در ثبت اطلاعات');
            }
            return functions::withError('', 404, 'اطلاعات ارسالی نادرست است');
        }
        return functions::withError('', 404, 'اطلاعات ارسالی نادرست است');
    }
    //endregion

    //region [getSpecificChangePriceHotel]

    /**
     * @param $id
     * @return mixed
     * @author alizade
     * @date 9/4/2022
     * @time 10:34 AM
     */
    public function getSpecificChangePriceHotel($id){
        return $this->getModel('priceHotelChangeModel')->get()->where('id',$id)->find();
    }
    //endregion

    public function updateExternalHotelCitiesFromOldDb()
    {
        $sql = "SELECT * FROM `external_hotel_city_tb_bk` WHERE `city_name_fa` <> '' ORDER BY `city_name_fa` DESC";
        /** @var ModelBase $model */
            Load::autoload('ModelBase');
        $modelBase = new ModelBase();
        $old_cities = $modelBase->select($sql);
        foreach ($old_cities as $old_city) {
            functions::insertLog('external hotel old cities item '.json_encode($old_city,256|64),'tt/hotel_cities_update');
            $model = $this->getModel('externalHotelCityModel');
            $found_city = $model->get()->where('city_name_en',$old_city['city_name_en'])->find();
            $update = $model->update(['city_name_fa'=>$old_city['city_name_fa']],"id='{$found_city['id']}'");
            if($update){
                $found_city['city_name_fa'] = $old_city['city_name_fa'];
                functions::insertLog('updated city = '.$old_city['city_name_fa'] . ' - ' . json_encode($found_city,256|64),'tt/hotel_cities_update_success');
            }else{
                functions::insertLog('failed on update = '. json_encode($found_city,256|64),'tt/hotel_cities_update_failed');
            }
        }
        return functions::toJson(count($old_cities));
    }

    public function checkMarketplaceService($params) {

        if($params['type_application'] == 'marketplaceHotel'){
            $type_class = $this->getController('reservationHotel');
            $type = $type_class->getHotelById(['id' => $params['type_id']]) ;
            if($type['user_id']){
                return true ;
            }
        }
        return false;
    }

    public function setMarketplaceService($params , $change_id) {

        if(isset($params['type_application'])) {
            $type = '' ;
            switch ($params['type_application']) {
                case 'marketplaceHotel'  :
                    $type = 'hotel' ;
                    break;
            }
            $marketplace = $this->getModel('marketPlaceServiceModel') ;
            $if_exist = $marketplace->get()->where('service_id' , $params['type_id'])
                ->where('change_price_id' , $change_id['id'])->where('service_type' ,$type)->find();
            if(!$if_exist) {
                $data_insert = [
                    'service_id'        => $params['type_id'] ,
                    'service_type'      => "'".$type."'" ,
                    'change_price_id'   => $change_id['id'] ,
                ];
                return $marketplace->insert($data_insert) ;
            }

        }

    }
}
