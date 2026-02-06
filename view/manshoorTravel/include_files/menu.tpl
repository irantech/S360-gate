{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
<header class="i_modular_menu header_area">
    <div class="main_header_area animated" id="navbar">
        <div class="parent-header">
            <div class="top-header">
                <div class="container">
                    <div class="nav-header">
                        <h1>منشور صلح پارسیان</h1>
                        <a class="nav-brand" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
                            <img alt="{$obj->Title_head()}" class="__logo_class__"
                                 src="project_files/images/logo.png" />
                        </a>
                        <h2>Manshoor Solh Parsian</h2>
                    </div>
                </div>
            </div>
            <div class="bottom-header">
                <div class="parent-menu">
                    <div class="div-bg-color"></div>
                    <div class="phone-number">
                        <a href="tel:021{$smarty.const.CLIENT_PHONE}"
                           class="__phone_class__ link-number-header mask ">
                            <h3>
                                {*{$smarty.const.CLIENT_PHONE}*}
                                62714
                            </h3>
                            <div class='position-relative'>
                                <h4 class="code-number">021</h4>
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.0" width="" height=""
                                     viewBox="0 0 128.000000 128.000000" preserveAspectRatio="xMidYMid meet">
                                    <g transform="translate(0.000000,128.000000) scale(0.100000,-0.100000)" fill=""
                                       stroke="none">
                                        <path d="M535 1226 c-81 -20 -146 -57 -210 -121 -65 -65 -102 -130 -120 -210 -11 -49 -12 -50 -56 -56 -63 -7 -106 -34 -129 -79 -17 -33 -20 -59 -20 -170 0 -155 14 -196 80 -230 42 -22 162 -28 190 -10 12 8 16 53 20 267 5 253 6 259 31 314 37 79 90 133 167 171 59 29 76 33 152 33 71 0 94 -4 141 -26 79 -37 133 -90 171 -167 l33 -66 3 -257 c3 -244 2 -260 -18 -298 -25 -50 -81 -81 -144 -81 -40 0 -47 3 -61 30 -18 35 -81 70 -125 70 -76 0 -150 -74 -150 -150 0 -74 76 -150 149 -150 45 0 108 35 126 70 14 27 20 30 63 30 108 0 217 71 243 159 12 39 14 41 51 41 55 0 109 31 136 78 20 36 22 54 22 171 0 112 -3 138 -20 171 -23 45 -66 72 -129 79 -44 6 -45 7 -56 56 -53 236 -302 389 -540 331z m-345 -636 l0 -150 -29 0 c-54 0 -61 18 -61 150 0 132 7 150 61 150 l29 0 0 -150z m974 134 c13 -12 16 -40 16 -134 0 -132 -7 -150 -61 -150 l-29 0 0 150 0 150 29 0 c16 0 37 -7 45 -16z m-490 -500 c31 -30 9 -84 -34 -84 -10 0 -26 7 -34 16 -31 30 -9 84 34 84 10 0 26 -7 34 -16z" />
                                    </g>
                                </svg>
                            </div>

                        </a>
                    </div>
                    <nav class="navigation" id="navigation1">
                        <div class="nav-menus-wrapper">
                            <ul class="nav-menu align-to-right">

                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/flight">پرواز</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/hotel">هتل</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/tour">تور</a>
                                    <ul class="nav-dropdown">
                                        <li><a href="javascript:">خارجی</a>
                                            <ul class="nav-dropdown">


                                                {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCountries('yes' , false , 31, 'notLike')}
                                                    <li>
                                                        <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$item_tour.id}-all/all/all">
                                                            {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                                        </a>
                                                        {if $item_tour['city_list']}
                                                            <ul class="nav-dropdown ">

                                                                {foreach $item_tour['city_list'] as $city }
                                                                    <li>
                                                                        <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$item_tour.id}-{$city['id']}/all/all">
                                                                            {$city['name']}
                                                                        </a>
                                                                    </li>
                                                                {/foreach}
                                                            </ul>
                                                        {/if}
                                                    </li>
                                                {/foreach}

                                            </ul>
                                        </li>

                                        <li><a href="javascript:">داخلی</a>
                                            <ul class="nav-dropdown">
                                                {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCities('=1', 'return')}
                                                    <li>
                                                        <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-{$item_tour.id}/all/all">
                                                            {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                                        </a>
                                                    </li>
                                                {/foreach}
                                                <li class="other-tour">
                                                    <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-all/all/all/0">
                                                        همه تورها
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
{*                                        <li><a href="javascript:">تور های لحظه آخری</a></li>*}
                                    </ul>
                                </li>

                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/insurance">بیمه</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری خرید</a></li>
{*                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/visa">ویزا</a></li>*}
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/mag">مجله گردشگری</a></li>

{*                                <li><a href="{$smarty.const.ROOT_ADDRESS}/gallery">گالری</a></li>*}
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/convertDate" target="_blank">تبدیل
                                        تاریخ</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">آژانس ما</a>
                                </li>
                            </ul>
                        </div>
                        <div class="nav-toggle"></div>
                    </nav>

                    <div class="login">
                        <a class="__login_register_class__   {if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}link-number-header{/if} mask "
                           href='{if $obj_main_page->isLogin()}javascript:{else}{$smarty.const.ROOT_ADDRESS}/authenticate{/if}'>
                            <i class="far fa-user ml-1 mobileloginicon"></i>
                            <span>
                        <span>{include file="../../include/signIn/topBarName.tpl"}</span>
                            </span>
                        </a>
                        <div class="main-navigation__sub-menu2 arrow-up show-content-box-login-js" style="display: none">
                            {include file="../../include/signIn/topBar.tpl"}
                        </div>

                    </div>
                    <div class="div-bg-color"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="float-sm">
        {load_presentation_object filename="aboutUs" assign="objAbout"}
        {assign var="about"  value=$objAbout->getData()}
        {assign var="socialLinks"  value=$about['social_links']|json_decode:true}
        {assign var="socialLinksArray" value=['telegram'=>'telegramHref','whatsapp'=> 'whatsappHref','instagram' => 'instagramHref','aparat' => 'aparatHref','youTube' => 'youtubeHref','facebook' => 'facebookHref','linkedin' => 'linkeDinHref']}

        {foreach $socialLinks as $key => $val}
            {assign var=$socialLinksArray[$val['social_media']] value=$val['link']}
        {/foreach}
        <a class="text-white d-flex align-items-center fl-fl float-TEX" href="{$smarty.const.ROOT_ADDRESS}/page/travel" target="_blank">
            <i class="fa-solid fa-users"></i>
            <div>سفر کلید فهم زندگی است</div>
            <img alt="img" class="fixed-menu1" src="project_files/images/fixed-menu.png" />
        </a>
        <a class="text-white d-flex align-items-center SMTelegram fl-fl float-gp" href="{if $telegramHref}{$telegramHref}{/if}" target="_blank">
            <i class="fab fa-telegram"></i>
            <div>تلگرام</div>
            <img alt="img" class="fixed-menu1" src="project_files/images/fixed-menu2.png" />
        </a>
        <a class="text-white d-flex align-items-center SMWhatsApp fl-fl float-rs" href="{if $whatsappHref}{$whatsappHref}{/if}" target="_blank">
            <i class="fab fa-whatsapp"></i>
            <div>واتساپ</div>
            <img alt="img" class="fixed-menu1" src="project_files/images/fixed-menu3.png" />
        </a>
        <div class="fl-fl fl-flinstagram float-ig text-white d-flex align-items-center" href="">
            <a class="SMInstageram d-flex align-items-center" href="{if $instagramHref}{$instagramHref}{/if}" style="font-size: 12px">
                <i class="fab fa-instagram"></i>
                <div>msptrip</div>
                <img alt="img" class="fixed-menu1" src="project_files/images/fixed-menu4.png" />
            </a>
            <a class="SMInstageram2 d-flex align-items-center" href="{if $instagramHref}{$instagramHref}{/if}" style="font-size: 12px">
                <i class="fab fa-instagram"></i>
                <div>msptravel.ir</div>
            </a>
        </div>
    </div>
</header>