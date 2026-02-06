<?php
require '../../../config/bootstrap.php';
require LIBRARY_DIR . 'Load.php';
require CONFIG_DIR . 'config.php';
spl_autoload_register(array('Load', 'autoload'));


$factorNumber = filter_var($_GET['factorNumber'], FILTER_SANITIZE_STRING);
$objAppHotelLocal = Load::controller('appHotelLocal');
$infoBook = $objAppHotelLocal->getInfoHotelBook($factorNumber);
?>
<div class="page" data-page="ruls">

    <div class="page-content">
        <div class="nav-info">
            <div class="nav-info-inner site-bg-main-color">
                <div class="back-link">
                    <a href="#" class="link back">
                        <span></span>
                    </a>
                </div>
                <div class="title">اطلاعات رزرو هتل</div>
            </div>
        </div>
        <div class="blank-page">


            <!--<div class="view-blit-download">
                <a class="dlTicket" factorNumberPdf="<?php /*echo $factorNumber */ ?>" class="item-content item-link" >مشاهده و دانلود PDF</a>
            </div>-->


            <div class="blit-item hotel-history site-border-main-color view-blit">

                <div class="blit-i-info">
                    <div class="blit-i-info-top">
                        <div class="blit-i-city">
                            <span><?php echo $infoBook[0]['hotel_name'] ?></span>
                        </div>
                    </div>
                </div>

                <div class="blit-i-bottom savabegh-kharid-item">
                    <div class="savabegh-price">
                        <span>تاریخ ورود به هتل</span>
                        <span><?php echo $infoBook[0]['start_date']; ?></span>
                    </div>
                    <div class="savabegh-price">
                        <span>مدت اقامت</span>
                        <span><?php echo $infoBook[0]['number_night']; ?> شب </span>
                    </div>
                    <div class="savabegh-price">
                        <span>شماره فاکتور</span>
                        <span><?php echo $factorNumber; ?></span>
                    </div>
                    <div class="savabegh-price">
                        <span>قیمت</span>
                        <span>
                            <?php
                            $price = functions::calcDiscountCodeByFactor($infoBook[0]['total_price'], $infoBook[0]['factor_number']);
                            echo number_format($price);
                            ?> ریال
                        </span>
                    </div>
                    <div class="savabegh-date">
                        <span>تاریخ خرید</span>
                        <span><?php echo dateTimeSetting::jdate('Y-m-d H:i:s', $infoBook[0]['creation_date_int']) ?></span>
                    </div>
                </div>

                <?php
                $countPassengerRegister = 0;
                foreach ($infoBook as $info) {
                    if ($info['passenger_name'] != '') {
                        $countPassengerRegister++;
                        ?>
                        <div class="blit-i-bottom view-blit-info">
                            <div class="view-blit-name view-blit-info-item">
                                <span>اتاق: </span><span><?php echo $info['room_name'] ?></span>
                            </div>
                            <div class="view-blit-parvaz-num view-blit-info-item">
                                <span>نام و نام خانوادگی: </span><span><?php echo $info['passenger_name'] . ' ' . $info['passenger_family'] ?></span>
                            </div>
                            <div class="view-blit-parvaz-num view-blit-info-item">
                                <span>شماره ملی/پاسپورت: </span><span><?php echo (!empty($info['passenger_national_code'])) ? $info['passenger_national_code'] : $info['passportNumber'] ?></span>
                            </div>
                            <div class="view-blit-parvaz-num view-blit-info-item">
                                <span>تاریخ تولد: </span><span><?php echo (!empty($info['passenger_birthday'])) ? $info['passenger_birthday'] : $info['passenger_birthday_en'] ?></span>
                            </div>
                        </div>
                        <?php
                    }
                }

                // اگر برای هتل رزرواسیون اسامی مسافران را وارد نکرده بود؛ اطلاعات سرپرست را نمایش بده //
                if ($countPassengerRegister == 0){
                    ?>
                    <div class="blit-i-bottom view-blit-info">
                        <div class="view-blit-name view-blit-info-item">
                            <span>سرپرست مسافران</span>
                        </div>
                        <div class="view-blit-parvaz-num view-blit-info-item">
                            <span>نام و نام خانوادگی: </span><span><?php echo $info['passenger_leader_fullName'] ?></span>
                        </div>
                        <div class="view-blit-parvaz-num view-blit-info-item">
                            <span>تلفن: </span><span><?php echo $info['passenger_leader_tell'] ?></span>
                        </div>
                    </div>
                    <?php
                }
                ?>

            </div>


        </div>
    </div>
</div>
