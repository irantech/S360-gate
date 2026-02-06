<?php


$array_special_char = ["\n", "‘", "’", "“", "”", "„" , "(", ")", "<", ">","</","/>","alert","+","from","sleep"] ;

$except_char = ['comment' , 'comment_en','tel_number' , 'distance_to_important_places' , 'distance_to_important_places_en' ];

foreach ($_POST as $key=>$item) {
    if(!in_array($key , $except_char)){

        $item_after_replace[$key] = str_replace($array_special_char, '', $item);

        $_POST[$key] = $item_after_replace[$key];
    }

}


require 'config/bootstrap.php';
require CONFIG_DIR . 'config.php';
require CONFIG_DIR . 'configBase.php';
require LIBRARY_DIR . 'functions.php';
require CONTROLLERS_DIR . 'dateTimeSetting.php';
require LIBRARY_DIR . 'Load.php';
spl_autoload_register(array('Load', 'autoload'));


if (isset($_POST['flag']) && $_POST['flag'] == 'ShowRoomHotel') {
    unset($_POST['flag']);

    $param = $_POST;

    if (SOFTWARE_LANG == 'en' || SOFTWARE_LANG == 'ar' || substr($param['startDate'], "0", "4") > 2000){
        $param['startDate'] = functions::ConvertToJalali($param['startDate']);
        $param['endDate'] = functions::ConvertToJalali($param['endDate']);
    }

    $resultHotelLocal = Load::controller('resultHotelLocal');
	
	/** @var resultHotelLocal $resultHotelLocal */
	$SearchHotelRoom = $resultHotelLocal->getHotelRoomForAjax($param);
    $Room_byHotel    = $resultHotelLocal->getHotelRoomPricesForAjax($param);

    $resultShowHotelRoomPrices = '';
    if ($SearchHotelRoom && $Room_byHotel) {
        ob_start();
        ?>


        <form action="" method="post" id="formHotelReserve" style="width: 100%;">

            <!-- Inputs For box-reserve-hotel-fix  -->


            <!--<div class="box-reserve-hotel-fix">
                <div class="box-reserve-hotel-fix-items">
                    <span><b class="roomFinalTxt">0 <?php /*echo functions::Xmlinformation('Selectedroom'); */?> </b>
                        <?php /*echo functions::Xmlinformation('For'); */?> <?php /*echo $param['nights']; */?> <?php /*echo functions::Xmlinformation('Timenight'); */?></span>
                    <span class="roomFinalPrice site-main-text-color">0 <?php /*echo functions::Xmlinformation('Rial'); */?></span>
                    <span class="roomFinalBtn multi-rooms-price-btn-container">
                        <button id="btnReserve" type="button" disabled="disabled"
                                class="site-secondary-text-color site-bg-main-color site-main-button-color-hover"
                                onclick="ReserveHotel()"><?php /*echo functions::Xmlinformation('Reservation'); */?>
                        </button>
                        <img class="imgLoad" src="<?php /*echo ROOT_ADDRESS_WITHOUT_LANG; */?>/view/client/assets/images/load2.gif" id="img"/>
                    </span>
                </div>
            </div>-->

            <input id="idHotel_reserve" name="idHotel_reserve" type="hidden" value="<?php echo $param['idHotel']; ?>">
            <input id="nights_reserve" name="nights_reserve" type="hidden" value="<?php echo $param['nights']; ?>">
            <input id="startDate_reserve" name="startDate_reserve" type="hidden" value="<?php echo $param['startDate']; ?>">
            <input id="endDate_reserve" name="endDate_reserve" type="hidden" value="<?php echo $param['endDate']; ?>">
            <input id="IdCity_Reserve" name="IdCity_Reserve" type="hidden" value="<?php echo $param['city']; ?>">
            <input id="typeApplication" name="typeApplication" type="hidden" value="api">
            <input id="factorNumber" name="factorNumber" type="hidden" value="">
            <input id="CurrencyCode" name="CurrencyCode" type="hidden" value="<?php echo $param['currencyCode']; ?>">
            <input id="href" name="href" type="hidden" value="passengersDetailHotelLocal">


            <?php
            $CountRoom = 0;
            $AllTypeRoomHotel = "";
            $counter_button_reserve = "1";

            $dateYear = substr($param['startDate'], 0, 4);
            $dateMonth = substr($param['startDate'], 5, 2);
            $dateDay = substr($param['startDate'], 8, 2);
            $sDate = $dateYear . $dateMonth . $dateDay;

            foreach ($SearchHotelRoom as $room) {
                $CountRoom++;
                ?>
                <div class="hotel-detail-room-list">
                    <div class="hotel-rooms-item">
                        <div class="hotel-rooms-row">
                            <div class="hotel-rooms-content-col">

                                <div class="hotel-rooms-content">
                                    <div class="hotel-rooms-name-container">
                                        <?php
                                        if ($Room_byHotel[$room['Code']][$sDate]['Discount'] > 0) {
                                            ?>
                                            <span class="hotel-room-number-label site-bg-main-color site-bg-color-border-bottom">
                                                <?php echo $Room_byHotel[$room['Code']][$sDate]['Discount']; ?> % <?php echo functions::Xmlinformation('Discount'); ?>
                                            </span>
                                            <?php
                                        }
                                        ?>
                                        <span class="hotel-rooms-name"><?php echo $room['Name']; ?></span>
                                    </div>

                                    <?php
                                    $disabledEveryNightCurrency = functions::CurrencyCalculate($Room_byHotel[$room['Code']][$sDate]['PriceBoard'], $param['currencyCode']);
                                    $everyNightCurrency = functions::CurrencyCalculate($Room_byHotel[$room['Code']][$sDate]['Price'], $param['currencyCode']);

                                    $AllTypeRoomHotel = $AllTypeRoomHotel . $room['Code'] . '/';
                                    ?>
                                    <div class="divided-list">
                                        <div class="divided-list-item">
                                            <span><i class="fa fa-bed"></i><?php echo functions::Xmlinformation('Onlyroom'); ?></span>
                                        </div>
                                        <div class="divided-list-item">
                                            <span>
                                                <i class="fa fa-money"></i><?php echo functions::Xmlinformation('Priceforanynight'); ?>:
                                                <?php
                                                if ($disabledEveryNightCurrency['AmountCurrency'] > 0) {
                                                    ?>
                                                    <strike class="currency priceOff"><?php echo functions::numberFormat($disabledEveryNightCurrency['AmountCurrency']); ?></strike>
                                                    <?php
                                                }
                                                ?>
                                                <i class="site-main-text-color"><?php echo functions::numberFormat($everyNightCurrency['AmountCurrency']); ?></i>
                                                <?php echo $everyNightCurrency['TypeCurrency']; ?>
                                            </span>
                                        </div>
                                    </div>

                                    <input type="hidden" value="" id="FinalRoomCount<?php echo $room['Code']; ?>">
                                    <input type="hidden" value="" id="FinalPriceRoom<?php echo $room['Code']; ?>">
                                    <input type="hidden" value="" id="tempInput<?php echo $room['Code']; ?>">

                                    <div class="divided-list">
                                        <div class="divided-list-item">
                                            <span><i class="fa fa-male"></i><?php echo $room['MaxCapacity']; ?> <?php echo functions::Xmlinformation('People'); ?></span>
                                        </div>
                                        <div class="divided-list-item">
                                            <div class="DetailRoom showCancelRule"
                                                 id="btnCancelRule-<?php echo $room['Code']; ?>" data-roomindex="<?php echo $room['Code']; ?>">
                                                <i class="fa fa-angle-down"></i>
                                                <span><?php echo functions::Xmlinformation('Detailprice'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="hotel-rooms-price-col">

                                <div class="Hotel-roomsHead" data-title="<?php echo functions::Xmlinformation('Countroom'); ?>">
                                    <div class="selsect-room-reserve"><?php echo functions::Xmlinformation('Countroom'); ?></div>
                                    <div class="select nuumbrtRoom extraBed">
                                        <input id="remainingCapacity<?php echo $room['Code']; ?>" name="remainingCapacity<?php echo $room['Code']; ?>" type="hidden"
                                               value="<?php echo $Room_byHotel[$room['Code']][$sDate]['RemainingCapacity']; ?>">
                                        <select name="RoomCount<?php echo $room['Code']; ?>" id="RoomCount<?php echo $room['Code']; ?>"
                                                class="select2-num" onchange="CalculateRoomPrices('<?php echo $room['Code']; ?>')">
                                            <option><?php echo functions::Xmlinformation('Room'); ?></option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                        </select>
                                    </div>
                                </div>

                                <?php
                                if ($Room_byHotel[$room['Code']][$sDate]['RemainingCapacity'] > 0) {
                                    ?>
                                    <span class="online-badge"><span class="online-txt"><i></i><?php echo functions::Xmlinformation('Onlinereservation'); ?></span></span>
                                    <?php
                                }
                                ?>

                            </div>
                        </div>
                        <div class="hotel-rooms-rule-row">
                            <div class="col-xs-12 col-md-12 box-cancel-rule">
                                <img class="imgLoad" src="assets/images/load.gif"
                                     id="loaderCancel-<?php echo $room['Code']; ?>">
                                <div class="box-cancel-rule-col displayN" id="boxCancelRule-<?php echo $room['Code']; ?>">

                                    <div class="filtertip-searchbox">
                                        <div class="filter-content">

                                            <div class="RoomDescription">
                                                <div class="DetailPriceView">

                                                    <?php
                                                    $Room_price = 0;
                                                    foreach ($Room_byHotel[$room['Code']] as $roomPriceDate) {


                                                        $dateYear = substr($roomPriceDate['Date'], 0, 4);
                                                        $dateMonth = substr($roomPriceDate['Date'], 4, 2);
                                                        $dateDay = substr($roomPriceDate['Date'], 6, 2);
                                                        $date = $dateYear . '-' . $dateMonth . '-' . $dateDay;

                                                        $Room_price = $Room_price + $roomPriceDate['Price'];

                                                        $roomCurrency = functions::CurrencyCalculate($roomPriceDate['Price'], $param['currencyCode']);
                                                        if ($roomPriceDate['RemainingCapacity'] > 0) {
                                                            ?>
                                                            <div class="details">
                                                                <div class="AvailableSeprate"><?php echo $date; ?></div>
                                                                <div class="seprate">
                                                                    <b><?php echo functions::numberFormat($roomCurrency['AmountCurrency']); ?></b> <?php echo $roomCurrency['TypeCurrency']; ?>
                                                                    <i class="fa fa-check checkIcon"></i>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <div class="details">
                                                                <div class="NotAvailableSeprate"><?php echo $date; ?></div>
                                                                <div class="seprate">
                                                                    <b><?php echo functions::numberFormat($roomCurrency['AmountCurrency']); ?></b> <?php echo $roomCurrency['TypeCurrency']; ?>
                                                                    <i class="fa fa-close closeIcon"></i>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }

                                                    }

                                                    $roomTotalCurrency = functions::CurrencyCalculate($Room_price, $param['currencyCode']);
                                                    ?>

                                                    <input type="hidden" value="<?php echo $room['Code']; ?>" id="idRoom" class="idRoom">
                                                    <input type="hidden" value="<?php echo $Room_price; ?>" data-amount="<?php echo $roomTotalCurrency['AmountCurrency']; ?>"
                                                           data-unit="<?php echo $roomTotalCurrency['TypeCurrency']; ?>" id="priceRoom<?php echo $room['Code']; ?>" class="priceRoom<?php echo $room['Code']; ?>">
                                                    <input type="hidden" value="<?php echo $param['nights']; ?>" id="stayingTime" class="stayingTime">


                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>

            <input type="hidden" name="CountRoom" id="CountRoom" value="<?php echo $CountRoom; ?>">
            <input type="hidden" name="TypeRoomHotel" id="TypeRoomHotel" value="<?php echo $AllTypeRoomHotel; ?>">
            <input type="hidden" name="TotalNumberRoom" id="TotalNumberRoom" value="">
            <input type="hidden" id="TotalNumberRoom_Reserve" name="TotalNumberRoom_Reserve" value="">


        </form>
        <?php
        $resultShowHotelRoomPrices = ob_get_clean();
        echo $resultShowHotelRoomPrices;



        $resultShowHotelRoomPrices .= '
        <div class="container">
            <div class="row">
                <div class="rp-tableHotelRoom">
        
                <form action="" method="post" id="formHotelReserve" style="width: 100%;">
                
                <input id="idHotel_reserve" name="idHotel_reserve" type="hidden" value="' . $param['idHotel'] . '">
                <input id="nights_reserve" name="nights_reserve" type="hidden" value="' . $param['nights'] . '">
                <input id="startDate_reserve" name="startDate_reserve" type="hidden" value="' . $param['startDate'] . '">
                <input id="endDate_reserve" name="endDate_reserve" type="hidden" value="' . $param['endDate'] . '">
                <input id="IdCity_Reserve" name="IdCity_Reserve" type="hidden" value="' . $param['city'] . '">
                <input id="typeApplication" name="typeApplication" type="hidden" value="api">
                <input id="factorNumber" name="factorNumber" type="hidden" value="">
                <input id="CurrencyCode" name="CurrencyCode" type="hidden" value="' . $param['currencyCode'] . '">
                <input id="href" name="href" type="hidden" value="passengersDetailHotelLocal">
                
                <div class="finalPriceTable" >
                      <table class="API-hotel-table">
                        <thead class="API-hotel-header">
                          <tr class="API-Hotel-roomsHead">
                             <th class="API-Hotel-roomsHead-c1">'. functions::Xmlinformation('Typeroom').'</th>
                             <th class="API-Hotel-roomsHead-c4">'. functions::Xmlinformation('CapacityRoom').'</th>
                             <th class="API-Hotel-roomsHead-c5">'. functions::Xmlinformation('Countroom').'</th>
                             <th class="API-Hotel-roomsHead-c7">'. functions::Xmlinformation('Priceforanynight').'</th>
                          </tr>
                        </thead>
                        <tbody class="API-hotel-body">';

        $CountRoom = 0;
        $AllTypeRoomHotel = "";
        $counter_button_reserve = "1";

        $dateYear = substr($param['startDate'], 0, 4);
        $dateMonth = substr($param['startDate'], 5, 2);
        $dateDay = substr($param['startDate'], 8, 2);
        $sDate = $dateYear . $dateMonth . $dateDay;

        foreach ($SearchHotelRoom as $room) {
            $CountRoom++;

            if ($Room_byHotel[$room['Code']][$sDate]['Price'] != 0) {
                $resultShowHotelRoomPrices .= '<tr>
                                <td class="Hotel-roomsHead" data-title="'. functions::Xmlinformation('Typeroom').'" rowspan="2">
                                   <h5 class="roomsTitle">' . $room['Name'] . '</h5>';

                if ($Room_byHotel[$room['Code']][$sDate]['RemainingCapacity'] > 0) {
                    $resultShowHotelRoomPrices .= '
                    <span class="online-badge">
                        
                        <span class="online-txt"><i></i> '. functions::Xmlinformation('Onlinereservation').'</span>
                    </span>
                    ';
                }

                if ($Room_byHotel[$room['Code']][$sDate]['Discount'] > 0) {
                    $resultShowHotelRoomPrices .= '
                                        <div class="divDiscountRoom">
                                          <span><b id="discountRoom">' . $Room_byHotel[$room['Code']][$sDate]['Discount'] . ' % '. functions::Xmlinformation('Discount').'</b></span>
                                        </div>';
                }

                $resultShowHotelRoomPrices .= '
                                </td >
    
    
                                <td class="API-Hotel-roomsHead" data-title="'. functions::Xmlinformation('CapacityRoom').'">
                                  <div class="roomCapacity" >
                                    <i class="fa fa-user txt15"></i> <i class="inIcon">x</i><i class="txtIcon ng-binding">' . $room['MaxCapacity'] . '</i>
                                  </div>
                                </td>
    
    
    
                                <td class="API-Hotel-roomsHead" data-title="'. functions::Xmlinformation('Countroom').'">
                                  <div class="select nuumbrtRoom extraBed">';

                $resultShowHotelRoomPrices .= '
                    <input id="remainingCapacity' . $room['Code'] . '" name="remainingCapacity' . $room['Code'] . '" type="hidden" 
                            value="' . $Room_byHotel[$room['Code']][$sDate]['RemainingCapacity'] . '">
                    
                                      <select name="RoomCount' . $room['Code'] . '" id="RoomCount' . $room['Code'] . '" class="select2-num" onchange="CalculateRoomPrices(' . $room['Code'] . ')">
                                        <option > '. functions::Xmlinformation('Room').'</option >';
                for ($s = 1; $s <= 9; $s++) {
                    $resultShowHotelRoomPrices .= '<option value="' . $s . '">' . $s . '</option>';
                }
                $resultShowHotelRoomPrices .= '</select>';

                $disabledEveryNightCurrency = functions::CurrencyCalculate($Room_byHotel[$room['Code']][$sDate]['PriceBoard'], $param['currencyCode']);
                $everyNightCurrency = functions::CurrencyCalculate($Room_byHotel[$room['Code']][$sDate]['Price'], $param['currencyCode']);

                $resultShowHotelRoomPrices .= '</div>
    
                                </td>
                                <td class="Hotel-roomsHead" data-title="'. functions::Xmlinformation('Priceforanynight').'">
    
                                  <div>
                                      <strike class="strikePrice"><span class="currency priceOff">' . functions::numberFormat($disabledEveryNightCurrency['AmountCurrency']) . '</span> ' . $disabledEveryNightCurrency['TypeCurrency'] . '</strike>
                                  </div>
    
                                  <span class="pricePerNight"><span class="currency">' . functions::numberFormat($everyNightCurrency['AmountCurrency']) . '</span> ' . $everyNightCurrency['TypeCurrency'] . '</span>
                                  <input type="hidden" name="test-price" id="test-price" value="' . $Room_byHotel[$room['Code']][$sDate]['PriceOnline'] . '">
                                  <div  class="DetailPrice">
                    '. functions::Xmlinformation('Detailprice').'<i class="fa  fa-angle-down"></i>
                                  </div>';

                $AllTypeRoomHotel = $AllTypeRoomHotel . $room['Code'] . '/';

                $resultShowHotelRoomPrices .= '
                                      <input type="hidden" value="" id="FinalRoomCount' . $room['Code'] . '">
                                      <input type="hidden" value="" id="FinalPriceRoom' . $room['Code'] . '">
                                      <input type="hidden" value="" id="tempInput' . $room['Code'] . '">
    
    
                                </td>';

                $resultShowHotelRoomPrices .= '</tr>';
            }

            $resultShowHotelRoomPrices .= '

                          <tr class="RoomDescription trShowHideHotelDetail">
                            <td colspan="3">
                              <div class="DetailPriceView displayiN">';


            $Room_price = 0;
            foreach ($Room_byHotel[$room['Code']] as $roomPriceDate) {


                $dateYear = substr($roomPriceDate['Date'], 0, 4);
                $dateMonth = substr($roomPriceDate['Date'], 4, 2);
                $dateDay = substr($roomPriceDate['Date'], 6, 2);
                $date = $dateYear . '-' . $dateMonth . '-' . $dateDay;

                $Room_price = $Room_price + $roomPriceDate['Price'];

                $roomCurrency = functions::CurrencyCalculate($roomPriceDate['Price'], $param['currencyCode']);
                if ($roomPriceDate['RemainingCapacity'] > 0) {

                    $resultShowHotelRoomPrices .= '
                                          <div class="details">
                                          <div class="AvailableSeprate">' . $date . '</div>
                                          <div class="seprate">
                                              <span>' . functions::numberFormat($roomCurrency['AmountCurrency']) . '</span> ' . $roomCurrency['TypeCurrency'] . '
                                          </div>
                                          <div>
                                              <i class="fa fa-check checkIcon"></i>
                                          </div>
                                        </div>';

                } else {
                    $resultShowHotelRoomPrices .= '
                                        <div class="details">
                                          <div class="NotAvailableSeprate">' . $date . '</div>
                                          <div class="seprate">
                                              <span>' . functions::numberFormat($roomCurrency['AmountCurrency']) . '</span> ' . $roomCurrency['TypeCurrency'] . '
                                          </div>
                                          <div>
                                              <i class="fa fa-close closeIcon"></i>
                                          </div>
                                        </div>';

                }

            }

            $roomTotalCurrency = functions::CurrencyCalculate($Room_price, $param['currencyCode']);
            $resultShowHotelRoomPrices .= '
                                  <input type="hidden" value="' . $room['Code'] . '" id="idRoom" class="idRoom">
                                  <input type="hidden" value="' . $Room_price . '" data-amount="' . $roomTotalCurrency['AmountCurrency'] . '" 
                                  data-unit="' . $roomTotalCurrency['TypeCurrency'] . '" id="priceRoom' . $room['Code'] . '" class="priceRoom' . $room['Code'] . '">
                                  <input type="hidden" value="' . $param['nights'] . '" id="stayingTime" class="stayingTime">

                              </div>
                            </td>
                          </tr>';
        }

        $resultShowHotelRoomPrices .= '
                        </tbody>


                      </table>
                     </div><div class="finalPriceCol">
                          <div class="finalPriceColHeader">
                              '. functions::Xmlinformation('Reserve').'
                          </div>
                          <div class="finalPrice">
                              <div class="roomFinalTxt">0 '. functions::Xmlinformation('Selectedroom').'
                              </div>
                              <div class="">'.functions::StrReplaceInXml(['@@night@@'=>$param['nights']],'ForXNight').'</div>
                              <div class="roomFinalPrice">0 '. functions::Xmlinformation('Rial').'</div>

                                <div class="input roomBook">
                                    <button type="button" class="buttonReserveHotel site-main-button-color site-secondary-text-color" onclick="ReserveHotel()">'. functions::Xmlinformation('Reserve').'</button>
                                    <img class="imgLoad" src="'.ROOT_ADDRESS_WITHOUT_LANG.'/view/client/assets/images/load2.gif" id="img"/>
                                </div>

                            </div>
                     </div>
                    <input type="hidden" name="CountRoom" id="CountRoom" value="' . $CountRoom . '">
                    <input type="hidden" name="TypeRoomHotel" id="TypeRoomHotel" value="' . $AllTypeRoomHotel . '">
                    <input type="hidden" name="TotalNumberRoom" id="TotalNumberRoom" value="">
                    <input type="hidden" id="TotalNumberRoom_Reserve" name="TotalNumberRoom_Reserve" value="">';

        $resultShowHotelRoomPrices .= '
                  </form>
    
                </div>
            </div>
        </div>
            ';

        //echo $resultShowHotelRoomPrices;

    } else {

        ob_start();
        ?>
        <div class="container">
            <div class="row">
                <div class="hotel-detail-room-list">
                    <div class="hotel-rooms-item">
                        <p class="txtMessageinfoHotelRoom"><?php echo functions::Xmlinformation('NoAvailableReserve'); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $resultShowHotelRoomPrices = ob_get_clean();
        echo $resultShowHotelRoomPrices;

    }


}

if (isset($_POST['flag']) && $_POST['flag'] == "CheckedLogin") {
    unset($_POST['flag']);
    Load::autoload('apiHotelLocal');
    $Local = new apiHotelLocal;
    $result = $Local->checkLogin();

    if (isset($_POST['dataTypeResult']) && $_POST['dataTypeResult'] == 'json'){
        unset($_POST['dataTypeResult']);

        $dataJson['message'] = $result;
        echo json_encode($dataJson);
    } else {
        echo $result;
    }
}


if (isset($_POST['flag']) && $_POST['flag'] == "nextStepReserveHotel") {
    unset($_POST['flag']);
    Load::autoload('apiHotelLocal');
    $Local = new apiHotelLocal;
    $result = $Local->NextStepReserveHotel($_POST);

    if (isset($_POST['dataTypeResult']) && $_POST['dataTypeResult'] == 'json'){
        unset($_POST['dataTypeResult']);

        $arrayResult = explode(":", $result);
        $dataJson['message'] = $arrayResult[0];
        $dataJson['factorNumber'] = trim($arrayResult[1]);
        echo json_encode($dataJson);

    } else {
        echo $result;
    }
}

if (isset($_POST['flag']) && $_POST['flag'] == "nextStepReserveHotel") {

    unset($_POST['flag']);
    Load::autoload('apiHotelLocal');
    $Local = new apiHotelLocal;
    $result = $Local->NextStepReserveHotel($_POST);

    if (isset($_POST['dataTypeResult']) && $_POST['dataTypeResult'] == 'json'){
        unset($_POST['dataTypeResult']);

        $arrayResult = explode(":", $result);
        $dataJson['message'] = $arrayResult[0];
        $dataJson['factorNumber'] = trim($arrayResult[1]);
        echo json_encode($dataJson);

    } else {
        echo $result;
    }
}

if (isset($_POST['flag']) && $_POST['flag'] == "register_memeberHotel") {

    $Local = Load::library('apiHotelLocal');
   echo  $Local->registerPassengerOnline();
}

if (isset($_POST['flag']) && $_POST['flag'] == 'HotelReserve') {

    unset($_POST['flag']);

    Load::autoload('apiHotelLocal');
    $controller = new apiHotelLocal();


    echo $controller->Hotel_Reserve_Room($_POST['factorNumber'], $_POST['typeApplication']);

}

/////////////////////////////////////////////////////////////////
//////////////////// panel admin reservation ////////////////////
if (isset($_POST['flag']) && $_POST['flag'] == 'logicalDeletion') {

    $controller = Load::controller('reservationBasicInformation');
    unset($_POST['flag']);
    echo $controller->logicalDeletion($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'insert_change_price_hotel') {
    $PriceHotelChange = Load::controller('PriceHotelChange');
    unset($_POST['flag']);
    echo $PriceHotelChange->InsertChangePriceHotel($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'delete_change_price_hotel') {

    $PriceChange = Load::controller('PriceHotelChange');
    echo $PriceChange->DeleteChangePriceHotel($_POST['id']);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'insert_type_of_vehicle') {

    $TypeOfVehicle = Load::controller('reservationBasicInformation');
    unset($_POST['flag']);
    echo $TypeOfVehicle->InsertTypeOfVehicle($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'EditTypeOfVehicle') {

    $edit = Load::controller('reservationBasicInformation');
    unset($_POST['flag']);
    echo $edit->updateTypeOfVehicle($_POST);

}
if (isset($_POST['flag']) && $_POST['flag'] == 'insert_vehicle_model') {

    $controller = Load::controller('reservationBasicInformation');
    unset($_POST['flag']);
    echo $controller->InsertVehicleModel($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'EditVehicleModel') {

    $edit = Load::controller('reservationBasicInformation');
    unset($_POST['flag']);
    echo $edit->updateVehicleModel($_POST);

}
if (isset($_POST['flag']) && $_POST['flag'] == 'insert_vehicle_grade') {

    $controller = Load::controller('reservationBasicInformation');
    unset($_POST['flag']);
    echo $controller->InsertVehicleGrade($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'EditVehicleGrade') {

    $edit = Load::controller('reservationBasicInformation');
    unset($_POST['flag']);
    echo $edit->updateVehicleGrade($_POST);

}
if (isset($_POST['flag']) && $_POST['flag'] == 'insert_country') {

    $controller = Load::controller('reservationBasicInformation');
    unset($_POST['flag']);
    echo $controller->InsertCountry($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'EditCountry') {

    $controller = Load::controller('reservationBasicInformation');
    unset($_POST['flag']);
    echo $controller->updateCountry($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'insert_city') {

    $controller = Load::controller('reservationBasicInformation');
    unset($_POST['flag']);
    echo $controller->InsertCity($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'EditCity') {

    $controller = Load::controller('reservationBasicInformation');
    unset($_POST['flag']);
    echo $controller->updateCity($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'insert_region') {

    $controller = Load::controller('reservationBasicInformation');
    unset($_POST['flag']);
    echo $controller->InsertRegion($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'EditRegion') {

    $controller = Load::controller('reservationBasicInformation');
    unset($_POST['flag']);
    echo $controller->updateRegion($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'insertTransportCompanies') {

    unset($_POST['flag']);
    $controller = Load::controller('reservationBasicInformation');
    echo $controller->insertTransportCompanies($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'listTransportCompanies') {

    unset($_POST['flag']);
    $controller = Load::controller('reservationPublicFunctions');
    echo $controller->listTransportCompanies($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'listTypeOfPlane') {

    unset($_POST['flag']);
    $controller = Load::controller('reservationPublicFunctions');
    echo $controller->listTypeOfPlane($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'EditTransportCompanies') {

    unset($_POST['flag']);
    $controller = Load::controller('reservationBasicInformation');
    echo $controller->updateTransportCompanies($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'FillComboContinent') {

    unset($_POST['flag']);
    $controller = Load::controller('reservationPublicFunctions');
    echo $controller->ListCountryForAjax($_POST['continent']);

}
if (isset($_POST['flag']) && $_POST['flag'] == 'FillComboCountry') {

    unset($_POST['flag']);
    $controller = Load::controller('reservationPublicFunctions');
    echo $controller->ListCity($_POST['Country']);

}
if (isset($_POST['flag']) && $_POST['flag'] == 'FillComboCity') {

    unset($_POST['flag']);
    $controller = Load::controller('reservationPublicFunctions');
    echo $controller->ListRegion($_POST['City']);

}
if (isset($_POST['flag']) && $_POST['flag'] == 'FillComboRoute') {

    $controller = Load::controller('reservationPublicFunctions');
    unset($_POST['flag']);
    echo $controller->ListDestinationAirport($_POST['origin_airport']);

}
if (isset($_POST['flag']) && $_POST['flag'] == 'insert_flyNumber') {
   $controller = Load::controller('reservationTicket');
   unset($_POST['flag']);
   echo $controller->InsertFlyNumber($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'EditFlyNumber') {

    $controller = Load::controller('reservationTicket');
    unset($_POST['flag']);
    echo $controller->updateFlyNumber($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'FlyCodeTicket') {

    $Result = Load::controller('reservationTicket');
    unset($_POST['flag']);
    echo $Result->flyCodeTicket($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'InformationFlyNumber') {

    $Result = Load::controller('reservationTicket');
    unset($_POST['flag']);
    echo $Result->informationFlyNumber($_POST['fly_code']);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'insert_ticket') {
    $Result = Load::controller('reservationTicket');
    unset($_POST['flag']);
    echo $Result->InsertTicket($_POST, 'insert');
}
if (isset($_POST['flag']) && $_POST['flag'] == 'editTickets') {
    $Result = Load::controller('reservationTicket');
    unset($_POST['flag']);
    echo $Result->InsertTicket($_POST, 'update');
}
if (isset($_POST['flag']) && $_POST['flag'] == 'logicalDeletionAllTicket') {

    $Result = Load::controller('reservationTicket');
    unset($_POST['flag']);
    echo $Result->logicalDeletionAllTicket($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'logicalDeletionTicket') {

    $Result = Load::controller('reservationTicket');
    unset($_POST['flag']);
    echo $Result->logicalDeletionTicket($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'editOneTicket') {

    $Result = Load::controller('reservationTicket');
    unset($_POST['flag']);
    echo $Result->editOneTicket($_POST);
}

if (isset($_POST['flag']) && $_POST['flag'] == 'insert_room') {

    $controller = Load::controller('reservationBasicInformation');
    unset($_POST['flag']);
    echo $controller->InsertRoomType($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'EditRoom') {

    $edit = Load::controller('reservationBasicInformation');
    unset($_POST['flag']);
    echo $edit->updateRoomType($_POST);

}
if (isset($_POST['flag']) && $_POST['flag'] == 'insert_hotel') {

    $edit = Load::controller('reservationBasicInformation');
    unset($_POST['flag']);
    echo $edit->InsertHotel($_POST);

}

if (isset($_POST['flag']) && $_POST['flag'] == 'EditHotel') {

    $edit = Load::controller('reservationBasicInformation');
    unset($_POST['flag']);
    echo $edit->EditHotel($_POST);

}
if (isset($_POST['flag']) && $_POST['flag'] == 'insert_Gallery') {

    $edit = Load::controller('reservationBasicInformation');
    unset($_POST['flag']);
    echo $edit->InsertGallery($_POST);

}
if (isset($_POST['flag']) && $_POST['flag'] == 'EditGallery') {

    $edit = Load::controller('reservationBasicInformation');
    unset($_POST['flag']);
    echo $edit->updateGallery($_POST);

}
if (isset($_POST['flag']) && $_POST['flag'] == 'insert_hotelRoom') {
	/** @var reservationBasicInformation $controller */
    $controller = Load::controller('reservationBasicInformation');
    unset($_POST['flag']);
    echo $controller->InsertHotelRoom($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'EditHotelRoom') {

    $controller = Load::controller('reservationBasicInformation');
    unset($_POST['flag']);
    echo $controller->updateHotelRoom($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'insert_facilities') {

    $controller = Load::controller('reservationBasicInformation');
    unset($_POST['flag']);
    echo $controller->InsertFacilities($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'insert_room_facilities') {

    $controller = Load::controller('reservationBasicInformation');
    unset($_POST['flag']);
    echo $controller->InsertRoomFacilities($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'insert_hotel_facilities') {

    $controller = Load::controller('reservationBasicInformation');
    unset($_POST['flag']);
    echo $controller->InsertHotelFacilities($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'EditFacilities') {

    $controller = Load::controller('reservationBasicInformation');
    unset($_POST['flag']);
    echo $controller->EditFacilities($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'ShowAllHotel') {

    $Result = Load::controller('reservationHotel');
    unset($_POST['flag']);
    echo $Result->showAllHotel($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'ShowAllHotelRoom') {

    $Result = Load::controller('reservationHotel');
    unset($_POST['flag']);
    echo $Result->showAllHotelRoom($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'insert_room_price') {

    $Result = Load::controller('reservationHotel');
    unset($_POST['flag']);
    echo $Result->InsertRoomPrice($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'insert_oneDayTour') {

    $Result = Load::controller('reservationHotel');
    unset($_POST['flag']);
    echo $Result->InsertOneDayTour($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'EditOneDayTour') {

    $Result = Load::controller('reservationHotel');
    unset($_POST['flag']);
    echo $Result->UpdateOneDayTour($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'deleteRoomPricesForUser') {

    $Result = Load::controller('reservationHotel');
    unset($_POST['flag']);
    echo $Result->deleteRoomPricesForUser($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'deleteRoomPrice') {

    $Result = Load::controller('reservationHotel');
    unset($_POST['flag']);
    echo $Result->deleteRoomPrice($_POST['idHotel'], $_POST['id'], $_POST['type']);
}

if (isset($_POST['flag']) && $_POST['flag'] == 'editRoomPricesForUser') {

    $Result = Load::controller('reservationHotel');
    unset($_POST['flag']);
    echo $Result->updateRoomPricesForUser($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'insertHotelRoomPrice') {

    $Result = Load::controller('reservationHotel');
    unset($_POST['flag']);
    echo $Result->InsertHotelRoomPrice($_POST, 'allRoom');
}
if (isset($_POST['flag']) && $_POST['flag'] == 'insertHotelRoomPriceUser') {

    $Result = Load::controller('reservationHotel');
    unset($_POST['flag']);
    echo $Result->InsertHotelRoomPrice($_POST, 'room');
}
if (isset($_POST['flag']) && $_POST['flag'] == 'cancelHotelReservation') {

    $Result = Load::controller('reservationHotel');
    unset($_POST['flag']);
    echo $Result->cancelHotelReservation($_POST['factor_number'], $_POST['type_application']);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'confirmationHotelReservation') {
	
    /** @var reservationHotel $Result */
	$Result = Load::controller('reservationHotel');
    unset($_POST['flag']);
    echo $Result->confirmationHotelReservation($_POST['factor_number'], $_POST['type_application']);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'newConfirmationHotelReserve') {

    $Result = Load::controller('detailHotel');
    unset($_POST['flag']);
    echo $Result->updateOfflineReserve($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'allowEditingHotel') {

    $Result = Load::controller('reservationHotel');
    unset($_POST['flag']);
    echo $Result->allowEditingHotel($_POST['factor_number'], $_POST['member_id']);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'ConfirmHotel') {

    $Result = Load::controller('reservationHotel');
    unset($_POST['flag']);
    echo $Result->ConfirmHotel($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'checkForConfirmHotel') {
  //var_dump('checkForConfirmHotel-checkForConfirmHotel-checkForConfirmHotel');
    functions::insertLog('come confirm hotel','Hotels/smsHotel');

    /** @var detailHotel $Result */
	$Result = Load::controller('detailHotel');
    unset($_POST['flag']);

    $resultCheck = $Result->GetDataFromReport($_POST);
    if (isset($_POST['dataTypeResult']) && $_POST['dataTypeResult'] == 'json'){
        unset($_POST['dataTypeResult']);
        echo $resultCheck;
    } else {
        $resultCheck = json_decode($resultCheck,true);
      if($resultCheck['book'] == 'OnRequest'){
        if($resultCheck['admin_checked'] == 0){
          echo 'OnRequest';
          return;
        }else{
          echo 'AdminChecking';
          return;
        }
      }elseif($resultCheck['book'] == 'Cancelled'){
        echo 'Cancelled';
        return;
      }elseif($resultCheck['book'] == 'PreReserve'){
        echo 'PreReserve';
      }
        echo json_encode($resultCheck);
    }

}
if (isset($_POST['flag']) && $_POST['flag'] == 'cancelReserveHotel') {

    $Result = Load::controller('reservationHotel');
    unset($_POST['flag']);
    $resultCheck = $Result->cancelReserveHotel($_POST['factorNumber']);

    if (isset($_POST['dataTypeResult']) && $_POST['dataTypeResult'] == 'json'){
        unset($_POST['dataTypeResult']);

        $dataJson['message'] = $resultCheck;
        echo json_encode($dataJson);
    } else {
        echo $resultCheck;
    }

}
if (isset($_POST['flag']) && $_POST['flag'] == 'editAllHotelRooms') {

    $Result = Load::controller('reservationHotel');
    unset($_POST['flag']);

    echo $Result->updateAllHotelRooms($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'checkForReserve') {

    $objHotel = Load::controller('resultHotelLocal');
    unset($_POST['flag']);
    $result = $objHotel->checkForReserve($_POST);
    if (isset($_POST['dataTypeResult']) && $_POST['dataTypeResult'] == 'json'){
        unset($_POST['dataTypeResult']);

        $dataJson['message'] = $result;
        echo json_encode($dataJson);
    } else {
        echo $result;
    }
}
if (isset($_POST['flag']) && $_POST['flag'] == 'showTicketInformation') {

    $objHotel = Load::controller('resultReservationTicket');
    unset($_POST['flag']);
    echo $objHotel->infoTicketForPopup($_POST);
}

if (isset($_POST['flag']) && $_POST['flag'] == 'SendHotelEmailForOther') {
    $members = Load::controller('members');
    unset($_POST['flag']);
    echo $members->SendHotelEmailForOther($_POST['email'], $_POST['factor_number'], $_POST['typeApplication']);
}


if (isset($_POST['flag']) && $_POST['flag'] == 'insertCurrencyRate') {

    $result = Load::controller('externalHotel');
    unset($_POST['flag']);
    echo $result->insertCurrencyRate($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'orderHotelActive') {

    $result = Load::controller('reservationHotel');
    unset($_POST['flag']);
    echo $result->orderHotelActive($_POST['id']);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'insertOrderHotel') {

    $result = Load::controller('reservationHotel');
    unset($_POST['flag']);
    echo $result->insertOrderHotel($_POST['title']);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'sendEmailForHotelBroker') {

    $result = Load::controller('reservationHotel');
    unset($_POST['flag']);
    echo $result->sendEmailForHotelBroker($_POST['factor_number'], $_POST['hotel_id']);
}
//////////////////// end panel admin reservation ////////////////////
////////////////////////////////////////////////////////////////////


//////////////////////////// External Hotel /////////////////////////
////////////////////////////////////////////////////////////////////
if (isset($_POST['flag']) && $_POST['flag'] == 'searchCityForExternalHotel') {
    unset($_POST['flag']);

    $result = Load::controller('resultExternalHotel');
    echo $result->searchCity($_POST['inputSearchValue'] , $_POST['json']);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'searchCityCountryForExternalHotel') {
    unset($_POST['flag']);

    $result = Load::controller('resultExternalHotel');
    echo $result->searchCountryCity($_POST['inputSearchValue']);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'searchCityForInternalHotel') {
    unset($_POST['flag']);

    $result = Load::controller('searchHotel');
    echo $result->searchCity($_POST['inputSearchValue'] , $_POST['json']);
}

if (isset($_POST['flag']) && $_POST['flag'] == 'searchCityHotelForInternalHotel') {
    unset($_POST['flag']);

    $result = Load::controller('searchHotel');

    echo $result->searchCityInternalHotel($_POST );
}

if (isset($_POST['flag']) && $_POST['flag'] == 'popularCityForInternalHotel') {
    unset($_POST['flag']);

    $result = Load::controller('searchHotel');
    echo $result->popularInternalHotelCities();
}


if (isset($_POST['flag']) && $_POST['flag'] == 'externalHotelPreReserve') {
    unset($_POST['flag']);

    $objHotel = Load::controller('resultExternalHotel');
    $result = $objHotel->setHotelPreReserve($_POST['factorNumber']);

    echo  $result;
}
if (isset($_POST['flag']) && $_POST['flag'] == 'updateExternalHotelCity') {
    unset($_POST['flag']);

    $objHotel = Load::controller('externalHotel');
    $result = $objHotel->updateExternalHotelCity($_POST);

    echo  $result;
}
if (isset($_POST['flag']) && $_POST['flag'] == 'updateExternalHotelRoom') {
    unset($_POST['flag']);

    $objHotel = Load::controller('externalHotel');
    $result = $objHotel->updateExternalHotelRoom($_POST);

    echo  $result;
}
if (isset($_POST['flag']) && $_POST['flag'] == 'updateExternalHotelFacilities') {
    unset($_POST['flag']);

    $objHotel = Load::controller('externalHotel');
    $result = $objHotel->updateExternalHotelFacilities($_POST);

    echo  $result;
}
/*if (isset($_POST['flag']) && $_POST['flag'] == 'requestCancelExternalHotel') {
    unset($_POST['flag']);

    $objHotel = Load::controller('resultExternalHotel');
    $result = $objHotel->productCancel($_POST);

    echo  $result;
}*/
////////////////////// end Foreign Hotel ///////////////////////////
////////////////////////////////////////////////////////////////////

//////////////////////////// Reservation Ticket /////////////////////////
////////////////////////////////////////////////////////////////////
if (isset($_POST['flag']) && $_POST['flag'] == 'selectReservationFlightDept') {

    unset($_POST['flag']);

    Load::autoload('apiLocal');
    $controller = new apiLocal();
    echo $controller->selectReservationFlightDept($_POST);
}
////////////////////// end Reservation Ticket ///////////////////////////
////////////////////////////////////////////////////////////////////


//////////////////////////// Reservation bus /////////////////////////
////////////////////////////////////////////////////////////////////
if (isset($_POST['flag']) && $_POST['flag'] == 'getResultReservationBus') {

    unset($_POST['flag']);

    $resultLocal = Load::controller('resultBus');
    echo $resultLocal->getBusList($_POST);
}
////////////////////// end Reservation bus ///////////////////////////
////////////////////////////////////////////////////////////////////

if (isset($_POST['flag']) && $_POST['flag'] == 'deleteRoomReservations') {

    $controller = Load::controller('editHotelBooking');
    unset($_POST['flag']);
    echo $controller->deleteRoomReservations($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'editDateReserve') {

    $controller = Load::controller('editHotelBooking');
    unset($_POST['flag']);
    echo $controller->editDateReserve($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'editPassengerHotel') {

    $controller = Load::controller('editHotelBooking');
    unset($_POST['flag']);
    echo $controller->editPassengerHotel($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'editTransferHotel') {

    $controller = Load::controller('editHotelBooking');
    unset($_POST['flag']);
    echo $controller->editTransferHotel($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'addOneDayTour') {

    $controller = Load::controller('editHotelBooking');
    unset($_POST['flag']);
    echo $controller->addOneDayTour($_POST);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'deleteOneDayTour') {

    $controller = Load::controller('editHotelBooking');
    unset($_POST['flag']);
    echo $controller->deleteOneDayTour($_POST);
}


////////////////////////////////////////////////
//////////////////europcar/////////////////////
/*if (isset($_POST['flag']) && $_POST['flag'] == 'convertDateForEuropcar') {

    $controller= Load::controller('resultEuropcarLocal');
    unset($_POST['flag']);
    echo $controller->convertDateForEuropcar($_POST);
}*/
if (isset($_POST['flag']) && $_POST['flag'] == 'CarReserve') {

    unset($_POST['flag']);
    $factorNumber = filter_var($_POST['factorNumber'], FILTER_SANITIZE_NUMBER_INT);

    $Model = Load::library('Model');
    $ModelBase = Load::library('ModelBase');

    $d['status'] = 'PreReserve';
    $d['creation_date_int'] = time();
    $Condition = "factor_number='{$factorNumber}' ";

    $Model->setTable("book_europcar_local_tb");
    $res = $Model->update($d, $Condition);

    $ModelBase->setTable("report_europcar_tb");
    $res_report = $ModelBase->update($d, $Condition);

    if ($res && $res_report) {
        echo 'successReserveCar:'. functions::Xmlinformation('SuccessPreReserve');
    } else {
        echo 'error:'.functions::Xmlinformation('ReserveFailed');
    }

}

if (isset($_POST['flag']) && $_POST['flag'] == 'createPayButton') {

    unset($_POST['flag']);

    $bankInputs = array(
        'flag' => 'check_credit_hotel',
        'factorNumber' => $_POST['factorNumber'],
        'typeApplication' => $_POST['typeApplication'],
        'typeTrip' => $_POST['typeTrip'],
        'paymentPrice' => $_POST['paymentPrice'],
        'paymentStatus'=>'fullPayment',
        'serviceType' => $_POST['serviceType']
    );

    $creditInputs = array(
        'flag' => 'buyByCreditHotelLocal',
        'factorNumber' => $_POST['factorNumber'],
        'typeApplication' => $_POST['typeApplication'],
        'paymentStatus'=>'fullPayment'
    );

    if ($_POST['currencyCode'] > 0) {

        $paymentPriceCurrency = functions::CurrencyCalculate($_POST['paymentPrice'], $_POST['currencyCode'], $_POST['currencyEquivalent']);

        $currencyInputs = array(
            'flag' => 'check_credit_hotel',
            'factorNumber' => $_POST['factorNumber'],
            'typeApplication' => $_POST['typeApplication'],
            'typeTrip' => $_POST['typeTrip'],
            'paymentPrice' => $_POST['paymentPrice'],
            'serviceType' => $_POST['serviceType'],
            'amount' => $paymentPriceCurrency['AmountCurrency'],
            'currencyCode' => $_POST['currencyCode'],
        );

        $output['result_currency'] = '<a class="s-u-select-update s-u-select-update-change site-main-button-flat-color" onclick=\'currencyPayment(this, amadeusPath + "returnBankHotelNew", ' . json_encode($currencyInputs) . ')\'>'.functions::Xmlinformation('Payment').'</a>';
    }



    $output['result_bank'] = '<a class="s-u-select-update s-u-select-update-change site-main-button-flat-color" onclick=\'goToBank(this, amadeusPath + "goBankHotelLocal", ' . json_encode($bankInputs) . ')\'>'.functions::Xmlinformation('Payment').'</a>';

    $output['result_credit'] = '<a class="s-u-select-update s-u-select-update-change site-main-button-flat-color" onclick=\'creditBuy(this, amadeusPath + "returnBankHotelNew", ' . json_encode($creditInputs) . ')\'>'.functions::Xmlinformation('Paycredit').'</a>';
//    if(  $_SERVER['REMOTE_ADDR']=='84.241.4.20'  ) {
//        var_dump($bankInputs);
//
//    }
    echo json_encode($output);
}

if (isset($_POST['flag']) && $_POST['flag'] == 'insertTourType') {

    $controller = Load::controller('reservationBasicInformation');
    unset($_POST['flag']);
    echo $controller->insertTourType($_POST);
}

if (isset($_POST['flag']) && $_POST['flag'] == 'editTourType') {

    $controller = Load::controller('reservationBasicInformation');
    unset($_POST['flag']);
    echo $controller->editTourType($_POST);
}

if (isset($_POST['flag']) && $_POST['flag'] == 'getAllCity') {
    unset($_POST['flag']);

    $controller = Load::controller('appHotelLocal');
    $result = $controller->getAllCityForSearch($_POST['cityName'], '1');

    echo json_encode($result);
}

if (isset($_POST['flag']) && $_POST['flag'] == 'getResultHotelLocalForApp') {
    unset($_POST['flag']);

    $controller = Load::controller('appHotelLocal');
    $result = $controller->getHotelListBySearch($_POST);

    echo json_encode($result);
}

if (isset($_POST['flag']) && $_POST['flag'] == 'cancellationsPercentageTickets') {
    unset($_POST['flag']);

    $controller = Load::controller('reservationTicket');
    $result = $controller->setCancellationsPercentageTickets($_POST);

    echo $result;
}

if (isset($_POST['flag']) && $_POST['flag'] == 'editCancellationsTickets') {
    unset($_POST['flag']);

    $controller = Load::controller('reservationTicket');
    $result = $controller->updateCancellationsTickets($_POST);

    echo $result;
}

if (isset($_POST['flag']) && $_POST['flag'] == 'requestCancelReservationTicket') {
    unset($_POST['flag']);

    $controller = Load::controller('reservationTicket');
    $result = $controller->setRequestCancelReservationTicket($_POST);

    echo $result;
}
if (isset($_POST['flag']) && $_POST['flag'] == 'confirmCancelReservationTicket') {
    unset($_POST['flag']);

    $controller = Load::controller('reservationTicket');
    $result = $controller->setConfirmCancelReservationTicket($_POST['requestNumber'], $_POST['id']);

    echo $result;
}
if (isset($_POST['flag']) && $_POST['flag'] == 'checkReserveHotel') {
    unset($_POST['flag']);

    $controller = Load::controller('bookhotelshow');
    $result = $controller->getHotelOnRequestForAdmin();

    echo $result;
}
if (isset($_POST['flag']) && $_POST['flag'] == 'checkReserveSpecial') {

    unset($_POST['flag']);

    $controller = Load::controller('bookhotelshow');
    $result = $controller->getHotelOnRequestForAdminSpecial();

    echo $result;
}
if (isset($_POST['flag']) && $_POST['flag'] == 'createExcelFile') {
    unset($_POST['flag']);

    $controller = Load::controller('bookhotelshow');
    $result = $controller->createExcelFile($_POST);

    echo $result;
}
if (isset($_POST['flag']) && $_POST['flag'] == 'createExcelFileForEuropcar') {
    unset($_POST['flag']);

    $controller = Load::controller('bookEuropcarShow');
    $result = $controller->createExcelFile($_POST);

    echo $result;
}


if (isset($_POST['flag']) && $_POST['flag'] == 'getInfoRoomExternalHotel') {
    unset($_POST['flag']);

    $controller = Load::controller('resultExternalHotel');
    $resultRoom = $controller->getRoomHotel($_POST);
    $result = '';
    if (!empty($resultRoom['CancelationRules'])){
        foreach ($resultRoom['CancelationRules'] as $room){
            $result .= '<span>'
                        . '<p>Deadline Date: ' . $room['DeadlineDate'] . '</p>'
                        . '<p>Canx Fee Amount: ' . $room['CanxFeeAmount'] . '</p>'
                        . '<p>Description: ' . $room['Description'] . '</p>'
                    . '</span>';
        }
    } else {
        $result .= '<span style="text-align: center;margin-top: 10px;">'
                    . '<p>اطلاعات کنسلی در دسترس نمیباشد لطفا جهت کسب اطلاعات بیشتر با پشتیبانی تماس حاصل فرمایید</p>'
                . '</span>';
    }
    echo $result;
}

if (isset($_POST['flag']) && $_POST['flag'] == 'setTemproryExternalHotel') {
    unset($_POST['flag']);

    $controller = Load::controller('resultExternalHotel');
    $result = $controller->setTemproryHotel($_POST);

    echo $result;
}
if (isset($_POST['flag']) && $_POST['flag'] == 'updateBusCities') {
    unset($_POST['flag']);

    $objHotel = Load::controller('busPanel');
    $result = $objHotel->updateBusCities($_POST);

    echo  $result;
}
if(isset($_POST['flag']) && $_POST['flag'] == 'searchHotel')
{
    unset($_POST['flag']);
    $objHotel = Load::controller('searchHotel');
    echo  $objHotel->searchHotel($_POST);
}

if(isset($_POST['flag']) && $_POST['flag'] == 'detailHotel')
{
	unset($_POST['flag']);

	$objHotel = Load::controller('detailHotel');
	echo $objHotel->Detail($_POST);
}
if(isset($_POST['flag']) && $_POST['flag'] == 'directDetailHotel')
{

	unset($_POST['flag']);


	$objHotel = Load::controller('detailHotel');
    header( "Content-type: application/json" );
echo  functions::clearJsonHiddenCharacters(json_encode($objHotel->DirectDetail($_POST),256|16));

}
if(isset($_POST['flag']) && $_POST['flag'] == 'getPrices')
{
	unset($_POST['flag']);
    /** @var detailHotel $objHotel */
	$objHotel = Load::controller('detailHotel');
	echo $objHotel->getPrices($_POST);
}
if(isset($_POST['flag']) && $_POST['flag'] == 'getCancellationPolicy')
{
	unset($_POST['flag']);
    /** @var detailHotel $objHotel */
	$objHotel = Load::controller('detailHotel');
	echo $objHotel->getCancellationPolicy($_POST);
}

if(isset($_POST['flag']) && $_POST['flag'] == 'searchboxHotels'){
	Load::autoload('searchboxHotels');
	$searchboxHotels = new searchboxHotels();
	echo $searchboxHotels->searchboxHotels($_POST);
}

if (isset($_POST['flag']) && $_POST['flag'] == "nextStepReserveApiHotel") {

	unset($_POST['flag']);
	$objHotel = Load::controller('apiHotelLocal');
	$result = $objHotel->NextStepReserveHotel($_POST);
	
	if (isset($_POST['dataTypeResult']) && $_POST['dataTypeResult'] == 'json'){
		unset($_POST['dataTypeResult']);
		$arrayResult = explode(":", $result);
		$dataJson['message'] = $arrayResult[0];
		$dataJson['factorNumber'] = trim($arrayResult[1]);
		echo json_encode($dataJson);
		
	} else {
		echo $result;
	}
}

if (isset($_POST['flag']) && $_POST['flag'] == "nextStepReserveApiHotelNew") {



	unset($_POST['flag']);
    /** @var detailHotel $objHotel */
    $objHotel = Load::controller('detailHotel');

	$result = $objHotel->insertTemporaryHotel($_POST);

	if (isset($_POST['dataTypeResult']) && $_POST['dataTypeResult'] == 'json'){
		unset($_POST['dataTypeResult']);
		$arrayResult = explode(":", $result);
		$dataJson['message'] = $arrayResult[0];
		$dataJson['factorNumber'] = trim($arrayResult[1]);

		echo json_encode($dataJson);
		
	} else {
		echo $result;
	}
}


if (isset($_POST['flag']) && $_POST['flag'] == "register_memeberNewHotel") {

	$objHotel = Load::controller('detailHotel');
	$objHotel->registerPassengerOnline();
}


if (isset($_POST['flag']) && $_POST['flag'] == 'HotelReserveNew') {

	unset($_POST['flag']);
	
	Load::autoload('detailHotel');
	$controller = new detailHotel();
	echo $controller->HotelReserveNew($_POST);
	exit();
}
if (isset($_POST['flag']) && $_POST['flag'] == 'GetDataFromReport') {
    functions::insertLog(' GetDataFromReport hotel','Hotels/smsHotel');
	unset($_POST['flag']);
	
	Load::autoload('detailHotel');
	$controller = new detailHotel();
	echo $controller->GetDataFromReport($_POST);
	exit();
}

if(isset($_POST['flag']) && $_POST['flag'] == 'checkOfflineStatus'){
	unset($_POST['flag']);
	Load::autoload('detailHotel');
	$controller = new detailHotel();
	echo $controller->checkOfflineStatus($_POST['request_number']);
	exit();
}

if(isset($_POST['flag']) && $_POST['flag'] == 'admin_checked'){
    unset($_POST['flag']);
	Load::autoload('detailHotel');
	$controller = new detailHotel();
	echo $controller->adminCheckedStatus($_POST);
	exit();
}
if(isset($_POST['flag']) && $_POST['flag'] == 'flightExternalRoutesDefault'){

    unset($_POST['flag']);

    /** @var ModelBase $ModelBase */

    if ( isset( $_POST['self_Db'] ) && $_POST['self_Db'] != true ) {
        $ModelBase = Load::library( 'ModelBase' );
        $clientSql = "SELECT DepartureCode,DepartureCityEn,DepartureCityFa,AirportFa,AirportEn,CountryFa,CountryEn  FROM flight_portal_tb where DepartureCode != 'IKA' ";
        $result =  $ModelBase->select( $clientSql ) ;
    } else {
        $Model = Load::library( 'Model' );
        $clientSql = "SELECT DepartureCode,DepartureCityEn,DepartureCityFa,AirportFa,AirportEn,CountryFa,CountryEn  FROM flight_portal_tb where DepartureCode != 'IKA'";
        $result =  $Model->select( $clientSql ) ;

    }

    foreach ($result as $key => $flight) {

        $countryNameEn = strtolower(trim($flight['CountryEn']));
        $countryNameEn = str_replace("  ", " ", $countryNameEn);
        $countryNameEn = str_replace(" ", "-", $countryNameEn);
        $cityNameEn = strtolower(trim($flight['DepartureCityEn']));
        $cityNameEn = str_replace("  ", " ", $cityNameEn);
        $cityNameEn = str_replace(" ", "-", $cityNameEn);

        $result[$key]['DepartureCityEn'] = $cityNameEn;
        $result[$key]['CountryEn'] = $countryNameEn;

    }

    				


    echo  json_encode($result ) ;
    exit();

}

if(isset($_POST['flag']) && $_POST['flag'] == 'flightInternalRoutesDefault'){
    unset($_POST['flag']);

    /** @var ModelBase $ModelBase */
    $ModelBase = Load::library( 'ModelBase' );
    $popular_cities = $this->getModel('hotelCitiesModel')->get()->where('position' , '!=' , null)->orderBy('position','DESC')->all();

    echo json_encode( $popular_cities );

    exit();
}

if (isset($_POST['flag']) && $_POST['flag'] == 'searchCityForInternalHotel') {
    unset($_POST['flag']);

    $result = Load::controller('searchHotel');
    echo $result->searchCity($_POST['inputSearchValue']);
}
if (isset($_POST['flag']) && $_POST['flag'] == 'isShowHotel') {

    $edit = Load::controller('reservationBasicInformation');
    unset($_POST['flag']);
    echo $edit->isShowHotel($_POST);

}
elseif (isset($_POST['flag']) && $_POST['flag'] == 'isSpecialHotel') {
    unset($_POST['flag']);

    $objController = Load::controller('reservationHotel');
    $result = $objController->isSpecialHotel($_POST['id']);

    echo $result;

}
elseif (isset($_POST['flag']) && $_POST['flag'] == 'isAcceptHotel') {
    unset($_POST['flag']);

    $objController = Load::controller('reservationHotel');
    $result = $objController->isAcceptHotel($_POST['id']);

    echo $result;

}
elseif (isset($_POST['flag']) && $_POST['flag'] == 'showHotelAtHome') {
    unset($_POST['flag']);

    $objController = Load::controller('reservationHotel');
    $result = $objController->showAtHome($_POST['id']);

    echo $result;

}elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'ConfirmRequestedHotelPrereserveByAdmin' ) {
    unset( $_POST['flag'] );
    $objController= Load::controller( 'reservationHotel' );

    echo $objController->confirmHotelRequested( $_POST );
}elseif ( isset( $_POST['flag'] ) && $_POST['flag'] == 'RejectRequestedHotelPreeserveByAdmin' ) {
    unset( $_POST['flag'] );
    $objController= Load::controller( 'reservationHotel' );

    echo $objController->RejectHotelRequested( $_POST );
}