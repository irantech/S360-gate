{if $smarty.const.TYPE_ADMIN eq 1}
{load_presentation_object filename="bookEuropcarShow" assign="objbook"}
{load_presentation_object filename="bookhotelshow" assign="objRsult"}
{load_presentation_object filename="resultEuropcarLocal" assign="objResultEuropcar"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>گزارش خرید</li>
                <li class="active">سوابق خرید اجاره خودرو</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">جستجوی سوابق خرید اجاره خودرو </h3>

                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید سوابق را در تاریخ های مورد نظرتان جستجو
                    کنید
                </p>

                <form id="SearchEuropcarHistory" method="post" action="{$smarty.const.rootAddress}europcarHistory">
                    <input type="hidden" name="flag" id="flag" value="createExcelFileForEuropcar">

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
                    <a onclick="createExcelForReportEuropcar()" class="btn btn-primary waves-effect waves-light " type="button" id="btn-excel">
                        <span class="btn-label"><i class="fa fa-download"></i></span>دریافت فایل اکسل</a>
                    <img src="../../pic/load.gif" alt="please wait ..." id="loader-excel" class="displayN">
                </div>

                <h3 class="box-title m-b-0">سوابق خرید اجاره خودرو</h3>
                <p class="text-muted m-b-30">کلیه سوابق خرید اجاره خودرو را در این لیست میتوانید مشاهده کنید
                </p>

                <div class="table-responsive">
                    <table id="europcarHistory" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>ایستگاه تحویل</th>
                            <th>تاریخ تحویل<br/>ساعت تحویل</th>
                            <th>ایستگاه بازگشت</th>
                            <th>تاریخ بازگشت<br/>ساعت بازگشت</th>
                            <th> تاریخ خرید<br> ساعت خرید</th>
                            <th>نام خریدار</th>
                            <th>شماره فاکتور</th>
                            <th>نام ماشین</th>
                            <th>قیمت کل</th>
                            <th>عملیات</th>
                            <th>وضعیت</th>
                        </tr>
                        </thead>
                        <tbody>


                        {assign var="listBook" value=$objbook->listBookEuropcarLocal()}
                        {foreach key=key item=item from=$listBook}

                            {if $smarty.const.TYPE_ADMIN eq '1'}
                                {assign var="addressClient" value=$objRsult->ShowAddressClient($item.client_id)}
                            {else}
                                {assign var="addressClient" value=$objRsult->ShowAddressClient($smarty.const.CLIENT_ID)}
                            {/if}


                        <tr id="del-{$item.id}">
                            <td>{$key+1}</td>

                            <td>
                                {$item.source_station_name}
                            </td>

                            <td>
                                {$item.get_car_date}
                                <hr style="margin:3px">
                                {$item.get_car_time}
                            </td>

                            <td>
                                {$item.dest_station_name}
                            </td>

                            <td>
                                {$item.return_car_date}
                                <hr style="margin:3px">
                                {$item.return_car_time}
                            </td>

                            <td>
                                {if $item.payment_date neq ''}
                                    {$item.payment_date}
                                    <hr style="margin:3px">
                                    {$item.payment_time}
                                {/if}
                            </td>

                            <td>
                                {$item.member_name}
                                <hr style="margin:3px">
                                {$item.member_discount}
                            </td>

                            <td>{$item.factor_number}</td>

                            <td>{$item.car_name}</td>

                            <td>
                                {if $item.price neq ''}
                                    <span style="text-decoration: line-through;">{$item.price}</span>
                                    <hr style="margin:3px">
                                {/if}
                                {$item.total_price}
                            </td>

                            <td>

                                <div class="btn-group m-r-10">

                                    <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light" type="button">  عملیات <span class="caret"></span></button>

                                    <ul role="menu" class="dropdown-menu animated flipInY">
                                        <li>
                                            <div class="pull-left">

                                                <div class="pull-left margin-10">
                                                    <a onclick="ModalShowBookForEuropcar('{$item.factor_number}');return false" data-toggle="modal" data-target="#ModalPublic">
                                                        <i style="margin: 5px auto;"  class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title="مشاهده خرید"></i>
                                                    </a>
                                                </div>

                                                {if $item.status eq 'BookedSuccessfully' || $item.status eq 'TemporaryReservation'}
                                                <div class="pull-left margin-10">
                                                    <a href="{$smarty.const.SERVER_HTTP}{$addressClient}/gds/eEuropcarLocal&num={$item.factor_number}"
                                                       target="_blank"
                                                       title="مشاهده اطلاعات خرید" >
                                                        <i style="margin: 5px auto;" class="fcbtn btn btn-outline btn-danger btn-1c tooltip-danger fa fa-print "
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title="مشاهده اطلاعات خرید"></i>
                                                    </a>
                                                </div>

                                                <div class="pull-left margin-10">
                                                    <a href="{$smarty.const.SERVER_HTTP}{$addressClient}/gds/pdf&target=BookingEuropcarLocal&id={$item.factor_number}"
                                                       target="_blank">
                                                        <i style="margin: 5px auto;" class="fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-file-pdf-o "
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title=" رزرو اجاره خودرو پارسی "></i>
                                                    </a>
                                                </div>

                                                {*<div class="pull-left margin-10">
                                                    <a href="{$smarty.const.SERVER_HTTP}{$addressClient}/gds/pdf&target=bookEuropcarShow&id={$item.factor_number}"
                                                       target="_blank">
                                                        <i style="margin: 5px auto;" class="fcbtn btn btn-outline btn-success btn-1c  tooltip-success  fa fa-file-pdf-o"
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title=" رزرو اجاره خودرو انگلیسی "></i>
                                                    </a>
                                                </div>*}
                                                {/if}

                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                {if $smarty.const.TYPE_ADMIN eq '1'}
                                    <hr style='margin:3px'>
                                    {$item.agency_name}
                                {/if}


                            </td>
                            <td>
                                {if $item.status eq 'BookedSuccessfully'}
                                    <a class="btn btn-success cursor-default" onclick="return false;"> رزرو قطعی</a>
                                {elseif $item.status eq 'PreReserve'}
                                    <a class="btn btn-warning cursor-default" onclick="return false;">پیش رزرو</a>
                                {elseif $item.status eq 'bank' && $item.tracking_code_bank eq ''}
                                    <a class="btn btn-danger cursor-default" onclick="return false;">پرداخت اینترنتی نا موفق</a>
                                {elseif $item.status eq 'TemporaryReservation'}
                                    <a class="btn btn-warning cursor-default" onclick="return false;">پیش رزرو</a>
                                    <hr style='margin:3px'>منتظر تایید یا عدم تایید سیستم یوروپ کار
                                {elseif $item.status eq 'Cancellation'}
                                    <a class="btn btn-danger cursor-default" onclick="return false;">لغو درخواست</a>
                                {elseif $item.status eq 'CancelFromEuropcar'}
                                    <a class="btn btn-danger cursor-default" onclick="return false;">لغو درخواست</a>
                                    <hr style='margin:3px'>لغو درخواست از طرف سیستم یوروپ کار
                                {elseif $item.status eq 'NoShow'}
                                    <a class="btn btn-danger cursor-default" onclick="return false;">NoShow</a>
                                {else}
                                    <a class="btn btn-danger cursor-default" onclick="return false;">نامشخص</a>
                                {/if}
                            </td>
                        </tr>

                        {/foreach}
                        </tbody>

                        <tfoot>
                        <tr>
                            <th colspan="9"></th>
                            <th colspan="10">({$objbook->totalPrice|number_format})ريال</th>
                            <th colspan="11"></th>
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
        <span> ویدیو آموزشی بخش سوابق خرید اجاره خودرو  </span>
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

<script type="text/javascript" src="assets/JsFiles/bookEuropcarShow.js"></script>
{/if}