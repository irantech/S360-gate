{if $smarty.const.TYPE_ADMIN eq 1}
{load_presentation_object filename="accountcharge" assign="objAccount"}
{load_presentation_object filename="bookshow" assign="objbook"}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li> حسابداری</li>
                <li class="active">گزارش شارژ حساب</li>
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
                <h3 class="box-title m-b-0">جستجوی سوابق شارژ حساب کاربری</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید سوابق را در تاریخ های مورد نظرتان  جستجو کنید </p>
                <form  id="SearchTransaction" method="post" action="{$smarty.const.rootAddress}chargeAccountUserList">

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
                        <input type="text" class="form-control" name="CodeRahgiri"  value="{$smarty.post.CodeRahgiri}"  id="CodeRahgiri" placeholder="کد رهگیری را وارد نمائید">

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
                <h3 class="box-title m-b-0">گزارش شارژ حساب</h3>
                <p class="text-muted m-b-30 ">شما میتوانید در لیست زیر کاربرانی که حساب کاربری خود را از طریق درگاه بانکی شارژ نموده اند مشاهده فرمائید،توجه کنید لیست زیر قبل از جستجو فقط تراکنش های  امروز را نمایش میدهد

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

                        {foreach key=key item=item from=$objAccount->listViewForAdmin()}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td>{$number}</td>
                            <td>

                                {$item.FactorNumber}

                            </td>
                            <td>{$item.Comment}</td>
                            <td>{$item.Price|number_format}
                                {$priceTotal = {$item.Price} + $priceTotal}
                            </td>
                            <td>{$objbook->DateJalali($item.PriceDate)}</td>
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
                            <td><span>{if $item.BankTrackingCode neq ''}{$item.BankTrackingCode}{else}ـــــــــــــ{/if}</span></td>
                            {*<td><span>{$objAccount->ClientName($item.FactorNumber)}</span></td>*}
                            <td><span>{$item.AgencyName}</span></td>
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
{/if}
