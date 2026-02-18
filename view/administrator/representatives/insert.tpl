{load_presentation_object filename="representatives" assign="obJRepresentatives"}
{assign var="getRepresentatives" value=$obJRepresentatives->getRepresentatives($smarty.get.id)}
{load_presentation_object filename="requestServiceStatus" assign="objStatus"}
{assign var="activityType" value=['agancy'=>'آژانس' ,'personal'=>'اشخاص حقیقی' ,'goverment'=>'ارگان دولتی' ,'privite'=>'شرکت خصوصی' ,'cooperative'=>'شرکت تعاونی' ]}
{assign var="countries" value=$obJRepresentatives->RepresentativesCountries()}
{*{assign var="cities" value=$obJRepresentatives->RepresentativesIranCities()}*}
{load_presentation_object filename="mainCity" assign="objCity"}
{load_presentation_object filename="reservationPublicFunctions" assign="objFunction"}


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
                    افزودن نمایندگی
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

        <form data-toggle="validator" method="post" id="add_representatives" enctype='multipart/form-data'>

            <div class="container">
                <h2>افزودن نمایندگی </h2>
                <p>ساخت نمایندگی جدید</p>
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
                                    <option value="{$value}">{$title}</option>
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
                        <td><input name="manager_name" value=""  ></td>
                    </tr>
                    <tr>
                        <td>نام شرکت / موسسه
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                            </span>
                        </td>
                        <td><input name="company_name" value="" ></td>
                    </tr>
                    <tr>
                        <td>نام انگلیسی شرکت / موسسه
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                            </span>
                        </td>
                        <td><input name="english_company_name" value="" ></td>
                    </tr>
                    <tr>
                        <td>تلفن
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                            </span>
                        </td>
                        <td><input name="phone_number" value="" ></td>
                    </tr>
                    <tr>
                        <td>موبایل
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                            </span>
                        </td>
                        <td><input name="mobile_number" value="" ></td>
                    </tr>
                    <tr>
                        <td>فکس
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                            </span>
                        </td>
                        <td><input name="fax_number" value="" ></td>
                    </tr>
                    <tr>
                        <td>ایمیل</td>
                        <td><input name="email" value="" ></td>
                    </tr>
                    <tr>
                        <td>سایت</td>
                        <td><input name="website" value="" ></td>
                    </tr>
                    <tr>
                        <td>کدپستی
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                            </span>
                        </td>
                        <td><input name="postal_code" value="" ></td>
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
                                    <option value='{$country.id}'>
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
                            <select name='province' id='province'>
                                <option value="">انتخاب کنید....</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>شهر
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                            </span>
                        </td>
                        <td><input name="city" value="" ></td>
                    </tr>
                    <tr>
                        <td>آدرس
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                            </span>
                        </td>
                        <td><input name="address" value="" ></td>
                    </tr>
                    {*
                    <tr>
                        <td>(Long)طول جغرافیایی </td>
                        <td><input name="long_p" value="" ></td>
                    </tr>
                    <tr>
                        <td>(Lat)عرض جغرافیایی </td>
                        <td><input name="lat_p" value="" ></td>
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
                                    <option  value='{$key}' >{$val}</option>
                                {/foreach}
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>عکس
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                            </span>
                        </td>
                        <td>
                            <input name='image' type='file'>
                        </td>
                    </tr>
{*                    <tr>*}
{*                        <td>فایل دریافتی</td>*}
{*                        {if $getRepresentatives['image'] neq ''}*}
{*                            <td><a href='{$getRepresentatives['image']}' target='_blank'><img src='assets/css/images/view_file.png' width='50' height='50'> </a></td>*}
{*                        {else}*}
{*                            <td>---</td>*}
{*                        {/if}*}
{*                    </tr>*}


                    </tbody>
                </table>

            </div>

            <input type="hidden" name="className" value="representatives">
            <input type="hidden" name="method" value="insertRepresentativesArray">
            <div class=' col-12 d-flex  align-items-center justify-content-center w-100 parentbtn-btn-fixed'>
                <button class="btn btn-success btn-block btn-fixed" type="submit" id="add_representatives">ذخیره</button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/representatives.js">
