{if $smarty.const.TYPE_ADMIN eq 1}
{load_presentation_object filename="bookhotelshow" assign="objbook"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>گزارش خرید</li>
                <li class="active">سوابق خرید هتل</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <h3 class="box-title m-b-0">جستجوی سوابق خرید هتل </h3>

                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید سوابق را در تاریخ های مورد نظرتان جستجو کنید</p>

                <form id="SearchHotelHistory" method="post" action="{$smarty.const.rootAddress}hotelHistory">
                    <input type="hidden" name="flag" id="flag" value="createExcelFile">

                    <div class="form-group col-sm-6">
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

                    <div class="form-group col-sm-6">
                        <label for="client_id" class="control-label">نرم افزار</label>
                        <select name="type_app" id="type_app" class="form-control">
                            <option value="">انتخاب کنید....</option>
                            <option value="all" {if $smarty.post.type_app eq 'all' }selected{/if}>همه</option>
                            <option value="api" {if $smarty.post.type_app eq 'api' }selected{/if}>هتل اشتراکی داخلی</option>
                            <option value="reservation" {if $smarty.post.type_app eq 'reservation' }selected{/if}>هتل رزرواسیون</option>
                            <option value="externalApi" {if $smarty.post.type_app eq 'externalApi' }selected{/if}>هتل اشتراکی خارجی</option>
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
                            <option value="all" {if $smarty.post.payment_type eq 'all' }selected{/if}>همه</option>
                            <option value="cash" {if $smarty.post.payment_type eq 'cash' }selected{/if}>نقدی</option>
                            <option value="credit" {if $smarty.post.payment_type eq 'credit' }selected{/if}>اعتباری</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-6 showAdvanceSearch " style="display: none;">
                        <label for="StartDate" class="control-label">تاریخ ورود</label>
                        <input type="text" class="form-control datepicker" name="StartDate" value="{$smarty.post.StartDate}"
                               id="StartDate" placeholder="تاریخ ورود جستجو را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6 showAdvanceSearch " style="display: none;">
                        <label for="EndDate" class="control-label">تاریخ خروج</label>
                        <input type="text" class="form-control datepicker" name="EndDate" value="{$smarty.post.EndDate}"
                               id="EndDate" placeholder="تاریخ خروج جستجو را وارد نمائید">
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
                    <a onclick="createExcelForReportHotel()" class="btn btn-primary waves-effect waves-light " type="button" id="btn-excel">
                        <span class="btn-label"><i class="fa fa-download"></i></span>دریافت فایل اکسل</a>
                    <img src="../../pic/load.gif" alt="please wait ..." id="loader-excel" class="displayN">
                </div>

                <h3 class="box-title m-b-0">سوابق خرید هتل</h3>
                <p class="text-muted m-b-30">کلیه سوابق خرید هتل را در این لیست میتوانید مشاهده کنید</p>

                <div class="table-responsive">
                    <table id="hotelHistory" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th> شهر<br/>هتل</th>
                            <th> تاریخ خرید<br> ساعت خرید<br>نام خریدار</th>
                            <th> تاریخ ورود<br> تاریخ خروج<br> مدت اقامت</th>
                            <th>شماره فاکتور</th>
                            <th>اتاق</th>
                            <th>سهم آژانس</th>
                            <th>سهم کارگزار</th>
                            {if $smarty.const.TYPE_ADMIN eq '1'}
                                <th>سهم ما</th>
                            {/if}
                            <th>قیمت کل <br> قیمت پرداختی</th>
                            <th>عملیات</th>
                            <th>وضعیت</th>
                        </tr>
                        </thead>
                        <tbody>

                        {assign var="listBook" value=$objbook->listBookHotelLocal()}
                        {foreach key=key item=item from=$listBook}
                            {$number = $key + 1}

                            {if $smarty.const.TYPE_ADMIN eq '1'}
                                {assign var="addressClient" value=$objbook->ShowAddressClient($item.client_id)}
                            {else}
                                {assign var="addressClient" value=$objbook->ShowAddressClient($smarty.const.CLIENT_ID)}
                            {/if}

                            {assign var="infoMember" value=$objFunctions->infoMember($item.member_id,$item.client_id)}

                        <tr id="del-{$item.id}">

                            <td>{$number}</td>
                            <td>
                                {$item.city_name}
                                <hr style="margin:3px">
                                {$item.hotel_name}
                            </td>
                            <td>
                                {if $item.payment_date neq ''}{$item.payment_date}<hr style="margin:3px">{/if}
                                {if $item.payment_time neq ''}{$item.payment_time}<hr style="margin:3px">{/if}
                                {$item.member_name}

                                    {if $item.services_discount neq '' && $infoMember.is_member eq '1'}
                                        <hr style='margin:3px'>
                                        {if $infoMember.fk_counter_type_id eq '5'}مسافر  {else} کانتر{/if}
                                        {$item.services_discount} %ای
                                    {/if}
                                </td>
                                <td>{$item.start_date}
                                    <hr style="margin:3px">
                                    {$item.end_date}
                                    <hr style="margin:3px">
                                    {$item.number_night} شب
                                </td>
                                <td>
                                    {$item.type_application_fa}
                                    <hr style="margin:3px">
                                    {$item.factor_number}
                                </td>
                                <td>
                                    <div class="button-box">
                                        <button type="button" class="btn btn-default btn-outline"
                                                title="" data-toggle="popover"
                                                data-placement="top" data-content="{$item.room}"
                                                data-original-title="اتاق های رزرو شده">{$item.room_count}</button>
                                    </div>
                                </td>

                                {if $item.type_application eq 'api' || $item.type_application eq 'api_app' || $item.type_application eq 'externalApi'}
                                    <td>{$item.agency_commission}</td>
                                    <td>

                                        {$item.price|number_format:0:".":","}

                                    </td>
                                    {if $smarty.const.TYPE_ADMIN eq '1'}
                                        <td>{$item.irantech_commission|number_format:0:".":","}</td>
                                    {/if}
                                {else}
                                    <td>-----</td>
                                    <td>-----</td>
                                    {if $smarty.const.TYPE_ADMIN eq '1'}
                                        <td>-----</td>
                                    {/if}
                                {/if}

                                <td>{$item.total_price|number_format:0:".":","}
                                    <hr style="margin:3px">
                                    {$item.hotel_payments_price|number_format:0:".":","}
                                </td>
                                <td>

                                    {assign var="linkView" value="ehotelLocal"}
                                    {assign var="linkPDF" value="BookingHotelLocal"}

                                    {if $smarty.const.CLIENT_NAME eq 'آهوان'}{*For Ahuan*}
                                        {$linkView = 'ehotelAhuan'}
                                        {$linkPDF = 'hotelVoucherAhuan'}

                                {elseif $smarty.const.CLIENT_NAME eq 'زروان مهر آریا'}{*For Zarvan*}
                                    {$linkView = 'ehotelZarvan'}
                                    {$linkPDF = 'BookingHotelLocal'}

                                {else}
                                    {$linkView = 'ehotelLocal'}
                                    {$linkPDF = 'BookingHotelLocal'}

                                {/if}
                                <div class="btn-group m-r-10">

                                    <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light" type="button">  عملیات <span class="caret"></span></button>

                                    <ul role="menu" class="dropdown-menu animated flipInY">
                                        <li>
                                            <div class="pull-left">

                                                {if $item.type_application eq 'reservation'}
                                                    {$objbook->getEditHotelBookingReport($item.factor_number)}
                                                    {if $objbook->editHotelBooking eq 'True'}
                                                        <div class="pull-left margin-10">
                                                            <a onclick="ModalShowEditBookHotel('{$item.factor_number}');return false" data-toggle="modal" data-target="#ModalPublic">
                                                                <i style="margin: 5px auto;"  class="fcbtn btn btn-success btn-outline btn-1c fa fa-list"
                                                                   data-toggle="tooltip" data-placement="top" title=""
                                                                   data-original-title="مشاهده ویرایش رزرو"></i>
                                                            </a>
                                                        </div>
                                                    {/if}

                                                    {if $item.status eq 'BookedSuccessfully'}
                                                        <div class="pull-left margin-10">
                                                            <a onclick="allowEditingHotel('{$item.factor_number}', '{$item.member_id}');return false" title="ویرایش رزرو">
                                                                <i style="margin: 5px auto;" class="fcbtn btn btn-warning btn-outline btn-1c tooltip-warning fa fa-check"
                                                                   data-toggle="tooltip" data-placement="top" title="" data-original-title="برگرداندن اعتبار و ظرفیت برای امکان ویرایش رزرو">
                                                                </i>
                                                            </a>
                                                        </div>
                                                    {/if}
                                                {/if}

                                                <div class="pull-left margin-10">
                                                    <a onclick="ModalShowBookForHotel('{$item.factor_number}');return false" data-toggle="modal" data-target="#ModalPublic">
                                                        <i style="margin: 5px auto;"  class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title="مشاهده خرید"></i>
                                                    </a>
                                                </div>

                                                <div class="pull-left margin-10">
                                                    {if $item.status eq 'BookedSuccessfully'}

                                                        <a href="{$smarty.const.SERVER_HTTP}{$addressClient}/gds/{$linkView}&num={$item.factor_number}"
                                                           target="_blank"
                                                           title="مشاهده اطلاعات خرید" >
                                                            <i style="margin: 5px auto;" class="fcbtn btn btn-outline btn-danger btn-1c tooltip-danger fa fa-print "
                                                               data-toggle="tooltip" data-placement="top" title=""
                                                               data-original-title="مشاهده اطلاعات خرید"></i>
                                                        </a>

                                                    {/if}
                                                </div>

                                                <div class="pull-left margin-10">
                                                    {if $item.status eq 'BookedSuccessfully'}
                                                    <a href="{$smarty.const.SERVER_HTTP}{$addressClient}/gds/pdf&target={$linkPDF}&id={$item.factor_number}"
                                                       target="_blank">
                                                        <i style="margin: 5px auto;" class="fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-file-pdf-o "
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title=" رزرو هتل پارسی "></i>
                                                    </a>
                                                    {/if}
                                                </div>

                                                <div class="pull-left margin-10">
                                                    {if $item.status eq 'BookedSuccessfully'}
                                                    <a href="{$smarty.const.SERVER_HTTP}{$addressClient}/gds/pdf&target=bookhotelshow&id={$item.factor_number}"
                                                       target="_blank">
                                                        <i style="margin: 5px auto;" class="fcbtn btn btn-outline btn-success btn-1c  tooltip-success  fa fa-file-pdf-o"
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title=" رزرو هتل انگلیسی "></i>
                                                    </a>
                                                    {/if}
                                                </div>

                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                {if $smarty.const.TYPE_ADMIN eq '1'}
                                    <hr style='margin:3px'>
                                    {if $item.agency_name neq ''}{$item.agency_name}{else}{$objFunctions->ClientName($item.client_id)}{/if}
                                    {if $item.request_from eq 'api'}
                                        <hr style="margin: 3px;">
                                        API
                                    {else}
                                        <hr style="margin: 3px;">
                                        <span>وبسایت</span>
                                    {/if}
                                {/if}


                                </td>
                                <td>
                                    {if $item.status eq 'BookedSuccessfully'}
                                        <a class="btn btn-success cursor-default" onclick="return false;"> رزرو قطعی</a>
                                    {elseif $item.status eq 'PreReserve'}
                                        <a class="btn btn-warning cursor-default" onclick="return false;">پیش رزرو (تایید شده توسط کانتر)</a>
                                    {elseif $item.status eq 'bank' && $item.tracking_code_bank eq ''}
                                        <a class="btn btn-danger cursor-default" onclick="return false;">پرداخت اینترنتی نا موفق</a>
                                    {elseif $item.status eq 'Cancelled'}
                                        <a class="btn btn-danger cursor-default" onclick="return false;">لغو درخواست</a>
                                    {else}
                                        <a class="btn btn-danger cursor-default" onclick="return false;">نامشخص</a>
                                    {/if}
                                </td>
                            </tr>

                        {/foreach}
                        </tbody>

                        <tfoot>
                            <tr>
                                <th colspan="5"></th>
                                <th colspan=""></th>
                                <th colspan=""></th>
                                <th colspan=""> {$objbook->price|number_format:0:".":","} ريال</th>
                                {if $smarty.const.TYPE_ADMIN eq '1'}
                                    <th colspan="">({$objbook->priceForMa|number_format:0:".":","})ريال</th>
                                {/if}
                                <th colspan="">({$objbook->totalPrice|number_format:0:".":","})ريال</th>
                                <th colspan=""></th>
                                <th colspan="2"></th>
                                <th></th>
                                <th></th>
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
        <span> ویدیو آموزشی بخش سوابق خرید هتل  </span>
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

<script type="text/javascript" src="assets/JsFiles/bookhotelshow.js"></script>
<script type="text/javascript" src="assets/JsFiles/reservationHotel.js"></script>
{/if}
