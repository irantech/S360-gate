<?php

/**
 * Class resultExternalHotel
 * @property resultExternalHotel $resultExternalHotel
 */
//if(  $_SERVER['REMOTE_ADDR']=='178.131.144.189'  ) {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//   @ini_set('display_errors', 1);
//   @ini_set('display_errors', 'on');
//}
class resultExternalHotel extends apiExternalHotel {

	public $error;
	public $errorMessage;
	public $arrayServices;
	public $countRoom;
	public $rooms;
	public $childrenCount;
	public $adultCount;
	public $IsLogin;
	public $counterId;
	public $serviceDiscount = array();
	public $minPrice;
	public $maxPrice;
	public $loginIdApi;
	public $searchIdApi;
	public $city;
	public $countHotel;
	public $facilities = [ 'MINIBAR', 'TV', 'WI-FI', 'ROOM SERVICE', 'SATELLITE TV' ];
	public $numberOfRooms;

	public function __construct() {
//		functions::insertLog( 'start file => resultExternalHotel', '00000-checkExternalHotel', 'yes' );
		parent::__construct();
		$this->IsLogin = Session::IsLogin();
		if ( $this->IsLogin ) {
			$this->counterId                      = functions::getCounterTypeId( $_SESSION['userId'] );
		} else {
			$this->counterId = '5';
		}

		$expServices         = explode( ";", CLIENT_SERVICES );
		$this->arrayServices = [];
		foreach ( $expServices as $val ) {
			$expVal                                        = explode( ",", $val );
			$this->arrayServices[ $expVal[0] ]['sourceId'] = $expVal[1];
			$this->arrayServices[ $expVal[0] ]['username'] = $expVal[2];
		}

	}

	public function getCity( $countryNameEn, $cityNameEn ) {
		$countryNameEn = str_replace( "-", " ", $countryNameEn );
		$cityNameEn    = str_replace( "-", " ", $cityNameEn );
		$ModelBase     = Load::library( 'ModelBase' );
		$sql           = " SELECT * FROM external_hotel_city_tb WHERE LOWER(country_name_en) = '{$countryNameEn}' AND LOWER(city_name_en) = '{$cityNameEn}' ";
		$result        = $ModelBase->load( $sql );

		return $result;
	}

	public function searchCity( $inputSearchValue , $json = false) {

		$ModelBase = Load::library( 'ModelBase' );
		$sql       = " SELECT 
        external_hotel_city_tb.city_name_en as DepartureCityEn,
        external_hotel_city_tb.city_name_fa as DepartureCityFa,
        external_hotel_city_tb.country_name_en as CountryTitleEn,
        external_hotel_city_tb.country_name_fa as CountryTitleFa,
        country_codes_tb.titleEn AS  CountryEn,
        country_codes_tb.titleFa AS  CountryFa
        FROM external_hotel_city_tb 
 LEFT JOIN country_codes_tb ON external_hotel_city_tb.country_id = country_codes_tb.id
                  WHERE
                    external_hotel_city_tb.country_name_en != 'iran'
                    AND (
                    external_hotel_city_tb.country_name_en LIKE '{$inputSearchValue}%'
                    OR external_hotel_city_tb.country_name_fa LIKE '{$inputSearchValue}%'
                    OR external_hotel_city_tb.city_name_en LIKE '{$inputSearchValue}%'
                    OR external_hotel_city_tb.city_name_fa LIKE '{$inputSearchValue}%'
                    ) limit 0,20
                    ";
//        		if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20'  ) {
//					var_dump($sql);
//					die;
//				}
		$cities    = $ModelBase->select( $sql );
        if($json) {

            foreach ( $cities as $key => $city ) {
                $countryNameEn = strtolower(trim($city['CountryTitleEn']));
                $countryNameEn = str_replace("  ", " ", $countryNameEn);
                $cities[$key]['CountryEn'] = str_replace(" ", "-", $countryNameEn);
                $cityNameEn = str_replace("  ", " ", $city['DepartureCityEn']);
                $cities[$key]['DepartureCityEn'] = str_replace(" ", "-", $cityNameEn);
            }
            return  json_encode($cities);
        }
		$listCity  = '';
		foreach ( $cities as $city ) {
            $country_name_fa = $city['CountryTitleFa'];
            if (isset($city['CountryFa']) && '' != $city['CountryFa']) {
                $country_name_fa = $city['CountryFa'];
            }
			$country_name_en = (!empty($city['CountryTitleEn'])) ? $city['CountryEn'] : $city['CountryTitleEn'];
			$city_name_en    = $city['DepartureCityEn'];
			$city_name_fa    = $city['DepartureCityFa'];

			$listCity      .= '<li class="li-inputSearch-externalHotel" data-json=\''.json_encode([
                    $country_name_fa,
$country_name_en,
$city_name_en   ,
$city_name_fa
                ],256|64).'\'
            onclick="selectCity(' . "'" . $this->convertStringForUrl($country_name_en) . "'" . ',' . "'" . $this->convertStringForUrl($city_name_en) . "'" . ',' . "'" . $country_name_fa . ' - ' . ($city_name_fa ? : $city_name_en) . "'" . ')">'
			                  . '<span>' . $country_name_fa . ' - ' . $city_name_fa . '</span>'
			                  . '<span>' . $country_name_en . ' - ' . $city_name_en . '</span>'
			                  . '</li>';
		}

		return $listCity;
	}
    public function searchCountryCity($params){

        /** @var ModelBase $ModelBase */
        $city = trim( urldecode( $params['inputSearchValue'] ) );

        $request = [];
        foreach ( $params as $key => $param ) {

            $request[ $key ] = functions::checkParamsInput( $param );
        }

        $ModelBase = Load::library( 'ModelBase' );
        $city = functions::arabicToPersian($city);
        $city2 = $city;
        $pos = strpos($city, 'ا');
        if ($pos === 0) {
            $city2 = 'آ'. mb_substr($city,1);
        }

        $clientSql = "SELECT * FROM external_hotel_city_tb
                  WHERE
                    country_name_en != 'iran'
                    AND (
                    country_name_en LIKE '{$city}%'
                    OR country_name_fa LIKE '{$city}%'
                    OR country_name_fa LIKE '{$city2}%'
                    OR city_name_en LIKE '{$city}%'
                    OR city_name_fa LIKE '{$city}%'
                    OR city_name_fa LIKE '{$city2}%'
                    )
                    GROUP BY country_name_en,city_name_en
                    LIMIT 0,20
                    ";
       
        //		return json_encode($clientSql);


        return json_encode( $ModelBase->select( $clientSql ) );
    }
    public function externalHotelCityList( $limit = 6 ) {
       
        $sDate = dateTimeSetting::jdate("Ymd", '', '', '', 'en');
        $model = Load::library('Model');
        $sql = "
                SELECT
                    'reservation' AS type_app,
                    reservationHotel.city AS place_id,
                    reservationCity.id AS city_id,
                    reservationCity.name AS city_name,
                    reservationCity.name_en AS city_name_en,
                    reservationCountry.id AS country_id,
                    reservationCountry.name AS country_name,
                    reservationCountry.name_en AS country_name_en,
                    reservationCountry.`name` AS country_persian_name,
                    (
                SELECT
                    reservationHotelPrice.online_price 
                FROM
                    " . DB_DATABASE . ".reservation_hotel_room_prices_tb AS reservationHotelPrice 
                WHERE
                    reservationHotelPrice.id_hotel = reservationHotel.id 
                    AND reservationHotelPrice.date = '" . $sDatePersian . "' 
                    AND reservationHotelPrice.flat_type = 'DBL' 
                    AND reservationHotelPrice.is_del = 'no' 
                    LIMIT 1
                    ) AS minimum_room_price,
                          (
                SELECT
                    reservationHotelPrice.currency_type 
                FROM
                    " . DB_DATABASE . ".reservation_hotel_room_prices_tb AS reservationHotelPrice 
                WHERE
                    reservationHotelPrice.id_hotel = reservationHotel.id 
                    AND reservationHotelPrice.date = '" . $sDatePersian . "' 
                    AND reservationHotelPrice.flat_type = 'DBL' 
                    AND reservationHotelPrice.is_del = 'no' 
                    LIMIT 1 
                    ) AS currency_type,
                     (
                SELECT
                    reservationHotelPrice.currency_price 
                FROM
                    " . DB_DATABASE . ".reservation_hotel_room_prices_tb AS reservationHotelPrice 
                WHERE
                    reservationHotelPrice.id_hotel = reservationHotel.id 
                    AND reservationHotelPrice.date = '" . $sDatePersian . "' 
                    AND reservationHotelPrice.flat_type = 'DBL' 
                    AND reservationHotelPrice.is_del = 'no' 
                    LIMIT 1 
                    ) AS currency_price,
                    ( SELECT GROUP_CONCAT( reservationHotelRoom.breakfast SEPARATOR '|' ) FROM " . DB_DATABASE . ".reservation_hotel_room_prices_tb AS reservationHotelRoom WHERE reservationHotel.id = reservationHotelRoom.id_hotel ) AS free_breakfast,
                    (
                SELECT
                    GROUP_CONCAT( reservationFacilities.title SEPARATOR '|' )
                FROM
                    " . DB_DATABASE . ".reservation_hotel_facilities_tb AS reservationHotelFacilities
                    INNER JOIN " . DB_DATABASE . ".reservation_facilities_tb AS reservationFacilities ON reservationHotelFacilities.id_facilities = reservationFacilities.id 
                WHERE
                    reservationHotel.id = reservationHotelFacilities.id_hotel 
                    ) AS facilities 
                FROM
                    " . DB_DATABASE . ".reservation_hotel_tb AS reservationHotel
                    INNER JOIN " . DB_DATABASE . ".reservation_city_tb AS reservationCity ON reservationHotel.city = reservationCity.id
                    INNER JOIN " . DB_DATABASE . ".reservation_country_tb AS reservationCountry ON reservationHotel.country = reservationCountry.id
                WHERE
                    reservationHotel.country != '1' 
                    AND reservationHotel.is_del = 'no'
                GROUP BY reservationHotel.city
                LIMIT  " . $limit . "
                ";
        $result = $model->select($sql, 'assoc');
        foreach ($result as $key => $city) {
            $countryNameEn = strtolower(trim($city['country_name_en']));
            $countryNameEn = str_replace("  ", " ", $countryNameEn);
            $countryNameEn = str_replace(" ", "-", $countryNameEn);
            $cityNameEn = strtolower(trim($city['city_name_en']));
            $cityNameEn = str_replace("  ", " ", $cityNameEn);
            $cityNameEn = str_replace(" ", "-", $cityNameEn);

            $result[$key]['DepartureCityEn'] = $cityNameEn;
            $result[$key]['CountryEn'] = $countryNameEn;
            $result[$key]['DepartureCityFa'] = $city['city_name'];
        }

        return $result;
    }
	/*public function numberOfRoomsSearch($rooms)
	{
		$expRooms = explode("R:", trim($rooms));
		$count = 0;
		$this->adultCount = 0;
		$this->childrenCount = 0;
		$this->rooms = [];
		foreach ($expRooms as $room) {
			if ($room != '') {
				$expRoom = explode("-", $room);

				$this->rooms[$count]['AdultCount'] = (int)$expRoom[0];
				$this->rooms[$count]['ChildrenCount'] = (int)$expRoom[1];
				$this->rooms[$count]['ChildrenAge'] = [];

				$this->adultCount += (int)$expRoom[0];
				$this->childrenCount += (int)$expRoom[1];

				if ((int)$expRoom[1] > 0) {
					$age = explode(",", $expRoom[2]);
					for ($i = 0; $i <= count($age); $i++) {

						if (isset($age[$i]) && $age[$i] != '') {
							$this->rooms[$count]['ChildrenAge'][$i] = (int)$age[$i];
						}
					}
				}

				$count++;
			}
		}

		$this->countRoom = count($this->rooms);
	}*/

	public function convertStringForUrl( $string ) {
		$string = strtolower( trim( $string ) );
		$string = str_replace( "  ", " ", $string );
		$string = str_replace( " ", "-", $string );
		$string = str_replace( "'", "", $string );

		return $string;
	}

    public function getHotelsFromDB( $countryNameEn, $cityNameEn, $sDate, $nights,$searched_rooms = null ) {
//        functions::insertLog('start getHotelsFromDB', '00000-checkExternalHotel', 'yes');
		if ( SOFTWARE_LANG == 'en' || SOFTWARE_LANG == 'ar' || substr( $sDate, "0", "4" ) > 2000 ) {
			$sDatePersian = functions::ConvertToJalali( $sDate );
		} else {
			$sDatePersian = $sDate;
		}

		$dateNow      = dateTimeSetting::jdate( "Ymd", '', '', '', 'en' );
		$sDatePersian = str_replace( "-", "", $sDatePersian );
		$sDatePersian = str_replace( "/", "", $sDatePersian );
		if ( trim( $sDatePersian ) >= trim( $dateNow ) ) {

			$countryNameEn = str_replace( "-", " ", $countryNameEn );
			$cityNameEn    = str_replace( "-", " ", $cityNameEn );

			// دسترسی به هتل های رزرواسیون و وب سرویس //

			if ( ( strpos( CLIENT_SERVICES, 'HotelReserveLocal' ) !== false ) && ( strpos( CLIENT_SERVICES, 'HotelPortal' ) !== false ) ) {

				$model = Load::library( 'Model' );
				$sql   = "
                SELECT
                    'reservation' AS type_app,
                    reservationHotel.city AS place_id,
                    reservationCountry.`name` AS country_persian_name,
                    reservationCity.`name` AS city_persian_name,
                    reservationCity.id AS city_id,
                    reservationHotel.id AS hotel_index,
                    reservationHotel.NAME AS hotel_persian_name,
                    reservationHotel.name_en AS hotel_name,
                    CONCAT( '" . ROOT_ADDRESS_WITHOUT_LANG . "/pic/', reservationHotel.logo ) AS image_url,
                    reservationHotel.`comment` AS breifing_description,
                    reservationHotel.star_code AS hotel_stars,
                    reservationHotel.address AS hotel_address,
                    reservationHotel.latitude AS latitude,
                    reservationHotel.longitude AS longitude,
                    reservationHotel.flag_special,
                    (
                SELECT
                    reservationHotelPrice.online_price /* " . $nights . "*/ 
                FROM
                    " . DB_DATABASE . ".reservation_hotel_room_prices_tb AS reservationHotelPrice 
                WHERE
                    reservationHotelPrice.id_hotel = reservationHotel.id 
                    AND reservationHotelPrice.date = '" . $sDatePersian . "' 
                    AND reservationHotelPrice.user_type = '" . $this->counterId . "' 
                    AND reservationHotelPrice.flat_type = 'DBL' 
                    AND reservationHotelPrice.is_del = 'no' 
                    LIMIT 1 
                    ) AS minimum_room_price,
                          (
                SELECT
                    reservationHotelPrice.currency_type /* " . $nights . "*/ 
                FROM
                    " . DB_DATABASE . ".reservation_hotel_room_prices_tb AS reservationHotelPrice 
                WHERE
                    reservationHotelPrice.id_hotel = reservationHotel.id 
                    AND reservationHotelPrice.date = '" . $sDatePersian . "' 
                    AND reservationHotelPrice.user_type = '" . $this->counterId . "' 
                    AND reservationHotelPrice.flat_type = 'DBL' 
                    AND reservationHotelPrice.is_del = 'no' 
                    LIMIT 1 
                    ) AS currency_type,
                    (
                            SELECT
                                reservationHotelPrice.discount
                            FROM
                                reservation_hotel_room_prices_tb AS reservationHotelPrice
                            WHERE
                                reservationHotelPrice.id_hotel = reservationHotel.id
                                AND reservationHotelPrice.date = '" . $sDatePersian . "'
                                AND reservationHotelPrice.user_type = '" . $this->counterId . "'
                                AND reservationHotelPrice.flat_type = 'DBL'
                                AND reservationHotelPrice.is_del = 'no'
                            LIMIT 1
                        ) AS commissionDiscount,
                     (
                SELECT
                    reservationHotelPrice.currency_price /* " . $nights . "*/ 
                FROM
                    " . DB_DATABASE . ".reservation_hotel_room_prices_tb AS reservationHotelPrice 
                WHERE
                    reservationHotelPrice.id_hotel = reservationHotel.id 
                    AND reservationHotelPrice.date = '" . $sDatePersian . "' 
                    AND reservationHotelPrice.user_type = '" . $this->counterId . "' 
                    AND reservationHotelPrice.flat_type = 'DBL' 
                    AND reservationHotelPrice.is_del = 'no' 
                    LIMIT 1 
                    ) AS currency_price,
                    ( SELECT GROUP_CONCAT( reservationHotelRoom.breakfast SEPARATOR '|' ) FROM " . DB_DATABASE . ".reservation_hotel_room_prices_tb AS reservationHotelRoom WHERE reservationHotel.id = reservationHotelRoom.id_hotel ) AS free_breakfast,
                    (
                SELECT
                    GROUP_CONCAT( reservationFacilities.title SEPARATOR '|' )
                FROM
                    " . DB_DATABASE . ".reservation_hotel_facilities_tb AS reservationHotelFacilities
                    INNER JOIN " . DB_DATABASE . ".reservation_facilities_tb AS reservationFacilities ON reservationHotelFacilities.id_facilities = reservationFacilities.id 
                WHERE
                    reservationHotel.id = reservationHotelFacilities.id_hotel 
                    AND reservationHotelFacilities.is_del = 'no'
                    ) AS facilities 
                FROM
                    " . DB_DATABASE . ".reservation_hotel_tb AS reservationHotel
                    INNER JOIN " . DB_DATABASE . ".reservation_city_tb AS reservationCity ON reservationHotel.city = reservationCity.id
                    INNER JOIN " . DB_DATABASE . ".reservation_country_tb AS reservationCountry ON reservationHotel.country = reservationCountry.id 
                WHERE
                    reservationHotel.country != '1' 
                    AND LOWER( reservationCountry.name_en ) = '" . $countryNameEn . "' 
                    AND LOWER( reservationCity.name_en ) = '" . $cityNameEn . "' 
                    AND reservationHotel.is_del = 'no'
                ";
               

			} elseif ( strpos( CLIENT_SERVICES, 'HotelPortal' ) !== false ) {

				$model = Load::library( 'ModelBase' );
				$sql   = "
                    SELECT
                        'externalApi' AS type_app,
                        apiHotel.place_id,
                        apiHotelCity.country_name_fa AS country_persian_name,
                        apiHotelCity.city_name_fa AS city_persian_name,
                        apiHotel.place_id AS city_id,
                        apiHotel.hotel_index,
                        apiHotel.hotel_persian_name,
                        apiHotel.hotel_name,
                        apiHotel.image_url,
                        apiHotel.breifing_description,
                        apiHotel.hotel_stars,
                        apiHotel.hotel_address,
                        (
                    SELECT
                        GROUP_CONCAT( apiHotelRoom.free_breakfast SEPARATOR '|' ) 
                    FROM
                        external_hotel_room_tb AS apiHotelRoom 
                    WHERE
                        apiHotel.hotel_index = apiHotelRoom.hotel_index 
                        ) AS free_breakfast,
                        ( SELECT GROUP_CONCAT( apiHotelFacilities.VALUE SEPARATOR '|' ) FROM external_hotel_facilities_tb AS apiHotelFacilities WHERE apiHotel.hotel_index = apiHotelFacilities.hotel_index ) AS facilities 
                    FROM
                        external_hotel_tb AS apiHotel 
                        INNER JOIN external_hotel_city_tb AS apiHotelCity ON apiHotel.place_id=apiHotelCity.id
                    WHERE
                        LOWER( apiHotel.country_name ) = '" . $countryNameEn . "' 
                        AND LOWER( apiHotel.city_name ) = '" . $cityNameEn . "' 
                        AND apiHotel.hotel_name != '' 
                  ";

			} elseif ( strpos( CLIENT_SERVICES, 'HotelReserveLocal' ) !== false ) {
                $passenger_condition = '' ;

               if(isset($searched_rooms) && !empty($searched_rooms)){
                   $hotel_id = $this->getHotelsByPassengerCount($countryNameEn , $cityNameEn , $searched_rooms);

                   $hotel_id = array_column($hotel_id, 'hotel_index');
                   $hotel_id = implode("','", $hotel_id);

                   $passenger_condition  = "AND reservationHotel.id in ('{$hotel_id}')";

               }
				$model = Load::library( 'Model' );
				$sql   = "
                    SELECT
                        'reservation' AS type_app,
                        reservationHotel.city AS place_id,
                        reservationCountry.`name` AS country_persian_name,
	                    reservationCity.`name` AS city_persian_name,
	                    reservationCity.id AS city_id,
                        reservationHotel.id AS hotel_index,
                        reservationHotel.NAME AS hotel_persian_name,
                        reservationHotel.name_en AS hotel_name,
                        CONCAT( '" . ROOT_ADDRESS_WITHOUT_LANG . "/pic/', reservationHotel.logo ) AS image_url,
                        reservationHotel.`comment` AS breifing_description,
                        reservationHotel.star_code AS hotel_stars,
                        reservationHotel.address AS hotel_address,
                        reservationHotel.longitude AS longitude,
                        reservationHotel.latitude AS latitude,
                        reservationHotel.flag_special,
                        (
                    SELECT
                        reservationHotelPrice.online_price /* " . $nights . "*/  
                    FROM
                        reservation_hotel_room_prices_tb AS reservationHotelPrice 
                    WHERE
                        reservationHotelPrice.id_hotel = reservationHotel.id 
                        AND reservationHotelPrice.date = '" . $sDatePersian . "' 
                        AND reservationHotelPrice.user_type = '" . $this->counterId . "' 
                        AND reservationHotelPrice.flat_type = 'DBL' 
                        AND reservationHotelPrice.is_del = 'no' 
                        LIMIT 1 
                        ) AS minimum_room_price,
                       
                 






                         (
                SELECT
                    reservationHotelPrice.currency_type /* " . $nights . "*/ 
                FROM
                    " . DB_DATABASE . ".reservation_hotel_room_prices_tb AS reservationHotelPrice 
                WHERE
                    reservationHotelPrice.id_hotel = reservationHotel.id 
                    AND reservationHotelPrice.date = '" . $sDatePersian . "' 
                    AND reservationHotelPrice.user_type = '" . $this->counterId . "' 
                    AND reservationHotelPrice.flat_type = 'DBL' 
                    AND reservationHotelPrice.is_del = 'no' 
                    LIMIT 1 
                    ) AS currency_type,
                     (
                SELECT
                    reservationHotelPrice.currency_price /* " . $nights . "*/ 
                FROM
                    " . DB_DATABASE . ".reservation_hotel_room_prices_tb AS reservationHotelPrice 
                WHERE
                    reservationHotelPrice.id_hotel = reservationHotel.id 
                    AND reservationHotelPrice.date = '" . $sDatePersian . "' 
                    AND reservationHotelPrice.user_type = '" . $this->counterId . "' 
                    AND reservationHotelPrice.flat_type = 'DBL' 
                    AND reservationHotelPrice.is_del = 'no' 
                    LIMIT 1 
                    ) AS currency_price,
                    (
                            SELECT
                                reservationHotelPrice.discount
                            FROM
                                reservation_hotel_room_prices_tb AS reservationHotelPrice
                            WHERE
                                reservationHotelPrice.id_hotel = reservationHotel.id
                                AND reservationHotelPrice.date = '" . $sDatePersian . "'
                                AND reservationHotelPrice.user_type = '" . $this->counterId . "'
                                AND reservationHotelPrice.flat_type = 'DBL'
                                AND reservationHotelPrice.is_del = 'no'
                            LIMIT 1
                        ) AS commissionDiscount,
                        ( SELECT GROUP_CONCAT( reservationHotelRoom.breakfast SEPARATOR '|' ) FROM reservation_hotel_room_prices_tb AS reservationHotelRoom WHERE reservationHotel.id = reservationHotelRoom.id_hotel ) AS free_breakfast,
                        (
                    SELECT
                        GROUP_CONCAT( reservationFacilities.title SEPARATOR '|' ) 
                    FROM
                        reservation_hotel_facilities_tb AS reservationHotelFacilities
                        INNER JOIN reservation_facilities_tb AS reservationFacilities ON reservationHotelFacilities.id_facilities = reservationFacilities.id 
                    WHERE
                        reservationHotel.id = reservationHotelFacilities.id_hotel 
                        AND reservationHotelFacilities.is_del = 'no'
                        ) AS facilities 
                    FROM
                        reservation_hotel_tb AS reservationHotel
                        INNER JOIN reservation_city_tb AS reservationCity ON reservationHotel.city = reservationCity.id
                        INNER JOIN reservation_country_tb AS reservationCountry ON reservationHotel.country = reservationCountry.id 
                    WHERE
                        reservationHotel.country != '1' 
                        AND LOWER( reservationCountry.name_en ) = '" . $countryNameEn . "' 
                        AND LOWER( reservationCity.name_en ) = '" . $cityNameEn . "' 
                        " . $passenger_condition. "
                        AND reservationHotel.is_del = 'no' 
                    ";
            } else {
//				functions::insertLog( 'end getHotelsFromDB', '00000-checkExternalHotel', 'yes' );
                $this->error        = true;
                $this->errorMessage = functions::Xmlinformation( 'Noaccesstihspage' );
                return false;
            }
//			functions::insertLog( 'before sql ', '00000-checkExternalHotel', 'yes' );
//              if ($_SERVER['REMOTE_ADDR'] == '93.118.161.174') {
//                var_dump($sql);
//                die();
//            }
            $hotels = $model->select( $sql, 'assoc' );
//			functions::insertLog( 'after sql ', '00000-checkExternalHotel', 'yes' );
//			functions::insertLog( 'end getHotelsFromDB', '00000-checkExternalHotel', 'yes' );
            return $hotels;
        } else {
//			functions::insertLog( 'end getHotelsFromDB', '00000-checkExternalHotel', 'yes' );
            $this->error        = true;
            $this->errorMessage = functions::Xmlinformation( 'Nohotel' );
            return false;
        }
    }
    public function getHotelsByPassengerCount($countryNameEn , $cityNameEn ,$searchRooms ) {
        $passengers = json_decode($searchRooms , true);
        $children = array() ;
        $adult = array() ;
        $roomCount = count($passengers);
        foreach ($passengers as $key => $passenger ) {
            foreach ($passenger as $pass) {
                if($pass['PassengerAge'] <= 12 ) {
                    $children[$key] ++ ;
                }else{
                    $adult[$key] ++ ;
                }
            }
        }
        $max_children = max($children) ;
        $max_adult = max($adult) ;
        $model = Load::library( 'Model' );
        $sql   = "
                    SELECT
                        reservationHotel.id AS hotel_index
                    FROM
                        reservation_hotel_tb AS reservationHotel
                        INNER JOIN reservation_city_tb AS reservationCity ON reservationHotel.city = reservationCity.id
                        INNER JOIN reservation_country_tb AS reservationCountry ON reservationHotel.country = reservationCountry.id 
                        INNER JOIN reservation_hotel_room_tb AS reservationHotelRoom ON reservationHotel.id = reservationHotelRoom.id_hotel
                        INNER JOIN reservation_hotel_room_prices_tb AS reservationHotelRoomPrice ON reservationHotel.id = reservationHotelRoomPrice.id_hotel 
                    WHERE
                        reservationHotel.country != '1' 
                        AND LOWER( reservationCountry.name_en ) = '" . $countryNameEn . "' 
                        AND LOWER( reservationCity.name_en ) = '" . $cityNameEn . "' 
                        AND (reservationHotelRoom.room_capacity + reservationHotelRoom.maximum_extra_beds) >= '{$max_adult}' AND reservationHotelRoom.maximum_extra_chd_beds >= '{$max_children}'
                        AND reservationHotelRoomPrice.remaining_capacity >= '" . $roomCount . "'  
                        AND reservationHotel.is_del = 'no'  
                        GROUP BY reservationHotel.id 
                    ";
        return $model->select($sql);
	}

	public function appendToArrayFacilities( $value ) {
		if ( ! in_array( $value, $this->facilities ) ) {
			$this->facilities[] = $value;
		}
	}

	public function getFacilityRoomPersian( $facilityEn ) {
		$facilityEn = strtoupper( $facilityEn );
		switch ( $facilityEn ) {
			case 'ROOM ONLY':
				return functions::Xmlinformation( 'Onlyroom' );
				break;
			case 'CONTINENTAL BREAKFAST':
				return functions::Xmlinformation( 'Withbreakfast' );
				break;
			case 'BREAKFAST BUFFET':
				return functions::Xmlinformation( 'Breakfastbuffet' );
				break;
			case 'BREAKFAST':
				return functions::Xmlinformation( 'Breakfast' );
				break;
			case 'BED AND BREAKFAST' || 'BED & BREAKFAST' || 'BED&BREAKFAST':
				return functions::Xmlinformation( 'Bedandbreakfast' );
				break;
			case 'HALF BOARD':
				return functions::Xmlinformation( 'Boarddirectors' );
				break;
			case 'FULL BOARD':
				return functions::Xmlinformation( 'Completeboard' );
				break;
			case 'LODGING ONLY':
				return functions::Xmlinformation( 'Lodgingonly' );
				break;
			default :
				return $facilityEn;
				break;
		}

	}

	public function setTemproryHotel( $param ) {

		$factorNumber = substr( time(), 0, 3 ) . mt_rand( 0000, 9999 ) . substr( time(), 7, 10 );
		$resultHotel  = $this->getHotelDetail( $param['hotelId'], $param['searchId'], $param['loginId'] );
		if ( ! empty( $resultHotel ) ) {
			$dataInsert['factor_number']      = $factorNumber;
			$dataInsert['login_id']           = $param['loginId'];
			$dataInsert['search_id']          = $param['searchId'];
			$dataInsert['search_rooms']       = $param['searchRooms'];
			$dataInsert['start_date']         = $param['startDate'];
			$dataInsert['end_date']           = $param['endDate'];
			$dataInsert['night']              = $param['nights'];
			$dataInsert['city_name']          = $resultHotel['CityName'];
			$dataInsert['country_name']       = $resultHotel['CountryName'];
			$dataInsert['hotel_id']           = $resultHotel['HotelIndex'];
			$dataInsert['hotel_name']         = $resultHotel['HotelName'];
			$dataInsert['hotel_persian_name'] = $resultHotel['HotelPersianName'];
			$dataInsert['hotel_type']         = $resultHotel['HotelType'];
			$dataInsert['image_url']          = $resultHotel['ImageURL'];
			$dataInsert['hotel_descriptions'] = $resultHotel['BreifingDescription'];
			$dataInsert['hotel_stars']        = $resultHotel['HotelStars'];
			$dataInsert['hotel_address']      = $resultHotel['HotelAddress'];
			foreach ( $resultHotel['RoomsDetail'] as $room ) {
				if ( $room['ReservePackageID'] == $param['roomId'] ) {
					$dataInsert['room_id']   = $param['roomId'];
					$dataInsert['room_list'] = json_encode( $room['RoomList'] );
					break;
				}
			}
			$resultRoom = $this->getRoomHotel( $param );
			if ( ! empty( $resultRoom ) && $resultRoom['FullAmount'] > 0 ) {
				$dataInsert['price_detail_id']     = $resultRoom['PriceDetailID'];
				$dataInsert['full_amount']         = $resultRoom['FullAmount'];
				$dataInsert['full_waged_amount']   = $resultRoom['FullWagedAmount'];
				$dataInsert['member_profit']       = $resultRoom['MemberProfit'];
				$dataInsert['room_count']          = $resultRoom['RoomCount'];
				$dataInsert['website_commission']  = $resultRoom['WebsiteCommission'];
				$dataInsert['company_commission']  = $resultRoom['CompanyCommission'];
				$dataInsert['employee_commission'] = $resultRoom['EmployeeCommission'];
				$dataInsert['service_amount']      = $resultRoom['ServiceAmount'];
				$dataInsert['service_provider_id'] = $resultRoom['ServiceProviderID'];
				$dataInsert['hotel_rule']          = $resultRoom['HotelRule'];
				$dataInsert['cancel_rule']         = json_encode( $resultRoom['CancelationRules'] );
				$dataInsert['create_date_in']      = dateTimeSetting::jtoday();
				$dataInsert['create_time_in']      = date( 'H:i:s' );

				$Model = Load::library( 'Model' );
				$Model->setTable( 'temprory_external_hotel_tb' );
				$resInsert = $Model->insertLocal( $dataInsert );

				if ( $resInsert ) {
					return 'success:' . $factorNumber;
				} else {
					return 'error';
				}


			} else {
				return 'error';
			}


		} else {
			return 'error';
		}


	}

	public function getHotelDetail( $hotelId, $searchIdApi, $loginIdApi ) {
		$dataRequest['HotelIndex']      = (int) $hotelId;
		$dataRequest['SearchID']        = $searchIdApi;
		$dataRequest['MemberSessionID'] = $loginIdApi;
		$dataRequest['UserName']        = $this->arrayServices['HotelPortal']['username'];

		$jsonData    = json_encode( $dataRequest );
		$resultHotel = parent::hotelDetail( $jsonData );
		if ( isset( $resultHotel['ErrorDetail'] ) && $resultHotel['ErrorDetail']['Code'] != '' ) {
			$this->error        = true;
			$this->errorMessage = 'متاسفانه دسترسی به اطلاعات هتل امکان پذیر نمیباشد، لطفا با پشتیبانی تماس بگیرید.';
		} else {
			return $resultHotel;
		}
	}

	public function getRoomHotel( $param ) {
		$dataRequest['HotelIndex']      = (int) $param['hotelId'];
		$dataRequest['RoomIndex']       = (int) $param['roomId'];
		$dataRequest['SearchID']        = $param['searchId'];
		$dataRequest['MemberSessionID'] = $param['loginId'];
		$dataRequest['UserName']        = $this->arrayServices['HotelPortal']['username'];

		$jsonData    = json_encode( $dataRequest );
		$resultHotel = parent::hotelPriceDetail( $jsonData );
		if ( isset( $resultHotel['ErrorDetail'] ) && $resultHotel['ErrorDetail']['Code'] != '' ) {
			$this->error        = true;
			$this->errorMessage = 'متاسفانه دسترسی به اطلاعات هتل امکان پذیر نمیباشد، لطفا با پشتیبانی تماس بگیرید.';
		} else {
			return $resultHotel;
		}
	}

	public function getPreInvoice( $factorNumber ) {
		$Model             = Load::library( 'Model' );
		$sql               = " SELECT * FROM temprory_external_hotel_tb WHERE factor_number = '{$factorNumber}' ";
		$preInvoiceReserve = $Model->Load( $sql, 'assoc' );

		if ( ! empty( $preInvoiceReserve ) ) {
			//$this->numberOfRoomsSearch($preInvoiceReserve['search_rooms']);
			$this->numberOfRooms              = functions::numberOfRoomsExternalHotelSearch( $preInvoiceReserve['search_rooms'] );
			$preInvoiceReserve['room_list']   = json_decode( $preInvoiceReserve['room_list'], true );
			$preInvoiceReserve['cancel_rule'] = json_decode( $preInvoiceReserve['cancel_rule'], true );

			return $preInvoiceReserve;
		} else {
			$this->error        = true;
			$this->errorMessage = 'متاسفانه دسترسی به اطلاعات هتل امکان پذیر نمیباشد، لطفا با پشتیبانی تماس بگیرید.';
		}
	}

	public function setHotelPreReserve( $factorNumber ) {
		$Model     = Load::library( 'Model' );
		$ModelBase = Load::library( 'ModelBase' );


		$resultHotel = $this->hotelPreReserve( $factorNumber );
		if ( isset( $resultHotel['ErrorDetail']['Code'] ) && $resultHotel['ErrorDetail']['Code'] != '' ) {

			$result['result']  = 'error';
			$result['message'] = $resultHotel['ErrorDetail']['MessagePersian'];

		} elseif ( isset( $resultHotel['PaymentCode'] ) && $resultHotel['PaymentCode'] != '' ) {

			$dataUpdateBook['status']            = "PreReserve";
			$dataUpdateBook['voucher_number']    = $resultHotel['PaymentCode'];
			$dataUpdateBook['voucher_url']       = $resultHotel['PaymentURL'];
			$dataUpdateBook['total_price_api']   = $resultHotel['FullPaymentAmount'];
			$dataUpdateBook['payment_date']      = Date( 'Y-m-d H:i:s' );
			$dataUpdateBook['creation_date_int'] = time();

			$condition = " factor_number = '{$factorNumber}' ";
			$Model->setTable( "book_hotel_local_tb" );
			$resUpdate[] = $Model->update( $dataUpdateBook, $condition );

			$ModelBase->setTable( "report_hotel_tb" );
			$resUpdate[] = $ModelBase->update( $dataUpdateBook, $condition );

			if ( in_array( '0', $resUpdate ) ) {
				$result['result']  = 'error';
				$result['message'] = 'خطا در  تغییرات';
			} else {
				$result['result']  = 'success';
				$result['message'] = 'تغییرات با موفقیت انجام شد';
			}


		} else {
			$result['result']  = 'error';
			$result['message'] = 'خطا در  تغییرات';
		}

		return json_encode( $result );

	}

	public function hotelPreReserve( $factorNumber ) {
		$Model         = Load::library( 'Model' );
		$sql           = " SELECT * FROM book_hotel_local_tb WHERE factor_number='{$factorNumber}' ";
		$hotelReserves = $Model->select( $sql, 'assoc' );

		$dataRequest['UserName']          = $this->arrayServices['HotelPortal']['username'];
		$dataRequest['LoginID']           = $hotelReserves[0]['login_id'];
		$dataRequest['CallBackURL']       = 'https://pg.sairosoft.com/payment/check/{{' . $factorNumber . '}}';
		$dataRequest['PaymentTypeID']     = 1;
		$dataRequest['PaymentCode']       = '';
		$dataRequest['ServiceName']       = 'HOTEL';
		$dataRequest['MemberDescription'] = '';
		$dataRequest['PriceDetailID']     = $hotelReserves[0]['hotel_room_prices_id'];
		$dataRequest['Description']       = '';

		$dataRequestBookArray['TestMode']    = true;
		$dataRequestBookArray['Nationality'] = 'IR';
		if ( ( isset( $_SERVER["HTTP_HOST"] ) && strpos( $_SERVER["HTTP_HOST"], '192.168.1.100' ) !== false )
		     || ( isset( $_SERVER["HTTP_HOST"] ) && strpos( $_SERVER["HTTP_HOST"], 'online.1011.ir' ) !== false )
		     || ( isset( $_SERVER["HTTP_HOST"] ) && strpos( $_SERVER["HTTP_HOST"], 'agency.1011.ir' ) !== false )
		     || ( isset( $_SERVER["HTTP_HOST"] ) && strpos( $_SERVER["HTTP_HOST"], 'test.1011.ir' ) !== false ) ) {//local && test

			$dataRequestBookArray['ContactInfo']['Email']           = 'info@iran-tech.com';
			$dataRequestBookArray['ContactInfo']['CellphoneNumber'] = '09222014065';
			$dataRequestBookArray['ContactInfo']['PhoneNumber']     = '09222014065';
			$dataRequestBookArray['ContactInfo']['Address']         = 'Tehran';

		} else {
			$dataRequestBookArray['ContactInfo']['Email']           = 'info@iran-tech.com';
			$dataRequestBookArray['ContactInfo']['CellphoneNumber'] = '09123493154';
			$dataRequestBookArray['ContactInfo']['PhoneNumber']     = '09123493154';
			$dataRequestBookArray['ContactInfo']['Address']         = 'Tehran';
		}

		$passengerNumber = 0;
		$roommate        = $hotelReserves[0]['roommate'] - 1;
		foreach ( $hotelReserves as $k => $passenger ) {
			$roomNumber = $passenger['roommate'] - 1;
			if ( $k > 0 && $roommate != $roomNumber ) {
				$passengerNumber = 0;
				$roommate        = $passenger['roommate'] - 1;
			}
			$dataRequestBookArray['RoomList'][ $roomNumber ][ $passengerNumber ]['FirstName']        = $passenger['passenger_name'];
			$dataRequestBookArray['RoomList'][ $roomNumber ][ $passengerNumber ]['LastName']         = $passenger['passenger_family'];
			$dataRequestBookArray['RoomList'][ $roomNumber ][ $passengerNumber ]['FirstNameEnglish'] = $passenger['passenger_name_en'];
			$dataRequestBookArray['RoomList'][ $roomNumber ][ $passengerNumber ]['LastNameEnglish']  = $passenger['passenger_family_en'];
			$dataRequestBookArray['RoomList'][ $roomNumber ][ $passengerNumber ]['Gender']           = true;
			$dataRequestBookArray['RoomList'][ $roomNumber ][ $passengerNumber ]['PassengerType']    = ( $passenger['passenger_age'] == 'Adt' ) ? 'ADULT' : 'CHILDREN';
			$dataRequestBookArray['RoomList'][ $roomNumber ][ $passengerNumber ]['Age']              = ( $passenger['passenger_age'] == 'Adt' ) ? 30 : (int) $passenger['passenger_birthday'];
			$passengerNumber ++;
		}

		$jsonBookArray               = json_encode( $dataRequestBookArray );
		$dataRequest['BookArray']    = (string) $jsonBookArray;
		$dataRequest['ExteraAgency'] = 0;

		$jsonData = json_encode( $dataRequest );
		functions::insertLog( $factorNumber . ' => : ' . $jsonData, 'preReserveExternalHotel' );
		$resultHotel = parent::hotelPreReserve( $jsonData );
		functions::insertLog( $factorNumber . ' => : ' . json_encode( $resultHotel, true ), 'preReserveExternalHotel' );
		if ( ! empty( $resultHotel ) ) {
			return $resultHotel;
		} else {
			return false;
		}

	}

	public function hotelReserve( $factorNumber ) {
		$Model         = Load::library( 'Model' );
		$sql           = " SELECT * FROM book_hotel_local_tb WHERE factor_number='{$factorNumber}' ";
		$hotelReserves = $Model->load( $sql, 'assoc' );

		$dataRequest['UserName']        = $this->arrayServices['HotelPortal']['username'];
		$dataRequest['PaymentCode']     = $hotelReserves['voucher_number'];
		$dataRequest['MemberSessionID'] = $hotelReserves['login_id'];

		$jsonData    = json_encode( $dataRequest );
		$resultHotel = parent::hotelReserve( $jsonData );
		if ( ! isset( $resultHotel['ErrorDetail'] ) ) {
			return $resultHotel;
		} else {
			return false;
		}

	}

	public function productCancelDetail( $factorNumber ) {

		$Model         = Load::library( 'Model' );
		$sql           = " SELECT * FROM book_hotel_local_tb WHERE factor_number='{$factorNumber}' ";
		$hotelReserves = $Model->load( $sql, 'assoc' );

		$dataRequest['UserName']        = $this->arrayServices['HotelPortal']['username'];
		$dataRequest['EmailAddress']    = 'info@iran-tech.com';
		$dataRequest['FNPPNRCode']      = $hotelReserves['request_number'];
		$dataRequest['OtherData']       = ' ';
		$dataRequest['MemberSessionID'] = $hotelReserves['login_id'];

		$jsonData     = json_encode( $dataRequest );
		$resultCancel = parent::productCancelationDetail( $jsonData );

		$result = [];
		if ( ! empty( $resultCancel ) && $resultCancel['IsRefundable'] == true ) {

			$result['error'] = false;
			if ( $resultCancel['ErrorMessage'] == '-1' ) {
				$result['message'] = 'کاربر گرامی، امکان کنسل شدن رزرو وجود ندارد.';

			} elseif ( $resultCancel['ErrorMessage'] == '0' ) {
				$result['message'] = 'کاربر گرامی، درصد کنسلی تا تاریخ ' . $resultCancel['MaxAge'] . '؛ ' . $resultCancel['PaidAmount'] . ' ریال میباشد.';
				$result['message'] .= ' و پس از گذشت این تاریخ، جریمه کنسلی تغییر میکند.';

			} else {

				$result['message'] = 'کاربر گرامی، درصد کنسلی تا تاریخ ' . $resultCancel['MaxAge'] . '؛ ' . $resultCancel['RefundedAmount'] . ' ریال میباشد.';
				$result['message'] .= ' و پس از گذشت این تاریخ، جریمه کنسلی تغییر میکند.';
			}


		} else {
			$result['error']   = true;
			$result['message'] = ( ! empty( $resultCancel['ErrorMessage']['TitlePersian'] ) ) ? $resultCancel['ErrorMessage']['TitlePersian'] : 'کاربر گرامی امکان کنسل شدن رزرو وجود ندارد.';
		}

		return $result;
	}

	public function productCancel( $param ) {
		$Model         = Load::library( 'Model' );
		$sql           = " SELECT * FROM book_hotel_local_tb WHERE factor_number='{$param['factorNumber']}' ";
		$hotelReserves = $Model->load( $sql, 'assoc' );

		$dataRequest['UserName']        = $this->arrayServices['HotelPortal']['username'];
		$dataRequest['EmailAddress']    = 'info@iran-tech.com';
		$dataRequest['FNPPNRCode']      = $hotelReserves['request_number'];
		$dataRequest['OtherData']       = ' ';
		$dataRequest['MemberSessionID'] = $hotelReserves['login_id'];

		$jsonData     = json_encode( $dataRequest );
		$resultCancel = parent::productCancelation( $jsonData );

		echo Load::plog( $resultCancel );

		if ( ! empty( $resultCancel ) && $resultCancel['IsStarted'] == true ) {

			$data['invoice_item_id_cancel'] = $resultCancel['InvoiceItemID'];
			$data['status']                 = 'Cancelled';

			$condition = " factor_number = '{$param['factorNumber']}' ";
			$Model->setTable( "book_hotel_local_tb" );
			$resUpdate[] = $Model->update( $data, $condition );

			$ModelBase = Load::library( 'ModelBase' );
			$ModelBase->setTable( "report_hotel_tb" );
			$resUpdate[] = $ModelBase->update( $data, $condition );

			if ( in_array( '0', $resUpdate ) ) {

				return 'error : خطا در  تغییرات.';
			} else {

				return 'success : تغییرات با موفقیت انجام شد';
			}


		} else {
			return 'error : ' . ( ! empty( $resultCancel['ErrorMessage']['TitlePersian'] ) ) ? $resultCancel['ErrorMessage']['TitlePersian'] : 'خطایی در کنسل شدن رزرو به وجود آمده';
		}


	}

    public function findCityNameById($id) {
        return $this->getModel('hotelCitiesModel')->get()->where('id' , $id)->find();
    }
}
