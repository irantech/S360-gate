{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
<header class="i_modular_menu header_area">
    <div class="main_header_area animated" id="navbar">
        <div class="container-fluid">
            <nav class="navigation" id="navigation1">
                <div class="parent-logo-menu">
                    <a class="nav-header" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
                        <img alt="{$obj->Title_head()}" class="__logo_class__ logo"
                             src="project_files/images/logo.png" />
                        <!--                            <div class="logo-caption">-->
                        <!--                                <img class="title-logo" src="project_files/images/title-logo.png" alt="title-logo">-->
                        <!--                                <h1>-->
                        <!--                                    <span class="sub-span">  آژانس مسافرتی </span>-->
                        <!--                                </h1>-->
                        <!--                            </div>-->
                    </a>
                    <div class="nav-menus-wrapper">
                        <ul class="nav-menu align-to-right">
                            <li>
                                <a href="javascript:">خدمات مسافرتی</a>
                                <ul class="nav-dropdown nav-submenu">
                                    <li>
                                        <a class="parent-sub-menu"
                                           href="{$smarty.const.ROOT_ADDRESS}/page/InternalFlight">
                                            <i class="fa-solid fa-plane-up"></i>
                                            <span class="title-menus">پرواز داخلی</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="parent-sub-menu"
                                           href="{$smarty.const.ROOT_ADDRESS}/page/ExternalFlight">
                                            <i class="fa-solid fa-plane-circle-check"></i>
                                            <span class="title-menus">پرواز خارجی</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="parent-sub-menu"
                                           href='{$smarty.const.ROOT_ADDRESS}/page/internal-hotel'>
                                            <i class="fa-solid fa-hotel"></i>
                                            <span class="title-menus">هتل داخلی</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="parent-sub-menu"
                                           href='{$smarty.const.ROOT_ADDRESS}/page/international-hotel'>
                                            <i class="fa-solid fa-bed-empty"></i>
                                            <span class="title-menus">هتل خارجی</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a>تور</a>
                                <ul class="nav-dropdown   ">

                                        <li>
                                        <a href="">تور داخلی</a>
                                        {if $objResult->ReservationTourCities('=1', 'return')}
                                            <ul class="nav-dropdown my-dropdown">
                                                {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCities('=1', 'return')}
                                                    <li class="">
                                                        <a class="link-drop"
                                                           href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-{$item_tour.id}/all/all">
                                          <span class="navs-text">
                                                {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                            </span>
                                            </a>
                                                    </li>
                                                {/foreach}
                                            </ul>
                                        {/if}
                                    </li>
                                    <li>
                                        <a href="">تور خارجی</a>
                                        {if $objResult->ReservationTourCountries('yes' , false )}
                                            <ul class="nav-dropdown my-dropdown">

                                                {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCountries('yes' , false , 31, 'notLike')}
                                                    <li class="">
                                                        <a class="link-drop"
                                                           href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$item_tour.id}-all/all/all">
                                           <span class="navs-text">
                                                 {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                            </span>
                                                        </a>
                                                    </li>
                                                {/foreach}
                                            </ul>
                                        {/if}
                                        </li>
                                    <li class="other-tour">
                                        <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">
                                            همه تورها
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="{$smarty.const.ROOT_ADDRESS}/page/visa">ویزا</a>
                            </li>
                            <li>
                                <a href="{$smarty.const.ROOT_ADDRESS}/page/insurance">بیمه</a>
                            </li>
                            <li>
                                <a href="{$smarty.const.ROOT_ADDRESS}/mag">وبلاگ</a>
                            </li>
                            <li>
                                <a href="{$smarty.const.ROOT_ADDRESS}/news">اخبار</a>
                            </li>
                            <li>
                                <a href="javascript:">بیلیتیوم</a>
                                <ul class="nav-dropdown nav-submenu">
                                    <li><a href="{$smarty.const.ROOT_ADDRESS}/club">باشگاه مشتریان بیلیتیوم</a></li>
                                    <li><a href="{$smarty.const.ROOT_ADDRESS}/rules">قوانین و مقررات</a></li>
                                    <li><a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">درباره ما بیلیتیوم</a></li>
                                    <li><a href="{$smarty.const.ROOT_ADDRESS}/contactUs">تماس با ما</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="parent-btn-header">
                    <a class="btn-follow" href="{$smarty.const.ROOT_ADDRESS}/UserTracking">
                        <svg viewbox="0 0 640 512" xmlns="http://www.w3.org/2000/svg">
                            <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path d="M32 128V384C32 401.7 46.33 416 64 416H338.2L330.2 448H64C28.65 448 0 419.3 0 384V128C0 92.65 28.65 64 64 64H512C547.3 64 576 92.65 576 128V192C565.1 191.7 554.2 193.6 544 197.6V128C544 110.3 529.7 96 512 96H64C46.33 96 32 110.3 32 128V128zM368 288C376.8 288 384 295.2 384 304C384 312.8 376.8 320 368 320H112C103.2 320 96 312.8 96 304C96 295.2 103.2 288 112 288H368zM96 208C96 199.2 103.2 192 112 192H464C472.8 192 480 199.2 480 208C480 216.8 472.8 224 464 224H112C103.2 224 96 216.8 96 208zM537.5 241.4C556.3 222.6 586.7 222.6 605.4 241.4L622.8 258.7C641.5 277.5 641.5 307.9 622.8 326.6L469.1 480.3C462.9 486.5 455.2 490.8 446.8 492.1L371.9 511.7C366.4 513 360.7 511.4 356.7 507.5C352.7 503.5 351.1 497.7 352.5 492.3L371.2 417.4C373.3 408.9 377.7 401.2 383.8 395.1L537.5 241.4zM582.8 264C576.5 257.8 566.4 257.8 560.2 264L535.3 288.8L575.3 328.8L600.2 303.1C606.4 297.7 606.4 287.6 600.2 281.4L582.8 264zM402.2 425.1L389.1 474.2L439 461.9C441.8 461.2 444.4 459.8 446.4 457.7L552.7 351.4L512.7 311.5L406.5 417.7C404.4 419.8 402.9 422.3 402.2 425.1L402.2 425.1z"></path>
                        </svg>
                        <span>پیگیری خرید</span>
                    </a>
                    <a class="__phone_class__ btn-phone-number"
                       href="tel:{$smarty.const.CLIENT_PHONE}"><i class="fa-solid fa-headphones-simple"></i></a>

                    <a class="__login_register_class__ button btn-user {if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if}"
                       href="{if $obj_main_page->isLogin()}javascript:{else}{$smarty.const.ROOT_ADDRESS}/authenticate{/if}">
                        <svg class="" data-v-640ab9c6="" fill="" viewbox="0 0 24 24">
                            <path d="M17.25 12.75A3.75 3.75 0 0 1 21 16.5v3.75a.75.75 0 0 1-.75.75H3.75a.75.75 0 0 1-.75-.75V16.5a3.75 3.75 0 0 1 3.75-3.75h10.5Zm0 1.5H6.75A2.25 2.25 0 0 0 4.5 16.5v3h15v-3a2.25 2.25 0 0 0-2.118-2.246l-.132-.004ZM12 3a4.5 4.5 0 1 1 0 9 4.5 4.5 0 1 1 0-9Zm0 1.5a3 3 0 1 0-.001 5.999A3 3 0 0 0 12 4.5Z"
                                  fill-rule="evenodd"></path>
                        </svg>
                        <span>{include file="../../include/signIn/topBarName.tpl"}</span>
                    </a>
                    <div class="main-navigation__sub-menu2 arrow-up show-content-box-login-js" style="display: none">
                        {include file="../../include/signIn/topBar.tpl"}
                    </div>
                </div>
                <div class="nav-toggle"></div>
            </nav>
        </div>
    </div>
</header>

{load_presentation_object filename="aboutUs" assign="objAbout"}
{assign var="about"  value=$objAbout->getData()}
{assign var="socialLinks"  value=$about['social_links']|json_decode:true}
{assign var="socialLinksArray" value=['telegram'=>'telegramHref','whatsapp'=> 'whatsappHref','instagram' => 'instagramHref', 'aparat' => 'aparatHref']}

{foreach $socialLinks as $key => $val}
    {assign var=$socialLinksArray[$val['social_media']] value=$val['link']}
{/foreach}
<div class="float-sm">
    <div class="fl-fl float-gp">
        <a href="{if $telegramHref}{$telegramHref}{else}javascript:;{/if}" target="_blank">
            <i class="fab fa-telegram"></i>            به ما ملحق شو!
        </a>
    </div>
    <div class="fl-fl float-tm">
        <a href="tel:{$smarty.const.CLIENT_MOBILE}" target="_blank">
            <i class="fa-regular fa-phone"></i>            تماس با ما!
        </a>
    </div>
    <div class="fl-fl float-ig">
        <a href="{if $instagramHref}{$instagramHref}{else}javascript:;{/if}" target="_blank">
            <i class="fab fa-instagram"></i>ما رو دنبال کن!
        </a>
    </div>
    <div class="fl-fl float-rs">
        <a href="{if $whatsappHref}{$whatsappHref}{else}javascript:;{/if}" target="_blank">
            <i class="fab fa-whatsapp"></i>ارتباط با پشتیبانی!
        </a>
    </div>

</div>