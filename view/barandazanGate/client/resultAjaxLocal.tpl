{load_presentation_object filename="resultLocal" assign="objResult"}
{$objResult->getTicketList()}
{$objResult->getTicketPrivate()}
{load_presentation_object filename="functions" assign="objFunctions"}
{assign var="InfoMember" value=$objFunctions->infoMember($objSession->getUserId())}
{assign var="InfoCounter" value=$objFunctions->infoCounterType($InfoMember.fk_counter_type_id)}


<div class=" s-u-ajax-container">
    <div id="lightboxContainer" class="lightboxContainerOpacity"> <img src="assets/images/rings.svg" width="60" alt="" class="LoadLightbox" style="display: none;"></div>
    <div class="s-u-result-wrapper">
        <div class="sort-by-section clearfix box">

            <div class="info-login">
                <div class="head-info-login"> 
                    <span class="site-bg-main-color site-bg-color-border-right-b">##Sortby##</span>
                </div>
                <div class="form-sort">

                    <div class="s-u-form-input-number form-item form-item-sort">
                        <div class="select ">
                            <select class="select2-num" id="timeSortSelect">
                                <option disabled selected hidden>##Flighttime##</option>
                                <option value='asc'>##Morningtonight##</option>
                                <option value='desc'>##Nighttomorning##</option>
                            </select>
                        </div>
                    </div>
                    <div class="s-u-form-input-number form-item form-item-sort">
                        <div class="select">
                            <select class="select2-num" id="priceSortSelect">
                                <option disabled selected hidden>##Price##</option>
                                <option value='asc'>##LTM##</option>
                                <option value='desc'>  ##MTL## </option>
                            </select>
                        </div>
                    </div>
                    <div class="s-u-form-input-number form-item form-item-sort countTiket">
                        {if $objResult->countTicketPrivate > 0}
                        <p>##Result##:<var>{math equation="x + y" x=$objResult->countTicket
                            y=$objResult->countTicketPrivate}</var><kbd>##Flight##</kbd></p>
                        {else}
                        <p>##Result##:<var>{$objResult->countTicket}</var><kbd>##Flight##</kbd></p>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
        <div class="items">
            <div class="" style="list-style: none">
                <div class="ParentArea" id="TextLight" style="display: none;">

                    <ul class="loading-animation alternate">
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                </div>
                <li class="" >
                    <div  class="carouseller" id="MinimumPriceCallApi">

                        {$objFunctions->ShowContentMinimumPrice($smarty.post.origin,$smarty.post.destination,$smarty.post.dept_date,$smarty.post.adult,$smarty.post.child,$smarty.post.infant)}

                    </div>
                </li>

            </div>
        </div>
        <li class="s-u-result-item-header displayiN">
            <div class="s-u-result-item-div">
                <p class="s-u-result-item-div-title s-u-result-item-div-logo-icon"></p>
            </div>
            <div class="s-u-result-item-wrapper">

                <div class="s-u-result-item-div">
                    <p class="s-u-result-item-div-title s-u-result-item-div-time-out"></p>
                </div>

                <div class="s-u-result-item-div">
                    <p class="s-u-result-item-div-title s-u-result-item-div-duration-local"></p>
                </div>

                <div class="s-u-result-item-div">
                    <p class="s-u-result-item-div-title s-u-result-item-div-flight-number-local"></p>
                </div>

                <div class="s-u-result-item-div">
                    <p class="s-u-result-item-div-title s-u-result-item-div-flight-number"></p>
                </div>

            </div>


            <div class="s-u-result-item-div">
                <p class="s-u-result-item-div-title s-u-result-item-div-flight-price"></p>
            </div>

        </li>


        <input type="hidden" value="{$objResult->adult_qty}" id="adult_qty">
        <input type="hidden" value="{$objResult->child_qty}" id="child_qty">
        <input type="hidden" value="{$objResult->infant_qty}" id="infant_qty">
        <input type="hidden" value="{$objResult->minPrice}" id="min_price">
        <input type="hidden" value="{$objResult->maxPrice}" id="max_price">


        <ul id="s-u-result-wrapper-ul">
<div class="items">
                {if $objResult->countTicketPrivate > 0}
                {foreach $objResult->TicketWarranty as $i=>$PTicket}

                <!--  گرفتن بلیط های اختصاصی  -->
                <!-- result item -->
                <div class="showListSort new">
                    <li class="s-u-result-item s-u-result-item-change  {$objGeneral->classTimeLOCAL($objResult->format_hour($PTicket.PDepartureTime))} {$PTicket.PAirline} {if  $PTicket.PFlightType_li eq system} system {else} charter{/if}"
                        id="{$i}-row" data-price="{$PTicket.PAdtPrice}"  data-type="{if $PTicket.PFlightType_li eq system}system{else}charter{/if}" data-airline="{$PTicket.PAirline}"
                        data-time=" {$objGeneral->classTimeLOCAL($objResult->format_hour($PTicket.PDepartureTime))}">

                        <div class="ribbon"><span>##specialoffer## </span></div>

                        <div class="s-u-result-item-div s-u-result-item-div-change col-xs-3 col-sm-2 s-u-result-item-div-width">
                            <div class="s-u-result-item-div-logo s-u-result-item-div-logo-change">
                                <img src="{$objGeneral->getAirlinePhoto($PTicket.PAirline)}" alt="{$PTicket.PAirline}"
                                     title="{$PTicket.PAirline}">
                            </div>
                            <div class="s-u-result-item-div s-u-result-content-item-div-change">
                                <!--  <span>{$PTicket.Airline.Name}</span>  -->
                                <span> <i> ##Numflight## :</i> {$PTicket.PFlightNo} </span>
                            </div>
                        </div>

                        <div class="s-u-result-item-wrapper s-u-result-item-wrapper-change col-xs-9 col-sm-10">
                            <div class="price-Box displayNone">

                                <div class="pop-up-h site-bg-main-color">
                                    <span>##TicketpricebasedpriceID##{$PTicket.PCabinType}</span>
                                    <span class="closeBtn"></span>
                                </div>
                                <div class="price-Content site-border-main-color">
                                    <p id="AlertPanelHTC"></p>

                                    <table class="tblprice">
                                        <tr>
                                            <td class="tdpricelabel">##Priceadult## :</td>
                                            <td class="tdprice"><i>{$PTicket.PAdtPrice|number_format:0:".":","}</i>##Rial##
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="tdpricelabel">##Pricechild## :</td>
                                            <td class="tdprice"><i>{$PTicket.PChdPrice|number_format:0:".":","}</i>##Rial##
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="tdpricelabel">##Pricebaby## :</td>
                                            <td class="tdprice"><i>{$PTicket.PInfPrice|number_format:0:".":","}</i>##Rial##
                                            </td>
                                        </tr>
                                    </table>

                                </div>

                                <div class="Clr"></div>
                            </div>

                            <!-- raft -->
                            <div class="details-wrapper-change">
                                <div class="s-u-result-raft first-row-change">
                                    <div class="s-u-result-item-div s-u-result-items-div-change right-Cell-change fltr padb5">
                                        <div class="s-u-result-item-div s-u-result-items-div-change displayib padl15 fltr displayN400 ">

                                            <span class="iranB">{$PTicket.PDepartureParentRegionName}</span>
                                            <span class="s-u-result-item-date-format s-u-result-item-date-format-change font15 ">{$PTicket.PPersianDepartureDate}</span>
                                            <span class="s-u-bozorg s-u-bozorg-change txt14 yekanB timeSortDep">{$objResult->format_hour($PTicket.PDepartureTime)}
                                        </span>

                                        </div>
                                        <div class="s-u-result-item-div s-u-result-items-div-change displayib padl1 fltr show-div ">
                                            <span></span>
                                            <span class="box-airplane">
                                                <i class="zmdi zmdi-local-airport zmdi-hc-rotate-270 airplane site-main-text-color"></i>
                                            </span>
                                            <span class="s-u-bozorg s-u-bozorg-change txt10">
                                            <i class="font-chanhe txt12"> {$objResult->LongTimeFlightHours($objResult->origin,$objResult->destination)} </i> ##Hour##
                                            <i class="font-chanhe txt12"> {$objResult->LongTimeFlightMinutes($objResult->origin,$objResult->destination)} </i> ##Minutes##
                                            </span>


                                        </div>
                                        <div class="s-u-result-item-div s-u-result-items-div-change displayib padl15 fltr displayN400">

                                            <span class="iranB">{$PTicket.PArrivalParentRegionName}</span>
                                            <span class="s-u-result-item-date-format s-u-result-item-date-format-change font15">{$PTicket.PArrivalDate}</span>
                                            <span class="s-u-bozorg s-u-bozorg-change txt14 yekanB ">{$objResult->format_hour_arrival($objResult->origin,$objResult->destination,$PTicket.PDepartureTime)}
                                        </span>

                                        </div>

                                        <div class="s-u-result-item-div s-u-result-items-div-change displayib padl15 fltr displayB400 ">
                                            <span class="iranB">{$PTicket.PDepartureParentRegionName}</span>
                                            <span class="iranB">{$PTicket.PArrivalParentRegionName}</span>

                                            <span class="s-u-result-item-date-format s-u-result-item-date-format-change font15">{$PTicket.PPersianDepartureDate}</span>
                                            <span class="s-u-bozorg s-u-bozorg-change txt14 yekanB timeSortDep">{$objResult->format_hour($PTicket.PDepartureTime)}
                                        </span>

                                        </div>


                                    </div>

                                    <div class="left-Cell-change">
                                        <span class="s-u-bozorg s-u-bozorg-change priceSortAdt"><i>{$PTicket.PAdtPrice|number_format:0:".":","}</i>##Rial##</span>
                                        <span class="displayib displayib-change">{$objResult->search($PTicket.Psubtickets,'SeatClass','C')}</span>
                                    </div>

                                </div>

                                <div class="second-row-change">
                                    <div class="right-Cell-change borbn fltr">
                                        <div class="flight-seat show-seat-div">
                                            <span> ##Typeairline## : {$objResult->AirPlaneType($PTicket.PAircraft)}</span>
                                        </div>
                                        <div class="flight-seat">
                                            <span class="s-u-bozorg-change s-u-result-items-div-change">
                                                <i class="font-chanhe ">{$PTicket.PCapacity}</i>  ##Chair##&nbsp; {$PTicket.PFlightType}
                                            </span>
                                            </div>

                                            <div class="amenities flight-info txtCenter">

                                            <span class=" chooseicon icons tooltipWeigh">
                                                <i class="zmdi zmdi-flight-land icon ">
                                                    <span class="tooltiptextWeight site-border-main-color site-bg-color-border-top"> ##Nostop## </span>
                                                </i>
                                            </span>

                                            <span class="chooseicon icons tooltipWeigh">
                                                <i class="zmdi zmdi-cutlery icon ">
                                                    <span class="tooltiptextWeight site-bg-color-border-top  site-border-main-color site-bg-color-border-top">##withmeal##</span>
                                                </i>

                                            </span>

                                            <!-- <span class="chooseicon price-pop">
                                                <i class="zmdi zmdi-money icon"></i>
                                            </span> -->

                                            <!-- <span class="chooseicon Cancellation-pop">
                                                <i class="zmdi zmdi-label icon"></i>
                                            </span> -->

                                            <span class="chooseicon icons tooltipWeigh">
                                                <i class="zmdi zmdi-markunread-mailbox icon ">
                                                    <span class="tooltiptextWeight site-border-main-color site-bg-color-border-top">##Permissible## 20 ##Kg## </span>
                                                </i>
                                            </span>
                                        </div>

                                    </div>
                                    <!-- نمایش قیمت بدون تخفیف  -->
                                    <div class="s-u-result-item-div-choose left-Cell-change  borbn fltl">
                                        <a class="s-u-select-flight-change site-secondary-text-color  DetailSelectTicket site-main-button-color"
                                           href="{$PTicket.PUrl}&oneway=1&id={$PTicket.id}&id_tour_bargasht=0&adl={$objResult->adult_qty}&chd_up={$objResult->child_qty}&inf={$objResult->infant_qty}"
                                           target="_blank"> ##Selectionflight##</a>

                                    </div>


                                </div>
                            </div>
                        </div>

                        <div class="clear"></div>
                    </li>
                </div>
                <!-- end result item -->

                {/foreach}
                {/if}

                {foreach $objResult->tickets as $i=>$ticket}


                {* گرفتن بلیطهای موجود *}
                <!-- result item -->
                <div class="showListSort">
                    <li class="s-u-result-item s-u-result-item-change  {$objGeneral->classTimeLOCAL($objResult->format_hour($ticket.DepartureTime))} {$ticket.Airline} {if  $ticket.FlightType_li eq system} system {else} charter{/if}"
                        id="{$i}-row" data-price="{$ticket.AdtPrice}" data-type="{if $ticket.FlightType_li eq system}system{else}charter{/if}" data-airline="{$ticket.Airline}"
                        data-time="{$objGeneral->classTimeLOCAL($objResult->format_hour($ticket.DepartureTime))}">


                        <div class="s-u-result-item-div s-u-result-item-div-change col-xs-3 col-sm-2 s-u-result-item-div-width">
                            <div class="s-u-result-item-div-logo s-u-result-item-div-logo-change">
                                <img src="{$objGeneral->getAirlinePhoto($ticket.Airline)}" alt="{$ticket.Airline}"
                                     title="{$ticket.Airline}">
                            </div>
                            <div class="s-u-result-item-div s-u-result-content-item-div-change">
                                <!--  <span>{$ticket.Airline.Name}</span>  -->
                                <span> <i> ##Numflight## :</i> {$ticket.FlightNo} </span>

                            </div>
                        </div>

                        <div class="s-u-result-item-wrapper s-u-result-item-wrapper-change col-xs-9 col-sm-10">


                            <!-- raft -->
                            <div class="details-wrapper-change">
                                <div class="s-u-result-raft first-row-change">
                                    <div class="s-u-result-item-div s-u-result-items-div-change right-Cell-change fltr padb5">
                                        <div class="s-u-result-item-div s-u-result-items-div-change displayib padl15 fltr displayN400 ">

                                            <span class="iranB">{$objResult->NameCity($ticket.DepartureCode)}</span>
                                            <span class="s-u-result-item-date-format s-u-result-item-date-format-change font15 ">{$ticket.PersianDepartureDate}</span>
                                            <span class="s-u-bozorg s-u-bozorg-change txt14 yekanB timeSortDep">{$objResult->format_hour($ticket.DepartureTime)}
                                        </span>

                                        </div>
                                        <div class="s-u-result-item-div s-u-result-items-div-change displayib padl1 fltr show-div ">
                                            <span></span>
                                            <span class="box-airplane">
                                                <i class="zmdi zmdi-local-airport zmdi-hc-rotate-270 airplane site-main-text-color"></i>
                                            </span>
                                            <span class="s-u-bozorg s-u-bozorg-change txt10">
                                            <i class="font-chanhe txt12"> {$objResult->LongTimeFlightHours($objResult->origin,$objResult->destination)} </i> ##Hour##
                                            <i class="font-chanhe txt12"> {$objResult->LongTimeFlightMinutes($objResult->origin,$objResult->destination)} </i> ##Minutes##
                                            </span>


                                        </div>
                                        <div class="s-u-result-item-div s-u-result-items-div-change displayib padl15 fltr displayN400">

                                            <span class="iranB">{$objResult->NameCity($ticket.ArrivalCode)}</span>
                                            <span class="s-u-result-item-date-format s-u-result-item-date-format-change font15">{$ticket.ArrivalDate}</span>
                                            <span class="s-u-bozorg s-u-bozorg-change txt14 yekanB ">{$objResult->format_hour_arrival($objResult->origin,$objResult->destination,$ticket.DepartureTime)}
                                        </span>

                                        </div>

                                        <div class="s-u-result-item-div s-u-result-items-div-change displayib padl15 fltr displayB400 ">
                                            <span class="iranB">{$objResult->NameCity($ticket.DepartureCode)}</span>
                                            <span class="iranB">{$objResult->NameCity($ticket.ArrivalCode)}</span>

                                            <span class="s-u-result-item-date-format s-u-result-item-date-format-change font15">{$ticket.PersianDepartureDate}</span>
                                            <span class="s-u-bozorg s-u-bozorg-change txt14 yekanB timeSortDep">{$objResult->format_hour($ticket.DepartureTime)}
                                        </span>

                                        </div>


                                    </div>

                                    <div class="left-Cell-change">
                                        <span class="s-u-bozorg s-u-bozorg-change priceSortAdt">

                                                 {if $InfoCounter['discount_system_private'] > 0 && $objFunctions->check_pid($ticket.Airline) eq private && $ticket.FlightType_li eq 'system'}
                                                    <i class="text-decoration-line displayb">{$ticket.AdtPrice|number_format:0:".":","}</i>
                                                    <i class="site-main-text-color-drck">{$objFunctions->CalculatePercent($InfoCounter['id'],$ticket.AdtPrice,$ticket.Airline,$ticket.FlightType_li)}</i>##Rial##
                                                    {else if $InfoCounter['discount_system_public'] > 0 && $objFunctions->check_pid($ticket.Airline) eq public && $ticket.FlightType_li eq 'system'}
                                                    <i class="text-decoration-line displayb">{$ticket.AdtPrice|number_format:0:".":","}</i>
                                                    <i class="site-main-text-color-drck">{$objFunctions->CalculatePercent($InfoCounter['id'],$ticket.AdtPrice,$ticket.Airline,$ticket.FlightType_li)}</i>##Rial##
                                                    {else if $InfoCounter['discount_charter'] > 0  && $ticket.FlightType_li eq 'charter'}
                                                    <i class="text-decoration-line displayb">{$ticket.AdtPrice|number_format:0:".":","}</i>
                                                    <i class="site-main-text-color-drck">{$objFunctions->CalculatePercent($InfoCounter['id'],$ticket.AdtPrice,$ticket.Airline,$ticket.FlightType_li)}</i>##Rial##
                                                    {else}
                                                    <i >{$ticket.AdtPrice|number_format:0:".":","}</i>##Rial##
                                                 {/if}


                                        {if $ticket.UserId neq '' && $ticket.UserId eq $objResult->USER_ID_API
                                && $ticket.UserName neq '' && $ticket.UserName eq $objResult->USER_NAME_API}
                                            <span style="color: white">.</span>
                                {/if}
                                        </span>
                                        <span class="displayib displayib-change">{$objResult->search($ticket.subtickets,'SeatClass','C')}</span>
                                    </div>

                                </div>

                                <div class="second-row-change">
                                    <div class="right-Cell-change borbn fltr">
                                        <div class="flight-seat show-seat-div">
                                            <span>##Typeairline## : {if $objResult->AirPlaneType($ticket.Aircraft) neq ''} {$objResult->AirPlaneType($ticket.Aircraft)}{else}{$ticket.Aircraft}{/if}</span>
                                        </div>
                                        <div class="flight-seat">
                                        <span class="s-u-bozorg-change s-u-result-items-div-change">
                                            <i class="font-chanhe ">{$ticket.Capacity}</i>
                                            ##Chair##  {$ticket.FlightType}
                                        </span>
                                        </div>

                                        <div class="amenities flight-info txtCenter">

                                        <span class=" chooseicon site-bg-main-color-b icons tooltipWeigh">
                                            <i class="zmdi zmdi-flight-land icon ">
                                                <span class="tooltiptextWeight site-border-main-color site-bg-color-border-top"> ##Nostop## </span>
                                            </i>
                                        </span>

                                            <span class="chooseicon site-bg-main-color-b icons tooltipWeigh">
                                            <i class="zmdi zmdi-cutlery icon ">
                                                <span class="tooltiptextWeight  site-border-main-color site-bg-color-border-top">##Alongwithfood## </span>
                                            </i>

                                        </span>
<!--
                                            <span class="chooseicon site-bg-main-color-b price-pop">
                                            <i class="zmdi zmdi-money icon"></i>
                                        </span> -->

                                            <!--<span class="chooseicon site-bg-main-color-b Cancellation-pop">-->
                                            <!--<i class="zmdi zmdi-label icon"></i>-->
                                        <!--</span>-->

                                            <span class="chooseicon site-bg-main-color-b icons tooltipWeigh">
                                            <i class="zmdi zmdi-markunread-mailbox icon ">
                                                <span class="tooltiptextWeight  site-border-main-color site-bg-color-border-top">##Permissible## 20 ##Kg## </span>
                                            </i>
                                        </span>
                                        </div>

                                    </div>
                                    <!-- نمایش قیمت بدون تخفیف  -->
                                    <div class="s-u-result-item-div-choose left-Cell-change  borbn fltl">
                                        <a class="s-u-select-flight-change site-secondary-text-color  DetailSelectTicket site-main-button-color">##Selectionflight##</a>

                                    </div>

                                    <div class="DetailSelectTicketContect">
                                        <div class="col-lg-12">
                                            {foreach $ticket.subtickets as $i=>$sub}
                                            <div class="s-u-SelectTicket-items">
                                                <div>
                                                <span class="s-u-bozorg s-u-bozorg-change">

                                                     {if $InfoCounter['discount_system_private'] > 0 && $objFunctions->check_pid($ticket.Airline) eq private && $ticket.FlightType_li eq 'system'}
                                                        <i class="text-decoration-line displayb">{$sub.AdtPrice|number_format:0:".":","}</i>
                                                        <i class="site-main-text-color-drck">{$objFunctions->CalculatePercent($InfoCounter['id'],$sub.AdtPrice,$ticket.Airline,$ticket.FlightType_li)}</i>##Rial##
                                                        {else if $InfoCounter['discount_system_public'] > 0 && $objFunctions->check_pid($ticket.Airline) eq public && $ticket.FlightType_li eq 'system'}
                                                        <i class="text-decoration-line displayb">{$sub.AdtPrice|number_format:0:".":","}</i>
                                                        <i class="site-main-text-color-drck">{$objFunctions->CalculatePercent($InfoCounter['id'],$sub.AdtPrice,$ticket.Airline,$ticket.FlightType_li)}</i>##Rial##
                                                        {else if $InfoCounter['discount_charter'] > 0  && $ticket.FlightType_li eq 'charter'}
                                                        <i class="text-decoration-line displayb">{$sub.AdtPrice|number_format:0:".":","}</i>
                                                        <i class="site-main-text-color-drck">{$objFunctions->CalculatePercent($InfoCounter['id'],$sub.AdtPrice,$ticket.Airline,$ticket.FlightType_li)}</i>##Rial##
                                                        {else}
                                                        <i>{$sub.AdtPrice|number_format:0:".":","}</i>##Rial##
                                                     {/if}
                                                </span>
                                                </div>
                                                <div class=" price-pop detailPriceIcon  site-bg-main-color-b">
                                                     <span onclick="InfoShowOneFlight('{$sub.CabinType}','{$sub.AdtPrice}','{$sub.ChdPrice}','{$sub.InfPrice}','{$sub.Airline.Code}','{$sub.FlightType}','{$InfoCounter.id}')"> ##Ratedetails## {$sub.CabinType}</span>
                                                    <!--<span > جزئیات نرخی</span>-->
                                                </div>
                                                <div>
                                                    <span>{if $sub.Reservable neq 'fasle'} 0 {else}{$sub.Capacity}{/if} ##Leftseat##</span>
                                                </div>


                                                <div class="loodingPostion">
                                                    <!--<a class="s-u-select-flight s-u-select-flight1-change">رزرو</a>-->
                                                    <input type="hidden" value='' name="session_filght_Id" id="session_filght_Id">



                                                    <a href="" onclick="return false"
                                                       class="f-loader-check f-loader-check-change"
                                                       id="loader_check_{$sub.FlightID}" style="display:none"></a>
                                                    <input type="hidden" value="{$sub.FlightID}" class="FlightID">
                                                    <input type="hidden" value="{$ticket.Airline}" id="Ailine_Code">
                                                    <input type="hidden" value="{$sub.SourceId}" id="SourceId">
                                                    <input type="hidden" value="{$sub.FlightType}" id="FlightType">
                                                    <input type="hidden" value="{$sub.Capacity}" id="Capacity">
                                                    <input type="hidden" value="{$sub.AdtPrice|number_format}" id="priceWithoutDiscount">
                                                    <input type="hidden" value="{$objFunctions->check_pid($ticket.Airline)}" id="PrivateM4">
                                                        {if $sub.Reservable eq true}
                                                        <a class="s-u-next-step s-u-select-flight1-change site-secondary-text-color site-main-button-flat-color nextStepclass"
                                                           id="nextStep_{$sub.FlightID}">##Reservation##</a>
                                                        {else}
                                                        <a class="s-u-next-step s-u-select-flight1-change site-secondary-text-color site-main-button-flat-color  flight-false">##End##
                                                            ##Capacity##</a>

                                                        {/if}

                                                </div>
                                            </div>

                                            {/foreach}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="clear"></div>
                    </li>
                </div>
                <!-- end result item -->

                {/foreach}
                {if ($ticket eq '' and $ticket neq '0') && ($PTicket eq '' and $PTicket neq '0')}
                <div class="userProfileInfo-messge ">
                    <div class="messge-login BoxErrorSearch">
                        <div style="float: right;">  <i class="fa fa-exclamation-triangle IconBoxErrorSearch"></i>
                        </div>
                        <div class="TextBoxErrorSearch">
                            ##Noflight##<br/>
##Changedate##
                        </div>
                    </div>
                </div>
                {literal}
                <script>

                    $('.select2').select2();
                    $('.select2-num').select2({minimumResultsForSearch: Infinity,});
                </script>
                {/literal}
                {/if}


            </div>

            {literal}<script type="text/javascript">{/literal}
            {foreach $objResult->aciveAirlines as $airline}
            	{literal}$("#{/literal}{$airline}{literal}-filter").css("display", "block");{/literal}
            {/foreach}
            {literal}</script>{/literal}

            <div class="s-u-next-setep-login-popup">
                <button class="cd-signin" id="login-popup">##Popup##</button>
            </div>

        </ul>
    </div>

</div>
{literal}
<div class="price-Box displayNone" id="ShowInfoFlightCabinType"></div>
<script type="text/javascript">
    //bar and ticket rules popup
    //show popup
    $(".s-u-ticket-rules-btn").on("click", function () {
        $('.s-u-result-item-details > ul > li').removeClass('light-white');
        $(this).toggleClass('light-white');
        $('.s-u-black-container').fadeIn();
        $(this).find('.s-u-t-r-p').fadeIn();
    });
    $('.s-u-bar-rules-btn').on("click", function (e) {
        e.preventDefault();
        $('.s-u-result-item-details > ul > li').removeClass('light-white');
        $(this).toggleClass('light-white');
        $('.s-u-black-container').fadeIn();
        $(this).find('.s-u-b-r-p').fadeIn();
    });
    //hide popup
    $('.s-u-t-r-p .s-u-t-r-p-h').on("click", function (e) {
        e.preventDefault();
        $(".s-u-black-container").fadeOut();
        $(".s-u-t-r-p").fadeOut();
        return false;
    });
    $('.s-u-b-r-p .s-u-t-r-p-h').on("click", function (e) {
        e.preventDefault();
        $(".s-u-black-container").fadeOut();
        $(".s-u-b-r-p").fadeOut();
        return false;
    });
    $('.s-u-black-container').on("click", function (e) {
        e.preventDefault();
        $('.s-u-black-container').fadeOut();
        $('.s-u-b-r-p').fadeOut();
        $('.s-u-t-r-p').fadeOut();
    });
    $('.s-u-select-flight').on("click", function () {
        var item = $(this).parents('.s-u-result-item');
        $('.s-u-result-item').fadeOut().filter(item).fadeIn();
        $(this).fadeOut();
        item.next('.s-u-steps').fadeIn();
        $('html,body').animate({
            scrollTop: $('.s-u-result-item-header').offset().top - 100
        }, '1000');
        //$('.pager').fadeOut();
    });
    //unselect

    $('.s-u-prev-step').on("click", function () {
        $('.s-u-result-item').fadeIn("slow");
        $(this).parents('.s-u-steps').fadeOut('fast');
        $('.s-u-select-flight').fadeIn('fast');
        $('#check_flight_' + $(this).attr('id')).show();
        $('#check_flight_' + $(this).attr('id')).text('##Checkflight##');
        $('#nextStep_' + $(this).attr('id')).hide();
        //$('.pager').fadeIn();
    })


    //tabs
    $('.rule-tab2').asTabs({
        namespace: 'rule-tab2',
        navSelector: '> ul',
        contentSelector: '> div'
    });
    $('.rule-tab').asTabs({
        namespace: 'rule-tab',
        navSelector: '> ul',
        contentSelector: '> div'
    });
  </script>
<!-- modal -->
<script type="text/javascript" src="assets/js/modal-login.js"></script>


<script type="text/javascript">
 $(function () {
    var minPrice = {/literal}{if isset($objResult->PminPrice)}{if $objResult->minPrice < $objResult->PminPrice} {$objResult->minPrice} {else}{$objResult->PminPrice}{/if}{else}{$objResult->minPrice} {/if} {literal},
        maxPrice = {/literal}{if isset($objResult->PmaxPrice)}{if $objResult->maxPrice >  $objResult->PmaxPrice} {$objResult->maxPrice} {else}{$objResult->PmaxPrice}{/if} {else} {$objResult->maxPrice} {/if} {literal},
        $filter_lists = $(".s-u-filter-item > div  > ul"),
        $filter_checkboxes = $(".s-u-filter-item input.check-switch"),
        $tickets = $(".s-u-result-item");
        $filter_checkboxes.change(filterflight);

        $('#slider-range').slider({
             range: true,
             min: minPrice,
             max: maxPrice,
             step: 1000,
             values: [minPrice, maxPrice],
             slide: function (event, ui) {
                 $("#amount").val(addCommas(ui.values[0]) + " - " + addCommas(ui.values[1]));
                 minPrice = ui.values[0];
                 maxPrice = ui.values[1];
                 filterflightPrice();
             }
         });

        $("#amount").val(addCommas(minPrice) + " - " + addCommas(maxPrice));

        function addCommas(nStr)
        {
	        nStr += '';
	        x = nStr.split('.');
	        x1 = x[0];
	        x2 = x.length > 1 ? '.' + x[1] : '';
	        var rgx = /(\d+)(\d{3})/;
	        while (rgx.test(x1)) {
	        x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
        }
        function filterSlider(elem) {
            var price = parseInt($(elem).data("price"), 10);
            return price >= minPrice && price <= maxPrice;
        }

        function filterflightPrice() {

	        $tickets.hide().filter(function () {
	        	return filterSlider(this);
	        }).show();
        }

 });



 	/*light box ruls and pric passengers*/
    $(document).ready(function() {
	    $('body').delegate('.price-pop', 'click', function() {
		    $(this).parents(".s-u-result-item-wrapper-change").find(".price-Box").toggleClass("displayBlock");
		    $("#lightboxContainer").addClass("displayBlock");
	    });

	    $('body').delegate('div#lightboxContainer', 'click', function() {
		    $(".price-Box").removeClass("displayBlock");
		    $("#lightboxContainer").removeClass("displayBlock");
	    });
	    $('body').delegate('.Cancellation-pop', 'click', function() {
		    $(".Cancellation-Box").toggleClass("displayBlock");
		    $("#lightboxContainer").addClass("displayBlock");
	    });
	    $('body').delegate('div#lightboxContainer', 'click', function() {
		    $(".Cancellation-Box").removeClass("displayBlock");
		    $("#lightboxContainer").removeClass("displayBlock");
	    });
	    $('body').delegate('.closeBtn', 'click', function() {
		    $(".price-Box").removeClass("displayBlock");
		    $("#lightboxContainer").removeClass("displayBlock");

		    $(".Cancellation-Box").removeClass("displayBlock");
		    $("#lightboxContainer").removeClass("displayBlock");
	    });
    });
</script>



  <script type="text/javascript">
      $('.select2').select2();
      $('.select2-num').select2({minimumResultsForSearch: Infinity,});
     setTimeout(function() {
         $.confirm({
             theme: 'supervan' ,// 'material', 'bootstrap'
             title: '##Update##',
             icon: 'fa fa-refresh',
             content: '##updatepriceandcapacity##',
             rtl: true,
             closeIcon: true,
             type: 'orange',
             buttons: {
                 confirm: {
                     text: '##Approve##',
                     btnClass: 'btn-green',
                     action: function () {
                         location.reload();
                     }
                 },
                 cancel: {
                     text: '##Optout##',
                     btnClass: 'btn-orange',
                 }
             }
         });
     }, 600000);

  
  </script>
{/literal}