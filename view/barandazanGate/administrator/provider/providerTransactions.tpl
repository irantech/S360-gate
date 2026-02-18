{if $smarty.const.TYPE_ADMIN eq '1'}
    {load_presentation_object filename="transactions" assign="objTransaction"}




    <div class="container-fluid">
        <div class="row bg-title">


            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <ol class="breadcrumb FloatRight">
                    <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                    {if  $smarty.const.TYPE_ADMIN eq '1'}
                        <li><a href="providerTransactionList">حسابداری تامین کنندگان</a></li>
                        <li class="active"> لیست تراکنش های تامین کننده</li>
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
                          action="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/provider/providerTransactions?api_id={$smarty.get.api_id}&sourceType={$smarty.get.sourceType}">

                        <input type="hidden" name="flag" id="flag" value="newCreateExcelFileForTransactionUser">

                        <div class="form-group col-sm-6">
                            <label for="date_of" class="control-    label">تاریخ شروع</label>
                            <input type="text" class="form-control datepicker" name="date_of"
                                   value="{if $smarty.post.date_of}{$smarty.post.date_of}{else}{$objFunctions->daysAgo(7)}{/if}"
                                   id="date_of" placeholder="تاریخ شروع جستجو را وارد نمائید">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="to_date" class="control-label">تاریخ پایان</label>
                            <input type="text" class="form-control datepickerReturn" name="to_date"
                                   value="{if $smarty.post.to_date}{$smarty.post.to_date}{else}{$objFunctions->timeNow()}{/if}"
                                   id="to_date" placeholder="تاریخ پایان جستجو را وارد نمائید">
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

                        <div class="form-group col-sm-6">
                            <label for="Reason" class="control-label">دلیل تراکنش</label>
                            <select name="Reason" id="Reason" class="form-control">
                                <option value="">انتخاب کنید....</option>
                                <option value="buy" {if $smarty.post.Reason eq 'buy' }selected="selected"{/if}>خرید</option>
                                <option value="charge" {if $smarty.post.Reason eq 'charge'}selected="selected"{/if}>شارژ حساب</option>
                                <option value="decrease" {if $smarty.post.Reason eq 'decrease'}selected="selected"{/if}>کسر از حساب</option>
                                <option value="increase" {if $smarty.post.Reason eq 'increase'}selected="selected"{/if}>واریز به حساب</option>
                                <option value="indemnity_cancel" {if $smarty.post.Reason eq 'indemnity_cancel'}selected="selected"{/if}> کنسلی</option>
                                <option value="all" {if $smarty.post.Reason eq 'all' or empty($smarty.post.Reason)}selected="selected"{/if}>همه</option>
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
                    {if $smarty.const.TYPE_ADMIN eq '1'}
                        <span class="pull-right">
                         <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/provider/transactionProviderAdd?{'api_id='}{$smarty.get.api_id}&{'sourceType='}{$smarty.get.sourceType}"
                            class="btn btn-info waves-effect waves-light " type="button">
                                <span class="btn-label"><i class="mdi mdi-trending-up"></i></span>افزودن تراکنش جدید
                        </a>
                            </span>
                    {/if}


                    <!--                <div class="box-btn-excel">
                    <a onclick="createExcelForTransactionUser()" class="btn btn-primary waves-effect waves-light "
                       type="button" id="btn-excel">
                        <span class="btn-label"><i class="fa fa-download"></i></span>دریافت فایل اکسل</a>
                    <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/load.gif" alt="please wait ..."
                         id="loader-excel" class="displayN">
                </div>-->


                    <h3 class="box-title m-b-0">لیست تراکنش های مختص به پروایدر</h3>
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
                    {assign var="transactions" value=$objTransaction->getAllProviderTransactions()}
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
                                <th>شماره رزرو</th>
                                {*                                <th>نوع خدمات</th>*}
                                <th>نقدی/اعتباری</th>
                                <th>اشتراکی/اختصاصی</th>
                                <th>نوع تراکنش</th>
                                <th>pnr</th>
                                <th>توضیحات</th>
                                <th>تاریخ تراکنش</th>
                                {*                                <th>مبلغ خرید از ما</th>*}
                                {*                                <th>مبلغ فروش به مسافر</th>*}
                                <th>واریز به حساب</th>
                                <th>کسر از حساب</th>
                                {*                                <th>مانده حساب</th>*}
                                <th>نام منبع</th>

                            </tr>
                            </thead>
                            <tbody>
                            {assign var="number" value="0"}
                            {assign var="charge" value="0"}
                            {assign var="payment" value="0"}

                            {foreach key=key item=item from=$transactions}
                                {$number=$number+1}
                                {$charge=$charge+$item.depositToAccount}
                                {$payment=$payment+$item.accountDeducted}
                                <tr id="del-{$item.id}" >
                                    <td style='background : {$item.color}'>{$number}</td>
                                    <td>{$item.client_name}</td>
                                    <td>
                                        {$item.factor_number}
                                    </td>
                                    {*                                    <td>{$item.service}</td>*}
                                    <td>{$item.cacheOrCredit}</td>
                                    <td>{$item.publicOrPrivate}</td>
                                    <td>
                                        {if $item.Reason == 'buy'}
                                            <span style="color: #28a745; font-weight: bold;">{$item.type}</span>
                                        {elseif $item.Reason == "indemnity_cancel" }
                                            <span style="color: red; font-weight: bold;">{$item.type}</span>
                                        {else}
                                            {$item.type}
                                        {/if}
                                    </td>
                                    <td>{$item.pnr}</td>
                                    <td>{$item.comment}</td>
                                    <td>{$item.date}</td>
                                    {*                                    <td>{$item.price|number_format}</td>*}
                                    {*                                    <td>{$item.customer_price|number_format}</td>*}
                                    <td style="color: red;">
                                        {if $item.depositToAccount == 0}
                                            {" "}
                                        {else}
                                        {$item.depositToAccount|number_format}
                                        {/if}
                                    </td>
                                    <td style="color: green;">
                                        {if $item.accountDeducted == 0}
                                            {" "}
                                        {else}
                                            {$item.accountDeducted|number_format}
                                        {/if}

                                    </td>
                                    {*                                    <td>{$item.remain|number_format:0:".":","}</td>*}
                                    <td>{$item.source}</td>

                                </tr>
                            {/foreach}
                            <!--                            <tfoot>
                            {if $objTransaction->is_search eq true}
                                <tr>
                                    <th colspan="8"></th>
                                    <th colspan="2">انتقال از قبل</th>
                                    {if $objTransaction->remain_prev gt 0}
                                        <th colspan="4">{$objTransaction->remain_prev|number_format}</th>
                                    {else}
                                        <th colspan=""></th>
                                        <th colspan="5">{$objTransaction->remain_prev|number_format}</th>
                                    {/if}


                                </tr>
                                <tr>
                                    <th colspan="3">جمع براساس جستجو</th>
                                    <th colspan="7"></th>
                                    <th colspan="">{$objTransaction->total_charge_search|number_format}</th>
                                    <th colspan="">{$objTransaction->total_buy_search|number_format}</th>
                                    <th colspan="">{$objTransaction->total_transaction_search|number_format} </th>
                                    <th colspan="1"></th>
                                </tr>
                            {/if}
                            <tr>
                                <th colspan="2">جمع کل</th>
                                <th colspan="8"></th>
                                <th colspan="">{$objTransaction->total_charge|number_format}</th>
                                <th colspan="">{$objTransaction->total_buy|number_format}</th>
                                <th colspan="">{$objTransaction->total_transaction|number_format} {if $objTransaction->total_transaction > 0}بستانکار{elseif $objTransaction->total_transaction < 0}بدهی{else}تسویه{/if}</th>
                                <th colspan="1"></th>
                            </tr>
                            </tfoot>
                            </tbody>

                        </table>-->
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

    <script type="text/javascript" src="assets/JsFiles/providercharge.js"></script>


{/if}