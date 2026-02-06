<header class="header_area fixedmenu ">
    <div class="main_header_area">


        <div class=" menus container">
            <nav id="navigation1" class="navigation">
                <!-- Logo Area Start -->

                <div class="nav-header">
                    <a class="flex-row" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}">
                        <div class="logo logoHolder flex-col">
                            <img src="project_files/images/logo.png" alt="{$obj->Title_head()}">
                        </div>


                    </a>
                    <div class="nav-toggle"></div>
                </div>

                <div class="nav-menus-wrapper">
                    <ul class="nav-menu ">

                        <li class=""><a href="javascript:;">تور</a>
                            <ul class="nav-dropdown first_child_menu  fadeIn animated">
                                <li><a href="javascript:;"> تور داخلی </a>
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
                                <li><a href="javascript:;"> تور خارجی </a>
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
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/tour"> جست و جوی تور </a></li>

                            </ul>
                        </li>

                        <li id="tours_m" class=""><a class="smoothScrollTo TabScroll " data-target="#flightda-tab"
                                                     href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/flight">##S360Flight##</a></li>

                        <li id="hotels_m" class=""><a class="smoothScrollTo TabScroll " data-target="#hotel-tab"
                                                      href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/hotel"> ##S360Hotels## </a></li>

                        <li class=""><a href="javascript:;">ویزا</a>
                            <ul class="nav-dropdown first_child_menu fadeIn animated">

                                {foreach key=key_continent item=item_continent from=$objResult->GetGdsContinents()}
                                    <li>
                                        <a href="javascript:;">
                                            {$item_continent.titleFa}
                                        </a>
                                        <ul class="nav-dropdown submenu-child fadeIn animated">

                                            {foreach key=key_country item=item_country from=$objResult->GetGdsCountriesByContinent($item_continent.id)}
                                                <li>
                                                    <a href="{$smarty.const.ROOT_ADDRESS}/resultVisa/{$item_country.code}/all/1-0-0">{$item_country.title}</a>
                                                </li>
                                            {/foreach}
                                        </ul>
                                    </li>
                                {/foreach}
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/visa">جست و جوی ویزا</a></li>
                            </ul>
                        </li>

                        <li id="hotels_m" class=""><a class="smoothScrollTo TabScroll " data-target="#hotel-tab"
                                                      href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/train"> قطار </a></li>
                        <li id="hotels_m" class=""><a class="smoothScrollTo TabScroll " data-target="#hotel-tab"
                                                      href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/bus"> اتوبوس </a></li>

                            <li id="fun_m" class=""><a class="smoothScrollTo TabScroll " data-target="#fun-tab"
                                                       href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/fun"> ##S360Entertainment## </a></li>
                            <li id="cars_m" class=""><a class="smoothScrollTo TabScroll " data-target="#car-tab"
                                                        href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/car"> ##S360Car## </a></li>


                        <li class="customers"><a href="javascript:;"> ##S360Passengers##</a>

                            <div class="megamenu-panel fadeIn animated  ">
                                <div class="megamenu-lists">
                                    <ul class="megamenu-list list-col-3">


                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/loginUser" target="_blank">##S360PassengerClub##</a></li>
                                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/vote" class="SMVote" target="_blank"> ##S360Poll## </a></li>
                                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/feedback" class="SMFeedback" target="_blank">##S360FeedBack##</a></li>


                                    </ul>
                                    <ul class="megamenu-list list-col-3">


                                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/lastminate" class="SMLastminate" target="_blank"> ##S360Min90## </a></li>
                                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/pay" class="SMPay" target="_blank"> ##S360OnlinePay## </a></li>
                                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/faq" class="SMFaq" target="_blank">##S360Faq##</a></li>
                                    </ul>

                                </div>
                            </div>

                        </li>
                        <li class=""><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/blog" class="SMLink">##S360Blog##</a></li>
                        <li class="know"><a href="javascript:;"> ##S360Information##</a>

                            <div class="megamenu-panel fadeIn animated  ">
                                <div class="megamenu-lists">
                                    <ul class="megamenu-list list-col-3">


                                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/aboutcountry" class="SMAboutCountry" target="_blank"> ##S360IntroduceCountries## </a></li>
                                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/aboutiran" class="SMAboutIran" target="_blank">##S360IntroduceIran##</a></li>
                                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/embassy" class="SMEmbassy" target="_blank">##S360Embassy##</a></li>
                                        <li><a href="{$smarty.const.ROOT_ADDRESS}/weather" class="SMWeather" target="_blank"> ##S360Weather## </a></li>
                                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/worldclock" class="SMWorldClock" target="_blank">##S360WorldClock##</a></li>


                                    </ul>
                                    <ul class="megamenu-list list-col-3">

                                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/blog" class="SMBlog" target="_blank"> ##S360Travelogue## </a></li>
                                        <li><a href="home.php#shamsiConvertDate"
                                               data-target=".shamsiConvertDate" class="smoothScrollTo"> ##S360ConvertDate## </a></li>
                                        <li><a href="javascript:;" class="" target="_blank">##S360ExchangeRate##</a></li>
                                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/news" class="SMNews" target="_blank"> ##S360News## </a></li>
                                        <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/worldgallery" class="SMWorldGallery" target="_blank">##S360WorldGallery##</a></li>

                                    </ul>

                                </div>
                            </div>

                        </li>
                        <li class="">
                            <a href="javascript:;">##S360OurAgency##</a>
                            <ul class="nav-dropdown first_child_menu">


                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/aboutus" class="SMAbout">##S360AboutUs##</a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/rules" class="SMRules"> ##S360Rules## </a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/staff" class="SMStaff"> ##S360Managers## </a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/employment" class="SMEmployment">##S360Employment##</a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/agentlist" class="SMAgentList" target="_blank"> ##S360Branches## </a></li>
                                <li class=""><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/contactus" class="SMContactUs"> ##S360ContactUs##</a></li>


                            </ul>

                        </li>


                        <li class="mobileMenu"><a href="<?php echo $linkSlash; ?>">##Home##</a></li>
                        <li class="peigiri_m"><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking" class="">##S360Track##</a></li>
                        <li class="mobileMenu"><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/contactus" class="SMContactUs"> ##S360ContactUs##</a></li>
                        <li class="mobileMenu"><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/aboutus" class="SMAbout">##S360AboutUs##</a></li>



                    </ul>
                </div>



                <div class="act-buttons">
                    <div class="nav-search">
                        <div class="top__user_menu">
                            <button class="main-navigation__button2">

                                {include file="`$smarty.const.FRONT_THEMES_DIR`iran_tech_s360/topBarName.tpl"}

                                <div class="button-chevron-2 ">

                                </div>
                            </button>

                            <div class="main-navigation__sub-menu2 arrow-up" style="display: none">

                                {include file="`$smarty.const.FRONT_THEMES_DIR`iran_tech_s360/topBar.tpl"}

                            </div>

                        </div>
                    </div>
                </div>

                <div class="act-buttons peygiri">

                    <div class="peigiri">
                        <a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">##S360Track##</a>
                    </div>
                </div>

              {*  <div class="social_top">

                    <ul>

                        <li><a href="" class="SMInstageram"><i class="fab fa-instagram"></i></a></li>
                        <li><a href="" class="SMTelegram"><i class="fab fa-telegram"></i></a></li>
                        <li><a href="" class="SMWhatsApp"><i class="fab fa-whatsapp"></i></a></li>

                    </ul>

                </div>*}

                <div class="lang">
                    <span>
                        <img src="project_files/images/language-icon-fa.png" alt="">
                    </span>

                    <ul class="lang_ul arrow-up ">

                        <li>
                            <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/">
                                <span>
                                  <img src="project_files/images/language-icon-fa.png" alt="" />
                                    فارسی
                              </span>
                            </a>
                        </li>

                        <li>
                            <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/en">
                                <span>
                                  <img src="project_files/images/language-icon-en.png" alt="" />
                                    English
                              </span>
                            </a>
                        </li>

                        <li>
                            <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/ar">
                                <span>
                                  <img src="project_files/images/language-icon-ar.png" alt="" />
                                    العربي
                              </span>
                            </a>
                        </li>
                    </ul>

                </div>



            </nav>
        </div>
    </div>


</header>