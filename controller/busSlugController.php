<?php

class busSlugController extends slugController implements slugInterface
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
        $SEARCH_ORIGIN_CITY = SEARCH_ORIGIN_CITY;
        $SEARCH_DESTINATION_CITY = SEARCH_DESTINATION_CITY;

        return "${ROOT_ADDRESS}/buses/" . $SEARCH_ORIGIN_CITY.'-'. $SEARCH_DESTINATION_CITY;

    }

}
