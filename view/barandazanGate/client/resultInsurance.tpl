{load_presentation_object filename="insurance" assign="objInsurance"}
{load_presentation_object filename="currencyEquivalent" assign="objCurrency"}
{assign var="search_result" value=$objInsurance->searchResult()}
{assign var="discount_data" value=$search_result['discount_data']}
{assign var="markup_data" value=$search_result['markup_data']}
{assign var="planInfo" value=$search_result['data']}
{assign var="allCountry" value=$objInsurance->getAllCountry()}
{assign var="i" value="1"}

{assign var="classNameBirthdayCalendar" value="shamsiBirthdayCalendar"}
{if $smarty.const.SOFTWARE_LANG neq 'fa'}
    {$classNameBirthdayCalendar="gregorianBirthdayCalendar"}
{/if}
{if $smarty.const.INSURANCE_TYPE == '1'}
    {$classNameBirthdayCalendar="gregorianBirthdayCalendar"}
{/if}

{*{assign var="classNameBirthdayCalendarAddedEn" value="gregorianBirthdayCalendar"}*}

{if $smarty.const.INSURANCE_TYPE == '1'}
    {$classNameBirthdayCalendarAdded="shamsiBirthdayCalendar"}
{/if}

{if $smarty.session.CurrencyUnit eq ''}

    {$objSession->setCurrency()}
{/if}



<!-- login and register popup -->
{assign var="useType" value="insurance"}
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentLoginRegister.tpl"}
<!-- login and register popup -->


<div id="blacklightboxContainer" class="lightboxContainerOpacity" style="display: none"></div>
<div class="row">
    <div class="col-lg-3 col-md-12 col-sm-12 col-12 col_main position-sticky ">


        <!-- Search Box -->
        <div class="filterBox">
            <div class="filtertip_hotel site-bg-main-color site-bg-color-border-bottom">
                <h1 class="font-15">{$info_page['name']}</h1>
                <p class="txt14">
                    <a class="iranM"></a>
                    <b dir="ltr"></b>
                </p>
                <span class="silence_span mt-2">{$planInfo|count} ##NumberInsorancesFound## </span>
                <div onclick="showSearchBoxInsurance()" class="open-sidebar-insurance">تغییر جستجو</div>
            </div>
            <div class="filtertip-searchbox">
                <form class="search-wrapper" name="gds_insurance" action="" method="post">

                    <div class="form-hotel-item form-hotel-item-searchBox marb10">
                        <div class="select">
                            <select name="insurance_type" id="insurance_type" class="select2" onchange="changeTourType()">
                                <option value="1" {if $smarty.const.INSURANCE_TYPE == '1'}selected="selected"{/if}>##Internalinsurance##</option>
                                <option value="2" {if $smarty.const.INSURANCE_TYPE == '2'}selected="selected"{/if}>##Foreigninsurance##</option>
                            </select>
                        </div>
                    </div>
{*                    <div class="form-hotel-item form-hotel-item-searchBox marb10">*}
{*                        <div class="select">*}
{*                            <select name="origin" id="origin" class="select2" {if $smarty.const.INSURANCE_TYPE == '2'}disabled="disabled"{/if}>*}
{*                                <option value="">##Origin##</option>*}
{*                                {foreach $allCountry as $country}*}
{*                                    <option value="{$country.abbr}"*}
{*                                            {if $country.abbr == $smarty.const.INSURANCE_ORIGIN}selected="selected"{/if}>{$country.persian_name}</option>*}
{*                                {/foreach}*}
{*                            </select>*}
{*                        </div>*}
{*                    </div>*}
                    <div class="form-hotel-item form-hotel-item-searchBox marb10">
                        <div class="select">
                            <select name="destination" id="destination" class="select2" {if $smarty.const.INSURANCE_TYPE == '1'}disabled="disabled"{/if}>
                                <option value="">##Destination##</option>
                                {foreach $allCountry as $country}
                                    <option value="{$country.abbr}"
                                            {if $country.abbr == $smarty.const.INSURANCE_DESTINATION}selected="selected"{/if}>{$country.persian_name}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    <div class="form-hotel-item form-hotel-item-searchBox marb10">
                        <div class="select">
{*                            <select name="num_day" id="num_day" class="select2">*}
{*                                <option selected="" default="" disabled> ##Durationtrip##</option>*}
{*                                <option value="5" {if $smarty.const.INSURANCE_NUM_DAY eq 5} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'5'],"TOXDay")}</option>*}
{*                                <option value="7" {if $smarty.const.INSURANCE_NUM_DAY eq 7} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'7'],"TOXDay")}</option>*}
{*                                <option value="8" {if $smarty.const.INSURANCE_NUM_DAY eq 8} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'8'],"TOXDay")}</option>*}
{*                                <option value="15" {if $smarty.const.INSURANCE_NUM_DAY eq 15} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'15'],"TOXDay")}</option>*}
{*                                <option value="23" {if $smarty.const.INSURANCE_NUM_DAY eq 23} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'23'],"TOXDay")}</option>*}
{*                                <option value="31" {if $smarty.const.INSURANCE_NUM_DAY eq 31} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'31'],"TOXDay")}</option>*}
{*                                <option value="45" {if $smarty.const.INSURANCE_NUM_DAY eq 45} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'45'],"TOXDay")}</option>*}
{*                                <option value="62" {if $smarty.const.INSURANCE_NUM_DAY eq 62} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'62'],"TOXDay")}</option>*}
{*                                <option value="92" {if $smarty.const.INSURANCE_NUM_DAY eq 92} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'92'],"TOXDay")}</option>*}
{*                                <option value="182" {if $smarty.const.INSURANCE_NUM_DAY eq 182} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'182'],"TOXDay")}</option>*}
{*                                <option value="186" {if $smarty.const.INSURANCE_NUM_DAY eq 186} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'186'],"TOXDay")}</option>*}
{*                                <option value="365" {if $smarty.const.INSURANCE_NUM_DAY eq 365} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'365'],"TOXDay")}</option>*}
{*                            </select>*}

{*                            <select name="num_day" id="num_day" class="select2">*}
{*                                <option selected="" default="" disabled> ##Durationtrip##</option>*}
{*                                <option value="4" {if $smarty.const.INSURANCE_NUM_DAY eq 4} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'1'],"STARTDAYFARA")}{functions::StrReplaceInXml(["@@Day@@"=>'4'],"ENDDAYFARA")}</option>*}
{*                                <option value="8" {if $smarty.const.INSURANCE_NUM_DAY eq 8} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'5'],"STARTDAYFARA")}{functions::StrReplaceInXml(["@@Day@@"=>'8'],"ENDDAYFARA")}</option>*}
{*                                <option value="10" {if $smarty.const.INSURANCE_NUM_DAY eq 10} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'9'],"STARTDAYFARA")}{functions::StrReplaceInXml(["@@Day@@"=>'10'],"ENDDAYFARA")}</option>*}
{*                                <option value="15" {if $smarty.const.INSURANCE_NUM_DAY eq 15} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'11'],"STARTDAYFARA")}{functions::StrReplaceInXml(["@@Day@@"=>'15'],"ENDDAYFARA")}</option>*}
{*                                <option value="21" {if $smarty.const.INSURANCE_NUM_DAY eq 21} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'16'],"STARTDAYFARA")}{functions::StrReplaceInXml(["@@Day@@"=>'21'],"ENDDAYFARA")}</option>*}
{*                                <option value="23" {if $smarty.const.INSURANCE_NUM_DAY eq 23} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'22'],"STARTDAYFARA")}{functions::StrReplaceInXml(["@@Day@@"=>'23'],"ENDDAYFARA")}</option>*}
{*                                <option value="31" {if $smarty.const.INSURANCE_NUM_DAY eq 31} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'24'],"STARTDAYFARA")}{functions::StrReplaceInXml(["@@Day@@"=>'31'],"ENDDAYFARA")}</option>*}
{*                                <option value="45" {if $smarty.const.INSURANCE_NUM_DAY eq 45} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'32'],"STARTDAYFARA")}{functions::StrReplaceInXml(["@@Day@@"=>'45'],"ENDDAYFARA")}</option>*}
{*                                <option value="62" {if $smarty.const.INSURANCE_NUM_DAY eq 62} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'46'],"STARTDAYFARA")}{functions::StrReplaceInXml(["@@Day@@"=>'62'],"ENDDAYFARA")}</option>*}
{*                                <option value="92" {if $smarty.const.INSURANCE_NUM_DAY eq 92} selected="selected" {/if}>{functions::StrReplaceInXml(["@@MONTH@@"=>'3'],"MONTHFARA")}</option>*}
{*                                <option value="180" {if $smarty.const.INSURANCE_NUM_DAY eq 180} selected="selected" {/if}>{functions::StrReplaceInXml(["@@MONTH@@"=>'6'],"MONTHFARA")}</option>*}
{*                                <option value="365" {if $smarty.const.INSURANCE_NUM_DAY eq 365} selected="selected" {/if}>{functions::StrReplaceInXml(["@@YEAR@@"=>'1'],"YEARFARA")}</option>*}
{*                            </select>*}
                        </div>
                    </div>
{*                    {if $smarty.const.CLIENT_ID != '307'}*}
                        <div class="form-hotel-item form-hotel-item-searchBox marb10">
                            <div class="select">
                                <select name="number_of_adults_insurance" id="number_of_adults_insurance" class="select2">
                                    <option selected="" default="" disabled>##Countpeople##</option>
                                    {for $num=1 to 9}
                                        <option value="{$num}" {if $num eq $smarty.const.INSURANCE_NUM_MEMBER} selected="selected" {/if}>{$num} ##People##</option>
                                    {/for}
                                </select>
                            </div>
                        </div>
{*                    {/if}*}
{*                    {if $smarty.const.CLIENT_ID == '307'}*}
{*                        <input type='hidden' name="number_of_adults_insurance" id="number_of_adults_insurance" value='1'>*}
{*                    {/if}*}
{*                    <div class="form-item-birthday-insurance ">*}
{*                        {foreach from=$smarty.const.INSURANCE_BIRTH_DATE|unserialize item="birthDate" name="birthLoop"}*}

{*                            <div class="form-item  form-item-Insurance-day">*}
{*                                <div class="input-group ">*}
{*                                    <div class="input-group-append">*}
{*                                        <span class="input-group-text">##BirthDayNumberOfPeople## {$smarty.foreach.birthLoop.iteration}</span>*}
{*                                    </div>*}
{*                                    <input {if $smarty.const.INSURANCE_TYPE == '1'} type="hidden" {else} type="text" {/if}*}
{*                                            class="form-control change-date-type-external shamsiBirthdayCalendar"*}
{*                                            name="txt_went_insurance{$smarty.foreach.birthLoop.iteration}"*}
{*                                            id="txt_went_insurance{$smarty.foreach.birthLoop.iteration}" value="{$birthDate}"*}
{*                                            placeholder="">*}
{*                                    <input {if $smarty.const.INSURANCE_TYPE == '1'} type="text" {else} type="hidden" {/if}*}
{*                                            class="form-control change-date-type-internal gregorianBirthdayCalendar"*}
{*                                               name="txt_went_insurance{$smarty.foreach.birthLoop.iteration}"*}
{*                                               id="txt_went_insuranceEn{$smarty.foreach.birthLoop.iteration}" value="{$birthDate}"*}
{*                                               placeholder="">*}
{*                                    <div class="input-group-append">*}
{*                                        <span class="input-group-text"><span class="fa fa-calendar"></span></span>*}
{*                                    </div>*}
{*                                </div>*}
{*                                *}{*<div class="input">*}
{*                                    <input type="text" name="txt_went_insurance{$smarty.foreach.birthLoop.iteration}"*}
{*                                           id="txt_went_insurance{$smarty.foreach.birthLoop.iteration}" value="{$birthDate}"*}
{*                                           class="{$classNameBirthdayCalendar}">*}
{*                                </div>*}
{*                            </div>*}
{*                        {/foreach}*}
{*                    </div>*}
{*                    <div class="form-hotel-item  form-hotel-item-searchBox-btn">*}
{*                        <span></span>*}
{*                        <div class="input">*}
{*                            <button class="site-bg-main-color " type="button"*}
{*                                    onclick="submitSearchInsuranceLocal()">##Search##*}
{*                            </button>*}
{*                        </div>*}
{*                    </div>*}
                </form>
            </div>
        </div>

        <div class="articles-list d-none">

            <h6>##RelatedArticles##</h6>
            <ul></ul>

        </div>
    </div>

    <div class="col-lg-9 col-md-12 col-sm-12 col-12 changePad-md insurance_detail_search col_main" style="text-align: center">

        {if $planInfo|count > 0}
            {foreach $planInfo as $info}

                {$provider_total_price = 0}
                <div class="showListSort">
                    <div class="international-available-box
                                    morning sepehran charter economy deptFlight">

                        <div class="international-available-item separator-dashed-right">

                            <div class="international-available-info">
                                <div class="international-available-item-right-Cell ">

                                    <div class=" international-available-airlines  ">

                                        <div class="international-available-airlines-logo">
                                            <div class="logo-airline-ico no-background-image">
                                                <img src="assets/images/{$info.source_type}Insurance.png">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="international-available-airlines-info insurance-list-box-content">
                                        <h4>{$info.plan_fa_title}</h4>
                                        {$markup_insurance_price = 0}
                                        {$main_insurance_price = 0}
                                        {$discount_insurance_price = 0}
                                        {foreach $info.passengers as $key => $price}
                                            {$main_insurance_price = $main_insurance_price + $price['price']}
                                            {$markup_insurance_price = $markup_insurance_price + $objInsurance->calculateMarkupPrice($price['price'],$markup_data)}
                                            {$discount_insurance_price = $discount_insurance_price + $objInsurance->calculatePrice($price['price'],$markup_data,$discount_data)}
                                        {/foreach}


                                        {assign var="total_price_club" value=$discount_insurance_price}


                                        <div class="show_less_div border-0">




                                        </div>
                                    </div>
                                </div>
                                <div class="international-available-item-left-Cell div-separator-dashed-right resultInsurance-btn-style">

                                    <div class="inner-avlbl-itm">
                                        {assign var="markup_total_main_currency" value=$objFunctions->CurrencyCalculate($markup_insurance_price)}
                                        {assign var="totalMainCurrency" value=$objFunctions->CurrencyCalculate($discount_insurance_price)}
                                        {assign var="setPriceChanges" value=$totalMainCurrency.AmountCurrency}



                                        {*<span class="silence_div2 mt-2 mb-2">
                                                <span>##PriceForEachPersone##</span>
                                                <i class="iranM site-main-text-color-drck CurrencyCal">
                                                {$objFunctions->numberFormat($every_price)}</i>
                                            </span>*}
                                        <span class="iranL  priceSortAdt">

                                        {if $discount_data['can_discount'] && $discount_data['value'] > 0}
                                            <strike><i class="iranM site-main-text-color-drck CurrencyCal"
                                                       data-amount="{$objFunctions->numberFormat($markup_total_main_currency.AmountCurrency)}">
                                                {$objFunctions->numberFormat($markup_total_main_currency.AmountCurrency)}</i>
                                            </strike>
                                            <span class="CurrencyText">
                                                {$totalMainCurrency.TypeCurrency}
                                            </span>
                                            <i class="iranM site-main-text-color-drck CurrencyCal"
                                               data-amount="{$objFunctions->numberFormat($setPriceChanges)}">
                                                {$objFunctions->numberFormat($setPriceChanges)}</i>

                                        {else}


                                            <i class="iranM site-main-text-color-drck CurrencyCal"
                                               data-amount="{$objFunctions->numberFormat($totalMainCurrency.AmountCurrency)}">
                                            {$objFunctions->numberFormat($totalMainCurrency.AmountCurrency)}</i>
                                        {/if}

                                        <span class="CurrencyText"> {$totalMainCurrency.TypeCurrency}</span>
                                        </span>

                                        <div class="SelectTicket">
                                            <a onclick="check_user_login('{$i}')"
                                               class="international-available-btn site-bg-main-color  site-main-button-color-hover">
                                                ##Insuranceissuance##
                                                <svg data-v-2824aec9="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path data-v-2824aec9="" d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"></path></svg>
                                            </a>
                                            <input type="hidden" class="insurance_title{$i}" value="{$info.plan_fa_title}"/>
                                            {if $setPriceChanges > 0}
                                                <input type="hidden" class="insurance_total_price{$i}" value="{$setPriceChanges}"/>
                                            {else}
                                                <input type="hidden" class="insurance_total_price{$i}" value="{$markup_total_main_currency.AmountCurrency}"/>
                                            {/if}
                                            <input type="hidden" class="insurance_zonecode{$i}"
                                                   value="{$info.plan_zone_code}"/>
                                            <input type="hidden" class="insurance_api{$i}" value="{$info.source_type}"/>
                                        </div>

                                    </div>
                                </div>


                                <div class="international-available-details">
                                    <div>
                                        <div class="international-available-panel-min">
                                            <ul class="tabs">
                                                <li class="tab-link site-border-top-main-color detailShow" data-tab="tab-1-{$i}">##Obligationsinsurer##</li>
                                                <li class="tab-link site-border-top-main-color detailShow current" data-tab="tab-2-{$i}">##Detailprice##</li>
                                                <li class="tab-link site-border-top-main-color detailShow " data-tab="tab-3-{$i}">##TypeCover##</li>
                                                <li class="tab-link site-border-top-main-color detailShow " data-tab="tab-4-{$i}">##Revocationrules##</li>
                                            </ul>
                                            <div id="tab-1-{$i}" class="tab-content">
                                                تعهدات بیمه گذار

                                                اعلام دقیق کیفیت خطر مورد بیمه به بیمه گر
                                                .-پرداخت به موقع حق بیمه .-حفاظت از مورد بیمه در حدی که هر کس به طور متعارف از اموال خود بدون توجه
                                                به داشتن بیمه به عمل می آورد و جلوگیری از توسعه خسارت در صورت تحقق خطر مورد بیمه -اعلام تشدید خطر.-اعلام به موقع وقوع حادثه ای که منجر به
                                                خسارت مورد تعهد بیمه گر است .نخستین وظیفه بیمه گذار در هنگام انعقاد قرارداد بیمه ،اعلام کیفیت و خصوصیات خطر مورد بیمه است به طوری که بیمه گر
                                                را در وضعیتی قرار دهد که بتواند به درستی و دقت ،خطر مورد بیمه را ارزیابی کند و یا شناخت کافی در زمینه رد یا قبول بیمه آن تصمیم بگیرد و در صورت
                                                قبولی بتواند حق بیمه متناسب با ریسک مورد بیمه را تعیین کند .بیمه گر حق دارد که اطلاعات مورد نیاز خود را از خطری که بیمه می کند به دست آورد
                                                .بیمه گر می تواند علاوه بر بررسی پیشنهاد بیمه گذار ،خود نیز با اعزام کارشناس بازدید اولیه در خصوص خطر موضوع بیمه به تحقیق بپردازد و اطلاعاتی
                                                از قبیل نوع ساختمان ،درجه مقاوت آن ،مواد اولیه ای که برای ساخت ساختمان استفاده شده و مجاورت مورد بیمه با خطرهای تشدید کننده و نوع وسایل اطفاء
                                                حریق که در ساختمان وجود دارد تحصیل کند .لکن در همین مورد نیز که بیمه گر خود به تحقیق درباره خطر اقدام می کند ،اولا”اساس ارزیابی او متکی به
                                                اظهارات بیمه گذار در پیشنهاد مورد بیمه است و در ثانی تحقیق بیمه گر الزامی نیست و بیمه گر می تواند صرفاً با توجه به اطلاعاتی که بیمه گذار در
                                                اختیار او قرار می دهد درباره رد یا قبول بیمه و حق بیمه و شرایط آن تصمیم بگیرد .ثالثا” اگر بیمه گذار به نحوی بیمه گر را درجریان امر و چگونگی
                                                خطر بگذارد که بیمه گر نیازی به تحقیق و صرف هزینه نداشته باشد ،در نهایت به نفع بیمه گذار خواهد بود .زیرا هزینه ای که بیمه گر در راه بررسی خطر
                                                متحمل می شود بر دوش بیمه گذار خواهد بود و بیمه گر در محاسبه ای که برای تعیین حق بیمه انجام می دهد چنین هزینه هایی را نیز در نظر می گیرد ،و
                                                سرانجام ،چه بسا اطلاعاتی که دانستن آن برای بیمه گر ضرورت دارد و یا تحقیق کارشناسی نتواند آن را به دست آورد . -حدود تعهد بیمه گذار در اعلام خطر
                                                موضوع بیمه اطلاعاتی که بیمه گذار باید در مورد خطر بیمه در اختیار بیمه گر قرار دهد دارای دو خصوصیت زیر است :-باید به بیمه گر اجازه دهد که با
                                                کمک این اطلاعات خطر را به درستی ارزیابی کند .-این اطلاعات باید برای بیمه گذار معلوم و مشخص باشد.
                                                بیمه ی مسافر بایستی قبل از خروج از ایران صادر بشه
                                                برای مسافری که خارج از ایران هست نمیشه بیمه نامه صادر کرد و تحت پوشش نیست ضمناً تمدید بیمه نامه برای مسافر امکان پذیر نیست.
                                                بیمه نامه از زمانی که صادر  میشه 6 ماه اعتبار داره. به عبارت دیگه مسافر 6 ماه از تاریخ صدور بیمه نامه فرصت داره از کشور خارج بشه ... حالا اگر سفر نرفت، ریجکت شد، مدت ویزاش کمتر شد، مدت سفرش کمتر شد و ... برای تمام این موارد راه حل داریم و امکان عودت کامل حق بیمه یا اون بخشی از بیمه نامه که استفاده نشده با هماهنگی قبلی وجود داره
                                                شروع بیمه نامه، از زمانی هست که مسافر از مرزهای قانونی کشور خارج میشه (بعد از درج مهر خروج در پاسپورت)
                                            </div>
                                            <div id="tab-2-{$i}" class="tab-content current price-Box-Tab">
                                                <table class="custom-table">
                                                    <tr>
                                                        <td style="color: #000">##Ages##</td>
                                                        <td style="color: #000">##Insuranceprice##</td>
                                                    </tr>
                                                    {$each_passenger_insurance_price = 0}
                                                    {$each_passenger_markup_insurance_price = 0}
                                                    {$each_passenger_main_insurance_price = 0}
                                                    {foreach $info.passengers as $key => $price}

                                                        {$each_passenger_main_insurance_price = $price['price']}
                                                        {$each_passenger_markup_insurance_price = $objInsurance->calculateMarkupPrice($price['price'],$markup_data)}
                                                        {$each_passenger_insurance_price = $objInsurance->calculatePrice($price['price'],$markup_data,$discount_data)}


                                                        <tr>
                                                            <td>
                                                                {if $price['type'] == Inf} ##Baby##
                                                                {elseif $price['type'] == Chd} ##Child##
                                                                {elseif $price['type'] == Adt} ##Adult##
                                                                {/if}
                                                            </td>
                                                            {assign var="everyMarkupMainCurrency" value=$objFunctions->CurrencyCalculate($each_passenger_markup_insurance_price)}
                                                            {assign var="everyMainCurrency" value=$objFunctions->CurrencyCalculate($each_passenger_insurance_price)}


                                                            <td>
                                                                {if $discount_data['can_discount'] && $discount_data['value'] > 0}
                                                                    <strike><i class="iranM site-main-text-color-drck CurrencyCal"
                                                                               data-amount="{$objFunctions->numberFormat($everyMarkupMainCurrency.AmountCurrency)}">
                                                                            {$objFunctions->numberFormat($everyMarkupMainCurrency.AmountCurrency)}</i>
                                                                    </strike>
                                                                    <span class="CurrencyText">
                                                                        {$everyMarkupMainCurrency.TypeCurrency}
                                                                    </span>

                                                                    <div class='d-block w-100 mt-2'>
                                                                        <i class="iranM site-main-text-color-drck CurrencyCal"
                                                                           data-amount="{$objFunctions->numberFormat($everyMainCurrency.AmountCurrency)}">
                                                                            {$objFunctions->numberFormat($everyMainCurrency.AmountCurrency)}</i>
                                                                        <span class="CurrencyText">
                                                                            {$everyMainCurrency.TypeCurrency}
                                                                        </span>
                                                                    </div>


                                                                {else}


                                                                    <i class="iranM site-main-text-color-drck CurrencyCal"
                                                                       data-amount="{$objFunctions->numberFormat($everyMainCurrency.AmountCurrency)}">
                                                                        {$objFunctions->numberFormat($everyMainCurrency.AmountCurrency)}</i>
                                                                {/if}


                                                            </td>
                                                        </tr>
                                                    {/foreach}
                                                </table>
                                            </div>
                                            <div id="tab-3-{$i}" class="tab-content ">
                                                <table class="custom-table">
                                                    <tr>
                                                        <td style="color: #000">##TypeCover## </td>
                                                        <td style="color: #000">##Description##</td>
                                                    </tr>

                                                    {foreach $info.covers as $key => $cover}
                                                        <tr>
                                                            <td>
                                                                {$cover.planCoverLimit}
                                                            </td>

                                                            <td>
                                                                {$cover.coverTitle}
                                                            </td>
                                                        </tr>
                                                    {/foreach}
                                                </table>
                                            </div>
                                            <div id="tab-4-{$i}" class="tab-content">

                                                اگر مسافر ریجکت شد، حتماً فرم ریجکتی رو از مسافر بگیرید و در مواقع لازم به ما ارائه بفرمایید.
                                                <br/>


                                                اگر مسافری ویزا گرفته و از رفتن به سفر منصرف شده، باید صبر کنه تا ویزاش منقضی بشه، صفحات پاسپورتش چک بشه که در اون مدت به منطقه ی تحت پوشش بیمه سفر نکرده باشه و با هماهنگی ما ابطال و کل حق بیمه پس داده بشه.

                                                <br/>

                                                اگر به طور مثال مسافر برای ویزای 3 ماهه اقدام کرد، اما ویزای 1 ماهه دریافت کرد، با ارائه مدرک می تونید بیمه نامه رو قبل از سفر ابطال و با مدت زمان جدید صادر بفرمایید.
                                                اگر مسافرتون کمتر از مدت بیمه نامه، خارج از ایران بود، می تونه با ارائه مهر ورود و خروج سفر یا سفرهاش  که در پاسپورت ثبت شده، مبلغ مدت زمان استفاده نشده رو پس بگیره
                                                <br/>
                                                مثلا مسافر بیمه ی ۳ ماهه سینگل یا مولتی خریداری کرده، اما ۲ ماه بیشتر سفر نکرده و بابت مابه التفاوت ۱ ماهه محق هست.
                                                <br/>

                                                اگه مسافرتون به چند کشور مختلف سفر می کنه، نیازی نیست چند بیمه نامه صادر کنید، فقط کافیه بیمه نامه ای صادر کنید که تمام کشورهای مورد سفر رو پوشش بده، به طور مثال اگر مسافر شما قصد سفر به حوزه ی شنگن رو داره، با انتخاب یکی از کشورهای عضو شنگن مثل فرانسه، تمام کشورهای شنگن تحت پوشش بیمه خواهند بود و مسافر محدودیتی در این خصوص هنگام سفر به کشورهای شنگن نداره.
                                                <br/>

                                                اگر مسافر شما به یکی از کشورهای آمریکا یا کانادا سفر می کنه، کشور مقصد صرفاً بایستی یکی از این دو کشور انتخاب بشه، در این حالت مسافر در کل دنیا تحت پوشش خواهد بود و اگه مثلاً اول بره فرانسه و بعد بره آمریکا یا کانادا، در تمام مقاصد تحت پوشش بیمه خواهد بود.
                                                <br/>
                                                اگر مسافر شما به کشور شنگن و غیر شنگن سفر داره، مثلاً همزمان به فرانسه و انگلستان سفر داره، کشور مقصد رو انگلستان انتخاب کنید تا هر دو کشور تحت پوشش باشن و zone  یا منطقه ی تحت پوشش بیمه نامه، " تمام کشورهای دنیا به غیر از آمریکا و کانادا" بشه
                                                <br/>
                                                طبق قانون بیمه، مسافر محترم، در هر سفر متوالی و پشت سرهم، نهایتاً، ۹۲ روز یا ۳ ماه تحت پوشش بیمه مسافرتی قرار می گیره
                                                <br/>
                                                بیمه نامه ۶ ماهه و یکساله برای مسافرینی کاربرد داره که قراره  طی ۶ ماه یا یکسال چندین سفر داشته باشن . به عبارت دیگه طی ۶ ماه یا یکسال چندین مرتبه از ایران خروج خواهند داشت. لذا بدیهیه که بایستی بیمه نامه های ۶ ماهه و یکساله به صورت multiple صادر بشن
                                                <br/>
                                                برای مسافری که بیش از ۳ ماه متوالی خارج از ایران حضور داره، می تونید یک بیمه ۳ ماهه صادر کنید و پس از پایان ۳ ماه مسافر محترم در صورت امکان از «بیمه های محلی» در کشور مقصد بهره مند بشه

                                            </div>
                                        </div>
                                    </div>
                                    <span class="international-available-detail-btn slideDownHotelDescription ">
                                     {if $objSession->IsLogin()}
                                         {assign var="counterId" value=$objFunctions->getCounterTypeId($smarty.session.userId)}
                                         {assign var="paramPointClub" value=[
                                         'service' => {$objInsurance->serviceTypeCheck($info['source_type'])},
                                         'baseCompany' => 'all',
                                         'company' => 'all',
                                         'counterId' => $counterId,
                                         'price' => $total_price_club]}
                                         {assign var="pointClub" value=$objFunctions->CalculatePoint($paramPointClub)}
                                         {if $pointClub gt 0}
                                             <div class="text_div_morei site-main-text-color iranM txt12">##Yourpurchasepoints## : {$pointClub} ##Point##</div>
                                         {/if}
                                     {/if}
                                    <div class="my-more-info">##Moredetail##<i class="fa fa-angle-down"></i>
                                    </div>
                                </span>
                                    <span class="international-available-detail-btn  slideUpHotelDescription displayiN">
                                    <i class="fa fa-angle-up site-main-text-color"></i>
                                </span>
                                </div>



                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                {$i=$i+1}
            {/foreach}
            <div class="sticky-article d-none"></div>
            <input type="hidden" id="selected_insurance_type" value="{$smarty.const.INSURANCE_TYPE}"/>
            <input type="hidden" id="insurance_destination" value="{$smarty.const.INSURANCE_DESTINATION}"/>
            <input type="hidden" id="insurance_origin" value="{$smarty.const.INSURANCE_ORIGIN}"/>
            <input type="hidden" id="insurance_num_day" value="{$smarty.const.INSURANCE_NUM_DAY}"/>
            <input type="hidden" id="insurance_member" value="{$smarty.const.INSURANCE_NUM_MEMBER}"/>
            <input type="hidden" id="insurance_birthdates" value='{$smarty.const.INSURANCE_BIRTH_DATE}'/>
            <input type="hidden" class="CurrencyCode" value='{$objSession->getCurrency()}'/>
            <input type="hidden" id="insurance_chosen" value=""/>
        {else}
            {*
            <div class="userProfileInfo-messge ">
                <div class="messge-login BoxErrorSearch">
                    <div style="float: right;"><i
                                class="fa fa-exclamation-triangle IconBoxErrorSearch"></i>
                    </div>
                    <div class="TextBoxErrorSearch">
                        ##Noinsurance##<br/>
                        ##Changeserach##
                    </div>
                </div>
            </div>
            *}
            {load_presentation_object filename="fullCapacity" assign="objFullCapacity"}
            {assign var="get_info" value=$objFullCapacity->getFullCapacitySite(1)}
            <div id='show_offline_request' >
                <div class='fullCapacity_div'>
                    {if $get_info['pic_url']!=''}
                        <img src='{$get_info['pic_url']}' alt='{$get_info['pic_title']}'>
                    {else}
                        <img src='assets/images/fullCapacity.png' alt='fullCapacity'>
                    {/if}
                    <h2>##Noinsurance##</h2>
                </div>
            </div>

        {/if}


        {assign var="moduleData" value=[
        'service'=>'Insurance',
        'origin'=>$smarty.const.INSURANCE_DESTINATION
        ]}

        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`textSearchResults.tpl"
        moduleData=$moduleData}
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`faqs.tpl"
        moduleData=$moduleData}
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`articles.tpl"
        moduleData=$moduleData}

    </div>
</div>


<script type="text/javascript" src="assets/js/modal-login.js"></script>






<script>
  $(document).ready(function () {

    $('body').delegate('ul.tabs li', "click", function () {

      $(this).siblings().removeClass("current");
      $(this).parent("ul.tabs").siblings(".tab-content").removeClass("current");


      var tab_id = $(this).attr('data-tab');


      $(this).addClass('current');
      $(this).parent("ul.tabs").siblings("#" + tab_id).addClass("current");

    });
  });
</script>
<script type="text/javascript">

  $(document).ready(function () {
    $('body').delegate(".slideDownHotelDescription", "click", function () {

      $(this).siblings().find(".international-available-panel-min").addClass("international-available-panel-max");
      $(".international-available-item-right-Cell").addClass("my-slideup");
      $(".international-available-item-left-Cell").addClass("my-slideup");
      $(this).closest(".slideDownHotelDescription").addClass("displayiN");
      $(this).siblings(".slideUpHotelDescription").removeClass("displayiN");
    });

    $('body').delegate(".slideUpHotelDescription", "click", function () {

      $(this).siblings().find(".international-available-panel-min").removeClass("international-available-panel-max");
      $(this).siblings(".slideDownHotelDescription").removeClass("displayiN");
      $(this).closest(".slideUpHotelDescription").addClass("displayiN");
    });
    $('body').delegate(".my-slideup", "click", function () {

      $(this).siblings().find(".international-available-panel-min").removeClass("international-available-panel-max");
      $(this).siblings().find(".slideDownHotelDescription").removeClass("displayiN");
      $(this).siblings().find(".slideUpHotelDescription").addClass("displayiN");
    });
  });

  $('body').delegate('.detailShow', 'click', function () {
    var InfoTab = $(this).attr('InfoTab');
    var counterTab = $(this).attr('counterTab');


    $(".loaderDetail").show();
    $.post(amadeusPath + 'user_ajax.php',
      {
        flag: 'detailRulCancelTicket',
        param: InfoTab
      },
      function (data) {
        setTimeout(function () {
          $(".loaderDetail").hide();
          $('#tab-2-' + counterTab).html(data);
        }, 10);

      });
  });

</script>
<script type="text/javascript">
  /*light box ruls and pric passengers*/
  $(document).ready(function () {

    let time_insurance = {$smarty.const.INSURANCE_NUM_DAY}
    if( time_insurance >= 92){

      $.confirm({
        title: useXmltag('BuyInsurance'),
        content: useXmltag('insuranceNote'),
        type: 'blue',
        typeAnimated: true,
        buttons: {
          close: {
            text: useXmltag('Yess'),
            btnClass: 'btn-red',
          }
        }
      });
    }

    $(".insurance-list-box-item-rules").on("click", function () {
      $(this).find(".price-Box").toggleClass("displayBlock");
      $("#blacklightboxContainer").addClass("displayBlock");
    });

    $(".insurance-list-box-item-obligation").on("click", function () {
      $(this).find(".price-Box").toggleClass("displayBlock");
      $("#blacklightboxContainer").addClass("displayBlock");
    });

    $(".insurance-list-box-item-detail").on("click", function () {
      $(this).find(".price-Box").toggleClass("displayBlock");
      $("#blacklightboxContainer").addClass("displayBlock");
    });

    $(".insurance-list-box-item-detail-covers").on("click", function () {
      $(this).find(".price-Box").toggleClass("displayBlock");
      $("#blacklightboxContainer").addClass("displayBlock");
    });

    $("body").delegate(".closeBtn", "click", function () {

      $(this).parent(".price-Box").removeClass("displayBlock");
      $(this).parents("#public_load").find("#blacklightboxContainer").removeClass("displayBlock");

    });

    $("#blacklightboxContainer").on("click", function () {
      $(".price-Box").removeClass("displayBlock");
      $("#blacklightboxContainer").removeClass("displayBlock");
    });


  });

</script>
<script type="text/javascript">
  $(document).ready(function () {

    //change number of passengers
    $('#number_of_adults_insurance').change(function (e) {

      var optVal= $("#insurance_type option:selected").val();
      var HtmlCode = "";
      if (optVal == 2) {
        var className='{$classNameBirthdayCalendarAdded}';
      }else{
        var classNameEn= '{$classNameBirthdayCalendarAddedEn}';
      }
      var typeInputDefoalt = {$smarty.const.INSURANCE_TYPE}
      var typeHidden = 'hidden';
      var typeText = 'text';
      if (typeInputDefoalt == 1) {
        var inputChangeType = typeHidden ;
      }else{
        var inputChangeType= typeText;
      }
      if (optVal == 2) {
        var inputChangeTypeEn = typeHidden ;
        var inputChangeType= typeText;

      }else{
        var inputChangeTypeEn= typeText;
        var inputChangeType = typeHidden ;

      }
      var i = $(".form-item-Insurance-day").length + 1;
      if (i <= $("#number_of_adults_insurance").val()) {
        while (i <= $("#number_of_adults_insurance").val()) {

          HtmlCode +="<div class=\"form-item  form-item-Insurance-day\"><div class='input-group'>\n" +
            "                                <div class=\"input-group-append\">\n" +
            "                                    <span class=\"input-group-text site-main-text-color\">##BirthDayNumberOfPeople## " + i + "</span>\n" +
            "                                </div>\n" +
            "                                <input type=\""+inputChangeTypeEn+"\" class=\"form-control change-date-type-internal  gregorianBirthdayCalendar  \"\n" +
            "                                       name=\"txt_went_insurance" + i + "\" \n" +
            "                                       id=\"txt_went_insuranceEn" + i + "\" >"+
            "                                <input type=\""+inputChangeType+"\" class=\"form-control change-date-type-external  shamsiBirthdayCalendar  \"\n" +
            "                                       name=\"txt_went_insurance" + i + "\" \n" +
            "                                       id=\"txt_went_insurance" + i + "\" >"+
            "                                <div class=\"input-group-append\">\n" +
            "                                    <span class=\"input-group-text\"><span class=\"fa fa-calendar\"></span></span>\n" +
            "                                </div>\n" +
            "                            </div></div>";

          /*HtmlCode += "<div class='form-item form-item-Insurance-day'>"
              + "<span class='fa-icon fa-stack fa-lg calendar-icon ' >"
              + "    <i class= 'fa fa-calendar fa-stack-1x  site-main-text-color ' ></i>"
              + " </span>"
              + "  <div class='input'><input type='text' name='txt_went_insurance" + i + "' id='txt_went_insurance" + i + "' class='"+className+"' placeholder=' ##BirthDayNumberOfPeople## " + i + "' /></div>"
              + "</div>";*/
          i++;
        }
        $(".form-item-birthday-insurance").append(HtmlCode);
      } else {
        while (i > $("#number_of_adults_insurance").val()) {

          $("#txt_went_insurance" + i).parents('.form-item-Insurance-day').remove();
          i--;
        }
      }

      //for gregorian birthday
      $('.gregorianBirthdayCalendar').datepicker({
        regional: '',
        maxDate: 'Y/M/D',
        showButtonPanel: !0,
        changeMonth: true,
        changeYear: true,
        yearRange: '1920:2120'
      });

    });



  });
</script>

<script src="assets/js/script.js"></script>