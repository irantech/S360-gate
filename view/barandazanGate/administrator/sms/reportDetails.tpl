{load_presentation_object filename="smsPanel" assign="objSms"}
{assign var="reportsList" value=$objSms->getReportsBySameID($smarty.get.id)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>پنل پیامکی</li>
                <li><a href="reports&type={$reportsList[0].sendType}">گزارش پیامک های ارسالی به صورت {if $reportsList[0].sendType eq 'manual'}دستی{else}خودکار{/if}</a></li>
                <li class="active"> جزئیات گزارش</li>
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
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام گیرنده</th>
                            <th>شماره گیرنده</th>
                            <th>تاریخ و ساعت ارسال</th>
                            <th>متن پیام</th>
                            <th>وضعیت ارسال</th>
                            <th>پیام وضعیت ارسال</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$reportsList}
                            {$number=$number+1}
                            <tr>
                                <td class="align-middle">{$number}</td>
                                <td class="align-middle">{$item.receiverName}</td>
                                <td class="align-middle">{$item.receiverMobile}</td>
                                <td class="text-left" dir="ltr">{$objDate->jdate('Y-m-d (H:i:s)', $item.creationDateInt)}</td>
                                <td class="align-middle">{$item.smsMessage}</td>
                                <td class="align-middle">{if $item.sendStatus eq '1'}موفق{else}ناموفق{/if}</td>
                                <td class="align-middle">{$item.sendErrorMessage}</td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/smsPanel.js"></script>