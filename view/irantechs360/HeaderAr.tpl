{assign var="pass_hash" value=$obj_main_page->hashPasswordUser()}
{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
<header class="header_area fixedmenu ">
    <div class="main_header_area">


        <div class=" menus container">
            <nav id="navigation1" class="navigation">
                <!-- Logo Area Start -->
                <div class="nav-header">
                    <a class="flex-row" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/ar">
                        <div class="logo logoHolder flex-col">
                            <img src="project_files/{$smarty.const.SOFTWARE_LANG}/images/logo.png" alt="{$obj_main_page->pageInfo['title']}">
                        </div>
                    </a>
                    <div class="nav-toggle"></div>
                </div>

                <div class="nav-menus-wrapper">
                    <ul class="nav-menu ">
                        <li class=""><a href="javascript:;">##Tour##</a>
                            <ul class="nav-dropdown first_child_menu  fadeIn animated">
                                <li><a href="javascript:;"> ##domesticTour## </a>
                                    <ul class="nav-dropdown submenu-child fadeIn animated">
                                        {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCities('=1', 'return')}
                                            <li>
                                                <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-{$item_tour.id}/{$objDate->jdate("Y-m-d", '', '', '', 'en')}/all">
                                                    {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                                </a>
                                            </li>
                                        {/foreach}
                                    </ul>
                                </li>
                                <li><a href="javascript:;"> ##foreigneTour## </a>
                                    <ul class="nav-dropdown submenu-child fadeIn animated">
                                        {foreach key=key_tour item=item_tour from=$objResult->ReservationTourCountries('yes')}
                                            <li>
                                                <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$item_tour.id}-all/{$objDate->jdate("Y-m-d", '', '', '', 'en')}/all">
                                                    {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}
                                                </a>
                                            </li>
                                        {/foreach}
                                    </ul>
                                </li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/tour"> ##Search## </a></li>

                            </ul>
                        </li>

                        <li id="tours_m" class=""><a class="smoothScrollTo TabScroll " data-target="#flightda-tab"
                                                     href="{$smarty.const.ROOT_ADDRESS}/page/flight">##S360Flight##</a></li>

                        <li id="hotels_m" class=""><a class="smoothScrollTo TabScroll " data-target="#hotel-tab"
                                                      href="{$smarty.const.ROOT_ADDRESS}/page/hotel"> ##S360Hotels## </a></li>

                        <li class=""><a href="javascript:;">##Visa##</a>
                            <ul class="nav-dropdown first_child_menu fadeIn animated">

                                {foreach key=key_continent item=item_continent from=$obj_main_page->continentsHaveVisa()}
                                    {
                                    <li>
                                        <a href="javascript:;">

                                            {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_continent.titleFa : $item_continent.titleEn}

                                        </a>
                                        <ul class="nav-dropdown submenu-child fadeIn animated">
                                            {foreach key=key_country item=item_country from=$obj_main_page->countriesHaveVisa($item_continent.id)}
                                                <li>
                                                    <a href="{$smarty.const.ROOT_ADDRESS}/resultVisa/{$item_country.code}/all/1-0-0">
                                                        {($smarty.const.SOFTWARE_LANG == 'fa') ? $item_country.title : $item_country.title_en}

                                                    </a>
                                                </li>
                                            {/foreach}
                                        </ul>
                                    </li>
                                {/foreach}
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/visa">##VisaSearch##</a></li>
                            </ul>
                        </li>

{*                        <li id="hotels_m" class=""><a class="smoothScrollTo TabScroll " data-target="#hotel-tab"*}
{*                                                      href="{$smarty.const.ROOT_ADDRESS}/page/train"> ##S360Train## </a></li>*}
{*                        <li id="hotels_m" class=""><a class="smoothScrollTo TabScroll " data-target="#hotel-tab"*}
{*                                                      href="{$smarty.const.ROOT_ADDRESS}/page/bus"> ##S360Bus## </a></li>*}

                        <li id="fun_m" class=""><a class="smoothScrollTo TabScroll " data-target="#fun-tab"
                                                   href="{$smarty.const.ROOT_ADDRESS}/page/fun"> ##S360Entertainment## </a></li>
{*                        <li id="cars_m" class=""><a class="smoothScrollTo TabScroll " data-target="#car-tab"*}
{*                                                    href="{$smarty.const.ROOT_ADDRESS}/page/car"> ##S360Car## </a></li>*}


                        <li class="customers"><a href="javascript:;"> ##S360Passengers##</a>

                            <div class="megamenu-panel fadeIn animated  ">
                                <div class="megamenu-lists">
                                    <ul class="megamenu-list list-col-3">

                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/loginUser" >##S360PassengerClub##</a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/vote"> ##S360Poll## </a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/feedback" class="">##S360FeedBack##</a></li>
                                    </ul>
                                    <ul class="megamenu-list list-col-3">
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/lastMinute" class="SMLastminate"> ##S360Min90## </a></li>
{*                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/pay" > ##S360OnlinePay## </a></li>*}
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/faq">##S360Faq##</a></li>

                                    </ul>

                                </div>
                            </div>

                        </li>
                        <li class=""><a href="{$smarty.const.ROOT_ADDRESS}/mag">##S360Blog##</a></li>
                        <li class="know"><a href="javascript:;"> ##S360Information##</a>

                            <div class="megamenu-panel fadeIn animated  ">
                                <div class="megamenu-lists">
                                    <ul class="megamenu-list list-col-3">
{*                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/aboutCountry" > ##S360IntroduceCountries## </a></li>*}
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/aboutIran" >##S360IntroduceIran##</a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/embassies"">##S360Embassy##</a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/weather"> ##S360Weather## </a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/clock">##S360WorldClock##</a></li>
                                    </ul>
                                    <ul class="megamenu-list list-col-3">

                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/recommendation"> ##S360Travelogue## </a></li>
                                        <li><a href="/ar/#shamsiConvertDate" data-target=".shamsiConvertDate" class="smoothScrollTo"> ##S360ConvertDate## </a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/currency">##S360ExchangeRate##</a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/news"> ##S360News## </a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/gallery">##S360WorldGallery##</a></li>

                                    </ul>

                                </div>
                            </div>

                        </li>
                        <li class="">
                            <a href="javascript:;">##S360OurAgency##</a>
                            <ul class="nav-dropdown first_child_menu">


                                <li><a href="{$smarty.const.ROOT_ADDRESS}/aboutUs" >##S360AboutUs##</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/rules"> ##S360Rules## </a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/personnel" > ##S360Managers## </a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/employment" >##S360Employment##</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/agencyList" > ##S360Branches## </a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/video" > ##S360videos## </a></li>
                                <li ><a href="{$smarty.const.ROOT_ADDRESS}/contactUs"> ##S360ContactUs##</a></li>


                            </ul>

                        </li>


                        <li class="mobileMenu"><a href="/">##Home##</a></li>
                        {*                        <li class="peigiri_m"><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking" >##S360Track##</a></li>*}
                        <li class="mobileMenu"><a href="{$smarty.const.ROOT_ADDRESS}/contactUs"> ##S360ContactUs##</a></li>
                        <li class="mobileMenu"><a href="{$smarty.const.ROOT_ADDRESS}/aboutUs" >##S360AboutUs##</a></li>



                    </ul>
                </div>



                <div class="act-buttons act-buttons-mobile">
                    <div class="nav-search">
                        <div class="top__user_menu">
                            <button class="{if $obj_main_page->isLogin()}main-navigation__button2{else}main-navigation__button1{/if} {if $obj_main_page->isLogin() }show-box-login-js{/if}">

                                {include file="`$smarty.const.FRONT_CURRENT_THEME`topBarName.tpl"}

                                <div class="button-chevron-2 ">

                                </div>
                            </button>

                            <div class="main-navigation__sub-menu2 arrow-up show-content-box-login-js" style="display: none">

                                {include file="`$smarty.const.FRONT_CURRENT_THEME`topBar.tpl"}

                            </div>

                        </div>
                    </div>
                </div>

                {*                <div class="act-buttons peygiri">*}

                {*                    <div class="peigiri">*}
                {*                        <a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">##S360Track##</a>*}
                {*                    </div>*}
                {*                </div>*}

                {*  <div class="social_top">

                      <ul>

                          <li><a href="" class="SMInstageram"><i class="fab fa-instagram"></i></a></li>
                          <li><a href="" class="SMTelegram"><i class="fab fa-telegram"></i></a></li>
                          <li><a href="" class="SMWhatsApp"><i class="fab fa-whatsapp"></i></a></li>

                      </ul>

                  </div>*}

                <div class="lang">
                    <span>
                        <img src="project_files/{$smarty.const.SOFTWARE_LANG}/images/language-icon-fa.png" alt="">
                    </span>

                    <ul class="lang_ul arrow-up">

                        <li>
                            <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa">
                                <span>
                                  <img src="project_files/{$smarty.const.SOFTWARE_LANG}/images/language-icon-fa.png" alt="" />
                                     Parsian
                              </span>
                            </a>
                        </li>

                        <li>
                            <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/en">
                                <span>
                                  <img src="project_files/{$smarty.const.SOFTWARE_LANG}/images/language-icon-en.png" alt="" />
                                     English
                              </span>
                            </a>
                        </li>
                    </ul>

                </div>



            </nav>
        </div>
    </div>


</header>
{load_presentation_object filename="aboutUs" assign="objAbout"}
{assign var="about"  value=$objAbout->getData()}
{assign var="socialLinks"  value=$about['social_links']|json_decode:true}
{assign var="socialLinksArray" value=['telegram'=>'telegramHref','whatsapp'=> 'whatsappHref','instagram' => 'instagramHref', 'aparat' => 'aparatHref']}

{foreach $socialLinks as $key => $val}
    {assign var=$socialLinksArray[$val['social_media']] value=$val['link']}
{/foreach}
<div class="float-sm">
    <div class="fl-fl float-gp">
        <a href="{if $telegramHref}{$telegramHref}{else}javascript:;{/if}" target="_blank"><i class="fab fa-telegram"></i>##joinUs##!</a>
    </div>
    <div class="fl-fl float-rs">
        <a href="tel:{$smarty.const.CLIENT_MOBILE}" target="_blank"><i class="fab fa-whatsapp"></i>##Contactus##!</a>
    </div>
    <div class="fl-fl float-ig">
        <a href="{if $instagramHref}{$instagramHref}{else}javascript:;{/if}" target="_blank"><i class="fab fa-instagram"></i>##followUs##!</a>
    </div>
</div>
<div class="left_text_">
    <div class="contact_popup">
        <div style="direction:rtl" class="popup_content">
            <div class="phone">
                ##SoftwareDemo##
            </div>
        </div>
    </div>
    <div class="tejari">
        ##NonCommercial##
    </div>
</div>
