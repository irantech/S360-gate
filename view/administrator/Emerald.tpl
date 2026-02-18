{if $smarty.const.TYPE_ADMIN eq 1}
{load_presentation_object filename="Emerald" assign="ObjUser"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>خدمات ویژه</li>
                <li class="active">زمرد</li>
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
                <h3 class="box-title m-b-0">لیست درخواست های ریالی زمرد</h3>
                <div class="div-emerald"><p class="text-muted m-b-30">در لیست زیر شما میتوانید درخواست های پرداخت ریالی زمرد را از سمت کانترها مشاهده کنید

                    </p>
                    <a href="EmeraldListAll" class="btn btn-primary">لیست تمام پرداختی ها</a></div>

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
                            <th>تأیید درخواست</th>
                            <th>لیست پرداختی ها</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$ObjUser->listAllTransaction()}
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
                                <td class="align-middle"><a href="" onclick="activate('{$item.id}','{$item.ClientId}'); return false;"><i class="fa fa-check-circle" style="color: green;transform:scale(2)"></i></a>
                                </td>
                                <td class="align-middle">
                                    <a href="EmeraldList&id={$item.idUser}&idclient={$item.ClientId}" class=""><i
                                                class="fcbtn btn btn-outline btn-primary btn-1e fa fa-list"
                                                data-toggle="tooltip" data-placement="top" title=""
                                                data-original-title="لیست پرداختی ها"></i></a>
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

<script type="text/javascript" src="assets/JsFiles/Emerald.js"></script>
{/if}