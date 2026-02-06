{load_presentation_object filename="pagesPermissions" assign="objPageAccess"}
{assign var="pageAccessList" value=$objPageAccess->getAllPages($smarty.get.id)}

{load_presentation_object filename="adminPages" assign="objAdminPages"}
{assign var="adminPagesList" value=$objAdminPages->getAllPages()}

{load_presentation_object filename="members" assign="objCounter"}
{assign var="member" value=$objCounter->getMemberById($smarty.get.id)}

{load_presentation_object filename="agencyDepartments" assign="objAgencyDepart"}
{assign var="infoDepart" value=$objAgencyDepart->getAgencyDepartById($member.id_departments)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/ticket/agencyList">همکاران</a></li>
                {if $member.is_member eq 1}
                    <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/ticket/counterList&id={$smarty.get.agencyID}">کانترها</a></li>
                {else if $member.is_member eq 2}
                    <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/agencyManager/list&id={$smarty.get.agencyID}">مدیران</a></li>
                {/if}
                <li class="active">
                    سطح دسترسی صفحات ادمین
                    {$member.name} {$member.family} -
                    واحد {$infoDepart.title}
                </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">سطح دستری به صفحه</h3>
                <form id="pageForm" method="post">
                    <input type="hidden" id="id_member" name="id_member" value="{$smarty.get.id}">
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="id_page">عنوان صفحه:</label>
                            <select class="form-control" id="id_page" name="id_page">
                                <option value="">انتخاب کنید</option>
                                {foreach from=$adminPagesList item=list}
                                    <option value="{$list.id}">{$list.title}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="col-md-2" style="margin-top: 30px;">
                            <div class="form-check mb-2">
                                <input type="checkbox"
                                       class="operation-checkbox"
                                       id="perm_view"
                                       checked
                                       disabled
                                       data-switchery="true">
                                <label for="perm_view">نمایش (View)</label>
                            </div>
                        </div>

                        <div class="col-md-2" style="margin-top: 30px;">
                            <div class="form-check mb-2">
                                <input type="checkbox"
                                       class="operation-checkbox"
                                       name="can_insert"
                                       value="1"
                                       id="can_insert"
                                       data-switchery="true">
                                <label for="can_insert">ثبت (Insert)</label>
                            </div>
                        </div>

                        <div class="col-md-2" style="margin-top: 30px;">
                            <div class="form-check mb-2">
                                <input type="checkbox"
                                       class="operation-checkbox"
                                       name="can_update"
                                       value="1"
                                       id="can_update"
                                       data-switchery="true">
                                <label for="can_update">ویرایش (Update)</label>
                            </div>
                        </div>

                        <div class="col-md-2" style="margin-top: 30px;">
                            <div class="form-check mb-2">
                                <input type="checkbox"
                                       class="operation-checkbox"
                                       name="can_delete"
                                       value="1"
                                       id="can_delete"
                                       data-switchery="true">
                                <label for="can_delete">حذف (Delete)</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group pull-right">
                                <button type="submit" class="btn btn-primary">ارسال اطلاعات</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <table id="myTable" class="table table-striped ">
                    <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>عنوان صفحه</th>
                        <th>نمایش</th>
                        <th>ثبت</th>
                        <th>ویرایش</th>
                        <th>حذف</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    {* یک آرایه map بسازیم *}
                    {assign var="pageTitleMap" value=[]}
                    {foreach from=$adminPagesList item=page}
                        {append var="pageTitleMap" index=$page.id value=$page.title}
                    {/foreach}

                    {assign var="number" value=0}
                    {foreach from=$pageAccessList item=item name=list}
                        {assign var="number" value=$number+1}
                        <tr id="del-{$item.id}">
                            <td>{$number}</td>
                            <td>{$pageTitleMap[$item.id_page]}</td>
                            <td>✔️</td>
                            <td>{if $item.can_insert eq 1}✔️{/if}</td>
                            <td>{if $item.can_update eq 1}✔️{/if}</td>
                            <td>{if $item.can_delete eq 1}✔️{/if}</td>
                            <td>
                                <a href="#" onclick="deleteAccess('{$item.id}')">
                                    <i class="fcbtn btn btn-outline btn-danger btn-1f tooltip-danger ti-trash"
                                       data-toggle="tooltip" data-placement="top"
                                       title="حذف دسترسی"></i>
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
<script type="text/javascript" src="assets/JsFiles/pagesPermissions.js"></script>