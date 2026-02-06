{load_presentation_object filename="agency" assign="objAgency"}
{$objAgency->getCounterType()}

{if $objSession->IsLogin() and $objSession->getTypeUser() eq 'agency'}

    {assign var="profile" value=$objAgency->getAgency($objSession->getAgencyId())} {*گرفتن اطلاعات کاربر*}
    {assign var="agency_id" value=$objSession->getAgencyId()}
{*{$profile|var_dump}*}

    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`agencyMenu.tpl"}
    <div class="client-head-content">
        <div class="client-head-content_c_">
            <div class="d-none main-Content-top s-u-passenger-wrapper-change">
                {*<span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                     <i class="zmdi zmdi-account-box-mail zmdi-hc-fw mart10"></i>
                 </span>*}
                <div class="panel-default-change border-0">
                    <div class="s-u-result-item-change">
                        {{functions::StrReplaceInXml(["@@click@@"=>"<a href='http://{$smarty.const.CLIENT_MAIN_DOMAIN}/{$MainUrlAddress}' style='color:red'>##ClickHere##</a>"],"InformationNotMandatory")}}
                    </div>
                </div>
            </div>
            <div class="main-Content-top s-u-passenger-wrapper-change">
                <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                    <i class="zmdi zmdi-account-box-mail zmdi-hc-fw mart10"></i> ##AddNewCounter##
                </span>

                <div class="card border-light mb-4">
                    <div class="card-body py-3">
                        <p class="text-muted mb-0">
                            <i class="zmdi zmdi-assignment-check me-2"></i>
                            شما با استفاده از فرم زیر می‌توانید کانتر جدیدی را در سیستم ثبت نمائید
                        </p>
                    </div>
                </div>


                <div class="panel-default-change border-0">
                    <form class=" s-u-result-item-change" data-toggle="validator" id="CounterAgencyAdd" method="post">
                        <input type="hidden" value="insert_counter" name="flag">
                        <input type="hidden" id="agency_id" value="{$agency_id}" name="agency_id">
                        <div class="w-100">
                            <div class="parent-grids w-100">
                                <div class="s-u-passenger-item s-u-passenger-item-change">
                                    <label for="name" class="control-label">نام کانتر</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           placeholder="نام  کانتر را وارد نمائید">
                                </div>
                                <div class="s-u-passenger-item s-u-passenger-item-change ">
                                    <label for="family" class="control-label">نام خانوادگی کانتر</label>
                                    <input type="text" class="form-control" id="family" name="family"
                                           placeholder="نام خانوادگی کانتر را وارد نمائید">
                                </div>
                                <div class="s-u-passenger-item s-u-passenger-item-change">
                                    <label for="mobile" class="control-label">شماره تلفن همراه</label>
                                    <input type="text" class="form-control" id="mobile" name="mobile"
                                           placeholder=" شماره تلفن همراه کانتر را وارد نمائید">
                                </div>
                                <div class="s-u-passenger-item s-u-passenger-item-change">
                                    <label for="email" class="control-label">ایمیل کانتر</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                           placeholder="ایمیل کانتر را وارد نمائید" >
                                </div>
                            </div>
                        </div>
                        <div class="w-100">
                            <div class="parent-grids w-100">
                                <div class="s-u-passenger-item  s-u-passenger-item-change form-group">
                                    <label for="fk_counter_type_id" class="control-label">نوع کانتر </label>
                                    <select class="form-control" name="fk_counter_type_id" id="fk_counter_type_id">
                                        <option value="">انتخاب کنید...</option>
                                        {foreach $objAgency->option as $option}
                                            {if $option.id neq '5' }
                                                <option value="{$option.id}">{$option.name}</option>
                                            {/if}
                                        {/foreach}
                                    </select>
                                </div>
{*                                <div class="s-u-passenger-item  s-u-passenger-item-change form-group no-star">*}
{*                                    <label for="accessAdmin" class="control-label">دسترسی به ادمین </label>*}
{*                                    <select class="form-control" name="accessAdmin" id="accessAdmin">*}
{*                                        <option value="">انتخاب کنید...</option>*}
{*                                        <option value="1" >بله </option>*}
{*                                        <option value="0" >خیر </option>*}
{*                                    </select>*}
{*                                </div>*}

                                <input type="hidden" name="accessAdmin" value="0">

                                <div class="s-u-passenger-item s-u-passenger-item-change">
                                    <label for="password" class="control-label">کلمه عبور کانتر</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                           placeholder="کلمه عبور کانتر را وارد نمائید">
                                </div>
                                <div class="s-u-passenger-item s-u-passenger-item-change">
                                    <label for="Confirm" class="control-label">تکرار کلمه عبور </label>
                                    <input type="password" class="form-control" id="Confirm" name="Confirm"
                                           placeholder="تکرار رمز عبور">
                                </div>
                            </div>
                        </div>







                        <div class="userProfileInfo-btn userProfileInfo-btn-change">
                            <input class="s-u-select-flight-change site-secondary-text-color site-main-button-flat-color"
                                   type="submit" value="ارسال اطلاعات">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


{else}
    {$objFunctions->redirectOutAgency()}
{/if}