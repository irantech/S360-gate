
{load_presentation_object filename="functions" assign="objFunctions"}
{assign var="cityOrigin" value=$smarty.const.SEARCH_ORIGIN_CITY}
{assign var="cityDestination" value=$smarty.const.SEARCH_DESTINATION_CITY}
{assign var="dateMove" value=$smarty.const.SEARCH_DATE_MOVE}


{load_presentation_object filename="resultBusTicket" assign="objBus"}
{load_presentation_object filename="resultBus" assign="objBusDetail"}
{assign var="originCity" value=$objFunctions->getRoute($cityOrigin)}
{assign var="destinationCity" value=$objFunctions->getRoute($cityDestination)}

{load_presentation_object filename="dateTimeSetting" assign="objDateTimeSetting"}
{if $smarty.const.SOFTWARE_LANG eq 'fa'}
    {assign var="correctDate" value=$objDateTimeSetting->jdate("l, d F o", '', '', '', 'en') }
{else}
    {assign var="correctDate" value=date("Y-m-d") }
{/if}


{load_presentation_object filename="currencyEquivalent" assign="objCurrency"}
<!-- FILTERS -->
<div class="row row-width" id="bus_result">
    <div class="col-lg-3 col-md-12 col-sm-12 col-12 col-padding-5 ">
        <div class="parent_sidebar">
            <!-- Change Currency Box -->
            {if $smarty.const.ISCURRENCY eq '1'}
                <div class="currency-gds ">
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

            <div class="filterBox">

                <!-- Result search -->
                <div class="filtertip site-bg-main-color site-bg-color-border-bottom">
                    <div class="tip-content">
                        <p class="">
                            <span class=" bold counthotel" id="originCityName"></span>
                            ##On##
                            <span class=" bold counthotel" id="destinationsCityName"></span>
                        </p>
                        <p class="counthotel txt12"><a id="dateMove" class="site-bg-main-color"></a></p>
                        <span class="silence_span"><b id="countBuses"></b> ##NumberFlightFound## </span>
                        <div class="open-sidebar-parvaz" onclick="showSearchBoxTicket()">
                            ##ChangeSearchType##
                        </div>
                    </div>
                </div>

                <!-- search box -->
                <div class=" s-u-update-popup-change">

                    <form class="search-wrapper" name="gds_bus" action="" method="post">
                        <div class="d-flex flex-wrap align-items-center position-relative">
                            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change">
                                <div class="s-u-in-out-wrapper raft raft-change change-bor">
                                    <select class="select2BusRouteSearch option1" name="cityOrigin" id="cityOrigin" style="width:100%;"
                                            tabindex="2">
                                        <option value="{$cityOrigin}" selected>{$originCity['name_fa']}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="swap-flight-box" onclick="swapBusCitiesNew()">
                                <span class="swap-flight"><i class="zmdi zmdi-swap site-main-text-color"></i></span>
                            </div>
                            <div class="s-u-form-block s-u-num-inp s-u-num-inp-change bargasht bargasht-change change-bor">
                                <div class="s-u-in-out-wrapper">
                                    <select class="select2BusRouteSearch option1" name="cityDestination" id="cityDestination" style="width:100%;"
                                            tabindex="2">
                                        <option value="{$cityDestination}" selected>{$destinationCity['name_fa']}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        {assign var="classNameStartDate" value="shamsiDeptCalendar"}
                        {if $smarty.const.SOFTWARE_LANG eq 'en' || $smarty.const.SOFTWARE_LANG eq 'ar' || $dateMove|substr:0:4 gt 2000}
                            {$classNameStartDate="gregorianDeptCalendar"}
                        {/if}


                        <div class="s-u-form-block s-u-num-inp s-u-num-inp-change width100">
                            <div class="s-u-form-date-wrapper">
                                <div class="s-u-date-pick">
                                    <div class="s-u-jalali s-u-jalali-change">
                                        <i class="zmdi zmdi-calendar-note site-main-text-color"></i>
                                        <input style="text-align: left" type="text"
                                               class="{$classNameStartDate}"
                                               placeholder="##Wentdate##" id="dateMoveBus"
                                               name="dateMoveBus" value="{$dateMove}">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="s-u-search-wrapper s-u-num-inp s-u-num-inp-search-change">
                            <a href="" onclick="return false" class="f-loader-check f-loader-check-bar" id="loader_check_submit"
                               style="display:none"></a>
                            <button type="button" onclick="loadingToggle($(this));submitSearchBus()" id="sendFlight"
                                    class="site-bg-main-color">##Search##
                            </button>
                        </div>

                    </form>
                    <div class="message_error_portal"></div>
                </div>


            </div>

            <div class="filterBox" id="s-u-filter-wrapper-ul">
                <span class="s-u-close-filter"></span>
                <div id="priceBoxBus" class="filtertip-searchbox ">
                    <span class="filter-title"><i class="zmdi zmdi-money "></i> ##Price## (##Rial##)</span>
                    <div class="filter-content padb0">
                        <div class="filter-price-text">
                            <span id="minPriceBus"> <i></i></span>-
                            <span id="maxPriceBus"> <i></i></span>
                        </div>
                        <div id="slider-range"></div>
                    </div>
                </div>

                <div class="filtertip-searchbox ">
                    <span class="filter-title"><i class="zmdi zmdi-time"></i>##RunTime##</span>
                    <div class="filter-content padb10" id="filterTimeMove"></div>
                </div>





                {*        <div class="filtertip-searchbox ">*}
                {*            <span class="filter-title">##Passengercompany##</span>*}
                {*            <div class="filter-content padb10 padt10 filterCompanyName_bus" id="filterCompanyName"></div>*}
                {*        </div>*}

            </div>

        </div>
    </div>
    <!-- LIST CONTENT-->
    <div class="col-lg-9 col-md-12  col-sm-12 col-12 col-padding-5 ">

        <div class="sort-by-section clearfix box bus_page_sort sorting bus-sort-by-section">
            <div class="info-login">
                <div class="head-info-login">
                    <span class="site-bg-main-color site-bg-color-border-right-b">##Sortby##</span>
                </div>
                <div class="form-sort hotel-sort hotel-sort-hotel">

                    <div class="s-u-form-input-number form-item col-md-6">
                        <div class="select">
                            <select class="select2" id="moveSortSelect" tabindex="-1"
                                    aria-hidden="true" onchange="selectSortBus(this);">
                                <option disabled="" selected="" hidden="">##BaseStartTime##</option>
                                <option value="min_time_move"> ##LTM##</option>
                                <option value="max_time_move"> ##MTL##</option>
                            </select>
                        </div>
                    </div>
                    <div class="s-u-form-input-number form-item  col-md-6 pr-0">
                        <div class="select">
                            <select class="select2" id="priceSortSelect" tabindex="-1"
                                    aria-hidden="true" onchange="selectSortBus(this);">
                                <option disabled="" selected="" hidden="">##Baseprice##</option>
                                <option value="min_price">##LTM##</option>
                                <option value="max_price">##MTL##</option>
                            </select>
                        </div>
                    </div>
                    {*<div class="s-u-form-input-number form-item form-item-sort countTiket">
                        <p>##Result##: <b id="countBuses"></b></p>
                    </div>*}
                    <div class="filter_search_mobile_res">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0" y="0" viewBox="0 0 512 512" xml:space="preserve" class="site-bg-svg-color">
                              <g>
                                  <g xmlns="http://www.w3.org/2000/svg">
                                      <path d="m420.404 0h-328.808c-50.506 0-91.596 41.09-91.596 91.596v328.809c0 50.505 41.09 91.595 91.596 91.595h328.809c50.505 0 91.595-41.09 91.595-91.596v-328.808c0-50.506-41.09-91.596-91.596-91.596zm61.596 420.404c0 33.964-27.632 61.596-61.596 61.596h-328.808c-33.964 0-61.596-27.632-61.596-61.596v-328.808c0-33.964 27.632-61.596 61.596-61.596h328.809c33.963 0 61.595 27.632 61.595 61.596z"  data-original="#000000" style="" class=""></path>
                                      <path d="m432.733 112.467h-228.461c-6.281-18.655-23.926-32.133-44.672-32.133s-38.391 13.478-44.672 32.133h-35.661c-8.284 0-15 6.716-15 15s6.716 15 15 15h35.662c6.281 18.655 23.926 32.133 44.672 32.133s38.391-13.478 44.672-32.133h228.461c8.284 0 15-6.716 15-15s-6.716-15-15.001-15zm-273.133 32.133c-9.447 0-17.133-7.686-17.133-17.133s7.686-17.133 17.133-17.133 17.133 7.686 17.133 17.133-7.686 17.133-17.133 17.133z"  data-original="#000000" style="" class=""></path>
                                      <path d="m432.733 241h-35.662c-6.281-18.655-23.927-32.133-44.672-32.133s-38.39 13.478-44.671 32.133h-228.461c-8.284 0-15 6.716-15 15s6.716 15 15 15h228.461c6.281 18.655 23.927 32.133 44.672 32.133s38.391-13.478 44.672-32.133h35.662c8.284 0 15-6.716 15-15s-6.716-15-15.001-15zm-80.333 32.133c-9.447 0-17.133-7.686-17.133-17.133s7.686-17.133 17.133-17.133 17.133 7.686 17.133 17.133-7.686 17.133-17.133 17.133z" data-original="#000000" style="" class=""></path>
                                      <path d="m432.733 369.533h-164.194c-6.281-18.655-23.926-32.133-44.672-32.133s-38.391 13.478-44.672 32.133h-99.928c-8.284 0-15 6.716-15 15s6.716 15 15 15h99.928c6.281 18.655 23.926 32.133 44.672 32.133s38.391-13.478 44.672-32.133h164.195c8.284 0 15-6.716 15-15s-6.716-15-15.001-15zm-208.866 32.134c-9.447 0-17.133-7.686-17.133-17.133s7.686-17.133 17.133-17.133 17.133 7.685 17.133 17.132-7.686 17.134-17.133 17.134z"  data-original="#000000" style="" class=""></path>
                                  </g>
                              </g>
                           </svg>
                        <span class="site-main-text-color">##Filter## </span>
                    </div>
                </div>
            </div>

        </div>
        {assign var="moduleData" value=[
        'service'=>'Bus',
        'origin'=>$smarty.const.SEARCH_ORIGIN_CITY,
        'destination'=>$smarty.const.SEARCH_DESTINATION_CITY ,
        'date'=>$smarty.const.SEARCH_DATE_MOVE
        ]}

        {$objFunctions->showConfigurationContents('bus_search_advertise','<div class="advertises">','</div>','<div class="advertise-item">','</div>')}


        {assign var="check_request_offline" value=$objFunctions->checkClientConfigurationAccess('busWaitingList')}
        {load_presentation_object filename="fullCapacity" assign="objFullCapacity"}
        {assign var="get_info" value=$objFullCapacity->getFullCapacitySite(1)}
        <div id='show_offline_request' class='d-none'>
            <div class='fullCapacity_div'>
                {if $get_info['pic_url']!=''}
                    <img src='{$get_info['pic_url']}' alt='{$get_info['pic_title']}'>
                {else}
                    <img src='assets/images/fullCapacity.png' alt='fullCapacity'>
                {/if}
                <h2>##Noresult##</h2>
                {if $check_request_offline eq true}
                    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/requestOffline/main.tpl"
                    moduleData=$moduleData}
                {/if}
            </div>
        </div>






        <div id="resultBusSearch">
            {*            <div class="loader-section">
                            <div class="images-loader">
                                <div class="images-circle owl-carousel">
                                    <div class="images-circle-item">
                                        <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/bus-perspolic.png"
                                             style="width: 60px;height: 60px;"/>
                                    </div>
                                </div>
                            </div>
                            <div class="my-progress">
                                <div id="myBar" class="my-progress-bar site-bg-main-color" role="progressbar" aria-valuenow="0"
                                     aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                <span class="site-bg-main-color-before site-bg-main-color-after-for-loader site-bg-main-color"
                                      id="myBarSpan">% 0</span>
                                </div>
                            </div>
                        </div>*}
            <div class="loader-section">
                <div id="loader-page" class="lazy-loader-parent ">
                    <div class="loader-page container site-bg-main-color">
                        <div class="parent-in row">

                            <div class="loader-txt">
                                <div id="bus_loader">
                          <span class="loader-date">
                              {$objBusDetail->DateJalali($dateMove,'TwoWay')}
                              {$objBusDetail->day}، {$objBusDetail->date_now}
                          </span>
                                    <div class="wrapper">

                                        <div class="locstart"></div>
                                        <div class="buspath">
                                            <div class="bus"></div>
                                        </div>
                                        <div class="locend"></div>
                                    </div>
                                </div>

                                <div class="loader-distinc">
                                    در حال جستجوی بهترین
                                    سفر
                                    از
                                    <span>
                             {$originCity['name_fa']}
                            </span>
                                    به
                                    <span>
                             {$destinationCity['name_fa']}
                            </span>
                                    برای شما هستیم
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>



        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`textSearchResults.tpl"
        moduleData=$moduleData}
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`faqs.tpl"
        moduleData=$moduleData}
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`articles.tpl"
        moduleData=$moduleData}






        <script type="text/javascript">
           getResultBusSearch('{$cityOrigin}', '{$cityDestination}', '{$dateMove}','{$smarty.const.SOFTWARE_LANG}');
        </script>

    </div>

</div>
<div id="ModalPublicContent"></div>

<!-- login and register popup -->
{assign var="useType" value="bus"}
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentLoginRegister.tpl"}
<!-- login and register popup -->

<form action="" method="post" id="formReserveBusTicket">
    <input id="originCity" name="originCity" type="hidden" value='{$cityOrigin}'/>
    <input id="destinationCity" name="destinationCity" type="hidden" value='{$cityDestination}'/>
    <input id="dateMove" name="dateMove" type="hidden" value='{$dateMove}'/>
    <input id="currencyCode" name="currencyCode" type="hidden" value='{$smarty.const.CURRENCY_CODEE}'/>
    <input id="busCode" name="busCode" type="hidden" value=""/>
    <input id="sourceCode" name="sourceCode" type="hidden" value=""/>
    <input id="requestNumber" name="requestNumber" type="hidden" value=""/>
    <input id="factorNumber" name="factorNumber" type="hidden" value=""/>
</form>

{literal}
    <script src="assets/js/scrollWithPage.min.js"></script>
    <script src="assets/js/script.js"></script>

    <script>

       $(document).ready(function () {


          // if($(window).width() > 990){
          //     $(".parent_sidebar").scrollWithPage("#bus_result");
          // }
          let elem = document.getElementById("myBar");
          let elementInternal = document.getElementById("myBarSpan");
          let width = 0;

          $('body').on('click', '.filter-title', function () {
             $(this).parent().find('.filter-content').slideToggle();
             $(this).parent().toggleClass('hidden_filter');
          })


          $('body').delegate(".slideDownHotelDescription","click", function () {
             $(this).siblings().find(".international-available-panel-min").addClass("international-available-panel-max");
             $(".international-available-item-right-Cell").addClass("my-slideup");
             $(".international-available-item-left-Cell").addClass("my-slideup");
             $(this).parents('.ticketSubDetail').find(".slideDownHotelDescription").addClass("displayiN");
             $(this).parents('.ticketSubDetail').find(".slideUpHotelDescription").removeClass("displayiN");



          });
          $('body').delegate(".slideUpHotelDescription","click", function () {
             $(this).siblings().find(".international-available-panel-min").removeClass("international-available-panel-max");
             $(this).parents('.ticketSubDetail').find(".slideDownHotelDescription").removeClass("displayiN");
             $(this).parents('.ticketSubDetail').find(".slideUpHotelDescription").addClass("displayiN");
          });
          $('body').delegate(".my-slideup","click", function () {
             $(this).siblings().find(".international-available-panel-min").removeClass("international-available-panel-max");
             $(this).siblings().find(".slideDownHotelDescription").removeClass("displayiN");
             $(this).siblings().find(".slideUpHotelDescription").addClass("displayiN");

          });
          $('body').delegate('ul.tabs li',"click", function () {
             $(this).siblings().removeClass("current");
             $(this).parent("ul.tabs").siblings(".tab-content").removeClass("current");
             let tab_id = $(this).attr('data-tab');
             $(this).addClass('current');
             $(this).parent("ul.tabs").siblings("#" + tab_id).addClass("current");
          });

          //change currency
          $(".currency-gds").click(function() {
             $('.change-currency').toggle();
             if ($(".currency-inner .currency-arrow").hasClass("currency-rotate")) {
                $( ".currency-inner .currency-arrow" ).removeClass('currency-rotate');
             } else {
                $( ".currency-inner .currency-arrow" ).addClass('currency-rotate')
             }
          });



       });
       //change search
       function showSearchBoxTicket() {
          $(".open-sidebar-parvaz").toggleClass('clos-sidebar-parvaz');

          $(".s-u-update-popup-change").toggleClass('open-search-box');
       }



       function swapBusCitiesNew() {
          let $origin = $('#cityOrigin');
          let $dest   = $('#cityDestination');

          let oVal  = $origin.val();
          let dVal  = $dest.val();

          let oText = $origin.find('option:selected').text() || $origin.find('option').first().text() || '';
          let dText = $dest.find('option:selected').text()   || $dest.find('option').first().text()   || '';


          if (!oVal && !dVal && !oText && !dText) return;

          function setSelect($sel, value, text) {
             let $opt = $sel.find('option').filter(function(){ return $(this).val() == value; });
             if ($opt.length) {
                $sel.val(value).trigger('change');
             } else {

                $sel.empty().append(new Option(text || value || '', value || '', true, true)).trigger('change');
             }
          }


          setSelect($origin, dVal, dText);
          setSelect($dest,   oVal, oText);
       }





    </script>
{/literal}

