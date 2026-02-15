{load_presentation_object filename="partner" assign="objPartner"}
{assign var="allClients" value=$objPartner->allClients()}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="flyAppClient">مشتریان نرم افزار پرواز</a></li>
                <li class="active">افزودن مشتری جدید</li>
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
                <h3 class="box-title m-b-0">افزودن مشتری جدید</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید مشتری جدیدی را در سیستم ثبت نمائید</p>

                <form data-toggle="validator" id="Client" method="post">
                    <input type="hidden" name="flag" value="insert_client">
                    <div class="form-group col-sm-6 ">

                        <label for="AgencyName" class="control-label">نام و نام خانوادگی مشتری</label>
                        <input type="text" class="form-control" id="AgencyName" name="AgencyName"
                               placeholder="نام کامل مشتری را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="Domain" class="control-label">نام دامنه (الزامی جهت ساخت دیتابیس)</label>
                        <input type="text" class="form-control" id="Domain" name="Domain"
                               placeholder="نام دامنه مشتری را وارد نمائید">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="MainDomain" class="control-label">نام دامنه اصلی (الزامی جهت ساخت دیتابیس)</label>
                        <input type="text" class="form-control" id="MainDomain" name="MainDomain"
                               placeholder="نام دامنه اصلی مشتری را وارد نمائید">

                    </div>

<!--                    <div class="form-group col-sm-6">
                        <label for="DbName" class="control-label">نام دیتابیس </label>
                        <input type="text" class="form-control" id="DbName" name="DbName"
                               placeholder="نام دیتابیس مشتری را وارد نمائید">

                    </div>-->

              {*      <div class="form-group col-sm-6">
                        <label for="DbUser" class="control-label">نام کاربری دیتابیس </label>
                        <input type="text" class="form-control" id="DbUser" name="DbUser"
                               placeholder="نام کاربری دیتابیس مشتری را وارد نمائید">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="DbPass" class="control-label">کلمه عبور دیتابیس </label>
                        <input type="password" class="form-control" id="DbPass" name="DbPass"
                               placeholder=" کلمه عبور دیتابیس مشتری را وارد نمائید">

                    </div>*}

                    <div class="form-group col-sm-6">
                        <label for="ThemeDir" class="control-label">مسیر پوشه قالب </label>
                        <input type="text" class="form-control" id="ThemeDir" name="ThemeDir"
                               placeholder="مسیر پوشه قالب  را وارد نمائید">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="Email" class="control-label">ایمیل مشتری</label>
                        <input type="email" class="form-control" id="Email" name="Email"
                               placeholder="ایمیل مشتری را وارد نمائید"
                        >

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="password" class="control-label">کلمه عبور مشتری</label>
                        <input type="password" class="form-control" id="password" name="password"
                               placeholder="کلمه عبور مشتری را وارد نمائید">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="Confirm" class="control-label">تکرار کلمه عبور </label>
                        <input type="password" class="form-control" id="Confirm" name="Confirm"
                               placeholder="تکرار رمز عبور">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="Manager" class="control-label">نام مدیر(مشتری) </label>
                        <input type="text" class="form-control" id="Manager" name="Manager"
                               placeholder="نام مدیر را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="Mobile" class="control-label">تلفن همراه مشتری </label>
                        <input type="text" class="form-control" id="Mobile" name="Mobile" maxlength="11"
                               placeholder="تلفن همراه مدیر  را وارد نمائید">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="Phone" class="control-label">تلفن ثابت مشتری </label>
                        <input type="text" class="form-control" id="Phone" name="Phone"
                               placeholder="تلفن ثابت  را وارد نمائید">

                    </div>
                    <!--<div class="form-group col-sm-6">-->
                        <!--<label for="type" class="control-label"> نوع کاربر  </label>-->
                        <!--<select name="Type" id="Type" class="form-control" onchange="selectClub();">-->
                            <!--<option value="">انتخاب کنید...</option>-->
                            <!--<option value="2">کاربر پنل</option>-->
                            <!--<option value="3">کاربر apiمنبع 4</option>-->
                        <!--</select>-->
                    <!--</div>-->

                    <div class="form-group col-sm-6">
                        <label for="IsEnableTicketHTC" class="control-label"> اجازه رزرواسیون بلیط  </label>
                        <select name="IsEnableTicketHTC" id="IsEnableTicketHTC" class="form-control">
                            <option value="">انتخاب کنید...</option>
                            <option value="1">دارد</option>
                            <option value="0">ندارد</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="IsEnableClub" class="control-label"> اجازه نمایش باشگاه  </label>
                        <select name="IsEnableClub" id="IsEnableClub" class="form-control" onchange="selectClub();">
                            <option value="">انتخاب کنید...</option>
                            <option value="1">دارد</option>
                            <option value="0">ندارد</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-6" style="display: none;" id="ClubPreCardNoDiv">
                        <label for="ClubPreCardNo" class="control-label"> پیش شماره کارت باشگاه</label>
                        <input type="text" class="form-control" id="ClubPreCardNo" name="ClubPreCardNo"
                               placeholder="پیش شماره کارت باشگاه را وارد نمائید">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="Title" class="control-label">عنوان </label>
                        <input type="text" class="form-control" id="Title" name="Title"
                               placeholder="عنوان را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6 ">
                        <label for="Description" class="control-label">متا توضیحات</label>
                        <textarea id="Description" name="Description" class="form-control"
                                  placeholder="متا توضیحات"></textarea>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="PinAllowAccountant" class="control-label">نام کاربری حسابداری <small style='color:red'>(در صورتی که مشتری اکانت حسابداری دارد،نام کاربری مشترک با حسابداری را وارد نمایید)</small></label>
                        <input type="text" class="form-control" id="PinAllowAccountant" name="PinAllowAccountant"
                               placeholder="نام کاربری حسابداری">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="id_whmcs" class="control-label">آیدی تیکت مشتری <small style='color:red'>(آیدی تیکت را از سیستم اتوماسیون داخلی شرکت توسط منشی که تعریف میشود دریافت کنید)</small></label>
                        <input type="text" class="form-control" id="id_whmcs" name="id_whmcs"
                               placeholder="آیدی تیکت">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="ravis_code" class="control-label"> کد راویس پیش فرض مشتری<small style='color:red'>(در اکسل راویس اگر همکارش کد نداشت این دیده می شود)</small></label>
                        <input type="text" class="form-control" id="ravis_code" name="ravis_code" value="">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="AllowSendSms" class="control-label"> اجازه ارسال پیامک </label>
                        <select name="AllowSendSms" id="AllowSendSms" class="form-control" onchange="SelectAllowPanel(this)">
                            <option value="">انتخاب کنید...</option>
                            <option value="1">دارد</option>
                            <option value="0">ندارد</option>
                        </select>
                    </div>


                    <div class="form-group col-sm-6">
                        <label for="IsCurrency" class="control-label"> اجازه ارزی کردن</label>
                        <select name="IsCurrency" id="IsCurrency" class="form-control">
                            <option value="">انتخاب کنید...</option>
                            <option value="1">دارد</option>
                            <option value="0">ندارد</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="default_language" class="control-label">زبان پیش فرض</label>
                        <select name="default_language" id="default_language" class="form-control">
                            <option value="fa">فارسی</option>
                            <option value="ar">عربی</option>
                            <option value="en">انگلیسی</option>
                            <option value="ru">روسی</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="diamondAccess" class="control-label">دسترسی زمرد</label>
                        <select name="diamondAccess" id="diamondAccess" class="form-control">
                            <option value="">انتخاب کنید...</option>
                            <option value="1">دارد</option>
                            <option value="0">ندارد</option>
                        </select>
                    </div>


                    <div class="form-group col-sm-6">
                        <label for="DefaultDb" class="control-label">دیتابیس پیش فرض</label>
                        <select name="DefaultDb" id="DefaultDb" class="form-control">
                            <option value="0">فعال نباشد</option>
                            <option value="1">فعال باشد</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-6 smsPanel" style="display: none">
                        <label for="UsernameSms" class="control-label">نام کاربری پنل پیامک  </label>
                        <input type="text" class="form-control" id="UsernameSms" name="UsernameSms"
                               placeholder="نام کاربری پنل پیامک را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6 smsPanel" style="display: none">
                        <label for="PasswordSms" class="control-label">کلمه عبور پنل پیامک </label>
                        <input type="text" class="form-control" id="PasswordSms" name="PasswordSms"
                               placeholder="کلمه عبور پنل پیامک را وارد نمائید">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="parent_id" class="control-label"> مشتری معرف </label>
                            <select name="parent_id" id="parent_id" class="form-control">
                                <option value="">انتخاب کنید...</option>
                                {foreach  $allClients as $client}
                                    <option value="{$client['id']}">{$client['AgencyName']}</option>
                                {/foreach}
                            </select>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="isIframe" class="control-label">این مشتری آیفریم است ؟ </label>
                        <select name="isIframe" id="isIframe" class="form-control">
                            <option value="">انتخاب کنید</option>
                            <option value="1">بله</option>
                            <option value="0">خیر</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="PasswordSms" class="control-label">لینک قوانین </label>
                        <input type="text" class="form-control" id="UrlRuls" name="UrlRuls"
                               placeholder="لینک قوانین  را وارد نمائید">
                    </div>

              {*      <div class="form-group col-sm-6">
                        <label for="PasswordSms" class="control-label">درخواست تلفنی فعال شود </label>
                        <select name="IsEnableTelOrder" id="IsEnableTelOrder" class="form-control">
                            <option value="">انتخاب کنید...</option>
                            <option value="1">بله</option>
                            <option value="0">خیر</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="PasswordSms" class="control-label">درخواست پیامکی فعال شود </label>
                        <select name="IsEnableSmsOrder" id="IsEnableSmsOrder" class="form-control">
                            <option value="">انتخاب کنید...</option>
                            <option value="1">بله</option>
                            <option value="0">خیر</option>
                        </select>
                    </div>*}







                    <div class="form-group col-sm-6 ">
                        <label for="Address" class="control-label">آدرس مشتری</label>
                        <textarea id="Address" name="Address" class="form-control"
                                  placeholder="آدرس مشتری را وارد نمائید"></textarea>
                    </div>

                    <div class="form-group col-sm-6 ">
                        <label for="AddressEn" class="control-label">آدرس انگلیسی مشتری</label>
                        <textarea id="AddressEn" name="AddressEn" class="form-control"
                                  placeholder="آدرس انگلیسی مشتری را وارد نمائید"></textarea>
                    </div>

                    <div class="form-group col-sm-6 ">
                        <label for="AboutMe" class="control-label">درباره ما(مشتری)</label>
                        <textarea id="AboutMe" name="AboutMe" class="form-control"
                                  placeholder="آدرس انگلیسی مشتری را وارد نمائید"></textarea>
                    </div>



                    <div class="form-group col-sm-6">
                        <label for="Logo" class="control-label">لوگو</label>
                        <input type="file" name="Logo" id="Logo" class="dropify" data-height="100"
                               data-default-file="assets/plugins/images/defaultLogo.png"/>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="Stamp" class="control-label">تصویر مهر / امضاء</label>
                        <input type="file" name="Stamp" id="Stamp" class="dropify" data-height="100"
                               data-default-file="assets/plugins/images/defaultLogo.png"/>
                    </div>


                    <div class="form-group col-sm-12">
                        <label class="control-label">اطلاعات تماس</label>

                        <div class="row">

                            <div class="form-group col-sm-12 DynamicAdditionalData">

                                <div data-target="BaseAdditionalDataDiv" class="col-sm-12 p-0 form-group">
                                    <div class="col-md-3 pr-0">
                                        <input data-parent="AdditionalDataValues" data-target="title" name="AdditionalData[0][title]" placeholder="عنوان" class="form-control"
                                               type="text">
                                    </div>
                                    <div class="col-md-8">
                                        <input data-parent="AdditionalDataValues" data-target="body" name="AdditionalData[0][body]" placeholder="متن نمایش" class="form-control"
                                               type="text">
                                    </div>
                                    <div class="col-md-1 pl-0">
                                        <div class="col-md-6 p-0">
                                            <button type="button" onclick="AddAdditionalData()" class="btn form-control btn-success">
                                                <span class="fa fa-plus"></span>
                                            </button>
                                        </div>
                                        <div class="col-md-6 p-0">
                                            <button onclick="RemoveAdditionalData($(this))" type="button" class="btn form-control btn-danger">
                                                <span class="fa fa-remove"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="form-group col-sm-12">
                        <label class="control-label">موقعیت روی نقشه</label>
                        <div id="map"></div>

                        <input type="hidden" class="form-control" id="GoogleMapLatitude" name="GoogleMapLatitude"
                               placeholder="GoogleMapLatitude را وارد نمائید">

                        <input type="hidden" class="form-control" id="GoogleMapLongitude" name="GoogleMapLongitude"
                               placeholder="عنوان را وارد نمائید">
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

{literal}
<script type="text/javascript" src="assets/JsFiles/FlayAppClient.js"></script>
<!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin=""></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ==" crossorigin="" />

<script>
  map = L.map('map').setView([35.695188083481064, 51.39678955078126], 8);

  L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
    maxZoom: 18
  }).addTo(map);
  newMarkerGroup = new L.LayerGroup();
  var marker = null;

  map.on('click', function (e) {
    if (marker !== null) {
      map.removeLayer(marker);
    }
    console.log('e.latlng',e.latlng)

    $('#GoogleMapLatitude').val(e.latlng.lat)
    $('#GoogleMapLongitude').val(e.latlng.lng)

    marker = L.marker(e.latlng).addTo(map);
  });


</script>
{/literal}