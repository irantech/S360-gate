<?php

$objResultHotelLocal->getHotelRoom($hotelId);
$objResultHotelLocal->getHotelRoomPrices($hotelId, $startDate, $endDate);
$objResultHotelLocal->getInfoRoom($hotelId);


?>


<div class="hotel-room-items">

    <?php
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

    $AllTypeRoomHotel = '';
    foreach ($objResultHotelLocal->reservationHotelRoom as $room) {

        $AllTypeRoomHotel .= $room['id_room'] . '/';
        ?>
        <div class="hotel-room-item hotel-room-1 hotel-room-auto <?php echo $classByNight; ?>"
             id="room<?php echo $room['id_room']; ?>">
            <div class="hri-top">
                <span><?php echo $room['room_name']; ?></span>
                <?php
                if ($objResultHotelLocal->RoomPrices[$room['id_room']]['DBL'][$startDate]['RemainingCapacity'] > 0) {
                    ?>
                    <div class="online-rezerv-hotel">
                        <span>رزرو آنلاین</span>
                    </div>
                    <?php
                }
                ?>
                <div class="capacity">
                    <span></span>
                    <span><?php echo $room['room_capacity']; ?> تخته</span>
                </div>
            </div>
            <?php
            $fkDBL = '';
            $fkEXT = '';
            $fkECHD = '';
            $CostRoom = 0;
            $CostBedEXT = 0;
            $CostBedCHD = 0;

            if ($nights > 1) {
                ?>
                <div class="hri-middle">
                    <?php
                    if (!empty($objResultHotelLocal->RoomPrices[$room['id_room']]['DBL'])) {
                        foreach ($objResultHotelLocal->RoomPrices[$room['id_room']]['DBL'] as $roomPrice) {

                            $fkDBL .= $roomPrice['id'] . '/';
                            $fkEXT .= $objResultHotelLocal->RoomPrices[$room['id_room']]['EXT'][$roomPrice['Date']]['id'] . '/';
                            $fkECHD .= $objResultHotelLocal->RoomPrices[$room['id_room']]['ECHD'][$roomPrice['Date']]['id'] . '/';

                            $CostRoom += $roomPrice['PriceOnline'];
                            $CostBedEXT += $objResultHotelLocal->RoomPrices[$room['id_room']]['EXT'][$roomPrice['Date']]['PriceOnline'];
                            $CostBedCHD += $objResultHotelLocal->RoomPrices[$room['id_room']]['ECHD'][$roomPrice['Date']]['PriceOnline'];

                            if ($roomPrice['RemainingCapacity'] > 0) {
                                ?>
                                <div class="price-preview">
                                    <div class="price-preview-date"><?php echo $roomPrice['Date']; ?></div>
                                    <div class="price-preview-price"><?php echo number_format($roomPrice['PriceOnline']); ?>
                                        <i>ریال</i></div>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="price-preview price-preview-unavailable">
                                    <div class="price-preview-date"><?php echo $roomPrice['Date']; ?></div>
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
                ?>
                <?php
                if (!empty($objResultHotelLocal->RoomPrices[$room['id_room']]['DBL'])) {
                    foreach ($objResultHotelLocal->RoomPrices[$room['id_room']]['DBL'] as $roomPrice) {
                        $fkDBL .= $roomPrice['id'] . '/';
                        $fkEXT .= $objResultHotelLocal->RoomPrices[$room['id_room']]['EXT'][$roomPrice['Date']]['id'] . '/';
                        $fkECHD .= $objResultHotelLocal->RoomPrices[$room['id_room']]['ECHD'][$roomPrice['Date']]['id'] . '/';
                        $CostRoom += $roomPrice['PriceOnline'];
                        $CostBedEXT += $objResultHotelLocal->RoomPrices[$room['id_room']]['EXT'][$roomPrice['Date']]['PriceOnline'];
                        $CostBedCHD += $objResultHotelLocal->RoomPrices[$room['id_room']]['ECHD'][$roomPrice['Date']]['PriceOnline'];
                    }
                }
                ?>
                <?php
            }
            ?>


            <input type="hidden" name="CostkolHotelRoom_EXT<?php echo $room['id_room']; ?>"
                   id="CostkolHotelRoom_EXT<?php echo $room['id_room']; ?>" value="<?php echo $CostBedEXT; ?>">
            <input type="hidden" name="CostkolHotelRoom_CHD<?php echo $room['id_room']; ?>"
                   id="CostkolHotelRoom_CHD<?php echo $room['id_room']; ?>" value="<?php echo $CostBedCHD; ?>">
            <input type="hidden" name="CostkolHotelRoom_DBL<?php echo $room['id_room']; ?>"
                   id="CostkolHotelRoom_DBL<?php echo $room['id_room']; ?>" value="<?php echo $CostRoom; ?>">
            <input name="fkDBL<?php echo $room['id_room']; ?>" id="fkDBL<?php echo $room['id_room']; ?>"
                   value="<?php echo $fkDBL; ?>" type="hidden">
            <input name="fkEXT<?php echo $room['id_room']; ?>" id="fkEXT<?php echo $room['id_room']; ?>"
                   value="<?php echo $fkEXT; ?>" type="hidden">
            <input name="fkECHD<?php echo $room['id_room']; ?>" id="fkECHD<?php echo $room['id_room']; ?>"
                   value="<?php echo $fkECHD; ?>" type="hidden">



            <div class="hri-bottom">

                <?php
                if (isset($objResultHotelLocal->RoomPrices[$room['id_room']]['DBL'][$startDate]['Discount']) && $objResultHotelLocal->RoomPrices[$room['id_room']]['DBL'][$startDate]['Discount'] > 0) {
                    ?>
                    <div class="off-percentage">
                            <span><?php echo $objResultHotelLocal->RoomPrices[$room['id_room']]['DBL'][$startDate]['Discount']; ?>
                                %</span>
                        <span>تخفیف</span>
                    </div>
                    <?php
                }
                ?>
                <div class="hri-price">
                    <?php
                    if (!empty($objResultHotelLocal->RoomPrices[$room['id_room']]['DBL'])) {
                        ?>
                        <span>قیمت برای <?php echo $nights; ?> شب</span>
                        <div class="price-off">
                            <?php
                            if (isset($objResultHotelLocal->RoomPrices[$room['id_room']]['DBL'][$startDate]['Discount']) && $objResultHotelLocal->RoomPrices[$room['id_room']]['DBL'][$startDate]['Discount'] > 0) {
                                ?>
                                <span class="price-old">
                                <?php echo number_format($objResultHotelLocal->RoomPrices[$room['id_room']]['DBL'][$startDate]['PriceBoardForView']); ?>
                            </span>
                                <?php
                            }
                            ?>
                            <span class="price-new">
                                    <?php echo number_format($objResultHotelLocal->RoomPrices[$room['id_room']]['DBL'][$startDate]['PriceOnlineForView']); ?>
                                <i>ریال</i>
                            </span>
                        </div>
                        <?php
                    } else {
                        ?>
                        <span></span>
                        <div class="price-off">
                            <span class="price-old"></span>
                            <span class="price-new">0<i>ریال</i></span>
                        </div>
                        <?php
                    }
                    ?>
                </div>




                <?php
                if (!empty($objResultHotelLocal->RoomPrices)) {
                    ?>
                    <div class="hri-rezerv" id="removeRoom<?php echo $room['id_room']; ?>">
                        <div class="remove-room myhidden" onclick="removeRoom('<?php echo $room['id_room']; ?>')"></div>
                        <span class="sheet-open site-bg-main-color"
                              data-sheet=".my-sheet<?php echo $room['id_room']; ?>">رزرو اتاق</span>
                    </div>
                    <?php
                }
                ?>


                <div class="sheet-modal hotel-room-sheet-1 my-sheet<?php echo $room['id_room']; ?>">
                    <div class="toolbar">
                        <div class="toolbar-inner">
                            <div class="left">
                                    <span class="sheet-title">
                                        <?php echo $room['room_name']; ?>
                                        <?php
                                        if (!empty($objResultHotelLocal->RoomPrices)) {
                                            if (isset($objResultHotelLocal->RoomPrices[$room['id_room']]['DBL'][$startDate]['Breakfast'])
                                                && $objResultHotelLocal->RoomPrices[$room['id_room']]['DBL'][$startDate]['Breakfast'] == 'yes') {
                                                echo ' + صبحانه';
                                            } elseif (isset($objResultHotelLocal->RoomPrices[$room['id_room']]['DBL'][$startDate]['Lunch'])
                                                && $objResultHotelLocal->RoomPrices[$room['id_room']]['DBL'][$startDate]['Lunch'] == 'yes') {
                                                echo ' + ناهار';
                                            } elseif (isset($objResultHotelLocal->RoomPrices[$room['id_room']]['DBL'][$startDate]['Dinner'])
                                                && $objResultHotelLocal->RoomPrices[$room['id_room']]['DBL'][$startDate]['Dinner'] == 'yes') {
                                                echo ' + شام';
                                            }
                                        }
                                        ?>
                                    </span>
                            </div>
                            <div class="right">
                                <a class="link sheet-close" href="#"
                                   onclick="selectRoom('<?php echo $room['id_room']; ?>')">بستن</a>
                            </div>
                        </div>
                    </div>
                    <div class="sheet-modal-inner">
                        <div class="block">
                            <div class="sheet-room">

                                <input type="hidden" id="priceRoom<?php echo $room['id_room']; ?>"
                                       name="priceRoom<?php echo $room['id_room']; ?>" value="">
                                <input type="hidden" id="nameRoom<?php echo $room['id_room']; ?>"
                                       name="nameRoom<?php echo $room['id_room']; ?>"
                                       value="<?php echo $room['room_name']; ?>">
                                <input type="hidden" id="finalRoomCount<?php echo $room['id_room']; ?>"
                                       name="finalRoomCount<?php echo $room['id_room']; ?>" value="">
                                <input type="hidden" id="finalPriceRoom<?php echo $room['id_room']; ?>"
                                       name="finalPriceRoom<?php echo $room['id_room']; ?>" value="">


                                <div class="hotel-room-number">
                                    <span>تعداد اتاق</span>
                                    <span>
                                         <div class="stepper stepper-raised stepper-fill stepper-init">

                                             <div class="stepper-button-plus">
                                                  <div class="stepper-svg">
                                                  <svg class="site-bg-svg-color" version="1.1" id="Capa_1"
                                                       xmlns="http://www.w3.org/2000/svg"
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
                                                        name="RoomCount<?php echo $room['id_room']; ?>"
                                                        id="RoomCount<?php echo $room['id_room']; ?>"
                                                        min="0" max="9" step="1" readonly>
                                             </div>
                                                <div class="stepper-button-minus">
                                                      <div class="stepper-svg">
                                                      <svg class="site-bg-svg-color" version="1.1" id="Capa_1"
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
                                <div class="hotel-room-extra-bed">


                                    <input type="hidden" value="<?php echo $room['maximum_extra_beds']; ?>"
                                           id="maximum_extra_beds<?php echo $room['id_room']; ?>"
                                           name="maximum_extra_beds<?php echo $room['id_room']; ?>">
                                    <input type="hidden" value="<?php echo $room['maximum_extra_chd_beds']; ?>"
                                           id="maximum_extra_chd_beds<?php echo $room['id_room']; ?>"
                                           name="maximum_extra_chd_beds<?php echo $room['id_room']; ?>">

                                    <?php
                                    if ($room['maximum_extra_beds'] > 0) {
                                        ?>
                                        <div class="extra-bed-item">
                                            <span>تخت اضافه بزرگسال <i>(<?php echo number_format($CostBedEXT); ?>
                                                    + ریال)</i> </span>
                                            <span>
                                                    <div class="stepper stepper-raised stepper-fill stepper-init">
                                                        <div class="stepper-button-plus">
                                                              <div class="stepper-svg">
                                                              <svg class="site-bg-svg-color" version="1.1" id="Capa_1"
                                                                   xmlns="http://www.w3.org/2000/svg"
                                                                   xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                                                   y="0px"
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
                                                             <input type="text" value="0" min="0"
                                                                    id="ExtraBed<?php echo $room['id_room']; ?>"
                                                                    name="ExtraBed<?php echo $room['id_room']; ?>"
                                                                    max="9" step="1" readonly>
                                                        </div>
                                                        <div class="stepper-button-minus">
                                                              <div class="stepper-svg">
                                                              <svg class="site-bg-svg-color" version="1.1" id="Capa_1"
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
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($room['maximum_extra_chd_beds'] > 0) {
                                        ?>
                                        <div class="extra-bed-item">
                                            <span>تخت اضافه کودک <i>(<?php echo number_format($CostBedCHD); ?>
                                                    + ریال)</i></span>
                                            <span>
                                                    <div class="stepper stepper-raised stepper-fill stepper-init">
                                                         <div class="stepper-button-plus">
                                                              <div class="stepper-svg">
                                                              <svg class="site-bg-svg-color" version="1.1" id="Capa_1"
                                                                   xmlns="http://www.w3.org/2000/svg"
                                                                   xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                                                   y="0px"
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
                                                             <input type="text" value="0" min="0"
                                                                    id="ExtraChildBed<?php echo $room['id_room']; ?>"
                                                                    name="ExtraChildBed<?php echo $room['id_room']; ?>"
                                                                    max="9" step="1" readonly>
                                                         </div>

                                                        <div class="stepper-button-minus">
                                                              <div class="stepper-svg">
                                                              <svg class="site-bg-svg-color" version="1.1" id="Capa_1"
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
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="hotel-room-btn">
                                    <a href="#" class="site-bg-main-color"
                                       onclick="selectRoom('<?php echo $room['id_room']; ?>')">تایید</a>
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

    <?php
    if (!empty($objResultHotelLocal->RoomPrices)) {
        ?>
        <div class="continue-rezerv-hotel myhidden" id="buttonReserveHotel">
            <div class="price-calculated">
                <span>مجموع قیمت سفارش برای <?php echo $nights; ?> شب</span>
                <span id="roomFinalPrice">0<i>ریال</i></span>
            </div>
            <a href="#" class="site-bg-main-color" onclick="checkLogin();"><span id="roomFinalTxt">0 اتاق</span> ادامه
                فرایند رزرو</a>
        </div>
        <?php
    }
    ?>


    <input name="typeRoomHotel" id="typeRoomHotel" value="<?php echo $AllTypeRoomHotel; ?>" type="hidden">
    <input name="totalNumberRoom" id="totalNumberRoom" value="" type="hidden">
    <input name="totalPriceHotel" id="totalPriceHotel" value="" type="hidden">
    <input name="totalNumberRoomReserve" id="totalNumberRoomReserve" value="" type="hidden">


</div>


