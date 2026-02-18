<?php


class tourModel extends Model
{
    protected $table = 'flight_route_tb';
    protected $pk = 'id';


    /**
     * @param string $origin_country
     * @param numeric $limit
     * @param string $type
     * @param string $language
     * @return array|false
     */
    public function getTours($origin_country, $limit, $language = 'fa',$type=null)
    {


        $limit = ' Limit ' . $limit;


        $type_condition = '';
        $discount_condition = '';
        $conditionSpecial = '';

        if (!empty($type)) {
            if (is_numeric($type)) {
                $type_condition = " AND tourType.fk_tour_type_id = '{$type}' ";
            }
            if ($type == 'discount') {
                $discount_condition = " AND tour.discount > 0 ";
            }
            if ($type == 'special') {
                $conditionSpecial = " AND tour.is_special = 'yes' ";
            }
        }

        if ($origin_country == 'internal') {
            $origin_country = '=1';
        } elseif ($origin_country == 'external') {
            $origin_country = '!=1';
        }
        $correct_date = date("Ymd", time());
        if ($language == 'fa') {
            $correct_date = dateTimeSetting::jdate("Ymd", "", "", "", "en");

        }
        $sql = "SELECT
                    tour.id,
                    tour.id_same,
                    tour.tour_name_en,
                    tour.tour_name,
                    tour.night,
                    tour.start_date,
                    tour.tour_pic,
                    tour.tour_type_id,
                    tourPackage.double_room_price_r as tour_price,
                    tour.is_special 
                FROM
                    reservation_tour_tb AS tour
                    INNER JOIN reservation_tour_rout_tb AS tourRout ON tourRout.fk_tour_id = tour.id 
                    LEFT JOIN reservation_tour_package_tb AS tourPackage ON tour.id = tourPackage.fk_tour_id
                WHERE
                    tour.is_del = 'no' 
                    AND tour.is_show = 'yes' 
                    AND tour.LANGUAGE = '{$language}' 
                    AND tour.start_date > '{$correct_date}'
                    AND tourRout.destination_country_id {$origin_country}
                    AND tourRout.tour_title = 'dept' 
            
                {$type_condition}
                {$discount_condition}
                {$conditionSpecial}
                            
                GROUP BY
                    tour.id_same 
                ORDER BY
                    tour.priority = 0,
                    tour.priority {$limit}";


        return parent::select($sql);
    }


}