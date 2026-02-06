<?php
//echo Load::plog($formData);

$formData['startDate_reserve'] = $formData['startDate'];
$formData['endDate_reserve'] = $formData['endDate'];
$formData['TypeRoomHotel'] = $formData['typeRoomHotel'];
$formData['idHotel_reserve'] = $formData['hotelId'];
$objResult->getPassengersDetailHotelForReservation($formData);
//echo Load::plog($objResult->temproryHotelRoom);

$countPassenger = 0;
$roomTypeCodes = '';
$numberOfRooms = '';
foreach ($objResult->temproryHotelRoom as $i=>$room){


    $roomTypeCodes .= $room['IdRoom'] . ',';
    $numberOfRooms .= $room['RoomCount'] . ',';

    $EXTCapacity = $room['maximum_extra_beds'] + $room['maximum_extra_chd_beds'];

    $dbl_total = $room['RoomCount'] * $room['RoomCapacity'];
    $ext_total = $room['ExtraBedCount'];
    $echd_total = $room['ExtraChildBedCount'];
    $extra_total = $room['ExtraBedCount'] + $room['ExtraChildBedCount'] * $EXTCapacity;


    for ($RC = 1; $RC <= $room['RoomCount']; $RC++){

        $isDBL = 0;

        $dbl_room = 1;
        $ext_room = 1;
        $echd_room = 1;

        $room_capacity = $room['RoomCapacity'] + $room['maximum_extra_beds'] + $room['maximum_extra_chd_beds'];
        $extra_beds_capacity = $room['maximum_extra_beds'];
        $extra_chd_beds_capacity = $room['maximum_extra_chd_beds'];

        for ($C = 1; $C <= $room_capacity; $C++){

            $flag = 0;
            if ($dbl_total != 0 && $dbl_room <= $room['RoomCapacity']){

                $roommate = 'IdRoom:' . $room['IdRoom']. '_RoomCount:' . $RC . '_DBL:' . $dbl_room;
                $flat_type = 'DBL';
                $dbl_room = $dbl_room + 1;
                $dbl_total = $dbl_total -1;
                $flag = 1;
                $isDBL++;

            } elseif (($ext_room <= $extra_beds_capacity) && $ext_total != 0 && $extra_total != 0){

                $roommate = 'IdRoom:' . $room['IdRoom']. '_RoomCount:' . $RC . '_EXT:' . $ext_room;
                $flat_type = 'EXT';
                $ext_room = $ext_room + 1;
                $ext_total = $ext_total - 1;
                $extra_total = $extra_total - 1;
                $flag = 1;

            } elseif (($echd_room <= $extra_chd_beds_capacity) && $echd_total != 0 && $extra_total != 0){

                $roommate = 'IdRoom:' . $room['IdRoom']. '_RoomCount:' . $RC . '_CEXT:' . $echd_room;
                $flat_type = 'ECHD';
                $echd_room = $echd_room + 1;
                $echd_total = $echd_total - 1;
                $extra_total = $extra_total - 1;
                $flag = 1;

            }


            if ($flag == 1){

                $countPassenger++;
                ?>
                <input type="hidden" id="roommate<?php echo $countPassenger; ?>" name="roommate<?php echo $countPassenger; ?>" value="<?php echo $roommate; ?>">
                <input type="hidden" id="flat_type<?php echo $countPassenger; ?>" name="flat_type<?php echo $countPassenger; ?>" value="<?php echo $flat_type; ?>">
                <input type="hidden" name="room_id<?php echo $countPassenger; ?>" id="room_id<?php echo $countPassenger; ?>" value="<?php echo $room['IdRoom']; ?>">
                <input type="hidden" name="IdHotelRoomPrice<?php echo $countPassenger; ?>" id="IdHotelRoomPrice<?php echo $countPassenger; ?>" value="<?php echo $room[$flat_type]; ?>">


                <?php
                if ($isDBL == 1){

                    ?>
                    <div class="passenger-info hotel-passenger-info">
                        <div class="accordion-list custom-accordion">
                            <div class="accordion-item">
                                <div class="accordion-item-toggle bozorgsal-passenger">
                                    <span>اطلاعات سرپرست برای اتاق <?php echo $RC; ?></span>
                                    <span><?php echo $room['RoomName']; ?></span>
                                    <i></i>
                                </div>
                                <div class="accordion-item-content">

                                    <div class="list list-passenger">

                                        <ul>
                                            
                                            <li>
                                                <a class="link popup-open list-mosaferan-btn site-border-main-color site-main-text-color"
                                                   href="#" data-popup=".popup-passenger-lists"
                                                   onclick="SelectOldPassenger('A<?php echo $countPassenger ?>')">انتخاب از لیست مسافران
                                                </a>
                                            </li>

                                            <li class="passenger-info-li passenger-nationality">
                                                <span>ملیت :</span>
                                                <div>
                                                    <label class="item-radio radio">
                                                        <input class="nationality-choose LocalA<?php echo $countPassenger ?>"
                                                               type="radio"
                                                               name="passengerNationalityA<?php echo $countPassenger; ?>"
                                                               id="passengerNationalityA<?php echo $countPassenger; ?>"
                                                               value="0" checked="checked"/>
                                                        <i class="icon-radio"></i>
                                                        <div class="item-inner">
                                                            <!-- Radio Title -->
                                                            <div class="item-title">ایرانی</div>
                                                        </div>
                                                    </label>
                                                    <label class="item-radio radio">
                                                        <input class="nationality-choose ForeignA<?php echo $countPassenger ?>"
                                                               type="radio"
                                                               name="passengerNationalityA<?php echo $countPassenger; ?>"
                                                               id="passengerNationalityA<?php echo $countPassenger; ?>"
                                                               value="1"/>
                                                        <i class="icon-radio"></i>
                                                        <div class="item-inner">
                                                            <!-- Radio Title -->
                                                            <div class="item-title">غیر ایرانی</div>
                                                        </div>
                                                    </label>

                                                </div>
                                            </li>


                                            <li class="passenger-info-li passenger-nationality">
                                                <span>جنسیت :</span>
                                                <div>
                                                    <label class="item-radio radio">
                                                        <input type="radio" value="Male" checked="checked"
                                                               id="genderA<?php echo $countPassenger; ?>"
                                                               name="genderA<?php echo $countPassenger; ?>"
                                                               class="MaleA<?php echo $countPassenger ?>">
                                                        <i class="icon-radio"></i>
                                                        <div class="item-inner">
                                                            <!-- Radio Title -->
                                                            <div class="item-title">مرد</div>
                                                        </div>
                                                    </label>
                                                    <label class="item-radio radio">
                                                        <input type="radio" value="Female"
                                                               id="genderA<?php echo $countPassenger; ?>"
                                                               name="genderA<?php echo $countPassenger; ?>"
                                                               class="FemaleA<?php echo $countPassenger ?>">
                                                        <i class="icon-radio"></i>
                                                        <div class="item-inner">
                                                            <!-- Radio Title -->
                                                            <div class="item-title">زن</div>
                                                        </div>
                                                    </label>

                                                </div>
                                            </li>


                                            <li class="item-content item-input">
                                                <div class="item-media">
                                                    <i class="icon demo-list-icon"></i>
                                                </div>
                                                <div class="item-inner">
                                                    <div class="item-title item-floating-label">نام (فارسی)</div>
                                                    <div class="item-input-wrap">
                                                        <input type="text"
                                                               id="nameFaA<?php echo $countPassenger; ?>"
                                                               name="nameFaA<?php echo $countPassenger; ?>">
                                                        <span class="input-clear-button"></span>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="item-content item-input">
                                                <div class="item-media">
                                                    <i class="icon demo-list-icon"></i>
                                                </div>
                                                <div class="item-inner">
                                                    <div class="item-title item-floating-label">نام خانوادگی (فارسی)
                                                    </div>
                                                    <div class="item-input-wrap">
                                                        <input type="text"
                                                               id="familyFaA<?php echo $countPassenger; ?>"
                                                               name="familyFaA<?php echo $countPassenger; ?>">
                                                        <span class="input-clear-button"></span>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="item-content item-input">
                                                <div class="item-media">
                                                    <i class="icon demo-list-icon"></i>
                                                </div>
                                                <div class="item-inner">
                                                    <div class="item-title item-floating-label">نام (انگلیسی)</div>
                                                    <div class="item-input-wrap">
                                                        <input type="text"
                                                               id="nameEnA<?php echo $countPassenger; ?>"
                                                               name="nameEnA<?php echo $countPassenger; ?>">
                                                        <span class="input-clear-button"></span>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="item-content item-input">
                                                <div class="item-media">
                                                    <i class="icon demo-list-icon"></i>
                                                </div>
                                                <div class="item-inner">
                                                    <div class="item-title item-floating-label">نام خانوادگی (انگلیسی)
                                                    </div>
                                                    <div class="item-input-wrap">
                                                        <input type="text"
                                                               id="familyEnA<?php echo $countPassenger; ?>"
                                                               name="familyEnA<?php echo $countPassenger; ?>">
                                                        <span class="input-clear-button"></span>
                                                    </div>
                                                </div>
                                            </li>

                                            <input type="hidden" name="birthday<?php echo $i ?>" id="birthday<?php echo $countPassenger ?>">
                                            <input type="hidden" name="birthdayEn<?php echo $i ?>" id="birthdayEn<?php echo $countPassenger ?>">

                                            <li class="item-content item-input birthday-select shamsi-bd">
                                                <div class="item-inner">
                                                    <div class="item-title item-label">تاریخ تولد (شمسی)</div>
                                                    <div class="item-input-wrap input-dropdown-wrap">
                                                        <select placeholder="لطفا انتخاب کنید..."
                                                                name="YearJalaliA<?php echo $countPassenger ?>"
                                                                id="YearJalaliA<?php echo $countPassenger ?>">
                                                            <option value="">سال</option>
                                                            <?php for ($Sh = 13; $Sh < 100; $Sh++) { ?>
                                                                <option value="<?php echo dateTimeSetting::jdate("Y", time() - ($Sh * (12 * 30 * 24 * 60 * 60)), '', '', 'en') ?>"><?php echo dateTimeSetting::jdate("Y", time() - ($Sh * (12 * 30 * 24 * 60 * 60))) ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="item-inner">
                                                    <div class="item-title item-label">.</div>
                                                    <div class="item-input-wrap input-dropdown-wrap">
                                                        <select placeholder="Please choose..."
                                                                name="MonthJalaliA<?php echo $countPassenger ?>"
                                                                id="MonthJalaliA<?php echo $countPassenger ?>">
                                                            <option value="">ماه</option>
                                                            <option value="01">فروردین</option>
                                                            <option value="02">اردیبهشت</option>
                                                            <option value="03">خرداد</option>
                                                            <option value="04">تیر</option>
                                                            <option value="05">مرداد</option>
                                                            <option value="06">شهریور</option>
                                                            <option value="07">مهر</option>
                                                            <option value="08">آبان</option>
                                                            <option value="09">آذر</option>
                                                            <option value="10">دی</option>
                                                            <option value="11">بهمن</option>
                                                            <option value="12">اسفند</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="item-inner">
                                                    <div class="item-title item-label">.</div>
                                                    <div class="item-input-wrap input-dropdown-wrap">
                                                        <select placeholder="Please choose..."
                                                                name="DayJalaliA<?php echo $countPassenger ?>"
                                                                id="DayJalaliA<?php echo $countPassenger ?>">
                                                            <option value="">روز</option>
                                                            <option value="01">1</option>
                                                            <option value="02">2</option>
                                                            <option value="03">3</option>
                                                            <option value="04">4</option>
                                                            <option value="05">5</option>
                                                            <option value="06">6</option>
                                                            <option value="07">7</option>
                                                            <option value="08">8</option>
                                                            <option value="09">9</option>
                                                            <option value="10">10</option>
                                                            <option value="11">11</option>
                                                            <option value="12">12</option>
                                                            <option value="13">13</option>
                                                            <option value="14">14</option>
                                                            <option value="15">15</option>
                                                            <option value="16">16</option>
                                                            <option value="17">17</option>
                                                            <option value="18">18</option>
                                                            <option value="19">19</option>
                                                            <option value="20">20</option>
                                                            <option value="21">21</option>
                                                            <option value="22">22</option>
                                                            <option value="23">23</option>
                                                            <option value="24">24</option>
                                                            <option value="25">25</option>
                                                            <option value="26">26</option>
                                                            <option value="27">27</option>
                                                            <option value="28">28</option>
                                                            <option value="29">29</option>
                                                            <option value="30">30</option>
                                                            <option value="31">31</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </li>


                                            <li class="item-content item-input birthday-select miladi-bd myhidden">
                                                <div class="item-inner">
                                                    <div class="item-title item-label">تاریخ تولد (میلادی)</div>
                                                    <div class="item-input-wrap input-dropdown-wrap">
                                                        <select placeholder="Please choose..."
                                                                name="YearMiladiA<?php echo $countPassenger ?>"
                                                                id="YearMiladiA<?php echo $countPassenger ?>">
                                                            <option value="">سال</option>
                                                            <?php for ($Mi = 13; $Mi < 100; $Mi++) { ?>
                                                                <option value="<?php echo date("Y", time() - ($Mi * (12 * 30 * 24 * 60 * 60))) ?>"><?php echo date("Y", time() - ($Mi * (12 * 30 * 24 * 60 * 60))) ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="item-inner">
                                                    <div class="item-title item-label">.</div>
                                                    <div class="item-input-wrap input-dropdown-wrap">
                                                        <select placeholder="Please choose..."
                                                                name="MonthMiladiA<?php echo $countPassenger ?>"
                                                                id="MonthMiladiA<?php echo $countPassenger ?>">
                                                            <option value="">ماه</option>
                                                            <option value="01">January</option>
                                                            <option value="02">February</option>
                                                            <option value="03">March</option>
                                                            <option value="04">April</option>
                                                            <option value="05">May</option>
                                                            <option value="06">June</option>
                                                            <option value="07">July</option>
                                                            <option value="08">August</option>
                                                            <option value="09">September</option>
                                                            <option value="10">October</option>
                                                            <option value="11">November</option>
                                                            <option value="12">December</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="item-inner">
                                                    <div class="item-title item-label">.</div>
                                                    <div class="item-input-wrap input-dropdown-wrap">
                                                        <select placeholder="Please choose..."
                                                                name="DayMiladiA<?php echo $countPassenger ?>"
                                                                id="DayMiladiA<?php echo $countPassenger ?>">
                                                            <option value="">روز</option>
                                                            <option value="01">1</option>
                                                            <option value="02">2</option>
                                                            <option value="03">3</option>
                                                            <option value="04">4</option>
                                                            <option value="05">5</option>
                                                            <option value="06">6</option>
                                                            <option value="07">7</option>
                                                            <option value="08">8</option>
                                                            <option value="09">9</option>
                                                            <option value="10">10</option>
                                                            <option value="11">11</option>
                                                            <option value="12">12</option>
                                                            <option value="13">13</option>
                                                            <option value="14">14</option>
                                                            <option value="15">15</option>
                                                            <option value="16">16</option>
                                                            <option value="17">17</option>
                                                            <option value="18">18</option>
                                                            <option value="19">19</option>
                                                            <option value="20">20</option>
                                                            <option value="21">21</option>
                                                            <option value="22">22</option>
                                                            <option value="23">23</option>
                                                            <option value="24">24</option>
                                                            <option value="25">25</option>
                                                            <option value="26">26</option>
                                                            <option value="27">27</option>
                                                            <option value="28">28</option>
                                                            <option value="29">29</option>
                                                            <option value="30">30</option>
                                                            <option value="31">31</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="item-content item-input code-melli">
                                                <div class="item-media">
                                                    <i class="icon demo-list-icon"></i>
                                                </div>
                                                <div class="item-inner">
                                                    <div class="item-title item-floating-label">کد ملی</div>
                                                    <div class="item-input-wrap">
                                                        <input type="text" class="UniqNationalCode" value=""
                                                               name="NationalCodeA<?php echo $countPassenger ?>"
                                                               id="NationalCodeA<?php echo $countPassenger ?>"
                                                               maxlength="10"
                                                               required
                                                               validate
                                                               pattern="[0-9]*"
                                                               data-error-message="لطفا  فقط عدد وارد نمائید">
                                                        <span class="input-clear-button"></span>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="country-passport country-passport myhidden">
                                                <div class="item-inner">
                                                    <div class="item-title item-label">کشور صادر کننده پاسپورت</div>
                                                    <?php
                                                    $countryCodes = functions::CountryCodes();
                                                    ?>
                                                    <div class="item-input-wrap input-dropdown-wrap">
                                                        <select placeholder="Please choose..."
                                                                name="passportCountryA<?php echo $countPassenger; ?>"
                                                                id="passportCountryA<?php echo $countPassenger; ?>">
                                                            <option value="">انتخاب کنید</option>
                                                            <?php foreach ($countryCodes as $Country) { ?>
                                                                <option value="<?php echo $Country['code'] ?>"><?php echo $Country['titleFa'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="item-content item-input passportNumber myhidden">
                                                <div class="item-media">
                                                    <i class="icon demo-list-icon"></i>
                                                </div>

                                                <div class="item-inner">
                                                    <div class="item-title item-floating-label">شماره پاسپورت</div>
                                                    <div class="item-input-wrap">
                                                        <input type="text" value=""
                                                               name="passportNumberA<?php echo $countPassenger ?>"
                                                               id="passportNumberA<?php echo $countPassenger ?>"
                                                               required
                                                               validate
                                                               data-error-message="لطفا  شماره پاسپورت را وارد نمائید">
                                                        <span class="input-clear-button"></span>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="item-content item-input passportExpire myhidden">
                                                <div class="item-media">
                                                    <i class="icon demo-list-icon"></i>
                                                </div>

                                                <div class="item-inner">
                                                    <div class="item-title item-floating-label">تاریخ انقضاء پاسپورت
                                                    </div>
                                                    <div class="item-input-wrap ReturnDate">
                                                        <input type="text" readonly="readonly"
                                                               placeholder="--/--/----"
                                                               id="passportExpireA<?php echo $countPassenger; ?>"
                                                               name="passportExpireA<?php echo $countPassenger; ?>"/>
                                                        <span class="input-clear-button"></span>
                                                    </div>
                                                </div>
                                            </li>

                                        </ul>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                    <?php

                } else {
                    ?>
                    <input type="hidden" id="passengerNationalityA<?php echo $countPassenger; ?>" name="passengerNationalityA<?php echo $countPassenger; ?>" value=""/>
                    <input type="hidden" id="genderA<?php echo $countPassenger; ?>" name="genderA<?php echo $countPassenger; ?>" value="">
                    <input type="hidden" id="nameFaA<?php echo $countPassenger; ?>" name="nameFaA<?php echo $countPassenger; ?>" value="">
                    <input type="hidden" id="familyFaA<?php echo $countPassenger; ?>" name="familyFaA<?php echo $countPassenger; ?>" value="">
                    <input type="hidden" id="nameEnA<?php echo $countPassenger; ?>" name="nameEnA<?php echo $countPassenger; ?>" value="">
                    <input type="hidden" id="familyEnA<?php echo $countPassenger; ?>" name="familyEnA<?php echo $countPassenger; ?>" value="">
                    <input type="hidden" id="familyEnA<?php echo $countPassenger; ?>" name="familyEnA<?php echo $countPassenger; ?>" value="">
                    <input type="hidden" id="YearJalaliA<?php echo $countPassenger; ?>" name="YearJalaliA<?php echo $countPassenger; ?>" value="">
                    <input type="hidden" id="MonthJalaliA<?php echo $countPassenger; ?>" name="MonthJalaliA<?php echo $countPassenger; ?>" value="">
                    <input type="hidden" id="DayJalaliA<?php echo $countPassenger; ?>" name="DayJalaliA<?php echo $countPassenger; ?>" value="">
                    <input type="hidden" id="YearMiladiA<?php echo $countPassenger; ?>" name="YearMiladiA<?php echo $countPassenger; ?>" value="">
                    <input type="hidden" id="MonthMiladiA<?php echo $countPassenger; ?>" name="MonthMiladiA<?php echo $countPassenger; ?>" value="">
                    <input type="hidden" id="DayMiladiA<?php echo $countPassenger; ?>" name="DayMiladiA<?php echo $countPassenger; ?>" value="">
                    <input type="hidden" id="passportCountryA<?php echo $countPassenger; ?>" name="passportCountryA<?php echo $countPassenger; ?>" value="">
                    <input type="hidden" id="NationalCodeA<?php echo $countPassenger; ?>" name="NationalCodeA<?php echo $countPassenger; ?>" value="">
                    <input type="hidden" id="passportNumberA<?php echo $countPassenger; ?>" name="passportNumberA<?php echo $countPassenger; ?>" value="">
                    <input type="hidden" id="passportExpireA<?php echo $countPassenger; ?>" name="passportExpireA<?php echo $countPassenger; ?>" value="">
                    <?php
                }
                ?>


                <?php
            }
        }
    }

}


?>


<!--transfer-->
<?php
if ($objResult->transfer_went != 'no' || $objResult->transfer_back != 'no'){

    $conditions = "id = {$objResult->infoReservationHotel['city']} ";
    $cityName = functions::getValueFields('reservation_city_tb', 'name', $conditions);
    ?>

    <input type="hidden" id="isTransfer" name="isTransfer" value="true">

    <div class="passenger-info hotel-passenger-info hotel-free-transfer">
        <div class="accordion-list custom-accordion">
            <div class="accordion-item">
                <div class="accordion-item-toggle">
                    <span>ترانسفر رایگان از جانب هتل</span>
                </div>
                <div class="accordion-item-content">

                    <div class="list list-passenger">

                        <ul>

                            <li class="item-content item-input">
                                <div class="item-media">
                                    <i class="icon demo-list-icon"></i>
                                </div>
                                <div class="item-inner">
                                    <div class="item-title item-floating-label">شهر مبدا</div>
                                    <div class="item-input-wrap">
                                        <input type="text" name="origin" id="origin">
                                        <span class="input-clear-button"></span>
                                    </div>
                                </div>
                            </li>
                            <li class="item-content item-input">
                                <div class="item-media">
                                    <i class="icon demo-list-icon"></i>
                                </div>
                                <div class="item-inner">
                                    <div class="item-title item-floating-label">شهر مبدا</div>
                                    <div class="item-input-wrap">
                                        <input type="text" name="destination" id="destination" placeholder="مقصد : <?php echo $cityName['name']; ?>" readonly="">
                                        <span class="input-clear-button"></span>
                                    </div>
                                </div>
                            </li>
                            <!--<li>
                                <input class="hidden-maghsad-input" value="0" type="hidden">
                                <a class="item-link item-content" href="#" id="autocomplete-standalone-Destination">
                                    <input type="hidden">
                                    <div class="item-inner">
                                        <div class="item-title">شهر مبدا</div>
                                        <div class="item-after choosen-city"></div>
                                    </div>
                                </a>
                            </li>-->
                            <!--<li class="transfer-maghsad-input">
                                <div class="item-link item-content" href="#">
                                    <div class="item-inner">
                                        <div class="item-title">شهر مقصد</div>
                                        <div class="item-after choosen-city">تهران</div>
                                    </div>
                                </div>
                            </li>-->
                            <?php
                            if ($objResult->transfer_went != 'no'){
                                ?>
                                <li class="raftbargasht">
                                    <div class="item-content item-input raft-date">
                                        <div class="item-inner">
                                            <div class="item-title item-label">تاریخ حرکت رفت</div>
                                            <div class="item-input-wrap DepartureDate">
                                                <input type="text" readonly="readonly" placeholder="--/--/----" name="flight_date_went" id="flight_date_went"/>
                                            </div>
                                        </div>s
                                    </div>
                                </li>
                                <li class="item-content item-input">
                                    <div class="item-media">
                                        <i class="icon demo-list-icon"></i>
                                    </div>
                                    <div class="item-inner">
                                        <div class="item-title item-floating-label">نام وسیله حرکت رفت</div>
                                        <div class="item-input-wrap">
                                            <input type="text" name="airline_went" id="airline_went">
                                            <span class="input-clear-button"></span>
                                        </div>
                                    </div>
                                </li>
                                <li class="item-content item-input">
                                    <div class="item-media">
                                        <i class="icon demo-list-icon"></i>
                                    </div>
                                    <div class="item-inner">
                                        <div class="item-title item-floating-label">شماره وسیله حرکت رفت</div>
                                        <div class="item-input-wrap">
                                            <input type="text" name="flight_number_went" id="flight_number_went">
                                            <span class="input-clear-button"></span>
                                        </div>
                                    </div>
                                </li>
                                <li class="item-content item-input harekat-time">
                                    <div class="item-inner">
                                        <div class="item-title item-label">ساعت رسیدن به مقصد</div>
                                        <div class="item-input-wrap input-dropdown-wrap">
                                            <select name="hour_went" id="hour_went">
                                                <option value="">ساعت</option>
                                                <?php
                                                for ($n=0; $n<=9; $n++){
                                                    ?>
                                                    <option value="0<?php echo $n; ?>">0<?php echo $n; ?></option>
                                                    <?php
                                                }
                                                for ($n=10; $n<=24; $n++){
                                                    ?>
                                                    <option value="<?php echo $n; ?>"><?php echo $n; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="item-inner">
                                        <div class="item-title item-label">.</div>
                                        <div class="item-input-wrap input-dropdown-wrap">
                                            <select name="minutes_went" id="minutes_went">
                                                <option value="">دقیقه</option>
                                                <?php
                                                for ($n=0; $n<=9; $n++){
                                                    ?>
                                                    <option value="0<?php echo $n; ?>">0<?php echo $n; ?></option>
                                                    <?php
                                                }
                                                for ($n=10; $n<=60; $n++){
                                                    ?>
                                                    <option value="<?php echo $n; ?>"><?php echo $n; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </li>
                                <?php
                            }
                            ?>

                            <?php
                            if ($objResult->transfer_back != 'no'){
                                ?>
                                <li class="raftbargasht">
                                    <div class="item-content item-input raft-date">
                                        <div class="item-inner">
                                            <div class="item-title item-label">تاریخ حرکت برگشت</div>
                                            <div class="item-input-wrap DepartureDate">
                                                <input type="text" name="flight_date_back" id="flight_date_back" class="datePersian"/>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="item-content item-input">
                                    <div class="item-media">
                                        <i class="icon demo-list-icon"></i>
                                    </div>
                                    <div class="item-inner">
                                        <div class="item-title item-floating-label">نام وسیله حرکت برگشت</div>
                                        <div class="item-input-wrap">
                                            <input type="text" name="airline_back" id="airline_back">
                                            <span class="input-clear-button"></span>
                                        </div>
                                    </div>
                                </li>
                                <li class="item-content item-input">
                                    <div class="item-media">
                                        <i class="icon demo-list-icon"></i>
                                    </div>
                                    <div class="item-inner">
                                        <div class="item-title item-floating-label">شماره وسیله حرکت برگشت</div>
                                        <div class="item-input-wrap">
                                            <input type="text" name="flight_number_back" id="flight_number_back">
                                            <span class="input-clear-button"></span>
                                        </div>
                                    </div>
                                </li>
                                <li class="item-content item-input harekat-time">
                                    <div class="item-inner">
                                        <div class="item-title item-label">ساعت رسیدن به مبدا</div>
                                        <div class="item-input-wrap input-dropdown-wrap">
                                            <select name="hour_back" id="hour_back">
                                                <option value="">ساعت</option>
                                                <?php
                                                for ($n=0; $n<=9; $n++){
                                                    ?>
                                                    <option value="0<?php echo $n; ?>">0<?php echo $n; ?></option>
                                                    <?php
                                                }
                                                for ($n=10; $n<=24; $n++){
                                                    ?>
                                                    <option value="<?php echo $n; ?>"><?php echo $n; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="item-inner">
                                        <div class="item-title item-label">.</div>
                                        <div class="item-input-wrap input-dropdown-wrap">
                                            <select name="minutes_back" id="minutes_back">
                                                <option value="">دقیقه</option>
                                                <?php
                                                for ($n=0; $n<=9; $n++){
                                                    ?>
                                                    <option value="0<?php echo $n; ?>">0<?php echo $n; ?></option>
                                                    <?php
                                                }
                                                for ($n=10; $n<=60; $n++){
                                                    ?>
                                                    <option value="<?php echo $n; ?>"><?php echo $n; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </li>
                                <?php
                            }
                            ?>




                        </ul>
                    </div>




                </div>
            </div>

        </div>
    </div>
    <?php
}
?>



<!--one day tour-->
<?php
$objResult->oneDayTour($formData['hotelId'], $formData['cityId']);
?>

<input type="hidden" id="isOneDayTour" name="isOneDayTour" value="<?php echo $objResult->showOneDayTour; ?>">
<?php
if ($objResult->showOneDayTour == 'True'){

    ?>
    <div class="passenger-info hotel-passenger-info hotel-gasht">
        <div class="accordion-list custom-accordion">
            <div class="accordion-item">
                <div class="accordion-item-toggle">
                    <span>گشت یک روزه</span>
                    <!--<span><?php /*echo $tour['title']; */?></span>-->
                </div>

                <?php
                foreach ($objResult->listOneDayTour as $key=>$tour){
                    $countTour = $key + 1;
                    ?>
                    <input type="hidden" name="idOneDayTour<?php echo $countTour; ?>" id="idOneDayTour<?php echo $countTour; ?>" value="<?php echo $tour['id']; ?>">

                    <div class="accordion-item-content">
                        <span class="title-one-day-tour"><?php echo $tour['title']; ?></span>
                        <div class="list list-passenger">
                            <ul>

                                <?php
                                if ($tour['adt_price_rial'] > 0){
                                    ?>
                                    <input type="hidden" value="<?php echo $tour['adt_price_rial']; ?>" name="adtPriceR<?php echo $countTour; ?>" id="adtPriceR<?php echo $countTour; ?>">
                                    <input type="hidden" value="<?php echo $tour['chd_price_rial']; ?>" name="chdPriceR<?php echo $countTour; ?>" id=chdPriceR{<?php echo $countTour; ?>">
                                    <input type="hidden" value="<?php echo $tour['inf_price_rial']; ?>" name="infPriceR<?php echo $countTour; ?>" id=infPriceR{<?php echo $countTour; ?>">

                                    <li class="stepper-nafarat stepper-gasht">
                                        <div class="item-inner">
                                            <div class="item-title"> بزرگسال
                                                <div class="item-gardesh-price">
                                                    <span><?php echo number_format($tour['adt_price_rial']); ?><i>ریال</i></span>
                                                </div>
                                            </div>
                                            <div class="item-after">

                                                <div class="stepper stepper-raised stepper-fill stepper-init">
                                                    <div class="stepper-button-plus">
                                                        <div class="stepper-svg">
                                                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                 viewBox="0 0 304.223 304.223"
                                                                 style="enable-background:new 0 0 304.223 304.223;"
                                                                 xml:space="preserve">
                                                                  <g>
                                                                      <g>
                                                                          <path d="M152.112,0C68.241,0,0.008,68.244,0.008,152.114c0,83.865,68.233,152.109,152.103,152.109
                                                                              c83.865,0,152.103-68.244,152.103-152.109C304.215,68.244,235.977,0,152.112,0z M152.112,275.989
                                                                              c-68.32,0-123.891-55.565-123.891-123.875c0-68.326,55.571-123.891,123.891-123.891s123.891,55.565,123.891,123.891
                                                                              C276.003,220.424,220.426,275.989,152.112,275.989z"/>
                                                                          <path d="M221.922,139.186h-56.887V82.298c0-7.141-5.782-12.929-12.923-12.929
                                                                              c-7.141,0-12.929,5.782-12.929,12.929v56.887H82.296c-7.141,0-12.923,5.782-12.923,12.929c0,7.141,5.782,12.923,12.923,12.923
                                                                              h56.882v56.893c0,7.142,5.787,12.923,12.929,12.923c7.141,0,12.929-5.782,12.929-12.923v-56.893h56.882
                                                                              c7.142,0,12.929-5.782,12.929-12.923C234.851,144.967,229.063,139.186,221.922,139.186z"/>
                                                                      </g>
                                                                  </g>
                                                              </svg>
                                                        </div>
                                                    </div>
                                                    <div class="stepper-input-wrap">
                                                        <input type="text" value="0"
                                                               id="adtNumR<?php echo $countTour; ?>" name="adtNumR<?php echo $countTour; ?>"
                                                               min="0" max="9" step="1" readonly>
                                                    </div>
                                                    <div class="stepper-button-minus">
                                                        <div class="stepper-svg">
                                                            <svg version="1.1" id="Capa_1"
                                                                 xmlns="http://www.w3.org/2000/svg"
                                                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                                                 y="0px"
                                                                 width="55.703px" height="55.704px"
                                                                 viewBox="0 0 55.703 55.704"
                                                                 style="enable-background:new 0 0 55.703 55.704;"
                                                                 xml:space="preserve">
                                                                  <g>
                                                                      <g>
                                                                          <path d="M27.851,0C12.495,0,0,12.495,0,27.852s12.495,27.851,27.851,27.851c15.357,0,27.852-12.494,27.852-27.851
                                                                              S43.209,0,27.851,0z M27.851,51.213c-12.882,0-23.362-10.48-23.362-23.362c0-12.882,10.481-23.362,23.362-23.362
                                                                              c12.883,0,23.364,10.48,23.364,23.362C51.215,40.733,40.734,51.213,27.851,51.213z"/>
                                                                          <path d="M38.325,25.607H17.379c-1.239,0-2.244,1.005-2.244,2.244c0,1.239,1.005,2.245,2.244,2.245h20.946
                                                                              c1.239,0,2.244-1.006,2.244-2.245C40.569,26.612,39.564,25.607,38.325,25.607z"/>
                                                                      </g>
                                                                  </g>
                                                              </svg>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                }
                                ?>


                                <li class="stepper-nafarat stepper-gasht">
                                    <div class="item-inner">
                                        <div class="item-title">کودک
                                            <div class="item-gardesh-price">
                                                <span><?php echo number_format($tour['chd_price_rial']); ?><i>ریال</i></span>
                                            </div>
                                        </div>
                                        <div class="item-after">

                                            <div class="stepper stepper-raised stepper-fill stepper-init">
                                                <div class="stepper-button-plus">
                                                    <div class="stepper-svg">
                                                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                             viewBox="0 0 304.223 304.223"
                                                             style="enable-background:new 0 0 304.223 304.223;"
                                                             xml:space="preserve">
                                                                  <g>
                                                                      <g>
                                                                          <path d="M152.112,0C68.241,0,0.008,68.244,0.008,152.114c0,83.865,68.233,152.109,152.103,152.109
                                                                              c83.865,0,152.103-68.244,152.103-152.109C304.215,68.244,235.977,0,152.112,0z M152.112,275.989
                                                                              c-68.32,0-123.891-55.565-123.891-123.875c0-68.326,55.571-123.891,123.891-123.891s123.891,55.565,123.891,123.891
                                                                              C276.003,220.424,220.426,275.989,152.112,275.989z"/>
                                                                          <path d="M221.922,139.186h-56.887V82.298c0-7.141-5.782-12.929-12.923-12.929
                                                                              c-7.141,0-12.929,5.782-12.929,12.929v56.887H82.296c-7.141,0-12.923,5.782-12.923,12.929c0,7.141,5.782,12.923,12.923,12.923
                                                                              h56.882v56.893c0,7.142,5.787,12.923,12.929,12.923c7.141,0,12.929-5.782,12.929-12.923v-56.893h56.882
                                                                              c7.142,0,12.929-5.782,12.929-12.923C234.851,144.967,229.063,139.186,221.922,139.186z"/>
                                                                      </g>
                                                                  </g>
                                                          </svg>
                                                    </div>
                                                </div>
                                                <div class="stepper-input-wrap">
                                                    <input type="text" value="0"
                                                           id="chdNumR<?php echo $countTour; ?>" name="chdNumR<?php echo $countTour; ?>"
                                                           min="0" max="9" step="1" readonly>
                                                </div>
                                                <div class="stepper-button-minus">
                                                    <div class="stepper-svg">
                                                        <svg version="1.1" id="Capa_1"
                                                             xmlns="http://www.w3.org/2000/svg"
                                                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                                             y="0px"
                                                             width="55.703px" height="55.704px"
                                                             viewBox="0 0 55.703 55.704"
                                                             style="enable-background:new 0 0 55.703 55.704;"
                                                             xml:space="preserve">
                                                                  <g>
                                                                      <g>
                                                                          <path d="M27.851,0C12.495,0,0,12.495,0,27.852s12.495,27.851,27.851,27.851c15.357,0,27.852-12.494,27.852-27.851
                                                                              S43.209,0,27.851,0z M27.851,51.213c-12.882,0-23.362-10.48-23.362-23.362c0-12.882,10.481-23.362,23.362-23.362
                                                                              c12.883,0,23.364,10.48,23.364,23.362C51.215,40.733,40.734,51.213,27.851,51.213z"/>
                                                                          <path d="M38.325,25.607H17.379c-1.239,0-2.244,1.005-2.244,2.244c0,1.239,1.005,2.245,2.244,2.245h20.946
                                                                              c1.239,0,2.244-1.006,2.244-2.245C40.569,26.612,39.564,25.607,38.325,25.607z"/>
                                                                      </g>
                                                                  </g>
                                                          </svg>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--<div class="stepper stepper-init stepper-small stepper-raised"  data-value-el="#oranges-count">
                                                <div class="stepper-button-minus">
                                                    <div class="stepper-svg">
                                                        <svg class="site-bg-svg-color" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                             width="55.703px" height="55.704px" viewBox="0 0 55.703 55.704" style="enable-background:new 0 0 55.703 55.704;"
                                                             xml:space="preserve">
                                                              <g>
                                                                  <g>
                                                                      <path d="M27.851,0C12.495,0,0,12.495,0,27.852s12.495,27.851,27.851,27.851c15.357,0,27.852-12.494,27.852-27.851
                                                                          S43.209,0,27.851,0z M27.851,51.213c-12.882,0-23.362-10.48-23.362-23.362c0-12.882,10.481-23.362,23.362-23.362
                                                                          c12.883,0,23.364,10.48,23.364,23.362C51.215,40.733,40.734,51.213,27.851,51.213z"/>
                                                                      <path d="M38.325,25.607H17.379c-1.239,0-2.244,1.005-2.244,2.244c0,1.239,1.005,2.245,2.244,2.245h20.946
                                                                          c1.239,0,2.244-1.006,2.244-2.245C40.569,26.612,39.564,25.607,38.325,25.607z"/>
                                                                  </g>
                                                              </g>
                                                          </svg>
                                                    </div>
                                                </div>
                                                <div class="show-number ChildNumber"><span id="oranges-count"></span></div>
                                                <div class="stepper-button-plus">
                                                    <div class="stepper-svg">
                                                        <svg class="site-bg-svg-color" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                             viewBox="0 0 304.223 304.223" style="enable-background:new 0 0 304.223 304.223;" xml:space="preserve">
                                                              <g>
                                                                  <g>
                                                                      <path d="M152.112,0C68.241,0,0.008,68.244,0.008,152.114c0,83.865,68.233,152.109,152.103,152.109
                                                                          c83.865,0,152.103-68.244,152.103-152.109C304.215,68.244,235.977,0,152.112,0z M152.112,275.989
                                                                          c-68.32,0-123.891-55.565-123.891-123.875c0-68.326,55.571-123.891,123.891-123.891s123.891,55.565,123.891,123.891
                                                                          C276.003,220.424,220.426,275.989,152.112,275.989z"/>
                                                                      <path d="M221.922,139.186h-56.887V82.298c0-7.141-5.782-12.929-12.923-12.929
                                                                          c-7.141,0-12.929,5.782-12.929,12.929v56.887H82.296c-7.141,0-12.923,5.782-12.923,12.929c0,7.141,5.782,12.923,12.923,12.923
                                                                          h56.882v56.893c0,7.142,5.787,12.923,12.929,12.923c7.141,0,12.929-5.782,12.929-12.923v-56.893h56.882
                                                                          c7.142,0,12.929-5.782,12.929-12.923C234.851,144.967,229.063,139.186,221.922,139.186z"/>
                                                                  </g>
                                                              </g>
                                                          </svg>
                                                    </div>
                                                </div>
                                            </div>-->

                                        </div>
                                    </div>
                                </li>

                                <li class="stepper-nafarat stepper-gasht">
                                    <div class="item-inner">
                                        <div class="item-title">نوزاد
                                            <div class="item-gardesh-price">
                                                <span><?php echo number_format($tour['inf_price_rial']); ?><i>ریال</i></span>
                                            </div>
                                        </div>
                                        <div class="item-after">

                                            <div class="stepper stepper-raised stepper-fill stepper-init">
                                                <div class="stepper-button-plus">
                                                    <div class="stepper-svg">
                                                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                             viewBox="0 0 304.223 304.223"
                                                             style="enable-background:new 0 0 304.223 304.223;"
                                                             xml:space="preserve">
                                                                  <g>
                                                                      <g>
                                                                          <path d="M152.112,0C68.241,0,0.008,68.244,0.008,152.114c0,83.865,68.233,152.109,152.103,152.109
                                                                              c83.865,0,152.103-68.244,152.103-152.109C304.215,68.244,235.977,0,152.112,0z M152.112,275.989
                                                                              c-68.32,0-123.891-55.565-123.891-123.875c0-68.326,55.571-123.891,123.891-123.891s123.891,55.565,123.891,123.891
                                                                              C276.003,220.424,220.426,275.989,152.112,275.989z"/>
                                                                          <path d="M221.922,139.186h-56.887V82.298c0-7.141-5.782-12.929-12.923-12.929
                                                                              c-7.141,0-12.929,5.782-12.929,12.929v56.887H82.296c-7.141,0-12.923,5.782-12.923,12.929c0,7.141,5.782,12.923,12.923,12.923
                                                                              h56.882v56.893c0,7.142,5.787,12.923,12.929,12.923c7.141,0,12.929-5.782,12.929-12.923v-56.893h56.882
                                                                              c7.142,0,12.929-5.782,12.929-12.923C234.851,144.967,229.063,139.186,221.922,139.186z"/>
                                                                      </g>
                                                                  </g>
                                                              </svg>
                                                    </div>
                                                </div>
                                                <div class="stepper-input-wrap">
                                                    <input type="text" value="0"
                                                           id="infNumR<?php echo $countTour; ?>" name="infNumR<?php echo $countTour; ?>"
                                                           min="0" max="9" step="1" readonly>
                                                </div>
                                                <div class="stepper-button-minus">
                                                    <div class="stepper-svg">
                                                        <svg version="1.1" id="Capa_1"
                                                             xmlns="http://www.w3.org/2000/svg"
                                                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                                             y="0px"
                                                             width="55.703px" height="55.704px"
                                                             viewBox="0 0 55.703 55.704"
                                                             style="enable-background:new 0 0 55.703 55.704;"
                                                             xml:space="preserve">
                                                                  <g>
                                                                      <g>
                                                                          <path d="M27.851,0C12.495,0,0,12.495,0,27.852s12.495,27.851,27.851,27.851c15.357,0,27.852-12.494,27.852-27.851
                                                                              S43.209,0,27.851,0z M27.851,51.213c-12.882,0-23.362-10.48-23.362-23.362c0-12.882,10.481-23.362,23.362-23.362
                                                                              c12.883,0,23.364,10.48,23.364,23.362C51.215,40.733,40.734,51.213,27.851,51.213z"/>
                                                                          <path d="M38.325,25.607H17.379c-1.239,0-2.244,1.005-2.244,2.244c0,1.239,1.005,2.245,2.244,2.245h20.946
                                                                              c1.239,0,2.244-1.006,2.244-2.245C40.569,26.612,39.564,25.607,38.325,25.607z"/>
                                                                      </g>
                                                                  </g>
                                                              </svg>
                                                    </div>
                                                </div>
                                            </div>

                                            <!--<div class="stepper stepper-init stepper-small stepper-raised" data-value-el="#oranges-count2">
                                                <div class="stepper-button-minus">
                                                    <div class="stepper-svg">
                                                        <svg class="site-bg-svg-color" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                             width="55.703px" height="55.704px" viewBox="0 0 55.703 55.704" style="enable-background:new 0 0 55.703 55.704;"
                                                             xml:space="preserve">
                                                              <g>
                                                                  <g>
                                                                      <path d="M27.851,0C12.495,0,0,12.495,0,27.852s12.495,27.851,27.851,27.851c15.357,0,27.852-12.494,27.852-27.851
                                                                          S43.209,0,27.851,0z M27.851,51.213c-12.882,0-23.362-10.48-23.362-23.362c0-12.882,10.481-23.362,23.362-23.362
                                                                          c12.883,0,23.364,10.48,23.364,23.362C51.215,40.733,40.734,51.213,27.851,51.213z"/>
                                                                      <path d="M38.325,25.607H17.379c-1.239,0-2.244,1.005-2.244,2.244c0,1.239,1.005,2.245,2.244,2.245h20.946
                                                                          c1.239,0,2.244-1.006,2.244-2.245C40.569,26.612,39.564,25.607,38.325,25.607z"/>
                                                                  </g>
                                                              </g>
                                                          </svg>
                                                    </div>
                                                </div>
                                                <div class="show-number InfantNumber"><span id="oranges-count2"></span></div>
                                                <div class="stepper-button-plus">
                                                    <div class="stepper-svg">
                                                        <svg class="site-bg-svg-color" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                             viewBox="0 0 304.223 304.223" style="enable-background:new 0 0 304.223 304.223;" xml:space="preserve">
                                                              <g>
                                                                  <g>
                                                                      <path d="M152.112,0C68.241,0,0.008,68.244,0.008,152.114c0,83.865,68.233,152.109,152.103,152.109
                                                                          c83.865,0,152.103-68.244,152.103-152.109C304.215,68.244,235.977,0,152.112,0z M152.112,275.989
                                                                          c-68.32,0-123.891-55.565-123.891-123.875c0-68.326,55.571-123.891,123.891-123.891s123.891,55.565,123.891,123.891
                                                                          C276.003,220.424,220.426,275.989,152.112,275.989z"/>
                                                                      <path d="M221.922,139.186h-56.887V82.298c0-7.141-5.782-12.929-12.923-12.929
                                                                          c-7.141,0-12.929,5.782-12.929,12.929v56.887H82.296c-7.141,0-12.923,5.782-12.923,12.929c0,7.141,5.782,12.923,12.923,12.923
                                                                          h56.882v56.893c0,7.142,5.787,12.923,12.929,12.923c7.141,0,12.929-5.782,12.929-12.923v-56.893h56.882
                                                                        s  c7.142,0,12.929-5.782,12.929-12.923C234.851,144.967,229.063,139.186,221.922,139.186z"/>
                                                                  </g>
                                                              </g>
                                                          </svg>
                                                    </div>
                                                </div>
                                            </div>-->

                                        </div>
                                    </div>
                                </li>


                            </ul>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <input type="hidden" name="countOneDayTour" id="countOneDayTour" value="<?php echo $countTour; ?>">

            </div>
        </div>
    </div>

    <?php
}
?>


<input type="hidden" name="ZoneFlight" id="ZoneFlight" value="<?php echo $objResult->infoReservationHotel['ZoneFlight']; ?>">

<input type="hidden" name="TypeRoomHotel" id="TypeRoomHotel" value="<?php echo $objResult->TotalRoomId; ?>">
<input type="hidden" name="guestUserStatus" id="guestUserStatus" value="<?php echo $objResult->guestUserStatus; ?>">

<input type="hidden" id="TotalPrice_Reserve" name="TotalPrice_Reserve" value="<?php echo $formData['totalPriceHotel']; ?>">
<input type="hidden" id="RoomTypeCodes_Reserve" name="RoomTypeCodes_Reserve" value="<?php echo $roomTypeCodes; ?>">
<input type="hidden" id="NumberOfRooms_Reserve" name="NumberOfRooms_Reserve" value="<?php echo $numberOfRooms; ?>">