<section class="i_modular_club_weather section_boxs py-5">
    <div class="container">
        <div class="d-flex flex-wrap">
{*            <div class="col-lg-3 p-1 col-12">*}
{*                <div class="links_box">*}
{*                    <div class="icon_box flatbox">*}
{*                        <i class="fa-regular fa-suitcase-rolling"></i>*}
{*                    </div>*}
{*                    <a class="ttt" href="javascript:">خدمات گردشگری</a>*}
{*                    <div class="captin_box"><p>خدمات گردشگری ارائه شده توسط سانی تور شامل تدارک اقامت، بلیط‌های هواپیما و کلیه خدمات مرتبط با تورها و ارائه راهنمایی‌های مفید برای سفرهای راحت و خاطره‌انگیز است.</p></div>*}
{*                    <div class="links_btn">*}
{*                        <a href="{$smarty.const.ROOT_ADDRESS}/orderServices" class="cta"><span>خدمات گردشگری</span></a>*}
{*                    </div>*}
{*                </div>*}
{*            </div>*}
            <div class="__date_convertor__ col-lg-4 p-1 col-12">
                <div class="links_box date_convert shamsiConvertDate">
                    <div class="icon_date flatbox">
                        <i class="fa-regular fa-calendars"></i>
                    </div>
                    <a class="ttt" href="javascript:"> تبدیل تاریخ</a>
                    <div class="captin_box">
                        <div class="form__group field">
                            <button class=" __JalaliToMiladi_input__  form__label btn_abs" id="shamsiConvertButton" onclick="convertJalaliToMiladi()" type="button">تبدیل

                            </button>
                            <input value="" type="text" readonly="" class="__MiladiToJalali_input__ form__field  convertShamsiMiladiCalendar"
                                   placeholder="##ConvertToGregorian##" name="txtShamsiCalendar" id="txtShamsiCalendar">
                        </div>
                        <div class="resultdate" id="showJalaliResult"></div>
                        <div class="form__group field">
                            <button class="__JalaliToMiladi_button__ form__label btn_abs" id="miladiConvertButton" onclick="convertMiladiToJalali()" type="button">تبدیل

                            </button>
                            <input type="text" readonly="" class="form__field  convertMiladiShamsiCalendar"
                                   placeholder="##ConvertSolar##" name="txtMiladiCalendar" id="txtMiladiCalendar">

                        </div>
                        <div class="resultdate" id="showMiladiResult"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 p-1 col-12 meteorology">
                <div class="links_box">
                    <div class=" flatbox">
                        <i class="fa-solid fa-earth-asia"></i>
                    </div>
                    <a class="ttt" href="{$smarty.const.ROOT_ADDRESS}/aboutCountry">  معرفی کشور ها</a>
                    <div class="captin_box"><p>سانی تور با معرفی کشورها، به مسافران امکان می‌دهند تا فرهنگ و زیبایی‌های هر کشور را به شیوه‌ای ممتاز تجربه کنند.</p></div>
                    <div class="links_btn"><a href="{$smarty.const.ROOT_ADDRESS}/aboutCountry" class="cta SMWeather"><span>معرفی کشور ها</span></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 p-1 col-12 exchange_rate">
                <div class="links_box">
                    <div class="icon_arz flatbox">
                        <i class="fa-light fa-map-location-dot"></i>
                    </div>
                    <a class="ttt SMChange" href="{$smarty.const.ROOT_ADDRESS}/aboutIran"> معرفی ایران</a>
                    <div class="captin_box"><p>سانی تور با محتواگذاری در جهت معرفی کشورمان ایران، به گردشگران فرصت می‌دهند تا اطلاعاتی درباره غنای فرهنگی، تاریخی و طبیعی کشور خود بدست آوریم.</p></div>
                    <div class="links_btn"><a href="{$smarty.const.ROOT_ADDRESS}/aboutIran" class="cta SMChange"><span>معرفی ایران </span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>