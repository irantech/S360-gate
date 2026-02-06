<?php
$roomTypeCodes = '';
$numberOfRooms = '';
$totalPrice = 0;
$countPassenger = 0;
$expCountRoomReserve = explode(",", $formData['totalNumberRoomReserve']);
for ($i = 0; $i < count($expCountRoomReserve); $i++) {
    $expCountAnyRoom = explode("-", $expCountRoomReserve[$i]);
    $roomId = $expCountAnyRoom[0];
    $roomCount = $expCountAnyRoom[1];

    $roomTypeCodes .= ',' . $roomId;
    $numberOfRooms .= ',' . $roomCount;
    $totalPrice += $formData['finalPriceRoom' . $roomId];

    for ($j = 1; $j <= $roomCount; $j++) {
        $countPassenger++;
        
        ?>

        <input type="hidden" name="RoomCount_Reserve<?php echo $roomId; ?>"
               id="RoomCount_Reserve<?php echo $roomId; ?>" value="<?php echo $roomCount; ?>">
        <input type="hidden" name="Id_Select_Room<?php echo $countPassenger; ?>"
               id="Id_Select_Room<?php echo $countPassenger; ?>" value="<?php echo $roomId; ?>">

        <div class="passenger-info hotel-passenger-info">
            <div class="accordion-list custom-accordion">
                <div class="accordion-item">
                    <div class="accordion-item-toggle bozorgsal-passenger">
                        <span>اطلاعات سرپرست برای اتاق <?php echo $j; ?></span>
                        <span><?php echo $formData['nameRoom' . $roomId]; ?></span>
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
                                        <div class="item-title item-floating-label">نام خانوادگی
                                            (انگلیسی)
                                        </div>
                                        <div class="item-input-wrap">
                                            <input type="text"
                                                   id="familyEnA<?php echo $countPassenger; ?>"
                                                   name="familyEnA<?php echo $countPassenger; ?>">
                                            <span class="input-clear-button"></span>
                                        </div>
                                    </div>
                                </li>

                                <input type="hidden" name="birthdayA<?php echo $i ?>" id="birthdayA<?php echo $countPassenger ?>">
                                <input type="hidden" name="birthdayEnA<?php echo $i ?>" id="birthdayEnA<?php echo $countPassenger ?>">

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


                                <li class="item-content item-input">
                                    <div class="item-media">
                                        <i class="icon demo-list-icon"></i>
                                    </div>
                                    <div class="item-inner">
                                        <div class="item-title item-floating-label">انتخاب چیدمان تخت
                                        </div>
                                        <div class="item-input-wrap selectionBedType">
                                            <select placeholder="Please choose..."
                                                    name="BedType<?php echo $countPassenger ?>"
                                                    id="BedType<?php echo $countPassenger ?>">
                                                <option value="Double">تخت دو نفره</option>
                                                <option value="Twin">تخت تک نفره</option>
                                            </select>
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

    }
}
?>


<input type="hidden" name="ZoneFlight" id="ZoneFlight" value="Local">
<input type="hidden" id="TotalPrice_Reserve" name="TotalPrice_Reserve" value="<?php echo $totalPrice; ?>">
<input type="hidden" id="RoomTypeCodes_Reserve" name="RoomTypeCodes_Reserve" value="<?php echo $roomTypeCodes; ?>">
<input type="hidden" id="NumberOfRooms_Reserve" name="NumberOfRooms_Reserve" value="<?php echo $numberOfRooms; ?>">