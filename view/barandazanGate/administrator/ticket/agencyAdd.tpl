{load_presentation_object filename="banks" assign="objBanks"}
{load_presentation_object filename="agency" assign="objAgency"}
{load_presentation_object filename="currency" assign="obj_currency_list"}

{assign var="currency_list" value=$obj_currency_list->CurrencyList()}

{$objAgency->getCounterType()}

{assign var="allCities" value=$objFunctions->cityIataList()}

{assign var="bank_list" value=$objBanks->getBankList()}

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-3 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="agencyList">همکاران</a></li>
                <li class="active">افزودن همکار جدید</li>
            </ol>
        </div>
        <div class="col-lg-6 col-sm-3 col-md-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">افزودن همکار جدید</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید همکار جدیدی را در سیستم ثبت نمائید</p>
                <hr>
                <form data-toggle="validator" id="AddAgency" method="post">
                    <input type="hidden" name="flag" value="insert_agency">
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <h4 class="elegant-box-title"><i class="fas fa-info-circle"></i> اطلاعات اصلی همکار</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-3">
                            <label for="name_fa" class="control-label">نام همکار</label>
                            <input type="text" class="form-control" id="name_fa" name="name_fa"
                                   placeholder="نام همکار را وارد نمائید">
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="manager" class="control-label">نام مدیر عامل </label>
                            <input type="text" class="form-control" id="manager" name="manager"
                                   placeholder="نام مدیر عامل را وارد نمائید">
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="phone" class="control-label">شماره تلفن ثابت</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                   placeholder="شماره تلفن ثابت را وارد نمائید">
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="mobile" class="control-label">شماره تلفن همراه</label>
                            <input type="text" class="form-control" id="mobile" name="mobile"
                                   placeholder=" شماره تلفن همراه مدیرعامل را وارد نمائید">
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="payment" class="control-label">نوع تسویه </label>
                            <select class="form-control" name="payment" id="payment" onchange="selectTypePayment()">
                                <option value=""> انتخاب کنید...</option>
                                <option value="cash">نقدی</option>
                                <option value="credit">اعتباری</option>
                            </select>
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="type_payment" class="control-label">نوع پرداخت </label>
                            <select class="form-control" name="type_payment" id="type_payment" onchange="selectTypeCurrency(this)">
                                <option value=""> انتخاب کنید...</option>
                                <option value="rial">ریالی</option>
                                <option value="currency">ارزی</option>
                            </select>
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="type_currency" class="control-label">نوع ارز </label>
                            <select class="form-control type-currency" name="type_currency" id="type_currency" disabled="disabled">
                                <option value=""> انتخاب کنید...</option>
                                {foreach $currency_list as $currency}
                                    <option value="{$currency['CurrencyCode']}">{$currency['CurrencyTitle']}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="isColleague" class="control-label">مربوط به آژانس همکار</label>
                            <select name="isColleague" id="isColleague" required aria-required="true"
                                    class="form-control" onchange="selectWhiteLabelForPartner(this)">
                                <option value="">انتخاب کنید ...</option>
                                <option value="1">بله</option>
                                <option value="0">خیر</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-3 hidden">
                            <label for="hasSite" class="control-label">همکار داری وایت لیبل</label>
                            <select name="hasSite" id="hasSite" required aria-required="true"
                                    class="form-control" onchange="showFieldsWhiteLabel(this)">
                                <option value="">انتخاب کنید ...</option>
                                <option value="1">بله</option>
                                <option value="0">خیر</option>

                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12">
                            <h4 class="elegant-box-title"><i class="fas fa-globe"></i> وب سرویس همکاران</h4>
                        </div>
                    </div>

                    <div class="webservice-sections">
                        <!-- سفر360 گیت -->
                        <div class="webservice-section">
                            <div class="section-title" style="margin: 22px 0 0 0 ">سفر360 گیت</div>
                            <div class="section-content">
                                <div class="form-group col-sm-3 with-icon">
                                    <label for="password" class="control-label">کلمه عبور سفر360 گیت</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                           placeholder="کلمه عبور همکار را وارد نمائید">
                                </div>

                                <div class="form-group col-sm-3 with-icon">
                                    <label for="confirmPass" class="control-label">تکرار کلمه عبور سفر360 گیت</label>
                                    <input type="password" class="form-control" id="confirmPass" name="confirmPass"
                                           placeholder="تکرار رمز عبور">
                                </div>
                            </div>
                        </div>

                        <!-- کد یکتای سپهر -->
                        <div class="webservice-section">
                            <div class="section-title" style="margin: 22px 0 0 0 ">کد یکتای سپهر</div>
                            <div class="section-content">
                                <div class="form-group col-sm-3 with-icon">
                                    <label for="sepehr_username" class="control-label">نام کاربری سپهر</label>
                                    <input type="text" class="form-control" id="sepehr_username" name="sepehr_username"
                                           placeholder="نام کاربری سپهر را وارد نمائید">
                                </div>

                                <div class="form-group col-sm-3 with-icon">
                                    <label for="sepehr_password" class="control-label">رمز عبور سپهر</label>
                                    <input type="password" class="form-control" id="sepehr_password" name="sepehr_password"
                                           placeholder="رمز عبور سپهر را وارد نمائید">
                                </div>
                            </div>
                        </div>



                        <!-- کد یکتای مقیم -->
                        <div class="webservice-section">
                            <div class="section-title" style="margin: 22px 0 0 0 ">کد یکتای مقیم</div>
                            <div class="section-content">
                                <div class="form-group col-sm-3 with-icon">
                                    <label for="seat_charter_code" class="control-label">کد یکتای مقیم</label>
                                    <input type="text" class="form-control" id="seat_charter_code" name="seat_charter_code"
                                           placeholder="کد یکتای مقیم">
                                </div>
                            </div>
                        </div>

                        <!-- کد یکتای راویس -->
                        <div class="webservice-section">
                            <div class="section-title" style="margin: 22px 0 0 0 ">کد یکتای راویس</div>
                            <div class="section-content">
                                <div class="form-group col-sm-3 with-icon">
                                    <label for="ravis_code" class="control-label">کد یکتای راویس</label>
                                    <input type="text" class="form-control" id="ravis_code" name="ravis_code"
                                           placeholder="کد یکتای راویس">
                                </div>
                            </div>
                        </div>

                        <!-- کد یکتای رجا -->
                        <div class="webservice-section">
                            <div class="section-title" style="margin: 22px 0 0 0 ">کد یکتای رجا</div>
                            <div class="section-content">
                                <div class="form-group col-sm-3 with-icon">
                                    <label for="raja_unique_code" class="control-label">کد یکتای رجا</label>
                                    <input type="text" class="form-control" id="raja_unique_code" name="raja_unique_code"
                                           placeholder="کد یکتای رجای آژانس را وارد نمائید">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12">
                            <h4 class="elegant-box-title"><i class="fas fa-university"></i> اطلاعات بانکی</h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-3">
                            <label for="bank_data[0][bank_list]" class="control-label">نام بانک</label>
                            <select name="bank_data[0][bank_list]" id="bank_data[0][bank_list]" aria-required="true"
                                    class="form-control">
                                <option value="">انتخاب کنید ...</option>
                                {foreach $bank_list as $bank}
                                    <option value="{$bank.id}">{$bank.title}</option>
                                {/foreach}
                            </select>
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="bank_data[0][name]" class="control-label">نام صاحب حساب</label>
                            <input type="text" class="form-control"
                                   name="bank_data[0][name]"
                                   id="bank_data[0][name]"
                                   value=""/>
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="bank_data[0][account_number]" class="control-label">شماره حساب اول</label>
                            <input type="text" class="dir_l form-control"
                                   name="bank_data[0][account_number]"
                                   id="bank_data[0][account_number]"
                                   value=""/>
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="bank_data[0][card_number]" class="control-label">شماره کارت اول</label>
                            <input type="text" class="dir_l input-mask form-control"
                                   name="bank_data[0][card_number]"
                                   id="bank_data[0][card_number]"
                                   placeholder="9999-9999-9999-9999"
                                   data-inputmask="'mask':'9999-9999-9999-9999'"
                                   value=""/>
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="bank_data[0][shaba]" class="control-label">شماره شبا اول</label>
                            <input type="text" class="dir_l input-mask form-control"
                                   name="bank_data[0][shaba]"
                                   id="bank_data[0][shaba]"
                                   data-inputmask="'mask':'IR99-9999-9999-9999-9999-9999-99'"
                                   value=""/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12">
                            <h4 class="elegant-box-title"><i class="fas fa-info"></i> اطلاعات تکمیلی</h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-3">
                            <label for="name_En" class="control-label">نام لاتین همکار</label>
                            <input type="text" class="form-control" id="name_En" name="name_En"
                                   placeholder="نام لاتین همکار را وارد نمائید">
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="accountant" class="control-label">نام حسابدار</label>
                            <input type="text" class="form-control" id="accountant" name="accountant"
                                   placeholder="نام حسابدار را وارد نمائید">
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="fax" class="control-label">شماره فکس همکار </label>
                            <input type="text" class="form-control" id="fax" name="fax"
                                   placeholder="شماره فکس آژانس را وارد نمائید">
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="postal_code" class="control-label">کد پستی همکار</label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code"
                                   placeholder="کد پستی همکار را وارد نمائید">
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="email" class="control-label">ایمیل همکار</label>
                            <input type="email" class="form-control" id="email" name="email"
                                   placeholder="ایمیل همکار را وارد نمائید">
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="birthday" class="control-label">تاریخ تولد</label>
                            <input type="text" class="form-control datepicker" id="birthday" name="birthday"
                                   placeholder="تاریخ تولد را وارد نمائید">
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="staff_number" class="control-label">تعداد پرسنل</label>
                            <input type="number" class="form-control" id="staff_number" name="staff_number"
                                   placeholder="تعداد پرسنل را وارد نمائید">
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="economic_code" class="control-label">کد اقتصادی</label>
                            <input type="text" class="form-control" id="economic_code" name="economic_code"
                                   placeholder="کد اقتصادی را وارد نمائید">
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="agency_national_code" class="control-label">شناسه ملی آژانس</label>
                            <input type="text" class="form-control" id="agency_national_code" name="agency_national_code"
                                   placeholder="شناسه ملی آژانس را وارد نمائید">
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="city_iata" class="control-label">شهر</label>
                            <select name="city_iata" id="city_iata" class="form-control">
                                <option value="">شهر مورد نظر را انتخاب نمائید</option>
                                {foreach $allCities as $city}
                                    <option value="{$city.city_iata}">{$city.city_name}</option>
                                {/foreach}
                            </select>
                        </div>





                        <div class="form-group col-sm-3">
                            <label for="language" class="control-label">زبان نمایش همکار</label>
                            <select name="language" id="language" required aria-required="true"
                                    class="form-control">
                                <option value="fa">فارسی</option>
                                <option value="en">انگلیسی</option>
                                <option value="ar">عربی</option>
                            </select>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="address_fa" class="control-label">آدرس همکار</label>
                            <textarea id="address_fa" name="address_fa" class="form-control"
                                      placeholder="آدرس همکار را وارد نمائید" rows="3"></textarea>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="address_en" class="control-label">آدرس لاتین همکار</label>
                            <textarea id="address_en" name="address_en" class="form-control"
                                      placeholder="آدرس لاتین همکار را وارد نمائید" rows="3"></textarea>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="aboutAgency" class="control-label">درباره همکار</label>
                            <textarea id="aboutAgency" name="aboutAgency" class="form-control"
                                      placeholder="درباره همکار را وارد نمائید" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12">
                            <h4 class="elegant-box-title"><i class="fas fa-file-upload"></i> آپلود مدارک مورد نیاز</h4>
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group col-lg-3 col-md-4 col-sm-6">
                            <label for="logo" class="control-label">لوگو</label>
                            <input type="file" name="logo" id="logo" class="dropify" data-height="100"
                                   data-default-file="assets/plugins/images/defaultLogo.png"/>
                        </div>
                        <div class="form-group col-lg-3 col-md-4 col-sm-6">
                            <label for="license" class="control-label">مجوز بند ب</label>
                            <input type="file" name="license" id="license" class="dropify" data-height="100"
                                   data-default-file="assets/plugins/images/noPhoto.png"/>
                        </div>

                        <div class="form-group col-lg-3 col-md-4 col-sm-6">
                            <label for="newspaper" class="control-label">روزنامه رسمی (آگهی تاسیس)</label>
                            <input type="file" name="newspaper" id="newspaper" class="dropify" data-height="100"
                                   data-default-file="assets/plugins/images/noPhoto.png"/>
                        </div>

                        <div class="form-group col-lg-3 col-md-4 col-sm-6">
                            <label for="aboutMePic" class="control-label">تصویر درباره ما</label>
                            <input type="file" name="aboutMePic" id="aboutMePic" class="dropify" data-height="100"
                                   data-default-file="assets/plugins/images/noPhoto.png"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg">ارسال اطلاعات</button>
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