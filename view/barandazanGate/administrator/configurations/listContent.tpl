{load_presentation_object filename="configurations" assign="objConfig"}
{if isset($smarty.get.config)}
    {assign var="allContent" value=$objConfig->getAllClientContents($smarty.const.CLIENT_ID,['configuration_id'=>$smarty.get.config],['id','title','content','configuration_id','content_type','is_active'])}
    {assign var="configuration" value=$objConfig->getConfigurationById($smarty.get.config)}
{else}
    {assign var="allContent" value=$objConfig->getAllClientContents($smarty.const.CLIENT_ID,[],['id','title','content','configuration_id','content_type','is_active'])}
{/if}
{assign var="allConfigurations" value=$objConfig->getClientConfigurations($smarty.const.CLIENT_ID,[],true)}
{*{$allConfigurations|json_encode}*}
{assign var="config_id" value=$smarty.get.config}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                {if isset($smarty.get.config)}
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/configurations/listContent">تمامی محتوا</a></li>

                <li><span>{$configuration.title}</span></li>

                {else}
                <li><span>تمامی محتوا</span></li>
                {/if}
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            {if isset($smarty.get.config)}
                <div class="white-box">
                    <h3 class="box-title">لیست محتوای تبلیغات
                        <a class="fcbtn btn btn-xs btn-outline btn-primary btn-1c pull-right"
                           href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/configurations/addContent?config={$smarty.get.config}"><i
                                    class="fa fa-plus"></i> افزودن </a>
                    </h3>
                    {if !in_array($configuration['service_group_id'],$objFunctions->array_column($objFunctions->listServiceClient(),'id'))}
                        <div class="alert alert-warning" role="alert">
                            <strong>اخطار</strong>
                            <p>این محتوا تا زمانی که خدمات آن را خریداری نکرده باشید در سایت نمایش داده نمیشود.</p>
                        </div>
                    {/if}

                    <div class="table-responsive table-bordered">
                        <table id="myTable" class="table table-striped table-hover">
                            <thead class="thead-default">
                            <tr>
                                <th>ردیف</th>
                                {if isset($smarty.get.config)}
                                <th>عنوان</th>
                                {else}
                                <th>زمینه تبلیغات</th>
                                {/if}
                                <th>نوع تبلیغات</th>
                                <th>فعال / غیر فعال</th>
                                <th>ویرایش</th>
                            </tr>
                            </thead>
                            <tbody>
                            {foreach $allContent as $key => $content}
                                {assign var="config" value=$objConfig->getConfigurationById($content.configuration_id)}
                                <tr>
                                    <td>{$key}</td>
                                    {if isset($smarty.get.config)}
                                        <td>{$content.title}</td>
                                        {else}
                                        <td>{$config.title}</td>
                                    {/if}
                                    <td>{$content.content_type}</td>
                                    <td class="align-middle">
                                        <a href="#"
                                           onclick="updateStatusConfigurations('{$content.id}'); return false">
                                            {if $content.is_active}
                                                <input type="checkbox" class="js-switch" data-color="#99d683"
                                                       data-secondary-color="#f96262" data-size="small" checked/>
                                            {else}
                                                <input type="checkbox" class="js-switch" data-color="#99d683"
                                                       data-secondary-color="#f96262" data-size="small"/>
                                            {/if}
                                        </a>
                                    </td>
                                    <td><a href="editContent?id={$content.id}&config={$config_id}" class="btn btn-primary">ویرایش</a> <button class="btn deleteContent btn-danger btn-outline" data-id="{$content.id}"><i class="fa fa-close"></i></button></td>
                                </tr>
                            {/foreach}
                            </tbody>
                        </table>
                    </div>
                </div>
            {else}
                <div class="white-box">
                    <h3 class="box-title m-b-0">لیست تبلیغات فعال برای شما</h3>
                    <p class="text-muted m-b-30">در اینجا شما میتوانید تمامی بخشهایی که قابلیت نمایش تبلیغات را دارد مشاهده کنید</p>
                    <div class="table-responsive table-bordered">
                        <table class="table table-striped table-hover">
                            <thead class="thead-default">
                            <tr>
                                <th>ردیف</th>
                                <th>عنوان</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            {foreach $allConfigurations as $key => $config}
                                <tr>
                                    <td scope="row">{$key+1}</td>
                                    <td>{$config['title']}</td>
                                    <td>
                                        <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/configurations/listContent?config={$config.id}"
                                           class="fcbtn btn btn-outline btn-success btn-1c"><i class="fa fa-list"></i> لیست مطالب </a>
                                    </td>
                                </tr>
                            {/foreach}
                            </tbody>
                        </table>
                    </div>
                </div>
            {/if}
        </div>
    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/configurations.js"></script>