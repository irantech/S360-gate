{load_presentation_object filename="agency" assign="objAgency"}
{load_presentation_object filename="banks" assign="objBanks"}
{$objAgency->getCounterType()}
{$objAgency->showedit($smarty.get.id)}

{assign var="allCities" value=$objFunctions->cityIataList()}
{assign var="bank_list" value=$objBanks->getBankList()}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-3 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="agencyList">همکاران</a></li>
                <li class="active">ویرایش همکار</li>
            </ol>
        </div>
        <div class="col-lg-6 col-sm-3 col-md-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>

        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">{if $smarty.get.type eq 'acceptWhiteLabel'}مشاهده{else}ویرایش{/if}
                    همکار </h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید همکار مورد نظر را در سیستم ویرایش
                    نمائید</p>

                <form id="EditAgency" method="post">
                    <input type="hidden" name="flag" value="update_agency">
                    <input type="hidden" name="edit_id" value="{$smarty.get.id}">
                    {if $smarty.get.type eq 'acceptWhiteLabel'}
                        <input type="hidden" name="type_edit" id="type_edit" value="{$smarty.get.type}">
                    {/if}
                    <div class="row">
                        <div class="form-group col-sm-3 ">
                            <label for="nameFa" class="control-label">نام همکار</label>
                            <input type="text" class="form-control" id="nameFa" name="nameFa"
                                   placeholder="نام  آژانس را وارد نمائید" value="{$objAgency->edit['name_fa']}">
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="nameEn" class="control-label">نام لاتین همکار</label>
                            <input type="text" class="form-control" id="nameEn" name="nameEn"
                                   placeholder="نام لاتین آژانس را وارد نمائید" value="{$objAgency->edit['name_en']}">

                        </div>


                        <div class="form-group col-sm-3">
                            <label for="accountant" class="control-label">نام حسابدار</label>
                            <input type="text" class="form-control" id="accountant" name="accountant"
                                   placeholder="نام حسابدار را وارد نمائید" value="{$objAgency->edit['accountant']}">

                        </div>

                        <div class="form-group col-sm-3">
                            <label for="manager" class="control-label">نام مدیر عامل </label>
                            <input type="text" class="form-control" id="manager" name="manager"
                                   placeholder="نام مدیر عامل را وارد نمائید" value="{$objAgency->edit['manager']}">

                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-3">
                            <label for="phone" class="control-label">شماره تلفن ثابت</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                   placeholder="شماره تلفن ثابت را وارد نمائید" value="{$objAgency->edit['phone']}">

                        </div>

                        <div class="form-group col-sm-3">
                            <label for="mobile" class="control-label">شماره تلفن همراه</label>
                            <input type="text" class="form-control" id="mobile" name="mobile"
                                   placeholder=" شماره تلفن همراه مدیرعامل را وارد نمائید"
                                   value="{$objAgency->edit['mobile']}">

                        </div>
                        <div class="form-group col-sm-3">
                            <label for="fax" class="control-label">شماره فکس همکار </label>
                            <input type="text" class="form-control" id="fax" name="fax"
                                   placeholder="شماره فکس آژانس را وارد نمائید" value="{$objAgency->edit['fax']}">

                        </div>

                        <div class="form-group col-sm-3">
                            <label for="postalcode" class="control-label">کد پستی همکار</label>
                            <input type="text" class="form-control" id="postalcode" name="postalcode"
                                   placeholder="کد پستی همکار را وارد نمائید" value="{$objAgency->edit['postal_code']}">

                        </div>

                        <div class="form-group col-sm-3">
                            <label for="email" class="control-label">ایمیل همکار</label>
                            <input type="email" class="form-control" id="email" name="email"
                                   placeholder="ایمیل مشتری را وارد نمائید" value="{$objAgency->edit['email']}">

                        </div>


                        <div class="form-group col-sm-3">
                            <label for="birthday" class="control-label">تاریخ تولد</label>
                            <input type="text" class="form-control datepicker" value="{$objAgency->edit['birthday']}"
                                   id="birthday" name="birthday"
                                   placeholder="تاریخ تولد را وارد نمائید">
                        </div>


                        <div class="form-group col-sm-3">
                            <label for="staff_number" class="control-label">تعداد پرسنل</label>
                            <input type="number" class="form-control" id="staff_number"
                                   value="{$objAgency->edit['staff_number']}"
                                   name="staff_number"
                                   placeholder="تعداد پرسنل را وارد نمائید">
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="website" class="control-label">وبسایت</label>
                            <input type="text" class="form-control"
                                   value="{$objAgency->edit['website']}"
                                   id="website" name="website"
                                   placeholder="وبسایت را وارد نمائید">
                        </div>


                        <div class="form-group col-sm-3">
                            <label for="economic_code" class="control-label">کد اقتصادی</label>
                            <input type="text" class="form-control"
                                   value="{$objAgency->edit['economic_code']}"
                                   id="economic_code" name="economic_code"
                                   placeholder="کد اقتصادی را وارد نمائید">
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="agency_national_code" class="control-label">شناسه ملی آژانس</label>
                            <input type="text" class="form-control"
                                   value="{$objAgency->edit['agency_national_code']}"
                                   id="agency_national_code" name="agency_national_code"
                                   placeholder="شناسه ملی آژانس را وارد نمائید">
                        </div>
                        <div class="form-group col-sm-3 with-icon">
                            <label for="sepehr_username" class="control-label">نام کاربری سپهر</label>
                            <input type="text" class="form-control"
                                   value="{$objAgency->edit['sepehr_username']}"
                                   id="sepehr_username" name="sepehr_username"
                                   placeholder="نام کاربری سپهر را وارد نمائید">
                        </div>
                        <div class="form-group col-sm-3 with-icon">
                            <label for="sepehr_password" class="control-label">رمز عبور سپهر</label>
                            <input type="password" class="form-control"
                                   value="{$objAgency->edit['sepehr_password']}"
                                   id="sepehr_password" name="sepehr_password"
                                   placeholder="رمز عبور سپهر را وارد نمائید">
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="seat_charter_code" class="control-label">کد یکتای مقیم</label>
                            <input type="text" class="form-control"
                                   value="{$objAgency->edit['seat_charter_code']}"
                                   id="seat_charter_code" name="seat_charter_code"
                                   placeholder="کد یکتای مقیم">
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="ravis_code" class="control-label">کد یکتای راویس</label>
                            <input type="text" class="form-control"
                                   value="{$objAgency->edit['ravis_code']}"
                                   id="ravis_code" name="ravis_code"
                                   placeholder="کد یکتای راویس">
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="raja_unique_code" class="control-label">کد یکتای رجا</label>
                            <input type="text" class="form-control"
                                   value="{$objAgency->edit['raja_unique_code']}"
                                   id="raja_unique_code" name="raja_unique_code"
                                   placeholder="کد یکتای رجای آژانس را وارد نمائید">
                        </div>


                        <div class="form-group col-sm-3">
                            <label for="payment" class="control-label">نوع تسویه </label>
                            <select class="form-control" name="payment" id="payment">
                                <option value=""> انتخاب کنید...</option>
                                <option value="cash" {if {$objAgency->edit['payment']} eq 'cash'}
                                        selected="selected {/if}">نقدی
                                </option>
                                <option value="credit" {if {$objAgency->edit['payment']} eq 'credit'}
                                        selected="selected {/if}">اعتباری
                                </option>
                            </select>
                        </div>

                        <div class="form-group col-sm-3 {if $objAgency->edit['payment'] eq 'cash'} d-none {/if}">
                            <label for="limit_credit" class="control-label">میزان اعتبار <small style="color:red">(میزان اعتبار)</small> </label>
                            <input type="text" class="form-control limit_credit " id="limit_credit" name="limit_credit"
                                   placeholder="میزان ا عتبار  همکار را وارد نمائید" value="{$objAgency->edit['limit_credit']}">
                        </div>

                        <div class="form-group col-sm-3 {if $objAgency->edit['payment'] eq 'cash'} d-none {/if}">
                            {*                            datepickerOfToday*}
                            <label for="time_limit_credit" class="control-label">تاریخ انقضای اعتبار </label>
                            <input type="text" class="form-control limit_credit datepicker" id="time_limit_credit" name="time_limit_credit"
                                   placeholder="تاریخ انقضای اعتبار  همکار را وارد نمائید"  value="{$objDate->jdate( "Y-m-d", $objAgency->edit['time_limit_credit'], '', '', 'en' )}">
                        </div>


                        <div class="form-group col-sm-3">
                            <label for="password" class="control-label">کلمه عبور همکار</label>
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="در صورتی که قصد تغییر کلمه عبور را ندارید این مورد را خالی بگذارید">

                        </div>

                        <div class="form-group col-sm-3">
                            <label for="Confirm" class="control-label">تکرار کلمه عبور </label>
                            <input type="password" class="form-control" id="Confirm" name="Confirm"
                                   placeholder="در صورتی که قصد تغییر کلمه عبور  را ندارید این مورد را خالی بگذارید">

                        </div>


                        <div class="form-group col-sm-3 ">
                            <label for="city_iata" class="control-label">شهر</label>
                            <select name="city_iata" id="city_iata" class="form-control select2">
                                <option value="">شهر مورد نظر را انتخاب نمائید</option>
                                {foreach $allCities as $city}
                                    <option value="{$city.city_iata}"
                                            {if $objAgency->edit['city_iata'] eq $city.city_iata}selected="selected"{/if}>{$city.city_name}</option>
                                {/foreach}
                            </select>
                        </div>

                        <div class="form-group col-sm-3 ">
                            <label for="isColleague" class="control-label">مربوط به آژانس همکار</label>
                            <select name="isColleague" id="isColleague" required aria-required="true"
                                    class="form-control" onchange="selectWhiteLabelForPartner(this)">
                                <option value="">انتخاب کنید ...</option>
                                <option {if $objAgency->edit['isColleague'] eq '1'}selected="selected"{/if} value="1">
                                    بله
                                </option>
                                <option {if $objAgency->edit['isColleague'] eq '0'}selected="selected"{/if} value="0">
                                    خیر
                                </option>

                            </select>
                        </div>


                        <div class="form-group col-sm-3 ">
                            <label for="addressFa" class="control-label">آدرس همکار</label>
                            <textarea id="addressFa" name="addressFa" class="form-control"
                                      placeholder="آدرس مشتری را وارد نمائید">{$objAgency->edit['address_fa']}</textarea>
                        </div>
                        <div class="form-group col-sm-3 ">
                            <label for="addressEn" class="control-label">آدرس لاتین همکار</label>
                            <textarea id="addressEn" name="addressEn" class="form-control"
                                      placeholder="آدرس لاتین مشتری را وارد نمائید">{$objAgency->edit['address_en']}</textarea>
                        </div>
                        <div class="form-group col-sm-3 ">
                            <label for="aboutAgency" class="control-label">درباره همکار</label>
                            <textarea id="aboutAgency" name="aboutAgency" class="form-control"
                                      placeholder="آدرباره همکار را وارد نمائید">{$objAgency->edit['aboutAgency']}</textarea>
                        </div>

                        <div class="form-group col-sm-3 ">
                            <label for="language" class="control-label">زبان نمایش همکار</label>
                            <select name="language" id="language" required aria-required="true"
                                    class="form-control">
                                <option value="fa" {if $objAgency->edit['language'] eq 'fa"'}selected="selected"{/if}>
                                    فارسی
                                </option>
                                <option value="en" {if $objAgency->edit['language'] eq 'en'}selected="selected"{/if}>
                                    انگلیسی
                                </option>
                                <option value="ar" {if $objAgency->edit['language'] eq 'ar'}selected="selected"{/if}>
                                    عربی
                                </option>
                            </select>
                        </div>

                        <div class="form-group col-sm-3  {if $objAgency->edit['hasSite'] eq '0'} hidden {/if}">
                            <label for="is" class="control-label">همکار داری وایت لیبل</label>
                            <select name="hasSite" id="hasSite" required aria-required="true"
                                    class="form-control" onchange="showFieldsWhiteLabel(this)">
                                <option value="">انتخاب کنید ...</option>
                                <option {if $objAgency->edit['hasSite'] eq '1'}selected="selected"{/if} value="1">بله
                                </option>
                                <option {if $objAgency->edit['hasSite'] eq '0'}selected="selected"{/if} value="0">خیر
                                </option>

                            </select>
                        </div>

                        <div class="form-group col-sm-3  fieldsWhiteLabel {if $objAgency->edit['hasSite'] eq '0'}show-white-label{/if}">
                            <label for="domain" class="control-label">دامنه </label>
                            <input type="text" class="form-control disabledWhiteLableField" id="domain" name="domain"
                                   placeholder="نام دامنه را وارد نمائید" value="{$objAgency->edit['domain']}">

                        </div>

                        <div class="form-group col-sm-3 fieldsWhiteLabel {if $objAgency->edit['hasSite'] eq '0'}show-white-label{/if} ">

                            <label for="colorMainBg" class="control-label">انتخاب رنگ اصلی</label>
                            <input type="text" class="gradient-colorpicker form-control disabledWhiteLableField"
                                   name="colorMainBg" id="colorMainBg"
                                   value="{if $objAgency->edit['colorMainBg'] neq ''}{$objAgency->edit['colorMainBg']}{else}#006699{/if}"/>
                        </div>


                        <div class="col-sm-3 form-group fieldsWhiteLabel {if $objAgency->edit['hasSite'] eq '0'}show-white-label{/if}">
                            <label for="colorMainBgHover" class="control-label ">انتخاب رنگ اصلی پر رنگ تر</label>
                            <input type="text" class="gradient-colorpicker form-control disabledWhiteLableField"
                                   name="colorMainBgHover"
                                   id="colorMainBgHover"
                                   value="{if $objAgency->edit['colorMainBgHover'] neq ''}{$objAgency->edit['colorMainBgHover']}{else}#006699{/if}"/>
                        </div>


                        <div class="col-sm-3 form-group fieldsWhiteLabel {if $objAgency->edit['hasSite'] eq '0'}show-white-label{/if}">
                            <label for="colorMainText" class="control-label">انتخاب رنگ متن</label>
                            <input type="text" class="gradient-colorpicker form-control disabledWhiteLableField"
                                   name="colorMainText"
                                   id="colorMainText"
                                   value="{if $objAgency->edit['colorMainText'] neq ''}{$objAgency->edit['colorMainText']}{else}#006699{/if}"/>
                        </div>

                        <div class="col-sm-3 form-group fieldsWhiteLabel {if $objAgency->edit['hasSite'] eq '0'}show-white-label{/if}">
                            <label for="colorMainTextHover" class="control-label"> انتخاب رنگ متن در حالت
                                انتخاب </label>
                            <input type="text" class="gradient-colorpicker form-control disabledWhiteLableField"
                                   name="colorMainTextHover"
                                   id="colorMainTextHover"
                                   value="{if $objAgency->edit['colorMainTextHover'] neq ''}{$objAgency->edit['colorMainTextHover']}{else}#006699{/if}"/>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-md-12 ">
                            <h3 class="box-title m-b-0">اطلاعات بانکی</h3>
                            <hr>
                        </div>
                    </div>

                    {assign var="bank_data" value=$objAgency->edit['bank_data']|json_decode:true}



                    {if $bank_data eq ''}
                        {assign var="bank_data" value=[['bank_list' => '', 'name' => '', 'account_number' => '', 'card_number' => '', 'shaba' => '']]|json_encode}
                    {/if}


                    {foreach $bank_data|json_decode:true as $key=>$item}

                        <div class="row">
                            <div class="form-group col-sm-3  ">
                                <label for="bank_data[{$key}][bank_list]" class="control-label">نام بانک</label>
                                <select name="bank_data[{$key}][bank_list]" id="bank_data[{$key}][bank_list]"
                                        aria-required="true"
                                        class="form-control select2">
                                    <option value="">انتخاب کنید ...</option>
                                    {foreach $bank_list as $bank}
                                        <option {if $item['bank_list'] == $bank.id} selected {/if}
                                                value="{$bank.id}">{$bank.title}</option>
                                    {/foreach}

                                </select>
                            </div>


                            <div class="col-sm-3 form-group">
                                <label for="bank_data[{$key}][name]" class="control-label">
                                    نام صاحب حساب
                                </label>
                                <input type="text" class="form-control"
                                       name="bank_data[{$key}][name]"
                                       id="bank_data[{$key}][name]"
                                       value="{$item['name']}"/>
                            </div>

                            <div class="col-sm-3 form-group">
                                <label for="bank_data[{$key}][account_number]" class="control-label">
                                    شماره حساب اول
                                </label>
                                <input type="text" class="dir_l form-control"
                                       name="bank_data[{$key}][account_number]"
                                       id="bank_data[{$key}][account_number]"
                                       value="{$item['account_number']}"/>
                            </div>


                            <div class="col-sm-3 form-group">
                                <label for="bank_data[{$key}][card_number]" class="control-label">
                                    شماره کارت اول
                                </label>
                                <input type="text" class="dir_l input-mask form-control"
                                       name="bank_data[{$key}][card_number]"
                                       id="bank_data[{$key}][card_number]"
                                       placeholder="9999-9999-9999-9999"
                                       data-inputmask="'mask':'9999-9999-9999-9999'"
                                       value="{$item['card_number']}"/>
                            </div>

                            <div class="col-sm-3 form-group">
                                <label for="bank_data[{$key}][shaba]" class="control-label">
                                    شماره شبا اول
                                </label>
                                <input type="text" class="dir_l input-mask form-control"
                                       name="bank_data[{$key}][shaba]"
                                       id="bank_data[{$key}][shaba]"
                                       data-inputmask="'mask':'IR99-9999-9999-9999-9999-9999-99'"
                                       value="{$item['shaba']}"/>
                            </div>
                        </div>
                    {/foreach}


                    <div class="row">

                        <div class="form-group col-lg-4 col-md-4 col-xs-4 col-sm-4">
                            <label for="logo" class="control-label">لوگو</label>
                            <input type="file" name="logo" id="logo" class="dropify" data-height="100"
                                   data-default-file="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/agencyPartner/{$smarty.const.CLIENT_ID}/logo/{$objAgency->edit['logo']}">
                            {if $objAgency->edit['logo'] neq ''}
                                <a class="downloadLink"
                                   href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/agencyPartner/{$smarty.const.CLIENT_ID}/logo/{$objAgency->edit['logo']}ش"
                                   target="_blank"
                                   type="application/octet-stream">مشاهده لوگو<i class="mdi mdi-download"></i></a>
                            {/if}
                        </div>
                        <div class="form-group col-lg-4 col-md-12 col-xs-4 col-sm-4">
                            <label for="logo" class="control-label">مجوز بند ب</label>
                            <input type="file" name="license" id="license" class="dropify" data-height="100"
                                   data-default-file="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/agencyPartner/{$smarty.const.CLIENT_ID}/license/{$objAgency->edit['license']}"/>
                            {if $objAgency->edit['license'] neq ''}
                                <a class="downloadLink"
                                   href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/agencyPartner/{$smarty.const.CLIENT_ID}/license/{$objAgency->edit['license']}"
                                   target="_blank"
                                   type="application/octet-stream">مشاهده مجوز بند ب<i class="mdi mdi-download"></i></a>
                            {/if}
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-xs-4 col-sm-4">
                            <label for="logo" class="control-label">روزنامه رسمی (آگهی تاسیس)</label>
                            <input type="file" name="newspaper" id="newspaper" class="dropify" data-height="100"
                                   data-default-file="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/agencyPartner/{$smarty.const.CLIENT_ID}/newspaper/{$objAgency->edit['newspaper']}"/>
                            {if $objAgency->edit['newspaper'] neq ''}
                                <a class="downloadLink"
                                   href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/agencyPartner/{$smarty.const.CLIENT_ID}/newspaper/{$objAgency->edit['newspaper']}"
                                   target="_blank"
                                   type="application/octet-stream">مشاهده روزنامه رسمی (آگهی تاسیس)<i
                                            class="mdi mdi-download"></i></a>
                            {/if}
                        </div>

                        <div class="form-group col-lg-4 col-md-4 col-xs-4 col-sm-4">
                            <label for="aboutMePic" class="control-label">تصویر درباره ما</label>
                            <input type="file" name="aboutMePic" id="aboutMePic" class="dropify" data-height="100"
                                   data-default-file="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/agencyPartner/{$smarty.const.CLIENT_ID}/aboutMePic/{$objAgency->edit['aboutMePic']}"/>
                            {if $objAgency->edit['aboutMePic'] neq ''}
                                <a class="downloadLink"
                                   href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/agencyPartner/{$smarty.const.CLIENT_ID}/aboutMePic/{$objAgency->edit['aboutMePic']}"
                                   target="_blank"
                                   type="application/octet-stream">مشاهده تصویر درباره ما<i
                                            class="mdi mdi-download"></i></a>
                            {/if}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <button type="submit" id="submitEdit" class="btn btn-primary">ارسال اطلاعات</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="assets/JsFiles/agency.js"></script>
<script type="text/javascript" src="assets/js/jquery.inputmask.min.js"></script>
<script>
    $(document).ready(function () {

        $(".input-mask").inputmask();
    });
</script>
