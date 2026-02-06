{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{load_presentation_object filename="aboutUs" assign="objAbout"}
{assign var="about"  value=$objAbout->getData()}
<header class="i_modular_menu header_area">
    <div class="main_header_area animated" id="navbar">
        <div class="top-header">
            <div class="container">
                <div class="parent-top-header">
                    <div class="header-top-right">
                        <span>دنبال کنید:</span>
                        {assign var="socialLinks"  value=$about['social_links']|json_decode:true}
                        {assign var="socialLinksArray" value=['telegram'=>'telegramHref','whatsapp'=> 'whatsappHref','instagram' => 'instagramHref','aparat' => 'aparatHref','youTube' => 'youtubeHref','facebook' => 'facebookHref','linkedin' => 'linkeDinHref' , 'twitter' => 'twitterHref']}

                        {foreach $socialLinks as $key => $val}
                            {assign var=$socialLinksArray[$val['social_media']] value=$val['link']}
                        {/foreach}

                        <div class="__social_class__ social-header">
                            <a class="__telegram_class__ fab fa-telegram footer_telegram"
                               href="{if $telegramHref}{$telegramHref}{/if}" target="_blank"></a>
                            <a class="__instagram_class__ fab fa-instagram footer_instagram"
                               href="{if $instagramHref}{$instagramHref}{/if}" target="_blank"></a>
                            <a class="__whatsapp_class__ fab fa-whatsapp footer_whatsapp"
                               href="{if $whatsappHref}{$whatsappHref}{/if}" target="_blank"></a>
                            <a class="__linkdin_class__ fa-brands fa-linkedin-in footer_linkedin"
                               href="{if $linkeDinHref}{$linkeDinHref}{/if}" target="_blank"></a>
                        </div>
                    </div>
                    <div class="header-top-left">
                        <a class="__email_class__ email-header"
                           href="mailto:{$smarty.const.CLIENT_EMAIL}">{$smarty.const.CLIENT_EMAIL}</a>
                        <a class="__phone_class_ btn-phone" href="tel:{$smarty.const.CLIENT_MOBILE}">
                            <span>{$smarty.const.CLIENT_MOBILE}</span>
                            <svg viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom-header">
            <div class="container">
                <nav class="navigation" id="navigation1">
                    <div class="parent-header-right">
                        <div class="nav-header">
                            <a class="nav-brand" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
                                <img alt="{$obj->Title_head()}" class="__logo_class__"
                                     src="project_files/images/logo.png" />
                                <div class="logo-caption">
                                    <h1>
                                        <span class="top-span"> ماه عسل گشت </span>
                                        <span class="sum-span">آژانس  مسافرتی</span>
                                    </h1>
                                </div>
                            </a>
                        </div>
                        <div class="nav-menus-wrapper">
                            <ul class="nav-menu align-to-right">
                                <li>
                                    <a class="link-header" href="{$smarty.const.ROOT_ADDRESS}/page/flight">پرواز</a>
                                </li>
                                <li>
                                    <a class="link-header" href="{$smarty.const.ROOT_ADDRESS}/page/hotel">هتل</a>
                                </li>
                                <li>
                                    <a class="link-header" href="{$smarty.const.ROOT_ADDRESS}/page/tour">تور</a>
                                    <ul class="nav-dropdown nav-submenu" style="right: auto;display: block;">
                                        <li class="">
                                            <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">داخلی</a>
                                            {if $objResult->ReservationTourCities('=1', 'return')}
                                                <ul class="nav-dropdown nav-submenu" style="display: block;">
                                                    {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCities('=1', 'return')}
                                                        <li>
                                                            <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-{$item_tour.id}/all/all">
                                                                {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                                            </a>
                                                        </li>
                                                    {/foreach}
                                                    <li><a class="a_header_active" href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-all/all/all/0">نمایش همه</a></li>
                                                </ul>
                                            {/if}
                                        </li>
                                        <li class="">
                                            <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">خارجی</a>
                                            {if $objResult->ReservationTourCountries('yes' , false , 31, 'notLike')}
                                                <ul class="nav-dropdown nav-submenu" style="display: none;">
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
                                            {/if}
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a class="link-header" href="{$smarty.const.ROOT_ADDRESS}/page/visa">ویزا</a>
                                </li>
                                <li>
                                    <a class="link-header" href="{$smarty.const.ROOT_ADDRESS}/page/insurance">بیمه</a>
                                </li>
                                <li>
                                    <a class="link-header" href="{$smarty.const.ROOT_ADDRESS}/UserTracking"
                                       target="_blank">پیگیری خرید</a>
                                </li>
                                <li>
                                    <a class="link-header" href="javascript:">دانستنی ها</a>
                                    <ul class="nav-dropdown nav-submenu">
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/TourismServices"> خدمات گردشگری </a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/authenticate">باشگاه مشتریان </a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/recommendation">سفرنامه </a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/Forms">فرم ها </a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/aboutIran">معرفی ایران</a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/aboutCountry">معرفی کشورها</a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/helpFile">فایل های راهنما</a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/personnel">مدیران و پرسنل</a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/faq">پرسشهای متداول</a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/weather">هواشناسی </a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/agencyList">نمایندگی ها </a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/currency">ارز </a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/vote">نظرسنجی </a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a class="link-header" href="javascript:">آژانس ما</a>
                                    <ul class="nav-dropdown nav-submenu">
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/mag">وبلاگ</a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/news"> اخبار</a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/orderServices"> درخواست خدمات</a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/pay">درگاه پرداخت آﻧﻼﻳﻦ</a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/rules">قوانین و مقررات</a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/contactUs">تماس با ما</a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">درباره ما</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="parent-btn-header">
                        <a class="__login_register_class__ button btn-user {if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if}" href="{if $obj_main_page->isLogin()}javascript:{else}{$smarty.const.ROOT_ADDRESS}/authenticate{/if}">
                            <span>{include file="../../include/signIn/topBarName.tpl"}</span>
                            <svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                                <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"></path>
                            </svg>
                        </a>
                        <div class="main-navigation__sub-menu2 arrow-up show-content-box-login-js" style="display: none">
                            {include file="../../include/signIn/topBar.tpl"}
                        </div>
                    </div>
                    <div class="nav-toggle"></div>
                </nav>
            </div>
        </div>
    </div>
</header>