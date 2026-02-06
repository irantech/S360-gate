<?php

class addRoomFactor extends apiHotelLocal
{
    public $adultArr = array();
    public $IsLogin ;
    public $count_basket ;
    public $city ;
    public $numberNight ;
    public $startDate ;
    public $counterTypeId = '';
    public $counterName = '';
    public $counterId = '';
    public $serviceDiscount = array();


    public function __construct()
    {
        $this->IsLogin = Session::IsLogin();
        if ($this->IsLogin){
            $this->counterId = functions::getCounterTypeId($_SESSION['userId']);
            $this->serviceDiscount['api'] = functions::ServiceDiscount($this->counterId, 'PublicLocalHotel');
            $this->serviceDiscount['ForeignApi'] = functions::ServiceDiscount($this->counterId, 'PublicPortalHotel');
        }else {
            $this->counterId = '5';
        }
    }


    public function statusRefresh(){

        session_start();
        if(isset($_SESSION['StatusRefresh']) && trim($_SESSION['StatusRefresh'])==$_POST['StatusRefresh']){
            // can't submit refresh
            unset($_SESSION['StatusRefresh']);
            unset($_SESSION['FactorNumberForHotelBooking']);
            unset($_SESSION['FactorNumber']);
            header('Location: ' . ROOT_ADDRESS . '/resultHotelLocal/' . $_POST['idCity_Reserve'] . '/' . $_POST['StartDate_Reserve'] . '/' . $_POST['Nights_Reserve'] );
            exit();
        }
        else{
            $_SESSION['StatusRefresh'] = $_POST['StatusRefresh'];
        }
    }


    public function registerPassengersReservationHotel()
    {
        /*echo 'registerPassengersReservationHotel <hr>';
        echo Load::plog($_POST);
        die();*/

        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $passengerController = Load::controller('passengers');

        // insert in to book table
        $d['factor_number'] = $_POST["factorNumber"];
        $d['type_application'] = $_POST["typeApplication"];
        $d['serviceTitle'] = functions::TypeServiceHotel($d['type_application']);

        $infoHotel = functions::GetInfoHotel($_POST["factorNumber"]);

        $d['member_id'] = $infoHotel['member_id'];
        $d['member_name'] = $infoHotel['member_name'];
        $d['member_mobile'] = $infoHotel['member_mobile'];
        $d['member_phone'] = $infoHotel['member_phone'];
        $d['member_email'] = $infoHotel['member_email'];
        $d['agency_id'] = $infoHotel['agency_id'];
        $d['agency_name'] = $infoHotel['agency_name'];
        $d['agency_accountant'] = $infoHotel['agency_accountant'];
        $d['agency_manager'] = $infoHotel['agency_manager'];
        $d['agency_mobile'] = $infoHotel['agency_mobile'];
        $d['passenger_leader_room'] = $infoHotel['passenger_leader_room'];
        $d['passenger_leader_room_fullName'] = $infoHotel['passenger_leader_room_fullName'];
        $d['start_date'] = $infoHotel['start_date'];
        $d['end_date'] = $infoHotel['end_date'];
        $d['number_night'] = $infoHotel['number_night'];
        $d['city_id'] = $infoHotel['city_id'];
        $d['hotel_id'] = $infoHotel['hotel_id'];
        $d['city_id'] = $infoHotel['city_id'];
        $d['city_name'] = $infoHotel['city_name'];
        $d['hotel_id'] = $infoHotel['hotel_id'];
        $d['hotel_name'] = $infoHotel['hotel_name'];
        $d['hotel_name_en'] = $infoHotel['hotel_name_en'];
        $d['hotel_address'] = $infoHotel['hotel_address'];
        $d['hotel_address_en'] = $infoHotel['hotel_address_en'];
        $d['hotel_telNumber'] = $infoHotel['hotel_telNumber'];
        $d['hotel_starCode'] = $infoHotel['hotel_starCode'];
        $d['hotel_entryHour'] = $infoHotel['hotel_entryHour'];
        $d['hotel_leaveHour'] = $infoHotel['hotel_leaveHour'];
        $d['hotel_pictures'] = $infoHotel['hotel_pictures'];
        $d['hotel_rules'] = $infoHotel['hotel_rules'];
        $d['origin'] = $infoHotel['origin'];
        $d['flight_date_went'] = $infoHotel['flight_date_went'];
        $d['airline_went'] = $infoHotel['airline_went'];
        $d['flight_number_went'] = $infoHotel['flight_number_went'];
        $d['hour_went'] = $infoHotel['hour_went'] ;
        $d['flight_date_back'] = $infoHotel['flight_date_back'];
        $d['airline_back'] = $infoHotel['airline_back'];
        $d['flight_number_back'] = $infoHotel['flight_number_back'];
        $d['hour_back'] = $infoHotel['hour_back'];

        $paymentPrice = $infoHotel['total_price'];

        $i = 1; $description = '';
        while (isset($_POST["nameFaA" . $i])) {

            $exp = explode("_", $_POST["roommate" . $i]);
            $expRoomCount = explode(":", $exp[1]);
            $editRoomCount[$_POST["room_id" . $i]]['room_count'] = $expRoomCount[1];
            $editRoomCount[$_POST["room_id" . $i]]['room_id'] = $_POST["room_id" . $i];

            $sql_check_book = " SELECT id FROM book_hotel_local_tb WHERE 
              factor_number ='{$_POST["factorNumber"]}' AND member_id='{$infoHotel['member_id']}' AND 
              roommate='{$_POST["roommate" . $i]}' AND passenger_gender='{$_POST["genderA" . $i]}' AND 
              type_application='reservation' ";
            $book_check = $Model->load($sql_check_book);

            if (empty($book_check)) {

                $passenger['gender'] = $_POST["genderA" . $i];
                $passenger['name_en'] = $_POST["nameEnA" . $i];
                $passenger['family_en'] = $_POST["familyEnA" . $i];
                $passenger['name'] = $_POST["nameFaA" . $i];
                $passenger['family'] = $_POST["familyFaA" . $i];
                $passenger['NationalCode'] = $_POST["NationalCodeA" . $i];
                $passenger['passportCountry'] = $_POST["passportCountryA" . $i];
                $passenger['passportNumber'] = $_POST["passportNumberA" . $i];
                $passenger['passportExpire'] = $_POST["passportExpireA" . $i];


                if ($_POST["passengerNationalityA" . $i] == '0') {
                    $this->adultArr[$i]['birthday_fa'] = $_POST["birthdayA" . $i];
                    $birthday = $_POST["birthdayA" . $i];
                } else{
                    $this->adultArr[$i]['birthday'] = $_POST["birthdayEnA" . $i];
                    $birthday = $_POST["birthdayEnA" . $i];
                }

                if ($this->IsLogin && $_POST["nameEn" . $i]!='') {

                    $passengerAddArray = array(
                        'passengerName' => $this->adultArr[$i]['name'],
                        'passengerNameEn' => $this->adultArr[$i]['name_en'],
                        'passengerFamily' => $this->adultArr[$i]['family'],
                        'passengerFamilyEn' => $this->adultArr[$i]['family_en'],
                        'passengerGender' => $this->adultArr[$i]['gender'],
                        'passengerBirthday' => $this->adultArr[$i]['birthday_fa'],
                        'passengerNationalCode' => $this->adultArr[$i]['NationalCode'],
                        'passengerBirthdayEn' => $this->adultArr[$i]['birthday'],
                        'passengerPassportCountry' => $this->adultArr[$i]['passportCountry'],
                        'passengerPassportNumber' => $this->adultArr[$i]['passportNumber'],
                        'passengerPassportExpire' => $this->adultArr[$i]['passportExpire'],
                        'memberID' => $this->adultArr[$i]['fk_members_tb_id'],
                        'passengerNationality' => $_POST["passengerNationalityA" . $i]
                    );
                    $passengerController->insert($passengerAddArray);
                }



                if (!empty($birthday)) {

                    $explode_br_fa = explode('-', $birthday);
                    $date_miladi = dateTimeSetting::jalali_to_gregorian($explode_br_fa[0], $explode_br_fa[1], $explode_br_fa[2], '-');
                    $passenger_age = $this->type_passengers(isset($passenger['birthday']) ? $passenger['birthday'] : $date_miladi);
                }

                $d['roommate'] = $_POST["roommate" . $i];
                $d['flat_type'] = $_POST["flat_type" . $i];
                $d['passenger_national_code'] = !empty($passenger['NationalCode']) ? $passenger['NationalCode'] : '0000000000';
                $d['passenger_age'] = $passenger_age;
                $d['passenger_gender'] = $passenger['gender'];
                $d['passenger_name'] = $passenger['name'];
                $d['passenger_name_en'] = $passenger['name_en'];
                $d['passenger_family'] = $passenger['family'];
                $d['passenger_family_en'] = $passenger['family_en'];
                $d['passenger_birthday'] = $birthday;
                $d['passenger_birthday_en'] = $passenger['birthday'];
                $d['passenger_national_code'] = $passenger['NationalCode'];
                $d['passportCountry'] = $passenger['passportCountry'];
                $d['passportNumber'] = $passenger['passportNumber'];
                $d['passportExpire'] = $passenger['passportExpire'];

                // info hotel room
                $infoHotelRoom = parent::infoHotelRoom($_POST["hotelId"], $_POST["room_id" . $i], $infoHotel['start_date'], $infoHotel['end_date'], $_POST['flat_type' . $i]);

                $d['hotel_room_prices_id'] = $infoHotelRoom['hotel_room_prices_id'];
                $d['room_id'] = $_POST["room_id" . $i];
                $d['room_name'] = $infoHotelRoom['room_name'];
                $d['room_name_en'] = $infoHotelRoom['room_name_en'];
                $d['max_capacity_count_room'] = $infoHotelRoom['room_capacity'];
                $d['remaining_capacity'] = $infoHotelRoom['remaining_capacity'];
                $d['date_current'] = $infoHotelRoom['date_current'];
                $d['price_current'] = $infoHotelRoom['online_price_1night'];
                $d['room_price'] = $infoHotelRoom['online_price'];
                $d['room_online_price'] = $infoHotelRoom['online_price'];
                $d['room_bord_price'] = $infoHotelRoom['board_price'];

                $d['currency_code'] = $_POST['CurrencyCode'];
                $d['currency_equivalent'] = $_POST['CurrencyEquivalent'];


                switch ($_POST['flat_type' . $i]){
                    case 'DBL':
                        $flat_type = 'تخت اصلی';
                        $d['room_count'] = $expRoomCount[1];
                        break;
                    case 'EXT':
                        $d['room_count'] = $_POST['extraBed'];
                        $flat_type = 'تخت اضافه بزرگسال';
                        break;
                    case 'ECHD':
                        $d['room_count'] = $_POST['extraChildBed'];
                        $flat_type = 'تخت اضافه کودک';
                        break;
                    default:
                        $flat_type = '';
                        break;
                }

                $paymentPrice += $infoHotelRoom['online_price'];
                //echo Load::plog($d);

                $Model->setTable('book_hotel_local_tb');
                $res[] = $Model->insertLocal($d);

                $ModelBase->setTable('report_hotel_tb');
                $d['client_id'] = CLIENT_ID;
                $res[] = $ModelBase->insertLocal($d);


                $description .= ' رزرو ' . $flat_type . ' اتاق: ' . $infoHotelRoom['room_name'] . '، مسافر ' . $passenger['name'] . ' ' . $passenger['family'];
            }

            $i++;
        }

        $description .= ' در هتل: ' . $infoHotel['hotel_name'];


        if (in_array('0', $res)){
            $this->error = 'خطا در  تغییرات';
        }else{

            if ($_POST['typeBed']=='room'){
                foreach ($editRoomCount as $count){
                    $dataCount['room_count'] = $count['room_count'];
                    $Condition = "factor_number='{$_POST["factorNumber"]}' AND room_id='{$count['room_id']}' ";
                    $Model->setTable("book_hotel_local_tb");
                    $resPrice[] = $Model->update($dataCount, $Condition);
                    $ModelBase->setTable("report_hotel_tb");
                    $resPrice[] = $ModelBase->update($dataCount, $Condition);
                }
            }


            $this->paymentPrice = $paymentPrice;
            $total_price['total_price'] = $paymentPrice;

            $Condition = "factor_number='{$_POST["factorNumber"]}' ";
            $Model->setTable("book_hotel_local_tb");
            $resPrice[] = $Model->update($total_price, $Condition);

            $ModelBase->setTable("report_hotel_tb");
            $resPrice[] = $ModelBase->update($total_price, $Condition);

            if (in_array('0', $resPrice)){
                $this->error = 'خطا در  تغییرات';
            }elseif (empty($book_check)){
                $date['fk_factor_number'] = $_POST["factorNumber"];
                $date['description'] = $description;
                $date['creation_date'] =  Date('Y-m-d H:i:s');

                $Model->setTable("reservation_edit_hotel_booking_tb");
                $resEdit = $Model->insertLocal($date);
                if ($resEdit) {
                    $this->error = 'تغییرات با موفقیت انجام شد';
                } else {
                    $this->error = 'خطا در  تغییرات';
                }
            }

        }




    }

    public function getPassengersHotel()
    {
        /*echo 'getPassengersHotel <hr>';
        echo Load::plog($_POST);
        die();*/

        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $sql_temprory_hotel = " SELECT * FROM book_hotel_local_tb WHERE factor_number ='{$_POST['factorNumber']}' ORDER BY room_id, flat_type ";
        $result_temprory_hotel = $Model->select($sql_temprory_hotel);

        if (empty($this->paymentPrice)){

            $this->paymentPrice = $result_temprory_hotel[0]['total_price'];
        }

        $AuxiliaryVariableRoom = $result_temprory_hotel[0]['room_id']; // Group by room
        $indexRoom = 0;
        $room_price = 0; $totalPrice = 0; $bed_price = 0;
        $ext = 0;
        foreach ($result_temprory_hotel as $k=>$hotel){

            //Group by room
            if ($AuxiliaryVariableRoom != $hotel['room_id']){

                $AuxiliaryVariableRoom = $hotel['room_id'];
                $indexRoom = 0; $room_price = 0; $bed_price = 0; $ext = 0;
            }

            //info hotel
            if ($k==0){

                $this->temproryHotel['factor_number'] = $hotel['factor_number'];
                $this->temproryHotel['passenger_leader_tell'] = $hotel['passenger_leader_room'];
                $this->temproryHotel['passenger_leader_fullName'] = $hotel['passenger_leader_room_fullName'];
                $this->temproryHotel['city_name'] = $hotel['city_name'];
                $this->temproryHotel['hotel_id'] = $hotel['hotel_id'];
                $this->temproryHotel['hotel_name'] = $hotel['hotel_name'];
                $this->temproryHotel['hotel_address'] = $hotel['hotel_address'];
                $this->temproryHotel['hotel_starCode'] = $hotel['hotel_starCode'];
                $this->temproryHotel['start_date'] = $hotel['start_date'];
                $this->temproryHotel['end_date'] = $hotel['end_date'];
                $this->temproryHotel['number_night'] = $hotel['number_night'];
                $this->temproryHotel['type_application'] = $hotel['type_application'];
                $this->temproryHotel['hotel_rules'] = $hotel['hotel_rules'];
                $this->temproryHotel['hotel_pictures'] = $hotel['type_application']=='api' ? "{$hotel['hotel_pictures']}" : "pic/{$hotel['hotel_pictures']}" ;

                $indexRoom = 0; $room_price = 0; $bed_price = 0; $ext = 0;

            }

            //info passenger
            $this->temproryHotel['passenger'][$k]['passenger_name'] = $hotel['passenger_name'];
            $this->temproryHotel['passenger'][$k]['passenger_family'] = $hotel['passenger_family'];
            $this->temproryHotel['passenger'][$k]['passenger_name_en'] = $hotel['passenger_name_en'];
            $this->temproryHotel['passenger'][$k]['passenger_family_en'] = $hotel['passenger_family_en'];
            $this->temproryHotel['passenger'][$k]['passenger_birthday'] = $hotel['passenger_birthday'];
            $this->temproryHotel['passenger'][$k]['passenger_birthday_en'] = $hotel['passenger_birthday_en'];
            $this->temproryHotel['passenger'][$k]['passenger_national_code'] = $hotel['passenger_national_code'];
            $this->temproryHotel['passenger'][$k]['passportNumber'] = $hotel['passportNumber'];
            $this->temproryHotel['passenger'][$k]['room_price'] = $hotel['room_price'];

            switch ($hotel['flat_type']) {
                case 'DBL':
                    $room_price += $hotel['room_price'] * $hotel['room_count'];
                    $this->temproryHotel['passenger'][$k]['title_flat_type'] = 'تخت اصلی اتاق';
                    break;
                case 'EXT':
                    $room_price += $hotel['room_price'];
                    $totalPrice += $bed_price += $hotel['room_price'];
                    $this->temproryHotel['passenger'][$k]['title_flat_type'] = 'تخت اضافه بزرگسال';
                    $ext++;
                    break;
                case 'ECHD':
                    $room_price += $hotel['room_price'];
                    $totalPrice += $bed_price += $hotel['room_price'];
                    $this->temproryHotel['passenger'][$k]['title_flat_type'] = 'تخت اضافه کودک';
                    $ext++;
                    break;
                default:
                    $this->temproryHotel['passenger'][$k]['title_flat_type'] = '';
            }

            //info room
            if ($indexRoom==0){

                $this->temproryHotel['room'][$hotel['room_id']]['room_name'] = $hotel['room_name'];
                $this->temproryHotel['room'][$hotel['room_id']]['max_capacity_count_room'] = $hotel['max_capacity_count_room'];
                $this->temproryHotel['room'][$hotel['room_id']]['room_count'] = $hotel['room_count'];
                $this->temproryHotel['room'][$hotel['room_id']]['price_current'] = $hotel['price_current'];
                $this->temproryHotel['room'][$hotel['room_id']]['room_price'] = $room_price;

                $totalPrice += $room_price;

            }

            $this->temproryHotel['room'][$hotel['room_id']]['flat_ext_count'] = $ext;



            $indexRoom++;
        }


    }

    public function CreditCustomer()
    {
        $Model = Load::library('Model');

        if ($this->IsLogin) {

            $SqlMember = "SELECT * FROM members_tb WHERE id='{$_SESSION["userId"]}'";
            $member = $Model->load($SqlMember);
            $agencyID = $member['fk_agency_id'];

            $sql_charge = "SELECT sum(credit) AS total_charge FROM credit_detail_tb WHERE type='increase' AND fk_agency_id='{$agencyID}'";
            $charge = $Model->load($sql_charge);
            $total_charge = $charge['total_charge'];

            $sql_buy = "SELECT sum(credit) AS total_buy FROM credit_detail_tb WHERE type='decrease' AND fk_agency_id='{$agencyID}'";
            $buy = $Model->load($sql_buy);
            $total_buy = $buy['total_buy'];

            $total_transaction = $total_charge - $total_buy;
            return $total_transaction;
        }
    }
}