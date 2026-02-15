{if $smarty.const.TYPE_ADMIN eq 1}
{load_presentation_object filename="bookshow" assign="objbook"}
{assign var="bookList" value=$objbook->listBookLocal()}
{assign var="GetWayIranTech" value=$objFunctions->DataIranTechGetWay()}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>گزارش خرید</li>
                <li class="active">سوابق خرید</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">جستجوی سوابق خرید </h3>

                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید سوابق را در تاریخ های مورد نظرتان جستجو
                    کنید
                </p>

                <form id="SearchTicketHistory" method="post" action="{$smarty.const.rootAddress}ticketHistory"
                      autocomplete="off">
                    <input type="hidden" name="flag" id="flag" value="createExcelFile">

                    <div class="form-group col-sm-6 ">
                        <label for="date_of" class="control-label">از تاریخ </label>
                        <input type="text" class="form-control datepicker" name="date_of" value="{if $smarty.post.date_of neq ''} {$smarty.post.date_of} {else}{$objFunctions->timeNow()}{/if}"
                               id="date_of" placeholder="تاریخ شروع جستجو را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="to_date" class="control-label">تا تاریخ</label>
                        <input type="text" class="form-control datepickerReturn" name="to_date"
                               value="{if $smarty.post.to_date neq ''}{$smarty.post.to_date}{else}{$objFunctions->timeNow()}{/if}" id="to_date"
                               placeholder="تاریخ پایان جستجو را وارد نمائید">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="successfull" class="control-label">وضعیت رزرو</label>
                        <select name="successfull" id="successfull" class="form-control">
                            <option value="">انتخاب کنید....</option>
                            <option value="all" {if $smarty.post.successfull eq 'all' }selected{/if}>همه</option>
                            <option value="book" {if $smarty.post.successfull eq  'book' }selected{/if}>موفق</option>
                            <option value="nothing" {if $smarty.post.successfull eq 'nothing' }selected{/if}>ناموفق
                            </option>
                        </select>
                    </div>
                    {if $smarty.const.TYPE_ADMIN eq '1'}
                        <div class="form-group col-sm-6">
                            <label for="flight_type" class="control-label">نوع پرواز</label>
                            <select name="flight_type" id="flight_type" class="form-control">
                                <option value="">انتخاب کنید....</option>
                                <option value="all">همه</option>
                                <option value="charterSourceFour"
                                        {if $smarty.post.flight_type eq 'charterSourceFour' }selected{/if}>چارتری سرور 4
                                </option>
                                <option value="charterSourceSeven"
                                        {if $smarty.post.flight_type eq 'charterSourceSeven' }selected{/if}>چارتری سرور
                                    7
                                </option>
                                <option value="SystemSourceFour"
                                        {if $smarty.post.flight_type eq 'SystemSourceFour' }selected{/if}>سیستمی سرور 4
                                </option>
                                  <option value="SystemSourceSeven"
                                        {if $smarty.post.flight_type eq 'SystemSourceSeven' }selected{/if}>سیستمی سرور 7
                                </option>
                                <option value="SystemSourceFive"
                                        {if $smarty.post.flight_type eq 'SystemSourceFive' }selected{/if}>سیستمی سرور 5
                                </option>
                                <option value="SystemSourceTen"
                                        {if $smarty.post.flight_type eq 'SystemSourceTen' }selected{/if}>سیستمی سرور 10
                                </option>
                                <option value="SystemSourceForeignNine"
                                        {if $smarty.post.flight_type eq 'SystemSourceForeignNine' }selected{/if}>سیستمی
                                    خارجی سرور 9
                                </option>
                                <option value="charterSourceNine"
                                        {if $smarty.post.flight_type eq 'charterSourceNine' }selected{/if}>چارتری سرور 9
                                </option>
                            </select>
                        </div>
                    {else}
                        <div class="form-group col-sm-6">
                            <label for="flight_type" class="control-label">نوع پرواز</label>
                            <select name="flight_type" id="flight_type" class="form-control">
                                <option value="">انتخاب کنید....</option>
                                <option value="all">همه</option>
                                <option value="charter" {if $smarty.post.flight_type eq 'charter' }selected{/if}>چاتری
                                </option>
                                <option value="system" {if $smarty.post.flight_type eq 'system' }selected{/if}>سیستمی
                                </option>
                                <option value="charterPrivate"
                                        {if $smarty.post.flight_type eq 'charterPrivate' }selected{/if}>چارتری اختصاصی
                                </option>
                            </select>
                        </div>
                    {/if}

                    <div class="form-group col-sm-6">
                        <label for="pnr" class="control-label">pnr</label>
                        <input type="text" class="form-control " name="pnr"
                               value="{$smarty.post.pnr}" id="pnr"
                               placeholder="pnr را وارد نمائید">

                    </div>
                    <div class="form-group col-sm-6">
                        <label for="passenger_name" class="control-label">نام یا نام خانوادگی مسافر</label>
                        <input type="text" class="form-control " name="passenger_name"
                               value="{$smarty.post.passenger_name}" id="passenger_name"
                               placeholder="تاریخ پایان جستجو را وارد نمائید">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="request_number" class="control-label">کد واچر</label>
                        <input type="text" class="form-control " name="request_number"
                               value="{$smarty.post.request_number}" id="request_number"
                               placeholder="کد واچر را وارد نمائید">

                    </div>
                    <div class="form-group col-sm-6">
                        <label for="request_number" class="control-label">شماره فاکتور </label>
                        <input type="text" class="form-control " name="factor_number"
                               value="{$smarty.post.factor_number}" id="factor_number"
                               placeholder="شماره فاکتور  را وارد نمائید">

                    </div>
                    {if $objsession->adminIsLogin()}
                        {if $smarty.const.TYPE_ADMIN eq '1'}
                            <div class="form-group col-sm-6">
                                <label for="client_id" class="control-label">نام همکار</label>
                                <select name="client_id" id="client_id" class="form-control select2">
                                    <option value="">انتخاب کنید....</option>
                                    <option value="all">همه</option>
                                    {foreach $objbook->list_hamkar() as $client }
                                        <option value="{$client.id}" {if $smarty.post.client_id eq $client.id} selected {/if}>{$client.AgencyName}</option>
                                    {/foreach}
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="cancel" class="control-label">نمایش بلیط های کنسل شده</label>
                                <select name="cancel" id="cancel" class="form-control select2">
                                    <option value="">انتخاب کنید....</option>
                                    <option value="No" {if $smarty.post.cancel eq 'No'} selected {/if}>{$client.cancel}
                                        خیر
                                    </option>
                                    <option value="Yes" {if $smarty.post.cancel eq 'Yes'} selected {/if}>{$client.cancel}
                                        بله
                                    </option>
                                </select>
                            </div>
                        {/if}

                        <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                            <label for="passenger_national_code" class="control-label">کد ملی مسافر</label>
                            <input type="text" class="form-control " name="passenger_national_code"
                                   value="{$smarty.post.passenger_national_code}" id="passenger_national_code"
                                   placeholder="کد ملی مسافر را وارد نمائید">

                        </div>
                        <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                            <label for="member_name" class="control-label">نام یا نام خانوادگی خریدار </label>
                            <input type="text" class="form-control " name="member_name"
                                   value="{$smarty.post.member_name}" id="member_name"
                                   placeholder="نام یا نام خانوادگی خریدار  را وارد نمائید">

                        </div>
                        <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                            <label for="client_id" class="control-label">نوع خرید</label>
                            <select name="payment_type" id="payment_type"
                                    class="form-control">
                                <option value="">انتخاب کنید....</option>
                                <option value="all" {if $smarty.post.payment_type eq 'all' }selected{/if}>همه</option>
                                <option value="cash" {if $smarty.post.payment_type eq 'cash' }selected{/if}>نقدی
                                </option>
                                <option value="credit" {if $smarty.post.payment_type eq 'credit' }selected{/if}>
                                    اعتباری
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-sm-6 showAdvanceSearch " style="display: none;">
                            <label for="DateFlight" class="control-label">تاریخ پرواز</label>
                            <input type="text" class="form-control datepicker" name="DateFlight"
                                   value="{$smarty.post.DateFlight}"
                                   id="DateFlight" placeholder="تاریخ پرواز جستجو را وارد نمائید">
                        </div>
                        <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                            <label for="eticket_number" class="control-label">شماره بلیط </label>
                            <input type="text" class="form-control " name="eticket_number"
                                   value="{$smarty.post.eticket_number}" id="eticket_number"
                                   placeholder="شماره بلیط  را وارد نمائید">

                        </div>
                        <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                            <label for="AirlineIata" class="control-label">نام ایرلاین</label>
                            <select name="AirlineIata" id="AirlineIata" class="form-control select2">
                                <option value="">انتخاب کنید....</option>
                                <option value="all">همه</option>
                                {foreach $objFunctions->getAirlines() as $Airline }
                                    <option value="{$Airline.abbreviation}" {if $smarty.post.AirlineIata eq $Airline.abbreviation} selected {/if}>{$Airline.name_fa}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                            <label for="IsAgency" class="control-label">نوع خریدار</label>
                            <select name="IsAgency" id="IsAgency" class="form-control select2">
                                <option value="">انتخاب کنید....</option>
                                <option value="agency" {if $smarty.post.IsAgency eq 'agency'} selected {/if}>کانتر
                                </option>
                                <option value="Ponline" {if $smarty.post.IsAgency eq 'Ponline'} selected {/if}>مسافر
                                    آنلاین
                                </option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="checkbox checkbox-success col-sm-6 ">

                                    <input id="checkBoxAdvanceSearch" type="checkbox" name="checkBoxAdvanceSearch"
                                           onclick="displayAdvanceSearch(this)">
                                    <label for="checkBoxAdvanceSearch" class="font-30"> جستجوی پیشرفته </label>

                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary pull-right">شروع جستجو</button>
                                </div>
                            </div>
                        </div>
                    {elseif $objsession->CheckAgencyPartnerLoginToAdmin()}
                        {assign var="agencyId" value=$objsession->getAgencyId() }
                        <div class="form-group col-sm-6">
                            <label for="client_id" class="control-label">نام کانتر</label>
                            <select name="CounterId" id="CounterId" class="form-control select2">
                                <option value="">انتخاب کنید....</option>
                                <option value="all">همه</option>
                                {foreach $objbook->listCounter($agencyId) as $Counter }
                                    <option value="{$Counter['id']}" {if $smarty.post.CounterId eq $Counter['id']} selected {/if}>{$Counter['name']} {$Counter['family']}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary pull-right">شروع جستجو</button>
                                </div>
                            </div>
                        </div>
                    {/if}


                    <div class="clearfix"></div>
                </form>
            </div>

        </div>
    </div>


    <div class="row">

        <div class="col-sm-12">

            <div class="white-box">

                <div class="box-btn-excel">
                    <a onclick="createExcelForReportTicket()" class="btn btn-primary waves-effect waves-light "
                       type="button" id="btn-excel">
                        <span class="btn-label"><i class="fa fa-download"></i></span>دریافت فایل اکسل</a>
                    <img src="../../pic/load.gif" alt="please wait ..." id="loader-excel" class="displayN">
                </div>

                <h3 class="box-title m-b-0">سوابق خرید</h3>
                <p class="text-muted m-b-30">کلیه سوابق خرید را در این لیست میتوانید مشاهده کنید
                </p>

                <div class="table-responsive">
                    <table id="ticketHistory" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>تاریخ خرید<br/>واچر<br/>بلیط<br/>پید</th>
                            <th>اطلاعات پرواز</th>
                            <th style="width: 77px;">نام خریدار <br/> نوع کاربر<br/>تعداد<br/>نوع کانتر</th>
                            <th>سهم آژانس</th>
                            <th style="direction: ltr">Total<br/>Fare</th>
                            {if $smarty.const.TYPE_ADMIN eq '1'}
                                <th> سهم ما</th>

                            {/if}
                            <th>پرداخت مسافر<br/>نام مسافر</th>
                            {if $smarty.const.TYPE_ADMIN eq '1'}
                                <th>نام آژانس</th>
                            {else}
                                <th>عملیات</th>
                            {/if}
                            <th>وضعیت</th>
                        </tr>
                        </thead>
                        <tbody>

                        {assign var="type" value="0"}

                        {assign var="price" value="0"}

                        {assign var="priceAgency" value="0"}

                        {assign var="pricesupplier" value="0"}

                        {assign var="priceMe" value="0"}

                        {assign var="price_api" value="0"}

                        {assign var="calc" value="0"}

                        {assign var="adt_qty" value="0"}

                        {assign var="chd_qty" value="0"}

                        {assign var="inf_qty" value="0"}

                        {assign var="charter_qty_type" value="0"}

                        {assign var="prSystem_qty_type" value="0"}

                        {assign var="pubSystem_qty_type" value="0"}

                        {assign var="charter_Price" value="0"}

                        {assign var="prSystem_Price" value="0"}

                        {assign var="pubSystem_Price" value="0"}

                        {assign var="totalQty" value="0"}





                        {assign var="number" value=$objbook->CountTicket}

                        {foreach key=key item=item from=$bookList}

                            {if $smarty.const.TYPE_ADMIN eq '1' && ($item.successfull eq 'book' || $item.successfull eq 'private_reserve') }
                            {$totalQty = ($item.adt_qty_f + $item.chd_qty_f + $item.inf_qty_f) + $totalQty}
                            {/if}
                            {assign  var='commission' value=$objFunctions->CommissionFlightSystemPublic($item.request_number)}
                            {$number = $number - 1}
                            {if $smarty.const.TYPE_ADMIN eq '1'}
                                {assign var="transactionLink" value="`$smarty.const.ROOT_ADDRESS_WITHOUT_LANG`/itadmin/transactionUser&id=`$item.client_id`"}
                            {/if}

                            {assign var="InfoMember" value=$objFunctions->infoMember($item.member_id,$item.client_id)}

                            <tr id="del-{$item.id}">
                                <td>{$number + 1}</td>

                                <td style="direction: ltr">


                                    {$objDate->jdate('Y-m-d (H:i:s)', $item.creation_date_int)}

                                    <hr style='margin:3px'>
                                    {$item.request_number}
                                    <hr style='margin:3px'>
                                    {$item.factor_number}
                                    <hr style='margin:3px'>
                                    {if $item.flight_type eq "charter"}
                                        چارتری
                                        <hr style='margin:3px'>
                                        چارتر {if $item.pid_private eq '1'}اختصاصی{else} اشتراکی{/if}
                                    {elseif $item.flight_type eq "system" }
                                        سیستمی
                                        <hr style='margin:3px'>
                                        {if $item.pid_private eq '1'} پیداختصاصی{else}پید اشتراکی{/if}
                                    {elseif $item.flight_type eq "charterPrivate"}
                                        چارتری
                                        <hr style='margin:3px'>
                                        رزرواسیون اختصاصی

                                    {else}
                                        نامشخص
                                    {/if}

                                </td>

                                <td>

                                    {if ($item.origin_city neq '') && ($item.desti_city neq '')}
                                        {$item.origin_city}({$item.origin_airport_iata})
                                        <br/>
                                        {$item.desti_city}({$item.desti_airport_iata})
                                    {else}
                                        {assign var="CityNameOrigin" value=$objFunctions->NameCityForeign($item.origin_airport_iata)}
                                        {assign var="CityNameDestination" value=$objFunctions->NameCityForeign($item.desti_airport_iata)}
                                        {$CityNameOrigin['DepartureCityFa']}({$item.origin_airport_iata})
                                        <br/>
                                        {$CityNameDestination['DepartureCityFa']}({$item.desti_airport_iata})
                                    {/if}
                                    <hr style='margin:3px'>
                                    {if $item.airline_name neq ''}
                                        {$item.airline_name}
                                    {else}
                                        {assign var="AirlineName" value=$objFunctions->InfoAirline($item.airline_iata)}
                                        {$AirlineName['name_fa']}
                                        {/if}
                                    ({$item.cabin_type})
                                    <hr style='margin:3px'>
                                    {$item.flight_number}
                                    <hr style='margin:3px'>

                                    {$objbook->format_hour($item.time_flight)}
                                    <hr style='margin:3px'>


                                    {$objbook->DateJalali($item.date_flight)}
                                </td>

                                     <td>

                                    {if $InfoMember['is_member'] eq '0'}                                        کاربر مهمان
                                        <hr style='margin:3px'>
                                        {$item.email_buyer}
                                    {else}
                                        {$item.member_name}
                                        <hr style='margin:3px'>
                                        کاربراصلی
                                    {/if}


                                    <hr style='margin:3px'>


                                    {$objbook->info_flight($item.request_number,$item.member_email)}

                                    {if $item.successfull eq 'book' || $item.successfull eq 'private_reserve'}
                                        {$adt_qty = ($objbook->adt_qty) + $adt_qty}
                                        {$chd_qty = ($objbook->chd_qty) + $chd_qty}
                                        {$inf_qty = ($objbook->inf_qty) + $inf_qty}
                                        {$charter_qty_type = (($objbook->charter_qty) + $charter_qty_type)}
                                        {$prSystem_qty_type = (($objbook->prSystem_qty) + $prSystem_qty_type)}
                                        {$pubSystem_qty_type = (($objbook->pubSystem_qty) + $pubSystem_qty_type)}
                                    {/if}

                                    <hr style='margin:3px'>
                                    {if $InfoMember.is_member eq '1'}  {if $InfoMember.fk_counter_type_id eq '5'}مسافر  {else} کانتر{/if} {$item.percent_discount} %ای{/if}

                                    {if $item.agency_id gt '0'}
                                        <hr style='margin:3px'>
                                        آژانس {$item.agency_name}
                                    {/if}
                                </td>

                                <td>
                                    {if $item.flight_type eq 'charter' ||  $item.flight_type eq 'system'}
                                        {if ($item.api_id eq '11' || $item.api_id eq '13' || $item.api_id eq '8') && ($item.flight_type eq 'system') && $item.pid_private eq '0'}
                                            {if $item.adt_fare_sum gt '0'}
                                                {$item.agency_commission}
                                            {else}
                                                {$commission['agencyCommission']}
                                            {/if}

                                        {else}
                                            {$item.agency_commission}
                                        {/if}
                                        {if $item.request_cancel neq confirm && ($item.successfull eq book || $item.successfull eq 'private_reserve')}
                                            {$priceAgency = $item.agency_commission + $priceAgency}
                                        {/if}
                                    {else}
                                        ---
                                    {/if}
                                </td>

                                <td>
                                    {if $item.flight_type neq 'charterPrivate'}
                                        {if $smarty.const.TYPE_ADMIN eq '1'}

                                            ({math equation="A+B+C" A=$item.adt_price B=$item.chd_price C=$item.inf_price})
                                            <br/>
                                            {if $item.adt_fare_sum gt '0'}
                                                {$item.adt_fare_sum + $item.chd_fare_sum + $item.inf_fare_sum|number_format }
                                            {else}
                                                {$commission['supplierCommission']|number_format}
                                            {/if}

                                            {if $item.request_cancel neq confirm && ($item.successfull eq book || $item.successfull eq 'private_reserve')}
                                                {$pricesupplier = $item.supplier_commission + $item.irantech_commission + $pricesupplier }
                                            {/if}

                                        {else}

                                            {if ($item.api_id eq '11' || $item.api_id eq '13' || $item.api_id eq '8') && $item.flight_type eq 'system' && $item.pid_private eq '0'}
                                                ({math equation="A+B+C" A=$item.adt_price B=$item.chd_price C=$item.inf_price})
                                                <br/>
                                                {if $item.adt_fare_sum gt '0'}
                                                    {$item.adt_fare_sum + $item.chd_fare_sum + $item.inf_fare_sum|number_format }
                                                {else}
                                                    {$commission['supplierCommission']|number_format}
                                                {/if}

                                            {else}
                                                {$item.supplier_commission|number_format}
                                            {/if}
                                            {if $item.request_cancel neq confirm && ($item.successfull eq book || $item.successfull eq 'private_reserve')}
                                                {$pricesupplier = $item.supplier_commission + $pricesupplier|number_format}
                                            {/if}

                                        {/if}

                                    {else}
                                        ---
                                    {/if}

                                </td>

                                {if $smarty.const.TYPE_ADMIN eq '1'}
                                    <td style="direction: ltr;">
                                        {if $item.flight_type neq 'charterPrivate'}
                                            {$item.irantech_commission|number_format}
                                            {if $item.request_cancel neq confirm && ($item.successfull eq book || $item.successfull eq 'private_reserve')}
                                                {$priceMe = $item.irantech_commission +$priceMe}
                                            {/if}
                                        {else}
                                            ----
                                        {/if}
                                    </td>
                             {*       <td>
                                        {if $item.flight_type neq 'charterPrivate'}
                                            {$item.api_commission}
                                            {if $item.request_cancel neq confirm && ($item.successfull eq book || $item.successfull eq 'private_reserve')}
                                                {$price_api = $item.api_commission +$price_api}
                                            {/if}
                                        {else}
                                            ----
                                        {/if}
                                    </td>*}
                                {/if}

                                <td>
                                    {if $item.flight_type neq 'charterPrivate'}
                                        {if $item.flight_type eq 'charter'}
                                            {if $item.percent_discount > 0}
                                                {$objFunctions->CalculateDiscount($item.request_number,'yes')|number_format}
                                                <hr style='margin:3px'>
                                                <span style="text-decoration: line-through;">
                                            {math equation="b+d+c" b=$item.agency_commission  d=$item.supplier_commission c=$item.irantech_commission}
                                                    {if $item.request_cancel neq confirm && ($item.successfull eq book || $item.successfull eq 'private_reserve')}
                                                        {$pricetotal = ($item.agency_commission + $item.supplier_commission + $item.irantech_commission) + $pricetotal}
                                                        {$charter_price = ($item.agency_commission + $item.supplier_commission + $item.irantech_commission + $charter_price)}
                                                    {/if}
                                           </span>
                                            {else}
                                                {$objFunctions->CalculateDiscount($item.request_number,'yes')}
                                                {if $item.request_cancel neq confirm && ($item.successfull eq book || $item.successfull eq 'private_reserve')}
                                                    {$pricetotal = ($item.agency_commission + $item.irantech_commission + $item.supplier_commission) + $pricetotal}
                                                    {$charter_price = ($item.agency_commission + $item.irantech_commission + $item.supplier_commission + $charter_price)}
                                                {/if}

                                            {/if}
                                        {elseif $item.flight_type eq 'system'}
                                            {if $item.percent_discount > 0}
                                                {$objFunctions->CalculateDiscount($item.request_number,'No')}
                                                <hr style='margin:3px'>
                                                <span style="text-decoration: line-through;">

                                                        {math equation="a+b+c" a=$item.adt_price b=$item.chd_price c=$item.inf_price}
                                                    {if $item.request_cancel neq confirm && ($item.successfull eq book ||  $item.successfull eq 'private_reserve')}
                                                        {$pricetotal = ($item.adt_price +$item.chd_price + $item.inf_price) + $pricetotal}

                                                        {if $item.pid_private eq '1'}
                                                            {$prsystem_price = ($item.adt_price +$item.chd_price + $item.inf_price + $prsystem_price)}
                                                        {else}
                                                            {$pubsystem_price = ($item.adt_price +$item.chd_price + $item.inf_price + $pubsystem_price)}
                                                        {/if}
                                                    {/if}
                                                    </span>
                                            {else}
                                                {if $item.IsInternal eq '0' || $item.api_id eq '14'}
                                                    {$objFunctions->CalculateDiscount($item.request_number,'No')}
                                                {else}
                                                    {math equation="a+b+c" a=$item.adt_price b=$item.chd_price c=$item.inf_price}
                                                {/if}

                                                {if $item.request_cancel neq confirm && ($item.successfull eq book ||  $item.successfull eq 'private_reserve')}
                                                    {$pricetotal = ($item.adt_price +$item.chd_price + $item.inf_price) + $pricetotal}
                                                    {if $item.pid_private eq '1'}
                                                        {$prsystem_price = ($item.adt_price +$item.chd_price + $item.inf_price  + $prsystem_price)}
                                                    {else}
                                                        {$pubsystem_price = ($item.adt_price +$item.chd_price + $item.inf_price  + $pubsystem_price)}
                                                    {/if}
                                                {/if}
                                            {/if}
                                        {/if}
                                    {else}

                                        <!--reservation-->
                                        {assign var="InfoTicketReservation" value=$objbook->getInfoTicketReservation($item.request_number)}
                                        {if $InfoTicketReservation['totalPriceWithoutDiscount'] neq 0}
                                            <span style="text-decoration: line-through;">
                                                {$InfoTicketReservation['totalPriceWithoutDiscount']|number_format:0:".":","}
                                            </span>
                                            <hr style='margin:3px'>
                                        {/if}
                                        {$InfoTicketReservation['totalPrice']|number_format:0:".":","}

                                        {$pricetotal = ($InfoTicketReservation['totalPrice']) + $pricetotal}

                                    {/if}
                                    <hr style='margin:3px'>
                                    <span class="font11">{$item.passenger_name} {$item.passenger_family}</span>
                                </td>

                                {if $smarty.const.TYPE_ADMIN eq '1'}
                                    <td>

                                        {if $item.type_app eq 'Web' || $item.type_app eq 'Application' || $item.type_app eq 'Api' }

                                            {if $item.successfull neq 'nothing' && $item.successfull neq 'error'}
                                                <div class="btn-group m-r-10">

                                                    <button aria-expanded="false" data-toggle="dropdown"
                                                            class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light"
                                                            type="button"> عملیات <span class="caret"></span></button>

                                                    <ul role="menu" class="dropdown-menu animated flipInY">
                                                        <li>
                                                            <div class="pull-left">
                                                                <div class="pull-left margin-10">
                                                                    {if $item.successfull neq 'nothing' && $item.successfull neq 'error'}
                                                                        <a onclick="ModalShowBook('{$item.request_number}');return false"
                                                                           data-toggle="modal"
                                                                           data-target="#ModalPublic">
                                                                            <i class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                                                               data-toggle="tooltip"
                                                                               data-placement="top" title=""
                                                                               data-original-title="مشاهده خرید"></i>
                                                                        </a>
                                                                    {/if}
                                                                </div>

                                                                {*<div class="pull-left margin-10">*}
                                                                {*{if $item.successfull eq 'book' || ($item.successfull eq 'private_reserve' &&  $smarty.const.TYPE_ADMIN eq '1')}*}
                                                                {*<a href="{$smarty.const.SERVER_HTTP}{$item.DomainAgency}/gds/eticketLocal&num={$item.request_number}"*}
                                                                {*target="_blank"*}
                                                                {*title="مشاهده اطلاعات خرید">*}
                                                                {*<i class="fcbtn btn btn-outline btn-danger btn-1c  tooltip-danger fa fa-print "*}
                                                                {*data-toggle="tooltip"*}
                                                                {*data-placement="top" title=""*}
                                                                {*data-original-title="مشاهده اطلاعات خرید"></i>*}
                                                                {*</a>*}
                                                                {*{/if}*}
                                                                {*</div>*}

                                                                <div class="pull-left margin-10">
                                                                    {if $item.successfull eq 'book' || ($item.successfull eq 'private_reserve' &&  $smarty.const.TYPE_ADMIN eq '1')}
                                                                        <a href="{$smarty.const.SERVER_HTTP}{$item.DomainAgency}/gds/pdf&target=boxCheck&id={$item.request_number}"
                                                                           target="_blank">
                                                                            <i class="fcbtn btn btn-outline btn-warning btn-1c  tooltip-warning fa fa-money "
                                                                               data-toggle="tooltip"
                                                                               data-placement="top" title=""
                                                                               data-original-title=" قبض صندوق"></i>

                                                                    {/if}
                                                                </div>
                                                                <div class="pull-left margin-10">
                                                                    {if $item.successfull eq 'book' || ($item.successfull eq 'private_reserve' &&  $smarty.const.TYPE_ADMIN eq '1')}

                                                                        <a href="{$smarty.const.SERVER_HTTP}{$item.DomainAgency}/gds/pdf&target=boxCheckCostumer&id={$item.request_number}"
                                                                           target="_blank">
                                                                            <i class="fcbtn btn btn-outline btn-primary btn-1c  tooltip-primary fa fa-money "
                                                                               data-toggle="tooltip"
                                                                               data-placement="top" title=""
                                                                               data-original-title=" قبض صندوق به تفکیک مشتریان"></i>
                                                                        </a>
                                                                    {/if}
                                                                </div>

                                                                {if $item.IsInternal eq '1'}
                                                                    <div class="pull-left margin-10">
                                                                        {if $item.successfull eq 'book' || ($item.successfull eq 'private_reserve' &&  $smarty.const.TYPE_ADMIN eq '1')}
                                                                            <a href="{$smarty.const.SERVER_HTTP}{$item.DomainAgency}/gds/pdf&target=parvazBookingLocal&id={$item.request_number}"
                                                                               target="_blank">
                                                                                <i class="fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-file-pdf-o "
                                                                                   data-toggle="tooltip"
                                                                                   data-placement="top" title=""
                                                                                   data-original-title="بلیط پارسی"></i>
                                                                            </a>
                                                                        {/if}
                                                                    </div>
                                                                {/if}

                                                                <div class="pull-left margin-10">
                                                                    {if $item.IsInternal eq '1'}
                                                                        {if $item.successfull eq 'book' || ($item.successfull eq 'private_reserve' &&  $smarty.const.TYPE_ADMIN eq '1')}
                                                                            <a href="{$smarty.const.SERVER_HTTP}{$item.DomainAgency}/gds/pdf&target=bookshow&id={$item.factor_number}"
                                                                               target="_blank" title="دانلود بلیط(pdf)">
                                                                                <i class="fcbtn btn btn-outline btn-success btn-1c  tooltip-success  fa fa-file-pdf-o"
                                                                                   data-toggle="tooltip"
                                                                                   data-placement="top" title=""
                                                                                   data-original-title=" بلیط انگلیسی "></i>
                                                                            </a>
                                                                        {/if}
                                                                    {else}
                                                                        {if $item.successfull eq 'book' || ($item.successfull eq 'private_reserve' &&  $smarty.const.TYPE_ADMIN eq '1')}
                                                                            <a href="{$smarty.const.SERVER_HTTP}{$item.DomainAgency}/gds/pdf&target=ticketForeign&id={$item.request_number}"
                                                                               target="_blank" title="دانلود بلیط(pdf)">
                                                                                <i class="fcbtn btn btn-outline btn-success btn-1c  tooltip-success  fa fa-file-pdf-o"
                                                                                   data-toggle="tooltip"
                                                                                   data-placement="top" title=""
                                                                                   data-original-title="چاپ بلیط"></i>
                                                                            </a>
                                                                        {/if}
                                                                    {/if}
                                                                </div>

                                                                <div class="pull-left margin-10">
                                                                    {if $item.successfull eq 'book' || ($item.successfull eq 'private_reserve' &&  $smarty.const.TYPE_ADMIN eq '1')}
                                                                        <a href="{$smarty.const.SERVER_HTTP}{$item.DomainAgency}/gds/pdf&target=parvazBookingLocal&id={$item.request_number}&cash=no"
                                                                           target="_blank">
                                                                            <i class="fcbtn btn btn-outline btn-default btn-1c tooltip-default fa fa-ticket "
                                                                               data-toggle="tooltip"
                                                                               data-placement="top" title=""
                                                                               data-original-title=" بلیط بدون قیمت "></i>
                                                                        </a>
                                                                    {/if}
                                                                </div>

                                                                 {if ($item.isInternal eq  '0' && $item.successfull eq 'book')|| ($item.pid_private eq '1' && $item.successfull eq 'private_reserve' && $smarty.const.TYPE_ADMIN eq '1' && $item.is_done_private neq '1')}
                                                                    <div class="pull-left margin-10">
                                                                        <a id="sendSms{$item.request_number}"
                                                                           onclick="DonePreReserve('{$item.request_number}','{$item.factor_number}','{$item.client_id}'); return false ; ">
                                                                            <i class="fcbtn btn btn-outline btn-danger btn-1c  tooltip-danger fa fa-times"
                                                                               data-toggle="tooltip"
                                                                               data-placement="top" title=""
                                                                               data-original-title="برای پیش رزرو کردن بلیط کلیک نمائید"></i>
                                                                        </a>
                                                                    </div>
                                                                {/if}

                                                                {if $smarty.const.TYPE_ADMIN eq '1'}
                                                                    <div class="pull-left margin-10">

                                                                        <a id="sendSms{$item.request_number}"
                                                                           onclick="insertPnr('{$item.request_number}','{$item.client_id}'); return false ; "
                                                                           data-toggle="modal"
                                                                           data-target="#ModalPublic">
                                                                            <i class="fcbtn btn btn-outline btn-info btn-1c  tooltip-info fa fa-book"
                                                                               data-toggle="tooltip"
                                                                               data-placement="top" title=""
                                                                               data-original-title="برای وارد کردن شماره بلیط و pnr کلیک کنید"></i>
                                                                        </a>

                                                                    </div>
                                                                {/if}
                                                                {if  ($item.successfull eq 'bank' || $item.successfull eq 'credit' )&& $smarty.const.TYPE_ADMIN eq '1'}
                                                                    <div class="pull-left margin-10">

                                                                        <a id="sendSms{$item.request_number}"
                                                                           onclick="FlightConvertToBook('{$item.request_number}','{$item.client_id}'); return false ; "
                                                                           data-toggle="modal"
                                                                           data-target="#ModalPublic">
                                                                            <i class="fcbtn btn btn-outline btn-info btn-1c  tooltip-info fa fa-book"
                                                                               data-toggle="tooltip"
                                                                               data-placement="top" title=""
                                                                               data-original-title="برا قطعی کردن بلیط کلیک نمائید"></i>
                                                                        </a>

                                                                    </div>
                                                                {/if}

                                                                <div class="pull-left margin-10">
                                                                    {if $smarty.const.TYPE_ADMIN eq '1'}
                                                                        <a id="SmsSend{$item.request_number}"
                                                                           onclick="ModalSendSms('{$item.request_number}'); return false ; "
                                                                           data-toggle="modal"
                                                                           data-target="#ModalPublic">
                                                                            <i class="fcbtn btn btn-outline btn-primary btn-1c  tooltip-primary fa fa-envelope-o"
                                                                               data-toggle="tooltip"
                                                                               data-placement="top" title=""
                                                                               data-original-title="برای ارسال پیام کلیک کنید"></i>
                                                                        </a>
                                                                    {/if}
                                                                </div>


                                                                {if ($item.successfull eq 'book' || $item.successfull eq 'private_reserve') && ($smarty.const.TYPE_ADMIN eq '1' || $smarty.const.CLIENT_ID eq '23')}
                                                                    <div class="pull-left margin-10">
                                                                        <a onclick="ModalSendInteractiveSms('{$item.factor_number}'); return false;"
                                                                           data-toggle="modal"
                                                                           data-target="#ModalPublic">
                                                                            <i class="fcbtn btn btn-outline btn-warning btn-1c  tooltip-warning fa fa-share"
                                                                               data-toggle="tooltip"
                                                                               data-placement="top" title=""
                                                                               data-original-title="برای ارسال مجدد کد ترانسفر کلیک کنید"></i>
                                                                        </a>
                                                                    </div>
                                                                {/if}

                                                                {*<div class="pull-left margin-10">*}
                                                                {*<a id="SendEmail{$item.request_number}"*}
                                                                {*onclick="ModalSenEmailForOther('{$item.request_number}'{if $item.client_id neq ''},'{$item.client_id }'{/if}); return false ; "*}
                                                                {*data-toggle="modal" data-target="#ModalPublic">*}
                                                                {*<i class="fcbtn btn btn-outline btn-info btn-1c  tooltip-info fa fa-envelope"*}
                                                                {*data-toggle="tooltip" data-placement="top"*}
                                                                {*title=""*}
                                                                {*data-original-title="برای ارسال ایمیل کلیک کنید"></i>*}
                                                                {*</a>*}
                                                                {*</div>*}

                                                            </div>

                                                        </li>


                                                    </ul>
                                                </div>
                                                <hr style='margin:3px'>
                                            {/if}
                                            <a href="{$transactionLink}" data-toggle="tooltip" data-placement="top"
                                               data-original-title="مشاهده تراکنش ها"
                                               target="_blank">{$item.NameAgency}</a>
                                            <br/>
                                            <hr style='margin:3px'>
                                            {if $item.payment_type eq 'cash' || $item.payment_type eq 'member_credit'}
                                                {if $item.payment_type eq 'cash'} نقدی {else} اعتباری {/if}

                                                {if $item.number_bank_port eq '379918'}

                                                    {if $item.flight_type eq 'charter' && $item.request_cancel neq confirm &&
                                                    ($item.successfull eq book || $item.successfull eq 'private_reserve')}

                                                        {$CashTotalMe = ($item.agency_commission +$item.irantech_commission +
                                                        $item.supplier_commission) + $CashTotalMe}

                                                    {elseif $item.flight_type eq 'system' && $item.request_cancel neq confirm &&
                                                    ($item.successfull eq book || $item.successfull eq 'private_reserve')}

                                                        {$CashTotalMe = ($item.adt_price + $item.chd_price + $item.inf_price) + $CashTotalMe}

                                                    {/if}

                                                {else}

                                                    {if $item.flight_type eq 'charter' && $item.request_cancel neq confirm &&
                                                    ($item.successfull eq book || $item.successfull eq 'private_reserve')}

                                                        {$CashTotalHe= ($item.agency_commission +$item.irantech_commission +
                                                        $item.supplier_commission) + $CashTotalHe}

                                                    {elseif $item.flight_type eq 'system' && $item.request_cancel neq confirm &&
                                                    ($item.successfull eq book || $item.successfull eq 'private_reserve')}

                                                        {$CashTotalHe = ($item.adt_price + $item.chd_price + $item.inf_price) + $CashTotalHe}

                                                    {/if}

                                                {/if}

                                            {elseif $item.payment_type eq 'credit'}
                                                اعتباری

                                                {if $item.flight_type eq 'charter' && $item.request_cancel neq confirm &&
                                                ($item.successfull eq book || $item.successfull eq 'private_reserve')}

                                                    {$CreditTotal= ($item.agency_commission +$item.irantech_commission +
                                                    $item.supplier_commission) + $CreditTotal}

                                                {elseif $item.flight_type eq 'system' && $item.request_cancel neq confirm &&
                                                ($item.successfull eq book || $item.successfull eq 'private_reserve')}

                                                    {$CreditTotal = ($item.adt_price +$item.chd_price + $item.inf_price) + $CreditTotal}

                                                {/if}

                                            {elseif $item.payment_type eq 'nothing'}
                                                نا مشخص
                                            {/if}

                                            {if $item.name_bank_port neq ''}
                                                <br>
                                                <hr style='margin:3px'>
                                                    {if $item.number_bank_port eq  $GetWayIranTech['userName'] || $item.number_bank_port eq  '5b8c0bc6-7f26-11ea-b1af-000c295eb8fc'  || $item.number_bank_port eq  '379918'}
                                                    درگاه سفر360
                                                {else}
                                                        درگاه خودش
                                                {/if}
                                            {/if}

                                            {if $item.api_id eq '1'}
                                                <hr style='margin:3px'>
                                                سرور5
                                            {elseif $item.api_id eq '5'}
                                                <hr style='margin:3px'>
                                                سرور 4
                                            {elseif $item.api_id eq '12'}
                                                <hr style='margin:3px'>
                                                سرور 12
                                            {elseif $item.api_id eq '13'}
                                                <hr style='margin:3px'>
                                                سرور 13
                                            {elseif $item.api_id eq '8'}
                                                <hr style='margin:3px'>
                                                سرور 7
                                            {elseif $item.api_id eq '10'}
                                                <hr style='margin:3px'>
                                                سرور 9
                                            {elseif $item.api_id eq '11'}
                                                <hr style='margin:3px'>
                                                سرور 10
                                            {elseif $item.api_id eq '14'}
                                                <hr style='margin:3px'>
                                                سرور 14
                                            {/if}


                                        {else}

                                            <!--reservation-->
                                            {if $item.successfull neq 'nothing' && $item.successfull neq 'error'}
                                                <div class="btn-group m-r-10">

                                                    <button aria-expanded="false" data-toggle="dropdown"
                                                            class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light"
                                                            type="button"> عملیات <span class="caret"></span></button>

                                                    <ul role="menu" class="dropdown-menu animated flipInY">
                                                        <li>
                                                            <div class="pull-left">

                                                                <div class="pull-left margin-10">
                                                                    {if $item.successfull neq 'nothing' && $item.successfull neq 'error'}
                                                                        <a onclick="ModalShowBook('{$item.request_number}');return false"
                                                                           data-toggle="modal"
                                                                           data-target="#ModalPublic">
                                                                            <i class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                                                               data-toggle="tooltip"
                                                                               data-placement="top" title=""
                                                                               data-original-title="مشاهده خرید"></i>
                                                                        </a>
                                                                    {/if}
                                                                </div>

                                                                {*<div class="pull-left margin-10">*}
                                                                {*{if $item.successfull eq 'book'}*}
                                                                {*<a href="{$smarty.const.SERVER_HTTP}{$item.DomainAgency}/gds/eReservationTicket&num={$item.request_number}"*}
                                                                {*target="_blank"*}
                                                                {*title="مشاهده اطلاعات خرید">*}
                                                                {*<i class="fcbtn btn btn-outline btn-danger btn-1c  tooltip-danger fa fa-print "*}
                                                                {*data-toggle="tooltip"*}
                                                                {*data-placement="top" title=""*}
                                                                {*data-original-title="مشاهده اطلاعات خرید"></i>*}
                                                                {*</a>*}
                                                                {*{/if}*}
                                                                {*</div>*}

                                                                <div class="pull-left margin-10">
                                                                    {if $item.successfull eq 'book'}
                                                                        <a href="{$smarty.const.SERVER_HTTP}{$item.DomainAgency}/gds/pdf&target=BookingReservationTicket&id={$item.request_number}"
                                                                           target="_blank">
                                                                            <i class="fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-file-pdf-o "
                                                                               data-toggle="tooltip"
                                                                               data-placement="top" title=""
                                                                               data-original-title=" بلیط پارسی "></i>
                                                                        </a>
                                                                    {/if}
                                                                </div>


                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <hr style='margin:3px'>
                                            {/if}
                                            <a href="{$transactionLink}" data-toggle="tooltip" data-placement="top"
                                               data-original-title="مشاهده تراکنش ها"
                                               target="_blank">{$item.NameAgency}</a>
                                        {/if}
                                        <hr style='margin:3px'>
                                        {$objFunctions->DetectDirection($item.factor_number,$item.request_number)}
                                    </td>
                                {else}
                                    <td>
                                        {if $item.type_app eq 'Web' || $item.type_app eq 'Application'}
                                            {if $item.successfull neq 'nothing' && $item.successfull neq 'error'}
                                                <div class="btn-group m-r-10">

                                                    <button aria-expanded="false" data-toggle="dropdown"
                                                            class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light"
                                                            type="button"> عملیات <span class="caret"></span></button>

                                                    <ul role="menu" class="dropdown-menu animated flipInY">
                                                        <li>
                                                            <div class="pull-left">
                                                                <div class="pull-left margin-10">
                                                                    {if $item.successfull neq 'nothing' && $item.successfull neq 'error'}
                                                                        <a onclick="ModalShowBook('{$item.request_number}');return false"
                                                                           data-toggle="modal"
                                                                           data-target="#ModalPublic">
                                                                            <i class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                                                               data-toggle="tooltip"
                                                                               data-placement="top"
                                                                               title=""
                                                                               data-original-title="مشاهده خرید"></i>
                                                                        </a>
                                                                    {/if}
                                                                </div>

                                                                <div class="pull-left margin-10">
                                                                    {if $item.successfull eq 'book' || ($item.successfull eq 'private_reserve' &&  $smarty.const.TYPE_ADMIN eq '1')}
                                                                        <a href="{$smarty.const.SERVER_HTTP}{$item.DomainAgency}/gds/pdf&target=boxCheck&id={$item.request_number}"
                                                                           target="_blank">
                                                                            <i class="fcbtn btn btn-outline btn-warning btn-1c  tooltip-warning fa fa-money "
                                                                               data-toggle="tooltip"
                                                                               data-placement="top"
                                                                               title=""
                                                                               data-original-title=" قبض صندوق"></i>
                                                                        </a>

                                                                    {/if}
                                                                </div>

                                                                <div class="pull-left margin-10">
                                                                    {if $item.successfull eq 'book' || ($item.successfull eq 'private_reserve' &&  $smarty.const.TYPE_ADMIN eq '1')}

                                                                        <a href="{$smarty.const.SERVER_HTTP}{$item.DomainAgency}/gds/pdf&target=boxCheckCostumer&id={$item.request_number}"
                                                                           target="_blank">
                                                                            <i class="fcbtn btn btn-outline btn-primary btn-1c  tooltip-primary fa fa-money "
                                                                               data-toggle="tooltip"
                                                                               data-placement="top" title=""
                                                                               data-original-title=" قبض صندوق به تفکیک مشتریان"></i>
                                                                        </a>
                                                                    {/if}
                                                                </div>


                                                                {if $item.IsInternal eq '1'}
                                                                    <div class="pull-left margin-10">
                                                                        {if $item.successfull eq 'book' || ($item.successfull eq 'private_reserve' &&  $smarty.const.TYPE_ADMIN eq '1')}
                                                                            <a href="{$smarty.const.SERVER_HTTP}{$item.DomainAgency}/gds/pdf&target=parvazBookingLocal&id={$item.request_number}"
                                                                               target="_blank">
                                                                                <i class="fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-file-pdf-o "
                                                                                   data-toggle="tooltip"
                                                                                   data-placement="top"
                                                                                   title=""
                                                                                   data-original-title=" بلیط پارسی "></i>
                                                                            </a>
                                                                        {/if}
                                                                    </div>
                                                                {/if}

                                                                <div class="pull-left margin-10">
                                                                    {if $item.IsInternal eq '1'}
                                                                        {if $item.successfull eq 'book' || ($item.successfull eq 'private_reserve' &&  $smarty.const.TYPE_ADMIN eq '1')}
                                                                            <a href="{$smarty.const.SERVER_HTTP}{$item.DomainAgency}/gds/pdf&target=bookshow&id={$item.factor_number}"
                                                                               target="_blank">
                                                                                <i class="fcbtn btn btn-outline btn-success btn-1c  tooltip-success  fa fa-file-pdf-o"
                                                                                   data-toggle="tooltip"
                                                                                   data-placement="top"
                                                                                   title=""
                                                                                   data-original-title=" بلیط انگلیسی "></i>
                                                                            </a>
                                                                        {/if}
                                                                    {else}
                                                                        {if $item.successfull eq 'book' || ($item.successfull eq 'private_reserve' &&  $smarty.const.TYPE_ADMIN eq '1')}
                                                                            <a href="{$smarty.const.SERVER_HTTP}{$item.DomainAgency}/gds/pdf&target=ticketForeign&id={$item.request_number}"
                                                                               target="_blank">
                                                                                <i class="fcbtn btn btn-outline btn-success btn-1c  tooltip-success  fa fa-file-pdf-o"
                                                                                   data-toggle="tooltip"
                                                                                   data-placement="top"
                                                                                   title=""
                                                                                   data-original-title=" بلیط انگلیسی "></i>
                                                                            </a>
                                                                        {/if}
                                                                    {/if}
                                                                </div>

                                                                <div class="pull-left margin-10">
                                                                    {if $item.successfull eq 'book' || ($item.successfull eq 'private_reserve' &&  $smarty.const.TYPE_ADMIN eq '1')}
                                                                        <a href="{$smarty.const.SERVER_HTTP}{$item.DomainAgency}/gds/pdf&target=parvazBookingLocal&id={$item.request_number}&cash=no"
                                                                           target="_blank">
                                                                            <i class="fcbtn btn btn-outline btn-default btn-1c tooltip-default fa fa-ticket "
                                                                               data-toggle="tooltip"
                                                                               data-placement="top"
                                                                               title=""
                                                                               data-original-title=" بلیط بدون قیمت "></i>
                                                                        </a>
                                                                    {/if}
                                                                </div>

                                                                <div class="pull-left margin-10">

                                                                    {if $smarty.const.TYPE_ADMIN eq '1'}
                                                                        <a id="SmsSend{$item.request_number}"
                                                                           onclick="ModalSendSms('{$item.request_number}'); return false ; "
                                                                           data-toggle="modal"
                                                                           data-target="#ModalPublic">
                                                                            <i class="fcbtn btn btn-outline btn-primary btn-1c  tooltip-primary fa fa-envelope-o"
                                                                               data-toggle="tooltip"
                                                                               data-placement="top"
                                                                               title=""
                                                                               data-original-title="برای ارسال پیام کلیک کنید"></i>
                                                                        </a>
                                                                    {/if}

                                                                    <a id="SendEmail{$item.request_number}"
                                                                       onclick="ModalSenEmailForOther('{$item.request_number}'{if $item.client_id neq ''},'{$item.client_id }'{/if}); return false ; "
                                                                       data-toggle="modal" data-target="#ModalPublic">
                                                                        <i class="fcbtn btn btn-outline btn-info btn-1c  tooltip-info fa fa-envelope"
                                                                           data-toggle="tooltip" data-placement="top"
                                                                           title=""
                                                                           data-original-title="برای ارسال ایمیل کلیک کنید"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <hr style='margin:3px'>
                                                {if $item.payment_type eq 'cash'} نقدی {else} اعتباری {/if}
                                                <hr style='margin:3px'>
                                                {$objFunctions->DetectDirection($item.factor_number,$item.request_number)}
                                            {/if}


                                        {else}
                                            <!--reservation-->
                                            {if $item.successfull neq 'nothing' && $item.successfull neq 'error'}
                                                <div class="btn-group m-r-10">

                                                    <button aria-expanded="false" data-toggle="dropdown"
                                                            class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light"
                                                            type="button"> عملیات <span class="caret"></span></button>

                                                    <ul role="menu" class="dropdown-menu animated flipInY">
                                                        <li>
                                                            <div class="pull-left">

                                                                <div class="pull-left margin-10">
                                                                    {if $item.successfull neq 'nothing' && $item.successfull neq 'error'}
                                                                        <a onclick="ModalShowBook('{$item.request_number}');return false"
                                                                           data-toggle="modal"
                                                                           data-target="#ModalPublic">
                                                                            <i class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                                                               data-toggle="tooltip"
                                                                               data-placement="top" title=""
                                                                               data-original-title="مشاهده خرید"></i>
                                                                        </a>
                                                                    {/if}
                                                                </div>

                                                                <div class="pull-left margin-10">
                                                                    {if $item.successfull eq 'book'}
                                                                        <a href="{$smarty.const.SERVER_HTTP}{$item.DomainAgency}/gds/eReservationTicket&num={$item.request_number}"
                                                                           target="_blank"
                                                                           title="مشاهده اطلاعات خرید">
                                                                            <i class="fcbtn btn btn-outline btn-danger btn-1c  tooltip-danger fa fa-print "
                                                                               data-toggle="tooltip"
                                                                               data-placement="top" title=""
                                                                               data-original-title="مشاهده اطلاعات خرید"></i>
                                                                        </a>
                                                                    {/if}
                                                                </div>

                                                                <div class="pull-left margin-10">
                                                                    {if $item.successfull eq 'book'}
                                                                        <a href="{$smarty.const.SERVER_HTTP}{$item.DomainAgency}/gds/pdf&target=BookingReservationTicket&id={$item.request_number}"
                                                                           target="_blank">
                                                                            <i class="fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-file-pdf-o "
                                                                               data-toggle="tooltip"
                                                                               data-placement="top" title=""
                                                                               data-original-title=" بلیط پارسی "></i>
                                                                        </a>
                                                                    {/if}
                                                                </div>

                                                                <div class="pull-left margin-10">
                                                                    {if $item.successfull eq 'book' || ($item.successfull eq 'private_reserve' &&  $smarty.const.TYPE_ADMIN eq '1')}

                                                                    <a onclick="ModalCancelAdmin('flight','{$item.request_number}');return false"
                                                                       target="_blank"  data-toggle="modal"
                                                                       data-target="#ModalPublic">
                                                                        <i class="fcbtn btn btn-outline btn-danger btn-1c  tooltip-danger fa fa-times "
                                                                           data-toggle="tooltip"
                                                                           data-placement="top" title=""
                                                                           data-original-title=" ثبت درخواست کنسلی پرواز"></i>
                                                                    </a>
                                                                    {/if}
                                                                </div>


                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <hr style='margin:3px'>
                                            {/if}
                                            <a href="{$transactionLink}" data-toggle="tooltip" data-placement="top"
                                               data-original-title="مشاهده تراکنش ها"
                                               target="_blank">{$item.NameAgency}</a>
                                            <hr style='margin:3px'>
                                            {$objFunctions->DetectDirection($item.factor_number,$item.request_number)}
                                        {/if}

                                        {if $item.api_id eq '1'}
                                            <hr style='margin:3px'>
                                            سرور5
                                        {elseif $item.api_id eq '5'}
                                            <hr style='margin:3px'>
                                            سرور 4
                                        {elseif $item.api_id eq '12'}
                                            <hr style='margin:3px'>
                                            سرور 12
                                        {elseif $item.api_id eq '13'}
                                            <hr style='margin:3px'>
                                            سرور 13
                                        {elseif $item.api_id eq '8'}
                                            <hr style='margin:3px'>
                                            سرور 7
                                        {elseif $item.api_id eq '10'}
                                            <hr style='margin:3px'>
                                            سرور 9
                                        {elseif $item.api_id eq '11'}
                                            <hr style='margin:3px'>
                                            سرور 10
                                        {/if}

                                    </td>
                                {/if}

                                <td>

                                    {if $item.type_app eq 'Web' || $item.type_app eq 'Application' || $item.type_app eq 'Api'}
                                        {if $item.successfull eq 'nothing'}
                                            <a href="#" onclick="return false;"
                                               class="btn btn-default cursor-default popoverBox  popover-default"
                                               data-toggle="popover" title="انصراف از خرید" data-placement="right"
                                               data-content="مسافر از تایید نهایی استفاده نکرده است"> انصراف از
                                                خرید </a>
                                        {elseif $item.successfull eq 'error'}
                                            {$objbook->btnErrorFlight($item)}
                                        {elseif $item.successfull eq 'prereserve'}
                                            <a href="#" onclick="return false;" class="btn btn-warning cursor-default">
                                                پیش رزرو </a>
                                        {elseif $item.successfull eq 'bank'}
                                            <a href="#" onclick="return false;"
                                               class="btn btn-primary cursor-default popoverBox  popover-primary"
                                               data-toggle="popover" title="هدایت به درگاه" data-placement="right"
                                               data-content="مسافر به درگاه بانکی منتقل شده است و سیستم در انتظار بازگشت از بانک است ،این خرید فقط در صورتی که بانک به سیستم کد تایید پرداخت را بدهد تکمیل میشود">
                                                هدایت به درگاه </a>
                                        {elseif $item.successfull eq 'credit'}
                                            <a href="#" onclick="return false;" class="btn btn-default cursor-default ">
                                                انتخاب گزینه اعتباری </a>
                                        {elseif $item.successfull eq 'processing'}
                                            <a href="#" onclick="return false;" class="btn btn-primary  cursor-primary ">
                                                در حال پردازش </a>
                                        {elseif $item.successfull eq 'private_reserve' && $item.pid_private eq '1' && $item.api_id eq '1'}
                                            <a href="#" onclick="return false;" class="btn btn-info cursor-default ">رزرو
                                                اختصاصی سرور 5</a>
                                        {elseif $item.successfull eq 'private_reserve' && $item.private_m4 eq '1'  && $item.IsInternal eq '0' && $item.api_id eq '10'}
                                            <a href="#" onclick="return false;" class="btn btn-primary cursor-default">رزرو
                                                اختصاصی سرور 9</a>
                                        {elseif $item.successfull eq 'book' && $item.private_m4 eq '1'  && $item.IsInternal eq '0' && $item.api_id eq '10'}
                                            <a href="#" onclick="return false;" class="btn btn-success cursor-default">رزرو سرور 9</a>
                                        {elseif $item.successfull eq 'private_reserve' && $item.private_m4 eq '1'  && $item.IsInternal eq '1' && $item.api_id eq '5'}
                                            <a href="#" onclick="return false;" class="btn btn-primary cursor-default">رزرو
                                                اختصاصی سرور 4</a>
                                        {elseif $item.successfull eq 'book' && $item.api_id eq '11' && $smarty.const.TYPE_ADMIN eq '1'}
                                            <a href="#" onclick="return false;" class="btn btn-info cursor-default">
                                                اشتراکی سرور 10</a>
                                        {elseif $item.successfull eq 'private_reserve' &&  $item.pid_private eq '1' && $item.api_id eq '12'}
                                            <a href="#" onclick="return false;" class="btn btn-info cursor-default ">رزرو
                                                اختصاصی سرور 12</a>
                                        {elseif $item.successfull eq 'book' &&  $item.pid_private eq '0' && $item.api_id eq '13'}
                                            <a href="#" onclick="return false;" class="btn btn-info cursor-default ">رزرو
                                                اشتراکی سرور 13</a>
                                        {elseif $item.successfull eq 'private_reserve' && $item.pid_private eq '1'  && $item.IsInternal eq '1' && $item.api_id eq '13'}
                                            <a href="#" onclick="return false;" class="btn btn-primary cursor-default">رزرو
                                                اختصاصی سرور 13</a>
                                        {elseif $item.successfull eq 'private_reserve' && $item.pid_private eq '1'  && $item.IsInternal eq '1' && $item.api_id eq '8'}
                                            <a href="#" onclick="return false;" class="btn btn-primary cursor-default">رزرو
                                                اختصاصی سرور 7</a>
                                        {elseif $item.successfull eq 'private_reserve' && $item.pid_private eq '1' && $item.api_id eq '14'}
                                            <a href="#" onclick="return false;" class="btn btn-info cursor-default ">رزرو
                                                اختصاصی سرور 14</a>
                                        {elseif $item.successfull eq 'book'}
                                            <a href="#" onclick="return false;" class="btn btn-success cursor-default">
                                                رزرو قطعی</a>

                                        {/if}



                                        {if $item.private_m4 eq '1' && ($item.successfull eq 'book' || $item.successfull eq 'private_reserve')}

                                            {if $item.pid_private eq '1' && $item.successfull eq 'private_reserve' }
                                                <hr style='margin:3px'>
                                                <a id="Jump2Step{$item.request_number}"
                                                   onclick="changeFlagBuyPrivate('{$item.request_number}')"
                                                   href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/{$smarty.const.FOLDER_ADMIN}/ticket/repeatStepSearch?ClientID={$item.client_id}&OriginIata={$item.origin_airport_iata}&DestinationIata={$item.desti_airport_iata}&DateFlight={$objFunctions->DateJalali($item.date_flight)}&RequestNumber={$item.request_number}&CabinType={$item.cabin_type}&FlightNumber={$item.flight_number}&AirLinIata={$item.airline_iata}"
                                                   target="_blank">
                                                    <i class="fcbtn btn btn-outline btn-info btn-1c  tooltip-info fa fa-shopping-cart"
                                                       data-toggle="tooltip" data-placement="right" title=""
                                                       data-original-title="برای ادامه خرید از سرور 5 کلیک نمائید"
                                                       id="i_Jump2Step{$item.request_number}"></i></a>
                                            {elseif $item.is_done_private eq '2' && $item.pid_private eq '1' && $item.successfull eq 'private_reserve'}
                                                <hr style='margin:3px'>
                                                <a id="nextChangeFlag"
                                                   onclick="changeFlagBuyPrivate('{$item.request_number}')"
                                                   href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/{$smarty.const.FOLDER_ADMIN}/ticket/repeatStepSearch?ClientID={$item.client_id}&OriginIata={$item.origin_airport_iata}&DestinationIata={$item.desti_airport_iata}&DateFlight={$objFunctions->DateJalali($item.date_flight)}&RequestNumber={$item.request_number}&CabinType={$item.cabin_type}&FlightNumber={$item.flight_number}&AirLinIata={$item.airline_iata}"
                                                   target="_blank">
                                                    <i class="fcbtn btn btn-outline btn-danger btn-1c  tooltip-danger fa fa-refresh"
                                                       data-toggle="tooltip" data-placement="right" title=""
                                                       data-original-title="در حال رزرو"></i></a>
                                            {/if}

                                            {if $item.pid_private eq '1' && $item.private_m4 eq '1' && ($item.successfull eq 'book' || $item.successfull eq 'private_reserve') && ($smarty.const.TYPE_ADMIN eq '1')}
                                                <a id="Jump2StepSourceFour{$item.request_number}"
                                                   onclick="changeFlagBuyPrivateToPublic('{$item.request_number}')"
                                                   href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/{$smarty.const.FOLDER_ADMIN}/ticket/repeatStepSearchSourceFour?ClientID={$item.client_id}&OriginIata={$item.origin_airport_iata}&DestinationIata={$item.desti_airport_iata}&DateFlight={$objFunctions->DateJalali($item.date_flight)}&RequestNumber={$item.request_number}&CabinType={$item.cabin_type}&FlightNumber={$item.flight_number}&AirLinIata={$item.airline_iata}"
                                                   target="_blank">
                                                    <i class="fcbtn btn btn-outline btn-primary btn-1c  tooltip-primary fa fa-search"
                                                       data-toggle="tooltip" data-placement="right" title=""
                                                       data-original-title="برای ادامه خرید از سرور 10 کلیک نمائید"
                                                       id="Jump2StepSourceFour{$item.request_number}"></i></a>
                                                <a id="Jump2StepSourceFour{$item.request_number}"
                                                   onclick="changeFlagBuyPrivateToPublic('{$item.request_number}')"
                                                   href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/{$smarty.const.FOLDER_ADMIN}/ticket/repeatStepSearchSourceFour?ClientID={$item.client_id}&OriginIata={$item.origin_airport_iata}&DestinationIata={$item.desti_airport_iata}&DateFlight={$objFunctions->DateJalali($item.date_flight)}&RequestNumber={$item.request_number}&CabinType={$item.cabin_type}&FlightNumber={$item.flight_number}&AirLinIata={$item.airline_iata}&SourceId=8"
                                                   target="_blank">
                                                    <i class="fcbtn btn btn-outline btn-primary btn-1c  tooltip-primary fa fa-search"
                                                       data-toggle="tooltip" data-placement="right" title=""
                                                       data-original-title="برای ادامه خرید از سرور 7 کلیک نمائید"
                                                       id="Jump2StepSourceFour{$item.request_number}"></i></a>
                                            {/if}

                                        {/if}

                                        {if  $item.pnr eq '' && $item.successfull eq 'book' && $smarty.const.TYPE_ADMIN eq '1' && $item.api_id eq '10'}
                                            <hr style='margin:3px'/>
                                     {*       <a id="Jump2StepSourceFour{$item.request_number}"
                                               onclick="changeFlagBuyPrivateToPublic('{$item.request_number}')"
                                               href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/{$smarty.const.FOLDER_ADMIN}/ticket/repeatSearchSourceNine?RequestNumber={$item.request_number}&OriginIata={$item.origin_airport_iata}&DestinationIata={$item.desti_airport_iata}&CabinType={$item.cabin_type}&FlightNumber={$item.flight_number}&AirLinIata={$item.airline_iata}"
                                               target="_blank">
                                                <i class="fcbtn btn btn-outline btn-primary btn-1c  tooltip-primary fa fa-search"
                                                   data-toggle="tooltip" data-placement="right" title=""
                                                   data-original-title="برای  رزرو  مجدد از سرور 9 کلیک نمائید"
                                                   id="Jump2StepSourceFour{$item.request_number}"></i></a>

*}
                                            <a id="Jump2StepSourceFour{$item.request_number}"
                                               onclick="changeFlagBuyPrivateToPublic('{$item.request_number}')"
                                               href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/{$smarty.const.FOLDER_ADMIN}/ticket/repeatSearchSourceNine?RequestNumber={$item.request_number}&TypeLevel=Final"
                                               target="_blank">
                                                <i class="fcbtn btn btn-outline btn-info btn-1c  tooltip-info fa fa-amazon"
                                                   data-toggle="tooltip" data-placement="right" title=""
                                                   data-original-title="برای ادامه خرید از سرور 9 کلیک نمائید"
                                                   id="Jump2StepSourceFour{$item.request_number}"></i></a>
                                        {/if}


                                        {*/***********************for source 10 in type admin *************************************/*}

                                        {if $item.pnr eq '' && $item.successfull eq 'book' && $smarty.const.TYPE_ADMIN eq '1'}

                                            {if $item.api_id eq '11'}
                                                <hr style='margin:3px'>
                                                <a id="Jump2StepPublic{$item.request_number}"
                                                   onclick="changeFlagBuySystemPublic('{$item.request_number}')"
                                                   href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/{$smarty.const.FOLDER_ADMIN}/ticket/repeatStepSearch?ClientID={$item.client_id}&OriginIata={$item.origin_airport_iata}&DestinationIata={$item.desti_airport_iata}&DateFlight={$objFunctions->DateJalali($item.date_flight)}&RequestNumber={$item.request_number}&CabinType={$item.cabin_type}&FlightNumber={$item.flight_number}&AirLinIata={$item.airline_iata}&Type=M10"
                                                   target="_blank">
                                                    <i class="fcbtn btn btn-outline btn-info btn-1c  tooltip-info fa fa-shopping-cart"
                                                       data-toggle="tooltip" data-placement="right" title=""
                                                       data-original-title="برای ادامه خرید از سرور 10 کلیک نمائید"
                                                       id="i_Jump2StepPublic{$item.request_number}"></i></a>
                                            {elseif $item.public_system_status eq '2'  && $item.successfull eq 'book' }
                                                <hr style='margin:3px'>
                                                <a id="nextChangeFlag"
                                                   onclick="changeFlagBuyPrivate('{$item.request_number}')"
                                                   href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/{$smarty.const.FOLDER_ADMIN}/ticket/repeatStepSearch?ClientID={$item.client_id}&OriginIata={$item.origin_airport_iata}&DestinationIata={$item.desti_airport_iata}&DateFlight={$objFunctions->DateJalali($item.date_flight)}&RequestNumber={$item.request_number}&CabinType={$item.cabin_type}&FlightNumber={$item.flight_number}&AirLinIata={$item.airline_iata}"
                                                   target="_blank">
                                                    <i class="fcbtn btn btn-outline btn-danger btn-1c  tooltip-danger fa fa-refresh"
                                                       data-toggle="tooltip" data-placement="right" title=""
                                                       data-original-title="در حال رزرو"></i></a>
                                            {/if}

                                            {if $item.api_id eq '11' && $item.pnr eq '' && ($item.successfull eq 'book') && ($smarty.const.TYPE_ADMIN eq '1')}
                                                <a id="Jump2StepPublic{$item.request_number}"
                                                   onclick="changeFlagBuyPrivateToPublic('{$item.request_number}')"
                                                   href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/{$smarty.const.FOLDER_ADMIN}/ticket/repeatStepSearchSourceFour?ClientID={$item.client_id}&OriginIata={$item.origin_airport_iata}&DestinationIata={$item.desti_airport_iata}&DateFlight={$objFunctions->DateJalali($item.date_flight)}&RequestNumber={$item.request_number}&CabinType={$item.cabin_type}&FlightNumber={$item.flight_number}&AirLinIata={$item.airline_iata}"
                                                   target="_blank">
                                                    <i class="fcbtn btn btn-outline btn-primary btn-1c  tooltip-primary fa fa-search"
                                                       data-toggle="tooltip" data-placement="right" title=""
                                                       data-original-title="برای ادامه خرید از سرور 10 کلیک نمائید"
                                                       id="i_Jump2StepPublic{$item.request_number}"></i></a>
                                            {/if}


                                        {/if}


                                        {if $item.pnr neq ''}
                                            <hr style='margin:3px'>
                                            {$item.pnr}

                                        {/if}
                                        <hr style='margin:3px'>
                                        {$item.remote_addr}
                                        <hr style='margin:3px'>
                                        {if $item.type_app eq 'Web'}                                            وب سایت
                                        {elseif $item.type_app eq 'Application'}                                            اپلیکیشن
                                        {elseif $item.type_app eq 'Api'}Api
                                        {/if}

                                    {else}
                                        <!--reservation-->
                                        {if $item.successfull eq 'book'}
                                            <a class="btn btn-success cursor-default" onclick="return false;"> رزرو
                                                قطعی</a>
                                        {elseif $item.successfull eq 'prereserve'}
                                            <a class="btn btn-warning cursor-default" onclick="return false;">پیش
                                                رزرو</a>
                                        {elseif $item.successfull eq 'bank' && $item.tracking_code_bank eq ''}
                                            <a class="btn btn-danger cursor-default" onclick="return false;">پرداخت
                                                اینترنتی نا موفق</a>
                                        {else}
                                            <a class="btn btn-danger cursor-default" onclick="return false;">نامشخص</a>
                                        {/if}
                                        <hr style='margin:3px'>
                                        بلیط رزرواسیون

                                    {/if}
                                </td>
                            </tr>
                        {/foreach}
                        </tbody>
                        <tfoot>
                        <tr>

                            <th colspan="3"></th>
                            <th colspan="">({$priceAgency|number_format})ريال</th>
                            <th colspan="">({$pricesupplier|number_format})ريال</th>
                            {if $smarty.const.TYPE_ADMIN eq '1'}
                                <th colspan="">({$priceMe|number_format})ريال</th>
                            {/if}
                            {if $smarty.const.TYPE_ADMIN eq '1'}
                                <th colspan="">({$price_api|number_format})ريال</th>
                            {/if}
                            <th colspan="1">({$pricetotal|number_format})ريال</th>
                            <th></th>


                        </tr>


                        {if $smarty.const.TYPE_ADMIN eq '1'}
                            <tr>
                                <th colspan="11">جمع کل({$totalQty})نفر</th>
                                {*<th colspan="4">جمع کودک({$chd_qty})نفر</th>
                                <th colspan="4">جمع نوزاد({$inf_qty})نفر</th>*}
                            </tr>

                        {*
                         <tr>
                                <th colspan="3">جمع نقدی درگاه ما :({$CashTotalMe|number_format})ریال</th>
                                <th colspan="4"> جمع نقدی درگاه مشتریان({$CashTotalHe|number_format}) ریال</th>
                                <th colspan="3">جمع اعتباری({$CreditTotal|number_format})ریال</th>
                            </tr>
                          <tr>
                              <th colspan="3">جمع چارتری({$charter_qty_type})نفر</th>
                              <th colspan="4">جمع اختصاصی({$prSystem_qty_type})نفر</th>
                              <th colspan="4">جمع اشتراکی({$pubSystem_qty_type})نفر</th>
                          </tr>
                          <tr>
                              <th colspan="4">جمع چارتری :({$charter_price|number_format})ریال</th>
                              <th colspan="4"> جمع سیستمی اشتراکی({$pubSystem_Price|number_format}) ریال</th>
                              <th colspan="4">جمع سیستمی اختصاصی({$prSystem_Price|number_format})ریال</th>
                          </tr>*}
                      {/if}

                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="i-section">
    <div class="i-info">
        <span> ویدیو آموزشی بخش سوابق خرید بلیط </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/370/---.html" target="_blank" class="i-btn"></a>

</div>
{if $smarty.post.checkBoxAdvanceSearch neq ''}
{literal}
    <script type="text/javascript">
        $('document').ready(function () {
            $('.showAdvanceSearch').fadeIn();
            $('#checkBoxAdvanceSearch').attr('checked', true);
        });
    </script>
{/literal}
{/if}


<script type="text/javascript" src="assets/JsFiles/bookshow.js"></script>
{/if}
