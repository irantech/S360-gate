{load_presentation_object filename="reportBuyFromIt" assign="objReport"}
{assign var="reports" value=$objReport->ShowBuysError('Active')}
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default ">
            <div class="panel-heading TitleSectionsDashboard" style="cursor: pointer;" data-toggle="collapse" data-target="#ActiveBox">
                <h6 style="font-weight: 500; font-size: 17px; color: #3c3939; margin: 0;">
                     گزارش رزروهای قطعی بدون تراکنش خرید - آژانس‌های فعال - از سال 1404/01/01 نمایش داده می شود. سالهای قبل را فعال نکردیم
                    <div class="pull-right"><i class="ti-minus"></i></div>
                </h6>
            </div>
                <div id="ActiveBox" class="panel-collapse collapse in" style="overflow: auto;">
                    <div class="panel-body clearfix">
                        <table class="table table-bordered text-center">
                            <thead>
                            <tr>
                                <th class="text-center">ردیف</th>
                                <th class="text-center">آژانس</th>
                                <th class="text-center">شماره فاکتور</th>
                                <th class="text-center">تاریخ خرید</th>
                                <th class="text-center">نوع خرید</th>
                                <th class="text-center">آیدی - وضعیت تراکنش Gds<br> قیمت خورده</th>
                                <th class="text-center">آیدی - وضعیت تراکنش مشتری<br> قیمت خورده</th>
                                <th class="text-center" style="width:200px;">توضیحات تراکنش<br/> کسر از حساب</th>
                            </tr>
                            </thead>
                            <tbody>
                                {assign var="activeIndex" value=1}
                                {foreach from=$reports item=row name=reports}
                                        <tr {if $row.transaction_comment} style="background-color:#a1f090 !important;" {/if}>
                                            <td>{$activeIndex}</td>
                                            <td>{$row.agency_name}</td>
                                            <td>
                                                FactorNumber: {$row.factor_number}
                                                <br/>RequestNumber: {$row.request_number}
                                                <br/>PNR: {$row.pnr}
                                            </td>
                                            <td style="direction: ltr;">{$row.creation_date}</td>
                                            <td>{$row.type}</td>
                                            <td>{$row.status_record}</td>
                                            <td>{$row.status_record_client}</td>
                                            <td>{$row.transaction_comment}</td>
                                        </tr>
                                        {assign var="activeIndex" value=$activeIndex+1}
                                {/foreach}
                            </tbody>
                         </table>
                     </div>
                </div>
            </div>
    </div>

    {include file="view/administrator/reports/DuplicateIndemnityCancelReport.tpl"}

    <div class="col-md-12 h5">
        <span style="float:right;margin-right: 20px;">
            <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/reports/reportBuyFromItArchived" target="_blank" >رزروهای قطعی آژانس های آرشیو شده</a>
        </span>
        <span style="float:right;margin-right: 100px;">
            <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/reports/TransactionRecordReport">گزارش رزروهایی که ثبت تراکنش بصورت دستی بوده </a>
        </span>
        <span style="float:right;margin-right: 100px;">
            <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/reports/DuplicateIndemnityCancelReportArchived">گزارش استرداد وجه تکراری آژانس های آرشیو شده </a>
        </span>
    </div>
</div>