{load_presentation_object filename="routeFlight" assign="ObjRoute"}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                {if $smarty.get.id neq ''}
                <li><a href="flyAppClient">مشتریان نرم افزار پرواز</a></li>
                {/if}
                <li class="active">لیست مسیر ها</li>
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
                <h3 class="box-title m-b-0">لیست روت های پروازی</h3>
                <p class="text-muted m-b-30">در لیست زیر شما میتوانید روت های موجود را مشاهده و الویت نمایش آنها را مشخص  کنید
             <br>( <small class="text-danger">الویت بالاتر ابتدای لیست نمایش داده میشود</small>)
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                        <tr>
                            <th style="width: 120px">ردیف</th>
                            <th style="width: 120px">نام شهر مبداء</th>
                            <th style="width: 120px"> الویت</th>
                            <th style="width: 120px">عملیات </th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}

                        {foreach key=key item=item from=$ObjRoute->flightRouteInternal(['is_group'=>true , 'use_customer_db'=>true])}
                        {$number=$number+1}
                        <tr>
                            <td class="text-align-center">{$number}</td>
                            <td class="text-align-center">
                                {$item.Departure_City}
                            </td>
                            <td class="text-align-center" onclick="EditInPlace('{$item.Departure_Code}','{$item.priorityDeparture}')" id="{$item.Departure_Code}{$item.priorityDeparture}">
                                {$item.priorityDeparture}
                            </td>
                            <td class="text-align-center"><a class="btn btn-block btn-outline btn-info" href="routeArrivalFlightLocal?Code={$item.Departure_Code}"><i class="fa fa-list"></i> لیست شهرهای مقصد</a></td>
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
        <span> ویدیو آموزشی بخش تعیین اولویت رویت </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/394/---.html" target="_blank" class="i-btn"></a>

</div>

<script type="text/javascript" src="assets/JsFiles/routeFlight.js"></script>
