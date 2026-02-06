{if $smarty.const.CLIENT_ID eq '44'}

    {$objFunctions->redirectToNewTransactions()}
{*    {include file="`$smarty.const.FRONT_CURRENT_ADMIN`new-transaction-user.tpl"}*}
{else}
    {load_presentation_object filename="accountcharge" assign="objAccount"}
    {load_presentation_object filename="bookshow" assign="objbook"}
    {load_presentation_object filename="transaction" assign="objTransaction"}


    {assign var="check_access_gateWay" value=$objFunctions->checkClientConfigurationAccess('special_gate_way')}

    {if $smarty.get.trans_id neq ''}
        {assign var="verify_bank_transaction" value=$objTransaction->verifyTransactionResponseFromBank()}
    {elseif $smarty.get.token neq '' && $check_access_gateWay eq true}
        {assign var="verify_bank_transaction" value=$objTransaction->verifyTransactionResponseFromBankCharter724($smarty.get.token)}
    {/if}


    {$objAccount->listAccountCharge()}
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

        {if $smarty.const.TYPE_ADMIN eq '2' }
{if $smarty.const.CLIENT_ID eq 166}
            <div class="row">
                <div class="col-sm-12">

                    {if $smarty.get.trans_id neq '' || ($smarty.get.token neq '' && $verify_bank_transaction eq true)}
                        {if $verify_bank_transaction eq true}
                            <div class="col-lg-12  alert alert-success" role="alert">
                                شارژ حساب با موفقیت انجام شد
                            </div>
                        {else}
                            <div class="col-lg-12  alert alert-danger" role="alert">
                                عملیات تراکنش با خطا مواجه شده یا کاربر از پرداخت انصراف داده است.
                            </div>
                        {/if}
                    {/if}


                    <div class="white-box">
                        <h3 class="box-title m-b-0">افزودن اعتبار حساب کاربری</h3>
                        <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید اعتبار حساب کاربری خود را افزایش
                            دهید </p>

                        {if !in_array($smarty.const.CLIENT_ID,$objFunctions->isSuspend())}
                            <form class='' id="chargeAccountForm" method="post">
                                <input type="hidden" name="flag" value="bankAccountCharge">
                                <input type='hidden' name="type_gate_way" id="type_gate_way" value="{$check_access_gateWay}">

                                <div class="form-group col-sm-6">

                                    <label for="amount" class="control-label">مبلغ اعتبار
                                        <small class="text-muted m-b-30">(شما
                                            به میزان دلخواه میتوانید پنل خود را شارژ نمائید،سیستم تا سقف این مبلغ به شما اجازه
                                            خرید میدهد)
                                        </small></label>

                                     <!-- <small class="text-muted m-b-30" style="color:red">
                                        (به جهت اختلال در درگاه اینترنتی لطفا برای شارژ حساب کاربری خود با پشتیبانی تماس حاصل نمایید)
                                    </small>-->
                                    <input type="text" class="form-control" id="transaction_increase_amount" name="amount"
                                           placeholder="مبلغ مورد نظر را به ریال وارد نمایید" <!--disabled-->
                                </div>

                                <img src="assets/plugins/images/load21.gif" class="LoaderPayment"
                                     id="loadingbank">
                                <button type="submit" class="fcbtn btn btn-info btn-outline btn-1b margin-top-23" id="btnbank">
                                    پرداخت
                                </button>
                            </form>
                        {else}

                            <div class='alert alert-error alert-danger rounded '>
                                متاسفانه درگاه با اختلال همراه است. لطفا با پشتیبانی تماس حاصل فرمایید.
                            </div>
                        {/if}

                        <div class="clearfix"></div>

                    </div>
                </div>
            </div>
{/if}
            {*1404 nowroz *}
            <div class='white-box'>
                      <p style='font-weight:bold'>
                          سلام و احترام
                          <br>
                          متاسفانه فعلا ، شرکت های پرداخت یاری اینترنتی توسط بانک مرکزی قطع شده است.
                          <br>
                          لطفا مبالغی که میخواهید شارژ بفرمایید را به شماره شبای زیر واریز و سپس فیش آن را به شماره ای که ذکر شده تلگرام بفرمایید.
                          <br>
                          همکاران بخش مالی، پس از نشستن مبالغ به حساب، به سرعت حساب شما را شارژ خواهند کرد. با تشکر
                          <br>
                          مبالغی که پس از ساعت کاری شرکت، پنجشنبه و ایام تعطیل به حساب شرکت واریز می گرد، در اولین روز کاری به اعتبار اضافه خواهد شد.
                          <br>
                          شماره شبا
                          <br>
                          <code style='display: inline-flex;'>790700010001108551633001</code>
                          <br>
                          بانک رسالت - اباذر افشار
                          <br>
                          شماره تلگرام:
                          <br>
                          <code>09057078341</code>
                      </p>
                    </div>
            {*<div class='white-box'>
                <p style='color:red; font-weight:bold'>به دلیل اختلال پیش آمده برای درگاه های اینترنتی ،لطفا برای شارژ پنل مبلغ مورد نظر را به شماره کارت زیر واریز بفرمائید.
                   <code style='display: inline-flex;'> 5022-2910-0660-9513</code>
                    سپس فیش واریزی را  به شماره <code>09057078341</code> اطلاع  بدهید.
                    سپاس از همکاری شما
                </p>
            </div>*}
        {/if}
        {if $smarty.const.CLIENT_ID eq 166 and 2==1}
            <div class="row">
                <div class="col-sm-12">
                    <form class='' id="chargeAccountForm2" method="post">
                        <input type="hidden" value="{$smarty.const.CLIENT_ID}" id="clientID" name="clientID">
                        <div class="form-group col-sm-6">
                            <label for="amount" class="control-label">مبلغ اعتبار
                                <small class="text-muted m-b-30">(شما
                                    به میزان دلخواه میتوانید پنل خود را شارژ نمائید،سیستم تا سقف این مبلغ به شما اجازه
                                    خرید میدهد)
                                </small></label>
                            <input type="text" class="form-control" id="amount" name="amount"
                                   placeholder="مبلغ مورد نظر را به ریال وارد نمایید" <!--disabled-->
                        </div>

                        <img src="assets/plugins/images/load21.gif" class="LoaderPayment" id="loadingbank">
                        <button type="submit" class="fcbtn btn btn-info btn-outline btn-1b margin-top-23" id="btnPayment" >
                            پرداخت
                        </button>
                    </form>
                </div>
            </div>
        {/if}

     </div>




        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">

                    <h3 class="box-title m-b-0">جستجوی سوابق تراکنش ها</h3>
                    <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید سوابق را در تاریخ های مورد نظرتان جستجو
                        کنید </p>
                    <form id="SearchTransaction" method="post"
                          action="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/transactionUser{if $smarty.get.id neq ''}&id={$smarty.get.id}{/if}">

                        <input type="hidden" name="flag" id="flag" value="createExcelFileForTransactionUser">

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
                        <div class="form-group col-sm-6 ">
                            <label for="Repeated" class="control-label">نمایش تراکنش های تکراری </label>
                            <select name="Repeated" id="Repeated" class="form-control">
                                <option value="">انتخاب کنید....</option>
                                <option value="yes" {if $smarty.post.Repeated eq 'yes'}selected="selected"{/if}>بله</option>
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
                        <a onclick="createExcelForTransactionUser()" class="btn btn-primary waves-effect waves-light "
                           type="button" id="btn-excel">
                            <span class="btn-label"><i class="fa fa-download"></i></span>دریافت فایل اکسل</a>
                        <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/load.gif" alt="please wait ..."
                             id="loader-excel" class="displayN">
                    </div>
                    {if $smarty.const.CLIENT_ID eq '44'}
                        <div>
                            <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/new-transaction-user&id=44" target="_blank" class="btn btn-warning waves-effect waves-light" style="float:left" >
                                <span class="btn-label"><i class="fa fa-list"></i></span>اکسل بدهکاری ها
                            </a>
                        </div>
                    {/if}

                    <h3 class="box-title m-b-0">لیست تراکنش های کاربر</h3>
                    {if $objAccount->total_repeated_price > 0}
                        <input type='hidden' id='start_repeated_date' name='start_repeated_date' value='{$objAccount->start_transaction_date}'>
                        <input type='hidden' id='end_repeated_date' name='end_repeated_date' value='{$objAccount->end_transaction_date}'>

                        <h4>بر اساس حسابرسی سالانه و مغایرت گیری انجام شده ایران تکنولوژی {$objAccount->total_repeated_price|number_format} ریال بیشتر به آن مجموعه محترم پرداخت کرده است.
                            <a onclick='filterRepeated()'>از اینجا ببینید</a>
                        </h4>
                        {if $smarty.post.Repeated eq 'yes'}
                            <h5>
                                لطفا نگران نباشید، هیچ اتفاقی برای حساب های شما نیوفتاده است. برای شفاف شدن موضوع با ایران تکنولوژی تماس بگیرید. اینجا رکوردهایی است که مبالغ کنسلی دوبار به شما پرداخت شده است.
                            </h5>
                        {/if}
                    {/if}
                    <p class="text-muted m-b-30">شما در لیست زیر تراکنش های یک هفته اخیر را مشاهده میکنید،در صورت تمایل به
                        مشاهده بقیه تراکنش ها از کادر جستجوی بالا استفاده کنید
                        {if $smarty.const.TYPE_ADMIN eq '1'}
                            <span class="pull-right">
                         <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/transactionUserAdd{if $smarty.get.id neq ''}&id={$smarty.get.id}{/if}"
                            class="btn btn-info waves-effect waves-light " type="button">
                    <span class="btn-label"><i class="mdi mdi-trending-up"></i></span>افزودن تراکنش جدید
                </a>
                </span>
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
                                <tr id="del-{$item.id}">
                                    <td style='background:{$item['color']}'>{$number}</td>
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
                            <tr>
                                {if $objAccount->is_search eq true}
                            <tr>
                                <th colspan="2">جمع براساس جستجو</th>
                                <th colspan="3"></th>
                                <th colspan="">{$objAccount->total_charge_search|number_format}</th>
                                <th colspan="">{$objAccount->total_buy_search|number_format}</th>
                                <th colspan="">{$objAccount->total_transaction_search|number_format} </th>
                                <th colspan="2"></th>
                            </tr>
                            {/if}
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



{/if}