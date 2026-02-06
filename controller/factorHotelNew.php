 <?php
/**
 * Class factorHotelNew
 * @property factorHotelNew $factorHotelNew
 */

error_reporting( 0 );
//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');


class factorHotelNew extends detailHotel {
	public $IsLogin;
	public $count_basket;
	public $city;
	public $numberNight;
	public $startDate;
	public $paymentPrice;
	public $paymentPriceOneDayTour;
	public $counterTypeId = '';
	public $counterName = '';
	public $counterId = 0;
	public $temproryHotel = array();
	public $serviceDiscount = array();
	public $error = false;
	public $errorMessage = '';
	public $price_room = '';

	public function __construct() {
		//		functions::displayErrorLog('iran-tech.com');
		parent::__construct();
		$this->IsLogin = Session::IsLogin();
//		if ( $this->IsLogin ) {
//			$this->counterId              = functions::getCounterTypeId( $_SESSION['userId'] );
////			$this->serviceDiscount['api'] = functions::ServiceDiscount( $this->counterId, 'PublicLocalHotel' );
//		} else {
//			$this->counterId = '5';
//		}
	}

	/**
	 * @return bool|mixed|temporaryHotelLocalModel
	 */
	public function temporaryHotelLocalModel() {
		return Load::getModel( 'temporaryHotelLocalModel' );
	}

	/**
	 * @return bool|mixed|bookHotelLocalModel
	 */
	public function bookHotelLocalModel() {
		return Load::getModel( 'bookHotelLocalModel' );
	}

	public function statusRefresh() {
		session_start();
		if ( isset( $_SESSION['StatusRefresh'] ) && trim( $_SESSION['StatusRefresh'] ) == $_POST['StatusRefresh'] ) {
			// can't submit refresh
			unset( $_SESSION['StatusRefresh'] );
			unset( $_SESSION['FactorNumberForHotelBooking'] );
			unset( $_SESSION['FactorNumber'] );
			header( 'Location: ' . ROOT_ADDRESS . '/searchHotel/' . $_POST['idCity_Reserve'] . '/' . $_POST['StartDate_Reserve'] . '/' . $_POST['Nights_Reserve'] );
			exit();
		} else {
			$_SESSION['StatusRefresh'] = $_POST['StatusRefresh'];
		}
	}

	public function registerPassengersHotel() {

		$factorNumber    = $_POST['factorNumber'];
		$typeApplication = $_POST['typeApplication'];
		$IdMember        = $_POST['idMember'];
		if(!$factorNumber || !$typeApplication || !$IdMember){
			$this->error        = true;
			$this->errorMessage = 'کاربر گرامی متاسفانه در روند رزرو مشکلی پیش آمده است. لطفا مجددا تلاش کنید.';
			return;
		}
		/** @var passengers $passengerController */
		$passengerController = Load::controller( 'passengers' );
		$objClientAuth = Load::library( 'clientAuth' );
		$objClientAuth->apiHotelAuth();


        $sourceId = $objClientAuth->sourceId;
		$serviceTitle       = functions::TypeServiceHotel( $typeApplication );
		$irantechCommission = Load::controller( 'irantechCommission' );
		$it_commission      = $irantechCommission->getCommission( $serviceTitle, $sourceId );
		$errorResult = [];
		$room_count  = $_POST['rooms_count'];

		$hasError    = true;
		$pos = 1;
		for ( $room_count_number = 1; $room_count_number <= $room_count; $room_count_number ++ ) {
			$i = 1;
//			functions::insertLog('room_count_number = ' . $room_count_number,'room_count_number');


			if ( isset( $_POST[ "genderA" . $room_count_number . $i ] ) ) {
				do {


					$finally_room_people = $room_count_number . $i;
					functions::insertLog('finally_room_people = ' . $finally_room_people,'room_count_number');

					if ( $typeApplication == 'externalApi' ||($typeApplication=='api' && ($sourceId=='17' || $sourceId=='29') ) ) {

                        $price_rooms = $this->temporaryHotelLocalModel()->get( [
							'id',
							'room_index',
							'is_internal',
							'type_of_price_change',
							'agency_commission_price_type',
							'SUM(agency_commission) AS agency_commission_sum',
                            'agency_commission',
							'SUM(price_online_current) AS price_online_current_sum',
                            'price_online_current',
							'SUM(price_board_current) AS price_board_current_sum',
                            'price_board_current',
							'SUM(price_current) AS price_current_sum',
                            'price_current',
							'SUM(price_foreign_current) AS price_foreign_current_sum',
                            'price_foreign_current',
						] )->where( 'factor_number', $factorNumber )->where( 'room_id', $_POST[ 'Id_Select_Room' . $room_count_number ] )->groupBy( 'room_index' )->all();

						$hasError    = true;
						$pos = 2;


						foreach ( $price_rooms as $price_room ) {

							if ( ! empty( $price_room ) && $price_room['price_current_sum'] > 0 ) {

								$adult[ $i ]['request_number']  = $_POST["requestNumber"];
								if($_POST['roomIndex'.$room_count_number]){
									$adult[ $i ]['room_index']      = $_POST['roomIndex'.$room_count_number];
								}
								$adult[ $i ]['gender']          = $_POST[ "genderA" . $finally_room_people ];
								$adult[ $i ]['extra_bed_count'] = 0;
								$adult[ $i ]['child_count']     = 0;

								$adult[ $i ]['name_en']                        = $_POST[ "nameEnA" . $finally_room_people ];
								$adult[ $i ]['family_en']                      = $_POST[ "familyEnA" . $finally_room_people ];
								$adult[ $i ]['name']                           = $_POST[ "nameFaA" . $finally_room_people ];
								$adult[ $i ]['family']                         = $_POST[ "familyFaA" . $finally_room_people ];
								$adult[ $i ]['NationalCode']                   = $_POST[ "NationalCodeA" . $finally_room_people ];
								$adult[ $i ]['fk_members_tb_id']               = $_POST["idMember"];
								$adult[ $i ]['passportCountry']                = $_POST[ "passportCountryA" . $finally_room_people ];
								$adult[ $i ]['passportNumber']                 = $_POST[ "passportNumberA" . $finally_room_people ];
								$adult[ $i ]['passportExpire']                 = $_POST[ "passportExpireA" . $finally_room_people ];
								$adult[ $i ]['passenger_leader_room']          = $_POST["passenger_leader_room"];
								$adult[ $i ]['passenger_leader_room_fullName'] = $_POST["passenger_leader_room_fullName"];
								$adult[ $i ]['BedType']                        = $_POST[ "BedType" . $finally_room_people ];
								$adult[ $i ]['Id_Select_Room']                 = $_POST[ "Id_Select_Room" . $room_count_number ];
                                $adult[ $i ]['passenger_age']                  = 'Adt';

								if ( isset( $_POST[ "timeEnteringRoom" . $finally_room_people ] ) ) {
									$adult[ $i ]['time_entering_room'] = $_POST[ "timeEnteringRoom" . $i ];
								}

								$adult[ $i ]['room_price']        = $price_room['price_current'];
								$adult[ $i ]['room_bord_price']   = $price_room['price_board_current'];
								$adult[ $i ]['room_online_price'] = $price_room['price_online_current'];

								$adult[ $i ]['birthday']                     = $_POST[ "birthdayEnA" . $finally_room_people ] ? $_POST[ "birthdayEnA" . $finally_room_people ] : '';
								$adult[ $i ]['birthday_fa']                  = $_POST[ "birthdayA" . $finally_room_people ] ? $_POST[ "birthdayA" . $finally_room_people ] : '';
                                if((!$_POST[ "birthdayEnA" . $finally_room_people ] && $_POST[ "birthdayA" . $finally_room_people ] )||
                                    ($_POST[ "birthdayA" . $finally_room_people ] && $_POST[ "passengerNationalityA" . $finally_room_people ] == 0) ) {
                                    $xpl = explode('-', $_POST[ "birthdayA" . $finally_room_people ]);
                                    $FinalDate = dateTimeSetting::jalali_to_gregorian($xpl[0], $xpl[1], $xpl[2], '-');
                                    $adult[ $i ]['birthday'] = $FinalDate;
                                }

								$adult[ $i ]['agency_commission']            = $price_room['agency_commission'];
								$adult[ $i ]['agency_commission_price_type'] = $price_room['agency_commission_price_type'];
								$adult[ $i ]['type_of_price_change']         = $price_room['type_of_price_change'];

								if ( $this->IsLogin ) {
									$passengerAddArray = array(
										'passengerName'            => $adult[ $i ]['name'],
										'passengerNameEn'          => $adult[ $i ]['name_en'],
										'passengerFamily'          => $adult[ $i ]['family'],
										'passengerFamilyEn'        => $adult[ $i ]['family_en'],
										'passengerGender'          => $adult[ $i ]['gender'],
										'passengerNationalCode'    => $adult[ $i ]['NationalCode'],
										'passengerBirthday'        => $adult[ $i ]['birthday_fa'],
										'passengerBirthdayEn'      => $adult[ $i ]['birthday'],
										'passengerPassportCountry' => $adult[ $i ]['passportCountry'],
										'passengerPassportNumber'  => $adult[ $i ]['passportNumber'],
										'passengerPassportExpire'  => $adult[ $i ]['passportExpire'],
										'memberID'                 => $adult[ $i ]['fk_members_tb_id'],
										'passengerNationality'     => $_POST[ "passengerNationalityA" . $finally_room_people ]
									);



									$passengerController->insert( $passengerAddArray );
								}
								if ( ISCURRENCY && $_POST['CurrencyCode'] > 0 ) {
									$Currency     = Load::controller( 'currencyEquivalent' );
									$InfoCurrency = $Currency->InfoCurrency( $_POST['CurrencyCode'] );
								}

								$adult[ $i ]['currency_code']       = $_POST['CurrencyCode'];
								$adult[ $i ]['currency_equivalent'] = ! empty( $InfoCurrency ) ? $InfoCurrency['EqAmount'] : '0';

								$errorResult                        = parent::FirstBookHotel( $adult[ $i ], $IdMember, $factorNumber, $typeApplication, $it_commission, $i );

                                $hasError                           = false;
								$pos = 3;


							} else {
								$errorResult [] = 0;
							}
						}
					}
                    else {

						$price_room = $this->getModel( 'temporaryHotelLocalModel' )->get( [
                            'id',
                            'room_index',
                            'is_internal',
                            'type_of_price_change',
                            'agency_commission_price_type',
                            'SUM( price_current ) AS price_current_sum',
                            'SUM( price_foreign_current ) AS price_foreign_current_sum',
                            'SUM( agency_commission ) AS agency_commission_sum',
                            'SUM( price_online_current ) AS price_online_current_sum',
                            'SUM( price_board_current ) AS price_board_current_sum',
                        ] )->where( 'factor_number', $factorNumber )->where( 'room_id', $_POST[ 'Id_Select_Room' . $room_count_number.$i ] )->find();
//
						$hasError                      = true;
						$pos = 4;
						$extra_bed                     = isset($_POST[ 'extra_bed_count-' . $i ] )? $_POST[ 'extra_bed_count-' . $room_count_number.$i ] : 0;
						$child_count                   = isset($_POST[ 'child_count-' . $i ]) ? $_POST[ 'child_count-' . $room_count_number.$i ] : 0;
						$adult_arr['room_index'] = 0;
//						if ( isset( $_POST[ 'roomIndex' . $i ] ) ) {
//							$adult_arr['room_index'] = $_POST[ 'roomIndex' . $i ];
//						}



						if ( ! empty( $price_room ) && $price_room['price_current_sum'] > 0 ) {
							$adult_arr['request_number']                 = $_POST["requestNumber"];
							$adult_arr['gender']                         = $_POST[ "genderA" . $room_count_number.$i ];
							$adult_arr['child_count']                    = $child_count;
							$adult_arr['extra_bed_count']                = $extra_bed;
							$adult_arr['name_en']                        = $_POST[ "nameEnA" . $room_count_number.$i ];
							$adult_arr['family_en']                      = $_POST[ "familyEnA" . $room_count_number.$i ];
							$adult_arr['name']                           = $_POST[ "nameFaA" . $room_count_number.$i ];
							$adult_arr['family']                         = $_POST[ "familyFaA" .$room_count_number.$i ];
							$adult_arr['NationalCode']                   = $_POST[ "NationalCodeA" . $room_count_number.$i ];
							$adult_arr['fk_members_tb_id']               = $_POST["idMember"];
							$adult_arr['passportCountry']                = $_POST[ "passportCountryA" . $room_count_number.$i ];
							$adult_arr['passportNumber']                 = $_POST[ "passportNumberA" . $room_count_number.$i ];
							$adult_arr['passportExpire']                 = $_POST[ "passportExpireA" . $room_count_number.$i ];
							$adult_arr['passenger_leader_room']          = $_POST["passenger_leader_room"];
							$adult_arr['passenger_leader_room_fullName'] = $_POST["passenger_leader_room_fullName"];
							$adult_arr['BedType']                        = $_POST[ "BedType" .$room_count_number.$i ];
							$adult_arr['Id_Select_Room']                 = $_POST[ "Id_Select_Room" . $room_count_number.$i ];
							if ( isset( $_POST[ "timeEnteringRoom" . $room_count_number.$i ] ) ) {
								$adult_arr['time_entering_room'] = $_POST[ "timeEnteringRoom" . $room_count_number.$i ];
							}

							$adult_arr['room_price']        = $price_room['price_current_sum'];
							$adult_arr['room_bord_price']   = $price_room['price_board_current_sum'];
							$adult_arr['room_online_price'] = $price_room['price_online_current_sum'];

							if ( $_POST[ "passengerNationalityA" . $room_count_number.$i ] == '0' ) {
								$adult_arr['birthday_fa'] = $_POST[ "birthdayA" . $room_count_number.$i ];

								$adult_arr['birthday']    = '';
							} else {
								$adult_arr['birthday_fa'] = '';
								$adult_arr['birthday']    = $_POST[ "birthdayEnA" . $room_count_number.$i ];
							}
							$adult_arr['agency_commission']            = $price_room['agency_commission_sum'];
							$adult_arr['agency_commission_price_type'] = $price_room['agency_commission_price_type'];


							$adult_arr['type_of_price_change']         = $price_room['type_of_price_change'];
							if ( $this->IsLogin ) {
								$passengerAddArray = array(
									'passengerName'            => $adult_arr['name'],
									'passengerNameEn'          => $adult_arr['name_en'],
									'passengerFamily'          => $adult_arr['family'],
									'passengerFamilyEn'        => $adult_arr['family_en'],
									'passengerGender'          => $adult_arr['gender'],
									'passengerBirthday'        => $adult_arr['birthday_fa'],
									'passengerNationalCode'    => $adult_arr['NationalCode'],
									'passengerBirthdayEn'      => $adult_arr['birthday'],
									'passengerPassportCountry' => $adult_arr['passportCountry'],
									'passengerPassportNumber'  => $adult_arr['passportNumber'],
									'passengerPassportExpire'  => $adult_arr['passportExpire'],
									'memberID'                 => $adult_arr['fk_members_tb_id'],
									'passengerNationality'     => $_POST[ "passengerNationalityA" .$room_count_number. $i ]
								);

								$passengerController->insert( $passengerAddArray );
							}

							if ( ISCURRENCY && $_POST['CurrencyCode'] > 0 ) {
								$Currency     = Load::controller( 'currencyEquivalent' );
								$InfoCurrency = $Currency->InfoCurrency( $_POST['CurrencyCode'] );
							}

							$adult_arr['currency_code']       = $_POST['CurrencyCode'];
							$adult_arr['currency_equivalent'] = ! empty( $InfoCurrency ) ? $InfoCurrency['EqAmount'] : '0';
							$errorResult                            = parent::FirstBookHotel( $adult_arr, $IdMember, $factorNumber, $typeApplication, $it_commission, $i );
							$hasError                               = false;
							$pos = 5;

						} else {

							$errorResult [] = 0;
						}
					}
					$i ++;

				} while ( isset( $_POST[ "genderA" . $room_count_number . $i ] ) );
			}

			$c = 1;
			if ( isset( $_POST[ "genderC" . $room_count_number . $c ] ) ) {

				do {

					if ( $typeApplication == 'externalApi' ) {
						$price_rooms = $this->temporaryHotelLocalModel()->get( [
							'id',
							'room_index',
							'is_internal',
							'type_of_price_change',
							'agency_commission_price_type',
							'agency_commission AS agency_commission_sum',
							'price_online_current  AS price_online_current_sum',
							'price_board_current AS price_board_current_sum',
							'price_current AS price_current_sum',
							'price_foreign_current AS price_foreign_current_sum'
						] )->where( 'factor_number', $factorNumber )->where( 'room_id', $_POST[ 'Id_Select_Room' . $room_count_number ] )->groupBy( 'room_index' )->all()
						;

						foreach ( $price_rooms as $price_room ) {
							if ( ! empty( $price_room ) && $price_room['price_current_sum'] > 0 ) {
								$extra_bed                            = $price_room['is_internal'] ? $_POST[ 'extra_bed_count-' . $c ] : 0;
								$child_count                          = $price_room['is_internal'] ? $_POST[ 'child_count-' . $c ] : 0;
								$child_insert[ $c ]['request_number'] = $_POST["requestNumber"];
								$child_insert[ $c ]['gender']         = $_POST[ "genderC" . $room_count_number . $c ];
								if($_POST['roomIndex'.$room_count_number]){
									$child_insert[ $c ]['room_index']      = $_POST['roomIndex'.$room_count_number];
								}
								$child_insert[ $c ]['child_count']     = $child_count;
								$child_insert[ $c ]['extra_bed_count'] = $extra_bed;

								$child_insert[ $c ]['name_en']                        = $_POST[ "nameEnC" . $room_count_number . $c ];
								$child_insert[ $c ]['family_en']                      = $_POST[ "familyEnC" . $room_count_number . $c ];
								$child_insert[ $c ]['name']                           = $_POST[ "nameFaC" . $room_count_number . $c ];
								$child_insert[ $c ]['family']                         = $_POST[ "familyFaC" . $room_count_number . $c ];
								$child_insert[ $c ]['NationalCode']                   = $_POST[ "NationalCodeC" . $room_count_number . $c ];
								$child_insert[ $c ]['fk_members_tb_id']               = $_POST["idMember"];
								$child_insert[ $c ]['passportCountry']                = $_POST[ "passportCountryC" . $room_count_number . $c ];
								$child_insert[ $c ]['passportNumber']                 = $_POST[ "passportNumberC" . $room_count_number . $c ];
								$child_insert[ $c ]['passportExpire']                 = $_POST[ "passportExpireC" . $room_count_number . $c ];
								$child_insert[ $c ]['passenger_leader_room']          = $_POST["passenger_leader_room"];
								$child_insert[ $c ]['passenger_leader_room_fullName'] = $_POST["passenger_leader_room_fullName"];
								$child_insert[ $c ]['BedType']                        = $_POST[ "BedType" . $room_count_number . $c ];
								$child_insert[ $c ]['Id_Select_Room']                 = $_POST[ "Id_Select_Room" . $room_count_number ];
								$child_insert[ $c ]['passenger_age']                  = 'Chd';

								if ( isset( $_POST[ "timeEnteringRoom" . $c ] ) ) {
									$child_insert[ $c ]['time_entering_room'] = $_POST[ "timeEnteringRoom" . $c ];
								}

								$child_insert[ $c ]['room_price']        = $price_room['price_current_sum'];
								$child_insert[ $c ]['room_bord_price']   = $price_room['price_board_current_sum'];
								$child_insert[ $c ]['room_online_price'] = $price_room['price_online_current_sum'];

								if ( $_POST[ "passengerNationalityC" . $room_count_number . $c ] == '0' ) {

									$child_insert[ $c ]['birthday_fa'] = $_POST[ "birthdayC" . $room_count_number . $c ] ? $_POST[ "birthdayC" . $room_count_number . $c ] : '';
                                    if($child_insert[ $c ]['birthday_fa'] != '') {
                                        $xpl = explode('-', $child_insert[ $c ]['birthday_fa']);
                                        $FinalDate = dateTimeSetting::jalali_to_gregorian($xpl[0], $xpl[1], $xpl[2], '-');

                                        $child_insert[ $c ]['birthday']    = $FinalDate;
                                    }else{
                                        $child_insert[ $c ]['birthday']    = '';
                                    }


								} else {
									$child_insert[ $c ]['birthday_fa'] = '';
									$child_insert[ $c ]['birthday']    = $_POST[ "birthdayEnC" . $room_count_number . $c ] ? $_POST[ "birthdayEnC" . $room_count_number . $c ] : '';
								}

								$child_insert[ $c ]['agency_commission']            = $price_room['agency_commission_sum'];
								$child_insert[ $c ]['agency_commission_price_type'] = $price_room['agency_commission_price_type'];
								$child_insert[ $c ]['type_of_price_change']         = $price_room['type_of_price_change'];

								if ( $this->IsLogin ) {
									$passengerAddArray = array(
										'passengerName'            => $child_insert[ $c ]['name'],
										'passengerNameEn'          => $child_insert[ $c ]['name_en'],
										'passengerFamily'          => $child_insert[ $c ]['family'],
										'passengerFamilyEn'        => $child_insert[ $c ]['family_en'],
										'passengerGender'          => $child_insert[ $c ]['gender'],
										'passengerBirthday'        => $child_insert[ $c ]['birthday_fa'],
										'passengerNationalCode'    => $child_insert[ $c ]['NationalCode'],
										'passengerBirthdayEn'      => $child_insert[ $c ]['birthday'],
										'passengerPassportCountry' => $child_insert[ $c ]['passportCountry'],
										'passengerPassportNumber'  => $child_insert[ $c ]['passportNumber'],
										'passengerPassportExpire'  => $child_insert[ $c ]['passportExpire'],
										'memberID'                 => $child_insert[ $c ]['fk_members_tb_id'],
										'passengerNationality'     => $_POST[ "passengerNationalityC" . $room_count_number . $c ]
									);

									$passengerController->insert( $passengerAddArray );
								}

								if ( ISCURRENCY && $_POST['CurrencyCode'] > 0 ) {
									$Currency     = Load::controller( 'currencyEquivalent' );
									$InfoCurrency = $Currency->InfoCurrency( $_POST['CurrencyCode'] );
								}

								$child_insert[ $c ]['currency_code']       = $_POST['CurrencyCode'];
								$child_insert[ $c ]['currency_equivalent'] = ! empty( $InfoCurrency ) ? $InfoCurrency['EqAmount'] : '0';
								$errorResult                               = parent::FirstBookHotel( $child_insert[ $c ], $IdMember, $factorNumber, $typeApplication, $it_commission, $c );
								$hasError                                  = false;
								$pos = 6;
							} else {
								$errorResult [] = 0;
							}
						}
					}
					$c ++;
				} while ( isset( $_POST[ "genderC" . $room_count_number . $c ] ) );
			}

		}
        
		//		if (in_array('0', $errorResult)){
		if ( $hasError ) {
			$this->error        = true;
			$this->errorMessage = functions::Xmlinformation('ReserveFailed').'-'.$pos;
		}
	}

	public function getPassengersHotel( $formData = null ) {

		if ( ! empty( $formData ) ) {
			$_POST = $formData;
		}
		$this->city        = $_POST['idCity_Reserve'];
		$this->numberNight = $_POST['Nights_Reserve'];
		$this->startDate   = $_POST['StartDate_Reserve'];

		$Model     = Load::library( 'Model' );
		$ModelBase = Load::library( 'ModelBase' );

//        $sql_temprory_hotel = " SELECT * FROM book_hotel_local_tb WHERE factor_number ='{$_POST['factorNumber']}'ORDER BY room_id, flat_type ";

		$result_temprory_hotel = $this->getModel( 'bookHotelLocalModel' )->get()->where( 'factor_number', $_POST['factorNumber'] )->orderBy( 'room_id,flat_type' )->all();

        functions::insertLog('first result_temprory_hotel===> '.json_encode($result_temprory_hotel,256|64),'HOTELLOG');

		//        $result_temprory_hotel = $Model->select($sql_temprory_hotel, 'assoc');

		$AuxiliaryVariableRoom = $result_temprory_hotel[0]['room_id']; // Group by room
		$indexRoom             = 0;
		$room_price            = 0;
		$room_price_api        = 0;
		$totalPrice            = 0;
		$totalPriceApi         = 0;
		$bed_price             = 0;
		$ext                   = 0;
		$roomExternalIndex     = 0;
		$extra_bed_price       = 0;
		$extra_child_price     = 0;

		foreach ( $result_temprory_hotel as $k => $hotel ) {
			//Group by room
			if ( $AuxiliaryVariableRoom != $hotel['room_id'] ) {

				$AuxiliaryVariableRoom = $hotel['room_id'];
				$indexRoom             = 0;
				$room_price            = 0;
				$bed_price             = 0;
				$ext                   = 0;
				$extra_bed_price       = 0;
				$extra_child_price     = 0;
			}

			//info hotel
			$this->temproryHotel['is_internal']               = $hotel['type_application'] == 'externalApi' ? 0 : 1;
			$this->temproryHotel['factor_number']             = $hotel['factor_number'];
			$this->temproryHotel['passenger_leader_tell']     = $hotel['passenger_leader_room'];
			$this->temproryHotel['passenger_leader_fullName'] = $hotel['passenger_leader_room_fullName'];
			$this->temproryHotel['city_name']                 = $hotel['city_name'];
			$this->temproryHotel['hotel_id']                  = $hotel['hotel_id'];
			$this->temproryHotel['hotel_name']                = $hotel['hotel_name'];
			$this->temproryHotel['hotel_address']             = $hotel['hotel_address'];
			$this->temproryHotel['hotel_starCode']            = $hotel['hotel_starCode'];
			if ( SOFTWARE_LANG == 'en' || SOFTWARE_LANG == 'ar' ) {
				$this->temproryHotel['start_date'] = functions::ConvertToMiladi( $hotel['start_date'] );
				$this->temproryHotel['end_date']   = functions::ConvertToMiladi( $hotel['end_date'] );
			} else {
				$this->temproryHotel['start_date'] = $hotel['start_date'];
				$this->temproryHotel['end_date']   = $hotel['end_date'];
			}
			$this->temproryHotel['number_night']     = $hotel['number_night'];
			$this->temproryHotel['type_application'] = $hotel['type_application'];
			$this->temproryHotel['hotel_rules']      = $hotel['hotel_rules'];
			$this->temproryHotel['hotel_pictures']   = ( $hotel['type_application'] == 'api' || $hotel['type_application'] == 'externalApi' || $hotel['type_application'] == 'api_app' ) ? "{$hotel['hotel_pictures']}" : ROOT_ADDRESS_WITHOUT_LANG . "/pic/{$hotel['hotel_pictures']}";

//			$indexRoom         = 0;
//			$room_price        = 0;
//			$room_price_api    = 0;
//			$bed_price         = 0;
//			$extra_bed_price   = 0;
//			$extra_child_price = 0;
//			$ext               = 0;

			//info passenger

			$this->temproryHotel['passenger'][ $k ]['passenger_name']          = $hotel['passenger_name'];
			$this->temproryHotel['passenger'][ $k ]['passenger_family']        = $hotel['passenger_family'];
			$this->temproryHotel['passenger'][ $k ]['passenger_ageCategory']   = $hotel['passenger_age'];
			$this->temproryHotel['passenger'][ $k ]['passenger_name_en']       = $hotel['passenger_name_en'];
			$this->temproryHotel['passenger'][ $k ]['passenger_family_en']     = $hotel['passenger_family_en'];
			$this->temproryHotel['passenger'][ $k ]['passenger_birthday']      = $hotel['passenger_birthday'];
			$this->temproryHotel['passenger'][ $k ]['passenger_birthday_en']   = $hotel['passenger_birthday_en'];
			$this->temproryHotel['passenger'][ $k ]['passenger_national_code'] = $hotel['passenger_national_code'];
			$this->temproryHotel['passenger'][ $k ]['passportNumber']          = $hotel['passportNumber'];
			$this->temproryHotel['passenger'][ $k ]['room_price']              = $hotel['room_price'];
			$this->temproryHotel['passenger'][ $k ]['room_name']               = $hotel['room_name'];
			$this->temproryHotel['passenger'][ $k ]['room_id']                 = $hotel['room_id'];
			$this->temproryHotel['passenger'][ $k ]['room_index']              = $hotel['room_index'];

			//api or reservation
			if ( $hotel['type_application'] == 'api' || $hotel['type_application'] == 'api_app' || $hotel['type_application'] == 'externalApi' ) {
				//				echo Load::plog($hotel['room_count']);
				$this->temproryHotel['passenger'][ $k ]['title_flat_type'] = functions::Xmlinformation( 'HeadOfRoom' );

                $room_price = $hotel['room_price'] * $hotel['room_count'];

                if($hotel['type_application'] == 'externalApi' && ((substr($hotel['hotel_id'],0,2) != '17') || (substr($hotel['hotel_id'],0,2) != '29'))){
                    $room_price_api = $hotel['room_online_price'];
                }else{
                    $room_price_api = $hotel['room_online_price'] * $hotel['room_count'];
                }
                functions::insertLog('$hotel ==>'.json_encode($hotel,256|64),'HOTELLOG');
                functions::insertLog('room_online_price ==> '.json_encode($room_price_api),'HOTELLOG');


                if( $hotel['type_application'] == 'api' && ((substr($hotel['hotel_id'],0,2) == '17') || (substr($hotel['hotel_id'],0,2) == '29')))
                {
                    $current_room_price = ($hotel['room_price'] * $hotel['room_count']) * $hotel['number_night'];
                    $current_room_api_price = $current_room_price;
                }else{
                    $current_room_price = ($hotel['room_price'] * $hotel['room_count']);

                    $current_room_api_price = $room_price_api;
                }



				if ( $hotel['extra_bed_count'] > 0 && $hotel['extra_bed_price'] > 0 ) {
                    if($hotel['source_id'] == '13') {

                        $price_rooms = $this->temporaryHotelLocalModel()->get( [
                            'id',
                            'SUM(extra_bed_price) AS bed_price',
                        ] )->where( 'factor_number', $hotel['factor_number'] )->where('room_id' , $hotel['room_id'] )->find();

                        $extra_bed_price    = $hotel['room_count'] * $hotel['extra_bed_count'] * $price_rooms['bed_price'];

                    }else{
                        $extra_bed_price    = $hotel['room_count'] * $hotel['extra_bed_count'] * $hotel['extra_bed_price'] * $hotel['number_night'];

                    }

					$current_room_price = $current_room_price + $extra_bed_price;
                    $current_room_api_price = $current_room_api_price + $extra_bed_price;


				}
				if ( $hotel['child_count'] > 0 && $hotel['child_price'] > 0 ) {
					$extra_child_price  = $hotel['child_count'] * $hotel['child_price'] * $hotel['number_night'];
					$current_room_price = $current_room_price + $extra_child_price;
                    $current_room_api_price = $current_room_api_price + $extra_child_price;

				}

//				if ( $hotel['type_of_price_change'] == 'increase' && $hotel['agency_commission_price_type'] == 'cost' ) {
//					$room_price = ( $current_room_price + $hotel['agency_commission'] );
//
//				} elseif ( $hotel['type_of_price_change'] == 'decrease' && $hotel['agency_commission_price_type'] == 'cost' ) {
//					$room_price = ( $current_room_price - $hotel['agency_commission'] );
//
//				} elseif ( $hotel['type_of_price_change'] == 'increase' && $hotel['agency_commission_price_type'] == 'percent' ) {
//					$room_price = ( ( $current_room_price * $hotel['agency_commission'] / 100 ) + $current_room_price );
//
//				} elseif ( $hotel['type_of_price_change'] == 'decrease' && $hotel['agency_commission_price_type'] == 'percent' ) {
//					$room_price = ( ( $current_room_price * $hotel['agency_commission'] / 100 ) - $current_room_price );
//
//				} else {


				$room_price = $current_room_price;
                $room_price_api = $current_room_api_price;
                functions::insertLog('current_room_api_price '.json_encode([$room_price_api,$current_room_api_price]),'HOTELLOG');
//				}
//
//				if ( ! empty( $this->serviceDiscount['api'] ) && $this->serviceDiscount['api']['off_percent'] > 0 ) {
//					$room_price = $room_price - ( ( $room_price * $this->serviceDiscount['api']['off_percent'] ) / 100 );
//				}
			}
			$search_rooms = json_decode( $hotel['search_rooms'], true );

			if ( $hotel['type_application'] == 'externalApi' ) {
				if ( $hotel['room_index'] == $roomExternalIndex ) {
					$this->temproryHotel['room'][ $hotel['room_index'] ]['AdultsCount']             = $search_rooms[ $hotel['room_index'] ]['Adults'];
					$this->temproryHotel['room'][ $hotel['room_index'] ]['ChildrenCount']           = $search_rooms[ $hotel['room_index'] ]['Children'];
					$this->temproryHotel['room'][ $hotel['room_index'] ]['room_name']               = $hotel['room_name'];
					$this->temproryHotel['room'][ $hotel['room_index'] ]['room_index']              = $hotel['room_index'];
					$this->temproryHotel['room'][ $hotel['room_index'] ]['max_capacity_count_room'] = $hotel['max_capacity_count_room'];
					$this->temproryHotel['room'][ $hotel['room_index'] ]['room_count']              = $hotel['room_count'];
					$this->temproryHotel['room'][ $hotel['room_index'] ]['price_current']           = $hotel['price_current'];
					$this->temproryHotel['room'][ $hotel['room_index'] ]['room_price']              = $room_price;
					$this->temproryHotel['room'][ $hotel['room_index'] ]['extra_bed_price']         = $extra_bed_price;
					$this->temproryHotel['room'][ $hotel['room_index'] ]['extra_child_price']       = $extra_child_price;
					$this->temproryHotel['room'][ $hotel['room_index'] ]['type_application']        = $hotel['type_application'];
					$roomExternalIndex ++;
				}
			}


			//info room
			if ( $indexRoom == 0 ) {
                $price_current = $hotel['price_current'];
				if ( $hotel['type_application'] == 'api' || $hotel['type_application'] == 'api_app' ) {
                    $this->serviceDiscount['api'] = functions::ServiceDiscount( $this->counterId, 'PublicLocalHotel' );
					if ( ! empty( $this->serviceDiscount['api'] ) && $this->serviceDiscount['api']['off_percent'] > 0 ) {
						$price_current = $price_current - ( ( $price_current * $this->serviceDiscount['api']['off_percent'] ) / 100 );
					}
				}
                if($hotel['type_application'] == 'externalApi'){
                    $this->serviceDiscount['api'] = functions::ServiceDiscount( $this->counterId, 'PublicPortalHotel' );
                }
				if ( $hotel['type_application'] != 'externalApi' ) {
					$this->temproryHotel['room'][ $hotel['room_id'] ]['max_capacity_count_room'] = $hotel['max_capacity_count_room'];
					$this->temproryHotel['room'][ $hotel['room_id'] ]['room_name']               = $hotel['room_name'];
					$this->temproryHotel['room'][ $hotel['room_id'] ]['room_count']              = $hotel['room_count'];
					$this->temproryHotel['room'][ $hotel['room_id'] ]['price_current']           = $price_current;
					$this->temproryHotel['room'][ $hotel['room_id'] ]['room_price']              = $room_price;
					$this->temproryHotel['room'][ $hotel['room_id'] ]['extra_bed_count']         = $hotel['extra_bed_count'];
					$this->temproryHotel['room'][ $hotel['room_id'] ]['extra_bed_price']         = ( $hotel['extra_bed_count'] > 0 ) ? $hotel['extra_bed_price'] : 0;
					$this->temproryHotel['room'][ $hotel['room_id'] ]['extra_child_count']       = $hotel['child_count'];
					$this->temproryHotel['room'][ $hotel['room_id'] ]['extra_child_price']       = ( $hotel['child_count'] > 0 ) ? $hotel['child_price'] : 0;
					$this->temproryHotel['room'][ $hotel['room_id'] ]['nights']                  = $hotel['number_night'];
				}

				/*$this->temproryHotel['room'][$hotel['room_index']]['passenger_name'] = $hotel['passenger_name'] . ' ' . $hotel['passenger_family'];
				$this->temproryHotel['room'][$hotel['room_index']]['passenger_birthday'] = $hotel['passenger_birthday'] != '' ? $hotel['passenger_birthday'] : $hotel['passenger_birthday_en'];
				$this->temproryHotel['room'][$hotel['room_id']]['passenger_national_code'] = $hotel['passenger_national_code'] != '' ? $hotel['passenger_national_code'] : $hotel['passportNumber'];*/


				$totalPrice    += $room_price;


                functions::insertLog('hotel '.json_encode($hotel),'HOTELLOG');
                if ( $hotel['type_application'] == 'externalApi' ) {
                    $totalPriceApi = $room_price_api;
                    functions::insertLog('hotel '.json_encode([$totalPriceApi,$room_price_api]),'HOTELLOG');
                }else{
                    $totalPriceApi += $room_price_api;
                }



			}

			if ( $hotel['type_application'] == 'externalApi' ) {
				$this->temproryHotel['room'][ $hotel['room_index'] ]['remarks']        = $hotel['remarks'];
				$this->temproryHotel['room'][ $hotel['room_index'] ]['flat_ext_count'] = $ext;
			} else {
				$this->temproryHotel['room'][ $hotel['room_id'] ]['flat_ext_count'] = $ext;
			}

			$indexRoom ++;


		}

		if ( $result_temprory_hotel[0]['type_application'] == 'api' ||
            $result_temprory_hotel[0]['type_application'] == 'api_app' ||
            $result_temprory_hotel[0]['type_application'] == 'externalApi' ) {

			if($result_temprory_hotel[0]['type_application'] == 'externalApi' || ($result_temprory_hotel[0]['isInternal']=='1' && ($result_temprory_hotel[0]['source_id']=='17' || $result_temprory_hotel[0]['source_id']=='29'))){
				$this->paymentPrice = ( $result_temprory_hotel[0]['price_current'] * $result_temprory_hotel[0]['number_night']);
                $d['total_price']     = $this->paymentPrice;
                $d['total_price_api'] = ( $result_temprory_hotel[0]['room_online_price'] * $result_temprory_hotel[0]['number_night']);
//                $d['room_bord_price'] = $this->paymentPrice;
//                $d['room_online_price'] = $this->paymentPrice;
//                $d['room_price'] = $this->paymentPrice;
//				var_dump($this->paymentPrice);
			}else{

                $this->paymentPrice = $totalPrice;
                $d['total_price']     = $totalPrice;
                $d['total_price_api'] = $totalPriceApi;
            }

            error_log(PHP_EOL.'trying update this data : ' . date('Y/m/d H:i:s') . ' D => : ' . json_encode($d,256|64), 3, LOGS_DIR . 'log_method_ReserveHotel.txt');
            error_log(PHP_EOL.'trying update this data : ' . date('Y/m/d H:i:s') . ' D => : ' . json_encode($d,256|64), 3, LOGS_DIR . 'HOTELLOG.txt');
            error_log(PHP_EOL.'TempHotelLocal : ' . date('Y/m/d H:i:s') . ' D => : ' . json_encode($result_temprory_hotel[0],256|64), 3, LOGS_DIR . 'HOTELLOG.txt');

			// payment price hotel

			$Condition            = "factor_number='{$_POST['factorNumber']}' ";
//            $this->bookHotelLocalModel()->get()->where( 'factor_number', $_POST['factorNumber'] );
            $update_book = $this->bookHotelLocalModel()->updateWithBind($d,$Condition);

//			$Model->setTable( "book_hotel_local_tb" );
//			$Model->update( $d, $Condition );
            /** @var reportHotelModel $report_model */
            $report_model = $this->getModel('reportHotelModel');
            $report_model->updateWithBind($d,$Condition);

//			$ModelBase->setTable( "report_hotel_tb" );
//			$ModelBase->update( $d, $Condition );
			//			echo Load::plog($_POST);
			$request = [
				'factorNumber'    => $_POST['factorNumber'],
				'typeApplication' => $hotel['type_application'],
				'passportCountry' => $hotel['passportCountry'],
				'requestNumber'   => $_POST['requestNumber']
			];

			$book    = $this->HotelReserveNew( $request );

			//			echo Load::plog( $book );
			//				if ( json_decode( $book,true )['book'] == 'yes' ) {
//			$sql_temprory_hotel    = " SELECT * FROM book_hotel_local_tb WHERE factor_number ='{$_POST['factorNumber']}';";
//			$Model->select( $sql_temprory_hotel );

            $result_temprory_hotel = $this->bookHotelLocalModel()->get()->where( 'factor_number', $_POST['factorNumber'] )->all();

			foreach ( $result_temprory_hotel as $r => $room ) {
				if ( $hotel['type_application'] == 'externalApi' ) {
					$this->temproryHotel['room'][ $r ]['remarks'] = $room['remarks'];
				}
			}
			//				}
		} else {
			$this->paymentPrice = $result_temprory_hotel[0]['room_price'];
		}
		//		echo json_encode($this->temproryHotel);exit();

		//		}
	}

	public function HotelReserveNew( $params = [] ) {
		return parent::HotelReserveNew( $params );
	}

	public function CreditCustomer() {
		$Model = Load::library( 'Model' );

		if ( $this->IsLogin ) {

			$SqlMember = "SELECT * FROM members_tb WHERE id='{$_SESSION["userId"]}'";
			$member    = $Model->load( $SqlMember );
			$agencyID  = $member['fk_agency_id'];

			$sql_charge   = "SELECT sum(credit) AS total_charge FROM credit_detail_tb WHERE type='increase' AND fk_agency_id='{$agencyID}'";
			$charge       = $Model->load( $sql_charge );
			$total_charge = $charge['total_charge'];

			$sql_buy   = "SELECT sum(credit) AS total_buy FROM credit_detail_tb WHERE type='decrease' AND fk_agency_id='{$agencyID}'";
			$buy       = $Model->load( $sql_buy );
			$total_buy = $buy['total_buy'];

			$total_transaction = $total_charge - $total_buy;

			return $total_transaction;
		}
	}
}