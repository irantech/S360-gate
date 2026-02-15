{load_presentation_object filename="invoice" assign="objInvoice"}
{load_presentation_object filename="dateTimeSetting" assign="objDateTimeSetting"}
{assign var="invoice_list" value=$objInvoice->getAllInvoiceData()}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/invoice">گزارش خرید</a></li>
                <li class="active">لیست فاکتورها</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>
    </div>



    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">جستجوی فاکتورها </h3>


                <form id="SearchTicketHistory" method="post"
                      action="{$smarty.const.rootAddress}hotelInvoice">


                    <div class="form-group col-sm-6 ">
                        <label for="date_of" class="control-label">تاریخ شروع</label>
                        <input type="text"
                               class="form-control datepicker" name="date_of" id="date_of"
                               value="{if isset($smarty.post.date_of)}{$smarty.post.date_of}{else}{$objDateTimeSetting->jdate("Y-m-d", strtotime('-7 day'), '', '', 'en')}{/if}"
                               placeholder="تاریخ شروع جستجو را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="to_date" class="control-label">تاریخ پایان</label>
                        <input type="text" class="form-control datepickerReturn" name="to_date" id="to_date"
                               value="{if isset($smarty.post.date_of)}{$smarty.post.to_date}{else}{$objDateTimeSetting->jdate("Y-m-d", time(), '', '', 'en')}{/if}"
                               placeholder="تاریخ پایان جستجو را وارد نمائید">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="RequestNumber" class="control-label">کد هگیری</label>
                        <input type="text" class="form-control " name="tracking_code"
                               value="{$smarty.post.tracking_code}" id="tracking_code"
                               placeholder="کد هگیری را وارد نمائید">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="status" class="control-label">کد هگیری</label>
                        <select name='status' id='status' class='form-control select2'>
                            <option value=''>انتخاب کنید</option>
                            <option value='waiting' {if $smarty.post.status eq 'waiting'}selected{/if}>در حال بررسی</option>
                            <option value='payed' {if $smarty.post.status eq 'payed'}selected{/if}>پرداخت شده</option>
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
                <h3 class="box-title m-b-0">سوابق کنسلی تایید شده </h3>
                <p class="text-muted m-b-30">کلیه سوابق را در این لیست میتوانید مشاهده کنید
                </p>
                <a class="table-responsive">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام هتل</th>
                            <th>نام همکار</th>
                            <th>کد رهگیری</th>
                            <th>واریز از</th>
                            <th>واریز به</th>
                            <th>حساب مبدا</th>
                            <th>حساب مقصد</th>
                            <th>نام صاحب حساب</th>
                            <th>واریز شده در تاریخ</th>
                            <th>عملیات</th>
                            <th>وضعیت درخواست</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$invoice_list}
                            {$number=$number+1}
                            <tr id="">
                                <td>{$number}</td>
                                <td>{$item.hotel_name}</td>
                                <td>{$item.full_name}</td>
                                <td>{$item.tracking_code}</td>
                                <td>{$item.from_company}</td>
                                <td>{$item.to_company}</td>
                                <td>{$item.origin_account}</td>
                                <td>{$item.destination_account}</td>
                                <td>{$item.account_holder}</td>
                                <td>
                                    {$item.payment_date}
                                </td>
                                <td>

                                    {if $item.status eq 'payed'}
                                        <span data-toggle="popover" data-placement="top" data-content="برای دریافت رسید پرداخت کلیک کنید"
                                              class="popoverBox  popover-info" data-original-title="رسید">
                                        <a href="{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}/gds/pdf&target=invoice&id={$item.factor_number}"
                                           class="fcbtn btn btn-outline  btn-info btn-1c fa fa-file-pdf-o cursor-default" target="_blank">
                                        </a>
                                    </span>
                                    {/if}
                                    {if $item.status neq 'payed'}
                                        <span data-toggle="popover" title="پرداخت شد؟" data-placement="top"
                                          data-content="برای ثبت پرداخت کلیک کنید" class="popoverBox  popover-primary">
                                            <a onclick="setPaymentData('{$item.tracking_code}')"
                                               class="fcbtn btn btn-outline btn-success btn-1c cursor-default popoverBox  popover-success mdi mdi-check">

                                            </a>
                                        </span>
                                    {/if}
                                </td>
                                <td>
                                    {if $item.status eq 'waiting'}
                                        <div class="btn btn-primary cursor-default" disabled="disabled"
                                             id="RequestMember">
                                            در حال بررسی
                                        </div>
                                    {elseif $item.status eq 'payed'}
                                        <div id="SetCancelClient" class="btn btn-success cursor-default" disabled="disabled"
                                        >واریز شد
                                        </div>
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


<script type="text/javascript" src="assets/JsFiles/invoice.js"></script>