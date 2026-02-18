<?php
/**
 * Class factorExternalHotel
 * @property factorExternalHotel $factorExternalHotel
 */
class factorExternalHotel extends apiExternalHotel
{
    public $IsLogin;
    public $counterId;
    public $serviceDiscount = array();
    public $error;
    public $errorMessage;
    public $passengers;
    public $paymentPrice;


    public function __construct()
    {
        $this->IsLogin = Session::IsLogin();
        if ($this->IsLogin) {
            $this->counterId = functions::getCounterTypeId($_SESSION['userId']);
            $this->serviceDiscount['externalApi'] = functions::ServiceDiscount($this->counterId, 'PublicPortalHotel');
        }
    }


    public function registerPassengersHotel()
    {

        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $objExternalHotel = Load::controller('resultExternalHotel');
        $passengerController = Load::controller('passengers');

        $factorNumber = $_POST['factorNumber'];
        $typeApplication = $_POST['typeApplication'];
        $idMember = $_POST['idMember'];

        $i = 1;
        while (isset($_POST["genderA" . $i])) {

            $passengers[$i]['factor_number'] = $factorNumber;
            $passengers[$i]['passenger_gender'] = $_POST["genderA" . $i];
            $passengers[$i]['passenger_name'] = $_POST["nameFaA" . $i];
            $passengers[$i]['passenger_name_en'] = $_POST["nameEnA" . $i];
            $passengers[$i]['passenger_family'] = $_POST["familyFaA" . $i];
            $passengers[$i]['passenger_family_en'] = $_POST["familyEnA" . $i];
            if ($_POST['passengerAge' . $i] == 'Adt') {
                $passengers[$i]['passenger_birthday'] = $_POST["birthdayA" . $i];
            } else {
                $passengers[$i]['passenger_birthday'] = $_POST['ageA' . $i];
            }
            $passengers[$i]['passenger_national_code'] = $_POST["NationalCodeA" . $i];
            $passengers[$i]['passportCountry'] = $_POST["passportCountryA" . $i];
            $passengers[$i]['passportNumber'] = $_POST["passportNumberA" . $i];
            $passengers[$i]['passportExpire'] = $_POST["passportExpireA" . $i];
            $passengers[$i]['passenger_age'] = $_POST['passengerAge' . $i];
            $passengers[$i]['roommate'] = $_POST['roommate' . $i];
            $passengers[$i]['creation_date_int'] = time();

            if ($this->IsLogin) {

                $passengerAddArray = array(
                    'passengerName' => $passengers[$i]['passenger_name'],
                    'passengerNameEn' => $passengers[$i]['passenger_name_en'],
                    'passengerFamily' => $passengers[$i]['passenger_family'],
                    'passengerFamilyEn' => $passengers[$i]['passenger_family_en'],
                    'passengerGender' => $passengers[$i]['passenger_gender'],
                    'passengerBirthday' => $passengers[$i]['passenger_birthday'],
                    'passengerNationalCode' => $passengers[$i]['passenger_national_code'],
                    'passengerBirthdayEn' => $passengers[$i]['passenger_birthday_en'],
                    'passengerPassportCountry' => $passengers[$i]['passportCountry'],
                    'passengerPassportNumber' => $passengers[$i]['passportNumber'],
                    'passengerPassportExpire' => $passengers[$i]['passportExpire'],
                    'memberID' => $idMember,
                    'passengerNationality' => ''
                );
                $passengerController->insert($passengerAddArray);

            }

            $this->passengers = $passengers;


            $resultInsert = [];
            $nationalCodeConditions = !empty($passengers[$i]['passenger_national_code']) ? "passenger_national_code='{$passengers[$i]['passenger_national_code']}' " : "passportNumber='{$passengers[$i]['passportNumber']}'";
            $sqlCheck = "SELECT * 
                        FROM book_hotel_local_tb 
                        WHERE 
                            factor_number = '{$factorNumber}'
                            AND member_id = '{$idMember}'
                            AND type_application = '{$typeApplication}'
                            AND {$nationalCodeConditions} ";
            $resultCheck = $Model->load($sqlCheck);

            if (empty($resultCheck)) {
                $Model->setTable('book_hotel_local_tb');
                $resultInsert[] = $Model->insertLocal($passengers[$i]);

                $ModelBase->setTable('report_hotel_tb');
                $passengers[$i]['client_id'] = CLIENT_ID;
                $resultInsert[] = $ModelBase->insertLocal($passengers[$i]);

            }

            $i++;
        }


        if (in_array('0', $resultInsert)) {

            $this->error = true;
            $this->errorMessage = 'متاسفانه مشکلی در فرآیند رزرو پیش آمده است. لطفا مجددا تلاش کنید.';

        } elseif (!empty($resultInsert)) {

            $sqlMember = " SELECT * FROM members_tb WHERE id='{$idMember}'";
            $user = $Model->load($sqlMember);
            if (!empty($user)) {
                $data['member_id'] = $idMember;
                $data['member_name'] = $user['name'] . ' ' . $user['family'];
                $data['member_mobile'] = $user['mobile'];
                $data['member_phone'] = $user['telephone'];
                $data['member_email'] = $user['email'];

                $checkSubAgency =  functions::checkExistSubAgency() ;
                if ($user['fk_agency_id'] > 0 || $checkSubAgency) {
                    $agencyId = ($checkSubAgency) ? SUB_AGENCY_ID : $user['fk_agency_id'];
                    $sql = " SELECT * FROM agency_tb WHERE id='{$agencyId}'";
                    $agency = $Model->load($sql);

                    $data['agency_id'] = $agency['id'];
                    $data['agency_name'] = $agency['name_fa'];
                    $data['agency_accountant'] = $agency['accountant'];
                    $data['agency_manager'] = $agency['manager'];
                    $data['agency_mobile'] = $agency['mobile'];
                }
            }


            $temproryReserve = $objExternalHotel->getPreInvoice($factorNumber);

            $city = $objExternalHotel->getCity($temproryReserve['city_name']);
            $star = ($temproryReserve['hotel_stars'] > 0) ? $temproryReserve['hotel_stars'] : 2;

            $data['city_id'] = $city['place_id'];
            $data['city_name'] = $temproryReserve['city_name'];
            $data['hotel_id'] = $temproryReserve['hotel_id'];
            $data['hotel_name'] = $temproryReserve['hotel_persian_name'];
            $data['hotel_name_en'] = $temproryReserve['hotel_name'];
            $data['hotel_address'] = $temproryReserve['hotel_address'];
            $data['hotel_address_en'] = $temproryReserve['hotel_address'];
            $data['hotel_starCode'] = $star;
            $data['hotel_pictures'] = $temproryReserve['image_url'];
            $data['hotel_rules'] = $temproryReserve['hotel_descriptions'];
            $data['room_id'] = $temproryReserve['room_id'];
            $data['room_name'] = '';
            foreach ($temproryReserve['room_list'] as $room) {
                $data['room_name'] .= $room['RoomName'] . ' - ';
            }
            $data['room_name'] = substr($data['room_name'], 0, -3);
            $data['room_name_en'] = $data['room_name'];
            $data['room_count'] = $temproryReserve['room_count'];

            $data['start_date'] = $temproryReserve['start_date'];
            $data['end_date'] = $temproryReserve['end_date'];
            $data['number_night'] = $temproryReserve['night'];

            $data['type_application'] = $typeApplication;
            $data['passenger_leader_room_fullName'] = (isset($data['member_name']) && !empty($data['member_name'])) ? $data['member_name'] : '';
            $data['login_id'] = $temproryReserve['login_id'];

            $serviceTitle = functions::TypeServiceHotel($typeApplication);
            $data['serviceTitle'] = $serviceTitle;

            if(ISCURRENCY && $_POST['CurrencyCode'] > 0){
                $Currency = Load::controller('currencyEquivalent');
                $InfoCurrency = $Currency->InfoCurrency($_POST['CurrencyCode']);
            }
            $data['currency_code'] = $_POST['CurrencyCode'];
            $data['currency_equivalent'] = !empty($InfoCurrency) ? $InfoCurrency['EqAmount'] : '0';

            $objClientAuth = Load::library('clientAuth');
            $objClientAuth->apiExternalHotelAuth();
            $sourceId = $objClientAuth->sourceId;
            //$sourceId = '12';
            $irantechCommission = Load::controller('irantechCommission');
            $it_commission = $irantechCommission->getCommission($serviceTitle, $sourceId);
            $data['irantech_commission'] = $it_commission;

            $fullAmount = $temproryReserve['full_amount'];


            // شروع زمان ده دقیقه برای پرداخت مبلغ و دریافت واچر //
            $param['hotelId'] = $temproryReserve['hotel_id'];
            $param['roomId'] = $temproryReserve['room_id'];
            $param['searchId'] = $temproryReserve['search_id'];
            $param['loginId'] = $temproryReserve['login_id'];
            $resultRoom = $objExternalHotel->getRoomHotel($param);
            if (!empty($temproryReserve) && !empty($resultRoom) && $resultRoom['FullAmount'] > 0){

                $fullAmount = $resultRoom['FullAmount'];
                $priceChange = functions::getHotelPriceChange($city['place_id'], $star, $this->counterId, $temproryReserve['start_date'], 'externalApi');
                if ($priceChange != 'false') {

                    $data['agency_commission'] = $priceChange['price'];
                    $data['agency_commission_price_type'] = $priceChange['price_type'];
                    $data['type_of_price_change'] = $priceChange['change_type'];

                    if ($priceChange['change_type'] == 'increase' && $priceChange['price_type'] == 'cost') {
                        $fullAmount = $resultRoom['FullAmount'] + $priceChange['price'];
                    } elseif ($priceChange['change_type'] == 'decrease' && $priceChange['price_type'] == 'cost') {
                        $fullAmount = $resultRoom['FullAmount'] - $priceChange['price'];
                    } elseif ($priceChange['change_type'] == 'increase' && $priceChange['price_type'] == 'percent') {
                        $fullAmount = ($resultRoom['FullAmount'] * $priceChange['price'] / 100) + $resultRoom['FullAmount'];
                    } elseif ($priceChange['change_type'] == 'decrease' && $priceChange['price_type'] == 'percent') {
                        $fullAmount = ($resultRoom['FullAmount'] * $priceChange['price'] / 100) - $resultRoom['FullAmount'];
                    }
                } else {
                    $data['agency_commission'] = 0;
                    $data['agency_commission_price_type'] = '';
                    $data['type_of_price_change'] = '';
                }

                if (!empty($this->serviceDiscount['externalApi']) && $this->serviceDiscount['externalApi']['off_percent'] > 0) {
                    $data['services_discount'] = $this->serviceDiscount['externalApi']['off_percent'];
                    $fullAmount = $fullAmount - (($fullAmount * $this->serviceDiscount['externalApi']['off_percent']) / 100);
                }


                $this->paymentPrice = $fullAmount;

                $data['hotel_room_prices_id'] = $resultRoom['PriceDetailID'];
                $data['room_price'] = $resultRoom['FullAmount'];
                $data['room_online_price'] = $resultRoom['FullAmount'];
                $data['room_bord_price'] = $resultRoom['FullAmount'];
                $data['total_price'] = $fullAmount;
                $data['total_price_api'] = $resultRoom['FullAmount'];


            } else {
                $this->error = true;
                $this->errorMessage = 'متاسفانه مشکلی در فرآیند رزرو پیش آمده است. لطفا مجددا تلاش کنید.';
            }


            $condition = " factor_number = '{$factorNumber}' ";
            $Model->setTable("book_hotel_local_tb");
            $resUpdate[] = $Model->update($data, $condition);

            $ModelBase->setTable("report_hotel_tb");
            $resUpdate[] = $ModelBase->update($data, $condition);

            if (in_array('0', $resUpdate)) {
                $this->error = true;
                $this->errorMessage = 'متاسفانه مشکلی در فرآیند رزرو پیش آمده است. لطفا مجددا تلاش کنید.';
            }

        } else {
            $this->error = true;
            $this->errorMessage = 'متاسفانه مشکلی در فرآیند رزرو پیش آمده است. لطفا مجددا تلاش کنید.';
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