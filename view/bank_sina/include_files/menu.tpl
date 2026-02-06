
        <header class="header_area">

            <div class="main_header_area animated">
                <div class="container">
                    <nav id="navigation1" class="navigation">
                        <div class="nav-header">
                            <a class="nav-brand" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
                                <img src="project_files/images/logo.png" alt="img"/> </a>
                        </div>
                        <div class="nav-menus-wrapper">
                            <ul class="nav-menu align-to-right">


                                <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">##Home##</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/hotel">##Hotel##</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-all/{$objDate->jtoday()}/all">##Tour##</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/rules"> ##ShoppingRules##</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">##S360UserTracking##</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">##AboutUs##</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/contactUs">##CallUs## </a></li>


                            </ul>
                        </div>
                        <div class="header-call">
                            <a class="header-tell" href="tel:{$smarty.const.CLIENT_PHONE}">{$smarty.const.CLIENT_PHONE}
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M484.6 330.6C484.6 330.6 484.6 330.6 484.6 330.6l-101.8-43.66c-18.5-7.688-40.2-2.375-52.75 13.08l-33.14 40.47C244.2 311.8 200.3 267.9 171.6 215.2l40.52-33.19c15.67-12.92 20.83-34.16 12.84-52.84L181.4 27.37C172.7 7.279 150.8-3.737 129.6 1.154L35.17 23.06C14.47 27.78 0 45.9 0 67.12C0 312.4 199.6 512 444.9 512c21.23 0 39.41-14.44 44.17-35.13l21.8-94.47C515.7 361.1 504.7 339.3 484.6 330.6zM457.9 469.7c-1.375 5.969-6.844 10.31-12.98 10.31c-227.7 0-412.9-185.2-412.9-412.9c0-6.188 4.234-11.48 10.34-12.88l94.41-21.91c1-.2344 2-.3438 2.984-.3438c5.234 0 10.11 3.094 12.25 8.031l43.58 101.7C197.9 147.2 196.4 153.5 191.8 157.3L141.3 198.7C135.6 203.4 133.8 211.4 137.1 218.1c33.38 67.81 89.11 123.5 156.9 156.9c6.641 3.313 14.73 1.531 19.44-4.219l41.39-50.5c3.703-4.563 10.16-6.063 15.5-3.844l101.6 43.56c5.906 2.563 9.156 8.969 7.719 15.22L457.9 469.7z"/></svg>
                            </a>
                        </div>
                        <div class="login-register">
                            <div class="menu-login site-bg-main-color">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M320 128a96 96 0 1 0 -192 0 96 96 0 1 0 192 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM32 480H416c-1.2-79.7-66.2-144-146.3-144H178.3c-80 0-145 64.3-146.3 144zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z"/></svg>
                                <div class="c-header__btn">
                                    <div class="c-header__btn-login" href="javascript:;">
                                        {include file="`$smarty.const.FRONT_THEMES_DIR`subagency/topBarName.tpl"}
                                    </div>
                                    <div class="main-navigation__sub-menu2 arrow-up">
                                        {include file="`$smarty.const.FRONT_THEMES_DIR`subagency/topBar.tpl"}
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="nav-toggle"></div>
                    </nav>
                </div>
            </div>
        </header>


