<div class="blit-info-detail">
    <div class="blit-info-detail-inner">
        <?php
        foreach ($ResultTicketDetail as $direction => $DetailTicket) {
            if ($DetailTicket['IsInternalFlight'] == '0') {
                $DataRouteDetail = $TicketDetail->DetailRoutesTemporary($DetailTicket['id']);

                $RoutReturn = functions::array_filter_by_value($DataRouteDetail,'TypeRoute','Return');

                $key=0;
                foreach ($RoutReturn as $routeReturn)
                {
                    $RoutReturnArray[$key] = $routeReturn ;
                    $key++;
                }
            }

            $SourceIDDirection[$direction] = $DetailTicket['SourceID'];
            $SourceIDTicket = json_encode($SourceIDDirection, true);
            ?>
            <input type="hidden" id="SourceID" name="SourceID" value='<?php echo $SourceIDTicket ?>'>
            <?php
            if(isset($DataRouteDetail) && !empty($DataRouteDetail))
            {
                ?>
                <div class="blit-info-detail-inner rafto-bargasht-info-detail">
                    <div class="blit-info-detail-info">
                        <div class="b-i-d-destination"><?php echo $DataRouteDetail[0]['OriginCity'] ?>
                            به <?php echo   !empty($RoutReturn) ? $RoutReturnArray[0]['OriginCity']: $DataRouteDetail[count($DataRouteDetail)-1]['DestiCity'] ?>
                            <span>(<?php echo $DataRouteDetail[0]['AirlineName'] ?>
                                - <?php echo $DataRouteDetail[0]['FlightNumber'] ?>)</span>
                        </div>

                        <?php if(!empty($RoutReturn)){?>
                        <div class="b-i-d-destination"><?php echo $RoutReturnArray[0]['OriginCity'] ?>
                            به <?php echo    $DataRouteDetail[0]['OriginCity'] ?>
                            <span>(<?php echo $RoutReturnArray[0]['AirlineName'] ?>
                                - <?php echo $RoutReturnArray[0]['FlightNumber'] ?>)</span>
                        </div>
                <?php }?>

<!--                        <div class="b-i-d-time">-->
<!--                                <span>--><?php //$FormatDate = functions::OtherFormatDate(str_replace('/', '-', $DataRouteDetail[0]['Date']));
//                                    echo $FormatDate['NowDay'] ?><!-- </span>-->
<!--                            <span>ساعت --><?php //echo functions::format_hour($DataRouteDetail[0]['Time']) ?><!--</span>-->
<!--                        </div>-->
                    </div>
                </div>
                <?php
            }else{
                ?>
                <div class="blit-info-detail-inner rafto-bargasht-info-detail">
                    <div class="blit-info-detail-info">
                        <div class="b-i-d-destination"><?php echo functions::NameCity($ResultTicketDetail[$direction]['OriginAirportIata']); ?>
                            به <?php echo functions::NameCity($ResultTicketDetail[$direction]['DestiAirportIata']); ?>
                            <span>(<?php echo $ResultTicketDetail[$direction]['AirlineName'] ?>
                                - <?php echo $ResultTicketDetail[$direction]['FlightNo'] ?>)</span>
                        </div>
                        <div class="b-i-d-time">
                                <span><?php $FormatDate = functions::OtherFormatDate(str_replace('/', '-', $ResultTicketDetail[$direction]['Date']));
                                    echo $FormatDate['NowDay'] ?> </span>
                            <span>ساعت <?php echo functions::format_hour($ResultTicketDetail[$direction]['Time']) ?></span>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>


        <?php } ?>

        <div class="blit-info-detail-btn site-border-main-color">
            <a class="link popup-open site-main-text-color" href="#" data-popup=".popup-blit-info" href="#">جزییات</a>
        </div>
    </div>
</div>