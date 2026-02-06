<?php
//$message = "start page external_hotel_ajax";
//$messages = date('Y/m/d H:i:s') . " microtime => " . microtime(true) * 1000 . "   " . $message . " \n";
//error_log($messages, 3, dirname(dirname(__FILE__)) . '/gds/logs/' . '00000-checkExternalHotel.txt');
//error_reporting( 1 );
//error_reporting( E_ALL | E_STRICT );
//@ini_set( 'display_errors', 1 );
//@ini_set( 'display_errors', 'on' );

$array_special_char = ["\n", "‘", "’", "“", "”", "„" , "(", ")", "<", ">","</","/>","alert","+","from","sleep"] ;
foreach ($_POST as $key=>$item) {
    $item_after_replace[$key] = str_replace($array_special_char, '', $item);

    $_POST[$key] = $item_after_replace[$key];
}

require 'config/bootstrap.php';
require CONFIG_DIR . 'config.php';
require CONFIG_DIR . 'configBase.php';
require LIBRARY_DIR . 'functions.php';
require CONTROLLERS_DIR . 'dateTimeSetting.php';
require LIBRARY_DIR . 'Load.php';
spl_autoload_register(array('Load', 'autoload'));
//functions::insertLog("after load files", '00000-checkExternalHotel', 'yes');

if (isset($_POST['flag'])) {

    $flag = $_POST['flag'];
    unset($_POST['flag']);

    switch ($flag) {
        case 'getResultExternalHotelPreviewReally':

            $return = [];
            functions::insertLog("start ajax preview", '00000-checkExternalHotel', 'yes');
            $objHotel = Load::controller('resultExternalHotel');
	
	        /** @var resultExternalHotel $objHotel */
	        $result = $objHotel->getHotelsFromDB( $_POST['countryNameEn'], $_POST['cityNameEn'], $_POST['startDate'], $_POST['nights']);
            if (!empty($result)) {

                ob_start();

                foreach ($result as $k => $hotel) {

                    if ($hotel['hotel_stars'] > 0) {
                        $star = $hotel['hotel_stars'];
                    } else {
                        $star = 2;
                    }
                    ?>
                    <div class="hotelResultItem" id="boxHotel_<?php echo $hotel['hotel_index']; ?>">
                        <div id="a1" class="hotel-result-item hotel-result-item-external"
                             data-typeApplication="<?php echo $hotel['type_app']; ?>"
                             data-price="<?php echo $hotel['minimum_room_price']; ?>"
                             data-star="<?php echo $star; ?>"
                             data-freeBreakfast="<?php echo $hotel['free_breakfast']; ?>"
                             data-facilities="<?php echo $hotel['facilities']; ?>"
                             data-hotelName="<?php echo $hotel['hotel_persian_name']; ?> <?php echo $hotel['hotel_name']; ?>"
                             data-hotelAddress="<?php echo $hotel['hotel_address']; ?>">

                            <?php
                            if ($hotel['type_app'] == 'reservation') {
                                ?>
                                <div class="ribbon-special-external-hotel">
                                    <span><i><?php echo Functions::Xmlinformation('Specialhotel') ?></i></span></div>
                                <?php
                            }
                            ?>

                            <div class="col-md-8 nopad">
                                <div class="hotel-result-item-content external-hotel-content">
                                    <div class="hotel-result-item-text">
                                        <a onclick="externalHotelDetail('<?php echo $hotel['type_app']; ?>', '<?php echo $hotel['hotel_index']; ?>', '<?php echo $hotel['hotel_name']; ?>')">
                                            <b class="hotel-result-item-name txtLeft"><?php echo $hotel['hotel_name']; ?></b>
                                        </a>

                                        <span class="hotel-star external-hotel-star">
                                    <input type="hidden" id="starSortDep" name="starSortDep"
                                           value="<?php echo $star; ?>">
                                            <?php
                                            for ($s = 1; $s <= $star; $s++) {
                                                ?>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <?php
                                            }
                                            for ($ss = $s; $ss <= 5; $ss++) {
                                                ?>
                                                <i class="fa fa-star-o" aria-hidden="true"></i>
                                                <?php
                                            }
                                            ?>
                                            </span>
                                        <input id="idHotel" name="idHotel" type="hidden"
                                               value="<?php echo $hotel['hotel_index']; ?>">

                                        <span class="hotel-result-item-content-location
                                    fa fa-map-marker external-hotel-location">
                                    <?php echo $hotel['hotel_address']; ?>
                                </span>
                                        <div class="external-hotel-facilities">
                                            <?php
                                            if (isset($hotel['facilities'])) {
                                                $expHotelsFacilities = explode("|", $hotel['facilities']);
                                                $countCh = 0;
                                                foreach ($expHotelsFacilities as $facilities) {
                                                    if ($countCh + strlen($facilities) <= 30) {
                                                        $countCh = $countCh + strlen($facilities);
                                                        ?>
                                                        <span><?php echo $facilities; ?></span>
                                                        <?php
                                                    }
                                                }
                                            } else {
                                                ?>
                                                <span>MINIBAR</span>
                                                <span>TV</span>
                                                <span>WI-FI</span>
                                                <span>ROOM SERVICE</span>
                                                <span>SATELLITE TV</span>
                                                <?php
                                            }
                                            ?>
                                            <span>...</span>
                                        </div>
                                    </div>

                                    <div class="hotel-result-item-bottom external-hotel-bottom">

                                <span class="hotel-time-stay">
                                    <?php echo functions::Xmlinformation('Startpricefor'); ?>
                                    <?php echo $_POST['nights']; ?>
                                    <?php echo functions::Xmlinformation('Night'); ?>
                                </span>

                                        <span class="hotel-start-price priceSortAdt">


                                    <?php
                                    if ($hotel['type_app'] == 'reservation') {
                                        ?>
                                        <b class="CurrencyCal"
                                           data-amount="<?php echo $hotel['minimum_room_price']; ?>"> <?php echo functions::numberFormat($hotel['minimum_room_price']); ?> </b>
                                        <?php
                                    } else {
                                        ?>
                                        <b class="CurrencyCal" data-amount="...">
                                            <img class="imgLoad"
                                                 src="<?php echo ROOT_ADDRESS_WITHOUT_LANG; ?>/view/client/assets/images/load2.gif"/>
                                        </b>
                                        <?php
                                    }
                                    ?>
                                            <span class="CurrencyText"><?php echo functions::Xmlinformation('Rial'); ?></span>
                                </span>

                                        <a onclick="externalHotelDetail('<?php echo $hotel['type_app']; ?>', '<?php echo $hotel['hotel_index']; ?>', '<?php echo $hotel['hotel_name']; ?>')"
                                           class="bookbtn mt1 site-bg-main-color  site-main-button-color-hover">
                                            <?php echo functions::Xmlinformation('Showreservation'); ?> </a>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 nopad">
                                <div class="hotel-result-item-image site-bg-main-color-hover external-hotel-image">
                                    <a onclick="externalHotelDetail('<?php echo $hotel['type_app']; ?>', '<?php echo $hotel['hotel_index']; ?>', '<?php echo $hotel['hotel_name']; ?>')">
                                        <img src="" alt=" ">
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php

                }

                $return['htmlHotels'] = ob_get_clean();
            }
            functions::insertLog("end ajax preview", '00000-checkExternalHotel', 'yes');

            $result = json_encode($return);

            break;
        case 'getResultExternalHotelPreview':
            ob_start();
            for ($i = 1; $i <= 10; $i++) {
                ?>
                <div class="hotelResultItem" id="boxHotel_">
                    <div id="a1" class="hotel-result-item"
                         data-typeApplication=""
                         data-price=""
                         data-star=""
                         data-freeBreakfast=""
                         data-facilities=""
                         data-hotelName=""
                         data-hotelAddress="">

                        <?php
                        if ((strpos(CLIENT_SERVICES, 'HotelReserveLocal') !== false)
                            && (strpos(CLIENT_SERVICES, 'HotelPortal') !== false && $i == 1)) {
                            ?>
                            <div class="ribbon-special-external-hotel"><span><i><?php echo Functions::Xmlinformation('Specialhotel') ?></i></span></div>
                            <?php
                        } elseif (strpos(CLIENT_SERVICES, 'HotelReserveLocal') !== false
                            && strpos(CLIENT_SERVICES, 'HotelPortal') == false) {
                            ?>
                            <div class="ribbon-special-external-hotel"><span><i><?php echo Functions::Xmlinformation('Specialhotel') ?></i></span></div>
                            <?php
                        }
                        ?>

                        <div class="col-md-8 nopad">
                            <div class="hotel-result-item-content external-hotel-content">
                                <div class="hotel-result-item-text">
                                    <a onclick="externalHotelDetail('', '', '')">
                                        <b class="hotel-result-item-name txtLeft">Dubai Palm Hotel</b>
                                    </a>

                                    <span class="hotel-star external-hotel-star">
                                        <input type="hidden" id="starSortDep" name="starSortDep"
                                               value="3">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                    </span>

                                    <span class="hotel-result-item-content-location
                                        fa fa-map-marker external-hotel-location">Al Muteena St,Al Muteena Area, Opp. Marco Polo Hotel - Dubai - United Arab Emirates</span>
                                    <div class="external-hotel-facilities">
                                        <span>MINIBAR</span>
                                        <span>TV</span>
                                        <span>WI-FI</span>
                                        <span>ROOM SERVICE</span>
                                        <span>SATELLITE TV</span>
                                        <span>...</span>
                                    </div>
                                </div>

                                <div class="hotel-result-item-bottom external-hotel-bottom">

                                    <span class="hotel-time-stay">
                                        <?php echo functions::Xmlinformation('Startpricefor'); ?> 1 <?php echo functions::Xmlinformation('Night'); ?>
                                    </span>

                                    <span class="hotel-start-price priceSortAdt">
                                        <b class="CurrencyCal" data-amount="...">
                                            <img class="imgLoad" src="<?php echo ROOT_ADDRESS_WITHOUT_LANG; ?>/view/client/assets/images/load2.gif"/>
                                        </b>
                                        <span class="CurrencyText"><?php echo functions::Xmlinformation('Rial'); ?></span>
                                    </span>

                                    <a onclick="externalHotelDetail('', '', '')"
                                       class="bookbtn mt1 site-bg-main-color  site-main-button-color-hover">
                                        <?php echo functions::Xmlinformation('Showreservation'); ?> </a>

                                    <div class="text_div_more_hotel_f site-main-text-color iranM txt12">
                                        <?php echo functions::Xmlinformation('Yourpurchasepoints'); ?> :
                                        <?php echo functions::Xmlinformation('Point'); ?>
                                    </div>


                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 nopad">
                            <div class="hotel-result-item-image site-bg-main-color-hover external-hotel-image">
                                <a onclick="externalHotelDetail('', '', '')">
                                    <img src="" alt=" ">
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
                <?php
            }
            $return['htmlHotels'] = ob_get_clean();
            $result = json_encode($return);
            break;
        case 'getResultExternalHotelSearch':
            /** @var resultSearchExternalHotel $objHotel */
	        $objHotel = Load::controller('resultSearchExternalHotel');
            $result   = $objHotel->getHotels($_POST);
            break;
        case 'getNumberOfRoomsExternalHotelRequested':

            $numberOfRooms = functions::numberOfRoomsExternalHotelSearch($_POST['searchRooms']);
            $rooms = functions::numberOfRoomsExternalHotelRequested($numberOfRooms['rooms']);
            $result = json_encode($rooms);

            break;
        default:
            $result = 'not fund ' . $flag;
            break;
    }


    echo $result;

} else {
    echo 'not fund flag';
}

?>