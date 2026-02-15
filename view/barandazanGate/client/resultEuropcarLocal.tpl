{load_presentation_object filename="resultEuropcarLocal" assign="objResult"}
{load_presentation_object filename="currencyEquivalent" assign="objCurrency"}

{assign var="sourceStationId" value=$smarty.const.SOURCE_STATION_ID}
{assign var="destStationId" value=$smarty.const.DEST_STATION_ID}
{assign var="getCarDateTime" value=$smarty.const.GET_CAR_DATETIME}
{assign var="returnCarDateTime" value=$smarty.const.RETURN_CAR_DATETIME}

{$objResult->getStation($sourceStationId, $destStationId)}
{$objResult->getDay($getCarDateTime, $returnCarDateTime)}
{$objResult->getCarRentalReservation($sourceStationId, $destStationId, $objResult->getCarDate, $objResult->getCarTime, $objResult->returnCarDate, $objResult->returnCarTime, '1')}

<!-- login and register popup -->
{assign var="useType" value="europcar"}
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentLoginRegister.tpl"}
<!-- login and register popup -->




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
        <div class="filtertip_hotel site-bg-main-color site-bg-color-border-bottom">
            <p class="txt14"><i class="fa fa-car" aria-hidden="true"></i><span class="hotel-city-name"> ##Carrental##  </span></p>
        </div>

        <div class="filtertip-searchbox ">
            <form class="search-wrapper" action="" method="post">

                <div class="clrB site-main-text-color-drck box-foreign-hotel-room-item">
                    <span class="filter-title">##Deliverystation## </span>
                </div>

                <div class="form-hotel-item form-hotel-item-searchBox">
                    <div class="select">
                        <select name="sourceStationId" id="sourceStationId" class="select2">
                            <option value="" selected="selected"> ##Deliverystation##</option>
                            {foreach $objResult->listStation['GetStationsResult']['Station'] as $val}
                                <option value="{$val['Id']}" {if $sourceStationId eq $val['Id']}selected="selected"{/if}>{$val['Name']}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>

                <p style="float: left" class="checkboxStations">
                    <input type="checkbox" class="FilterHoteltype" id="changeStations" name="changeStations" value="1"
                           {if $sourceStationId neq $destStationId}checked{/if}>
                    <label class="FilterHoteltypeName site-main-text-color-a" for="changeStations">##Bringcaranother##</label>
                </p>
                <div id="returnStations" {if $sourceStationId eq $destStationId}class="hidden"{/if}>

                    <div class="clrB site-main-text-color-drck box-foreign-hotel-room-item">
                        <span class="filter-title">##Stationreturned##</span>
                    </div>

                    <div class="form-hotel-item form-hotel-item-searchBox">
                        <div class="select">
                            <select name="destStationId" id="destStationId" class="select2">
                                <option value="" selected="selected"> ##Selection##</option>
                                {foreach $objResult->listStation['GetStationsResult']['Station'] as $val}
                                    <option value="{$val['Id']}" {if $destStationId eq $val['Id']}selected="selected"{/if}>{$val['Name']}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>

                </div>


                <div class="clrB site-main-text-color-drck box-foreign-hotel-room-item">
                    <span class="filter-title">##Datetimeofdelivery##</span>
                </div>

                <div class="form-hotel-item  form-hotel-item-searchBox-date padl5">
                        <span class="fa-stack fa-lg calendar-icon site-main-text-color">
                            <i class="fa fa-calendar fa-stack-1x"></i>
                        </span>
                    <div class="input">
                        <input type="text" class="shamsiDeptCalendarWithMinDateTomorrow" placeholder="##Datetimeofdelivery## "
                               id="startDate" name="startDate" value="{$objResult->getCarDate}">
                    </div>
                </div>

                <div class="form-hotel-item  form-hotel-item-searchBox-date padl5">
                    <div class="select">
                        <select name="startTime" id="startTime" class="select2">
                            <option value="{$objResult->getCarTime}">{$objResult->getCarTime}</option>
                            {$objResult->getListTime()}
                        </select>
                    </div>
                </div>

                <div class="clrB site-main-text-color-drck box-foreign-hotel-room-item">
                    <span class="filter-title">##Datetimeofreturn## </span>
                </div>

                <div class="form-hotel-item  form-hotel-item-searchBox-date padr5">
                        <span class="fa-stack fa-lg calendar-icon site-main-text-color">
                            <i class="fa fa-calendar fa-stack-1x"></i>
                        </span>
                    <div class="input">
                        <input type="text" class="shamsiReturnCalendarWithMinDateTomorrow" placeholder="##Returndate## "
                               id="endDate" name="endDate" value="{$objResult->returnCarDate}">
                    </div>
                </div>

                <div class="form-hotel-item  form-hotel-item-searchBox-date padl5">
                    <div class="select">
                        <select name="endTime" id="endTime" class="select2">
                            <option value="{$objResult->returnCarTime}">{$objResult->returnCarTime}</option>
                            {$objResult->getListTime()}
                        </select>
                    </div>
                </div>

                <div class="form-hotel-item  form-hotel-item-searchBox-btn" >
                    <span></span>
                    <div class="input">
                        <button class="site-bg-main-color" type="button" id="searchHotelLocal"
                                onclick="submitSearchEuropcar()" >##Search##</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="filterBox">

        <div class="filtertip-searchbox">
            <span class="filter-title"> ##Searchnamecar## </span>
            <div class="filter-content padb0">
                <input type="text" class="form-hotel-item-searchHotelName"  placeholder=" ##Namecar##" id="inputSearchName">
                <i class="fa fa-search fa-stack-1x form-hotel-item-searchHotelName-i site-main-text-color"></i>
            </div>
        </div>

        <div class="filtertip-searchbox mart20">
            <span class="filter-title"> ##Price## (##Rial##)</span>
            <div class="filter-content">
                <p class="sider-rang">
                    <span class="min-rang padr5">{$objResult->minPrice}</span>
                    -
                    <span class="max-reng padl5">{$objResult->maxPrice}</span>
                </p>
                <input data-addui='slider' data-min='{$objResult->minPrice}'  data-max='{$objResult->maxPrice}' data-range='true' value='{$objResult->minPrice},{$objResult->maxPrice}'/>
            </div>
        </div>

    </div>
</div>

<!-- LIST CONTENT-->
<div class="col-lg-9 col-md-12  col-sm-12 col-xs-12 " id="result">

{if $objResult->error eq 'true'}
    <div class="userProfileInfo-messge">
        <div class="messge-login BoxErrorSearch">
            <div style="float: right;">  <i class="fa fa-exclamation-triangle IconBoxErrorSearch"></i>
            </div>
            <div class="TextBoxErrorSearch">
                {if $objResult->errorMessage neq ''}
                    {$objResult->errorMessage} <br/>
                {else}
               ##nocarthisdate##<br/>
                {/if}
               ##Searchanotherdate##<br/>
            </div>
        </div>
    </div>
{else}

    <div id="hotelResult">

        {foreach $objResult->listCarRentalReservation['CarRentalReservationResult']['Cars']['CarDaysPrice'] as $car}
        <div class="hotelResultItem carItem">
            <div id="a1" class="hotel-result-item" data-price="{$car['Car']['PriceEachDayRial']}" data-hotelname="{$car['Car']['Brand']['Name']} {$car['Car']['Model']} {$car['Car']['GearBoxType']['Name']} {$car['Car']['Brand']['EngName']}">

                {if $objResult->serviceDiscountLocal['off_percent'] neq 0}
                <div class="ribbon-special-hotel">
                    <span><i> {$objResult->serviceDiscountLocal['off_percent']}% ##Discount## </i></span>
                </div>
                {/if}

                <div class="col-md-4 nopad">
                    <div class="hotel-result-item-image site-bg-main-color-hover">
                        <a>
                            <img src="{$objResult->urlImageCar($car['Car']['Img'])}" alt="{$car['Car']['Brand']['Name']}">
                        </a>
                    </div>
                </div>

                <div class="col-md-8 nopad">
                    <div class="hotel-result-item-content">
                        <div class="hotel-result-item-text">
                            <a>
                                <b class="hotel-result-item-name"> {$car['Car']['Brand']['Name']} - {$car['Car']['Model']} ({$car['Car']['Brand']['EngName']})</b>
                            </a>

                            <span class="hotel-result-item-content-location fa fa-map-marker">
                                <span>##Delivery## {$objResult->sourceStationName} </span>
                            </span>
                            <span class="car-result-item fa fa-check">
                                <span>##Capacity##: {$car['Car']['PassengerCount']} ##People## </span>
                            </span>
                            <span class="car-result-item fa fa-check">
                                <span>##MaximumKm##: {$car['Car']['AllowedKm']} Km</span>
                            </span>
                            <span class="car-result-item fa fa-check">
                                <span>##Minimumagedriver## {$car['Car']['MinAgeToRent']} ##Year## </span>
                            </span>
                            <span class="car-result-item fa fa-check">
                                {assign var="addKmCurrency" value=$objFunctions->CurrencyCalculate($car['Car']['AddKmCostRial'])}
                                <span>##Priceperkilometerextra##: <i class="CurrencyCal" data-amount="{$car['Car']['AddKmCostRial']}">{$objFunctions->numberFormat($addKmCurrency.AmountCurrency)}</i> <i class="CurrencyText">{$addKmCurrency.TypeCurrency}</i></span>
                            </span>
                            {if $car['Car']['InsuranceCostRial'] neq 0}
                                <span class="car-result-item fa fa-check">
                                    {assign var="insuranceCurrency" value=$objFunctions->CurrencyCalculate($car['Car']['InsuranceCostRial'])}
                                    <span> ##Insuranceprice##: <i class="CurrencyCal" data-amount="{$car['Car']['InsuranceCostRial']}">{$objFunctions->numberFormat($insuranceCurrency.AmountCurrency)}</i> <i class="CurrencyText">{$insuranceCurrency.TypeCurrency}</i></span>
                                </span>
                            {/if}

                            <a class="more-info-car-a" onclick="showMoreInfo('{$car['Car']['Id']}')">
                                <div class="more-info-car">
                                    <span class="slideDownHotelDescription">
                                        <div class="my-more-info">  ##Showmoredetail##<i id="arrow{$car['Car']['Id']}" class="fa fa-angle-down"></i></div>
                                    </span>
                                </div>
                            </a>

                        </div>

                        <div class="hotel-result-item-bottom">

                            <span class="hotel-time-stay">##Maximumdailyprice##</span>
                            {if $objResult->serviceDiscountLocal['off_percent'] neq 0}
                                <strike class="strikePrice">
                                    {assign var="everyMainCurrency" value=$objFunctions->CurrencyCalculate($car['Car']['PriceEachDayRial'])}
                                    <span class="currency priceOff"><b class="CurrencyCal" data-amount="{$car['Car']['PriceEachDayRial']}">{$objFunctions->numberFormat($everyMainCurrency.AmountCurrency)}</b> <span class="CurrencyText">{$everyMainCurrency.TypeCurrency}</span></span>
                                </strike>
                                {assign var="priceWithDiscount" value=$objResult->setDiscount($car['Car']['PriceEachDayRial'])}
                                {assign var="everyDiscountCurrency" value=$objFunctions->CurrencyCalculate($priceWithDiscount)}
                                <span class="hotel-start-price priceSortAdt"><b class="CurrencyCal" data-amount="{$priceWithDiscount}">{$objFunctions->numberFormat($everyDiscountCurrency.AmountCurrency)}</b> <span class="CurrencyText">{$everyDiscountCurrency.TypeCurrency}</span></span>
                            {else}
                                {assign var="everyMainCurrency" value=$objFunctions->CurrencyCalculate($car['Car']['PriceEachDayRial'])}
                                <span class="hotel-start-price priceSortAdt"><b class="CurrencyCal" data-amount="{$car['Car']['PriceEachDayRial']}">{$objFunctions->numberFormat($everyMainCurrency.AmountCurrency)}</b> <span class="CurrencyText">{$everyMainCurrency.TypeCurrency}</span></span>
                            {/if}


                            <div class="car-description">
                                <span class="c-promotion-box__cover-text js-product-status">
                                    <span>{$car['Car']['StationStatus']['Name']}</span>
                                </span>
                            </div>

                            <a onclick="reserveCar('{$car['Car']['Id']}')" class="bookbtn mt1 site-bg-main-color site-main-button-color-hover">##Reservation##</a>

                        </div>
                    </div>
                </div>


                <div class="car-details displayN" id="moreInfo{$car['Car']['Id']}">
                    <div class="international-available-panel-min international-available-panel-max">

                        <div id="" class="tab-content current">
                            <div class="international-available-airlines-detail-tittle padding-none margin-none">

                                <div class="international-available-airlines-detail border-none padding-none margin-none">

                                    <div class="airlines-detail-box">
                                        <span class="padt0 iranb txt12 lh18 displayb">##Tankcapacity##: <i class="iranNum">{$car['Car']['TankCapacity']}</i> ##Litter## </span>
                                        <span class="padt0 iranb txt12 lh18 displayb">##Enginecapacity##: <i class="iranNum">{$car['Car']['MotorCapacity']}</i></span>
                                        <span class="padt0 iranb txt12 lh18 displayb">##Fuel##: <i class="iranNum">{$car['Car']['FuelType']['Name']}</i></span>
                                    </div>

                                    <div class="airlines-detail-box">
                                        <span class="padt0 iranb txt12 lh18 displayb">##Gear##: <i class="iranNum">{$car['Car']['GearBoxType']['Name']}</i></span>
                                        <span class="padt0 iranb txt12 lh18 displayb"><i class="iranNum">{$car['Car']['DoorCount']}</i> در </span>
                                        <span class="padt0 iranb txt12 lh18 displayb"> ##Capacityfund##: <i class="iranNum">{$car['Car']['PassengerCount']}</i> ##Suitcase## </span>
                                    </div>

                                    <div class="airlines-detail-box">
                                        {assign var="safteCurrency" value=$objFunctions->CurrencyCalculate($car['Car']['ReturnGuaranteeBySafte'])}
                                        <span class="padt0 iranb txt12 lh18 displayb"> ##Refund## (##Promissorynote##): <i class="iranNum CurrencyCal" data-amount="{$car['Car']['ReturnGuaranteeBySafte']}"> {$objFunctions->numberFormat($safteCurrency.AmountCurrency)}</i> <i class="CurrencyText">{$safteCurrency.TypeCurrency}</i></span>

                                        {assign var="checkCurrency" value=$objFunctions->CurrencyCalculate($car['Car']['ReturnGuaranteeByCheck'])}
                                        <span class="padt0 iranb txt12 lh18 displayb">  ##Refund## (##Checkbook##): <i class="iranNum CurrencyCal" data-amount="{$car['Car']['ReturnGuaranteeByCheck']}">{$objFunctions->numberFormat($checkCurrency.AmountCurrency)}</i> <i class="CurrencyText">{$checkCurrency.TypeCurrency}</i></span>

                                        {assign var="cashCurrency" value=$objFunctions->CurrencyCalculate($car['Car']['ReturnGuaranteeByCash'])}
                                        <span class="padt0 iranb txt12 lh18 displayb">  ##Refund## (##Cash##): <i class="iranNum CurrencyCal" data-amount="{$car['Car']['ReturnGuaranteeByCash']}">{$objFunctions->numberFormat($cashCurrency.AmountCurrency)}</i> <i class="CurrencyText">{$cashCurrency.TypeCurrency}</i></span>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>

                </div>


            </div>
        </div>
        {/foreach}
    </div>

{/if}
</div>



<form  method="post" id="formCar" action="">
    <input id="idCar" name="idCar" type="hidden" value="">
    <input id="sourceStationId" name="sourceStationId" type="hidden" value="{$sourceStationId}">
    <input id="destStationId" name="destStationId" type="hidden" value="{$destStationId}">
    <input id="getCarDateTime" name="getCarDateTime" type="hidden" value="{$getCarDateTime}">
    <input id="returnCarDateTime" name="returnCarDateTime" type="hidden" value="{$returnCarDateTime}">
    <input type="hidden" name="typeApplication" id="typeApplication" value="apiEuropcar">
    <input type="hidden" name="CurrencyCode" class="CurrencyCode" value='{$objSession->getCurrency()}' />
</form>

{literal}
<!-- lazyView -->
<script>
    $(document).ready(function () {
        //$('.col-lg-9').lazyView();
    });
</script>
<!-- lazyView -->

<script type="text/javascript">

    $(document).ready(function () {

        /*setTimeout(function () {
            $('.loaderPublicForHotel').fadeOut(500);
            $('#result').show();
        }, 3000);*/

        var cars = $(".hotel-result-item");
        $( "#inputSearchName" ).keyup(function() {


            var inputSearchName = $("#inputSearchName").val();

            cars.hide().filter(function () {
                var hotelname = $(this).data("hotelname");

                var search = hotelname.indexOf(inputSearchName);
                if (search > -1){
                    return hotelname;
                }

            }).show();

        });

        $("body").delegate(".addui-slider-handle-h", "mousemove",function(){
            var maxRange= $(".addui-slider-handle-h div span").text();
            $(".max-reng").text(maxRange);
        });

        $("body").delegate(".addui-slider-handle-l", "mousemove",function(){
            var minRange= $(".addui-slider-handle-l div span").text();
            $(".min-rang").text(minRange);
        });


        $("body").delegate(".addui-slider-handle", "mousemove",function(){
            var minRange= $(".addui-slider-handle-l div span").text();
            var maxRange= $(".addui-slider-handle-h div span").text();

            cars.hide().filter(function () {
                var price = parseInt($(this).data("price"), 10);
                return price >= minRange && price <= maxRange;
            }).show();

        });


        $('#changeStations').change(function () {

            if ($(this).prop('checked')==true){
                $('#returnStations').removeClass('hidden').addClass('showHidden');
            } else {
                $('#returnStations').removeClass('showHidden').addClass('hidden');
            }
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

    function showMoreInfo(id) {

        if ($( "#arrow" + id).hasClass( "fa fa-angle-down")){
            $('#moreInfo' + id).removeClass('displayN');
            $('#arrow'  + id).removeClass('fa fa-angle-down').addClass('fa fa-angle-up');
        } else {
            $('#moreInfo' + id).addClass('displayN');
            $('#arrow'  + id).removeClass('fa fa-angle-up').addClass('fa fa-angle-down');
        }

    }

</script>
{/literal}