{load_presentation_object filename="configurations" assign="objConfig"}
{assign var="allConfigurations" value=$objConfig->getClientConfigurations($smarty.const.CLIENT_ID)}
{assign var="content" value=$objConfig->getClientContent($smarty.get.id)}
{assign var="configuration" value=$objConfig->getConfigurationById($content.configuration_id)}
{assign var="config_id" value=$smarty.get.config}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/configurations/listContent">تمامی محتوا</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/configurations/listContent?config={$content.configuration_id}">{$configuration.title}</a></li>
                <li><span>ویرایش محتوا</span></li>

            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">ویرایش محتوا </h3>
                <form id="editContent" action="/" method="post" class="row">
                    <input type="hidden" name="flag" id="flag" value="editClientContent">
                    <input type="hidden" name="id" id="id" value="{$content.id}">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label for="title" class="control-label">عنوان</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="عنوان را وارد کنید" value="{$content.title}">
                        </div>
                        <div class="form-group contnt-html {if $content.content_type eq 'image'}d-none{/if}">
                            <label for="content" class="control-label">محتوا</label>
                            <textarea name="content" id="content" rows="8" {if $content.content_type eq 'image'}required aria-required="true" {/if} class="form-control contnt-html">{$content.content}</textarea>
                        </div>
                        <div class="form-group contnt-image {if $content.content_type eq 'html'}d-none{/if}">
                            <label class="control-label" for="feature_image">تصویر شاخص </label>
                            <span class="help-block feedback">اندازه تصویر (800*158) </span>
                            <input type="file" name="feature_image" id="feature_image" class="dropify contnt-image" {if $config_id != 23}  data-height="158" data-max-height="159" data-width="800" data-max-width="801"  data-max-file-size="1M" {/if} data-default-file="{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}/gds/pic/{$content.image}"/>
                        </div>
                        <div class="form-group contnt-image {if $content.content_type eq 'html'}d-none{/if}">
                            <label for="link" class="control-label">لینک</label>
                            <input name="content" {if $content.content_type eq 'image'}required aria-required="true" {/if} id="link" type="url" class="form-control contnt-image" value="{$content.content}"/>
                        </div>
                    </div>
                    <div class="col-sm-4">

                        <div class="form-group">
                            <label for="content_type" class="control-label">نوع تبلیغ</label>
                            <select name="content_type" id="content_type" class="form-control">
                                <option value="image" {if $content.content_type eq 'image'} selected{/if}>تصویر</option>
                                <option value="html" {if $content.content_type eq 'html'} selected{/if}>متن/کد html</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="is_active" class="control-label">فعال / غیر فعال</label>
                            <select name="is_active" id="is_active" class="form-control">
                                <option value="1"  {if $content.is_active eq '1'}selected{/if}>فعال</option>
                                <option value="0"  {if $content.is_active eq '0'}selected{/if}>غیر فعال</option>
                            </select>
                        </div>

                        <input type="hidden" name="configuration_id" id="configuration_id" value="{$content.configuration_id}">
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
{if $content.content_type == 'html'}
    <script>
        $(document).ready(function () {
            setCKEditor();
        });
    </script>
{/if}
{*
{if $hasAccess eq false}
    <script>
        redirectToConfigurationPage('listContent');
    </script>
{/if}*}
