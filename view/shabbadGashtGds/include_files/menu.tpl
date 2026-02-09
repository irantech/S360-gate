{load_presentation_object filename="frontMaster" assign="obj"}
{load_presentation_object filename="Session" assign="objSession"}
{load_presentation_object filename="functions" assign="objFunctions"}
{load_presentation_object filename="dateTimeSetting" assign="objDate"}
{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{if $smarty.session['userId'] }
    {assign var="userInfo" value=functions::infoMember($smarty.session.userId)}
    {assign var="hashedPass" value=functions::HashKey({$userInfo['email']},'encrypt')}
{/if}

<header class="header_area">
    <div class="main_header_area animated h-100" id="navbar">
        <div class="container h-100">
            <div class="socialmedia-responsive">
                 <span class="btns_header ml-auto">
                    <a  class="button_C p-2"> EN </a>
                </span>

                <a href="#" class="SMInstageram instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" class="SMWhatsApp whatsapp"><i class="fab fa-whatsapp"></i></a>
                <a href="#" class="SMTelegram telegram"><i class="fab fa-telegram-plane"></i></a>
                <a href="#" class="SMYouTube youtube"><i class="fab fa-youtube"></i></a>
                <a href="#" class="SMAparat aparat"><i class="fab fa-aparat">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                             width="48" height="48"
                             viewBox="0 0 48 48"
                             style=" fill:#fff;"><path d="M 15.173828 2.609375 C 11.917119 2.5264688 8.94875 4.7335781 8.1875 8.0332031 L 7.078125 12.837891 C 10.172125 7.7938906 15.497719 4.4664844 21.386719 3.8964844 L 16.582031 2.7871094 C 16.110656 2.6782344 15.639072 2.6212187 15.173828 2.609375 z M 23.615234 7 C 16.369702 7.1611924 9.7609531 11.980828 7.6582031 19.314453 C 5.0702031 28.340453 10.289453 37.753797 19.314453 40.341797 C 28.339453 42.929797 37.753797 37.711547 40.341797 28.685547 C 42.929797 19.659547 37.711547 10.246203 28.685547 7.6582031 C 26.993172 7.1729531 25.28728 6.9628018 23.615234 7 z M 35.162109 7.078125 C 40.206109 10.172125 43.533516 15.497719 44.103516 21.386719 L 45.212891 16.582031 C 46.083891 12.811031 43.737797 9.0575 39.966797 8.1875 L 35.162109 7.078125 z M 20.191406 12.589844 C 20.456244 12.610334 20.723031 12.658375 20.988281 12.734375 C 23.111281 13.342375 24.338469 15.556687 23.730469 17.679688 C 23.122469 19.802687 20.906203 21.029875 18.783203 20.421875 C 16.660203 19.813875 15.433969 17.599562 16.042969 15.476562 C 16.575844 13.618937 18.337541 12.446412 20.191406 12.589844 z M 31.726562 15.898438 C 31.991494 15.918996 32.258063 15.966844 32.523438 16.042969 C 34.646437 16.650969 35.874625 18.865281 35.265625 20.988281 C 34.657625 23.110281 32.441359 24.338469 30.318359 23.730469 C 28.195359 23.122469 26.968172 20.908156 27.576172 18.785156 C 28.108172 16.927531 29.872041 15.754527 31.726562 15.898438 z M 24.035156 22.001953 C 25.139156 22.020953 26.017047 22.930156 25.998047 24.035156 C 25.979047 25.139156 25.069844 26.017047 23.964844 25.998047 C 22.860844 25.979047 21.982953 25.069844 22.001953 23.964844 C 22.020953 22.860844 22.930156 21.982953 24.035156 22.001953 z M 16.884766 24.126953 C 17.149697 24.147443 17.416266 24.193531 17.681641 24.269531 C 19.804641 24.877531 21.032828 27.093797 20.423828 29.216797 C 19.814828 31.339797 17.598563 32.566031 15.476562 31.957031 C 13.353562 31.349031 12.125375 29.134719 12.734375 27.011719 C 13.266375 25.154094 15.030244 23.983521 16.884766 24.126953 z M 3.8964844 26.615234 L 2.7871094 31.419922 C 1.9171094 35.190922 4.2622031 38.943453 8.0332031 39.814453 L 12.837891 40.923828 C 7.7948906 37.829828 4.4664844 32.504234 3.8964844 26.615234 z M 28.417969 27.433594 C 28.6829 27.454084 28.951422 27.502125 29.216797 27.578125 C 31.339797 28.186125 32.566031 30.400437 31.957031 32.523438 C 31.348031 34.646437 29.134719 35.873625 27.011719 35.265625 C 24.888719 34.657625 23.661531 32.443313 24.269531 30.320312 C 24.801531 28.462687 26.563447 27.290162 28.417969 27.433594 z M 40.923828 35.162109 C 37.829828 40.205109 32.504234 43.533516 26.615234 44.103516 L 31.419922 45.212891 C 35.190922 46.082891 38.943453 43.737797 39.814453 39.966797 L 40.923828 35.162109 z"></path></svg>
                    </i></a>
            </div>

            <nav id="navigation1" class="navigation h-100  d-flex justify-content-between align-items-center">
                <div class="nav-header">
                    <a class="nav-brand" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}"><img src="project_files/images/logo.png" alt="{$obj->Title_head()}"></a>
                </div>
                <div class="nav-menus-wrapper d-flex align-items-start flex-column ml-auto mr-2">
                    <ul class="nav-menu align-to-right">
                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/flight">پرواز</a></li>
                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/train">قطار</a></li>
                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/bus">اتوبوس</a></li>
                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/hotel">هتل ها</a></li>
                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/hotel-flight">پرواز+هتل</a></li>
                        <li><a href="javascript:">تور</a>
                            <ul class="nav-dropdown">
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/countrytour/1">تور خارجی</a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/irantourcity/1">تور داخلی</a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/tourid">تور زیارتی</a></li>
                            </ul>
                        </li>
                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/visacountry">ویزا</a>
                            {*<ul class="nav-dropdown">*}
                            {*{foreach key=key_continent item=item_continent from=$objResult->GetGdsContinents()}*}
                            {*<li>*}
                            {*<a href="javascript:">*}
                            {*{$item_continent.titleFa}*}
                            {*</a>*}
                            {*<ul class="nav-dropdown">*}
                            {*{foreach key=key_country item=item_country from=$objResult->GetGdsCountriesByContinent($item_continent.id)}*}
                            {*<li><a href="{$smarty.const.ROOT_ADDRESS}/resultVisa/{$item_country.code}/all/1-0-0">{$item_country.title}</a></li>*}
                            {*{/foreach}*}
                            {*</ul>*}
                            {*</li>*}
                            {*{/foreach}*}
                            {*</ul>*}
                        </li>
                        <li><a href="javascript:">خدمات</a>
                            <ul class="nav-dropdown">
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/news">اخبار</a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/faq"> پرسش و پاسخ </a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/article">وبلاگ</a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/insurance">بیمه</a></li>
                                <li><a href="https://sadadpsp.ir/tollpayment" target="_blank">پرداخت آنلاین عوارض خروج از کشور</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/pay">پرداخت آنلاین</a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/change">ارز</a></li>
                                <li><a href="https://charge.sep.ir/Eshop/KH71ggU85D">خرید شارژ ، بسته اینترنتی و پرداخت کلیه قبوض</a></li>
                            </ul>
                        </li>
                        <li><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری خرید</a></li>
                        <li><a href="javascript:">آژانس ما</a>
                            <ul class="nav-dropdown">
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/aboutus">درباره ما</a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/contactus">تماس با ما</a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/rules">قوانین و مقررات</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/loginUser">باشگاه مشتریان</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <span class="btns_header btns_header2 mr-auto">
                    <a href="javascript:" class="button_C p-2"> EN </a>
                </span>
                <span class="btns_header mr-1 stop-propagation  position-relative">
                            <a href="javascript:" class="button_C main-navigation__button2"><svg viewBox="0 0 24 24" width="24" height="24"
                                                                                                 fill="currentColor" class="ml-1 text-grays-500"
                                                                                                 data-v-765955f8=""><path
                                            d="M17.25 12.75A3.75 3.75 0 0 1 21 16.5v3.75a.75.75 0 0 1-.75.75H3.75a.75.75 0 0 1-.75-.75V16.5a3.75 3.75 0 0 1 3.75-3.75h10.5Zm0 1.5H6.75A2.25 2.25 0 0 0 4.5 16.5v3h15v-3a2.25 2.25 0 0 0-2.118-2.246l-.132-.004ZM12 3a4.5 4.5 0 1 1 0 9 4.5 4.5 0 1 1 0-9Zm0 1.5a3 3 0 1 0-.001 5.999A3 3 0 0 0 12 4.5Z"
                                            fill-rule="evenodd"></path></svg>
                                {include file="`$smarty.const.FRONT_THEMES_DIR`shabbadGashtGds/topBarName.tpl"}

                                <div class="button-chevron-2 ">

                                </div>
                            </a>
                            <div class="main-navigation__sub-menu2 arrow-up" style="display: none">

                                {include file="`$smarty.const.FRONT_THEMES_DIR`shabbadGashtGds/topBar.tpl"}

                            </div>
                        </span>
                <div class="nav-toggle mr-2"></div>
            </nav>
        </div>
    </div>
</header>