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
    //echo Load::plog($formData);
    $objResult = Load::controller('resultHotelLocal');
    if ($formData['typeApplication'] == 'reservation') {

        $objResult->getReservationHotel($formData['hotelId']);
        $infoHotel = $objResult->infoReservationHotel;
        $infoHotel['name'] = $objResult->infoReservationHotel['name'];
        $infoHotel['starCode'] = $objResult->infoReservationHotel['star_code'];
        $infoHotel['address'] = $objResult->infoReservationHotel['address'];
        $infoHotel['pictures'] = $objResult->infoReservationHotel['logo'];

    } else {

        //$objResult->getInfoHotelRoom($formData['hotelId']);
        $objResult->getPassengersDetailHotel($formData['factorNumber'], $formData['startDate'], $formData['endDate'], $formData['totalNumberRoomReserve']);
        $infoHotel['name'] = $objResult->temproryHotel[0]['hotel_name'];
        $infoHotel['starCode'] = $objResult->temproryHotel[0]['hotel_starCode'];
        $infoHotel['address'] = $objResult->temproryHotel[0]['hotel_address'];
        $infoHotel['pictures'] = $objResult->temproryHotel[0]['hotel_pictures'];
    }

    $infoMember = functions::infoMember(Session::getUserId());
    ?>


    <div class="page-content">
        <div class="nav-info site-bg-main-color">
            <div class="nav-info-inner">
                <div class="back-link">
                    <a href="#" class="link back">
                        <span></span>
                    </a>
                </div>
                <div class="title">ورود مشخصات</div>
            </div>
        </div>
        <div class="hotel-choosen">
            <div class="hotel-choosen-thumb">
                <img src="images/hotel-1.jpg" alt="">
            </div>
            <div class="hotel-choosen-info">
                <span class="hotel-choosen-name"><?php echo $infoHotel['name']; ?>
                    <span>(<?php echo $infoHotel['starCode']; ?> ستاره)</span>
                </span>
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
                    <span><?php echo $infoHotel['address']; ?></span>
                </div>

                <div class="hotel-choosen-time">
                    <div class="hotel-vorood-time">
                        <span>تاریخ ورود :</span>
                        <span><?php echo $formData['startDate']; ?></span>
                    </div>
                    <div class="hotel-khoroj-time">
                        <span>تاریخ خروج :</span>
                        <span><?php echo $formData['endDate']; ?></span>
                    </div>
                    <div class="eghamat-time"><i>مدت اقامت :</i> <span><?php echo $formData['nights']; ?> شب</span>
                    </div>
                    <div class="eghamat-time"><i>مبلغ کل:</i>
                        <span><?php echo number_format($formData['totalPriceHotel']); ?></span></div>
                </div>

            </div>
        </div>

        <form action="" method="post" class="hotel-passenger-page-info" id="formNextStepReserveHotel">

            <input type="hidden" name="SelectPassenger" id="SelectPassenger">
            <div class="blit-info-page">

                <?php
                if ($formData['typeApplication'] == 'reservation') {
                    include_once 'passengerHotelReservation.php';
                } else {
                    include_once 'passengerHotelApi.php';
                }
                ?>

                <input type="hidden" id="typeApplication" name="typeApplication"
                       value="<?php echo $formData['typeApplication']; ?>">
                <input type="hidden" id="factorNumber" name="factorNumber"
                       value="<?php echo $formData['factorNumber']; ?>">
                <input type="hidden" id="idCity_Reserve" name="idCity_Reserve"
                       value="<?php echo $formData['cityId']; ?>">
                <input type="hidden" id="Hotel_Reserve" name="Hotel_Reserve"
                       value="<?php echo $formData['hotelId']; ?>">
                <input type="hidden" id="StartDate_Reserve" name="StartDate_Reserve"
                       value="<?php echo $formData['startDate']; ?>">
                <input type="hidden" id="EndDate_Reserve" name="EndDate_Reserve"
                       value="<?php echo $formData['endDate']; ?>">
                <input type="hidden" id="Nights_Reserve" name="Nights_Reserve"
                       value="<?php echo $formData['nights']; ?>">
                <input type="hidden" id="IdMember" name="IdMember"
                       value="<?php echo Session::getUserId() ?>">
                <input type="hidden" id="countPassenger" name="countPassenger"
                       value="<?php echo $countPassenger; ?>">
                <input type="hidden" name="currentTime" id="currentTime"
                       value="<?php echo time() ?>">

                <input type="hidden" id="time_remmaining" name="time_remmaining" value="">
                <input type="hidden" id="CurrencyCode" name="CurrencyCode" value="">


                <!--<div class="buyer-info">
                    <span>اطلاعات سرگروه اصلی</span>
                    <div class="list">
                        <ul>
                            <li class="item-content item-input">
                                <div class="item-media">
                                    <i class="buyer-name-icon"></i>
                                </div>
                                <div class="item-inner">
                                    <div class="item-title item-floating-label">نام و نام خانوادگی</div>
                                    <div class="item-input-wrap">
                                        <input type="text">
                                        <span class="input-clear-button"></span>
                                    </div>
                                </div>
                            </li>
                            <li class="item-content item-input">
                                <div class="item-media">
                                    <i class="buyer-phone-icon"></i>
                                </div>
                                <div class="item-inner">
                                    <div class="item-title item-floating-label">تلفن همراه</div>
                                    <div class="item-input-wrap">
                                        <input type="text">
                                        <span class="input-clear-button"></span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>-->


                <div class="buyer-info">
                    <span>اطلاعات خریدار</span>
                    <div class="list">
                        <ul>

                            <li class="item-content item-input">
                                <div class="item-media">
                                    <i class="buyer-name-icon site-bg-main-color"></i>
                                </div>
                                <div class="item-inner">
                                    <div class="item-title item-floating-label">نام و نام خانوادگی</div>
                                    <div class="item-input-wrap">
                                        <input type="text" id="passenger_leader_room_fullName"
                                               name="passenger_leader_room_fullName"
                                               value="<?php echo $infoMember['name'] . ' ' . $infoMember['family'] ?>">
                                        <span class="input-clear-button"></span>
                                    </div>
                                </div>
                            </li>

                            <li class="item-content item-input">
                                <div class="item-media">
                                    <i class="buyer-mob-icon site-bg-main-color"></i>
                                </div>
                                <div class="item-inner">
                                    <div class="item-title item-floating-label">تلفن همراه</div>
                                    <div class="item-input-wrap">
                                        <input type="text" id="Mobile" name="Mobile"
                                               value="<?php echo $infoMember['mobile'] ?>">
                                        <span class="input-clear-button"></span>
                                    </div>
                                </div>
                            </li>

                            <!--<li class="item-content item-input">
                                <div class="item-media">
                                    <i class="buyer-phone-icon"></i>
                                </div>
                                <div class="item-inner">
                                    <div class="item-title item-floating-label">تلفن ثابت</div>
                                    <div class="item-input-wrap">
                                        <input type="text">
                                        <span class="input-clear-button"></span>
                                    </div>
                                </div>
                            </li>-->

                            <li class="item-content item-input">
                                <div class="item-media">
                                    <i class="buyer-email-icon site-bg-main-color"></i>
                                </div>
                                <div class="item-inner">
                                    <div class="item-title item-floating-label">ایمیل</div>
                                    <div class="item-input-wrap">
                                        <input type="text" id="Email" name="Email"
                                               value="<?php echo $infoMember['email'] ?>">
                                        <span class="input-clear-button"></span>
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>

                </div>

                <!--<div class="bottom-btn">
                    <a href="#" class="bot-btn">ادامه</a>
                </div>-->
                <div class="bottom-btn">
                    <a href="#" class="bot-btn site-bg-main-color" id="reserveHotel">
                        <span>ادامه</span>
                        <i class="preloader color-white myhidden"></i>
                    </a>
                </div>

            </div>

        </form>


        <div class="popup popup-passenger-lists">
            <div class="navbar">
                <div class="navbar-inner sliding">
                    <div class="title">لیست مسافران</div>
                    <a class="link popup-close" href="#">بستن</a>
                    <div class="subnavbar">
                        <form data-search-container=".virtual-list" data-search-item="li" data-search-in=".item-title"
                              class="searchbar searchbar-init">
                            <div class="searchbar-inner">
                                <div class="searchbar-input-wrap">
                                    <input type="search" placeholder="مسافر مورد نظر را جستوجو کنید"/>
                                    <i class="searchbar-icon"></i>
                                    <span class="input-clear-button"></span>
                                </div>
                                <span class="searchbar-disable-button if-not-aurora">لغو</span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="searchbar-backdrop"></div>
            <div class="page-content">
                <div class="list simple-list searchbar-not-found">
                    <ul>
                        <li>چیزی پیدا نشد</li>
                    </ul>
                </div>
                <div class="list virtual-list media-list searchbar-found"></div>
            </div>
        </div>


    </div>
</div>
