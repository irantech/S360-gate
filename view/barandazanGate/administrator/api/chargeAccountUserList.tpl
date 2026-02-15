{load_presentation_object filename="accountcharge" assign="objAccount"}
{load_presentation_object filename="bookshow" assign="objbook"}
{load_presentation_object filename="infoApi" assign="objapi"}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li> حسابداری</li>
                <li class="active">گزارش شارژ حساب api  </li>
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
                <h3 class="box-title m-b-0">گزارش شارژ حساب api  </h3>
                <p class="text-muted m-b-30 ">شما میتوانید در لیست زیر کاربرانی که حساب کاربری خود را از طریق درگاه بانکی شارژ نموده اند مشاهده فرمائید،توجه کنید لیست زیر قبل از جستجو فقط تراکنش های یک هفته اخیر را نمایش میدهد

                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>فاکتور</th>
                            <th>توضیحات</th>
                            <th>مبلغ</th>
                            <th>تاریخ تراکنش</th>
                            <th>نوع تراکنش</th>
                            <th>کد رهگیری تراکنش</th>
                            <th>نام آژانس</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}

                        {assign var="remain" value=$objAccount->total_transaction}
                        {foreach key=key item=item from=$objapi->listCharge()}
                            {$number=$number+1}
                            <tr id="del-{$item.id}">
                                <td>{$number}</td>
                                <td>

                                    {$item.FactorNumber}

                                </td>
                                <td>{$item.Comment}</td>
                                <td>
                                    {$item.Price|number_format}
                                    {$priceTotal = {$item.Price} + $priceTotal}
                                </td>
                                <td>{$objbook->DateJalali(date('Y-m-d H:i:s',$item.CreationDateInt))}</td>
                                <td>
                                    {if $item.Reason eq 'buy'}
                                        خرید بلیط
                                    {elseif $item.Reason eq 'charge'}
                                        شارژحساب
                                    {elseif $item.Reason eq  'price_cancel'}
                                        مبلغ کنسلی
                                    {elseif $item.Reason eq 'indemnity_cancel'}
                                        جریمه کنسلی
                                    {elseif $item.Reason eq  'increase'}
                                        واریز به حساب شما
                                    {elseif $item.Reason eq  'decrease'}
                                        کسر از حساب شما
                                    {else }
                                        ـــــــ
                                    {/if}

                                </td>
                                <td>
                                    <span>{if $item.BankTrackingCode neq ''}{$item.BankTrackingCode}{else}ـــــــــــــ{/if}</span>
                                </td>
                                {*<td><span>{$objAccount->ClientName($item.FactorNumber)}</span></td>*}
                                <td>
                                    <span>{$item.AgencyName}</span>
                                </td>
                            </tr>

                        {/foreach}

                        </tbody>

                        <tfoot>
                        <tr>
                            <td colspan="3"></td>
                            <th colspan="">جمع کل:({$priceTotal|number_format})ريال</th>
                            <td colspan="4"></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
