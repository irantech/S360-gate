<?php


class hotelCities extends clientAuth
{
    protected $external_cities;
    protected $cities_model;

    public function __construct(){
        parent::__construct();
//        functions::displayErrorLog();
        // todo: this below line is temporary,this will change after update database
//        $this->cities_model = $this->getModel('allHotelCitiesModel');
        $this->external_cities = $this->getModel('externalHotelCityModel');
    }

    public function allCountries($params = array(),$json = false)
    {
        return $this->getController('country')->getAllCountries($params = array(),$json = false);

    }

    public function getAllHotelCities(){
        return $this->getModel('hotelCitiesModel')->get()->all();
    }

    public function allCities($params = [], $data_table = true)
    {
        $result = $this->external_cities->get();


        if (isset($params['search']['value'])) {
            $search_for = $params['search']['value'];
            $result = $result->like('city_name_fa', $search_for,'left')->like('city_name_en',$search_for)->like('country_name_en', $search_for)->like('country_name_fa', $search_for);
//            $result->orderBy('CASE WHEN ' . $this->cities_model->getTable() . ".name LIKE '%$search_for%'", 'THEN 1 ELSE 2 END');
        }
//        $result->toSqlDie();
        $total = count($result->all());
//        echo json_encode('test2');die();

        if (isset($params['order'])) {
            foreach ($params['order'] as $order) {
                $field_by_column = ['id', 'city_name_fa', 'city_name_en', 'country_name_en','country_name_fa', 'country_code'];
                $result = $result->orderBy($field_by_column[$order['column']], strtoupper($order['dir']));
            }
        }

        if (isset($params['length']) && isset($params['start']) && $params['length'] != '-1') {
            $result = $result->limit($params['start'], $params['length']);
        }

        $result = $result->all();
        $json = [
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $result
        ];
        if ($data_table) {
            return functions::toJson($json);
        }
        return functions::toJson($result);
    }

    public function updateCity($request = [])
    {
        $id = $request['city_id'];
        unset($request['city_id']);
        $fields = ['city_name_fa', 'city_name_en', 'country_name_en','country_name_fa','country_id'];
        $city = $this->external_cities->get($fields)->where('id', $id)->find();
        $update_data = [];
        foreach ($request as $key => $item) {
            if (array_key_exists($key, $city) && $item != $city[$key]) {
                $update_data[$key] = $item;
            }
        }

        $update = $this->external_cities->updateWithBind($update_data, ['id' => $id]);
        if ($update) {
            return functions::withSuccess(null, 200, 'بروزرسانی شهر با موفقیت انجام شد');
        }
        return functions::withError(null, 400, 'خطا در بروزرسانی شهر لطفا اطلاعات را بررسی کنید');
    }

    public function newCity($request = [])
    {
        $fields = ['city_name_fa', 'city_name_en', 'country_name_en','country_name_fa','country_id'];
        $country_model = $this->getModel('countryCodesModel');
        $country = $country_model->get()->where('id',$request['country_id'])->find();
        $request['country_name_en'] = $country['titleEn'];
        $request['country_name_fa'] = $country['titleFa'];
        $city = $this->external_cities->get()->where('city_name_en', $request['city_name_en'])->find();
        if (is_array($city) && isset($city['city_name_en'])) {
            return functions::withError(['City exist'], 400, 'شهری با این اسم از قبل وجود دارد');
        }

        $data_insert = [];
        foreach ($fields as $key => $field) {
//            if (array_key_exists($key, $city) && $field != $city[$key]) {
                $data_insert[$field] = trim($request[$field]);
//            }
        }
        $insert = $this->external_cities->insertWithBind($data_insert);
        if ($insert) {
            return functions::withSuccess(['insert correct'], 201, 'شهر جدید اضافه شد');
        }

        return functions::withError(['failed insert'], 500, 'خطا در اضافه کردن شهر جدید');
    }

    public function deleteCity($params = array()){
        $city = $this->external_cities->get()->where('id', $params['id'])->find();
        if (!$city) {
            return functions::withError(null, 404, 'شهری یافت نشد');
        }
        $delete = $this->external_cities->delete("id='{$params['id']}'");

        if ($delete) {
            return functions::withSuccess(null, 200, 'شهر با موفقیت حذف شد');
        }
        return functions::withError(null, 500, 'خطا در حذف شهر');
    }

    public function updateCountries()
    {
        $country_model = $this->getModel('countryCodesModel');
        $exists_countries = $country_model->get('code_two_letter')->all();
        $country_codes = [];

        foreach ($exists_countries as $c) {
            $country_codes[] = $c['code_two_letter'];
        }

        $countries = $this->external_cities->get(['country_code','country_name'])
            ->where('country_code',"".implode("', '",$country_codes)."","NOT IN")
            ->groupBy('country_code')
            ->orderBy('country_code','asc')
            ->toSqlDie();
        foreach ($countries as $country) {
            $country = $country_model->get()->where('code_two_letter',$country['country_code'])->find();
            if($country){
                continue;
            }

        }
    }

    public function updateCountryIds()
    {
        $country_model = $this->getModel('countryCodesModel');
        $all_countries = $country_model->get()->all();
        $countries = [];
        foreach ($all_countries as $country) {
            $countries['ids'][] = $country['id'];
            $countries['codes'][$country['id']] = $country['code_two_letter'];
            $countries['names'][$country['id']] = $country['titleEn'];
        }
        $cities = $this->external_cities->get()->where('updated_at',null,'IS')->where('country_id', null,'IS')->orWhere('country_id','');
        $remains = count($cities->all());
        $cities = $cities->limit(0,200)->all();
        $updates = [];
        foreach ($cities as $city) {
            if (in_array($city['country_name_en'], $countries['names']) || in_array($city['country_name_fa'], $countries['names']) || in_array($city['country_code'], $countries['codes'])) {
                $country_id = array_search($city['country_code'], $countries['codes']);
                $this->external_cities->updateWithBind(['country_id'=>$country_id],['id'=>$city['id']]);
                $city['country_id'] = $country_id;
            }else{
                $this->external_cities->updateWithBind(['updated_at'=>date('Y-m-d H:i:s',time())],['id'=>$city['id']]);
            }
            $updates[] = $city;
        }
        return functions::toJson([$remains,$updates]);
    }

    public function getDataHotelLocal($params) {
        $name      = trim( $params['input_value'] );
        $result    = [];
        $i         = 0;
        $hotel_cities = $this->getModel('hotelCitiesModel');
        if(!$name){
            $result['Cities'] = [];
            $result['ApiHotels'] = [];
            $result['ReservationHotels'] = [];

            return functions::clearJsonHiddenCharacters( json_encode( $result ) );

        }
        $cities = $hotel_cities->get(['id AS city_id','city_name','city_name_en'])
            ->like('city_name',"{$name}%","LEFT")
            ->like('city_name_en',"{$name}%","LEFT")
            ->like('city_iata',"{$name}%","LEFT")
            ->all();
        if ( count( $cities ) > 0 ) {
            $result['cities'] = [];
            foreach ( $cities as $city ) {
                $cityItem = [
                    'city_id'     => $city['city_id'],
                    'city_name'   => $city['city_name'],
                    'city_name_en' => $city['city_name_en'],
                    'page' => 'hotelCities',
                    'type_app' => 'city',
                ];

                $result['cities'][] = $cityItem;
            }
        }

        $reservation_hotel_name = $this->getModel('reservationHotelModel')->getTable();
        $reservation_city_name = $this->getModel('reservationCityModel')->getTable();
        $reservation_hotels = $this->getModel('reservationHotelModel')->
        get(['`id` AS hotel_id',
            $reservation_hotel_name.'.`name` AS hotel_name',
            $reservation_hotel_name.'.`name_en` AS hotel_name_en',
            $reservation_hotel_name.'.`city` AS city_id',
            $reservation_hotel_name.'.`priority` AS hotel_priority',
            $reservation_hotel_name.'.`name` AS hotel_name',
            $reservation_city_name.'.`name` AS city_name',
            "'roomHotelLocal' AS page",
            "'reservation' AS typeApp",
        ])->join($reservation_city_name, 'id', 'city', 'INNER')->
        where($reservation_hotel_name.'.is_del', 'no')->
        openParentheses()->
        like($reservation_hotel_name.'.`name`', $name)->
        like($reservation_hotel_name.'.`name_en`', $name)->
        closeParentheses()->
        all();

        if ( count( $reservation_hotels ) > 0 ) {
            foreach ( $reservation_hotels as $hotel ) {
                $i ++;
                //				$ReservationHotel = [];
                $hotel_name_en = trim( strtolower( $hotel['hotel_name_en'] ) );
                $hotel_name_en = str_replace( "  ", " ", $hotel_name_en );
                $hotel_name_en = str_replace( " ", "-", $hotel_name_en );

                $reservation_hotel = [
                    'hotel_id'      => trim( $hotel['hotel_id'] ),
                    'hotel_name'  => join(' ', [trim( $hotel['hotel_name'] ),trim( $hotel['city_name'] )]),
                    'hotel_name_en'  => $hotel_name_en,
                    'city_name'    => trim( $hotel['city_name'] ),
                    'city_id'      => $hotel['city_id'],
                    'page'=>'reservationHotel',
                    'type_app'=>'reservation',
                ];

                $result['hotels'][] = $reservation_hotel;
            }
        }
        $api_result    = $this->getLibrary('ApiHotelCore')->GetHotelsByName( $name );
        functions::insertLog(json_encode(['res'=>$api_result]),'Hotels/GetHotelsByName');

        if ( is_array( $api_result ) && count( $api_result ) > 0 ) {
            foreach ( $api_result as $hotel ) {
                $i ++;
                $hotel_name_en = strtolower( trim( urldecode( $hotel['NameEn'] ) ) );
                $hotel_name_en = str_replace( "  ", " ", $hotel_name_en );
                $hotel_name_en = str_replace( " ", "-", $hotel_name_en );
                $ApiHotel    = [
                    'hotel_id'       => $hotel['Id'],
                    'hotel_name' => $hotel['Name'],
                    'hotel_name_en'   => $hotel_name_en,
                    'city_name'     => $hotel['CityName'],
                    'city_id'       => $hotel['CityId'],
                    'page'=>'apiHotels',
                    'type_app'=>'api',
                ];

                $result['hotels'][] = $ApiHotel;

            }
        }

        return functions::toJson($result);

    }

    public function getDataHotelInternational( $params ) {
        $city = trim($params['input_value']);
        $city = functions::arabicToPersian($city);
        $city2 = $city;
        $pos = strpos($city, 'ا');
        if ($pos === 0) {
            $city2 = 'آ'. mb_substr($city,1);
        }

        $result_search = $this->getModel('externalHotelCityModel')
            ->get()
            ->where('country_name_en','iran','!=')
            ->openParentheses()
            ->like('country_name_en',$city)
            ->like('country_name_fa',$city2)
            ->like('city_name_fa',$city2)
            ->like('city_name_en',$city)
            ->like('country_code',$city)
            ->like('city_name_fa',$city)
            ->closeParentheses()
            ->groupBy('country_name_en,city_name_en')
            ->all();

        $result=[];

        foreach ($result_search as $key=>$item) {
            $result[$key]=$item;
            $result[$key]['country_name_en']=str_replace(["  ", " "],"-", strtolower(trim($item['country_name_en'])));
            $result[$key]['city_name_en']=str_replace(["  ", " "],"-", strtolower(trim($item['city_name_en'])));
        }


        return functions::toJson($result);

    }

    public function getResultForSearchBox($params) {

        if($params['type_search']=='internal'){
            return $this->getDataHotelLocal($params);
        }
        return $this->getDataHotelInternational($params);
    }

}