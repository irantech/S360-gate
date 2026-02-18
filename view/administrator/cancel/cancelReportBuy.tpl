{if $smarty.const.TYPE_ADMIN eq 1}
{load_presentation_object filename="cancelBuy" assign="objCancelBuy"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>گزارش خرید</li>
                <li class="active">سوابق کنسلی خریدها</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <h3 class="box-title m-b-0">جستجوی سوابق کنسلی خریدها </h3>

                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید سوابق را در تاریخ های مورد نظرتان جستجو
                    کنید
                </p>

                <form id="cancelReportForm" method="post" action="cancelReportBuy">
                    <input type="hidden" name="flag" id="flag" value="createExcelFileForCancelReportBuy">

                    <div class="form-group col-sm-6 ">
                        <label for="date_of" class="control-label">تاریخ شروع (کنسلی)</label>
                        <input type="text" class="form-control datepicker" name="date_of" value="{$smarty.post.date_of}"
                               id="date_of" placeholder="تاریخ شروع جستجو را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="to_date" class="control-label">تاریخ پایان (کنسلی)</label>
                        <input type="text" class="form-control datepickerReturn" name="to_date"
                               value="{$smarty.post.to_date}" id="to_date"
                               placeholder="تاریخ پایان جستجو را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="status" class="control-label">وضعیت کنسلی</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">انتخاب کنید....</option>
                            <option value="all" {if $smarty.post.status eq 'all' }selected{/if}>همه</option>
                            <option value="request_user" {if $smarty.post.status eq  'request_user' }selected{/if}>درخواست کاربر</option>
                            <option value="confirm_admin" {if $smarty.post.status eq 'confirm_admin' }selected{/if}>تایید درخواست کاربر</option>
                            <option value="confirm_admin" {if $smarty.post.status eq 'reject_cancel_request' }selected{/if}>رد درخواست کنسلی کاربر</option>
                            <option value="cancelled" {if $smarty.post.status eq 'cancelled' }selected{/if}>کنسل شده</option>
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

                <div class="box-btn-excel">
                    <a onclick="createExcel()" class="btn btn-primary waves-effect waves-light " type="button"
                       id="btn-excel">
                        <span class="btn-label"><i class="fa fa-download"></i></span>دریافت فایل اکسل</a>
                    <img src="../../pic/load.gif" alt="please wait ..." id="loader-excel" class="displayN">
                </div>

                <h3 class="box-title m-b-0">سوابق کنسلی خریدها</h3>
                <p class="text-muted m-b-30">کلیه سوابق کنسلی خریدها را در این لیست میتوانید مشاهده کنید</p>

                <div class="table-responsive">
                    <table id="hotelHistory" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>شماره فاکتور<br>نرم افزار</th>
                            <th>نام کاربر<br>نام آژانس</th>
                            <th> تاریخ و ساعت درخواست<br>توضیحات کاربر</th>
                            <th>تاریخ و ساعت تایید درخواست<br>توضیحات مدیریت</th>
                            <th>درصد کنسلی<br>مبلغ کنسلی</th>
                            <th>تاریخ و ساعت کنسلی</th>
                            <th>عملیات</th>
                            <th>وضعیت</th>
                        </tr>
                        </thead>
                        <tbody>

                        {assign var="listBook" value=$objCancelBuy->cancelReportBuy()}
                        {foreach key=key item=item from=$listBook}
                            <tr id="del-{$item.id}">

                                <td>{$item['number_column']}</td>

                                <td>{$item['factor_number']}
                                    <hr style="margin:3px">{$item['type_application_fa']}
                                </td>

                                <td>{$item['member_name']}
                                    <hr style="margin:3px">{$item['client_name']}
                                </td>

                                <td>{$item['request_date']} {$item['request_time']}
                                    <br>
                                    <br>
                                    <div class="button-box">
                                        <button type="button" class="btn btn-default btn-outline"
                                                title="" data-toggle="popover"
                                                data-placement="top" data-content="{$item['comment_user']}"
                                                data-original-title="توضیحات کاربر">مشاهده توضیحات کاربر</button>
                                    </div>
                                </td>

                                <td>{$item['confirm_date']} {$item['confirm_time']}
                                    {if $item['comment_admin'] neq ''}
                                        <br>
                                        <br>
                                        <div class="button-box">
                                            <button type="button" class="btn btn-default btn-outline"
                                                    title="" data-toggle="popover"
                                                    data-placement="top" data-content="{$item['comment_admin']}"
                                                    data-original-title="توضیحات مدیر">مشاهده توضیحات مدیر</button>
                                        </div>
                                    {/if}
                                </td>

                                <td>{if $item['cancel_percent'] neq ''}{$item['cancel_percent']} %{/if}
                                    {if $item['cancel_price'] neq ''}<hr style="margin:3px">{$item['cancel_price']|number_format:0:".":","} ریال{/if}</td>

                                <td>{$item['cancelled_date']} {$item['cancelled_time']}</td>

                                <td>

                                    {* ***
                                    * اگر ادمین اصلی بود و خرید از نرم افزارهای رزرواسیون (اختصاصی) نبود یا اگر ادمین اصلی نبود و خرید از نرم افزارهای رزرواسیون(اختصاصی) بود، اجازه تایید یا رد درخواست را دارد *
                                    *** *}
                                    {assign var="isReservationBuy" value=$objCancelBuy->isReservationBuy($item['type_application'], $item['factor_number'], $item['client_id'])}
                                    {if ($smarty.const.TYPE_ADMIN eq '1' && !$isReservationBuy) || ($smarty.const.TYPE_ADMIN neq '1' && $isReservationBuy)}
                                        <div class="btn-group m-r-10">

                                            <button aria-expanded="false" data-toggle="dropdown"
                                                    class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light"
                                                    type="button"> عملیات <span class="caret"></span>
                                            </button>

                                            <ul role="menu" class="dropdown-menu animated flipInY">
                                                <li>
                                                    <div class="pull-left">

                                                        <div class="pull-left margin-10">
                                                        <span id="ConfirmCancelRequest-{$item.id}"
                                                              title="درخواست کنسلی" data-toggle="popover" data-placement="top"
                                                              class="popoverBox  popover-success"
                                                                {*data-content="با زدن این دکمه ،کادری برای شما باز میشود که می توانید توضیحات خود را نوشته و در خواست کنسلی کاربر را تایید کنید."*}
                                                              data-content="تایید درخواست کنسلی کاربر.">

                                                           <a onclick="modalCancelBuy('Confirm', '{$item['factor_number']}', '{$item['client_id']}','{$item['type_application']}');return false"
                                                              class="fcbtn btn btn-outline btn-success btn-1c mdi mdi-check "
                                                              id="RequestMember-{$item.id}" data-toggle="modal"
                                                              data-target="#ModalPublic"></a>
                                                        </span>
                                                        </div>

                                                        <div class="pull-left margin-10">
                                                        <span id="FailedCancelRequestUser-{$item.id}"
                                                              title="درخواست کنسلی"
                                                              data-toggle="popover" data-placement="top"
                                                              class="popoverBox  popover-danger"
                                                              data-content="در درخواست کنسلی کاربر">

                                                        <a onclick="modalCancelBuy('Reject', '{$item['factor_number']}', '{$item['client_id']}','{$item['type_application']}');return false"
                                                           id="FailedCancel-{$item.id}"
                                                           class="fcbtn btn btn-outline btn-danger btn-1c mdi mdi-close "
                                                           data-toggle="modal" data-target="#ModalPublic"></a>
                                                        </span>
                                                        </div>

                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    {/if}

                                </td>

                                <td>
                                    {if $item.status eq 'request_user'}
                                        <span class="btn btn-warning cursor-default">درخواست کنسلی کاربر</span>
                                    {elseif $item.status eq 'confirm_admin'}
                                        <span class="btn btn-success cursor-default">تایید درخواست کنسلی</span>
                                    {elseif $item.status eq 'reject_cancel_request'}
                                        <span class="btn btn-danger cursor-default">رد درخواست کنسلی کاربر</span>
                                    {elseif $item.status eq 'cancelled'}
                                        <span class="btn btn-danger cursor-default">کنسل شده</span>
                                    {else}
                                        <span class="btn btn-danger cursor-default">نامشخص</span>
                                    {/if}
                                </td>

                            </tr>
                        {/foreach}
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>
</div>

<div class="i-section">
    <div class="i-info">
        <span> ویدیو آموزشی بخش سوابق کنسلی خریدها    </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/370/---.html" target="_blank" class="i-btn"></a>

</div>
<script type="text/javascript" src="assets/JsFiles/cancelReportBuy.js"></script>
{/if}
