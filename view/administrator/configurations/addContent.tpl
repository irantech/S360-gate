{load_presentation_object filename="configurations" assign="objConfig"}
{assign var="hasAccess" value=$objConfig->checkClientConfigurationAccess($smarty.get.config,$smarty.const.CLIENT_ID)}
{if $hasAccess eq false}
    {$objFunctions->redirect('/gds/itadmin/configurations/listContent')}
{/if}
{assign var="allConfigurations" value=$objConfig->getClientConfigurations($smarty.const.CLIENT_ID,[],true)}

{assign var="configuration" value=$objConfig->getConfigurationById($smarty.get.config)}
{assign var="config_id" value=$smarty.get.config}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/configurations/listContent">تمامی محتوا</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/configurations/listContent?config={$configuration.id}">{$configuration.title}</a>
                </li>
                <li><span>افزودن محتوا</span></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">افزودن محتوا </h3>
                <form id="addContent" action="/" method="post" class="row">
                    <input type="hidden" name="flag" id="flag" value="addNewClientContent">
                    {*<input type="hidden" name="configuration_id" id="configuration_id" value="{$smarty.get.config}">*}
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label for="title" class="control-label">عنوان</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="عنوان را وارد کنید">
                        </div>
                        <div class="form-group d-none contnt-html">
                            <label for="content" class="control-label">محتوا</label>
                            <textarea name="content" id="content" rows="8" disabled aria-disabled="true" class="form-control contnt-html"></textarea>
                        </div>
                        <div class="form-group contnt-image">
                            <label class="control-label" for="feature_image">تصویر شاخص </label>
                            <span class="help-block feedback">اندازه تصویر (800*158) </span>
                            <input type="file" name="feature_image" id="feature_image" class="dropify contnt-image" {if $config_id != 23} data-height="158" data-max-height="159" data-width="800" data-max-width="801" data-max-file-size="1M" {/if}  data-default-file="{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}/gds/pic/articles/no-photo.png"/>
                        </div>
                        <div class="form-group contnt-image">
                            <label for="link" class="control-label">لینک</label>
                            <input name="content" id="link" required aria-required="true" type="url" class="form-control contnt-image"/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="content_type" class="control-label">نوع تبلیغ</label>
                            <select name="content_type" id="content_type" class="form-control">
                                <option value="image" selected>تصویر</option>
                                <option value="html">متن/کد html</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="is_active" class="control-label">فعال / غیر فعال</label>
                            <select name="is_active" id="is_active" class="form-control">
                                <option value="1" selected>فعال</option>
                                <option value="0">غیر فعال</option>
                            </select>
                        </div>
                        <input type="hidden" name="configuration_id" id="configuration_id" value="{$smarty.get.config}">
                        <div class="form-group pull-right">
                            <button type="submit" class="fcbtn btn btn-info btn-outline btn-1b margin-top-23">ارسال</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="assets/JsFiles/configurations.js"></script>
{if $smarty.get.content_type == 'html'}
    <script>
        $(document).ready(function () {
            setCKEditor();
        });
    </script>
{/if}

{if $hasAccess eq false}
    <script>
        redirectToConfigurationPage('listContent');
    </script>
{/if}