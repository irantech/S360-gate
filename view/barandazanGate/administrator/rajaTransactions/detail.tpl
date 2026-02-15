{load_presentation_object filename="rajaTransactions" assign="objTransactions"}

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

                <h3 class="box-title m-b-0">لیست تراکنش های کاربر</h3>
                <p class="text-muted m-b-30">شما در لیست زیر تراکنش های یک هفته اخیر را مشاهده میکنید،در صورت تمایل به
                    مشاهده بقیه تراکنش ها از کادر جستجوی بالا استفاده کنید
                </p>
                <div class="table-responsive">
                    <table id="newTransaction" class="table table-striped">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>کد آژانس</th>
                            <th>نام آژانس</th>
                            <th>  مبلغ قابل واریز بعد از...</th>
                            <th>نام شهر</th>
                            <th>نام نمایندگی</th>
                            <th>شناسه پرداخت</th>
                            <th>دریافتی از مسافر</th>
                            <th>برگشتی به مسافر</th>
                            <th> خالص خدمات ایستگاهی</th>
                            <th>درآمد ناخالص</th>
                            <th>سهم آژانس</th>
                            <th>مالیات بر ارزش افزوده</th>
                            <th>سپرده بیمه</th>
                            <th>بستانکاری و بدهکاری قبلی</th>
                            <th>جریمه</th>
                            <th>واریزی</th>
                            <th>مغایرت</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="rowNum" value=0}
                        {assign var="transactionsDtail" value=$objTransactions->getDetail($smarty.get.tracking_code)}
                        {foreach $transactionsDtail as $transactionDtail}
                            {$rowNum=$rowNum+1}
                            <tr {if $transactionDtail.is_valid_agency eq true}{else}class="text-white" style="background: #ff7676 !important" {/if}>
                                <td>{$rowNum}</td>
                                <td>{$transactionDtail.agency_code}</td>
                                <td>{$transactionDtail.agency_name}</td>
                                <td>
                                    {$transactionDtail.depositable_amount|number_format:0:'.':','} ریال
                                </td>
                                <td>{$transactionDtail.city_name}</td>
                                <td>{$transactionDtail.representation_name}</td>
                                <td>{$transactionDtail.payment_id}</td>
                                <td>
                                    {$transactionDtail.received_passenger|number_format:0:'.':','} ریال
                                </td>
                                <td>
                                    {$transactionDtail.return_traveler|number_format:0:'.':','} ریال
                                </td>
                                <td>
                                    {$transactionDtail.station_services|number_format:0:'.':','} ریال
                                </td>
                                <td>
                                    {$transactionDtail.gross_income|number_format:0:'.':','} ریال
                                </td>
                                <td>
                                    {$transactionDtail.agency_share|number_format:0:'.':','} ریال
                                </td>
                                <td>
                                    {$transactionDtail.tax|number_format:0:'.':','} ریال
                                </td>
                                <td>
                                    {$transactionDtail.insurance_deposit|number_format:0:'.':','} ریال
                                </td>
                                <td>
                                    {$transactionDtail.previous_credit_debit|number_format:0:'.':','} ریال
                                </td>
                                <td>
                                    {$transactionDtail.fine|number_format:0:'.':','} ریال
                                </td>
                                <td>
                                    {$transactionDtail.deposit|number_format:0:'.':','} ریال
                                </td>
                                <td>
                                    {$transactionDtail.contradiction|number_format:0:'.':','} ریال
                                </td>
                            </tr>
                        {/foreach}
                        </tbody>
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

<style>
    .table > thead > tr > th {
        white-space: nowrap;
        padding: 15px 15px;
    }
</style>

<script type="text/javascript" src="assets/JsFiles/rajaTransactions.js"></script>