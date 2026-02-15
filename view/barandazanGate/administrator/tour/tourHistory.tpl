{if $smarty.const.TYPE_ADMIN eq 1}
{load_presentation_object filename="bookTourShow" assign="objbook"}
{load_presentation_object filename="bookhotelshow" assign="objRsult"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>گزارش خرید</li>
                <li class="active">سوابق خرید تور</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">جستجوی سوابق خرید تور </h3>

                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید سوابق را در تاریخ های مورد نظرتان جستجو
                    کنید
                </p>

                <form id="SearchTourHistory" method="post" action="{$smarty.const.rootAddress}tourHistory">
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
                    <a onclick="createExcelForReportTour()" class="btn btn-primary waves-effect waves-light " type="button" id="btn-excel">
                        <span class="btn-label"><i class="fa fa-download"></i></span>دریافت فایل اکسل</a>
                    <img src="../../pic/load.gif" alt="please wait ..." id="loader-excel" class="displayN">
                </div>

                <h3 class="box-title m-b-0">سوابق خرید تور</h3>
                <p class="text-muted m-b-30">کلیه سوابق خرید تور را در این لیست میتوانید مشاهده کنید</p>

                <div class="table-responsive">
                    <table id="tourHistory" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام تور<br/>تخفیف</th>
                            <th>تاریخ رفت<br/>تاریخ برگشت</th>
                            <th>چند شب / چند روز</th>
                            <th> تاریخ خرید<br> ساعت خرید<br/>شماره فاکتور</th>
                            <th>قیمت کل<br>قیمت پرداختی<br> جریمه کنسلی</th>
                            <th>قیمت کل ارزی<br>قیمت پرداختی ارزی</th>
                            <th>عملیات</th>
                            <th>وضعیت</th>
                        </tr>
                        </thead>
                        <tbody>

                        {foreach key=key item=item from=$objbook->listBookTourLocal()}


                            {if $smarty.const.TYPE_ADMIN eq '1'}
                                {assign var="addressClient" value=$objRsult->ShowAddressClient($item.client_id)}
                            {else}
                                {assign var="addressClient" value=$objRsult->ShowAddressClient($smarty.const.CLIENT_ID)}
                            {/if}


                        <tr id="del-{$item.id}">
                            <td>{$key+1}</td>

                            <td>
                                {$item.tour_name}
                                <hr style="margin:3px">
                                {$item.tour_code}
                                {if $item.tour_discount neq ''}
                                <hr style="margin:3px">
                                    {$item.tour_discount} {if $item.tour_discount_type eq 'price'}ریال{else}%{/if}
                                {/if}
                            </td>

                            <td>
                                {$item.tour_start_date}
                                <hr style="margin:3px">
                                {$item.tour_end_date}
                            </td>

                            <td>{$item.tour_night} شب و {$item.tour_day} روز</td>

                            <td>
                                {if $item.payment_date neq ''}
                                    {$item.payment_date}
                                    <hr style="margin:3px">
                                    {$item.payment_time}
                                {/if}
                                <hr style="margin:3px">
                                {$item.factor_number}
                            </td>

                            <td>
                                {$item.tour_total_price|number_format:0:".":","}
                                {if $item.price neq ''}
                                    <hr style="margin:3px">
                                    <span style="text-decoration: line-through;">{$item.price|number_format:0:".":","}</span>
                                {/if}
                                <hr style="margin:3px">
                                {$item.tour_payments_price|number_format:0:".":","}
                                <hr style="margin:3px">
                                {$item.cancellation_price|number_format:0:".":","}
                            </td>

                            <td>
                                {$item.tour_total_price_a|number_format:0:".":","} {$item.currency_title_fa}
                                <hr style="margin:3px">
                                {$item.tour_payments_price_a|number_format:0:".":","} {$item.currency_title_fa}

                                {if $item.tour_total_price_a gt 0 && $item.tour_total_price_a gt $item.tour_payments_price_a}
                                    <hr style="margin:3px">
                                    <div class="pull-left margin-10">
                                        <a onclick="setTourPaymentsPriceA('{$item.factor_number}', '{$item.tour_total_price_a}');return false" title="پرداخت مبلغ ارزی">
                                            <i style="margin: 5px auto;" class="fcbtn btn btn-warning btn-outline btn-1c tooltip-warning fa fa-check"
                                               data-toggle="tooltip" data-placement="top" title="" data-original-title="تایید پرداخت مبلغ ارزی تور">
                                            </i>
                                        </a>
                                    </div>
                                {/if}

                            </td>

                            <td>

                                <div class="btn-group m-r-10">

                                    <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light" type="button">  عملیات <span class="caret"></span></button>

                                    <ul role="menu" class="dropdown-menu animated flipInY">
                                        <li>
                                            <div class="pull-left">

                                                <div class="pull-left margin-10">
                                                    <a onclick="ModalShowBookForTour('{$item.factor_number}');return false" data-toggle="modal" data-target="#ModalPublic">
                                                        <i style="margin: 5px auto;"  class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title="مشاهده خرید"></i>
                                                    </a>
                                                </div>

                                                {if $item.status eq 'BookedSuccessfully' || $item.status eq 'TemporaryReservation'}
                                                <div class="pull-left margin-10">
                                                    <a href="{$smarty.const.SERVER_HTTP}{$addressClient}/gds/eTourReservation&num={$item.factor_number}"
                                                       target="_blank"
                                                       title="مشاهده اطلاعات خرید" >
                                                        <i style="margin: 5px auto;" class="fcbtn btn btn-outline btn-danger btn-1c tooltip-danger fa fa-print "
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title="مشاهده اطلاعات خرید"></i>
                                                    </a>
                                                </div>

                                                <div class="pull-left margin-10">
                                                    <a href="{$smarty.const.SERVER_HTTP}{$addressClient}/gds/pdf&target=BookingTourLocal&id={$item.factor_number}"
                                                       target="_blank">
                                                        <i style="margin: 5px auto;" class="fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-file-pdf-o"
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title=" رزرو تور پارسی "></i>
                                                    </a>
                                                </div>

                                                {/if}

                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                {if $smarty.const.TYPE_ADMIN eq '1'}
                                    <hr style='margin:3px'>
                                    {if $item.agency_name neq ''}{$item.agency_name}{else}{$objFunctions->ClientName($item.client_id)}{/if}
                                {/if}

                                <hr style='margin:3px'>
                                {$item.member_name}


                            </td>
                            <td>
                                {if $item.tour_total_price_a eq 0 && $item.status eq 'BookedSuccessfully'}
                                    <a class="btn btn-success cursor-default" onclick="return false;"> رزرو قطعی</a>
                                {elseif $item.tour_total_price_a gt 0 && $item.tour_total_price_a eq $item.tour_payments_price_a && $item.status eq 'BookedSuccessfully'}
                                    <a class="btn btn-success cursor-default" onclick="return false;"> رزرو قطعی</a>
                                {elseif $item.tour_total_price_a gt 0 && $item.tour_total_price_a gt $item.tour_payments_price_a && $item.status eq 'BookedSuccessfully'}
                                    <a class="btn btn-success cursor-default" onclick="return false;"> رزرو قطعی  ( بدون پرداخت مبلغ ارزی)</a>
                                {elseif $item.status eq 'PreReserve'}
                                    <a class="btn btn-warning cursor-default" onclick="return false;">پیش رزرو (تایید شده توسط کانتر)</a>
                                {elseif $item.status eq 'TemporaryReservation'}
                                    <a class="btn btn-success cursor-default" onclick="return false;">رزرو موقت (پرداخت مبلغ پیش رزرو)</a>
                                {elseif $item.status eq 'TemporaryPreReserve'}
                                    <a class="btn btn-warning cursor-default" onclick="return false;">پیش رزرو موقت</a>
                                {elseif $item.status eq 'bank' && $item.tracking_code_bank eq ''}
                                    <a class="btn btn-danger cursor-default" onclick="return false;">پرداخت اینترنتی نا موفق</a>
                                {elseif $item.status eq 'Cancellation'}
                                    <a class="btn btn-danger cursor-default" onclick="return false;">کنسلی</a>
                                    <hr style='margin:3px'>
                                    {$item.cancellation_comment}
                                {else}
                                    <a class="btn btn-danger cursor-default" onclick="return false;">نامشخص</a>
                                {/if}

                                {if $item.cancel_status eq 'CancellationRequest'}
                                    <hr style='margin:3px'>
                                    <a class="btn btn-danger cursor-default" onclick="return false;">درخواست کنسلی از طرف مسافر</a>
                                {elseif $item.cancel_status eq 'ConfirmCancellationRequest'}
                                    <hr style='margin:3px'>
                                    <a class="btn btn-danger cursor-default" onclick="return false;">تایید درخواست کنسلی از طرف کارگزار</a>
                                {/if}
                            </td>
                        </tr>

                        {/foreach}
                        </tbody>

                        <tfoot>
                        <tr>

                            <th colspan="6"></th>
                            <th colspan="7">({$objbook->totalPrice|number_format})ريال</th>
                            <th colspan="8"></th>
                            <th colspan="9"></th>

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
        <span> ویدیو آموزشی بخش سوابق خرید تور   </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/370/---.html" target="_blank" class="i-btn"></a>

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

<script type="text/javascript" src="assets/JsFiles/bookTourShow.js"></script>
{/if}