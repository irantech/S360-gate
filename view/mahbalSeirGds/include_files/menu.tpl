{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
<header class="i_modular_menu header_area fixedmenu">
    <div class="main_header_area">
        <div class="menus container">
            <nav class="navigation" id="navigation1">
                <!-- Logo Area Start -->
                <div class="nav-header">
                    <a class="flex-row" href="">
                        <a class="logo logoHolder flex-col" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
                            <img alt="{$obj->Title_head()}" class="__logo_class__"
                                 src="project_files/images/logo.png" />
                        </a>
                    </a>
                    <div class="nav-toggle"></div>
                </div>
                <div class="nav-menus-wrapper">
                    <ul class="nav-menu">
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/tour">تور</a>
                            <ul class="nav-dropdown first_child_menu">
                                <li><a href="javascript:"> تور داخلی </a>
                                    {if $objResult->ReservationTourCities('=1', 'return')}
                                    <ul class="nav-dropdown submenu-child">
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
                                    {/if}
                                </li>
                                <li><a href="javascript:"> تور خارجی </a>
                                    {if $objResult->ReservationTourCountries('yes' , false , 31, 'notLike')}
                                    <ul class="nav-dropdown submenu-child">
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

                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/Flight">بلیط</a></li>
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/visa">ویزا</a></li>
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/hotel">هتل</a></li>
                        <li><a href="javascript:">سایر</a>
                            <ul class="nav-dropdown first_child_menu">
                                <li><a class="SMBlog" href="http://mag.mahbalseir.com">مجله مه بال سیر</a></li>
                                <li><a class="SMRules" href="{$smarty.const.ROOT_ADDRESS}/rules"> قوانین و مقررات </a>
                                </li>
                                <li><a class="SMEmployment" href="{$smarty.const.ROOT_ADDRESS}/employment"> فرم
                                        استخدام </a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/vote">نظرسنجی</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/news"> اخبار</a></li>
                                <li><a class="SMAbout" href="{$smarty.const.ROOT_ADDRESS}/aboutUs"> درباره ما </a></li>
                                <li><a class="SMContactUs" href="{$smarty.const.ROOT_ADDRESS}/contactUs"> تماس با ما</a>
                                </li>
                            </ul>
                        </li>
                        <li class="mobileMenu"><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">صفحه اصلی</a></li>
                        <li class="mobileMenu"><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری
                                خرید</a></li>
                        <li class="mobileMenu"><a class="SMContactUs" href="{$smarty.const.ROOT_ADDRESS}/contactUs">تماس
                                با ما</a></li>
                        <li class="mobileMenu"><a class="SMAbout" href="{$smarty.const.ROOT_ADDRESS}/aboutUs">درباره
                                ما</a></li>
                    </ul>
                </div>
                <div class="left-menu">
                    <div class="act-buttons">
                        <div class="nav-search">
                            <div class="top__user_menu">

                                <a class="__login_register_class__ main-navigation__button2 btn-user {if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if}"
                                        href="{if $obj_main_page->isLogin()}javascript:{else}{$smarty.const.ROOT_ADDRESS}/authenticate{/if}">
                                    {include file="`$smarty.const.FRONT_CURRENT_THEME`topBarName.tpl"}
                                </a>
                                <div class="main-navigation__sub-menu2 arrow-up show-content-box-login-js"
                                     style="display: none">
                                    {include file="`$smarty.const.FRONT_CURRENT_THEME`topBar.tpl"}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="act-buttons peygiri">
                        <div class="peigiri">
                            <a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری
                                خرید</a>
                        </div>
                    </div>
                    <div class="lang">
                        <a href="https://mahbalseir.com/en">
                            <img alt="" src="project_files/images/language-icon-en.png" />
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>