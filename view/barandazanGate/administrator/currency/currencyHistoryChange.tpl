{load_presentation_object filename="currencyHistoryChange" assign="ObjCurrencyHistoryChange"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>تنظیمات</li>
                <li>تنظیمات نرخ ارز</li>
                <li class="active">سوابق تغییر ارز</li>
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
                <h3 class="box-title m-b-0">لیست سوابق تغییر ارز
                </h3>
                <p class="text-muted m-b-30">
                            شما در لیست زیر میتوانید سوابق تغییر ارز را مشاهده نمائید
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان ارز</th>
                            <th>معادل</th>
                            <th>نوع تغییر</th>
                            <th>تاریخ تغییر</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$ObjCurrencyHistoryChange->ListHistoryCurrencyChange($smarty.get.id)}
                            {$number=$number+1}
                            <tr id="del-{$item.id}">
                                <td>{$number}</td>
                                <td>{$item.CurrencyTitle}</td>
                                <td>{$item.EqAmount}ریال</td>
                                <td>{if $item.Action eq 'add'}افزودن ارز جدید{elseif $item.Action eq 'active'}فعال کردن{elseif $item.Action eq 'inactive'}غیر فعال کردن{elseif $item.Action eq 'changePrice'}تغییر قیمت{/if}</td>
                                <td dir="ltr" class="text-left">{$objDate->jdate('Y-m-d (H:i:s)', $item.CreationDateInt)}</td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
