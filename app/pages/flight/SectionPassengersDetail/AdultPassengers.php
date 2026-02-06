<?php if ($AdultCount > 0) {
    for ($i = 1; $i <= $AdultCount; $i++) {
        ?>
        <input type="hidden" name="birthdayA<?php echo $i ?>" id="birthdayA<?php echo $i ?>">
        <input type="hidden" name="birthdayEnA<?php echo $i ?>" id="birthdayEnA<?php echo $i ?>">
        <div class="accordion-item">
            <div class="accordion-item-toggle bozorgsal-passenger">
                <span>اطلاعات مسافر</span>
                <span>(بزرگسال)</span>
                <i></i>
            </div>
            <div class="accordion-item-content">
                <div class="list list-passenger">
                    <ul>
                        <li>
                            <a class="link popup-open list-mosaferan-btn site-border-main-color site-main-text-color"
                               href="#" data-popup=".popup-passenger-lists"
                               onclick="SelectOldPassenger('A<?php echo $i ?>')">انتخاب از لیست
                                مسافران</a>
                        </li>

                        <li class="passenger-info-li passenger-nationality">
                            <span>ملیت :</span>
                            <div>
                                <label class="item-radio radio">
                                    <input class="nationality-choose LocalA<?php echo $i ?>"
                                           type="radio"
                                           id="passengerNationalityA<?php echo $i ?>"
                                           name="passengerNationalityA<?php echo $i ?>"
                                           value="0" checked="checked"
                                    />
                                    <i
                                        class="icon-radio"></i>
                                    <div class="item-inner">
                                        <!-- Radio Title -->
                                        <div class="item-title">ایرانی</div>
                                    </div>
                                </label>
                                <label class="item-radio radio"><input
                                        class="nationality-choose ForeignA<?php echo $i ?>"
                                        type="radio"
                                        name="passengerNationalityA<?php echo $i ?>"
                                        id="passengerNationalityA<?php echo $i ?>"
                                        value="1"/><i
                                        class="icon-radio"></i>
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
                                    <input type="radio" class="MaleA<?php echo $i ?>"
                                           name="genderA<?php echo $i ?>"
                                           id="genderA<?php echo $i ?>" value="Male"
                                           checked="checked">
                                    <i class="icon-radio"></i>
                                    <div class="item-inner">
                                        <!-- Radio Title -->
                                        <div class="item-title">مرد</div>
                                    </div>
                                </label>
                                <label class="item-radio radio">
                                    <input type="radio" class="FemaleA<?php echo $i ?>"
                                           name="genderA<?php echo $i ?>"
                                           id="genderA<?php echo $i ?>" value="Female">
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
                                    <input type="text" value="" class="NamePersian"
                                           name="nameFaA<?php echo $i ?>"
                                           id="nameFaA<?php echo $i ?>">
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
                                    <input type="text" value="" name="familyFaA<?php echo $i ?>"
                                           id="familyFaA<?php echo $i ?>">
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
                                    <input type="text" value="" name="nameEnA<?php echo $i ?>"
                                           id="nameEnA<?php echo $i ?>">
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
                                    <input type="text" value="" name="familyEnA<?php echo $i ?>"
                                           id="familyEnA<?php echo $i ?>">
                                    <span class="input-clear-button"></span>
                                </div>
                            </div>
                        </li>

                        <li class="item-content item-input birthday-select shamsi-bd <?php echo ($FlightZone !='Local') ? 'myhidden':''?>">
                            <div class="item-inner">
                                <div class="item-title item-label">تاریخ تولد (شمسی)</div>
                                <div class="item-input-wrap input-dropdown-wrap">
                                    <select placeholder="لطفا انتخاب کنید..."
                                            name="YearJalaliA<?php echo $i ?>"
                                            id="YearJalaliA<?php echo $i ?>">
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
                                            name="MonthJalaliA<?php echo $i ?>"
                                            id="MonthJalaliA<?php echo $i ?>">
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
                                            name="DayJalaliA<?php echo $i ?>"
                                            id="DayJalaliA<?php echo $i ?>">
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


                        <li class="item-content item-input birthday-select miladi-bd <?php echo ($FlightZone =='Local') ? 'myhidden':''?>">
                            <div class="item-inner">
                                <div class="item-title item-label">تاریخ تولد (میلادی)</div>
                                <div class="item-input-wrap input-dropdown-wrap">
                                    <select placeholder="Please choose..."
                                            name="YearMiladiA<?php echo $i ?>"
                                            id="YearMiladiA<?php echo $i ?>">
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
                                            name="MonthMiladiA<?php echo $i ?>"
                                            id="MonthMiladiA<?php echo $i ?>">
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
                                            name="DayMiladiA<?php echo $i ?>"
                                            id="DayMiladiA<?php echo $i ?>">
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
                        <li class="item-content item-input country-passport <?php echo ($FlightZone =='Local') ? 'myhidden':''?>">
                            <div class="item-inner">
                                <div class="item-title item-label">کشور صادر کننده پاسپورت</div>
                                <div class="item-input-wrap input-dropdown-wrap">
                                    <select placeholder="Please choose..."
                                            name="passportCountryA<?php echo $i ?>"
                                            id="passportCountryA<?php echo $i ?>">
                                        <option value="">انتخاب کنید</option>
                                        <?php foreach ($PassportCountry as $Country){?>
                                            <option value="<?php echo $Country['code']?>"><?php echo $Country['titleFa']?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>

                        </li>


                        <li class="item-content item-input code-melli <?php echo ($FlightZone !='Local') ? 'myhidden':''?>">
                            <div class="item-media">
                                <i class="icon demo-list-icon"></i>
                            </div>
                            <div class="item-inner">
                                <div class="item-title item-floating-label">کد ملی</div>
                                <div class="item-input-wrap">
                                    <input type="text" class="UniqNationalCode" value=""
                                           name="NationalCodeA<?php echo $i ?>"
                                           id="NationalCodeA<?php echo $i ?>" required validate
                                           pattern="[0-9]*"
                                           data-error-message="لطفا  فقط عدد وارد نمائید">
                                    <span class="input-clear-button"></span>
                                </div>
                            </div>
                        </li>

                        <li class="item-content item-input passportNumber <?php echo ($FlightZone =='Local') ? 'myhidden':''?>">
                            <div class="item-media">
                                <i class="icon demo-list-icon"></i>
                            </div>

                            <div class="item-inner ">
                                <div class="item-title item-floating-label">شماره پاسپورت</div>
                                <div class="item-input-wrap">
                                    <input type="text" value=""
                                           name="passportNumberA<?php echo $i ?>"
                                           id="passportNumberA<?php echo $i ?>" required
                                           validate
                                           data-error-message="لطفا  شماره پاسپورت را وارد نمائید">
                                    <span class="input-clear-button"></span>
                                </div>
                            </div>
                        </li>

                        <li class="item-content item-input passportExpire <?php echo ($FlightZone =='Local') ? 'myhidden':''?>">
                            <div class="item-media">
                                <i class="icon demo-list-icon"></i>
                            </div>

                            <div class="item-inner">
                                <div class="item-title item-label">تاریخ انقضای پاسپورت</div>
                                <div class="item-input-wrap ReturnDate">
                                    <input type="text" readonly="readonly"
                                           placeholder="--/--/----"
                                           id="passportExpireA<?php echo $i; ?>" class="passportengheza"/>
                                </div>
                            </div>
                        </li>

                    </ul>
                </div>


            </div>
        </div>
    <?php }
} ?>