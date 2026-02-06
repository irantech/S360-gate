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


                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/Flight">##Ticket##</a></li>

                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/hotel">##Hotel##</a></li>
                        <li><a href="javascript:">##Another##</a>
                            <ul class="nav-dropdown first_child_menu">
                                <li><a class="SMBlog" href="{$smarty.const.ROOT_ADDRESS}/mag">##S360Blog##</a></li>
                                <li><a class="SMRules" href="{$smarty.const.ROOT_ADDRESS}/rules">##Rules##</a>
                                </li>
{*                                <li><a class="SMEmployment" href="{$smarty.const.ROOT_ADDRESS}/employment">##Employment##</a></li>*}
{*                                <li><a href="{$smarty.const.ROOT_ADDRESS}/vote">##SendVoteAnswer##</a></li>*}
{*                                <li><a href="{$smarty.const.ROOT_ADDRESS}/news">##News##</a></li>*}
                                <li><a class="SMAbout" href="{$smarty.const.ROOT_ADDRESS}/aboutUs">##AboutUs##</a></li>
                                <li><a class="SMContactUs" href="{$smarty.const.ROOT_ADDRESS}/contactUs">##Contactus##</a>
                                </li>
                            </ul>
                        </li>
                        <li class="mobileMenu"><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">##Home##</a></li>
                        <li class="mobileMenu"><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">##TrackOrder##</a></li>
                        <li class="mobileMenu"><a class="SMContactUs" href="{$smarty.const.ROOT_ADDRESS}/contactUs">##Contactus##</a></li>
                        <li class="mobileMenu"><a class="SMAbout" href="{$smarty.const.ROOT_ADDRESS}/aboutUs">##AboutUs##</a></li>
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
                            <a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">##TrackOrder##</a>
                        </div>
                    </div>
                    <div class="lang">
                        <a href="https://mahbalseir.com/fa">
                            <img alt="" src="project_files/images/language-icon-fa.png" />
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>