{load_presentation_object filename="settingCore" assign="objsettingCore"}
{assign var="infoSourceAgency" value=$objsettingCore->infoSourceAgency($smarty.get.agencyId,$smarty.get.sourceId)}
{assign var="Agency" value=$objsettingCore->listAgencyById($smarty.get.agencyId)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/userCore/listAgencyCore">لیست آژانس - سرور</a></li>
                <li class="active"> ویرایش سرور برای آژانس</li>
                <li>{$Agency['name']}</li>

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
                <h3 class="box-title m-b-0">ثبت سرور برای آژانس به سیستم Core</h3>

                <form id="editSourceAgency" method="post">
                    <input type="hidden" name="Method" value="editSourceAgency">
                    <input type="hidden" name="flag" value="editSourceAgency">
                    <input type="hidden" name="agencyId" value="{$smarty.get.agencyId}">
                    <input type="hidden" name="sourceId" value="{$smarty.get.sourceId}">


                    <div class="form-group col-sm-6">
                        <label for="userName" class="control-label">نام کاربری</label>
                        <input type="text" class="form-control" id="userName" name="userName"
                               placeholder="نام کاربری را وارد نمائید" value="{$infoSourceAgency['userName']}">

                    </div>


                    <div class="form-group col-sm-6">
                        <label for="password" class="control-label">کلمه عبور</label>
                        <input type="text" class="form-control" id="password" name="password"
                               placeholder="کلمه عبور را وارد نمائید" value="{$infoSourceAgency['password']}">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="token" class="control-label">توکن</label>
                        <input type="text" class="form-control" id="token" name="token"
                               placeholder="توکن را در صورت لزوم وارد نمائید" value="{$infoSourceAgency['token']}">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="isActiveInternal" class="control-label">فعال بودن داخلی</label>
                        <select class="form-control" name="isActiveInternal" id="isActiveInternal">
                            <option value="">انتخاب کنید...</option>
                            <option value="1" {if $infoSourceAgency['isActiveInternal'] eq '1'}selected{/if}>فعال
                            </option>
                            <option value="0" {if $infoSourceAgency['isActiveInternal'] eq '0'}selected{/if}>غیر فعال
                            </option>
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="EqAmount" class="control-label">فعال بودن خارجی</label>
                        <select class="form-control" name="isActiveExternal" id="isActiveExternal">
                            <option value="">انتخاب کنید...</option>
                            <option value="1" {if $infoSourceAgency['isActiveExternal'] eq '1'}selected{/if}>فعال
                            </option>
                            <option value="0" {if $infoSourceAgency['isActiveExternal'] eq '0'}selected{/if}>غیر فعال
                            </option>
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="webServiceType" class="control-label">انتخاب اشتراکی یا اختصاصی بودن وب سرویس</label>
                        <select class="form-control" name="webServiceType" id="webServiceType">
                            <option value="">انتخاب کنید...</option>
                            <option value="public" {if $infoSourceAgency['webServiceType'] eq 'public'}selected{/if}>اشتراکی</option>
                            <option value="private" {if $infoSourceAgency['webServiceType'] eq 'private'}selected{/if}>اختصاصی (این گزینه انتخاب نشود ، فقط در مواقع خاص با هماهنگی فنی اگر انتخاب شود نتیجه قطع خواهد شد)</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group  pull-right">
                                <img src="assets/plugins/images/load21.gif" class="LoaderPayment"
                                     id="loadingbank">
                                <button type="submit" class="fcbtn btn btn-info btn-outline btn-1b margin-top-23"
                                        id="btnbank">ارسال
                                </button>
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

