{if $smarty.const.TYPE_ADMIN eq 1}
{load_presentation_object filename="LogError" assign="ObjLogError"}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                {if $smarty.get.id neq ''}
                <li><a href="flyAppClient">مشتریان نرم افزار پرواز</a></li>
                {/if}
                <li class="active">سوابق خطای وب سرویس </li>
                {if $smarty.get.id neq ''}
                <li class="">{$objFunctions->ClientName($smarty.get.id)}</li>
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
                <h3 class="box-title m-b-0">لیست خطاهای وب سرویس</h3>
                <p class="text-muted m-b-30">در لیست زیر شما میتوانید  خطاهای ایجاد شده در روند رزرو  را مشاهده کنید

                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>شماره واچر</th>
                            <th>شماره پرواز</th>
                            <th>مبدا</th>
                            <th>مقصد</th>
                            <th>دلیل خطا</th>
                            <th>نام مشتری</th>
                            <th>مرحله خطا</th>
                            <th style="width: 140px;">تاریخ </th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}

                        {foreach key=key item=item from=$ObjLogError->ListLogErrorAdmin()}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td>{$number}</td>
                            <td>
                                {$item.request_number}
                            </td>
                            <td>{$item.flight_number}</td>
                            {*<td>{$item.FlightNumber}</td>*}
                            <td>{$item.origin}</td>
                            {*<td>{$item.OriginFind}</td>*}
                            <td>{$item.desti}</td>
                            {*<td>{$item.DestinationFind}</td>*}
                            <td>
                                {$objFunctions->ShowError($item.messageCode)}
                                {*{if  $item.FlightType eq 'system'}ایرلاین تغییر قیمت یا تغییر ظرفیت داشته است{else}چارتر کننده تغییر قیمت یا تغییر ظرفیت داشته است{/if}*}

                            </td>

                            <td>
                                {*$ObjLogError->ClientName($item.request_number)*}
                                {$objFunctions->ClientName($item.clientId)}
                            </td>

                            <td>
                                {if $item.action eq 'Revalidate'}
                                    <span>اعتبار سنجی</span>
                                {elseif $item.action eq 'PreReserve'}
                                    <span>ورود اسامی</span>
                                {elseif $item.action eq 'Book'}
                                    <span>پیش رزرو</span>
                                {elseif $item.action eq 'Reserve'}
                                    <span>مرحله نهایی(رزرو)</span>
                                {/if}
                            </td>

                            <td dir="ltr" class="text-left">{$objDate->jdate('Y-m-d (H:i:s)', $item.creation_date_int)}</td>
                        </tr>

                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/bankList.js"></script>
{/if}