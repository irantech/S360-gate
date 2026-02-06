{load_presentation_object filename="accountcharge" assign="objAccount"}
{load_presentation_object filename="bookshow" assign="objbook"}
{load_presentation_object filename="transaction" assign="objTransaction"}


{$objAccount->listTransactions()}
<div class="container-fluid">
    <div class="row bg-title">


        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                {if  $smarty.const.TYPE_ADMIN eq '1'}
                    <li><a href="flyAppClient">مشتریان نرم افزار پرواز</a></li>
                    <li class="active"> لیست تراکنش های کاربر</li>
                    {if $smarty.get.id neq ''}
                        <li>{$objFunctions->ClientName($smarty.get.id)}</li>
                    {/if}
                {else}
                    <li class="active"> لیست تراکنش های کاربر</li>
                {/if}
            </ol>
        </div>
    </div>
    


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <h3 class="box-title m-b-0">جستجوی سوابق تراکنش ها</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید سوابق را در تاریخ های مورد نظرتان جستجو
                    کنید </p>
                <form id="SearchTransaction" method="post"
                      action="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/new-transaction-user{if $smarty.get.id neq ''}&id={$smarty.get.id}{/if}">

                    <input type="hidden" name="flag" id="flag" value="newCreateExcelFileForTransactionUser">
                    <input type="hidden" name="client_id" id="client_id" value="{$smarty.get.id}">

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
                        <label for="CodeRahgiri" class="control-label">کد رهگیری تراکنش</label>
                        <input type="text" class="form-control" name="CodeRahgiri" value="{$smarty.post.CodeRahgiri}"
                               id="CodeRahgiri" placeholder="کد رهگیری را وارد نمائید">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="FactorNumber" class="control-label">شماره فاکتور تراکنش</label>
                        <input type="text" class="form-control" name="FactorNumber" value="{$smarty.post.FactorNumber}"
                               id="FactorNumber" placeholder="شماره فاکتور را وارد نمائید">

                    </div>

                    <div class="form-group col-sm-6 ">
                        <label for="Reason" class="control-label">دلیل تراکنش </label>
                        <select name="Reason" id="Reason" class="form-control">
                            <option value="">انتخاب کنید....</option>
                            <option value="buy" {if $smarty.post.Reason eq 'buy'}selected="selected"{/if}>خرید</option>
                            <option value="charge" {if $smarty.post.Reason eq 'charge'}selected="selected"{/if}>شارژ
                                حساب
                            </option>
                            <option value="decrease" {if $smarty.post.Reason eq 'decrease'}selected="selected"{/if}>کسر
                                از حساب
                            </option>
                            <option value="increase" {if $smarty.post.Reason eq 'increase'}selected="selected"{/if}>
                                واریز به حساب
                            </option>
                            <option value="indemnity_cancel"
                                    {if $smarty.post.Reason eq 'indemnity_cancel'}selected="selected"{/if}>واریز کنسلی
                            </option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group pull-right">
                                <button type="submit" class="btn btn-primary">شروع جستجو</button>
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
                    <a onclick="newCreateExcelFileForTransactionUser()" class="btn btn-primary waves-effect waves-light "
                       type="button" id="btn-excel">
                        <span class="btn-label"><i class="fa fa-download"></i></span>دریافت فایل اکسل</a>
                    <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/load.gif" alt="please wait ..."
                         id="loader-excel" class="displayN">
                </div>


                <h3 class="box-title m-b-0">لیست تراکنش های کاربر</h3>
                <p class="text-muted m-b-30">شما در لیست زیر تراکنش های یک هفته اخیر را مشاهده میکنید،در صورت تمایل به
                    مشاهده بقیه تراکنش ها از کادر جستجوی بالا استفاده کنید
                    {if $smarty.const.TYPE_ADMIN eq '1'}
<!--                        <span class="pull-right">
                         <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/transactionUserAdd{if $smarty.get.id neq ''}&id={$smarty.get.id}{/if}"
                            class="btn btn-info waves-effect waves-light " type="button">
                    <span class="btn-label"><i class="mdi mdi-trending-up"></i></span>افزودن تراکنش جدید
                </a>
                </span>-->
                    {/if}
                </p>
                <div class="table-responsive">
                    <table id="newTransaction" class="table table-striped">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>شماره فاکتور</th>
                            <th>توضیحات</th>
                            <th>تاریخ تراکنش</th>
                            <th>نوع تراکنش</th>
{*                            <th>نقدی/اعتباری</th>*}
                            <th>واریز شده به حساب</th>
                            <th>کسرشده از حساب</th>
                            <th>مانده حساب</th>
                            <th>کد رهگیری تراکنش</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}

                        {foreach key=key item=item from=$objAccount->list}
                            {$number=$number+1}
                            <tr id="del-{$item.id}" {if $item.isPending eq true}style="background-color:#da0606 !important;color:#ffffff !important"{/if}>
                                <td>{$number}</td>
                                <td>
                                    {if $item.Reason eq 'buy' && $item.FactorNumber neq ''}
                                        <a href="#" onclick="ModalShowBook('{$item.FactorNumber}');return false"
                                           data-toggle="modal" data-target="#ModalPublic">{$item.FactorNumber}</a>
                                    {else}
                                        {$item.FactorNumber}
                                    {/if}


                                </td>
                                <td>{$item.Comment}</td>
                                <td>{$item.transactionDate}</td>
                                <td>{$item.ReasonFa}</td>
{*                                <td><span>{$item.payment_type_fa}</span></td>*}
                                <td><span>{$item.depositToAccount|number_format:0:".":","}</span></td>
                                <td><span>{$item.accountDeducted|number_format:0:".":","}</span></td>
                                <td><span>{$item.remain|number_format}</span></td>
                                <td><span>{$item.BankTrackingCode}</span>
                                </td>
                                <td>
                                    {if $item.Status eq '1' && $item.Reason eq 'charge'}
                                        <span>
                                        <a href="{$smarty.const.SERVER_HTTP}{$item.domain_agency}/gds/pdf&target=contentPdf&id={$item.FactorNumber}&cash=transactionReceipt">
                                            <i class='fcbtn btn btn-outline btn-primary fa fa-download'
                                               data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="برای دریافت رسید تراکنش کلیک نمایید"></i> </a>
                                    </span>
                                    {/if}
                                </td>
                            </tr>
                        {/foreach}
                        </tbody>
                        <tfoot>
                        {if $objAccount->is_search eq true}
                            <tr>
                                <th colspan="4"></th>
                                <th colspan="">انتقال از قبل</th>
                                {if $objAccount->remain_prev gt 0}
                                <th colspan="4">{$objAccount->remain_prev|number_format}</th>
                                {else}
                                    <th colspan=""></th>
                                    <th colspan="4">{$objAccount->remain_prev|number_format}</th>
                                {/if}


                            </tr>
                        <tr>
                            <th colspan="2">جمع براساس جستجو</th>
                            <th colspan="3"></th>
                            <th colspan="">{$objAccount->total_charge_search|number_format}</th>
                            <th colspan="">{$objAccount->total_buy_search|number_format}</th>
                            <th colspan="">{$objAccount->total_transaction_search|number_format} </th>
                            <th colspan="2"></th>
                        </tr>
                        {/if}
                        <tr>
                            <th colspan="2">جمع کل</th>
                            <th colspan="3"></th>
                            <th colspan="">{$objAccount->total_charge|number_format}</th>
                            <th colspan="">{$objAccount->total_buy|number_format}</th>
                            <th colspan="">{$objAccount->total_transaction|number_format} {if $objAccount->total_transaction > 0}بستانکار{elseif $objAccount->total_transaction < 0}بدهی{else}تسویه{/if}</th>
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
        <span> ویدیو آموزشی بخش گزارش تراکنش ها   </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/367/--.html" target="_blank" class="i-btn"></a>

</div>

<script type="text/javascript" src="assets/JsFiles/accountcharge.js"></script>


