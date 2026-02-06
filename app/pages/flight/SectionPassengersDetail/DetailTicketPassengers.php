<div class="popup popup-blit-info">
    <div class="block">
        <span>جزییات بلیط</span>
        <!-- Close Popup -->

        <div class="head-pop-fix">
            <span>جزییات بلیط</span>
            <a class="link popup-close" href="#">بستن</a>
        </div>


        <?php foreach ($ResultTicketDetail as $direction => $DetailTicket) {

            if($DetailTicket['IsInternalFlight']=='0')
            {
                $DetailRouteForeign = $TicketDetail->DetailRoutesTemporary($DetailTicket['id']);
                foreach ($DetailRouteForeign as $route)
                {
                ?>
                    <div class="blit-detail-inner">
                        <div class="blit-detail-airline">
                            <div>
                            <?php  if (substr($route['Transit'], 0, 7) != "0:00:00" && !empty($route['Transit'])) {?>

                                <span>
                        <?php
                        $city = functions::NameCityForeign($route['OriginAirportIata']);
                        echo 'توقف در'.'&nb'.!empty($route['Departure']['City']) ? $city['DepartureCityFa'] : $city['DepartureCityFa'] . '(' . $city['AirportFa'] . ')'
                        ?>
                    </span>
                                <span>
                        <?php
                        $Transit = explode(':', $route['Transit']);
                        echo (($Transit[0] > '0') ? $Transit[0] . 'روز و' : ' ') . $Transit[1] . ' ' . 'ساعت و' . ' ' . $Transit[2] . 'دقیقه';
                        ?>

                    </span>
                                <?php
                            }?>
                        </div>
                            <div class="blit-detail-airline-left">
                                <span>شماره پرواز : <?php echo $route['FlightNumber'] ?></span>
                                <span>هواپیمایی <?php echo $route['AirlineName'] ?></span>
                                <span>مقدار بار مجاز <?php echo($route['BaggageType'] == 'Piece' ? ' 20 کیلوگرم' : ($route['BaggageType'] == '0' ? '8کیلوگرم فقط در کابین' : $route['Baggage'] . 'کیلوگرم')) ?></span>
                                <span>مدت پرواز:<?php
                                    $LongTime = explode(':', $route['LongTime']);
                                    echo (($LongTime[0] > '0') ? $LongTime[0] . 'روز و' : ' ') . $LongTime[1] . ' ' . 'ساعت و' . ' ' . $LongTime[2] . 'دقیقه';
                                     ?> </span>
                            </div>
                            <img src="<?php echo functions::getAirlinePhoto($ResultTicketDetail[$direction]['Airline_IATA']) ?>"
                                 alt="">
                        </div>

                        <div class="blit-detail-mabda site-bg-main-color-before">
                            <div class="blit-detail-mabda-city">
                                <span><?php echo $route['OriginCity'] ?></span>
                                <span><?php echo $route['Time'] ?></span>
                            </div>
                            <span><?php $FormatDate = functions::OtherFormatDate(str_replace('/', '-', $route['Date']));
                                echo $FormatDate['NowDay'] ?></span>
                        </div>

                        <div class="blit-detail-mabda site-bg-main-color-before">
                            <div class="blit-detail-mabda-city">
                                <span><?php echo $route['DestiCity'] ?></span>
                                <span><?php echo $route['ArrivalTime'] ?></span>
                            </div>
                            <span><?php $FormatDate = functions::OtherFormatDate(str_replace('/', '-', $route['ArrivalDate']));
                                echo $FormatDate['NowDay'] ?></span>
                        </div>

                <?php }?>
                        <div class="blit-detail-price">
                            <span>قیمت:</span>
                            <span><?php $Price = functions::setPriceChanges($ResultTicketDetail[$direction]['Airline_IATA'], $ResultTicketDetail[$direction]['FlightType'], $ResultTicketDetail[$direction]['AdtPrice'], ($FlightZone == 'Local') ? 'Local' : 'Portal', strtolower($ResultTicketDetail[$direction]['FlightType']) == 'system' ? '' : 'public');

                                $PriceExplode = explode(':', $Price);
                                echo number_format($PriceExplode[0]) . ' ' . 'ریال'; ?></span>
                        </div>
                    </div>
                <?php

            }else{
                ?>
                <div class="blit-detail-inner">
                    <div class="blit-detail-airline">

                        <div class="blit-detail-airline-left">
                            <span>شماره پرواز : <?php echo $ResultTicketDetail[$direction]['FlightNo'] ?></span>
                            <span>هواپیما <?php echo functions::AirPlaneType($ResultTicketDetail[$direction]['AirlineName']) ?></span>
                            <span>کلاس نرخی <?php echo $ResultTicketDetail[$direction]['CabinType'] ?></span>
                            <span>مقدار بار مجاز 20 کیلو گرم</span>
                            <span>مدت پرواز:<?php $TimeLongFlight = functions::LongTimeFlightHours($ResultTicketDetail[$direction]['OriginAirportIata'], $ResultTicketDetail[$direction]['DestiAirportIata']);
                                echo $TimeLongFlight['Hour'] . 'ساعت' . ' ' . $TimeLongFlight['Minutes'] . 'دقیقه' ?> </span>
                        </div>
                        <img src="<?php echo functions::getAirlinePhoto($ResultTicketDetail[$direction]['Airline_IATA']) ?>"
                             alt="">
                    </div>
                    <div class="blit-detail-mabda site-bg-main-color-before">
                        <div class="blit-detail-mabda-city">
                            <span><?php echo $ResultTicketDetail[$direction]['OriginCity'] ?></span>
                            <span><?php echo functions::format_hour($ResultTicketDetail[$direction]['Time']) ?></span>
                        </div>
                        <span><?php $FormatDate = functions::OtherFormatDate(str_replace('/', '-', $ResultTicketDetail[$direction]['Date']));
                            echo $FormatDate['NowDay'] ?></span>
                    </div>
                    <div class="blit-detail-mabda site-bg-main-color-before">
                        <div class="blit-detail-mabda-city">
                            <span><?php echo $ResultTicketDetail[$direction]['DestiCity'] ?></span>
                            <span><?php echo functions::format_hour_arrival($ResultTicketDetail[$direction]['OriginAirportIata'], $ResultTicketDetail[$direction]['DestiAirportIata'], $ResultTicketDetail[$direction]['Time']) ?></span>
                        </div>
                        <span><?php $FormatDate = functions::OtherFormatDate(str_replace('/', '-', $ResultTicketDetail[$direction]['Date']));
                            echo $FormatDate['NowDay'] ?></span>
                    </div>
                    <div class="blit-detail-price">
                        <span>قیمت:</span>
                        <span><?php $Price = functions::setPriceChanges($ResultTicketDetail[$direction]['Airline_IATA'], $ResultTicketDetail[$direction]['FlightType'], $ResultTicketDetail[$direction]['AdtPrice'], ($FlightZone == 'Local') ? 'Local' : 'Portal', strtolower($ResultTicketDetail[$direction]['FlightType']) == 'system' ? '' : 'public');

                            $PriceExplode = explode(':', $Price);
                            echo number_format($PriceExplode[0]) . ' ' . 'ریال'; ?></span>
                    </div>
                </div>

                <?php
            }
            ?>



        <?php } ?>





    </div>
</div>