{if $smarty.const.TYPE_ADMIN eq 1}
{load_presentation_object filename="bookingTrain" assign="objbook"}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>گزارش خرید</li>
                <li class="active">سوابق خرید بلیط قطار</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">جستجوی سوابق خرید بلیط قطار </h3>

                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید سوابق را در تاریخ های مورد نظرتان جستجو
                    کنید
                </p>

                <form id="SearchTourHistory" method="post" action="{$smarty.const.rootAddress}trainHistory">
                    <input type="hidden" name="flag" id="flag" value="createExcelFile">

                    <div class="form-group col-sm-6 ">
                        <label for="date_of" class="control-label">تاریخ شروع (خرید)</label>
                        <input type="text" class="form-control datepicker" name="date_of" value="{$smarty.post.date_of}"
                               id="date_of" placeholder="تاریخ شروع جستجو را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="to_date" class="control-label">تاریخ پایان (خرید)</label>
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
                            <option value="nothing" {if $smarty.post.status eq 'nothing' }selected{/if}>ناموفق</option>
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
                                <option value="all" {if $smarty.post.payment_type eq 'all' }selected{/if}>همه</option>
                                <option value="cash" {if $smarty.post.payment_type eq 'cash' }selected{/if}>نقدی</option>
                                <option value="credit" {if $smarty.post.payment_type eq 'credit' }selected{/if}>اعتباری</option>
                            </select>
                        </div>
                        {/if}


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
                    <a onclick="createExcelForReportTour()" class="btn btn-primary waves-effect waves-light " type="button" id="btn-excel">
                        <span class="btn-label"><i class="fa fa-download"></i></span>دریافت فایل اکسل</a>
                    <img src="../../pic/load.gif" alt="please wait ..." id="loader-excel" class="displayN">
                </div>

                <h3 class="box-title m-b-0">سوابق خرید بلیط قطار</h3>
                <p class="text-muted m-b-30">کلیه سوابق خرید را در این لیست میتوانید مشاهده کنید</p>

                <div class="table-responsive">
                    <table id="trainHistory" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>مبدا</th>
                            <th>مقصد</th>
                            <th>نوع مسیر</th>
                            <th>تاریخ حرکت </th>
                            <th>ساعت حرکت / ساعت رسیدن</th>
                            <th>شماره قطار /نام قطار/نوع قطار</th>
                            <th> تاریخ خرید <br/> شماره واچر <br/>شماره فاکتور</th>
                            <th>خریدار</th>
                            <th> مبلغ </th>
                            <th>عملیات</th>
                            <th>وضعیت</th>
                        </tr>
                        </thead>
                        <tbody>

                                {foreach key=key item=item from=$objbook->bookList()}

                                <tr id="del-{$item.id}">
                                    <td>{$key+1}</td>
                                    <td>
                                        {$item.Departure_City}
                                    </td>
                                    <td>
                                        {$item.Arrival_City}
                                    </td>
                                    <td>
                                        {if $item.Route_Type eq '1'} رفت  {else}برگشت {/if}
                                    </td>
                                    <td>
                                        {$item.MoveDate}

                                    </td>
                                    <td>
                                        {$item.ExitTime} / {$item.TimeOfArrival}
                                    </td>
                                    <td>
                                        {$item.TrainNumber}/{$item.WagonName}/{if $item.is_specific eq 'yes'}سهمی ای{else}عادی{/if}
                                    </td>
                                    <td>
                                        {$item.creation_date_int}
                                        <hr style="margin:3px">
                                        {$item.requestNumber}
                                        <hr style="margin:3px">
                                        {$item.factor_number}
                                    </td>
                                    <td>

                                        {if $smarty.const.TYPE_ADMIN eq '1'}

                                            {if $item.agency_name neq ''}{$item.agency_name}{else}{$objFunctions->ClientName($item.client_id)}{/if}
                                        {/if}

                                        <hr style='margin:3px'>
                                        {if $item.member_name neq ' '}{$item.member_name}{else}کاربر مهمان{/if}
                                    </td>
                                    <td>
                                        {if $item.successfull eq 'book' && $item.TicketNumber gt 0}
                                               {$objFunctions->numberformat($objbook->TotalPriceByTicketNumberAdmin($item.TicketNumber,$item.successfull))} ریال
                                            {else}
                                            {$objFunctions->numberformat($objbook->TotalPriceByTicketNumberAdmin($item.requestNumber,'no'))}
                                        {/if}
                                    </td>
                                    <td>
                                        <div class="btn-group m-r-10">

                                            <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light" type="button">  عملیات <span class="caret"></span></button>

                                            <ul role="menu" class="dropdown-menu animated flipInY">
                                                <li>
                                                    <div class="pull-left">

                                                        <div class="pull-left margin-10">
                                                            <a onclick="ModalShowBookForTrain('{$item.requestNumber}');return false" data-toggle="modal" data-target="#ModalPublic">
                                                                <i style="margin: 5px auto;"  class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                                                   data-toggle="tooltip" data-placement="top" title=""
                                                                   data-original-title="مشاهده خرید"></i>
                                                            </a>
                                                        </div>

                                                        <div class="pull-left margin-10">

                                                            {if $smarty.const.ADMIN_TYPE eq '1'}
                                                                {assign var="url" value=$item.DomainAgency}
                                                                {else}
                                                                {assign var="url" value=$smarty.const.CLIENT_DOMAIN}
                                                            {/if}

                                                            {if $item.successfull eq 'book'}
                                                                <a href="{$smarty.const.SERVER_HTTP}{$url}/gds/pdf&target=trainBooking&id={$item.requestNumber}"
                                                                               target="_blank">
                                                                <i class="fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-file-pdf-o "
                                                                   data-toggle="tooltip"
                                                                   data-placement="top" title=""
                                                                   data-original-title="بلیط پارسی"></i>
                                                            </a>
                                                            {/if}
                                                        </div>

                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td>
                                        {if  $item.successfull eq 'book'}
                                            <a class="btn btn-success cursor-default" onclick="return false;"> رزرو قطعی</a>
                                        {elseif $item.successfull eq 'prereserve'}
                                            <a class="btn btn-warning cursor-default" onclick="return false;">پیش رزرو</a>
                                        {elseif $item.successfull eq 'bank'}
                                            <a class="btn btn-primary cursor-default" onclick="return false;">هدایت به درگاه</a>
                                        {elseif $item.successfull eq 'nothing' || $item.successfull eq ''}
                                            <a class="btn btn-info cursor-default" onclick="return false;">نامشخص</a>
                                        {elseif $item.successfull eq 'error'}
                                            <a class="btn btn-danger cursor-default" onclick="return false;">خطا از سمت رجا</a>
                                        {/if}
                                    </td>
                                </tr>

                                {/foreach}
                        </tbody>

                        <tfoot>
                        <tr>

                            <th colspan="2"></th>
{*                            <th colspan="7">({$objbook->totalPrice|number_format})ريال</th>*}
                            <th colspan="8"></th>
                            <th colspan="2"></th>

                        </tr>
                        </tfoot>

                    </table>
                </div>

            </div>
        </div>

    </div>
</div>

<div class="i-section">
    <div class="i-info">
        <span> ویدیو آموزشی بخش سوابق خرید بلیط قطار</span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/368/---.html" target="_blank" class="i-btn"></a>

</div>

{if $smarty.post.checkBoxAdvanceSearch neq ''}
{literal}
<script type="text/javascript">
    $('document').ready(function () {
        $('.showAdvanceSearch').fadeIn();
        $('#checkBoxAdvanceSearch').attr('checked',true);
    });
</script>
    {/literal}
{/if}

<script type="text/javascript" src="assets/JsFiles/bookTrainShow.js"></script>
{/if}