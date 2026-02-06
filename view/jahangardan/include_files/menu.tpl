{assign var="pass_hash" value=$obj_main_page->hashPasswordUser()}
{if  $smarty.session.layout neq 'pwa' }
    <header class="header_area">
    <div class="main_header_area animated h-100" id="navbar">
        <div class="container-fluid h-100">
            <nav id="navigation1" class="h-100 navigation d-flex justify-content-between align-items-center">
                <div class="nav-header">
                    <a class="nav-brand" href="{$smarty.const.DOMAIN_FOR_URL}">
                    <img src="project_files/images/logo.png" alt="{$obj->Title_head()}"></a>
                </div>
                <div class="nav-menus-wrapper d-flex align-items-start flex-column ml-auto" >
                    <ul class="nav-menu align-to-right">
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/cancellationFee">درصد جریمه کنسلی</a></li>
                        <li><a href="https://jahangardan.com/">میزبان شو</a></li>
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/page/terminal">ترمینال پرواز</a></li>

                        <li><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری خرید</a></li>
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/mag">مجله گردشگری</a></li>
                        <li><a href="https://charge.sep.ir/Charge">پرداخت شارژ</a></li>
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/weather">هواشناسی</a></li>
                        <li><a href="javascript:">درباره ما</a>
                            <ul class="nav-dropdown">
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/loginUser">باشگاه مشتریان</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/rules">قوانین و مقررات</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">درباره ما</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/contactUs">تماس با ما</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <span class="btns_header mr-auto d-flex position-relative">
                    <a href="tel:09422022012" class="buttonfa-headset button ml-1"> <i class="fa-regular fa-headset ml-1"></i> 09422022012 </a>
                    <a href="javascript:" class="main-navigation__button2 button">
                        <i class="far fa-user ml-1"></i>
                        {include file="`$smarty.const.FRONT_THEMES_DIR`jahangardan_kohan/jahangardan_fa/topBarName.tpl"}
                    </a>
                    <div class="main-navigation__sub-menu2 arrow-up" style="display: none">

                        {include file="`$smarty.const.FRONT_THEMES_DIR`jahangardan_kohan/jahangardan_fa/topBar.tpl"}

                    </div>

                </span>
                <div class="nav-toggle mr-2"></div>
            </nav>
        </div>
    </div>
</header>
{/if}