<?php


foreach ($ResultTicketDetail as $direction => $DetailTicket) {
    if ($DetailTicket['IsInternalFlight'] == '0') {
        $DataRouteDetail = $TicketDetail->DetailRoutesTemporary($DetailTicket['id']);
        $RoutDept = functions::array_filter_by_value($DataRouteDetail, 'TypeRoute', 'Dept');
        $RoutReturn = functions::array_filter_by_value($DataRouteDetail, 'TypeRoute', 'Return');

        $keyDept = 0;
        foreach ($RoutDept as $routeReturn) {
            $RoutDeptArray[$keyDept] = $routeReturn;
            $keyDept++;
        }

        $keyReturn = 0;
        foreach ($RoutReturn as $routeReturn) {
            $RoutReturnArray[$keyReturn] = $routeReturn;
            $keyReturn++;
        }

    }
    ?>
    <div class="blit-detail-inner  blit-raft-bargasht-info blit-<?php echo $direction == 'dept' ? 'raft' : 'bargasht' ?>-info">
        <?php


        if (isset($DataRouteDetail) && !empty($DataRouteDetail)) {
            foreach ($RoutDeptArray as $keyRouteDept => $route) {
                ?>
                <div class="blit-detail-foreign-raft">
                    <?php
                    if (substr($route['Transit'], 0, 7) != "0:00:00" && !empty($route['Transit'])) { ?>
                        <div class="blit-detail-foreign-tavaghof">
                            <span>
                                توقف در
                            <?php
                            $city = functions::NameCityForeign($route['OriginAirportIata']);
                            echo !empty($route['Departure']['City']) ? $city['DepartureCityFa'] : $city['DepartureCityFa'] . ' ( ' . $city['AirportFa'] . ' ) '
                            ?>
                            </span>

                            <span>
                            <?php
                            $Transit = explode(':', $route['Transit']);
                            echo (($Transit[0] > '0') ? $Transit[0] . 'روز و' : ' ') . $Transit[1] . ' ' . 'ساعت و' . ' ' . $Transit[2] . 'دقیقه';
                            ?>
                            </span>
                        </div>
                        <?php
                    }
                    ?>
                    <?php if ($keyRouteDept == '0') { ?>
                        <h1 class="TitleDetailTicket site-bg-main-color-before">بلیط رفت </h1>
                    <?php } ?>
                    <div class="blit-detail-foreign-item">
                    <div class="blit-detail-airline">

                        <div class="blit-detail-airline-left">
                            <span>شماره پرواز : <?php echo $route['FlightNumber'] ?></span>
                            <span>هواپیما  :<?php echo $route['AirlineName'] ?>
                    </span>
                        </div>
                        <img src="<?php echo functions::getAirlinePhoto($route['Airline_IATA']) ?>" alt="">

                    </div>

                    <div class="blit-detail-mabda site-bg-main-color-before">
                        <div class="blit-detail-mabda-city">
                            <span><?php echo $route['OriginCity'] ?>
                            <i><?php  $Airport = functions::NameCityForeign($route['OriginAirportIata']);
                                    echo $Airport['AirportFa'];
                            ?></i>
                            </span>
                            <span><?php echo functions::format_hour($route['Time']) ?>
                            <i><?php $FormatDate = functions::OtherFormatDate(str_replace('/', '-', $route['Date']));
                                echo $FormatDate['NowDay'] ?></i>
                            </span>
                        </div>
                    </div>

                    <div class="blit-detail-mabda site-bg-main-color-before">
                        <div class="blit-detail-mabda-city">
                            <span><?php echo $route['DestiCity'] ?>
                                <i><?php  $Airport = functions::NameCityForeign($route['DestiAirportIata']);
                                    echo $Airport['AirportFa'];
                                    ?></i>
                            </span>
                            <span>
                                <?php echo functions::format_hour($route['ArrivalTime']) ?>
                                <i><?php $FormatDate = functions::OtherFormatDate(str_replace('/', '-', $route['ArrivalDate']));
                                    echo $FormatDate['NowDay'] ?></i>
                            </span>
                        </div>
                    </div>
                    </div>
                </div>
            <?php }
            foreach ($RoutReturnArray as $keyRouteReturn => $route) {
                ?>
                <div class="blit-detail-foreign-bargasht">
                    <?php
                    if (substr($route['Transit'], 0, 7) != "0:00:00" && !empty($route['Transit'])) { ?>
                        <div class="blit-detail-foreign-tavaghof">
                            <span>
                                توقف در
                                <?php
                                $city = functions::NameCityForeign($route['OriginAirportIata']);
                                echo !empty($route['Departure']['City']) ? $city['DepartureCityFa'] : $city['DepartureCityFa'] . ' ( ' . $city['AirportFa'] . ' ) '
                                ?>
                            </span>

                            <span>
                            <?php
                            $Transit = explode(':', $route['Transit']);
                            echo (($Transit[0] > '0') ? $Transit[0] . 'روز و' : ' ') . $Transit[1] . ' ' . 'ساعت و' . ' ' . $Transit[2] . 'دقیقه';
                            ?>
                            </span>
                        </div>
                        <?php
                    }
                    ?>
                <?php if ($keyRouteReturn == '0') { ?>
                    <h1 class="TitleDetailTicket site-bg-main-color-before">بلیط برگشت </h1>
                <?php } ?>
                <div class="blit-detail-foreign-item">
                    <div class="blit-detail-airline">

                        <div class="blit-detail-airline-left">
                            <span>شماره پرواز : <?php echo $route['FlightNumber'] ?></span>
                            <span>هواپیما  :<?php echo $route['AirlineName'] ?>
                    </span>
                        </div>
                        <img src="<?php echo functions::getAirlinePhoto($route['Airline_IATA']) ?>" alt="">

                    </div>


                    <div class="blit-detail-mabda site-bg-main-color-before">
                        <div class="blit-detail-mabda-city">
                            <span><?php echo $route['OriginCity'] ?>
                                <i><?php  $Airport = functions::NameCityForeign($route['OriginAirportIata']);
                                    echo $Airport['AirportFa'];
                                    ?></i>
                            </span>
                            <span><?php echo functions::format_hour($route['Time']) ?>
                                <i><?php $FormatDate = functions::OtherFormatDate(str_replace('/', '-', $route['Date']));
                                    echo $FormatDate['NowDay'] ?></i>
                            </span>
                        </div>
                    </div>

                    <div class="blit-detail-mabda site-bg-main-color-before">
                        <div class="blit-detail-mabda-city">
                            <span><?php echo $route['DestiCity'] ?>
                                <i><?php  $Airport = functions::NameCityForeign($route['DestiAirportIata']);
                                    echo $Airport['AirportFa'];
                                    ?></i>
                            </span>
                            <span>
                                <?php echo functions::format_hour($route['ArrivalTime']) ?>
                                <i><?php $FormatDate = functions::OtherFormatDate(str_replace('/', '-', $route['ArrivalDate']));
                                    echo $FormatDate['NowDay'] ?></i>
                            </span>
                        </div>
                    </div>
                </div>
                </div>
                <?php }
                ?>

            <div class="blit-detail-price">
                <span>قیمت بلیط <?php echo $DetailTicket['IsInternalFlight'] == '1' ? (($direction == 'dept') ? 'رفت' : 'برگشت') : '' ?>
                    : </span>

                <span><?php $Price = functions::setPriceChanges($ResultTicketDetail[$direction]['Airline_IATA'], $ResultTicketDetail[$direction]['FlightType'], $ResultTicketDetail[$direction]['AdtPrice'],$ResultTicketDetail[$direction]['AdtFare'],$ResultTicketDetail[$direction]['AdtPrice'], ($TypeZoneFlight == 'Local') ? 'Local' : 'Portal', strtolower($ResultTicketDetail[$direction]['FlightType']) == 'system' ? '' : 'public',$ResultTicketDetail[$direction]['SourceID']);

                    $PriceExplode = explode(':', $Price);
                    if (strtolower($PriceExplode[2]) == 'yes') {
                        echo number_format($PriceExplode[0]) . ' ' . 'ریال';
                    } else {
                        echo number_format($PriceExplode[1]) . ' ' . 'ریال';
                    }
                    ?></span>
            </div>
            <?php

        } else {
            ?>
            <div class="dakheli">
            <div class="blit-detail-airline">

                <div class="blit-detail-airline-left">
                    <h1 class="TitleDetailTicket site-bg-main-color-before">
                        بلیط <?php echo(($direction == 'TwoWay') ? 'دو طرفه' : ($direction == 'dept' ? 'رفت' : 'برگشت')) ?></h1>
                    <span>شماره پرواز : <?php echo $ResultTicketDetail[$direction]['FlightNumber'] ?></span>
                    <span>هواپیما  :<?php echo functions::AirPlaneType($ResultTicketDetail[$direction]['AirlineName']) ?>
                    </span>
                </div>
                <img src="<?php echo functions::getAirlinePhoto($ResultTicketDetail[$direction]['Airline_IATA']) ?>"
                     alt="">
            </div>

            <div class="blit-detail-mabda site-bg-main-color-before">
                <div class="blit-detail-mabda-city">
                    <span><?php echo $ResultTicketDetail[$direction]['OriginCity'] ?></span>
                    <span><?php $FormatDate = functions::OtherFormatDate(str_replace('/', '-', $ResultTicketDetail[$direction]['Date']));
                        echo $FormatDate['NowDay'] ?>
                        - ساعت <?php echo functions::format_hour($ResultTicketDetail[$direction]['Time']) ?></span>
                </div>
            </div>

            <div class="blit-detail-mabda site-bg-main-color-before">
                <div class="blit-detail-mabda-city">
                    <span><?php echo $ResultTicketDetail[$direction]['DestiCity'] ?></span>
                    <span><?php $FormatDate = functions::OtherFormatDate(str_replace('/', '-', $ResultTicketDetail[$direction]['Date']));
                        echo $FormatDate['NowDay'] ?>
                        - ساعت<?php echo functions::format_hour_arrival($ResultTicketDetail[$direction]['OriginAirportIata'], $ResultTicketDetail[$direction]['DestiAirportIata'], $ResultTicketDetail[$direction]['Time']); ?></span>
                </div>
            </div>

            <div class="blit-detail-price">
                <span>قیمت بلیط <?php echo $DetailTicket['IsInternalFlight'] == '1' ? (($direction == 'dept') ? 'رفت' : 'برگشت') : '' ?>
                    : </span>

                <span><?php $Price = functions::setPriceChanges($ResultTicketDetail[$direction]['Airline_IATA'], $ResultTicketDetail[$direction]['FlightType'], $ResultTicketDetail[$direction]['AdtPrice'], ($TypeZoneFlight == 'Local') ? 'Local' : 'Portal', strtolower($ResultTicketDetail[$direction]['FlightType']) == 'system' ? '' : 'public');

                    $PriceExplode = explode(':', $Price);
                    if (strtolower($PriceExplode[2]) == 'yes') {
                        echo number_format($PriceExplode[0]) . ' ' . 'ریال';
                    } else {
                        echo number_format($PriceExplode[1]) . ' ' . 'ریال';
                    }
                    ?></span>
            </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>