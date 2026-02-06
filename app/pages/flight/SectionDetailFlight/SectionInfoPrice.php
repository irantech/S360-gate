<?php
$DetailPrice= functions::CalculatePriceDetailApp($DetailTicket['uniq_id']);

//                                 echo Load::plog($DetailPrice);

foreach ($ResultTicketDetail as $direction=>$DetailTicket){
    ?>
    <div class="blit-price-detail">
        <span class="blit-price-detail-title">جزئیات بلیط <?php echo (($direction == 'TwoWay')? 'دو طرفه' : ($direction == 'dept' ? 'رفت' : 'برگشت')) ?></span>
        <div>
            <span>قیمت بزرگسال</span>
            <span><?php  echo number_format($DetailPrice['AdtPrice'][$direction]);?>ریال</span>
        </div>
        <?php if($DetailTicket['Chd_qty'] > 0){?>
            <div>
                <span>قیمت کودک</span>
                <span><?php  echo number_format($DetailPrice['ChdPrice'][$direction]);?>ریال</span>
            </div>
        <?php }
        if($DetailTicket['Inf_qty'] > 0){?>
            <div>
                <span>قیمت نوزاد</span>
                <span><?php  echo number_format($DetailPrice['InfPrice'][$direction]);?>ریال</span>
            </div>
        <?php }

        ?>

    </div>
    <?php

    if($DetailTicket['IsInternalFlight']=='1')
    {
        $Fee= functions::cancelingRulesApp($DetailTicket['Airline_IATA'],$DetailTicket['CabinType']);

        if($DetailTicket['FlightType']=='system')
        {
            ?>
            <div class="blit-price-cancel">
                <span class="blit-price-detail-title">جزئیات نرخ کنسلی بلیط <?php echo ($direction=='dept') ? 'رفت':'برگشت'; ?></span>
                <div>
                    <span>کلاس پروازی<span><?php echo $DetailTicket['CabinType']?></span> </span>
                </div>
                <div>
                    <span>تا 12 ظهر 3 روز قبل از پرواز</span>
                    <span><?php  echo is_numeric($Fee['ThreeDaysBefore']) ? $Fee['ThreeDaysBefore'] . '% جریمه' : $Fee['ThreeDaysBefore']; ?></span>
                </div>
                <div>
                    <span>تا 12 ظهر 1 روز قبل از پرواز</span>
                    <span><?php echo is_numeric($Fee['OneDaysBefore']) ? $Fee['OneDaysBefore'] . '% جریمه' : $Fee['OneDaysBefore']; ?></span>
                </div>
                <div>
                    <span>تا 3 ساعت قبل از پرواز</span>
                    <span><?php echo is_numeric($Fee['ThreeHoursBefore']) ? $Fee['ThreeHoursBefore'] . '% جریمه' : $Fee['ThreeHoursBefore']; ?></span>
                </div>
                <div>
                    <span>تا 30 دقیقه قبل از پرواز</span>
                    <span><?php echo is_numeric($Fee['ThirtyMinutesAgo']) ? $Fee['ThirtyMinutesAgo'] . '% جریمه' : $Fee['ThirtyMinutesAgo']; ?></span>
                </div>
                <div>
                    <span>از 30 دقیقه قبل پرواز به بعد</span>
                    <span><?php echo is_numeric($Fee['OfThirtyMinutesAgoToNext']) ? $Fee['OfThirtyMinutesAgoToNext'] . '% جریمه' : $Fee['OfThirtyMinutesAgoToNext']; ?></span>
                </div>
            </div>
            <?php
        }else{
            ?>

            <div class="blit-price-cancel">
                <span class="blit-price-detail-title">جزئیات نرخ کنسلی بلیط <?php echo ($direction=='dept') ? 'رفت':'برگشت'; ?></span>
                <div>
                    <span>کلاس پروازی<span><?php echo $DetailTicket['CabinType']?></span></span>
                </div>
                <div>
                    <span>قوانین كنسلی پروازهای چارتری بر اساس تفاهم چارتر كننده و سازمان هواپیمایی كشوری می باشد</span>
                </div>
            </div>

            <?php
        }
    }


}
?>