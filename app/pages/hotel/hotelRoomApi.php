<?php

$param['idHotel'] = $hotelId;
$param['startDate'] = $startDate;
$param['city'] = $cityId;
$param['hotelStar'] = $hotelStar;
$param['nights'] = $nights;
$hotelRoom = $objResultHotelLocal->getHotelRoomForAjax($param);
$roomPrice = $objResultHotelLocal->getHotelRoomPricesForAjax($param);
?>


<div class="hotel-room-items">

    <?php
    if ($hotelRoom && $roomPrice) {

        $countRoom = 0;
        $allTypeRoomHotel = "";
        $counter_button_reserve = "1";
        $sDate = str_replace("-", "", $startDate);

        switch ($nights) {
            case '1':
                $classByNight = 'one-day-hotel';
                break;
            case '2':
                $classByNight = 'two-day-hotel';
                break;
            case '3':
                $classByNight = 'three-day-hotel';
                break;
            default :
                $classByNight = '';
                break;
        }

        foreach ($hotelRoom as $room) {
            $countRoom++;
            $allTypeRoomHotel .= $room['Code'] . '/';
            ?>
            <div class="hotel-room-item hotel-room-2 hotel-room-auto <?php echo $classByNight; ?>"
                 id="room<?php echo $room['Code']; ?>">
                <div class="hri-top">
                    <span><?php echo $room['Name']; ?></span>
                    <div class="capacity">
                        <span></span>
                        <span><?php echo $room['MaxCapacity']; ?> تخته</span>
                    </div>
                </div>
                <?php
                $roomsPrice = 0;
                $roomsPriceBoard = 0;
                $flagRemainingCapacity = 0;
                if ($nights > 1) {
                    ?>
                    <div class="hri-middle">
                        <?php
                        if (isset($roomPrice[$room['Code']]) && $roomPrice[$room['Code']] != ''){
                            foreach ($roomPrice[$room['Code']] as $roomPriceDate) {
                                $dateYear = substr($roomPriceDate['Date'], 0, 4);
                                $dateMonth = substr($roomPriceDate['Date'], 4, 2);
                                $dateDay = substr($roomPriceDate['Date'], 6, 2);
                                $date = $dateYear . '-' . $dateMonth . '-' . $dateDay;

                                $roomsPrice += $roomPriceDate['Price'];
                                $roomsPriceBoard += $roomPriceDate['PriceBoard'];

                                if ($roomPriceDate['RemainingCapacity'] > 0) {
                                    ?>
                                    <div class="price-preview">
                                        <div class="price-preview-date"><?php echo $date; ?></div>
                                        <div class="price-preview-price"><?php echo number_format($roomPriceDate['Price']); ?>
                                            <i>ریال</i></div>
                                    </div>
                                    <?php
                                } else {
                                    $flagRemainingCapacity++;
                                    ?>
                                    <div class="price-preview price-preview-unavailable">
                                        <div class="price-preview-date"><?php echo $date; ?></div>
                                        <div class="price-preview-price">ناموجود</div>
                                    </div>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </div>
                    <?php
                } else {
                    if (isset($roomPrice[$room['Code']]) && $roomPrice[$room['Code']] != ''){
                        foreach ($roomPrice[$room['Code']] as $roomPriceDate) {
                            $roomsPrice += $roomPriceDate['Price'];
                            $roomsPriceBoard += $roomPriceDate['PriceBoard'];
                            if ($roomPriceDate['RemainingCapacity'] <= 0) {
                                $flagRemainingCapacity++;
                            }
                        }
                    }
                }
                ?>

                <div class="hri-bottom">

                    <?php
                    if (isset($roomPrice[$room['Code']][$sDate]['Discount']) && $roomPrice[$room['Code']][$sDate]['Discount'] >0){
                        ?>
                        <div class="off-percentage">
                            <span><?php echo $roomPrice[$room['Code']][$sDate]['Discount']; ?>%</span>
                            <span>تخفیف</span>
                        </div>
                        <?php
                    }
                    ?>

                    <div class="hri-price">
                        <span>قیمت برای <?php echo $nights; ?> شب</span>
                        <div class="price-off">
                            <span class="price-old"><?php echo number_format($roomsPriceBoard); ?></span>
                            <span class="price-new"><?php echo number_format($roomsPrice); ?><i>ریال</i></span>
                        </div>
                    </div>


                    <input type="hidden" value="" id="finalRoomCount<?php echo $room['Code']; ?>"
                           name="finalRoomCount<?php echo $room['Code']; ?>">
                    <input type="hidden" value="" id="finalPriceRoom<?php echo $room['Code']; ?>"
                           name="finalPriceRoom<?php echo $room['Code']; ?>">
                    <input type="hidden" id="priceRoom<?php echo $room['Code']; ?>"
                           name="priceRoom<?php echo $room['Code']; ?>" value="<?php echo $roomsPrice; ?>">
                    <input type="hidden" id="nameRoom<?php echo $room['Code']; ?>"
                           name="nameRoom<?php echo $room['Code']; ?>" value="<?php echo $room['Name']; ?>">

                    <?php
//                    if ($flagRemainingCapacity == 0) {
//                        ?>
<!--                        <div class="hri-rezerv  unabailable">-->
<!--                            <span class="site-bg-main-color">ناموجود</span>-->
<!--                        </div>-->
<!--                        --><?php
//                    }
                    ?>

                    <?php
                    //if ($flagRemainingCapacity == 0) {
                    if ($roomPrice[$room['Code']][$sDate]['RemainingCapacity'] > 0) {
                        ?>
                        <div>
                            <span>رزرو آنلاین</span>
                        </div>
                        <?php
                    }
                    ?>


                    <div class="hri-rezerv" id="removeRoom<?php echo $room['Code']; ?>">
                        <div class="remove-room myhidden"
                             onclick="removeRoom('<?php echo $room['Code']; ?>')"></div>
                        <span class="sheet-open site-bg-main-color" data-sheet=".my-sheet<?php echo $room['Code']; ?>">رزرو اتاق</span>
                    </div>


                    <div class="sheet-modal hotel-room-sheet-1 my-sheet<?php echo $room['Code']; ?>">
                        <div class="toolbar">
                            <div class="toolbar-inner">
                                <div class="left">
                                    <span class="sheet-title">
                                        <?php echo $room['Name']; ?>
                                    </span>
                                </div>
                                <div class="right">
                                    <a class="link sheet-close" href="#"
                                       onclick="selectRoom('<?php echo $room['Code']; ?>')">بستن</a>
                                </div>
                            </div>
                        </div>
                        <div class="sheet-modal-inner">
                            <div class="block">
                                <div class="sheet-room">

                                    <div class="hotel-room-number">
                                        <span>تعداد اتاق</span>
                                        <span>
                                             <div class="stepper stepper-raised stepper-fill stepper-init">

                                                 <div class="stepper-button-plus">
                                                      <div class="stepper-svg">
                                                      <svg version="1.1" id="Capa_1" class="site-bg-svg-color" xmlns="http://www.w3.org/2000/svg"
                                                           xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                           viewBox="0 0 304.223 304.223"
                                                           style="enable-background:new 0 0 304.223 304.223;"
                                                           xml:space="preserve">
                                                      <g>
                                                          <g>
                                                              <path d="M152.112,0C68.241,0,0.008,68.244,0.008,152.114c0,83.865,68.233,152.109,152.103,152.109
                                                                  c83.865,0,152.103-68.244,152.103-152.109C304.215,68.244,235.977,0,152.112,0z M152.112,275.989
                                                                  c-68.32,0-123.891-55.565-123.891-123.875c0-68.326,55.571-123.891,123.891-123.891s123.891,55.565,123.891,123.891
                                                                  C276.003,220.424,220.426,275.989,152.112,275.989z"/>
                                                              <path d="M221.922,139.186h-56.887V82.298c0-7.141-5.782-12.929-12.923-12.929
                                                                  c-7.141,0-12.929,5.782-12.929,12.929v56.887H82.296c-7.141,0-12.923,5.782-12.923,12.929c0,7.141,5.782,12.923,12.923,12.923
                                                                  h56.882v56.893c0,7.142,5.787,12.923,12.929,12.923c7.141,0,12.929-5.782,12.929-12.923v-56.893h56.882
                                                                  c7.142,0,12.929-5.782,12.929-12.923C234.851,144.967,229.063,139.186,221.922,139.186z"/>
                                                          </g>
                                                      </g>
                                                      </svg>
                                                    </div>
                                                 </div>
                                                 <div class="stepper-input-wrap">
                                                     <input type="text" value="0"
                                                            name="RoomCount<?php echo $room['Code']; ?>"
                                                            id="RoomCount<?php echo $room['Code']; ?>"
                                                            min="0" max="9" step="1" readonly>
                                                 </div>
                                                    <div class="stepper-button-minus">
                                                          <div class="stepper-svg">
                                                          <svg version="1.1" class="site-bg-svg-color" id="Capa_1"
                                                               xmlns="http://www.w3.org/2000/svg"
                                                               xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                                               y="0px"
                                                               width="55.703px" height="55.704px"
                                                               viewBox="0 0 55.703 55.704"
                                                               style="enable-background:new 0 0 55.703 55.704;"
                                                               xml:space="preserve">
                                                          <g>
                                                              <g>
                                                                  <path d="M27.851,0C12.495,0,0,12.495,0,27.852s12.495,27.851,27.851,27.851c15.357,0,27.852-12.494,27.852-27.851
                                                                      S43.209,0,27.851,0z M27.851,51.213c-12.882,0-23.362-10.48-23.362-23.362c0-12.882,10.481-23.362,23.362-23.362
                                                                      c12.883,0,23.364,10.48,23.364,23.362C51.215,40.733,40.734,51.213,27.851,51.213z"/>
                                                                  <path d="M38.325,25.607H17.379c-1.239,0-2.244,1.005-2.244,2.244c0,1.239,1.005,2.245,2.244,2.245h20.946
                                                                      c1.239,0,2.244-1.006,2.244-2.245C40.569,26.612,39.564,25.607,38.325,25.607z"/>
                                                              </g>
                                                          </g>
                                                          </svg>
                                                        </div>
                                                    </div>
                                              </div>
                                        </span>
                                    </div>

                                    <div class="hotel-room-btn">
                                        <a href="#" class="site-bg-main-color" onclick="selectRoom('<?php echo $room['Code']; ?>')">تایید</a>
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
        <input type="hidden" name="countRoom" id="countRoom" value="<?php echo $countRoom; ?>">
        <input type="hidden" name="typeRoomHotel" id="typeRoomHotel" value="<?php echo $allTypeRoomHotel; ?>">
        <input type="hidden" name="totalNumberRoom" id="totalNumberRoom" value="">
        <input type="hidden" name="totalPriceHotel" id="totalPriceHotel" value="">
        <input type="hidden" id="totalNumberRoomReserve" name="totalNumberRoomReserve" value="">
</div>
        <div class="continue-rezerv-hotel myhidden" id="buttonReserveHotel">
            <div class="price-calculated">
                <span>مجموع قیمت سفارش برای <?php echo $nights; ?> شب</span>
                <span id="roomFinalPrice">0<i>ریال</i></span>
            </div>
            <a href="#" class="site-bg-main-color" onclick="checkLogin();"><span id="roomFinalTxt">0 اتاق</span> ادامه فرایند رزرو</a>
        </div>

        <?php

    } else {
        ?>
        <div>
            <span>هم اکنون امکان رزرو وجود ندارد.</span>
        </div>
            </div>
        <?php
    }
    ?>


