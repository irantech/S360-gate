{load_presentation_object filename="contactUs" assign="objContact"}

{if $smarty.const.SOFTWARE_LANG eq 'en'}
    <link rel='stylesheet' href='assets/styles/css/modules-en/contactUs-en.css'>
{else}
    <link rel='stylesheet' href='assets/modules/css/contactUs.css'>
{/if}





<div class='d-flex flex-wrap w-100 parent-contactus'>

    <div class="header_top w-100 mt-4">
        <h3 class="site-main-text-color">##S360Min90##</h3>
    </div>


    <div class='d-flex flex-wrap align-items-start mt-lg-5 mt-5 w-100'>

        <div class='w-100'>
            <div class='d-flex flex-wrap'>
                <form id="lastminute-form-id" class='d-flex flex-wrap w-100'>
                    <input type='hidden' name='type' value='lastminute'>
{*                    <h1 class='w-100 font-20 my-4'>##KeepInTouch##</h1>*}
                    <div class="form-group p-2 mb-0 col-lg-6 col-md-6 col-12">
                        {*                    <label for="exampleInputEmail1">##Namefamily##</label>*}
                        {if $objSession->IsLogin() }
                            <input placeholder='##Namefamily##' type="text" name="contactUs-name" disabled id="contactUs-name" value="{$objSession->getNameUser()}" class="form-control input_contactUs" required>
                        {else}
                            <input placeholder='##Namefamily##' type="text" name="contactUs-name" id="contactUs-name"
                                   class="form-control input_contactUs" required>
                        {/if}
                    </div>
                    <div class="form-group p-2 mb-0 col-lg-6 col-md-6 col-12">
                        {*                    <label for="exampleInputEmail1">##Mobile##</label>*}
                        <input placeholder='##Phonenumber##' type="number" min="0" id="contactUs-phone" name="contactUs-phone" class="form-control input_contactUs" required>
                    </div>
                    <div class="form-group p-2 mb-0 col-12">
                        {*                    <label for="exampleInputEmail1">##Email##</label>*}
                        <input placeholder='##Email##' type="email" id="contactUs-Email" name="contactUs-Email" class="form-control input_contactUs" required>
                    </div>
                    <div class="form-group p-2 mb-0 col-12">
                        {*                    <label for="exampleInputEmail1">##contactMessage##</label>*}
                        <textarea placeholder='##Body##...' id="contactUs-Message" name="contactUs-Message" class="form-control textarea_contactUs" rows="4" maxlength="3000" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-contactus btn-block btn-primary py-3 px-5 mx-auto mt-2 text-black site-main-button-color">##Register##</button>
                </form>
            </div>
        </div>
    </div>


{*    <div class='d-flex gap-10 flex-wrap col-md-6 col-sm-12 p-2'>*}
{*        <div class='d-flex overflow-hidden gap-10 flex-wrap w-100 bg-white border border-50 rounded p-0'>*}
{*            <div class='d-block p-3'>*}
{*                <div class='border-50 border-bottom d-flex flex-wrap gap-10 justify-content-center pb-1 w-100'>*}
{*                    <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$smarty.const.CLIENT_LOGO}"*}
{*                         class='d-flex flex-wrap'*}
{*                         style='width: 85px;'*}
{*                         alt='{$smarty.const.CLIENT_NAME}'>*}
{*                    <span class='d-flex flex-wrap font-15 justify-content-center text-center'>*}
{*                        {$smarty.const.CLIENT_NAME}*}
{*                    </span>*}
{*                </div>*}

{*                <div class='overflow-shadow d-flex flex-wrap gap-10 justify-content-center w-100 mb-3'>*}
{*                    {$smarty.const.ABOUT_ME}*}
{*                </div>*}

{*                <div class='d-flex flex-wrap gap-10 justify-content-center w-100 mb-3'>*}
{*                    <a class='btn btn-secondary font-12 p-2' href='{$smarty.const.ROOT_ADDRESS}/aboutUs'>*}

{*                        <svg style='width:12px;fill:white' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">*}
{*                            <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->*}
{*                            <path d="M272 64C263.2 64 256 56.84 256 48C256 39.16 263.2 32 272 32H432C440.8 32 448 39.16 448 48V208C448 216.8 440.8 224 432 224C423.2 224 416 216.8 416 208V86.63L187.3 315.3C181.1 321.6 170.9 321.6 164.7 315.3C158.4 309.1 158.4 298.9 164.7 292.7L393.4 64H272zM0 112C0 85.49 21.49 64 48 64H176C184.8 64 192 71.16 192 80C192 88.84 184.8 96 176 96H48C39.16 96 32 103.2 32 112V432C32 440.8 39.16 448 48 448H368C376.8 448 384 440.8 384 432V304C384 295.2 391.2 288 400 288C408.8 288 416 295.2 416 304V432C416 458.5 394.5 480 368 480H48C21.49 480 0 458.5 0 432V112z" />*}
{*                        </svg>*}
{*                        ##AboutUs##*}
{*                    </a>*}
{*                    <a class='btn btn-secondary font-12 p-2' href='https://{$smarty.const.CLIENT_MAIN_DOMAIN}/faq'>*}
{*                        <svg style='width:12px;fill:white' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">*}
{*                            <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->*}
{*                            <path d="M272 64C263.2 64 256 56.84 256 48C256 39.16 263.2 32 272 32H432C440.8 32 448 39.16 448 48V208C448 216.8 440.8 224 432 224C423.2 224 416 216.8 416 208V86.63L187.3 315.3C181.1 321.6 170.9 321.6 164.7 315.3C158.4 309.1 158.4 298.9 164.7 292.7L393.4 64H272zM0 112C0 85.49 21.49 64 48 64H176C184.8 64 192 71.16 192 80C192 88.84 184.8 96 176 96H48C39.16 96 32 103.2 32 112V432C32 440.8 39.16 448 48 448H368C376.8 448 384 440.8 384 432V304C384 295.2 391.2 288 400 288C408.8 288 416 295.2 416 304V432C416 458.5 394.5 480 368 480H48C21.49 480 0 458.5 0 432V112z" />*}
{*                        </svg>*}

{*                        ##FaqPage##*}
{*                    </a>*}
{*                </div>*}
{*                <div class='d-flex flex-wrap gap-10 w-100 mb-3'>*}
{*                     <span class='d-flex font-12 flex-wrap font-15 w-100 justify-content-center text-center mb-3'>*}
{*                         ##ContactWays##*}
{*                    </span>*}

{*                    <span class='d-flex font-12 flex-wrap font-15 w-100 justify-content-center text-center mb-3'>*}
{*                          ##Address## : {$smarty.const.CLIENT_ADDRESS}*}
{*                     </span>*}

{*                    <div class='d-flex gap-10 flex-wrap col-md-12 p-2'>*}
{*                        {assign var="additional_data" value=$smarty.const.ADDITIONAL_DATA|json_decode:true}*}
{*                        {foreach $additional_data as $item}*}
{*                            <div class='d-grid gap-5 justify-content-center flex-wrap bg-light shadow-sm border border-light rounded p-2'>*}
{*                                <span class="text-muted text-center">{$item['title']}</span>*}
{*                                <span class="text-center">{$item['body']}</span>*}
{*                            </div>*}
{*                        {/foreach}*}
{*                    </div>*}

{*                </div>*}


{*            </div>*}

{*        </div>*}
{*    </div>*}
</div>


{literal}

<!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin=""></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ==" crossorigin="" />

<script>
    {/literal}
    const GoogleMapLatitude = {$smarty.const.CLIENT_MAP_LAT}
    const GoogleMapLongitude = {$smarty.const.CLIENT_MAP_LNG}
    {literal}
    map = L.map('map').setView([GoogleMapLatitude, GoogleMapLongitude], 14)
    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 18,
    }).addTo(map)
    newMarkerGroup = new L.LayerGroup()
    var marker = null
    marker = L.marker({

      lat: GoogleMapLatitude,
      lng: GoogleMapLongitude,

    }).addTo(map)
    setTimeout(() => {
      map.invalidateSize()
    }, "1000")
</script>
{/literal}
{literal}
    <script src="assets/js/customForContactUs.js"></script>
{/literal}




