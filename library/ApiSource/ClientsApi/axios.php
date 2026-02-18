<?php
class axios{
    protected $content;
    protected $adminController;

    public function __construct()
    {
        header("Content-type: application/json");

            $this->content=json_decode(file_get_contents('php://input'), true);
            if(empty($this->content)){
            	$this->content = $_REQUEST;
            }
            
            $this->adminController=Load::controller('admin');
            $method=$this->content['method'];
            $params=$this->content;
            echo $this->$method($params);
    }

    public function getPackage($params)
    {
        $package = Load::controller('package');
        return $package->getPackage($params);
    }

    public function getFullCapacity($params)
    {
        $full_capacity = Load::controller('fullCapacity');
        return $full_capacity->getFullCapacitySite($params);
    }
    public function getFlight($params)
    {
        /** @var newApiFlight $newObjectController */
        $newObjectController = Load::controller('newApiFlight',$params['urlWeb']);
        return $newObjectController->getTicketList();
    }

    public function dateRout($params)
    {
        Load::controllerWithParams('newApiFlight');
        $newObjectController = new newApiFlight($params['urlWeb']);
        $result['init'] = $newObjectController->dateRout();
        return $newObjectController->dateRout();
    }

    public function getCities($params)    {
        return functions::getAirport(array($params['param'][0],$params['param'][1]['origin']));
    }

    public function initialInformation($params)
    {
        Load::controllerWithParams('newApiFlight');
        $newObjectController = new newApiFlight($params['urlWeb']);
        return $newObjectController->dateRout();
    }

    public function searchboxHotels( $params ) {

        $name      = urldecode( $params['inputValue'] );
        $result    = [];
        $hotelHtml = '';
        $i         = 0;

        $Model = Load::library('Model');
        $sqlReservationCities = "
		SELECT id AS city_id,name AS city_name, name_en AS city_name_en FROM reservation_city_tb WHERE id_country=1 AND reservation_city_tb.name LIKE '{$name}%' OR reservation_city_tb.name_en LIKE '{$name}%'
		";
        echo json_encode($Model->load($sqlReservationCities)); die();
        $Client = functions::infoClientByDomain($params['domain']);
        $clientId = $Client['id'];

        /** @var admin $admin */
        $admin = Load::controller('admin');

        $cities = $admin->ConectDbClient($sqlReservationCities,$clientId,'SelectAll');

        if ( count( $cities ) > 0 ) {
            $result['Cities'] = [];
            foreach ( $cities as $city ) {
                $cityItem = [
                    'CityId'     => $city['city_id'],
                    'CityName'   => $city['city_name'],
                    'CityNameEn' => $city['city_name_en'],
                ];

                $result['Cities'][] = $cityItem;
            }
        }

        $sqlReservationHotel = "
		SELECT
	reservation_hotel_tb.`id` AS hotel_id,
	reservation_hotel_tb.`name` AS hotel_name,
	reservation_hotel_tb.`name_en` AS hotel_name_en,
	reservation_hotel_tb.`city` AS city_id,
	reservation_hotel_tb.`priority` AS hotel_priority,
	reservation_hotel_tb.`discount`,
	'roomHotelLocal' AS page,
	'reservation' AS typeApp,
	reservation_city_tb.`name` AS city_name
FROM
	reservation_hotel_tb
	INNER JOIN reservation_city_tb ON reservation_hotel_tb.city = reservation_city_tb.id
WHERE
	reservation_hotel_tb.`name` LIKE '%{$name}%'
	OR reservation_hotel_tb.`name_en` LIKE '%{$name}%'
	AND reservation_hotel_tb.`is_del` = 'no'";
        $reservationHotels   = $admin->ConectDbClient($sqlReservationHotel,$clientId,'Select');
//        $reservationHotels   = $Model->select( $sqlReservationHotel );

        $labelReservation = "no";

        if ( count( $reservationHotels ) > 0 ) {
            foreach ( $reservationHotels as $hotel ) {
                $i ++;
                //				$ReservationHotel = [];
                $hotelNameEn = trim( strtolower( $hotel['hotel_name_en'] ) );
                $hotelNameEn = str_replace( "  ", " ", $hotelNameEn );
                $hotelNameEn = str_replace( " ", "-", $hotelNameEn );

                $ReservationHotel = [
                    'HotelId'     => trim( $hotel['hotel_id'] ),
                    'HotelName'   => trim( $hotel['hotel_name'] ),
                    'HotelNameEn' => $hotelNameEn,
                    'CityName'    => trim( $hotel['city_name'] ),
                    'CityId'      => $hotel['city_id'],
                ];

                $result['ReservationHotels'][] = $ReservationHotel;
            }
        }

        /*get data from api */
        Load::library( 'ApiHotelCore' );
        $ApiHotelCore = new ApiHotelCore();
        $apiResult    = $ApiHotelCore->GetHotelsByName( $name );
        if ( is_array( $apiResult ) && count( $apiResult ) > 0 ) {
            foreach ( $apiResult as $hotel ) {
                $i ++;
                $hotelNameEn = strtolower( trim( urldecode( $hotel['NameEn'] ) ) );
                $hotelNameEn = str_replace( "  ", " ", $hotelNameEn );
                $hotelNameEn = str_replace( " ", "-", $hotelNameEn );
                $ApiHotel    = [
                    'HotelId'     => $hotel['Id'],
                    'HotelName'   => $hotel['Name'],
                    'HotelNameEn' => $hotelNameEn,
                    'CityName'    => $hotel['CityName'],
                    'CityId'      => $hotel['CityId'],
                ];

                $result['ApiHotels'][] = $ApiHotel;

            }
        }

        echo json_encode( $result, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
        exit();
    }

    public function getPricePackage($params)
    {
        unset($params['method']);
        $getDetailAndPriceHotel = Load::controller('package');
        return $getDetailAndPriceHotel->getDetailAndPrice($params);
    }

    public function revalidateFlightPackage($params)
    {

        $getInfoRevalidateController = Load::controller('package');

        return $getInfoRevalidateController->revalidateFlight($params);
    }

    public function InsertHotelPackage($params)
    {
        $getInfoRevalidateController = Load::controller('package');

        return $getInfoRevalidateController->InsertHotelPackage($params);

    }
	
	public function searchHotels($params) {
    	
//    	$params = $_GET;
//    	echo json_encode($params);
//    	exit();
//    	unset($params['method']);
    	
		/** @var ApiHotelSearch $ApiHotelSearch */
		$ApiHotelSearch = Load::controller('ApiHotelSearch');
		return $ApiHotelSearch->searchHotels($params);
    }
}

new axios();
