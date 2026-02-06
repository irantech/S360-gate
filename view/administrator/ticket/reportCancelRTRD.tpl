{load_presentation_object filename="listCancel" assign="objCancel"}
{load_presentation_object filename="bookshow" assign="objbook"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>حسابداری</li>
                <li class="active">گزارش کنسلی RR</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">گزارشRR </h3>

                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید سوابق را در تاریخ های مورد نظرتان جستجو
                    کنید
                </p>

                <form id="SearchTicketHistory" method="post" action="{$smarty.const.rootAddress}reportCancelRTRD">

                    <div class="form-group col-sm-6 ">
                        <label for="date_of" class="control-label">تاریخ شروع</label>
                        <input type="text" class="form-control datepicker" name="date_of" value="{$smarty.post.date_of}"
                               id="date_of" placeholder="تاریخ شروع جستجو را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="to_date" class="control-label">تاریخ پایان</label>
                        <input type="text" class="form-control datepickerReturn" name="to_date"
                               value="{$smarty.post.to_date}" id="to_date"
                               placeholder="تاریخ پایان جستجو را وارد نمائید">

                    </div>


                        <div class="form-group col-sm-6">
                            <label for="flight_type" class="control-label">نوع پرواز</label>
                            <select name="flight_type" id="flight_type" class="form-control">
                                <option value="">انتخاب کنید....</option>
                                <option value="all">همه</option>
                                <option value="charterSourceFour" {if $smarty.post.flight_type eq 'charterSourceFour' }selected{/if}>چارتری سرور 4</option>
                                <option value="charterSourceSeven" {if $smarty.post.flight_type eq 'charterSourceSeven' }selected{/if}>چارتری سرور 7</option>
                                <option value="SystemSourceFour" {if $smarty.post.flight_type eq 'SystemSourceFour' }selected{/if}>سیستمی سرور 4</option>
                                <option value="SystemSourceFive" {if $smarty.post.flight_type eq 'SystemSourceFive' }selected{/if}>سیستمی سرور 5</option>
                                <option value="SystemSourceTen" {if $smarty.post.flight_type eq 'SystemSourceTen' }selected{/if}>سیستمی سرور 10</option>
                                <option value="SystemSourceForeignNine" {if $smarty.post.flight_type eq 'SystemSourceForeignNine' }selected{/if}>سیستمی خارجی سرور 9</option>
                            </select>
                        </div>


                    <div class="form-group col-sm-6">
                        <label for="request_number" class="control-label">کد واچر</label>
                        <input type="text" class="form-control " name="request_number"
                               value="{$smarty.post.request_number}" id="request_number"
                               placeholder="کد واچر را وارد نمائید">

                    </div>


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


                        {/if}

                    <div class="form-group col-sm-6">
                        <label for="StatusConfirm" class="control-label">وضعیت کنسلی</label>
                        <select name="StatusConfirm" id="StatusConfirm" class="form-control select2">
                            <option value="">انتخاب کنید....</option>
                            <option value="Confirm" {if $smarty.post.StatusConfirm eq 'Confirm'} selected {/if}>تایید شده</option>
                            <option value="NotVerified" {if $smarty.post.StatusConfirm eq 'NotVerified'} selected {/if}>تایید نشده</option>
                        </select>
                    </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary pull-right">شروع جستجو</button>
                                </div>
                            </div>
                        </div>
                    <div class="clearfix"></div>
                </form>
            </div>

        </div>
    </div>

    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">گزارش RR</h3>
                <p class="text-muted m-b-30">کلیه سوابق خرید را در این لیست میتوانید مشاهده کنید
                </p>
                <div class="table-responsive">
                    <table id="RTRDRepoert" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            {if $smarty.const.TYPE_ADMIN eq '1'}
                                <th>نام آژانس</th>
                            {/if}
                            <th>نام سرور</th>
                            <th>شماره فاکتور</th>
                            {*<th>شماره تراکنش</th>*}
                            <th>تاریخ خرید</th>
                            <th>شماره بلیط
                            </th>
                            <th> ایرلاین </th>
                            <th>نام مسافر</th>
                            <th>مسیر</th>
                            <th>FARE</th>
                            <th>TAX</th>
                            <th>TOTAL</th>
                            <th>COMMISSION</th>
                            <th>PROVIDER</th>
                            <th>PENALTY</th>
                        </tr>
                        </thead>
                        <tbody>
                        
                        {assign var='number' value=0}
                        {assign var='FareTotlaPrice' value=0}
                        {assign var='TaxTotlaPrice' value=0}
                        {assign var='TotlaPrice' value=0}
                        {assign var='ComTotlalPrice' value=0}
                        {assign var='RecivedTotlaPrice' value=0}
                        {assign var='Penalty' value=0}
                        {foreach key=key item=item from=$objCancel->CancelRTRD()}
                            {if $item.flight_type eq 'charter'}
                                {assign var='Pricetotal' value=($item.adt_price +$item.chd_price+$item.inf_price) + $item.irantech_commmission }
                            {elseif $item.flight_type eq 'system' && $item.pid_private eq '1'}
                                {assign var='Pricetotal' value=($item.adt_price +$item.chd_price+$item.inf_price)}
                            {elseif $item.flight_type eq 'system' && $item.pid_private eq '0'}
                                {assign var='Pricetotal' value=($item.adt_price +$item.chd_price+$item.inf_price)}
                            {/if}

                            {if $item.flight_type eq 'system'}
                                {if $item.adt_fare gt 0 || $item.chd_fare gt 0 || $item.inf_fare gt 0}
                                    {assign var='ShowPriceFare' value=($item.adt_fare+$item.chd_fare+$item.inf_fare)}
                                {else}
                                    {assign var='ShowPriceFare' value=($Pricetotal - ($Pricetotal * (4573/100000)))|round}
                                {/if}
                            {else}
                                {assign var='ShowPriceFare' value='0'}
                            {/if}

                            {$number= $number + 1}
                            <tr id="del-{$item.id}">
                                <td>{$number}</td>
                                {if $smarty.const.TYPE_ADMIN eq '1'}
                                    <td>{$item.AgencyName}</td>
                                {/if}
                                <td>
                                    {if $item.api_id eq '1'}
                                        سرور5
                                    {elseif $item.api_id eq '5'}
                                        سرور 4

                                    {elseif $item.api_id eq '8'}
                                        سرور 7
                                    {elseif $item.api_id eq '10'}
                                        سرور 9
                                    {elseif $item.api_id eq '11'}
                                        سرور 10

                                    {/if}
                                    <hr style="margin: 3px" />
                                    {if $item.flight_type eq 'charter'}
                                        چارتری
                                    {elseif $item.flight_type eq 'system'}
                                        سیستمی
                                    {/if}

                                </td>


                                <td>{$item.factor_number}</td>
                                {*<td>{if $item.tracking_code_bank neq ''} {$item.tracking_code_bank} {else}  ندارد{/if}</td>*}
                                <td dir="ltr" class="text-left">
                                    {$objDate->jdate('Y-m-d (H:i:s)', $item.creation_date_int)}
                                </td>
                                <td>
                                    {$item.eticket_number}
                                    {if $item.cancel eq $item.request_number && $item.cancel neq '' && $item.request_cancel eq 'confirm'}
                                        <hr>
                                        <span style="color: red">کنسل شده-تایید شده</span>
                                    {/if}

                                </td>
                                <td>
                                    {$item.airline_iata}
                                </td>

                                <td>
                                    {if $item.passenger_name neq '' &&  $item.passenger_family neq ''}
                                        {$item.passenger_name} {$item.passenger_family}
                                    {else}
                                        {$item.passenger_name_en} {$item.passenger_family_en}
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
                                </td>
                                <td>
                                    {$objFunctions->numberFormat($ShowPriceFare)}
                                    {$FareTotlaPrice = $ShowPriceFare + $FareTotlaPrice}
                                </td>
                                <td>

                                    {if $item.adt_tax gt 0 || $item.chd_tax gt 0 || $item.inf_tax gt 0}
                                        {assign var="ShowTaxFare" value=($item.adt_tax + $item.chd_tax + $item.inf_tax)}
                                    {else}
                                        {assign var="ShowTaxFare" value=$Pricetotal - $ShowPriceFare}
                                    {/if}
                                    {$objFunctions->numberFormat($ShowTaxFare)}
                                    {$TaxTotlaPrice = $ShowTaxFare + $TaxTotlaPrice}

                                </td>
                                <td>

                                    {$objFunctions->numberFormat($Pricetotal)}
                                    {$TotlaPrice = $Pricetotal + $TotlaPrice}
                                </td>
                                <td>
                                    {assign var="ComPrice" value=$item.agency_commission}
                                    {$objFunctions->numberFormat($ComPrice)}

                                    {$ComTotlalPrice = $ComPrice + $ComTotlalPrice}
                                </td>
                                <td>
                                    {$objFunctions->numberFormat($item.supplier_commission)}
                                    {$RecivedTotlaPrice = $item.supplier_commission + $RecivedTotlaPrice}
                                </td>
                                <td>
                                    {$objFunctions->numberFormat($item.PriceIndemnity/$item.CountIdDetail)}
                                    <hr/>
                                    <span style="color: red">{$item.PercentIndemnity}%</span>
                                    {$Penalty = ($item.PriceIndemnity/$item.CountIdDetail) + $Penalty}
                                </td>

                            </tr>
                        {/foreach}
                        </tbody>
                        <tfoot>
                        <tr>

                            <th colspan="{if $smarty.const.TYPE_ADMIN eq '1'} 9{else}8{/if}"></th>
                            <th colspan="">({$FareTotlaPrice|number_format})ريال</th>
                            <th colspan="">({$TaxTotlaPrice|number_format})ريال</th>
                            <th colspan="">({$TotlaPrice|number_format})ريال</th>
                            <th colspan="">({$ComTotlalPrice|number_format})ريال</th>
                            <th colspan="">({$RecivedTotlaPrice|number_format})ريال</th>
                            <th colspan="">({$Penalty|number_format})ريال</th>
                            <th></th>


                        </tr>

                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
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
