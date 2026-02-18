{if $smarty.const.TYPE_ADMIN eq 1}
{load_presentation_object filename="bookingVisa" assign="objbook"}

<div class="container-fluid">

    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>گزارش خرید</li>
                <li class="active">سوابق خرید ویزا</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">جستجوی سوابق خرید </h3>

                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید سوابق را در تاریخ های مورد نظرتان جستجو کنید</p>

                <form id="SearchVisaHistory" method="post" action="{$smarty.const.rootAddress}visaHistory">
                    <input type="hidden" name="flag" id="flag" value="createExcelFile">

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
                        <label for="status" class="control-label">وضعیت رزرو</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">انتخاب کنید....</option>
                            <option value="all" {if $smarty.post.status eq 'all' }selected{/if}>همه</option>
                            <option value="book" {if $smarty.post.status eq  'book' }selected{/if}>موفق</option>
                            <option value="nobook" {if $smarty.post.status eq 'nobook' }selected{/if}>ناموفق</option>
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
                            'all' }selected{/if}>همه</option>
                            <option value="cash" {if $smarty.post.payment_type eq
                            'cash' }selected{/if}>نقدی</option>
                            <option value="credit" {if $smarty.post.payment_type eq
                            'credit' }selected{/if}>اعتباری</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="checkbox checkbox-success col-sm-6 ">

                                <input id="checkBoxAdvanceSearch" type="checkbox" name="checkBoxAdvanceSearch"
                                       onclick="displayAdvanceSearch(this)" >
                                <label for="checkBoxAdvanceSearch" class="font-30"> جستجوی پیشرفته </label>

                            </div>
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

                <div class="box-btn-excel">
                    <a onclick="createExcelForReportVisa()" class="btn btn-primary waves-effect waves-light " type="button" id="btn-excel">
                        <span class="btn-label"><i class="fa fa-download"></i></span>دریافت فایل اکسل</a>
                    <img src="../../pic/load.gif" alt="please wait ..." id="loader-excel" class="displayN">
                </div>

                <h3 class="box-title m-b-0">سوابق خرید</h3>
                <p class="text-muted m-b-30">کلیه سوابق خرید را در این لیست میتوانید مشاهده کنید</p>
                <div class="table-responsive">
                    <table id="visaHistory" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>تاریخ خرید<br />شماره فاکتور</th>
                            <th>مقصد<br />نوع ویزا</th>
                            <th>عنوان ویزا</th>
                            <th>نام خریدار<br />نوع کاربر<br />تعداد<br />نوع کانتر</th>
                            <th>سهم آژانس</th>
                            {if $smarty.const.TYPE_ADMIN eq '1'}
                                <th style="direction: ltr">+ apiسود </th>
                                <th> سهم ما</th>
                            {/if}
                            <th>مبلغ کل<br />مبلغ پرداختی</th>
                            <th>عملیات</th>
                            <th>وضعیت</th>
                        </tr>
                        </thead>
                        <tbody>

                        {assign var="bookList" value=$objbook->bookList()}

                        {assign var="number" value=$objbook->bookCount}

                        {foreach key=key item=item from=$bookList}

                            {$number = $number - 1}

                        <tr id="del-{$item.id}">

                            <td>{$number + 1}</td>

                            <td>
                                <span dir="ltr">
                                    {$item.creation_date_int}
                                </span>
                                <br />{$item.factor_number}
                            </td>

                            <td>{$item.visa_destination}<br />{$item.visa_type}</td>

                            <td>{$item.visa_title}</td>

                            <td>
                                {if $item['is_member'] eq '0'} کاربر مهمان <hr style='margin:3px'>{$item.member_email}
                                {else} {$item.member_name} <hr style='margin:3px'> کاربر اصلی
                                {/if}
                                <hr style='margin:3px'>

                                <span class=" fa fa-user" style="margin-left: 5px;">{$item['adt_count']}</span>
                                <span class=" fa fa-child" style="margin-left: 5px;">{$item['chd_count']}</span>
                                <span class=" fa fa-child" style="margin-left: 5px;">{$item['inf_count']}</span>
                                <hr style='margin:3px'>
                                {if $item.is_member eq '1'} {if $item.fk_counter_type_id eq '5'}مسافر  {else} کانتر{/if} {/if}
                            </td>

                            <td>{$item.agency_commission|number_format}</td>

                            {if $smarty.const.TYPE_ADMIN eq '1'}
                                <td>{$item.api_commission|number_format}</td>
                                <td>{$item.irantech_commission|number_format}</td>
                            {/if}

                            <td>
                                {if $item.totalPrice neq $item.totalPayment}
                                    <span style="text-decoration: line-through;">{$item.totalPrice|number_format}</span>
                                    <br />
                                {/if}
                                {$item.totalPayment|number_format}<br />{$item.totalPrePayment|number_format}
                            </td>

                            <td>
                                {if $item.status neq 'nothing'}
                                <div class="btn-group m-r-10">

                                    <ul role="menu" class="animated flipInY" style="list-style: none; padding: 0;">
                                        <li>
                                            {if $item.status neq 'nothing'}
                                            <a onclick="ModalShowBookForVisa('{$item.factor_number}');return false" data-toggle="modal" data-target="#ModalPublic">
                                                <i class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                                   data-toggle="tooltip" data-placement="top" title="" data-original-title="مشاهده خرید"></i>
                                            </a>
                                            {/if}
                                        </li>
                                    </ul>

                                    {if $smarty.const.TYPE_ADMIN eq '1'}
                                        <hr style='margin:3px'>
                                        {$item.NameAgency}
                                    {/if}

                                    <hr style='margin:3px'>

                                    {if $item.payment_type eq 'cash'}
                                    نقدی
                                    {elseif $item.payment_type eq 'credit' || $item.payment_type eq 'member_credit'}
                                    اعتباری
                                    {/if}

                                    {if $smarty.const.TYPE_ADMIN eq '1' && $item.payment_type eq 'cash'}
                                        <hr style='margin:3px'>
                                        {$item.numberPortBank}
                                    {/if}


                                    {if $item.passengers_file neq ''}
                                        <hr style='margin:3px'>
                                        {assign var="arrayFile" value=$item.passengers_file|json_decode}
                                        <div class="btn-group m-r-10">
                                            <button aria-expanded="false" data-toggle="dropdown"
                                                    class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light"
                                                    type="button">  دانلود مدارک <span class="caret"></span>
                                            </button>
                                            <ul role="menu" class="dropdown-menu animated flipInY">
                                                <li>
                                                    <div class="pull-left">
                                                        {foreach $arrayFile as $k=>$file}
                                                            <div class="pull-left margin-10">
                                                                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationVisa/passengersImages/{$file}" target="_blank">
                                                                    <i style="margin: 5px auto;"  class="fcbtn btn btn-success btn-outline btn-1c fa fa-download"
                                                                       data-toggle="tooltip" data-placement="top" title=""
                                                                       data-original-title="دانلود فایل {$k + 1}"></i>
                                                                </a>
                                                            </div>
                                                        {/foreach}
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    {/if}

                                </div>
                                {/if}
                            </td>

                            <td>
                                {if $item.status eq 'nothing'}
                                    <a href="#" onclick="return false;" class="btn btn-danger cursor-default"> نا مشخص </a>
                                {elseif $item.status eq 'prereserve'}
                                    <a href="#" onclick="return false;" class="btn btn-warning cursor-default"> پیش رزرو </a>
                                {elseif $item.status eq 'bank'}
                                    <a href="#" onclick="return false;" class="btn btn-primary cursor-default"> هدایت به درگاه </a>
                                {elseif $item.status eq 'book'}
                                    <a href="#" onclick="return false;" class="btn btn-success cursor-default"> رزرو قطعی </a>
                                {/if}

                                {if $smarty.const.TYPE_ADMIN eq '1'}
                                    <hr style='margin:3px'>
                                    {$item.remote_addr}
                                {/if}
                            </td>

                        </tr>
                        {/foreach}
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="5"></th>
                            <th>({$objbook->totalAgencyCommission|number_format})ريال</th>
                            {if $smarty.const.TYPE_ADMIN eq '1'}
                                <th>({$objbook->totalApiCommission|number_format})ريال</th>
                            {/if}
                            {if $smarty.const.TYPE_ADMIN eq '1'}
                                <th>({$objbook->totalOurCommission|number_format})ريال</th>
                            {/if}
                            <th>({$objbook->totalCost|number_format})ريال</th>
                            {if $smarty.const.TYPE_ADMIN eq '1'}
                                <th colspan="2"></th>
                            {else}
                                <th colspan="2"></th>
                            {/if}
                        </tr>

                        {if $smarty.const.TYPE_ADMIN eq '1'}
                        <tr>
                            <th colspan="4">جمع بزرگسال({$objbook->adt_qty})نفر</th>
                            <th colspan="4">جمع کودک({$objbook->chd_qty})نفر</th>
                            <th colspan="3">جمع نوزاد({$objbook->inf_qty})نفر</th>
                        </tr>
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
        <span> ویدیو آموزشی بخش سوابق خرید ویزا   </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/370/---.html" target="_blank" class="i-btn"></a>

</div>
<script type="text/javascript" src="assets/JsFiles/bookvisashow.js"></script>
{/if}
