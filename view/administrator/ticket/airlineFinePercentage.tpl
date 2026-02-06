{load_presentation_object filename="airline" assign="objVisa"}
{assign var="fineList" value=$objVisa->airlineFineList()}
{load_presentation_object filename="country" assign="objCountry"}
<style>
    .numeric-input {
        max-width: 150px;
        margin: 0 auto;
        text-align: center;
    }

    .ajax-status {
        font-size: 12px;
        min-height: 20px;
    }
    /* کلاس‌های نرخی */
    .fare-classes-box {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;  /* متن وسط چین */
        gap: 5px;
    }

    .class-box {
        background-color: #17a2b8; /* رنگ آبی ملایم */
        color: #fff;
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 13px;
        text-align: center; /* متن داخل باکس هم وسط چین */
    }

    /* درصد جریمه */
    .fine-percentages-box {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .fine-box {
        background-color: #f8f9fa; /* خاکستری روشن */
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 8px 12px;
        font-size: 13px;
        color: #333;
    }


</style>

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="active">مدیریت نرخ ایرلاین ها</li>
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
                <h3 class="box-title m-b-0">لیست ایرلاین ها </h3>
                <p class="text-muted m-b-30  ">در لیست زیر نرخ ها را میتوانید مشاهده و ویرایش نمایید.
                    <span class="pull-right">
                         <a href="addAirlineFinePercentage" class="btn btn-info waves-effect waves-light " type="button">
                            <span class="btn-label"><i class="fa fa-plus"></i></span>افزودن نرخ جریمه
                        </a>
                    </span>
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>ایرلاین</th>
                            <th>وضعیت</th>
                            <th>کلاس نرخی</th>
                            <th>درصد جریمه</th>
                            <th>ویرایش</th>
                            <th>حذف</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value=0}
                        {foreach $fineList as $item}
                            {assign var="number" value=$number+1}
                            <tr>
                                <td>{$number}</td>
                                <td>
                                    {$item.airline_name} ({$item.airline_uniqe_iata})
                                </td>
                                <td>
                                    {if $item.package_status eq 'active'}
                                        <span class="badge badge-success">فعال</span>
                                    {else}
                                        <span class="badge badge-danger">غیرفعال</span>
                                    {/if}
                                </td>
                                <td>
                                    <div class="fare-classes-box">
                                        {foreach $item.fare_classes as $fc}
                                            <span class="badge badge-info class-box">{$fc.class_name}</span>
                                        {/foreach}
                                    </div>
                                </td>
                                <td>
                                    <div class="fine-percentages-box">
                                        {foreach $item.fine_percentages as $fp}
                                            <div class="fine-box">
                                                {* تعریف و نرمال سازی متغیرها *}
                                                {assign var="FD" value=$fp.from_day|default:0}
                                                {assign var="FH" value=$fp.from_hour|default:0}
                                                {assign var="UD" value=$fp.until_day|default:0}
                                                {assign var="UH" value=$fp.until_hour|default:0}

                                                {* حالت 1: همه مقادیر غیرصفر *}
                                                {if $FD && $FH && $UD && $UH}
                                                    از ساعت {$FH} ، {$FD} روز قبل از پرواز تا ساعت {$UH} ، {$UD} روز قبل از پرواز
                                                    = {$fp.fine_percentage}% جریمه
                                                    {* حالت 2: فقط until_day صفر یا null *}
                                                {elseif $FD && $FH && !$UD && $UH}
                                                   از ساعت {$FH} ، {$FD} روز قبل باز پرواز تا {$UH} ساعت قبل از پرواز
                                                    = {$fp.fine_percentage}% جریمه
                                                    {* حالت 3: from_day و until_day صفر یا null *}
                                                {elseif !$FD && $FH && !$UD && $UH}
                                                    از {$FH} ساعت مانده به پرواز تا {$UH} ساعت مانده به پرواز
                                                    = {$fp.fine_percentage}% جریمه
                                                    {* حالت 4: from_day و from_hour صفر یا null *}
                                                {elseif !$FD && !$FH && $UD && $UH}
                                                    تا ساعت {$UH} ، {$UD} روز قبل از پرواز
                                                    = {$fp.fine_percentage}% جریمه
                                                    {* حالت 5: فقط until_hour غیرصفر *}
                                                {elseif !$FD && !$FH && !$UD && $UH}
                                                 تا {$UH} ساعت مانده به پرواز
                                                    = {$fp.fine_percentage}% جریمه
                                                    {* حالت 7: فقط from_day و from_hour غیرصفر *}
                                                {elseif $FD && $FH && !$UD && !$UH}
                                                     از ساعت {$FH} ، {$FD} روز مانده به پرواز
                                                    = {$fp.fine_percentage}% جریمه
                                                    {* حالت 8: فقط from_hour غیرصفر *}
                                                {elseif !$FD && $FH && !$UD && !$UH}
                                                    از {$FH} ساعت مانده به پرواز به بعد
                                                    = {$fp.fine_percentage}% جریمه
                                                    {* حالت 9: همه صفر یا null *}
                                                {elseif !$FD && !$FH && !$UD && !$UH}
                                                  بعد از پرواز (no show)
                                                    = {$fp.fine_percentage}% جریمه
                                                {else}
                                                    بازده نامشخص
                                                {/if}
                                            </div>
                                        {/foreach}
                                    </div>
                                </td>
                                <td>
                                    <a href="editAirlineFinePercentage&id={$item.package_id}" class="btn btn-sm btn-primary" title="ویرایش">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="javascript:void(0)" onclick="soft_deletion('{$item.package_id}');" class="btn btn-sm btn-danger" title="حذف">
                                        <i class="fa fa-trash"></i>
                                    </a>
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
        <span> ویدیو آموزشی بخش لیست ویزاها  </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/392/-.html" target="_blank" class="i-btn"></a>

</div>

<script type="text/javascript" src="assets/JsFiles/airline.js"></script>