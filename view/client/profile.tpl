
{load_presentation_object filename="user" assign="objUser"}
{if $objSession->IsLogin()}
{assign var="profile" value=$objUser->getProfileGds({$objSession->getUserId()})} {*گرفتن اطلاعات کاربر*}
{assign var="country_name" value=$objUser->getCountryName({$profile['passport_country_id']})}
{assign var="check_is_counter" value=$objUser->checkIsCounter() }
{assign var="userid" value=$objSession->getUserId()}

<main>
    <section class="profile_section mt-3 mb-3 row">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 position-static">
                    <div class="menu-profile-ris d-lg-none">
                        <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/{$MainUrlAddress}" class="logo_img"><img src='{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$smarty.const.CLIENT_LOGO}' alt='logo'></a>
                        <button onclick="openMenuProfile()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M0 88C0 74.75 10.75 64 24 64H424C437.3 64 448 74.75 448 88C448 101.3 437.3 112 424 112H24C10.75 112 0 101.3 0 88zM0 248C0 234.7 10.75 224 24 224H424C437.3 224 448 234.7 448 248C448 261.3 437.3 272 424 272H24C10.75 272 0 261.3 0 248zM424 432H24C10.75 432 0 421.3 0 408C0 394.7 10.75 384 24 384H424C437.3 384 448 394.7 448 408C448 421.3 437.3 432 424 432z"/></svg></button>
                    </div>
                    <div onclick="closeMenuProfile()" class="bg-black-profile-ris d-lg-none"></div>
                    <div class="box-style sticky-100">
                        {include file="./profileSideBar.tpl"}
                    </div>
                </div>
                <div class="col-lg-9">
                    {include file="./profileHead.tpl"}
                    <div class="alert_msg" id="messageA{$i}"></div>
                        <form class=" s-u-result-item-change" data-toggle="validator" id="UpdateUserProfile" method="post">
                            <input type="hidden" value="UpdateUserProfile" name="flag" >
                        <div class="box-style">
                        <div class="box-style-padding">
                            <h2 class="title">##EditProfileInfo##</h2>
                            <div class="d-flex justify-content-between align-items-center">
                                {*
                                <span class='d-flex align-items-center'>
                                {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                    {$register_date = $objFunctions->DateJalali($profile['register_date'])}
                                {else}
                                    {$register_date = date('Y-m-d',strtotime($profile['register_date']))}
                                {/if}

                                ##Setupdate##: <span class='s-u-passenger-date d-flex mr-2'>{$register_date}</span>
                            </span>
                            *}
                                <div class="change-Password-btn__parent d-block d-lg-none">
                                    <a onclick="profileChangePassword({$profile['id']})" class="change-Password-btn">##ChangePassword##</a>
                                </div>
                            </div>
                            <div class="userInformation-header">
                                <div class="userInformation-header-gender">
                                    <div class="form-groupNew">
                                        <input {if $profile['gender'] eq 'Male'} checked="checked" {/if} name="gender" value="male" type="radio" id="male">
                                        <label for="male">##Sir##</label>
                                    </div>
                                    <div class="form-groupNew">
                                        <input {if $profile['gender'] eq 'Female'} checked="checked" {/if} name="gender" value="female" type="radio" id="female">
                                        <label for="female">##Lady##</label>
                                    </div>

                                </div>
                                <div class="origin">
                                    <div class="profile_dropdown_custom">
                                        <button type="button">
                                            {if $profile['national_type'] eq 'IR'}
                                            <span class='Iranian'>##Iranian##</span>
                                            {elseif $profile['national_type'] eq 'NO_IR'}
                                                <span class='NoIranian'>##Noiranian##</span>
                                            {else}
                                                <span class='Iranian'>##Iranian##</span>
                                            {/if}

                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M360.5 217.5l-152 143.1C203.9 365.8 197.9 368 192 368s-11.88-2.188-16.5-6.562L23.5 217.5C13.87 208.3 13.47 193.1 22.56 183.5C31.69 173.8 46.94 173.5 56.5 182.6L192 310.9l135.5-128.4c9.562-9.094 24.75-8.75 33.94 .9375C370.5 193.1 370.1 208.3 360.5 217.5z"/></svg>
                                        </button>
                                        <div>
                                            <div>
                                                <button type="button" name="IR" onclick="dropdown_custom_btn(event.target)" {if $profile['national_type'] eq 'IR'} class="active" {/if}>##Iranian##</button>
                                                <button type="button" name="NO_IR" onclick="dropdown_custom_btn(event.target)" {if $profile['national_type'] eq 'NO_IR'} class="active" {/if}>##Noiranian##</button>
                                                {if $profile['national_type']}
                                                <input type="hidden" name="national_type" id="national_type" value="{$profile['national_type']}" >
                                                {else}
                                                <input type="hidden" name="national_type" id="national_type" value="IR" >
                                                {/if}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="change-Password-btn__parent d-none d-lg-block">
                                    <a onclick="profileChangePassword(event.currentTarget , {$profile['id']})" class="change-Password-btn position-relative">
                                        ##ChangePassword##
                                        <div class="bouncing-loader bouncing-loader-none">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="form-profile">
                                <label class="label_style">
                                    <span class="d-flex justify-content-between align-items-center w-100">
                                        ##NameFaProfile##
                                        <span class='star'>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                                        </span>
                                    </span>
                                    <input type="text" name="name" id="name" onkeypress=" return persianLetters(event, 'name')" value="{$profile['name']}" placeholder="##NameFaProfile##">
                                </label>
                                <label class="label_style">
                                    <span class="d-flex justify-content-between align-items-center w-100">
                                        ##FamilyFaProfile##
                                        <span class='star'>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                                        </span>
                                    </span>
                                    <input type="text" name="family" id="family" onkeypress=" return persianLetters(event, 'family')" value="{$profile['family']}" placeholder="##FamilyFaProfile##">
                                </label>
                                <label class="label_style">
                                    <span>##NameEnProfile##</span>
                                    <input type="text" name="name_en" id="name_en" onkeypress="return isAlfabetKeyFields(event, 'name_en')" value="{$profile['name_en']}" placeholder="##NameEnProfile##">
                                </label>
                                <label class="label_style">
                                     <span>##FamilyEnProfile##</span>
                                    <input type="text" name="family_en" id="family_en" onkeypress="return isAlfabetKeyFields(event, 'family_en')" value="{$profile['family_en']}" placeholder="##FamilyEnProfile##">
                                </label>
                            </div>
                        </div>
                    </div>
                            {*
                    <div class="box-style">
                        <div class="box-style-padding">
                            <h2 class="title">##TravelInformation##</h2>
                            <div class="form-profile">
                                <label class="label_style nationalNumber_label_profile">
                                    <span>##Nationalnumber##</span>
                                    <input type="text" name="national_code" id="national_code" onkeyup="return checkNumber(event, 'national_code')" maxlength="10" value="{$profile['national_code']}" placeholder="##Nationalnumber##">
                                </label>
                                <div class="label_style  country_label_profile">
                                    <span>##PassportIssuingCountry##</span>
                                    <div class="calender_profile calender_profile_grid_1">
                                        <div>
                                            <select id="passport_country_id" name="passport_country_id" placeholder="##Day##" class="select2">
                                                <option value=''>انتخاب کنید</option>
                                                {foreach $objFunctions->CountryCodes() as $Country}
                                                    <option {if $profile['passport_country_id'] == $Country['id'] } selected {/if}   value="{$Country['id']}">{$Country['titleFa']}</option>
                                                {/foreach}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="label_style nationalNumber_label_profile">
                                    <span>##DateOfBirth##</span>
                                    <div class="calender_profile">
                                        <div>
                                            <select id="birth_day_ir" name="birth_day_ir" placeholder="##Day##" class="select2">
                                                <option value='0'>روز</option>
                                                {for $day = 1 to 31}
                                                    <option {if $profile['birth_day_ir'] == $day } selected {/if} value="{$day}" data-id="{$day}">{$day}</option>
                                                {/for}
                                            </select>
                                        </div>
                                        <div>
                                            <select id="birth_month_ir" name="birth_month_ir" placeholder="##Month##" class="select2">
                                                <option value='0'>ماه</option>
                                                {foreach $objUser->monthsPersian() as $key => $value}
                                                    <option {if $profile['birth_month_ir'] == $value } selected {/if} value="{$value}" data-id="{$key}">{$value}</option>
                                                {/foreach}
                                            </select>
                                        </div>
                                        <div>
                                            <select id="birth_year_ir" name="birth_year_ir" placeholder="##Year##" class="select2">
                                                <option value='0'>سال</option>
                                                {foreach $objUser->yearsPersian() as $key => $value}
                                                    <option {if $profile['birth_year_ir'] == $value } selected {/if} value="{$value}" data-id="{$key}">{$value}</option>
                                                {/foreach}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="label_style country_label_profile">
                                    <span>##DateOfBirth##</span>
                                    <div class="calender_profile">
                                        <div>
                                            <select id="birth_day_miladi" name="birth_day_miladi" placeholder="##Day##" class="select2">
                                                <option value='0'>روز</option>
                                                {for $day = 1 to 31}
                                                    <option {if $profile['birth_day_miladi'] == $day } selected {/if} value="{$day}" data-id="{$key}">{$day}</option>
                                                {/for}
                                            </select>
                                        </div>
                                        <div>
                                            <select id="birth_month_miladi" name="birth_month_miladi" placeholder="##Month##" class="select2">
                                                <option value='0'>ماه</option>
                                                {foreach $objUser->monthsMiladi() as $key => $value}
                                                    <option {if $profile['birth_month_miladi'] == $value } selected {/if} value="{$value}" data-id="{$key}">{$value}</option>
                                                {/foreach}
                                            </select>
                                        </div>
                                        <div>
                                            <select id="birth_year_miladi" name="birth_year_miladi" placeholder="##Year##" class="select2">
                                                <option value='0'>سال</option>
                                                {foreach $objUser->yearsMiladi() as $key => $value}
                                                    <option {if $profile['birth_year_miladi'] == $value } selected {/if} value="{$value}" data-id="{$key}">{$value}</option>
                                                {/foreach}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <label class="label_style">
                                    <span>##PassportNumber## <span class="nationalNumber_label_profile">( ##ForeignFlight## )</span></span>
                                    <input type="text" id="passport_number" name="passport_number" value="{$profile['passport_number']}" maxlength="10"  onkeypress="return isAlfabetNumberKeyFields(event, 'passportNumberA{$i}')" placeholder="شماره گذرنامه (##optional##)">
                                </label>
                                <div class="label_style nationalNumber_label_profile">
                                    <span>##PassportExpiration## ( ##ForeignFlight## )</span>
                                    <div class="calender_profile">
                                        <div>
                                            <select id="expire_day_ir" name="expire_day_ir" placeholder="##Day##" class="select2">
                                                <option value='0'>روز</option>
                                                {for $day = 1 to 31}
                                                    <option {if $profile['expire_day_ir'] == $day } selected {/if} value="{$day}" >{$day}</option>
                                                {/for}
                                            </select>
                                        </div>

                                        <div>
                                            <select id="expire_month_ir" name="expire_month_ir" placeholder="##Month##" class="select2">
                                                <option value='0'>ماه</option>
                                                {foreach $objUser->monthsPersian() as $key => $value}
                                                    <option {if $profile['expire_month_ir'] == $value } selected {/if} value="{$value}" data-id="{$key}">{$value}</option>
                                                {/foreach}
                                            </select>
                                        </div>

                                        <div>
                                            <select id="expire_year_ir" name="expire_year_ir" placeholder="##Year##" class="select2">
                                                <option value='0'>سال</option>
                                                {foreach $objUser->yearsPersianExpire() as $key => $value}
                                                    <option {if $profile['expire_year_ir'] == $value } selected {/if} value="{$value}" data-id="{$value}">{$value}</option>
                                                {/foreach}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="label_style country_label_profile">
                                    <span>##PassportExpiration##</span>
                                    <div class="calender_profile">
                                        <div>
                                            <select id="expire_day_miladi" name="expire_day_miladi" placeholder="##Day##" class="select2">
                                                <option value='0'>روز</option>
                                                {for $day = 1 to 31}
                                                    <option {if $profile['expire_day_miladi'] == $day } selected {/if} value="{$day}" data-id="{$day}">{$day}</option>
                                                {/for}
                                            </select>
                                        </div>
                                        <div>
                                            <select id="expire_month_miladi" name="expire_month_miladi" placeholder="##Month##" class="select2">
                                                <option value='0'>ماه</option>
                                                {foreach $objUser->monthsMiladi() as $key => $value}
                                                    <option {if $profile['expire_month_miladi'] == $value } selected {/if} value="{$value}" data-id="{$key}">{$value}</option>
                                                {/foreach}
                                            </select>
                                        </div>
                                        <div>
                                            <select id="expire_year_miladi" name="expire_year_miladi" placeholder="##Year##" class="select2">
                                                <option value='0'>سال</option>
                                                {foreach $objUser->yearsMiladiExpire() as $key => $value}
                                                    <option {if $profile['expire_year_miladi'] == $value } selected {/if} value="{$value}" data-id="{$value}">{$value}</option>
                                                {/foreach}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    *}
                    <div class="box-style">
                        <div class="box-style-padding">
                            <h2 class="title">##OsafarContactsInformation##</h2>
                            <div class="form-profile">
                                <label class="label_style">
                                    <span class="d-flex justify-content-between align-items-center w-100">
                                        ##UserName##
                                        <span class='star'>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                                        </span>
                                    </span>
                                    <input type="text" name="user_name" id="user_name" value="{$profile['user_name']}" disabled="disabled" onkeyup="return checkNumber(event, 'mobile')" placeholder="##MobileNumber##" style='color: #a49e9e; background-color: #f0ecec;'>
                                </label>
                                <label class="label_style">
                                    <span class="d-flex justify-content-between align-items-center w-100">
                                        ##MobileNumber##
                                        <span class='star'>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                                        </span>
                                    </span>
                                    <input type="text" name="mobile" id="mobile" value="{$profile['mobile']}" disabled="disabled" onkeyup="return checkNumber(event, 'mobile')" placeholder="##MobileNumber##" style='color: #a49e9e; background-color: #f0ecec;'>
                                </label>
                                <label class="label_style">
                                    <span class="d-flex justify-content-between align-items-center w-100">
                                        ##Phone##
                                        <span class='star'>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                                        </span>
                                    </span>
                                    <input type="text" name="telephone" id="telephone" value="{$profile['telephone']}"  onkeyup="return checkNumber(event, 'telephone')" placeholder="##Phone##">
                                </label>
                                <label class="label_style">
                                    <span>##Email##</span>
                                    <input type="text" name="email" id="email" value="{$profile['email']}"   class='disabled' placeholder="ایمیل">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="box_btn">
                        <button  type="submit" >##SaveData##</button>
                    </div>

                    </form>

                </div>
            </div>
        </div>
    </section>
</main>
<div id="html_modal_change_password"></div>
{literal}

    <script src="assets/js/profile.js"></script>
    <script type="text/javascript">
      function profileChangePassword(currentTarget , member_id) {
        $(currentTarget).children('.bouncing-loader').removeClass("bouncing-loader-none")
        $.post(libraryPath + 'ModalCreatorProfile.php', {
            Method: 'ModalShowChangePassword',
            passenger_id: member_id
          },
          function (data) {
            $("#html_modal_change_password").html(data);
            $(currentTarget).children('.bouncing-loader').addClass("bouncing-loader-none")
          });
      }






      $(document).ready(function() {
        $('body').on('click' ,'.submitChangePasswordProfile' , function (event) {
          let currentTarget = $(event.currentTarget)
          var thiss=$(this);
          // thiss.removeClass('submitChangePasswordProfile').addClass('disabled');
          console.log('runing');
          var form = $("#memberChangePassword");
          var url = form.attr("action");
          var formData = $(form).serializeArray();
          var formArray = {};
          $.each(formData, function() {
            formArray[this.name] = this.value;
          });
          var oldpass = formArray['old_pass'];
          var newpass = formArray['new_pass'];
          var confpass = formArray['con_pass'];
          if (oldpass == "" || newpass == "" || confpass == "") {
            $.alert({
              title: useXmltag("Changpassword"),
              icon: 'fa fa-trash',
              content: useXmltag("Pleaseenterrequiredfields"),
              rtl: true,
              type: 'red',
            });
          } else if (newpass.length < 8 || confpass.length < 8) {
            $.alert({
              title: useXmltag("Changpassword"),
              icon: 'fa fa-trash',
              content: useXmltag("NumberCharactersPasswordNoLessEight"),
              rtl: true,
              type: 'red'
            });
          } else {
            currentTarget.children('.bouncing-loader').removeClass("bouncing-loader-none")
            $.post(amadeusPath + 'user_ajax.php',
              {
                old_pass: oldpass,
                new_pass: newpass,
                conf_pass: confpass,
                flag: 'ChangePass'
              },
              function (data) {
                console.log(currentTarget.children('.bouncing-loader').addClass("bouncing-loader-none"))
                var res = data.split(':');
                if (data.indexOf('success') > -1) {
                  $.alert({
                    title: useXmltag("Changpassword"),
                    icon: 'fa fa-trash',
                    content: res[1],
                    rtl: true,
                    type: 'green',
                  });
                  setTimeout(function () {
                    $('#memberChangePassword')[0].reset();
                  }, 1000);
                  setTimeout(function() {
                    location.reload()
                  }, 2000);
                } else {
                  $.alert({
                    title: useXmltag("Changpassword"),
                    icon: 'fa fa-trash',
                    content: res[1],
                    rtl: true,
                    type: 'red',
                  });
                }
              });
          }
        });
      });




    </script>
{/literal}

{else}
    {$objUser->redirectOut()}
{/if}
