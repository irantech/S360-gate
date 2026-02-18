{load_presentation_object filename="user" assign="objUser"}
{if $objSession->IsLogin() and $objSession->getTypeUser() eq 'counter' &&  $smarty.const.IS_ENABLE_CLUB eq 1}
    {assign var="typeMember" value=$objFunctions->TypeUser($objSession->getUserId())}
    {assign var="profile" value=$objUser->getProfileGds({$objSession->getUserId()})} {*گرفتن اطلاعات کاربر*}
    {assign var="country_name" value=$objUser->getCountryName({$profile['passport_country_id']})}
    {assign var="userid" value=$objSession->getUserId()}

    {assign var="getPopularDiscountCode" value=$objUser->getDiscountCodeUser('popular')}
    {assign var="getPointDiscountCode" value=$objUser->getDiscountCodeUser('point')}
    {assign var="check_is_counter" value=$objUser->checkIsCounter() }
        {assign var="info_profile" value = $objUser->getProfile($userid)}
        {assign var="info_club" value = $objUser->getAboutClub()}

    <main>
        <section class="profile_section mt-3 mb-3 row">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 position-static">
                        <div class="menu-profile-ris d-lg-none">
                            <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/{$MainUrlAddress}" class="logo_img"><img src='{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$smarty.const.CLIENT_LOGO}' alt='logo'></a>
                            <button onclick="openMenuProfile()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M0 88C0 74.75 10.75 64 24 64H424C437.3 64 448 74.75 448 88C448 101.3 437.3 112 424 112H24C10.75 112 0 101.3 0 88zM0 248C0 234.7 10.75 224 24 224H424C437.3 224 448 234.7 448 248C448 261.3 437.3 272 424 272H24C10.75 272 0 261.3 0 248zM424 432H24C10.75 432 0 421.3 0 408C0 394.7 10.75 384 24 384H424C437.3 384 448 394.7 448 408C448 421.3 437.3 432 424 432z"/></svg></button>
                        </div>
                        <div onclick="closeMenuProfile()" class="bg-black-profile-ris d-lg-none"></div>
                        <div class="box-style sticky-100">
                            {include file="./profileSideBar.tpl" about_user=$info_club}
                        </div>
                    </div>
                    <div class="col-lg-9">
                        {include file="./profileHead.tpl" about_user=$info_club}
                        <div class="box-style-alert">
                            <div class="alert alert-primary" role="alert">
                                <div class="w-100">
                                    <h2>
                                        <i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464zM296 336h-16V248C280 234.8 269.3 224 256 224H224C210.8 224 200 234.8 200 248S210.8 272 224 272h8v64h-16C202.8 336 192 346.8 192 360S202.8 384 216 384h80c13.25 0 24-10.75 24-24S309.3 336 296 336zM256 192c17.67 0 32-14.33 32-32c0-17.67-14.33-32-32-32S224 142.3 224 160C224 177.7 238.3 192 256 192z"/></svg></i>
                                        ##AboutClub##  {$info_club['about_title_customer_club']}
                                    </h2>
                                    <p>
                                        {$info_club['about_customer_club']|strip_tags}
                                    </p>
                                    <button onclick="more_btn()">
                                        <span>##More##</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        {if !empty($getPopularDiscountCode)}
                        <div class="box-style discounts_introduction">
                            <div class="box-style-padding">
                                <h2 class="title">##Discounts##</h2>
                                        <div class="discounts_style" id="discounts-js">
                                            {foreach $getPopularDiscountCode as $code}
                                            <div class="discounts_style_box">
                                                <div>
                                        <span class="info">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M576 256C576 305 502.1 336 464.2 336H382.2L282.4 496C276.4 506 266.4 512 254.4 512H189.5C179.5 512 169.5 508 163.5 500C157.6 492 155.6 480.1 158.6 471L201.5 336H152.5L113.6 388C107.6 396 98.61 400 88.62 400H31.7C22.72 400 12.73 396 6.74 388C.7485 380-1.248 370 1.747 360L31.7 256L.7488 152C-1.248 143 .7488 133 6.74 125C12.73 117 22.72 112 31.7 112H88.62C98.61 112 107.6 117 113.6 125L152.5 176H201.5L158.6 41C155.6 32 157.6 21 163.5 13C169.5 5 179.5 0 189.5 0H254.4C265.4 0 277.4 7 281.4 16L381.2 176H463.2C502.1 176 576 208 576 256H576zM527.1 256C525.1 246 489.1 224 463.2 224H355.3L245.4 48H211.5L266.4 224H128.6L80.63 160H53.67L81.63 256L53.67 352H80.63L128.6 288H266.4L211.5 464H245.4L355.3 288H463.2C490.1 288 526.1 267 527.1 256V256z"/></svg>
                                            {$code['service_title']}
                                        </span>

                                                    <span>
                                            ##UsableUpTo## {$code['end_date_code']} ##AnotherDay##
                                        </span>
                                                    <span>
                                            {$code['count_used']} ##UseLoad##
                                        </span>
                                                </div>
                                                <h6>##Codediscount## {$code['title']} - ##Amount##{$code['amount']|number_format} ##Rial## </h6>
                                                <button onclick="copyOnClipboard(event , '{$code['code']}');">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M502.6 70.63l-61.25-61.25C435.4 3.371 427.2 0 418.7 0H255.1c-35.35 0-64 28.66-64 64l.0195 256C192 355.4 220.7 384 256 384h192c35.2 0 64-28.8 64-64V93.25C512 84.77 508.6 76.63 502.6 70.63zM464 320c0 8.836-7.164 16-16 16H255.1c-8.838 0-16-7.164-16-16L239.1 64.13c0-8.836 7.164-16 16-16h128L384 96c0 17.67 14.33 32 32 32h47.1V320zM272 448c0 8.836-7.164 16-16 16H63.1c-8.838 0-16-7.164-16-16L47.98 192.1c0-8.836 7.164-16 16-16H160V128H63.99c-35.35 0-64 28.65-64 64l.0098 256C.002 483.3 28.66 512 64 512h192c35.2 0 64-28.8 64-64v-32h-47.1L272 448z"/></svg>
                                                    <span>{$code['code']}</span>
                                                </button>
                                            </div>
                                        {/foreach}
                                        </div>
                                        {if $getPopularDiscountCode|count gt 4}
                                        <div class="more_btn">
                                            <a onclick="more_btn_club('discounts-js' , event)" href="javascript:">
                                                <span>##More##</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg>
                                            </a>
                                        </div>
                                        {/if}

                            </div>
                        </div>
                        {/if}
                        {if !empty($getPointDiscountCode)}
                        <div class="box-style discounts_introduction">
                            <div class="box-style-padding">
                                <h2 class="title">##BuyDiscountCodeWithPoints##</h2>

                                        <div class="discounts_style" id="club-js">
                                            {foreach $getPointDiscountCode as $code}
                                            <div class="discounts_style_box">
                                            <div>
                                            <span class="info">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M576 256C576 305 502.1 336 464.2 336H382.2L282.4 496C276.4 506 266.4 512 254.4 512H189.5C179.5 512 169.5 508 163.5 500C157.6 492 155.6 480.1 158.6 471L201.5 336H152.5L113.6 388C107.6 396 98.61 400 88.62 400H31.7C22.72 400 12.73 396 6.74 388C.7485 380-1.248 370 1.747 360L31.7 256L.7488 152C-1.248 143 .7488 133 6.74 125C12.73 117 22.72 112 31.7 112H88.62C98.61 112 107.6 117 113.6 125L152.5 176H201.5L158.6 41C155.6 32 157.6 21 163.5 13C169.5 5 179.5 0 189.5 0H254.4C265.4 0 277.4 7 281.4 16L381.2 176H463.2C502.1 176 576 208 576 256H576zM527.1 256C525.1 246 489.1 224 463.2 224H355.3L245.4 48H211.5L266.4 224H128.6L80.63 160H53.67L81.63 256L53.67 352H80.63L128.6 288H266.4L211.5 464H245.4L355.3 288H463.2C490.1 288 526.1 267 527.1 256V256z"/></svg>
                                               {$code['service_title']}

                                            </span>
                                                <span>
                                                ##UsableUpTo## {$code['end_date_code']} ##AnotherDay##
                                            </span>
                                                <span>
                                                {$code['count_used']} ##UseLoad##
                                            </span>
                                            </div>
                                                <h6>##Codediscount## {$code['title']} - ##Amount##{$code['amount']|number_format} ##Rial##</h6>
                                            <section>
                                            <span>
                                                <i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M509.1 198.8l-112-160C394.1 34.55 389.2 32 384 32H127.1C122.8 32 117.9 34.55 114.9 38.83l-112 160c-4.344 6.203-3.75 14.59 1.406 20.11l240 256C247.4 478.2 251.6 480 256 480s8.635-1.828 11.67-5.062l240-256C512.9 213.4 513.4 205 509.1 198.8zM383.4 75.13L465.3 192h-170.9L383.4 75.13zM256 189.6L160.3 64h191.4L256 189.6zM128.6 75.13L217.6 192H46.73L128.6 75.13zM256 440.6L52.93 224h406.1L256 440.6z"/></svg></i>
                                                {$code['limit_point_club']} ##Point##
                                            </span>
                                                <a href="javascript:" onclick="getDiscountCodeWithPoint(event.currentTarget , '{$code['id']}')">
                                                    <span>##GetDiscountCode##</span>
                                                    <div class="bouncing-loader bouncing-loader-none">
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                    </div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"></path></svg>
                                                </a>
                                            </section>
                                        </div>
                                        {/foreach}
                                        </div>
                                        {if $getPointDiscountCode|count gt 4}
                                            <div class="more_btn">
                                                <a onclick="more_btn_club('club-js' , event)" href="javascript:">
                                                    <span>##More##</span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg>
                                                </a>
                                            </div>
                                        {/if}

                            </div>
                        </div>
                        {/if}
                        <div class="box-style">
                            <div class="box-style-padding">
                                <h2 class="title">##SpecialDiscount##</h2>
                                <div class="row">
                                    <div class="col-lg-6 py-lg-0 py-3">
                                        {assign var="afte_substr" value=$objFunctions->substrDataSmarty($info_profile['mobile'],0,4)}
                                        {assign var="array_codes_phone" value=$objUser->getCodesPhoneSpecialDiscount()}
                                        {assign var="is_include_phone" value=in_array($afte_substr,$objUser->getCodesPhoneSpecialDiscount())}
                                        <div class="style_box_num_id {if $is_include_phone eq true}green{else}default{/if}">
                                            <h3>{$info_profile['mobile']}</h3>
                                            {if $is_include_phone eq true}

                                                <p>##UseMobileNumberReserving##</p>

                                            {else}

                                                <p>##YouCanSeeDiscountsEnabled##</p>

                                            {/if}
                                            <a href="javascript:" onclick="getSpecialDiscountCode(event.currentTarget , 'phone')">
                                                <span>##Detail##</span>
                                                <div class="bouncing-loader bouncing-loader-none">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"></path></svg>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 py-lg-0 py-3">

                                        {assign var="is_include_code" value=in_array(($info_profile['national_code']|substr:0:3),$objUser->getNationalCodesSpecialDiscount())}
                                        <div class="style_box_num_id {if $is_include_code}info{else}default{/if}">
                                            <h3>{$info_profile['national_code']}</h3>
                                            {if $is_include_code eq true}

                                                <p>##YouCanUseSpecialDiscounts##</p>

                                            {else}

                                                <p> ##YouCanSeeListDiscountsEnabled##</p>

                                            {/if}
                                            <a href="javascript:" onclick="getSpecialDiscountCode(event.currentTarget , 'national_code')">
                                                <span>##Detail##</span>
                                                <div class="bouncing-loader bouncing-loader-none">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"></path></svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-style discounts_introduction">
                            <div class="box-style-padding">
                                <h2 class="title">##InviteFreinds##</h2>
                                <div class="row">
                                    <div class="col-lg-7 py-lg-0 py-3 col-12">
                                        <div class="introduction_main_div">
                                            <div class="introduction_detail_div">
                                                <div>
                                                    <span>##RewardEeachIntroduction##</span>
                                                    <h6>{($objUser->getGetReagentPoint())|number_format} ##Rial## </h6>
                                                </div>
                                            </div>


                                            <div class="introduction_btn_div">
                                                {if $info_profile['fk_counter_type_id'] == 5}
                                                <button onclick="copyOnClipboard(event , '{$info_profile['reagent_code']}');">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M502.6 70.63l-61.25-61.25C435.4 3.371 427.2 0 418.7 0H255.1c-35.35 0-64 28.66-64 64l.0195 256C192 355.4 220.7 384 256 384h192c35.2 0 64-28.8 64-64V93.25C512 84.77 508.6 76.63 502.6 70.63zM464 320c0 8.836-7.164 16-16 16H255.1c-8.838 0-16-7.164-16-16L239.1 64.13c0-8.836 7.164-16 16-16h128L384 96c0 17.67 14.33 32 32 32h47.1V320zM272 448c0 8.836-7.164 16-16 16H63.1c-8.838 0-16-7.164-16-16L47.98 192.1c0-8.836 7.164-16 16-16H160V128H63.99c-35.35 0-64 28.65-64 64l.0098 256C.002 483.3 28.66 512 64 512h192c35.2 0 64-28.8 64-64v-32h-47.1L272 448z"/></svg>
                                                    <span>{$info_profile['reagent_code']}</span>
                                                </button>
                                                    <button onclick="share_btn('{$info_profile['reagent_code']}')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M448 112C448 156.2 412.2 192 368 192C345.1 192 324.4 182.4 309.9 166.1L158.9 242.5C159.6 246.9 160 251.4 160 256C160 260.6 159.6 265.1 158.9 269.5L309.9 345C324.4 329.6 345.1 320 368 320C412.2 320 448 355.8 448 400C448 444.2 412.2 480 368 480C323.8 480 288 444.2 288 400C288 390.3 289.7 380.1 292.9 372.3L147.2 299.5C132.9 321.5 108.2 336 80 336C35.82 336 0 300.2 0 256C0 211.8 35.82 176 80 176C108.2 176 132.9 190.5 147.2 212.5L292.9 139.7C289.7 131 288 121.7 288 112C288 67.82 323.8 32 368 32C412.2 32 448 67.82 448 112L448 112zM79.1 304C106.5 304 127.1 282.5 127.1 256C127.1 229.5 106.5 208 79.1 208C53.49 208 31.1 229.5 31.1 256C31.1 282.5 53.49 304 79.1 304zM368 64C341.5 64 320 85.49 320 112C320 138.5 341.5 160 368 160C394.5 160 416 138.5 416 112C416 85.49 394.5 64 368 64zM368 448C394.5 448 416 426.5 416 400C416 373.5 394.5 352 368 352C341.5 352 320 373.5 320 400C320 426.5 341.5 448 368 448z"/></svg></button>
                                                {else}
                                                <button>
                                                    <span>##IntroductionCodeNotAssigned## </span>
                                                </button>
                                                    <button onclick="share_btn('{$info_profile['reagent_code']}')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M448 112C448 156.2 412.2 192 368 192C345.1 192 324.4 182.4 309.9 166.1L158.9 242.5C159.6 246.9 160 251.4 160 256C160 260.6 159.6 265.1 158.9 269.5L309.9 345C324.4 329.6 345.1 320 368 320C412.2 320 448 355.8 448 400C448 444.2 412.2 480 368 480C323.8 480 288 444.2 288 400C288 390.3 289.7 380.1 292.9 372.3L147.2 299.5C132.9 321.5 108.2 336 80 336C35.82 336 0 300.2 0 256C0 211.8 35.82 176 80 176C108.2 176 132.9 190.5 147.2 212.5L292.9 139.7C289.7 131 288 121.7 288 112C288 67.82 323.8 32 368 32C412.2 32 448 67.82 448 112L448 112zM79.1 304C106.5 304 127.1 282.5 127.1 256C127.1 229.5 106.5 208 79.1 208C53.49 208 31.1 229.5 31.1 256C31.1 282.5 53.49 304 79.1 304zM368 64C341.5 64 320 85.49 320 112C320 138.5 341.5 160 368 160C394.5 160 416 138.5 416 112C416 85.49 394.5 64 368 64zM368 448C394.5 448 416 426.5 416 400C416 373.5 394.5 352 368 352C341.5 352 320 373.5 320 400C320 426.5 341.5 448 368 448z"/></svg></button>
                                                {/if}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 py-lg-0 py-3 col-12">
                                        <div class="text_box_introduction_box">
                                            <a  href="javascript:" onclick="getTotalUserReward( event.currentTarget,'{$info_profile['id']}')" class="text_box_introduction">
                                                <h6>##SumReward##</h6>
                                                {assign var="amount_reagent" value=$objUser->getSumReagentPoint()}
                                                <p>{($amount_reagent['sum_amount'])|number_format} ##Rial##</p>
                                            </a>
                                            <a href="javascript:" onclick="getInvitedUserList( event.currentTarget,'{$info_profile['reagent_code']}')"  class="text_box_introduction">
                                                <h6>##Invited##</h6>
                                                {assign var="amount_reagent" value=$objUser->getCountUseMembersOfReagentCode({$info_profile['reagent_code']})}
                                               <br>
                                                <p>{$amount_reagent['count_use_reagent']} ##People##</p>
                                            </a>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/vote" target='_blank'   class="text_box_introduction">
                                                <h6>##S360Poll##</h6>
                                            </a>
                                        </div>


                                        <div class="text_box_introduction">
                                            <h6>##CodeShare##</h6>
                                            <p>##ShareDedicatedReagentCode##</p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-style">
                            <div class="box-style-padding accordion_Club">
                                <h2 class="title">##NabaeBaghdadUserFaq##</h2>
                                <div class="accordion" id="accordionExample">
                                    {assign var="faqs" value=$objUser->getFaqPublic()}
                                    {foreach $faqs as $key=>$faq}
                                    <div class="card">
                                        <div class="card-header" id="heading{$key}">

                                            <button class="btn btn-link btn-block text-left"
                                                    type="button"
                                                    data-toggle="collapse"
                                                    data-target="#collapse{$key}"
                                                    aria-expanded="true"
                                                    aria-controls="collapse{$key}">
                                                {$faq['title']}
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M360.5 217.5l-152 143.1C203.9 365.8 197.9 368 192 368s-11.88-2.188-16.5-6.562L23.5 217.5C13.87 208.3 13.47 193.1 22.56 183.5C31.69 173.8 46.94 173.5 56.5 182.6L192 310.9l135.5-128.4c9.562-9.094 24.75-8.75 33.94 .9375C370.5 193.1 370.1 208.3 360.5 217.5z"/></svg>
                                            </button>
                                        </div>
                                        <div id="collapse{$key}"
                                             class="style_accordion_main collapse show"
                                             aria-labelledby="heading{$key}"
                                             data-parent="#accordionExample">
                                            <div class="card-body">
                                               {$faq['content']}
                                            </div>
                                        </div>
                                    </div>
                                    {/foreach}

                                </div>
                                <div class="more_btn">
                                    <a href="{$smarty.const.ROOT_ADDRESS}/faq">
                                        <span>##More##</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <div id="html_modal_special_codes"></div>
    <div id="html_modal_change_password"></div>

{literal}

    <script src="assets/js/profile.js"></script>
    <script type="text/javascript">
    </script>
{/literal}

{else}

    {$objUser->redirectOut()}
{/if}
