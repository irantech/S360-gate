{load_presentation_object filename="configurations" assign="objConfig"}
{if $smarty.const.TYPE_ADMIN eq '1'}
{assign var="thisConfig" value=$objConfig->getConfigurationById($smarty.get.id)}
{assign var="service_groups" value=$objConfig->getAllServiceGroups()}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/configurations/listConfigurations">تمامی تنظیمات</a></li>
                <li><a class="badge badge-warning" href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/configurations/addConfiguration"><i class="fa fa-plus"></i> افزودن </a></li>

            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">ویرایش کانفیگ  </h3>
                <form id="editConfiguration" action="/" method="post" class="row">
                    <input type="hidden" id="id" name="id" value="{$thisConfig.id}">
                    <div class="form-group col-sm-4">
                        <label for="title" class="control-label">عنوان</label>
                        <input type="text" class="form-control" id="title" placeholder="عنوان تنظیمات را وارد کنید" value="{$thisConfig.title}">
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="title_en" class="control-label">عنوان انگلیسی</label>
                        <input type="text" class="form-control" id="title_en" placeholder="عنوان انگلیسی تنظیمات را وارد کنید" value="{$thisConfig.title_en}">
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="service_group" class="control-label">نوع خدمات مربوطه</label>
                        <select name="service_group" id="service_group" class="form-control">
                            {foreach $service_groups as $service_group}
                                <option {if $thisConfig.service_group_id eq $service_group.id}selected{/if} value="{$service_group.id}">{$service_group.Title}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="col-sm-12">
                    <div class="col-sm-6">
                        <div class="pull-left">
                            <label for="config{$thisConfig.id}" class="control-label">فعال/غیرفعال</label>
                            {if $thisConfig.is_active eq '1'}
                                <input type="checkbox" class="js-switch" data-color="#99d683"
                                       data-secondary-color="#f96262" data-size="small" checked
                                       id="config{$thisConfig.id}"/>
                            {else}
                                <input type="checkbox" class="js-switch" data-color="#99d683"
                                       data-secondary-color="#f96262" data-size="small"
                                       id="config{$thisConfig.id}"/>
                            {/if}

                        </div>
                        <div class="pull-right">
                            <label for="userCanEdit{$thisConfig.id}" class="control-label">تغییر توسط کلاینت</label>
                            {if $thisConfig.client_can_edit eq '1'}
                                <input type="checkbox" class="js-switch" data-color="#99d683"
                                       data-secondary-color="#f96262" data-size="small" checked
                                       id="userCanEdit{$thisConfig.id}"/>
                            {else}
                                <input type="checkbox" class="js-switch" data-color="#99d683"
                                       data-secondary-color="#f96262" data-size="small"
                                       id="userCanEdit{$thisConfig.id}"/>
                            {/if}

                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group pull-right">
                            <button type="submit" class="fcbtn btn btn-info btn-outline btn-1b margin-top-23">ارسال</button>
                        </div>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="assets/JsFiles/configurations.js"></script>
{/if}