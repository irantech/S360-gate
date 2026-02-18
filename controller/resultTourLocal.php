<?php

class resultTourLocal extends clientAuth {

	public $IsLogin;
	public $counterId;
	public $error;
	public $errorMessage;
	public $listTour = array();
	public $listSuggestedTours = array();
	public $listAirline = array();
	public $listRegion = array();
	public $arrayTour = array();
	public $isUserComments = false;
	public $minPrice;
	public $maxPrice;
	public $countTour;
	public $titlePageSearch;
	public $portalServiceDiscount = array();
	public $localServiceDiscount = array();
	public $counter_types = array();

	public $info_api = array();
    public $info_access = array();

	public function __construct() {

        $this->info_access = $this->getAccessTourWebService();

        if($this->info_access){
            $this->info_api = new tourApi($this->info_access);
        }
		$this->IsLogin = Session::IsLogin();


		if ( $this->IsLogin ) {
			$this->counterId = functions::getCounterTypeId( $_SESSION['userId'] );
		} else {
			$this->counterId = '5';
		}
		$this->portalServiceDiscount['public']  = functions::ServiceDiscount( $this->counterId, 'PublicPortalTour' );
		$this->portalServiceDiscount['private'] = functions::ServiceDiscount( $this->counterId, 'PrivatePortalTour' );
		$this->localServiceDiscount['public']   = functions::ServiceDiscount( $this->counterId, 'PublicLocalTour' );
		$this->localServiceDiscount['private']  = functions::ServiceDiscount( $this->counterId, 'PrivateLocalTour' );

	}


	public function accessReservationTour() {
        return parent::reservationTourAuth();
	}

	public static function prePaymentCalculate( $price, $pre_payment_percentage )  {
		//        if ($pre_payment_percentage == 0) return '0';
        return (( $price * $pre_payment_percentage ) / 100);
	}


	// بازگرداندن لیست تمامی کشور های ثبت شده درون سیستم
	function getAllCountry( $tourType = null, $route = null  , $tourCategory = null , $city_id = null , $country_id = null) {

		$dateNow = dateTimeSetting::jdate( "Ymd", '', '', '', 'en' );
		$Model   = Load::library( 'Model' );

		if ( isset( $route ) && $route == 'dept' ) {
			$sql = " SELECT
                  C.id, C.name,C.name_en
              FROM
                  reservation_country_tb AS C
                  INNER JOIN reservation_tour_tb AS T ON T.origin_country_id = C.id
              WHERE
                  T.is_del = 'no' AND T.is_show = 'yes' AND T.start_date > '{$dateNow}'
              ";

			if ( isset( $tourType ) && $tourType == 'external' ) {
				$sql .= " AND C.id = '1' ";
			}

		} elseif ( isset( $route ) && $route == 'return' ) {
			$sql = " SELECT
                  C.id, C.name, C.name_en, C.abbreviation
              FROM
                  reservation_country_tb AS C
                  INNER JOIN reservation_tour_rout_tb AS TR ON C.id=TR.destination_country_id
                  INNER JOIN reservation_tour_tb AS T ON T.id = TR.fk_tour_id
                  INNER JOIN reservation_city_tb AS CR ON CR.id = T.origin_city_id
              WHERE
                   T.is_del = 'no'
                  AND CR.is_del = 'no'
                  AND T.is_show = 'yes'
                   AND TR.is_del = 'no'
                   AND TR.tour_title = 'dept'
                   AND T.start_date > '{$dateNow}'
              ";

            if(isset( $country_id ) && !empty($country_id)){
                $sql .= " AND T.origin_country_id = '{$country_id}' ";
            }else{
                $sql .= " AND T.origin_country_id = '1' ";
            }

			if ( isset( $tourType ) && $tourType == 'external' ) {
				$sql .= " AND C.id != '1' ";
			}

            if ( isset( $city_id ) && !empty($city_id) ) {
                $sql .= " AND T.origin_city_id = '{$city_id}' ";
            }else{
                $sql .= " AND CR.id  = '1' ";
            }
		}
        if(isset($tourCategory) && !empty($tourCategory) && $tourCategory!= 'all'  ) {

            $sql .= " AND T.tour_type_id LIKE '%" . '"' . $tourCategory . '"' . "%' ";
        }

		$sql    .= "
            GROUP BY C.id
            ORDER BY T.id DESC
          ";

		$result = $Model->select( $sql );

        if($this->info_access){
            $providers = $this->getModel('providersTourModel')->get()->where('client_id',$this->info_access['clientId'])->find();


            $result_api = $this->getController('admin')->ConectDbClient($sql, json_decode($providers['providers'],true)[0], "SelectAll", "", "", "");

            $countries = [];
            foreach ($result as $item) {
                $countries[] = $item['name_en'];
            }
            foreach ($result_api as $item) {
                if(!in_array($item['name_en'],$countries)){
                    $result[] = $item ;
                }
            }


//            if($_SERVER['REMOTE_ADDR']=='84.241.4.20'){
//                echo json_encode($result,256|64); die();
//            }
        }
		return $result;
	}

	// بازگرداندن لیست تمامی شهر های ثبت شده درون سیستم
    function getAllCity( $idCountry = null, $tourType = null, $route = null ) {

        $dateNow = dateTimeSetting::jdate( "Ymd", '', '', '', 'en' );
        $Model   = Load::library( 'Model' );
        if ( $route == 'dept' ) {

            $sql = " SELECT
                      C.id, C.name,C.name_en
                  FROM
                      reservation_city_tb AS C
                      INNER JOIN reservation_tour_tb AS T ON C.id = T.origin_city_id
                  WHERE
                      T.is_del = 'no' AND T.is_show = 'yes' AND T.start_date > '{$dateNow}'
                  ";

            if ( isset( $tourType ) && $tourType == 'external' ) {
                $sql .= " AND C.id_country = '1' ";
            }else if(isset( $tourType ) && !empty($tourType) && $tourType != "all" ) {
                $sql .= " AND T.tour_type_id LIKE '%" . '"' . $tourType . '"' . "%' ";
            }

        } elseif ( $route == 'return' ) {

            $sql = " SELECT
                      C.id, C.name
                  FROM
                      reservation_city_tb AS C
                      INNER JOIN reservation_tour_rout_tb AS TR ON C.id = TR.destination_city_id 
                      INNER JOIN reservation_tour_tb AS T ON T.id = TR.fk_tour_id
                  WHERE
                      T.is_del = 'no' AND T.is_show = 'yes' AND TR.is_del = 'no' AND T.start_date > '{$dateNow}'
                  ";

            if ( isset( $tourType ) && $tourType == 'external' ) {
                $sql .= " AND C.id_country != '1' ";
            }else if(isset( $tourType ) && !empty($tourType) && $tourType != "all") {
                $sql .= " AND T.tour_type_id LIKE '%" . '"' . $tourType . '"' . "%' ";
            }
        }
        if ( isset( $idCountry ) && is_numeric( $idCountry ) ) {
            $sql .= " AND C.id_country = '{$idCountry}' ";
        }
        $sql    .= "
            GROUP BY C.id
            ORDER BY T.id DESC
          ";

        $result = $Model->select( $sql );
        if($this->info_access){
            $providers = $this->getModel('providersTourModel')->get()->where('client_id',$this->info_access['clientId'])->find();


            $result_api = $this->getController('admin')->ConectDbClient($sql, json_decode($providers['providers'],true)[0], "SelectAll", "", "", "");

            $cities = [];
            foreach ($result as $item) {
                $cities[] = $item['name_en'];
            }
            foreach ($result_api as $item) {
                if(!in_array($item['name_en'],$cities)){
                    $result[] = $item ;
                }
            }

//             if($_SERVER['REMOTE_ADDR']=='84.241.4.20'){
//                echo json_encode($result_api,256|64); die();
//            }
        }
        return $result;
    }


    // بازگرداندن لیست تمامی منطقه های ثبت شده درون سیستم
	function getAllRegion( $idCity = null, $tourType = null, $route = null ) {
		$dateNow = dateTimeSetting::jdate( "Ymd", '', '', '', 'en' );
		$Model   = Load::library( 'Model' );
		$sql     = "SELECT * FROM reservation_region_tb WHERE 1=1 ";

		if ( $route == 'dept' ) {

			$sql = " SELECT
                      R.id, R.name
                  FROM
                      reservation_region_tb AS R
                      INNER JOIN reservation_tour_tb AS T ON R.id=T.origin_region_id
                  WHERE
                      T.is_del = 'no' AND T.is_show = 'yes' AND T.start_date > '{$dateNow}'
                  ";
		} elseif ( $route == 'return' ) {

			$sql = " SELECT
                      R.id, R.name
                  FROM
                      reservation_region_tb AS R
                      INNER JOIN reservation_tour_rout_tb AS TR ON R.id=TR.destination_region_id
                      INNER JOIN reservation_tour_tb AS T ON T.id = TR.fk_tour_id
                  WHERE
                      T.is_del = 'no' AND T.is_show = 'yes' AND TR.is_del = 'no' AND T.start_date > '{$dateNow}'
                  ";
		}
		if ( isset( $idCity ) && is_numeric( $idCity ) ) {
			$sql .= " AND R.id_city = '{$idCity}' ";
		}
		$sql    .= "
            GROUP BY R.id
            ORDER BY T.id DESC
          ";
		$result = $Model->select( $sql );

		return $result;
	}


	#region listTour
	public function listTour( $limit, $special = null ) {
		$date             = dateTimeSetting::jtoday( '' );
		$Model            = Load::library( 'Model' );
		$conditionSpecial = '';
		if ( isset( $special ) && $special == 'yes' ) {
			$conditionSpecial = " AND is_special = 'yes' ";
		}
		$sql  = " SELECT *
                     FROM 
                        reservation_tour_tb 
                     WHERE 
                        is_del = 'no' AND is_show = 'yes' AND start_date > '{$date}' {$conditionSpecial}
                     GROUP BY tour_code 
                     ORDER BY id DESC 
                     {$limit}";
		$tour = $Model->select( $sql );

		return $tour;
	}

	#endregion

	public function showListTour() {

		$logged_in        = Session::IsLogin();
		$has_access       = functions::checkClientConfigurationAccess( 'b2b_show_access', CLIENT_ID );
		$show_result      = true;
		$is_counter       = false;
		$show_login_popup = false;
		$user_details     = [];
		$error_message    = '';
		/** @var members_tb $model */
		$model = Load::model( 'members' );
		if ( $logged_in ) {
			$user_details = $model->get( Session::getUserId() );
		}

		if ( $has_access ) {
			$show_result = false;
			if ( ! $logged_in ) {
				$show_login_popup = true;
			}else{
				if(isset( $user_details['fk_counter_type_id'] ) && $user_details['fk_counter_type_id'] != 5 ) {
					$is_counter  = true;
					$show_result = true;
				}
				if($user_details['fk_counter_type_id'] == 5){
					$error_message = functions::Xmlinformation('B2bNoAccessMessage')->__toString();
				}
			}
		}

		$return = [
			'show_result'      => $show_result,
			'logged_in'        => $logged_in,
			'has_access'       => $has_access,
			'show_login_popup' => $show_login_popup,
			'is_counter'       => $is_counter,
			'error_message'    => $error_message,
		];

		return json_encode( $return,256|64 );

	}

	#region listTourTravelProgram
	public function listTourTravelProgram( $TourId,$is_api=null ) {

        if($is_api){
            return $this->info_api->getListTourTravelProgramApi(['id_same'=>$TourId]);
        }
		$Model                     = Load::library( 'Model' );
		$sql                       = " SELECT *
                     FROM 
                        tourtravelprogram_tb 
                     WHERE 
                        tour_id = '{$TourId}'";

		$tourTravelProgram         = $Model->load( $sql );
		$data                      = $tourTravelProgram['data'];
		$tourTravelProgram['data'] = preg_replace( "/\r\n|\r|\n/", '<br/>', $data );

		return $tourTravelProgram;
	}
	#endregion


    public function getCounterTypes() {
        $counter_type_controller=$this->getController('counterType');
        $counter_type_controller->getAll('all');

        $this->counter_types=$counter_type_controller->list;

    }

	#region listTourBySearch
	public function listTourBySearch( $param = array() ) {

        if($this->info_api){
            $destination_type = 'all' ;
            if(SEARCH_TOUR_TYPE != 'all'){
                if(SEARCH_TOUR_TYPE =='external'){
                    $destination_type = 'external';
                }
                if(SEARCH_TOUR_TYPE =='internal'){
                    $destination_type = 'internal';
                }
            }
            $data_request_search = [
                "origin_country_id" => $param['originCountryId'],
                "origin_city_id" => $param['originCityId'],
                "destination_country_id" => $param['destinationCountryId'],
                "destination_city_id" => $param['destinationCityId'],
                "start_date" => $param['searchDate'],
                "tourTypeId" => $param['tourTypeId'],
                "language" => SOFTWARE_LANG,
                "destination_type" => $destination_type,
                "is_special" => $param['is_special']
            ];

            $tours_api = $this->info_api->search($data_request_search);

        }

		if ( $this->accessReservationTour() ) {
            $this->getCounterTypes();

			$Model = Load::library( 'Model' );

			/*if (SOFTWARE_LANG == 'en' || SOFTWARE_LANG == 'ar' || substr($param['searchDate'], "0", "4") > 2000){
				$param['searchDate'] = functions::ConvertToJalali($param['searchDate']);
			}*/


			if ( SOFTWARE_LANG == 'fa' ) {
				$dateNow = dateTimeSetting::jdate( "Ymd", '', '', '', 'en' );
			} else {
				$dateNow = date( "Ymd", time());
			}
            if($param['searchDate'] != 'all') {
                $SDate = str_replace("-", "", $param['searchDate']);
            }else{
                $SDate = $dateNow ;
            }

            $controllerPublic = Load::controller( 'reservationPublicFunctions' );
            $date2Check       = $controllerPublic->dateNextFewDays( $SDate, ' + 120' );


            if ( trim( $date2Check ) >= trim( $dateNow ) ) {
                $this->error        = false;
                $this->errorMessage = '';
            } else {
                $this->error        = true;
                $this->errorMessage = functions::Xmlinformation( "TourNotCurrentlyAvailable" ) . '<br>' . functions::Xmlinformation( "PleaseSearchDateCountryCityTypeTour" );
            }





//			$date1 = $controllerPublic->dateNextFewDays( $param['searchDate'], ' - 120' );
//			$date2 = $controllerPublic->dateNextFewDays( $param['searchDate'], ' + 120' );
            if(SOFTWARE_LANG == 'fa') {
                if($param['searchDate'] != 'all') {
                    $search_start_date = str_replace("-", "", $param['searchDate']);
                    $search_date = explode('-' ,$param['searchDate']  );
                    $search_end_month = $controllerPublic->shamsiMonthToEndDay( $search_date[0], $search_date[1] );
                    $search_end_date = implode("-" , [$search_date[0] , $search_date[1] ,$search_end_month  ]);
                    $search_end_date = str_replace("-", "", $search_end_date);
                }else{
                    $search_start_date = $dateNow;
                }


            }else{
                if($param['searchDate'] != 'all') {
                    $search_start_date = str_replace("-", "", $param['searchDate']);
                    $search_date = explode('-' ,$param['searchDate']  );
                    $search_end_month = $controllerPublic->miladiMonthToEndDay( $search_date[0], $search_date[1] );
                    $search_end_date = implode("-" , [$search_date[0] , $search_date[1] ,$search_end_month  ]);
                    $search_end_date = str_replace("-", "", $search_end_date);
                }else{
                    $search_start_date = $dateNow;
                }

            }

			$WHERE = " AND T.start_date >'{$dateNow}' ";
			if ( isset( $param['tourTypeId'] ) && $param['tourTypeId'] == 'internal' ) {
				$WHERE .= " AND T.origin_country_id = '1' ";
				$WHERE .= " AND TR.destination_country_id = '1' ";
				$WHERE .= " AND TR.tour_title = 'dept' ";

				$this->titlePageSearch = functions::Xmlinformation( "Internal" );

			} elseif ( isset( $param['tourTypeId'] ) && $param['tourTypeId'] == 'external' ) {
				$WHERE .= " AND T.origin_country_id = '1' ";
				$WHERE .= " AND TR.destination_country_id != '1' ";
				$WHERE .= " AND TR.tour_title = 'dept' ";

				$this->titlePageSearch = functions::Xmlinformation( "Foreign" );

			} elseif ( isset( $param['tourTypeId'] ) && $param['tourTypeId'] != 'all' && $param['tourTypeId'] != 'lastMinuteTour' ) {

				$Join = '';
				//                $WHERE .= " AND TTT.fk_tour_type_id = {$param['tourTypeId']} AND TTT.is_del = 'no' ";
				$WHERE .= " AND T.tour_type_id LIKE '%" . '"' . $param['tourTypeId'] . '"' . "%' ";
				//                $Join  .= " INNER JOIN reservation_tour_tourType_tb AS TTT ON T.id_same=TTT.fk_tour_id_same";

				$objController         = Load::controller( 'reservationPublicFunctions' );
				$this->titlePageSearch = $objController->ShowName( 'reservation_tour_type_tb', $param['tourTypeId'], 'tour_type' );

			}
            $Join = '';
            if($param['searchDate'] != 'all') {
                $WHERE .= " AND (T.start_date >= '{$search_start_date}' AND T.start_date <= '{$search_end_date}') ";
            }else{
                $WHERE .= " AND (T.start_date >= '{$search_start_date}' ) ";
            }


            $objResultHotel = Load::controller( 'resultHotelLocal' );

            if ( isset( $param['originCountryId'] ) && $param['originCountryId'] != 'all' ) {
                $WHERE .= " AND T.origin_country_id = '{$param['originCountryId']}' ";
                $Join  .= " INNER JOIN reservation_tour_tourType_tb AS TTT ON T.id_same=TTT.fk_tour_id_same";
            }
            if ( isset( $param['destinationCountryId'] ) && $param['destinationCountryId'] != 'all' ) {
                $WHERE                 .= " AND TR.destination_country_id = '{$param['destinationCountryId']}' ";
                $this->titlePageSearch = $objResultHotel->getCountry( $param['destinationCountryId'] );

            }
            if ( isset( $param['originCityId'] ) && $param['originCityId'] != 'all' ) {
                $WHERE .= " AND T.origin_city_id = '{$param['originCityId']}' ";
            }
            if ( isset( $param['destinationCityId'] ) && $param['destinationCityId'] != 'all' ) {
                $WHERE                 .= " AND TR.destination_city_id = '{$param['destinationCityId']}' ";
                $this->titlePageSearch = $objResultHotel->getCity( $param['destinationCityId'] );
            }
            if ( isset( $param['originRegionId'] ) && $param['originRegionId'] != 'all' ) {
                $WHERE .= " AND T.origin_region_id = '{$param['originRegionId']}' ";
            }
            if ( isset( $param['destinationRegionId'] ) && $param['destinationRegionId'] != 'all' ) {
                $WHERE                 .= " AND TR.destination_region_id = '{$param['destinationRegionId']}' ";
                $this->titlePageSearch = $objResultHotel->getRegion( $param['destinationRegionId'] );
            }

            if ( isset( $param['is_special'] ) && $param['is_special'] == '1' ) {
                $WHERE  .= " AND T.is_special = 'yes' ";

            }




			/*       $sql = " SELECT
							T.*, TR.destination_country_name, TR.destination_city_name, TR.destination_region_name,
							TR.airline_name, TR.type_vehicle_name, TR.exit_hours, TR.airline_id, TR.type_vehicle_id,
							TR.id AS idRout,
							  (
						  SELECT
							  destination_country_id
						  FROM
							  reservation_tour_rout_tb AS tourRoute
						  WHERE
							  tourRoute.fk_tour_id = T.id
							  AND tourRoute.tour_title = 'dept'
							  AND tourRoute.destination_country_id != '1'

							  AND tourRoute.is_del = 'no'
						  GROUP BY
							  tourRoute.fk_tour_id
							  ) AS isExternal
						FROM
							reservation_tour_tb AS T
							LEFT JOIN reservation_tour_rout_tb AS TR ON T.id=TR.fk_tour_id
							LEFT JOIN reservation_tour_tourType_tb AS TTT ON T.id_same=TTT.fk_tour_id_same
						WHERE
							T.is_del = 'no' AND TTT.is_del = 'no' AND
							T.is_show = 'yes' AND TR.tour_title='dept'
							{$WHERE }
						GROUP BY T.tour_code
						ORDER BY T.priority=0,T.priority ASC
						"; */
			$sql = " SELECT
                      	T.id , T.id_same,T.tour_name,T.tour_name_en,T.tour_type_id,
                        T.tour_code,T.start_date,T.end_date,T.night,T.`day`,T.tour_pic,
                        T.origin_continent_id,T.origin_country_id,T.is_show,T.is_special,T.is_del,
                        T.`language`,
                        T.origin_city_name,
                        T.change_price,
                        ReservationOriginCity.name_en AS origin_city_name_en,
                        T.origin_city_id,
                        T.origin_region_name,
                        T.origin_country_name,
                        ReservationOriginCountry.name_en AS origin_country_name_en,
                        TR.destination_country_name,
                        ReservationDestinationCountry.name_en AS destination_country_name_en,
                        TR.destination_city_name,
                        ReservationDestinationCity.name_en AS destination_city_name_en,
                        TR.destination_region_name,
                        TR.airline_name,
                        TR.type_vehicle_name,
                        TR.exit_hours,
                        TR.airline_id,
                        TR.type_vehicle_id,
                        TR.tour_title,
                        TR.destination_country_id,
                        TR.id AS idRout
                  FROM
                      reservation_tour_tb AS T
                      INNER JOIN reservation_tour_rout_tb AS TR ON T.id=TR.fk_tour_id
                      LEFT JOIN reservation_city_tb AS ReservationOriginCity ON ReservationOriginCity.id=T.origin_city_id
                      LEFT JOIN reservation_country_tb AS ReservationOriginCountry ON ReservationOriginCountry.id=T.origin_country_id
                      LEFT JOIN reservation_city_tb AS ReservationDestinationCity ON ReservationDestinationCity.id=TR.destination_city_id
                      LEFT JOIN reservation_country_tb AS ReservationDestinationCountry ON ReservationDestinationCountry.id=TR.destination_country_id
                      {$Join}
                  WHERE
                      T.is_del = 'no'
                      AND 
                      T.is_show = 'yes' 
                      AND TR.tour_title='dept'
                      AND (TR.is_route_fake = '1' OR TR.is_route_fake IS NULL) 
                      {$WHERE}
                  GROUP BY T.tour_code
                  ORDER BY T.priority=0,T.priority ASC
                  ";


			//            echo print_r('$data');
			//            die();


			/*   if((isset($_SERVER["HTTP_HOST"]) && strpos($_SERVER["HTTP_HOST"],'s360online.iran-tech.com') !== false) ){//local

				   echo $sql;
			   }*/

//            echo '<pre style="display:none">'.($sql).'</pre>';



            $tours = $Model->select( $sql );

//            echo json_encode($tours,256);
			if ( ! empty( $tours ) ) {
				foreach ( $tours as $k => $tour ) {


					$isShowTour       = 'yes';
					$isLastMinuteTour = $this->isLastMinuteTour( $tour['start_date'], $tour['start_time_last_minute_tour'] );
					if ( $param['tourTypeId'] == 'lastMinuteTour' && $isLastMinuteTour == 'no' ) {
						$isShowTour = 'no';
					}

					if ( $isShowTour == 'yes' ) {

						$this->listTour[ $k ]                     = $tour;
						$this->listTour[ $k ]['is_api'] = false;
						$this->listTour[ $k ]['isLastMinuteTour'] = $isLastMinuteTour;

						switch ( $tour['type_vehicle_name'] ) {
							case 'هواپیما':
								$type_vehicle_name = functions::Xmlinformation( "Airline" ) . ' ' . $tour['airline_name'];
								break;
							case 'اتوبوس':
								$type_vehicle_name = functions::Xmlinformation( "BusDriving" ) . ' ' . $tour['airline_name'];
								break;
							case 'قطار':
								$type_vehicle_name = functions::Xmlinformation( "Train" ) . ' ' . $tour['airline_name'];
								break;
							case 'کشتی':
								$type_vehicle_name = functions::Xmlinformation( "Shipyard" ) . ' ' . $tour['airline_name'];
								break;
							default:
								$type_vehicle_name = $tour['type_vehicle_name'] . ' ' . $tour['airline_name'];
								break;
						}
						if ( ! in_array( $type_vehicle_name, $this->listAirline ) ) {
							$this->listAirline[ $k ] = $type_vehicle_name;
						}

						$this->listTour[ $k ]['typeVehicleName'] = $type_vehicle_name;

						$arrayTourType = json_decode( $tour['tour_type_id'] );
						if ( in_array( '1', $arrayTourType ) ) {
							$oneDayTour = 'yes';
						} else {
							$oneDayTour = 'no';
						}

                        $minPrice = $this->minPriceHotelByIdTourR( $tour['id'], $oneDayTour );





						$this->listTour[ $k ]['discount']            = $minPrice['discount'];

                            $this->listTour[ $k ]['min_price_r']            = $minPrice['minPriceR'];


						$this->listTour[ $k ]['min_price_a']            = $minPrice['minPriceA'];
//						$this->listTour[ $k ]['discounted_min_price_r'] = $minPrice['discountedMinPriceR'];
						$masterRate                                     = Load::controller( 'admin' );
                        $this->listTour[ $k ]['rater']=[];
					/*	$this->listTour[ $k ]['rater']                  = json_decode( $masterRate->getMasterRate( [
							'record_id'  => $tour['id_same'],
							'table_name' => 'reservation_tour_tb',
						] ), true );*/
						$this->listTour[ $k ]['currency_title_fa']      = $minPrice['CurrencyTitleFa'];

						if ( $this->listTour[ $k ]['min_price_r'] != 0 ) {
                                $price[] = $this->listTour[$k]['min_price_r'];
						}


						$this->listTour[ $k ]['arrayRegions']     = $this->getRegions( $tour['id'] );
						$this->listTour[ $k ]['arrayTypeVehicle'] = $this->getTypeVehicle( $tour['id'] );


						$objReservationTour                   = Load::controller( 'reservationTour' );
						$this->listTour[ $k ]['infoTourRout'] = $objReservationTour->infoTourRoutByIdTour( $tour['id'] );

						/*if ($tour['idHotel'] != ''){
							$this->listTour[$k]['infoHotel'] = $this->getInfoReservationHotel($tour['idHotel']);
						}*/


						$arrayInfoAgency                            = functions::infoAgencyByMemberId( $tour['user_id'] );
						$this->listTour[ $k ]['infoAgency']['name'] = $tour['agency_name'];
						$this->listTour[ $k ]['infoAgency']['logo'] = $arrayInfoAgency['logo'];

						$agencyRate                                 = functions::getAgencyRate( $tour['agency_id'] );
						$this->listTour[ $k ]['infoAgency']['rate'] = $agencyRate['average'];
					}


					$availableToursId[] = $tour['id_same'];
				}

				$this->minPrice  = min( $price );
				$this->maxPrice  = max( $price );
				$this->countTour = count( $this->listTour );

                if(!empty($tours_api))
                {


                    $i = $this->countTour ;
                    foreach ($tours_api as $key=>$tour){
                        $key = ($key==0) ? $i : $key+$i;
                        $this->listTour[$key] = $tour ;
                    }
                }


			} else {
                if(!empty($tours_api))
                {
                        $i = $this->countTour ;
                    foreach ($tours_api as $key=>$tour){
                        $key = ($key==0) ? $i : $key+$i;
                        $this->listTour[$key] = $tour ;
                    }
                }else{
                    $this->error        = true;
                    $this->errorMessage = functions::Xmlinformation( "TourNotCurrentlyAvailable" ) . '<br>' . functions::Xmlinformation( "PleaseSearchDateCountryCityTypeTour" );
                }


			}

			$objReservationTour = Load::controller( 'reservationTour' );

			$this->listSuggestedTours = $objReservationTour->infoTourSuggestedByTourId( $availableToursId, $tour['origin_city_id'] );


		}

		//        echo'<span style="display:none;">'.$sql.print_r($this->listTour).'</span>';

	}
	#endregion

	#region calculateDiscountedPrices
	public function calculateDiscountedPrices( $discountType, $discount, $price ) {
		$arrayPrice = [];
		if ( $discountType == 'percent' ) {
			$arrayPrice['discountPercent']      = $discount;
			$arrayPrice['priceWithoutDiscount'] = $price;
			$arrayPrice['price']                = $price - ( ( $discount * $price ) / 100 );

		} elseif ( $discountType == 'price' ) {
			if ( ! empty( $price ) ) {

				$arrayPrice['discountPercent']      = round( ( ( ( $price ) - ( $price - $discount ) ) * 100 ) / $price );
				$arrayPrice['priceWithoutDiscount'] = $price;
				$arrayPrice['price']                = $price - $discount;
			} else {
				$arrayPrice['price'] = 0;
			}

		} else {
			$arrayPrice['discountPercent']      = 0;
			$arrayPrice['priceWithoutDiscount'] = 0;
			$arrayPrice['price']                = $price;
		}

		return $arrayPrice;
	}
	#endregion


	#region getTypeVehicle
    public function getTypeVehicle($id,$is_api=false) {


        if($is_api){

            return $this->info_api->typeVehicleApi(['tour_id'=>$id]);
        }
        $Model = Load::library('Model');
        $reservationTransportCompaniesModel = $this->getModel('reservationTransportCompaniesModel');
        $airlineModel = $this->getModel('airlineModel');
        $reservationTourModel = $this->getModel('reservationTourModel');
        $reservationTourRoutModel = $this->getModel('reservationTourRoutModel');
        $reservationTourRoutModelTable = $reservationTourRoutModel->gettable();

        $result = $reservationTourModel->get([
            $reservationTourRoutModelTable . '.airline_id',
            $reservationTourRoutModelTable . '.type_vehicle_id',
            $reservationTourRoutModelTable . '.airline_name',
            $reservationTourRoutModelTable . '.type_vehicle_name',
            $reservationTourRoutModelTable . '.tour_title'
        ], true)->join($reservationTourRoutModelTable, 'fk_tour_id')
            ->where('reservation_tour_tb.id', $id)
            ->groupBy($reservationTourRoutModelTable . '.tour_title ')
            ->orderBy($reservationTourRoutModelTable . '.id , '.$reservationTourRoutModelTable .'.tour_title = "dept"')
            ->all();

        $listTypeVehicle = [];

        foreach ($result as $val) {

            $listTypeVehicle[$val['tour_title']]['type_vehicle_name'] = $val['type_vehicle_name'];
            if ($val['type_vehicle_name'] !== 'هواپیما') {
                $vehicle = $reservationTransportCompaniesModel->get([
                    'id', 'name', 'name_en', 'pic', 'abbreviation','fk_id_type_of_vehicle'
                ])
                    ->where('fk_id_type_of_vehicle', $val['type_vehicle_id'])
                    ->where('id', $val['airline_id'])
                    ->where('is_del', 'no')
                    ->find();

                $vehicle['logo_address']= ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . $vehicle['pic'];


            } else {
                $vehicle = $airlineModel->get([
                    'id', 'name_fa', 'name_en', 'photo', 'abbreviation'
                ], true)
                    ->where('id', $val['airline_id'])
                    ->where('del', 'no')
                    ->find();

                $vehicle['logo_address']= ROOT_ADDRESS_WITHOUT_LANG . '/pic/airline/' . $vehicle['photo'];

            }
            $listTypeVehicle[$val['tour_title']]['vehicle'] = $vehicle;

            $listTypeVehicle[$val['tour_title']]['airline_name'] = $val['airline_name'];
            $listTypeVehicle[$val['tour_title']]['tour_title'] = ($val['tour_title'] == 'dept') ? functions::Xmlinformation("Went") : functions::Xmlinformation("Return");
        }

        return $listTypeVehicle;
    }
	#endregion


	#region getRegions
	public function getRegions( $id ) {
		$Model  = Load::library( 'Model' );
		$sql    = " SELECT destination_region_name FROM reservation_tour_rout_tb WHERE fk_tour_id = '{$id}' AND is_del = 'no' ";
		$region = $Model->select( $sql );

		foreach ( $region as $val ) {
			if ( $val['destination_region_name'] != '' ) {
				$result[] = $val['destination_region_name'];
			}

			if ( $val['destination_region_name'] != '' && !in_array( $val['destination_region_name'], $this->listRegion ) ) {
				$this->listRegion[] = $val['destination_region_name'];
			}

		}

		return $result;
	}
	#endregion


	#region getAllTourType
	public function getAllTourType() {
		$Model  = Load::library( 'Model' );
		$sql    = " SELECT * FROM reservation_tour_type_tb WHERE is_del = 'no' ";
		$result = $Model->select( $sql );

        if ($this->info_api) {
            $all_types = $this->info_api->getAllTypeTour([]);

            if ($all_types) {
                if (empty($result)) {
                    $result = $all_types;
                } else {
                    $abbrevations = [];
                    foreach ($all_types as $type) {
                        $abbrevations[] = $type['tour_type_en'];
                    }
                    foreach ($all_types as $item) {
                        if (!in_array($item['abbreviation'], $abbrevations)) {
                            $result[] = $item;
                        }
                    }
                }
            }
        }
		return $result;
	}
	#endregion

    public function getTourServices() {

        return
            [
                (string)functions::Xmlinformation('Travel'),
                (string)functions::Xmlinformation('Transfer'),
                (string)functions::Xmlinformation('Insurance'),
                (string)functions::Xmlinformation('Ticket'),
                (string)functions::Xmlinformation('Breakfast')
            ]
        ;
    }


	#region getTourTypes
	public function getTourTypes($id=null) {

        if($id) {

            return $this->getModel('reservationTourTypeModel')->get()
                ->where('is_del', 'no')
                ->whereNotIn('id', ['1', '2'])
                ->whereIn('id', $id)
                ->openParentheses()
                ->where('is_approved', '1')
                ->orWhere('member_id', Session::getUserId())
                ->closeParentheses()
                ->all();

        } else {

            return $this->getModel('reservationTourTypeModel')->get()
                ->where('is_del', 'no')
                ->whereNotIn('id', ['1', '2'])
                ->openParentheses()
                ->where('is_approved', '1')
                ->orWhere('member_id', Session::getUserId())
                ->closeParentheses()
                ->all();
        }
	}
    public function toggleApproveTourType($param) {
        $reservationTourTypeModel=$this->getModel('reservationTourTypeModel');
        $type=$reservationTourTypeModel->get()
            ->where('id',$param['type_id'])
            ->find();
        if($type) {
            return $reservationTourTypeModel->updateWithBind([
                'is_approved' => $type['is_approved'] == '1' ? '0' : '1'
            ],[
                'id'=>$param['type_id']
            ]);
        }
    }
	#endregion

    public function tourDiscountFieldsIndex()
    {

        // آیا فعال است؟
        $isEachPerson =$this->isEachPersonEnabled() ;

        return [
            [
                'index' => 'adult_amount',
                'title' => $isEachPerson
                    ? functions::Xmlinformation('PriceAdultEachPerson')->__toString()
                    : functions::Xmlinformation('Priceadult')->__toString()
            ],
            [
                'index' => 'child_amount',
                'title' => $isEachPerson
                    ? functions::Xmlinformation('PriceChildEachPerson')->__toString()
                    : functions::Xmlinformation('Pricechild')->__toString()
            ],
            [
                'index' => 'infant_amount',
                'title' => $isEachPerson
                    ? functions::Xmlinformation('PriceInfantEachPerson')->__toString()
                    : functions::Xmlinformation('Pricebaby')->__toString()
            ],
        ];
    }

    public function isEachPersonEnabled()
    {
        $setting = $this->getModel('reservationSettingModel')
            ->getByTitle('eachPerson');

        return !empty($setting) && $setting['enable'] == 1;
    }
    public function is_toman()
    {
        $setting = $this->getModel('reservationSettingModel')
            ->getByTitle('toman');

        return !empty($setting) && $setting['enable'] == 1;
    }





    #region getInfoTourByIdTour
    public function getInfoTourByIdTour( $idTour ) {
        $objReservationTour                  = Load::controller( 'reservationTour' );
        $this->arrayTour['infoTour']         = $objReservationTour->infoTourById( $idTour );




        $api_base = false ;
        $detail = [] ;

        if (!$this->arrayTour['infoTour']) {
            $api_base = true;
            if (method_exists($this->info_api, 'detail')) {
                $detail = $this->info_api->detail($idTour);
                if (!empty($detail['tour'])) {
                    $this->arrayTour['infoTour'] = $detail['tour'];
                } else {
                    $this->arrayTour['infoTour'] = []; // یا null
                }
            } else {
                $this->arrayTour['infoTour'] = []; // یا null
            }
        }

        $this->arrayTour['is_api'] = $api_base ;

        $this->arrayTour['arrayTypeVehicle'] = $api_base ? $detail['vehicle'] : $this->getTypeVehicle( $idTour );
        $this->arrayTour['suggestionTours']  = $api_base ? $detail['suggestion_tours'] : $objReservationTour->infoTourSuggestedByTourId( $this->arrayTour['infoTour']['id_same'], $this->arrayTour['infoTour']['origin_city_id'] );

        $infoTourRoutByIdTour            = $objReservationTour->infoTourRoutByIdTour( $idTour );


        $this->arrayTour['infoTourRout'] = $api_base ? $detail['info_tour_route_by_id_tour'] : $infoTourRoutByIdTour;
        $one_day_tour = 'no';

        if(strpos($this->arrayTour['infoTour']['tour_type_id'], '"1"') !== false){
            $one_day_tour = 'yes';
        }


        if($api_base){
            $prices = [
                'minPriceR' => $detail['price']['price'],
                'minPriceA' => $detail['price']['price_currency'],
                'CurrencyTitleFa' =>$detail['price']['Currency_title'],
            ];
            $this->arrayTour['minPrice']     =  $prices ;
        }else{
            $this->arrayTour['minPrice']     = $this->minPriceHotelByIdTourR($idTour , $one_day_tour);
        }

        $destination_cities              = '';
        $destination_region              = '';
        $serviceTitle                    = '';
        foreach ( $infoTourRoutByIdTour as $city ) {
            if ( $city['tour_title'] == 'dept' ) {
                if ( $city['night'] > 0 ) {
                    $destination_cities .= $city['destination_city_name'] . ' / ';
                    $destination_region .= $city['destination_region_name'] . ' / ';
                }
                if ( $city['destination_country_id'] == '1' ) {
                    $serviceTitle = $api_base ? 'PublicLocalTour':'PrivateLocalTour';
                } else {
                    $serviceTitle = $api_base ? 'PublicLocalTour':'PrivatePortalTour';
                }
            }
        }
        $this->arrayTour['destination_cities'] = substr( $destination_cities, 0, - 3 );
        $this->arrayTour['destination_region'] = substr( $destination_region, 0, - 3 );
        $this->arrayTour['serviceTitle']       = $serviceTitle;

        $this->arrayTour['gallery']               = $api_base ? $detail['gallery_tour'] : $this->getTourGallery( $idTour );
        $arrayInfoAgency                          = $api_base ? [] : functions::infoAgencyByMemberId( $this->arrayTour['infoTour']['user_id'] );
        $this->arrayTour['infoAgency']['name']    = $arrayInfoAgency['name_fa'];
        $this->arrayTour['infoAgency']['phone']   = $arrayInfoAgency['phone'];
        $this->arrayTour['infoAgency']['logo']    = $arrayInfoAgency['logo'];
        $this->arrayTour['infoAgency']['address'] = $arrayInfoAgency['address_fa'];
        $this->arrayTour['infoAgency']['domain']  = $arrayInfoAgency['domain'];

        $this->arrayTour['arrayDate']             = $api_base ? $detail['tour_days'] : $this->listTourDates( $this->arrayTour['infoTour']['tour_code'] , $one_day_tour );

        if($api_base){
            $this->arrayTour['tour_routes'] = $detail['tour_route'];
        }
        if(!$api_base){
            $comments_controller = $this->getController('comments');
            $this->arrayTour['comments'] = $comments_controller->getAllComments('tour', $this->arrayTour['infoTour']['id_same']);
        }
    }
    #endregion

    #region getInfoTourByIdTour
    public function getInfoTourByIdSameTour( $idSameTour ) {

        $objReservationTour                  = Load::controller( 'reservationTour' );
        $idTour                               = $objReservationTour->infoTourByIdSameDetail( $idSameTour )['id'];

        if($idTour) {
            defined('TOUR_ID') or define('TOUR_ID', $idTour);
            $this->arrayTour['infoTour']         = $objReservationTour->infoTourById( $idTour );

            $api_base = false ;
            $detail = [] ;
            if(!$this->arrayTour['infoTour']){
                $api_base = true ;
                $detail = $this->info_api->detail($idTour);
                $this->arrayTour['infoTour']  = $detail['tour'];
            }

            $this->arrayTour['is_api'] = $api_base ;

            $this->arrayTour['arrayTypeVehicle'] = $api_base ? $detail['vehicle'] : $this->getTypeVehicle( $idTour );
            $this->arrayTour['suggestionTours']  = $api_base ? $detail['suggestion_tours'] : $objReservationTour->infoTourSuggestedByTourId( $this->arrayTour['infoTour']['id_same'], $this->arrayTour['infoTour']['origin_city_id'] );

            $infoTourRoutByIdTour            = $objReservationTour->infoTourRoutByIdTour( $idTour );

            $this->arrayTour['infoTourRout'] = $api_base ? $detail['info_tour_route_by_id_tour'] : $infoTourRoutByIdTour;
            $one_day_tour = 'no';

            if(strpos($this->arrayTour['infoTour']['tour_type_id'], '"1"') !== false){
                $one_day_tour = 'yes';
            }


            if($api_base){
                $prices = [
                    'minPriceR' => $detail['price']['price'],
                    'minPriceA' => $detail['price']['price_currency'],
                    'CurrencyTitleFa' =>$detail['price']['Currency_title'],
                ];
                $this->arrayTour['minPrice']     =  $prices ;
            }else{
                $this->arrayTour['minPrice']     = $this->minPriceHotelByIdTourR($idTour , $one_day_tour);
            }

            $destination_cities              = '';
            $destination_region              = '';
            $serviceTitle                    = '';
            foreach ( $infoTourRoutByIdTour as $city ) {
                if ( $city['tour_title'] == 'dept' ) {
                    if ( $city['night'] > 0 ) {
                        $destination_cities .= $city['destination_city_name'] . ' / ';
                        $destination_region .= $city['destination_region_name'] . ' / ';
                    }
                    if ( $city['destination_country_id'] == '1' ) {
                        $serviceTitle = $api_base ? 'PublicLocalTour':'PrivateLocalTour';
                    } else {
                        $serviceTitle = $api_base ? 'PublicLocalTour':'PrivatePortalTour';
                    }
                }
            }
            $this->arrayTour['destination_cities'] = substr( $destination_cities, 0, - 3 );
            $this->arrayTour['destination_region'] = substr( $destination_region, 0, - 3 );
            $this->arrayTour['serviceTitle']       = $serviceTitle;

            $this->arrayTour['gallery']               = $api_base ? $detail['gallery_tour'] : $this->getTourGallery( $idSameTour );
            $arrayInfoAgency                          = $api_base ? [] : functions::infoAgencyByMemberId( $this->arrayTour['infoTour']['user_id'] );
            $this->arrayTour['infoAgency']['name']    = $arrayInfoAgency['name_fa'];
            $this->arrayTour['infoAgency']['phone']   = $arrayInfoAgency['phone'];
            $this->arrayTour['infoAgency']['logo']    = $arrayInfoAgency['logo'];
            $this->arrayTour['infoAgency']['address'] = $arrayInfoAgency['address_fa'];
            $this->arrayTour['infoAgency']['domain']  = $arrayInfoAgency['domain'];
//            if(  $_SERVER['REMOTE_ADDR']=='93.118.161.174'  ) {
//                var_dump('aaa');
//                var_dump($this->arrayTour);
//                die;
//            }
//                var_dump($this->arrayTour['gallery'] );
//                die;
            $this->arrayTour['arrayDate']             = $api_base ? $detail['tour_days'] : $this->listTourDates( $this->arrayTour['infoTour']['tour_code'] , $one_day_tour );

            if($api_base){
                $this->arrayTour['tour_routes'] = $detail['tour_route'];
            }
            if(!$api_base){
                $comments_controller = $this->getController('comments');
                $this->arrayTour['comments'] = $comments_controller->getAllComments('tour', $this->arrayTour['infoTour']['id_same']);
            }
        }



    }
    #endregion

	#region minPriceHotelByIdRout
	public function minPriceHotelByIdRout( $id ) {
		$Model    = Load::library( 'Model' );
		$sql      = " SELECT min(double_room_price_r) as minPrice FROM reservation_tour_rout_hotel_tb WHERE fk_tour_rout_id = '{$id}' AND is_del = 'no' ";
		$minPrice = $Model->load( $sql );

		return $minPrice['minPrice'];
	}
	#endregion


	#region listTourDates
	public function listTourDates( $tourCode , $one_day_tour = 'no' ) {
		$controllerPublic = Load::controller( 'reservationPublicFunctions' );
		$today            = dateTimeSetting::jtoday( '' );
		$Model            = Load::library( 'Model' );
        $inner_join_Package  = '';
        $has_package  = '';
        if($one_day_tour == 'no') {
            $package_select = ",
                    TP.three_room_capacity,TP.double_room_capacity,TP.single_room_capacity,TP.child_with_bed_capacity,TP.infant_without_bed_capacity,TP.infant_without_chair_capacity,
                    TP.custom_room";
            $inner_join_Package  = 'INNER JOIN reservation_tour_package_tb AS TP ON T.id =TP.fk_tour_id';
            $has_package= "AND TP.is_del='no' " ;
        }
        $sql    = " SELECT T.start_date,T.id, T.end_date, T.stop_time_reserve, TR.exit_hours {$package_select}
                 FROM 
                    reservation_tour_tb T
                    INNER JOIN reservation_tour_rout_tb AS TR ON T.id=TR.fk_tour_id
                 {$inner_join_Package}
                 WHERE 
                    T.start_date > '{$today}' 
                   AND T.tour_code = '{$tourCode}'
                   AND T.is_del='no'  
                     {$has_package}
                   AND T.is_show='yes'
                 GROUP BY T.start_date
                 LIMIT 0,50";

		$resultTours      = $Model->select( $sql );
        $result = [];
		foreach ( $resultTours as $k => $val ) {


			// اگر تاریخ و ساعت سرچ قبل از تاریخ ساعت حرکت بود نمایش بده //
			$result_isReserveByStopTime = functions::isReserveByStopTime( $val['exit_hour'], $val['stop_time_reserve'], $val['start_date'] );
			if ( $result_isReserveByStopTime ) {
                $result[ $k ]['id']        = $val['id'];
				$nameStartDate = $controllerPublic->nameDay( $val['start_date'] );
				$nameEndDate   = $controllerPublic->nameDay( $val['end_date'] );

				$y                                = substr( $val['start_date'], 0, 4 );
				$m                                = substr( $val['start_date'], 4, 2 );
				$d                                = substr( $val['start_date'], 6, 2 );
				$result[ $k ]['startDate']        = $y . '/' . $m . '/' . $d;

				$result[ $k ]['startWeekdayName'] = $nameStartDate['name'];

				$y                              = substr( $val['end_date'], 0, 4 );
				$m                              = substr( $val['end_date'], 4, 2 );
				$d                              = substr( $val['end_date'], 6, 2 );
				$result[ $k ]['endDate']        = $y . '/' . $m . '/' . $d;
				$result[ $k ]['endWeekdayName'] = $nameEndDate['name'];
                if($one_day_tour == 'no') {
                    $result[ $k ]['capacity']       = $val['three_room_capacity']+$val['double_room_capacity']+$val['child_with_bed_capacity']+$val['infant_without_bed_capacity']+$val['infant_without_chair_capacity'];
                    if(isset($val['custom_room']) && !empty($val['custom_room'])) {
                        $room = json_decode($val['custom_room'], true) ;
                        if(count($room) > 0 ) {
                            foreach ($room as $single_room) {
                                $result[ $k ]['capacity'] += array_values($single_room)[0]['capacity'];
                            }
                        }
                    }
                }else{
                    $result[ $k ]['capacity']  = 1 ;
                }

            }

		}

		return $result;
	}
	#endregion


	#region minPriceHotelByIdTourR
    public function minPriceHotelByIdTourR($id, $oneDayTour='no') {


        $Model = Load::library('Model');
        /** @var reservationTour $reservation_tour_controller */
        $reservation_tour_controller = Load::controller('reservationTour');
//        if(  $_SERVER['REMOTE_ADDR']=='93.118.161.174'  ) {
//            var_dump('dddd');
//            var_dump($oneDayTour);
//            die;
//        }
        if ($oneDayTour == 'yes') {

            $sql = "
            SELECT
                id_same, change_price, adult_price_one_day_tour_r, adult_price_one_day_tour_a, currency_type_one_day_tour
            FROM
                reservation_tour_tb
            WHERE
                id = '{$id}'
            ";
            $resultMinPrice = $Model->load($sql);


            $change_price = $reservation_tour_controller->doPriceChange($resultMinPrice['adult_price_one_day_tour_r'] , $resultMinPrice['change_price']);
            if(functions::isEnableSetting('toman')) {
                $minPrice['minPriceR'] = round($change_price/10);
            }else{
                $minPrice['minPriceR'] = $change_price;
            }

            $minPrice = $this->calculateDiscount( $resultMinPrice['id_same'], $minPrice, 0);




            $minPrice['minPriceA'] = $resultMinPrice['adult_price_one_day_tour_a'];

            $minPrice['CurrencyTitleFa'] = $resultMinPrice['currency_type_one_day_tour'];
            $minPrice['is_toman'] = $this->is_toman();

        } else {

            $sql = "
    SELECT
        T.change_price,
        P.id AS package_id,
      
        CASE
			
			WHEN P.double_room_price_r > 0 THEN
			P.double_room_price_r 
			WHEN P.single_room_price_r > 0 THEN
			P.single_room_price_r ELSE P.three_room_price_r 
		END 
		 AS min_price_r,
        CASE
            WHEN P.double_room_price_a > 0 THEN P.double_room_price_a
            WHEN P.single_room_price_r > 0 THEN P.single_room_price_a
            ELSE P.three_room_price_a
        END AS min_price_a,
        P.currency_type
    FROM
        reservation_tour_tb AS T
        LEFT JOIN reservation_tour_package_tb AS P ON T.id = P.fk_tour_id 
    WHERE 
        T.id = '{$id}'  AND P.is_del = 'no'
    ORDER BY min_price_r ASC
    
";
            $counter_type_id=Session::getCounterTypeId();

            $resultMinPrice = $Model->load($sql);




            $change_price = $reservation_tour_controller->doPriceChange($resultMinPrice['min_price_r'] , $resultMinPrice['change_price']);

            $minPrice['minPriceR'] = $change_price;

            if (CLIENT_ID != '292') {
                $minPrice = $this->calculateDiscount( $id, $minPrice, $resultMinPrice['package_id']);
            } else {
                $minPrice['discount']['adult_amount'] = 0;
                $minPrice['discount']['after_discount'] = $minPrice['minPriceR'];
                $minPrice['discountedMinPriceR'] = 0;
            }


//            if(isset($minPrice['minPriceR']['adult_amount']) && $minPrice['minPriceR'] !== null){



            if(functions::isEnableSetting('toman')) {
                $minPrice['minPriceR'] = round($minPrice['minPriceR']/10);
                $minPrice['discount']['adult_amount'] = round($minPrice['discount']['adult_amount']/10);
                $minPrice['discount']['after_discount'] = round($minPrice['discount']['after_discount']/10);
                $minPrice['discountedMinPriceR'] = round($minPrice['discountedMinPriceR']/10);
            }


//            if(isset($minPrice['minPriceR']['adult_amount']) && $minPrice['minPriceR'] !== null){




//            }


            $minPrice['minPriceA'] = $resultMinPrice['min_price_a'];

            $minPrice['CurrencyTitleFa'] = $resultMinPrice['currency_type'];
            $minPrice['is_toman'] = $this->is_toman();
        }
        

        return $minPrice;
    }
	#endregion
    #region getInfoReservationHotel
	public function getInfoReservationHotel( $idHotel ,$is_api=false) {

        if($is_api){
            return $this->info_api->infoSpecialHotel(['hotel_id'=>$idHotel]);
        }
		$Model  = Load::library( 'Model' );
		$sql    = " SELECT
                    Hotel.name, Hotel.name_en, Hotel.trip_advisor, Hotel.star_code,
                    Hotel.logo, Hotel.region, Hotel.type_code,
                    Facilities.id_facilities As facilitiesId, Facilities.is_del AS is_del_facilities
                 FROM 
                    reservation_hotel_tb AS Hotel
                    LEFT JOIN reservation_hotel_facilities_tb AS Facilities ON Hotel.id = Facilities.id_hotel
                 WHERE Hotel.id={$idHotel} ";
		$result = $Model->select( $sql );
		$hotel  = [];
		if ( ! empty( $result ) ) {
			$facilities = '';
			foreach ( $result as $k => $val ) {
				if ( $val['is_del_facilities'] == 'no' ) {
					$facilities .= $val['facilitiesId'] . ',';
				}
			}
			$hotel['name']         = $result[0]['name'];
			$hotel['name_en']      = $result[0]['name_en'];
			$hotel['trip_advisor'] = $result[0]['trip_advisor'];
			$hotel['star_code']    = $result[0]['star_code'];
			$hotel['logo']         = $result[0]['logo'];
			$hotel['region']       = $result[0]['region'];
			$hotel['type_code']    = $result[0]['type_code'];
			$hotel['facilities']   = substr( $facilities, 0, - 1 );
		}


		return $hotel;
	}
	#endregion


	#region userCommentsInsert
	public function userCommentsInsert( $param ) {
		$Model   = Load::library( 'Model' );
		$dateNow = date( 'Y-m-d' );
		$expDate = explode( "-", $dateNow );
		$date    = dateTimeSetting::gregorian_to_jalali( $expDate[0], $expDate[1], $expDate[2], '-' );
		date_default_timezone_set( "Asia/Tehran" );
		$time = date( 'H:i:s' );

		$d['parent_id']      = $param['parent_id'];
		$d['page']           = $param['page'];
		$d['fk_id_page']     = $param['id'];
		$d['full_name']      = $param['fullName'];
		$d['email']          = $param['email'];
		$d['comments']       = $param['comments'];
		$d['create_date_in'] = $date;
		$d['create_time_in'] = $time;
		$d['is_show']        = '';

		$Model->setTable( 'user_comments_tb' );
		$res = $resTour = $Model->insertLocal( $d );

		if ( $res ) {

			$return = 'SUCCESS';
		} else {

			$return = 'ERROR';
		}

		echo $return;
	}
	#endregion


	#region pageShowUserComments
	public function pageShowUserComments( $selectedPage, $id ) {
		$Model  = Load::library( 'Model' );
		$sql    = " SELECT * FROM user_comments_tb WHERE page = '{$selectedPage}' AND fk_id_page = '{$id}' AND is_show = 'yes' ORDER BY id ";
		$result = $Model->select( $sql );
		if ( ! empty( $result ) ) {
			$this->isUserComments = true;

			return $result;
		} else {
			$this->isUserComments = false;
		}

	}
	#endregion


	#region agencyRateInsert
	public function agencyRateInsert( $param ) {
		$Model = Load::library( 'Model' );

		$page   = filter_var( $param['page'], FILTER_SANITIZE_STRING );
		$id     = filter_var( $param['id'], FILTER_SANITIZE_STRING );
		$vote   = $param['vote'];
		$cookie = str_replace( '.', '_', 'rate_' . $page . '_' . $id . '_' . $_SERVER['REMOTE_ADDR'] );

		$star1 = $star2 = $star3 = $star4 = $star5 = 0;
		if ( $vote == 1 ) {
			$star1 ++;
		} elseif ( $vote == 2 ) {
			$star2 ++;
		} elseif ( $vote == 3 ) {
			$star3 ++;
		} elseif ( $vote == 4 ) {
			$star4 ++;
		} elseif ( $vote == 5 ) {
			$star5 ++;
		}

		$res = 0;
		if ( ! isset( $_COOKIE[ $cookie ] ) ) {

			$sql    = " SELECT * FROM sniper_rate_tb WHERE page = '{$page}'  AND fk_id_page = '{$id}' ";
			$result = $Model->load( $sql );

			if ( ! empty( $result ) ) {

				$average = ( ( $result['1star'] * 1 ) + ( $result['2star'] * 2 ) + ( $result['3star'] * 3 ) + ( $result['4star'] * 4 ) + ( $result['5star'] * 5 ) ) / ( $result['total_vote'] );

				$d['1star']      = $result['1star'] + $star1;
				$d['2star']      = $result['2star'] + $star2;
				$d['3star']      = $result['3star'] + $star3;
				$d['4star']      = $result['4star'] + $star4;
				$d['5star']      = $result['5star'] + $star5;
				$d['total_vote'] = $result['total_vote'] + 1;
				$d['average']    = $average;

				$condition = "page = '{$page}'  AND fk_id_page = '{$id}'";
				$Model->setTable( 'sniper_rate_tb' );
				$res = $Model->update( $d, $condition );

			} else {

				$average = ( ( $star1 * 1 ) + ( $star2 * 2 ) + ( $star3 * 3 ) + ( $star4 * 4 ) + ( $star5 * 5 ) ) / 1;

				$d['page']       = $page;
				$d['fk_id_page'] = $id;
				$d['1star']      = $star1;
				$d['2star']      = $star2;
				$d['3star']      = $star3;
				$d['4star']      = $star4;
				$d['5star']      = $star5;
				$d['total_vote'] = '1';
				$d['average']    = $average;

				$Model->setTable( 'sniper_rate_tb' );
				$res = $resTour = $Model->insertLocal( $d );

			}
		}

		if ( $res ) {
			setcookie( $cookie, 'voted', time() + 3600 * 24 * 5, '/' );//, $_SERVER['HTTP_HOST'], true, true

			$sql       = " SELECT * FROM sniper_rate_tb WHERE page = '{$page}'  AND fk_id_page = '{$id}' ";
			$data_show = $Model->load( $sql );

			$return = 'SUCCESS|' . $data_show['total_vote'] . '|' . $data_show['average'];
		} else {

			$return = 'ERROR|';
		}

		echo $return;

	}
	#endregion


	#region pageShowRate
	public function pageShowRate( $selectedPage, $id ) {
		$Model = Load::library( 'Model' );

		$return = array(
			'total'   => 0,
			'average' => 0
		);

		$sql    = " SELECT * FROM sniper_rate_tb WHERE page = '{$selectedPage}' AND fk_id_page = '{$id}' ";
		$result = $Model->load( $sql );
		if ( ! empty( $result ) ) {
			$return['total']   = $result['total_vote'];
			$return['average'] = $result['average'];
		}

		return $return;

	}
	#endregion


	#region getTourGallery
	public function getTourGallery( $tourId ) {
		$Model       = Load::library( 'Model' );
		$sql         = " SELECT * FROM reservation_tour_gallery_tb WHERE is_del = 'no' AND fk_tour_id_same='{$tourId}' ORDER BY id DESC";
		$tourGallery = $Model->select( $sql );

		return $tourGallery;
	}
	#endregion


	#region getFactorNumber
	public function getFactorNumber() {
		$factorNumber = dateTimeSetting::jdate( "Ymd", '', '', '', 'en' ) . mt_rand( 00, 99 ) . substr( time(), 7, 10 );

		return $factorNumber;
	}
	#endregion


	#region infoTourPackage
	public function infoTourPackage( $id ,$is_api=false) {

        if($is_api){
            $data_package=[
                'package_id'=>$id
            ];
            return $this->info_api->packageOfTour($data_package);
        }
        $counter_type_id = Session::IsLogin() ? Session::getCounterTypeId(): '5';
		$Model = Load::library( 'Model' );
		 $sql   = "
            SELECT
                TP.*, H.*, T.change_price, T.discount_type, T.discount, discount.*,
                TP.id as packageId, H.id as packageHotelId 
            FROM
                reservation_tour_tb as T
                LEFT JOIN reservation_tour_package_tb as TP ON T.id=TP.fk_tour_id
                LEFT JOIN reservation_tour_hotel_tb as H ON TP.id=H.fk_tour_package_id
                LEFT JOIN reservation_tour_discount_tb as discount ON TP.id=discount.tour_package_id
            WHERE
                TP.id = '{$id}' 
                AND TP.is_del = 'no'
            AND discount.counter_type_id = '{$counter_type_id}'
            GROUP BY H.id
            ";
//            AND discount.counter_type_id = '{$counter_type_id}'
		$tour  = $Model->select( $sql );

		return $tour;
	}
	#endregion


	#region setInfoReserveTourPackage
	public function setInfoReserveTourPackage( $packageId, $POSTCountRoom ,$is_api=false) {
		$countSingleRoom         = 0;
		$countDoubleRoom         = 0;
		$countThreeRoom          = 0;
		$countFourRoom          = 0;
		$countFiveRoom          = 0;
		$countSixRoom          = 0;
		$countChildRoom          = 0;
		$countInfantWithoutBed   = 0;
		$countInfantWithoutChair = 0;
		$countAllRooms           = explode( '|', $POSTCountRoom );
        $price_per_person = functions::isEnableSetting('eachPerson');
		foreach ( $countAllRooms as $countRoom ) {

			$count = explode( ':', $countRoom );
            functions::insertLog(json_encode($count) , '000000000ararara');
            switch ( $count[0] ) {
				case 'oneBed':
					$countSingleRoom = $count[1];
					break;
				case 'twoBed':
					$countDoubleRoom = $count[1];
					break;
				case 'threeBed':
					$countThreeRoom = $count[1];
					break;
				case 'childwithbed':
					$countChildRoom = $count[1];
					break;
				case 'babywithoutbed':
					$countInfantWithoutBed = $count[1];
					break;
				case 'babywithoutchair':
					$countInfantWithoutChair = $count[1];
					break;
                case 'fourBed':
                    $countFourRoom = $count[1];
                    break;
                case 'fiveBed':
                    $countFiveRoom = $count[1];
                    break;
                case 'sixBed':
                    $countSixRoom = $count[1];
                    break;
				default:
					break;
			}
		}

		$infoTourPackage = $this->infoTourPackage( $packageId,$is_api );

		functions::insertLog( 'package id ==>' . json_encode( $infoTourPackage ), '$infoTourPackage' );
        if ( ! empty( $infoTourPackage ) ) {
            $package['id']=$packageId;
            $total_price_package = 0;
            $custom_room = $infoTourPackage[0]['custom_room'] ? json_decode($infoTourPackage[0]['custom_room'],256) : '' ;
            if ( $countSingleRoom > 0 ) {

                $price = $infoTourPackage[0]['single_room_price_r'] + $infoTourPackage[0]['change_price'];
                $price = $this->calculateDiscountedPrices( $infoTourPackage[0]['discount_type'], $infoTourPackage[0]['discount'], $price );

                $package['infoRooms']['single_room']['name_fa']       = functions::Xmlinformation( "OneBed" );
                $package['infoRooms']['single_room']['count']         = $countSingleRoom;

                if($price_per_person){
                    $package['infoRooms']['single_room']['price']         = $price['price'];
                    $package['infoRooms']['single_room']['total_price']   = $price['price'] * $countSingleRoom;
                    $package['infoRooms']['single_room']['price_a']       = ( $infoTourPackage[0]['single_room_price_a'] > 0 ) ? intval($infoTourPackage[0]['single_room_price_a']) : 0;
                    $package['infoRooms']['single_room']['total_price_a'] = ($package['infoRooms']['single_room']['price_a'] ) * $countSingleRoom;
                }else{
                    $package['infoRooms']['single_room']['price']         = $price['price'];
                    $package['infoRooms']['single_room']['total_price']   = ( $price['price'] - $infoTourPackage[0]['adult_amount']) * $countSingleRoom;
                    $package['infoRooms']['single_room']['price_a']       = ( $infoTourPackage[0]['single_room_price_a'] > 0 ) ? intval($infoTourPackage[0]['single_room_price_a']) : 0;
                    $package['infoRooms']['single_room']['total_price_a'] = ($package['infoRooms']['single_room']['price_a'] ) * $countSingleRoom;

                }

                $package['infoRooms']['single_room']['currency_type'] = ($infoTourPackage[0]['currency_type'] );
                $total_price_package += $package['infoRooms']['single_room']['total_price'] ;
            }

            if ( $countDoubleRoom > 0 ) {

                $price = $infoTourPackage[0]['double_room_price_r'] + $infoTourPackage[0]['change_price'];
                $price = $this->calculateDiscountedPrices( $infoTourPackage[0]['discount_type'], $infoTourPackage[0]['discount'], $price );
                $package['infoRooms']['double_room']['name_fa']       = functions::Xmlinformation( "TwoBed" );
                if($price_per_person){
                    $package['infoRooms']['double_room']['price']         = ($price['price'] - $infoTourPackage[0]['adult_amount']) * 2;
                    $package['infoRooms']['double_room']['price_a']       = ( $infoTourPackage[0]['double_room_price_a'] > 0 ) ? intval($infoTourPackage[0]['double_room_price_a']) * 2 : 0;
                    $package['infoRooms']['double_room']['total_price']   = ( $price['price'] - $infoTourPackage[0]['adult_amount']) * ( $countDoubleRoom  ) * 2;
                    $package['infoRooms']['double_room']['total_price_a'] = ($package['infoRooms']['double_room']['price_a']) * ( $countDoubleRoom  ) ;
                }else{
                    $package['infoRooms']['double_room']['price']         = ($price['price'] - $infoTourPackage[0]['adult_amount']);
                    $package['infoRooms']['double_room']['price_a']       = ( $infoTourPackage[0]['double_room_price_a'] > 0 ) ? intval($infoTourPackage[0]['double_room_price_a']) : 0;
                    $package['infoRooms']['double_room']['total_price']   = ( $price['price'] - $infoTourPackage[0]['adult_amount']) * ( $countDoubleRoom  );
                    $package['infoRooms']['double_room']['total_price_a'] = ($package['infoRooms']['double_room']['price_a']) * ( $countDoubleRoom  );

                }
                $package['infoRooms']['double_room']['count']         = $countDoubleRoom;
                $package['infoRooms']['double_room']['currency_type'] = ($infoTourPackage[0]['currency_type']);
                $total_price_package += $package['infoRooms']['double_room']['total_price'] ;
            }

            if ( $countThreeRoom > 0) {

                $price = $infoTourPackage[0]['three_room_price_r'] + $infoTourPackage[0]['change_price'];
                $price = $this->calculateDiscountedPrices( $infoTourPackage[0]['discount_type'], $infoTourPackage[0]['discount'], $price );

                $package['infoRooms']['three_room']['name_fa']       = functions::Xmlinformation( "ThreeBed" );
                if($price_per_person){
                    $package['infoRooms']['three_room']['price']         = ($price['price'] - $infoTourPackage[0]['adult_amount']) * 3;
                    $package['infoRooms']['three_room']['price_a']       = ( $infoTourPackage[0]['three_room_price_a'] > 0 ) ? intval($infoTourPackage[0]['three_room_price_a'] ) * 3 : 0;
                    $package['infoRooms']['three_room']['total_price']   = ( $price['price'] - $infoTourPackage[0]['adult_amount']) * ( $countThreeRoom  ) * 3 ;
                    $package['infoRooms']['three_room']['total_price_a'] = ($package['infoRooms']['three_room']['price_a'] ) * ( $countThreeRoom  ) ;
                }else{
                    $package['infoRooms']['three_room']['price']         = ($price['price'] - $infoTourPackage[0]['adult_amount']);
                    $package['infoRooms']['three_room']['price_a']       = ( $infoTourPackage[0]['three_room_price_a'] > 0 ) ? intval($infoTourPackage[0]['three_room_price_a'] ) : 0;
                    $package['infoRooms']['three_room']['total_price']   = ( $price['price'] - $infoTourPackage[0]['adult_amount']) * ( $countThreeRoom  );
                    $package['infoRooms']['three_room']['total_price_a'] = ($package['infoRooms']['three_room']['price_a'] ) * ( $countThreeRoom  );
                }
                $package['infoRooms']['three_room']['count']         = $countThreeRoom;
                $package['infoRooms']['three_room']['currency_type'] = ($infoTourPackage[0]['currency_type'] ) ;
                $total_price_package += $package['infoRooms']['three_room']['total_price'] ;

            }

            foreach($custom_room as $custom) {

                if ( $countFourRoom > 0 && $custom['fourRoom'] ) {

                    $price = $custom['fourRoom']['price_r'] + $infoTourPackage[0]['change_price'];

                    $price = $this->calculateDiscountedPrices( $infoTourPackage[0]['discount_type'], $infoTourPackage[0]['discount'], $price );

                    if($price_per_person){
                        $package['infoRooms']['four_room']['price']         = ($price['price'] - $infoTourPackage[0]['adult_amount']) * 4;
                        $package['infoRooms']['four_room']['price_a']       = ( $custom['fourRoom']['price_a'] > 0 ) ? intval($custom['fourRoom']['price_a'] )  * 4 : 0;
                        $package['infoRooms']['four_room']['total_price']   = ( $price['price'] - $infoTourPackage[0]['adult_amount']) * ( $countFourRoom  )  * 4;
                        $package['infoRooms']['four_room']['total_price_a'] = ($custom['fourRoom']['price_a'] ) * ( $countFourRoom  ) * 4;
                    }else{
                        $package['infoRooms']['four_room']['price']         = ($price['price'] - $infoTourPackage[0]['adult_amount']);
                        $package['infoRooms']['four_room']['price_a']       = ( $custom['fourRoom']['price_a'] > 0 ) ? intval($custom['fourRoom']['price_a'] ) : 0;
                        $package['infoRooms']['four_room']['total_price']   = ( $price['price'] - $infoTourPackage[0]['adult_amount']) * ( $countFourRoom  );
                        $package['infoRooms']['four_room']['total_price_a'] = ($custom['fourRoom']['price_a'] ) * ( $countFourRoom  );
                    }
                    $package['infoRooms']['four_room']['name_fa']       = functions::Xmlinformation( "fourRoom" );
                    $package['infoRooms']['four_room']['count']         = $countFourRoom;
                    $package['infoRooms']['four_room']['currency_type'] = ($infoTourPackage[0]['currency_type'] ) ;
                    $total_price_package += $package['infoRooms']['four_room']['total_price'] ;
                }

                if ( $countFiveRoom > 0 && $custom['fiveRoom'] ) {

                    $price = $custom['fiveRoom']['price_r'] + $infoTourPackage[0]['change_price'];
                    $price = $this->calculateDiscountedPrices( $infoTourPackage[0]['discount_type'], $infoTourPackage[0]['discount'], $price );
                    if($price_per_person){
                        $package['infoRooms']['five_room']['price']         = ($price['price'] - $infoTourPackage[0]['adult_amount']) * 5;
                        $package['infoRooms']['five_room']['price_a']       = ( $custom['fiveRoom']['price_a'] > 0 ) ? intval($custom['fiveRoom']['price_a'] ) * 5 : 0;
                        $package['infoRooms']['five_room']['total_price']   = ( $price['price'] - $infoTourPackage[0]['adult_amount']) * ( $countFiveRoom  )  * 5;
                        $package['infoRooms']['five_room']['total_price_a'] = ( $custom['fiveRoom']['price_a'] ) * ( $countFiveRoom  );
                    }else{
                        $package['infoRooms']['five_room']['price']         = ($price['price'] - $infoTourPackage[0]['adult_amount']);
                        $package['infoRooms']['five_room']['price_a']       = ( $custom['fiveRoom']['price_a'] > 0 ) ? intval($custom['fiveRoom']['price_a'] ) : 0;
                        $package['infoRooms']['five_room']['total_price']   = ( $price['price'] - $infoTourPackage[0]['adult_amount']) * ( $countFiveRoom  );
                        $package['infoRooms']['five_room']['total_price_a'] = ( $custom['fiveRoom']['price_a'] ) * ( $countFiveRoom  );
                    }
                    $package['infoRooms']['five_room']['name_fa']       = functions::Xmlinformation( "fiveRoom" );
                    $package['infoRooms']['five_room']['count']         = $countFiveRoom;
                    $package['infoRooms']['five_room']['currency_type'] = ($infoTourPackage[0]['currency_type'] ) ;
                    $total_price_package += $package['infoRooms']['five_room']['total_price'] ;

                }

                if ( $countSixRoom > 0 && $custom['sixRoom'] ) {

                    $price = $custom['sixRoom']['price_r'] + $infoTourPackage[0]['change_price'];
                    $price = $this->calculateDiscountedPrices( $infoTourPackage[0]['discount_type'], $infoTourPackage[0]['discount'], $price );

                    if($price_per_person){
                        $package['infoRooms']['six_room']['price']         = ($price['price'] - $infoTourPackage[0]['adult_amount']) * 6;
                        $package['infoRooms']['six_room']['price_a']       = ( $custom['sixRoom']['price_a'] > 0 ) ? intval($custom['sixRoom']['price_a'] ) * 6 : 0;
                        $package['infoRooms']['six_room']['total_price']   = ( $price['price'] - $infoTourPackage[0]['adult_amount']) * ( $countSixRoom  ) * 6;
                        $package['infoRooms']['six_room']['total_price_a'] = ($custom['sixRoom']['price_a'] ) * ( $countSixRoom  );
                    }else{
                        $package['infoRooms']['six_room']['price']         = ($price['price'] - $infoTourPackage[0]['adult_amount']);
                        $package['infoRooms']['six_room']['price_a']       = ( $custom['sixRoom']['price_a'] > 0 ) ? intval($custom['sixRoom']['price_a'] ) : 0;
                        $package['infoRooms']['six_room']['total_price']   = ( $price['price'] - $infoTourPackage[0]['adult_amount']) * ( $countSixRoom  );
                        $package['infoRooms']['six_room']['total_price_a'] = ($custom['sixRoom']['price_a'] ) * ( $countSixRoom  );
                    }

                    $package['infoRooms']['six_room']['name_fa']       = functions::Xmlinformation( "sixRoom" );
                    $package['infoRooms']['six_room']['count']         = $countSixRoom;
                    $package['infoRooms']['six_room']['currency_type'] = ($infoTourPackage[0]['currency_type'] ) ;
                    $total_price_package += $package['infoRooms']['six_room']['total_price'] ;

                }
            }

            if ( $countChildRoom > 0 ) {

                $price = $infoTourPackage[0]['child_with_bed_price_r'] + $infoTourPackage[0]['change_price'];
                $price = $this->calculateDiscountedPrices( $infoTourPackage[0]['discount_type'], $infoTourPackage[0]['discount'], $price );

                $package['infoRooms']['child_with_bed']['name_fa']       = functions::Xmlinformation( "Childwithbed" );
                $package['infoRooms']['child_with_bed']['price']         = ($price['price']  - $infoTourPackage[0]['child_amount']);
                $package['infoRooms']['child_with_bed']['count']         = $countChildRoom;
                $package['infoRooms']['child_with_bed']['total_price']   = ( $price['price']  - $infoTourPackage[0]['child_amount']) * $countChildRoom;
                $package['infoRooms']['child_with_bed']['price_a']       = ( $infoTourPackage[0]['child_with_bed_price_a'] > 0 ) ? intval($infoTourPackage[0]['child_with_bed_price_a']) : 0;
                $package['infoRooms']['child_with_bed']['total_price_a'] = ($package['infoRooms']['child_with_bed']['price_a']) * $countChildRoom;
                $package['infoRooms']['child_with_bed']['currency_type'] = ($infoTourPackage[0]['currency_type']);
                $total_price_package += $package['infoRooms']['child_with_bed']['total_price'] ;

            }

            if ( $countInfantWithoutBed > 0 ) {

                $price = $infoTourPackage[0]['infant_without_bed_price_r'] + $infoTourPackage[0]['change_price'];
                $price = $this->calculateDiscountedPrices( $infoTourPackage[0]['discount_type'], $infoTourPackage[0]['discount'], $price );

                $package['infoRooms']['infant_without_bed']['name_fa']       = functions::Xmlinformation( "Babywithoutbed" );
                $package['infoRooms']['infant_without_bed']['price']         = ($price['price'] - $infoTourPackage[0]['infant_amount']);
                $package['infoRooms']['infant_without_bed']['count']         = $countInfantWithoutBed;
                $package['infoRooms']['infant_without_bed']['total_price']   = ( $price['price'] - $infoTourPackage[0]['infant_amount'] ) * $countInfantWithoutBed;
                $package['infoRooms']['infant_without_bed']['price_a']       = ( $infoTourPackage[0]['infant_without_bed_price_a'] > 0 ) ? intval($infoTourPackage[0]['infant_without_bed_price_a'] ) : 0;
                $package['infoRooms']['infant_without_bed']['total_price_a'] = ($package['infoRooms']['infant_without_bed']['price_a'] ) * $countInfantWithoutBed;
                $package['infoRooms']['infant_without_bed']['currency_type'] = ($infoTourPackage[0]['currency_type']);
                $total_price_package += $package['infoRooms']['infant_without_bed']['total_price'] ;


            }

            if ( $countInfantWithoutChair > 0 ) {

                $price = $infoTourPackage[0]['infant_without_chair_price_r'] + $infoTourPackage[0]['change_price'];
                $price = $this->calculateDiscountedPrices( $infoTourPackage[0]['discount_type'], $infoTourPackage[0]['discount'], $price );

                $package['infoRooms']['infant_without_chair']['name_fa']       = functions::Xmlinformation( "Babywithoutchair" );
                $package['infoRooms']['infant_without_chair']['price']         = ($price['price'] - $infoTourPackage[0]['infant_amount']);
                $package['infoRooms']['infant_without_chair']['count']         = $countInfantWithoutChair;
                $package['infoRooms']['infant_without_chair']['total_price']   = ( $price['price']- $infoTourPackage[0]['infant_amount'] ) * $countInfantWithoutChair;
                $package['infoRooms']['infant_without_chair']['price_a']       = ( $infoTourPackage[0]['infant_without_chair_price_a'] > 0 ) ? intval($infoTourPackage[0]['infant_without_chair_price_a']) : 0;
                $package['infoRooms']['infant_without_chair']['total_price_a'] = ($package['infoRooms']['infant_without_chair']['price_a'] ) * $countInfantWithoutChair;
                $package['infoRooms']['infant_without_chair']['currency_type'] = ($infoTourPackage[0]['currency_type']);
                $total_price_package += $package['infoRooms']['infant_without_chair']['total_price'] ;


            }

            $package['currencyTitleFa'] = ( isset( $_POST['currencyTitleFa'] ) && $_POST['currencyTitleFa'] != '' ) ? $_POST['currencyTitleFa'] : '';


            if(functions::isEnableSetting('toman')) {
                $package['total_price_package'] = round($total_price_package/10);
            }else{
                $package['total_price_package'] = $total_price_package;
            }


            foreach ( $infoTourPackage as $k => $val ) {
                $infoReservationHotel                       = $this->getInfoReservationHotel( $val['fk_hotel_id'],$is_api );
                $package['infoHotel'][ $k ]['hotel_name']   = $val['hotel_name'];
                $package['infoHotel'][ $k ]['city_name']    = $val['city_name'];
                $package['infoHotel'][ $k ]['room_service'] = $val['room_service'];
                $package['infoHotel'][ $k ]['star_code']    = $infoReservationHotel['star_code'];
                $package['infoHotel'][ $k ]['trip_advisor'] = $infoReservationHotel['trip_advisor'];
            }

        }

		functions::insertLog( 'package id ==>' . json_encode( $package , 256 ), 'insertPackageReserve' );

		return $package;
	}
	#endregion


	#region isLastMinuteTour
	public function isLastMinuteTour( $startDate, $startTimeLastMinuteTour ) {
		if ( strpos( $startDate, "-" ) ) {
			$startDate = str_replace( "-", "", $startDate );
		} elseif ( strpos( $startDate, "/" ) ) {
			$startDate = str_replace( "/", "", $startDate );
		}
		$dateNow = dateTimeSetting::jdate( "Ymd", '', '', '', 'en' );
		$day     = $startDate - $dateNow;
		if ( ! empty( $startTimeLastMinuteTour ) & $day <= $startTimeLastMinuteTour ) {
			return 'yes';
		} else {
			return 'no';
		}
	}
	#endregion


	#region SetPriorityParentDeparture

	public function SetPriorityParentDeparture( $Param ) {
		$Model = Load::library( 'Model' );
		$Model->setTable( 'reservation_tour_tb' );
		$p1   = $Param['PriorityOld'];
		$p2   = $Param['PriorityNew'];
		$Code = $Param['CodeDeparture'];

		$RoutesSql       = "SELECT * FROM reservation_tour_tb WHERE id_same <> '{$Code}'  GROUP BY  id_same";
		$ResultRoutesSql = $Model->select( $RoutesSql );


		$RoutesSql   = "SELECT max(priority) AS MAXPriority FROM reservation_tour_tb
                      WHERE EXISTS (SELECT * FROM reservation_tour_tb WHERE priority ='{$p2}' )";
		$PriorityMax = $Model->load( $RoutesSql );

		$flag = false;

		if ( $p1 == 0 ) {
			//مقدار کد مور نظر آپدیت میشود

			$Condition              = "id_same='{$Code}'";
			$dataCodeUp['priority'] = ! empty( $PriorityMax['MAXPriority'] ) ? ( $PriorityMax['MAXPriority'] + 1 ) : $p2;
			$updatePriorityCode     = $Model->update( $dataCodeUp, $Condition );
			if ( $updatePriorityCode ) {
				$flag = true;
			}
		} elseif ( $p1 < $p2 ) {// الویت را بیشتر میکنیم
			for ( $j = 0; $j < count( $ResultRoutesSql ); $j ++ ) {
				if ( $ResultRoutesSql[ $j ]['priority'] != 0 ) {
					$dataUp['priority'] = $ResultRoutesSql[ $j ]['priority'] - 1;
				} else {
					$dataUp['priority'] = 0;
				}
				$Condition               = "priority>='{$p1}' AND priority<='{$p2}' AND id_same = '{$ResultRoutesSql[$j]['id_same']}' AND priority <> '0'";
				$updatePriorityOtherCode = $Model->update( $dataUp, $Condition );
			}
			//مقدار کد مور نظر آپدیت میشود
			$Condition              = "id_same='{$Code}'";
			$dataCodeUp['priority'] = $p2;
			$updatePriorityCode     = $Model->update( $dataCodeUp, $Condition );

			if ( $updatePriorityCode && $updatePriorityOtherCode ) {
				$flag = true;
			}
		} elseif ( $p1 > $p2 ) {// الویت را کمتر میکنیم
			for ( $j = 0; $j < count( $ResultRoutesSql ); $j ++ ) { // upd maghadir beyne p1 & p2
				if ( $ResultRoutesSql[ $j ]['priority'] != 0 ) {
					$dataDown['priority'] = $ResultRoutesSql[ $j ]['priority'] + 1;
				} else {
					$dataDown['priority'] = 0;
				}
				$Condition               = "priority<='{$p1}' AND priority>='{$p2}' AND id_same = '{$ResultRoutesSql[$j]['id_same']}' AND priority <> '0'";
				$updatePriorityOtherCode = $Model->update( $dataDown, $Condition );
			}
			//مقدار کد مور نظر آپدیت میشود
			$dataDownCode['priority'] = $p2;
			$Condition                = "id_same='{$Code}'";
			$updatePriorityCode       = $Model->update( $dataDownCode, $Condition );


			if ( $updatePriorityCode && $updatePriorityOtherCode ) {
				$flag = true;
			}
		}

		if ( $flag ) {
			return 'SuccessChangePriority:تغییر الویت با موفیقت انجام شد';
		} else {
			return 'ErrorChangePriority:خطا در تغییر الویت';
		}

	}

	#endregion

	function sortTour() {

		$Model  = Load::library( 'Model' );
		$sql    = " SELECT title_en FROM reservation_tour_setting_tb WHERE enable='1' AND is_del='no'";
		$result = $Model->load( $sql );
		if ( ! empty( $result ) ) {
			return $result['title_en'];
		} else {
			return 'max_star_code';
		}

	}

	/**
	 * @param $id
	 * @param array $minPrice
	 *
	 * @return array
	 */
	public function doDiscount( $id, array $minPrice, $web_service_type = 'private' ) {




//        var_dump($id,  $minPrice, $web_service_type);
//        die;
//        if(  $_SERVER['REMOTE_ADDR']=='93.118.161.174'  ) {
//            var_dump('aaaa');
//            var_dump($id,  $minPrice, $web_service_type);
//            var_dump('bbbb');
//            die;
//        }

		$destination_country_id          = functions::getTypeServiceTour( 'reservation', $id );
		$minPrice['discountedMinPriceR'] = null;
		if ( $destination_country_id == 'PrivatePortalTour' ) {
//            var_dump('22222');
//
//            die;
			if ( ! empty( $this->portalServiceDiscount[ $web_service_type ] ) && $this->portalServiceDiscount[ $web_service_type ]['off_percent'] > 0 ) {
				$price                           = $minPrice['minPriceR'];
				$price                           = $price - ( ( $price * $this->portalServiceDiscount[ $web_service_type ]['off_percent'] ) / 100 );
				$minPrice['discountedMinPriceR'] = $price;
			}
		} elseif ( $destination_country_id == 'PrivateLocalTour' ) {
//            var_dump('aaaa');
//            var_dump($this->localServiceDiscount[ $web_service_type ]);
//            var_dump($this->localServiceDiscount[ $web_service_type ]['off_percent']);
//            var_dump($minPrice['minPriceR']);
//            die;
			if ( ! empty( $this->localServiceDiscount[ $web_service_type ] ) && $this->localServiceDiscount[ $web_service_type ]['off_percent'] > 0 ) {
				$price                           = $minPrice['minPriceR'];
				$price                           = $price - ( ( $price * $this->localServiceDiscount[ $web_service_type ]['off_percent'] ) / 100 );
				$minPrice['discountedMinPriceR'] = $price;
			}
		}

		return $minPrice;
	}

    public function calculateDiscount($tour_id, array $minPrice, $package_id,$age_type='adult') {


        if(!$this->counter_types){
            $this->getCounterTypes();
        }


        if(Session::IsLogin()){

        $counter_type_id = Session::getCounterTypeId();

        }else{
            $counter_type_id='5';
        }


        $discount_counter=functions::arrayFilterByValue($this->counter_types,'id',$counter_type_id)[0];

        $field_name ='adult_amount';
        switch ($age_type){
            case 'adult':
                $field_name ='adult_amount';
                break;
            case 'child':
                $field_name ='child_amount';
                break;
            case 'infant':
                $field_name ='infant_amount';
                break;
        }


        $discount = $this->getModel('reservationTourDiscountModel')
            ->get($field_name)
            ->where('tour_package_id', $package_id)
            ->where('tour_id', $tour_id)
            ->where('counter_type_id', $counter_type_id)
            ->find();

        $price = $minPrice['minPriceR'];

        $minPrice['discount'] = $discount;
        $minPrice['discount']['after_discount'] = $price;


        $discount_result = $discount[$field_name];


        if($price > $discount_result){
            $price = $price - $discount_result;
            $minPrice['discount']['after_discount'] = $minPrice['minPriceR'] - $discount_result;
        }
        $minPrice['discountedMinPriceR'] = $price;
        $minPrice['discount']['counter_type_name'] =$discount_counter['name'] ;



        return $minPrice;
    }


    public function getDiscountCounterOneDayTour($params) {
        $counter_type_id = 0;

            $counter_type_id= (Session::IsLogin()) ? Session::getCounterTypeId(): '5';

        return  $this->getModel('reservationTourDiscountModel')
            ->get()
            ->where('tour_id', $params['id_same'])
            ->where('counter_type_id', $counter_type_id)
            ->find();
    }





}


