<?php if ($InfantCount > 0) {
    for ($i = 1; $i <= $InfantCount; $i++) {
        ?>
        <input type="hidden" name="birthdayI<?php echo $i ?>" id="birthdayI<?php echo $i ?>">
        <input type="hidden" name="birthdayEnI<?php echo $i ?>" id="birthdayEnI<?php echo $i ?>">

        <div class="accordion-item">
            <div class="accordion-item-toggle bozorgsal-passenger">
                <span>اطلاعات مسافر</span>
                <span>(نوزاد)</span>
                <i></i>
            </div>
            <div class="accordion-item-content">

                <div class="list list-passenger">

                    <ul>

                        <li>
                            <a class="link popup-open list-mosaferan-btn site-border-main-color site-main-text-color"
                               href="#" data-popup=".popup-passenger-lists"
                               onclick="SelectOldPassenger('I<?php echo $i ?>')">انتخاب از لیست
                                مسافران</a>
                        </li>

                        <li class="passenger-info-li passenger-nationality">
                            <span>ملیت :</span>
                            <div>
                                <label class="item-radio radio">
                                    <input class="nationality-choose"
                                           type="radio"
                                           id="passengerNationalityI<?php echo $i ?>"
                                           name="passengerNationalityI<?php echo $i ?>"
                                           value="0" checked="checked"
                                    />
                                    <i
                                        class="icon-radio"></i>
                                    <div class="item-inner">
                                        <!-- Radio Title -->
                                        <div class="item-title">ایرانی</div>
                                    </div>
                                </label>
                                <label class="item-radio radio"><input class="nationality-choose"
                                                                       type="radio"
                                                                       name="passengerNationalityI<?php echo $i ?>"
                                                                       id="passengerNationalityI<?php echo $i ?>"
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
                                    <input type="radio" name="genderI<?php echo $i ?>"
                                           id="genderI<?php echo $i ?>" value="Male" checked="checked">
                                    <i class="icon-radio"></i>
                                    <div class="item-inner">
                                        <!-- Radio Title -->
                                        <div class="item-title">مرد</div>
                                    </div>
                                </label>
                                <label class="item-radio radio">
                                    <input type="radio" name="genderI<?php echo $i ?>"
                                           id="genderI<?php echo $i ?>" value="Female">
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
                                    <input type="text" value="" name="nameFaI<?php echo $i ?>"
                                           id="nameFaI<?php echo $i ?>">
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
                                    <input type="text" value="" name="familyFaI<?php echo $i ?>"
                                           id="familyFaI<?php echo $i ?>">
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
                                    <input type="text" value="" name="nameEnI<?php echo $i ?>"
                                           id="nameEnI<?php echo $i ?>">
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
                                    <input type="text" value="" name="familyEnI<?php echo $i ?>"
                                           id="familyEnI<?php echo $i ?>">
                                    <span class="input-clear-button"></span>
                                </div>
                            </div>
                        </li>

                        <li class="item-content item-input birthday-select shamsi-bd <?php echo ($FlightZone !='Local') ? 'myhidden':''?>">
                            <div class="item-inner">
                                <div class="item-title item-label">تاریخ تولد (شمسی)</div>
                                <div class="item-input-wrap input-dropdown-wrap">
                                    <select placeholder="لطفا انتخاب کنید..."
                                            name="YearJalaliI<?php echo $i ?>"
                                            id="YearJalaliI<?php echo $i ?>">
                                        <?php for ($Shi = 0; $Shi < 3; $Shi++) { ?>
                                            <option value="<?php echo dateTimeSetting::jdate("Y", time() - ($Shi * (12 * 30 * 24 * 60 * 60)), '', '', 'en') ?>"><?php echo dateTimeSetting::jdate("Y", time() - ($Shi * (12 * 30 * 24 * 60 * 60))) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="item-inner">
                                <div class="item-title item-label">.</div>
                                <div class="item-input-wrap input-dropdown-wrap">
                                    <select placeholder="Please choose..."
                                            name="MonthJalaliI<?php echo $i ?>"
                                            id="MouthJalaliI<?php echo $i ?>">
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
                                            name="DayJalaliI<?php echo $i ?>"
                                            id="DayJalaliI<?php echo $i ?>">
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
                                            name="YearMiladiI<?php echo $i ?>"
                                            id="YearMiladiI<?php echo $i ?>">
                                        <?php for ($MiI = 0; $MiI < 3; $MiI++) { ?>
                                            <option value="<?php echo date("Y", time() - ($MiI * (12 * 30 * 24 * 60 * 60))) ?>"><?php echo date("Y", time() - ($MiI * (12 * 30 * 24 * 60 * 60))) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="item-inner">
                                <div class="item-title item-label">.</div>
                                <div class="item-input-wrap input-dropdown-wrap">
                                    <select placeholder="Please choose..."
                                            name="MonthMiladiI<?php echo $i ?>"
                                            id="MonthMiladiI<?php echo $i ?>">
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
                                            name="DayMiladiI<?php echo $i ?>"
                                            id="DayMiladiI<?php echo $i ?>">
                                        <option value="01">1</option>
                                        <option value="02">2</option>
                                        <option value="03">3</option>
                                        <option value="04">4</option>
                                        <option value="05">5</option>
                                        <option value="06">6</option>
                                        <option value="07">7</option>
                                        <option value="08">8</option>
                                        <option value="09">9</option>
                                        <option value="010">10</option>
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

                        <li class="item-content item-input code-melli <?php echo ($FlightZone !='Local') ? 'myhidden':''?>">
                            <div class="item-media">
                                <i class="icon demo-list-icon"></i>
                            </div>
                            <div class="item-inner">
                                <div class="item-title item-floating-label">کد ملی</div>
                                <div class="item-input-wrap">
                                    <input type="text" class="UniqNationalCode" value=""
                                           name="NationalCodeI<?php echo $i ?>" id="NationalCodeI<?php echo $i ?>"
                                           required validate pattern="[0-9]*"
                                           data-error-message="لطفا  فقط عدد وارد نمائید">
                                    <span class="input-clear-button"></span>
                                </div>
                            </div>
                        </li>

                        <li class="item-content item-input country-passport <?php echo ($FlightZone =='Local') ? 'myhidden':''?>">
                            <div class="item-inner">
                                <div class="item-title item-label">کشور صادر کننده پاسپورت</div>
                                <div class="item-input-wrap input-dropdown-wrap">
                                    <select placeholder="Please choose..."
                                            name="passportCountryI<?php echo $i ?>"
                                            id="passportCountryI<?php echo $i ?>">
                                        <option value="">انتخاب کنید</option>
                                        <?php foreach ($PassportCountry as $Country){?>
                                            <option value="<?php echo $Country['code']?>"><?php echo $Country['titleFa']?></option>
                                        <?php }?>


                                    </select>
                                </div>
                            </div>

                        </li>

                        <li class="item-content item-input passportNumber <?php echo ($FlightZone =='Local') ? 'myhidden':''?>">
                            <div class="item-media">
                                <i class="icon demo-list-icon"></i>
                            </div>
                            <div class="item-inner">
                                <div class="item-title item-floating-label">شماره پاسپورت</div>
                                <div class="item-input-wrap">
                                    <input type="text" value="" name="passportNumberI<?php echo $i ?>"
                                           id="passportNumberI<?php echo $i ?>" required validate
                                           data-error-message="لطفا  شماره پا وارد نمائید">
                                    <span class="input-clear-button"></span>
                                </div>
                            </div>
                        </li>

                        <li class="item-content item-input passportExpire <?php echo ($FlightZone =='Local') ? 'myhidden':''?>">
                            <div class="item-media">
                                <i class="icon demo-list-icon"></i>
                            </div>

                            <div class="item-inner">
                                <div class="item-title item-floating-label">تاریخ انقضاء پاسپورت
                                </div>
                                <div class="item-input-wrap">
                                    <input type="text" value="" name="passportExpireI<?php echo $i ?>"
                                           id="passportExpireI<?php echo $i ?>">
                                    <span class="input-clear-button"></span>
                                </div>
                            </div>
                        </li>

                    </ul>
                </div>


            </div>
        </div>
    <?php }
} ?>