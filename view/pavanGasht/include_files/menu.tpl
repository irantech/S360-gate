{load_presentation_object filename="reservationBasicInformation" assign="objResult"}

<header class="header_area " id="header">
    <div class="main_header_area animated">
        <div class="container-fluid">
            <nav id="navigation1" class="navigation">
                <div class="nav-header">
                    <a class="nav-brand" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
                        <img src="project_files/images/logo.png" alt="{$obj->Title_head()}">
                        <div>
                            <h1 class="tikland">پاوان گشت</h1>
                            <div class="tikland-child">آژانس خدمات مسافرت هوائی و جهانگردی</div>

                        </div>
                    </a>
                </div>
                <div class="nav-menus-wrapper">
                    <ul class="nav-menu align-to-right">

                        <li>
                            <a href="javascript:">پرواز</a>
                            <ul class="nav-dropdown nav-submenu">
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/internal-flight">پرواز داخلی</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/external-flight">پرواز خارجی</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="{$smarty.const.ROOT_ADDRESS}/page/hotel">هتل داخلی</a>
                        </li>
                        <!-- منوی جدید تور -->
                        <li>
                            <a href="javascript:">تور</a>
                            <ul class="nav-dropdown nav-submenu">


                                <li>
                                    <a href="{$smarty.const.ROOT_ADDRESS}/page/TourExternal">تور خارجی</a>
                                    {if $objResult->ReservationTourCountries('yes', false, 7)}
                                        <ul class="nav-dropdown nav01">
                                            {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCountries('yes', false, 7)}
                                                {assign var="year" value=substr($item_tour['start_date'], 0, 4)}
                                                {assign var="month" value=substr($item_tour['start_date'], 4, 2)}
                                                {assign var="day" value=substr($item_tour['start_date'], 6)}
                                                <li>
                                                    <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$item_tour.id}-all/all/all">
                                                        {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                                    </a>
                                                    <ul class="nav-dropdown my-dropdown">
                                                        {foreach $item_tour['city_list'] as $city}
                                                            {assign var="year" value=substr($city['start_date'], 0, 4)}
                                                            {assign var="month" value=substr($city['start_date'], 4, 2)}
                                                            {assign var="day" value=substr($city['start_date'], 6)}
                                                            <li>
                                                                <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$item_tour.id}-{$city['id']}/all/7">
                                                                    {$city['name']}
                                                                </a>
                                                            </li>
                                                        {/foreach}
                                                    </ul>
                                                </li>
                                            {/foreach}
                                            <li>
                                                <a href="{$smarty.const.ROOT_ADDRESS}/page/tour" class="all-tour-menu">همه تورها</a>
                                            </li>
                                        </ul>
                                    {/if}
                                </li>


                                <li>
                                    <a href="{$smarty.const.ROOT_ADDRESS}/page/TourInternal">تور داخلی</a>
                                    {if $objResult->ReservationTourCities('=1', 'return')}
                                        <ul class="nav-dropdown nav01">
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
                                    <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/all-all/all/21/all">
                                        تور طبیعت گردی
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li>
                            <a href="{$smarty.const.ROOT_ADDRESS}/mag"> وبلاگ</a>
                        </li>
                        <li>
                            <a href="javascript:">آژانس ما</a>
                            <ul class="nav-dropdown nav-submenu">
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">درباره ما</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/contactUs"> ارتباط با ما</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری خرید</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/club">باشگاه مشتریان</a></li>
                            </ul>
                        </li>

                    </ul>
                </div>


                {*                <div class="nav-menus-wrapper">*}

{*                    <ul class="nav-menu align-to-right">*}

{*                        <li>*}
{*                            <a href="javascript:">پرواز</a>*}
{*                            <ul class="nav-dropdown nav-submenu">*}
{*                                <li><a href="gds/fa/page/internal-flight">پرواز داخلی</a></li>*}
{*                                <li><a href="gds/fa/page/external-flight"> پرواز خارجی</a></li>*}
{*                            </ul>*}
{*                        </li>*}

{*                        <li>*}
{*                            <a href="{$smarty.const.ROOT_ADDRESS}/page/TourExternal">تور های خارجی</a>*}
{*                            {if $objResult->ReservationTourCountries('yes', false, 7)}*}
{*                                <ul class="nav-dropdown">*}
{*                                    {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCountries('yes', false, 7)}*}
{*                                        {assign var="year" value=substr($item_tour['start_date'], 0, 4)}*}
{*                                        {assign var="month" value=substr($item_tour['start_date'], 4, 2)}*}
{*                                        {assign var="day" value=substr($item_tour['start_date'], 6)}*}
{*                                        <li>*}
{*                                            <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$item_tour.id}-all/all/all">*}
{*                                                {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}*}
{*                                            </a>*}
{*                                            <ul class="nav-dropdown my-dropdown">*}
{*                                                {foreach $item_tour['city_list'] as $city}*}
{*                                                    {assign var="year" value=substr($city['start_date'], 0, 4)}*}
{*                                                    {assign var="month" value=substr($city['start_date'], 4, 2)}*}
{*                                                    {assign var="day" value=substr($city['start_date'], 6)}*}
{*                                                    <li>*}
{*                                                        <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$item_tour.id}-{$city['id']}/all/7">*}
{*                                                            {$city['name']}*}
{*                                                        </a>*}
{*                                                    </li>*}
{*                                                {/foreach}*}
{*                                            </ul>*}
{*                                        </li>*}
{*                                    {/foreach}*}
{*                                    <li>*}
{*                                        <a href="{$smarty.const.ROOT_ADDRESS}/page/tour" class="all-tour-menu">همه تورها</a>*}
{*                                    </li>*}
{*                                </ul>*}
{*                            {/if}*}
{*                        </li>*}

{*                        <li>*}
{*                            <a href="{$smarty.const.ROOT_ADDRESS}/page/TourInternal">تورهای داخلی</a>*}
{*                            {if $objResult->ReservationTourCities('=1', 'return')}*}
{*                            <ul class="nav-dropdown   ">*}
{*                                {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCities('=1', 'return')}*}
{*                                    <li>*}
{*                                        <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-{$item_tour.id}/all/all">*}
{*                                            {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}*}
{*                                        </a>*}
{*                                    </li>*}
{*                                {/foreach}*}
{*                                <li class="other-tour">*}
{*                                    <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-all/all/all/0">*}
{*                                        همه تورها*}
{*                                    </a>*}
{*                                </li>*}
{*                            </ul>*}
{*                            {/if}*}
{*                        </li>*}
{*                        <li>*}
{*                            <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/all-all/all/21/all">تور طبیعت گردی*}
{*                                </a>*}
{*                            <!--                            <ul class="nav-dropdown">-->*}
{*                            <!--                                <li>-->*}
{*                            <!--                                    <a href="javascript:">قوانین و مقررات</a>-->*}
{*                            <!--                                </li>-->*}
{*                            <!--                                <li>-->*}
{*                            <!--                                    <a href="javascript:">تماس با ما</a>-->*}
{*                            <!--                                </li>-->*}
{*                            <!--                                <li>-->*}
{*                            <!--                                    <a href="javascript:">درباره ما</a>-->*}
{*                            <!--                                </li>-->*}
{*                            <!--                            </ul>-->*}
{*                        </li>*}

{*                        <li>*}
{*                            <a href="{$smarty.const.ROOT_ADDRESS}/mag"> وبلاگ</a>*}
{*                        </li>*}
{*                        <li>*}
{*                            <a href="javascript:">آژانس ما</a>*}
{*                            <ul class="nav-dropdown nav-submenu">*}
{*                                <li><a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">درباره ما</a></li>*}
{*                                <li><a href="{$smarty.const.ROOT_ADDRESS}/contactUs"> ارتباط با ما</a></li>*}
{*                                <li><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری خرید</a></li>*}
{*                                <li><a href="{$smarty.const.ROOT_ADDRESS}/club">باشگاه مشتریان</a></li>*}
{*                            </ul>*}
{*                        </li>*}

{*                    </ul>*}
{*                </div>*}


                <div class="nav-search">
                    <a href="tel:{$smarty.const.CLIENT_PHONE}" class="phone-number-parent">
                        <span class="phone-number">{$smarty.const.CLIENT_PHONE}</span>
                        <i class="far fa-phone" id="icon-phone"></i>
                    </a>
                    <a href="{if $obj_main_page->isLogin()}javascript:{else}{$smarty.const.ROOT_ADDRESS}/authenticate{/if}"
                       class='parent-userName {if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if}'>
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






