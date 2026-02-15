{load_presentation_object filename="resultGasht" assign="objGasht"}
{load_presentation_object filename="currencyEquivalent" assign="objCurrency"}
{assign var="allCountry" value=$objGasht->getCitiesFromDB()}
{assign var="list" value=$objGasht->getGashtResult()}




<!-- login and register popup -->
{assign var="useType" value="gasht"}
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentLoginRegister.tpl"}
<!-- login and register popup -->


<div class="col-lg-3 col-md-12 col-sm-12 col-12 col-padding-5 ">
    <div class="parent_sidebar">
    <!-- Change Currency Box -->
    {if $smarty.const.ISCURRENCY eq '1'}
        <div class="currency-gds">

            {assign var="CurrencyInfo"  value=$objCurrency->InfoCurrency($objSession->getCurrency())}

            {if $CurrencyInfo neq null}
                <div class="currency-inner DivDefaultCurrency">
                    <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/flagCurrency/{$CurrencyInfo['CurrencyFlag']}" alt="" id="IconDefaultCurrency">
                    <span class="TitleDefaultCurrency">{$CurrencyInfo['CurrencyTitleFa']}</span>
                    <span class="currency-arrow"></span>
                </div>
            {else}
                <div class="currency-inner DivDefaultCurrency">
                    <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/flagCurrency/Iran.png" alt="" id="IconDefaultCurrency">
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
                        <div class="change-currency-item" onclick="ConvertCurrency('{$Currency.CurrencyCode}','{$Currency.CurrencyFlag}','{$Currency.CurrencyTitle}')">
                            <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/flagCurrency/{$Currency.CurrencyFlag}" alt="">
                            <span>{$Currency.CurrencyTitle}</span>
                        </div>
                    {/foreach}
                </div>
            </div>
        </div>
    {/if}
    <!-- Search Box -->
    <div class="filterBox">
        <div class="filtertip_hotel site-bg-main-color site-bg-color-border-bottom parvaz-sidebar">
            <div class="open-sidebar-parvaz" onclick="showSearchBoxTicket()">
                ##ChangeSearchType##
            </div>

            <p class="txt14">  ##Search##
                  {if $smarty.const.REQUEST_TYPE==0}
                        {assign var="typeSearch" value="gasht"}
                ##Gasht##
                    {else}
                        {assign var="typeSearch" value="transfer"}
            ##transfer##
            {/if}</p>
            <p class="txt14">
                <a class="iranM"></a>
                <b dir="ltr"></b>
            </p>
        </div>
        <div class="filtertip-searchbox s-u-update-popup-change">
            <form class="search-wrapper" action="" method="post" id="GashtForm" name="GashtForm">
                {*<div class="clrB site-main-text-color-drck box-foreign-hotel-room-item">*}
                {*<span class="filter-title">مقصد</span>*}
                {*</div>*}
                <div class="form-hotel-item form-hotel-item-searchBox">
                    <div class="select">
                            <select name="destination_{$typeSearch}" id="destination_{$typeSearch}" class="select2">
                            <option value="">##Destination##</option>
                            {foreach $allCountry as $country}
                                <option value="{$country.city_code}"
                                        {if $country.city_code == $smarty.const.CITY_CODE}selected="selected"{/if}>{$country.city_name}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>

                {*<div class="clrB site-main-text-color-drck box-foreign-hotel-room-item">*}
                {*<span class="filter-title">تاریخ </span>*}
                {*</div>*}

                <div class="form-hotel-item  form-hotel-item-searchBox-date bibbib">

                    <div class="input">
                        <input type="text" class="shamsiDeptCalendarToCalculateNights" placeholder="##Date## "
                                   id="date_{$typeSearch}" name="date_{$typeSearch}" value="{$smarty.const.REQUEST_DATE}">
                        <span class="fa-stack fa-lg calendar-icon site-main-text-color">
                            <i class="fa fa-calendar fa-stack-1x"></i>
                        </span>
                    </div>
                </div>


                {*<div class="clrB site-main-text-color-drck box-foreign-hotel-room-item">*}
                {*<span class="filter-title">نوع گشت</span>*}
                {*</div>*}
                {if $smarty.const.REQUEST_TYPE==0}
                <div class="form-hotel-item form-hotel-item-searchBox">
                    <div class="select">
                        <select name="gasht-type" id="gasht-type" class="select2">
                            {if $smarty.const.GASHT_TYPE neq ''}
                                {if $smarty.const.GASHT_TYPE eq '1'}
                                    {assign var ='type' value="##Solo##"}
                                {elseif $smarty.const.GASHT_TYPE eq '2'}
                                    {assign var ='type' value="##Group##"}
                                {/if}
                                <option value="{$smarty.const.GASHT_TYPE}">{$type}</option>
                                <option value="">----------</option>

                            {/if}
                            {if $smarty.const.GASHT_TYPE eq ''}
                                <option value=""> ##Select##</option>
                            {/if}
                            <option value="1">##Solo##</option>
                            <option value="2">##Group##</option>
                        </select>
                    </div>
                </div>
                {else}
                    <div class="form-hotel-item form-hotel-item-searchBox">
                        <div class="select">
                            <select name="welcome-type" id="welcome-type" class="select2">
                                {if $smarty.const.WELCOME_TYPE neq '0'}
                                    {if $smarty.const.WELCOME_TYPE eq '1'}
                                        {assign var ='w_type' value="##Welcome##"}
                                    {elseif $smarty.const.WELCOME_TYPE eq '2'}
                                        {assign var ='w_type' value="##Glance##"}
                                    {elseif $smarty.const.WELCOME_TYPE eq '3'}
                                        {assign var ='w_type' value="##Welcomeglance##"}
                                    {/if}
                                    <option value="{$smarty.const.WELCOME_TYPE}">{$w_type}</option>
                                    <option value="0">----------</option>

                                {/if}
                                {if $smarty.const.WELCOME_TYPE eq '0'}
                                    <option value="0"> ##Selection##</option>
                                {/if}
                                <option value="1">##Welcome##</option>
                                <option value="2">##Glance##</option>
                                <option value="3"> ##Welcomeglance## </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-hotel-item form-hotel-item-searchBox">
                        <div class="select">
                            <select name="vehicle-type" id="vehicle-type" class="select2">
                                {if $smarty.const.VEHICLE_TYPE neq '0'}
                                    {if $smarty.const.VEHICLE_TYPE eq '1'}
                                        {assign var ='v_type' value="##Riding##"}
                                    {elseif $smarty.const.VEHICLE_TYPE eq '2'}
                                        {assign var ='v_type' value="##Van##"}
                                    {elseif $smarty.const.VEHICLE_TYPE eq '3'}
                                        {assign var ='v_type' value="##Minibus##"}
                                    {elseif $smarty.const.VEHICLE_TYPE eq '4'}
                                        {assign var ='v_type' value="##Bus##"}
                                    {/if}
                                    <option value="{$smarty.const.VEHICLE_TYPE}">{$v_type}</option>
                                    <option value="0">----------</option>

                                {/if}
                                {if $smarty.const.VEHICLE_TYPE eq '0'}
                                    <option value="0">##Selection## </option>
                                {/if}
                                <option value="1">##Riding##</option>
                                <option value="2">##Van##</option>
                                <option value="3">##Minibus##</option>
                                <option value="4">##Bus##</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-hotel-item form-hotel-item-searchBox">
                        <div class="select">
                            <select name="transfer-place" id="transfer-place" class="select2">
                                {if $smarty.const.TRANSFER_PLACE neq '0'}
                                    {if $smarty.const.TRANSFER_PLACE eq '1'}
                                        {assign var ='t_place' value="##Airport##"}
                                    {elseif $smarty.const.TRANSFER_PLACE eq '2'}
                                        {assign var ='t_place' value="##terminal##"}
                                    {elseif $smarty.const.TRANSFER_PLACE eq '3'}
                                        {assign var ='t_place' value="##Rail##"}
                                    {elseif $smarty.const.TRANSFER_PLACE eq '4'}
                                        {assign var ='t_place' value="##Harbor##"}
                                    {/if}
                                    <option value="{$smarty.const.TRANSFER_PLACE}">{$t_place}</option>
                                    <option value="0">----------</option>

                                {/if}
                                {if $smarty.const.TRANSFER_PLACE eq '0'}
                                    <option value="0">##ChoseOption##</option>
                                {/if}
                                <option value="1">##Airport##</option>
                                <option value="2">##terminal##</option>
                                <option value="3">##Rail##</option>
                                <option value="4">##Harbor##</option>
                            </select>
                        </div>
                    </div>
                {/if}


                <div class="form-hotel-item  form-hotel-item-searchBox-btn">
                    <span><input type="hidden" name="request-type" id="request-type" value="{$smarty.const.REQUEST_TYPE}"></span>
                    <div class="input">
                        <button class="site-bg-main-color" type="button"
                                onclick="submitSearchGasht()">##Search##
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

        {assign var="moduleData" value=[
        'service'=>'GashtTransfer',
        'origin'=>$paramSearch.CITY_CODE
        ]}



        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`faqs.tpl"
        moduleData=$moduleData}
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`articles.tpl"
        moduleData=$moduleData}

<!--    <div class="articles-list d-none">

        <h6>##RelatedArticles##</h6>
        <ul></ul>

    </div>-->
    </div>
</div>

<div class="col-lg-9 col-md-12 col-sm-12 col-12 col-padding-5">
    {assign var=i value=1}
{if $list|count>0}
    {foreach  key=keyCity item=itemCity from=$list}

        {if $itemCity.data|count > 0}
        {foreach key=key item=item from=$itemCity.data}
            {if $item.PriceAfterOff > 0}
            {*{$list|@print_r}*}
            {assign var="discountManual" value=$objGasht->getDiscount($smarty.const.REQUEST_TYPE)}

            <div id="a1" class="hotel-result-item main-visa">

            {if $discountManual  neq 0}
                <div class="bs-discount star">
                    <span> %{$discountManual|string_format:"%d"} ##Discount##</span>
                </div>
                {/if}


                <div class="col-md-12 row-visa p-0">
                    <div class="hotel-result-item-content hotel-result-item-content1 p-0">
                        <div class="hotel-result-item-text international-available-item-right-Cell ">
                            <a class="col-md-12 p-0">
                                {if $item.ServiceName  neq ''}
                                    <b class="hotel-result-item-name">{$item.ServiceName} </b>
                                {/if}
                            </a>

                            <div class="col-md-12 p-0" id="description{$i}">

                                <ul class="icons_gasht ">

                                    <li class="icons tooltipWeigh"><a > <i class="mdi mdi-bus site-main-text-color ">

                                               </i>
                                            <span class="tooltiptextWeight site-border-main-color site-bg-color-border-top">##Freeshipping##</span>
                                        </a></li>
                                    <li  class="icons tooltipWeigh"><a > <i class="mdi mdi-human-male site-main-text-color "></i>
                                            <span class="tooltiptextWeight site-border-main-color site-bg-color-border-top">##Circularguide##</span>

                                        </a></li>
                                    <li  class="icons tooltipWeigh"><a > <i class="mdi mdi-clock site-main-text-color "></i>
                                            <span class="tooltiptextWeight site-border-main-color site-bg-color-border-top">##Timelyimplementation##</span>

                                        </a></li>
                                </ul>

                            </div>



                        </div>



                        <div class="hotel-result-item-bottom">

                            <span class="hotel-time-stay">##Price##
                                {if $smarty.const.REQUEST_TYPE==0}
                                ##Gasht##
                                {else}
                             ##transfer##
                                {/if}
                               </span>
                            {$PriceAfterOff=$item.PriceAfterOff-(($item.PriceAfterOff*$discountManual)/100)}
                            {assign var="after_price_change" value=$objFunctions->setGashtPriceChanges($PriceAfterOff*10)}
                            {assign var="price_change" value=$objFunctions->setGashtPriceChanges($item.PriceAfterOff*10)}
                            {assign var="everyMainCurrency" value=$objFunctions->CurrencyCalculate($price_change)}
                            {assign var="afterEveryMainCurrency" value=$objFunctions->CurrencyCalculate($after_price_change)}
                            {if $discountManual eq 0}

                                <span class="iranM site-main-text-color-drck CurrencyCal " data-amount="{$after_price_change}"><b>{$objFunctions->numberFormat($afterEveryMainCurrency.AmountCurrency)}</b> <i class="pirce CurrencyText">{$afterEveryMainCurrency.TypeCurrency}</i> </span>
                            {elseif $discountManual neq 0 }


                                <span class="iranM site-main-text-color-drck CurrencyCal" data-amount="{$price_change}"><b><del
                                                style="color: red;display: inline-block">{$objFunctions->numberFormat($everyMainCurrency.AmountCurrency)} </b> {$everyMainCurrency.TypeCurrency}</del></span>
                                <span class="iranM site-main-text-color-drck CurrencyCal " data-amount="{$after_price_change}"><b>{$objFunctions->numberFormat($afterEveryMainCurrency.AmountCurrency)}</b> {$afterEveryMainCurrency.TypeCurrency}</span>
                            {/if}

                                <input type="hidden" name="ServiceID{$item.ServiceID}" id="ServiceID{$item.ServiceID}"
                                       value="{$item.ServiceID}">
                                <input type="hidden" name="ServiceName{$item.ServiceID}"
                                       id="ServiceName{$item.ServiceID}" value="{$item.ServiceName}">
                                <input type="hidden" name="ServiceComment{$item.ServiceID}"
                                       id="ServiceComment{$item.ServiceID}"
                                       value="{$item.ServiceComment }">
                                <input type="hidden" name="Price{$item.ServiceID}" id="Price{$item.ServiceID}"
                                       value="{$item.Price}">
                                <input type="hidden" name="Discount{$item.ServiceID}" id="Discount{$item.ServiceID}"
                                       value="{$item.Discount}">
                                <input type="hidden" name="PriceAfterOff{$item.ServiceID}"
                                       id="PriceAfterOff{$item.ServiceID}"
                                       value="{$item.PriceAfterOff}">
                                <input type="hidden" name="REQUEST_DATE{$item.ServiceID}"
                                       id="REQUEST_DATE{$item.ServiceID}"
                                       value="{$smarty.const.REQUEST_DATE}">
                                <input type="hidden" name="cityName{$item.ServiceID}" id="cityName{$item.ServiceID}"
                                       value="{$itemCity.city_name}">
                            <input type="hidden" name="requestType{$item.ServiceID}" id="requestType{$item.ServiceID}"
                                                                               value="{$smarty.const.REQUEST_TYPE}">
                            <input type="hidden" name="encryptData{$item.ServiceID}" id="encryptData{$item.ServiceID}"
                                   value="{$itemCity.encrypt_code}">
                            <input type="hidden" name="CurrencyCode{$item.ServiceID}" id="CurrencyCode{$item.ServiceID}"
                                   value="{$objSession->getCurrency()}">




                                <a onclick="viewGasht({$item.ServiceID})" class="bookbtn mt1 site-bg-main-color  site-main-button-color-hover">##ShowReservation##</a>
                                {*<button class="bookbtn mt1 site-bg-main-color site-main-text-color site-main-button-color-hover" type="button" onclick="viewGasht()" >مشاهده و رزرو</button>*}

                        </div>

                    </div>




                    <div class="car-details displayN" id="moreInfo{$item.ServiceID}">
                        <div class="international-available-panel-min international-available-panel-max">

                            <div id="" class="tab-content current">
                                <div class="international-available-airlines-detail-tittle padding-none margin-none">

                                    <div class="international-available-airlines-detail international_a_a_d border-none padding-none margin-none">

                                        {$item.ServiceComment }
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>
                    <span class="result_more_up displayN">
                        <i class="fa fa-angle-up site-main-text-color"></i>
                    </span>
                    <span class="result_more_down">
                        {if $objSession->IsLogin()}
                            {if $smarty.const.REQUEST_TYPE eq 0}
                                {assign var="serviceType" value="LocalGasht"}
                            {else}
                                {assign var="serviceType" value="LocalTransfer"}
                            {/if}
                            {assign var="counterId" value=$objFunctions->getCounterTypeId($smarty.session.userId)}
                            {if $discountManual eq 0}
                                {assign var="price" value=$after_price_change}
                            {elseif $discountManual neq 0 }
                                {assign var="price" value=$price_change}
                            {/if}
                            {assign var="paramPointClub" value=[
                            'service' => $serviceType,
                            'baseCompany' => 'all',
                            'company' => 'all',
                            'counterId' => $counterId,
                            'price' => $price]}
                            {assign var="pointClub" value=$objFunctions->CalculatePoint($paramPointClub)}
                            {if $pointClub gt 0}
                                <div class="text_div_morei site-main-text-color iranM txt12">##Yourpurchasepoints## : {$pointClub} ##Point##</div>
                            {/if}
                        {/if}
                        <div class="my-more-info1" id="detail-show">
                            ##Moredetail##
                            <i class="fa fa-angle-down"></i></div>
                    </span>
                </div>

            </div>
            {/if}
            {assign var=i value=$i+1}

        {/foreach}
        {else}
            {*<div class="userProfileInfo-messge ">
                <div class="messge-login BoxErrorSearch">
                    <div style="float: right;"><i
                                class="fa fa-exclamation-triangle IconBoxErrorSearch"></i>
                    </div>
                    <div class="TextBoxErrorSearch">


                        ##Notransfer##<br/>
                       ##Changeserach##

                    </div>
                </div>
            </div>*}
            {load_presentation_object filename="fullCapacity" assign="objFullCapacity"}
            {assign var="get_info" value=$objFullCapacity->getFullCapacitySite(1)}
            <div id='show_offline_request' >
                <div class='fullCapacity_div'>
                    {if $get_info['pic_url']!=''}
                        <img src='{$get_info['pic_url']}' alt='{$get_info['pic_title']}'>
                    {else}
                        <img src='assets/images/fullCapacity.png' alt='fullCapacity'>
                    {/if}
                    <h2>##Notransfer##</h2>
                    <h2>##Changeserach##</h2>
                </div>
            </div>
        {/if} {/foreach}

{else}
     <div class="userProfileInfo-messge ">
                <div class="messge-login BoxErrorSearch">
                    <div style="float: right;"><i
                                class="fa fa-exclamation-triangle IconBoxErrorSearch"></i>
                    </div>
                    <div class="TextBoxErrorSearch">
        {if $objGasht->errorMessage neq ''}
            {$objGasht->errorMessage} <br/>
            </div>
            </div>
            </div>
	{/if}
{/if}

    <form action="{$smarty.const.ROOT_ADDRESS}/passengersDetailGasht" method="post" id="GashtFormHidden" name="GashtFormHidden">
        <input type="hidden" name="serviceIdBib" id="serviceIdBib" value="">
        {*<input type="hidden" name="serviceAdultBib" id="serviceAdultBib" value="">*}
        {*<input type="hidden" name="serviceChildBib" id="serviceChildBib" value="">*}
        {*<input type="hidden" name="serviceInfantBib" id="serviceInfantBib" value="">*}
    </form>

    <div class="sticky-article d-none"></div>
</div>
{literal}
    <script>
        $(document).ready(function () {

        });
    </script>
    <script>


        // =============number input
        function add(value) {
            var currentVal = parseInt($("#ppp" + value).val());
            if (!isNaN(currentVal)) {
                $("#ppp" + value).val(currentVal + 1);
            }
        }
        ;

        function minus(value) {
            var currentVal = parseInt($("#ppp" + value).val());
            if (!isNaN(currentVal)) {
                if (currentVal > 0) {
                    $("#ppp" + value).val(currentVal - 1);
                }
            }
        }
        ;

        function closeOver(f, value) {
            return function () {
                f(value);
            };
        }

        $(function () {
            var numButtons = 6;
            for (var i = 1; i <= numButtons; i++) {
                $("#addy" + i).click(closeOver(add, i));
                $("#minusy" + i).click(closeOver(minus, i));
            }
        });


    </script>
    <script>

            function showMoreInfoGasht(id) {

                if ($('#arrow' + id).hasClass('fa-angle-down')) {
                   $('#description' + id).removeClass('displayiN');
                    $('#arrow' + id).removeClass('fa-angle-down').addClass('fa-angle-up');
                } else {
                    $('#description' + id).addClass('displayiN');
                    $('#arrow' + id).removeClass('fa-angle-up').addClass('fa-angle-down');
                }

            }

    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('body').delegate(".slideDownHotelDescription","click", function () {
                $(this).siblings('.car-details').removeClass('displayN');
            });
            $('body').delegate(".slideUpHotelDescription","click", function () {
                $(this).siblings('.car-details').addClass('displayN');
            });

            $('body').delegate(".my-slideup","click", function () {
                $(this).siblings().find(".international-available-panel-min").removeClass("international-available-panel-max");

            });
        });
    </script>
    <script>
        $(document).ready(function () {

            $('body').on('click', '.result_more_down', function () {
                $(this).parent().children('.result_more_up').removeClass('displayN');
                $(this).parent().children('.car-details').removeClass('displayN')
                $(this).addClass('displayN');


            })
            $('body').on('click', '.result_more_up', function () {
                $(this).parent().children('.result_more_down').removeClass('displayN');
                $(this).parent().children('.car-details').addClass('displayN');
                $(this).addClass('displayN');


            })
      /*     $('body').on('click', '.slideDownHotelDescription1', function () {
                $(this).parent().find('.slideUpHotelDescription1').removeClass('displayN');
                $(this).addClass('displayN');
                $(this).parent('.car-details').removeClass('displayN');
            })*/
            $('body').delegate('ul.tabs li',"click", function () {

                $(this).siblings().removeClass("current");
                $(this).parent("ul.tabs").siblings(".tab-content").removeClass("current");

                var tab_id = $(this).attr('data-tab');

                $(this).addClass('current');
                $(this).parent("ul.tabs").siblings("#" + tab_id).addClass("current");

            });
            //change currency
            $('body').on('click','.currency-gds',function (){
                $(this).find('.change-currency').toggle();
                if ($(".currency-inner .currency-arrow").hasClass("currency-rotate")) {
                    $( ".currency-inner .currency-arrow" ).removeClass('currency-rotate');
                } else {
                    $( ".currency-inner .currency-arrow" ).addClass('currency-rotate')
                }8855857988877448
            })

           /* //change currency
            $( ".currency-gds" ).click(function() {
                $('.change-currency').toggle();
                if ($(".currency-inner .currency-arrow").hasClass("currency-rotate")) {
                    $( ".currency-inner .currency-arrow" ).removeClass('currency-rotate');
                } else {
                    $( ".currency-inner .currency-arrow" ).addClass('currency-rotate')
                }
            });*/
        });
    </script>
{/literal}

<script>
    {*loadArticles('GashtTransfer','{$smarty.const.CITY_CODE}')*}
</script>