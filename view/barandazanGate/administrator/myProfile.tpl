{load_presentation_object filename="partner" assign="objPartner"}

<style>
    #map {
        height: 380px;
        display: flex;
        flex-wrap: wrap;
        width: 100%;
    }
    .bootstrap-select.btn-group .dropdown-toggle .filter-option {
        text-align: right;
    }
    .btn-default, .btn-default.disabled {
        background: #fff;
        border: 1px solid #d7d0d0;
    }

</style>


{$objPartner->showedit($smarty.const.CLIENT_ID)}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="active">ویرایش پروفایل </li>
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
                <h3 class="box-title m-b-0">ویرایش پروفایل </h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید  اطلاعات خود را در سیستم ویرایش  نمائید</p>

                <form id="EditProfile" method="post">
                    <input type="hidden" name="flag" value="update_client">
                    <input type="hidden" name="client_id" value="{$smarty.const.CLIENT_ID}">
                    <div class="form-group col-sm-6 ">

                        <label for="AgencyName" class="control-label">نام و نام خانوادگی </label>
                        <input type="text" class="form-control" id="AgencyName" name="AgencyName"
                               placeholder="نام کامل  را وارد نمائید" value="{$objPartner->list['AgencyName']}">
                    </div>


                    <div class="form-group col-sm-6">
                        <label for="Email" class="control-label">ایمیل </label>
                        <input type="email" class="form-control" id="Email" name="Email"
                               placeholder="ایمیل  را وارد نمائید" value="{$objPartner->list['Email']}">
                    </div>


                    <div class="form-group col-sm-6">
                        <label for="Manager" class="control-label">نام مدیر </label>
                        <input type="text" class="form-control" id="Manager" name="Manager"
                               placeholder="نام مدیر را وارد نمائید" value="{$objPartner->list['Manager']}">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="Phone" class="control-label">تلفن ثابت  </label>
                        <input type="text" class="form-control" id="Phone" name="Phone"
                               placeholder="تلفن ثابت  را وارد نمائید" value="{$objPartner->list['Phone']}">

                    </div>

                    <div class="form-group col-sm-6 ">
                        <label for="Address" class="control-label">آدرس </label>
                        <textarea id="Address" name="Address" class="form-control"
                                  placeholder="آدرس  را وارد نمائید">{$objPartner->list['Address']}</textarea>
                    </div>

                    <div class="form-group col-sm-6 ">
                        <label for="AddressEn" class="control-label">آدرس انگلیسی </label>
                        <textarea id="AddressEn" name="AddressEn" class="form-control"
                                  placeholder="آدرس انگلیسی  را وارد نمائید">{$objPartner->list['AddressEn']}</textarea>
                    </div>

                    <div class="form-group col-sm-6 ">
                        <label for="AboutMe" class="control-label">درباره ما</label>
                        <textarea id="AboutMe" name="AboutMe" class="form-control"
                                  placeholder="درباره ما را وارد نمائید">{$objPartner->list['AboutMe']}</textarea>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="Stamp" class="control-label">تصویر مهر / امضاء</label>
                        <input type="file" name="Stamp" id="Stamp" class="dropify" data-height="100"
                               data-default-file="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$objPartner->list['Stamp']}" >
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="Logo" class="control-label">لوگو</label>
                        <input type="file" name="Logo" id="Logo" class="dropify" data-height="100"
                               data-default-file="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$objPartner->list['Logo']}" >
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="Mobile" class="control-label">تلفن همراه  </label>
                        <br/>
                        <small class="blink_me">(تمام اطلاع رسانی های سیستم در موارد کنسلی پرواز ها ،تاخیر ها و تعجیل ها به این شماره موبایل پیامک میشود، لطفا دقت فرمائید، پیامک تبلیغاتی این شماره مسدود نباشد)</small>
                        <input type="text" class="form-control" id="Mobile" name="Mobile"
                               placeholder="تلفن همراه مدیر  را وارد نمائید" value="{$objPartner->list['Mobile']}">

                    </div>


                    <div class="form-group col-sm-12">
                        <label class="control-label">اطلاعات تماس</label>
                        <div class="row">

                            <div class="form-group col-sm-12 DynamicAdditionalData">



                                {assign var="AdditionalData" value=$objPartner->list['AdditionalData']}

                            {if $AdditionalData eq ''}
                                    {assign var="AdditionalData" value='[{"title":"", "icon":"","body":""}]'}
                                {/if}

                                {assign var="counter" value='0'}
                                {foreach key=key item=item from=$AdditionalData|json_decode:true}

                                    <div data-target="BaseAdditionalDataDiv" class="col-sm-12 p-0 form-group">
                                        <div class="col-md-2 pr-0">
                                            <input data-parent="AdditionalDataValues" data-target="title" name="AdditionalData[{$counter}][title]" placeholder="عنوان" class="form-control"
                                                   value="{$item.title}" type="text">
                                        </div>
                                        <div class="col-md-2 pr-0">
                                            <select dir="rtl" data-parent="AdditionalDataValues"  data-target="language" name="AdditionalData[{$counter}][language]" class="form-control selectpicker" style='' >
                                                {foreach $languages as $value=>$title}
                                                    <option value="{$value}" {if $item.language eq $value} selected {/if}>{$title}</option>
                                                {/foreach}
                                            </select>
                                        </div>
                                        <div class="col-md-2 pr-0">
                                            <select  dir="rtl" data-parent="AdditionalDataValues" data-target="type"  name="AdditionalData[{$counter}][type]" class="form-control selectpicker" style=''>
                                                <option value=''>انتخاب کنید...</option>
                                                <option value='tel' {if $item.type=='tel'}selected {/if}>تماس</option>
                                                <option value='mail' {if $item.type=='mail'}selected {/if}>ایمیل</option>
                                                <option value='social' {if $item.type=='social'}selected {/if}>شبکه اجتماعی</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 pr-0">
                                            <select  dir="rtl" data-parent="AdditionalDataValues" data-target="icon"  name="AdditionalData[{$counter}][icon]" class="form-control selectpicker" style=''>
                                                <option value=''>انتخاب کنید...</option>
                                                <option {if $item.icon=='fa fa-phone'}selected {/if} value='fa fa-phone' data-content="<i class='size10 fa fa-phone' aria-hidden='true'></i> تلفن"></option>
                                                <option {if $item.icon=='fa fa-mobile'}selected {/if} value='fa fa-mobile' data-content="<i class='size10 fa fa-mobile' aria-hidden='true'></i> موبایل"></option>
                                                <option {if $item.icon=='fa fa-home'}selected {/if} value='fa fa-home' data-content="<i class='size10 fa fa-home' aria-hidden='true'></i> آدرس"></option>
                                                <option {if $item.icon=='fa fa-envelope'}selected {/if} value='fa fa-envelope' data-content="<i class='size10 fa fa-envelope' aria-hidden='true'></i> ایمیل"></option>
                                                <option {if $item.icon=='fa-brands fa-instagram'}selected {/if} value='fa-brands fa-instagram' data-content="<i class='size10 fa fa-instagram' ></i> اینستاگرام"></option>
                                                <option {if $item.icon=='fa fa-whatsapp'}selected {/if} value='fa fa-whatsapp' data-content="<i class='size10 fa fa-whatsapp' ></i> واتساپ"></option>
                                                <option {if $item.icon=='fa-brands fa-telegram'}selected {/if} value='fa-brands fa-telegram' data-content="<i class='size10 fa fa-paper-plane' ></i> تلگرام"></option>

                                            </select>
                                        </div>
                                        <div class="col-md-3">
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
