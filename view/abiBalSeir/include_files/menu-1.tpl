{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
<header class="i_modular_menu header_area {if $smarty.const.GDS_SWITCH neq 'mainPage' && $smarty.const.GDS_SWITCH neq 'page'} header-page {/if}">
    <div class="main_header_area animated" id="navbar">
        <div class="container">
            <nav class="navigation d-flex align-items-center">
                <div class="nav-header">
                    <a class="d-flex align-items-center" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
                        <img alt="{$obj->Title_head()}" src="project_files/images/logo.png"/>
                        <!--                        <div class="text-nav-brand">-->
                        <!--                            <h1>پرواز بیست مهتاب</h1>-->
                        <!--                            <h2>شـرکـت خـدمـات مـسـافـرتـی</h2>-->
                        <!--                        </div>-->
                    </a>
                </div>
                <div class="nav-menus-wrapper">
                    <ul class="nav-menu">
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">درباره ما</a></li>

                        <li><a href="{$smarty.const.ROOT_ADDRESS}/contactUs">تماس با ما</a></li>
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/rules">قوانین و مقررات</a></li>

                    </ul>
                </div>
                <div class="box_button_header">
                    <a class="button_header d-none d-lg-flex" href="{$smarty.const.ROOT_ADDRESS}/UserTracking"><span>پیگیری خرید</span></a>
                    <a class="__login_register_class__ button_header logIn
{if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if}" href="{if $obj_main_page->isLogin()}javascript:{else}{$smarty.const.ROOT_ADDRESS}/authenticate{/if}"
                    >
                    {include file="../../include/signIn/topBarName.tpl"}
                    </a>
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