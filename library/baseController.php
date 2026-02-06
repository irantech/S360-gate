<?php

class baseController {

    /**
     * @param $model_name
     * @return bool|mixed|Model|ModelBase|flightRouteModel|FlightPortalModel|reservationTourTourtypeModel|airportModel|flightRouteCustomerModel
     */
    public function getModel($model_name) {

        return Load::getModel($model_name);
    }

    /**
     * @param $controller_name
     * @return admin|bool|mixed|members|routeFlight|clientAuth|servicesDiscount|newApiFlight|mainTour|routeTrain|resultBus|reservationHotel|insurance|priceChanges|routeFlight|reservationPublicFunctions|resultReservationTicket|transaction|CreditDetail|airline|bank|accountcharge|configFlight|temporaryLocalModel|currencyEquivalent|passengers|partner|memberCredit|reportFlight|clientWhiteCommission|BookingHotelNew|country|hotelCities|counterType|bookRoutes|logErrorFlights|sliders|continentCodes|routeTrain|gashToTransferCities|cancellationFeeSetting|apiCodeExist|settingCore|reservationBasicInformation
     */
    public function getController($controller_name,$param=null) {
        return Load::controller($controller_name,$param);
    }

    /**
     * @param $library_name
     * @return mixed|Model|ModelBase|apiLocal
     */
    public function getLibrary($library_name) {
        return Load::library($library_name);
    }


}