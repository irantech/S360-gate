{load_presentation_object filename="cancellationFeeSetting" assign="ObjFee"}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>تنظیمات</li>
                <li class="active">لیست تنظیمات جریمه کنسلی</li>
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
                <h3 class="box-title m-b-0">تنظیم جریمه کنسلی</h3>
                <p class="text-muted m-b-30"> در لیست زیر شما میتوانید تنظیماتی که تا کنون اعمال کرده اید را مشاهده نمائید
                    {if $smarty.const.TYPE_ADMIN eq '1'}
                    <span class="pull-right">
                         <a href="cancellationFeeSetting" class="btn btn-info waves-effect waves-light " type="button">
                    <span class="btn-label"><i class="fa fa-user-plus"></i></span>افزودن تنطیمات جدید
                </a>
                </span>
                    {/if}

                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام ایرلاین</th>
                            <th>شناسه نرخی</th>
                            <th>تا 12 ظهر 3 روز قبل از پرواز</th>
                            <th>تا 12 ظهر 1 روز قبل از پرواز</th>
                            <th>تا 3 ساعت قبل از پرواز</th>
                            <th>تا 30 دقیقه قبل از پرواز</th>
                            <th>از 30 دقیقه قبل پرواز به بعد</th>
                            {if $smarty.const.TYPE_ADMIN eq '1'}
                            <th>عملیات</th>
                            {/if}
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$ObjFee->ListFee()}
                        {$number=$number+1}
                            {assign var="arilineInfo" value=$objFunctions->InfoAirline($item.AirlineIata)}
                        <tr id="del-{$item.id}">
                            <td class="align-middle">{$number}</td>
                            <td class="align-middle">{$arilineInfo['name_fa']}</td>
                            <td class="align-middle">{$item.TypeClass}</td>
                            <td class="align-middle">{$item.ThreeDaysBefore}%</td>
                            <td class="align-middle">{$item.OneDaysBefore}%</td>
                            <td class="align-middle">{$item.ThreeHoursBefore}%</td>
                            <td class="align-middle">{$item.ThirtyMinutesAgo}%</td>
                            <td class="align-middle">{$item.OfThirtyMinutesAgoToNext}%</td>
                            {if $smarty.const.TYPE_ADMIN eq '1'}
                            <td class="align-middle" style="width: 120px">
                                <a href="cancellationFeeSettingEdit&id={$item.id}" class=""><i
                                        class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="ویرایش تنظیمات"></i></a>

                            </td>
                            {/if}
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
        <span> ویدیو آموزشی بخش  درصد جریمه کنسلی    </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/363/--.html" target="_blank" class="i-btn"></a>

</div>

<script type="text/javascript" src="assets/JsFiles/agency.js"></script>