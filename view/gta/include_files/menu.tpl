{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
<header class="i_modular_menu header_area">
    <div class="main_header_area animated" id="navbar">
        <div class="container">
            <nav class="navigation d-flex align-items-center">
                <div class="nav-header">
                    <a class="d-flex" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
                        <img alt="آژانس مسافرتی پرشین گلف" src="project_files/images/logo.png" />
                    </a>
                </div>
                <div class="nav-menus-wrapper">
                    <ul class="nav-menu">
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/flight">پرواز</a></li>
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/hotel">هتل</a></li>
                        <li>
                            <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">تور
                            </a>
                            <ul class="nav-dropdown">
                                <li>
                                    <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">داخلی</a>
                                    {if $objResult->ReservationTourCities('=1', 'return')}
                                        <ul class="nav-dropdown" >
                                            {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCities('=1', 'return')}
                                                <li>
                                                    <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-{$item_tour.id}/all/all">
                                                        {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                                    </a>
                                                </li>
                                            {/foreach}
                                            <li><a class="bg-active" href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-all/all/all/0">نمایش همه</a></li>
                                        </ul>
                                    {/if}
                                </li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/tour">خارجی</a>
                                    {if $objResult->ReservationTourCountries('yes' , false , 31, 'notLike')}
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
                                    {/if}
                                </li>
                                <li><a href='https://voffice.khatamtour.com/v_office/log_in/?page=vSYaBH50bSVhZnVpO2VjzDZnb192O21eBy5ydD90bDU0BDhiOnVjzDZnb3BeOakaxSR0zA2'>تورهای بازنشستگی</a></li>
                                <li><a class="bg-active" href="{$smarty.const.ROOT_ADDRESS}/page/tour">جست و جوی تور</a></li>
                            </ul>
                        </li>
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/visa">ویزا
                            </a>
                            <ul class="nav-dropdown">
                                {foreach key=key_continent item=item_continent from=$obj_main_page->continentsHaveVisa()}
                                <li><a href="javascript:"> {$item_continent.titleFa}</a>
                                    <ul class="nav-dropdown nav-submenu nav-menu_ul">
                                        {foreach key=key_country item=item_country from=$obj_main_page->countriesHaveVisa($item_continent.id)}
                                            <li>
                                                <a href="{$smarty.const.ROOT_ADDRESS}/resultVisa/{$item_country.code}/all/1-0-0">{$item_country.title}</a>
                                            </li>
                                        {/foreach}
                                    </ul>
                                </li>
                                {/foreach}

                                <li><a class="bg-active" href="{$smarty.const.ROOT_ADDRESS}/page/visa">جست و جوی ویزا</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">
                                پیگیری خرید
                            </a>
                        </li>
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/mag">وبلاگ</a>
                        </li>
                        <li><a href="javascript:">آژانس ما
                            </a>
                            <ul class="nav-dropdown">
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">درباره ما</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/contactUs">تماس با ما</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/authenticate">باشگاه مشتریان</a></li>
                                <li><a href="https://khatamtour.com/" target='_blank'>خاتم تور</a></li>
                                <li><a href="https://co.gta.ir/" target='_blank'>سایت خبری دفتر مرکزی</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="box_button_header">
                    <a class="button_header d-md-flex" href="javascript:">
                        <span class="__phone_class__"
                     href="tel:{$smarty.const.CLIENT_PHONE}">{$smarty.const.CLIENT_PHONE}</span></a>

                    <a class="__login_register_class__ button_header logIn {if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if}"
                       href="{if $obj_main_page->isLogin()}javascript:{else}{$smarty.const.ROOT_ADDRESS}/authenticate{/if}"><i>
                            <svg viewbox="0 0 448 512">
                                <path d="M224 256c70.7 0 128-57.31 128-128s-57.3-128-128-128C153.3 0 96 57.31 96 128S153.3 256 224 256zM224 32c52.94 0 96 43.06 96 96c0 52.93-43.06 96-96 96S128 180.9 128 128C128 75.06 171.1 32 224 32zM274.7 304H173.3C77.61 304 0 381.6 0 477.3c0 19.14 15.52 34.67 34.66 34.67h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304zM413.3 480H34.66C33.2 480 32 478.8 32 477.3C32 399.4 95.4 336 173.3 336h101.3C352.6 336 416 399.4 416 477.3C416 478.8 414.8 480 413.3 480z"></path>
                            </svg>
                        </i>
                        <span>{include file="../../include/signIn/topBarName.tpl"}</span>
                    </a>
                    <div class="main-navigation__sub-menu2 arrow-up show-content-box-login-js" style="display: none">
                        {include file="../../include/signIn/topBar.tpl"}
                    </div>
                </div>
                <div class="nav-toggle">
                    <svg viewbox="0 0 448 512">
                        <path d="M0 80C0 71.16 7.164 64 16 64H432C440.8 64 448 71.16 448 80C448 88.84 440.8 96 432 96H16C7.164 96 0 88.84 0 80zM0 240C0 231.2 7.164 224 16 224H432C440.8 224 448 231.2 448 240C448 248.8 440.8 256 432 256H16C7.164 256 0 248.8 0 240zM432 416H16C7.164 416 0 408.8 0 400C0 391.2 7.164 384 16 384H432C440.8 384 448 391.2 448 400C448 408.8 440.8 416 432 416z"></path>
                    </svg>
                </div>
            </nav>
        </div>
    </div>
</header>