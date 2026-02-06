{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
 <header class="header_area  {if $smarty.const.GDS_SWITCH neq 'mainPage'}position-static{/if}">
        <div class="main_header_area animated" id="navbar">

            <div class="container-fluid">
                <nav class="navigation d-flex align-items-center">
                    <div class="nav-header">
                        <a class="d-flex align-items-center" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
                            <img alt="فلای ایرتور" src="project_files/images/logo.png"/>
                            <div class="text-nav-brand">
                                <h1>فلای ایرتور</h1>
                                <h2>Fly Airtour</h2>
                            </div>
                        </a>
                    </div>
                    <div class="nav-menus-wrapper">
                        <ul class="nav-menu">
                            <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">صفحه اصلی</a></li>
{*                            <li><a href="{$smarty.const.ROOT_ADDRESS}/page/flight">پرواز</a></li>*}
                            <li><a href="{$smarty.const.ROOT_ADDRESS}/page/hotel">هتل</a></li>
                            <li><a href="{$smarty.const.ROOT_ADDRESS}/page/tour">تور</a>
                                <ul class="nav-dropdown">
                                    <li><a href="javascript:;"> تور داخلی </a>
                                        {$inernal_tours = $objResult->ReservationTourCities('=1', 'return')}
                                        {if $inernal_tours}
                                            <ul class="nav-dropdown nav-submenu nav-menu_ul">
                                                {foreach key=key_tour item=item_tour from=$inernal_tours}
                                                    <li>
                                                        <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-{$item_tour.id}/all/all">
                                                            {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                                        </a>
                                                    </li>
                                                {/foreach}
                                            </ul>
                                        {/if}
                                    </li>
                                    <li><a href="javascript:;"> تور خارجی </a>

                                        {$foreging_tours = $objResult->ReservationTourCountries('yes')}
                                        {if $foreging_tours}
                                            <ul class="nav-dropdown nav-submenu nav-menu_ul">
                                                {foreach key=key_tour item=item_tour from=$foreging_tours}
                                                    <li>
                                                        <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$item_tour.id}-all/all/all">
                                                            {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                                        </a>
                                                    </li>
                                                {/foreach}
                                            </ul>
                                        {/if}


                                    </li>
                                </ul>
                            </li>
                            <li class=""><a href="javascript:;">ویزا</a>
                                <ul class="nav-dropdown first_child_menu fadeIn animated">

                                    {foreach key=key_continent item=item_continent from=$obj_main_page->continentsHaveVisa()}
                                        <li>
                                            <a href="javascript:;">
                                                {$item_continent.titleFa}
                                            </a>
                                            <ul class="nav-dropdown submenu-child fadeIn animated">
                                                {foreach key=key_country item=item_country from=$obj_main_page->countriesHaveVisa($item_continent.id)}
                                                    <li>
                                                        <a href="{$smarty.const.ROOT_ADDRESS}/resultVisa/{$item_country.code}/all/1-0-0">{$item_country.title}</a>
                                                    </li>
                                                {/foreach}
                                            </ul>
                                        </li>
                                    {/foreach}
                                    <li><a href="{$smarty.const.ROOT_ADDRESS}/page/visa">جست و جوی ویزا</a></li>
                                </ul>
                            </li>
                            <li><a href="{$smarty.const.ROOT_ADDRESS}/page/insurance">بیمه</a></li>
                            <li class="d-block d-lg-none"><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری خرید</a></li>
                            <li><a href="javascript:">دانستنیها</a>
                                <ul class="nav-dropdown">
                                    <li><a href="{$smarty.const.ROOT_ADDRESS}/currency">نرخ ارز</a></li>
                                    <li><a href="{$smarty.const.ROOT_ADDRESS}/news">اخبار</a></li>
                                    <li><a href="{$smarty.const.ROOT_ADDRESS}/mag">وبلاگ</a></li>
                                    <li><a href="{$smarty.const.ROOT_ADDRESS}/vote">نظرسنجی</a></li>
                                </ul>
                            </li>
                            <li><a href="javascript:">آژانس ما</a>
                                <ul class="nav-dropdown">
                                    <li><a href="{$smarty.const.ROOT_ADDRESS}/pay">درگاه پرداخت</a></li>
                                    <li><a href="{$smarty.const.ROOT_ADDRESS}/rules">قوانین و مقررات</a></li>
                                    <li><a href="{$smarty.const.ROOT_ADDRESS}/page/Licenses">مجوزها</a></li>
                                    <li><a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">درباره ما</a></li>
                                    <li><a href="{$smarty.const.ROOT_ADDRESS}/employment">فرم استخدام</a></li>
                                    <li><a href="{$smarty.const.ROOT_ADDRESS}/contactUs">تماس با ما</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="position-relative box_button_header">
                        <a class="number_button_header" href="tel:{$smarty.const.CLIENT_PHONE}">
                            <span>{$smarty.const.CLIENT_PHONE}</span>
                            <svg viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M480.3 320.3L382.1 278.2c-21.41-9.281-46.64-3.109-61.2 14.95l-27.44 33.5c-44.78-25.75-82.29-63.25-108-107.1l33.55-27.48c17.91-14.62 24.09-39.7 15.02-61.05L191.7 31.53c-10.16-23.2-35.34-35.86-59.87-30.19l-91.25 21.06C16.7 27.86 0 48.83 0 73.39c0 241.9 196.7 438.6 438.6 438.6c24.56 0 45.53-16.69 50.1-40.53l21.06-91.34C516.4 355.5 503.6 330.3 480.3 320.3zM463.9 369.3l-21.09 91.41c-.4687 1.1-2.109 3.281-4.219 3.281c-215.4 0-390.6-175.2-390.6-390.6c0-2.094 1.297-3.734 3.344-4.203l91.34-21.08c.3125-.0781 .6406-.1094 .9531-.1094c1.734 0 3.359 1.047 4.047 2.609l42.14 98.33c.75 1.766 .25 3.828-1.25 5.062L139.8 193.1c-8.625 7.062-11.25 19.14-6.344 29.14c33.01 67.23 88.26 122.5 155.5 155.5c9.1 4.906 22.09 2.281 29.16-6.344l40.01-48.87c1.109-1.406 3.187-1.938 4.922-1.125l98.26 42.09C463.2 365.2 464.3 367.3 463.9 369.3z"></path></svg>
                            <p>اگر در سایت ما بهترین پیشنهاد را پیدا نکردید لطفا تماس بگیرید</p>
                        </a>
                        <a class="button_header d-none d-lg-flex" href="{$smarty.const.ROOT_ADDRESS}/UserTracking"><span>پیگیری خرید</span></a>

                        <a class="__login_register_class__ button_header logIn {if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if}" href="{if $obj_main_page->isLogin()}javascript:{else}{$smarty.const.ROOT_ADDRESS}/authenticate{/if}"><i>
                                <svg viewbox="0 0 448 512">
                                    <path d="M224 256c70.7 0 128-57.31 128-128s-57.3-128-128-128C153.3 0 96 57.31 96 128S153.3 256 224 256zM224 32c52.94 0 96 43.06 96 96c0 52.93-43.06 96-96 96S128 180.9 128 128C128 75.06 171.1 32 224 32zM274.7 304H173.3C77.61 304 0 381.6 0 477.3c0 19.14 15.52 34.67 34.66 34.67h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304zM413.3 480H34.66C33.2 480 32 478.8 32 477.3C32 399.4 95.4 336 173.3 336h101.3C352.6 336 416 399.4 416 477.3C416 478.8 414.8 480 413.3 480z"></path>
                                </svg>
                            </i><span>حساب کاربری من</span></a>
                        <div class="main-navigation__sub-menu2 arrow-up show-content-box-login-js" style="display: none">
                            {include file="../../include/signIn/topBar.tpl"}
                        </div>
                    </div>
                    <div class="nav-toggle mr-2">
                        <svg viewbox="0 0 448 512">
                            <path d="M0 80C0 71.16 7.164 64 16 64H432C440.8 64 448 71.16 448 80C448 88.84 440.8 96 432 96H16C7.164 96 0 88.84 0 80zM0 240C0 231.2 7.164 224 16 224H432C440.8 224 448 231.2 448 240C448 248.8 440.8 256 432 256H16C7.164 256 0 248.8 0 240zM432 416H16C7.164 416 0 408.8 0 400C0 391.2 7.164 384 16 384H432C440.8 384 448 391.2 448 400C448 408.8 440.8 416 432 416z"></path>
                        </svg>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    {load_presentation_object filename="aboutUs" assign="objAbout"}
    {assign var="about"  value=$objAbout->getData()}
    {assign var="socialLinks"  value=$about['social_links']|json_decode:true}

    {assign var="socialLinksArray" value=['telegram'=>'telegramHref','whatsapp'=> 'whatsappHref','instagram' => 'instagramHref','aparat' => 'aparatHref','youTube' => 'youtubeHref','facebook' => 'facebookHref','linkedin' => 'linkeDinHref']}

    {foreach $socialLinks as $key => $val}
        {assign var=$socialLinksArray[$val['social_media']] value=$val['link']}
    {/foreach}
<div class="__social_class__ float-sm">
        <div class="fl-fl float-rs">
            <a class="__whatsapp_class__" href="{if $whatsappHref}{$whatsappHref}{/if}" target="_blank">
                <i class="fab fa-whatsapp-c"><img alt="whatsapp-business-api-logo-icon" src="project_files/images/whatsapp-business-api-logo-icon.png"/></i>
            </a>
        </div>
        <div class="fl-fl float-ig">
            <a class="__instagram_class__" href="{if $instagramHref}{$instagramHref}{/if}" target="_blank"><i class="fab fa-instagram"></i></a>
        </div>
        <div class="fl-fl float-gp">
            <a class="__telegram_class__" href="{if $telegramHref}{$telegramHref}{/if}" target="_blank"><i class="fab fa-telegram"></i></a>
        </div>
        <div class="fl-fl float-gp">
            <a class="__linkdin_class__" href="{if $linkeDinHref}{$linkeDinHref}{/if}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
        </div>
        <div class="fl-fl float-gp">
            <a class="__youtube_class__" href="{if $youtubeHref}{$youtubeHref}{/if}" target="_blank"><i class="fab fa-youtube"></i></a>
        </div>
    </div>
