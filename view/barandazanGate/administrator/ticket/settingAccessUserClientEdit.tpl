{load_presentation_object filename="settingAccessUserClientList" assign="objAccess"}
{$objAccess->ShowAccess($smarty.get.id,$smarty.get.ClientId)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="flyAppClient">مشتریان نرم افزار پرواز</a></li>
                <li>تنظیمات</li>
                <li class="active">تنظیمات دسترسی</li>
                <li class="">{$objFunctions->ClientName($smarty.get.ClientId)}</li>
            </ol>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>

        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <h3 class="box-title m-b-0">ویرایش تنطیمات دسترسی</h3>
                <p class="text-muted m-b-30">با استفاده از فرم زیر میتوانید دسترسی مورد نظر را  ویرایش نمائید </p>

                <form data-toggle="validator" id="EditAccess" method="post">
                    <input type="hidden" name="flag"  id="flag" value="EditAccessNew">
                    <input type="hidden" name="ClientId" id="ClientId" value="{$smarty.get.ClientId}">
                    <input type="hidden" name="id" id="id" value="{$smarty.get.id}">

                    <div class="form-group col-sm-6">
                        <label for="ServiceId" class="control-label">نام سرویس </label>
                        <select class="form-control " name="ServiceId" id="ServiceId" onchange="SelectServiceForSource(this)">
                            <option value=""> انتخاب کنید...</option>
                            {foreach $objAccess->ServiceList() as $Service}
                            <option value="{$Service['id']}" {if $objAccess->ShowEdit['ServiceId'] eq $Service['id']} selected="selected"{/if}>{$Service['Title']}</option>
                            {/foreach}
                        </select>
                    </div>
{*$objAccess->SourceEdit($objAccess->ShowEdit['ServiceId'])|print_r*}
                    <div class="form-group col-sm-6">
                        <label for="SourceId" class="control-label">نام منبع </label>
                        <select class="form-control " name="SourceId" id="SourceId">
                            {foreach $objAccess->SourceEdit($objAccess->ShowEdit['ServiceId']) as $source}
                            <option value="{$source['id']}" {if $objAccess->ShowEdit['SourceId'] eq $source['id']}selected="selected"{/if}>{$source['Title']}</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="Username" class="control-label">نام کاربری وب سرویس  </label>
                        <input type="text" class="form-control" id="Username" name="Username"
                               placeholder="نام کاربری" value="{$objAccess->ShowEdit['Username']}">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="Password" class="control-label">رمز عبور وب سرویس </label>
                        <input type="text" class="form-control" id="Password" name="Password"
                               placeholder="رمز عبور" value="{$objAccess->ShowEdit['Password']}">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="Username" class="control-label">آدرس وب سرویس </label>
                        <input type="text" class="form-control" id="ApiUrl" name="ApiUrl"
                               placeholder="آدرس وب سرویس" value="{$objAccess->ShowEdit['ApiUrl']}">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="ApiKey" class="control-label">کلید تبادل یا آیدی وب سرویس </label>
                        <input type="text" class="form-control" id="ApiKey" name="ApiKey"
                               placeholder="کلید تبادل یا آیدی وب سرویس" value="{$objAccess->ShowEdit['ApiKey']}">
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">ارسال اطلاعات</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript" src="assets/JsFiles/settingAccessUserClient.js"></script>

