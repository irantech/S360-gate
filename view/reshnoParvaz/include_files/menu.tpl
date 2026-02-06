{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
<header class="i_modular_menu header_area">
    <div class="main_header_area animated" id="navbar">
        <div class="container">
            <nav class="navigation" id="navigation1">
                <div class="nav-header">
                    <a class="nav-brand" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
                        <img alt="{$obj->Title_head()}" class="__logo_class__" src="project_files/images/logo.png" />
                        <div class="logo-caption">
                            <span class="sub-logo">رشنو پرواز</span>
                            <span>آژانس خدماتی مسافرتی</span>
                        </div>
                    </a>
                </div>
                <div class="nav-menus-wrapper">
                    <ul class="nav-menu align-to-right">
                        <li>
                            <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">
                                <i class="fa-duotone fa-suitcase-rolling"></i>

                                تور داخلی</a>
                            {if $objResult->ReservationTourCities('=1', 'return')}
                            <ul class="nav-dropdown nav-submenu nav-menu_ul">
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
                        <li>
                            <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">
                                <i class="fa-duotone fa-plane-up"></i>

                                تور خارجی</a>
                            {if $objResult->ReservationTourCountries('yes' , false , 31, 'notLike')}
                            <ul class="nav-dropdown nav-submenu nav-menu_ul">
                                {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCountries('yes' , false , 31, 'notLike')}
                                <li>
                                    <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$item_tour.id}-all/all/all">
                                        {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                    </a>
                                </li>
                                {/foreach}
                            </ul>
                            {/if}
                        </li>
                        <li>
                            <a href="{$smarty.const.ROOT_ADDRESS}/page/visa">
                                <i class="fa-duotone fa-earth-americas"></i>

                                ویزا</a>
                        </li>
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">
                                <i class="fa-duotone fa-rectangle-list"></i>

                                پیگیری خرید

                            </a></li>
                        <li>
                            <a href="{$smarty.const.ROOT_ADDRESS}/mag">
                                <i class="fa-duotone fa-message-lines"></i>
                                وبلاگ</a>
                        </li>
                    </ul>
                </div>
                <div class="parent-btn-header">

                    <a class="__login_register_class__ button btn-user {if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if}"
                       href="{if $obj_main_page->isLogin()}javascript:{else}{$smarty.const.ROOT_ADDRESS}/authenticate{/if}">
                        <i class="fa-duotone fa-user-group"></i>
                    </a>
                    <div class="main-navigation__sub-menu2 arrow-up show-content-box-login-js" style="display: none">
                        {include file="../../include/signIn/topBar.tpl"}
                    </div>
                    <a class="button btn-phone" href="tel:{$smarty.const.CLIENT_PHONE}" >
                        <span class="__phone_class__">{$smarty.const.CLIENT_PHONE}</span>
                        <i class="fa-duotone fa-phone"></i>
                    </a>
                </div>
                <div class="nav-toggle"></div>
            </nav>
        </div>
    </div>
</header>