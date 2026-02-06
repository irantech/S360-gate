{load_presentation_object filename="accountcharge" assign="objAccount"}
{load_presentation_object filename="bookshow" assign="objbook"}
{load_presentation_object filename="infoApi" assign="objapi"}
{$objAccount->listAccountCharge()}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                {if  $smarty.const.TYPE_ADMIN eq '1'}
                    <li><a href="flyAppClient">مشتریان نرم افزار پرواز</a></li>
                    <li class="active">    گزارش تراکنش api</li>
                    {if $smarty.get.id neq ''}
                        <li>{$objFunctions->ClientName($smarty.get.id)}</li>
                    {/if}
                {else}
                    <li class="active">  گزارش تراکنش api  </li>
                {/if}
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>

        <!-- /.col-lg-12 -->
    </div>







    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">لیست تراکنش  api</h3>
                <p class="text-muted m-b-30">شما در لیست زیر تراکنش های یک هفته اخیر را مشاهده میکنید،در صورت تمایل به
                    مشاهده بقیه تراکنش ها از کادر جستجوی بالا استفاده کنید

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
                            <th>نقدی/اعتباری</th>
                            <th>واریز شده به حساب</th>
                            <th>کسرشده از حساب</th>
                            <th>مانده حساب</th>
                            <th>کد رهگیری تراکنش</th>
                        </tr>
                        </thead>
                        <tbody>

                        {assign var="remain" value=$objAccount->total_transaction}
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objapi->listTransaction()}
                            {$number=$number+1}
                            <tr id="del-{$item.id}">
                                <td>{$number}</td>
                                <td>
                                    {if $item.Reason eq 'buy'}
                                        {if $item.FactorNumber neq ''}
                                            {$item.FactorNumber}

                                        {else}
                                            {$item.FactorNumber}
                                        {/if}
                                    {else}
                                        {$item.FactorNumber}
                                    {/if}
                                </td>
                                <td>{$item.Comment}</td>
                                <td>{if $item.PriceDate neq
                                    'NULL'}{$objbook->DateJalali(date('Y-m-d H:i:s',$item.CreationDateInt))}{else}{$objDate->DateJalali(date('Y-m-d H:i:s',$item.CreationDateInt))}{/if}
                                </td>
                                <td>
                                    {if $item.Reason eq 'buy'}
                                        خرید بلیط
                                    {elseif $item.Reason eq 'buy_hotel'}
                                        رزرو هتل
                                    {elseif $item.Reason eq 'buy_reservation_hotel'}
                                        رزرو هتل رزرواسیون
                                    {elseif $item.Reason eq 'buy_reservation_ticket'}
                                        خرید بلیط رزرواسیون
                                    {elseif $item.Reason eq 'buy_insurance'}
                                        رزرو بیمه
                                    {elseif $item.Reason eq 'buy_gasht_transfer'}
                                        رزرو گشت و ترانسفر
                                    {elseif $item.Reason eq 'charge'}
                                        شارژحساب
                                    {elseif $item.Reason eq 'price_cancel'}
                                        مبلغ کنسلی
                                    {elseif $item.Reason eq 'indemnity_cancel'}
                                        استرداد وجه
                                    {elseif $item.Reason eq 'increase'}
                                        واریز به حساب شما
                                    {elseif $item.Reason eq 'decrease'}
                                        کسر از حساب شما
                                    {elseif $item.Reason eq 'indemnity_edit_ticket'}
                                        جریمه اصلاح بلیط
                                    {elseif $item.Reason eq 'diff_price'}
                                        واریز تغییر قیمت شناسه نرخی
                                    {else}
                                        ـــــــ
                                    {/if}

                                </td>
                                <td><span>{if $item.payment_type eq 'cash'}نقدی{elseif $item.payment_type eq 'credit'}اعتباری{else}ـــــــ{/if}</span>
                                </td>
                                <td><span>{if $item.Status=='1'}{$item.Price|number_format}{else}0{/if}</span></td>
                                <td><span>{if $item.Status=='2'}{$item.Price|number_format}{else}0{/if}</span></td>
                                <td>
                                    <span>{$remain|number_format}</span>
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
                            <th colspan="">{$objAccount->total_transaction|number_format} {if $objAccount->total_transaction > 0}بستانکار{elseif $objAccount->total_transaction < 0}بدهی{else}تسویه{/if}</th>
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


