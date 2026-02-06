{load_presentation_object filename="resultReservationVisa" assign="objResultVisa"}
{load_presentation_object filename="currencyEquivalent" assign="objCurrency"}
{load_presentation_object filename="currency" assign="objCurrencyVisa"}
{load_presentation_object filename="country" assign="objCountry"}
{load_presentation_object filename="visaType" assign="objVisaType"}
{load_presentation_object filename="visa" assign="objVisa"}

{assign var="searchResult" value=$objResultVisa->visaSearch($smarty.const.DESTINATION_CODE, $smarty.const.VISA_TYPE)}
{assign var="continents" value=$objCountry->continentsList()}
{assign var="searchContinent" value=$objCountry->getCountryByCode($smarty.const.DESTINATION_CODE)}
{assign var="searchCountries" value=$objResultVisa->countriesHaveVisa($searchContinent.continentID)}
{assign var="visaTypeList" value=$objVisaType->visaTypeList()}

<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 nopad">

    <!-- Change Currency Box -->
    {if $smarty.const.ISCURRENCY eq '1'}
        <div class="currency-gds">

            {assign var="CurrencyInfo"  value=$objCurrency->InfoCurrency($objSession->getCurrency())}

            {if $CurrencyInfo neq null}
                <div class="currency-inner DivDefaultCurrency">
                    <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/flagCurrency/{$CurrencyInfo['CurrencyFlag']}"
                         alt="" id="IconDefaultCurrency">
                    <span class="TitleDefaultCurrency">{$CurrencyInfo['CurrencyTitleFa']}</span>
                    <span class="currency-arrow"></span>
                </div>
            {else}
                <div class="currency-inner DivDefaultCurrency">
                    <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/flagCurrency/Iran.png" alt=""
                         id="IconDefaultCurrency">
                    <span class="TitleDefaultCurrency">##IranianRial##</span>
                    <span class="currency-arrow"></span>
                </div>
            {/if}

            <div class="change-currency">
                <div class="change-currency-inner">
                    <div class="change-currency-item main" onclick="ConvertCurrency('0','Iran.png','ریال ایران')">
                        <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/flagCurrency/Iran.png" alt="">
                        <span>##Iran##</span>
                    </div>
                    {foreach $objCurrency->ListCurrencyEquivalent()  as  $Currency}
                        <div class="change-currency-item"
                             onclick="ConvertCurrency('{$Currency.CurrencyCode}','{$Currency.CurrencyFlag}','{$Currency.CurrencyTitle}')">
                            <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/flagCurrency/{$Currency.CurrencyFlag}"
                                 alt="">
                            <span>{$Currency.CurrencyTitle}</span>
                        </div>
                    {/foreach}
                </div>
            </div>
        </div>
    {/if}

    <!-- Search Box -->
    <div class="filterBox">
        <div class="filtertip_hotel site-bg-main-color site-bg-color-border-bottom">
            <p class="txt14">##Searchnamevisa## </p>
            <span class="silence_span ph-item2"></span>
            <p class="txt14">
                <a class="iranM"></a>
                <b dir="ltr"></b>
            </p>
        </div>
        <div class="filtertip-searchbox noTopRadius">
            <form class="search-wrapper" action="" method="post">

                <div class="form-hotel-item form-hotel-item-searchBox marb10">
                    <div class="select">
                        <select name="visa_continent" id="visa_continent" class="select2"
                                onchange="initCountriesOfContinent()">
                            <option value="">##Continent##</option>
                            {foreach $continents as $each}
                                <option value="{$each.id}"
                                        {if $searchContinent.continentID eq $each.id}selected="selected"{/if}>{$each.titleFa}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>

                <div class="form-hotel-item form-hotel-item-searchBox marb10">
                    <div class="select">
                        <select name="visa_destination" id="visa_destination" class="select2">
                            <option value="">##Destination##</option>
                            {foreach $searchCountries as $each}
                                <option value="{$each.abbreviation}"
                                        {if $smarty.const.DESTINATION_CODE eq $each.abbreviation}selected="selected"{/if}>{$each.name}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>

                <div class="form-hotel-item form-hotel-item-searchBox">
                    <div class="select">
                        <select name="visa_type" id="visa_type" class="select2">
                            <option value="all" {if $smarty.const.VISA_TYPE eq 'all'}selected="selected"{/if}>##All##
                            </option>
                            <option value=""> ##Typevisa##</option>
                            {foreach $visaTypeList as $each}
                                <option value="{$each.id}"
                                        {if $smarty.const.VISA_TYPE eq $each.id}selected="selected"{/if}>{$each.title}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>

                <div class="s-u-form-block s-u-num-inp s-u-num-inp-change width100">
                    <div class="s-u-form-input-wrapper">
                        <p class="s-u-number-input  s-u-number-input-change  inp-adt inp-adt-change">
                            <i class="plus zmdi zmdi-plus-circle site-main-text-color-h" id="add1"></i>
                            <input id="qty1" type="number" value="{$smarty.const.SEARCH_ADULT}" name="adult" min="0"
                                   max="9">
                            <i class="minus zmdi zmdi-minus-circle site-main-text-color-h" id="minus1"></i>
                        </p>
                    </div>
                </div>

                <div class="s-u-form-block s-u-num-inp s-u-num-inp-change width100">
                    <div class="s-u-form-input-wrapper">
                        <p class="s-u-number-input  s-u-number-input-change  inp-child inp-child-change">
                            <i class="plus zmdi zmdi-plus-circle site-main-text-color-h" id="add2"></i>
                            <input id="qty2" type="number" value="{$smarty.const.SEARCH_CHILD}" name="child" min="0"
                                   max="9">
                            <i class="minus zmdi zmdi-minus-circle site-main-text-color-h" id="minus2"></i>
                        </p>
                    </div>
                </div>

                <div class="s-u-form-block s-u-num-inp s-u-num-inp-change width100">
                    <div class="s-u-form-input-wrapper">
                        <p class="s-u-number-input  s-u-number-input-change  inp-baby inp-baby-change">
                            <i class="plus zmdi zmdi-plus-circle site-main-text-color-h" id="add3"></i>
                            <input id="qty3" type="number" value="{$smarty.const.SEARCH_INFANT}" name="infant" min="0"
                                   max="9">
                            <i class="minus zmdi zmdi-minus-circle site-main-text-color-h" id="minus3"></i>
                        </p>
                    </div>
                </div>

                <div class="form-hotel-item  form-hotel-item-searchBox-btn">
                    <span></span>
                    <div class="input">
                        <button class="site-main-button-color site-secondary-text-color" type="button"
                                onclick="submitSearchVisa('flatResultVisa')">##Search##
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="articles-list d-none">

        <h6>##RelatedArticles##</h6>
        <ul></ul>

    </div>
</div>

<div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 changePad-md">

    {if $objResultVisa->reservationVisaAuth() eq 'False'}
        <div class="userProfileInfo-messge">
            <div class="messge-login BoxErrorSearch">
                <div style="float: right;"><i class="fa fa-exclamation-triangle IconBoxErrorSearch"></i></div>
                <div class="TextBoxErrorSearch">##Gosupport##</div>
            </div>
        </div>
    {elseif $objResultVisa->error eq true}
        <div class="userProfileInfo-messge">
            <div class="messge-login BoxErrorSearch">
                <div style="float: right;"><i class="fa fa-exclamation-triangle IconBoxErrorSearch"></i></div>
                <div class="TextBoxErrorSearch">{$objResultVisa->errorMessage}</div>
            </div>
        </div>
    {else}
        <div class="main-visa">
            {assign var="i" value=0}

            {foreach $searchResult as $key => $item}
                {assign var="visaTypeMoreDetail" value=$objVisa->getVisaTypeMoreDetail(['country_id'=>$searchContinent.countryID,'type_id'=>$item.visaTypeID])}

                <div class="row-visa d-flex flex-wrap p-0 mb-3 international-available-details">
                    <div class="p-3 international-available-item-right-Cell ">
                        <div class="col-md-12 col-sm-4 col-xs-12 bg-1 pb-3 mb-3 border-bottom">{$item.title} ( {$item.visaTypeTitle} )</div>
                        <div class="col-md-3 col-sm-3"><span
                                    class="p-2 align-items-center border align-center align-content-center justify-content-center d-flex rounded border-warning col-xs-12 text-right visa-text align-center align-content-center justify-content-center d-flex"> ##GetVisa##: {$item.deadline} </span></div>
                        <div class="col-md-3 col-sm-3"><span
                                    class="p-2 align-items-center border align-center align-content-center justify-content-center d-flex rounded border-warning col-xs-12 text-right visa-text align-center align-content-center justify-content-center d-flex"> ##VisaValidity##: {$item.validityDuration} </span></div>
                        <div class="col-md-3 col-sm-3"><span
                                    class="p-2 align-items-center border align-center align-content-center justify-content-center d-flex rounded border-warning col-xs-12 text-right visa-text align-center align-content-center justify-content-center d-flex">  ##Countenter##: {$item.allowedUseNo} </span></div>
                        <div class="col-md-3 col-sm-3"><span
                                    class="p-2 align-items-center border align-center align-content-center justify-content-center d-flex rounded border-warning col-xs-12 text-right visa-text align-center align-content-center justify-content-center d-flex">  ##Typevisa##: {$item.visaTypeTitle}</span></div>


                    </div>
                    <div class="col-md-12  col-sm-12 col-xs-12 dital-row-visa displayiN">
                        <div class="container">
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
                            </div>
                        </div>
                    </div>

                    <div class="col international-available-item-left-Cell pt-3 my-slideup pr-3">
                        {if $item.redirectUrlCheck == '1'}
                            <div class="p-0 inner-avlbl-itm flex-wrap align-items-centeralign-center align-content-center justify-content-center d-flex col-xs-12 text-right visa-text align-center align-content-center justify-content-center d-flex">
                                <div class="col-md-12">
                                    {if $item.mainCost neq $item.priceWithDiscount}
                                        <p class="visa-text">
                                            {assign var="mainCurrency" value=$objFunctions->CurrencyCalculate($item.mainCost)}
                                            <span class="old-price text-decoration-line CurrencyCal CurrencyText"
                                                  data-amount="{$item.mainCost}">{$objFunctions->numberFormat($mainCurrency.AmountCurrency)}</span>
                                        </p>
                                    {/if}
                                    {assign var="discountCurrency" value=$objFunctions->CurrencyCalculate($item.priceWithDiscount)}
                                    <span class="text-success h4"
                                          data-amount="{$item.priceWithDiscount}">{$objFunctions->numberFormat($discountCurrency.AmountCurrency)}</span>
                                    <span class=" d-inline-block font13 align-items-center align-center align-content-center justify-content-center">
                                        {if $item.OnlinePayment eq 'yes'}
                                            {$discountCurrency.TypeCurrency}
                                        {else}
                                            {assign var="VisacurrencyType" value=$objCurrencyVisa->ShowInfo($item.currencyType)}
                                            {$VisacurrencyType.CurrencyTitle}
                                        {/if}

                                    </span>

                                </div>
                                <div class="col-md-12 p-0">
                                    <p class="marb5 visa-text priceSortAdt_visa">
                                        <i> ##PrePrice##: </i>
                                        {assign var="prePaymentCurrency" value=$objFunctions->CurrencyCalculate($item.prePaymentCost)}
                                        <span class=" iranM site-main-text-color-drck CurrencyCal"
                                              data-amount="{$item.prePaymentCost}">{$objFunctions->numberFormat($prePaymentCurrency.AmountCurrency)}</span>
                                        <i class="CurrencyText">
                                            {if $item.OnlinePayment eq 'yes'}
                                                {$prePaymentCurrency.TypeCurrency}
                                            {else}
                                                {assign var="VisacurrencyType" value=$objCurrencyVisa->ShowInfo($item.currencyType)}
                                                {$VisacurrencyType.CurrencyTitle}
                                            {/if}
                                        </i>
                                    </p>
                                </div>


                                <div class="SelectTicket">
                                    <a href="{$visaTypeMoreDetail.url}?targetId={$item.id}" class="international-available-btn site-bg-main-color site-main-button-color-hover">
                                        ##MoreDetails##
                                    </a>
                                </div>
                            </div>
                            {else}
                            <div class="p-0 inner-avlbl-itm flex-wrap align-items-centeralign-center align-content-center justify-content-center d-flex col-xs-12 text-right visa-text align-center align-content-center justify-content-center d-flex">
                                <div class="col-md-12">
                                    {if $item.mainCost neq $item.priceWithDiscount}
                                        <p class="visa-text">
                                            {assign var="mainCurrency" value=$objFunctions->CurrencyCalculate($item.mainCost)}
                                            <span class="old-price text-decoration-line CurrencyCal CurrencyText"
                                                  data-amount="{$item.mainCost}">{$objFunctions->numberFormat($mainCurrency.AmountCurrency)}</span>
                                        </p>
                                    {/if}
                                    {assign var="discountCurrency" value=$objFunctions->CurrencyCalculate($item.priceWithDiscount)}
                                    <span class="text-success h4"
                                          data-amount="{$item.priceWithDiscount}">{$objFunctions->numberFormat($discountCurrency.AmountCurrency)}</span>
                                    <span class=" d-inline-block font13 align-items-center align-center align-content-center justify-content-center">
                                        {if $item.OnlinePayment eq 'yes'}
                                            {$discountCurrency.TypeCurrency}
                                        {else}
                                            {assign var="VisacurrencyType" value=$objCurrencyVisa->ShowInfo($item.currencyType)}
                                            {$VisacurrencyType.CurrencyTitle}
                                        {/if}

                                    </span>

                                </div>
                                <div class="col-md-12 p-0">
                                    <p class="marb5 visa-text priceSortAdt_visa">
                                        <i> ##PrePrice##: </i>
                                        {assign var="prePaymentCurrency" value=$objFunctions->CurrencyCalculate($item.prePaymentCost)}
                                        <span class=" iranM site-main-text-color-drck CurrencyCal"
                                              data-amount="{$item.prePaymentCost}">{$objFunctions->numberFormat($prePaymentCurrency.AmountCurrency)}</span>
                                        <i class="CurrencyText">
                                            {if $item.OnlinePayment eq 'yes'}
                                                {$prePaymentCurrency.TypeCurrency}
                                            {else}
                                                {assign var="VisacurrencyType" value=$objCurrencyVisa->ShowInfo($item.currencyType)}
                                                {$VisacurrencyType.CurrencyTitle}
                                            {/if}
                                        </i>
                                    </p>
                                </div>


                                <div class="SelectTicket">
                                    <a class="international-available-btn site-bg-main-color site-main-button-color-hover"
                                       onclick="chooseVisa({$item.id}); return false;">{if $item.OnlinePayment == 'yes'}##Reservation##{else}##SendRequest##{/if}</a>
                                </div>
                            </div>
                        {/if}
                    </div>


                    <span class="p-2 align-items-center border-top align-center align-content-center justify-content-center d-flex col-xs-12 text-right visa-text align-center align-content-center justify-content-center">
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
                                    <div class="col-md-3 site-main-text-color iranM txt12">##Yourpurchasepoints## : {$pointClub}
                                        ##Point##</div>
                                {/if}
                            {/if}

                        {if $item.redirectUrlCheck == '0'}
                            <a class="site-main-text-color text-left col-md-3 mr-auto iranM txt12">
                                <div>##Moredetail##<i class="fa fa-angle-down"></i>
                                </div>
                            </a>
                        {/if}

                        </span>

                    <span class="international-available-detail-btn  slideUpAirDescription displayiN">

                        <i class="fa fa-angle-up site-main-text-color"></i>
                    </span>
                </div>
            {/foreach}

            <form method="post" action="" name="visaForm" id="visaForm">
                <input type="hidden" name="adultQty" id="adultQty" value="{$smarty.const.SEARCH_ADULT}"/>
                <input type="hidden" name="childQty" id="childQty" value="{$smarty.const.SEARCH_CHILD}"/>
                <input type="hidden" name="infantQty" id="infantQty" value="{$smarty.const.SEARCH_INFANT}"/>
                <input type="hidden" name="visaID" id="visaID" value=""/>
                <input type="hidden" name="CurrencyCode" class="CurrencyCode" value='{$objSession->getCurrency()}'/>
            </form>

        </div>
    {/if}

    <div class="sticky-article d-none"></div>
</div>


<!-- login and register popup -->
{assign var="useType" value="visa"}
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentLoginRegister.tpl"}
<!-- login and register popup -->


{literal}
    <script src="assets/js/script.js"></script>
    <script>
        $(document).ready(function () {

            $('body').delegate(".slideDownAirDescription", "click", function () {
                $(this).parents('.international-available-details').find(".international-available-panel-min").addClass("international-available-panel-max");

                $(this).parents('.international-available-detail-btn').addClass("displayiN")
                $(this).parents('.international-available-details').find('.slideUpAirDescription').removeClass("displayiN");

                $(this).parents('.international-available-details').find('.dital-row-visa').removeClass('displayiN');



            });
            $('body').delegate(".slideUpAirDescription", "click", function () {

                $(this).parents('.international-available-details').find(".international-available-panel-min").removeClass("international-available-panel-max");
                $(this).parents('.international-available-details').find('.international-available-detail-btn').removeClass("displayiN");
                $(this).addClass("displayiN");

                $(this).parents('.international-available-details').find('.dital-row-visa').addClass('displayiN');

            });




            $('.silence_span').removeClass('ph-item2').html($('.row-visa').length + ' ' + useXmltag("NumberVisaFound"));
            $('.slideDownHotelDescription').click(function () {
                $(this).parents('.row-visa').find('.dital-row-visa').toggleClass('displayiN');
                $(this).parents('.row-visa').find('.dital-row-visa').find('p').css({'font-family': 'inherit'});
                $(this).parents('.row-visa').find('.dital-row-visa').find('p *').css({'font-family': 'inherit'});
                $(this).toggleClass('displayiN');
                $('.slideUpHotelDescription').toggleClass('displayiN');

            });

            $('.slideUpHotelDescription').click(function () {
                $(this).parents('.row-visa').find('.dital-row-visa').toggleClass('displayiN');
                $(this).toggleClass('displayiN');
                $('.slideDownHotelDescription').toggleClass('displayiN');

            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('body').delegate(".slideDownHotelDescription", "click", function () {

                $(this).siblings().find(".international-available-panel-min").addClass("international-available-panel-max");
                $(".international-available-item-right-Cell").addClass("my-slideup");
                $(".international-available-item-left-Cell").addClass("my-slideup");

            });

            $('body').delegate(".slideUpHotelDescription", "click", function () {

                $(this).siblings().find(".international-available-panel-min").removeClass("international-available-panel-max");

            });
            $('body').delegate(".my-slideup", "click", function () {

                $(this).siblings().find(".international-available-panel-min").removeClass("international-available-panel-max");

            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('body').delegate('ul.tabs li', "click", function () {

                $(this).siblings().removeClass("current");
                $(this).parent("ul.tabs").siblings(".tab-content").removeClass("current");

                var tab_id = $(this).attr('data-tab');

                $(this).addClass('current');
                $(this).parent("ul.tabs").siblings("#" + tab_id).addClass("current");

            });

            //change currency
            $(".currency-gds").click(function () {
                $('.change-currency').toggle();
                if ($(".currency-inner .currency-arrow").hasClass("currency-rotate")) {
                    $(".currency-inner .currency-arrow").removeClass('currency-rotate');
                } else {
                    $(".currency-inner .currency-arrow").addClass('currency-rotate')
                }
            });
        });
    </script>
{/literal}

<script>
    loadArticles('Visa','{$smarty.const.DESTINATION_CODE}');
</script>
