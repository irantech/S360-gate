{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
<header class="i_modular_menu header-gisoo">
    <div class="parent-user-follow">
        <i class="fa-regular fa-bars my-bars-gisoo"></i>
        <a class="parent-btn-follow" href="{$smarty.const.ROOT_ADDRESS}/UserTracking">
            <span>پیگیری خرید</span>
            <svg viewbox="0 0 640 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M32 128V384C32 401.7 46.33 416 64 416H338.2L330.2 448H64C28.65 448 0 419.3 0 384V128C0 92.65 28.65 64 64 64H512C547.3 64 576 92.65 576 128V192C565.1 191.7 554.2 193.6 544 197.6V128C544 110.3 529.7 96 512 96H64C46.33 96 32 110.3 32 128V128zM368 288C376.8 288 384 295.2 384 304C384 312.8 376.8 320 368 320H112C103.2 320 96 312.8 96 304C96 295.2 103.2 288 112 288H368zM96 208C96 199.2 103.2 192 112 192H464C472.8 192 480 199.2 480 208C480 216.8 472.8 224 464 224H112C103.2 224 96 216.8 96 208zM537.5 241.4C556.3 222.6 586.7 222.6 605.4 241.4L622.8 258.7C641.5 277.5 641.5 307.9 622.8 326.6L469.1 480.3C462.9 486.5 455.2 490.8 446.8 492.1L371.9 511.7C366.4 513 360.7 511.4 356.7 507.5C352.7 503.5 351.1 497.7 352.5 492.3L371.2 417.4C373.3 408.9 377.7 401.2 383.8 395.1L537.5 241.4zM582.8 264C576.5 257.8 566.4 257.8 560.2 264L535.3 288.8L575.3 328.8L600.2 303.1C606.4 297.7 606.4 287.6 600.2 281.4L582.8 264zM402.2 425.1L389.1 474.2L439 461.9C441.8 461.2 444.4 459.8 446.4 457.7L552.7 351.4L512.7 311.5L406.5 417.7C404.4 419.8 402.9 422.3 402.2 425.1L402.2 425.1z"></path></svg>
        </a>
        <a class="parent-btn-user
           {if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if}" href="{if $obj_main_page->isLogin()}javascript:{else}{$smarty.const.ROOT_ADDRESS}/authenticate{/if}"
        >
            <svg class="" data-v-640ab9c6="" fill="" viewbox="0 0 24 24"><path d="M17.25 12.75A3.75 3.75 0 0 1 21 16.5v3.75a.75.75 0 0 1-.75.75H3.75a.75.75 0 0 1-.75-.75V16.5a3.75 3.75 0 0 1 3.75-3.75h10.5Zm0 1.5H6.75A2.25 2.25 0 0 0 4.5 16.5v3h15v-3a2.25 2.25 0 0 0-2.118-2.246l-.132-.004ZM12 3a4.5 4.5 0 1 1 0 9 4.5 4.5 0 1 1 0-9Zm0 1.5a3 3 0 1 0-.001 5.999A3 3 0 0 0 12 4.5Z" fill-rule="evenodd"></path></svg>

        <span>{include file="../../include/signIn/topBarName.tpl"}</span>
        </a>
        <div class="main-navigation__sub-menu2 arrow-up show-content-box-login-js" style="display: none">
            {include file="../../include/signIn/topBar.tpl"}
        </div>
    </div>
    <div class='title-header'>
        <h3>
            <span class="safar">سفری آسان</span>
            <span class="ba">با</span>
            <span class="suuny">سانی تور</span>
        </h3>
    </div>
    <a class="parent-logo" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
        <img alt="{$obj->Title_head()}" src="project_files/images/logo.png"/>
    </a>
</header>