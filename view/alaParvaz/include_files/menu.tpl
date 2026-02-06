{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
<header class="i_modular_menu header_area fixedmenu">
    <div class="main_header_area animated">
        <div class="container">
            <nav class="navigation" id="navigation1">
                <div class="nav-header">
                    <a alt="{$obj->Title_head()}" class="__logo_class__ nav-brand"
                       href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
                        <img alt="img-logo" src="project_files/images/logo.png" />
                    </a>
                </div>
                <div class="nav-menus-wrapper">
                    <ul class="nav-menu align-to-right">
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/tour">تور</a>
                            <ul class="nav-dropdown">
                                <li>
                                    <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">تورهای داخلی</a>
                                    {if $objResult->ReservationTourCities('=1', 'return')}
                                        <ul class="nav-dropdown dropdown2" >
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
                                <li>
                                    <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">تور های خارجی</a>
                                    {if $objResult->ReservationTourCountries('yes' , false , 31, 'notLike')}
                                        <ul class="nav-dropdown dropdown2">
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
                                <li>
                                    <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">جست و جوی تور</a>
                                </li>
                            </ul>
                        </li>
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/flight">پرواز</a>
                        </li>
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/hotel">هتل ها</a>
                        </li>
                        <li class="megamenu-list-title">
                            <a href="{$smarty.const.ROOT_ADDRESS}/pay" target="_blank">پرداخت
                                آنلاین </a>
                        </li>
                        <li>
                            <a href="{$smarty.const.ROOT_ADDRESS}/mag">وبلاگ</a>
                        </li>
                        <li>
                            <a href="{$smarty.const.ROOT_ADDRESS}/club">باشگاه مشتریان</a>
                        </li>
                        <li><a href="javascript:">آژانس ما</a>
                            <ul class="nav-dropdown">
                                <li>
                                    <a href="{$smarty.const.ROOT_ADDRESS}/rules" target="_blank">قوانین و مقررات</a>
                                </li>
                                <li>
                                    <a href="{$smarty.const.ROOT_ADDRESS}/aboutUs" target="_blank">درباره ما</a>
                                </li>
                                <li>
                                    <a href="{$smarty.const.ROOT_ADDRESS}/contactUs" target="_blank">تماس با ما</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="nav-search">
                    <a class="__login_register_class__ button btn-user btn-style {if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if}"
                       href="{if $obj_main_page->isLogin()}javascript:{else}{$smarty.const.ROOT_ADDRESS}/authenticate{/if}">
                        <span>{include file="../../include/signIn/topBarName.tpl"}</span>
{*                        <i class="fa-light fa-user my-user"></i>*}
                    </a>
                    <div class="main-navigation__sub-menu2 arrow-up show-content-box-login-js" style="display: none">
                        {include file="../../include/signIn/topBar.tpl"}
                    </div>
                </div>
                <div class="act-buttons peygiri">
                    <div class="peigiri">
                        <a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری خرید</a>
                    </div>
                </div>
                <div class="nav-toggle"></div>
            </nav>
        </div>
    </div>
</header>