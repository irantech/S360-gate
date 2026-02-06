{load_presentation_object filename="agency" assign="objAgency"}
{$objAgency->getAll()} {*گرفتن لیست آژانسها*}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="active">همکاران</li>
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
                <h3 class="box-title m-b-0">لیست همکاران زیر مجموعه</h3>
                <p class="text-muted m-b-30"> در لیست زیر شما میتوانید لیست همکاران زیر مجموعه خود را مشاهده نمائید
                    <span class="pull-right">
                         <a href="agencyAdd" class="btn btn-info waves-effect waves-light " type="button">
                            <span class="btn-label"><i class="fa fa-user-plus"></i></span>افزودن همکار جدید
                        </a>
                    </span>


                    <span class="pull-right ml-2">
                         <a href="partner-white-label" class="btn btn-info waves-effect waves-light " type="button">
                            <span class="btn-label"><i class="fa fa-user"></i></span>مدیریت  وایت لیبل
                        </a>
                    </span>
                </p>
                <div class="w-100">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام آژانس (با مدیریت)/ آژانس همکار</th>
                            <th>تعداد کانتر</th>
                            <th>نوع پرداخت<br/>نوع ارز</th>
                            <th>اعتبار غیر مالی </th>
                            <th>اعتبار </th>
                            <th> خرید </th>
                            <th>اعتبار باقی مانده</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objAgency->list}
                        {$number=$number+1}
                            {if $item.type_payment eq 'currency'}
                                {assign value=0 var="format_desimal"}
                            {else}
                                {assign value=0 var="format_desimal"}
                            {/if}
                        <tr id="del-{$item.id}" >
                            <td class="align-middle">{$number}</td>
                            <td class="align-middle">{$item.name_fa}({$item.manager})/{if $item.isColleague eq '0'}خیر{elseif $item.isColleague eq '1'}بله{else}{/if}</td>
                            <td class="align-middle">{$item.numCounter}</td>
                            <td class="align-middle">{$item.type_payment_title}<hr/>{$item.currency_title}</td>
                            <td class="align-middle"  {if $item.check_time_limit_credit eq false && $item.limit_credit > 0 }style="color:#8d3434"{/if}>{$item.limit_credit|number_format}
                                <br/>
                                {if $item.check_time_limit_credit eq false && $item.limit_credit > 0 }(<span {if $item.check_time_limit_credit eq false && $item.limit_credit > 0 }style="color:#8d3434"{/if}>منقضی شده</span>){/if}</td>
                            <td class="align-middle">{if $item.give eq ''}0{else}{$item.give|number_format:$format_desimal}{/if}</td>
                            <td class="align-middle">{if $item.buy eq ''}0{else}{$item.buy|number_format:$format_desimal}{/if}</td>
                            <td class="align-middle">{if $item.credit eq ''}0{else}{$item.credit|number_format:$format_desimal}{/if}
                            </td>
                            <td>
                                <a href="#" onclick="changeStatusAgency('{$item.id}'); return false;">
                                    {if $item.active eq 'on'}
                                        <input type="checkbox" class="js-switch" data-color="#99d683"
                                               data-secondary-color="#f96262" data-size="small" checked/>
                                    {else}
                                        <input type="checkbox" class="js-switch" data-color="#99d683"
                                               &id={$item.id}  data-secondary-color="#f96262" data-size="small"/>
                                    {/if}
                                </a>
                            </td>
                            <td>
                                <div class="btn-group m-r-10">
                                    <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light" type="button">  عملیات <span class="caret"></span></button>
                                    <ul role="menu" class="dropdown-menu dropdown-menu-left animated flipInY">
                                        <li class="li-list-operator">
                                            {if $item.hasSite eq '1'}
                                                <a href="agencyAccess&id={$item.id} " >
                                                    <i class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-key"
                                                       data-toggle="tooltip"
                                                       data-placement="top" title=""
                                                       data-original-title="ایجاد دسترسی به همکار"></i>
                                                </a>

                                                <a href="agencyCommission&id={$item.id} " >
                                                    <i class="fcbtn btn btn-outline btn-primary btn-1c tooltip-primary fa fa-key"
                                                       data-toggle="tooltip"
                                                       data-placement="top" title=""
                                                       data-original-title="تعیین کمیسیون دریافتی از همکار"></i>
                                                </a>
                                            {/if}

                                        </li>
                                        <li class="li-list-operator">
                                            <a href="agencyEdit&id={$item.id} " ><i
                                        class="fcbtn btn btn-outline btn-primary btn-1c mdi mdi-account-edit tooltip-primary"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="ویرایش همکار"></i></a>
                                        </li>
                                        <li class="li-list-operator">
                                            <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/agencyManager/list&id={$item.id}" ><i
                                                        class="fcbtn btn btn-outline btn-success btn-1c mdi mdi-account-card-details tooltip-success"
                                                        data-toggle="tooltip" data-placement="top" title=""
                                                        data-original-title="لیست مدیران"></i></a>
                                        </li>
                                        <li class="li-list-operator">
                                            <a href="counterList&id={$item.id}" ><i
                                        class="fcbtn btn btn-outline btn-info btn-1c mdi mdi-account-card-details tooltip-info"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="لیست کانتر ها"></i></a>
                                        </li>
                                        <li class="li-list-operator">
                                            <a href="creditDetailList&id={$item.id}" ><i
                                        class="fcbtn btn btn-outline btn-warning btn-1c mdi mdi-credit-card tooltip-warning"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="جزئیات اعتبار"></i></a>
                                        </li>
                                        <li class="li-list-operator">
                                <a href="#" onclick="delete_agency_list('{$item.id}'); return false;"><i
                                        class="fcbtn btn btn-outline btn-danger btn-1c mdi mdi-account-remove tooltip-danger"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="حذف همکار"></i></a>
                                        </li>
                                        <li class="li-list-operator">
                                <a href="creditDetailCharge&id={$item.id}" ><i
                                        class="fcbtn btn btn-outline btn-default btn-1c mdi mdi-battery-charging tooltip-default"
                                        data-toggle="tooltip" data-placement="right" title=""
                                        data-original-title="لیست جزئیات شارژ همکار"></i></a>
                                        </li>
                                        <li class="li-list-operator">
                                <a href="agencyAttachments&id={$item.id}" ><i
                                        class="fcbtn btn btn-outline btn-success btn-1c mdi mdi-file-document-box tooltip-default"
                                        data-toggle="tooltip" data-placement="right" title=""
                                        data-original-title="لیست مدارک"></i></a>
                                        </li>

                                    </ul>
                                </div>
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