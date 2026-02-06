{load_presentation_object filename="partner" assign="objPartner"}

{if $smarty.get.id !=""}
    <style>
        #map {
            height: 280px;
            display: flex;
            flex-wrap: wrap;
            width: 100%;
        }
    </style>

{$objPartner->showedit($smarty.get.id)}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="flyAppClient">مشتریان نرم افزار پرواز</a></li>
                <li class="active">ویرایش مشتری </li>
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
                <h3 class="box-title m-b-0">ویرایش مشتری </h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید  اطلاعات مشتری  را در سیستم ویرایش  نمائید</p>

                <form data-toggle="validator" id="EditClient" method="post">
                    <input type="hidden" name="flag" value="update_client">
                    <input type="hidden" name="client_id" value="{$smarty.get.id}">
                    <div class="form-group col-sm-6 ">

                        <label for="AgencyName" class="control-label">نام و نام خانوادگی مشتری</label>
                        <input type="text" class="form-control" id="AgencyName" name="AgencyName"
                               placeholder="نام کامل مشتری را وارد نمائید" value="{$objPartner->list['AgencyName']}">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="Domain" class="control-label">نام دامنه</label>
                        <input type="text" class="form-control" id="Domain" name="Domain"
                               placeholder="نام دامنه مشتری را وارد نمائید" value="{$objPartner->list['Domain']}">

                    </div>

                     <div class="form-group col-sm-6">
                            <label for="MainDomain" class="control-label">نام دامنه اصلی</label>
                            <input type="text" class="form-control" id="MainDomain" name="MainDomain"
                                   placeholder="نام دامنه اصلی مشتری را وارد نمائید" value="{$objPartner->list['MainDomain']}">

                     </div>

                    {*    <div class="form-group col-sm-6">
                         <label for="DbName" class="control-label">نام دیتابیس </label>
                         <input type="text" class="form-control" id="DbName" name="DbName"
                                placeholder="نام دیتابیس مشتری را وارد نمائید" value="{$objPartner->list['DbName']}">

                     </div>*}



                    <div class="form-group col-sm-6">
                        <label for="ThemeDir" class="control-label">مسیر پوشه قالب </label>
                        <input type="text" class="form-control" id="ThemeDir" name="ThemeDir"
                               placeholder="مسیر پوشه قالب  را وارد نمائید" value="{$objPartner->list['ThemeDir']}">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="Email" class="control-label">ایمیل مشتری</label>
                        <input type="email" class="form-control" id="Email" name="Email"
                               placeholder="ایمیل مشتری را وارد نمائید" value="{$objPartner->list['Email']}">


                    </div>


                    <div class="form-group col-sm-6">
                        <label for="Manager" class="control-label">نام مدیر(مشتری) </label>
                        <input type="text" class="form-control" id="Manager" name="Manager"
                               placeholder="نام مدیر را وارد نمائید" value="{$objPartner->list['Manager']}">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="Mobile" class="control-label">تلفن همراه مشتری </label>
                        <input type="text" class="form-control" id="Mobile" name="Mobile" maxlength="11"
                               placeholder="تلفن همراه مدیر  را وارد نمائید" value="{$objPartner->list['Mobile']}">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="Phone" class="control-label">تلفن ثابت مشتری </label>
                        <input type="text" class="form-control" id="Phone" name="Phone"
                               placeholder="تلفن ثابت  را وارد نمائید" value="{$objPartner->list['Phone']}">

                    </div>

                    <!--<div class="form-group col-sm-6">-->
                        <!--<label for="type" class="control-label"> نوع کاربر  </label>-->
                        <!--<select name="Type" id="Type" class="form-control" onchange="selectClub();">-->
                            <!--<option value="">انتخاب کنید...</option>-->
                            <!--<option value="2" {if {$objPartner->list['Type']} eq '2'}selected="selected"{/if}>کاربر پنل</option>-->
                            <!--<option value="3" {if {$objPartner->list['Type']} eq '3'}selected="selected"{/if}>کاربر api منبع 4</option>-->
                        <!--</select>-->
                    <!--</div>-->

                    <div class="form-group col-sm-6">
                        <label for="IsEnableTicketHTC" class="control-label"> اجازه رزرواسیون بلییط  </label>
                        <select name="IsEnableTicketHTC" id="IsEnableTicketHTC" class="form-control">
                            <option value="">انتخاب کنید...</option>
                            <option value="1" {if {$objPartner->list['IsEnableTicketHTC']} eq '1'}selected="selected"{/if}>دارد</option>
                            <option value="0" {if {$objPartner->list['IsEnableTicketHTC']} eq '0'}selected="selected"{/if}>ندارد</option>
                        </select>
                    </div>


                    <div class="form-group col-sm-6" style="display: none;" id="ClubPreCardNoDiv">
                        <label for="ClubPreCardNo" class="control-label"> پیش شماره کارت باشگاه</label>
                        <input type="text" class="form-control" id="ClubPreCardNo" name="ClubPreCardNo"
                               placeholder="پیش شماره کارت باشگاه را وارد نمائید" value="{$objPartner->list['ClubPreCardNo']}">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="IsEnableClub" class="control-label"> اجازه نمایش باشگاه  </label>
                        <select name="IsEnableClub" id="IsEnableClub" class="form-control ">
                            <option value="">انتخاب کنید...</option>
                            <option value="1" {if {$objPartner->list['IsEnableClub']} eq '1'}selected="selected"{/if}>دارد</option>
                            <option value="0" {if {$objPartner->list['IsEnableClub']} eq '0'}selected="selected"{/if}>ندارد</option>
                        </select>
                    </div>


                    <div class="form-group col-sm-6">
                        <label for="Title" class="control-label">عنوان </label>
                        <input type="text" class="form-control" id="Title" name="Title"
                               placeholder="عنوان را وارد نمائید" value="{$objPartner->list['Title']}">
                    </div>

                    <div class="form-group col-sm-6 ">
                        <label for="Description" class="control-label">متا توضیحات</label>
                        <textarea id="Description" name="Description" class="form-control"
                                  placeholder="متا توضیحات">{$objPartner->list['Description']}</textarea>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="PinAllowAccountant" class="control-label">نام کاربری حسابداری <small style='color:red'>(در صورتی که مشتری اکانت حسابداری دارد،نام کاربری مشترک با حسابداری را وارد نمایید)</small></label>
                        <input type="text" class="form-control" id="PinAllowAccountant" name="PinAllowAccountant"
                               placeholder="نام کاربری حسابداری" value="{$objPartner->list['PinAllowAccountant']}">
                    </div>
                    
                    <div class="form-group col-sm-6">
                        <label for="id_whmcs" class="control-label">آیدی تیکت مشتری <small style='color:red'>(آیدی تیکت را از سیستم اتوماسیون داخلی شرکت توسط منشی که تعریف میشود دریافت کنید)</small></label>
                        <input type="text" class="form-control" id="id_whmcs" name="id_whmcs" placeholder="آیدی تیکت" value="">
                            <span class="input-group-text" id="id_whmcs_txt">
							{if isset($objPartner->list['hash_id_whmcs']) && $objPartner->list['hash_id_whmcs'] !== ''}{$objPartner->list['hash_id_whmcs']}{else}کد ندارد{/if}
						</span>
                    </div>

                        <div class="form-group col-sm-6">
                            <label for="ravis_code" class="control-label"> کد راویس پیش فرض مشتری<small style='color:red'>(در اکسل راویس اگر همکارش کد نداشت این دیده می شود)</small></label>
                            <input type="text" class="form-control" id="ravis_code" name="ravis_code" value="{$objPartner->list['ravis_code']}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="Title" class="control-label">لینک قوانین </label>
                            <input type="text" class="form-control" id="UrlRuls" name="UrlRuls"
                                   placeholder="لینک قوانین  را وارد نمائید" value="{$objPartner->list['UrlRuls']}">
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="isIframe" class="control-label">این مشتری آیفریم است ؟ </label>
                            <select name="isIframe" id="isIframe" class="form-control">
                                <option value="">انتخاب کنید</option>
                                <option value="1"  {if $objPartner->list['isIframe'] == 1} selected {/if}>بله</option>
                                <option value="0" {if $objPartner->list['isIframe'] == 0} selected {/if}>خیر</option>
                            </select>
                        </div>

                    <div class="form-group col-sm-6">
                        <label for="default_language" class="control-label">زبان پیش فرض</label>
                        <select name="default_language" id="default_language" class="form-control">
                            <option value="fa" {if {$objPartner->list['default_language']} eq 'fa'}selected="selected"{/if}>فارسی</option>
                            <option value="ar" {if {$objPartner->list['default_language']} eq 'ar'}selected="selected"{/if}>عربی</option>
                            <option value="en" {if {$objPartner->list['default_language']} eq 'en'}selected="selected"{/if}>انگلیسی</option>
                            <option value="ru" {if {$objPartner->list['default_language']} eq 'ru'}selected="selected"{/if}>روسی</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="diamondAccess" class="control-label">دسترسی زمرد</label>
                        <select name="diamondAccess" id="diamondAccess" class="form-control">
                            <option value="">انتخاب کنید...</option>
                            <option value="1" {if {$objPartner->list['diamondAccess']} eq '1'}selected="selected"{/if}>دارد</option>
                            <option value="0" {if {$objPartner->list['diamondAccess']} eq '0'}selected="selected"{/if}>ندارد</option>
                        </select>
                    </div>


                    <div class="form-group col-sm-6">
                        <label for="DefaultDb" class="control-label">دیتابیس پیش فرض</label>
                        <select name="DefaultDb" id="DefaultDb" class="form-control">
                            <option value="no"  {if $objPartner->list['DefaultDb'] eq '0'}selected="selected"{/if}>فعال نباشد</option>
                            <option value="yes"  {if $objPartner->list['DefaultDb'] eq '1'}selected="selected"{/if}>فعال باشد</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="IsCurrency" class="control-label"> اجازه ارزی کردن</label>
                        <select name="IsCurrency" id="IsCurrency" class="form-control">
                            <option value="">انتخاب کنید...</option>
                            <option value="1" {if {$objPartner->list['IsCurrency']} eq '1'}selected="selected"{/if}>دارد</option>
                            <option value="0" {if {$objPartner->list['IsCurrency']} eq '0'}selected="selected"{/if}>ندارد</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="AllowSendSms" class="control-label"> اجازه ارسال پیامک </label>
                        <select name="AllowSendSms" id="AllowSendSms" class="form-control">
                            <option value="">انتخاب کنید...</option>
                            <option value="1" {if {$objPartner->list['AllowSendSms']} eq '1'}selected="selected"{/if}>دارد</option>
                            <option value="0" {if {$objPartner->list['AllowSendSms']} eq '0'}selected="selected"{/if}>ندارد</option>

                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="UsernameSms" class="control-label">نام کاربری پنل پیامک  </label>
                        <input type="text" class="form-control" id="UsernameSms" name="UsernameSms"
                               placeholder="نام کاربری پنل پیامک را وارد نمائید" value="{$objPartner->list['UsernameSms']}">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="PasswordSms" class="control-label">کلمه عبور پنل پیامک </label>
                        <input type="text" class="form-control" id="PasswordSms" name="PasswordSms"
                               placeholder="کلمه عبور پنل پیامک را وارد نمائید" value="{$objPartner->list['PasswordSms']}">
                    </div>

  {*                  <div class="form-group col-sm-6">
                        <label for="PasswordSms" class="control-label">درخواست تلفنی فعال شود </label>
                        <select name="IsEnableTelOrder" id="IsEnableTelOrder" class="form-control">
                            <option value="">انتخاب کنید...</option>
                            <option value="1" {if {$objPartner->list['IsEnableTelOrder']} eq '1'}selected="selected"{/if}>بله</option>
                            <option value="0" {if {$objPartner->list['IsEnableTelOrder']} eq '0'}selected="selected"{/if}>خیر</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="PasswordSms" class="control-label">درخواست پیامکی فعال شود </label>
                        <select name="IsEnableSmsOrder" id="IsEnableSmsOrder" class="form-control">
                            <option value="">انتخاب کنید...</option>
                            <option value="1" {if {$objPartner->list['IsEnableSmsOrder']} eq '1'}selected="selected"{/if}>بله</option>
                            <option value="0" {if {$objPartner->list['IsEnableSmsOrder']} eq '0'}selected="selected"{/if}>خیر</option>
                        </select>
                    </div>*}


                    <div class="form-group col-sm-6 ">
                        <label for="Address" class="control-label">آدرس مشتری</label>
                        <textarea id="Address" name="Address" class="form-control"
                                  placeholder="آدرس مشتری را وارد نمائید">{$objPartner->list['Address']}</textarea>
                    </div>

                    <div class="form-group col-sm-6 ">
                        <label for="AddressEn" class="control-label">آدرس انگلیسی مشتری</label>
                        <textarea id="AddressEn" name="AddressEn" class="form-control"
                                  placeholder="آدرس انگلیسی مشتری را وارد نمائید">{$objPartner->list['AddressEn']}</textarea>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="Logo" class="control-label">لوگو</label>
                        <input type="file" name="Logo" id="Logo" class="dropify" data-height="100"
                               data-default-file="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$objPartner->list['Logo']}" >
                     </div>

                    <div class="form-group col-sm-6">
                        <label for="Stamp" class="control-label">تصویر مهر / امضاء</label>
                        <input type="file" name="Stamp" id="Stamp" class="dropify" data-height="100"
                               data-default-file="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$objPartner->list['Stamp']}"/>
                    </div>

                    <div class="form-group col-sm-6 ">
                        <label for="AboutMe" class="control-label">درباره ما(مشتری)</label>
                        <textarea id="AboutMe" name="AboutMe" class="form-control"
                                  placeholder="درباره ما(مشتری) را وارد نمائید">{$objPartner->list['AboutMe']}</textarea>
                    </div>

                    
                    

                    <div class="form-group col-sm-12">
                        <label class="control-label">معرفی خدمات</label>
                        <div class="row">

                            <div class="form-group col-sm-12 DynamicAdditionalData">



                                {assign var="AdditionalData" value=$objPartner->list['AdditionalData']}
                                {if $AdditionalData eq ''}
                                    {assign var="AdditionalData" value='[{"title":"","body":""}]'}
                                {/if}
                                {assign var="counter" value='0'}
                                {foreach key=key item=item from=$AdditionalData|json_decode:true}

                                    <div data-target="BaseAdditionalDataDiv" class="col-sm-12 p-0 form-group">
                                        <div class="col-md-3 pr-0">
                                            <input data-parent="AdditionalDataValues" data-target="title" name="AdditionalData[{$counter}][title]" placeholder="عنوان" class="form-control"
                                                   value="{$item.title}" type="text">
                                        </div>
                                        <div class="col-md-8">
                                            <input data-parent="AdditionalDataValues" data-target="body" name="AdditionalData[{$counter}][body]" placeholder="متن نمایش" class="form-control"
                                                   value="{$item.body}" type="text">
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
                                    {assign var="counter" value=$counter+1}
                                {/foreach}

                            </div>
                        </div>
                        
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="control-label">موقعیت روی نقشه</label>
                        <div id="map"></div>

                        <input type="hidden" class="form-control"
                               value="{$objPartner->list['GoogleMapLatitude']}"
                               id="GoogleMapLatitude" name="GoogleMapLatitude"
                               placeholder="GoogleMapLatitude را وارد نمائید">

                        <input type="hidden" class="form-control"
                               value="{$objPartner->list['GoogleMapLongitude']}"
                               id="GoogleMapLongitude" name="GoogleMapLongitude"
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


<script type="text/javascript" src="assets/JsFiles/FlayAppClient.js"></script>
{literal}
    <script type="text/javascript" src="assets/JsFiles/FlayAppClient.js"></script>
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin=""></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ==" crossorigin="" />

    <script>
      const GoogleMapLatitude = $('#GoogleMapLatitude')
      const GoogleMapLongitude = $('#GoogleMapLongitude')

      map = L.map('map').setView([GoogleMapLatitude.val(), GoogleMapLongitude.val()], 8);


      L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
        maxZoom: 18
      }).addTo(map);
      newMarkerGroup = new L.LayerGroup();
      var marker = null;



      marker = L.marker({

        lat: GoogleMapLatitude.val(),
        lng: GoogleMapLongitude.val(),

      }).addTo(map)

      map.on('click', function (e) {
        if (marker !== null) {
          map.removeLayer(marker);
        }
        console.log('e.latlng',e.latlng)

        GoogleMapLatitude.val(e.latlng.lat)
        GoogleMapLongitude.val(e.latlng.lng)

        marker = L.marker(e.latlng).addTo(map);
      });


    </script>
{/literal}
{else}
<script>
    window.location = 'flyAppClient';
</script>
{/if}

