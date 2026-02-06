{load_presentation_object filename="Emerald" assign="ObjUser"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>خدمات ویژه</li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/Emerald">زمرد</a></li>
                <li class="active">لیست تمام پرداختی ها</li>
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
                <h3 class="box-title m-b-0">لیست تمام پرداختی های زمرد</h3>
                <div class="div-emerald"><p class="text-muted m-b-30">در لیست زیر شما میتوانید لیست تمام پرداختی های ریالی زمرد را مشاهده کنید

                    </p>
                    </div>

                <div class="table-responsive">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام کاربر</th>
                            <th>شماره شبا</th>
                            <th>نام صاحب حساب</th>
                            <th>بانک صاحب حساب</th>
                            <th>مشتری</th>
                            <th>مقدار درخواست</th>
                            <th>تاریخ درخواست</th>
                            <th>تاریخ پرداخت</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$ObjUser->listAllSuccessTransaction()}
                            {$number=$number+1}
                            <tr id="del-{$item.id}">
                                <td class="align-middle">{$number}</td>
                                <td class="align-middle">{$item.name} {$item.family}</td>
                                <td class="align-middle">{$item.sheba}</td>
                                <td class="align-middle">{$item.name_hesab}</td>
                                <td class="align-middle">{$item.bank_hesab}</td>
                                <td class="align-middle">{$item.AgencyName}</td>
                                <td class="align-middle">{$item.value|number_format}</td>
                                <td class="align-middle">{$item.date}</td>
                                <td class="align-middle">{$item.paydate}</td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/Emerald.js"></script>