{load_presentation_object filename="members" assign="objCounter"}
{load_presentation_object filename="agency" assign="objAgency"}
{$objCounter->showedit($smarty.get.id)}
{$objAgency->getCounterType()}
{load_presentation_object filename="agencyDepartments" assign="objAgencyDepart"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                {if $objsession->adminIsLogin()}
                    <li><a href="agencyList">همکاران</a></li>
                {else}
                    <li>کاربران</li>
                {/if}
                {if $smarty.server.REQUEST_URI|strstr:"counterEdit"}
                    {assign var="TypeMember" value="کانتر"}
                    {assign var="isMember" value="1"}
                    <li><a href="counterList&id={$smarty.get.agencyID}">کانترها</a></li>
                    <li class="active">ویرایش کانتر </li>
                {elseif $smarty.server.REQUEST_URI|strstr:"agencyManager/edit"}
                    {assign var="TypeMember" value="مدیر"}
                    {assign var="isMember" value="2"}
                    <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/agencyManager/list&id={$smarty.get.agencyID}">مدیران</a></li>
                    <li class="active">ویرایش مدیر </li>
                {/if}
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
                <h3 class="box-title m-b-0">ویرایش {$TypeMember} </h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید اطلاعات  {$TypeMember}  را در سیستم ویرایش نمائید</p>
                {if $objsession->adminIsLogin()}
                    {assign var="AgencyId" value=$smarty.get.agencyID}
                {else}
                    {assign var="AgencyId" value=$objsession->getAgencyId()}
                {/if}
                <form  id="Editcounter" method="post" autocomplete="off">
                    <input type="hidden" name="flag" id="flag" value="update_counter">
                    <input type="hidden" name="agency_id" id="agency_id" value="{$AgencyId}">
                    <input type="hidden" name="counter_id" id="counter_id" value="{$objCounter->list['id']}">
                    <input type="hidden" id="formType" value="{$TypeMember}">
                    <input type="hidden" name="is_member" id="is_member" value="{$isMember}">
                    <div class="form-group col-sm-6 ">
                        <label for="name" class="control-label">نام {$TypeMember}</label>
                        <input type="text" class="form-control" id="name" name="name"
                               placeholder="نام  {$TypeMember} را وارد نمائید" value="{$objCounter->list['name']}">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="family" class="control-label">نام خانوادگی {$TypeMember}</label>
                        <input type="text" class="form-control" id="family" name="family"
                               placeholder="نام خانوادگی {$TypeMember} را وارد نمائید" value="{$objCounter->list['family']}">

                    </div>
                    <div class="form-group col-sm-6">
                        <label for="family" class="control-label">نام انگلیسی</label>
                        <input type="text" class="form-control" id="name_en" name="name_en"
                               placeholder="نام انگلیسی را وارد نمائید" value="{$objCounter->list['name_en']}">

                    </div>
                    <div class="form-group col-sm-6">
                        <label for="family" class="control-label">نام خانوادگی انگلیسی</label>
                        <input type="text" class="form-control" id="family_en" name="family_en"
                               placeholder="نام خانوادگی انگلیسی را وارد نمائید" value="{$objCounter->list['family_en']}">

                    </div>
                    <div class="form-group col-sm-6">
                        <label for="mobile" class="control-label">نام کاربری</label>
                        <input type="text" class="form-control" id="mobile" name="mobile"
                               placeholder=" نام کاربری را وارد نمائید" value="{$objCounter->list['user_name']}" disabled='disabled'>

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="mobile" class="control-label">شماره تلفن همراه</label>
                        <input type="text" class="form-control" id="mobile" name="mobile" disabled='disabled'
                               placeholder=" شماره تلفن همراه {$TypeMember} را وارد نمائید" value="{$objCounter->list['mobile']}">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="mobile" class="control-label">تلفن ثابت</label>
                        <input type="text" class="form-control" id="telephone" name="telephone"
                               placeholder=" تلفن ثابت کاربر را وارد نمائید" value="{$objCounter->list['telephone']}" >

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="email" class="control-label">ایمیل {$TypeMember}</label>
                        <input type="text" class="form-control" id="email" name="email"
                               placeholder="ایمیل {$TypeMember} را وارد نمائید" value="{$objCounter->list['email']}"
                               data-required="false">

                    </div>
                    {if $smarty.server.REQUEST_URI|strstr:"counterEdit"}
                        <div class="form-group col-sm-6">
                            <label for="typeCounter" class="control-label">نوع کانتر </label>
                            <select class="form-control" name="typeCounter" id="typeCounter">
                                <option value="">انتخاب کنید...</option>
                                {foreach $objAgency->option as $option}

                                <option value="{$option.id}" {if $option.id eq $objCounter->list['fk_counter_type_id']} selected="selected"{/if}>{$option.name}</option>

                                {/foreach}
                            </select>
                        </div>
                    {/if}
                    <div class="form-group col-sm-6">
                        <label for="accessAdmin" class="control-label">دسترسی به ادمین </label>
                        <select class="form-control" name="accessAdmin" id="accessAdmin" data-required="false">
                            <option value="">انتخاب کنید...</option>
                            <option value="1" {if $objCounter->list['accessAdmin'] eq '1'}selected="selected"{/if} >بله </option>
                            <option value="0"{if $objCounter->list['accessAdmin'] eq '0'}selected="selected"{/if} >خیر </option>
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="password" class="control-label">کلمه عبور {$TypeMember}</label>
                        <input type="password" class="form-control" id="password" name="password"
                               placeholder="در صورتی که قصد تغییر کلمه عبور را ندارید دو فیلد کلمه عبور و تکرار آن را خالی رها نمائید">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="Confirm" class="control-label">تکرار کلمه عبور </label>
                        <input type="password" class="form-control" id="Confirm" name="Confirm"
                               placeholder="در صورتی که قصد تغییر کلمه عبور را ندارید دو فیلد کلمه عبور و تکرار آن را خالی رها نمائید">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="Department" class="control-label">فعالیت در واحد</label>
                        {assign var="main_depart" value=$objAgencyDepart->getAgencyDepart()}
                        <select name="id_departments" id="id_departments" class="form-control" data-required="false">
                            <option value="">-- انتخاب واحد --</option>
                            {foreach $main_depart as $depart}
                                <option value="{$depart.id}" {if $depart.id == $objCounter->list['id_departments']}selected{/if}>
                                    {$depart.title}
                                </option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group pull-right">
                                <button type="submit" class="btn btn-primary">ارسال اطلاعات</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="assets/JsFiles/counter.js"></script>
{literal}
    <script>
       $(document).ready(function() {
          // فیلدهایی که نمیخوای required باشند
          var fieldsToClean = [ "#id_departments", "#accessAdmin"];

          fieldsToClean.forEach(function(selector) {
             // اگر فرم validate شده، rule های jQuery Validate را حذف می‌کنیم
             if ($(selector).length && $(selector).rules) {
                $(selector).rules("remove"); // همه rule ها را پاک می کند
             }

             // حذف attribute HTML required اگر وجود دارد
             $(selector).removeAttr("required");
          });
       });
    </script>
{/literal}


