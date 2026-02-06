<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css" />
{load_presentation_object filename="passengersDetailLocal" assign="objDetail"}
{load_presentation_object filename="resultTourLocal" assign="objResult"}
{load_presentation_object filename="reservationTour" assign="objTour"}
{assign var="showTourToman" value = $objFunctions->isEnableSetting('toman')}
{if $showTourToman}
    {assign var="iranCurrency" value=$objFunctions->Xmlinformation('toman')}
{else}
    {assign var="iranCurrency" value=$objFunctions->Xmlinformation('Rial')}
{/if}
{$objDetail->getCustomers()}   {*گرفتن اطلاعات مربوط به مسافران هر مشتری*}

<span id="SOFTWARE_LANG_SPAN" data-lang="{$smarty.const.SOFTWARE_LANG}" class="d-none"></span>

{if $smarty.const.SOFTWARE_LANG === 'en'}
    {assign var="countryTitleName" value="titleEn"}
{else}
    {assign var="countryTitleName" value="titleFa"}
{/if}

{if isset($smarty.post.factor_number)}
    {assign var="FactorNumber" value=$smarty.post.factor_number}
{else}
    {assign var="FactorNumber" value=$objResult->getFactorNumber()}
{/if}

{assign var="priceChanged" value=$objTour->getRequestPriceChanged($FactorNumber)}


{assign var="date" value="|"|explode:$smarty.post.selectDate}

{assign var="infoTour" value=$objTour->infoTourByDate($smarty.post.tourCode, $date[0],$smarty.post.typeTourReserve)}

{$objResult->getInfoTourByIdTour($infoTour['id'])}



{assign var="array_package" value=[]}


    {assign var="hotels" value=$objTour->infoTourHotelByIdPackage($smarty.post.packageId)}


    {foreach from=$hotels item=hotel key=hotel_key}
        {assign var="hotel_information" value=$objTour->getHotelInformation($hotel['fk_hotel_id'])}
        {assign var="tour_route_information" value=$objTour->infoTourRoutByIdPackage($infoTour['id'], $hotel['fk_city_id'])}

        {$array_package['hotels'][$hotel_key] = $hotel_information}
        {$array_package['hotels'][$hotel_key]['night'] = $tour_route_information[0]['night']}
        {$array_package['hotels'][$hotel_key]['room_service'] = $tour_route_information[0]['room_service']}
    {/foreach}



  {if $smarty.const.SOFTWARE_LANG eq 'fa'}
    {assign var="index_name" value='name'}
    {assign var="index_name_tag" value='name_fa'}
    {assign var="index_city" value='city_name'}
{else}
    {assign var="index_name" value='name_en'}
    {assign var="index_name_tag" value='name_en'}
    {assign var="index_city" value='city_name_en'}
{/if}


        {assign var="cities" value=[]}

{foreach $objResult->arrayTour['infoTourRout'] as $item}
        {$cities[]=$item[$index_name]}

{/foreach}


{if $smarty.post.typeTourReserve eq 'noOneDayTour'}

 {assign var="arrayTourPackage" value=$objResult->setInfoReserveTourPackage($smarty.post.packageId, $smarty.post.countRoom)}

{/if}

{assign var="arrayTypeVehicle" value=$objResult->getTypeVehicle($infoTour['id'])}
{if $infoTour['prepayment_percentage'] neq 0}
    {assign var="paymentStatusValue" value='prePayment'}
{else}
    {assign var="paymentStatusValue" value='fullPayment'}
{/if}

{load_presentation_object filename="currencyEquivalent" assign="objCurrency"}

<div class="">
    <form style="margin: 0 -10px" method="post" id="requestForm" action="{$smarty.const.ROOT_ADDRESS}/factorRequest"
          enctype="multipart/form-data">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding ">

        <div class="hotel-booking-room s-u-passenger-wrapper-change">
                <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                    <i class="fa fa-car" aria-hidden="true"></i>
                    ##Bookingfollowingtour##
                </span>

            <div class="col-md-3 col-xs-12 nopad">
                <div class="hotel-booking-room-image" style="height: 181px;">
                    <a>
                        <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$infoTour['tour_pic']}"
                             alt="{$infoTour['tour_name']}">
                    </a>
                </div>
            </div>

            <div class="col-md-9 col-xs-12 hotel-reserve-room-content-par">
                <div class="hotel-booking-room-content">
                    <div class="hotel-booking-room-text">
                        <div class="names_tour_reserve">
                            <span class="hotel-booking-room-name">
                            {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                {$infoTour['tour_name']}
                            {else}
                                {$infoTour['tour_name_en']}
                            {/if}
                                 ({$infoTour['tour_code']})
                            </span>

                            <span class="hotel-booking-room-name car-booking-price">
                                <span class="d-flex flex-wrap">
                                         ##Price## :
                                    <i>
                                            {if $smarty.post.typeTourReserve neq 'oneDayTour'}
                                                 {assign var="total_price" value= ($arrayTourPackage['total_price_package'] )}
                                            {else}
                                                 {assign var="total_price" value= ($smarty.post.totalPrice)}
                                            {/if}


                                        {$total_price|number_format:0:".":","}
                                    </i> {$iranCurrency}
                                </span>
                                {if $infoTour['prepayment_percentage'] neq 0}
                                            {if $smarty.post.typeTourReserve neq 'oneDayTour'}
                                                  {assign var="prePaymentPrice" value=$objResult->prePaymentCalculate($arrayTourPackage['total_price_package'] , $infoTour['prepayment_percentage'])}
                                            {else}
                                                 {assign var="prePaymentPrice" value=$objResult->prePaymentCalculate($smarty.post.totalPrice)}
                                            {/if}

                                    <span class="d-flex flex-wrap mt-3">
                                         ##Prereserve## :
                                    <i>
                                            {$prePaymentPrice|number_format:0:".":","}
                                    </i> {$iranCurrency}
                                </span>
                                {/if}

                                {if $priceChanged neq 0}
                                        ##IncreasePrice## : {$priceChanged|number_format}

                                        <span class="d-flex flex-wrap mt-3">
                                        {$iranCurrency} :
                                        <i>
                                            {assign var="changedPrePaymentPrice" value=$prePaymentPrice}
                                            {$changedPrePaymentPrice|number_format:0:".":","}
                                        </i>{$iranCurrency}

                                    {/if}

                            </span>

                        </div>

                        <div class="hotel-result-item-rule hotel-result-item-rule_1 hotel-result-item-rule_1 ">
                            <p>
                                <i class="fa fa-check site-main-text-color"></i>
                                {$infoTour['tour_type']}

                            </p>
                            <p>
                                <i class="fa fa-check site-main-text-color"></i>
                                {if $infoTour['night'] neq 0}{$infoTour['night']} ##Night## {else} {$infoTour['day']} ##Day## {/if}
                            </p>



                                      <p>
                                        <i class="fa fa-check site-main-text-color"></i>
                                        {if $smarty.const.SOFTWARE_LANG === 'en'}
                                            {$objFunctions->vehicleEnName($objResult->arrayTour['arrayTypeVehicle']['dept']['type_vehicle_name'])}
                                        {else}
                                            {$objResult->arrayTour['arrayTypeVehicle']['dept']['type_vehicle_name']}
                                        {/if}



                                        : {$objResult->arrayTour['arrayTypeVehicle']['dept']['airline_name']}
                                    </p>

                                    <p>
                                        <i class="fa fa-check site-main-text-color"></i>
                                        {if $smarty.const.SOFTWARE_LANG === 'en'}
                                            {$objFunctions->vehicleEnName($objResult->arrayTour['arrayTypeVehicle']['return']['type_vehicle_name'])}
                                        {else}
                                            {$objResult->arrayTour['arrayTypeVehicle']['return']['type_vehicle_name']}
                                        {/if}



                                        : {$objResult->arrayTour['arrayTypeVehicle']['return']['airline_name']}
                                    </p>


                            <p>
                                <i class="fa fa-check site-main-text-color"></i>##Special## {$infoTour['tour_reason']}
                            </p>
                            <p>
                                <i class="fa fa-check site-main-text-color"></i>##Permissibleamount##
                                : {if $infoTour['free'] gt 0 } {$infoTour['free']} ##Kg## {else} - {/if}
                            </p>
                            <p>
                                <i class="fa fa-check site-main-text-color"></i>##Visa##: {if $infoTour['visa'] eq 'yes'}##Have##{else}##Donthave##{/if}
                            </p>
                            <p>
                                <i class="fa fa-check site-main-text-color"></i>##Insurance##: {if $infoTour['insurance'] eq 'yes'}##Have##{else}##Donthave##{/if}
                            </p>
                        </div>


                    </div>


                    <div class="hotel-booking-room-text">
                        <ul>
                            <li class="car-check-text "><i class="fa fa-map-marker"></i> ##ToursOfCity## :
                                <span class="hotel-check-date" dir="rtl">{$cities|join:', '}</span>
                            </li>
                            <li class="car-check-text"><i class="fa fa-calendar-check-o"></i> ##Wentdate## :
                                <span class="hotel-check-date" dir="rtl">{$date[0]}</span>
                            </li>
                            <li class="car-check-text"><i class="fa fa-calendar-check-o"></i> ##Returndate## :
                                <span class="hotel-check-date" dir="rtl">{$date[1]}</span>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
            <div class="hotel-booking-room " style="margin: 10px 15px">

                <input type="hidden" id="typeTourReserve" name="typeTourReserve"
                       value="{$smarty.post.typeTourReserve}">
                <input type="hidden" name="discountType" id="discountType" value="{$smarty.post.discountType}">
                <input type="hidden" name="discount" id="discount" value="{$smarty.post.discount}">

                {if $smarty.post.typeTourReserve eq 'noOneDayTour'}

                {assign var="arrayTourPackage" value=$objResult->setInfoReserveTourPackage($smarty.post.packageId, $smarty.post.countRoom)}
                <input type="hidden" id="packageId" name="packageId" value="{$smarty.post.packageId}">
                <input type="hidden" id="countRoom" name="countRoom" value="{$smarty.post.countRoom}">
                <input type="hidden" id="currencyTitleFa" name="currencyTitleFa"
                       value="{$smarty.post.currencyTitleFa}">

                <div class="table-striped">
                    <div class="divTable table-responsive">

                        <div class="divTableHeading s-u-last-p-bozorgsal-change site-main-text-color">
                            <div class="divTableRow">
                                <div class="divTableHead">
                                    <div class="">##PackageHotels##</div>
                                </div>
                                {foreach $arrayTourPackage['infoRooms'] as $val}
                                    <div class="divTableHead">{$val['name_fa']}</div>
                                {/foreach}
                            </div>
                        </div>


                        <div class="divTableBody">

                            <div class="divTableRow">
                                <div class="divTableCell">
                                 {foreach $array_package['hotels'] as $hotel}

                                        <div class="rounded clearfix col-12 col-xs-12 my-11 px-21 packageinfo">
                                            <a class="mb-0 col-xs-6">{$hotel[$index_name]}
                                                <i>({$hotel[$index_city]})</i>
                                            </a>
                                            <div class="d-flex col-md-12 col-xs-6 px-0 py-1 p-1245">

                                                <div class="d-inline">
                                                    <div class="d-inline-block pagination__dot ltr hotelGrade "
                                                         data-tooltip="{$hotel['star_code']} ##Star##"
                                                         title="{$hotel['star_code']} ##Star##">
                                                        {for $s=1 to $hotel['star_code']}
                                                            <i class="fa fa-star orange-text"></i>
                                                        {/for}
                                                        {for $ss=$s to 5}
                                                            <i class="fa fa-star-o orange-text"></i>
                                                        {/for}
                                                    </div>
                                                </div>
                                                <span class=hidden-xs">

                                                    <label class="room_service_1 ">({$hotel['room_service']})</label>
                                                </span>
                                            </div>

                                        </div>
                                    {/foreach}
                                </div>

                                {foreach $arrayTourPackage['infoRooms'] as $room}
                                    <div class="divTableCell">
                                        <p>##Price##:
                                            <label class=""
                                                   style="display: inline-block">
                                                   {if $showTourToman}
                                                    {round($room['total_price']/10)|number_format:0:".":","}
                                                   {else}
                                                    {$room['total_price']|number_format:0:".":","}
                                                   {/if}


                                                {$iranCurrency}</label>
                                            {if $room['price_a'] gt 0}
                                                +
                                                <label class="green-text"
                                                       style="display: inline-block">{$room['total_price_a']|number_format}


                                        {if $smarty.const.SOFTWARE_LANG neq 'fa'}
                                            {$objFunctions->changeCurrencyName($room['currency_type'])}
                                        {else}
                                            {$room['currency_type']}
                                        {/if}
                                          </label>
                                            {/if}
                                        </p>

                                        <p>##Count##:
                                            <label class="green-text"
                                                   style="display: inline-block">{$room['count']}</label>
                                        </p>
                                    </div>
                                {/foreach}
                            </div>

                        </div>

                    </div>
                    <p></p>
                    {elseif $smarty.post.typeTourReserve eq 'oneDayTour'}

                    {assign var="discount_counter" value=$objResult->getDiscountCounterOneDayTour(['id_same'=>$infoTour['id_same']])}

                    <div class="table-striped">
                        <div class="divTable">

                            <div class="divTableHeading ">
                                <div class="divTableRow">
                                    <div class="divTableHead">
                                        <div class="name-city-rout">##Onetour##</div>
                                    </div>
                                    {if $smarty.post.passengerCountADT gt 0}
                                        <div class="divTableHead">##Adult##</div>
                                    {/if}
                                    {if $smarty.post.passengerCountCHD gt 0}
                                        <div class="divTableHead">##Child##</div>
                                    {/if}
                                    {if $smarty.post.passengerCountINF gt 0}
                                        <div class="divTableHead">##Baby##</div>
                                    {/if}
                                </div>
                            </div>


                            <div class="divTableBody">
                                <div class="divTableRow">
                                    <div class="divTableCell">
                                        <div>##Numberpeoplandprice##</div>
                                    </div>
                                    {if $smarty.post.passengerCountADT gt 0}
                                        <div class="divTableCell">
                                            <p>##Price##:
                                                {assign var="price_adult" value=((($infoTour['adult_price_one_day_tour_r'] + $infoTour['change_price']) - $discount_counter['adult_amount'] ) * $smarty.post.passengerCountADT)}
                                                <label class="green-text"
                                                       style="display: inline-block">{$price_adult|number_format:0:".":","} + {$infoTour['adult_price_one_day_tour_a'] * $smarty.post.passengerCountADT}({$infoTour['currency_type_one_day_tour']})</label>
                                            </p>

                                            <p>##Count##:
                                                <label class="green-text"
                                                       style="display: inline-block">{$smarty.post.passengerCountADT}</label>
                                            </p>
                                        </div>
                                    {/if}
                                    {if $smarty.post.passengerCountCHD gt 0}
                                        <div class="divTableCell">
                                            <p>##Price##:
                                                {assign var="price_child" value=((($infoTour['child_price_one_day_tour_r']+ $infoTour['change_price']) - $discount_counter['child_amount']) * $smarty.post.passengerCountCHD) }
                                                <label class="green-text"
                                                       style="display: inline-block">{$price_child|number_format:0:".":","} + {$infoTour['child_price_one_day_tour_a'] * $smarty.post.passengerCountCHD}({$infoTour['currency_type_one_day_tour']})</label>
                                            </p>

                                            <p>##Count##:
                                                <label class="green-text"
                                                       style="display: inline-block">{$smarty.post.passengerCountCHD}</label>
                                            </p>
                                        </div>
                                    {/if}
                                    {if $smarty.post.passengerCountINF gt 0}
                                        <div class="divTableCell">
                                            <p>##Price##:
                                                {assign var="price_infant" value=((($infoTour['infant_price_one_day_tour_r'] + $infoTour['change_price'])- $discount_counter['child_amount'] )  * $smarty.post.passengerCountINF)}
                                                <label class="green-text"
                                                       style="display: inline-block">{$price_infant|number_format:0:".":","} + {$infoTour['infant_price_one_day_tour_a'] * $smarty.post.passengerCountINF}({$infoTour['currency_type_one_day_tour']})</label>
                                            </p>

                                            <p>##Count##:
                                                <label class="green-text"
                                                       style="display: inline-block">{$smarty.post.passengerCountINF}</label>
                                            </p>
                                        </div>
                                    {/if}
                                </div>

                            </div>


                        </div>
                          <input type="hidden" id="adultPriceOneDayTourR" name="adultPriceOneDayTourR" value="{$price_adult}">
                    <input type="hidden" id="adultCountOneDayTour" name="adultCountOneDayTour"
                           value="{$smarty.post.passengerCountADT}">
                    <input type="hidden" id="childPriceOneDayTourR" name="childPriceOneDayTourR"
                           value="{$price_child}">
                    <input type="hidden" id="childCountOneDayTour" name="childCountOneDayTour"
                           value="{$smarty.post.passengerCountCHD}">
                    <input type="hidden" id="infantPriceOneDayTourR" name="infantPriceOneDayTourR"
                           value="{$price_infant}">
                    <input type="hidden" id="infantCountOneDayTour" name="infantCountOneDayTour"
                           value="{$smarty.post.passengerCountINF}">
                    </div>

                    {/if}


                </div>

            </div>
        </div>

            {for $nPassenger=1 to $smarty.post.passengerCount}

                {if $nPassenger le $smarty.post.passengerCountADT}
                    {assign var="passengerAge" value="adt"}
                    {assign var="classNameBirthdayShamsi" value="shamsiAdultBirthdayCalendar"}
                    {assign var="classNameBirthdayMiladi" value="gregorianAdultBirthdayCalendar"}
                {elseif $nPassenger gt $smarty.post.passengerCountADT && $nPassenger le $smarty.post.passengerCountADT + $smarty.post.passengerCountCHD}
                    {assign var="passengerAge" value="chd"}
                    {assign var="classNameBirthdayShamsi" value="shamsiChildBirthdayCalendar"}
                    {assign var="classNameBirthdayMiladi" value="gregorianChildBirthdayCalendar"}
                {elseif $nPassenger gt $smarty.post.passengerCountCHD && $nPassenger le $smarty.post.passengerCountADT + $smarty.post.passengerCountCHD + $smarty.post.passengerCountINF}
                    {assign var="passengerAge" value="inf"}
                    {assign var="classNameBirthdayShamsi" value="shamsiInfantBirthdayCalendar"}
                    {assign var="classNameBirthdayMiladi" value="gregorianInfantBirthdayCalendar"}
                {else}
                    {assign var="classNameBirthdayMiladi" value="gregorianAdultBirthdayCalendar"}
                {/if}

                <input type="hidden" id="numberRow" value="{$nPassenger}">
                <input type="hidden" name="passengerAge{$nPassenger}" id="passengerAge{$nPassenger}"
                       value="{$passengerAge}">

                            <div class="clear"></div>


                        </div>
                    </div>
                    <div class="clear"></div>


                </div>
            {/for}


            {if not $objSession->IsLogin()}

            {/if}

            <input type="hidden" id="idTour" name="idTour" value="{$infoTour['id']}">
            <input type="hidden" id="prepayment_percentage" name="prepayment_percentage"
                   value="{$infoTour['prepayment_percentage']}">
            <input type="hidden" id="paymentStatus" name="paymentStatus" value="{$paymentStatusValue}">
            <input type="hidden" id="passengerCount" name="passengerCount" value="{$smarty.post.passengerCount}">
            <input type="hidden" id="cities" name="cities" value="{$smarty.post.cities}">
            <input type="hidden" id="serviceTitle" name="serviceTitle" value="{$smarty.post.serviceTitle}">
            <input type="hidden" id="startDate" name="startDate" value="{$date[0]}">
            <input type="hidden" id="endDate" name="endDate" value="{$date[1]}">
            <input type="hidden" id="totalPriceA" name="totalPriceA" value="{$smarty.post.totalPriceA}">
            <input type="hidden" id="totalPrice" name="totalPrice" value="{$smarty.post.totalPrice}">
            <input type="hidden" id="totalOriginPrice" name="totalOriginPrice" value="{$smarty.post.totalOriginPrice}">
            <input type="hidden" id="paymentPrice" name="paymentPrice" value="{$smarty.post.paymentPrice}">
            <input type="hidden" id="factorNumber" name="factorNumber" value="{$FactorNumber}">

            <input type="hidden" name="typeApplication" id="typeApplication" value="reservation">
            {if $smarty.const.GDS_SWITCH !=  'passengerDetailReservationTour' }
                <input type="hidden" name="idMember" id="idMember" value="">
            {/if}



    </form>
</div>