{load_presentation_object filename="agency" assign="objAgency"}
{assign var="listAgency" value=$objAgency->listRequestAgency()} {*گرفتن لیست آژانسها*}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="active">همکاران غیرفعال</li>
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
                <h3 class="box-title m-b-0">لیست درخواست وایت لیبل همکاران زیر مجموعه مشتریان سفر360</h3>
                <p class="text-muted m-b-30">در لیست زیر آژانس های زیر مجموعه ایی که درخواست وایت لیبل دارند را مشاهده میکنید
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام مشتری</th>
                            <th>نام آژانس (با مدیریت)</th>
                            <th>وضعیت</th>
                            <th> دامنه</th>
                            <th> عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$listAgency}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td class="align-middle">{$number}</td>
                            <td class="align-middle">{$item.clientName}</td>
                            <td class="align-middle">{$item.name_fa}({$item.manager})</td>
                            <td class="align-middle">{if $item.active eq 'on'}<span class="btn-sm btn-success">فعال</span>{else}<span class="btn-sm btn-danger">غیر فعال</span>{/if}</td>
                            <td class="align-middle">{$item.domain}</td>
                            <td>

                                    <a href="agencyEdit&id={$item.id}&type=acceptWhiteLabel" class=""><i
                                                class="fcbtn btn btn-outline btn-info btn-1c fa fa-eye tooltip-info"
                                                data-toggle="tooltip" data-placement="top" title=""
                                                data-original-title="مشاهده همکار"></i>
                                    </a>

                                <a href="#" onclick="acceptSubAgencyWhiteLabel('{$item.id}'); return false" class=""><i
                                            class="fcbtn btn btn-outline btn-success btn-1c fa fa-check tooltip-success"
                                            data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="تایید وایت لیبل همکار"></i>
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