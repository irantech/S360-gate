<?php

require '../../../config/bootstrap.php';
require LIBRARY_DIR . 'Load.php';
require CONFIG_DIR . 'config.php';
spl_autoload_register(array('Load', 'autoload'));

?>

<div class="page" data-page="blit-info-1">

    <?php
    $formData = !empty($_GET['formData']) ? $_GET['formData'] : '';
    $formData = json_decode($formData, true);
    $formData['typeApplication'] = $formData['typeApplication'] . '_app';
    $objResult = Load::controller('resultHotelLocal');
    $objFactor = Load::controller('factorHotelLocal');
    if ($formData['typeApplication'] == 'reservation_app') {
        $objFactor->registerPassengersReservationHotel($formData);
    } else {
        $objFactor->registerPassengersHotel($formData);
    }
    $objFactor->getPassengersHotel($formData);

    $serviceType = functions::TypeServiceHotel($formData['typeApplication']);
    ?>

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
        <div class="hotel-choosen">
            <div class="hotel-choosen-thumb">
                <img src="images/hotel-1.jpg" alt="">
            </div>
            <div class="hotel-choosen-info">
                <span class="hotel-choosen-name"><?php echo $objFactor->temproryHotel['hotel_name']; ?></span>
                <span class="hotel-choosen-star">نام هتل</span>
                <div class="hotel-choosen-adress">
                    <i>
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
						<g>
                            <path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035
						c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719
						c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z"/>
                        </g>
						</svg>
                    </i>
                    <span><?php echo $objFactor->temproryHotel['hotel_address']; ?></span></div>
                <div class="hotel-choosen-time">
                    <div class="hotel-vorood-time">
                        <span>تاریخ ورود :</span>
                        <span><?php echo $objFactor->temproryHotel['start_date']; ?></span>
                    </div>
                    <div class="hotel-khoroj-time">
                        <span>تاریخ خروج :</span>
                        <span><?php echo $objFactor->temproryHotel['end_date']; ?></span>
                    </div>
                    <div class="eghamat-time"><i>مدت اقامت :</i>
                        <span><?php echo $objFactor->temproryHotel['number_night']; ?> شب</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="hotel-passenger-page-info">
        <div class="blit-info-page">

            <!--<div class="count-down">
                <span>زمان باقی مانده</span>
                <div class="clockdiv" id="clockdiv2">
                    <div>
                        <span class="seconds"></span>
                        <div class="smalltext">ثانیه</div>
                    </div>
                    <div>
                        <span class="minutes"></span>
                        <div class="smalltext">دقیقه</div>
                    </div>
                </div>
            </div>-->

            <div class="passenger-info-detail">
                <?php
                $countPassengerRegister = 0;
                foreach ($objFactor->temproryHotel['passenger'] as $passenger) {
                    if ($passenger['passenger_name'] != ''){
                        $countPassengerRegister++;
                        ?>
                        <div class="passenger-info-item passenger-1">
                            <span><?php echo $passenger['room_name']; ?></span>
                            <ul>
                                <li>
                                    <span>سرپرست اتاق</span>
                                    <span><?php echo $passenger['passenger_name'] . ' ' . $passenger['passenger_family']; ?></span>
                                </li>
                                <li>
                                    <span>تاریخ تولد</span>
                                    <span><?php echo $passenger['passenger_birthday'] != '' ? $passenger['passenger_birthday'] : $passenger['passenger_birthday_en']; ?></span>
                                </li>
                                <li>
                                    <span>کد ملی</span>
                                    <span><?php echo $passenger['passenger_national_code'] != '' ? $passenger['passenger_national_code'] : $passenger['passportNumber']; ?></span>
                                </li>
                                <li>
                                    <span>قیمت</span>
                                    <span><?php echo number_format($objFactor->temproryHotel['room'][$passenger['room_id']]['room_price']); ?></span>
                                </li>
                            </ul>
                        </div>
                        <?php
                    }
                }

                // اگر برای هتل رزرواسیون اسامی مسافران را وارد نکرده بود؛ اطلاعات سرپرست را نمایش بده //
                if ($countPassengerRegister == 0){
                    ?>
                    <div class="passenger-info-item passenger-1">
                        <span>سرپرست مسافران</span>
                        <ul>
                            <li>
                                <span>نام و نام خانوادگی</span>
                                <span><?php echo $objFactor->temproryHotel['passenger_leader_fullName']; ?></span>
                            </li>
                            <li>
                                <span>تلفن</span>
                                <span><?php echo $objFactor->temproryHotel['passenger_leader_tell']; ?></span>
                            </li>
                        </ul>
                    </div>
                    <?php
                }
                ?>
            </div>
            <!--<div class="terms-and-conditions">
                <p>
                    <label class="checkbox">
                        <input type="checkbox" value="0" id="checkRule" name="checkRule">
                        <i class="icon-checkbox"></i>
                    </label>
                    <a href="#" target="_blank">قوانین و مقرررات</a> را میپذیرم
                </p>
            </div>-->
            <div class="terms-and-conditions">
                <p>رزرو هتل از ما به منزله قبول تمامی <a href="#" target="_blank" onclick="return false">قوانین و مقرررات</a> ما می باشد</p>
            </div>


            <?php
            if (Session::IsLogin() && functions::TypeUser(Session::getUserId()) == 'Ponline') {
                ?>
                <div class="off-code">
                    <span>
                        <input type="text" id="discount-code" class="form-control"
                               placeholder="کد تخفیف خود را وارد کنید">
                    </span>
                    <span>
                        <button type="button" class="discount-code-btn" onclick="setDiscountCode('<?php echo $serviceType?>', 0)">بررسی و اعمال کد</button>
                    </span>
                </div>
                <?php
            }
            ?>

            <div class="price-section">
                <div class="total-price">
                    <span>قیمت کل :</span>
                    <input type="hidden" name="priceWithoutDiscountCode" id="priceWithoutDiscountCode" value="<?php echo $objFactor->paymentPrice + $objFactor->paymentPriceOneDayTour; ?>">
                    <span><?php echo number_format($objFactor->paymentPrice + $objFactor->paymentPriceOneDayTour); ?><i>ریال</i></span>
                </div>

                <div class="discountDiv myhidden">
                    <div class="total-price-off"></div>
                    <div class="total-price-pay">
                        <span class="discountText">مبلغ قابل پرداخت :</span>
                        <span class="discountPrice"></span><i>ریال</i>
                    </div>
                </div>
            </div>

            <!--<div class="price-section">
                <div class="total-price">
                    <span>قیمت کل :</span>
                    <input type="hidden" name="priceWithoutDiscountCode" id="priceWithoutDiscountCode" value="<?php /*echo $objFactor->paymentPrice + $objFactor->paymentPriceOneDayTour; */?>">
                    <span><?php /*echo number_format($objFactor->paymentPrice + $objFactor->paymentPriceOneDayTour); */?><i>ریال</i></span>
                </div>

                <div class="discountDiv myhidden">
                    <div class="total-price-off">
                        <span>تخفیف :</span>
                        <span>0<i>ریال</i></span>
                    </div>

                    <div class="total-price-pay">
                        <span class="discountText">مبلغ قابل پرداخت :</span>
                        <span class="discountPrice">0<i>ریال</i></span>
                    </div>
                </div>
            </div>-->

            <div class="bottom-btn" id="btnPreReserve">
                <a onclick="preReserveHotel('<?php echo $formData['factorNumber']; ?>', '<?php echo $formData['typeApplication']; ?>')"
                   class="bot-btn site-bg-main-color">پرداخت</a>
            </div>

            <input type="hidden" id="total_price" name="total_price" value="">
            <input type="hidden" id="serviceType" name="serviceType" value="<?php echo $serviceType; ?>">
            <input type="hidden" name="factorNumber" id="factorNumber" value="<?php echo $formData['factorNumber']; ?>">
            <input type="hidden" name="timeConfirmHotel" id="timeConfirmHotel" value="">

            <div class="after-pay-sec displayN" id="alertForOnRequest">
                <div class="top-after-pay" id="alterRequest">
                    <!--<i class="success-icon"></i>
                    <span>کاربر گرامی درخواست هتل شما با موفقیت در سیستم ثبت شده است.</span>
                    <span>حداکثر تا 10 دقیقه دیگر نتیجه نهایی رزرو به شما اعلام می گردد.</span>-->
                </div>
                <div class="middle-after-pay">
                    <div class="text-after-pay displayN" id="alertOnRequestForCounter">
                        <!--<span>برای تکمیل خرید و پرداخت مبلغ رزرو از لینک پیگیری خرید هتل استفاده نمایید</span>-->
                    </div>
                    <div class="time-after-pay">
                        <span>زمان باقی مانده</span>
                        <div class="clockdiv" id="clockdiv">
                            <div>
                                <span class="seconds"></span>
                                <div class="smalltext">ثانیه</div>
                            </div>
                            <div>
                                <span class="minutes"></span>
                                <div class="smalltext">دقیقه</div>
                            </div>
                        </div>
                    </div>
                    <div class="faktor-after-pay">
                        <span>شماره فاکتور:</span>
                        <span><?php echo $formData['factorNumber']; ?></span>
                    </div>
                </div>
                <div class="bottom-after-pay" id="btnSearchInternalHotel">
                    <a href="/searchInternalHotel/">بازگشت</a>
                </div>
                <div class="bottom-after-pay displayN" id="btnHotelHistory">
                    <a href="/hotelHistory/">سوابق خرید هتل</a>
                </div>
            </div>


        </div>
        </div>

    </div>
</div>
