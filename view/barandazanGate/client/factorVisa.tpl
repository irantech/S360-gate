<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css"/>

{assign var="post_data_doubt" value=$objFunctions->existDoubtfulCharacter($smarty.post)}
{load_presentation_object filename="factorVisa" assign="objFactor"}
{load_presentation_object filename="currency" assign="objCurrencyVisa"}
{load_presentation_object filename="members" assign="objMember"}
{$objMember->get()}

{assign var="CurrencyCode" value=$smarty.post.CurrencyCode}
{assign var="serviceType" value=$objFunctions->getVisaServiceType()} {*  لازم برای انتخاب نوع بانک*}

<div class="row">
    <div class="col-lg-12">
{*        {if $objFactor->bookInfo['visa_OnlinePayment'] == 'yes'}*}


{*            <div id="lightboxContainer" class="lightboxContainerOpacity"></div>*}



{*        {else}*}

{*            <div class="alert d-flex justify-content-center flex-wrap alert-success text-center">*}
{*                <span>*}
{*                    <span class="d-flex">*}
{*                        ##ApplicationSuccessfullyRegistered##*}
{*                    </span>*}
{*                    <div class="d-flex justify-content-center flex-wrap">*}
{*                        <span class="small ml-3">##TrackingCode## : </span>*}
{*                        <pre class="badge badge-info p-2">{$objFactor->bookInfo['factor_number'] }</pre>*}
{*                    </div>*}
{*                </span>*}
{*            </div>*}


{*        {/if}*}
        {if $objFactor->error eq 'true'}

        <div class="container">

            <div id="lightboxContainer" class="lightboxContainerOpacity"></div>

            <div class=" s-u-passenger-wrapper-change s-u-passenger-wrapper " >
            <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                <i class="zmdi zmdi-alert-circle mart10 zmdi-hc-fw"></i>
                ##Note##
            </span>
                <div class="s-u-result-wrapper">
                    <span class="s-u-result-item-change direcR iranR txt12 txtRed">{$objFactor->errorMessage}</span>
                </div>
            </div>
            <div class="Clr"></div>
        </div>

        {/if}

            {if $post_data_doubt eq true}

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 s-u-passenger-wrapper-change noCharge doubt">
            <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color ">
                ##Note## <i class="zmdi zmdi-alert-circle mart10  zmdi-hc-fw"></i>
            </span>
                    <div class="s-u-result-wrapper">
                <span class="s-u-result-item-change direcR iranR txt12 txtRed">
                   ##doubtCharacter##
                </span>
                    </div>
                </div>

            {else}

                {load_presentation_object filename="resultReservationVisa" assign="objResultVisa"}
                {load_presentation_object filename="visa" assign="objVisa"}
                {load_presentation_object filename="country" assign="objCountry"}
                {load_presentation_object filename="currency" assign="objCurrencyVisa"}



                {assign var="visaInfo" value=$objVisa->getVisaByID($smarty.post.visaID)}
                {assign var="visaDetail" value=$objVisa->getVisaDetailById($smarty.post.visa_detail)}
                {assign var="countryInfo" value=$objCountry->getCountryByCode($visaInfo.countryCode)}

                {assign var="reasearch_address" value="{$smarty.const.ROOT_ADDRESS}/resultVisa/{$smarty.post.distination_code}/{$smarty.post.visa_type}/{$smarty.post.count_adult_internaly}-{$smarty.post.count_child_internal}-{$smarty.post.count_infant_internal}"}

                {load_presentation_object filename="passengersDetailLocal" assign="objDetail"}
                {$objDetail->getCustomers()}   {*گرفتن اطلاعات مربوط به مسافران هر مشتری*}

                {if isset($smarty.post.nameFaA)}

                    {* {load_presentation_object filename="factorVisa" assign="objFactor"}
                    {$objFactor->registerBooks()}

                    {load_presentation_object filename="members" assign="objMember"}
                    {$objMember->get()} *}

                {/if}

            {if $smarty.const.SOFTWARE_LANG eq 'en'}
            <link rel='stylesheet' href='assets/styles/css/modules-en/visa-en.css'>
            {else}
            <link rel='stylesheet' href='assets/styles/visa.css'>
            {/if}

                {assign var="InfoMember" value=$objFunctions->infoMember($objSession->getUserId())}


                <div id="lightboxContainer" class="lightboxContainerOpacity"></div>
                <!-- last passenger list -->
                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`passengerPopup.tpl"}
                <!--end  last passenger list -->


                <div class="s-u-content-result">

                    <span class="price-after-discount-code d-none">
                        {($smarty.post.count_adult_internal + $smarty.post.count_child_internal) * $smarty.post.prePaymentCost}
                    </span>

                    <div class="factor-visa-info">
                        <div class="factor-visa-info-div">
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="factor-img">
                                    {*                            <img src="/gds/pic/{$visaInfo.cover_image}" alt="" class="factor-head-img"/>*}
                                    <img  src="/gds/pic/country/{$smarty.const.CLIENT_ID}/{$visaInfo.pic}" alt="" class="factor-head-img"/>
                                    <span>{$visaInfo.title}</span>
                                </div>
                                <a class="btn btn-change-visa" href="{$smarty.const.ROOT_ADDRESS}/page/visa"><i class="fa fa-pen"></i><span> تغییر ویزا</span></a>
                            </div>

                            <div class="info-visa mt-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <h3>پیش پرداخت</h3>
                                        <span>{number_format(($smarty.post.count_adult_internal + $smarty.post.count_child_internal) * $smarty.post.prePaymentCost)} ریال </span>
                                    </div>
                                    <div class="col-lg-2">
                                        <h3>حداکثر اقامت</h3>
                                        {if $visaDetail['maximum_nation']}
                                            <span>{$visaDetail['maximum_nation']}</span>
                                        {else}
                                            <span>{$visaInfo.maximumNation}</span>
                                        {/if}
                                    </div>
                                    <div class="col-lg-2">
                                        <h3>تعداد ورودی</h3>
                                        {if $visaDetail['allowed_use_no']}
                                            <span>{$visaDetail['allowed_use_no']}</span>
                                        {else}
                                            <span>{$visaInfo.allowedUseNo}</span>
                                        {/if}
                                    </div>  <div class="col-lg-2">
                                        <h3>اعتبار ویزا</h3>
                                        <span>{$visaInfo.validityDuration}</span>
                                    </div>  <div class="col-lg-3">
                                        <h3>الزامات گذرنامه</h3>
                                        <span>طبق اعتبار پاسپورت</span>

                                    </div>
                                </div>



                            </div>
                        </div>
                    <form method="post" enctype="multipart/form-data">

                        {*فرم ثبت نام به تعداد افراد بزرگسال*}
                        {for $i=1 to $smarty.post.count_adult_internal}
                            <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first">

                <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
            ##Adult## <i class="soap-icon-family"></i>

                     {if $objSession->IsLogin() and ($smarty.session.typeUser eq 'counter')}
                         <span class="s-u-last-passenger-btn s-u-last-passenger-btn-change"
                               onclick="setHidenFildnumberRow('A{$i}')">
                            <i class="zmdi zmdi-pin-account zmdi-hc-fw"></i> ##Passengerbook##
                        </span>
                     {/if}
                </span>

                                <div class="panel-default-change ">
                                    <div class="panel-heading-change">

{*                                        <span class="hidden-xs-down">##Nation##:</span>*}

{*                                        <span class="kindOfPasenger">*}
{*                            <label class="control--checkbox">*}
{*                                <span>##Iranian##</span>*}
{*                                <input type="radio" name="passengerNationalityA{$i}" id="passengerNationalityA{$i}"*}
{*                                       value="0" class="nationalityChange" checked="checked">*}
{*                                <div class="checkbox  ">*}
{*                                    <div class="filler"></div>*}
{*                                   <svg fill="#000000" viewBox="0 0 30 30">*}
{*                                    <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z"/>*}
{*                                   </svg>*}
{*                                </div>*}
{*                            </label>*}
{*                        </span>*}
{*                                        <span class="kindOfPasenger">*}
{*                            <label class="control--checkbox">*}
{*                                <span>##Noiranian##</span>*}
{*                                <input type="radio" name="passengerNationalityA{$i}" id="passengerNationalityA{$i}"*}
{*                                       value="1" class="nationalityChange">*}
{*                                <div class="checkbox">*}
{*                                    <div class="filler"></div>*}
{*                                   <svg fill="#000000" viewBox="0 0 30 30">*}
{*                                    <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z"/>*}
{*                                   </svg>*}
{*                                </div>*}
{*                            </label>*}
{*                        </span>*}


                                    </div>


                                    <div class="panel-body-change">
{*                                        <div class="s-u-passenger-item  s-u-passenger-item-change ">*}
{*                                            <select id="genderA{$i}" name="genderA{$i}">*}
{*                                                <option value="Male">##Sir##</option>*}
{*                                                <option value="Female">##Lady##</option>*}
{*                                            </select>*}
{*                                        </div>*}

                                        <div class="s-u-passenger-item s-u-passenger-item-change">
                                            <input id="nameEnA{$i}" type="text" placeholder="##Nameenglish##" name="nameEnA{$i}"
                                                   onkeypress="return isAlfabetKeyFields(event, 'nameEnA{$i}')" class="">
                                        </div>
                                        <div class="s-u-passenger-item s-u-passenger-item-change">
                                            <input id="familyEnA{$i}" type="text" placeholder="##Familyenglish##"
                                                   name="familyEnA{$i}"
                                                   onkeypress="return isAlfabetKeyFields(event, 'familyEnA{$i}')" class="">
                                        </div>
{*                                        <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">*}
{*                                            <input id="birthdayEnA{$i}" type="text" placeholder="##miladihappybirthday##(##Noiranian##)"*}
{*                                                   name="birthdayEnA{$i}" class="gregorianAdultBirthdayCalendar"*}
{*                                                   readonly="readonly">*}
{*                                        </div>*}

{*                                        <div class="s-u-passenger-item s-u-passenger-item-change">*}
{*                                            <input id="nameFaA{$i}" type="text" placeholder="##Namepersion##" name="nameFaA{$i}"*}
{*                                                   onkeypress=" return persianLetters(event, 'nameFaA{$i}')" class="justpersian">*}
{*                                        </div>*}
{*                                        <div class="s-u-passenger-item s-u-passenger-item-change">*}
{*                                            <input id="familyFaA{$i}" type="text" placeholder="##Familypersion##"*}
{*                                                   name="familyFaA{$i}" onkeypress=" return persianLetters(event, 'familyFaA{$i}')"*}
{*                                                   class="justpersian">*}
{*                                        </div>*}
                                        <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                            <input id="birthdayA{$i}" type="text" placeholder="##shamsihappybirthday##"
                                                   name="birthdayA{$i}"
                                                   class="shamsiAdultBirthdayCalendar" readonly="readonly">
                                        </div>

{*                                        <div class="s-u-passenger-item s-u-passenger-item-change justIranian">*}
{*                                            <input id="NationalCodeA{$i}" type="tel" placeholder="##Nationalnumber##"*}
{*                                                   name="NationalCodeA{$i}"*}
{*                                                   maxlength="10" class="UniqNationalCode"*}
{*                                                   onkeyup="return checkNumber(event, 'NationalCodeA{$i}')">*}
{*                                        </div>*}

{*                                        <div class="s-u-passenger-item s-u-passenger-item-change select-meliat noneIranian">*}
{*                                            <select name="passportCountryA{$i}" id="passportCountryA{$i}" class="select2">*}
{*                                                <option value="">##Countryissuingpassport##</option>*}
{*                                                {foreach $objFunctions->CountryCodes() as $Country}*}
{*                                                    <option value="{$Country['code']}">{$Country['titleFa']}</option>*}
{*                                                {/foreach}*}
{*                                            </select>*}
{*                                        </div>*}
                                        <div class="s-u-passenger-item s-u-passenger-item-change">
                                            <input id="passportNumberA{$i}" type="text" placeholder="##Numpassport##"
                                                   name="passportNumberA{$i}" class="UniqPassportNumber"
                                                   onkeypress="return isAlfabetNumberKeyFields(event, 'passportNumberA{$i}')">
                                        </div>
                                        <div class="s-u-passenger-item s-u-passenger-item-change">
                                            <input id="passportExpireA{$i}" class="gregorianFromTodayCalendar" type="text"
                                                   placeholder="##Passportexpirydate##" name="passportExpireA{$i}">
                                        </div>



                                        {if $visaInfo['custom_file_fields'] neq ''}
                                            <div class="d-flex flex-wrap w-100 mt-3">

                                                <span class="w-100 title-of-head-box mb-3">##CustomAssets##</span>

                                                {assign var="custom_file_fields" value=json_decode($visaInfo['custom_file_fields'],true)}

                                                {foreach $custom_file_fields as $key=>$item}
                                                    <div class="s-u-passenger-item s-u-passenger-item-change">

                                                        <div class="d-flex flex-wrap">
                                                            <h6>{$item}</h6>
                                                            <div class="input-group d-flex flex-wrap">
                                            <span class="input-group-btn d-flex flex-wrap">
                                                <span class="btn btn-file site-bg-main-color border-radius-top-right">
                                                    جستجو  &hellip; <input type="file"
                                                                           placeholder="{$item}"
                                                                           data-id="{$i}{$key}"
                                                                           id="custom_file_fields_A_{$i}"
                                                                           name="custom_file_fields_A_{$i}[]"
                                                                           single>
                                                </span>
                                            </span>
                                                                <input type="text"
                                                                       class="form-control border-radius-top-left border-r-0" readonly>
                                                                <div class="d-flex h-200 flex-wrap w-100 border-radius-bottom hidden-overflow">
                                                                    <img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEBLAEsAAD/4QCCRXhpZgAASUkqAAgAAAABAA4BAgBgAAAAGgAAAAAAAABJbWFnZSBwcmV2aWV3IGljb24uIFBpY3R1cmUgcGxhY2Vob2xkZXIgZm9yIHdlYnNpdGUgb3IgdWktdXggZGVzaWduLiBWZWN0b3IgZXBzIDEwIGlsbHVzdHJhdGlvbi7/4QWBaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/Pgo8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIj4KCTxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+CgkJPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIiB4bWxuczpJcHRjNHhtcENvcmU9Imh0dHA6Ly9pcHRjLm9yZy9zdGQvSXB0YzR4bXBDb3JlLzEuMC94bWxucy8iICAgeG1sbnM6R2V0dHlJbWFnZXNHSUZUPSJodHRwOi8veG1wLmdldHR5aW1hZ2VzLmNvbS9naWZ0LzEuMC8iIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1sbnM6cGx1cz0iaHR0cDovL25zLnVzZXBsdXMub3JnL2xkZi94bXAvMS4wLyIgIHhtbG5zOmlwdGNFeHQ9Imh0dHA6Ly9pcHRjLm9yZy9zdGQvSXB0YzR4bXBFeHQvMjAwOC0wMi0yOS8iIHhtbG5zOnhtcFJpZ2h0cz0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3JpZ2h0cy8iIHBob3Rvc2hvcDpDcmVkaXQ9IkdldHR5IEltYWdlcy9pU3RvY2twaG90byIgR2V0dHlJbWFnZXNHSUZUOkFzc2V0SUQ9IjEyMjIzNTc0NzUiIHhtcFJpZ2h0czpXZWJTdGF0ZW1lbnQ9Imh0dHBzOi8vd3d3LmlzdG9ja3Bob3RvLmNvbS9sZWdhbC9saWNlbnNlLWFncmVlbWVudD91dG1fbWVkaXVtPW9yZ2FuaWMmYW1wO3V0bV9zb3VyY2U9Z29vZ2xlJmFtcDt1dG1fY2FtcGFpZ249aXB0Y3VybCIgPgo8ZGM6Y3JlYXRvcj48cmRmOlNlcT48cmRmOmxpPmRpY2tjcmFmdDwvcmRmOmxpPjwvcmRmOlNlcT48L2RjOmNyZWF0b3I+PGRjOmRlc2NyaXB0aW9uPjxyZGY6QWx0PjxyZGY6bGkgeG1sOmxhbmc9IngtZGVmYXVsdCI+SW1hZ2UgcHJldmlldyBpY29uLiBQaWN0dXJlIHBsYWNlaG9sZGVyIGZvciB3ZWJzaXRlIG9yIHVpLXV4IGRlc2lnbi4gVmVjdG9yIGVwcyAxMCBpbGx1c3RyYXRpb24uPC9yZGY6bGk+PC9yZGY6QWx0PjwvZGM6ZGVzY3JpcHRpb24+CjxwbHVzOkxpY2Vuc29yPjxyZGY6U2VxPjxyZGY6bGkgcmRmOnBhcnNlVHlwZT0nUmVzb3VyY2UnPjxwbHVzOkxpY2Vuc29yVVJMPmh0dHBzOi8vd3d3LmlzdG9ja3Bob3RvLmNvbS9waG90by9saWNlbnNlLWdtMTIyMjM1NzQ3NS0/dXRtX21lZGl1bT1vcmdhbmljJmFtcDt1dG1fc291cmNlPWdvb2dsZSZhbXA7dXRtX2NhbXBhaWduPWlwdGN1cmw8L3BsdXM6TGljZW5zb3JVUkw+PC9yZGY6bGk+PC9yZGY6U2VxPjwvcGx1czpMaWNlbnNvcj4KCQk8L3JkZjpEZXNjcmlwdGlvbj4KCTwvcmRmOlJERj4KPC94OnhtcG1ldGE+Cjw/eHBhY2tldCBlbmQ9InciPz4K/+0ArFBob3Rvc2hvcCAzLjAAOEJJTQQEAAAAAACQHAJQAAlkaWNrY3JhZnQcAngAYEltYWdlIHByZXZpZXcgaWNvbi4gUGljdHVyZSBwbGFjZWhvbGRlciBmb3Igd2Vic2l0ZSBvciB1aS11eCBkZXNpZ24uIFZlY3RvciBlcHMgMTAgaWxsdXN0cmF0aW9uLhwCbgAYR2V0dHkgSW1hZ2VzL2lTdG9ja3Bob3Rv/9sAQwAKBwcIBwYKCAgICwoKCw4YEA4NDQ4dFRYRGCMfJSQiHyIhJis3LyYpNCkhIjBBMTQ5Oz4+PiUuRElDPEg3PT47/9sAQwEKCwsODQ4cEBAcOygiKDs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7/8IAEQgCZAJkAwERAAIRAQMRAf/EABoAAQEBAQEBAQAAAAAAAAAAAAACAwUEAQb/xAAWAQEBAQAAAAAAAAAAAAAAAAAAAQL/2gAMAwEAAhADEAAAAf2KAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAScWyAAAAAAAAAAADor7oAAAAAAAFFAAAAAAAAAzAAAAAAAB5zwWdeUAAAAAAAAAAScSzuygAAAAAACigAAAAAAAAZgAAAAAAA854LOvKAAAAAAAAAAJOJZ3ZQAAAAAABRQAAAAAAAAMwAAAAAAAec8FnXlAAAAAA+ElgAAEnEs7soAAAAAAAooAAAAAAAAGYAAAAAAAPOeCzrygAAAAD4cCzy2dCXtSgACTiWd2UAAAAAAAUUAAAAAAAADMAAAAAAAHnPBZ15QAAAAB5z87rIH6jOqAAJOJZ3ZQAAAAAABRQAAAAAAAAMwAAAAAAAec8FnXlAAAAAEn56zCz1y9+UAAScSzuygAAAAAACigAAAAAAAAZgAAAAAAA854LOvKAAAAABJibn0AAEnEs7soAAAAAAAooAAAAAAAAGYAAAAAAAPOeCzrygAYEnpAAAAAAAJOJZ3ZQAAAAAABRQAAAAAAAAMwAAAAAAAec8FnXlAGBwNSTv5vpAAAAJKABJxLO7KAAAAAAAKKAAAAAAAABmAAAAAAADzngs68oGBwNTNBS9/N9IAABgcHU7EvtgCTiWd2UAAAAAAAUUAAAAAAAADMAAAAAAAHnPBZ15RgcDUzQAUvfzfSAAYHA1M0+ncmvbAk4lndlAAAAAAAFFAAAAAAAAAzAAAAAAAB5zwWdeXA4GpmgAApe/m+kAwOBqZoB9O5Ne2JOJZ3ZQAAAAAABRQAAAAAAAAMwAAAAAAAec8FnQl4GpmgAAApe/m+kwOBqZoAB9O5NeuOJZ3ZQAAAAAABRQAAAAAAAAMwAAAAAAAec5VnmrNAAAABS9mXkWZoAAB9O3NeBO7KAAAAAAAKKAAAAAAAABmAAAAAAADzn53WQAAAAAAAAAAB7Ze7KAAAAAAAKKAAAAAAAABmAAAAAAADzn53WQAAAAAAAAAAB7Ze7KAAAAAAAKKAAAAAAAABmAAAAAAADE/N6yAAAAAAAAAAAPfL25QAAAAAABRQAAAAAAAAMwAAAAAAADzmdAAAAAAAAAAAemLAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAACQAAAAAAAAAAAAAAAAAAAAAAAAAAAAfT6AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD/8QAJxAAAQMCBgMBAQEBAQAAAAAAAwABAhFgBBMUMTNAIDBQEBKQITL/2gAIAQEAAQUC/wA+Gs1rNazWs1rNazWs1rNazWs1rNazWs1rNazWs1rNazWs1vhu/wDLSxJJPnHWcdZx1nHWcdZx1nHWcdZx1nHWcdZx1nHWcdZx1nHWcdZx1nHWcdZx1nHWedYc+Z0W+GfgwW/WfbCc3Qb4Z+DBb9Z9sJzdBvhn4MFv7v6b0PthOboN8M/Bgt/aY8iOsPiHaXk+2E5ug3wz8GC39h+H9b/z4vthOboN8M/Bgt/Y7VYonFJAC5JeT7YTm6DfDPwYLf2uzOskXofbCc3Qb4Z+DBb+JCMKITMVve+2E5ug3wz8GC38CEYUZzckoyeEgmYsfTX/AL4PthOboN8M/Bgt/wBIRhRnNyS/IyeEgmYsfMpWFGRJSmA+Y36+2E5ug3wz8GC3/CEYUZzckvCMnhIJmLHxKVhRnNySTPRwHzG/H2wnN0G+GfgwW6IRhRnNyS8oyeEgmYsf0pWFGc3JL9Z6OA+YyfbCc3Qb4Z+DBbkIwozm5JeiMnhIJmLFFKwozm5JeLPRwHzGfbCc3Qb4Z+DDkYTTm5JeqMnhJsVDLnNyS82ejhPmRwnN0G+Gfg6+ywnN0G+Gfg7GE5ug3wyt/Quxg4vmdBviSAOb6US0olpRLSiWlEtKJaUS0olpRLSiWlEtKJaUS0olpRLSiWlEtKJaUS0olpRLSiWmEoxaLdBrNazWs1rNazWs1rNazWs1rNazWs1rNazWs1rNazWs1rNbp0VFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRU/zA//EABYRAQEBAAAAAAAAAAAAAAAAAAFgsP/aAAgBAwEBPwHEgI0jSNI0jSNI0jSNI0jSNMm3/8QAFBEBAAAAAAAAAAAAAAAAAAAAwP/aAAgBAgEBPwE5T//EACkQAAEBBgUEAwEBAAAAAAAAAAABAhExMpGhIDBQcYEQQFFhEiFBsCL/2gAIAQEABj8C/hpPX8P8/RFaEVoRWhFaEVoRWhFaEVoRWhFaEVoRWhFaEVoRWhFaEVoRWhFaEVoRWhFaEVoOajqjWw13HGqNbDXccao1sNZ8UyeNUa2Gs7wz0+LS/WRxqjWw1mtbYEx8ao1sNZrlHLDz0esqZHGqNbDWd9kiZPGqNbDWJ6nvx2PGqNbDWF6j1Hoe/GU7FxqjWw1geo9er0PfjIep83/Y5ZsPGqNbDXV6j1wvQ9+MT1Hr0eg5ZsHGqNbDXR6j1xvQ9+MD1Hrgeg5ZuvGqNbDQ9R65L0Pfjo9R64noOWbpxqjWw2qj1y3ofJY+B65D0HLMcao1t3PGqNbdzxqjSJ47n5fiaq9WSW5LcluS3JbktyW5LcluS3JbktyW5LcluS3JbktyW5LcluS3JbjkR38NT//EACoQAAECBAYCAgIDAQAAAAAAAAEAMRFBUXEgITBQofAQ4UCxYGGQkaCw/9oACAEBAAE/If8AhpAAAAytBEqT6QAj8fWta1rWta1rWta1rWtagZlQsbXPKe6q4Y+O/ZM3bqrgj47lkzduquCNeKYZ19ByyZu3VXBGqSACSwRWATIHgGjjyBMsblkzduquCNWIQ8CPMeGJyyZu3VXBGqA7BEFAh+lXgZBUNcblkzduquCNYDAARQoCMeNAACAyxuWTN26q4IxT5yFVE4yF/gHLJm7dVcEYZ85CqPD+kOHgQqGF9JAAIiJYYXLJm7dVcEYJ85CqPD+vI4eBCoYX0EyEhVR+/RCSG1hzgcsmbt1VwR5nzkKo8P6wjh4EKhhfEmQkKo8Pn9eCCJAiaG1hz5csmbt1VwR4n3kKo9P6xjh4EKhhfAmQkKo8Pn9YCCJAiaG1hz4csmbt1VwQp85CqPD+tEcPAhUML+EyEhVHh8/rEQRIETQ2sOU5ZM3bqqnGICqPT+tMcPAhFSlTw+f1oEESBE0E2WA/tM3fhigSUQYEJm78NUzdugryORN8gg5DdUIKNRkuol1Euol1Euol1Euol1Euol1Euol1Euol1Euol1Euol1Euol1Euol1Eu4lAyCg/0KgAAAAAAAAAAAAAQ/i/8A/9oADAMBAAIAAwAAABBtttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttv/8A/wD/AP8A/wD/AP8A/wCG2222222222222222222222222u22222222223222222222222222222222222221W2222222222+22222222222222222222222222q222222/2223222222222222222222222222221W222223i222+22222222222222222222222222q222222yS223222222222222222222222222221W22222+jm22+22222222222222222222222222q222222/+223222222222222222222222222221W2382222222+22222222222222222222222222q23xE2222+23222222222222222222222222221W3wTE222+I2+22222222222222222222222222q3wSTE22+CY3222222222222222222222222221XwSSTE2+CSY+22222222222222222222222222rwSSSTE+CSSZ222222222222222222222222221wSSSSTACSSSY22222222222222222222222222iSSSSSSSSSSTW22222222222222222222222220SSSSSSSSSSSS22222222222222222222222223ySSSSSSSSSSSe222222222222222222222222225JJJJJJJJJJJ22222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222223//xAAdEQEAAgIDAQEAAAAAAAAAAAABABExUCAwQBCw/9oACAEDAQE/EPw07ZbLZbLZbLZbLZbLZbLZbLZbLZbLZbLZbLZbBvaOPSNo49I2jj0jaOO8vweg2jjuOOs2jjvJXwOg2jjwKOk2jjmWDfhNo45F+jfgNo44ll8BvoWpcG+JtHHAvMb5LwHgbRx9LF6BvgvIb+m0cfC9Y38XoG/htHEHtvqG4bRx6TaOPSbR9JtalEolEolEolEolEolEolEolEolEolEolEolH4av8A/8QAHREAAwEBAAMBAQAAAAAAAAAAAAERMFAQIECwYP/aAAgBAgEBPxD8NOERERERERERERERERERERERERERERERENdRD+h9RD+h9RD+h9RD2S8NYPqIeqzfUQ9k/DeD6iHvcX1EP3a+F9RDwa+B9RDxaya9X1EPJrJr0fUQ82smvL6iHo1k14fUQ9Zk0PqL6X1F9L/jX1aUpSlKUpSlKUpSlKUpSl/DV//EACgQAAEDAwMDBQEBAQAAAAAAAAEAETFAUWEhUPBB0fEQIDBxoZGQsf/aAAgBAQABPxD/ABxcXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6eiMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMGhJYxhMBHrj02JsrwXsvBey8F7LwXsvBey8F7LwXsvBey8F7LwXsvBey8F7LwXsvBey8F7LwXsvBey8F7LwXsvBey8F7LwXsiGwgSSLf8TSgBsOgB3oZmiMGiIQ62sn9pwBCQ4JOKJEzRGDRFzmaf96iRM0Rg0Rc5n5w2zWAX+D96iRM0Rg0Rc5n5TtMByT0CEHJYJZxc+hlh7g5Pprb3/vUSJmiMGiLnM/KZOf8Ax1/PUTojIkwv9t7v3qJEzRGDRFzmflHM5xDBR6QSMWgd/Q20Gcg/ge/96iRM0Rg0Rc5n5ik9SBwmTc/j+ICAAEACPf8AvUSJmiMGiLnM+49I5aDkloE6yjIxQfvUSJmiMGiLnM+09I5aDkk/2JgCAsEQOdoU4Awn1ZGPiIQTzh1Pt/eokTNEYNEXOZ9h6Ry0HJJ/sTAEBYepA52hTgDCfVkY+AlO5aDkk6mBLuN9QgYgG1HQbj2fvUSJmiMGiLnM+p6Ry0HJJ/sTA6BYe0gc7QhOAMJ9WRj3Ep3LQcknOxQOgWHoeAc4A6hAxANqOmY9f3qJEzRGDRFzmfQ8I5aDkk/mJgdAsPeQOdoU4Awn1ZGPYSnctBySc7FA6BYew8A5wEgoGIBtR0zHp+9RImaIwaIucyj0jloOST/YmAICw+Egc7QpwBhPqyMehKdy0HJJzsUDoFh7jwDnASEDEA2o6DcL96iRM0Rg0RFockA5LVP5iYHQLD4yBztCjnQ0iEk4wnOxQOgWHwHgHOAkFG4B1x0FpFEiZojB2kh84hwQdRRImaIwd7LEzRGDQjkc5lyiCRBDEaEGoC4FyCcnpQzNEYNEbmjkhd9ssvhlZfDKy+GVl8MrL4ZWXwysvhlZfDKy+GVl8MrL4ZWXwysvhlZfDKy+GVl8MrL4ZWXwysvhlZfDKy+GVl8MoDM+GUAjGAUMzRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGE+6fdPun3T7p90+6fdPun3T7p90+6fdPun3T7p90+6fdPun3T7p90+6fdPun3T7p90+6fdPun3T7p90+6fdPun3T7p90+6fdPun3T7p90+6fdPun3T7p90+6fdPun3T46/5f//Z
"
                                                                         data-id="{$i}{$key}"
                                                                         alt="" class="imagepreview w-100 h-100">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                {/foreach}
                                            </div>
                                        {/if}





{*                                        <div class="s-u-passenger-item s-u-passenger-item-change no-star">*}
{*                                                    <div class="file-upload-wrapper site-bg-main-color-before"*}
{*                                                         data-text="فایل خود را انتخاب کنید">*}
{*                                                        <input class="file-upload-field" id="VisaFileA{$i}" multiple="multiple" type="file"*}
{*                                                               name="VisaFileA{$i}" >*}

{*                                                    </div>*}

{*                                                </div>*}

                                        <div class="alert_msg d-flex" id="messageA{$i}"></div>
                                    </div>
                                </div>
                            </div>
                        {/for}

                        {*فرم ثبت نام به تعداد کودکان*}
                        {for $i=1 to $smarty.post.count_child_internal}
                            <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change  first">
<div class="d-flex">
                            <span class="s-u-last-p-koodak s-u-last-p-koodak-change site-main-text-color">
                            ##Child## <i class="soap-icon-man-3"></i>


                                            {if $objSession->IsLogin() and ($smarty.session.typeUser eq 'counter')}
                                                <span class="s-u-last-passenger-btn s-u-last-passenger-btn-change"
                                                      onclick="setHidenFildnumberRow('C{$i}')">
                                        <i class="zmdi zmdi-pin-account zmdi-hc-fw"></i>##Passengerbook##
                                    </span>
                                                    </span>
                                            {/if}
</div>
                                <div class="panel-default-change site-border-main-color">
                                    <div class="panel-heading-change">

{*                                        <span class="hidden-xs-down">##Nation##:</span>*}

{*                                        <span class="kindOfPasenger">*}
{*                            <label class="control--checkbox">*}
{*                                <span>##Iranian##</span>*}
{*                                <input type="radio" name="passengerNationalityC{$i}" id="passengerNationalityC{$i}"*}
{*                                       value="0" class="nationalityChange" checked="checked">*}
{*                                <div class="checkbox">*}
{*                                    <div class="filler"></div>*}
{*                                    <svg viewBox="0 0 20 20">*}
{*                                        <polyline points="4 11 8 15 16 6"></polyline>*}
{*                                    </svg>*}
{*                                </div>*}
{*                            </label>*}
{*                        </span>*}
{*                                        <span class="kindOfPasenger">*}
{*                            <label class="control--checkbox">*}
{*                                <span>##Noiranian##</span>*}
{*                                <input type="radio" name="passengerNationalityC{$i}" id="passengerNationalityC{$i}"*}
{*                                       value="1" class="nationalityChange">*}
{*                                <div class="checkbox">*}
{*                                    <div class="filler"></div>*}
{*                                    <svg viewBox="0 0 20 20">*}
{*                                        <polyline points="4 11 8 15 16 6"></polyline>*}
{*                                    </svg>*}
{*                                </div>*}
{*                            </label>*}
{*                        </span>*}


                                    </div>


                                    <div class="panel-body-change">
{*                                        <div class="s-u-passenger-item s-u-passenger-item-change">*}
{*                                            <select id="genderC{$i}" name="genderC{$i}">*}
{*                                                <option value="" disabled selected="selected">##Sex##</option>*}
{*                                                <option value="Male">##Boy##</option>*}
{*                                                <option value="Female">##Girl##</option>*}
{*                                            </select>*}
{*                                        </div>*}

                                        <div class="s-u-passenger-item s-u-passenger-item-change">
                                            <input id="nameEnC{$i}" type="text" placeholder="##Nameenglish##" name="nameEnC{$i}"
                                                   onkeypress="return isAlfabetKeyFields(event, 'nameEnC{$i}')">
                                        </div>
                                        <div class="s-u-passenger-item s-u-passenger-item-change">
                                            <input id="familyEnC{$i}" type="text" placeholder="##Familyenglish##"
                                                   name="familyEnC{$i}"
                                                   onkeypress="return isAlfabetKeyFields(event, 'familyEnC{$i}')">
                                        </div>
                                        <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                                            <input id="birthdayEnC{$i}" type="text" placeholder="##miladihappybirthday##"
                                                   name="birthdayEnC{$i}" class="gregorianChildBirthdayCalendar"
                                                   readonly="readonly">
                                        </div>

{*                                        <div class="s-u-passenger-item s-u-passenger-item-change">*}
{*                                            <input id="nameFaC{$i}" type="text" placeholder="##Namepersion##" name="nameFaC{$i}"*}
{*                                                   onkeypress=" return persianLetters(event, 'nameFaC{$i}')" class="justpersian">*}
{*                                        </div>*}
{*                                        <div class="s-u-passenger-item s-u-passenger-item-change">*}
{*                                            <input id="familyFaC{$i}" type="text" placeholder="##Familypersion##"*}
{*                                                   name="familyFaC{$i}" onkeypress=" return persianLetters(event, 'familyFaC{$i}')"*}
{*                                                   class="justpersian">*}
{*                                        </div>*}
                                        <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                            <input id="birthdayC{$i}" type="text" placeholder="##shamsihappybirthday##"
                                                   name="birthdayC{$i}"
                                                   class="shamsiChildBirthdayCalendar" readonly="readonly">
                                        </div>

{*                                        <div class="s-u-passenger-item s-u-passenger-item-change justIranian">*}
{*                                            <input id="NationalCodeC{$i}" type="tel" placeholder="##Nationalnumber##"*}
{*                                                   name="NationalCodeC{$i}"*}
{*                                                   maxlength="10" class="UniqNationalCode"*}
{*                                                   onkeyup="return checkNumber(event, 'NationalCodeC{$i}')">*}
{*                                        </div>*}

{*                                        <div class="s-u-passenger-item s-u-passenger-item-change select-meliat noneIranian">*}
{*                                            <select name="passportCountryC{$i}" id="passportCountryC{$i}"*}
{*                                                    class="select2">*}
{*                                                <option value="">##Countryissuingpassport##</option>*}
{*                                                {foreach $objFunctions->CountryCodes() as $Country}*}
{*                                                    <option value="{$Country['code']}">{$Country['titleFa']}</option>*}
{*                                                {/foreach}*}
{*                                            </select>*}
{*                                        </div>*}
                                        <div class="s-u-passenger-item s-u-passenger-item-change">
                                            <input id="passportNumberC{$i}" type="text" placeholder="##Numpassport##"
                                                   name="passportNumberC{$i}" class="UniqPassportNumber"
                                                   onkeypress="return isAlfabetNumberKeyFields(event, 'passportNumberC{$i}')">
                                        </div>
                                        <div class="s-u-passenger-item s-u-passenger-item-change">
                                            <input id="passportExpireC{$i}" class="gregorianFromTodayCalendar" type="text"
                                                   placeholder="##Passportexpirydate##" name="passportExpireC{$i}">
                                        </div>



{*                                        <div class="s-u-passenger-item s-u-passenger-item-change no-star">*}
{*                                            <div class="file-upload-wrapper site-bg-main-color-before"*}
{*                                                 data-text="فایل خود را انتخاب کنید">*}
{*                                                <input class="file-upload-field" id="VisaFileC{$i}" multiple="multiple" type="file"*}
{*                                                       name="VisaFileC{$i}[]">*}
{*                                            </div>*}

{*                                        </div>*}


                                        {if $visaInfo['custom_file_fields'] neq ''}
                                            <div class="d-flex flex-wrap w-100 mt-3">

                                                <span class="w-100 title-of-head-box mb-3">##CustomAssets##</span>

                                                {assign var="custom_file_fields" value=json_decode($visaInfo['custom_file_fields'],true)}

                                                {foreach $custom_file_fields as $key=>$item}
                                                    <div class="s-u-passenger-item s-u-passenger-item-change">

                                                        <div class="d-flex flex-wrap">
                                                            <h6>{$item}</h6>
                                                            <div class="input-group d-flex flex-wrap">
                                            <span class="input-group-btn d-flex flex-wrap">
                                                <span class="btn btn-file-child site-bg-main-color border-radius-top-right">
                                                    جستجو  &hellip; <input type="file"
                                                                           placeholder="{$item}"
                                                                           data-id="{$i}{$key}"
                                                                           id="custom_file_fields_C_{$i}"
                                                                           name="custom_file_fields_C_{$i}[]"
                                                                           single>
                                                </span>
                                            </span>
                                                                <input type="text"
                                                                       class="form-control border-radius-top-left border-r-0" readonly>
                                                                <div class="d-flex h-200 flex-wrap w-100 border-radius-bottom hidden-overflow">
                                                                    <img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEBLAEsAAD/4QCCRXhpZgAASUkqAAgAAAABAA4BAgBgAAAAGgAAAAAAAABJbWFnZSBwcmV2aWV3IGljb24uIFBpY3R1cmUgcGxhY2Vob2xkZXIgZm9yIHdlYnNpdGUgb3IgdWktdXggZGVzaWduLiBWZWN0b3IgZXBzIDEwIGlsbHVzdHJhdGlvbi7/4QWBaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/Pgo8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIj4KCTxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+CgkJPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIiB4bWxuczpJcHRjNHhtcENvcmU9Imh0dHA6Ly9pcHRjLm9yZy9zdGQvSXB0YzR4bXBDb3JlLzEuMC94bWxucy8iICAgeG1sbnM6R2V0dHlJbWFnZXNHSUZUPSJodHRwOi8veG1wLmdldHR5aW1hZ2VzLmNvbS9naWZ0LzEuMC8iIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1sbnM6cGx1cz0iaHR0cDovL25zLnVzZXBsdXMub3JnL2xkZi94bXAvMS4wLyIgIHhtbG5zOmlwdGNFeHQ9Imh0dHA6Ly9pcHRjLm9yZy9zdGQvSXB0YzR4bXBFeHQvMjAwOC0wMi0yOS8iIHhtbG5zOnhtcFJpZ2h0cz0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3JpZ2h0cy8iIHBob3Rvc2hvcDpDcmVkaXQ9IkdldHR5IEltYWdlcy9pU3RvY2twaG90byIgR2V0dHlJbWFnZXNHSUZUOkFzc2V0SUQ9IjEyMjIzNTc0NzUiIHhtcFJpZ2h0czpXZWJTdGF0ZW1lbnQ9Imh0dHBzOi8vd3d3LmlzdG9ja3Bob3RvLmNvbS9sZWdhbC9saWNlbnNlLWFncmVlbWVudD91dG1fbWVkaXVtPW9yZ2FuaWMmYW1wO3V0bV9zb3VyY2U9Z29vZ2xlJmFtcDt1dG1fY2FtcGFpZ249aXB0Y3VybCIgPgo8ZGM6Y3JlYXRvcj48cmRmOlNlcT48cmRmOmxpPmRpY2tjcmFmdDwvcmRmOmxpPjwvcmRmOlNlcT48L2RjOmNyZWF0b3I+PGRjOmRlc2NyaXB0aW9uPjxyZGY6QWx0PjxyZGY6bGkgeG1sOmxhbmc9IngtZGVmYXVsdCI+SW1hZ2UgcHJldmlldyBpY29uLiBQaWN0dXJlIHBsYWNlaG9sZGVyIGZvciB3ZWJzaXRlIG9yIHVpLXV4IGRlc2lnbi4gVmVjdG9yIGVwcyAxMCBpbGx1c3RyYXRpb24uPC9yZGY6bGk+PC9yZGY6QWx0PjwvZGM6ZGVzY3JpcHRpb24+CjxwbHVzOkxpY2Vuc29yPjxyZGY6U2VxPjxyZGY6bGkgcmRmOnBhcnNlVHlwZT0nUmVzb3VyY2UnPjxwbHVzOkxpY2Vuc29yVVJMPmh0dHBzOi8vd3d3LmlzdG9ja3Bob3RvLmNvbS9waG90by9saWNlbnNlLWdtMTIyMjM1NzQ3NS0/dXRtX21lZGl1bT1vcmdhbmljJmFtcDt1dG1fc291cmNlPWdvb2dsZSZhbXA7dXRtX2NhbXBhaWduPWlwdGN1cmw8L3BsdXM6TGljZW5zb3JVUkw+PC9yZGY6bGk+PC9yZGY6U2VxPjwvcGx1czpMaWNlbnNvcj4KCQk8L3JkZjpEZXNjcmlwdGlvbj4KCTwvcmRmOlJERj4KPC94OnhtcG1ldGE+Cjw/eHBhY2tldCBlbmQ9InciPz4K/+0ArFBob3Rvc2hvcCAzLjAAOEJJTQQEAAAAAACQHAJQAAlkaWNrY3JhZnQcAngAYEltYWdlIHByZXZpZXcgaWNvbi4gUGljdHVyZSBwbGFjZWhvbGRlciBmb3Igd2Vic2l0ZSBvciB1aS11eCBkZXNpZ24uIFZlY3RvciBlcHMgMTAgaWxsdXN0cmF0aW9uLhwCbgAYR2V0dHkgSW1hZ2VzL2lTdG9ja3Bob3Rv/9sAQwAKBwcIBwYKCAgICwoKCw4YEA4NDQ4dFRYRGCMfJSQiHyIhJis3LyYpNCkhIjBBMTQ5Oz4+PiUuRElDPEg3PT47/9sAQwEKCwsODQ4cEBAcOygiKDs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7/8IAEQgCZAJkAwERAAIRAQMRAf/EABoAAQEBAQEBAQAAAAAAAAAAAAACAwUEAQb/xAAWAQEBAQAAAAAAAAAAAAAAAAAAAQL/2gAMAwEAAhADEAAAAf2KAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAScWyAAAAAAAAAAADor7oAAAAAAAFFAAAAAAAAAzAAAAAAAB5zwWdeUAAAAAAAAAAScSzuygAAAAAACigAAAAAAAAZgAAAAAAA854LOvKAAAAAAAAAAJOJZ3ZQAAAAAABRQAAAAAAAAMwAAAAAAAec8FnXlAAAAAA+ElgAAEnEs7soAAAAAAAooAAAAAAAAGYAAAAAAAPOeCzrygAAAAD4cCzy2dCXtSgACTiWd2UAAAAAAAUUAAAAAAAADMAAAAAAAHnPBZ15QAAAAB5z87rIH6jOqAAJOJZ3ZQAAAAAABRQAAAAAAAAMwAAAAAAAec8FnXlAAAAAEn56zCz1y9+UAAScSzuygAAAAAACigAAAAAAAAZgAAAAAAA854LOvKAAAAABJibn0AAEnEs7soAAAAAAAooAAAAAAAAGYAAAAAAAPOeCzrygAYEnpAAAAAAAJOJZ3ZQAAAAAABRQAAAAAAAAMwAAAAAAAec8FnXlAGBwNSTv5vpAAAAJKABJxLO7KAAAAAAAKKAAAAAAAABmAAAAAAADzngs68oGBwNTNBS9/N9IAABgcHU7EvtgCTiWd2UAAAAAAAUUAAAAAAAADMAAAAAAAHnPBZ15RgcDUzQAUvfzfSAAYHA1M0+ncmvbAk4lndlAAAAAAAFFAAAAAAAAAzAAAAAAAB5zwWdeXA4GpmgAApe/m+kAwOBqZoB9O5Ne2JOJZ3ZQAAAAAABRQAAAAAAAAMwAAAAAAAec8FnQl4GpmgAAApe/m+kwOBqZoAB9O5NeuOJZ3ZQAAAAAABRQAAAAAAAAMwAAAAAAAec5VnmrNAAAABS9mXkWZoAAB9O3NeBO7KAAAAAAAKKAAAAAAAABmAAAAAAADzn53WQAAAAAAAAAAB7Ze7KAAAAAAAKKAAAAAAAABmAAAAAAADzn53WQAAAAAAAAAAB7Ze7KAAAAAAAKKAAAAAAAABmAAAAAAADE/N6yAAAAAAAAAAAPfL25QAAAAAABRQAAAAAAAAMwAAAAAAADzmdAAAAAAAAAAAemLAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAADMAAAAAAAAAAAAAAAAAAAAAAAAAAAAFFAAAAAAAAAzAAAAAAAAAAAAAAAAAAAAAAAAAAAABRQAAAAAAAAMwAAAAAAAAAAAAAAAAAAAAAAAAAAAAUUAAAAAAAACQAAAAAAAAAAAAAAAAAAAAAAAAAAAAfT6AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD/8QAJxAAAQMCBgMBAQEBAQAAAAAAAwABAhFgBBMUMTNAIDBQEBKQITL/2gAIAQEAAQUC/wA+Gs1rNazWs1rNazWs1rNazWs1rNazWs1rNazWs1rNazWs1vhu/wDLSxJJPnHWcdZx1nHWcdZx1nHWcdZx1nHWcdZx1nHWcdZx1nHWcdZx1nHWcdZx1nHWedYc+Z0W+GfgwW/WfbCc3Qb4Z+DBb9Z9sJzdBvhn4MFv7v6b0PthOboN8M/Bgt/aY8iOsPiHaXk+2E5ug3wz8GC39h+H9b/z4vthOboN8M/Bgt/Y7VYonFJAC5JeT7YTm6DfDPwYLf2uzOskXofbCc3Qb4Z+DBb+JCMKITMVve+2E5ug3wz8GC38CEYUZzckoyeEgmYsfTX/AL4PthOboN8M/Bgt/wBIRhRnNyS/IyeEgmYsfMpWFGRJSmA+Y36+2E5ug3wz8GC3/CEYUZzckvCMnhIJmLHxKVhRnNySTPRwHzG/H2wnN0G+GfgwW6IRhRnNyS8oyeEgmYsf0pWFGc3JL9Z6OA+YyfbCc3Qb4Z+DBbkIwozm5JeiMnhIJmLFFKwozm5JeLPRwHzGfbCc3Qb4Z+DDkYTTm5JeqMnhJsVDLnNyS82ejhPmRwnN0G+Gfg6+ywnN0G+Gfg7GE5ug3wyt/Quxg4vmdBviSAOb6US0olpRLSiWlEtKJaUS0olpRLSiWlEtKJaUS0olpRLSiWlEtKJaUS0olpRLSiWmEoxaLdBrNazWs1rNazWs1rNazWs1rNazWs1rNazWs1rNazWs1rNbp0VFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRUVFRU/zA//EABYRAQEBAAAAAAAAAAAAAAAAAAFgsP/aAAgBAwEBPwHEgI0jSNI0jSNI0jSNI0jSNMm3/8QAFBEBAAAAAAAAAAAAAAAAAAAAwP/aAAgBAgEBPwE5T//EACkQAAEBBgUEAwEBAAAAAAAAAAABAhExMpGhIDBQcYEQQFFhEiFBsCL/2gAIAQEABj8C/hpPX8P8/RFaEVoRWhFaEVoRWhFaEVoRWhFaEVoRWhFaEVoRWhFaEVoRWhFaEVoRWhFaEVoOajqjWw13HGqNbDXccao1sNZ8UyeNUa2Gs7wz0+LS/WRxqjWw1mtbYEx8ao1sNZrlHLDz0esqZHGqNbDWd9kiZPGqNbDWJ6nvx2PGqNbDWF6j1Hoe/GU7FxqjWw1geo9er0PfjIep83/Y5ZsPGqNbDXV6j1wvQ9+MT1Hr0eg5ZsHGqNbDXR6j1xvQ9+MD1Hrgeg5ZuvGqNbDQ9R65L0Pfjo9R64noOWbpxqjWw2qj1y3ofJY+B65D0HLMcao1t3PGqNbdzxqjSJ47n5fiaq9WSW5LcluS3JbktyW5LcluS3JbktyW5LcluS3JbktyW5LcluS3JbjkR38NT//EACoQAAECBAYCAgIDAQAAAAAAAAEAMRFBUXEgITBQofAQ4UCxYGGQkaCw/9oACAEBAAE/If8AhpAAAAytBEqT6QAj8fWta1rWta1rWta1rWtagZlQsbXPKe6q4Y+O/ZM3bqrgj47lkzduquCNeKYZ19ByyZu3VXBGqSACSwRWATIHgGjjyBMsblkzduquCNWIQ8CPMeGJyyZu3VXBGqA7BEFAh+lXgZBUNcblkzduquCNYDAARQoCMeNAACAyxuWTN26q4IxT5yFVE4yF/gHLJm7dVcEYZ85CqPD+kOHgQqGF9JAAIiJYYXLJm7dVcEYJ85CqPD+vI4eBCoYX0EyEhVR+/RCSG1hzgcsmbt1VwR5nzkKo8P6wjh4EKhhfEmQkKo8Pn9eCCJAiaG1hz5csmbt1VwR4n3kKo9P6xjh4EKhhfAmQkKo8Pn9YCCJAiaG1hz4csmbt1VwQp85CqPD+tEcPAhUML+EyEhVHh8/rEQRIETQ2sOU5ZM3bqqnGICqPT+tMcPAhFSlTw+f1oEESBE0E2WA/tM3fhigSUQYEJm78NUzdugryORN8gg5DdUIKNRkuol1Euol1Euol1Euol1Euol1Euol1Euol1Euol1Euol1Euol1Euol1Eu4lAyCg/0KgAAAAAAAAAAAAAQ/i/8A/9oADAMBAAIAAwAAABBtttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttv/8A/wD/AP8A/wD/AP8A/wCG2222222222222222222222222u22222222223222222222222222222222222221W2222222222+22222222222222222222222222q222222/2223222222222222222222222222221W222223i222+22222222222222222222222222q222222yS223222222222222222222222222221W22222+jm22+22222222222222222222222222q222222/+223222222222222222222222222221W2382222222+22222222222222222222222222q23xE2222+23222222222222222222222222221W3wTE222+I2+22222222222222222222222222q3wSTE22+CY3222222222222222222222222221XwSSTE2+CSY+22222222222222222222222222rwSSSTE+CSSZ222222222222222222222222221wSSSSTACSSSY22222222222222222222222222iSSSSSSSSSSTW22222222222222222222222220SSSSSSSSSSSS22222222222222222222222223ySSSSSSSSSSSe222222222222222222222222225JJJJJJJJJJJ22222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222223//xAAdEQEAAgIDAQEAAAAAAAAAAAABABExUCAwQBCw/9oACAEDAQE/EPw07ZbLZbLZbLZbLZbLZbLZbLZbLZbLZbLZbLZbBvaOPSNo49I2jj0jaOO8vweg2jjuOOs2jjvJXwOg2jjwKOk2jjmWDfhNo45F+jfgNo44ll8BvoWpcG+JtHHAvMb5LwHgbRx9LF6BvgvIb+m0cfC9Y38XoG/htHEHtvqG4bRx6TaOPSbR9JtalEolEolEolEolEolEolEolEolEolEolEolH4av8A/8QAHREAAwEBAAMBAQAAAAAAAAAAAAERMFAQIECwYP/aAAgBAgEBPxD8NOERERERERERERERERERERERERERERERENdRD+h9RD+h9RD+h9RD2S8NYPqIeqzfUQ9k/DeD6iHvcX1EP3a+F9RDwa+B9RDxaya9X1EPJrJr0fUQ82smvL6iHo1k14fUQ9Zk0PqL6X1F9L/jX1aUpSlKUpSlKUpSlKUpSl/DV//EACgQAAEDAwMDBQEBAQAAAAAAAAEAETFAUWEhUPBB0fEQIDBxoZGQsf/aAAgBAQABPxD/ABxcXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6cXTi6eiMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMHe5miMGhJYxhMBHrj02JsrwXsvBey8F7LwXsvBey8F7LwXsvBey8F7LwXsvBey8F7LwXsvBey8F7LwXsvBey8F7LwXsvBey8F7LwXsiGwgSSLf8TSgBsOgB3oZmiMGiIQ62sn9pwBCQ4JOKJEzRGDRFzmaf96iRM0Rg0Rc5n5w2zWAX+D96iRM0Rg0Rc5n5TtMByT0CEHJYJZxc+hlh7g5Pprb3/vUSJmiMGiLnM/KZOf8Ax1/PUTojIkwv9t7v3qJEzRGDRFzmflHM5xDBR6QSMWgd/Q20Gcg/ge/96iRM0Rg0Rc5n5ik9SBwmTc/j+ICAAEACPf8AvUSJmiMGiLnM+49I5aDkloE6yjIxQfvUSJmiMGiLnM+09I5aDkk/2JgCAsEQOdoU4Awn1ZGPiIQTzh1Pt/eokTNEYNEXOZ9h6Ry0HJJ/sTAEBYepA52hTgDCfVkY+AlO5aDkk6mBLuN9QgYgG1HQbj2fvUSJmiMGiLnM+p6Ry0HJJ/sTA6BYe0gc7QhOAMJ9WRj3Ep3LQcknOxQOgWHoeAc4A6hAxANqOmY9f3qJEzRGDRFzmfQ8I5aDkk/mJgdAsPeQOdoU4Awn1ZGPYSnctBySc7FA6BYew8A5wEgoGIBtR0zHp+9RImaIwaIucyj0jloOST/YmAICw+Egc7QpwBhPqyMehKdy0HJJzsUDoFh7jwDnASEDEA2o6DcL96iRM0Rg0RFockA5LVP5iYHQLD4yBztCjnQ0iEk4wnOxQOgWHwHgHOAkFG4B1x0FpFEiZojB2kh84hwQdRRImaIwd7LEzRGDQjkc5lyiCRBDEaEGoC4FyCcnpQzNEYNEbmjkhd9ssvhlZfDKy+GVl8MrL4ZWXwysvhlZfDKy+GVl8MrL4ZWXwysvhlZfDKy+GVl8MrL4ZWXwysvhlZfDKy+GVl8MoDM+GUAjGAUMzRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGDvczRGE+6fdPun3T7p90+6fdPun3T7p90+6fdPun3T7p90+6fdPun3T7p90+6fdPun3T7p90+6fdPun3T7p90+6fdPun3T7p90+6fdPun3T7p90+6fdPun3T7p90+6fdPun3T46/5f//Z
"
                                                                         data-id="{$i}{$key}"
                                                                         alt="" class="imagepreview-child w-100 h-100">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                {/foreach}
                                            </div>
                                        {/if}


                                        <div id="messageC{$i}"></div>
                                    </div>
                                </div>

                            </div>
                        {/for}

                        {*فرم ثبت نام به تعداد نوزادان*}
                        {for $i=1 to $smarty.post.count_infant_internal}
                            <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first">
                <span class="s-u-last-p-nozad s-u-last-p-nozad-change site-main-text-color">
              <i class="soap-icon-man-1"></i>  ##Baby##
                </span>
                                <div class="panel-default-change site-border-main-color">
                                    <div class="panel-heading-change">

{*                                        <span class="hidden-xs-down">##Nation##:</span>*}

{*                                        <span class="kindOfPasenger">*}
{*                            <label class="control--checkbox">*}
{*                                <span>##Iranian##</span>*}
{*                                <input type="radio" name="passengerNationalityI{$i}" id="passengerNationalityI{$i}"*}
{*                                       value="0" class="nationalityChange" checked="checked">*}
{*                                <div class="checkbox">*}
{*                                    <div class="filler"></div>*}
{*                                    <svg viewBox="0 0 20 20">*}
{*                                        <polyline points="4 11 8 15 16 6"></polyline>*}
{*                                    </svg>*}
{*                                </div>*}
{*                            </label>*}
{*                        </span>*}
{*                                        <span class="kindOfPasenger">*}
{*                            <label class="control--checkbox">*}
{*                                <span>##Noiranian##</span>*}
{*                                <input type="radio" name="passengerNationalityI{$i}" id="passengerNationalityI{$i}"*}
{*                                       value="1" class="nationalityChange">*}
{*                                <div class="checkbox">*}
{*                                    <div class="filler"></div>*}
{*                                    <svg viewBox="0 0 20 20">*}
{*                                        <polyline points="4 11 8 15 16 6"></polyline>*}
{*                                    </svg>*}
{*                                </div>*}
{*                            </label>*}
{*                        </span>*}

                                        {if $objSession->IsLogin() and ($smarty.session.typeUser eq 'counter')}
                                            <span class="s-u-last-passenger-btn s-u-last-passenger-btn-change"
                                                  onclick="setHidenFildnumberRow('I{$i}')">
                            <i class="zmdi zmdi-pin-account zmdi-hc-fw"></i>##Passengerbook##
                        </span>
                                        {/if}

                                    </div>


                                    <div class="panel-body-change ">
{*                                        <div class="s-u-passenger-item s-u-passenger-item-change">*}
{*                                            <select id="genderI{$i}" name="genderI{$i}">*}
{*                                                <option value="" disabled selected="selected">##Sex##</option>*}
{*                                                <option value="Male">##Boy##</option>*}
{*                                                <option value="Female">##Girl##</option>*}
{*                                            </select>*}
{*                                        </div>*}

                                        <div class="s-u-passenger-item s-u-passenger-item-change">
                                            <input id="nameEnI{$i}" type="text" placeholder="##Nameenglish##" name="nameEnI{$i}"
                                                   onkeypress="return isAlfabetKeyFields(event, 'nameEnI{$i}')">
                                        </div>
                                        <div class="s-u-passenger-item s-u-passenger-item-change">
                                            <input id="familyEnI{$i}" type="text" placeholder="##Familyenglish##"
                                                   name="familyEnI{$i}"
                                                   onkeypress="return isAlfabetKeyFields(event, 'familyEnI{$i}')">
                                        </div>
                                        <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                                            <input id="birthdayEnI{$i}" type="text" placeholder="##miladihappybirthday##"
                                                   name="birthdayEnI{$i}" class="gregorianInfantBirthdayCalendar"
                                                   readonly="readonly">
                                        </div>

                                        <div class="s-u-passenger-item s-u-passenger-item-change">
                                            <input id="nameFaI{$i}" type="text" placeholder="##Namepersion##" name="nameFaI{$i}"
                                                   onkeypress=" return persianLetters(event, 'nameFaI{$i}')" class="justpersian">
                                        </div>
                                        <div class="s-u-passenger-item s-u-passenger-item-change">
                                            <input id="familyFaI{$i}" type="text" placeholder="##Familypersion##"
                                                   name="familyFaI{$i}" onkeypress=" return persianLetters(event, 'familyFaI{$i}')"
                                                   class="justpersian">
                                        </div>
                                        <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                            <input id="birthdayI{$i}" type="text" placeholder="##shamsihappybirthday##"
                                                   name="birthdayI{$i}"
                                                   class="shamsiInfantBirthdayCalendar" readonly="readonly">
                                        </div>

                                        <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                            <input id="NationalCodeI{$i}" type="tel" placeholder="##Nationalnumber##"
                                                   name="NationalCodeI{$i}"
                                                   maxlength="10" class="UniqNationalCode"
                                                   onkeyup="return checkNumber(event, 'NationalCodeI{$i}')">
                                        </div>

                                        <div class="s-u-passenger-item s-u-passenger-item-change select-meliat noneIranian">
                                            <select name="passportCountryI{$i}" id="passportCountryI{$i}"
                                                    class="select2">
                                                <option value="">##Countryissuingpassport##</option>
                                                {foreach $objFunctions->CountryCodes() as $Country}
                                                    <option value="{$Country['code']}">{$Country['titleFa']}</option>
                                                {/foreach}
                                            </select>
                                        </div>
                                        <div class="s-u-passenger-item s-u-passenger-item-change">
                                            <input id="passportNumberI{$i}" type="text" placeholder="##Numpassport##"
                                                   name="passportNumberI{$i}" class="UniqPassportNumber"
                                                   onkeypress="return isAlfabetNumberKeyFields(event, 'passportNumberI{$i}')">
                                        </div>
                                        <div class="s-u-passenger-item s-u-passenger-item-change">
                                            <input id="passportExpireI{$i}" class="gregorianFromTodayCalendar" type="text"
                                                   placeholder="##Passportexpirydate##" name="passportExpireI{$i}">
                                        </div>


                                        <div class="s-u-passenger-item s-u-passenger-item-change no-star">
                                            <div class="file-upload-wrapper site-bg-main-color-before"
                                                 data-text="فایل خود را انتخاب کنید">
                                                <input class="file-upload-field" id="VisaFileI{$i}" multiple="multiple" type="file"
                                                       name="VisaFileI{$i}[]">
                                            </div>

                                        </div>


                                        <div id="messageI{$i}"></div>
                                    </div>
                                </div>

                            </div>
                        {/for}


                        {if $objSession->IsLogin()}
                            <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first">

                <span class="s-u-last-p-nozad s-u-last-p-nozad-change site-main-text-color">

                    ##InformationSaler##
                </span>

                                <div class="panel-default-change-Buyer boxInformationBuyer">
                                    <div class="s-u-passenger-items widthInputInformationBuyer s-u-passenger-item-change">
                                        <input id="Mobile_buyer" type="tel" placeholder="##SalerPhone##" name="Mobile_buyer"
                                               value="{$InfoMember.mobile}"
                                               onkeypress="return checkNumber(event, 'Mobile_buyer')"/>
                                    </div>

                                    <div class="s-u-passenger-items widthInputInformationBuyer padl0 s-u-passenger-item-change">
                                        <input id="Email_buyer" type="email" placeholder="##Emailbuyer##" name="Email_buyer"
                                               value="{$InfoMember.email}"/>
                                    </div>
                                    <div id="errorInfo" class="alert_msg"></div>
                                </div>

                            </div>
                        {/if}

                        {if not $objSession->IsLogin()}
                            <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change-Buyer  first">
            <span class="s-u-last-p-pasenger s-u-last-p-pasenger-change site-main-text-color">
              <i class="zmdi zmdi-account-box-phone zmdi-hc-fw"></i>
                ##InformationSaler##
          </span>
                                <input type="hidden" name="UsageNotLogin" value="yes" id="UsageNotLogin">
                                <div class="panel-default-change-Buyer">
                                    <div class="s-u-passenger-items s-u-passenger-item-change">
                                        <input id="Mobile" type="text" placeholder="##Phonenumber##" name="Mobile" class="dir-ltr">
                                    </div>
                                    <div class="s-u-passenger-items s-u-passenger-item-change no-star">
                                        <input id="Telephone" type="text" placeholder="##Phone##" name="Telephone" class="dir-ltr">
                                    </div>
                                    <div class="s-u-passenger-items s-u-passenger-item-change padl0">
                                        <input id="Email" type="email" placeholder="##Email##" name="Email" class="dir-ltr">
                                    </div>
                                    <div class="alert_msg" id="messageInfo"></div>
                                </div>
                            </div>
                        {/if}

                        <div class="btn-section mt-2">
                            <p class="s-u-result-item-RulsCheck-item">
                                <input class="FilterHoteltype Show_by_filters FilterHoteltypeName-top" id="RulsCheck" name="heck_list1" value="" type="checkbox">
                                <label class="FilterHoteltypeName site-main-text-color-a " for="RulsCheck">
                                    <a class="site-main-text-color" href="{$smarty.const.URL_RULS}" target="_blank">##Seerules## </a> ##IhavestudiedIhavenoobjection##
                                </label>
                            </p>
                            <div class="btn-visa mt-3">
                                <div class="passengersDetailLocal_next">
                                    {assign var="passengerCount" value=$smarty.post.count_adult_internal + $smarty.post.count_child_internal + $smarty.post.count_infant_internal}
                                    <a class="f-loader-check loaderpassengers" id="loader_check" style="display:none"></a>
                                    <input type="button"
                                           onclick="preReserveVisa('{$smarty.post.factorNumber}' , {$smarty.now} ,{$smarty.post.count_adult_internal} , {$smarty.post.count_child_internal} , this) "
{*                                                                       onclick="checkPassengerVisa({$smarty.now} , {$smarty.post.count_adult_internal} , {$smarty.post.count_child_internal} , {$smarty.post.count_infant_internal})"*}
                                           value="درخواست ویزا"
                                           class="s-u-submit-passenger s-u-select-flight-change s-u-submit-passenger-Buyer site-bg-main-color"
                                           id="final_ok_and_insert_passenger">
                                </div>
                            </div>
                            <div id="messageBook" class="error-flight"></div>


                        </div>

                        <input type="hidden" id="numberRow" value="0"/>
{*                        <input type="hidden" class="internal-adult-js" name="count_adult_internal" id="count_adult_internal" value="{$smarty.post.count_adult_internal}">*}
{*                        <input type="hidden" class="internal-child-js" name="count_child_internal" id="count_child_internal" value="{$smarty.post.count_child_internal}">*}
                        <input type="hidden" name="time_remmaining" id="time_remmaining" value=""/>
                        <input type="hidden" name="OnlinePayment" id="OnlinePayment" value="{$visaInfo.OnlinePayment}"/>
                        <input type="hidden" name="visaID" id="visaID" value="{$smarty.post.visaID}"/>
                        <input type="hidden" name="idMember" id="idMember" value=""/>


                        <input type="hidden" name="CurrencyCode" id="CurrencyCode" value="{$smarty.post.CurrencyCode}"/>
                    </form>
                </div>





            {literal}
                <script src="assets/js/jquery.counter.js" type="text/javascript"></script>
                <script type="text/javascript">

                   $("form").on("change", ".file-upload-field", function () {
                      $(this).parent(".file-upload-wrapper")
                         .attr("data-text", $(this).val().replace(/.*(\/|\\)/, ''));
                   });
                   /*$('.counter').counter({});
                   $('.counter').on('counterStop', function () {
                       $('.lazy_loader_flight').slideDown({
                           start: function () {
                               $(this).css({
                                   display: "flex"
                               })
                           }
                       });

                   });*/

                   $(document).on('change', '.btn-file :file', function () {
                      const FileType = checkFileType($(this));
                      if (FileType) {
                         readURL(this, $(this));
                         var input = $(this),
                            numFiles = input.get(0).files ? input.get(0).files.length : 1,
                            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                         input.trigger('fileselect', [numFiles, label]);
                      }
                   });

                   $(document).ready(function () {
                      $('.btn-file :file').on('fileselect', function (event, numFiles, label) {

                         var input = $(this).parents('.input-group').find(':text'),
                            log = numFiles > 1 ? numFiles + ' files selected' : label;

                         if (input.length) {
                            input.val(log);
                         } else {
                            if (log) alert(log);
                         }

                      });
                   });

                   function readURL(input, thiss) {


                      if (input.files && input.files[0]) {
                         var reader = new FileReader();
                         reader.onload = function (e) {
                            $('.imagepreview[data-id="' + thiss.data('id') + '"]').attr('src', e.target.result);
                         }
                         reader.readAsDataURL(input.files[0]);
                      } else {
                         $('.imagepreview').attr('src', '');
                      }
                   }

                   $(".btn-file :file").change(function () {
                      const FileType = checkFileType($(this), true);
                      if (FileType) {
                         readURL(this, $(this));
                      }

                   });









                   $(document).on('change', '.btn-file-child :file', function () {
                      const FileType = checkFileType($(this));
                      if (FileType) {
                         readURLChild(this, $(this));
                         var input = $(this),
                            numFiles = input.get(0).files ? input.get(0).files.length : 1,
                            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                         input.trigger('fileselect', [numFiles, label]);
                      }
                   });

                   $(document).ready(function () {
                      $('.btn-file-child :file').on('fileselect', function (event, numFiles, label) {

                         var input = $(this).parents('.input-group').find(':text'),
                            log = numFiles > 1 ? numFiles + ' files selected' : label;

                         if (input.length) {
                            input.val(log);
                         } else {
                            if (log) alert(log);
                         }

                      });
                   });

                   function readURLChild(input, thiss) {


                      if (input.files && input.files[0]) {
                         var reader = new FileReader();
                         reader.onload = function (e) {
                            $('.imagepreview-child[data-id="' + thiss.data('id') + '"]').attr('src', e.target.result);
                         }
                         reader.readAsDataURL(input.files[0]);
                      } else {
                         $('.imagepreview-child').attr('src', '');
                      }
                   }

                   $(".btn-file-child :file").change(function () {
                      const FileType = checkFileType($(this), true);
                      if (FileType) {
                         readURLChild(this, $(this));
                      }

                   });











                   // $("#send_data").on('click' , function(){
                   //    $("#formPassengerDetailVisa").submit();
                   // })


                </script>
                <script src="assets/js/jdate.js" type="text/javascript"></script>
                <script src="assets/js/script.js"></script>
            {/literal}

            {/if}

        </div>


        <!-- bank connect -->
        <div class="main-pay-content">

            <!-- payment methods drop down -->
            {assign var="memberCreditPermition" value="0"}
            {if $objSession->IsLogin() && $objMember->list['fk_counter_type_id'] == '5'}
                {$memberCreditPermition = "1"}
            {/if}

            {assign var="counterCreditPermition" value="0"}
            {if $objSession->IsLogin() && $objMember->list['fk_counter_type_id'] != '5'}
                {$counterCreditPermition = "1"}
            {/if}

            {assign var="bankInputs" value=['flag' => 'check_credit_visa', 'factorNumber' => $smarty.post.factorNumber, 'serviceType' => $serviceType]}
            {assign var="bankAction" value="`$smarty.const.ROOT_ADDRESS`/goBankVisa"}

            {assign var="creditInputs" value=['flag' => 'buyByCreditVisa', 'factorNumber' => $smarty.post.factorNumber]}
            {assign var="creditAction" value="`$smarty.const.ROOT_ADDRESS`/returnBankVisa"}

            {assign var="currencyPermition" value="0"}
            {if $smarty.const.ISCURRENCY && $CurrencyCode > 0}
                {$currencyPermition = "1"}
                {assign var="currencyInputs" value=['flag' => 'check_credit_visa', 'factorNumber' => $smarty.post.factorNumber, 'serviceType' => $serviceType, 'amount' => $totalCurrency.AmountCurrency, 'currencyCode' => $CurrencyCode]}
                {assign var="currencyAction" value="`$smarty.const.ROOT_ADDRESS`/returnBankVisa"}
            {/if}

            {include file="`$smarty.const.FRONT_CURRENT_CLIENT`paymentMethods.tpl"}
            <!-- payment methods drop down -->

        </div>
</div>

    <div class="col-lg-3">

    </div>
</div>