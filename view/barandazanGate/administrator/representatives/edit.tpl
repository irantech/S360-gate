{load_presentation_object filename="representatives" assign="obJRepresentatives"}
{assign var="getRepresentatives" value=$obJRepresentatives->getRepresentatives($smarty.get.id)}
{load_presentation_object filename="requestServiceStatus" assign="objStatus"}
{assign var="activityType" value=['agancy'=>'آژانس' ,'personal'=>'اشخاص حقیقی' ,'goverment'=>'ارگان دولتی' ,'privite'=>'شرکت خصوصی' ,'cooperative'=>'شرکت تعاونی' ]}
{assign var="countries" value=$obJRepresentatives->RepresentativesCountries()}
{load_presentation_object filename="reservationPublicFunctions" assign="objFunction"}

{assign var="cities" value=$obJRepresentatives->RepresentativesCities($getRepresentatives['country'])}
{*{$getRepresentatives|var_dump}*}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">

                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/representatives/list">
                        لیست نمایندگی
                    </a>
                </li>
                <li class='active'>
                    جزییات نمایندگی
                    <span class='font-bold underdash'>{$getRepresentatives['company_name']}</span>
                </li>
            </ol>
        </div>
    </div>
    <style>
        .error {
            display: block;
            margin-top: 5px;
            margin-bottom: 10px;
            color: #db3835 !important;
        }
        span svg {
            width: 10px;
            height: 10px;
            fill: red;
        }
    </style>

    <div class="row representatives">

        <form data-toggle="validator" method="post" id="editRepresentatives" enctype='multipart/form-data'>

        <div class="container">
            <h2>جزییات نمایندگی {$getRepresentatives['company_name']}</h2>
            <p>همه اطلاعات ارسالی را در این قسمت مشاهده نمائید</p>
            <table class="table table-bordered request-table">
                <thead>
                <tr>
                    <th>عنوان</th>
                    <th>اطلاعات</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td> زبان
                        <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                            </span>
                    </td>
                    <td>
                        <select name="language"  id="language">
                            {foreach $languages as $value=>$title}
                                <option value="{$value}" {if $getRepresentatives['oLang'] == $value} selected{/if}>{$title}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>نام مدیر
                        <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                        </span>
                    </td>
                    <td><input name="manager_name" value="{if $getRepresentatives['manager_name']}{$getRepresentatives['manager_name']}{else}---{/if}" ></td>
                </tr>
                <tr>
                    <td>نام شرکت / موسسه
                        <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                        </span>
                    </td>
                    <td><input name="company_name" value="{if $getRepresentatives['company_name']}{$getRepresentatives['company_name']}{else}---{/if}" ></td>
                </tr>
                <tr>
                    <td>نام انگلیسی شرکت / موسسه
                        <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                        </span>
                    </td>
                    <td><input name="english_company_name" value="{if $getRepresentatives['english_company_name']}{$getRepresentatives['english_company_name']}{else}---{/if}" ></td>
                </tr>
                <tr>
                    <td>تلفن
                        <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                        </span>
                    </td>
                    <td><input name="phone_number" value="{if $getRepresentatives['phone_number']}{$getRepresentatives['phone_number']}{else}---{/if}" ></td>
                </tr>
                <tr>
                    <td>موبایل
                        <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                        </span>
                    </td>
                    <td><input name="mobile_number" value="{if $getRepresentatives['mobile_number']}{$getRepresentatives['mobile_number']}{else}---{/if}" ></td>
                </tr>
                <tr>
                    <td>فکس
                        <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                        </span>
                    </td>
                    <td><input name="fax_number" value="{if $getRepresentatives['fax_number']}{$getRepresentatives['fax_number']}{else}---{/if}" ></td>
                </tr>
                <tr>
                    <td>ایمیل</td>
                    <td><input name="email" value="{if $getRepresentatives['email']}{$getRepresentatives['email']}{else}---{/if}" ></td>
                </tr>
                <tr>
                    <td>سایت</td>
                    <td><input name="website" value="{if $getRepresentatives['website']}{$getRepresentatives['website']}{else}---{/if}" ></td>
                </tr>
                <tr>
                    <td>کدپستی
                        <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                        </span>
                    </td>
                    <td><input name="postal_code" value="{if $getRepresentatives['postal_code']}{$getRepresentatives['postal_code']}{else}---{/if}" ></td>
                </tr>
                <tr>
                    <td>کشور
                        <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                        </span>
                    </td>
                    <td>
                        <select name="country" id="country" onchange='FillComboCity2(this.value, "province")'>
                            <option value="">انتخاب کنید....</option>
                            {foreach $obJRepresentatives->RepresentativesCountries() as $country}
                                <option {if $getRepresentatives['country'] eq $country.id} selected {/if} value='{$country.id}'>
                                    {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                        {$country['name']}
                                    {else}
                                        {if $country['name_en'] }
                                            {$country['name_en']}
                                        {else}
                                            {$country['name']}
                                        {/if}
                                    {/if}
                                </option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>استان
                        <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                        </span>
                    </td>
                    <td>
                        <select name="province" id="province" class="">
                            {if $cities}
                                {foreach $cities as $item}
                                    <option {if $getRepresentatives['province'] eq $item.id} selected {/if} value='{$item.id}'>{$item['name']}</option>
                                {/foreach}
                            {/if}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>شهر
                        <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                        </span>
                    </td>
                    <td><input name="city" value="{if $getRepresentatives['city']}{$getRepresentatives['city']}{else}---{/if}" ></td>
                </tr>
                <tr>
                    <td>آدرس
                        <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                        </span>
                    </td>
                    <td><input name="address" value="{if $getRepresentatives['address']}{$getRepresentatives['address']}{else}---{/if}" ></td>
                </tr>
                {*
                <tr>
                    <td>(Long)طول جغرافیایی </td>
                    <td><input name="long_p" value="{if $getRepresentatives['long_p']}{$getRepresentatives['long_p']}{else}---{/if}" ></td>
                </tr>
                <tr>
                    <td>(Lat)عرض جغرافیایی </td>
                    <td><input name="lat_p" value="{if $getRepresentatives['lat_p']}{$getRepresentatives['lat_p']}{else}---{/if}" ></td>
                </tr>
                *}
                <tr>
                    <td>رده شغلی
                        <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                        </span>
                    </td>
                    <td>
                        <select name='activity_type'>
                            <option value=''>انتخاب</option>
                            {foreach $activityType as $key => $val}
                                <option {if $getRepresentatives['activity_type'] eq $key} selected {/if} value='{$key}' >{$val}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>فایل دریافتی
                        <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                        </span>
                    </td>

                    <td>
                        {if $getRepresentatives['image'] neq ''}
                        <a href='{$getRepresentatives['image']}' target='_blank' title='مشاهده فایل'>
                            <img src='assets/css/images/view_file.png' width='50' height='50'>
                        </a>
                        {else}
                            ---
                        {/if}
                        <button type='button' onclick="uploadFileRepresentatives()" class='btn btn-primary'>آپلود فایل</button>
                            <div class="form-group show-file" style='display: none;'>
                                <br>
                                <input type="file" name="image" id="image" class="dropify" data-height="100" value='{$getRepresentatives['image']}'
                                       data-default-file="{$getRepresentatives['image']}"/>
                            </div>
                    </td>

                    <script>
                      function uploadFileRepresentatives() {
                        $(".show-file").show();  // To show
                      }
                    </script>



                </tr>

                </tbody>
            </table>

        </div>

            <input type="hidden" name="className" value="representatives">
            <input type="hidden" name="method" value="updateRepresentatives">
            <input type="hidden" name="request_id" value="{$getRepresentatives.sId}">
            <input type="hidden" name="representatives_id" value="{$getRepresentatives.oId}">


            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">
                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>نتیجه بررسی ادمین</h4>
                        </div>

                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="created_at">تاریخ ثبت این نمایندگی</label>
                                <input type="text" class="form-control" name="created_at" id="created_at"
                                       disabled value="{$getRepresentatives.created_at}">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="status_id">وضعیت نمایندگی</label>
                                <select  value="{$getRepresentatives.status}" name="status_id" id="status_id" class="form-control select2">
                                    <option value="">انتخاب کنید</option>
                                    {foreach $objStatus->getRequestServiceStatusList() as $status}
                                        <option value="{$status['id']}"  {if $getRepresentatives['status']==$status['value']} selected{/if} {if $status['value']=='seen' || $status['value']=='not_seen'} disabled="disabled"{/if}>{$status['title']}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="admin_response">یادداشت ادمین </label>
                                <textarea name="admin_response" class="form-control" id="admin_response"
                                          placeholder="یادداشت ادمین">{$getRepresentatives['admin_response']}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class=' col-12 d-flex  align-items-center justify-content-center w-100 parentbtn-btn-fixed'>
                <button class="btn btn-success btn-block btn-fixed" type="submit" id="submit-button">ذخیره</button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/representatives.js">
