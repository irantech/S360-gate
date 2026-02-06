<?php

class hotelSlugController extends slugController implements slugInterface
{
    protected static $model = reservationHotel::class;

    public function initData() {
        // TODO: Implement initData() method.
    }

    public function getData() {
        // TODO: Implement getData() method.
    }

    public function getUrl() {
        $ROOT_ADDRESS = ROOT_ADDRESS;
        $SEARCH_COUNTRY = SEARCH_COUNTRY;
        $SEARCH_CITY = SEARCH_CITY;

        $url = "${ROOT_ADDRESS}/resultExternalHotel/" . $SEARCH_COUNTRY.'/'  . $SEARCH_CITY;

        return $url;
    }
    
}
