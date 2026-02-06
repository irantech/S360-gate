{load_presentation_object filename="configurations" assign="objConfig"}
{if $smarty.const.TYPE_ADMIN eq '1'}

{assign var="allConfigurations" value=$objConfig->getAllConfigurations()}
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
            <div class="white-box"><h3 class="box-title m-b-0">لیست تمامی تنظیمات</h3>
                <div class="table-responsive table-bordered">
                    <table id="myTable" class="table table-striped table-hover">
                        <thead class="thead-default">
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان</th>
                            <th>عنوان انگلیسی</th>
                            <th>خدمات</th>
                            {*<th>نوع</th>*}
                            <th>ویرایش</th>
                            <th>فعال/غیرفعال</th>
                            <th>تغییر توسط کلاینت</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="rowNum" value=0}
                        {foreach $allConfigurations as $config}
                            {$rowNum=$rowNum+1}
                            <tr>
                                <td>{$rowNum}</td>
                                <td>{$config.title}</td>
                                <td>{$config.title_en}</td>
                                <td>{$config.service_group_title}</td>
                                {*<td>{$config.type}</td>*}
                                <td>
                                    <a class="btn btn-sm btn-outline btn-primary" href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/configurations/editConfiguration?id={$config.id}"><i class="fa fa-edit"></i>ویرایش </a>
                                </td>
                                <td>
                                    <a href="#" onclick="changeConfigurationStatus('{$config.id}'); return false">
                                        {if $config.is_active eq '1'}
                                            <input type="checkbox" class="js-switch" data-color="#99d683"
                                                   data-secondary-color="#f96262" data-size="small" checked
                                                   id="config{$config.id}"/>
                                        {else}
                                            <input type="checkbox" class="js-switch" data-color="#99d683"
                                                   data-secondary-color="#f96262" data-size="small"
                                                   id="config{$config.id}"/>
                                        {/if}
                                    </a>
                                </td><td>
                                    <a href="#" onclick="changeConfigurationEdit('{$config.id}'); return false">
                                        {if $config.client_can_edit eq '1'}
                                            <input type="checkbox" class="js-switch" data-color="#99d683"
                                                   data-secondary-color="#f96262" data-size="small" checked
                                                   id="userCanEdit{$config.id}"/>
                                        {else}
                                            <input type="checkbox" class="js-switch" data-color="#99d683"
                                                   data-secondary-color="#f96262" data-size="small"
                                                   id="userCanEdit{$config.id}"/>
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


<script type="text/javascript" src="assets/JsFiles/configurations.js"></script>
{/if}