{load_presentation_object filename="configurations" assign="objConfig"}
{if $smarty.const.TYPE_ADMIN eq '1'}

{assign var="allConfigurations" value=$objConfig->getAllConfigurations()}
{assign var="service_groups" value=$objConfig->getAllServiceGroups()}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/configurations/listConfigurations">تمامی تنظیمات</a></li>
                <li><span> افزودن </span></li>

            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">افزودن کانفیگ  </h3>
                <form id="addConfiguration" action="/" method="post" class="row">
                    <div class="form-group col-sm-4">
                        <label for="title" class="control-label">عنوان</label>
                        <input type="text" class="form-control" id="title" placeholder="عنوان تنظیمات را وارد کنید">
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="title_en" class="control-label">عنوان انگلیسی</label>
                        <input type="text" class="form-control" id="title_en" placeholder="عنوان انگلیسی تنظیمات را وارد کنید">
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="service_group" class="control-label">نوع خدمات مربوطه</label>
                        <select name="service_group" id="service_group" class="form-control">
                            {foreach $service_groups as $service_group}
                                <option value="{$service_group.id}">{$service_group.Title}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group  pull-right">
                            <button type="submit" class="fcbtn btn btn-info btn-outline btn-1b margin-top-23">ارسال</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="assets/JsFiles/configurations.js"></script>
{/if}