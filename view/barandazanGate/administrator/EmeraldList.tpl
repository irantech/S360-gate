{load_presentation_object filename="Emerald" assign="ObjUser"}
{assign var="RequestInfo" value=$ObjUser->ShowListRequest($smarty.get.id,$smarty.get.idclient)}
{assign var="Name" value=$ObjUser->ShowNameCounter($smarty.get.id,$smarty.get.idclient)}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>خدمات ویژه</li>
                <li>زمرد</li>
                <li class="active">لیست درخواست های پرداخت "{$Name['name']} {$Name['family']}"</li>
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
                <h3 class="box-title m-b-0">لیست درخواست های پرداخت"{$Name['name']} {$Name['family']}" </h3>
                <p class="text-muted m-b-30">در لیست زیر شما میتوانید درخواست های پرداخت ریالی زمرد {$Name['name']} {$Name['family']} را مشاهده کنید

                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام کاربر</th>
                            <th>مقدار درخواست</th>
                            <th>تاریخ درخواست</th>
                            <th>تأیید درخواست</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$RequestInfo}
                            {$number=$number+1}
                            <tr id="del-{$item.id}">
                                <td class="align-middle">{$number}</td>
                                <td class="align-middle">{$item.name} {$item.family}</td>
                                <td class="align-middle">{$item.value|number_format}</td>
                                <td class="align-middle">{$item.date}</td>
                                <td class="align-middle">
                                    {if $item.status eq 'Progress'}
                                    <a href="#" onclick="activate2('{$item.id}','{$smarty.get.idclient}','EmeraldList&id={$smarty.get.id}&idclient={$smarty.get.idclient}'); return false;"><i class="fa fa-check-circle" style="color: green;transform:scale(2)"></i></a>
                                        {else}
                                <span class="align-middle" style="color: green">پرداخت شده</span>
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

<script type="text/javascript" src="assets/JsFiles/Emerald.js"></script>