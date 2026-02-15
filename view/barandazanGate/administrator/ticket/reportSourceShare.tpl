{load_presentation_object filename="bookshow" assign="objbook"}
{load_presentation_object filename="source" assign="objSource"}
{load_presentation_object filename="services" assign="objService"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>حسابداری</li>
                <li class="active">گزارش سهم منابع</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">جستجو </h3>

                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید سوابق را در تاریخ های مورد نظرتان جستجو
                    کنید
                </p>

                <form id="SearchTicketHistory" method="post" action="">

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

                    {*<div class="form-group col-sm-6">
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
                    </div>*}


                    <div class="form-group col-sm-6">
                        <label for="request_number" class="control-label">کد واچر</label>
                        <input type="text" class="form-control " name="request_number"
                               value="{$smarty.post.request_number}" id="request_number"
                               placeholder="کد واچر را وارد نمائید">

                    </div>

                    {if $objsession->adminIsLogin()}

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

                        <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                            <label for="passenger_name" class="control-label">نام یا نام خانوادگی مسافر</label>
                            <input type="text" class="form-control " name="passenger_name"
                                   value="{$smarty.post.passenger_name}" id="passenger_name"
                                   placeholder="تاریخ پایان جستجو را وارد نمائید">

                        </div>

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
                                <option value="cash" {if $smarty.post.payment_type eq 'cash' }selected{/if}>نقدی</option>
                                <option value="credit" {if $smarty.post.payment_type eq 'credit' }selected{/if}>اعتباری</option>
                            </select>
                        </div>

                        <div class="form-group col-sm-6 showAdvanceSearch " style="display: none;">
                            <label for="DateFlight" class="control-label">تاریخ پرواز</label>
                            <input type="text" class="form-control datepicker" name="DateFlight" value="{$smarty.post.DateFlight}"
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
                <h3 class="box-title m-b-0">گزارش سهم منابع</h3>
                <p class="text-muted m-b-30">کلیه سهم منابع پرواز را در این لیست میتوانید مشاهده کنید
                </p>
                <div class="table-responsive">
                    <table class="table table-striped text-center doDataTable">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th class="text-center">آژانس | شماره فاکتور | تعداد <br /> خدمات | منبع</th>
                            <th>Fare</th>
                            <th>Total</th>
                            <th>درصد سود خریدار | مقدار</th>
                            <th>فروش به مسافر</th>
                            <th>درصد همکار | سود همکار</th>
                            <th>سهم ایران تک</th>
                            <th>سود آژانس</th>
                            <th>کسر در ایرلاین</th>
                            <th>کسر از اعتبار آژانس</th>
                            <th>کسر از اعتبار زیرمجموعه</th>
                        </tr>
                        </thead>
                        <tbody>

                        {assign var='number' value=0}
                        {foreach key=key item=item from=$objbook->listSourceShare()}
                            {$number= $number + 1}

                            {assign var="trustSource" value=$objSource->getFlightSourceByTrustID($item.api_id)}
                            {assign var="serviceInfo" value=$objService->getServiceByTitle($item.serviceTitle)}

                            {assign var="fare" value=0}
                            {assign var="total" value=0}
                            {assign var="airlineCost" value=0}
                            {assign var="saleToCustomerCost" value=0}

                            {if $item.type_app eq 'Web' || $item.type_app eq 'Application'}

                                {if $item.flight_type eq 'charter'}
                                    {$total = $item.adt_price + $item.chd_price + $item.inf_price + $item.irantech_commmission + $item.api_commission}
                                {elseif $item.flight_type eq 'system' && $item.pid_private eq '1'}
                                    {$total = $item.adt_price + $item.chd_price + $item.inf_price + $item.irantech_commmission}
                                {elseif $item.flight_type eq 'system' && $item.pid_private eq '0'}
                                    {$total = $item.adt_price + $item.chd_price + $item.inf_price + $item.irantech_commmission}
                                {/if}

                                {$fare = $total - ($total * (4573/100000))}
                                {$airlineCost = $total - ($fare * (5/100))}
                                {$saleToCustomerCost = $objFunctions->CalculateDiscount($item.request_number, 'yes')}

                            {else}

                                {$total = $item.adt_price + $item.chd_price + $item.inf_price}
                                {$saleToCustomerCost = $item.total_price}

                            {/if}

                            <tr>
                                <td>{$number}</td>
                                <td>{$item.NameAgency} | {$item.factor_number}<br /> {$serviceInfo.TitleFa} | {if $trustSource.Title neq ''}{$trustSource.Title}{else}رزرواسیون{/if}</td>
                                <td>{$fare|number_format}</td>
                                <td>{$total|number_format}</td>
                                <td>???</td>
                                <td>{$saleToCustomerCost|number_format}</td>
                                <td>{$item.percent_discount}%</td>
                                <td>{$item.irantech_commission|number_format}</td>
                                <td>???</td>
                                <td>{$airlineCost|number_format}</td>
                                <td>{$item.credit|number_format}</td>
                                <td>{$item.subCredit|number_format}</td>
                            </tr>
                        {/foreach}
                        </tbody>
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
