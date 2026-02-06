{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
<header class="i_modular_menu header_area">
    <div class="main_header_area animated" id="navbar">
        <nav class="navigation navigation-landscape" id="navigation1">
            <div class="parent-top">
                <div class="container parent-social">
                    {assign var="socialLinks"  value=$about['social_links']|json_decode:true}
                    {assign var="socialLinksArray" value=['telegram'=>'telegramHref','whatsapp'=> 'whatsappHref','instagram' => 'instagramHref','aparat' => 'aparatHref','youTube' => 'youtubeHref','facebook' => 'facebookHref','linkedin' => 'linkeDinHref' , 'twitter' => 'twitterHref']}

                    {foreach $socialLinks as $key => $val}
                        {assign var=$socialLinksArray[$val['social_media']] value=$val['link']}
                    {/foreach}
                    <article class="parent-social-header">
                        <a class="__instagram_class__"  href="{if $instagramHref}{$instagramHref}{/if}" target="_blank">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a class="__telegram_class__" href="{if $telegramHref}{$telegramHref}{/if}" target="_blank">
                            <i class="fa-brands fa-telegram"></i>
                        </a>
                        <a class="__linkdin_class__"  href="{if $linkeDinHref}{$linkeDinHref}{/if}" target="_blank">
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>
                        <a class="__facebook_class__" href="{if $facebookHref}{$facebookHref}{/if}" target="_blank">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                    </article>
                    <article class="parent-email-phone">
                        <div class="email-phone-item">
                            <a class="__email_class__"
                               href="mailto:{$smarty.const.CLIENT_EMAIL}">{$smarty.const.CLIENT_EMAIL}</a>
                            <svg viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"></path>
                            </svg>
                        </div>
                        <div class="email-phone-item">
                            <a class="__phone_class__"
                               href="tel:{$smarty.const.CLIENT_PHONE}">{$smarty.const.CLIENT_PHONE}</a>
                            <svg viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"></path>
                            </svg>
                        </div>
                    </article>
                </div>
            </div>
            <div class="parent-bottom">
                <div class="container parent-bottom-header">
                    <a class="nav-header" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
                        <img alt="{$obj->Title_head()}" class="__logo_class__ logo"
                             src="project_files/images/logo.png" />
                        <div class="logo-caption">
                            <div>
                                <span class="top-span">ستاره سام گشت</span>
                                <span class="sum-span">آژانس  خدمات مسافرتی</span>
                            </div>
                        </div>
                    </a>
                    <div class="nav-menus-wrapper">
                        <ul class="nav-menu align-to-right">
                            <li class="li-navs">
                                <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">خانه</a>
                            </li>
                            <li class="li-navs">
                                <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">تور داخلی</a>
                                {if $objResult->ReservationTourCities('=1', 'return')}
                                <ul class="nav-dropdown nav-submenu">
                                    {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCities('=1', 'return')}
                                    <li class="">
                                        <a class="link-drop" href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-{$item_tour.id}/all/all">
                                          <span class="navs-text">
                                                 {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                            </span>
                                        </a>
                                    </li>
                                    {/foreach}
                                    <li class="">
                                        <a class="link-drop" href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-all/all/all/0">
                                              <span class="navs-text">
                                                همه تورها
                                              </span>
                                        </a>
                                    </li>

                                </ul>
                                {/if}
                            </li>
                            <li class="li-navs">
                                <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">تور خارجی</a>
                                {if $objResult->ReservationTourCountries('yes' , false , 31, 'notLike')}
                                <ul class="nav-dropdown nav-submenu">
                                    {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCountries('yes' , false , 31, 'notLike')}
                                    <li class="">
                                        <a class="link-drop" href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$item_tour.id}-all/all/all">
                                           <span class="navs-text">
                                                 {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                            </span>
                                        </a>
                                    </li>
                                    {/foreach}
                                </ul>
                                {/if}
                            </li>
                            <li class="li-navs">
                                <a href="{$smarty.const.ROOT_ADDRESS}/mag">وبلاگ</a>
                            </li>
                            <li class="li-navs">
                                <a href="{$smarty.const.ROOT_ADDRESS}/news">اخبار</a>
                            </li>
                            <li class="li-navs">
                                <a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری خرید</a>
                            </li>
                            <li class="li-navs">
                                <a href="javascript:">آژانس ما</a>
                                <ul class="nav-dropdown nav-submenu">
                                    <li>
                                        <a class="link-drop" href="{$smarty.const.ROOT_ADDRESS}/pay">
                                             <span class="navs-text">
                                                درگاه پرداخت آنلاین
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="link-drop" href="{$smarty.const.ROOT_ADDRESS}/rules">
                                            <span class="navs-text">
                                                قوانین و مقررات
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="link-drop" href="{$smarty.const.ROOT_ADDRESS}/aboutUs">
                                            <span class="navs-text">
                                                درباره ما
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="link-drop" href="{$smarty.const.ROOT_ADDRESS}/contactUs">
                                            <span class="navs-text">
                                                تماس با ما
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                    <a class="__login_register_class__ button btn-user {if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if}"
                       href="{if $obj_main_page->isLogin()}javascript:{else}{$smarty.const.ROOT_ADDRESS}/authenticate{/if}">
                        <svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                            <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z"></path>
                        </svg>
                    </a>
                    <div class="main-navigation__sub-menu2 arrow-up show-content-box-login-js" style="display: none">
                        {include file="../../include/signIn/topBar.tpl"}
                    </div>
                    <div class="nav-toggle"></div>
                </div>
            </div>
        </nav>
    </div>
</header>