<?php require '../../../config/bootstrap.php';

?>
<div class="page" data-page="hotel-dakheli-search">
    <div class="page-content">
        <div class="nav-search nv-hotel-dakheli">
            <div class="nav-search-inner">
                <div class="back-link">
                    <a href="<?php echo ROOT_ADDRESS_WITHOUT_LANG . '/app/'?>" class="link back external">
                        <span></span>
                    </a>
                </div>
                <div class="title">رزرو هتل داخلی</div>
            </div>
        </div>
        <div class="search-bar-app sba-hotel-dakheli">
            <div class="list list-search">
                <ul>
                    <li class="hotel-city-choose">
                        <a class="item-content" href="#" id="search-city-hotel">
                            <input class="hidden-mabda-input" value="0" type="hidden">
                            <div class="item-inner">
                                <div class="item-title">انتخاب شهر مقصد</div>
                                <div class="item-after"></div>
                            </div>
                        </a>
                    </li>

                    <input class="hidden-bargasht-input" value="0" type="hidden">
                    <input class="hidden-raft-input" value="0" type="hidden">

                    <li class="hotel-vorood-khorooj-choose">

                        <div class="item-content item-input vorood-date">
                            <div class="item-inner">
                                <div class="item-title item-label">تاریخ ورود</div>
                                <div class="item-input-wrap startDate">
                                    <input type="text" readonly="readonly" placeholder="--/--/----"
                                           id="shamsiDeptCalendarToCalculateNights"/>
                                </div>
                            </div>
                        </div>
                        <div class="item-content item-input khorooj-date">
                            <div class="item-inner">
                                <div class="item-title item-label">تاریخ خروج</div>
                                <div class="item-input-wrap endDate">
                                    <input type="text" readonly="readonly" placeholder="--/--/----"
                                           id="shamsiReturnCalendarToCalculateNights"/>
                                </div>
                            </div>
                        </div>
                        <div class="staying-time"></div>
                        <input type="hidden" id="nights" name="nights" value="0">
                    </li>
                    <li class="search-btn">
                        <a href="#" class="button button-fill site-bg-main-color searchHotelInternal">
                            <span> جست و جو هتل</span>
                            <i class="preloader color-white myhidden"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>