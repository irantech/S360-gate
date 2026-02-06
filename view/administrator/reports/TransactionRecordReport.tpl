{load_presentation_object filename="reportBuyFromIt" assign="objReport"}
{assign var="reports" value=$objReport->TransactionRecordReport()}
<br><br><br>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default ">
            <div class="panel-heading TitleSectionsDashboard" style="cursor: pointer;" data-toggle="collapse" data-target="#archivedBox">
                <h6 style="font-weight: 500; font-size: 17px; color: #3c3939; margin: 0;">
                   <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a> -
                    گزارش رزروهایی که ثبت تراکنش بصورت دستی بوده
                    <div class="pull-right"><i class="ti-minus"></i></div>
                </h6>
            </div>
            <div id="archivedBox" class="panel-collapse collapse in" style="overflow: auto;">
                <div class="panel-body clearfix">
                    <table class="table table-bordered text-center">
                        <thead>
                        <tr>
                            <th class="text-center">ردیف</th>
                            <th class="text-center">آژانس</th>
                            <th class="text-center">شماره فاکتور</th>
                            <th class="text-center">تاریخ</th>
                            <th class="text-center">نوع خرید</th>
                            <th class="text-center" >توضیحات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="Index" value=1}
                        {foreach from=$reports item=row name=reports}
                                <tr>
                                    <td>{$Index}</td>
                                    <td>{$row.agency_name}</td>
                                    <td>{$row.factor_number}</td>
                                    <td style="direction: ltr;">{$row.PriceDate}</td>
                                    <td>{$row.type}</td>
                                    <td>{$row.transaction_comment}</td>
                                </tr>
                                {assign var="Index" value=$Index+1}
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>