{load_presentation_object filename="members" assign="objCounter"}
{load_presentation_object filename="agencyDepartments" assign="objAgencyDepart"}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/ticket/agencyList">همکاران</a></li>
                <li class="active">مدیران</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

        </div>
    </div>
    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">لیست مدیران</h3>
                <p class="text-muted m-b-30"> در لیست زیر شما میتوانید لیست مدیران همکار زیر مجموعه خود را مشاهده
                    نمائید

                        <span class="pull-right">
                         <a href="insert&agencyID={$smarty.get.id}" class="btn btn-info waves-effect waves-light " type="button">
                             <span class="btn-label"><i class="fa fa-user-plus"></i></span>افزودن مدیر جدید
                        </a>
                    </span>
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام مدیر</th>
                            <th>نام کاربری مدیر</th>
                            <th>آژانس مربوطه</th>
                            <th>واحد</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="departList" value=[]}
                        {foreach $objAgencyDepart->getAgencyDepart() as $depart}
                            {assign var="temp" value=["id"=>$depart.id,"title"=>$depart.title]}
                            {assign var="departList" value=$departList|@array_merge:[$temp]}
                        {/foreach}

                        {assign var="number" value="0"}
                        {assign var="Id" value=$smarty.get.id}
                        {foreach key=key item=item from=$objCounter->getCountersByAgency($Id,'2')}
                            {$number=$number+1}
                            <tr id="del-{$item.id}">
                                <td>{$number}</td>
                                <td>{$item.name} {$item.family}</td>
                                <td>{$item.user_name}</td>
                                <td>{$item.agencyName}</td>
                                <td>
                                    {assign var="unitName" value=""}
                                    {foreach $departList as $d}
                                        {if $d.id == $item.id_departments}
                                            {assign var="unitName" value=$d.title}
                                        {/if}
                                    {/foreach}
                                    {$unitName|default:"-"}
                                </td>
                                <td>
                                    <a href="#" onclick="active_counter_list('{$item.id}'); return false;">
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
                                    <a href="edit&id={$item.id}{if $smarty.get.id}&agencyID={$smarty.get.id}{/if}">
                                        <i class="fcbtn btn btn-outline btn-primary btn-1f  tooltip-primary ti-pencil-alt "
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title=" ویرایش مدیر "></i>
                                    </a>
                                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/menuPermissions/list_for_manager&id={$item.id}{if $smarty.get.id}&agencyID={$smarty.get.id}{/if}">
                                        <i class="fcbtn btn btn-outline btn-success btn-1f tooltip-success fa fa-user-secret"
                                           data-toggle="tooltip" data-placement="top"
                                           title="" data-original-title="سطح دسترسی منوها"></i>
                                    </a>
                                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/pagesPermissions/pagesPermissions&id={$item.id}{if $smarty.get.id}&agencyID={$smarty.get.id}{/if}">
                                        <i class="fcbtn btn btn-outline btn-warning btn-1e fa fa-key tooltip-warning"
                                           data-toggle="tooltip" data-placement="top"
                                           data-original-title="سطح دسترسی صفحات"></i>
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

<script type="text/javascript" src="assets/JsFiles/counter.js"></script>