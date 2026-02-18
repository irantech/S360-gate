{if $smarty.const.TYPE_ADMIN eq 1}
{load_presentation_object filename="settingCore" assign="settingCore"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/userCore/listAgencyCore">لیست آژانس - سرور</a></li>
                <li class="active">ثبت سرور برای آژانس</li>

            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>

        <!-- /.col-lg-12 -->
    </div>


        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">ثبت سرور برای آژانس به سیستم Core</h3>

                    <form id="insertSourceAgency" method="post">
                        <input type="hidden" name="Method" value="insertSourceAgency">
                        <input type="hidden" name="flag" value="insertSourceAgency">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="name" class="control-label">نام آژانس</label>
                                    <select class="form-control select2" name="agencyId" id="agencyId" >
                                        <option value="">انتخاب کنید...</option>
                                        {foreach $settingCore->ListAgency() as $agency}
                                            <option value="{$agency['id']}">{$agency['name']}</option>
                                        {/foreach}
                                    </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="sourceId" class="control-label">نام سرور</label>
                                <select class="form-control" name="sourceId" id="sourceId" >
                                    <option value="">انتخاب کنید...</option>
                                    {foreach $settingCore->ListServer() as $agency}
                                        <option value="{$agency['id']}">{$agency['name_fa']}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="webServiceType" class="control-label">انتخاب اشتراکی یا اختصاصی بودن وب سرویس</label>
                                <select class="form-control" name="webServiceType" id="webServiceType"  onclick="SetInfoSource()">
                                    <option value="">انتخاب کنید...</option>
                                    <option value="public">اشتراکی</option>
                                    <option value="private">اختصاصی (این گزینه انتخاب نشود ، فقط در مواقع خاص با هماهنگی فنی اگر انتخاب شود نتیجه قطع خواهد شد)</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="userName" class="control-label">نام کاربری</label>
                                <input type="text" class="form-control" id="userName" name="userName"
                                       placeholder="نام کاربری را وارد نمائید">

                            </div>
                            <div class="form-group col-sm-6">
                                <label for="password" class="control-label">کلمه عبور</label>
                                <input type="text" class="form-control" id="password" name="password"
                                       placeholder="کلمه عبور را وارد نمائید">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="token" class="control-label">توکن</label>
                                <input type="text" class="form-control" id="token" name="token"
                                       placeholder="توکن را در صورت لزوم وارد نمائید">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="isActiveInternal" class="control-label">فعال بودن داخلی</label>
                                <select class="form-control" name="isActiveInternal" id="isActiveInternal">
                                    <option value="">انتخاب کنید...</option>
                                    <option value="1">فعال</option>
                                    <option value="0">غیر فعال</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="isActiveExternal" class="control-label">فعال بودن خارجی</label>
                                <select class="form-control" name="isActiveExternal" id="isActiveExternal">
                                    <option value="">انتخاب کنید...</option>
                                    <option value="1">فعال</option>
                                    <option value="0">غیر فعال</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group  pull-right">
                                        <img src="assets/plugins/images/load21.gif" class="LoaderPayment"
                                             id="loadingbank">
                                        <button type="submit" class="fcbtn btn btn-info btn-outline btn-1b margin-top-23" id="btnbank">ارسال</button>
                                    </div>
                                </div>
                            </div>
                    </form>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
</div>

<script type="text/javascript" src="assets/JsFiles/core.js"></script>
{/if}


