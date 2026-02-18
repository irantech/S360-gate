{load_presentation_object filename="agency" assign="objAgency"}
{$objAgency->checkWhiteLabelAgency($smarty.get.id)}
{assign var="infoAgency" value=$objAgency->getAgency($smarty.get.id)} {*گرفتن لیست آژانسها*}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/ticket/agencyList">همکاران</li>
                <li class="active">ایجاد دسترسی برای {$infoAgency.name_fa}</li>
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
                <h3 class="box-title m-b-0">دسترسی به آژانس زیر مجموعه</h3>
                    <p class="text-muted m-b-30">
                        شما در جدول زیر می توانید دسترسی های مورد نظر خود برای وایت لیبل همکار را در نظر بگیرید
                    </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نوع خدمات</th>
                            <th>وضعیت</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objFunctions->listServiceClient()}
                            {$number=$number+1}
                            <tr id="del-{$item.id}">
                                <td class="align-middle">{$number}</td>
                                <td class="align-middle">{$item.Title}</td>
                                <td class="align-middle">
                                    <a href="#"
                                       onclick="changeStatusServiceAgency('{$infoAgency['id']}', '{$item.id}'); return false">
                                        {if $objAgency->checkExistAccessAgency($infoAgency['id'],$item.id) neq ''}
                                            <input type="checkbox" class="js-switch" data-color="#99d683"
                                                   data-secondary-color="#f96262" data-size="middle" checked/>
                                        {else}
                                            <input type="checkbox" class="js-switch" data-color="#99d683"
                                                   data-secondary-color="#f96262" data-size="middle"/>
                                        {/if}
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
        <span> ویدیو آموزشی بخش همکاران</span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/373/-.html" target="_blank" class="i-btn"></a>

</div>

<script type="text/javascript" src="assets/JsFiles/agency.js"></script>