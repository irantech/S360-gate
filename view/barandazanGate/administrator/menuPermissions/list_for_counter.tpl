{load_presentation_object filename="admin" assign="objAdmin"}
{assign var="access" value=$objAdmin->ListAllAccessMenuCounter($smarty.get.id)}

{load_presentation_object filename="members" assign="objCounter"}
{assign var="member" value=$objCounter->getMemberById($smarty.get.id)}

{load_presentation_object filename="agencyDepartments" assign="objAgencyDepart"}
{assign var="infoDepart" value=$objAgencyDepart->getAgencyDepartById($member.id_departments)}

{load_presentation_object filename="userPermissions" assign="objUserPermission"}
{assign var="infoUserPermission" value=$objUserPermission->getUserPermissionById($smarty.get.id)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/ticket/agencyList">همکاران</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/ticket/counterList&id={$smarty.get.agencyID}">کانترها</a></li>
                <li class="active">
                    سطح دسترسی منوهای
                    {$member.name} {$member.family} -
                    واحد {$infoDepart.title}
                </li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                {* سطح دسترسی عملیات *}
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="card border p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5>
                                    سطح دسترسی عملیات
                                </h5>
                            </div>
                            <hr class="my-2">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-2">
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
                                    <div class="col-md-2">
                                        <div class="form-check mb-2">
                                            <input type="checkbox"
                                                   class="operation-checkbox"
                                                   name="permissions[can_insert]"
                                                   value="1"
                                                   id="perm_insert"
                                                   data-switchery="true"
                                                   {if $infoUserPermission.can_insert == 1}checked{/if}>
                                            <label for="perm_insert">ثبت (Insert)</label>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-check mb-2">
                                            <input type="checkbox"
                                                   class="operation-checkbox"
                                                   name="permissions[can_update]"
                                                   value="1"
                                                   id="perm_update"
                                                   data-switchery="true"
                                                   {if $infoUserPermission.can_update == 1}checked{/if}>
                                            <label for="perm_update">ویرایش (Update)</label>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-check mb-2">
                                            <input type="checkbox"
                                                   class="operation-checkbox"
                                                   name="permissions[can_delete]"
                                                   value="1"
                                                   id="perm_delete"
                                                   data-switchery="true"
                                                   {if $infoUserPermission.can_delete == 1}checked{/if}>
                                            <label for="perm_delete">حذف (Delete)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
                <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
                <form id="AccessMenuForm" method="post">
                    <input type="hidden" name="idMember" id="idMember" value="{$smarty.get.id}">
                    <input type="hidden" name="roleMember" id="roleMember" value="manager">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="card border p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">سطح دسترسی منوها در پنل</h5>
                                </div>
                                <hr class="my-2 mb-4">
                                {assign var="menus" value=$objAdmin->ListAllMenuForCounters($member.id_departments,$smarty.get.agencyID)}
                                {assign var=menuIndex value=0}
                                {foreach from=$menus item=menu}
                                    {assign var=menuIndex value=$menuIndex+1}
                                    {assign var=bgColor value=($menuIndex % 2 == 0) ? '#f2f2f2' : '#fafafa'} <!-- خاکستری روشن و پررنگ -->

                                    <!-- سطح 1 -->
                                    <div class="card mb-4 p-3 shadow-sm border-primary" style="background-color: {$bgColor};">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h5 class="fw-bold fs-5" style="font-size: 16px;">{$menu.title}</h5>
                                            <input type="checkbox" class="parent-checkbox js-switch" data-id="{$menu.id}" {if isset($access[$menu.id]) && $access[$menu.id] == 1}checked{/if}>
                                        </div>
                                        <hr style="margin-top:0.25rem; margin-bottom:2rem;">

                                        {if $menu.children|@count > 0}
                                            <div class="level-2 ms-3 mt-2">  {* لایه دوم *}
                                                {foreach from=$menu.children item=child}
                                                    {if $child.children|@count > 0}
                                                        <div class="mb-3 p-2 border rounded level-2-box">
                                                            <div class="form-check d-inline-block me-3 mb-2">
                                                                <input type="checkbox" class="child-checkbox js-switch" data-id="{$child.id}" name="menus[{$child.id}]" value="1" id="child{$child.id}" {if isset($access[$child.id]) && $access[$child.id] == 1}checked{/if}>
                                                                <label for="child{$child.id}" class="fw-semibold fs-6" style="font-size: 15px;">{$child.title}</label>
                                                            </div>

                                                            <!-- سطح 3 -->
                                                            <div class="level-3 ms-4 d-flex flex-wrap mt-2">
                                                                {foreach from=$child.children item=subChild name=subLoop}
                                                                <div class="form-check me-4 mb-3 level-3-box" style="min-width: 195px !important;">
                                                                    <input type="checkbox" class="subchild-checkbox js-switch" data-id="{$subChild.id}" name="menus[{$subChild.id}]" value="1" id="subchild{$subChild.id}" {if isset($access[$subChild.id]) && $access[$subChild.id] == 1}checked{/if}>
                                                                    <label for="subchild{$subChild.id}" class="fs-7" >{$subChild.title}</label>
                                                                </div>
                                                                {if $smarty.foreach.subLoop.index+1 % 5 == 0}</div><div class="level-3 ms-4 d-flex flex-wrap mt-2">{/if}
                                                                {/foreach}
                                                            </div>
                                                        </div>
                                                    {else}
                                                        <!-- بلوک child بدون زیرمجموعه -->
                                                        <div class="form-check d-inline-block me-3 mb-3 level-2-box">
                                                            <input type="checkbox" class="child-checkbox js-switch" data-id="{$child.id}" name="menus[{$child.id}]" value="1" id="child{$child.id}" {if isset($access[$child.id]) && $access[$child.id] == 1}checked{/if}>
                                                            <label for="child{$child.id}" class="fw-semibold fs-6" style="min-width: 195px !important;font-size: 14px;">{$child.title}</label>
                                                        </div>
                                                    {/if}
                                                {/foreach}
                                            </div>
                                        {/if}
                                    </div>
                                {/foreach}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="assets/JsFiles/menuPermissions.js"></script>
<style>
    .level-2 {
        margin-right: 20px;  /* کمی تو بره */
        border-right: 2px dashed #ccc; /* خط راهنما برای درختی بودن */
        padding-right: 10px;
    }
    .level-3 {
        margin-right: 40px;  /* بیشتر تو بره */
        border-right: 1px dotted #bbb;
        padding-right: 10px;
    }
</style>