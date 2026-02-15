{load_presentation_object filename="resultReservationVisa" assign="objResultVisa"}
{load_presentation_object filename="currencyEquivalent" assign="objCurrency"}
{load_presentation_object filename="currency" assign="objCurrencyVisa"}
{load_presentation_object filename="country" assign="objCountry"}
{load_presentation_object filename="visaType" assign="objVisaType"}
{load_presentation_object filename="visa" assign="objVisa"}
{load_presentation_object filename="agency" assign="objAgency"}
{*{load_presentation_object filename="articles" assign="obj_articles" }*}

{assign var="searchResult" value=$objResultVisa->visaSearch($smarty.const.DESTINATION_CODE, $smarty.const.VISA_TYPE , $smarty.const.VISA_CATEGORY)}
{assign var="continents" value=$objCountry->continentsList()}
{assign var="countries" value=$objCountry->getCountriesWithVisa()}
{assign var="searchContinent" value=$objCountry->getCountryByCode($smarty.const.DESTINATION_CODE)}
{assign var="searchCountries" value=$objResultVisa->countriesHaveVisa($searchContinent.continentID)}
{assign var="visaTypeList" value=$objResultVisa->allCountryVisaTypes($smarty.const.DESTINATION_CODE)}



{if $smarty.const.SOFTWARE_LANG eq 'en'}
    <link rel='stylesheet' href='assets/styles/css/modules-en/visa-en.css'>
{else}
    <link rel='stylesheet' href='assets/styles/visa.css'>
{/if}

<div class="row">
    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 col-padding-5">
        <div class="parent_sidebar">

            <!-- Search Box -->
            <div class="filterBox">
                <div class="filtertip_visa site-bg-main-color site-bg-color-border-bottom">
                    <p class="txt14">##Searchnamevisa## </p>
                    <span class="silence_span ph-item2"></span>
                    {*<p class="txt14">
                        <a class="iranM"></a>
                        <b dir="ltr"></b>
                    </p>*}
                </div>
                <div class="filtertip-searchbox ">
                    <form class="search-wrapper" action="" method="post">
                        <input type='hidden' value='True' id='visa_continent' name='visa_continent'
                               class='continent-visa-js'>

                        <div class="form-hotel-item form-hotel-item-searchBox marb10">
                            <div class="select">
                                <select name="visa_destination" onchange="initTypeOfCountry()" id="visa_destination"
                                        class="select2">

{*                                    <option value="">##Destination##</option>*}
                                    <option value="all"
                                            {if $smarty.const.VISA_COUNTRY eq 'all'}selected="selected"{/if}>##All##
                                    </option> {foreach $countries as $each}
                                        <option value="{$each.abbreviation}"
                                                {if $smarty.const.DESTINATION_CODE eq $each.abbreviation}selected="selected"{/if}>
                                            {if $smarty.const.SOFTWARE_LANG != 'fa'}
                                                {$each.name_en}
                                            {else}
                                                {$each.name}
                                            {/if}
                                        </option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>


                        <div class="form-hotel-item form-hotel-item-searchBox">
                            <div class="select">
                                <select name="visa_type" id="visa_type" class="select2">
                                    <option value="all" {if $smarty.const.VISA_TYPE eq 'all'}selected="selected"{/if}>
                                        ##All##
                                    </option>
                                    {foreach $visaTypeList as $each}
                                        <option value="{$each.id}"
                                                {if $smarty.const.VISA_TYPE eq $each.id}selected="selected"{/if}>{$each.title}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>

                        <div class="number_passengers displayiN">

                            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change width100 ">
                                <div class="s-u-form-input-wrapper">
                                    <p class="s-u-number-input  s-u-number-input-change  inp-adt inp-adt-change">
                                        <i class="plus zmdi zmdi-plus-circle site-main-text-color-h" id="add1"></i>
                                        <input id="qty1" type="number" value="{$smarty.const.SEARCH_ADULT}" name="adult"
                                               min="0"
                                               max="9">
                                        <i class="minus zmdi zmdi-minus-circle site-main-text-color-h" id="minus1"></i>
                                    </p>
                                </div>
                            </div>

                            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change width100 ">
                                <div class="s-u-form-input-wrapper">
                                    <p class="s-u-number-input  s-u-number-input-change  inp-child inp-child-change">
                                        <i class="plus zmdi zmdi-plus-circle site-main-text-color-h" id="add2"></i>
                                        <input id="qty2" type="number" value="{$smarty.const.SEARCH_CHILD}" name="child"
                                               min="0"
                                               max="9">
                                        <i class="minus zmdi zmdi-minus-circle site-main-text-color-h" id="minus2"></i>
                                    </p>
                                </div>
                            </div>

                            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change width100 ">
                                <div class="s-u-form-input-wrapper">
                                    <p class="s-u-number-input  s-u-number-input-change  inp-baby inp-baby-change">
                                        <i class="plus zmdi zmdi-plus-circle site-main-text-color-h" id="add3"></i>
                                        <input id="qty3" type="number" value="{$smarty.const.SEARCH_INFANT}"
                                               name="infant" min="0"
                                               max="9">
                                        <i class="minus zmdi zmdi-minus-circle site-main-text-color-h" id="minus3"></i>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="form-visa-item-searchBox-btn">
                            <span></span>
                            <div class="input">
                                <button class="site-bg-main-color site-secondary-text-color" type="button"
                                        onclick="submitSearchVisa()">##Search##
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>

    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 changePad-md col-padding-5">

        {if $objResultVisa->reservationVisaAuth() eq 'False'}
            <div class="userProfileInfo-messge">
                <div class="messge-login BoxErrorSearch">
                    <div style="float: right;"><i class="fa fa-exclamation-triangle IconBoxErrorSearch"></i></div>
                    <div class="TextBoxErrorSearch">##Gosupport##</div>
                </div>
            </div>
        {elseif $objResultVisa->error eq true}
            {* <div class="userProfileInfo-messge">
                 <div class="messge-login BoxErrorSearch">
                     <div style="float: right;"><i class="fa fa-exclamation-triangle IconBoxErrorSearch"></i></div>
                     <div class="TextBoxErrorSearch">{$objResultVisa->errorMessage}</div>
                 </div>
             </div>*}
            {load_presentation_object filename="fullCapacity" assign="objFullCapacity"}
            {assign var="get_info" value=$objFullCapacity->getFullCapacitySite(1)}
            <div id='show_offline_request'>
                <div class='fullCapacity_div'>
                    {if $get_info['pic_url']!=''}
                        <img src='{$get_info['pic_url']}' alt='{$get_info['pic_title']}'>
                    {else}
                        <img src='assets/images/fullCapacity.png' alt='fullCapacity'>
                    {/if}
                    <h2>##PleaseSearchAnotherDestinationVisa##</h2>
                    <h2>##CurrentlyNoVisaIntendedDestination##</h2>
                </div>
            </div>
        {else}
            {$objFunctions->showConfigurationContents('visa_search_advertise','<div class="advertises">','</div>','<div class="advertise-item">','</div>')}
            <div class="main-visa">
                {assign var="i" value=0}


                {foreach $searchResult as $key => $item}
                    {assign var="visaTypeMoreDetail" value=$objVisa->getVisaTypeMoreDetail(['country_id'=>$searchContinent.countryID,'type_id'=>$item.visaTypeID])}
                    <div class="card_visa ">

                        <div class="col_right_visa">

{*                            <div class="col-md-12 d-flex flex-wrap">*}
{*                                <h5>*}
{*                                    {$item.title} ( {$item.visaTypeTitle} )*}
{*                                </h5>*}
{*                                {if $item.agency_id != 0}*}
{*                                    {assign var="agencyInfoByIdMember" value=$objAgency->AgencyInfoByIdMember($item.agency_id)}*}
{*                                    <button class="mr-auto btn theme-btn2 site-bg-main-color"> ##Agency##*}
{*                                        : {$agencyInfoByIdMember['name_fa']} </button>*}
{*                                {else}*}
{*                                    <button class="{if $smarty.const.SOFTWARE_LANG eq 'en'} ml-auto {else} mr-auto {/if} btn theme-btn2 site-bg-main-color site-main-button-color-hover site-bg-color-dock-border">*}
{*                                        ##Agency## : {$smarty.const.CLIENT_NAME} </button>*}
{*                                {/if}*}
{*                            </div>*}

                            <ul class="col-md-12">
                                <li class="col-md-3 text-center">
                            <span>
                                ##DeliveryTime##:
                                <i> {$item.deadline}</i>
                            </span>
                                </li>
                                <li class="col-md-3 text-center">
                            <span>
                                ##VisaValidity##:
                                <i> {$item.validityDuration}</i>
                            </span>
                                </li>
                                <li class="col-md-3 text-center">
                            <span>
                                ##Countenter##:
                                <i> {$item.allowedUseNo}</i>
                            </span>
                                </li>
                                <li class="col-md-3 text-center">
                            <span>
                                ##Typevisa##:
                                <i> {$item.visaTypeTitle}</i>
                            </span>
                                </li>
                            </ul>

                        </div>


                        <div class="col_left_visa">

                            {if $item.redirectUrlCheck == '1'}
                                <div class="prices_visa">

                                <span class="">
                                    {if $item.mainCost neq $item.priceWithDiscount}
                                        <p class="visa-text">
                                            {assign var="mainCurrency" value=$objFunctions->CurrencyCalculate($item.mainCost, $item.currencyType)}
                                            <span class="old-price text-decoration-line CurrencyCal CurrencyText"
                                                  data-amount="{$item.mainCost}">{$objFunctions->numberFormat($mainCurrency.AmountCurrency)}</span>
                                        </p>
                                    {/if}

                                    {assign var="discountCurrency" value=$objFunctions->CurrencyCalculate($item.priceWithDiscount, $item.currencyType)}
                                    <span class="price_visa"
                                          data-amount="{$item.priceWithDiscount}">{$objFunctions->numberFormat($discountCurrency.AmountCurrency)}</span>
                                    <span class="  d-inline-block font13 align-items-center align-center align-content-center justify-content-center">
                                        {if $item.OnlinePayment eq 'yes'}
                                            {$discountCurrency.TypeCurrency}
                                        {else}
                                            {if $item.currencyType eq '0'}
                                                ##Rial##
                                            {else}
                                                {assign var="VisacurrencyType" value=$objCurrencyVisa->ShowInfo($item.currencyType)}
                                                {$VisacurrencyType.CurrencyTitle}
                                            {/if}

                                        {/if}


                                    </span>

                                </span>
                                    <div class="prepayment flex-wrap">
                                        <i class="d-block w-100"> ##PrePrice##: </i>
                                        {assign var="prePaymentCurrency" value=$objFunctions->CurrencyCalculate($item.prePaymentCost , $item.currencyType)}
                                        <span class=" iranM site-main-text-color-drck CurrencyCal"
                                              data-amount="{$item.prePaymentCost}">{$objFunctions->numberFormat($prePaymentCurrency.AmountCurrency)}</span>
                                        {*<i class="CurrencyText">
                                            {if $item.OnlinePayment eq 'yes'}
                                                {$prePaymentCurrency.TypeCurrency}
                                            {else}
                                                {if $item.currencyType eq '0'}
                                                    تومان
                                                {else}
                                                    {assign var="VisacurrencyType" value=$objCurrencyVisa->ShowInfo($item.currencyType)}
                                                    {$VisacurrencyType.CurrencyTitle}
                                                {/if}
                                            {/if}
                                        </i>*}
                                    </div>
                                </div>
                                <div class="">
                                    {assign var="agencyInfoByIdMember" value=$objAgency->AgencyInfoByIdMember($item.agency_id)}
                                </div>
                                <a href="{$visaTypeMoreDetail.url}?targetId={$item.id}"
                                   class="btn theme-btn site-bg-main-color">
                                    ##MoreDetails##
                                </a>
                            {else}
                                <div class="">
                                    <div class="prices_visa">
                                        {*                                    sssssssssss- {$item.currencyType}*}
                                        {if $item.mainCost neq $item.priceWithDiscount}
                                            <p class="visa-text">
                                                {assign var="mainCurrency" value=$objFunctions->CurrencyCalculate($item.mainCost, $item.currencyType)}
                                                <span class=""
                                                      data-amount="{$item.mainCost}">{$objFunctions->numberFormat($mainCurrency.AmountCurrency)}</span>
                                            </p>
                                        {/if}
                                        {assign var="discountCurrency" value=$objFunctions->CurrencyCalculate($item.priceWithDiscount , $item.currencyType)}
                                        <span class="price_visa"
                                              data-amount="{$item.priceWithDiscount}">{$objFunctions->numberFormat($discountCurrency.AmountCurrency)}</span>
                                        <span class="">
                                        {if $item.OnlinePayment eq 'yes'}
                                            {$discountCurrency.TypeCurrency}
                                        {else}
                                            {if $item.currencyType eq '0'}
                                                ##Rial##

                                            {else}
                                                {assign var="VisacurrencyType" value=$objCurrencyVisa->ShowInfo($item.currencyType)}
                                                {$VisacurrencyType.CurrencyTitle}



                                            {/if}
                                        {/if}

                                    </span>

                                    </div>
                                    <div class="marb5 visa-text text-center priceSortAdt_visa">
                                        <p class="">
                                            <span class="d-block"> ##PrePrice##: </span>
                                            {assign var="prePaymentCurrency" value=$objFunctions->CurrencyCalculate($item.prePaymentCost, $item.currencyType)}
                                            <span class=" iranM CurrencyCal"
                                                  data-amount="{$item.prePaymentCost}">{$objFunctions->numberFormat($prePaymentCurrency.AmountCurrency)}</span>
                                            <i class="CurrencyText">
                                                {if $item.OnlinePayment eq 'yes'}
                                                    {$prePaymentCurrency.TypeCurrency}
                                                {else}
                                                    {if $item.currencyType eq '0'}
                                                        ##Rial##
                                                    {else}
                                                        {assign var="VisacurrencyType" value=$objCurrencyVisa->ShowInfo($item.currencyType)}
                                                        {$VisacurrencyType.CurrencyTitle}
                                                    {/if}
                                                {/if}
                                            </i>
                                        </p>
                                    </div>


{*                                    <a class="btn theme-btn  site-bg-main-color site-main-button-color-hover"*}
{*                                       onclick="chooseVisa({$item.id}); return false;">{if $item.OnlinePayment == 'yes'}##Request##{else}##Request##{/if}</a> *}
{*                                    *}
                                    <a class="btn theme-btn  site-bg-main-color site-main-button-color-hover"
                                       onclick="chooseVisa2({$item.id});">درخواست</a>

                                </div>
                            {/if}
                        </div>

                        <div class="international-available-details">
                            <div>
                                <div class=" international-available-panel-min">
                                    <ul class="tabs">
                                        <li class="tab-link current site-border-top-main-color"
                                            data-tab="tab-1-{$key}"> ##Description##
                                        </li>
                                        <li class="tab-link site-border-top-main-color"
                                            data-tab="tab-2-{$key}"> ##Documents##
                                        </li>
                                    </ul>

                                    <div id="tab-1-{$key}" class="tab-content current">
                                        <p>
                                            {$item.descriptions}
                                        </p>
                                    </div>

                                    <div id="tab-2-{$key}"
                                         class="tab-content price-Box-Tab">
                                        <p>
                                            {$item.documents}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <span class="international-available-detail-btn more_1">
                            {if $objSession->IsLogin()}
                                {assign var="counterId" value=$objFunctions->getCounterTypeId($smarty.session.userId)}
                                {assign var="paramPointClub" value=[
                                'service' => {$objFunctions->getVisaServiceType()},
                                'baseCompany' => 'all',
                                'company' => 'all',
                                'counterId' => $counterId,
                                'price' => $item.mainCost]}
                                {assign var="pointClub" value=$objFunctions->CalculatePoint($paramPointClub)}
                                {if $pointClub gt 0}
                                    <div class="site-main-text-color text_div_morei ">
                                        ##Yourpurchasepoints## : {$pointClub}
                                        ##Point##
                                    </div>
                                {/if}
                            {/if}
                                    <div class="my-more-info">
                              ##Moredetail##
                                    <i class="fa fa-angle-down"></i>
                                        </div>


                        {if $item.redirectUrlCheck == '0'}

                        {/if}

                        </span>
                            <span class="slideUpAirDescription displayiN">


                                <i class="fa fa-angle-up site-main-text-color"></i>
                    </span>
                        </div>


                    </div>
                {/foreach}

                <form method="post" name="visaResultForm" id="visaResultForm">
                    <input type="hidden" name="adultQty" id="adultQty" value="{$smarty.const.SEARCH_ADULT}" />
                    <input type="hidden" name="childQty" id="childQty" value="{$smarty.const.SEARCH_CHILD}" />
                    <input type="hidden" name="infantQty" id="infantQty" value="{$smarty.const.SEARCH_INFANT}" />
                    <input type="hidden" name="visa_type" id="visa_type" value="{$smarty.const.VISA_TYPE}" />
                    <input type="hidden" name="distination_code" id="distination_code"
                           value="{$smarty.const.DESTINATION_CODE}" />
                    <input type="hidden" name="visaID" id="visaID" value="" />
                    <input type="hidden" name="CurrencyCode" class="CurrencyCode"
                           value='{$objSession->getCurrency()}' />
                </form>

            </div>
        {/if}



        {assign var="moduleData" value=[
        'service'=>'Visa',
        'origin'=>$smarty.const.DESTINATION_CODE,
        'type'=>$smarty.const.VISA_TYPE
        ]}

        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`textSearchResults.tpl"
        moduleData=$moduleData}
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`faqs.tpl"
        moduleData=$moduleData}
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`articles.tpl"
        moduleData=$moduleData}


    </div>
</div>

<!-- login and register popup -->
{assign var="useType" value="visa2"}
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentLoginRegister.tpl"}
<!-- login and register popup -->


{literal}
    <script src="assets/js/script.js"></script>
    <script>
       $(document).ready(function() {
          $(".currency-gds").click(function() {
             $(".change-currency").toggle()
             if ($(".currency-inner .currency-arrow").hasClass("currency-rotate")) {
                $(".currency-inner .currency-arrow").removeClass("currency-rotate")
             } else {
                $(".currency-inner .currency-arrow").addClass("currency-rotate")
             }
          })

          $("body").delegate(".international-available-detail-btn", "click", function() {
             $(this).addClass("displayiN")
             $(this).parents(".international-available-details").find(".international-available-panel-min").addClass("international-available-panel-max")
             $(this).parents(".international-available-detail-btn").addClass("displayiN")
             $(this).parents(".international-available-details").find(".slideUpAirDescription").removeClass("displayiN")
          })

          $("body").delegate(".slideUpAirDescription", "click", function() {
             $(this).addClass("displayiN")
             $(this).parents(".international-available-details").find(".international-available-panel-min").removeClass("international-available-panel-max")
             $(this).parents(".international-available-details").find(".international-available-detail-btn").removeClass("displayiN")
          })


          $(".silence_span").removeClass("ph-item2").html($(".card_visa").length + " " + useXmltag("NumberVisaFound"))
          $(".slideDownHotelDescription").click(function() {
             $(this).parents(".row-visa").find(".dital-row-visa").toggleClass("displayiN")
             $(this).parents(".row-visa").find(".dital-row-visa").find("p").css({"font-family": "inherit"})
             $(this).parents(".row-visa").find(".dital-row-visa").find("p *").css({"font-family": "inherit"})
             $(this).toggleClass("displayiN")
             $(".slideUpHotelDescription").toggleClass("displayiN")

          })

          $(".slideUpHotelDescription").click(function() {
             $(this).parents(".row-visa").find(".dital-row-visa").toggleClass("displayiN")
             $(this).toggleClass("displayiN")
             $(".slideDownHotelDescription").toggleClass("displayiN")

          })
       })
    </script>
    <script type="text/javascript">
       $(document).ready(function() {
          $("body").delegate(".slideDownHotelDescription", "click", function() {

             $(this).siblings().find(".international-available-panel-min").addClass("international-available-panel-max")
             $(".international-available-item-right-Cell").addClass("my-slideup")
             $(".international-available-item-left-Cell").addClass("my-slideup")

          })

          $("body").delegate(".slideUpHotelDescription", "click", function() {

             $(this).siblings().find(".international-available-panel-min").removeClass("international-available-panel-max")

          })
          $("body").delegate(".my-slideup", "click", function() {

             $(this).siblings().find(".international-available-panel-min").removeClass("international-available-panel-max")

          })
       })
    </script>
    <script>
       $(document).ready(function() {
          $("body").delegate("ul.tabs li", "click", function() {

             $(this).siblings().removeClass("current")
             $(this).parent("ul.tabs").siblings(".tab-content").removeClass("current")

             var tab_id = $(this).attr("data-tab")

             $(this).addClass("current")
             $(this).parent("ul.tabs").siblings("#" + tab_id).addClass("current")

          })
       })
    </script>
{/literal}

<script>
    {*loadArticles('Visa','{$smarty.const.DESTINATION_CODE}:{$smarty.const.VISA_TYPE}');*}
</script>