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
                            <th style="width: 140px;">تاریخ </th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}

                        {foreach key=key item=item from=$ObjLogError->InfoShow($smarty.get.id)}
                            {$number=$number+1}
                            <tr id="del-{$item.id}">
                                <td>{$number}</td>
                                <td>{$item.request_number}</td>
                                <td>{$item.flight_number}</td>
                                <td>{$item.origin}</td>
                                <td>{$item.desti}</td>
                                <td>
                                    {$objFunctions->ShowError($item.messageCode)}
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
