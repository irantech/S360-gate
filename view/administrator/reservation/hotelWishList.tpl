{load_presentation_object filename="bookhotelshow" assign="objbook"}
{assign var="expiredBook" value=$objbook->checkForExpired()}

{if strpos($expiredBook,'Success') neq false}
    <script type="text/javascript">
        alert('یک یا چند رزرو بدلیل عدم رسیدگی (محدودیت زمانی) لغو شدند');
    </script>
{/if}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت هتل رزرواسیون</li>
                <li class="active">لیست درخواست هتل</li>
            </ol>
        </div>
    </div>



    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">جستجوی سوابق خرید هتل </h3>

                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید سوابق را در تاریخ های مورد نظرتان جستجو
                    کنید
                </p>

                <form id="SearchHotelWishList" method="post" action="{$smarty.const.rootAddress}hotelWishList">

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
                            <option value="OnRequest" {if $smarty.post.status eq  'OnRequest' }selected{/if}>منتظر تایید</option>
                            <option value="Cancelled" {if $smarty.post.status eq 'Cancelled' }selected{/if}>لغو درخواست</option>
                            <option value="PreReserve" {if $smarty.post.status eq 'PreReserve' }selected{/if}>پیش رزرو</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="factor_number" class="control-label">شماره فاکتور</label>
                        <input type="text" class="form-control " name="factor_number"
                               value="{$smarty.post.factor_number}" id="factor_number"
                               placeholder="شماره فاکتور را وارد نمائید">
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
                <h3 class="box-title m-b-0">لیست درخواست هتل</h3>
                <p class="text-muted m-b-30">کلیه درخواست های هتل را در این لیست میتوانید مشاهده کنید
                </p>

                <div class="table-responsive" style="min-height:300px;">
                    <table id="hotelWishList" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>شهر</th>
                            <th>هتل</th>
                            <th> تاریخ خرید<br> ساعت خرید</th>
                            <th> تاریخ ورود<br> تاریخ خروج<br> مدت اقامت</th>
                            <th>شماره فاکتور<br></th>
                            <th>قیمت کل</th>
                            <th>اتاق</th>
                            <th> نام خریدار</th>
                            <th>عملیات</th>
                            <th>وضعیت</th>
                        </tr>
                        </thead>
                        <tbody>

                        {assign var="TotalPrice" value="0"}
                        {foreach key=key item=item from=$objbook->hotelWishList()}
                        {$number = $number + 1}
                        {assign var="rooms" value=$objbook->InformationOfEachReservation($item.factor_number)}
                        {$TotalPrice = $TotalPrice + $item.total_price}


                        <tr id="del-{$item.id}">
                            <td>{$number}</td>
                            <td>{$item.city_name}</td>
                            <td>{$item.hotel_name}</td>
                            <td>
                                {$objFunctions->showDate('Y-m-d H:i:s',$item.creation_date_int)|replace:' ':'<hr style="margin:3px" />'}
                                {*{if $item.payment_date neq ''}
                                    {$objFunctions->set_date_payment($item.payment_date)|replace:' ':'<hr style="margin:3px" />'}
                                {/if}*}
                            </td>
                            <td>{$item.start_date}<br>{$item.end_date}<br>{$item.number_night} شب</td>
                            <td>
                                {$item.factor_number}
                                <hr style="margin:3px">
                                {if $item.type_application eq 'reservation'}هتل رزرواسیون
                                {elseif $item.type_application eq 'reservation_app'}هتل رزرواسیون<br>(خرید از اَپلیکیشن)
                                {elseif $item.type_application eq 'api' && $item.serviceTitle eq 'PublicLocalHotel'}هتل اشتراکی
                                {elseif $item.type_application eq 'api' && $item.serviceTitle eq 'PrivateLocalHotel'}هتل اختصاصی
                                {elseif $item.type_application eq 'api_app'}هتل اشتراکی<br>(خرید از اَپلیکیشن)
                                {/if}
                            </td>
                            <td>{$item.total_price|number_format:0:".":","}</td>

                            <td>
                                <div class="button-box">
                                    <button type="button" class="btn btn-default btn-outline"
                                            title="" data-toggle="popover"
                                            data-placement="top" data-content="{$rooms['room']}"
                                            data-original-title="اتاق های رزرو شده">{$item.room_count}</button>
                                </div>
                            </td>

                            <td>
                                {if $item.member_name neq ''}
                                    {$item.member_name}
                                {else}
                                    {$item.passenger_leader_room_fullName}
                                {/if}
                            </td>
                            <td>
                                <div class="btn-group m-r-10">

                                    <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light" type="button">  عملیات <span class="caret"></span></button>

                                    <ul role="menu" class="dropdown-menu animated flipInY">
                                        <li>
                                            <div class="pull-left">
                                                <div class="pull-left margin-10">
                                                    <a onclick="ModalShowBookForHotel('{$item.factor_number}');return false" data-toggle="modal" data-target="#ModalPublic">
                                                        <i style="margin: 5px auto;"  class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title="مشاهده خرید"></i>
                                                    </a>
                                                </div>

                                                {if $item.type_application eq 'reservation'}
                                                <div class="pull-left margin-10">
                                                    <a onclick="sendEmailForHotelBroker('{$item.factor_number}', '{$item.hotel_id}');return false" title="ارسال واچر به کارگزار">
                                                        <i style="margin: 5px auto;"  class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-reply"
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title="ارسال واچر به کارگزار">
                                                        </i>
                                                    </a>
                                                </div>
                                                {/if}

                                                {if $item.status eq 'OnRequest'}
                                                <div class="pull-left margin-10">
                                                    <a onclick="ajaxCheckOfflineStatus('{$item.request_number}');return false" title="بررسی وضعیت">
                                                        <i style="margin: 5px auto;" class="fcbtn btn btn-outline btn-success btn-1c tooltip-warning fa fa-refresh"
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title="بررسی وضعیت">
                                                        </i>
                                                    </a>
                                                </div>
                                                {*<div class="pull-left margin-10">
                                                    <a onclick="confirmationHotelReservation('{$item.factor_number}', '{$item.type_application}');return false" title="مشاهده اطلاعات خرید" >
                                                        <i style="margin: 5px auto;" class="fcbtn btn btn-outline btn-success btn-1c  tooltip-success  fa fa-check"
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title="تایید رزرو">
                                                        </i>
                                                    </a>
                                                </div>*}

                                                <div class="pull-left margin-10">
                                                        <a onclick="newConfirmationHotelReserve('{$item.factor_number}', '{$item.type_application}');return false" title="مشاهده اطلاعات خرید" >
                                                            <i style="margin: 5px auto;" class="fcbtn btn btn-outline btn-success btn-1c  tooltip-success  fa fa-check"
                                                               data-toggle="tooltip" data-placement="top" title=""
                                                               data-original-title="تایید رزرو">
                                                            </i>
                                                        </a>
                                                    </div>
                                                <div class="pull-left margin-10">
                                                    <a onclick="cancelHotelReservation('{$item.factor_number}', '{$item.type_application}');return false" title="مشاهده اطلاعات خرید" >
                                                        <i style="margin: 5px auto;" class="fcbtn btn btn-outline btn-danger btn-1c  tooltip-danger fa fa-times "
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title="لغو درخواست">
                                                        </i>
                                                    </a>
                                                </div>
                                                <div class="pull-left margin-10">
                                                        <a href="#" data-factor="{$item.factor_number}"  class="admin_checked" title="{if $item.admin_checked == 1}درحال بررسی {else}منتظر تایید{/if}">
                                                            <i style="margin: 5px auto;" class="fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-check-circle "
                                                               data-toggle="tooltip" data-placement="top" title="{if $item.admin_checked}درحال بررسی {else}منتظر تایید{/if}">
                                                            </i>
                                                        </a>
                                                </div>
                                                {/if}

                                                <div class="pull-left margin-10">
                                                    <a href="{$smarty.const.SERVER_HTTP}{$objbook->ShowAddressClient($smarty.const.CLIENT_ID)}/gds/ehotelReservation&num={$item.factor_number}"
                                                       target="_blank"
                                                       title="مشاهده اطلاعات خرید" >
                                                        <i style="margin: 5px auto;" class="fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-print "
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title="مشاهده اطلاعات خرید">
                                                        </i>
                                                    </a>
                                                </div>

                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                {if $smarty.const.TYPE_ADMIN eq '1'}
                                    <hr style='margin:3px'>
                                    {if $item.agency_name neq ''}{$item.agency_name}{else}{$objFunctions->ClientName($item.client_id)}{/if}
                                {/if}


                            </td>

                            <td>
                                {if $item.status eq 'BookedSuccessfully'}
                                    <a class="btn btn-success cursor-default" onclick="return false;"> رزرو قطعی</a>
                                {elseif $item.status eq 'PreReserve'}
                                    <a class="btn btn-warning cursor-default" onclick="return false;">پیش رزرو</a>
                                {elseif $item.status eq 'bank' && $item.tracking_code_bank eq ''}
                                    <a class="btn btn-danger cursor-default" onclick="return false;">پرداخت اینترنتی نا موفق</a>
                                {elseif $item.status eq 'Cancelled' && $item.admin_checked eq '1'}
                                    <a class="btn btn-danger cursor-default" onclick="return false;">لغو درخواست</a>
                                {elseif $item.status eq 'Cancelled' && $item.admin_checked eq '0'}
                                    <a class="btn btn-danger cursor-default" onclick="return false;">لغو درخواست به دلیل محدودیت زمانی</a>
                                {elseif $item.status eq 'OnRequest'}
                                    {if $item.admin_checked eq '1'}
                                        <a class="btn btn-primary cursor-default" onclick="return false;">در حال بررسی</a>
                                        {else}
                                        <a class="btn btn-primary cursor-default" onclick="return false;">منتظر تایید مدیر</a>
                                    {/if}
                                {else}
                                    <a class="btn btn-danger cursor-default" onclick="return false;">نامشخص</a>
                                {/if}

                                {if $item.type_application eq 'reservation'}
                                    <hr style="margin:3px">

                                    {if $item.status_confirm_hotel eq 'Ok'}
                                        تایید شده توسط هتل
                                    {elseif $item.status_confirm_hotel eq 'No'}
                                        رد درخواست توسط هتل
                                    {elseif $item.status_confirm_hotel eq 'Cancel'}
                                        لغو درخواست توسط هتل
                                    {elseif $item.status_confirm_hotel eq 'sendMail'}
                                        ایمیل برای کارگزار هتل ارسال شده. پاسخی از سمت هتل دریافت نشده.
                                    {else}
                                        ایمیلی برای کارگزار هتل ارسال نشده است.
                                    {/if}
                                {/if}

                            </td>

                        </tr>

                        <tr class="displayN">
                            <td colspan="11">
                                <p id="error-log-response-{$item.factor_number}"></p>
                            </td>
                        </tr>

                        {/foreach}
                        </tbody>

                    </table>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                </div>


            </div>
        </div>

    </div>
</div>

<div class="i-section">
    <div class="i-info">
        <span> ویدیو آموزشی بخش لیست درخواست هتل </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/376/--.html" target="_blank" class="i-btn"></a>

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
