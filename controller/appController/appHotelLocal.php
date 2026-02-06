<?php
/**
 * Class appHotelLocal
 * @property appHotelLocal $appHotelLocal
 */
class appHotelLocal extends apiHotelLocal
{


    public function __construct()
    {

    }

    #region getAllCityForSearch
    public function getAllCityForSearch($cityName, $country = null)
    {
        $Model = Load::library('Model');
        $sql = " SELECT id, name FROM reservation_city_tb WHERE 1=1 ";
        if (isset($country) && $country != '') {
            $sql .= " AND id_country = '{$country}' ";
        }
        $sql .= " AND name LIKE '%" . $cityName . "%' ";
        $result = $Model->select($sql);

        return $result;

    }
    #endregion


    #region getHotelListBySearch
    public function getHotelListBySearch($param)
    {
        $objResultHotelLocal = Load::controller('resultHotelLocal');
        $objResultHotelLocal->getHotelByCity($param['cityId'], $param['startDate'], $param['endDate'], 'app');
        $printListHotel = '';
        if (!empty($objResultHotelLocal->Hotel)) {
            foreach ($objResultHotelLocal->Hotel as $hotel) {
                $printListHotel .= '
            <div class="hotel-result-item"
                    data-hotelId="' . $hotel['hotel_id'] . '"
                    data-typeApplication="' . $hotel['type_application'] . '"
                    data-star="' . $hotel['star_code'] . '"
                    data-hotelType="' . $hotel['type_code'] . '"
                    data-price="' . $hotel['min_room_price'] . '"
                    >
                <a href="#" class="hotel-result-item-inner" id="viewHotel" 
                    hotelId="' . $hotel['hotel_id'] . '"
                    typeApplication="' . $hotel['type_application'] . '"
                    >
                    <div class="hotel-result-thumb">
                        <img src="' . $hotel['pic'] . '" alt="' . $hotel['hotel_name'] . '">';
                if ($hotel['type_application'] == 'reservation') {
                    $printListHotel .= '<span>ویژه</span>';
                }
                $printListHotel .= '</div>
                    <div class="hotel-result-item-info">
                        <span class="hrii-name">' . $hotel['hotel_name'] . '<span>(<i id="starHotel">' . $hotel['star_code'] . '</i> ستاره)</span></span>
                        <span class="hrii-loc">
					<i>
						<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
						<g>
						<path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035
						c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719
						c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z"/>
						</g>
						</svg>
					</i>
				' . $hotel['address'] . '
				</span>
                        ';
                if ($hotel['min_room_price'] > 0) {
                    $printListHotel .= '<span class="hrii-price"> قیمت از شبی<span><b id="priceHotelTRoom">' . number_format($hotel['min_room_price']) . '</b><i>ریال </i></span></span>';
                }
                if ($hotel['discount'] > 0) {
                    $printListHotel .= '<span class="hrii-off site-bg-main-color"> تخفیف تا <i>' . $hotel['discount'] . '%</i></span>';
                }
                $printListHotel .= '</div>
                </a>
            </div>
            ';
            }
        }
        return $printListHotel;
    }
    #endregion


    #region userBuyReport
    public function userBuyReport()
    {
        $Model = Load::library('Model');
        $userId = Session::getUserId();
        /*$sql = "SELECT * "
            . " FROM book_hotel_local_tb "
            . " WHERE member_id='{$userId}' AND status='BookedSuccessfully' "
            . " GROUP BY factor_number ORDER BY creation_date_int DESC ";*/
        $sql = "SELECT * "
            . " FROM book_hotel_local_tb "
            . " WHERE member_id='{$userId}' 
            AND (
            ( ( type_application = 'reservation_app' OR type_application = 'api_app' ) AND ( STATUS = 'BookedSuccessfully' OR STATUS = 'PreReserve' ) ) 
            OR ( ( type_application = 'reservation' OR type_application = 'api' ) AND STATUS = 'BookedSuccessfully' ) 
            )  "
            . " GROUP BY factor_number ORDER BY creation_date_int DESC ";
        $buy = $Model->select($sql);

        return $buy;
    }
    #endregion


    #region getInfoHotelBook
    public function getInfoHotelBook($factorNumber)
    {
        $Model = Load::library('Model');
        $userId = Session::getUserId();
        $sql = "SELECT * "
            . " FROM book_hotel_local_tb "
            . " WHERE factor_number='{$factorNumber}' ";
        $result = $Model->select($sql);

        return $result;
    }
    #endregion


}