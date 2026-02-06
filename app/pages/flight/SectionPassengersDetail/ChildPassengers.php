<?php if ($ChildCount > 0) {
    for ($i = 1; $i <= $ChildCount; $i++) {
        ?>
        <input type="hidden" name="birthdayC<?php echo $i ?>" id="birthdayC<?php echo $i ?>">
        <input type="hidden" name="birthdayEnC<?php echo $i ?>" id="birthdayEnC<?php echo $i ?>">
        <div class="accordion-item">
            <div class="accordion-item-toggle bozorgsal-passenger">
                <span>اطلاعات مسافر</span>
                <span>(کودک)</span>
                <i></i>
            </div>
            <div class="accordion-item-content">

                <div class="list list-passenger">

                    <ul>
                        <li>
                            <a class="link popup-open list-mosaferan-btn site-border-main-color site-main-text-color"
                               href="#" data-popup=".popup-passenger-lists"
                               onclick="SelectOldPassenger('C<?php echo $i ?>')">انتخاب از لیست
                                مسافران</a>
                        </li>

                        <li class="passenger-info-li passenger-nationality">
                            <span>ملیت :</span>
                            <div>
                                <label class="item-radio radio">
                                    <input class="nationality-choose LocalC<?php echo $i ?>"
                                           type="radio"
                                           id="passengerNationalityC<?php echo $i ?>"
                                           name="passengerNationalityC<?php echo $i ?>"
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
                                        class="nationality-choose ForeignC<?php echo $i ?>"
                                        type="radio"
                                        name="passengerNationalityC<?php echo $i ?>"
                                        id="passengerNationalityC<?php echo $i ?>"
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
                                    <input type="radio" name="genderC<?php echo $i ?>" id="genderC<?php echo $i ?>"
                                           value="Male" checked="checked">
                                    <i class="icon-radio"></i>
                                    <div class="item-inner">
                                        <!-- Radio Title -->
                                        <div class="item-title">مرد</div>
                                    </div>
                                </label>
                                <label class="item-radio radio">
                                    <input type="radio" name="genderC<?php echo $i ?>" id="genderC<?php echo $i ?>"
                                           value="Female">
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
                                    <input type="text" value="" name="nameFaC<?php echo $i ?>"
                                           id="nameFaC<?php echo $i ?>">
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
                                    <input type="text" value="" name="familyFaC<?php echo $i ?>"
                                           id="familyFaC<?php echo $i ?>">
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
                                    <input type="text" value="" name="nameEnC<?php echo $i ?>"
                                           id="nameEnC<?php echo $i ?>">
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
                                    <input type="text" value="" name="familyEnC<?php echo $i ?>"
                                           id="familyEnC<?php echo $i ?>">
                                    <span class="input-clear-button"></span>
                                </div>
                            </div>
                        </li>

                        <li class="item-content item-input birthday-select shamsi-bd <?php echo ($FlightZone !='Local') ? 'myhidden':''?>" >
                            <div class="item-inner">
                                <div class="item-title item-label">تاریخ تولد (شمسی)</div>
                                <div class="item-input-wrap input-dropdown-wrap">
                                    <select placeholder="لطفا انتخاب کنید..." name="YearJalaliC<?php echo $i ?>"
                                            id="YearJalaliC<?php echo $i ?>">
                                        <?php for ($ShC = 2; $ShC < 13; $ShC++) { ?>
                                            <option value="<?php echo dateTimeSetting::jdate("Y", time() - ($ShC * (12 * 30 * 24 * 60 * 60)), '', '', 'en') ?>"><?php echo dateTimeSetting::jdate("Y", time() - ($ShC * (12 * 30 * 24 * 60 * 60))) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="item-inner">
                                <div class="item-title item-label">.</div>
                                <div class="item-input-wrap input-dropdown-wrap">
                                    <select placeholder="Please choose..." name="MonthJalaliC<?php echo $i ?>"
                                            id="MonthJalaliC<?php echo $i ?>">
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
                                    <select placeholder="Please choose..." name="DayJalaliC<?php echo $i ?>"
                                            id="DayJalaliC<?php echo $i ?>">
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
                                    <select placeholder="Please choose..." name="YearMiladiC<?php echo $i ?>"
                                            id="YearMiladiC<?php echo $i ?>">
                                        <?php for ($Mic = 2; $Mic < 13; $Mic++) { ?>
                                            <option value="<?php echo date("Y", time() - ($Mic * (12 * 30 * 24 * 60 * 60))) ?>"><?php echo date("Y", time() - ($Mic * (12 * 30 * 24 * 60 * 60))) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="item-inner">
                                <div class="item-title item-label">.</div>
                                <div class="item-input-wrap input-dropdown-wrap">
                                    <select placeholder="Please choose..." name="MonthMiladiC<?php echo $i ?>"
                                            id="MonthMiladiC<?php echo $i ?>">
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
                                    <select placeholder="Please choose..." name="DayMiladiC<?php echo $i ?>"
                                            id="DayMiladiC<?php echo $i ?>">
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
                                            name="passportCountryC<?php echo $i ?>"
                                            id="passportCountryC<?php echo $i ?>">
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
                                           name="NationalCodeC<?php echo $i ?>" id="NationalCodeC<?php echo $i ?>"
                                           required validate pattern="[0-9]*"
                                           data-error-message="لطفا  فقط عدد وارد نمائید">
                                    <span class="input-clear-button"></span>
                                </div>
                            </div>
                        </li>

                        <li class="item-content item-input  passportNumber <?php echo ($FlightZone =='Local') ? 'myhidden':''?>">
                            <div class="item-media">
                                <i class="icon demo-list-icon"></i>
                            </div>

                            <div class="item-inner">
                                <div class="item-title item-floating-label">شماره پاسپورت</div>
                                <div class="item-input-wrap">
                                    <input type="text" value="" name="passportNumberC<?php echo $i ?>"
                                           id="passportNumberC<?php echo $i ?>" required validate
                                           data-error-message="لطفا شماره پاسپورت را وارد نمائید">
                                    <span class="input-clear-button"></span>
                                </div>
                            </div>
                        </li>

                        <li class="item-content item-input  passportExpire <?php echo ($FlightZone =='Local') ? 'myhidden':''?>">
                            <div class="item-media">
                                <i class="icon demo-list-icon"></i>
                            </div>

                            <div class="item-inner">
                                <div class="item-title item-floating-label">تاریخ انقضاء پاسپورت
                                </div>
                                <div class="item-input-wrap">
                                    <input type="text" value="" name="passportExpireC<?php echo $i ?>"
                                           id="passportExpireC<?php echo $i ?>">
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