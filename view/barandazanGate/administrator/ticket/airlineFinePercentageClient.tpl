{load_presentation_object filename="airLineFineController" assign="objFine"}
{assign var="groups" value=$objFine->airlineFineListGroupedByTimeRanges()}

<style>
    /* جدول کلی */
    .fine-table {
        width: 100%;
        border-collapse: collapse;
        text-align: center;
        font-size: 13px;
        margin-bottom: 20px;
    }

    /* هدر جدول */
    .fine-table thead th {
        background-color: #eee;
        padding: 10px;
        border: 1px solid #d3d3d3;
        text-align: center;
    }

    /* سلول‌ها */
    .fine-table tbody td {
        border: 1px solid #d3d3d3;
        padding: 8px;
    }

    /* کلاس‌های نرخی */
    .class-code {
        background-color: #28a745; /* سبز روشن */
        color: #fff;
        padding: 5px 10px;
        border-radius: 6px;
        display: inline-block;
        min-width: 40px;
    }

    /* سلول‌های درصد جریمه */
    .fine-cell {
        background-color: #f1f3f5; /* خاکستری روشن */
        color: #333;
        padding: 5px 8px;
        border-radius: 6px;
        display: inline-block;
    }

    /* بدون جریمه */
    .fine-cell:contains("بدون جریمه") {
        font-weight: bold;
        color: #28a745;
    }

    /* غیرقابل استرداد */
    .fine-cell:contains("غیرقابل استرداد") {
        font-weight: bold;
        color: #dc3545;
    }

    /* لوگوی ایرلاین و نام */
    .airline-cell {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .airline-logo {
        background-color: #f03c52;
        color: #fff;
        font-weight: bold;
        padding: 5px 10px;
        border-radius: 6px;
        margin-bottom: 5px;
    }

    .airline-name {
        font-size: 14px;
        font-weight: bold;
    }

    /* responsive برای موبایل */
    @media (max-width: 768px) {
        .fine-table thead th, .fine-table tbody td {
            font-size: 12px;
            padding: 6px;
        }
    }

    .header-range {
        border-bottom: 1px dashed rgba(255,255,255,0.3);
        padding: 5px 0;
        margin-bottom: 5px;
    }

    .header-range:last-child {
        border-bottom: none;
        margin-bottom: 0;
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

                </p>
                {foreach $groups as $group}
                    <div class="fine-card">
                        <div class="table-wrapper">
                            <table class="fine-table">
                                <thead>
                                <tr>
                                    <th>ایرلاین</th>
                                    <th>شناسه<br>نرخی(کلاس)</th>

                                    {foreach $group.time_ranges as $tr}
                                        <th>{$tr.title}</th>
                                    {/foreach}
                                </tr>
                                </thead>
                                <tbody>
                                {foreach $group.items as $item}
                                    <tr>
                                        <td>
                                            <div class="airline-cell">
                                                <div class="airline-logo">
                                                    {$item.airline_uniqe_iata}
                                                </div>
                                                <span class="airline-name">{$item.airline_name}</span>
                                            </div>
                                        </td>
                                        <td>
                                            {foreach $item.fare_classes as $fc}
                                                <span>{$fc.class_name}</span>{if !$fc@last}، {/if}
                                            {/foreach}
                                        </td>
                                        {foreach $item.merged_percentages as $mp}
                                            <td {if $mp.colspan > 1}colspan="{$mp.colspan}"{/if}>
                                                <span class="fine-cell">
                                                    {$mp.fine_text}
                                                </span>
                                            </td>
                                        {/foreach}
                                    </tr>
                                {/foreach}
                                </tbody>
                            </table>
                        </div>
                    </div>
                {/foreach}
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