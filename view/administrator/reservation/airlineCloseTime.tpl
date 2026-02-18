{load_presentation_object filename="airlineCloseTime" assign="objAirline"}
{assign var="allAirlines" value=$objAirline->getAll()}
{assign var="globalTime" value=$objAirline->getGlobalTime()}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="flyAppClient">اطلاعات پایه رزرواسیون</a></li>
                <li class="active">ساعات ارسال مانیفست ایرلاین ها</li>
                {if $smarty.get.id neq ''}
                    <li>{$objFunctions->ClientName($smarty.get.id)}</li>
                {/if}
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
                <h3 class="box-title m-b-0">لیست ساعات ارسال مانیفست ایرلاین ها</h3>
                <div class="text-muted m-b-30 d-flex align-items-center justify-content-between">
                    <p class="mb-0">
                    شما میتوانید در لیست زیر لیست ساعات ارسال مانیفست ایرلاین های مورد نظر خود را تغییر دهید یا تعیین نمایید
                    </p>
                        <a onclick="ModalChangeCloseTime()" type="button" class="btn btn-info waves-effect waves-light" data-toggle="modal" data-target="#ModalPublic">
                        <span class="btn-label"><i class="fa fa-plus"></i></span>تنظیمات کلی
                    </a>
                </div>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام فارسی</th>
                            <th>نام انگلیسی</th>
                            <th>مخفف</th>
                            <th>ساعت بستن داخلی</th>
                            <th>ساعت بستن خارجی</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach $allAirlines as $item}
                            {$number=$number+1}
                            <tr>
                                <td class="align-middle">{$number}</td>
                                <td class="align-middle">{$item.name_fa}</td>
                                <td class="align-middle">{$item.name_en}</td>
                                <td class="align-middle">{$item.abbreviation}</td>
                                <td class="align-middle">
                                    {if $item.close_time_internal}
                                        {$item.close_time_internal}
                                    {else}
                                        {$globalTime.internal}
                                    {/if}
                                </td>
                                <td class="align-middle">
                                    {if $item.close_time_external}
                                        {$item.close_time_external}
                                    {else}
                                        {$globalTime.external}
                                    {/if}
                                </td>
                                <td>
                                    <a onclick="ModalChangeCloseTime({$item.id})" type="button" data-toggle="modal" data-target="#ModalPublic">
                                        <i class="fcbtn btn btn-outline btn-primary btn-1e  fa fa-edit tooltip-primary"
                                                data-toggle="tooltip" data-placement="top" title=""
                                                data-original-title="ویرایش">
                                        </i>
                                    </a>
                                    {if isset($item.close_time_internal) and isset($item.close_time_external)}
                                        <a onclick="deleteCloseTime({$item.id})">
                                            <i class="fcbtn btn btn-outline btn-warning btn-1e  fa fa-refresh tooltip-warning"
                                               data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="بازگردانی به تنظیمات پیش فرض">
                                            </i>
                                        </a>
                                    {/if}

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

<script type="text/javascript" src="assets/JsFiles/airlineCloseTime.js"></script>


