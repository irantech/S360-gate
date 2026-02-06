<?php

//error_reporting(0);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');

require '../../../config/bootstrap.php';
require LIBRARY_DIR . 'Load.php';
require CONFIG_DIR . 'config.php';
spl_autoload_register(array('Load', 'autoload'));

$objAppHotelLocal = Load::controller('appHotelLocal');
$bookList = $objAppHotelLocal->userBuyReport();
?>
<div class="page" data-page="blit-info-1">

    <div class="page-content">
        <div class="nav-info site-bg-main-color">
            <div class="nav-info-inner">
                <div class="back-link">
                    <a href="#" class="link back">
                        <span></span>
                    </a>
                </div>
                <div class="title">سوابق خرید هتل</div>
            </div>
        </div>
        <div class="blit-info-page">

            <div>
                <?php foreach ($bookList as $key => $buy) {

                    $serviceType = functions::TypeServiceHotel($buy['type_application']);
                    ?>
                    <div class="blit-item savabegh-item hotel-savabegh site-border-main-color">

                        <div class="blit-i-info">
                            <div class="blit-i-info-top">
                                <div class="blit-i-city">
                                    <span><?php echo $buy['hotel_name'] ?> <i>( <?php echo $buy['number_night']; ?> شب ) </i></span>
                                </div>
                            </div>
                        </div>

                        <div class="blit-i-bottom savabegh-kharid-item">
                            <div class="savabegh-faktor">
                                <span>تاریخ ورود به هتل</span>
                                <span><?php echo $buy['start_date']; ?></span>
                            </div>
                            <div class="savabegh-price">
                                <span>قیمت</span>
                                <span>
                                    <?php
                                    $price = functions::calcDiscountCodeByFactor($buy['total_price'], $buy['factor_number']);
                                    echo number_format($price);
                                    ?> ریال
                                </span>
                            </div>
                            <div class="savabegh-faktor">
                                <span>شماره فاکتور</span>
                                <span><?php echo $buy['factor_number'] ?></span>
                            </div>
                            <div class="savabegh-date">
                                <span>تاریخ خرید</span>
                                <span><?php echo dateTimeSetting::jdate('Y-m-d H:i:s', $buy['creation_date_int']) ?></span>
                            </div>
                            <div class="savabegh-btns   <?php if ($buy['status'] == 'PreReserve' && ($buy['type_application'] == 'reservation_app' || $buy['type_application'] == 'api_app')){ ?> savabegh-btns-2 <?php } ?> ">
                                <?php if ($buy['status'] == 'PreReserve' && ($buy['type_application'] == 'reservation_app' || $buy['type_application'] == 'api_app')){ ?>
                                    <a class="site-border-main-color site-main-text-color goBankForHotelOnRequest"
                                       factorNumber="<?php echo $buy['factor_number'] ?>"
                                       serviceType="<?php echo $serviceType ?>">پرداخت</a>
                                    <?php
                                }
                                ?>
                                <a class="site-bg-main-color viewHotelBookingInformation"
                                   factorNumber="<?php echo $buy['factor_number'] ?>">مشاهده</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>


            </div>

        </div>

    </div>
</div>
