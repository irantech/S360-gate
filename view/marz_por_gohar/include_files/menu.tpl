<header class="header_area">
    <div class="main_header_area animated" id="navbar">
        <div class="container">
            <nav id="navigation1" class="navigation">
                <div class="nav-header">
                    <a class="nav-brand" href="https://{$smarty.const.CLIENT_DOMAIN}">
                        <div class='parent-logo'>
                            <img src="project_files/images/logo.png" alt="{$obj->Title_head()}">
                        </div>
                        <div class="logo-caption">
                            <h1>
                                <span> مـرز پرگـهـر</span>
                                <span class="sum-span">MP Travel</span>
                            </h1>
                            <!--                            <img src="images/logo-nahaee.png" alt="img-caption">-->
                        </div>
                    </a>
                </div>
                <div class="nav-menus-wrapper ">
                    <ul class="nav-menu align-to-right">
                        <li>
                            <a href="javascript:">تور</a>
                            <ul class="nav-dropdown">
                                <li><a href="javascript:;"> تور داخلی </a>
                                    {if $objResult->ReservationTourCities('=1', 'return')}
                                    <ul class="nav-dropdown nav-submenu nav-menu_ul">
                                        {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCities('=1', 'return')}
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
                                    {if $objResult->ReservationTourCountries('yes')}
                                    <ul class="nav-dropdown nav-submenu nav-menu_ul">
                                        {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCountries('yes')}
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
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/shopping">راهنمای خرید</a></li>
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/orderServices">درخواست تور و خدمات</a></li>
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری خرید</a></li>
                        <li>
                            <a href="javascript:">آژانس ما</a>
                            <ul class="nav-dropdown nav-submenu ">
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">درباره ما</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/contactUs">تماس با ما</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/rules">قوانین و مقررات</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/mag">مقالات مفید</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="parent-btn-header">
                    <a href="{if $obj_main_page->isLogin()}javascript:{else}{$smarty.const.ROOT_ADDRESS}/authenticate{/if}"
                       class="{if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if} button_logIn button  btn-user">
                        <span>{include file="../../include/signIn/topBarName.tpl"}</span>
                        <i class="far fa-user"></i>

                    </a>
                    <div class="main-navigation__sub-menu2">
                        {include file="../../include/signIn/topBar.tpl"}
                    </div>
                    <a class="button  btn-phone" href="tel:{$smarty.const.CLIENT_PHONE}">
                        <span>{$smarty.const.CLIENT_PHONE}</span>
                        <i class="fa-light fa-phone"></i>
                    </a>
                </div>
                <div class="nav-toggle "></div>
            </nav>
        </div>
    </div>
</header>