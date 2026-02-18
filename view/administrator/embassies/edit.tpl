{load_presentation_object filename="embassies" assign="objEmbassies"}
{assign var="embassy" value=$objEmbassies->getEmbassy($smarty.get.id)}
{assign var="countries" value=$objEmbassies->getCountries()}

<div class='container-fluid'>
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/embassies/list">
                        لیست سفارت خانه ها
                    </a>
                </li>
                <li class="active">ویرایش سفارت خانه</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <form id='editEmbassy' class='d-flex flex-wrap w-100' method='post' enctype='multipart/form-data'>

        <div class='col-lg-8'>
            <div class="parent-item-embassies">
                <div class='form-group'>
                    <span class='control-label label-header'>اطلاعات سفارتخانه</span>
                    <div class="parent-embassies-padding d-flex">
                        <div class="col-lg-6 pr-0">
                            <label for="embassyName">نام سفارت خانه</label>
                            <input type='hidden' value='editEmbassy' id='method' name='method'>
                            <input type='hidden' value='embassies' id='className' name='className'>
                            <input type='hidden' value='{$smarty.get.id}' id='id' name='id'>
                            <input type='text' name='embassyName' value='{$embassy[0]['name']}' class='form-control' id='embassyName' placeholder='نام سفارت خانه مد نظر را بنویسید'>
                        </div>

                        <div class="col-lg-6 pl-0">
                           <label for='embassyName'>کشور سفارت خانه</label>
                            <select name="country" class='select2 select-embassy'>
                                {foreach $countries as $country}
                                    <option {if $embassy[0]['country_id'] eq $country.id } selected {/if}
                                            value='{$country.id}'>{$country.titleFa}</option>
                                {/foreach}
                            </select>
                       </div>
                    </div>
                    <div class="parent-embassies-padding">
                        <div class='form-group'>
                              <label for='embassyDescription' class='control-label'>توضیحات</label>
                              <textarea name="embassyDescription" class="form-control" id="embassyDescription"
                                        placeholder="توضیحات مربوط به سفارت خانه را بنویسید">{$embassy[0]['description']}</textarea>
                        </div>
                    </div>
                </div>
            </div>



            <div class="parent-item-embassies">
                <div class='form-group  DynamicAdditionalData'>
                    {assign var="counter" value='0'}
                    <label for='embassyNumber' class='control-label label-header'>شماره تماس</label>
                    {foreach key=key item=item from=$embassy[0]['contact_information']|json_decode:true}
                        <div data-target="baseAdditionalNumber" class="d-flex baseAdditionalNumber align-items-center parent-embassies-padding justify-content-between">
                            <div class='col-lg-8 p-0'>
                                <div class='d-flex'>
                                    <input type='text' required name='embassyNumber[0][title]' value='{$item.title}' data-parent="additionalNumber" data-target='title' class='form-control ml-5' placeholder='عنوان'>
                                    <input type='text' required name='embassyNumber[0][number]' value='{$item.number}' data-parent="additionalNumber" data-target='number' class='form-control' placeholder='متن نمایش'>
                                </div>
                            </div>
                            <div class='col-lg-4 d-flex align-items-center justify-content-end p-0'>
                                <button type='button' onclick="addAdditionalNumber()" class='link-embassy link-plus'>
                                    <span class='fa fa-plus'></span>
                                    افزودن
                                </button>
                                <button type='button' onclick="removeAdditionalNumber($(this))" class='link-embassy link-remove'>
                                    <span class="fa fa-remove"></span>
                                    حذف
                                </button>
                            </div>
                        </div>
                        {assign var="counter" value=$counter+1}
                    {/foreach}
                </div>
            </div>
        </div>

        <div class='col-lg-4'>
            <div class='parent-item-embassies '>
                <div class="form-group">
                    <label for="language" class="control-label">زبان</label>
                    <select name="language" class="form-control" id="language">
                        {foreach $languages as $value=>$title}
                            <option value="{$value}" {if $embassy[0]['language'] eq $value} selected {/if}>{$title}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class='parent-item-embassies'>
                <div class='form-group'>
                    <span  class='control-label label-header'>آدرس</span>
                    <div class='parent-embassies-padding'>
                        <textarea name='embassyAddress' class='form-control' rows="4" id='embassyAddress'
                                  placeholder='آدرس مربوط به سفارت خانه را بنویسید'>{$embassy[0]['address']}</textarea>
                    </div>
                </div>
            </div>
            <div class='parent-item-embassies'>
                <div class='form-group'>
                    <span class='control-label label-header'>موقعیت مکانی سفارت</span>
                    <div class='parent-embassies-padding'>
                        <div id="map" class='d-flex flex-wrap w-100 map-embassies'></div>
                        <input type="hidden" class="form-control" value='{$embassy[0]['lat']}' id="lat" name="lat">
                        <input type="hidden" class="form-control" value='{$embassy[0]['lng']}' id="lng" name="lng">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="parentbtn-btn-fixed d-flex align-items-center justify-content-center w-100">
                <button type="submit" class="btn btn-primary  btn-fixed">ارسال اطلاعات</button>
            </div>
        </div>
        </form>
    </div>


</div>

{literal}
    <script type="text/javascript" src="assets/JsFiles/embassies.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ==" crossorigin="">
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin=""></script>
    <script>
      const default_location = [$('#lat').val(), $('#lng').val()];
      const default_zoom = 15;
      let map = L.map('map');
      map.setView(default_location, default_zoom);
      L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {maxZoom: 19}).addTo(map);
      newMarkerGroup = new L.LayerGroup();
      marker = L.marker(default_location).addTo(map);
      map.on('click', function (e) {
        if (marker !== null) {
          map.removeLayer(marker);
        }
        marker = L.marker(e.latlng).addTo(map);
        let lat = e.latlng.lat;
        let lng = e.latlng.lng;
        $('#lat').val(lat);
        $('#lng').val(lng);
      });

      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          (position) => map.panTo([position.coords.latitude, position.coords.longitude]),
          (err) => console.warn(`Geolocation error (${err.code}): ${err.message}`),
          { timeout: 20000 } // Timeout in ms
        );
      }


    </script>
{/literal}
