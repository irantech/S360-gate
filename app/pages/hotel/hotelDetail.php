<?php
//error_reporting(0);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');


require '../../../config/bootstrap.php';
require LIBRARY_DIR . 'Load.php';
require CONFIG_DIR . 'config.php';
spl_autoload_register(array('Load', 'autoload'));

$hotelId = !empty($_GET['hotelId']) ? $_GET['hotelId'] : '';
$typeApplication = !empty($_GET['typeApplication']) ? $_GET['typeApplication'] : '';
$startDate = !empty($_GET['startDate']) ? $_GET['startDate'] : '';
$endDate = !empty($_GET['endDate']) ? $_GET['endDate'] : '';
$nights = !empty($_GET['nights']) ? $_GET['nights'] : '';

$objResultHotelLocal = Load::controller('resultHotelLocal');
$objResultHotelLocal->getHotel($hotelId, $typeApplication);

$cityId = $objResultHotelLocal->SearchHotel['AddressInfo']['CityCode'];
$hotelStar = $objResultHotelLocal->SearchHotel['StarCode'];
if ($hotelStar > 5){ $hotelStar = '5'; }

$cityName = $objResultHotelLocal->getCity($cityId);

?>
<div class="page">
    <div class="sheet-modal-bg"></div>
    <div class="page-content hotel-detail ">
        <div class="nav-hotel-detail">
            <div class="nav-search-inner">
                <div class="back-link">
                    <a href="#" class="link back">
                        <span></span>
                    </a>
                </div>
                <div class="hotel-name-section">
                    <div class="hotel-name"><?php echo $objResultHotelLocal->SearchHotel['Name']; ?></div>
                    <div class="stars-rating">
                        <div class="rating rating_<?php echo $hotelStar; ?>">
                            <span class="star-rate-ico"></span>
                            <span class="star-rate-ico"></span>
                            <span class="star-rate-ico"></span>
                            <span class="star-rate-ico"></span>
                            <span class="star-rate-ico"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hotel-detail-images">
            <div data-pagination='{"el": ".swiper-pagination"}' data-space-between="5"
                 class="swiper-container swiper-init">
                <div class="swiper-pagination"></div>
                <div class="swiper-wrapper">
                    <?php
                    if (isset($objResultHotelLocal->SearchHotel['HotelPictures']) && !empty($objResultHotelLocal->SearchHotel['HotelPictures'])){
                        foreach ($objResultHotelLocal->SearchHotel['HotelPictures'] as $pic){
                            //if ($pic['Format'] != 'webm'){
                            ?>
                            <div class="swiper-slide"><img src="<?php echo $pic['Url']; ?>" alt="<?php echo $pic['Name']; ?>"></div>
                            <?php
                            //}
                        }
                    } else if (isset($objResultHotelLocal->SearchHotel['Logo']) && $objResultHotelLocal->SearchHotel['Logo'] != '') {
                        ?>
                        <div class="swiper-slide"><img src="<?php echo $objResultHotelLocal->SearchHotel['Logo']; ?>" alt="<?php echo $objResultHotelLocal->SearchHotel['Name']; ?>"></div>
                        <?php
                    } else {
                        ?>
                        <div class="swiper-slide"><img src="" alt=""></div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="hotel-detail-inner">
            <div class="toolbar tabbar">
                <div class="toolbar-inner">
                    <a href="#tab-1" class="tab-link tab-link-active hotel-room-css-reset">لیست اتاق ها</a>
                    <a href="#tab-2" class="tab-link">اطلاعات هتل</a>
                    <a href="#tab-3" class="tab-link">قوانین و مقررات</a>
                </div>
            </div>

            <input class="hidden-bargasht-input" value="0" type="hidden">
            <input class="hidden-raft-input" value="0" type="hidden">

            <div class="tabs-animated-wrap">
                <div class="tabs">
                    <div id="tab-1" class="page-content tab tab-active">
                        <div class="block">

                            <!--<div class="change-date">
                                <div class="start-rezerv-date">
                                    <div class="start-rezerv-date-inner startDate">
                                        <input type="text" readonly="readonly" placeholder="--/--/----"
                                               id="shamsiDeptCalendarToCalculateNights" value="<?php /*echo $startDate; */?>"/>
                                    </div>
                                </div>
                                <div class="end-rezerv-date">
                                    <div class="end-rezerv-date-inner endDate">
                                        <input type="text" readonly="readonly" placeholder="--/--/----"
                                               id="shamsiReturnCalendarToCalculateNights" value="<?php /*echo $endDate; */?>"/>
                                    </div>
                                </div>
                                <div id="editNight"><input type="hidden" id="night" name="night" value="0"></div>
                                <div class="btn-rezerv-date reSearchHotelInternal">
                                    <div class="btn-rezerv-date-inner" id="reSearchHotelInternal">تغییر</div>
                                </div>
                            </div>-->

                            <form action="" method="post" id="formHotelReserve">

                                <input id="factorNumber" name="factorNumber" type="hidden" value="">
                                <input id="typeApplication" name="typeApplication" type="hidden" value="<?php echo $typeApplication;?>">
                                <input id="cityId" name="cityId" type="hidden" value="<?php echo $cityId;?>">
                                <input id="hotelId" name="hotelId" type="hidden" value="<?php echo $hotelId;?>">
                                <input id="startDate" name="startDate" type="hidden" value="<?php echo $startDate;?>">
                                <input id="endDate" name="endDate" type="hidden" value="<?php echo $endDate;?>">
                                <input id="nights" name="nights" type="hidden" value="<?php echo $nights;?>">

                                <?php
                                if ($typeApplication == 'reservation'){
                                    include_once 'hotelRoomReservation.php';
                                } else {
                                    include_once 'hotelRoomApi.php';
                                }
                                ?>

                            </form>

                        </div>
                    </div>
                    <div id="tab-2" class="page-content tab">
                        <div class="block">
                            <div class="hotel-info-block">
                                <div class="hotel-address">
                                    <span>آدرس :</span>
                                    <span><?php echo $objResultHotelLocal->SearchHotel['AddressInfo']['Address']; ?></span>
                                    <div id="g-map"></div>
                                </div>
                                <div class="hotel-fea">
                                    <span>امکانات هتل</span>
                                    <div class="hotel-fea-inner">
                                        <?php
                                        foreach ($objResultHotelLocal->SearchHotel['HotelFacilityList'] as $facilityList){
                                            if (isset($objResultHotelLocal->HotelFacilityList[$facilityList]) && $objResultHotelLocal->HotelFacilityList[$facilityList] != ''){
                                                $class = $objResultHotelLocal->HotelFacilityList[$facilityList];
                                            } else {
                                                $class = 'ravis-icon-hotel';
                                            }
                                            ?>
                                            <div class="hotel-fea-item">
                                                <i class="<?php echo $class; ?> site-main-text-color"></i>
                                                <span><?php echo $facilityList; ?></span>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php
                                if ($typeApplication == 'reservation'){
                                    $countLine = $objResultHotelLocal->countLine($objResultHotelLocal->SearchHotel['DistanceToImportantPlaces']);
                                    ?>
                                    <div class="hotel-room-fea">
                                        <span>هتل زدیک است به</span>
                                        <div class="hotel-fea-inner">
                                            <div class="hotel-close-to-item">
                                                <span><?php echo $objResultHotelLocal->SearchHotel['DistanceToImportantPlaces']; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="hotel-room-fea">
                                        <span>امکانات اتاق</span>
                                        <div class="hotel-fea-inner">
                                            <?php
                                            foreach ($objResultHotelLocal->SearchHotel['RoomFacilitiesList'] as $facilityList){
                                                if (isset($objResultHotelLocal->RoomFacilitiesList[$facilityList]) && $objResultHotelLocal->RoomFacilitiesList[$facilityList] != ''){
                                                    $class = $objResultHotelLocal->RoomFacilitiesList[$facilityList];
                                                } else {
                                                    $class = 'ravis-icon-hotel-room';
                                                }
                                                ?>
                                                <div class="hotel-fea-item">
                                                    <i class="<?php echo $class; ?> site-main-text-color"></i>
                                                    <span><?php echo $facilityList; ?></span>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                    <div id="tab-3" class="page-content tab">
                        <div class="block">
                            <div class="hotel-info-block">
                                <div class="rules-section rule-vorood-khorooj">
                                    <span>قوانین ورود و خروج</span>
                                    <?php
                                    if ($objResultHotelLocal->SearchHotel['EntryHour'] != '' && $objResultHotelLocal->SearchHotel['LeaveHour'] != ''){
                                        ?>
                                        <p>مسافرین گرامی ‌می‌توانند بعد از ساعت <?php echo $objResultHotelLocal->SearchHotel['EntryHour']; ?> اتاق خود را تحویل گیرند و قبل از ساعت
                                            <?php echo $objResultHotelLocal->SearchHotel['LeaveHour']; ?> اقامتگاه خود را تحویل دهند. </p>
                                        <?php
                                    } else {
                                        ?>
                                        <p>مسافرین گرامی ‌می‌توانند بعد از ساعت 14:00 اتاق خود را تحویل گیرند و قبل از ساعت
                                            14:00 اقامتگاه خود را تحویل دهند. </p>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="rules-section rule-cancel">
                                    <span>قوانین کنسل کردن</span>
                                    <?php
                                    if (isset($objResultHotelLocal->SearchHotel['CancellationConditions']) && $objResultHotelLocal->SearchHotel['CancellationConditions'] != '') {
                                        ?>
                                        <p><?php echo $objResultHotelLocal->SearchHotel['CancellationConditions']; ?></p>
                                        <?php
                                    } else {
                                        ?>
                                        <p>قوانین کنسلی هتل ها بسته به شرایط و زمان لغو رزرو، متفاوت است. به همین دلیل شرایط و مبلغ جریمه در زمان کنسلی اعلام و از مبلغ واریزی کسر خواهد شد. مابقی مبلغ به حساب مسافر واریز خواهد گشت.</p>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="rules-section rule-child">
                                    <span>قوانین خردسال</span>
                                    <?php
                                    if (isset($objResultHotelLocal->SearchHotel['ChildHalfPriceCode']) && $objResultHotelLocal->SearchHotel['ChildHalfPriceCode'] != '') {
                                        ?>
                                        <p><?php echo $objResultHotelLocal->SearchHotel['ChildHalfPriceCode']; ?></p>
                                        <?php
                                    } elseif (isset($objResultHotelLocal->SearchHotel['ChildDescription']) && $objResultHotelLocal->SearchHotel['ChildDescription'] != ''){
                                        ?>
                                        <p><?php echo $objResultHotelLocal->SearchHotel['ChildDescription']; ?></p>
                                        <?php
                                    } else {
                                        ?>
                                        <p>هزینه اقامت کودکان خردسال تا سن 5 سال رایگان محاسبه خواهد شد .</p>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


        </div>



    </div>
</div>
</div>
<!--<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
      integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
      crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
        integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
        crossorigin=""></script>

<script>
    // position we will use later ,
    var lat = 35.754699;
    var lon = 51.330483;
    // initialize map
    map = L.map('g-map').setView([lat, lon], 15);
    // set map tiles source
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
        maxZoom: 16,
        minZoom: 14,
    }).addTo(map);
    // add marker to the map
    marker = L.marker([lat, lon]).addTo(map);
    // add popup to the marker
    marker.bindPopup("تهران ، بلوار اشرفی اصفهانی ، خیابان مخبری ، پلاک 48 ، طبقه اول ، واحد 5").openPopup();
</script>
-->