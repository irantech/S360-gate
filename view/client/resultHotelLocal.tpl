{load_presentation_object filename="resultHotelLocal" assign="objResult"}
{load_presentation_object filename="currencyEquivalent" assign="objCurrency"}

{assign var="sortHotel" value=$objResult->sortHotel()}

{assign var="search_end_date" value=$objResult->computingEndDate($smarty.const.SEARCH_START_DATE, $smarty.const.SEARCH_NIGHT)}

{$objResult->getAllCity()}
{$objResult->AllHotelType()}

{assign var="cityName" value=$objResult->getCity($smarty.const.SEARCH_CITY)}
{$objResult->getHotelByCity($smarty.const.SEARCH_CITY, $smarty.const.SEARCH_START_DATE, $search_end_date, $smarty.const.SEARCH_HOTEL_TYPE, $smarty.const.SEARCH_STAR, $smarty.const.SEARCH_PRICE, $smarty.const.SEARCH_HOTEL_NAME)}

<div class="loaderPublicForHotel"></div>
<div class="d-flex flex-wrap">
<!-- FILTERS -->
<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 nopad ">

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
        <div class="filtertip_hotel site-bg-main-color site-bg-color-border-bottom ">
            <p class="txt14 city-name-sidebar-result-hotel">   ##Allhotelincity## <span class="hotel-city-name">{$cityName}</span>  </p>
            <p class="txt14">

                <span class="silence_span">{$objResult->countHotel} ##NumberHotelsFound## </span>
            </p>
        </div>

        <div class="filtertip-searchbox filtertip-searchbox-box1">
            <form class="search-wrapper" action="" method="post">

                <div class="form-hotel-item form-hotel-item-searchBox">
                    <div class="select">
                        <select name="destination_city" id="destination_city" class="select2">
                            {foreach $objResult->all_city as $city}
                            <option value="{$city.id}" {if $city.id eq $smarty.const.SEARCH_CITY}selected="selected"{/if}>{$city.name}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>

                {assign var="classNameStartDate" value="shamsiDeptCalendarToCalculateNights"}
                {assign var="classNameEndDate" value="shamsiReturnCalendarToCalculateNights"}
                {if $smarty.const.SOFTWARE_LANG eq 'en' || $smarty.const.SOFTWARE_LANG eq 'ar' || $smarty.const.SEARCH_START_DATE|substr:0:4 gt 2000}
                    {$classNameStartDate="deptCalendarToCalculateNights"}
                {/if}

                {if $smarty.const.SOFTWARE_LANG eq 'en' || $smarty.const.SOFTWARE_LANG eq 'ar' || $search_end_date|substr:0:4 gt 2000}
                    {$classNameEndDate="returnCalendarToCalculateNights"}
                {/if}

                <div class="form-hotel-item  form-hotel-item-searchBox-date padl5">
                  <span class="fa-stack fa-lg calendar-icon site-main-text-color">
                    <i class="fa fa-calendar fa-stack-1x"></i>
                  </span>
                    <div class="input">
                        <input type="text" class="{$classNameStartDate}"
                               placeholder=" ##Wentdate##" id="startDate" name="startDate"
                               value="{$smarty.const.SEARCH_START_DATE}">
                    </div>
                </div>

                <div class="form-hotel-item  form-hotel-item-searchBox-date padr5">
                  <span class="fa-stack fa-lg calendar-icon site-main-text-color">
                    <i class="fa fa-calendar fa-stack-1x"></i>
                  </span>
                    <div class="input">
                        <input type="text" class="{$classNameEndDate}"
                               placeholder="##Returndate## " id="endDate" name="endDate"
                               value="{$search_end_date}">
                    </div>
                </div>

                <div class="form-hotel-item  form-hotel-item-stayTime padr5 mt-0">
                   <span class="fa-stack fa-lg calendar-icon ">
                     <i class="fa fa-bed fa-stack-1x site-main-text-color"></i>
                   </span>
                    <span class="lh35 stayingTime">{$smarty.const.SEARCH_NIGHT} ##Night## </span>
                    <input type="hidden" id="stayingTime" name="stayingTime" value="{$smarty.const.SEARCH_NIGHT}"/>
                    <input type="hidden" id="hotelType" name="hotelType" value="{$smarty.const.SEARCH_HOTEL_TYPE}"/>
                    {*<input type="hidden" id="star" name="star" value="{$smarty.const.SEARCH_STAR}"/>
                    <input type="hidden" id="price" name="price" value="{$smarty.const.SEARCH_PRICE}"/>*}
                </div>

                <div class="form-hotel-item  form-hotel-item-searchBox-btn" >
                    <span></span>
                    <div class="input">
                        <button class="site-bg-main-color" type="button" id="searchHotelLocal" onclick="submitSearchHotelLocal()" >##Search##</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="filterBox">

        <div class="filtertip-searchbox">
            <span class="filter-title">  ##Searchnamehotel##</span>
            <div class="filter-content padb0">
                <input type="text" class="form-hotel-item-searchHotelName"  placeholder=" ##Namehotel##" id="inputSearchHotel">
                <i class="fa fa-search fa-stack-1x form-hotel-item-searchHotelName-i site-main-text-color"></i>
            </div>
        </div>

        <div class="filtertip-searchbox">
            <span class="filter-title"> ##Price## (##Rial##)</span>
            <div class="filter-content padb0">
                <div class="filter-price-text">
                    <span> <i></i> ##Rial##</span>
                    <span> <i></i> ##Rial##</span>
                </div>
                <div id="slider-range"></div>
            </div>
        </div>

        <div class="filtertip-searchbox">
            <span class="filter-title">##Starhotel##</span>
            <div class="filter-content padb10">

                <div class="raste-item">
                    <input type="checkbox" class="FilterHoteltype hotelStarFilter" id="starHotel5" name="starHotel5" value="5">
                    <label class="FilterHoteltypeName site-main-text-color-a" for="starHotel5"></label>
                    <div class="hotel-star-filter-box">
                        <div class="hotel-star-filter star-5">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>

                <div class="raste-item">
                    <input type="checkbox" class="FilterHoteltype hotelStarFilter" id="starHotel4" name="starHotel4" value="4">
                    <label class="FilterHoteltypeName site-main-text-color-a" for="starHotel4"></label>
                    <div class="hotel-star-filter-box">
                        <div class="hotel-star-filter star-4">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>

                <div class="raste-item">
                    <input type="checkbox" class="FilterHoteltype hotelStarFilter" id="starHotel3" name="starHotel3" value="3">
                    <label class="FilterHoteltypeName site-main-text-color-a" for="starHotel3"></label>
                    <div class="hotel-star-filter-box">
                        <div class="hotel-star-filter star-3">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>

                <div class="raste-item">
                    <input type="checkbox" class="FilterHoteltype hotelStarFilter" id="starHotel2" name="starHotel2" value="2">
                    <label class="FilterHoteltypeName site-main-text-color-a" for="starHotel2"></label>
                    <div class="hotel-star-filter-box">
                        <div class="hotel-star-filter star-2">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
                <div class="raste-item">
                    <input type="checkbox" class="FilterHoteltype hotelStarFilter" id="starHotel1" name="starHotel1" value="1">
                    <label class="FilterHoteltypeName site-main-text-color-a" for="starHotel1"></label>
                    <div class="hotel-star-filter-box">
                        <div class="hotel-star-filter star-1">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="filtertip-searchbox">
            <span class="filter-title"> ##Line##</span>
            <div class="filter-content padb10 padt10">
                <p class="raste-item">
                    <input type="checkbox" class="FilterHoteltype Show_all" id="check_list_all" name="check_list_all" value="all" checked>
                    <label class="FilterHoteltypeName site-main-text-color-a" for="check_list_all">##All##</label>
                </p>
                {foreach $objResult->All_HotelType as $HotelType}
                <p class="raste-item">
                    <input type="checkbox" class="FilterHoteltype ShowByHotelFilters" id="check_list{$HotelType.Code}" name="heck_list{$HotelType.Code}" value="{$HotelType.Code}">
                    <label class="FilterHoteltypeName site-main-text-color-a" for="check_list{$HotelType.Code}">{$HotelType.Name}</label>
                </p>
                {/foreach}
            </div>
        </div>

    </div>
</div>

<!-- LIST CONTENT-->
<div class="col-lg-9  col-md-12  col-sm-12 col-xs-12 " id="result">


    {if $objResult->errorSearchHotel eq 'true'}

    <div class="userProfileInfo-messge">
        <div class="messge-login BoxErrorSearch">
            <div style="float: right;">  <i class="fa fa-exclamation-triangle IconBoxErrorSearch"></i>
            </div>
            <div class="TextBoxErrorSearch">
  ##Nohotel##<br/>
                ##Changeserach##

            </div>
        </div>
    </div>

    {elseif !$smarty.const.SEARCH_CITY || !$smarty.const.SEARCH_START_DATE || !$smarty.const.SEARCH_NIGHT }

        <div class="userProfileInfo-messge ">
            <div class="messge-login BoxErrorSearch">
                <div style="float: right;">  <i class="fa fa-exclamation-triangle IconBoxErrorSearch"></i>
                </div>
                <div class="TextBoxErrorSearch">
                    ##Nohotel##<br/>
                    ##Changeserach##
                </div>
            </div>
        </div>

    {else}


        <div class="sort-by-section clearfix box">
            <div class="info-login">
                <div class="head-info-login">
                    <span class="site-bg-main-color site-bg-color-border-right-b">
                                ##Sortby##
                    </span>
                </div>
                <div class="form-sort hotel-sort hotel-sort-hotel">

                    <div class="s-u-form-input-number col-md-6">
                        <div class="select">
                            <select class="select2" id="starSortSelect" tabindex="-1"
                                    aria-hidden="true" onchange="selectSortHotel(this);">
                                <option disabled="" selected="" hidden="">##Starhotel## </option>
                                <option value="min_star_code">  ##LTM## </option>
                                <option value="max_star_code">   ##MTL## </option>
                            </select>
                        </div>
                    </div>
                    <div class="s-u-form-input-number col-md-6 pr-0">
                        <div class="select">
                            <select class="select2" id="priceSortSelect" tabindex="-1"
                                    aria-hidden="true" onchange="selectSortHotel(this);">
                                <option disabled="" selected="" hidden="">##Price##</option>
                                <option value="min_room_price">##LTM## </option>
                                <option value="max_room_price"> ##MTL##  </option>
                            </select>
                        </div>
                    </div>
                    {*<div class="s-u-form-input-number form-item form-item-sort countTiket">
                        <p>##Result##:<var>{$objResult->countHotel}</var><kbd>##Hotel##</kbd></p>
                    </div>*}
                </div>
            </div>
        </div>


        <div id="hotelResult">
        {foreach $objResult->Hotel as $Hotel}
            <div class="hotelResultItem">
                <div id="a1" class="hotel-result-item"
                     data-typeApplication="{$Hotel.type_application}"
                     data-priority="{$Hotel.priority}"
                     data-price="{$Hotel.min_room_price}"
                     data-star="{$Hotel.star_code}"
                     data-HotelType="{$Hotel.type_code}"
                     data-HotelName="{$Hotel.hotel_name}">

                    {if $Hotel.type_application eq 'reservation'}
                        <div class="ribbon-special-hotel"><span><i> ##Specialhotel##  </i></span></div>
                        {if $Hotel.discount>0}
                            <div class="ribbon-hotel site-bg-color-dock-border-top"><span class="site-bg-main-color "><i> {$Hotel.discount}% ##Discount## </i></span></div>
                        {/if}
                    {else}
                        {if $Hotel.discount>0}
                            <div class="ribbon-special-hotel-top site-bg-color-dock-border-top"><span  class="site-bg-main-color"><i> {$Hotel.discount}% ##Discount## </i></span></div>
                        {/if}
                    {/if}


                    <div class="col-md-4 nopad">
                        <div class="hotel-result-item-image site-bg-main-color-hover">

                            <a onclick="hotelDetail('{$Hotel.type_application}', '{$Hotel.hotel_id}', '{$Hotel.hotel_name_en}')">
{*                                <img src="{$Hotel.pic}" alt=" ">*}
                                <img src="{$Hotel.pic}" alt=" ">
{*                                <img src="{$objResult->ReadHotelImageSourceFrom360($Hotel.hotel_id)}" alt=" ">*}
                            </a>
                        </div>
                    </div>

                    <div class="col-md-8 nopad">
                        <div class="hotel-result-item-content">
                            <div class="hotel-result-item-text">
                                <a onclick="hotelDetail('{$Hotel.type_application}', '{$Hotel.hotel_id}', '{$Hotel.hotel_name_en}')">
                                    <b class="hotel-result-item-name"> {$Hotel.hotel_name}</b>
                                    {*{if $Hotel.hotel_name_en neq ''}<b class="hotel-result-item-name hotel-nameEn">{$Hotel.hotel_name_en}</b>{/if}*}
                                </a>
                                <span class="hotel-result-item-content-location fa-map-marker height40">
                                    <span>{$Hotel.address}</span>
                                </span>
                                <p class="hotel-result-item-description {if $Hotel.type_application eq 'reservation'}height46{else}height95{/if}">
                                    {$Hotel.cancel_conditions}
                                </p>
                                {if $Hotel.type_application eq 'reservation'}
                                    <ul class="hotelpreferences">
                                        {foreach $Hotel.facilities as $k=>$facilities}
                                            {if $k lte '11'}
                                                <li class="tooltip-hotel">
                                                    <span class="{$facilities['iconClass']}"></span>
                                                    <span class="tooltiptext-hotel">{$facilities['title']}</span>
                                                </li>
                                            {/if}
                                        {/foreach}
                                    </ul>
                                {/if}
                            </div>

                            <div class="hotel-result-item-bottom">
                                <input type="hidden" id="starSortDep" name="starSortDep" value="{$Hotel.star_code}">
                                {if $Hotel.star_code neq 0}
                                    <span class="hotel-star">
                                        {for $s=1 to $Hotel.star_code}
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                        {/for}
                                        {for $ss=$s to 5}
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                        {/for}
                                    </span>
                                {/if}

                                <input id="idHotel" name="idHotel" type="hidden" value="{$Hotel.Code}">

                                {if $Hotel.min_room_price neq 0}
                                    <span class="hotel-time-stay">##Startpricefor## {$smarty.const.SEARCH_NIGHT} ##Night##</span>

                                    {if $Hotel.type_application neq 'reservation' && $Hotel.min_room_price_without_discount neq 0}
                                        {assign var="disabledCurrency" value=$objFunctions->CurrencyCalculate($Hotel.min_room_price_without_discount)}
                                        <strike class="strikePrice">
                                            <span class="currency priceOff CurrencyCal"
                                                  data-amount="{$Hotel.min_room_price_without_discount}">{$objFunctions->numberFormat($disabledCurrency.AmountCurrency)}</span>
                                        </strike>
                                    {/if}

                                    {assign var="mainCurrency" value=$objFunctions->CurrencyCalculate($Hotel.min_room_price)}
                                    <span class="hotel-start-price priceSortAdt">
                                        <b class="CurrencyCal" data-amount="{$Hotel.min_room_price}"> {$objFunctions->numberFormat($mainCurrency.AmountCurrency)} </b>
                                        <span class="CurrencyText">{$mainCurrency.TypeCurrency}</span>
                                    </span>
                                {*{else}
                                    <div class="car-description">
                                    <span class="c-promotion-box__cover-text js-product-status">
                                        <span>##Unavailable##</span>
                                    </span>
                                    </div>*}
                                {/if}

                                <a onclick="hotelDetail('{$Hotel.type_application}', '{$Hotel.hotel_id}', '{$Hotel.hotel_name_en}')"
                                   class="bookbtn mt1 site-bg-main-color  site-main-button-color-hover">  ##ShowReservation##</a>

                                {if $objSession->IsLogin()}
                                    {assign var="counterId" value=$objFunctions->getCounterTypeId($smarty.session.userId)}
                                    {assign var="paramPointClub" value=[
                                        'service' => $objFunctions->TypeServiceHotel($Hotel.type_application),
                                        'baseCompany' => 'all',
                                        'company' => 'all',
                                        'counterId' => $counterId,
                                        'price' => $Hotel.min_room_price]}
                                    {assign var="pointClub" value=$objFunctions->CalculatePoint($paramPointClub)}
                                    {if $pointClub gt 0}
                                        <div class="text_div_more_hotel site-main-text-color iranM txt12">##Yourpurchasepoints## : {$pointClub} ##Point##</div>
                                    {/if}
                                {/if}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {/foreach}
        </div>

    {/if}

</div>
</div>

<form  method="post" id="formHotel" action="" target="_blank">
    <input id="startDate" name="startDate" type="hidden" value="{$smarty.const.SEARCH_START_DATE}">
    <input id="nights" name="nights" type="hidden" value="{$smarty.const.SEARCH_NIGHT}">
    <input type="hidden" name="CurrencyCode" class="CurrencyCode" value='{$objSession->getCurrency()}' />
</form>







{literal}

<script>

    //filterHotelStar
    $(".hotelStarFilter").on("click", function () {
        let hotelList = $(".hotel-result-item");
        let isCheck = 0;
        hotelList.hide();
        $("input:checkbox.hotelStarFilter").each(function () {
            let check = $(this).prop('checked');
            let val = $(this).val();
            if (check == true) {
                isCheck++;
                hotelList.filter(function () {
                    let star = $(this).data("star");
                    return val == star
                }).show();
            }
        });

        setTimeout(function () {
            if (isCheck == 0) {
                hotelList.show();
            }
        }, 30);

        $('html, body').animate({
            scrollTop: $('.sort-by-section').offset().top
        }, 'slow');

    });
    // end filterHotelStar


    $(function () {
        $("#slider-range").slider({
            range: true,
            min: {/literal}{$objResult->minPrice}{literal},
            max: {/literal}{$objResult->maxPrice}{literal},
            step: 500000,
            animate: false,
            values: [{/literal}{$objResult->minPrice}{literal}, {/literal}{$objResult->maxPrice}{literal}],
            slide: function (event, ui) {

                let minRange = ui.values[0];
                let maxRange = ui.values[1];

                $(".filter-price-text span:nth-child(2) i").html(addCommas(minRange));
                $(".filter-price-text span:nth-child(1) i").html(addCommas(maxRange));

                let hotels = $(".hotel-result-item");
                hotels.hide().filter(function () {
                    let price = parseInt($(this).data("price"), 10);
                    return price >= minRange && price <= maxRange;
                }).show();

            }
        });

        $(".filter-price-text span:nth-child(2) i").html(addCommas({/literal}{$objResult->minPrice}{literal}));
        $(".filter-price-text span:nth-child(1) i").html(addCommas({/literal}{$objResult->maxPrice}{literal}));
    });
</script>
<script type="text/javascript">

    $(document).ready(function () {

        setTimeout(function () {
            $('.loaderPublicForHotel').fadeOut(500);
            sortHotelList('{/literal}{$sortHotel}{literal}');
            $('#result').show();
        }, 3000);


        $(".ShowByHotelFilters").on("click",function(){
            $('.Show_all').prop('checked', true);
            var hotelList = $(".hotel-result-item");
            var isCheck = 0;
            hotelList.hide();
            $("input:checkbox.ShowByHotelFilters").each(function(){
                var check = $(this).prop('checked');
                var val = $(this).val();
                console.log(check, val);
                if (check == true){
                    isCheck++;
                    $('.Show_all').prop('checked', false);
                    var Check = parseInt($(this).val());
                    hotelList.filter(function () {
                        var hotelType = parseInt($(this).data("hoteltype"), 10);
                        return hotelType == Check;
                    }).show();
                }

            });

            setTimeout(function () {
                console.log('isCheck', isCheck);
                if (isCheck == 0){
                    hotelList.show();
                }
            }, 30);

        });

        $(".Show_all").on("click",function(){
            var hotelList = $(".hotel-result-item");
            hotelList.show();
            var check = $(this).prop('checked');
            if (check == true){
                $("input:checkbox.ShowByHotelFilters").each(function(){
                    $(this).prop( "checked", false );
                });
            } else {
                $(".Show_all").prop( "checked", true );
            }
        });


        $("#inputSearchHotel").keyup(function() {

            var hotels = $(".hotel-result-item");
            var inputSearchHotel = $("#inputSearchHotel").val();

            hotels.hide().filter(function () {
                var hotelName = $(this).data("hotelname");

                var search = hotelName.indexOf(inputSearchHotel);
                if (search > -1){
                    return hotelName;
                }

            }).show();

        });


        //change currency
        $( ".currency-gds" ).click(function() {
            $('.change-currency').toggle();
            if ($(".currency-inner .currency-arrow").hasClass("currency-rotate")) {
                $( ".currency-inner .currency-arrow" ).removeClass('currency-rotate');
            } else {
                $( ".currency-inner .currency-arrow" ).addClass('currency-rotate')
            }
        });



    });



</script>
{/literal}