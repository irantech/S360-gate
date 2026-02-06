{if $smarty.const.TYPE_ADMIN eq '1'}
{load_presentation_object filename="accountcharge" assign="objAccountcharge"}


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
                      action="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/transactions">

                    <input type="hidden" name="flag" id="flag" value="createExcelFileForTransactionUser">

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
                    <div class="form-group col-sm-6 ">
                        <label for="color" class="control-label">نمایش تکراری ها </label>
                        <select name="color" id="color" class="form-control">
                            <option value="">انتخاب کنید....</option>
                            <option value="red" {if $smarty.post.color eq 'red'}selected="selected"{/if}>بله</option>
                          
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


<!--                <div class="box-btn-excel">
                    <a onclick="createExcelForTransactionUser()" class="btn btn-primary waves-effect waves-light "
                       type="button" id="btn-excel">
                        <span class="btn-label"><i class="fa fa-download"></i></span>دریافت فایل اکسل</a>
                    <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/load.gif" alt="please wait ..."
                         id="loader-excel" class="displayN">
                </div>-->


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
                {assign var="transactions" value=$objAccountcharge->allTransactions()}
                {if $transactions['calculate']}
                    <div class='row'>
                        {foreach key=key item=item from=$transactions['calculate']}
                            {assign var="divide" value=$item['amount']/2}
                            <div class='col-md-4'>
                                {$key} : {$item['amount']|number_format} / {$divide|number_format}
                            </div>
                        {/foreach}
                    </div>

                {/if}
                <div class="table-responsive">
                    <table id="all_transactions" class="table table-striped">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام مشتری</th>
                            <th>شماره فاکتور</th>
                            <th>توضیحات</th>
                            <th>تاریخ تراکنش</th>
                            <th>نوع تراکنش</th>
                            <th>واریز شده به حساب</th>
                            <th>کسرشده از حساب</th>
                            <th>کد رهگیری تراکنش</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {assign var="charge" value="0"}
                        {assign var="payment" value="0"}

                        {foreach key=key item=item from=$transactions['result']}
                            {$number=$number+1}
                            {$charge=$charge+$item.depositToAccount}
                            {$payment=$payment+$item.accountDeducted}
                            <tr id="del-{$item.id}" >
                                <td style='background : {$item.color}'>{$number}</td>
                                <td>{$item.client_name}</td>
                                <td>
                                    {*{if $item.Reason eq 'buy' && $item.FactorNumber neq ''}
                                        <a href="#" onclick="ModalShowBook('{$item.FactorNumber}');return false"
                                           data-toggle="modal" data-target="#ModalPublic">{$item.FactorNumber}</a>
                                    {else}
                                        {$item.FactorNumber}
                                    {/if}*}
                                    {$item.FactorNumber}
                                </td>
                                <td>{$item.Comment}</td>
                                <td>{$item.transactionDate}</td>
                                <td>{$item.ReasonFa}</td>
                                <td><span>{$item.depositToAccount|number_format:0:".":","}</span></td>
                                <td><span>{$item.accountDeducted|number_format:0:".":","}</span></td>
                                <td><span>{$item.BankTrackingCode}</span></td>
                            </tr>
                        {/foreach}
                        </tbody>
                        <tfoot>

                        <tr>
                            <th colspan="2">جمع کل</th>
                            <th colspan=""></th>
                            <th colspan="1"></th>
                            <th colspan="2">واریز شده:{$charge|number_format:0:".":","}</th>
                            <th colspan="2">کسر شده:{$payment|number_format:0:".":","}</th>
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


{/if}