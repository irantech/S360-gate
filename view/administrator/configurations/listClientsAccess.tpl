{load_presentation_object filename="configurations" assign="objConfig"}
{if $smarty.const.TYPE_ADMIN eq '1'}
    {*if !$smarty.get.id}
        {$objFunctions->redirect('/gds/itadmin/ticket/flyAppClient')}
    {/if*}
{assign var="allClients" value=$objConfig->getAllClientsConfiguration($smarty.get.id)}
{assign var="allConfigurations" value=$objConfig->getAllConfigurations()}
{*{assign var="inputs"  value=$objConfig->insertAllAdvertiseAccess($smarty.get.id)}*}
{*<code>{$inputs|json_encode}</code>*}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/configurations/listConfigurations">تمامی تنظیمات</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            {foreach $allClients as $client}
                <div class="white-box" id="cart-client-{$client.client_id}">
                    <h4 class="card-title">{$client.name} </h4>
                    <div class="card-text">
                        {if $client.configurations|count > 0}
                            <table class="table">
                                <tbody>
                                {foreach $client.configurations as $config}
                                    <tr>
                                        <td>{$config.title}</td>
                                        <td>
                                            <button class="fcbtn btn btn-sm btn-outline btn-danger btn-1b remove-configuration-access" data-id="{$client.client_id}" data-config="{$config.id}"><i class="fa fa-times"></i></button>
                                        </td>
                                    </tr>
                                {/foreach}
                                </tbody>
                            </table>
                        {/if}
                        <button type="button" class="fcbtn btn btn-outline btn-info btn-1c insert-advertise-access" data-id="{$client.client_id}">افزودن دسترسی بنر تبلیغات</button>
                        <!-- Button trigger modal -->
                        <button type="button" class="fcbtn btn btn-outline btn-primary btn-1c" data-toggle="modal"
                                data-target="#addConfigurationAccess{$client.client_id}">افزودن دسترسی جدید
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="addConfigurationAccess{$client.client_id}" tabindex="-1" role="dialog"
                             aria-labelledby="modelTitleId" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="/" method="post" class="newConfigurationAccess">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <h5 class="modal-title">افزودن دسترسی جدید برای {$client.name}</h5>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="client_id" id="client_id" value="{$client.client_id}">
                                            <select name="configuration_id" id="configuration_id">
                                                {foreach $allConfigurations as $configuration}
                                                    <option value="{$configuration.id}">{$configuration.title}
                                                        - {$configuration.service_group_title}</option>
                                                {/foreach}
                                            </select>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">انصراف</button>
                                            <button type="submit" class="btn btn-primary">ثبت</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {/foreach}

        </div>
    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/configurations.js"></script>
{/if}