<?php
/**
 * Class reservationTour
 * @property reservationTour $reservationTour
 */
//if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20'  ) {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}


//ini_set('memory_limit', '-1');

class manifestTourController extends clientAuth
{

    public $id;


    public function __construct()
    {
        parent::__construct();

    }


    public function reportTourManifest($agencyId = null)
    {

        $Model = Load::library('Model');
        $counters = array();
        if ($agencyId) {
            $sqlCounters = "SELECT id, name, family, mobile FROM members_tb 
                        WHERE fk_agency_id = '{$agencyId}' AND active = 'on' AND del = 'no'";

            $countersResult = $Model->select($sqlCounters);

            foreach ($countersResult as $counter) {
                $counters[$counter['id']] = [
                    'name' => $counter['name'] . ' ' . $counter['family'],
                    'mobile' => $counter['mobile']
                ];
            }
        }

        if (empty($counters)) {
            return array();
        }

        $counterIds = implode("', '", array_keys($counters));
        $userIdCondition = " WHERE T.user_id IN ('{$counterIds}') ";


        if (SOFTWARE_LANG == 'fa') {
            $dateNow = dateTimeSetting::jdate("Ymd", '', '', '', 'en');
        } else {
            $dateNow = date("Ymd");
        }

        $sql = "SELECT   	
            (SELECT min(subQueryReservation.start_date) FROM reservation_tour_tb as subQueryReservation
              WHERE subQueryReservation.is_del = 'no' AND subQueryReservation.id_same = T.id_same
            GROUP BY subQueryReservation.id_same  
            ORDER BY subQueryReservation.id_same DESC) AS minDate,
            (SELECT max(subQueryReservation.end_date) FROM reservation_tour_tb as subQueryReservation
             WHERE subQueryReservation.is_del = 'no' AND subQueryReservation.id_same = T.id_same
            GROUP BY subQueryReservation.id_same  
            ORDER BY subQueryReservation.id_same DESC) AS maxDate,
            T.id,
            T.tour_type_id,
            T.user_id,
            T.discount_type,
            T.is_show,
            T.is_del,
            T.tour_name,
            T.tour_name_en,
            T.priority,
            T.tour_code,
            T.night,
            T.`day`,
            T.`create_date_in`,
            T.`create_time_in`,
            T.`discount`,
            T.`language`,
            T.`id_same`,
            T.`suggested`,
            T.`is_special`,
            TR.destination_country_name,
            TR.destination_country_id,
            TR.destination_city_id,
            TR.destination_city_name
        FROM
            reservation_tour_tb as T 
        INNER JOIN reservation_tour_rout_tb AS TR ON T.id = TR.fk_tour_id
        {$userIdCondition} 
        GROUP BY T.id_same 
        ORDER BY T.id_same DESC";

        $tour = $Model->select($sql);
        foreach ($tour as &$tourItem) {
            $userId = $tourItem['user_id'];
            if (isset($counters[$userId])) {
                $tourItem['counter_name'] = $counters[$userId]['name'];
                $tourItem['counter_mobile'] = $counters[$userId]['mobile'];
            } else {
                $tourItem['counter_name'] = 'نامشخص';
                $tourItem['counter_mobile'] = '---';
            }
        }

        return $tour;
    }





    public function getTourBookingCount($tourCode)
    {
        if (empty($tourCode)) {
            return 0;
        }

        $Model = Load::library('Model');

        $sql = "SELECT COUNT(*) AS total 
            FROM book_tour_local_tb 
            WHERE tour_code = '{$tourCode}' 
            AND ( 
                status = 'BookedSuccessfully' 
                OR 
                (status = 'RequestAccepted' AND payment_status = 'fullPayment')
            )";

        $result = $Model->select($sql);

        if (!empty($result[0]['total'])) {
            return (int)$result[0]['total'];
        }

        return 0;
    }









}


?>
