{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
<header class="i_modular_menu header_area">
    <div class="main_header_area animated" id="navbar">
        <div class="container">
            <nav class="navigation" id="navigation1">
                <div class="parent-menu-logo">
                    <div class="nav-header">
                        <a class="nav-brand" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
                            <img alt="{$obj->Title_head()}" class="__logo_class__ logo-img" src="project_files/images/logo.png"/>
                        </a>

                    </div>
                    <div class="nav-menus-wrapper">
                        <ul class="nav-menu align-to-right">
                            <li>
                                <a href="{$smarty.const.ROOT_ADDRESS}/page/hotel"> هتل داخلی</a>
                            </li>
                            <li>
                                <a class="link-header" href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری خرید</a>
                            </li>
                            <li>
                                <a class="link-header" href="{$smarty.const.ROOT_ADDRESS}/rules">قوانین و مقررات</a>
                            </li>
                            <li>
                                <a class="link-header" href="{$smarty.const.ROOT_ADDRESS}/aboutUs">درباره ما</a>
                            </li>
                            <li>
                                <a class="link-header" href="{$smarty.const.ROOT_ADDRESS}/contactUs">تماس با ما</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="parent-btn-header">
                    <a class="__phone_class__ button btn-phone"
                       href="tel:{$smarty.const.CLIENT_PHONE}">
                        <span>{$smarty.const.CLIENT_PHONE}</span>
                        <i class="far fa-phone"></i>
                    </a>

                    <a class="__login_register_class__ button btn-user {if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if}"
                        {if $obj_main_page->isLogin()}
                            href="javascript:"
                        {else}
                                {if $smarty.const.SOFTWARE_LANG == 'fa'}
                                href="{$smarty.const.ROOT_ADDRESS}/authenticate"
                                {else}
                                href="{$smarty.const.ROOT_ADDRESS}/loginUser"
                                {/if}
                        {/if}
                        >
                        <span>{include file="../../include/signIn/topBarName.tpl"}</span>
                        <i class="far fa-user"></i>
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