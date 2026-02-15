<?php
/**
 * Class reservationBasicInformation
 * @property reservationBasicInformation $reservationBasicInformation
 */

//if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20'  ) {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}

class reservationBasicInformation extends clientAuth {

    public $id = '';
    public $list = '';
    public $listTypeOfVehicle;
    public $listVehicleModel;
    public $listCountry;
    public $listCity;
    public $listRegion;
    public $edit;
    public $listVehicleGrade;
    public $listRoom;
    public $listGallery;
    public $ListHotelRoom;
    public $listHotelRoomType;
    public $listFacilities;
    public $listRoomFacilities;
    public $listHotelFacilities;
    public $listBroker;
    private  $filtersListFly;
    public function __construct() {


    }


    /////////////////بررسی برای امکان حذف در دیتابیس/////////////////
    public function permissionToDelete($nameTable, $nameField, $valueField) {

        $Model = Load::library('Model');

        $sql = " SELECT id FROM {$nameTable} WHERE {$nameField}='{$valueField}' AND is_del = 'no' ";
        $result = $Model->select($sql);
        if (!empty($result)) {
            return 'yes';
        } else {
            return 'no';
        }


    }


    /////////////////حذف منطقی/////////////////
    public function logicalDeletion($info) {

        $Model = Load::library('Model');

        if ($info['tableName'] == 'visa_tb' || $info['tableName'] == 'visa_type_tb') {
            $data['isDell'] = 'yes';
        } else {
            $data['is_del'] = 'yes';
        }

        $condition = "id='{$info['id']}'";
        $Model->setTable($info['tableName']);
        $res = $Model->update($data, $condition);

        if ($res) {
            return 'success : حذف تغییرات با موفقیت انجام شد';
        } else {
            return 'error : خطا در حذف تغییرات';
        }
    }

    /////////////////حذف/////////////////
    /*public function deleteRecord($info) {

        $Model = Load::library('Model');

        $condition = "id='{$info['id']}'";
        $Model->setTable($info['tableName']);
        $res = $Model->delete($condition);

        return 'success : حذف تغییرات با موفقیت انجام شد';

    }*/


    //////دریافت اطلاعات کامل از یک جدول/////
    public function SelectAll($nameTable, $fieldCondition = NUll , $valueCondition = '' , $operator = '=') {

        $Model = Load::library('Model');
        if($operator != '=') {
            $sql = " SELECT * FROM {$nameTable} WHERE {$fieldCondition} {$operator} AND is_del='no' ORDER BY id ASC";

        }else if ($fieldCondition != '' && $valueCondition != '') {
            $sql = " SELECT * FROM {$nameTable} WHERE {$fieldCondition}='{$valueCondition}' AND is_del='no' ORDER BY id ASC";
        } else {
            $sql = "SELECT * FROM {$nameTable} WHERE is_del='no' ";
        }

        $result = $Model->select($sql);

        return $result;

    }

    //////دریافت اطلاعات کامل از یک جدول بدون تکرار/////
    public function SelectAllDistinct($nameTable, $fieldCondition = '', $valueCondition = '') {

        $Model = Load::library('Model');

        if ($fieldCondition != '' && $valueCondition != '') {
            $sql = " SELECT DISTINCT * FROM {$nameTable} WHERE {$fieldCondition}='{$valueCondition}' AND is_del='no' ORDER BY id ASC";
        } else {
            $sql = "SELECT DISTINCT * FROM {$nameTable} WHERE is_del='no' ";
        }

        $result = $Model->select($sql);

        return $result;

    }

    //////دریافت اطلاعات کامل از یک جدول براساس شرط/////
    public function SelectAllWithCondition($nameTable, $fieldCondition, $valueCondition) {

        $Model = Load::library('Model');
        if (isset($nameTable) && !empty($nameTable)) {
            $sql = " SELECT * FROM {$nameTable} WHERE {$fieldCondition}='{$valueCondition}' AND is_del='no' ";
            $res = $Model->load($sql);
            if (!empty($res)) {
                $this->list = $res;
            }
        } else {
            header("Location: " . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . "/404.tpl");
        }

    }


    /////////////////بررسی برای امکان حذف اتاق در دیتابیس/////////////////
    public function permissionToDelete_room($id_hotel, $id_room) {

        $Model = Load::library('Model');
        $dateNow = dateTimeSetting::jdate("Ymd", '', '', '', 'en');
        $sql = " SELECT id FROM reservation_hotel_room_prices_tb 
                  WHERE id_hotel='{$id_hotel}' AND id_room='{$id_room}' AND date>='{$dateNow}' AND flat_type='DBL' AND is_del='no' ";
        $result = $Model->select($sql);
        if (!empty($result)) {
            return 'yes';
        } else {
            return 'no';
        }


    }





    /////////////////نوع وسیله نقلیه/////////////////
    ////////////////////////////////////////////////
    public function InsertTypeOfVehicle($info) {

        $Model = Load::library('Model');

        $sql = " SELECT * FROM  reservation_type_of_vehicle_tb WHERE name='{$info['vehicle_name']}' AND is_del='no' ";
        $vehicle = $Model->load($sql);


        if (empty($vehicle)) {

            $data['name'] = $info['vehicle_name'];
            $data['type'] = $info['vehicle_type'];
            $data['is_del'] = 'no';

            $Model->setTable('reservation_type_of_vehicle_tb');
            $res = $Model->insertLocal($data);

            if ($res) {
                return 'success :  تغییرات با موفقیت انجام شد';
            } else {
                return 'error : خطا در  تغییرات';
            }

        } else {
            return 'error : نوع وسیله نقلیه تکراری می باشد.';
        }


    }

    public function updateTypeOfVehicle($val) {

        $Model = Load::library('Model');

        $d['name'] = $val['vehicle_name'];
        $d['type'] = $val['vehicle_type'];

        $Condition = "id='{$val['type_id']}' ";
        $Model->setTable("reservation_type_of_vehicle_tb");
        $res = $Model->update($d, $Condition);

        if ($res) {
            return 'success :  تغییرات با موفقیت انجام شد' . ':' . $val['type_id'];
        } else {
            return 'error : خطا در  تغییرات' . ':' . $val['type_id'];
        }

    }



    /////////////////مدل وسیله نقلیه/////////////////
    ////////////////////////////////////////////////
    public function InsertVehicleModel($info) {

        $Model = Load::library('Model');

        $sql = " SELECT * FROM  reservation_vehicle_model_tb WHERE name='{$info['vehicle_model']}' AND is_del='no' ";
        $vehicle = $Model->load($sql);

        if (empty($vehicle)) {

            $data['id_type_of_vehicle'] = $info['id_type_of_vehicle'];
            $data['name'] = $info['vehicle_model'];
            $data['abbreviation'] = $info['vehicle_abbreviation'];
            $data['is_del'] = 'no';

            $Model->setTable('reservation_vehicle_model_tb');
            $res = $Model->insertLocal($data);

            if ($res) {
                return 'success :  تغییرات با موفقیت انجام شد' . ':' . $info['id_type_of_vehicle'];
            } else {
                return 'error : خطا در  تغییرات' . ':' . $info['id_type_of_vehicle'];
            }

        } else {
            return 'error : مدل وسیله نقلیه تکراری می باشد.' . ':' . $info['id_type_of_vehicle'];
        }


    }

    public function updateVehicleModel($val) {

        $Model = Load::library('Model');

        $d['name'] = $val['vehicle_model'];
        $d['abbreviation'] = $val['vehicle_abbreviation'];

        $Condition = "id='{$val['type_id']}' ";
        $Model->setTable("reservation_vehicle_model_tb");
        $res = $Model->update($d, $Condition);

        if ($res) {
            return 'success :  تغییرات با موفقیت انجام شد' . ':' . $val['type_id'];
        } else {
            return 'error : خطا در  تغییرات' . ':' . $val['type_id'];
        }

    }



    /////////////////درجه وسیله نقلیه/////////////////
    ////////////////////////////////////////////////
    public function InsertVehicleGrade($info) {

        $Model = Load::library('Model');

        $sql = " SELECT * FROM  reservation_vehicle_grade_tb WHERE name='{$info['vehicle_grade']}' AND is_del='no' ";
        $vehicle = $Model->load($sql);

        if (empty($vehicle)) {

            $data['name'] = $info['vehicle_grade'];
            $data['abbreviation'] = $info['vehicle_grade_abbreviation'];
            $data['is_del'] = 'no';

            $Model->setTable('reservation_vehicle_grade_tb');
            $res = $Model->insertLocal($data);

            if ($res) {
                return 'success :  تغییرات با موفقیت انجام شد';
            } else {
                return 'error : خطا در  تغییرات';
            }

        } else {
            return 'error : درجه وسیله نقلیه تکراری می باشد.';
        }


    }

    public function updateVehicleGrade($val) {

        $Model = Load::library('Model');

        $d['name'] = $val['vehicle_grade'];
        $d['abbreviation'] = $val['vehicle_grade_abbreviation'];

        $Condition = "id='{$val['type_id']}' ";
        $Model->setTable("reservation_vehicle_grade_tb");
        $res = $Model->update($d, $Condition);

        if ($res) {
            return 'success :  تغییرات با موفقیت انجام شد' . ':' . $val['type_id'];
        } else {
            return 'error : خطا در  تغییرات' . ':' . $val['type_id'];
        }

    }


    public function getVehicleGrades() {
        try {
            $vehicleGradeTable = $this->getModel('reservationVehicleGradeModel')->getTable();

            $getters = [
                $vehicleGradeTable . '.id',
                $vehicleGradeTable . '.name',
                $vehicleGradeTable . '.abbreviation',
                $vehicleGradeTable . '.is_del'
            ];

            $result = $this->getModel('reservationVehicleGradeModel')
                ->get($getters, true)
                ->where($vehicleGradeTable . '.is_del', 'no')
                ->orderBy($vehicleGradeTable . '.name', 'ASC')
                ->all();

            return $result;

        } catch (Exception $e) {
            return [];
        }
    }



    /////////////////تعریف کشور / شهر/////////////////
    ////////////////////////////////////////////////
    public function InsertCountry($info) {

        $ModelBase = Load::library('ModelBase');

        $sqlBase = " SELECT * FROM  country_codes_tb WHERE code='{$info['country_code']}' AND validate='1'";
        $countryBase = $ModelBase->load($sqlBase);

        $Model = Load::library('Model');

        $sql = " SELECT * FROM  reservation_country_tb WHERE abbreviation='{$info['country_code']}' AND is_del='no'";
        $country = $Model->load($sql);
        if (empty($country)) {
            $config = Load::Config('application');
            $path = "country/".CLIENT_ID."/";
            $config->pathFile($path);
            $ext = explode(".", $_FILES['pic']['name']);
            $_FILES['pic']['name'] = date("sB")."-" . rand(10, 10000);
            $ext = strtolower($ext[count($ext)-1]);
            $_FILES['pic']['name'] = $_FILES['pic']['name'].".".$ext;
            if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
                $type = 'pic';
            } else{
                $type = 'file';
            }
            $result_upload = $config->UploadFile($type, "pic", "");
            $explode_name_pic = explode(':', $result_upload);
            if ($explode_name_pic[0] == 'done') {
                $result_upload = $explode_name_pic[1];
            }else{
                return functions::withError('', 200, $explode_name_pic[0]);
            }
            if ($type = 'pic'){
                functions::SaveImages('pic/country/'.CLIENT_ID ,'', $result_upload);
            }
            if (empty($result_upload)) {
                return functions::withError('', 200, 'ورود فیلد فایل اجباری می باشد');
            }
            $data['name'] = $countryBase['titleFa'];
            $data['name_en'] = $countryBase['titleEn'];
            $data['abbreviation'] = $countryBase['code'];
            $data['id_continent'] = $countryBase['continent_code'];
            $data['cost_arz'] = $info['cost_arz'];
            $data['type_arz'] = $info['type_arz'];
            $data['comments_visa'] = $info['comments_visa'];
            $data['is_del'] = 'no';
            $data['pic'] = $result_upload;
//            $data['expire_passport'] = $info['expire_passport'];

            $Model->setTable('reservation_country_tb');
            $res = $Model->insertLocal($data);
            $result  = $this->getModel('reservationCountryModel')->get(['id'])->orderBy('id' , 'DESC')->limit('0', '1')->find();
            $slugTourModel = $this->getController('tourSlugController');

            $check_slug = $this->getModel('slugModel')->get()->where('slug_fa', '-' . $countryBase['titleFa'])->find();

            if (!$check_slug) {
                $slugTourModel->store(['en' =>  $countryBase['titleEn'].'-', 'ar' => $countryBase['titleEn'].'-', 'fa' =>  $countryBase['titleFa'].'-'], ['city_id' => 'all', 'country_id' => $result['id']]);
            }

            if ($res) {
                return 'success :  تغییرات با موفقیت انجام شد' . ':' . $info['id_continent'];
            } else {
                return 'error : خطا در  تغییرات' . ':' . $info['id_continent'];
            }

        } else {
            return 'error : کشور تکراری میباشد.' . ':' . $info['id_continent'];
        }


    }

    public function GetGdsContinents() {

        return $this->getController('continentCodes')->getListContinents();
    }

    public function GetGdsCountriesByContinent($continentID) {


        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $queryVisa = "SELECT DISTINCT(countryCode) FROM visa_tb WHERE isActive = 'yes' AND isDell = 'no'";
        $resultVisa = $Model->select($queryVisa);

        $i = 0;
        foreach ($resultVisa as $visa) {
            $availibleVisa[$i] = $visa['countryCode'];
            $i++;
        }


        $query = "SELECT `code`, `titleFa`,`titleEn` FROM country_codes_tb WHERE continent_code = '{$continentID}' ORDER BY `titleFa`";
        $resultCountry = $ModelBase->select($query);


        foreach ($resultCountry as $country) {
            if (in_array($country['code'], $availibleVisa)) {
                $requestedCountries[$i]['code'] = $country['code'];
                $requestedCountries[$i]['title'] = $country['titleFa'];
                $requestedCountries[$i]['title_en'] = $country['titleEn'];

                $i++;
            }
        }


        return $requestedCountries;
    }

    function ReservationHotelCountry($type = null, $country = null) {
        $Model = Load::library('Model');
        if ($country != null) {
            $countryCondition = 'AND RC.id ' . $country;
        }


        $sql = "SELECT DISTINCT
                ( RC.id ),
                RC.name AS name_country,
                RC.id 
                FROM
                    reservation_country_tb AS RC
                    INNER JOIN reservation_hotel_tb AS RH ON RC.id = RH.country
                WHERE
                RH.is_del = 'no'
                  " . $countryCondition;

        $result = $Model->select($sql);

        return $result;
    }


    public function ReservationHotelCities($countryId = null, $Limit = '') {

        $Model = Load::library('Model');
        $dateNow = dateTimeSetting::jdate("Ymd", '', '', '', 'en');


        if ($countryId != null) {
            $countryCondition = 'AND H.country ' . $countryId;
        } else {
            $countryCondition = '';
        }
        if ($Limit != null) {
            $QueryLimit = " LIMIT " . $Limit . " ";
        } else {
            $QueryLimit = '';
        }

        $sql = "SELECT DISTINCT
	( RC.NAME ),
	RC.id AS City_id,
	RC.pic ,
	( SELECT
            MIN( HHR.online_price ) 
        FROM
            reservation_hotel_tb HH
            INNER JOIN reservation_hotel_room_prices_tb HHR ON HH.id = HHR.id_hotel 
        WHERE
            HHR.user_type = '5'
            AND HH.city = City_id 
            
            AND HHR.date = '{$dateNow}'
            AND HHR.flat_type = 'DBL' 
            AND HHR.is_del = 'no' 
            ) AS minPrice 
        FROM
            reservation_city_tb AS RC
            INNER JOIN reservation_hotel_tb AS H ON H.city = RC.id
            LEFT JOIN reservation_hotel_room_prices_tb AS RP ON RP.id_hotel = H.id 
        WHERE
            H.is_del = 'no' 
          
            {$countryCondition}
        GROUP BY
            H.id 
        ORDER BY
            H.priority=0,H.priority ASC,
            H.star_code DESC,
            H.NAME ASC,
            H.discount DESC
                 {$QueryLimit}
                ";


        $result = $Model->select($sql);

        return $result;

    }

    public function ReservationTourContinents($is_external = false, $isSpecial = false) {

        $continents = $this->getModel('continentCodesModel')->get(['titleFa', 'titleEn', 'id']);
        $continents = $continents->all();


        $Model = Load::library('Model');
        $dateNow = dateTimeSetting::jdate("Ymd", '', '', '', 'en');
        $sql = " SELECT 
              C.id, C.name,C.id_continent
          FROM
              reservation_country_tb AS C
              INNER JOIN reservation_tour_rout_tb AS TR ON C.id=TR.destination_country_id
              INNER JOIN reservation_tour_tb AS T ON T.id = TR.fk_tour_id
          ";
        if ($is_external == true) {
            $sql .= " WHERE C.id != '1' AND TR.is_del = 'no' AND T.start_date > '{$dateNow}' AND T.is_show = 'yes' AND TR.tour_title = 'dept'";
            if ($isSpecial) {
                $sql .= "AND T.is_special = 'yes' ";
            }
        }
        $sql .= "
      GROUP BY C.id 
          ORDER BY T.id DESC
          ";
        $countries = $Model->select($sql);


        $continents_array = array();
        foreach ($continents as $continent) {
            $country_array = [];
            foreach ($countries as $country) {
                if ($country['id_continent'] == $continent['id']) {
                    if (!in_array($country, $country_array))
                        $country_array[] = $country;
                }
            }
            if ($country_array) {
                $continent['countries'] = $country_array;
                $continents_array[] = $continent;
            }
        }

        return $continents_array;
    }

    public function ReservationTourCountriesForAll($is_external = false, $isSpecial = false , $type_id = null , $type_kind = 'like') {
        $Model = Load::library('Model');


        $dateNow = dateTimeSetting::jdate("Ymd", '', '', '', 'en');
        $sql = "SELECT 
              C.id, C.name, C.name_en , T.tour_pic , T.start_date, T.origin_country_id, T.origin_city_id , C.abbreviation, C.pic as pic
          FROM
              reservation_country_tb AS C
              INNER JOIN reservation_tour_rout_tb AS TR ON C.id=TR.destination_country_id
              INNER JOIN reservation_tour_tb AS T ON T.id = TR.fk_tour_id
          ";
        if ($is_external == true) {
            $sql .= " WHERE C.id != '1' AND TR.is_del = 'no' AND T.start_date > '{$dateNow}' AND T.is_show = 'yes' AND TR.tour_title = 'dept'";
            if ($isSpecial) {
                $sql .= "AND T.is_special = 'yes' ";
            }
        }else{
            $sql.="AND TR.is_del = 'no' AND T.start_date > '{$dateNow}' AND T.is_show = 'yes' AND TR.tour_title = 'dept'";
        }
        if( isset($type_id) && !empty($type_id)) {
            if(isset($type_kind) && !empty($type_kind) && $type_kind== 'notLike') {
                $type_kind = 'like' ;
            }
            $sql .=   "   AND T.tour_type_id {$type_kind} '%" . '"' . $type_id . '"' . "%' ";
        }
        $sql .= "
         AND (TR.is_route_fake = '1' OR TR.is_route_fake IS NULL)
      GROUP BY C.id
          ORDER BY T.id DESC
          ";


//        if(  $_SERVER['REMOTE_ADDR']=='93.118.161.174'  ) {
//
//            echo $sql;
//            die;
//        }

        $result = $Model->select($sql);
        foreach ($result as $key => $country) {

            $result[$key]['country_id'] = $country['id'];
            $result[$key]['city_list'] = $this->getCitiesOfCountryForAll($country['id'] , $isSpecial , $type_id , $type_kind);
        }

        return $result;
    }

    public function getCitiesOfCountryForAll($country_id , $isSpecial = false,  $type_id = null , $type_kind = 'like') {
        $Model = Load::library('Model');
        $dateNow = dateTimeSetting::jdate("Ymd", '', '', '', 'en');
        $spacial = '' ;
        if ($isSpecial) {
            $spacial = "AND T.is_special = 'yes' ";
        }
        $sqlCity = " SELECT
                      CT.id , CT.name , CT.name_en ,   T.start_date 
                  FROM
                      reservation_country_tb AS C
                      INNER JOIN reservation_tour_rout_tb AS TR ON C.id=TR.destination_country_id
                      INNER JOIN reservation_tour_tb AS T ON T.id = TR.fk_tour_id
                      INNER JOIN reservation_city_tb AS CT ON CT.id = TR.destination_city_id
                  WHERE
                      CT.id_country =  {$country_id}
                      AND T.is_del = 'no'
                      AND T.is_show = 'yes'
                      AND TR.tour_title = 'dept'
                      AND T.start_date > '{$dateNow}'
                      AND T.tour_type_id {$type_kind} '%" . '"' . $type_id . '"' . "%'
                      {$spacial}
                  GROUP BY CT.id
                  ORDER BY T.id DESC
                  ";

        return $Model->select($sqlCity);

    }

    public function ReservationTourCountries($is_external = false, $isSpecial = false , $type_id = null , $type_kind = 'like') {
        $Model = Load::library('Model');

        $software_lang = SOFTWARE_LANG;
        $dateNow = dateTimeSetting::jdate("Ymd", '', '', '', 'en');
        $sql = "SELECT
              C.id, C.name, C.name_en, C.abbreviation, C.sort_order, C.id_continent, TR.type_vehicle_id AS vehicle_ids ,
              COALESCE(CC.sort_order, 0) as continent_sort_order,
              T.tour_pic , T.start_date, T.origin_country_id, T.origin_city_id
          FROM
              reservation_country_tb AS C
              INNER JOIN reservation_tour_rout_tb AS TR ON C.id=TR.destination_country_id
              INNER JOIN reservation_tour_tb AS T ON T.id = TR.fk_tour_id
              LEFT JOIN reservation_continent_config_tb AS CC ON C.id_continent = CC.continent_id AND CC.is_del = 'no'
          ";







//if(  $_SERVER['REMOTE_ADDR']=='178.131.176.190'  ) {
//        echo $sql;
//        die;
//}

        if ($is_external == true) {
            $sql .= " WHERE C.id != '1' AND TR.is_del = 'no' AND T.start_date > '{$dateNow}' AND T.is_show = 'yes' AND TR.tour_title = 'dept'";
            if ($isSpecial) {
                $sql .= "AND T.is_special = 'yes' ";
            }
        }else{
            $sql.=" WHERE TR.is_del = 'no' AND T.start_date > '{$dateNow}' AND T.is_show = 'yes' AND TR.tour_title = 'dept'";
        }
        if( isset($type_id) && !empty($type_id)) {
            if(isset($type_kind) && !empty($type_kind) && $type_kind== 'notLike') {
                $type_kind = 'not like' ;
            }
            $sql .=   "   AND T.tour_type_id {$type_kind} '%" . '"' . $type_id . '"' . "%' ";
        }
        $sql .= "
         AND T.language = '{$software_lang}'
         AND (TR.is_route_fake = '1' OR TR.is_route_fake IS NULL)
         AND TR.id = (
             SELECT MAX(id)
             FROM reservation_tour_rout_tb
             WHERE fk_tour_id = T.id
             AND tour_title = 'dept'
             AND is_del = 'no'
             AND (is_route_fake = '1' OR is_route_fake IS NULL)
         )
      GROUP BY C.id
          ";


        $result = $Model->select($sql);


        usort($result, function($a, $b) {
            // اگر a اولویت نداشت ولی b داشت، b باید جلوتر باشه
            if ($a['sort_order'] == 0 && $b['sort_order'] > 0) {
                return 1;
            }
            // اگر b اولویت نداشت ولی a داشت، a باید جلوتر باشه
            if ($a['sort_order'] > 0 && $b['sort_order'] == 0) {
                return -1;
            }
            // هر دو اولویت 0 دارن => بر اساس id مرتب کن
            if ($a['sort_order'] == 0 && $b['sort_order'] == 0) {
                return $a['id'] - $b['id'];
            }
            // هر دو اولویت دارن => اولویت کمتر اول بیاد، اگه مساوی بودن => بر اساس id
            return $a['sort_order'] == $b['sort_order']
                ? $a['id'] - $b['id']
                : $a['sort_order'] - $b['sort_order'];
        });



        foreach ($result as $key => $country) {
            $result[$key]['country_id'] = $country['id'];
            $result[$key]['city_list'] = $this->getCitiesOfCountry($country['id'] , $isSpecial , $type_id , $type_kind);
        }
//echo json_encode($result);
//        die;
        return $result;
    }

    public function getCitiesOfCountry($country_id , $isSpecial = false,  $type_id = null , $type_kind = 'like') {
        $Model = Load::library('Model');
        $dateNow = dateTimeSetting::jdate("Ymd", '', '', '', 'en');
        $spacial = '' ;
        if ($isSpecial) {
            $spacial = "AND T.is_special = 'yes' ";
        }
        $sqlCity = " SELECT
                      CT.id , CT.name , CT.name_en ,  T.start_date , TR.type_vehicle_id AS vehicle_ids2
                  FROM
                      reservation_country_tb AS C
                      INNER JOIN reservation_tour_rout_tb AS TR ON C.id=TR.destination_country_id
                      INNER JOIN reservation_tour_tb AS T ON T.id = TR.fk_tour_id
                      INNER JOIN reservation_city_tb AS CT ON CT.id = TR.destination_city_id
                  WHERE
                      CT.id_country =  {$country_id}
                      AND T.is_del = 'no'
                      AND T.is_show = 'yes'
                      AND TR.tour_title = 'dept'
                      AND T.start_date > '{$dateNow}'
                  ";
//if(  $_SERVER['REMOTE_ADDR']=='5.201.144.255'  ) {
//        echo $sqlCity;
//        die;
//}

        if( isset($type_id) && !empty($type_id)) {
            if(isset($type_kind) && !empty($type_kind) && $type_kind== 'notLike') {
                $type_kind = 'not like' ;
            }
            $sqlCity .=   "
                      AND T.tour_type_id {$type_kind} '%" . '"' . $type_id . '"' . "%'
               ";
        }

        $sqlCity .=   "
                  {$spacial}
                  GROUP BY CT.id
                  ORDER BY T.id DESC
               ";

        return $Model->select($sqlCity);

    }

    public function ReservationTourCities($idCountry, $route, $isSpecial = false, $type_id = null , $kind_type_id = 'like') {

        $Model = Load::library('Model');

        $dateNow = dateTimeSetting::jdate("Ymd", '', '', '', 'en');
        if ($isSpecial == true) {
            $special = "AND T.is_special = 'yes' ";
        } else {
            $special = '';
        }
        $software_lang = SOFTWARE_LANG;
        $type = '' ;
        if( isset($type_id) && !empty($type_id)) {
            if(isset($kind_type_id) && !empty($kind_type_id) && $kind_type_id == 'notLike') {
                $kind_type_id = 'not like';
            }
            if(is_array($type_id)) {
                foreach ($type_id as $typeId) {

                    $type .=   "   AND T.tour_type_id {$kind_type_id}  '%" . '"' . $typeId . '"' . "%' ";

                }
            }else{
                $type .=   "   AND T.tour_type_id {$kind_type_id}  '%" . '"' . $type_id . '"' . "%' ";
            }

        }



        if ($route == 'dept') {

            $sql = " SELECT 
                      C.id, C.name, C.name_en,C.abbreviation,C.id_country , T.start_date
                  FROM
                      reservation_city_tb AS C 
                      INNER JOIN reservation_tour_tb AS T ON C.id=T.origin_city_id
                  WHERE
                      C.id_country {$idCountry} 
                      AND T.is_del = 'no' 
                      AND T.is_show = 'yes' 
                      AND T.start_date > '{$dateNow}' AND T.start_date < '20000101' 
                      {$type}
                      {$special}
                  GROUP BY C.id
                  ORDER BY T.id DESC
                  ";

        } elseif ($route == 'return') {

            $sql = " SELECT 
                      C.id, C.name, C.name_en, C.id_country ,T.tour_pic  , T.start_date
                  FROM
                      reservation_city_tb AS C
                      INNER JOIN reservation_tour_rout_tb AS TR ON C.id=TR.destination_city_id
                      INNER JOIN reservation_tour_tb AS T ON T.id = TR.fk_tour_id
                  WHERE
                      C.id_country {$idCountry}
                      AND T.is_del = 'no' 
                      AND T.is_show = 'yes' 
                      AND T.language = '{$software_lang}' 
                      AND T.start_date > '{$dateNow}' AND T.start_date < '20000101' 
                      {$type}
                      AND TR.tour_title = 'dept'
                      {$special}
                  GROUP BY C.id
                  ORDER BY TR.id DESC
                  ";
        }

        return $Model->select($sql);


    }

    public function GetGdsCityForTour($idCountry, $route, $isSpecial = false, $isOneDay = false) {
        $Model = Load::library('Model');
        $data_total = array();
        $dateNow = date("Ymd");
        if ($idCountry != '') {
            $idCountry = 'AND C.id_country ' . $idCountry;
        }
        if ($isSpecial == true) {
            $special = "AND T.is_special = 'yes' ";
        } else {
            $special = '';
        }

        if ($route == 'dept') {

            $sql = " SELECT 
                      C.id, C.name,C.name_en,C.abbreviation,T.tour_type_id
                  FROM
                      reservation_city_tb AS C 
                      INNER JOIN reservation_tour_tb AS T ON C.id=T.origin_city_id
                  WHERE
                      T.is_del = 'no' 
                      {$idCountry} 
                      AND T.is_show = 'yes' 
                      AND T.start_date > '{$dateNow}' 
                      {$special}
                  GROUP BY C.id
                  ORDER BY T.id DESC
                  ";

        } elseif ($route == 'return') {
            $sql = " SELECT 
                      C.id, C.name,C.name_en,T.tour_type_id
                  FROM
                      reservation_city_tb AS C
                      INNER JOIN reservation_tour_rout_tb AS TR ON C.id=TR.destination_city_id
                      INNER JOIN reservation_tour_tb AS T ON T.id = TR.fk_tour_id
                  WHERE
                      T.is_del = 'no' 
                      {$idCountry}
                      AND T.is_show = 'yes' 
                      AND T.language = 'en' 
                      AND T.start_date > '{$dateNow}'
                      AND TR.tour_title = 'dept'
                      AND T.tour_type_id LIKE '%" . '"' . '1' . '"' . "%'
                      {$special}
                  GROUP BY C.id
                  ORDER BY TR.id DESC
                  ";
        }
        $result = $Model->select($sql);


        foreach ($result as $data_query) {

            $arrayTourType = json_decode($data_query['tour_type_id']);
            if (in_array('1', $arrayTourType)) {
                if ($isOneDay) {
                    $data_total[] = $data_query;
                }
            } else {
                if (!$isOneDay) {
                    $data_total[] = $data_query;
                }
            }
        }

        return $data_total;
    }

    public function GetToursReservationByType($type = null, $limit = null, $country = '') {
        $Model = Load::library('Model');

        $conditionType = "";
        $conditionSpecial = "";
        $conditionCountry = "";
        $leftJoinCountry = "";
        if (!empty($type) && is_numeric($type)) {
            $conditionType = " AND tourType.fk_tour_type_id = '{$type}' ";
        } elseif (!empty($type) && $type == 'discount') {
            $conditionType = " AND tour.discount > 0 ";
        } elseif (!empty($type) && $type == 'special') {
            $conditionSpecial = " AND tour.is_special = 'yes' ";
        }
        if (!empty($country)) {
            $conditionCountry = "AND tourRout.destination_country_id" . $country . " ";
            $leftJoinCountry = "INNER JOIN reservation_tour_rout_tb AS tourRout ON tourRout.fk_tour_id = tour.id";

        }
        $software_lang = SOFTWARE_LANG;
        $date = date("Ymd", time());

        $sql = "SELECT tour.id,tour.id_same,tour.tour_name_en,tour.night,tour.start_date,tour.tour_pic,tour.tour_type_id,tour.tour_type,tour.is_special
          FROM reservation_tour_tb AS tour";

        $sql .= ($leftJoinCountry != "") ? $leftJoinCountry : '';

        $sql .= " WHERE tour.is_del = 'no' AND tour.is_show = 'yes' AND tour.language = '{$software_lang}'  AND tour.start_date > '{$date}'
             {$conditionType} 
             {$conditionSpecial} 
             {$conditionCountry} 
           GROUP BY tour.tour_type  ORDER BY tour.priority=0,tour.priority {$limit} ";

        $result = $Model->select($sql);

        $tour = array();

        foreach ($result as $data) {


            if ($data['tour_pic'] != '') {
                $data['tour_pic'] = 'https://online.' . 'gds/pic/reservationTour/' . $data['tour_pic'];
            } else {
                $data['tour_pic'] = 'images/nophoto.png';
            }

            $arrayTourType = json_decode($data['tour_type_id']);
            if (in_array('1', $arrayTourType)) {
                $oneDayTour = 'yes';
            } else {
                $oneDayTour = 'no';
            }
            $data['tour_name_en'] = str_replace(' ', '-', $data['tour_name_en']);
            $data['start_date'] = substr($data['start_date'], 6, 2) . '-' . substr($data['start_date'], 4, 2) . '-' . substr($data['start_date'], 0, 4);
            $data['tour_type'] = str_replace('-تور چند روزه', '', $data['tour_type']);
            $data['tour_type_en'] = str_replace('-تور چند روزه', '', $data['tour_type_en']);
            $tour_type_id = json_decode($data['tour_type_id']);
            foreach ($tour_type_id as $item) {
                $getTourType = $this->getTourType(['id' => $item]);
            }
            if (($key = array_search(['1', '2'], $tour_type_id)) !== false) {
                unset($tour_type_id[$key]);
            }
            $data['tour_type_id'] = $tour_type_id[0];
            $data['getTourType'] = $getTourType;


            $tour[] = $data;
        }


        return $tour;
    }

    public function getTourType($info) {

        $Model = Load::library('Model');

        $sql = " SELECT * FROM  reservation_tour_type_tb WHERE id='{$info['id']}' AND is_del='no' ";
        $tour = $Model->load($sql);

        if (!empty($tour)) {

            return $tour;

        }

        return false;


    }

    public function updateCountry($info) {

        $Model = Load::library('Model');
        functions::insertLog('data: ' . json_encode($info) , '000shojaee');
        if (isset($_FILES['pic']['name'])) {
            $check_exist = $this->getModel('reservationCountryModel')->get()->where('id', $info['type_id'])->find();
            functions::insertLog('$check_exist: ' . json_encode($check_exist) , '000shojaee');

            if ($check_exist) {
                functions::DeleteImages('country/'.CLIENT_ID.'/' ,$check_exist['pic']);
            }


            /** @var application $config */
            $config = Load::Config('application');
            $path = "country/".CLIENT_ID."/";
            $config->pathFile($path);
            $ext = explode(".", $_FILES['pic']['name']);
            $_FILES['pic']['name'] = date("sB")."-" . rand(10, 10000);
            $ext = strtolower($ext[count($ext)-1]);
            $_FILES['pic']['name'] = $_FILES['pic']['name'].".".$ext;
            if (in_array ( $ext, array ( 'jpg', 'jpe', 'jpeg', 'png', 'gif' ) ) ) {
                $type = 'pic';
            } else{
                $type = 'file';
            }
            $result_upload = $config->UploadFile($type, "pic", "");
            $explode_name_pic = explode(':', $result_upload);

            if ($explode_name_pic[0] == 'done') {
                $result_upload = $explode_name_pic[1];
            }else{
                return functions::withError('', 200, $explode_name_pic[0]);
            }
            $dataUpdate = [
                'pic' => $result_upload,
            ];
            if ($type = 'pic'){
                functions::SaveImages('pic/country/'.CLIENT_ID ,'', $result_upload);
            }
            if (empty($dataUpdate)) {
                return functions::withError('', 200, 'ورود فیلد تصویر اجباری می باشد');
            }
        }

        $data['name'] = $info['country_name'];
        $data['name_en'] = $info['country_name_en'];
        $data['name_ar'] = $info['country_name_ar'];
        $data['abbreviation'] = $info['country_abbreviation'];
        $data['id_continent'] = $info['id_continent'];
        $data['cost_arz'] = $info['cost_arz'];
        $data['type_arz'] = $info['type_arz'];
        $data['comments_visa'] = $info['comments_visa'];
        $data['pic'] = $result_upload;

//        $data['expire_passport'] = $info['expire_passport'];

        $Condition = "id='{$info['type_id']}' ";
        $Model->setTable("reservation_country_tb");
        $res = $Model->update($data, $Condition);

        if ($res) {
            return 'success :  تغییرات با موفقیت انجام شد' . ':' . $info['type_id'];
        } else {
            return 'error : خطا در  تغییرات' . ':' . $info['type_id'];
        }

    }

    public function InsertCity($info) {

        $Model = Load::library('Model');

        $sql = " SELECT * FROM  reservation_city_tb WHERE name='{$info['city_name']}' AND id_country='{$info['id_country']}' AND is_del='no'";
        $city = $Model->load($sql);

        if (empty($city)) {

            #region [آپلود فایل هتل]
            if (isset($_FILES['pic']) && $_FILES['pic'] != "") {

                $config = Load::Config('application');
                $success = $config->UploadFile("pic", "pic", "");
                $explod_name_pic = explode(':', $success);

                if ($explod_name_pic[0] == "done") {

                    $data['pic'] = $explod_name_pic[1];

                } else {
                    $data['pic'] = '';
                }

            } else {

                $data['pic'] = '';
            }
            #endregion



            $data['name'] = $info['city_name'];
            $data['name_en'] = $info['city_name_en'];
            $data['name_ar'] = $info['city_name_ar'];
            $data['abbreviation'] = $info['city_abbreviation'];
            $data['id_country'] = $info['id_country'];
            $data['is_del'] = 'no';

            $Model->setTable('reservation_city_tb');
            $res = $Model->insertLocal($data);

            $result  = $this->getModel('reservationCityModel')->get(['id'])->orderBy('id' , 'DESC')->limit('0', '1')->find();


            $slugTourModel = $this->getController('tourSlugController');
            $slugTourModel->store(['en' =>  $info['city_name_en'].'-', 'ar' => $info['city_name_ar'].'-', 'fa' => $info['city_name'].'-'], ['city_id' => $result['id'], 'country_id' => $info['id_country']]);

            if ($res) {
                return 'success :  تغییرات با موفقیت انجام شد' . ':' . $info['id_country'];
            } else {
                return 'error : خطا در  تغییرات' . ':' . $info['id_country'];
            }


        } else {
            return 'error : شهر تکراری میباشد.' . ':' . $info['id_country'];
        }


    }

    public function updateCity_old($info) {

        $Model = Load::library('Model');

        #region [آپلود فایل هتل]
        if (isset($_FILES['pic']) && $_FILES['pic'] != "") {

            $config = Load::Config('application');
            $success = $config->UploadFile("pic", "pic", "");
            $explod_name_pic = explode(':', $success);

            if ($explod_name_pic[0] == "done") {
                $data['pic'] = $explod_name_pic[1];
            }

        }
        #endregion

        $data['name'] = $info['city_name'];
        $data['name_en'] = $info['city_name_en'];
        $data['name_ar'] = $info['city_name_ar'];
        $data['abbreviation'] = $info['city_abbreviation'];
        $data['id_country'] = $info['id_country'];

        $Condition = "id='{$info['type_id']}' ";
        $Model->setTable("reservation_city_tb");
        $res = $Model->update($data, $Condition);

        if ($res) {
            return 'success :  تغییرات با موفقیت انجام شد' . ':' . $info['type_id'];
        } else {
            return 'error : خطا در  تغییرات' . ':' . $info['type_id'];
        }


    }


    public function updateCity($info) {

        $Model = Load::library('Model');

        #region [آپلود فایل هتل]
        if (isset($_FILES['pic']) && $_FILES['pic'] != "") {

            $config = Load::Config('application');
            $success = $config->UploadFile("pic", "pic", "");
            $explod_name_pic = explode(':', $success);

            if ($explod_name_pic[0] == "done") {
                $data['pic'] = $explod_name_pic[1];
            }
        }
        #endregion

        // اگر id کمتر از 300 باشد فقط تصویر قابل تغییر است
        if ($info['type_id'] < 300) {

            // اگر هیچ تصویر جدیدی آپلود نشده باشد
            if (!isset($data['pic'])) {
                return 'error : شما فقط مجاز به ویرایش تصویر هستید' . ':' . $info['type_id'];
            }

            // فقط تصویر آپدیت شود
            $Condition = "id='{$info['type_id']}' ";
            $Model->setTable("reservation_city_tb");
            $res = $Model->update($data, $Condition);

            if ($res) {
                return 'success : تصویر با موفقیت ویرایش شد' . ':' . $info['type_id'];
            } else {
                return 'error : خطا در ویرایش تصویر' . ':' . $info['type_id'];
            }
        }

        // برای idهای 300 و بالاتر، همه فیلدها قابل تغییر هستند
        //به دلیل اینکه در هتل ها به مشکل نخوریم این مورد را انجام دادیم
        $data['name'] = $info['city_name'];
        $data['name_en'] = $info['city_name_en'];
        $data['name_ar'] = $info['city_name_ar'];
        $data['abbreviation'] = $info['city_abbreviation'];
        $data['id_country'] = $info['id_country'];

        $Condition = "id='{$info['type_id']}' ";
        $Model->setTable("reservation_city_tb");
        $res = $Model->update($data, $Condition);

        if ($res) {
            return 'success : تغییرات با موفقیت انجام شد' . ':' . $info['type_id'];
        } else {
            return 'error : خطا در تغییرات' . ':' . $info['type_id'];
        }
    }


    public function InsertRegion($info) {

        $Model = Load::library('Model');

        $sql = " SELECT * FROM  reservation_region_tb WHERE name='{$info['region_name']}' AND id_city='{$info['id_city']}' AND is_del='no' ";
        $region = $Model->load($sql);

        if (empty($region)) {

            $data['name'] = $info['region_name'];
            $data['abbreviation'] = $info['region_abbreviation'];
            $data['id_city'] = $info['id_city'];
            $data['is_del'] = 'no';

            $Model->setTable('reservation_region_tb');
            $res = $Model->insertLocal($data);

            if ($res) {
                return 'success :  تغییرات با موفقیت انجام شد' . ':' . $info['id_city'];
            } else {
                return 'error : خطا در  تغییرات' . ':' . $info['id_city'];
            }

        } else {
            return 'error : منطقه تکراری میباشد.' . ':' . $info['id_city'];
        }


    }


    ///////////////////عنوان و کیفیت و منظره اتاق/////////////////////
    /////////////////////////////////////////////////////////////////

    public function updateRegion($info) {

        $Model = Load::library('Model');

        $data['name'] = $info['region_name'];
        $data['abbreviation'] = $info['region_abbreviation'];
        $data['id_city'] = $info['id_city'];

        $Condition = "id='{$info['type_id']}' ";
        $Model->setTable("reservation_region_tb");
        $res = $Model->update($data, $Condition);

        if ($res) {
            return 'success :  تغییرات با موفقیت انجام شد' . ':' . $info['type_id'];
        } else {
            return 'error : خطا در  تغییرات' . ':' . $info['type_id'];
        }

    }

    public function InsertRoomType($info) {

        $Model = Load::library('Model');

        $sql = " SELECT * FROM  {$info['table_name']} WHERE comment='{$info['comment']}' AND is_del='no' ";
        $room = $Model->load($sql);

        switch ($info['table_name']) {
            case 'reservation_room_quality_tb':
                $pages = 'roomQuality';
                break;
            case 'reservation_room_view_tb':
                $pages = 'roomView';
                break;
            case 'reservation_room_title_tb':
                $pages = 'roomTitle';
                break;

        }

        if (empty($room)) {

            $data['comment'] = $info['comment'];
            $data['is_del'] = 'no';

            $Model->setTable($info['table_name']);
            $res = $Model->insertLocal($data);

            if ($res) {
                return 'success :  تغییرات با موفقیت انجام شد' . ':' . $pages;
            } else {
                return 'error : خطا در  تغییرات' . ':' . $pages;
            }

        } else {
            return 'error : عنوان اتاق تکراری می باشد.' . ':' . $pages;
        }


    }





    ///////////////////////اضافه کردن هتل////////////////////////////
    /////////////////////////////////////////////////////////////////

    public function updateRoomType($val) {

        $Model = Load::library('Model');

        switch ($val['table_name']) {
            case 'reservation_room_quality_tb':
                $pages = 'roomQuality';
                break;
            case 'reservation_room_view_tb':
                $pages = 'roomView';
                break;
            case 'reservation_room_title_tb':
                $pages = 'roomTitle';
                break;

        }

        $d['comment'] = $val['comment'];

        $Condition = "id='{$val['type_id']}' ";
        $Model->setTable($val['table_name']);
        $res = $Model->update($d, $Condition);

        if ($res) {
            return 'success :  تغییرات با موفقیت انجام شد' . ':' . $pages;
        } else {
            return 'error : خطا در  تغییرات' . ':' . $pages;
        }

    }

    public function InsertHotel($info) {


        $Model = Load::library('Model');

        $sql = " SELECT * FROM  reservation_hotel_tb WHERE name='{$info['name']}' AND name_en='{$info['name_en']}'
                  AND country='{$info['origin_country']}' AND city='{$info['origin_city']}' AND is_del='no' ";
        $hotel = $Model->load($sql);

        if (empty($hotel)) {

            if (isset($info['is_request']) && $info['is_request'] == 'true') {
                $isRequest = 1;
            } else {
                $isRequest = 0;
            }

            // اگر عکس انتخاب شده بود //
            if (isset($_FILES['pic']) && $_FILES['pic'] != "") {

                $config = Load::Config('application');
                $success = $config->UploadFile("pic", "pic", "");
                $explod_name_pic = explode(':', $success);

                if ($explod_name_pic[0] == "done") {

                    $data['logo'] = $explod_name_pic[1];
                }

            }

            $data['name'] = $info['name'];

            if(isset($info['user_id'])) {
                $data['is_show'] = 'no';
                $data['is_accept'] = 'no';
                $data['user_id'] = $info['user_id'];
            }

            $description = [
                'name' => 'description',
                'content' => filter_var($info['description'], FILTER_SANITIZE_STRING)
            ];


            $data['name_en'] = $info['name_en'];
            $data['discount'] = $info['discount'];
            $data['star_code'] = $info['star_code'];
            $data['type_code'] = $info['type_code'];
            $data['number_of_rooms'] = $info['number_of_rooms'];
            $data['site'] = $info['site'];
            $data['country'] = $info['origin_country'];
            $data['city'] = $info['origin_city'];
            $data['region'] = $info['origin_region'];
            $data['address'] = $info['address'];
            $data['address_en'] = $info['address_en'];
            $data['tel_number'] = $info['tel_number'];
            $data['trip_advisor'] = $info['trip_advisor'];
            $data['email_manager'] = $info['email_manager'];
            $data['entry_hour'] = $info['entry_hour'];
            $data['leave_hour'] = $info['leave_hour'];
            $data['latitude'] = $info['latitude'];
            $data['longitude'] = $info['longitude'];
            $data['comment'] = $info['comment'];
            $data['title'] = $info['title'];
            $data['heading'] = $info['heading'];
            $data['description'] = $info['description'];
            $data['comment_en'] = $info['comment_en'];
            $data['distance_to_important_places'] = $info['distance_to_important_places'];
            $data['distance_to_important_places_en'] = $info['distance_to_important_places_en'];
            $data['rules'] = $info['rules'];
            $data['rules_en'] = $info['rules_en'];
            $data['cancellation_conditions'] = $info['cancellation_conditions'];
            $data['cancellation_conditions_en'] = $info['cancellation_conditions_en'];
            $data['child_conditions'] = $info['child_conditions'];
            $data['child_conditions_en'] = $info['child_conditions_en'];
            $data['user_name'] = '';
            $data['pass'] = '';
            $data['is_del'] = 'no';
            $data['is_request'] = $isRequest;
            $data['iframe_code'] = $info['iframe_code'];
            $data['prepayment_percentage'] = $info['prepaymentPercentage'];
            $data['sepehr_hotel_code'] = $info['sepehr_hotel_code'];

//var_dump($data['prepayment_percentage']);
//var_dump('9898');
//die;
            if (isset($info['chk_flag_special']) && $info['chk_flag_special'] = 1) {
                $data['flag_special'] = 'yes';
            } else {
                $data['flag_special'] = 'no';
            }

            if(isset($info['user_id'])) {
                $data['flag_special'] = 'yes';
            }

            if (isset($info['chk_flag_discount']) && $info['chk_flag_discount'] = 1) {
                $data['flag_discount'] = 'yes';
            } else {
                $data['flag_discount'] = 'no';
            }

            if (isset($info['transfer_went']) && $info['transfer_went'] != '') {
                $data['transfer_went'] = 'yes';
            } else {
                $data['transfer_went'] = 'no';
            }

            if (isset($info['transfer_back']) && $info['transfer_back'] != '') {
                $data['transfer_back'] = 'yes';
            } else {
                $data['transfer_back'] = 'no';
            }

            $Model->setTable("reservation_hotel_tb");
            $res = $Model->insertLocal($data);
            $idHotel = $Model->getLastId();

            $lastId = $Model->getLastId();

            if ($res) {

                /* $resultInsertRoom = $this->insertFirstHotelRoom($idHotel);
                 if ($resultInsertRoom) {*/

                // کارگزار هتل
                if (isset($info['count_package']) && $info['count_package'] > 0) {
                    for ($i = 1; $i <= $info['count_package']; $i++) {

                        if ($info['chk_broker' . $i] == '1') {
                            $d['choose'] = 'yes';
                        } else {
                            $d['choose'] = 'no';
                        }

                        $d['id_hotel'] = $lastId;
                        $d['broker'] = $info['broker' . $i];
                        $d['email'] = $info['email' . $i];
                        $d['is_del'] = 'no';


                        $Model->setTable("reservation_hotel_broker_tb");
                        $res_broker[] = $Model->insertLocal($d);

                    }

                    if (in_array("0", $res_broker)) {
                        return 'error : خطا در  تغییرات';

                    } else {
                        return 'success :  تغییرات با موفقیت انجام شد';
                    }

                } else {
                    if(isset($info['user_id'])){
                        return 'success :  .تغییرات با موفقیت انجام شد. منتظر تاییدیه مدیریت باشید ';
                    }
                    return 'success :  تغییرات با موفقیت انجام شد';
                }


                /*} else {
                    return 'error : خطا در  تغییرات';
                }*/


            } else {
                return 'error : خطا در  تغییرات';
            }

        } else {
            return 'error : هتل تکراری می باشد.';
        }


    }

    public function insertFirstHotelRoom($idHotel) {

        $infoRoom1['room_title'] = 'اتاق یک نفره';
        $infoRoom1['room_quality'] = '';
        $infoRoom1['room_view'] = '';
        $infoRoom1['id_hotel'] = $idHotel;
        $infoRoom1['room_name_en'] = 'SGL‏';
        $infoRoom1['room_comment'] = '';
        $infoRoom1['room_capacity'] = '1';
        $infoRoom1['maximum_extra_beds'] = '0';
        $infoRoom1['maximum_extra_chd_beds'] = '0';
        $resultInsertRoom[] = $this->InsertHotelRoom($infoRoom1);

        $infoRoom2['room_title'] = 'اتاق دو نفره(دبل)';
        $infoRoom2['room_quality'] = '';
        $infoRoom2['room_view'] = '';
        $infoRoom2['id_hotel'] = $idHotel;
        $infoRoom2['room_name_en'] = 'DBL‏';
        $infoRoom2['room_comment'] = '';
        $infoRoom2['room_capacity'] = '2';
        $infoRoom2['maximum_extra_beds'] = '0';
        $infoRoom2['maximum_extra_chd_beds'] = '0';
        $resultInsertRoom[] = $this->InsertHotelRoom($infoRoom2);

        $infoRoom3['room_title'] = 'اتاق دو نفره(توئین)';
        $infoRoom3['room_quality'] = '';
        $infoRoom3['room_view'] = '';
        $infoRoom3['id_hotel'] = $idHotel;
        $infoRoom3['room_name_en'] = 'DBL-T‏';
        $infoRoom3['room_comment'] = '';
        $infoRoom3['room_capacity'] = '2';
        $infoRoom3['maximum_extra_beds'] = '0';
        $infoRoom3['maximum_extra_chd_beds'] = '0';
        $resultInsertRoom[] = $this->InsertHotelRoom($infoRoom3);

        if (in_array("error : خطا در  تغییرات", $resultInsertRoom)) {
            return false;
        } else {
            return true;
        }

    }



    ///////////////////////////گالری هتل/////////////////////////////
    /////////////////////////////////////////////////////////////////

    public function InsertHotelRoom($info) {

        $Model = Load::library('Model');



        $roomType = $info['room_title'] . '-' . $info['room_quality'] . '-' . $info['room_view'];
        $sql = " SELECT * FROM  reservation_room_type_tb WHERE comment='{$roomType}' AND is_del='no' ";
        $result_roomType = $Model->load($sql);

        if (empty($result_roomType)) {

            $d['comment'] = $roomType;
            $d['is_del'] = 'no';

            $Model->setTable('reservation_room_type_tb');
            $res = $Model->insertLocal($d);
            $id_typeRoom = $Model->getLastId();

        } else {

            $id_typeRoom = $result_roomType['id'];
        }

        $sql = " SELECT * FROM  reservation_hotel_room_tb 
                    WHERE id_hotel='{$info['id_hotel']}' AND id_room='{$id_typeRoom}' AND is_del='no' ";
        $result_hotelRoom = $Model->load($sql);

        if (empty($result_hotelRoom)) {

            $data['id_hotel'] = $info['id_hotel'];
            $data['id_room'] = $id_typeRoom;
            $data['room_name'] = $roomType;
            $data['room_name_en'] = $info['room_name_en'];
            $data['room_comment'] = $info['room_comment'];
            $data['room_capacity'] = $info['room_capacity'];
            $data['maximum_extra_beds'] = $info['maximum_extra_beds'];
            $data['maximum_extra_chd_beds'] = $info['maximum_extra_chd_beds'];
            $data['is_del'] = 'no';

            $Model->setTable('reservation_hotel_room_tb');
            $res = $Model->insertLocal($data);

            if ($res) {
                return 'success :  تغییرات با موفقیت انجام شد';
            } else {
                return 'error : خطا در  تغییرات';
            }


        } else {
            return 'error : اتاق تکراری می باشد.';
        }

    }

    public function EditHotel($info) {
//var_dump('bbbbb');
//die;

        $Model = Load::library('Model');

        #region [آپلود فایل هتل]
        if (isset($_FILES['pic']) && $_FILES['pic'] != "") {

            $config = Load::Config('application');
            $success = $config->UploadFile("pic", "pic", "");
            $explod_name_pic = explode(':', $success);

            if ($explod_name_pic[0] == "done") {
                $data['logo'] = $explod_name_pic[1];
            }

        }
        #endregion


        $comment = str_replace(",", "`,`", $info['comment']);
        $comment = str_replace("'", " ", $comment);
        $comment = str_replace("from", "`from`", $comment);

        $comment_en = str_replace(",", "`,`", $info['comment_en']);
        $comment_en = str_replace("'", " ", $comment_en);
        $comment_en = str_replace("from", "`from`", $comment_en);

        if(isset($info['user_id'])) {
            $data['is_show'] = 'no';
        }
        $description = [
            'name' => 'description',
            'content' => filter_var($info['description'], FILTER_SANITIZE_STRING)
        ];
        if ($info['description']) {
            $added_metas = json_encode(array_merge([$description]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }


        $data['name'] = $info['name'];
        $data['name_en'] = $info['name_en'];
        $data['heading'] = $info['heading'];
        $data['title'] = $info['title'];
        $data['description'] = $info['description'];
        $data['discount'] = $info['discount'];
        $data['star_code'] = $info['star_code'];
        $data['type_code'] = $info['type_code'];
        $data['number_of_rooms'] = $info['number_of_rooms'];
        $data['site'] = $info['site'];
        $data['country'] = $info['origin_country'];
        $data['city'] = $info['origin_city'];
        $data['region'] = $info['origin_region'];
        $data['address'] = $info['address'];
        $data['address_en'] = $info['address_en'];
        $data['tel_number'] = $info['tel_number'];
        $data['trip_advisor'] = $info['trip_advisor'];
        $data['email_manager'] = $info['email_manager'];
        $data['entry_hour'] = $info['entry_hour'];
        $data['leave_hour'] = $info['leave_hour'];
        $data['latitude'] = $info['latitude'];
        $data['longitude'] = $info['longitude'];
        $data['comment'] = $comment;
        $data['comment_en'] = $comment_en;
        $data['distance_to_important_places'] = $info['distance_to_important_places'];
        $data['distance_to_important_places_en'] = $info['distance_to_important_places_en'];
        $data['rules'] = $info['rules'];
        $data['rules_en'] = $info['rules_en'];
        $data['cancellation_conditions'] = $info['cancellation_conditions'];
        $data['cancellation_conditions_en'] = $info['cancellation_conditions_en'];
        $data['child_conditions'] = $info['child_conditions'];
        $data['child_conditions_en'] = $info['child_conditions_en'];
        $data['user_name'] = '';
        $data['pass'] = '';
        $data['iframe_code'] = $info['iframe_code'];
        $data['prepayment_percentage'] = $info['prepaymentPercentage'];
        $data['sepehr_hotel_code'] = $info['sepehr_hotel_code'];
        $data['updated_at'] = date('Y-m-d H:i:s', time());




        if (isset($info['chk_flag_special']) && $info['chk_flag_special'] = 1) {
            $data['flag_special'] = 'yes';
        } else {
            $data['flag_special'] = 'no';
        }
        if(isset($info['user_id'])) {
            $data['flag_special'] = 'yes';
        }

        if (isset($info['chk_flag_discount']) && $info['chk_flag_discount'] = 1) {
            $data['flag_discount'] = 'yes';
        } else {
            $data['flag_discount'] = 'no';
        }

        if (isset($info['transfer_went']) && $info['transfer_went'] != '') {
            $data['transfer_went'] = 'yes';
        } else {
            $data['transfer_went'] = 'no';
        }

        if (isset($info['transfer_back']) && $info['transfer_back'] != '') {
            $data['transfer_back'] = 'yes';
        } else {
            $data['transfer_back'] = 'no';
        }

        $Condition = "id='{$info['type_id']}' ";
        $Model->setTable('reservation_hotel_tb');
        $res = $Model->update($data, $Condition);

        if ($res) {

            $this->getController('siteMap')->createSitemap();

            // کارگزار هتل
            if (isset($info['count_package']) && $info['count_package'] > 0) {
                $success = 0;
                for ($i = 1; $i <= $info['count_package']; $i++) {

                    if (isset($info['chk_broker' . $i]) && $info['chk_broker' . $i] == '1') {
                        $d['choose'] = 'yes';
                    } else {
                        $d['choose'] = 'no';
                    }
                    $d['id_hotel'] = $info['type_id'];
                    $d['broker'] = $info['broker' . $i];
                    $d['email'] = $info['email' . $i];
                    $d['is_del'] = 'no';

                    $sql = " SELECT * FROM reservation_hotel_broker_tb WHERE 
                        id_hotel='{$info['type_id']}' AND email='{$info['email'.$i]}' AND is_del='no' ";
                    $hotel = $Model->load($sql);
                    if (empty($hotel)) {
                        $Model->setTable("reservation_hotel_broker_tb");
                        $res_broker = $Model->insertLocal($d);
                        if ($res_broker) {
                            $success++;
                        }
                    } else {

                        $Condition = " id_hotel='{$info['type_id']}' AND email='{$info['email'.$i]}' ";
                        $Model->setTable('reservation_hotel_broker_tb');
                        $res_broker = $Model->update($d, $Condition);
                        if ($res_broker) {
                            $success++;
                        }
                    }

                }
                if ($success == $info['count_package']) {
                    return 'success :  تغییرات با موفقیت انجام شد' . ':' . $info['type_id'];
                } else {
                    return 'error : خطا در  تغییرات' . ':' . $info['type_id'];
                }

            } else {
                return 'success :  تغییرات با موفقیت انجام شد' . ':' . $info['type_id'];
            }


        } else {
            return 'error : خطا در  تغییرات' . ':' . $info['type_id'];
        }

    }





    ///////////////////////////اتاق هتل/////////////////////////////
    /////////////////////////////////////////////////////////////////

    public function InsertGallery($info) {
        switch ($info['table_name']) {
            case 'reservation_hotel_gallery_tb':
                $link = 'addHotelGallery&id=' . $info['id_hotel'];
                break;
            case 'reservation_room_gallery_tb':
                $data['id_hotel'] = $info['id_hotel'];
                $link = 'addRoomGallery&idHotel=' . $info['id_hotel'] . '&idRoom=' . $info['id_room'];
                break;
        }

        $Model = Load::library('Model');

        // آپلود فایل هتل //
        if (isset($_FILES['pic']) && $_FILES['pic'] != "") {

            $config = Load::Config('application');
            $success = $config->UploadFile("pic", "pic", 5120000);
            $explod_name_pic = explode(':', $success);

            if ($explod_name_pic[0] == "done") {
                $data['pic'] = $explod_name_pic[1];

                $data[$info['foreign_key_constraint']] = $info[$info['foreign_key_constraint']];
                $data['name'] = $info['name'];
                $data['comment'] = $info['comment'];
                $data['is_del'] = 'no';

                $Model->setTable($info['table_name']);
                $res = $Model->insertLocal($data);


                if ($res) {
                    return 'success :  تغییرات با موفقیت انجام شد' . ':' . $link;
                } else {
                    return 'error : خطا در  تغییرات' . ':' . $link;
                }

            } else {
                return 'error :' . $success . ':' . $link;
            }

        } else {
            $data['pic'] = '';
        }


    }

    public function updateGallery($val) {


        $Model = Load::library('Model');

        #region [آپلود فایل هتل]
        if (isset($_FILES['pic']) && $_FILES['pic'] != "") {

            $config = Load::Config('application');
            $success = $config->UploadFile("pic", "pic", "99900000");
            $explod_name_pic = explode(':', $success);

            if ($explod_name_pic[0] == "done") {

                $d['pic'] = $explod_name_pic[1];

            }

        } else {
            $data['pic'] = '';
        }
        #endregion

        $d['name'] = $val['name'];
        $d['comment'] = $val['comment'];

        $Condition = "id='{$val['type_id']}' ";
        $Model->setTable($val['table_name']);
        $res = $Model->update($d, $Condition);

        if ($res) {
            return 'success :  تغییرات با موفقیت انجام شد' . ':' . $val['type_id'];
        } else {
            return 'error : خطا در  تغییرات' . ':' . $val['type_id'];
        }

    }

    public function ListHotelRoom($id_hotel) {

        $Model = Load::library('Model');

        $sql = " SELECT HR.*, RT.comment, RT.id as idRoom FROM
                    reservation_hotel_room_tb HR INNER JOIN  reservation_room_type_tb RT ON  HR.id_room=RT.id
                  WHERE HR.id_hotel='{$id_hotel}' AND HR.is_del='no' ORDER BY HR.id ASC ";

//        echo $sql;
//        die;
        $room = $Model->select($sql);
        return $room;
    }

    public function showListHotelRoom($id) {

        $Model = Load::library('Model');
        if (isset($id) && !empty($id)) {
            $edit_query = " SELECT HR.*, RT.comment FROM
                    reservation_hotel_room_tb HR INNER JOIN  reservation_room_type_tb RT ON  HR.id_room=RT.id
                  WHERE HR.id='{$id}' AND HR.is_del='no' ORDER BY HR.id ASC";
            $res_edit = $Model->load($edit_query);

            if (!empty($res_edit)) {

                $room = explode('-', $res_edit['comment']);
                $this->listHotelRoomType['room_title'] = $room[0];
                $this->listHotelRoomType['room_quality'] = $room[1];
                $this->listHotelRoomType['room_view'] = $room[2];
                $this->listHotelRoom = $res_edit;

            } else {
                header("Location: " . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . "/404.tpl");
            }
        } else {
            header("Location: " . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . "/404.tpl");
        }
    }


    ///////////////////////////امکانات هتل/////////////////////////////
    /////////////////////////////////////////////////////////////////

    public function updateHotelRoom($info) {

        $Model = Load::library('Model');

        $roomType = $info['room_title'] . '-' . $info['room_quality'] . '-' . $info['room_view'];

        $sql = " SELECT * FROM  reservation_room_type_tb WHERE comment='{$roomType}' AND is_del='no' ";
        $result_roomType = $Model->load($sql);

        $oldRoom = $result_roomType['id'];

        if (empty($result_roomType)) {

            $d['comment'] = $roomType;
            $d['is_del'] = 'no';

            $Model->setTable('reservation_room_type_tb');
            $res = $Model->insertLocal($d);
            $id_typeRoom = $Model->getLastId();


        } else {

            $id_typeRoom = $result_roomType['id'];

        }

        $data['id_hotel'] = $info['id_hotel'];
        $data['id_room'] = $id_typeRoom;
        $data['room_name'] = $roomType;
        $data['room_name_en'] = $info['room_name_en'];
        $data['room_comment'] = $info['room_comment'];
        $data['room_capacity'] = $info['room_capacity'];
        $data['maximum_extra_beds'] = $info['maximum_extra_beds'];
        $data['maximum_extra_chd_beds'] = $info['maximum_extra_chd_beds'];

        $Condition = "id='{$info['type_id']}' ";
        $Model->setTable('reservation_hotel_room_tb');
        $res = $Model->update($data, $Condition);

        if ($res) {

            return 'success : تغییرات با موفقیت انجام شد' . ':' . $info['type_id'];
            /*$RoomPrices['id_room'] = $id_typeRoom;

            $ConditionRoomPrices = " id_hotel='{$info['id_hotel']}' AND id_room='{$oldRoom}' ";
            $Model->setTable('reservation_hotel_room_prices_tb');
            $resRoomPrices = $Model->update($RoomPrices, $ConditionRoomPrices);

            if ($resRoomPrices){
                return 'success : تغییرات با موفقیت انجام شد' . ':' . $info['type_id'];
            }else{
                return 'error : خطا در  تغییرات' . ':' . $info['type_id'];
            }*/


        } else {
            return 'error : خطا در  تغییرات' . ':' . $info['type_id'];
        }

    }

    public function InsertFacilities($info) {

        $Model = Load::library('Model');

        $data['title'] = $info['title'];
        $data['icon_class'] = $info['radio'];
        $data['is_del'] = 'no';

        $sql = " SELECT * FROM  reservation_facilities_tb WHERE title='{$info['title']}' AND is_del='no' ";
        $result = $Model->load($sql);
        if (empty($result)) {

            $Model->setTable('reservation_facilities_tb');
            $res = $Model->insertLocal($data);

            if ($res) {
                return 'success :  تغییرات با موفقیت انجام شد';
            } else {
                return 'error : خطا در  تغییرات';
            }
        } else {
            return 'error : اطلاعات تکراری می باشد.';
        }


    }

    public function EditFacilities($val) {

        $Model = Load::library('Model');

        $d['title'] = $val['title'];
        if (isset($val['radio']) && $val['radio'] != '') {
            $d['icon_class'] = $val['radio'];
        }

        $Condition = "id='{$val['id']}' ";
        $Model->setTable("reservation_facilities_tb");
        $res = $Model->update($d, $Condition);

        if ($res) {
            return 'success :  تغییرات با موفقیت انجام شد';
        } else {
            return 'error : خطا در  تغییرات';
        }

    }

    public function showFacilities() {

        $Model = Load::library('Model');

        $query = " SELECT * FROM reservation_facilities_tb WHERE is_del='no' ORDER BY id ASC ";
        $res = $Model->select($query);
        $this->listFacilities = $res;

    }

    public function InsertRoomFacilities($info) {

        $Model = Load::library('Model');

        $check_insert = "no";
        for ($i = 1; $i <= $info['CountFacilities']; $i++) {

            if (isset($info['chk_room_facilities' . $i]) && $info['chk_room_facilities' . $i] != "") {


                $sql = " SELECT * FROM  reservation_room_facilities_tb 
                          WHERE id_hotel='{$info['id_hotel']}' AND id_room='{$info['id_room']}' AND
                                id_facilities='{$info['chk_room_facilities'.$i]}' AND is_del='no'";
                $result_roomFacilities = $Model->load($sql);

                if (empty($result_roomFacilities)) {

                    $data['id_hotel'] = $info['id_hotel'];
                    $data['id_room'] = $info['id_room'];
                    $data['id_facilities'] = $info['chk_room_facilities' . $i];
                    $data['is_del'] = 'no';

                    $Model->setTable('reservation_room_facilities_tb');
                    $res = $Model->insertLocal($data);

                    if ($res) {
                        $check_insert = "yes";
                    } else {
                        $check_insert = "no";
                    }

                }

            }

        }

        $link = "roomFacilities&idHotel=" . $info['id_hotel'] . "&idRoom=" . $info['id_room'];

        if ($check_insert == "yes") {
            return 'success :  تغییرات با موفقیت انجام شد' . ':' . $link;
        } else {
            return 'error : اطلاعات تکراری وجود داشت' . ':' . $link;
        }

    }

    public function showRoomFacilities($idHotel, $idRoom) {

        $Model = Load::library('Model');

        $query = " SELECT *, RF.id as idFacilities FROM
                    reservation_room_facilities_tb RF INNER JOIN  reservation_facilities_tb F ON  RF.id_facilities=F.id
                  WHERE RF.id_hotel='{$idHotel}' AND RF.id_room='{$idRoom}' AND RF.is_del='no' ORDER BY F.id ASC ";

        $res = $Model->select($query);

        $this->listRoomFacilities = $res;

    }

    public function showHotelFacilities($id) {

        $Model = Load::library('Model');
        if (isset($id) && !empty($id)) {

            $query = " SELECT *, RF.id as idFacilities FROM
                    reservation_hotel_facilities_tb RF INNER JOIN  reservation_facilities_tb F ON  RF.id_facilities=F.id
                  WHERE RF.id_hotel='{$id}' AND RF.is_del='no' ORDER BY F.id ASC ";
            $res = $Model->select($query);
            $this->listHotelFacilities = $res;
        } else {
            header("Location: " . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . "/404.tpl");
        }
    }

    public function InsertHotelFacilities($info) {

        $Model = Load::library('Model');

        $check_insert = "no";
        for ($i = 1; $i <= $info['CountFacilities']; $i++) {

            if (isset($info['chk_hotel_facilities' . $i]) && $info['chk_hotel_facilities' . $i] != "") {


                $sql = " SELECT * FROM  reservation_hotel_facilities_tb 
                              WHERE id_hotel='{$info['id_hotel']}' AND  id_facilities='{$info['chk_hotel_facilities'.$i]}' AND is_del='no' ";
                $result_roomFacilities = $Model->load($sql);

                if (empty($result_roomFacilities)) {

                    $data['id_hotel'] = $info['id_hotel'];
                    $data['id_facilities'] = $info['chk_hotel_facilities' . $i];
                    $data['is_del'] = 'no';

                    $Model->setTable('reservation_hotel_facilities_tb');
                    $res = $Model->insertLocal($data);

                    if ($res) {
                        $check_insert = "yes";
                    } else {
                        $check_insert = "no";
                    }

                }

            }

        }

        $link = "hotelFacilities&id=" . $info['id_hotel'];

        if ($check_insert == "yes") {
            return 'success :  تغییرات با موفقیت انجام شد' . ':' . $link;
        } else {
            return 'error : اطلاعات تکراری وجود داشت' . ':' . $link;
        }


    }


    //// اضافه کردن شرکت حمل و نقل

    public function getHotelBroker($idHotel) {

        $Model = Load::library('Model');
        $sql = " SELECT * FROM reservation_hotel_broker_tb WHERE id_hotel='{$idHotel}' AND is_del='no' ORDER BY id ASC ";
        $res = $Model->select($sql);
        if (!empty($res)) {
            $this->listBroker = $res;
        }

    }

    public function insertTransportCompanies($param) {
        $Model = Load::library('Model');

        $data['fk_id_type_of_vehicle'] = $param['id_type_of_vehicle'];
        $data['name'] = $param['name'];
        $data['name_en'] = $param['name_en'];
        $data['abbreviation'] = $param['abbreviation'];
        $data['is_del'] = 'no';

        if (isset($_FILES['pic']) && $_FILES['pic'] != "") {

            $config = Load::Config('application');
            $success = $config->UploadFile("pic", "pic", "");
            $explod_name_pic = explode(':', $success);

            if ($explod_name_pic[0] == "done") {

                $data['pic'] = $explod_name_pic[1];

            } else {
                $data['pic'] = '';
            }

        } else {
            $data['pic'] = '';
        }


        $Model->setTable("reservation_transport_companies_tb");
        $res = $Model->insertLocal($data);

        if ($res) {
            return 'success :  تغییرات با موفقیت انجام شد';
        } else {
            return 'error : خطا در  تغییرات';
        }


    }


    /////////////////نوع تور/////////////////

    public function updateTransportCompanies($param) {

        $Model = Load::library('Model');

        $data['name'] = $param['name'];
        $data['name_en'] = $param['name_en'];
        $data['abbreviation'] = $param['abbreviation'];

        if (isset($_FILES['pic']) && $_FILES['pic'] != "") {

            $config = Load::Config('application');
            $success = $config->UploadFile("pic", "pic", "");
            $explod_name_pic = explode(':', $success);

            if ($explod_name_pic[0] == "done") {
                $data['pic'] = $explod_name_pic[1];
            }

        }

        $Condition = "id='{$param['id']}' ";
        $Model->setTable("reservation_transport_companies_tb");
        $res = $Model->update($data, $Condition);

        if ($res) {
            return 'success :  تغییرات با موفقیت انجام شد';
        } else {
            return 'error : خطا در  تغییرات';
        }

    }

    public function insertTourType($info) {

        $Model = Load::library('Model');

        $sql = " SELECT * FROM  reservation_tour_type_tb WHERE tour_type='{$info['tour_type']}' AND is_del='no' ";
        $tour = $Model->load($sql);

        if (empty($tour)) {

            $data['tour_type'] = $info['tour_type'];
            $data['tour_type_en'] = $info['tour_type_en'];
            $data['is_del'] = 'no';

            $Model->setTable('reservation_tour_type_tb');
            $res = $Model->insertLocal($data);

            if ($res) {
                return 'success :  تغییرات با موفقیت انجام شد';
            }

            return 'error : خطا در  تغییرات';

        } else {
            return 'error : نوع تور تکراری می باشد.';
        }


    }

    public function editTourType($val) {

        $Model = Load::library('Model');

        $d['tour_type'] = $val['tour_type'];
        $d['tour_type_en'] = $val['tour_type_en'];
        $Condition = "id='{$val['id']}' ";
        $Model->setTable("reservation_tour_type_tb");
        $res = $Model->update($d, $Condition);

        if ($res) {
            return 'success :  تغییرات با موفقیت انجام شد';
        } else {
            return 'error : خطا در  تغییرات';
        }

    }

    public function GetTourCityOnlineSearch() {

        $Code = filter_var($_POST['Code'], FILTER_SANITIZE_STRING);
        $Type = filter_var($_POST['Type'], FILTER_SANITIZE_STRING);
        $dateNow = dateTimeSetting::jdate("Ymd", '', '', '', 'en');

        $Model = Load::library('Model');

        $sql_routs = "SELECT RCity.id,RCity.name,RCity.id_country
            FROM reservation_city_tb AS RCity
            INNER JOIN reservation_tour_rout_tb AS RTourRout ON RCity.id=RTourRout.destination_city_id
            INNER JOIN reservation_tour_tb AS RTour ON RTour.id=RTourRout.fk_tour_id
            WHERE 
              RCity.name Like '%{$Code}%'
              OR RCity.name_en Like '%{$Code}%'
              OR RTour.tour_name Like '%{$Code}%'
              AND RTour.is_del = 'no' 
              AND RTour.is_show = 'yes' 
              AND RTour.language = '" . SOFTWARE_LANG . "' 
              AND RTour.start_date > '{$dateNow}' AND RTour.start_date < '20000101' 
              AND RTourRout.tour_title = 'dept'
              GROUP BY RCity.id
                  ORDER BY RTourRout.id DESC";

        $res = $Model->select($sql_routs);
        $result = '';
        foreach ($res as $rout) {
            $result .= '<li class="textSearchFlightForeign" onclick="SubmitSearchTourResult(' . "'" . $rout['id'] . "'" . ',' . "'" . $rout['id_country'] . "'" . ',' . "'" . dateTimeSetting::jdate("Y-m-d", '', '', '', 'en') . "'" . ',' . "'" . $rout['name'] . "'" . ')">
        ' . $rout['name'] . '</li>';

        }
        return $result;
    }

    public function isShowHotel($params) {
        $Model = Load::library('Model');

        if ($params['isShow'] == 'yes') {
//            $data['change_price'] = str_ireplace(",", "", $params['detail']);
            $data['comment_cancel'] = '';
            $data['is_del'] = 'no';
        } elseif ($params['isShow'] == 'no') {
            $data['comment_cancel'] = $params['detail'];
//            $data['change_price'] = 0;
        }

        $data['is_show'] = $params['isShow'];


        $Condition = "id='{$params['idHotel']}' ";
        $Model->setTable('reservation_hotel_tb');
        $res = $Model->update($data, $Condition);

        return "success: " . functions::Xmlinformation('ChangesSuccessfullyCompleted');
    }

    public function getHotel($idHotel) {

        $Model = Load::library('Model');
        $sql = " SELECT * FROM reservation_hotel_tb WHERE id='{$idHotel}' AND is_del='no'";

        return $Model->load($sql);

    }


    public function getInfoHotelData($nameTable, $fieldCondition, $valueCondition) {
        $Model = Load::library('Model');
        if (isset($nameTable) && !empty($nameTable)) {
            $sql = " SELECT * FROM {$nameTable} WHERE {$fieldCondition}='{$valueCondition}' AND is_del='no' ";
            $res = $Model->load($sql);
            if (!empty($res)) {
                $res['city'] =  $res['city'];
                $main_city_controller = Load::controller('mainCity');
                $res['city_title']  = $main_city_controller->fetchCityRecord($res['city'])[0]['name'];
                $res['city_title_en']  = $main_city_controller->fetchCityRecord($res['city'])[0]['name_en'];

                $country_controller = Load::controller('mainCountry');
                $res['country_title']  = $country_controller->getCountryRecords($res['country'])[0]['name'];
                $res['country_title_en']  = $country_controller->getCountryRecords($res['country'])[0]['name_en'];

                return $res;
            }
        } else {
            header("Location: " . ROOT_ADDRESS_WITHOUT_LANG . '/' . FOLDER_ADMIN . "/404.tpl");
        }

    }

    public function GetFlyForEdit()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $id = isset($input['id']) ? intval($input['id']) : 0;

        if ($id <= 0) {
            functions::JsonError('شناسه نامعتبر است');
            return;
        }

        $fly = $this->getModel('reservationFlyModel')
            ->get()
            ->where('id', $id)
            ->find();

        $infoFly = $this->getModel('temporaryDataModel')
            ->get(['data'])
            ->where('reference_id', $id)
            ->where('reference_type', 'fly_number')
            ->find();

        if (!empty($infoFly['data'])) {
            $fly['departure_hours']='';
            $extraData = json_decode($infoFly['data'], true);
            if (is_array($extraData)) {
                $fly['departure_time'] = $extraData['departure_hours'].':'.$extraData['departure_minutes'] ;
            }
        }

        return $fly;
    }
    //create function for get reservation_fly_tb records and use model and orm to get records
    public function getReservationFlyRecords() {
        $flyTable = $this->getModel('reservationFlyModel')->getTable();
        $ticketTable = $this->getModel('reservationTicketModel')->getTable();
        $vehicleTable = $this->getModel('reservationVehicleModel')->getTable() ;
        $temporaryTable = $this->getModel('temporaryDataModel')->getTable() ;

        $records=$this->getModel('reservationFlyModel')
            ->get([
                $flyTable . '.*',
                $ticketTable . '.exit_hour',
                $vehicleTable . '.name as vehicle_model',
                $temporaryTable.'.data as DataTmp'
            ],true)
            ->joinSimple(
                [$ticketTable, $ticketTable],
                $flyTable . '.id',
                $ticketTable.'.fly_code',
                'LEFT'
            )
            ->joinSimple(
                [$vehicleTable, $vehicleTable],
                $ticketTable . '.type_of_vehicle',
                $vehicleTable.'.id',
                'LEFT'
            )
            ->joinSimple(
                [$temporaryTable, $temporaryTable],
                $temporaryTable.".reference_id",
                "{$flyTable}.id AND {$temporaryTable}.reference_type = 'fly_number'",
                'LEFT'
            );

           // Date from filter - from ticket table
            if (!empty($this->filtersListFly['date_from'])) {
                $dateFrom = str_replace(['-','/'], '', $this->filtersListFly['date_from']);
                $records->where($ticketTable . '.date', $dateFrom, '>=');
            }

            // Date to filter - from ticket table
            if (!empty($this->filtersListFly['date_to'])) {
                $dateTo = str_replace(['-','/'], '', $this->filtersListFly['date_to']);
                $records->where($ticketTable . '.date', $dateTo, '<=');
            }

            // Origin filter - expect city ID
            if (!empty($this->filtersListFly['origin'])) {
                $records->where($flyTable . '.origin_city', $this->filtersListFly['origin']);
            }

            // Destination filter - expect city ID
            if (!empty($this->filtersListFly['destination'])) {
                $records->where($flyTable . '.destination_city', $this->filtersListFly['destination']);
            }

            // Fly code filter
            if (!empty($this->filtersListFly['fly_code'])) {
                $records->where($flyTable . '.fly_code', '%' . $this->filtersListFly['fly_code'] . '%', 'LIKE');
            }

            // Airline filter - expect airline ID
            if (!empty($this->filtersListFly['airline'])) {
                $records->where($flyTable . '.airline', $this->filtersListFly['airline']);
            }

            // Vehicle type filter - expect vehicle type ID
            if (!empty($this->filtersListFly['vehicle_type'])) {
                $records->where($flyTable . '.type_of_vehicle_id', $this->filtersListFly['vehicle_type']);
            }

            // Exit hour filter
            if (!empty($this->filtersListFly['exit_hour'])) {
                $records->where($ticketTable . '.exit_hour', $this->filtersListFly['exit_hour']);
            }

            $result = $records
                ->groupBy($flyTable . '.id')
                ->orderBy($flyTable.'.id','desc')
                ->all();
        return $result;
    }

    public function getFilteredListFly($params) {
        // Extract filters from params
        $this->filtersListFly = isset($params['filters']) ? $params['filters'] : $params;
        $records = $this->getReservationFlyRecords();

        // اگر نتیجه خالی بود
        if (empty($records)) {
            return functions::JsonSuccess([
                'html' => '<tr><td colspan="9" class="text-center text-muted">هیچ رکوردی یافت نشد</td></tr>'
            ]);
        }

        $html = '';
        $counter = 0;
        foreach ($records as $item) {
            $counter++;
            $origin = $this->getController('reservationPublicFunctions')->ShowName('reservation_country_tb',$item['origin_country']).' - '.$this->getController('reservationPublicFunctions')->ShowName('reservation_city_tb',$item['origin_city']);
            $destination = $this->getController('reservationPublicFunctions')->ShowName('reservation_country_tb',$item['destination_country']).' - '.$this->getController('reservationPublicFunctions')->ShowName('reservation_city_tb',$item['destination_city']);
            $origin_region = $this->getController('reservationPublicFunctions')->ShowName('reservation_region_tb',$item['origin_region']);
            $destination_region = $this->getController('reservationPublicFunctions')->ShowName('reservation_region_tb',$item['destination_region']);
            $vehicle_type = $this->getController('reservationPublicFunctions')->ShowName('reservation_type_of_vehicle_tb',$item['type_of_vehicle_id']);

            // مدل وسیله نقلیه
            $vehicle_model = '';
            if (!empty($item['vehicle_model'])) {
                $vehicle_model = $item['vehicle_model'];
            } elseif (!empty($item['type_of_plane'])) {
                $vehicle_model = $this->getController('reservationPublicFunctions')->ShowName('reservation_vehicle_model_tb',$item['type_of_plane']);
            }

            // ساعت حرکت
            $exit_hour = '-';
            if (!empty($item['DataTmp'])) {
                $tmp = json_decode($item['DataTmp'], true);
                $exit_hour = $tmp['departure_hours'].':'.$tmp['departure_minutes'];
            } elseif (!empty($item['exit_hour'])) {
                $exit_hour = $item['exit_hour'];
            }

            $html .= "
        <tr id='del-{$item['id']}'>
            <td>{$counter}</td>
            <td>{$origin}</td>
            <td>{$origin_region}</td>
            <td>{$destination}</td>
            <td>{$destination_region}</td>
            <td>{$item['fly_code']}</td>
            <td>{$vehicle_type}</td>
            <td>{$this->getAirlineName($item)}</td>
            <td>{$vehicle_model}</td>
            <td>{$exit_hour}</td>
            <td>{$item['time']}</td>
            <td>
                <a href='javascript:void(0)' onclick='quickEditFly({$item['id']})'>
                    <i  class='fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary'
                        data-toggle='tooltip' data-placement='top' title='''
                        data-original-title='ویرایش'>

                    </i>
                </a>
                
            </td>
            <td>
               <a href='ticketAdd?fly_id={$item['id']}' title='افزودن برنامه پروازی' class='btn btn-success btn-sm'>
                 <i class='fa fa-ticket'></i>
               </a>
            </td>
        </tr>";

        }

        return functions::JsonSuccess(['html' => $html]);
    }

    private function getAirlineName($item) {
        $type = $this->getController('reservationPublicFunctions')->ShowName('reservation_type_of_vehicle_tb',$item['type_of_vehicle_id']);
        if ($type == 'هواپیما') {
            return $this->getController('reservationPublicFunctions')->ShowNameBase('airline_tb','name_fa',$item['airline']);
        } else {
            return $this->getController('reservationPublicFunctions')->ShowName('reservation_transport_companies_tb',$item['airline']);
        }
    }

}
?>
