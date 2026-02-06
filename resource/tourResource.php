<?php

require_once('./resource/resourceAbstract.php');

class tourResource extends resourceAbstract
{
    protected $fillables = array(
        'id',
        'id_same',
        'tour_name',
        'tour_name_en',
        'language',
        'tour_pic',
        'full_url_tour_pic' => 'tour_pic',  // Custom index with transformation
        'min_price_r',
        'night',
        'origin_city_name',
        'origin_city_name_en',
        'origin_country_name',
        'origin_country_name_en',
        'start_date',
        'description',
        'destination_country_name',
    );
    protected $destinationFillables = array(
        'country_name',
        'city_name',
        'night'
    );
    protected $hotelFillables = array(
        'star',
        'name',
        'name_en'
    );

    /**
     *
     * @param $inner_data
     * @return array
     */
    public function collection($inner_data) {

        $result = $this->resourceMaker($inner_data, $this->fillables);
        foreach ($result as $index => $tour) {
            $result[$index]['destinations'] = $this->destinationResourceMaker($inner_data[$index]['destinations']);
            if (count($inner_data[$index]['hotels']) > 0) {
                $result[$index]['hotels'] = $this->hotelResourceMaker($inner_data[$index]['hotels']);
            }


            if (isset($inner_data[$index]['getTypeVehicle'])) {
                $result[$index]['getTypeVehicle'] = $inner_data[$index]['getTypeVehicle'];
            }

            if (isset($inner_data[$index]['discount'])) {
                $result[$index]['discount'] = $inner_data[$index]['discount'];
            }
        }
        return $result;
    }

    /**
     * Custom transformation function to create full URL for tour_pic
     *
     * @param $tour_pic
     * @return string
     */
    protected function full_url_tour_pic($tour_pic) {
        return ROOT_ADDRESS_WITHOUT_LANG . '/pic/reservationTour/' . $tour_pic;
    }

    protected function destinationResourceMaker($destinations) {
        return $this->resourceMaker($destinations, $this->destinationFillables);
    }

    protected function hotelResourceMaker($hotels) {

        return $this->resourceMaker($hotels, $this->hotelFillables,true);
    }
}
