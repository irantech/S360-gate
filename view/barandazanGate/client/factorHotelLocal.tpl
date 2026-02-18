<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css"/>
{load_presentation_object filename="factorHotelLocal" assign="objFactor"}
{load_presentation_object filename="resultHotelLocal" assign="objResult"}
<!-- can't submit refresh -->
{$objFactor->statusRefresh()}

{load_presentation_object filename="members" assign="objMember"}
{$objMember->get()}


{**اضافه کردن اطلاعات مسافران به جدول و گرفتن اطلاعات مربوط به مسافران**}
{if $smarty.post.typeApplication eq 'reservation'}
    {$objFactor->registerPassengersReservationHotel()}
    {$listOneDayTour = $objResult->getInfoReserveOneDayTour($smarty.post.factorNumber)}
{else}
    {$objFactor->registerPassengersHotel()}
{/if}

{if $objFactor->error eq true}
    <div class="s-u-content-result">
        <div id="lightboxContainer" class="lightboxContainerOpacity"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 s-u-passenger-wrapper-change ">
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

    {$objFactor->getPassengersHotel()}
    <div class="s-u-content-result">

        <div id="lightboxContainer" class="lightboxContainerOpacity"></div>



        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 s-u-passenger-wrapper-change">
            {if $objFactor->temproryHotel['prepayment_percentage'] neq 0}
                {*                {$objFactor->temproryHotel['prepayment_percentage']}aaaaaaaaaaaa*}
                {assign var="paymentStatusValue" value='prePayment'}
            {else}
                {assign var="paymentStatusValue" value='fullPayment'}
                {*                {$objFactor->temproryHotel['prepayment_percentage']}bbbbbbbbb*}
            {/if}
            <input type="hidden" name="typeApplication" id="typeApplication"
                   value="{$objFactor->temproryHotel['type_application']}">

            <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
            <i class="zmdi zmdi-account-box-mail zmdi-hc-fw mart10"></i> ##Invoice##
                {*<i class="ravis-icon-hotel zmdi-hc-fw mart10"></i> {$objFactor->temproryHotel['hotel_name']}*}
        </span>

            <div class="hotel-booking-room marb0">

                <div class="col-md-3 nopad">

                    {if $objFactor->temproryHotel['type_application'] eq 'reservation'}
                        <div class="ribbon-special-hotel"><span><i> ##Specialhotel## </i></span></div>
                    {/if}

                    <div class="hotel-booking-room-image">
                        <a>
                            <img src="{$objFactor->temproryHotel['hotel_pictures']}" alt="hotel-image">
                        </a>
                    </div>
                </div>

                <div class="col-md-9 pl-0 ">
                    <div class="hotel-booking-room-content">
                        <div class="hotel-booking-room-text">
                            <b class="hotel-booking-room-name"> {$objFactor->temproryHotel['hotel_name']} </b>

                            <span class="hotel-star">
                        {for $s=1 to $objFactor->temproryHotel['hotel_starCode']}
                            <i class="fa fa-star" aria-hidden="true"></i>
                        {/for}
                                {for $ss=$s to 5}
                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                {/for}
                        </span>

                            <span class="hotel-booking-room-content-location ">
                          {$objFactor->temproryHotel['hotel_address']}
                       </span>
                            <!--                            <p class="hotel-booking-roomm-description hotel-result-item-rule">
                                <span class="fa fa-bell-o"></span>
                                {$objFactor->temproryHotel['hotel_rules']}
                            </p>-->
                        </div>

                        <div class="hotel-booking-room-text">
                            <ul>
                                <li class="hotel-check-text"><i class="fa fa-calendar-times-o"></i> ##Enterdate## :
                                    <span class="hotel-check-date"
                                          dir="rtl">{$objFactor->temproryHotel['start_date']}</span></li>
                                <li class="hotel-check-text"><i class="fa fa-calendar-check-o"></i> ##Exitdate## :
                                    <span class="hotel-check-date"
                                          dir="rtl">{$objFactor->temproryHotel['end_date']}</span></li>
                                <li class="hotel-check-text"><i
                                            class="fa fa-bed"></i> {$objFactor->temproryHotel['number_night']} ##Night##
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>


            <div class="clear"></div>
            <div class="hotel-booking-room">

                <h4 class="tableOrderHeadTitle site-bg-main-color">
                    <span>##Listroom##</span>
                </h4>

                <div class="table-responsive ov position-relative room_table">

                    <div class="table_hotel_nz">
                        <div class="thead_hotel">
                            <div class="tr_hotel">
                                <div class="th_hotel">##Specifications##</div>
                                <div  class="th_hotel hidden-xs">##Service##</div>
                                <div  class="th_hotel">##Price##</div>
                            </div>
                        </div>
                        <div class="tbody_hotel">

                            {assign var="TotalPrice" value=""}
                            {foreach  $objFactor->temproryHotel['room'] as $i=>$room}

                                {$TotalPrice = $TotalPrice + $room['room_price']}

                                <div class="tr_hotel hotel_room_row">
                                    <div class="th_hotel">
                                        {assign var="everyNightCurrency" value=$objFunctions->CurrencyCalculate($room.price_current, $smarty.post.CurrencyCode)}
                                        {if $everyNightCurrency gt 0 AND $objFactor->temproryHotel.number_night gt 0}
                                            <div class="box_pricees">
                                                <div class="detail_room_hotel detail_room_hotel_new">
                                                    {for $night_number =0; $night_number < $objFactor->temproryHotel.number_night; $night_number++}
                                                        {assign var='night_date' value=$objFunctions->DateAddDay($smarty.post.startDate_reserve,$night_number)}
                                                        <div class="details">
                                                            <div class="AvailableSeprate site-bg-main-color site-bg-color-border-right-b ">{$night_date}</div>
                                                            <div class="seprate">
                                                                        <span><b>{$room['price_current']|number_format}</b>##Rial## <i class="fa fa-male checkIcon"></i>
                                                                            <span class="tooltip-price">##Adult##</span>
                                                                        </span>
                                                                {if $room.TotalPriceBedEXT gt 0 AND $room.ExtraBedCount gt 0}
                                                                    <span><b>{$room.TotalPriceBedEXT|number_format}</b>##Rial## <i class="fa fa-bed checkIcon"></i>
                                                                    <span class="tooltip-price">##Extrabed##</span>
                                                                </span>
                                                                {/if}
                                                                {if $room.TotalPriceBedCHD gt 0 AND $room.ExtraChildBedCount gt 0}
                                                                    <span><b>{$room.TotalPriceBedCHD|number_format}</b>##Rial## <i class="fas fa-baby-carriage"></i>
                                                                    <span class="tooltip-price">##Child##</span>
                                                                </span>
                                                                {/if}
                                                            </div>
                                                        </div>
                                                    {/for}
                                                </div>
                                            </div>
                                        {/if}
                                        <span class="roomsTitle  extra-title-bed">{$room['room_name']}</span>
                                        <div class="rooms-element d-flex justify-content-center  extra-title-bed"">
                                            {$objFunctions->StrReplaceInXml(['@@count@@'=>{$room['room_count']}],'RoomCountNumber')}
                                        </div>
                                        {if $room.child_room_count gt 0}
                                            <div class="extra-bed-element d-flex justify-content-center extra-title-bed">
                                                <div class="extra-bed-count">
                                                    <span class='d-flex mx-1' >
                                                        {$room['child_room_count']}
                                                    </span>
                                                </div>
                                                <span class="extra-bed-title">
                                                    ##HotelExtraChild##
                                                </span>
                                            </div>
                                        {/if}

                                        {if $room['extra_bed_count'] gt 0}
                                            <div class="extra-bed-element d-flex justify-content-center extra-title-bed">
                                                <div class="extra-bed-count">
                                                    <span class='d-flex mx-1' >
                                                        {$room['extra_bed_count']}
                                                    </span>
                                                </div>
                                                <span class="extra-bed-title">
                                                  ##HotelExtraBed##
                                                </span>
                                            </div>
                                        {/if}
                                        <input type="hidden" name="RoomCount{$room['room_id']}" id="RoomCount{$room['IdRoom']}" value="{$room['room_count']}">
                                    </div>
                                    <div class="th_hotel hidden-xs">
                                        <ul class="HotelRoomFeatureList">
                                            {if $room.Dinner neq 'yes' and $room.Breakfast neq 'yes' and $room.Lunch neq 'yes' }
                                                ---
                                            {else}
                                                {if $room['Breakfast'] eq 'yes'}
                                                    <li class="Breakfast"><i class="fa fa-coffee"></i> ##Breakfast##</li>
                                                {/if}
                                                {if $room['Lunch'] eq 'yes'}
                                                    <li class="Breakfast"><i class="fa fa-cutlery"></i> ##Lunch##</li>
                                                {/if}
                                                {if $room['Dinner'] eq 'yes'}
                                                    <li class="Breakfast"><i class="fa fa-cutlery"></i> ##Dinner##</li>
                                                {/if}
                                            {/if}
                                        </ul>
                                    </div>

                                    <div class="th_hotel totalRoomCurrency_hotel">
                                        {assign var="totalRoomCurrency" value=$objFunctions->CurrencyCalculate($room['room_price'], $smarty.post.CurrencyCode)}
                                        <div class="extra-prices">
                                            {*
                                             {$objFunctions->numberFormat($totalRoomCurrency.AmountCurrency)}
                                             <i>{$totalRoomCurrency.TypeCurrency}</i>
                                             <span class=" plus_price_room" title="جزییات قیمت برای هر اتاق">
                                                 <i class="far fa-list-alt"></i>
                                             </span>*}
                                            <span class="extra-price-value">&nbsp;</span>
                                            <span class="extra-price-value">
                                                {math equation="x * y * z" x=$room.price_current y=$room.room_count z=$objFactor->temproryHotel.number_night assign=totalPrice}
                                                {$totalPrice|number_format}
                                                {$totalRoomCurrency.TypeCurrency}
                                            </span>
                                            {if $room['child_room_count'] > 0}
                                                <span class="extra-price-value">
                                                        {math equation="x * y * z" x=$room.child_room_price y=$room.child_room_count z=$objFactor->temproryHotel.number_night assign=totalPriceECHD}
                                                    {$totalPriceECHD|number_format}
                                                    {$totalRoomCurrency.TypeCurrency}
                                                    </span>
                                            {/if}
                                            {if $room['extra_bed_count'] > 0}
                                                <span class="extra-price-value">
                                                        {math equation="x * y * z" x=$room.extra_bed_price y=$room.extra_bed_count z=$objFactor->temproryHotel.number_night assign=totalPriceEXT}
                                                    {$totalPriceEXT|number_format}
                                                    {$totalRoomCurrency.TypeCurrency}
                                                    </span>
                                            {/if}

                                        </div>
                                    </div>
                                </div>

                            {/foreach}

                        </div>
                    </div>
                </div>
                <div class="DivTotalPrice ">
                    {assign var="paymentPriceCurrency" value=$objFunctions->CurrencyCalculate($objFactor->paymentPrice, $smarty.post.CurrencyCode)}
                    <div class="fltl">##Totalamount## :
                        <span>{$objFunctions->numberFormat($paymentPriceCurrency.AmountCurrency)}</span>
                        <i>{$paymentPriceCurrency.TypeCurrency}</i>
                    </div>
                    <div class="fltl">
                        <i>
                            {$objFactor->temproryHotel['prepayment_percentage']}
                        </i>
                        <i>%  ##PrePayment## :</i>
                        <i>{$objFunctions->numberFormat($objFactor->temproryHotel['hotel_payments_price'])}</i>
                        <i>{$paymentPriceCurrency.TypeCurrency}</i>

                    </div>
                </div>
            </div>

            {if $smarty.post.typeApplication eq 'reservation' && $listOneDayTour neq ''}
                <h4 class="tableOrderHeadTitle site-bg-main-color">
                    <span>##Onedayspatrollist##</span>
                </h4>
                <div class="rp-tableOrder site-border-main-color">
                    <table>
                        <thead>
                        <tr class="Hotel-tableOrderHead">
                            <th class="Hotel-tableOrderHead-c1">##Titletour##</th>
                            <th class="Hotel-tableOrderHead-c6">##TotalPrice## (##Rial##)</th>
                        </tr>
                        </thead>
                        <tbody>

                        {foreach  $listOneDayTour  as $val}
                            <tr>
                                <td class="Hotel-tableOrderHead">
                                    <h5 class="roomsTitle">{$val['title']}</h5>
                                </td>

                                <td class="Hotel-tableOrderHead">
                                    {assign var="roomFinalCurrency" value=$objFunctions->CurrencyCalculate($val['price'], $smarty.post.CurrencyCode)}
                                    <div class="roomFinalPrice ">{$objFunctions->numberFormat($roomFinalCurrency.AmountCurrency)} {$roomFinalCurrency.TypeCurrency}</div>
                                </td>
                            </tr>
                        {/foreach}

                        </tbody>
                    </table>
                </div>
            {/if}



        </div>

        <div class="clear"></div>


        <div class="main-Content-bottom Dash-ContentL-B">
            <div class="main-Content-bottom-table Dash-ContentL-B-Table">
                {if $objFactor->temproryHotel['passenger'][0]['passenger_name'] neq ''}
                    <div class="main-Content-bottom-table-Title Dash-ContentL-B-Title l-p-p-header l-p-p-header-change site-bg-main-color">
                        <i class="icon-table"></i>
                        <h3>##Listpassengers##</h3>
                    </div>
                    <div class="table-responsive">
                        <table id="passengers" class="display" cellspacing="0" width="100%">

                            <thead>
                            <tr>
                                <th>##Ages##</th>
                                <th>##Name##</th>
                                <th>##Nameenglish##</th>
                                <th>##Family##</th>
                                <th>##Familyenglish##</th>
                                <th>##Happybirthday##</th>
                                <th>##Numpassport##/##Nationalnumber##</th>
                            </tr>
                            </thead>
                            <tbody>

                            {foreach $objFactor->temproryHotel['passenger'] as $i=>$passenger}
                                <tr>
                                    <td>{$passenger['title_flat_type']}</td>
                                    <td>
                                        <p>{$passenger['passenger_name']}</p>
                                    </td>
                                    <td>
                                        <p>{$passenger['passenger_name_en']}</p>
                                    </td>
                                    <td>
                                        <p>{$passenger['passenger_family']}</p>
                                    </td>
                                    <td>
                                        <p>{$passenger['passenger_family_en']}</p>
                                    </td>
                                    <td>
                                        <p>{if !$passenger['passenger_birthday']} {$passenger['passenger_birthday_en']} {else} {$passenger['passenger_birthday']}{/if}</p>
                                    </td>
                                    <td>
                                        <p>{if $passenger['passenger_national_code'] eq ''}{$passenger['passportNumber']}{else}{$passenger['passenger_national_code']}{/if}</p>
                                    </td>
                                </tr>
                            {/foreach}

                            </tbody>


                        </table>
                    </div>
                {elseif $objFactor->temproryHotel['type_application'] eq 'reservation'}
                    <div class="main-Content-bottom-table-Title Dash-ContentL-B-Title l-p-p-header l-p-p-header-change site-bg-main-color">
                        <i class="icon-table"></i>
                        <h3>##TravelerGuard##</h3>
                    </div>
                    <div class="Dash-ContentL-Title-leader">
                        <span class="leaderRoom-Title">  ##Namefamily##  :</span>
                        <span class="leaderRoom">{$objFactor->temproryHotel['passenger_leader_fullName']}</span>
                        <span class="leaderRoom-Title">##Telephone## :</span>
                        <span class="leaderRoom">{$objFactor->temproryHotel['passenger_leader_tell']}</span>
                    </div>
                {/if}
            </div>
        </div>
    </div>
    <div class="clear"></div>

    <!--  برای رزرو یک اتاق یا بیشتر به صورت موقت، و بازگرداندن یک شماره درخواست و شماره ( پی ان آر ) برای اعمال دستورات بر روی این رزرو-->
    <input type="hidden" value="" name="RequestNumber" id="RequestNumber">
    <input type="hidden" value="" name="RequestPNR" id="RequestPNR">
    <input type="hidden" value="" name="total_price" id="total_price">
    <input type="hidden" name="paymentPrice" id="paymentPrice" value="{$objFactor->paymentPrice}">
    </div>
    <div class="clear"></div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 s-u-passenger-wrapper-change"
         style="padding: 0">
        <div class="s-u-result-wrapper">
            <div class="s-u-result-item-change direcR iranR txt12 txtRed s-u-result-item-RulsCheck">
                <div style="text-align: right">
                    {assign var="serviceType" value=$objFunctions->TypeServiceHotel($smarty.post.typeApplication)} {* لازم برای انتخاب نوع بانک *}
                    {if $objSession->IsLogin() && $objMember->list['fk_counter_type_id'] =='5'}
                        <div class="s-u-result-item-RulsCheck-item">
                            {*                            <input class="FilterHoteltype Show_all FilterHoteltypeName-top" id="discount_code" name=""*}
                            {*                                   value="" type="checkbox">*}
                            {*                            <label class="FilterHoteltypeName site-main-text-color-a" for="discount_code">##Ihavediscountcodewantuse##</label>*}

                            <div class="col-sm-12  parent-discount  ">
                                <div class="row separate-part-discount align-items-center">
                                    <div class="col-sm-6 col-xs-12">
                                        <label for="discount-code">##Codediscount## :</label>
                                        <input type="text" id="discount-code" class="form-control">
                                    </div>
                                    <div class="col-sm-2 col-xs-12 align-self-end">
                                    <span class="input-group-btn">
                                        <input type="hidden" name="priceWithoutDiscountCode"
                                               id="priceWithoutDiscountCode"
                                               value="{$paymentPriceCurrency.AmountCurrency}"/>
                                        <button type="button"
                                                onclick="setDiscountCode('{$serviceType}', '{$smarty.post.CurrencyCode}')"
                                                class="site-secondary-text-color site-main-button-flat-color iranR discount-code-btn">##Reviewapplycode##  </button>
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
                                            <span class="price__amount-price price-after-discount-code">{$objFunctions->numberFormat($paymentPriceCurrency.AmountCurrency)}</span>
                                            <span class="price__unit-price">{$paymentPriceCurrency.TypeCurrency}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {/if}
                    <div class="s-u-result-item-RulsCheck-item d-flex justify-content-between flex-sm-row flex-column">
                        <div class="d-flex">
                            <input class="FilterHoteltype Show_by_filters FilterHoteltypeName-top" id="RulsCheck"
                                   name="heck_list1" value="" type="checkbox">
                            <label class="FilterHoteltypeName site-main-text-color-a " for="RulsCheck">
                                <a class="txtRed" href="{$smarty.const.URL_RULS}" target="_blank">##Seerules## </a>
                                ##IhavestudiedIhavenoobjection##
                            </label>
                        </div>
                        <div class="btn-final-confirmation" id="btn-final-Reserve">
                            <div class="next_hotel__">
                                <a href="" onclick="return false" class="f-loader-check loaderfactors" id="loader_check"
                                   style="display:none"></a>
                                <a class="s-u-check-step s-u-select-flight-change s-u-submit-passenger-Buyer txt15 lh40 site-bg-main-color"
                                   id="final_ok_and_insert_passenger"
                                   onclick="ReserveTemprory('{$smarty.post.factorNumber}', '{$smarty.post.typeApplication}')">##Approvefinal## </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="timeConfirmHotel" id="timeConfirmHotel" value="">

    <div id="messageBook" class="error-flight"></div>
    <!-- OnRequest -->
    <div id="cancelHotel" class="displayN">
        <div class="main-cancel-box s-u-p-factor-bank s-u-p-factor-bank-change">
            <h4 class="site-bg-main-color site-bg-color-border-bottom site-main-button-flat-color">
                ##Cancelrequest##</h4>
            <div class="s-u-select-bank mart30">
                <span> ##Yourrequesthascanceledtolackof##</span>
                <span class="author"><i>##Youcanbookanotherhotel##</i></span>
            </div>
            <div class="s-u-select-update-wrapper">
                <a class="s-u-select-update s-u-select-update-change site-main-button-flat-color"
                   onclick="backToResultHotelLocal('{$objFactor->city}', '{$objFactor->startDate}', '{$objFactor->numberNight}')">
                    ##Anotherhotel## </a>
            </div>
        </div>
    </div>
    <div id="onRequestOnlinePassenger" class="displayN">
        <div class="Attention Attention-change">
            <div class="s-u-select-bank mart30 marb30 bg-yellow">
                <input type="hidden" name="factorNumber" id="factorNumber"
                       value="{$objFactor->temproryHotel['factor_number']}">
                <span class="author">
                    <i class="bg-yellow"> ##Dearguestsuccessfullyregisteredbooking##</i>
                </span>
                <div class="msg">
                <span class="box-offline-reserve offline-reserve-msg">
                    <span class="msg-time">
                       <div class="counter counter-analog" data-direction="down" data-format="59:59" data-stop="00:00"
                            style="direction: ltr">10:00</div>
                    </span>
                </span>
                    <span class="box-offline-reserve offline-factorNumber"> ##Invoicenumber##: {$objFactor->temproryHotel['factor_number']}</span>
                </div>
            </div>
        </div>
        <div class="btn-final-confirmation">
            <a class="s-u-check-step s-u-select-flight-change s-u-submit-passenger-Buyer txt15 lh40 site-main-button-color"
               onclick="backToResultHotelLocal('{$objFactor->city}', '{$objFactor->startDate}', '{$objFactor->numberNight}')">
                ##Return## </a>
        </div>
    </div>
    <div id="onRequest" class="displayN">
        <div class="Attention Attention-change">
            <div class="s-u-select-bank mart30 marb30 bg-yellow">
                <input type="hidden" name="factorNumber" id="factorNumber"
                       value="{$objFactor->temproryHotel['factor_number']}">
                <span class="author">
                <i class="bg-yellow"> ##Dearguestsuccessfullyregisteredbooking##</i>
            </span>
                <div class="msg">
                    <span class="box-offline-reserve offline-reserve-msg">##Usehotelshoppingpaymentbooking##</span>
                    <span class="box-offline-reserve offline-factorNumber"> ##Invoicenumber##: {$objFactor->temproryHotel['factor_number']}</span>
                </div>
            </div>
        </div>
        <div class="btn-final-confirmation">
            <a class="s-u-check-step s-u-select-flight-change s-u-submit-passenger-Buyer txt15 lh40 site-main-button-color"
               onclick="backToResultHotelLocal('{$objFactor->city}', '{$objFactor->startDate}', '{$objFactor->numberNight}')">
                ##Return## </a>
        </div>
    </div>
    <div id="confirmHotel" class="displayN">
        <div class="Attention Attention-change">
            <div class="s-u-select-bank mart30 marb30 bg-yellow">
                <span class="author">
                    <i class="alert alert-success"> ##Dearguestrequestapprovedbookingfee##</i>
                </span>


                <div>
                    <div class="msg">
                        <span class="box-offline-reserve offline-reserve-msg">
                            <span class="msg-time">
                                <div class="counter counter-analog" data-direction="down" data-format="59:59" data-stop="00:00"
                                     style="direction: ltr">10:00</div>
                            </span>
                        </span>
                        <span class="box-offline-reserve offline-factorNumber"> ##Invoicenumber##: {$objFactor->temproryHotel['factor_number']}</span>
                    </div>
                    <div class="s-u-check-tracking-code">
                        <p>
                            ##Usehotelshoppingpaymentbooking##
                        </p>
                        <a class="s-u-check-step s-u-select-flight-change s-u-submit-passenger-Buyer txt15 lh40 site-main-button-color"
                           href="{$smarty.const.ROOT_ADDRESS}/UserTracking">
                            ##TrackOrder## </a>
                    </div>
                </div>
            </div>
        </div>
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
        {if $objFactor->temproryHotel['hotel_payments_price']>0}
            {assign var="bankInputs" value=['flag' => 'check_credit_hotel', 'factorNumber' => $objFactor->temproryHotel['factor_number'], 'typeApplication' => $smarty.post.typeApplication, 'typeTrip' => 'hotelLocal', 'paymentPrice' => $objFactor->temproryHotel['hotel_payments_price'] , 'paymentStatus' => $paymentStatusValue, 'serviceType' => $serviceType]}
        {else}
            {assign var="bankInputs" value=['flag' => 'check_credit_hotel', 'factorNumber' => $objFactor->temproryHotel['factor_number'], 'typeApplication' => $smarty.post.typeApplication, 'typeTrip' => 'hotelLocal', 'paymentPrice' => $objFactor->paymentPrice , 'paymentStatus' => $paymentStatusValue, 'serviceType' => $serviceType]}
        {/if}
        {assign var="bankAction" value="`$smarty.const.ROOT_ADDRESS`/goBankHotelLocal"}

        {assign var="creditInputs" value=['flag' => 'buyByCreditHotelLocal', 'factorNumber' => $objFactor->temproryHotel['factor_number'], 'paymentStatus' => $paymentStatusValue, 'typeApplication' => $smarty.post.typeApplication]}
        {assign var="creditAction" value="`$smarty.const.ROOT_ADDRESS`/returnBankHotelLocal"}

        {assign var="currencyPermition" value="0"}
        {if $smarty.const.ISCURRENCY && $smarty.post.CurrencyCode > 0}
            {$currencyPermition = "1"}
            {assign var="currencyInputs" value=['flag' => 'check_credit_hotel', 'factorNumber' => $objFactor->temproryHotel['factor_number'], 'typeApplication' => $smarty.post.typeApplication, 'typeTrip' => 'hotelLocal', 'paymentPrice' => $objFactor->paymentPrice , 'paymentStatus' => $paymentStatusValue, 'serviceType' => $serviceType, 'amount' => $paymentPriceCurrency.AmountCurrency, 'currencyCode' => $smarty.post.CurrencyCode]}
            {assign var="currencyAction" value="`$smarty.const.ROOT_ADDRESS`/returnBankHotelLocal"}
        {/if}

        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`paymentMethods.tpl"}
        <!-- payment methods drop down -->

    </div>
    <!--BACK TO TOP BUTTON-->
    <div class="backToTop"></div>
{literal}
    <script type="text/javascript">
       $(document).ready(function () {
          $('.plus_price_room i').click(function () {
             $(this).parents('.hotel_room_row').find('.box_pricees').toggle();
             $(this).toggleClass('fa fa-times')
             $(this).toggleClass('far fa-list-alt')
          });
          $('.table-responsive').bind('click', function (e) {
             e.stopPropagation();
          });
          $('body').click(function () {
             $('.box_pricees').hide();
             $('.plus_price_room i').removeClass('fa fa-times')
             $('.plus_price_room i').addClass('far fa-list-alt')
          });
          $(this).find(".price-pop").click(function () {

             $(".price-Box").toggleClass("displayBlock");
             $("#lightboxContainer").addClass("displayBlock");
          });
          $(this).find(".closeBtn").click(function () {

             $(".price-Box").removeClass("displayBlock");
             $("#lightboxContainer").removeClass("displayBlock");
          });
          $("div#lightboxContainer").click(function () {

             $(".price-Box").removeClass("displayBlock");
             $("#lightboxContainer").removeClass("displayBlock");
          });
          $(this).find(".Cancellation-pop").click(function () {

             $(".Cancellation-Box").toggleClass("displayBlock");
             $("#lightboxContainer").addClass("displayBlock");
          });
          $(this).find(".closeBtn").click(function () {

             $(".Cancellation-Box").removeClass("displayBlock");
             $("#lightboxContainer").removeClass("displayBlock");
          });
          $("div#lightboxContainer").click(function () {

             $(".Cancellation-Box").removeClass("displayBlock");
             $("#lightboxContainer").removeClass("displayBlock");
          });
          // $('body').delegate('.DetailSelectTicket','click', function(e) {
          $('.DetailSelectTicket').on('click', function (e) {
             $(this).parent().siblings('.DetailSelectTicketContect').slideToggle('fast');
          });

       });
    </script>
{/literal}
{literal}
    <!-- jQuery Site Scipts -->
    <script src="assets/js/script.js"></script>
    <script src="assets/js/jdate.min.js" type="text/javascript"></script>
    <script src="assets/js/jdate.js" type="text/javascript"></script>
    <script src="assets/js/jquery.counter.js" type="text/javascript"></script>
    <script type="text/javascript">

       function timeForConfirmHotel() {

          setInterval(function () {

             var timeConfirmHotel = $('#timeConfirmHotel').val();

             if (timeConfirmHotel == 'yes') {

                var factorNumber = $('#factorNumber').val();
                $.post(amadeusPath + 'hotel_ajax.php',
                   {
                      factorNumber: factorNumber,
                      flag: "checkForConfirmHotel"
                   },
                   function (data) {

                      if (data.indexOf('PreReserve') > -1) {
                         $('#timeConfirmHotel').val('no');
                         $('#AdminChecking').addClass('displayN');
                         $('#onRequest').addClass('displayN');
                         $('#onRequestOnlinePassenger').addClass('displayN');
                         $('#confirmHotel').removeClass('displayN');
                         $('#btn-final-confirmation').removeClass('displayN');
                         $('.counterBank').counter({});
                         setTimeout(function () {
                            $('#final_ok_and_insert_passenger').removeAttr("onclick").attr("disabled", true).css('cursor', 'not-allowed').text('##Accepted##');

                            $('.s-u-p-factor-bank-change').show();
                            $('#loader_check').css("display", "none");
                            $('html, body').animate({scrollTop: $('#factor_bank').offset().top}, 'slow');
                         }, 2000);

                      } else if (data.indexOf('Cancelled') > -1) {
                         $('#timeConfirmHotel').val('no');
                         $('#onRequest').addClass('displayN');
                         $('#onRequestOnlinePassenger').addClass('displayN');
                         $('#AdminChecking').addClass('displayN');
                         $('#cancelHotel').removeClass('displayN');
                      } else if (data.indexOf('AdminChecking') > -1) {
                         $('#timeConfirmHotel').val('no');
                         $('#factor_bank').addClass('displayN');
                         $('#confirmHotel').addClass('displayN');
                         $('#onRequest').addClass('displayN');
                         $('#onRequestOnlinePassenger').addClass('displayN');
                         $('#cancelHotel').addClass('displayN');
                         $('#AdminChecking').removeClass('displayN');
                      }


                   });

             }

          }, 60000);

       }


       /*$('.counter').on('counterStop', function () {

           var factorNumber = $('#factorNumber').val();
           $.post(amadeusPath + 'hotel_ajax.php',
               {
                   factorNumber: factorNumber,
                   flag: "checkForConfirmHotel"
               },
               function (data) {

                   if (data.indexOf('PreReserve') > -1) {

                       $('#onRequestOnlinePassenger').addClass('displayN');
                       $('#confirmHotel').removeClass('displayN');
                       $('.counterBank').counter({});
                       setTimeout(function () {
                           $('#final_ok_and_insert_passenger').removeAttr("onclick").attr("disabled", true).css('cursor', 'not-allowed').text('##Accepted##');

                           $('.s-u-p-factor-bank-change').show();
                           $('#loader_check').css("display", "none");
                           $('html, body').animate({scrollTop: $('#factor_bank').offset().top}, 'slow');
                       }, 2000);

                   } else if (data.indexOf('Cancelled') > -1) {

                       $('#onRequestOnlinePassenger').addClass('displayN');
                       $('#cancelHotel').removeClass('displayN');

                   } else {

                       $.post(amadeusPath + 'hotel_ajax.php',
                           {
                               factorNumber: factorNumber,
                               flag: "cancelReserveHotel"
                           },
                           function (data) {

                               $('#factor_bank').addClass('displayN');
                               $('#confirmHotel').addClass('displayN');
                               $('#onRequestOnlinePassenger').addClass('displayN');
                               $('#cancelHotel').removeClass('displayN');

                           });

                   }


               });

       });*/


       $('.counterBank').on('counterStop', function () {

          var factorNumber = $('#factorNumber').val();
          $.post(amadeusPath + 'hotel_ajax.php',
             {
                factorNumber: factorNumber,
                flag: "cancelReserveHotel"
             },
             function (data) {

                $.alert({
                   title: '##Reservationhotel##',
                   icon: 'fa fa-times',
                   content: "##Yourhotelreservationdeadlineexpiredrestart##",
                   rtl: true,
                   type: 'red'
                });
                location.href = '{/literal}{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}{literal}';

             });

       });

    </script>
    <!-- modal login    -->
    <script type="text/javascript" src="assets/js/modal-login.js"></script>
{/literal}

{/if}
