<?php
error_reporting(0);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');


require '../../../config/bootstrap.php';
require LIBRARY_DIR . 'Load.php';

$RequestNumber = json_decode($_GET['RequestNumber'], true);

$factorNumber = $_GET['factorNumber'] ;
$TicketDetail = Load::controller('TicketDetailApp');
$ResultTicketDetail = $TicketDetail->infoBookByFactorNumber($factorNumber);


if (isset($RequestNumber['dept']) && !empty($RequestNumber['dept'])) {
    $DataRequestNumber['dept'] = $RequestNumber['dept'];
}

if (isset($RequestNumber['return']) && !empty($RequestNumber['return'])) {
    $DataRequestNumber['return'] = $RequestNumber['return'];
}

if (isset($RequestNumber['TwoWay']) && !empty($RequestNumber['TwoWay'])) {
    $DataRequestNumber['TwoWay'] = $RequestNumber['TwoWay'];
}

$RequestNumberTicketFactor = isset($DataRequestNumber['dept']) ? $DataRequestNumber['dept'] : $DataRequestNumber['TwoWay'];
$RequestNumberTicket = json_encode($DataRequestNumber, true);
$ResultTicketBook = $TicketDetail->ShowDetailTicketBook($RequestNumberTicketFactor);

$AdtPriceTotal = '0';
$ChdPriceTotal = '0';
$InfPriceTotal = '0';
$PriceTotal = '0';
$SourceIDDirection = '';
$SourceIDTicket = '';
?>
<div class="page" data-page="blit-info-1">
    <input type="hidden" name="Uniq_id" id="Uniq_id"
           value="<?php echo !empty($_GET['Uniq_id']) ? $_GET['Uniq_id'] : '' ?>">
    <input type="hidden" name="TypeZoneFlightDetail" id="TypeZoneFlightDetail"
           value="<?php echo !empty($FlightZone) ? $FlightZone : '' ?>">
    <input type="hidden" name="AdultCount" id="AdultCount"
           value="<?php echo $AdultCount ?>">
    <input type="hidden" name="ChildCount" id="ChildCount"
           value="<?php echo $ChildCount ?>">
    <input type="hidden" name="InfantCount" id="InfantCount"
           value="<?php echo $InfantCount ?>">
    <input type="hidden" name="IdMember" id="IdMember"
           value="<?php echo Session::getUserId(); ?>">
    <input type="hidden" name="RequestNumber" id="RequestNumber"
           value='<?php echo $RequestNumberTicket ?>'>


    <div class="page-content">
        <div class="nav-info site-bg-main-color">
            <div class="nav-info-inner">
                <div class="back-link">
                    <a href="#" class="link back">
                        <span></span>
                    </a>
                </div>
                <div class="title">پیش فاکتور</div>
            </div>
        </div>
        <div class="blit-info-page">

            <div class="passenger-info-detail">
                <?php foreach ($ResultTicketDetail[$TicketDetail->direction] as $key => $book) { ?>
                    <div class="passenger-info-item passenger-1">
                    <span> مسافر <?php echo functions::ConvertNumberToAlphabet($key + 1, 'App') ?>
                        <i>(<?php if ($book['passenger_age'] == 'Adt') {
                                echo 'بزرگسال';
                            } else if ($book['passenger_age'] == 'Chd') {
                                echo 'کودک';
                            } else if ($book['passenger_age'] == 'Inf') {
                                echo 'نوزاد';
                            } ?>)</i></span>
                        <ul>
                            <li>
                                <span>نام و نام خانوادگی</span>
                                <span><?php echo $book['passenger_name'] . ' ' . $book['passenger_family'] ?></span>
                                <span><?php echo '(' . $book['passenger_name_en'] . ' ' . $book['passenger_family_en'] . ')' ?></span>
                            </li>
                            <li>
                                <span>تاریخ تولد</span>
                                <span><?php echo $book['passenger_national_code'] == '0000000000' ? $book['passenger_birthday_en'] : $book['passenger_birthday'] ?></span>
                            </li>
                            <li>
                                <span>کد ملی</span>
                                <span><?php echo $book['passenger_national_code'] == '0000000000' ? $book['passportNumber'] : $book['passenger_national_code'] ?></span>
                            </li>
                            <li>
                                <span>قیمت بلیط</span>
                                <span><?php

                                        echo number_format(functions::CalculatePriceOnePersonApp($factorNumber,($book['passenger_national_code'] == '0000000000') ? $book['passportNumber'] : $book['passenger_national_code']));
                                    ?>ریال</span>
                            </li>
                        </ul>
                    </div>

                    <?php

                    $serviceTitle[$book['direction']] = $book['serviceTitle'];

                }


                $serviceTitleJson = json_encode($serviceTitle, true);

                if (isset($serviceTitle['dept']) && !empty($serviceTitle['dept'])) {
                    $serviceTitle['dept'] = $serviceTitle['dept'];
                }

                if (isset($serviceTitle['return']) && !empty($serviceTitle['return'])) {
                    $serviceTitle['return'] = $serviceTitle['return'];
                }

                if (isset($serviceTitle['TwoWay']) && !empty($serviceTitle['TwoWay'])) {
                    $serviceTitle['TwoWay'] = $serviceTitle['TwoWay'];
                }
                ?>
                <input type="hidden" name="serviceType" id="serviceType" value='<?php echo $serviceTitleJson ?>'>
            </div>



            <div class="terms-and-conditions">
                <p>

                    خرید بلیط از ما به منزله قبول تمامی
                    <a href="#" target="_blank" onclick="return false">قوانین و مقرررات</a>
                    ما می باشد
                </p>
            </div>
            <?php
            if (functions::TypeUser(Session::getUserId()) == 'Ponline') {
                ?>
                <!--            <div class="terms-and-conditions">-->
                <!--                <p><label class="checkbox"><input type="checkbox" id="CheckDiscountCode"><i class="icon-checkbox"></i></label>کد تخفیف دارم، می خواهم از آن استفاده کنم</p>-->
                <!--            </div>-->

                <div class="off-code">
                            <span><input type="text" id="discount-code" class="form-control"
                                         placeholder="کد تخفیف خود را وارد کنید"></span>
                    <span><button type="button" class="discount-code-btn" name="DiscountCodeButton"
                                  id="DiscountCodeButton1"
                                  onclick='setDiscountCode(<?php echo $serviceTitleJson ?>, 0)'>بررسی و اعمال کد</button></span>
                </div>
                <?php
            }
            ?>



            <?php  $PriceTotal = functions::CalculateDiscount($factorNumber);?>

            <div class="price-section">
                <div class="total-price">
                    <span>قیمت کل :</span>
                    <input type="hidden" name="priceWithoutDiscountCode" id="priceWithoutDiscountCode"
                           value="<?php echo $PriceTotal ?>">
                    <span><?php echo number_format($PriceTotal) ?></span><i>ریال</i>
                </div>

                <div class="discountDiv myhidden">
                    <div class="total-price-off "></div>
                    <div class="total-price-pay">
                        <span class="discountText">مبلغ قابل پرداخت :</span>
                        <span class="discountPrice"></span><i>ریال</i>
                    </div>
                </div>

            </div>
            <div class="bottom-btn faktor-btns">
                <a href="<?php echo ROOT_ADDRESS_WITHOUT_LANG ?>/app/pages/ChooseBank.php?factorNumber=<?php echo $factorNumber ?>&requestNumberDept=<?php echo $DataRequestNumber['dept'] ?>&requestNumberReturn=<?php echo $DataRequestNumber['return'] ?>&requestNumberTwoWay=<?php echo $DataRequestNumber['TwoWay'] ?>&serviceTitleDept=<?php echo $serviceTitle['dept'] ?>&serviceTitleReturn=<?php echo $serviceTitle['return'] ?>&serviceTitleTwoWay=<?php echo $serviceTitle['TwoWay'] ?>&discountCode= &flag=check_credit&nameApplication=flight"
                   class="bot-btn site-bg-main-color site-bg-color-dock-border link external">
                    <span>پرداخت</span>
                    <i class="preloader color-white myhidden"></i>
                </a>
                <a href="<?php echo ROOT_ADDRESS_WITHOUT_LANG . '/app/' ?>"
                   class="bot-btn site-main-text-color site-bg-color-dock-border search-again external">
                    <span>جست و جو مجدد</span>
                    <i class="preloader color-white myhidden"></i>
                </a>
            </div>
        </div>


        <div class="popup popup-blit-info">
            <div class="block">
                <span>جزییات بلیط</span>
                <!-- Close Popup -->

                <div class="head-pop-fix">
                    <span>جزییات بلیط</span>
                    <a class="link popup-close" href="#">بستن</a>
                </div>


                <?php foreach ($ResultTicketDetail as $direction => $DetailTicket) {

                    if ($DetailTicket['IsInternalFlight'] == '0') {
                        $DetailRouteForeign = $TicketDetail->DetailRoutes($DetailTicket['id']);
                        foreach ($DetailRouteForeign as $route) {
                            ?>
                            <div class="blit-detail-inner">
                            <div class="blit-detail-airline">
                                <?php if (substr($route['Transit'], 0, 7) != "0:00:00" && !empty($route['Transit'])) { ?>

                                    <span>
                        <?php
                        $city = functions::NameCityForeign($route['OriginAirportIata']);
                        echo 'توقف در' . '&nb' . !empty($route['Departure']['City']) ? $city['DepartureCityFa'] : $city['DepartureCityFa'] . '(' . $city['AirportFa'] . ')'
                        ?>
                    </span>
                                    <span>
                        <?php
                        $Transit = explode(':', $route['Transit']);
                        echo (($Transit[0] > '0') ? $Transit[0] . 'روز و' : ' ') . $Transit[1] . ' ' . 'ساعت و' . ' ' . $Transit[2] . 'دقیقه';
                        ?>

                    </span>
                                    <?php
                                } ?>
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

                        <?php } ?>
                        <div class="blit-detail-price">
                            <span>قیمت:</span>
                            <span><?php $Price = functions::setPriceChanges($ResultTicketDetail[$direction]['Airline_IATA'], $ResultTicketDetail[$direction]['FlightType'], $ResultTicketDetail[$direction]['AdtPrice'], ($FlightZone == 'Local') ? 'Local' : 'Portal', strtolower($ResultTicketDetail[$direction]['FlightType']) == 'system' ? '' : 'public');

                                $PriceExplode = explode(':', $Price);
                                echo number_format($PriceExplode[0]) . ' ' . 'ریال'; ?></span>
                        </div>
                        </div>
                        <?php

                    } else {
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

    </div>
</div>
