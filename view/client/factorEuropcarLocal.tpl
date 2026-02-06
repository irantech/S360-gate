{load_presentation_object filename="factorEuropcarLocal" assign="objFactor"}
{$objFactor->registerPassengers()}

{load_presentation_object filename="resultEuropcarLocal" assign="objResult"}
{assign var="totalFinalPrice" value=$objResult->getReservePaymentPrice($smarty.post.factorNumber)}

{load_presentation_object filename="members" assign="objMember"}
{$objMember->get()}

{assign var="idCar" value=$smarty.post.idCar}
{assign var="sourceStationId" value=$smarty.post.sourceStationId}
{assign var="destStationId" value=$smarty.post.destStationId}
{assign var="getCarDateTime" value=$smarty.post.getCarDateTime}
{assign var="returnCarDateTime" value=$smarty.post.returnCarDateTime}
{assign var="typeApplication" value=$smarty.post.typeApplication}
{assign var="CurrencyCode" value=$smarty.post.CurrencyCode}


{$objResult->getDay($getCarDateTime, $returnCarDateTime)}


{if $objFactor->error eq 'true'}
<div class="container">

    <div id="lightboxContainer" class="lightboxContainerOpacity"></div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 s-u-passenger-wrapper-change " >
        <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
            ##Note## <i class="zmdi zmdi-alert-circle mart10  zmdi-hc-fw"></i>
        </span>
        <div class="s-u-result-wrapper">
            <span class="s-u-result-item-change direcR iranR txt12 txtRed">{$objFactor->errorMessage}</span>
        </div>
    </div>
    <div class="Clr"></div>
</div>
{else}

    <div class="container">

        <div id="lightboxContainer" class="lightboxContainerOpacity"></div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 s-u-passenger-wrapper-change " >
        <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
              ##Note## <i class="zmdi zmdi-alert-circle mart10  zmdi-hc-fw"></i>
        </span>
            <div class="s-u-result-wrapper">
            <span class="s-u-result-item-change direcR iranR txt12 txtRed">
##DontReloadPageInfo##
            </span>
            </div>
        </div>
        <div class="Clr"></div>


        <div class="s-u-passenger-wrapper-change">
        <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">##Invoice##
            <i class="zmdi zmdi-account-box-mail zmdi-hc-fw mart5" aria-hidden="true"></i></span>

            <div class="hotel-booking-room marb0">

                <div class="col-md-3 nopad">
                    <div class="hotel-booking-room-image">
                        <a>
                            <img src="{$objFactor->carBookingInfo['car_image']}" alt="{$objFactor->carBookingInfo['car_name']}">
                        </a>
                    </div>
                </div>

                <div class="col-md-9 ">
                    <div class="hotel-booking-room-content">
                        <div class="hotel-booking-room-text">
                            <b class="hotel-booking-room-name">
                                {$objFactor->carBookingInfo['car_name']} ({$objFactor->carBookingInfo['car_name_en']})
                            </b>
                            <b class="hotel-booking-room-name car-booking-price">##Priceday##:
                                {if $objFactor->serviceDiscountLocal['off_percent'] neq 0}
                                    {assign var="mainCurrency" value=$objFunctions->CurrencyCalculate($objResult->setDiscount($objFactor->carBookingInfo['car_price']), $CurrencyCode)}
                                    <i>{$objFunctions->numberFormat($mainCurrency.AmountCurrency)}</i> {$mainCurrency.TypeCurrency}
                                {else}
                                    {assign var="mainCurrency" value=$objFunctions->CurrencyCalculate($objFactor->carBookingInfo['car_price'], $CurrencyCode)}
                                    <i>{$objFunctions->numberFormat($mainCurrency.AmountCurrency)}</i> {$mainCurrency.TypeCurrency}
                                {/if}
                            </b>

                            <div class="hotel-result-item-rule car-rule">
                                <p>
                                    <i class="fa fa-check"></i>##Capacity##: {$objFactor->carBookingInfo['car_passenger_count']} ##People##
                                </p>
                                <p>
                                    <i class="fa fa-check"></i>##MaximumKm##: {$objFactor->carBookingInfo['car_allowed_km']} Km
                                </p>
                                <p>
                                    <i class="fa fa-check"></i>##Minimumagedriver## {$objFactor->carBookingInfo['car_min_age_to_rent']}
                                </p>
                                <p>
                                    {assign var="addKmCurrency" value=$objFunctions->CurrencyCalculate($objFactor->carBookingInfo['car_add_km_cos_rial'], $CurrencyCode)}
                                    <i class="fa fa-check"></i>##Priceperkilometerextra##: {$objFunctions->numberFormat($addKmCurrency.AmountCurrency)} {$addKmCurrency.TypeCurrency}
                                </p>
                                {if $objFactor->carBookingInfo['InsuranceCostRial'] neq 0}
                                    <p>
                                        {assign var="insuranceCurrency" value=$objFunctions->CurrencyCalculate($objFactor->carBookingInfo['car_insurance_cost_rial'], $CurrencyCode)}
                                        <i class="fa fa-check"></i>##Insuranceprice##: {$objFunctions->numberFormat($insuranceCurrency.AmountCurrency)} {$insuranceCurrency.TypeCurrency}
                                    </p>
                                {/if}
                            </div>

                        </div>

                        <div class="hotel-booking-room-text">
                            <ul>
                                <li class="car-check-text width35"><i class="fa fa-map-marker"></i> ##Delivery## :
                                    <span class="hotel-check-date" dir="rtl">{$objFactor->carBookingInfo['source_station_name']}</span>
                                </li>
                                <li class="car-check-text"><i class="fa fa-calendar-check-o"></i> ##Deliverydate## :
                                    <span class="hotel-check-date" dir="rtl">{$objResult->getCarDate}</span>
                                </li>
                                <li class="car-check-text"><i class="fa fa-clock-o"></i> ##Timedelivery## :
                                    <span class="hotel-check-date" dir="rtl">{$objResult->getCarTime}</span>
                                </li>
                            </ul>
                        </div>

                        <div class="hotel-booking-room-text">
                            <ul>
                                <li class="car-check-text width35"><i class="fa fa-map-marker"></i> ##Return## :
                                    <span class="hotel-check-date" dir="rtl">{$objFactor->carBookingInfo['dest_station_name']}</span>
                                </li>
                                <li class="car-check-text"><i class="fa fa-calendar-check-o"></i> ##Returndate## :
                                    <span class="hotel-check-date" dir="rtl">{$objResult->returnCarDate}</span>
                                </li>
                                <li class="car-check-text"><i class="fa fa-clock-o"></i> ##Returntime## :
                                    <span class="hotel-check-date" dir="rtl">{$objResult->returnCarTime}</span>
                                </li>
                            </ul>
                        </div>

                    </div>

                </div>
                <div class="clear"></div>

                {if $objFactor->thingInfo[0] neq ''}
                    <h4 class="tableOrderHeadTitle site-bg-main-color">
                        <span> ##Selectedcaraccessorieslist##</span>
                    </h4>
                    <div class="rp-tableOrder site-border-main-color">
                        <table>
                            <thead>
                            <tr class="Hotel-tableOrderHead">
                                <th class="Hotel-tableOrderHead-c1">##Title## </th>
                                <th class="Hotel-tableOrderHead-c3">##Numberofrequests## </th>
                                <th class="Hotel-tableOrderHead-c6"> ##TotalPrice##</th>
                            </tr>
                            </thead>
                            <tbody>

                            {foreach $objFactor->thingInfo as $thing}
                                <tr>
                                    <td class="Hotel-tableOrderHead">
                                        <h5 class="roomsTitle">{$thing['thingsName']}</h5>
                                    </td>

                                    <td class="Hotel-tableOrderHead">
                                        <h5 class="roomsTitle">{$thing['countThings']}</h5>
                                    </td>

                                    <td class="Hotel-tableOrderHead">
                                        {assign var="perThingCurrency" value=$objFunctions->CurrencyCalculate($thing['priceThings'], $CurrencyCode)}
                                        <div class="roomFinalPrice ">{$objFunctions->numberFormat($perThingCurrency.AmountCurrency)} {$perThingCurrency.TypeCurrency}</div>
                                    </td>
                                </tr>
                            {/foreach}

                            </tbody>
                        </table>
                    </div>

                    <div class="DivTotalPrice ">
                        {assign var="totalThingsCurrency" value=$objFunctions->CurrencyCalculate($objFactor->carBookingInfo['things_price'], $CurrencyCode)}
                        <div class="fltl">##Totalcostaccessories## : <span>{$objFunctions->numberFormat($totalThingsCurrency.AmountCurrency)}</span> {$totalThingsCurrency.TypeCurrency}</div>
                    </div>
                <div class="clear"></div>
                {/if}


                <div class="main-Content-bottom Dash-ContentL-B">
                    <div class="main-Content-bottom-table Dash-ContentL-B-Table">
                        <div class="main-Content-bottom-table-Title Dash-ContentL-B-Title l-p-p-header l-p-p-header-change site-bg-main-color">
                            <i class="icon-table"></i><h3> ##Driverprofile## </h3>
                        </div>

                        <table id="passengers" class="display" width="100%" cellspacing="0">

                            <thead>
                            <tr>
                                <th>##Name## / ##Nameenglish##</th>
                                <th>##Family##  / ##Familyenglish##</th>
                                <th>##Happybirthday##</th>
                                <th>##Phonenumber## / ##Telephone##</th>
                                <th>##Email##</th>
                                <th>##Address##</th>
                                <th>##Numpassport##/##Nationalnumber##</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                                <td>
                                    <p>{$objFactor->carBookingInfo['passenger_name']}</p>
                                    <p>{$objFactor->carBookingInfo['passenger_name_en']}</p>
                                </td>
                                <td>
                                    <p>{$objFactor->carBookingInfo['passenger_family']}</p>
                                    <p>{$objFactor->carBookingInfo['passenger_family_en']}</p>
                                </td>
                                <td>
                                    <p>{$objFactor->carBookingInfo['passenger_birthday']}</p>
                                    <p>{$objFactor->carBookingInfo['passenger_birthday_en']}</p>
                                </td>
                                <td>
                                    <p>{$objFactor->carBookingInfo['passenger_mobile']}</p>
                                    <p>{$objFactor->carBookingInfo['passenger_telephone']}</p>
                                </td>
                                <td>
                                    <p>{$objFactor->carBookingInfo['passenger_email']}</p>
                                </td>
                                <td>
                                    <p>{$objFactor->carBookingInfo['passenger_address']}</p>
                                </td>
                                <td>
                                    <p>{$objFactor->carBookingInfo['passenger_national_code']}</p>
                                    <p>{$objFactor->carBookingInfo['passportNumber']}</p>
                                </td>
                            </tr>

                            </tbody>


                        </table>
                    </div>
                </div>

                {*<div class="car-box-RefundType-DrivingCrimesType">
                    <span> تحویل خودرو در محل مشتری?
                        <i>
                            {if $objFactor->carBookingInfo['has_source_station_return_cost'] eq '1'} دارد
                            {elseif $objFactor->carBookingInfo['has_source_station_return_cost'] eq '0'} ندارد
                            {/if}
                        </i>
                    </span>
                    <span> استرداد خودرو در محل مشتری?
                        <i>
                            {if $objFactor->carBookingInfo['has_dest_station_return_cost'] eq '1'} دارد
                            {elseif $objFactor->carBookingInfo['has_dest_station_return_cost'] eq '0'} ندارد
                            {/if}
                        </i>
                    </span>
                </div>*}

                <div class="car-box-RefundType-DrivingCrimesType">
                    <span> ##Refundtype##:
                        <i>
                            {if $objFactor->carBookingInfo['refund_type'] eq '1'} ##Checkbook##
                            {elseif $objFactor->carBookingInfo['refund_type'] eq '2'} ##Promissorynote##
                            {elseif $objFactor->carBookingInfo['refund_type'] eq '3'} ##Cash##
                            {/if}
                        </i>
                    </span>
                    <span> ##Typevehiclecrimewarranty##:
                        <i>
                            {if $objFactor->carBookingInfo['driving_crimes_type'] eq '1'} ##Checkbook##
                            {elseif $objFactor->carBookingInfo['driving_crimes_type'] eq '2'} ##Promissorynote##
                            {elseif $objFactor->carBookingInfo['driving_crimes_type'] eq '3'} ##Cash##
                            {/if}
                        </i>
                    </span>
                    <span> ##Deliverycarincustomersite##?
                        <i>
                            {if $objFactor->carBookingInfo['has_source_station_return_cost'] eq '1'} ##Have##
                            {elseif $objFactor->carBookingInfo['has_source_station_return_cost'] eq '0'} ##Donthave##
                            {/if}
                        </i>
                    </span>
                    <span> ##Refundscaratthecustomerpremises##?
                        <i>
                            {if $objFactor->carBookingInfo['has_dest_station_return_cost'] eq '1'} ##Have##
                            {elseif $objFactor->carBookingInfo['has_dest_station_return_cost'] eq '0'} ##Donthave##
                            {/if}
                        </i>
                    </span>
                </div>

                <div class="car-box-file">
                    <span> ##Identityidentity##:
                        <i>
                            {if $objFactor->carBookingInfo['identity_file_type'] eq '1'} ##Nationalcard##
                            {elseif $objFactor->carBookingInfo['identity_file_type'] eq '2'} ##Certificates##
                            {elseif $objFactor->carBookingInfo['identity_file_type'] eq '3'} ##Passport##
                            {/if}
                        </i>
                        <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/europcar/{$objFactor->carBookingInfo['identity_file']}" alt="{$objFactor->carBookingInfo['identity_file']}">
                    </span>
                    <span> ##Residencedocument##:
                        <i>
                            {if $objFactor->carBookingInfo['habitation_file_type'] eq '1'} ##Lastphonebill##
                            {elseif $objFactor->carBookingInfo['habitation_file_type'] eq '2'} ##Propertycertificatelease##
                            {elseif $objFactor->carBookingInfo['habitation_file_type'] eq '3'} ##Another##
                            {/if}
                        </i>
                        <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/europcar/{$objFactor->carBookingInfo['habitation_file']}" alt="{$objFactor->carBookingInfo['habitation_file']}">
                    </span>
                    <span> ##Occupation##:
                        <i>
                            {if $objFactor->carBookingInfo['job_file_type'] eq '1'} ##Lastlegalcheck##
                            {elseif $objFactor->carBookingInfo['job_file_type'] eq '2'}##Doctorcard##
                            {elseif $objFactor->carBookingInfo['job_file_type'] eq '3'}##Businesscardbusinesslicense##
                            {elseif $objFactor->carBookingInfo['job_file_type'] eq '4'} ##Companyrecords##
                            {elseif $objFactor->carBookingInfo['job_file_type'] eq '5'}##Printbankaccount##
                            {elseif $objFactor->carBookingInfo['job_file_type'] eq '6'} ##Another##
                            {/if}
                        </i>
                        <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/europcar/{$objFactor->carBookingInfo['job_file']}" alt="{$objFactor->carBookingInfo['job_file']}">
                    </span>
                </div>


            </div>
        </div>
        <div class="clear"></div>


        {* for display price *}
        <div id="displayPrice">
            <div class="Attention Attention-change" >
                <div class="s-u-select-bank marb30 bg-yellow">

                    <span class="s-u-result-item-change direcR iranR txt12 txtRed">##Likelypricepaychangepaymentprice##</span>
                    <span class="s-u-result-item-change direcR iranR txt12 txtRed">##Formoreinformationcontactemail##</span>
                    <span class="author">
                        <i class="bg-yellow">##Dearusersuccessfullyregisteredcompletethepurchasepurchase##</i>
                    </span>
                    <div class="msg">
                        <span class="box-offline-reserve displayPriceEuropcar"> ##Paymentamount##: <i id="paymentPriceEuropcar">{$objFunctions->numberFormat($totalFinalPrice.price)} {$totalFinalPrice.unit}</i></span>
                    </div>

                </div>
            </div>
            {if $totalFinalPrice.status eq false}
                <div class="btn-final-confirmation">
                    <a class="s-u-check-step s-u-select-flight-change s-u-submit-passenger-Buyer txt15 lh40 site-main-button-color"
                       onclick="backToResultEuropcarLocal('{$sourceStationId}', '{$destStationId}', '{$getCarDateTime}', '{$returnCarDateTime}')"> ##Return##  </a>
                </div>
            {/if}
        </div>
        <div class="clear"></div>


        {if $totalFinalPrice.status eq true}

            <input type="hidden" id="idCar" name="idCar" value="{$idCar}">
            <input type="hidden" id="sourceStationId" name="sourceStationId" value="{$sourceStationId}">
            <input type="hidden" id="destStationId" name="destStationId" value="{$destStationId}">
            <input type="hidden" id="getCarDateTime" name="getCarDateTime" value="{$getCarDateTime}">
            <input type="hidden" id="returnCarDateTime" name="returnCarDateTime" value="{$returnCarDateTime}">
            <input type="hidden" id="typeApplication" name="typeApplication" value="{$typeApplication}">
            <input type="hidden" name="ZoneFlight" id="ZoneFlight" value="Local">

            <input type="hidden" id="allThingsId" name="allThingsId" value="{$objResult->allThingsId}">
            <input type="hidden" id="paymentsPriceCar" name="paymentsPriceCar" value="{$objFactor->carBookingInfo['PriceEachDayRial']}">
            <input type="hidden" id="paymentsPrice" name="paymentsPrice" value="{$objFactor->carBookingInfo['PriceEachDayRial']}">
            <input type="hidden" id="selectThingsId" name="selectThingsId" value="">
            <input type="hidden" id="selectThingsCount" name="selectThingsCount" value="">
            <input type="hidden" value="" name="IdMember" id="IdMember">


            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 s-u-passenger-wrapper-change  " style="padding: 0">
                <div class="s-u-result-wrapper">
                    <div class="s-u-result-item-change direcR iranR txt12 txtRed s-u-result-item-RulsCheck">
                        <div style="text-align: right">
                            {assign var="serviceType" value="LocalEuropcar"} {* لازم برای انتخاب نوع بانک *}
                            {if $objSession->IsLogin() && $objMember->list['fk_counter_type_id'] =='5'}
                                <div class="s-u-result-item-RulsCheck-item">
                                    <input class="FilterHoteltype Show_all FilterHoteltypeName-top" id="discount_code" name="" value=""   type="checkbox">
                                    <label class="FilterHoteltypeName site-main-text-color-a  " for="discount_code" >##Ihavediscountcodewantuse##</label>

                                    <div class="col-sm-12  parent-discount displayiN ">
                                        <div class="row separate-part-discount">
                                            <div class="col-sm-6 col-xs-12">
                                                <label for="discount-code">##Codediscount## :</label>
                                                <input type="text" id="discount-code" class="form-control" >
                                            </div>
                                            <div class="col-sm-2 col-xs-12">
                                        <span class="input-group-btn">
                                            <input type="hidden" name="priceWithoutDiscountCode" id="priceWithoutDiscountCode" value="{$totalFinalPrice.price}" />
                                            <button type="button" onclick="setDiscountCode('{$serviceType}', '{$CurrencyCode}')" class="site-secondary-text-color site-main-button-flat-color iranR discount-code-btn">بررسی و اعمال کد  </button>
                                        </span>
                                            </div>
                                            <div class="col-sm-4 col-xs-12">
                                                <span class="discount-code-error"></span>
                                            </div>
                                        </div>
                                        <div class="row separate-part-discount">
                                            <div class="info-box__price info-box__item pull-left">
                                                <div class="item-discount">
                                                    <span class="item-discount__label">##Amountpayable## :</span>
                                                    <span class="price__amount-price price-after-discount-code">{$objFunctions->numberFormat($totalFinalPrice.price)}</span>
                                                    <span class="price__unit-price">{$totalFinalPrice.unit}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            {/if}
                            <p class="s-u-result-item-RulsCheck-item">
                                <input class="FilterHoteltype Show_by_filters FilterHoteltypeName-top" id="RulsCheck" name="heck_list1" value="" type="checkbox">
                                <label class="FilterHoteltypeName site-main-text-color-a " for="RulsCheck">
                                    <a class="txtRed" href="{$smarty.const.URL_RULS}" target="_blank">##Seerules## </a> ##IhavestudiedIhavenoobjection##
                                </label>
                            </p>
                        </div>
                    </div>
                </div>
            </div>


            <div class="btn-final-confirmation" id="btn-final-Reserve">
                <a href="" onclick="return false" class="f-loader-check loaderfactors"  id="loader_check" style="display:none"></a>
                <a class="s-u-check-step s-u-select-flight-change s-u-submit-passenger-Buyer txt15 lh40 site-main-button-color" id="final_ok_and_insert_passenger"
                   onclick="reserveCarTemprory('{$smarty.post.factorNumber}')">##Approvefinal##  </a>
            </div>
            <div id="messageBook" class="error-flight"></div>

        {/if}

    </div>

{/if}


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

    {assign var="bankInputs" value=['flag' => 'check_credit_car', 'factorNumber' => $smarty.post.factorNumber, 'typeTrip' => 'carLocal', 'serviceType' => $serviceType]}
    {assign var="bankAction" value="`$smarty.const.ROOT_ADDRESS`/goBankEuropcarLocal"}

    {assign var="creditInputs" value=['flag' => 'buyByCreditCarLocal', 'factorNumber' => $smarty.post.factorNumber]}
    {assign var="creditAction" value="`$smarty.const.ROOT_ADDRESS`/returnBankEuropcarLocal"}

    {assign var="currencyPermition" value="0"}
    {if $smarty.const.ISCURRENCY && $CurrencyCode > 0}
        {$currencyPermition = "1"}
        {assign var="currencyInputs" value=['flag' => 'check_credit_car', 'factorNumber' => $smarty.post.factorNumber, 'typeTrip' => 'carLocal', 'serviceType' => $serviceType, 'amount' => $totalFinalPrice.price, 'currencyCode' => $CurrencyCode]}
        {assign var="currencyAction" value="`$smarty.const.ROOT_ADDRESS`/returnBankEuropcarLocal"}
    {/if}

    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`paymentMethods.tpl"}
    <!-- payment methods drop down -->


</div>


{literal}
<script src="assets/js/html5gallery.js"></script>
<script src="assets/js/jquery.fancybox.min.js"></script>
<script src="assets/js/script.js"></script>
<script src="assets/js/jdate.min.js" type="text/javascript"></script>
<script src="assets/js/jdate.js" type="text/javascript"></script>
<script src="assets/js/jquery.counter.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/js/modal-login.js"></script>
<script type="text/javascript">

    $(document).ready(function() {

        $(this).find(".closeBtn").click(function () {

            $(".price-Box").removeClass("displayBlock");
            $("#lightboxContainer").removeClass("displayBlock");
        });
        $("div#lightboxContainer").click(function () {

            $(".price-Box").removeClass("displayBlock");
            $("#lightboxContainer").removeClass("displayBlock");
        });

        $("div#lightboxContainer").click(function () {

            $(".Cancellation-Box").removeClass("displayBlock");
            $("#lightboxContainer").removeClass("displayBlock");
        });

        $("div#lightboxContainer").click(function () {
            $(".last-p-popup").css("display", "none");
        });

    });
</script>

{/literal}

