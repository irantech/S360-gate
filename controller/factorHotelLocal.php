<?php
/**
 * Class factorHotelLocal
 * @property factorHotelLocal $factorHotelLocal
 */


class factorHotelLocal extends apiHotelLocal
{
    public $adultArr = array();
    public $IsLogin ;
    public $count_basket ;
    public $city ;
    public $numberNight ;
    public $startDate ;
    public $paymentPrice ;
    public $paymentPriceOneDayTour ;
    public $counterTypeId = '';
    public $counterName = '';
    public $counterId = '';
    public $serviceDiscount = array();
    public $error = false;
    public $errorMessage = '';


    public function __construct()
    {
        $this->IsLogin = Session::IsLogin();
        if ($this->IsLogin){
            $this->counterId = functions::getCounterTypeId($_SESSION['userId']);
            $this->serviceDiscount['api'] = functions::ServiceDiscount($this->counterId, 'PublicLocalHotel');
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

    public function registerPassengersHotel($formData = null)
    {
        if (!empty($formData)){
            $_POST = $formData;
            $_POST['passenger_leader_room'] = $_POST['Mobile'];
        }
        $this->IsLogin = Session::IsLogin();

        $factorNumber = $_POST['factorNumber'];
        $typeApplication = $_POST['typeApplication'];
        $IdMember = $_POST['idMember'];

        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $passengerController = Load::controller('passengers');

        $objClientAuth = Load::library('clientAuth');
        $objClientAuth->apiHotelAuth();
        $sourceId = $objClientAuth->sourceId;
        //$sourceId = '6';
        $serviceTitle = functions::TypeServiceHotel($typeApplication);
        $irantechCommission = Load::controller('irantechCommission');
        $it_commission = $irantechCommission->getCommission($serviceTitle, $sourceId);

        $errorResult = [];
        $i = 1;
        while (isset($_POST["genderA" . $i])) {

            if (!empty($formData)){
                $_POST['birthdayA' . $i] = $formData['YearJalaliA' . $i] . '-' . $formData['MonthJalaliA' . $i] . '-' . $formData['DayJalaliA' . $i];
                $_POST['birthdayEnA' . $i] = $formData['YearMiladiA' . $i] . '-' . $formData['MonthMiladiA' . $i] . '-' . $formData['DayMiladiA' . $i];
            }

            $sql_check_temprory = "
                SELECT
                    type_of_price_change,
                    agency_commission_price_type,
                    SUM( agency_commission ) AS agency_commission_sum,
                    SUM( price_online_current ) AS price_online_current_sum,
                    SUM( price_board_current ) AS price_board_current_sum,
                    SUM( price_current ) AS price_current_sum,
                    SUM( price_foreign_current ) AS price_foreign_current_sum 
                FROM
                    temprory_hotel_local_tb 
                WHERE
                    factor_number = '{$_POST['factorNumber']}' 
                    AND room_id = '{$_POST['Id_Select_Room' . $i]}'
                            ";

            error_log($sql_check_temprory,3,LOGS_DIR.'sqlTest.txt');
            $price_room = $Model->load($sql_check_temprory);
            if (!empty($price_room) && $price_room['price_current_sum'] > 0 && $price_room['price_online_current_sum'] > 0){

                $this->adultArr[$i]['gender'] = $_POST["genderA" . $i];
                $this->adultArr[$i]['name_en'] = $_POST["nameEnA" . $i];
                $this->adultArr[$i]['family_en'] = $_POST["familyEnA" . $i];
                $this->adultArr[$i]['name'] = $_POST["nameFaA" . $i];
                $this->adultArr[$i]['family'] = $_POST["familyFaA" . $i];
                $this->adultArr[$i]['NationalCode'] = $_POST["NationalCodeA" . $i];
                $this->adultArr[$i]['fk_members_tb_id'] = $_POST["idMember"];
                $this->adultArr[$i]['passportCountry'] = $_POST["passportCountryA" . $i];
                $this->adultArr[$i]['passportNumber'] = $_POST["passportNumberA" . $i];
                $this->adultArr[$i]['passportExpire'] = $_POST["passportExpireA" . $i];
                $this->adultArr[$i]['passenger_leader_room'] = $_POST["passenger_leader_room"];
                $this->adultArr[$i]['passenger_leader_room_fullName'] = $_POST["passenger_leader_room_fullName"];
                $this->adultArr[$i]['passenger_leader_room_email'] = $_POST["passenger_leader_room_email"];
                $this->adultArr[$i]['passenger_leader_room_postalcode'] = $_POST["passenger_leader_room_postalcode"];
                $this->adultArr[$i]['passenger_leader_room_address'] = $_POST["passenger_leader_room_address"];
                $this->adultArr[$i]['BedType'] = $_POST["BedType" . $i];
                $this->adultArr[$i]['Id_Select_Room'] = $_POST["Id_Select_Room" . $i];

                if (isset($_POST["timeEnteringRoom" . $i])) {
                    $this->adultArr[$i]['time_entering_room'] = $_POST["timeEnteringRoom" . $i];
                }

                $this->adultArr[$i]['room_price'] = $price_room['price_current_sum'];
                $this->adultArr[$i]['room_bord_price'] = $price_room['price_board_current_sum'];
                $this->adultArr[$i]['room_online_price'] = $price_room['price_online_current_sum'];

                if ($_POST["passengerNationalityA" . $i] == '0') {
                    $this->adultArr[$i]['birthday_fa'] = $_POST["birthdayA" . $i];
                    $this->adultArr[$i]['birthday'] = '';

                } else{
                    $this->adultArr[$i]['birthday_fa'] = '';
                    $this->adultArr[$i]['birthday'] = $_POST["birthdayEnA" . $i];
                }

                $this->adultArr[$i]['agency_commission'] = $price_room['agency_commission_sum'];
                $this->adultArr[$i]['agency_commission_price_type'] = $price_room['agency_commission_price_type'];
                $this->adultArr[$i]['type_of_price_change'] = $price_room['type_of_price_change'];

                if ($this->IsLogin) {
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

                if(ISCURRENCY && $_POST['CurrencyCode'] > 0){
                    $Currency = Load::controller('currencyEquivalent');
                    $InfoCurrency = $Currency->InfoCurrency($_POST['CurrencyCode']);
                }

                $this->adultArr[$i]['currency_code'] = $_POST['CurrencyCode'];
                $this->adultArr[$i]['currency_equivalent'] = !empty($InfoCurrency) ? $InfoCurrency['EqAmount'] : '0';

                parent::FirstBookHotel($this->adultArr[$i], $IdMember, $factorNumber, $typeApplication, $it_commission);

            } else {
                $errorResult [] = 0;
            }



            $i++;
        }

        if (in_array('0', $errorResult)){
            $this->error = true;
            $this->errorMessage = 'کاربر گرامی متاسفانه در روند رزرو مشکلی پیش آمده است. لطفا مجددا تلاش کنید.';
        }

    }

    public function getPassengersHotel($formData = null)
    {
        if (!empty($formData)){
            $_POST = $formData;
        }

        $this->city = $_POST['idCity_Reserve'];
        $this->numberNight = $_POST['Nights_Reserve'];
        $this->startDate = $_POST['StartDate_Reserve'];

        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $sql_temprory_hotel = " SELECT * FROM book_hotel_local_tb 
                                WHERE 
                                    factor_number ='{$_POST['factorNumber']}' 
                                ORDER BY 
                                    room_id, flat_type ";
        $result_temprory_hotel = $Model->select($sql_temprory_hotel);


        $sql_hotel = "
                    SELECT * from reservation_hotel_tb
                    where id = '{$result_temprory_hotel[0]['hotel_id']}'
                ";
        $reservation_hotel = $Model->load($sql_hotel);

        $AuxiliaryVariableRoom = $result_temprory_hotel[0]['room_id']; // Group by room
        $indexRoom = 0;
        $room_price = 0;
        $room_price_api = 0;
        $totalPrice = 0;
        $totalPriceApi = 0;
        $bed_price = 0;
        $ext = 0;
        if($reservation_hotel['user_id']) {
            $start_date  = str_replace('-' , '/' ,$result_temprory_hotel[0]['start_date']) ;
            $priceChanges = functions::getMarketHotelPriceChange($reservation_hotel['id'] , $this->counterId,  $start_date,'marketplaceHotel' );
            $discount_hotel = functions::marketServiceDiscount($this->counterId,'marketplaceHotel' , $reservation_hotel['id']);
        }


        foreach ($result_temprory_hotel as $k=>$hotel){

            //Group by room
            if ($AuxiliaryVariableRoom != $hotel['room_id']){

                $AuxiliaryVariableRoom = $hotel['room_id'];
                $indexRoom = 0;
                $room_price = 0;
                $bed_price = 0;
                $ext = 0;
            }


            //info hotel
            if ($k==0){


                $this->temproryHotel['factor_number'] = $hotel['factor_number'];
                $this->temproryHotel['passenger_leader_tell'] = $hotel['passenger_leader_room'];
                $this->temproryHotel['passenger_leader_fullName'] = $hotel['passenger_leader_room_fullName'];
                $this->temproryHotel['passenger_leader_room_email'] = $hotel['passenger_leader_room_email'];
                $this->temproryHotel['passenger_leader_room_postalcode'] = $hotel['passenger_leader_room_postalcode'];
                $this->temproryHotel['passenger_leader_room_address'] = $hotel['passenger_leader_room_address'];

                $this->temproryHotel['city_name'] = $hotel['city_name'];
                $this->temproryHotel['hotel_id'] = $hotel['hotel_id'];
                $this->temproryHotel['hotel_name'] = $hotel['hotel_name'];
                $this->temproryHotel['hotel_address'] = $hotel['hotel_address'];
                $this->temproryHotel['hotel_starCode'] = $hotel['hotel_starCode'];
                $this->temproryHotel['prepayment_percentage'] = $_POST['prepaymentPercentage'];
                $this->temproryHotel['hotel_payments_price'] = $hotel['hotel_payments_price'];
                if (SOFTWARE_LANG == 'en' || SOFTWARE_LANG == 'ar'){
                    $this->temproryHotel['start_date'] = functions::ConvertToMiladi($hotel['start_date']);
                    $this->temproryHotel['end_date'] = functions::ConvertToMiladi($hotel['end_date']);
                } else {
                    $this->temproryHotel['start_date'] = $hotel['start_date'];
                    $this->temproryHotel['end_date'] = $hotel['end_date'];
                }
                $this->temproryHotel['number_night'] = $hotel['number_night'];
                $this->temproryHotel['type_application'] = $hotel['type_application'];
                $this->temproryHotel['hotel_rules'] = $hotel['hotel_rules'];
                $this->temproryHotel['hotel_pictures'] = ($hotel['type_application']=='api' || $hotel['type_application']=='api_app') ? "{$hotel['hotel_pictures']}" : ROOT_ADDRESS_WITHOUT_LANG."/pic/{$hotel['hotel_pictures']}" ;

                $indexRoom = 0; $room_price = 0; $room_price_api = 0; $bed_price = 0; $ext = 0;

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
            if($reservation_hotel['user_id']) {
                $this->temproryHotel['passenger'][$k]['room_price'] = $hotel['room_price'] = functions::calculateHotelPrice($priceChanges,$discount_hotel,$hotel['room_price'], true);
            }else{
                $this->temproryHotel['passenger'][$k]['room_price'] = $hotel['room_price'];
            }

            $this->temproryHotel['passenger'][$k]['room_name'] = $hotel['room_name'];
            $this->temproryHotel['passenger'][$k]['room_id'] = $hotel['room_id'];

            //api or reservation
            if ($hotel['type_application']=='api' || $hotel['type_application']=='api_app'){

                $this->temproryHotel['passenger'][$k]['title_flat_type'] = functions::Xmlinformation('HeadOfRoom');

                $room_price_api = $hotel['room_price'] * $hotel['room_count'];

                if ($hotel['type_of_price_change'] == 'increase' && $hotel['agency_commission_price_type'] == 'cost') {
                    $room_price = ($hotel['room_price'] + $hotel['agency_commission']) * $hotel['room_count'];

                } elseif ($hotel['type_of_price_change'] == 'decrease' && $hotel['agency_commission_price_type'] == 'cost') {
                    $room_price = ($hotel['room_price'] - $hotel['agency_commission']) * $hotel['room_count'];

                } elseif ($hotel['type_of_price_change'] == 'increase' && $hotel['agency_commission_price_type'] == 'percent') {
                    $room_price = (($hotel['room_price'] * $hotel['agency_commission'] / 100) + $hotel['room_price']) * $hotel['room_count'];

                } elseif ($hotel['type_of_price_change'] == 'decrease' && $hotel['agency_commission_price_type'] == 'percent') {
                    $room_price = (($hotel['room_price'] * $hotel['agency_commission'] / 100) - $hotel['room_price']) * $hotel['room_count'];

                } else {
                    $room_price = $hotel['room_price'] * $hotel['room_count'];
                }


                if (!empty($this->serviceDiscount['api']) && $this->serviceDiscount['api']['off_percent']>0){
                    $room_price = $room_price - (($room_price * $this->serviceDiscount['api']['off_percent']) / 100);
                }


            }else {

                switch ($hotel['flat_type']) {
                    case 'DBL':
                        $room_price += $hotel['room_price'] * $hotel['room_count'];
                        $this->temproryHotel['passenger'][$k]['title_flat_type'] = functions::Xmlinformation("BaseBedForRomm");
                        break;
                    case 'EXT':
                        $room_price += $hotel['room_price'];
                        $totalPrice += $bed_price += $hotel['room_price'];
                        $this->temproryHotel['passenger'][$k]['title_flat_type'] = functions::Xmlinformation("ExtrabedAdult");
                        $ext++;
                        break;
                    case 'ECHD':
                        $room_price += $hotel['room_price'];
                        $totalPrice += $bed_price += $hotel['room_price'];
                        $this->temproryHotel['passenger'][$k]['title_flat_type'] = functions::Xmlinformation("Extrabedchild");
                        $ext++;
                        break;
                    default:
                        $this->temproryHotel['passenger'][$k]['title_flat_type'] = '';
                }


            }

            //info room
            if ($indexRoom==0){

                if ($hotel['type_application']=='api' || $hotel['type_application']=='api_app'){
                    $price_current = $hotel['price_current'];
                    if (!empty($this->serviceDiscount['api']) && $this->serviceDiscount['api']['off_percent']>0){
                        $price_current = $price_current - (($price_current * $this->serviceDiscount['api']['off_percent']) / 100);
                    }
                }else {
                    $price_current = $hotel['price_current'];
                }

                // ======= دریافت اطلاعات وعده‌ها از جدول قیمت اتاق =======
                $hotelId = $hotel['hotel_id'];
                $roomId  = $hotel['room_id'];
                $startDate = $hotel['start_date'];
                $endDate   = $hotel['end_date'];

                $startDateSql = str_replace(['-', '/'], '', $startDate);
                $endDateSql   = str_replace(['-', '/'], '', $endDate);
                $sql_meal = "
                        SELECT
                            RP.breakfast, RP.lunch, RP.dinner
                        FROM 
                            reservation_hotel_room_prices_tb RP 
                        WHERE 
                            RP.id_hotel='{$hotelId}' AND
                            RP.id_room='{$roomId}' AND
                            RP.is_del='no' AND
                            RP.user_type='{$this->counterId}' AND
                            RP.date>='{$startDateSql}' AND RP.date<'{$endDateSql}'
                        GROUP BY RP.date
                    ";
                    $ResultHotelRoom = $Model->select($sql_meal);

                    // اگر داده‌ای بود، بررسی کنیم آیا در هیچ روزی yes داریم یا نه
                    $hasBreakfast = $hasLunch = $hasDinner = 'no';
                    if (!empty($ResultHotelRoom)) {
                        foreach ($ResultHotelRoom as $meal) {
                            if ($meal['breakfast'] == 'yes') $hasBreakfast = 'yes';
                            if ($meal['lunch'] == 'yes') $hasLunch = 'yes';
                            if ($meal['dinner'] == 'yes') $hasDinner = 'yes';
                        }
                    }


                $this->temproryHotel['room'][$hotel['room_id']]['room_name'] = $hotel['room_name'];
                $this->temproryHotel['room'][$hotel['room_id']]['max_capacity_count_room'] = $hotel['max_capacity_count_room'];
                $this->temproryHotel['room'][$hotel['room_id']]['room_count'] = $hotel['room_count'];
                $this->temproryHotel['room'][$hotel['room_id']]['price_current'] = $price_current;
                $this->temproryHotel['room'][$hotel['room_id']]['child_room_count'] = $hotel['child_count'];
                $this->temproryHotel['room'][$hotel['room_id']]['child_room_price'] = $hotel['child_price'];
                $this->temproryHotel['room'][$hotel['room_id']]['extra_bed_count'] = $hotel['extra_bed_count'];
                $this->temproryHotel['room'][$hotel['room_id']]['extra_bed_price'] = $hotel['extra_bed_price'];
                $this->temproryHotel['room'][$hotel['room_id']]['room_price'] = $room_price;
                $this->temproryHotel['room'][$hotel['room_id']]['Breakfast'] = $hasBreakfast;
                $this->temproryHotel['room'][$hotel['room_id']]['Lunch'] = $hasLunch;
                $this->temproryHotel['room'][$hotel['room_id']]['Dinner'] = $hasDinner;
                $totalPrice += $room_price;
                $totalPriceApi += $room_price_api;
            }
            $this->temproryHotel['room'][$hotel['room_id']]['flat_ext_count'] = $ext;
            $indexRoom++;
        }

        if ($hotel['type_application']=='api' || $hotel['type_application']=='api_app'){
            $this->paymentPrice = $totalPrice;

            // payment price hotel
            $d['total_price'] = $totalPrice;
            $d['total_price_api'] = $totalPriceApi;

            $Condition = "factor_number='{$_POST['factorNumber']}' ";
            $Model->setTable("book_hotel_local_tb");
            $Model->update($d, $Condition);

            $ModelBase->setTable("report_hotel_tb");
            $ModelBase->update($d, $Condition);
        } else {
            $this->paymentPrice = round($result_temprory_hotel[0]['total_price']);
        }
    }
    public function prePaymentCalculate( $price, $pre_payment_percentage )  {
//        var_dump($price);
//die;
        return (( $price * $pre_payment_percentage ) / 100);
    }

    public function registerPassengersReservationHotel($formData = null)
    {

        if (!empty($formData)){
            $_POST = $formData;
            $_POST['passenger_leader_room'] = $_POST['Mobile'];
        }


        $this->IsLogin = Session::IsLogin();

        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $passengerController = Load::controller('passengers');

        $factorNumber = $_POST["factorNumber"];
        $IdMember = $_POST['idMember'];
        $typeApplication = $_POST['typeApplication'];

        if (isset($_POST['resumeReserve']) && $_POST['resumeReserve']) {
            $isResumeRequest = true;
            $factorNumber = filter_var($_POST['factorNumber'], FILTER_SANITIZE_STRING);
            $idMember = filter_var($_POST['oldIdMember'], FILTER_SANITIZE_STRING);


        } else {
            $isResumeRequest = false;
            $factorNumber = filter_var($_POST['factorNumber'], FILTER_SANITIZE_STRING);
            $idMember = filter_var($_POST['idMember'], FILTER_SANITIZE_STRING);
        }


        // info hotel
        $resultInfoHotel = parent::infoHotel($_POST["Hotel_Reserve"]);

        $prepaymentPercentageValue = $this->prePaymentCalculate($_POST['TotalPrice_Reserve'], $resultInfoHotel['prepayment_percentage']);


        $objClientAuth = Load::library('clientAuth');
        $objClientAuth->reservationHotelAuth();
        $sourceId = $objClientAuth->sourceId;
        //$sourceId = '5';
        $isExternal = '';
        if ($resultInfoHotel['countryId'] != 1) {
            $isExternal = 'yes';
        }
        $serviceTitle = functions::TypeServiceHotel($typeApplication, $isExternal);
        $irantechCommission = Load::controller('irantechCommission');
        $it_commission = $irantechCommission->getCommission($serviceTitle, $sourceId);

        // تشکیل آرایه با اندیس کد اتاق و مقدار تعداد اتاق انتخاب شده
        $countRoom = array();
        $exp_RoomTypeCodes = explode(",", $_POST['RoomTypeCodes_Reserve']);
        $exp_NumberOfRooms = explode(",", $_POST['NumberOfRooms_Reserve']);

        for($c=0; $c<count($exp_RoomTypeCodes); $c++){
            if ($exp_NumberOfRooms[$c] != ''){
                $countRoom[$exp_RoomTypeCodes[$c]] = $exp_NumberOfRooms[$c];
            }
        }

        $infoHotel['start_date'] = $_POST["StartDate_Reserve"];
        $infoHotel['end_date'] = $_POST["EndDate_Reserve"];
        $infoHotel['number_night'] = $_POST["Nights_Reserve"];
        $infoHotel['total_price'] = $_POST["TotalPrice_Reserve"];
      


        $infoHotel['city_id'] = $resultInfoHotel['city_id'];
        $infoHotel['city_name'] = $resultInfoHotel['city_name'];
        $infoHotel['hotel_id'] = $resultInfoHotel['hotel_id'];
        $infoHotel['hotel_name'] = $resultInfoHotel['hotel_name'];
        $infoHotel['hotel_name_en'] = (isset($resultInfoHotel['hotel_name_en']) && $resultInfoHotel['hotel_name_en'] != '') ? $resultInfoHotel['hotel_name_en'] : '';
        $infoHotel['hotel_address'] = $resultInfoHotel['address'];
        $infoHotel['hotel_logo'] = $resultInfoHotel['logo'];
        $infoHotel['hotel_address_en'] = '';
        $infoHotel['hotel_telNumber'] = $resultInfoHotel['tel_number'];
        $infoHotel['hotel_starCode'] = $resultInfoHotel['star_code'];
        $infoHotel['hotel_entryHour'] = $resultInfoHotel['entry_hour'];
        $infoHotel['hotel_leaveHour'] = $resultInfoHotel['leave_hour'];
        $infoHotel['hotel_pictures'] = $resultInfoHotel['logo'];
        $infoHotel['hotel_rules'] = $resultInfoHotel['cancellation_conditions'];

        // info transfer_went and transfer_back
        if (isset($_POST['isTransfer']) && $_POST['isTransfer'] == true){
            $infoHotel['isTransfer'] = $_POST['isTransfer'];
            $infoHotel['origin'] = $_POST['origin'];
            $infoHotel['flight_date_went'] = $_POST['flight_date_went'];
            $infoHotel['airline_went'] = $_POST['airline_went'];
            $infoHotel['flight_number_went'] = $_POST['flight_number_went'];
            $infoHotel['hour_went'] = $_POST['minutes_went'] . ':' . $_POST['hour_went'] ;
            $infoHotel['flight_date_back'] = $_POST['flight_date_back'];
            $infoHotel['airline_back'] = $_POST['airline_back'];
            $infoHotel['flight_number_back'] = $_POST['flight_number_back'];
            $infoHotel['hour_back'] = $_POST['minutes_back'] . ':' . $_POST['hour_back'] ;
        }

        $sql = " SELECT * FROM members_tb WHERE id='{$idMember}'";
        $user = $Model->load($sql);



        if(!$isResumeRequest){
            $infoHotel['member_id'] = $user['id'];
            $infoHotel['member_name'] = empty($user['name'])?$_POST['requestedMemberName']:$user['name'] . ' ' . $user['family'];
            $infoHotel['member_mobile'] = empty($user['mobile'])?$_POST['requestedMemberPhoneNumber']:$user['mobile'];
            $infoHotel['member_phone'] = $user['telephone'];
            $infoHotel['member_email'] = $user['email'];
        }
        $total_price_api = 0 ;
        $discount =  0;
        if($resultInfoHotel['user_id']){
            $res = functions::getMarketHotelPriceChange( $resultInfoHotel['hotel_id'] , $this->counterId, $_POST["StartDate_Reserve"], 'marketplaceHotel' );
            $discount_hotel = functions::marketServiceDiscount($this->counterId,'marketplaceHotel' , $resultInfoHotel['hotel_id']);
            $i = 1;
            while (isset($_POST["room_id" . $i])) {
                $resultInfoHotelRoom = parent::infoHotelRoom($_POST["Hotel_Reserve"], $_POST["room_id" . $i], $_POST["StartDate_Reserve"], $_POST["EndDate_Reserve"], $_POST['flat_type' . $i]);

                $this_hotel_calculate_price = functions::calculateHotelPrice($res,$discount_hotel, $resultInfoHotelRoom['board_price']);
                $total_price_api += $this_hotel_calculate_price['price_with_increase_change'] ;
                $discount = $this_hotel_calculate_price['discount_amount'];
                $i++;
            }
        }

        if( $resultInfoHotel['is_request'] == '1') {

            if(!$isResumeRequest){
                $i = 1;
                while (isset($_POST["room_id" . $i])) {

                    $this->adultArr[$i]['roommate'] = $_POST["roommate" . $i];
                    $this->adultArr[$i]['room_id'] = $_POST["room_id" . $i];
                    $this->adultArr[$i]['hotel_room_prices_id'] = $_POST["IdHotelRoomPrice" . $i];
                    $this->adultArr[$i]['flat_type'] = $_POST["flat_type" . $i];

                    // info hotel room
                    $resultInfoHotelRoom = parent::infoHotelRoom($_POST["Hotel_Reserve"], $_POST["room_id" . $i], $_POST["StartDate_Reserve"], $_POST["EndDate_Reserve"], $_POST['flat_type' . $i]);

                    $infoHotel['room_id'] = $resultInfoHotelRoom['room_id'];
                    $infoHotel['room_name'] = $resultInfoHotelRoom['room_name'];
                    $infoHotel['room_name_en'] = $resultInfoHotelRoom['room_name_en'];
                    $infoHotel['room_capacity'] = $resultInfoHotelRoom['room_capacity'];
                    $infoHotel['maximum_extra_beds'] = $resultInfoHotelRoom['maximum_extra_beds'];
                    $infoHotel['maximum_extra_chd_beds'] = $resultInfoHotelRoom['maximum_extra_chd_beds'];
                    $infoHotel['remaining_capacity'] = $resultInfoHotelRoom['remaining_capacity'];
                    $infoHotel['price_current'] = $resultInfoHotelRoom['online_price_1night'];
                    $infoHotel['date_current'] = $resultInfoHotelRoom['date_current'];
                    $infoHotel['extra_bed_count'] = $_POST["extraBedCount" . $i];
                    $infoHotel['child_count'] = $_POST["ExtraChildBedCount" . $i];
                    $infoHotel['extra_bed_price'] = $_POST["ExtChildBedCount" . $i];
                    $infoHotel['child_price'] = $_POST["extraChildBedPrice" . $i];
                    $infoHotel['services_discount'] = $discount;
                    $infoHotel['total_price_api'] = $total_price_api;

                    $IsLogin = Session::IsLogin();
                    if ($IsLogin || $_POST['guestUserStatus']=='yes'){
                        $infoHotel['room_price'] = $resultInfoHotelRoom['online_price'];
                        $infoHotel['room_online_price'] = $resultInfoHotelRoom['online_price'];
                        $infoHotel['room_bord_price'] = $resultInfoHotelRoom['board_price'];
                    }else {
                        $infoHotel['room_price'] = $resultInfoHotelRoom['board_price'];
                        $infoHotel['room_online_price'] = $resultInfoHotelRoom['board_price'];
                        $infoHotel['room_bord_price'] = $resultInfoHotelRoom['board_price'];
                    }

                    $infoHotel['room_count'] = $countRoom[$_POST["room_id" . $i]];
                    $infoHotel['max_capacity_count_room'] = '';

                    $infoHotel['agency_commission'] = '';
                    $infoHotel['agency_commission_price_type'] = '';
                    $infoHotel['type_of_price_change'] = '';

                    if(ISCURRENCY && $_POST['CurrencyCode'] > 0){
                        $Currency = Load::controller('currencyEquivalent');
                        $InfoCurrency = $Currency->InfoCurrency($_POST['CurrencyCode']);
                    }

                    $this->adultArr[$i]['currency_code'] = $_POST['CurrencyCode'];
                    $this->adultArr[$i]['currency_equivalent'] = !empty($InfoCurrency) ? $InfoCurrency['EqAmount'] : '0';

                    // insert in to book table
                    parent::firstBookReservationHotel($this->adultArr[$i], $IdMember, $factorNumber, $infoHotel, $typeApplication, $it_commission, $serviceTitle);
                    $i++;

                }
            }
            else{
                $i = 1;
                $sql = " SELECT * FROM book_hotel_local_tb WHERE factor_number = '{$factorNumber}' OR pnr = '{$factorNumber}' OR request_number = '$factorNumber' ";

                $bookHotel = $Model->select($sql);

                while (isset($_POST["nameEnA" . $i])) {

                    if (!empty($formData)){
                        $_POST['birthdayA' . $i] = $formData['YearJalaliA' . $i] . '-' . $formData['MonthJalaliA' . $i] . '-' . $formData['DayJalaliA' . $i];
                        $_POST['birthdayEnA' . $i] = $formData['YearMiladiA' . $i] . '-' . $formData['MonthMiladiA' . $i] . '-' . $formData['DayMiladiA' . $i];
                    }

                    $this->adultArr[$i]['gender'] = $_POST["genderA" . $i];
                    $this->adultArr[$i]['name'] = $_POST["nameFaA" . $i];
                    $this->adultArr[$i]['family'] = $_POST["familyFaA" . $i];
                    $this->adultArr[$i]['name_en'] = $_POST["nameEnA" . $i];
                    $this->adultArr[$i]['family_en'] = $_POST["familyEnA" . $i];
                    $this->adultArr[$i]['NationalCode'] = $_POST["NationalCodeA" . $i];
                    $this->adultArr[$i]['fk_members_tb_id'] = $_POST["IdMember"];
                    $this->adultArr[$i]['passportCountry'] = (isset($_POST["passportCountry" . $i]) && $_POST["passportCountry" . $i] != '') ? $_POST["passportCountry" . $i] : '';
                    $this->adultArr[$i]['passportNumber'] = (isset($_POST["passportNumber" . $i]) && $_POST["passportNumber" . $i] != '') ? $_POST["passportNumber" . $i] : '';
                    $this->adultArr[$i]['passportExpire'] = (isset($_POST["passportExpire" . $i]) && $_POST["passportExpire" . $i] != '') ? $_POST["passportExpire" . $i] : '';

                    if ($_POST["passengerNationalityA" . $i] == '0') {
                        $this->adultArr[$i]['birthday_fa'] = $_POST["birthdayA" . $i];
                        $this->adultArr[$i]['birthday'] = '';
                    } else{
                        $this->adultArr[$i]['birthday_fa'] = '';
                        $this->adultArr[$i]['birthday'] = $_POST["birthdayEnA" . $i];
                    }

                    $this->adultArr[$i]['passenger_leader_room'] = $_POST["passenger_leader_room"];
                    $this->adultArr[$i]['passenger_leader_room_fullName'] = $_POST["passenger_leader_room_fullName"];
                    $this->adultArr[$i]['passenger_leader_room_email'] = $_POST["passenger_leader_room_email"];
                    $this->adultArr[$i]['passenger_leader_room_postalcode'] = $_POST["passenger_leader_room_postalcode"];
                    $this->adultArr[$i]['passenger_leader_room_address'] = $_POST["passenger_leader_room_address"];

                    if ($this->IsLogin) {
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

                    // insert in to book table
                    parent::updateReservationHotelOnRequest($this->adultArr[$i], $IdMember, $factorNumber, $typeApplication  , $bookHotel[$i-1]['id']);

                    $i++;
                }
            }


        }else {

            $i = 1;
            while (isset($_POST["nameEnA" . $i])) {

                if (!empty($formData)){
                    $_POST['birthdayA' . $i] = $formData['YearJalaliA' . $i] . '-' . $formData['MonthJalaliA' . $i] . '-' . $formData['DayJalaliA' . $i];
                    $_POST['birthdayEnA' . $i] = $formData['YearMiladiA' . $i] . '-' . $formData['MonthMiladiA' . $i] . '-' . $formData['DayMiladiA' . $i];
                }

                $this->adultArr[$i]['gender'] = $_POST["genderA" . $i];
                $this->adultArr[$i]['name'] = $_POST["nameFaA" . $i];
                $this->adultArr[$i]['family'] = $_POST["familyFaA" . $i];
                $this->adultArr[$i]['name_en'] = $_POST["nameEnA" . $i];
                $this->adultArr[$i]['family_en'] = $_POST["familyEnA" . $i];
                $this->adultArr[$i]['NationalCode'] = $_POST["NationalCodeA" . $i];
                $this->adultArr[$i]['fk_members_tb_id'] = $_POST["IdMember"];
                $this->adultArr[$i]['passportCountry'] = (isset($_POST["passportCountry" . $i]) && $_POST["passportCountry" . $i] != '') ? $_POST["passportCountry" . $i] : '';
                $this->adultArr[$i]['passportNumber'] = (isset($_POST["passportNumber" . $i]) && $_POST["passportNumber" . $i] != '') ? $_POST["passportNumber" . $i] : '';
                $this->adultArr[$i]['passportExpire'] = (isset($_POST["passportExpire" . $i]) && $_POST["passportExpire" . $i] != '') ? $_POST["passportExpire" . $i] : '';

                if ($_POST["passengerNationalityA" . $i] == '0') {
                    $this->adultArr[$i]['birthday_fa'] = $_POST["birthdayA" . $i];
                    $this->adultArr[$i]['birthday'] = '';
                } else{
                    $this->adultArr[$i]['birthday_fa'] = '';
                    $this->adultArr[$i]['birthday'] = $_POST["birthdayEnA" . $i];
                }

                $this->adultArr[$i]['passenger_leader_room'] = $_POST["passenger_leader_room"];
                $this->adultArr[$i]['passenger_leader_room_fullName'] = $_POST["passenger_leader_room_fullName"];
                $this->adultArr[$i]['passenger_leader_room_email'] = $_POST["passenger_leader_room_email"];
                $this->adultArr[$i]['passenger_leader_room_postalcode'] = $_POST["passenger_leader_room_postalcode"];
                $this->adultArr[$i]['passenger_leader_room_address'] = $_POST["passenger_leader_room_address"];
                $this->adultArr[$i]['roommate'] = $_POST["roommate" . $i];
                $this->adultArr[$i]['room_id'] = $_POST["room_id" . $i];
                $this->adultArr[$i]['child_count'] = $_POST["ExtraChildBedCount" . $i];
                $this->adultArr[$i]['child_count'] = $_POST["extraBedCount" . $i];
                $this->adultArr[$i]['extra_bed_price'] = $_POST["ExtChildBedCount" . $i];
                $this->adultArr[$i]['hotel_room_prices_id'] = $_POST["IdHotelRoomPrice" . $i];
                $this->adultArr[$i]['flat_type'] = $_POST["flat_type" . $i];



                if ($this->IsLogin) {
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

                // info hotel room
                $resultInfoHotelRoom = parent::infoHotelRoom($_POST["Hotel_Reserve"], $_POST["room_id" . $i], $_POST["StartDate_Reserve"], $_POST["EndDate_Reserve"], $_POST['flat_type' . $i]);


                $infoHotel['room_id'] = $resultInfoHotelRoom['room_id'];
                $infoHotel['room_name'] = $resultInfoHotelRoom['room_name'];
                $infoHotel['room_name_en'] = $resultInfoHotelRoom['room_name_en'];
                $infoHotel['room_capacity'] = $resultInfoHotelRoom['room_capacity'];
                $infoHotel['maximum_extra_beds'] = $resultInfoHotelRoom['maximum_extra_beds'];
                $infoHotel['maximum_extra_chd_beds'] = $resultInfoHotelRoom['maximum_extra_chd_beds'];
                $infoHotel['remaining_capacity'] = $resultInfoHotelRoom['remaining_capacity'];
                $infoHotel['price_current'] = $resultInfoHotelRoom['online_price_1night'];
                $infoHotel['date_current'] = $resultInfoHotelRoom['date_current'];
                //$infoHotel['extra_bed_count'] = $_POST["extraBedCount" . $i];
                // $infoHotel['child_count'] = $_POST["ExtraChildBedCount" . $i];
                //$infoHotel['extra_bed_price'] = $_POST["ExtChildBedCount" . $i];
                //$infoHotel['child_price'] = $_POST["extraChildBedPrice" . $i];
                $infoHotel['extra_bed_count'] = isset($_POST["ExtBedCount{$_POST["room_id" . $i]}"]) ? $_POST["ExtBedCount{$_POST["room_id" . $i]}"] : 0;
                $infoHotel['extra_bed_price'] = isset($_POST["ExtBedPricePerUnit{$_POST["room_id" . $i]}"]) ? $_POST["ExtBedPricePerUnit{$_POST["room_id" . $i]}"] : 0;
                $infoHotel['child_count'] = isset($_POST["ExtraChildBedCount{$_POST["room_id" . $i]}"]) ? $_POST["ExtraChildBedCount{$_POST["room_id" . $i]}"] : 0;
                $infoHotel['child_price'] = isset($_POST["ExtraChildBedPricePerUnit{$_POST["room_id" . $i]}"]) ? $_POST["ExtraChildBedPricePerUnit{$_POST["room_id" . $i]}"] : 0;

                $infoHotel['hotel_payments_price'] = $prepaymentPercentageValue;
                $infoHotel['prepayment_percentage'] = $resultInfoHotel['prepayment_percentage'];
                $infoHotel['services_discount'] = $discount;
                $infoHotel['total_price_api'] = $total_price_api;

                $IsLogin = Session::IsLogin();
                if ($IsLogin || $_POST['guestUserStatus']=='yes'){
                    $infoHotel['room_price'] = $resultInfoHotelRoom['online_price'];
                    $infoHotel['room_online_price'] = $resultInfoHotelRoom['online_price'];
                    $infoHotel['room_bord_price'] = $resultInfoHotelRoom['board_price'];
                }else {
                    $infoHotel['room_price'] = $resultInfoHotelRoom['board_price'];
                    $infoHotel['room_online_price'] = $resultInfoHotelRoom['board_price'];
                    $infoHotel['room_bord_price'] = $resultInfoHotelRoom['board_price'];
                }

                $infoHotel['room_count'] = $countRoom[$_POST["room_id" . $i]];
                $infoHotel['max_capacity_count_room'] = '';

                $infoHotel['agency_commission'] = '';
                $infoHotel['agency_commission_price_type'] = '';
                $infoHotel['type_of_price_change'] = '';

                if(ISCURRENCY && $_POST['CurrencyCode'] > 0){
                    $Currency = Load::controller('currencyEquivalent');
                    $InfoCurrency = $Currency->InfoCurrency($_POST['CurrencyCode']);
                }

                $this->adultArr[$i]['currency_code'] = $_POST['CurrencyCode'];
                $this->adultArr[$i]['currency_equivalent'] = !empty($InfoCurrency) ? $InfoCurrency['EqAmount'] : '0';

                // insert in to book table
                parent::firstBookReservationHotel($this->adultArr[$i], $IdMember, $factorNumber, $infoHotel, $typeApplication, $it_commission, $serviceTitle);

                $i++;
            }
        }



        // ثبت درخواست تور یک روزه
        $amountR = 0; $amountA = 0;
        if (isset($_POST['isOneDayTour']) && $_POST['isOneDayTour'] == True){
            for($ii=1;$ii<=$_POST['countOneDayTour'];$ii++){

                if ($_POST['adtNumR'.$ii] > 0){

                    $sql_check = " SELECT id FROM reservation_book_one_day_tour_tb WHERE fk_factor_number ='{$factorNumber}' AND fk_id_one_day_tour ='{$_POST['idOneDayTour'.$ii]}' ";
                    $book_check = $Model->load($sql_check);

                    if (empty($book_check)){

                        $OneDayTour['fk_factor_number'] = $factorNumber;
                        $OneDayTour['fk_id_one_day_tour '] = $_POST['idOneDayTour'.$ii];
                        $OneDayTour['num_adt_r'] = $_POST['adtNumR'.$ii];
                        $OneDayTour['num_chd_r'] = $_POST['chdNumR'.$ii];
                        $OneDayTour['num_inf_r'] = $_POST['infNumR'.$ii];
                        $OneDayTour['num_adt_a'] = '0';
                        $OneDayTour['num_chd_a'] = '0';
                        $OneDayTour['num_inf_a'] = '0';
                        /*$OneDayTour['num_adt_a'] = $_POST['adtNumA'.$ii];
                        $OneDayTour['num_chd_a'] = $_POST['chdNumA'.$ii];
                        $OneDayTour['num_inf_a'] = $_POST['infNumA'.$ii];*/

                        $Model->setTable('reservation_book_one_day_tour_tb');
                        $Model->insertLocal($OneDayTour);
                    }

                    $amountR = $amountR + ($_POST['adtNumR'.$ii]*$_POST['adtPriceR'.$ii]);
                    if (isset($_POST['chdNumR'.$ii])){$amountR = $amountR + ($_POST['chdNumR'.$ii]*$_POST['chdPriceR'.$ii]);}
                    if (isset($_POST['infNumRs'.$ii])){$amountR = $amountR + ($_POST['infNumR'.$ii]*$_POST['infPriceR'.$ii]);}
                    //$amountA = $amountA + ($_POST['adtNumA'.$ii]*$_POST['adtPriceA'.$ii])+($_POST['chdNumA'.$ii]*$_POST['chdPriceA'.$ii])+($_POST['infNumA'.$ii]*$_POST['infPriceA'.$ii]);

                }

            }
        }



        $this->paymentPriceOneDayTour = $amountR;
        //$this->paymentPrice = $this->paymentPrice + $amountR;
        // payment price hotel
        $total_price['total_price'] = $_POST["TotalPrice_Reserve"] + $amountR;
        if(!$isResumeRequest && $resultInfoHotel['is_request'] == '1') {
            $total_price['status'] = 'OnRequest';
        }

        $Condition = "factor_number='{$factorNumber}' ";
        $Model->setTable("book_hotel_local_tb");
        $Model->update($total_price, $Condition);

        $ModelBase->setTable("report_hotel_tb");
        $ModelBase->update($total_price, $Condition);



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