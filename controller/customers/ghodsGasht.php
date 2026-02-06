<?php
//todo: ********************* CREATE ACCESS CLIENT FOR ((FLIGHT + HOTEL)) *********************




class ghodsGasht extends mainPage {

    public function __construct() {

        parent::__construct();
    }


    public function classTabsSearchBox($service_name) {
        switch ($service_name) {
            case 'Flight':
                return 'fa-light fa-plane-circle-check';
                break;
            case 'Hotel':
                return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M48 384C56.84 384 64 376.8 64 368c0-105.9 86.13-192 192-192s192 86.13 192 192c0 8.844 7.156 16 16 16s16-7.156 16-16c0-118.1-91.97-214.9-208-223.2V96h32C312.8 96 320 88.84 320 80S312.8 64 304 64h-96C199.2 64 192 71.16 192 80S199.2 96 208 96h32v48.81C123.1 153.1 32 249.9 32 368C32 376.8 39.16 384 48 384zM496 416h-480C7.156 416 0 423.2 0 432S7.156 448 16 448h480c8.844 0 16-7.156 16-16S504.8 416 496 416z"/></svg>';
                break;
            case 'Train':
                return 'fa-light fa-train';
                break;
            case 'Package':
                return 'fa-light fa-tree-palm';
                break;
            case 'Bus':
                return 'fa-light fa-bus';
                break;
            case 'Tour':
                return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M352.1 128h-32.07l.0123-80c0-26.47-21.53-48-48-48h-96c-26.47 0-48 21.53-48 48L128 128H96.12c-35.35 0-64 28.65-64 64v224c0 35.35 28.58 64 63.93 64L96 496C96 504.8 103.2 512 112 512S128 504.8 128 496V480h192v16c0 8.836 7.164 16 16 16s16-7.164 16-16l.0492-16c35.35 0 64.07-28.65 64.07-64V192C416.1 156.7 387.5 128 352.1 128zM160 48C160 39.17 167.2 32 176 32h96C280.8 32 288 39.17 288 48V128H160V48zM384 416c0 17.64-14.36 32-32 32H96c-17.64 0-32-14.36-32-32V192c0-17.64 14.36-32 32-32h256c17.64 0 32 14.36 32 32V416zM304 336h-160C135.2 336 128 343.2 128 352c0 8.836 7.164 16 16 16h160c8.836 0 16-7.164 16-16C320 343.2 312.8 336 304 336zM304 240h-160C135.2 240 128 247.2 128 256c0 8.836 7.164 16 16 16h160C312.8 272 320 264.8 320 256C320 247.2 312.8 240 304 240z"/></svg>';
                break;
            case 'Insurance':
                return 'fa-light fa-umbrella-beach';
                break;
            case 'GashtTransfer':
                return 'fa-light fa-cars';
                break;
            case 'Europcar':
                return 'fa-light fa-car';
                break;
            case 'Entertainment':
                return 'fa-light fa-tree-city';
                break;
            case 'Visa':
                return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M224 80c-70.75 0-128 57.25-128 128s57.25 128 128 128s128-57.25 128-128S294.8 80 224 80zM129.6 224h39.13c1.5 27 6.5 51.38 14.12 70.38C155.3 281.1 134.9 255.3 129.6 224zM168.8 192H129.6c5.25-31.25 25.62-57.13 53.25-70.38C175.3 140.6 170.3 165 168.8 192zM224 302.8C216.3 295.3 203.3 268.3 200.6 224h46.75C244.8 268.3 231.8 295.3 224 302.8zM200.5 192C203.3 147.8 216.3 120.8 224 113.3C231.8 120.8 244.8 147.8 247.4 192H200.5zM265.1 294.4C272.8 275.4 277.8 251 279.3 224h39.13C313.1 255.3 292.8 281.1 265.1 294.4zM279.3 192c-1.5-27-6.5-51.38-14.12-70.38c27.62 13.25 48 39.13 53.25 70.38H279.3zM448 368v-320C448 21.49 426.5 0 400 0h-320C35.82 0 0 35.82 0 80V448c0 35.35 28.65 64 64 64h368c8.844 0 16-7.156 16-16S440.8 480 432 480H416v-66.95C434.6 406.4 448 388.8 448 368zM384 480H64c-17.64 0-32-14.36-32-32s14.36-32 32-32h320V480zM400 384H64c-11.71 0-22.55 3.389-32 8.9V80C32 53.49 53.49 32 80 32h320C408.8 32 416 39.16 416 48v320C416 376.8 408.8 384 400 384z"/></svg>';
                break;
            default:
                return '';


        }
    }


    public function nameTabsSearchBox($service_name) {
        switch ($service_name) {
            case 'Flight':
                return functions::Xmlinformation("Airplane") ;
                break;
            case 'Hotel':
                return functions::Xmlinformation("Hotel") ;
                break;
            case 'Train':
                return functions::Xmlinformation("Train") ;
                break;
            case 'Package':
                return functions::Xmlinformation("Flight") . '+' . functions::Xmlinformation("Hotel") ;
                break;
            case 'Bus':
                return functions::Xmlinformation("Bus") ;
                break;
            case 'Tour':
                return functions::Xmlinformation("Tour") ;
                break;
            case 'Insurance':
                return functions::Xmlinformation("Insurance") ;
                break;
            case 'GashtTransfer':
                return functions::Xmlinformation("GashtTransfer") ;
                break;
            case 'Europcar':
                return functions::Xmlinformation("Carrental") ;
                break;
            case 'Entertainment':
                return functions::Xmlinformation("Entertainment") ;
                break;
            case 'Visa':
                return functions::Xmlinformation("Visa") ;
                break;
            default:
                return '';


        }
    }


    public function nameBoxSearchBox($service_name) {
        switch ($service_name) {
            case 'Flight':
                return functions::Xmlinformation("foreingIranFlightsTickets") ;
                break;
            case 'Hotel':
                return functions::Xmlinformation("foreigneIranHotel") ;
                break;
            case 'Train':
                return functions::Xmlinformation("trainTicket") ;
                break;
            case 'Package':
                return functions::Xmlinformation("flightHotelpackage") ;
                break;
            case 'Bus':
                return functions::Xmlinformation("Busticket") ;
                break;
            case 'Tour':
                return functions::Xmlinformation("foreigneIranTours") ;
                break;
            case 'Insurance':
                return functions::Xmlinformation("travelInsurance") ;
                break;
            case 'GashtTransfer':
                return functions::Xmlinformation("GashtTransfer") ;
                break;
            case 'Europcar':
                return functions::Xmlinformation("S360Car") ;
                break;
            case 'Entertainment':
                return functions::Xmlinformation("S360Entertainment") ;
                break;
            case 'Visa':
                return functions::Xmlinformation("Visa") ;
                break;
            default:
                return '';


        }
    }

}