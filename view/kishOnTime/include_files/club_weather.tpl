<div class="i_modular_club_weather arz-parent">
    <div class="arz">
        <div class="arz-parent-opacity">
            <div class="container-fluid"> <!-- arz & date -->
                <div class="row arz-parent">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 mb-4">
                        <div class="service">
                            <div class="icon-holder"><i class="fas fa-3x fa-user-plus"></i></div>
                            <h4 class="heading">عضویت در باشگاه</h4>
                            <p class="description">دنیای پر رقابت امروز، تنها شرکت هایی موفق خواهند بود که در مسیر

                                شناخت نیاز مشتریان خود گام برداشته و بتوانند با سرعت هر چه بیشتر، کیفیت هر چه بهتر و

                                دسترسی دنیای پر رقابت امروز، تنها شرکت هایی موفق خواهند بود که در مسیر شناخت نیاز

                                مشتریان خود گام برداشته و بتوانند با سرعت هر چه بیشتر، کیفیت هر چه بهتر و دسترسی

                                آسان تر به آن پاسخ مناسب دهند

                            </p>
                            <div class="btns">
                                <a class="service-btn login-btn" href="{$smarty.const.ROOT_ADDRESS}/authenticate">ورود</a>
                                <a class="service-btn register-btn" href="{$smarty.const.ROOT_ADDRESS}/authenticate">ثبت نام</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 mb-4">
                        <div class="__date_convertor__ service shamsiConvertDate">
                            <div class="icon-holder"><i class="fas fa-3x fa-calendar-alt"></i></div>
                            <h4 class="heading convert-date-parent">تبدیل تاریخ</h4>
                            <div class="convert-date">
                                <div class="tabdil">
                                    <input class="__JalaliToMiladi_input__ convertShamsiMiladiCalendar"
                                           placeholder="##ConvertToGregorian##" name="txtShamsiCalendar" id="txtShamsiCalendar" type="text" />
                                    <button class="__JalaliToMiladi_button__" id="shamsiConvertButton" onclick="convertJalaliToMiladi()">به میلادی
                                    </button>
                                    <div class="resultdate" id="showJalaliResult"></div>
                                </div>
                                <div class="tabdil">
                                    <input class="__MiladiToJalali_input__ convertMiladiShamsiCalendar"
                                                           id="txtMiladiCalendar" name="txtMiladiCalendar"
                                                           placeholder="تاریخ میلادی" type="text" />
                                    <button class="__MiladiToJalali_button__" id="miladiConvertButton" onclick="convertMiladiToJalali()">به شمسی
                                    </button>
                                    <div class="resultdate" id="showMiladiResult"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 mb-4">
                        <div class="service">
                            <div class="icon-holder"><i class="fas fa-3x fa-sun"></i></div>
                            <h4 class="heading">هواشناسی</h4>
                            <p class="description">توسط این بخش می تواند منطقه یا مناطق جغرافیایی را جهت نمایش وضعیت

                                آب هوایی انتخاب نماید.تا در زمان گردش بیشترین لذت را از مسافرت خود داشته باشیدتوسط

                                این بخش می تواند منطقه یا مناطق جغرافیایی را جهت آب هوایی انتخاب نماید.</p>
                            <div class="btns"><a class="service-btn SMWeather"
                                                 href="{$smarty.const.ROOT_ADDRESS}/weather">هواشناسی</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>