<header class="header_area fixedmenu ">
    <div class="main_header_area">


        <div class=" menus container">
            <nav id="navigation1" class="navigation">
                <!-- Logo Area Start -->
                <div class="nav-header">
                    <a class="flex-row" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}">
                        <div class="logo logoHolder flex-col">
                            <img src="project_files/images/logo.png" alt="{$obj->Title_head()}<">
                        </div>


                    </a>
                    <div class="nav-toggle"></div>
                </div>

                <div class="nav-menus-wrapper">
                    <ul class="nav-menu ">

                        <li id="tours_m" class="">
                            <a class="smoothScrollTo TabScroll " data-target="#flightda-tab"
                                                     href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/{$mainPage}#flightda">##S360Flight##</a></li>
                        <li id="hotels_m" class="">
                            <a class="smoothScrollTo TabScroll " data-target="#hotel-tab"
                                                      href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/{$mainPage}#hotel"> ##S360Hotels## </a></li>
                        <li id="tours_m" class="">
                            <a class="smoothScrollTo TabScroll " data-target="#tour-tab"
                                                     href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/{$mainPage}#tour">##S360Tour##</a></li>


                        <li class=""><a href="javascript:;">##S360Passengers##</a>
                            <ul class="nav-dropdown ">

                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/survey" class="SMSurvey">Survey</a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/contactus" class="SMContactUs">Suggestion</a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}#newsletter-form-scroll" class="smoothScrollTo" data-target=".newsletter-form-scroll">News Letter</a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/faq" class="SMFaq">Faq</a></li>

                            </ul>

                        </li>

                        <li class=""><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/blog" class="SMLink">##S360Blog##</a></li>

                        <li class=""><a href="javascript:;">Iran</a>
                            <ul class="nav-dropdown ">


                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/aboutiran" class="SMAboutIran">About Iran</a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/weather" class="SMWeather">Iran Weather</a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/logbook" class="SMLogBook">Itinerary</a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/news" class="SMNews">News</a></li>

                            </ul>

                        </li>

                        <li class=""><a href="javascript:;">About Us</a>
                            <ul class="nav-dropdown">


                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/aboutus" class="SMAbout">About Us </a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/rules" class="SMRules">Terms and Conditions</a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/staff" class="SMStaff">Staff</a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/agentlist" class="">Agent</a></li>

                            </ul>

                        </li>

                        <li class=""><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/contactus" class="SMLink">Contact Us</a></li>

                        <li class=""><a href="javascript:;">Medical Services</a>
                            <ul class="nav-dropdown">
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/healthy_type" class="">Package And Tour</a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/hospital" class="">Medical Center</a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/doctor" class="">Doctor</a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/patient_information" class="">Patient Information</a></li>
                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/compare_changes" class="">Before After</a></li>

                            </ul>

                        </li>

                        <li class="mobileMenu"><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}">Home</a></li>
                        <li class="mobileMenu"><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">##S360Track##</a></li>
                        <li class="mobileMenu"><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/contactus" class="SMLink">Contact Us</a></li>
                        <li class="mobileMenu"><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/aboutus" class="SMAbout">About Us </a></li>



                    </ul>
                </div>


                <div class="act-buttons peygiri">
                    <div class="peigiri">




                                <a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">##S360Track##</a>



                    </div>
                </div>

                <div class="act-buttons">
                    <div class="nav-search">
                        <div class="top__user_menu">
                            <button class="main-navigation__button2">

                                {include file="`$smarty.const.FRONT_THEMES_DIR`iran_tech_s360/topBarName.tpl"}

                                <div class="button-chevron-2 ">

                                </div>
                            </button>

                            <div class="main-navigation__sub-menu2 arrow-up p-0">

                                {include file="`$smarty.const.FRONT_THEMES_DIR`iran_tech_s360/topBar.tpl"}

                            </div>

                        </div>
                    </div>
                </div>


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