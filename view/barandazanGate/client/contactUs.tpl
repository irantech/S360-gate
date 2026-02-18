{load_presentation_object filename="contactUs" assign="objContact"}
{load_presentation_object filename="aboutUs" assign="objAbout"}
{assign var="about"  value=$objAbout->getData()}
{load_presentation_object filename="faqs" assign="objFaq"}
{assign var="send_data" value=['limit'=>10 , 'service' =>'contactUs', 'order' => 'DESC']}
{assign var='list_faq' value=$objFaq->getByPosition($send_data)}

{if $smarty.const.SOFTWARE_LANG eq 'en'}
    <link rel='stylesheet' href='assets/styles/css/modules-en/contactUs-en.css'>
{else}
    <link rel='stylesheet' href='assets/modules/css/contactUs.css'>
{/if}

<script>
  $(".content_tech > .container").removeClass("container")
  $(".content_tech").addClass("p-0")

</script>
<div class='parent-banner'>
<div class='contactUs-img'>
    <img src='assets/images/contact-us-banner.jpg'>
    <div class='container'>
        <div class='contactUs-title'>
    <h2>##Contactus##</h2>
            <p>##suggestionorrequest##</p>
            <p>##supportteamwillrespond##</p>
        </div>
    </div>
</div>
<div class='container'>
        <div class='contactUs-box d-flex flex-wrap align-items-start w-100'>
            <div class='contactUs-info w-100 col-lg-6 col-12'>
                <div class='contactUs-info-parent w-100'>
                    <p class='contactUs-info-title'>##KeepInTouchtwo##</p>
                    {assign var='additional_data' value=$smarty.const.ADDITIONAL_DATA|json_decode:true}
                    {foreach $additional_data as $item}
                        {*                {$item['language']}*}
                        {if  $item['language'] eq $smarty.const.SOFTWARE_LANG || $item['language'] eq ''}
                        <div class=''>
                            <div class='contactUs_mainDiv site-main-bg-color-h'>
                                {if $item['icon'] }
                                    <span>
                            <i class="{$item['icon']}  site-border-main-color site-main-text-color"></i>
                                </span>
                                {else}
                                    <span>
                          <i class='far fa-bookmark site-border-main-color site-main-text-color'></i>
                            </span>
                                {/if}
                                <a {if $item['type']=='tel'} href='tel:{$item['body']}' {elseif $item['type']=='mail'} href="mailto:{$item['body']}" {elseif $item['type']=='social'} href='{$item['body']}' target='_blank' {else} href='javascript:' {/if}>
                                    <h2 class='site-main-text-color'>
                                        {$item['title']}

                                    </h2>
                                    <p>{$item['body']}</p>
                                </a>
                            </div>
                        </div>
                        {/if}
                    {/foreach}
                </div>
                <div class='contactUs-socila'>
                    <p>##Followusonsocial##</p>

                    {assign var="socialLinks"  value=$about['social_links']|json_decode:true}
                    {assign var="socialLinksArray" value=['telegram'=>'telegramHref','whatsapp'=> 'whatsappHref','instagram' => 'instagramHref','aparat' => 'aparatHref','youTube' => 'youtubeHref','facebook' => 'facebookHref','linkedin' => 'linkeDinHref' , 'twitter' => 'twitterHref' , 'twitter' => 'twitterHref' , 'bale' => 'baleHref' , 'ita' => 'itaHref']}

                    {foreach $socialLinks as $key => $val}
                        {assign var=$socialLinksArray[$val['social_media']] value=$val['link']}
                    {/foreach}
                    <div class='contactUs-socila-parent'>
                        <a class='tooltip-social' href='{if $telegramHref}{$telegramHref}{/if}' target='_blank'>
                            <i class="fa-brands fa-telegram"></i>
                            <span class="tooltiptext-social">##Telegram##
                        <i class="fa-sharp fa-solid fa-triangle"></i>
                        </span>
                        </a>
                        <a class='tooltip-social' href='{if $instagramHref}{$instagramHref}{/if}' target='_blank'>
                            <i class="fa-brands fa-instagram"></i>
                            <span class="tooltiptext-social">##Instagram##
                              <i class="fa-sharp fa-solid fa-triangle"></i>
                            </span>
                        </a>
                        <a class='tooltip-social' href='{if $whatsappHref}{$whatsappHref}{/if}' target='_blank'>
                            <i class="fa-brands fa-whatsapp"></i>
                            <span class="tooltiptext-social">##Whatsapp##
                                <i class="fa-sharp fa-solid fa-triangle"></i>
                            </span>
                        </a>
                        <a class='tooltip-social' href='{if $youtubeHref}{$youtubeHref}{/if}' target='_blank'>
                            <i class="fa-brands fa-youtube"></i>
                            <span class="tooltiptext-social">##Youtube##
                                <i class="fa-sharp fa-solid fa-triangle"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class='contactUs-form col-lg-6 col-12'>
                <div class='d-flex flex-wrap'>
                    <p class='contactUs-form-title'>##contactSendMessage##</p>
                    <form id="fcf-form-id" class='d-flex flex-wrap w-100 '>
                        {*                    <h1 class='w-100 font-20 my-4'>##KeepInTouch##</h1>*}
                        <div class="form-group p-0 mb-0 col-12">
                            <label for="exampleInputEmail1">##Namefamily##</label>
                            {if $objSession->IsLogin() }
                                <input placeholder='##Namefamily##' type="text" name="contactUs-name" disabled id="contactUs-name" value="{$objSession->getNameUser()}" class="form-control input_contactUs" required>
                            {else}
                                <input placeholder='##Namefamily##' type="text" name="contactUs-name" id="contactUs-name"
                                       class="form-control input_contactUs" required>
                            {/if}
                        </div>
                        <div class="form-group p-0 mb-0 col-12">
                            <label for="exampleInputEmail1">##Mobile##</label>
                            <input placeholder='##Phonenumber##' type="number" min="0" id="contactUs-phone" name="contactUs-phone" class="form-control input_contactUs" required>
                        </div>
                        <div class="form-group p-0 mb-0 col-12">
                            <label for="exampleInputEmail1">##Email##</label>
                            <input placeholder='##Email##' type="email" id="contactUs-Email" name="contactUs-Email" class="form-control input_contactUs" required>
                        </div>
                        <div class="form-group p-0 mb-0 col-12">
                            <label for="exampleInputEmail1">##contactMessage##</label>
                            <textarea placeholder='##Enterthetext##' id="contactUs-Message" name="contactUs-Message" class="form-control textarea_contactUs" rows="4" maxlength="3000" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-contactus btn-block btn-primary site-main-button-color">##Register##</button>
                    </form>
                </div>
            </div>
        </div>
        <div>
            {if $list_faq|count > 0}
            <div class="Questions">
                <div class="Questions-title">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.496 6.033h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286a.237.237 0 0 0 .241.247m2.325 6.443c.61 0 1.029-.394 1.029-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94 0 .533.425.927 1.01.927z"></path>
                        </svg>
                        <h2>##FaqPage##</h2>
                    </div>
                    <a href='{$smarty.const.ROOT_ADDRESS}/faq'>
                        <p>##All##</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5"></path>
                        </svg>
                    </a>
                </div>
                <div class='row'>
                    <div class="Questions-parent col-md-12 col-lg-6" id="accordionExample">
                        {foreach $list_faq as $key => $item}
                            {if $key % 2 == 0}
                        <button class="card Questions-item collapsed" type="button" data-toggle="collapse" data-target="#collapse{$item['id']}" aria-expanded="true" aria-controls="collapse{$item['id']}">
                            <div class="card-header Question-header" id="heading{$item['id']}">
                                <h2 class="mb-0">
                                    <div class="Question-txt">
                                        <img src='assets/images/help.png'>
                                        <div class=" Question-btn btn btn-link btn-block text-left collapsed">
                                            {$item['title']}
                                        </div>
                                        <span class="Question-icon">
                                <svg viewBox="0 0 24 24" fill="currentColor" class="block Question-icon-svg"><path d="M21.266 7.302a.75.75 0 0 1 1.037 1.08l-.069.066-9.75 8.25a.75.75 0 0 1-.89.058l-.078-.058-9.75-8.25a.75.75 0 0 1 .893-1.202l.075.056L12 15.142l9.266-7.84Z"></path></svg>
                                  </span>
                                    </div>
                                </h2>
                            </div>
                            <div id="collapse{$item['id']}" class="collapse" aria-labelledby="heading{$item['id']}" data-parent="#accordionExample">
                                <div class="card-body">
                                    {$item['content']}
                                </div>
                            </div>
                        </button>
                            {/if}
                        {/foreach}

                    </div>
                    <div class='col-md-12 col-lg-6'>
                        {foreach $list_faq as $key => $item}
                            {if $key % 2 == 1}
                        <button class="card Questions-item collapsed" type="button" data-toggle="collapse" data-target="#collapse{$item['id']}" aria-expanded="true" aria-controls="collapse{$item['id']}">
                            <div class="card-header Question-header" id="heading{$item['id']}">
                                <h2 class="mb-0">
                                    <div class="Question-txt">
                                        <img src='assets/images/help.png'>
                                        <div class=" Question-btn btn btn-link btn-block text-left collapsed">
                                            {$item['title']}
                                        </div>
                                        <span class="Question-icon">
                                <svg viewBox="0 0 24 24" fill="currentColor" class="block Question-icon-svg"><path d="M21.266 7.302a.75.75 0 0 1 1.037 1.08l-.069.066-9.75 8.25a.75.75 0 0 1-.89.058l-.078-.058-9.75-8.25a.75.75 0 0 1 .893-1.202l.075.056L12 15.142l9.266-7.84Z"></path></svg>
                                 </span>
                                    </div>
                                </h2>
                            </div>
                            <div id="collapse{$item['id']}" class="collapse" aria-labelledby="heading{$item['id']}" data-parent="#accordionExample">
                                <div class="card-body">
                                    {$item['content']}
                                </div>
                            </div>
                        </button>
                            {/if}
                        {/foreach}

                    </div>
                </div>
            </div>
            {/if}
            <div class='parent-map d-flex flex-wrap align-items-start w-100'>
                <div class="Questions-title">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2024 Fonticons, Inc. --><path d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/></svg>
                        <h2>##Mylocation##</h2>
                    </div>
                </div>
                <div class='d-flex flex-wrap col-12 h_custom p-0'>
                    <div class='w-100 h-100 overflow-hidden'>
                        {if $smarty.const.CLIENT_ID == '308'}
                            <img src='assets/images/contactUs_map.png' alt='contactUs_map'>
                        {else}
                            <div class='w-100 h-100' id='map'></div>
                        {/if}
                    </div>
                </div>
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


{literal}

<!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin=""></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ==" crossorigin="" />

<script>
    {/literal}
    const GoogleMapLatitude = {$smarty.const.CLIENT_MAP_LAT}
    const GoogleMapLongitude = {$smarty.const.CLIENT_MAP_LNG}

    {literal}
    map = L.map('map').setView([GoogleMapLatitude, GoogleMapLongitude], 14 )
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




