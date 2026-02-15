{load_presentation_object filename="bookshowTest" assign="objbook"}
{load_presentation_object filename="bookhotelshow" assign="objRsult"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>گزارش خرید</li>
                <li class="active">سوابق خرید </li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>
    </div>


    <div class="row">

        <div class="col-sm-12">

            <div class="white-box">

                <h3 class="box-title m-b-0">سوابق خرید</h3>
                <p class="text-muted m-b-30">کلیه سوابق خرید را در این لیست میتوانید مشاهده کنید
                </p>

                <form id="FormExecuteHistoryFilter" action="{$smarty.const.rootAddress}mainTicketHistory" method="post">
                    <input type="hidden" name="member_id" value='{$smarty.get.id}'>
                    {if isset($smarty.get.agencyID)}
                        <input type="hidden" name="agency_id" value='{$smarty.get.agencyID}'>
                    {/if}

                    <input type="hidden" name="RowCounter" id="RowCounter">
                    <div class="d-none" data-info="filter-div" data-target="flight">
                        <input type="hidden" name="flag" id="flag" value="createExcelFile">
                    </div>
                    <div class="d-none" data-info="filter-div" data-target="hotel">
                        <input type="hidden" name="flag" id="flag" value="createExcelFile">
                    </div>
                    <div class="d-none" data-info="filter-div" data-target="insurance">
                        <input type="hidden" name="flag" id="flag" value="createExcelFileForInsurance">
                    </div>
                    <div class="d-none" data-info="filter-div" data-target="visa">
                        <input type="hidden" name="flag" id="flag" value="createExcelFile">
                    </div>
                    <div class="d-none" data-info="filter-div" data-target="gasht">
                        <input type="hidden" name="flag" id="flag" value="createExcelFile">
                    </div>
                    <div class="d-none" data-info="filter-div" data-target="tour">
                        <input type="hidden" name="flag" id="flag" value="createExcelFile">
                    </div>
                    <div class="d-none" data-info="filter-div" data-target="bus">
                        <input type="hidden" name="flag" id="flag" value="createExcelFile">
                    </div>
                    <div class="d-none" data-info="filter-div" data-target="train">
                        <input type="hidden" name="flag" id="flag" value="createExcelFile">
                    </div>
                    <div class="d-none" data-info="filter-div" data-target="entertainment">
                        <input type="hidden" name="flag" id="flag" value="createExcelFile">
                    </div>


                    <div class="form-group col-sm-6">
                        <label for="date_of" class="control-label">تاریخ شروع (خرید)</label>
                        <input type="text" class="form-control datepicker" name="date_of" value="{$objFunctions->timeNow()}"
                               autocomplete="off"
                               id="date_of" placeholder="تاریخ شروع جستجو را وارد نمائید">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="to_date" class="control-label">تاریخ پایان (خرید)</label>
                        <input type="text" class="form-control datepickerReturn" name="to_date"
                               value="{$objFunctions->timeNow()}" id="to_date"
                               autocomplete="off"
                               placeholder="تاریخ پایان جستجو را وارد نمائید">
                    </div>
                    <div class="d-none" data-info="filter-div" data-target="flight">
                        <div class="form-group col-sm-6">
                            <label for="successfull" class="control-label">وضعیت رزرو</label>
                            <select name="successfull" id="successfull" class="form-control">
                                <option value="">انتخاب کنید....</option>
                                <option value="all" {if $smarty.post.successfull eq 'all' }selected{/if}>همه</option>
                                <option value="book" {if $smarty.post.successfull eq  'book' }selected{/if}>موفق
                                </option>
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
                                            {if $smarty.post.flight_type eq 'charterSourceFour' }selected{/if}>چارتری
                                        سرور 4
                                    </option>
                                    <option value="charterSourceSeven"
                                            {if $smarty.post.flight_type eq 'charterSourceSeven' }selected{/if}>چارتری
                                        سرور
                                        7
                                    </option>
                                    <option value="SystemSourceFour"
                                            {if $smarty.post.flight_type eq 'SystemSourceFour' }selected{/if}>سیستمی
                                        سرور 4
                                    </option>
                                    <option value="SystemSourceSeven"
                                            {if $smarty.post.flight_type eq 'SystemSourceSeven' }selected{/if}>سیستمی
                                        سرور 7
                                    </option>
                                    <option value="SystemSourceFive"
                                            {if $smarty.post.flight_type eq 'SystemSourceFive' }selected{/if}>سیستمی
                                        سرور 5
                                    </option>
                                    <option value="SystemSourceTen"
                                            {if $smarty.post.flight_type eq 'SystemSourceTen' }selected{/if}>سیستمی سرور
                                        10
                                    </option>
                                    <option value="SystemSourceForeignNine"
                                            {if $smarty.post.flight_type eq 'SystemSourceForeignNine' }selected{/if}>
                                        سیستمی
                                        خارجی سرور 9
                                    </option>
                                    <option value="charterSourceNine"
                                            {if $smarty.post.flight_type eq 'charterSourceNine' }selected{/if}>چارتری
                                        سرور 9
                                    </option>
                                </select>
                            </div>
                        {else}
                            <div class="form-group col-sm-6">
                                <label for="flight_type" class="control-label">نوع پرواز</label>
                                <select name="flight_type" id="flight_type" class="form-control">
                                    <option value="">انتخاب کنید....</option>
                                    <option value="all">همه</option>
                                    <option value="charter" {if $smarty.post.flight_type eq 'charter' }selected{/if}>
                                        چاتری
                                    </option>
                                    <option value="system" {if $smarty.post.flight_type eq 'system' }selected{/if}>
                                        سیستمی
                                    </option>
                                    <option value="charterPrivate"
                                            {if $smarty.post.flight_type eq 'charterPrivate' }selected{/if}>چارتری
                                        اختصاصی
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
                                    <option value="all" {if $smarty.post.payment_type eq 'all' }selected{/if}>همه
                                    </option>
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
                        {/if}

                    </div>
                    <div class="d-none" data-info="filter-div" data-target="hotel">
                        <div class="form-group col-sm-6">
                            <label for="status" class="control-label">وضعیت رزرو</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">انتخاب کنید....</option>
                                <option value="all" {if $smarty.post.status eq 'all' }selected{/if}>همه</option>
                                <option value="book" {if $smarty.post.status eq  'book' }selected{/if}>موفق</option>
                                <option value="nothing" {if $smarty.post.status eq 'nothing' }selected{/if}>ناموفق
                                </option>
                            </select>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="factor_number" class="control-label">شماره فاکتور</label>
                            <input type="text" class="form-control " name="factor_number"
                                   value="{$smarty.post.factor_number}" id="factor_number"
                                   placeholder="شماره فاکتور را وارد نمائید">
                        </div>

                        {if $objsession->adminIsLogin()}
                            {if $smarty.const.TYPE_ADMIN eq '1'}
                                <div class="form-group col-sm-6">
                                    <label for="client_id" class="control-label">نام همکار</label>
                                    <select name="client_id" id="client_id" class="form-control ">
                                        <option value="">انتخاب کنید....</option>
                                        <option value="all">همه</option>
                                        {foreach $objbook->list_hamkar() as $client }
                                            <option value="{$client.id}" {if $smarty.post.client_id eq $client.id} selected {/if}>{$client.AgencyName}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            {/if}
                            <div class="form-group col-sm-6">
                                <label for="client_id" class="control-label">نرم افزار</label>
                                <select name="type_app" id="type_app" class="form-control">
                                    <option value="">انتخاب کنید....</option>
                                    <option value="all" {if $smarty.post.type_app eq 'all' }selected{/if}>همه</option>
                                    <option value="api" {if $smarty.post.type_app eq 'api' }selected{/if}>هتل اشتراکی
                                        داخلی
                                    </option>
                                    <option value="reservation"
                                            {if $smarty.post.type_app eq 'reservation' }selected{/if}>هتل رزرواسیون
                                    </option>
                                    <option value="externalApi"
                                            {if $smarty.post.type_app eq 'externalApi' }selected{/if}>هتل اشتراکی خارجی
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                                <label for="passenger_name" class="control-label">نام یا نام خانوادگی مسافر</label>
                                <input type="text" class="form-control " name="passenger_name"
                                       value="{$smarty.post.passenger_name}" id="passenger_name"
                                       placeholder="نام یا نام خانوادگی مسافر جستجو را وارد نمائید">
                            </div>
                            <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                                <label for="passenger_national_code" class="control-label">کد ملی مسافر</label>
                                <input type="text" class="form-control " name="passenger_national_code"
                                       value="{$smarty.post.passenger_name}" id="passenger_national_code"
                                       placeholder="کد ملی مسافر را وارد نمائید">
                            </div>
                            <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                                <label for="member_name" class="control-label">نام یا نام خانوادگی خریدار </label>
                                <input type="text" class="form-control " name="member_name"
                                       value="{$smarty.post.passenger_name}" id="member_name"
                                       placeholder="نام یا نام خانوادگی خریدار  را وارد نمائید">
                            </div>
                            <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                                <label for="client_id" class="control-label">نوع خرید</label>
                                <select name="payment_type" id="payment_type" class="form-control">
                                    <option value="">انتخاب کنید....</option>
                                    <option value="all" {if $smarty.post.payment_type eq 'all' }selected{/if}>همه
                                    </option>
                                    <option value="cash" {if $smarty.post.payment_type eq 'cash' }selected{/if}>نقدی
                                    </option>
                                    <option value="credit" {if $smarty.post.payment_type eq 'credit' }selected{/if}>
                                        اعتباری
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6 showAdvanceSearch " style="display: none;">
                                <label for="StartDate" class="control-label">تاریخ ورود</label>
                                <input type="text" class="form-control datepicker" name="StartDate"
                                       value="{$smarty.post.StartDate}"
                                       id="StartDate" placeholder="تاریخ ورود جستجو را وارد نمائید">
                            </div>
                            <div class="form-group col-sm-6 showAdvanceSearch " style="display: none;">
                                <label for="EndDate" class="control-label">تاریخ خروج</label>
                                <input type="text" class="form-control datepicker" name="EndDate"
                                       value="{$smarty.post.EndDate}"
                                       id="EndDate" placeholder="تاریخ خروج جستجو را وارد نمائید">
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="checkbox checkbox-success col-sm-6 ">
                                        <input id="checkBoxAdvanceSearch" type="checkbox" name="checkBoxAdvanceSearch"
                                               onclick="displayAdvanceSearch(this)">
                                        <label for="checkBoxAdvanceSearch" class="font-30"> جستجوی پیشرفته </label>
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
                                        <option value="{$Counter['id']}"
                                                {if $smarty.post.CounterId eq $Counter['id']} selected {/if}>{$Counter['name']} {$Counter['family']}</option>
                                    {/foreach}
                                </select>
                            </div>
                        {/if}

                        <div class="clearfix"></div>
                    </div>
                    <div class="d-none" data-info="filter-div" data-target="insurance">
                        <div class="form-group col-sm-6">
                            <label for="status" class="control-label">وضعیت رزرو</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">انتخاب کنید....</option>
                                <option value="all" {if $smarty.post.status eq 'all' }selected{/if}>همه</option>
                                <option value="book" {if $smarty.post.status eq  'book' }selected{/if}>موفق</option>
                                <option value="nobook" {if $smarty.post.status eq 'nobook' }selected{/if}>ناموفق
                                </option>
                            </select>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="factor_number" class="control-label">شماره فاکتور</label>
                            <input type="text" class="form-control " name="factor_number"
                                   value="{$smarty.post.factor_number}" id="factor_number"
                                   placeholder="شماره فاکتور را وارد نمائید">

                        </div>

                        {if $smarty.const.TYPE_ADMIN eq '1'}
                            <div class="form-group col-sm-6">
                                <label for="client_id" class="control-label">نام همکار</label>
                                <select name="client_id" id="client_id" class="form-control ">
                                    <option value="">انتخاب کنید....</option>
                                    <option value="all">همه</option>
                                    {foreach $objbook->list_hamkar() as $client }
                                        <option value="{$client.id}" {if $smarty.post.client_id eq $client.id} selected {/if}>{$client.AgencyName}</option>
                                    {/foreach}
                                </select>
                            </div>
                        {/if}

                        <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                            <label for="passenger_name" class="control-label">نام یا نام خانوادگی مسافر</label>
                            <input type="text" class="form-control " name="passenger_name"
                                   value="{$smarty.post.passenger_name}" id="passenger_name"
                                   placeholder="نام یا نام خانوادگی مسافر را وارد نمائید">

                        </div>

                        <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                            <label for="passenger_passport_number" class="control-label">شماره پاسپورت مسافر</label>
                            <input type="text" class="form-control " name="passenger_passport_number"
                                   value="{$smarty.post.passenger_name}" id="passenger_passport_number"
                                   placeholder="شماره پاسپورت مسافر را وارد نمائید">

                        </div>

                        <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                            <label for="member_name" class="control-label">نام یا نام خانوادگی خریدار </label>
                            <input type="text" class="form-control " name="member_name"
                                   value="{$smarty.post.passenger_name}" id="member_name"
                                   placeholder="نام یا نام خانوادگی خریدار  را وارد نمائید">

                        </div>

                        <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                            <label for="client_id" class="control-label">نوع خرید</label>
                            <select name="payment_type" id="payment_type"
                                    class="form-control">
                                <option value="">انتخاب کنید....</option>
                                <option value="all" {if $smarty.post.payment_type eq
                                'all' }selected{/if}>همه
                                </option>
                                <option value="cash" {if $smarty.post.payment_type eq
                                'cash' }selected{/if}>نقدی
                                </option>
                                <option value="credit" {if $smarty.post.payment_type eq
                                'credit' }selected{/if}>اعتباری
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

                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                    <div class="d-none" data-info="filter-div" data-target="visa">
                        <div class="form-group col-sm-6">
                            <label for="status" class="control-label">وضعیت رزرو</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">انتخاب کنید....</option>
                                <option value="all" {if $smarty.post.status eq 'all' }selected{/if}>همه</option>
                                <option value="book" {if $smarty.post.status eq  'book' }selected{/if}>موفق</option>
                                <option value="nobook" {if $smarty.post.status eq 'nobook' }selected{/if}>ناموفق
                                </option>
                            </select>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="factor_number" class="control-label">شماره فاکتور</label>
                            <input type="text" class="form-control " name="factor_number"
                                   value="{$smarty.post.factor_number}" id="factor_number"
                                   placeholder="شماره فاکتور را وارد نمائید">

                        </div>

                        {if $smarty.const.TYPE_ADMIN eq '1'}
                            <div class="form-group col-sm-6">
                                <label for="client_id" class="control-label">نام همکار</label>
                                <select name="client_id" id="client_id" class="form-control ">
                                    <option value="">انتخاب کنید....</option>
                                    <option value="all">همه</option>
                                    {foreach $objbook->list_hamkar() as $client }
                                        <option value="{$client.id}" {if $smarty.post.client_id eq $client.id} selected {/if}>{$client.AgencyName}</option>
                                    {/foreach}
                                </select>
                            </div>
                        {/if}

                        <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                            <label for="passenger_name" class="control-label">نام یا نام خانوادگی مسافر</label>
                            <input type="text" class="form-control " name="passenger_name"
                                   value="{$smarty.post.passenger_name}" id="passenger_name"
                                   placeholder="نام یا نام خانوادگی مسافر را وارد نمائید">

                        </div>

                        <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                            <label for="passenger_passport_number" class="control-label">شماره پاسپورت مسافر</label>
                            <input type="text" class="form-control " name="passenger_passport_number"
                                   value="{$smarty.post.passenger_name}" id="passenger_passport_number"
                                   placeholder="شماره پاسپورت مسافر را وارد نمائید">

                        </div>

                        <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                            <label for="member_name" class="control-label">نام یا نام خانوادگی خریدار </label>
                            <input type="text" class="form-control " name="member_name"
                                   value="{$smarty.post.passenger_name}" id="member_name"
                                   placeholder="نام یا نام خانوادگی خریدار  را وارد نمائید">

                        </div>

                        <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                            <label for="client_id" class="control-label">نوع خرید</label>
                            <select name="payment_type" id="payment_type"
                                    class="form-control">
                                <option value="">انتخاب کنید....</option>
                                <option value="all" {if $smarty.post.payment_type eq
                                'all' }selected{/if}>همه
                                </option>
                                <option value="cash" {if $smarty.post.payment_type eq
                                'cash' }selected{/if}>نقدی
                                </option>
                                <option value="credit" {if $smarty.post.payment_type eq
                                'credit' }selected{/if}>اعتباری
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

                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                    <div class="d-none" data-info="filter-div" data-target="gasht">
                        <div class="form-group col-sm-6">
                            <label for="status" class="control-label">وضعیت رزرو</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">انتخاب کنید....</option>
                                <option value="all" {if $smarty.post.status eq 'all' }selected{/if}>همه</option>
                                <option value="book" {if $smarty.post.status eq  'book' }selected{/if}>موفق</option>
                                <option value="nobook" {if $smarty.post.status eq 'nobook' }selected{/if}>ناموفق
                                </option>
                            </select>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="factor_number" class="control-label">شماره فاکتور</label>
                            <input type="text" class="form-control " name="factor_number"
                                   value="{$smarty.post.factor_number}" id="factor_number"
                                   placeholder="شماره فاکتور را وارد نمائید">

                        </div>

                        {if $smarty.const.TYPE_ADMIN eq '1'}
                            <div class="form-group col-sm-6">
                                <label for="client_id" class="control-label">نام همکار</label>
                                <select name="client_id" id="client_id" class="form-control ">
                                    <option value="">انتخاب کنید....</option>
                                    <option value="all">همه</option>
                                    {foreach $objbook->list_hamkar() as $client }
                                        <option value="{$client.id}" {if $smarty.post.client_id eq $client.id} selected {/if}>{$client.AgencyName}</option>
                                    {/foreach}
                                </select>
                            </div>
                        {/if}

                        <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                            <label for="passenger_name" class="control-label">نام یا نام خانوادگی مسافر</label>
                            <input type="text" class="form-control " name="passenger_name"
                                   value="{$smarty.post.passenger_name}" id="passenger_name"
                                   placeholder="نام یا نام خانوادگی مسافر را وارد نمائید">

                        </div>


                        <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                            <label for="member_name" class="control-label">نام یا نام خانوادگی خریدار </label>
                            <input type="text" class="form-control " name="member_name"
                                   value="{$smarty.post.member_name}" id="member_name"
                                   placeholder="نام یا نام خانوادگی خریدار  را وارد نمائید">

                        </div>
                        <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                            <label for="member_name" class="control-label">شماره موبایل مسافر</label>
                            <input type="number" class="form-control " name="passenger_mobile"
                                   value="{$smarty.post.passenger_mobile}" id="passenger_mobile"
                                   placeholder="نام یا نام خانوادگی خریدار  را وارد نمائید">

                        </div>

                        <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                            <label for="client_id" class="control-label">نوع خرید</label>
                            <select name="payment_type" id="payment_type"
                                    class="form-control">
                                <option value="">انتخاب کنید....</option>
                                <option value="all" {if $smarty.post.payment_type eq
                                'all' }selected{/if}>همه
                                </option>
                                <option value="cash" {if $smarty.post.payment_type eq
                                'cash' }selected{/if}>نقدی
                                </option>
                                <option value="credit" {if $smarty.post.payment_type eq
                                'credit' }selected{/if}>اعتباری
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

                            </div>
                        </div>
                    </div>
                    <div class="d-none" data-info="filter-div" data-target="tour">
                        <div class="form-group col-sm-6">
                            <label for="status" class="control-label">وضعیت رزرو</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">انتخاب کنید....</option>
                                <option value="all" {if $smarty.post.status eq 'all' }selected{/if}>همه</option>
                                <option value="book" {if $smarty.post.status eq  'book' }selected{/if}>موفق</option>
                                <option value="nothing" {if $smarty.post.status eq 'nothing' }selected{/if}>ناموفق
                                </option>
                            </select>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="factor_number" class="control-label">شماره فاکتور</label>
                            <input type="text" class="form-control " name="factor_number"
                                   value="{$smarty.post.factor_number}" id="factor_number"
                                   placeholder="شماره فاکتور را وارد نمائید">
                        </div>

                        {if $objsession->adminIsLogin()}

                            {if $smarty.const.TYPE_ADMIN eq '1'}
                                <div class="form-group col-sm-6">
                                    <label for="client_id" class="control-label">نام همکار</label>
                                    <select name="client_id" id="client_id" class="form-control ">
                                        <option value="">انتخاب کنید....</option>
                                        <option value="all">همه</option>
                                        {foreach $objRsult->list_hamkar() as $client }
                                            <option value="{$client.id}" {if $smarty.post.client_id eq $client.id} selected {/if}>{$client.AgencyName}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            {/if}
                            <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                                <label for="passenger_name" class="control-label">نام یا نام خانوادگی مسافر</label>
                                <input type="text" class="form-control " name="passenger_name"
                                       value="{$smarty.post.passenger_name}" id="passenger_name"
                                       placeholder="نام یا نام خانوادگی مسافر جستجو را وارد نمائید">
                            </div>
                            <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                                <label for="passenger_national_code" class="control-label">کد ملی مسافر</label>
                                <input type="text" class="form-control " name="passenger_national_code"
                                       value="{$smarty.post.passenger_name}" id="passenger_national_code"
                                       placeholder="کد ملی مسافر را وارد نمائید">
                            </div>
                            <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                                <label for="member_name" class="control-label">نام یا نام خانوادگی خریدار </label>
                                <input type="text" class="form-control " name="member_name"
                                       value="{$smarty.post.passenger_name}" id="member_name"
                                       placeholder="نام یا نام خانوادگی خریدار  را وارد نمائید">
                            </div>
                            {if $smarty.const.TYPE_ADMIN eq '1'}
                                <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                                    <label for="client_id" class="control-label">نوع خرید</label>
                                    <select name="payment_type" id="payment_type" class="form-control">
                                        <option value="">انتخاب کنید....</option>
                                        <option value="all" {if $smarty.post.payment_type eq 'all' }selected{/if}>همه
                                        </option>
                                        <option value="cash" {if $smarty.post.payment_type eq 'cash' }selected{/if}>
                                            نقدی
                                        </option>
                                        <option value="credit" {if $smarty.post.payment_type eq 'credit' }selected{/if}>
                                            اعتباری
                                        </option>
                                    </select>
                                </div>
                            {/if}
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="checkbox checkbox-success col-sm-6 ">
                                        <input id="checkBoxAdvanceSearch" type="checkbox" name="checkBoxAdvanceSearch"
                                               onclick="displayAdvanceSearch(this)">
                                        <label for="checkBoxAdvanceSearch" class="font-30"> جستجوی پیشرفته </label>
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
                                    {foreach $objRsult->listCounter($agencyId) as $Counter }
                                        <option value="{$Counter['id']}" {if $smarty.post.CounterId eq $Counter['id']} selected {/if}>{$Counter['name']} {$Counter['family']}</option>
                                    {/foreach}
                                </select>
                            </div>
                        {/if}
                    </div>
                    <div class="d-none" data-info="filter-div" data-target="bus">
                        <div class="form-group col-sm-6">
                            <label for="status" class="control-label">وضعیت رزرو</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">انتخاب کنید....</option>
                                <option value="all" {if $smarty.post.status eq 'all' }selected{/if}>همه</option>
                                {*<option value="temporaryReservation" {if $smarty.post.status eq  'temporaryReservation' }selected{/if}>رزرو موقت</option>*}
                                <option value="book" {if $smarty.post.status eq  'book' }selected{/if}>موفق</option>
                                <option value="nobook" {if $smarty.post.status eq 'nobook' }selected{/if}>ناموفق
                                </option>
                            </select>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="factor_number" class="control-label">شماره فاکتور</label>
                            <input type="text" class="form-control " name="factor_number"
                                   value="{$smarty.post.factor_number}" id="factor_number"
                                   placeholder="شماره فاکتور را وارد نمائید">

                        </div>

                        {if $smarty.const.TYPE_ADMIN eq '1'}
                            <div class="form-group col-sm-6">
                                <label for="client_id" class="control-label">نام همکار</label>
                                <select name="client_id" id="client_id" class="form-control ">
                                    <option value="">انتخاب کنید....</option>
                                    <option value="all">همه</option>
                                    {foreach $objbook->list_hamkar() as $client }
                                        <option value="{$client.id}" {if $smarty.post.client_id eq $client.id} selected {/if}>{$client.AgencyName}</option>
                                    {/foreach}
                                </select>
                            </div>
                        {/if}

                        <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                            <label for="passenger_name" class="control-label">نام یا نام خانوادگی مسافر</label>
                            <input type="text" class="form-control " name="passenger_name"
                                   value="{$smarty.post.passenger_name}" id="passenger_name"
                                   placeholder="نام یا نام خانوادگی مسافر را وارد نمائید">
                        </div>

                        <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                            <label for="member_name" class="control-label">نام یا نام خانوادگی خریدار </label>
                            <input type="text" class="form-control " name="member_name"
                                   value="{$smarty.post.member_name}" id="member_name"
                                   placeholder="نام یا نام خانوادگی خریدار  را وارد نمائید">
                        </div>

                        <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                            <label for="member_name" class="control-label">شماره موبایل مسافر</label>
                            <input type="number" class="form-control " name="passenger_mobile"
                                   value="{$smarty.post.passenger_mobile}" id="passenger_mobile"
                                   placeholder="نام یا نام خانوادگی خریدار  را وارد نمائید">
                        </div>

                        <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                            <label for="client_id" class="control-label">نوع خرید</label>
                            <select name="payment_type" id="payment_type" class="form-control">
                                <option value="">انتخاب کنید....</option>
                                <option value="all" {if $smarty.post.payment_type eq 'all' }selected{/if}>همه</option>
                                <option value="cash" {if $smarty.post.payment_type eq 'cash' }selected{/if}>نقدی
                                </option>
                                <option value="credit" {if $smarty.post.payment_type eq 'credit' }selected{/if}>
                                    اعتباری
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

                            </div>
                        </div>
                    </div>
                    <div class="d-none" data-info="filter-div" data-target="train">
                        <div class="form-group col-sm-6">
                            <label for="status" class="control-label">وضعیت رزرو</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">انتخاب کنید....</option>
                                <option value="all" {if $smarty.post.status eq 'all' }selected{/if}>همه</option>
                                <option value="book" {if $smarty.post.status eq  'book' }selected{/if}>موفق</option>
                                <option value="nothing" {if $smarty.post.status eq 'nothing' }selected{/if}>ناموفق
                                </option>
                            </select>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="factor_number" class="control-label">شماره فاکتور</label>
                            <input type="text" class="form-control " name="factor_number"
                                   value="{$smarty.post.factor_number}" id="factor_number"
                                   placeholder="شماره فاکتور را وارد نمائید">
                        </div>

                        {*<div class="form-group col-sm-6">
                            <label for="TrainNumber" class="control-label">شماره فاکتور</label>
                            <input type="text" class="form-control " name="TrainNumber"
                                   value="{$smarty.post.TrainNumber}" id="TrainNumber"
                                   placeholder="شماره فاکتور را وارد نمائید">
                        </div>*}

                        {if $objsession->adminIsLogin()}

                            {if $smarty.const.TYPE_ADMIN eq '1'}
                                <div class="form-group col-sm-6">
                                    <label for="client_id" class="control-label">نام همکار</label>
                                    <select name="client_id" id="client_id" class="form-control ">
                                        <option value="">انتخاب کنید....</option>
                                        <option value="all">همه</option>
                                        {foreach $objbook->list_hamkar() as $client }
                                            <option value="{$client.id}" {if $smarty.post.client_id eq $client.id} selected {/if}>{$client.AgencyName}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            {/if}
                            <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                                <label for="passenger_name" class="control-label">نام یا نام خانوادگی مسافر</label>
                                <input type="text" class="form-control " name="passenger_name"
                                       value="{$smarty.post.passenger_name}" id="passenger_name"
                                       placeholder="نام یا نام خانوادگی مسافر جستجو را وارد نمائید">
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
                            {if $smarty.const.TYPE_ADMIN eq '1'}
                                <div class="form-group col-sm-6 showAdvanceSearch" style="display: none;">
                                    <label for="client_id" class="control-label">نوع خرید</label>
                                    <select name="payment_type" id="payment_type" class="form-control">
                                        <option value="">انتخاب کنید....</option>
                                        <option value="all" {if $smarty.post.payment_type eq 'all' }selected{/if}>همه
                                        </option>
                                        <option value="cash" {if $smarty.post.payment_type eq 'cash' }selected{/if}>
                                            نقدی
                                        </option>
                                        <option value="credit" {if $smarty.post.payment_type eq 'credit' }selected{/if}>
                                            اعتباری
                                        </option>
                                    </select>
                                </div>
                            {/if}
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="checkbox checkbox-success col-sm-6 ">
                                        <input id="checkBoxAdvanceSearch" type="checkbox" name="checkBoxAdvanceSearch"
                                               onclick="displayAdvanceSearch(this)">
                                        <label for="checkBoxAdvanceSearch" class="font-30"> جستجوی پیشرفته </label>
                                    </div>

                                </div>
                            </div>
                        {/if}

                        <div class="clearfix"></div>
                    </div>


                    <div class="form-group w-100 mb-3 float-left">
                        <button type="button"
                                onclick="ExecuteHistoryFilter($('a:not(.btn-default)[data-info=pendingBtn]').attr('data-target'))"
                                class="btn btn-info float-left">اعمال فیلتر
                        </button>
                    </div>
                </form>


                <div class="box-btn-excel w-100">
                    <a data-info="filter-div" data-target="flight" data-target-file="user_ajax.php"
                       class="btn btn-primary waves-effect waves-light ld-ext-left d-none"
                       onclick="ExecuteExcelFilter($(this))" type="button">
                        <span class="btn-label"><i class="fa fa-download"></i></span>دریافت فایل اکسل
                        <div class="ld ld-ring ld-spin"></div>
                    </a>
                    <a data-info="filter-div" data-target="hotel" data-target-file="hotel_ajax.php"
                       class="btn btn-primary waves-effect waves-light ld-ext-left d-none"
                       onclick="ExecuteExcelFilter($(this))" type="button">
                        <span class="btn-label"><i class="fa fa-download"></i></span>دریافت فایل اکسل
                        <div class="ld ld-ring ld-spin"></div>
                    </a>
                    <a data-info="filter-div" data-target="insurance" data-target-file="user_ajax.php"
                       class="btn btn-primary waves-effect waves-light ld-ext-left d-none"
                       onclick="ExecuteExcelFilter($(this))" type="button">
                        <span class="btn-label"><i class="fa fa-download"></i></span>دریافت فایل اکسل
                        <div class="ld ld-ring ld-spin"></div>
                    </a>
                    <a data-info="filter-div" data-target="visa" data-target-file="visa_ajax.php"
                       class="btn btn-primary waves-effect waves-light ld-ext-left d-none"
                       onclick="ExecuteExcelFilter($(this))" type="button">
                        <span class="btn-label"><i class="fa fa-download"></i></span>دریافت فایل اکسل
                        <div class="ld ld-ring ld-spin"></div>
                    </a>
                    <a data-info="filter-div" data-target="gasht" data-target-file="gasht_ajax.php"
                       class="btn btn-primary waves-effect waves-light ld-ext-left d-none"
                       onclick="ExecuteExcelFilter($(this))" type="button">
                        <span class="btn-label"><i class="fa fa-download"></i></span>دریافت فایل اکسل
                        <div class="ld ld-ring ld-spin"></div>
                    </a>
                    <a data-info="filter-div" data-target="tour" data-target-file="tour_ajax.php"
                       class="btn btn-primary waves-effect waves-light ld-ext-left d-none"
                       onclick="ExecuteExcelFilter($(this))" type="button">
                        <span class="btn-label"><i class="fa fa-download"></i></span>دریافت فایل اکسل
                        <div class="ld ld-ring ld-spin"></div>
                    </a>
                    <a data-info="filter-div" data-target="bus" data-target-file="bus_ajax.php"
                       class="btn btn-primary waves-effect waves-light ld-ext-left d-none"
                       onclick="ExecuteExcelFilter($(this))" type="button">
                        <span class="btn-label"><i class="fa fa-download"></i></span>دریافت فایل اکسل
                        <div class="ld ld-ring ld-spin"></div>
                    </a>
                    <a data-info="filter-div" data-target="train" data-target-file="train_ajax.php"
                       class="btn btn-primary waves-effect waves-light ld-ext-left d-none"
                       onclick="ExecuteExcelFilter($(this))" type="button">
                        <span class="btn-label"><i class="fa fa-download"></i></span>دریافت فایل اکسل
                        <div class="ld ld-ring ld-spin"></div>
                    </a>

                    <a data-info="filter-div" data-target="entertainment" data-target-file="entertainment_ajax.php"
                       class="btn btn-primary waves-effect waves-light ld-ext-left d-none"
                       onclick="ExecuteExcelFilter($(this))" type="button">
                        <span class="btn-label"><i class="fa fa-download"></i></span>دریافت فایل اکسل
                        <div class="ld ld-ring ld-spin"></div>
                    </a>

                </div>

                <div class="mt-3 p-0 col-sm-1 float-left text-center">
                    <div class="form-group">
                        <label for="AutoRefreshInput">نرخ تازه سازی (ثانیه)</label>
                        <input type="number" min="5" class="form-control" value="0" id="AutoRefreshInput"
                               placeholder="~ 20">
                    </div>
                </div>

                <div class="table_history_admin">

                    <div class="w-100 table-responsive tabs_ticket-history">
                        <div class="w-100">
                            <a data-target="flight"
                               data-info="pendingBtn" onclick="ExecuteHistoryFilter($(this).attr('data-target'))"
                               class="btn btn-default waves-effect waves-light ld-ext-left" type="button">
                                <span class="btn-label"><i class="fa fa-history"></i></span>بلیط
                                <div class="ld ld-ring ld-spin"></div>
                            </a>
                            <a  data-target="hotel"
                                data-info="pendingBtn" onclick="ExecuteHistoryFilter($(this).attr('data-target'))"
                                class="btn btn-default waves-effect waves-light ld-ext-left" type="button">
                                <span class="btn-label"><i class="mdi mdi-hospital-building"></i></span>هتل
                                <div class="ld ld-ring ld-spin"></div>

                            </a>


                            <a data-target="insurance"
                               data-info="pendingBtn" onclick="ExecuteHistoryFilter($(this).attr('data-target'))"
                               class="btn btn-default waves-effect waves-light ld-ext-left" type="button">
                                <span class="btn-label"><i class="mdi mdi-umbrella"></i></span>بیمه
                                <div class="ld ld-ring ld-spin"></div>
                            </a>

                            <a data-target="visa"
                               data-info="pendingBtn" onclick="ExecuteHistoryFilter($(this).attr('data-target'))"
                               class="btn btn-default waves-effect waves-light ld-ext-left" type="button">
                                <span class="btn-label"><i class="mdi mdi-book-open"></i></span>ویزا
                                <div class="ld ld-ring ld-spin"></div>
                            </a>


                            <a data-target="gasht"
                               data-info="pendingBtn" onclick="ExecuteHistoryFilter($(this).attr('data-target'))"
                               class="btn btn-default waves-effect waves-light ld-ext-left" type="button">
                                <span class="btn-label"><i class="mdi mdi-bus"></i></span>گشت
                                <div class="ld ld-ring ld-spin"></div>
                            </a>

                            <a data-target="tour"
                               data-info="pendingBtn" onclick="ExecuteHistoryFilter($(this).attr('data-target'))"
                               class="btn btn-default waves-effect waves-light ld-ext-left" type="button">
                                <span class="btn-label"><i class="fa fa-suitcase"></i></span>تور
                                <div class="ld ld-ring ld-spin"></div>
                            </a>
                            <a data-target="bus"
                               data-info="pendingBtn" onclick="ExecuteHistoryFilter($(this).attr('data-target'))"
                               class="btn btn-default waves-effect waves-light ld-ext-left" type="button">
                                <span class="btn-label"><i class="mdi mdi-bus"></i></span>اتوبوس
                                <div class="ld ld-ring ld-spin"></div>
                            </a>
                            {*{if $smarty.const.TYPE_ADMIN eq '1'}
                                <a  data-target="busLog"
                                    data-info="pendingBtn" onclick="ExecuteHistoryFilter($(this).attr('data-target'))"
                                    class="btn btn-default waves-effect waves-light ld-ext-left custom-style-btn" type="button">
                                    log
                                    <div class="ld ld-ring ld-spin"></div>

                                </a>
                            {/if}*}
                            <a data-target="train"
                               data-info="pendingBtn" onclick="ExecuteHistoryFilter($(this).attr('data-target'))"
                               class="btn btn-default waves-effect waves-light ld-ext-left" type="button">
                                <span class="btn-label"><i class="mdi mdi-bus"></i></span>قطار
                                <div class="ld ld-ring ld-spin"></div>
                            </a>
                            <a data-target="entertainment"
                               data-info="pendingBtn" onclick="ExecuteHistoryFilter($(this).attr('data-target'))"
                               class="btn btn-default waves-effect waves-light ld-ext-left" type="button">
                                <span class="btn-label"><i class="fa fa-suitcase"></i></span>تفریحات
                                <div class="ld ld-ring ld-spin"></div>
                            </a>

                        </div>
                    </div>


                    <div class="table-responsive ld-over p-4 border w-100">
                        <div class="ld ld-ring ld-spin"></div>
                        <table id="mainTicketHistory" class="w-100 table table-striped text-center">
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>


<script type="text/javascript" src="assets/JsFiles/bookshow.js"></script>
<script type="text/javascript" src="assets/JsFiles/bookhotelshow.js"></script>
<script type="text/javascript" src="assets/JsFiles/reservationHotel.js"></script>
<script type="text/javascript" src="assets/JsFiles/bookinsuranceshow.js"></script>
<script type="text/javascript" src="assets/JsFiles/bookvisashow.js"></script>
<script type="text/javascript" src="assets/JsFiles/bookGashtShow.js"></script>
<script type="text/javascript" src="assets/JsFiles/bookTourShow.js"></script>
<script type="text/javascript" src="assets/JsFiles/bookBusShow.js"></script>
<script type="text/javascript" src="assets/JsFiles/bookTrainShow.js"></script>
<script>
    ExecuteHistoryFilter('flight');
    $(document).ready(function () {
        var interval = null;
        $('#AutoRefreshInput').change(function () {
            clearInterval(interval);
            var thiss = $(this);
            if(thiss.val() == '0'){
                clearInterval(interval);
            }
            if(thiss.val() >= '5')
            {
                interval = setInterval(function () {
                    ExecuteHistoryFilter($('a:not(.btn-default)[data-info=pendingBtn]').attr('data-target'));
                }, thiss.val() * 1000);
            }
            if(thiss.val() <= '5' && thiss.val() != 0)
            {
                thiss.val(5);
                clearInterval(interval);
                interval = setInterval(function () {
                    ExecuteHistoryFilter($('a:not(.btn-default)[data-info=pendingBtn]').attr('data-target'));
                }, thiss.val() * 1000);
            }
        });

        {if $smarty.const.TYPE_ADMIN eq '1'}
        setInterval(function () {
            CheckReserveHotelTab();
        }, 30000);
        {/if}


    });

</script>