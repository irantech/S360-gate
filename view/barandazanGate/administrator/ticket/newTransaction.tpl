{load_presentation_object filename="accountcharge" assign="objAccount"}
{load_presentation_object filename="bookshow" assign="objbook"}
{$objAccount->newTransaction()}

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
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>

        <!-- /.col-lg-12 -->
    </div>

    {if $smarty.const.TYPE_ADMIN eq '2' || $smarty.const.TYPE_ADMIN eq '3'}
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">افزودن اعتبار حساب کاربری</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید اعتبار حساب کاربری خود را افزایش
                    دهید </p>


                <form id="chargeAccountForm" method="post">
                    <input type="hidden" name="flag" value="bankAccountCharge">

                    <div class="form-group col-sm-6">

                        <label for="amount" class="control-label">مبلغ اعتبار</label>
                        <input type="text" class="form-control" id="amount" name="amount"
                               placeholder="مبلغ مورد نظر را به ریال وارد نمایید">
                    </div>


                    <img src="assets/plugins/images/load21.gif" class="LoaderPayment"
                         id="loadingbank">
                    <button type="submit" class="fcbtn btn btn-info btn-outline btn-1b margin-top-23" id="btnbank">
                        پرداخت
                    </button>
                </form>


                <div class="clearfix"></div>

            </div>
        </div>
    </div>
    {/if}


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">جستجوی سوابق تراکنش ها</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید سوابق را در تاریخ های مورد نظرتان  جستجو کنید </p>
                <form  id="SearchTransaction" method="post" action="{$smarty.const.rootAddress}newTransaction{if $smarty.get.id neq ''}&id={$smarty.get.id}{/if}">

                    <div class="form-group col-sm-6 ">
                        <label for="date_of" class="control-label">تاریخ شروع</label>
                        <input type="text" class="form-control datepicker" name="date_of"  value="{$smarty.post.date_of}"  id="date_of" placeholder="تاریخ شروع جستجو را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="to_date" class="control-label">تاریخ پایان</label>
                        <input type="text" class="form-control datepickerReturn" name="to_date"  value="{$smarty.post.to_date}"  id="to_date" placeholder="تاریخ پایان جستجو را وارد نمائید">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="CodeRahgiri" class="control-label">کد رهگیری تراکنش</label>
                        <input type="text" class="form-control"name="CodeRahgiri"  value="{$smarty.post.CodeRahgiri}"  id="CodeRahgiri" placeholder="کد رهگیری را وارد نمائید">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="FactorNumber" class="control-label">شماره فاکتور تراکنش</label>
                        <input type="text" class="form-control" name="FactorNumber"  value="{$smarty.post.FactorNumber}"  id="FactorNumber" placeholder="شماره فاکتور را وارد نمائید">

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
                <h3 class="box-title m-b-0">لیست تراکنش های کاربر</h3>
                <p class="text-muted m-b-30">شما در لیست زیر تراکنش های یک هفته اخیر را مشاهده میکنید،در صورت تمایل به
                    مشاهده بقیه تراکنش ها از کادر جستجوی بالا استفاده کنید

                </p>
                <div class="table-responsive">
                    <table id="newTransaction" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>شماره واچر<br/>فاکتور</th>
                            <th>توضیحات</th>
                            <th>تاریخ تراکنش</th>
                            <th>نوع تراکنش</th>
                            <th>نقدی/اعتباری</th>
                            <th>واریز شده به حساب</th>
                            <th>کسرشده از حساب</th>
                            <th>مانده حساب</th>
                            <th>کد رهگیری تراکنش</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {assign var="remain" value=$objAccount->total_transactionNew}

                        {foreach key=key item=item from=$objAccount->list}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td>{$number}</td>
                            <td>
                                {if $item.Reason eq 'buy'}
                                {if $item.FactorNumber neq ''}
                                <a href="#"
                                   onclick="ModalShowBook('{$objAccount->giveRequestNumber($item.FactorNumber)}');return false"
                                   data-toggle="modal" data-target="#ModalPublic">{$objAccount->giveRequestNumber($item.FactorNumber)}</a>
                                <br/>
                                {$item.FactorNumber}
                                {else}
                                ندارد
                                <br/>
                                {$item.FactorNumber}
                                {/if}
                                {else}
                                ندارد
                                <br/>
                                {$item.FactorNumber}
                                {/if}
                            </td>
                            <td>{$item.Comment}</td>
                            <td>{if $item.PriceDate neq
                                'NULL'}{$objbook->DateJalali($item.PriceDate)}{else}{$objDate->jdate('Y-m-d', $item.CreationDateInt)}{/if}
                            </td>
                            <td>
                                {if $item.Reason eq 'buy'}
                                خرید بلیط
                                {else if $item.Reason eq 'charge'}
                                شارژحساب
                                {else if $item.Reason eq 'price_cancel'}
                                مبلغ کنسلی
                                {else if $item.Reason eq 'indemnity_cancel'}
                                استرداد وجه
                                {else if $item.Reason eq 'increase'}
                                واریز به حساب شما
                                {else if $item.Reason eq 'decrease'}
                                کسر از حساب شما
                                {else if $item.Reason eq 'indemnity_edit_ticket'}
                                جریمه اصلاح بلیط
                                {else if $item.Reason eq 'diff_price'}
                                واریز تغییر قیمت شناسه نرخی
                                {else }
                                ـــــــ
                                {/if}

                            </td>
                            <td><span>{if $item.payment_type eq 'cash'}نقدی{else if $item.payment_type eq 'credit'}اعتباری{else}ـــــــ{/if}</span>
                            </td>
                            <td><span>{if $item.Status=='1'}{$item.Price}{else}0{/if}</span></td>
                            <td><span>{if $item.Status=='2'}{$item.Price}{else}0{/if}</span></td>
                            <td><span>{$remain}</span>
                                {if $item.Status=='1'}
                                {$remain = $remain - $item.Price}
                                {else}
                                {$remain = $remain + $item.Price}
                                {/if}
                            </td>
                            <td>
                                <span>{if $item.BankTrackingCode neq ''}{$item.BankTrackingCode}{else}ـــــــــــــ{/if}</span>
                            </td>
                        </tr>
                        {/foreach}
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="2">جمع کل</th>
                            <th colspan="4"></th>
                            <th colspan="">{$objAccount->total_charge|number_format}</th>
                            <th colspan="">{$objAccount->total_buy|number_format}</th>
                            <th colspan="">{$objAccount->total_transaction|number_format} {if $objAccount->total_transaction > 0}بستانکار{else if $objAccount->total_transaction < 0}بدهی{else}تسویه{/if}</th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>

<script type="text/javascript" src="assets/JsFiles/accountcharge.js"></script>


