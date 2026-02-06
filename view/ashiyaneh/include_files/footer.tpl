{load_presentation_object filename="aboutUs" assign="objAbout"}
{assign var="about"  value=$objAbout->getData()}
{if $smarty.session.layout neq 'pwa'}
    {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}
        <footer class="i_modular_footer">
            <div class="body-footer">
                <div class="container">
                    <div class="row">
                        <div class="parent-footer-iran d-flex flex-wrap w-100">
                            <div class="item-footer col-lg-4 col-md-6 col-sm-12 col-12">
                                <div class="parent-item-footer parent-item-footer-responsive">
                                    <!--                            <a class="nav-brand" href="__main_link_href__">-->
                                    <!--                                <img class="__logo_class__" src="project_files/images/footer-logo.png" alt="">-->
                                    <!--                                <div class="logo-caption">-->
                                    <!--                                    <span class="sub-logo">Arvan Travel</span>-->
                                    <!--                                    <span>Travel agency</span>-->
                                    <!--                                </div>-->
                                    <!--                            </a>-->
                                    <div class="box-item-footer text-right">
                                        <h3 class="p-0">
                                            Contact us
                                        </h3>
                                    </div>
                                    <div class="child-item-footer align-items-start">
                                        <i class="fa-light fa-location-dot">
                                        </i>
                                        <span class="__address_class__">
                                         {$smarty.const.CLIENT_ADDRESS}
                                        </span>
                                    </div>
                                    <div class="child-item-footer">
                                        <i class="fa-light fa-mobile">
                                        </i>
                                        <a class="__mobile_class__" href="tel:{$smarty.const.CLIENT_MOBILE}">
                                            {$smarty.const.CLIENT_MOBILE}
                                        </a>
                                    </div>
                                    <div class="child-item-footer">
                                        <i class="fa-light fa-envelope">
                                        </i>
                                        <a class="__email_class__" href="mailto:{$smarty.const.CLIENT_EMAIL}">
                                            {$smarty.const.CLIENT_EMAIL}
                                        </a>
                                    </div>
                                    {assign var="socialLinks"  value=$about['social_links']|json_decode:true}
                                    {assign var="socialLinksArray" value=['telegram'=>'telegramHref','whatsapp'=> 'whatsappHref','instagram' => 'instagramHref','aparat' => 'aparatHref','youTube' => 'youtubeHref','facebook' => 'facebookHref','linkedin' => 'linkeDinHref' , 'twitter' => 'twitterHref']}

                                    {foreach $socialLinks as $key => $val}
                                        {assign var=$socialLinksArray[$val['social_media']] value=$val['link']}
                                    {/foreach}
                                    <div class="__social_class__ footer-icon my-footer-icon">
                                        <a class="__telegram_class__ footer_telegram"
                                           href="{if $telegramHref}{$telegramHref}{/if}" target="_blank">
                                            <svg viewbox="0 0 496 512" xmlns="http://www.w3.org/2000/svg">
                                                <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path d="M248,8C111.033,8,0,119.033,0,256S111.033,504,248,504,496,392.967,496,256,384.967,8,248,8ZM362.952,176.66c-3.732,39.215-19.881,134.378-28.1,178.3-3.476,18.584-10.322,24.816-16.948,25.425-14.4,1.326-25.338-9.517-39.287-18.661-21.827-14.308-34.158-23.215-55.346-37.177-24.485-16.135-8.612-25,5.342-39.5,3.652-3.793,67.107-61.51,68.335-66.746.153-.655.3-3.1-1.154-4.384s-3.59-.849-5.135-.5q-3.283.746-104.608,69.142-14.845,10.194-26.894,9.934c-8.855-.191-25.888-5.006-38.551-9.123-15.531-5.048-27.875-7.717-26.8-16.291q.84-6.7,18.45-13.7,108.446-47.248,144.628-62.3c68.872-28.647,83.183-33.623,92.511-33.789,2.052-.034,6.639.474,9.61,2.885a10.452,10.452,0,0,1,3.53,6.716A43.765,43.765,0,0,1,362.952,176.66Z">
                                                </path>
                                            </svg>
                                        </a>
                                        <a class="__instagram_class__ footer_instagram"
                                           href="{if $instagramHref}{$instagramHref}{/if}" target="_blank">
                                            <svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                                                <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z">
                                                </path>
                                            </svg>
                                        </a>
                                        <a class="__whatsapp_class__ footer_whatsapp"
                                           href="{if $whatsappHref}{$whatsappHref}{/if}" target="_blank">
                                            <svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                                                <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z">
                                                </path>
                                            </svg>
                                        </a>
                                        <a class="__linkdin_class__ footer_linkedin"
                                           href="{if $linkeDinHref}{$linkeDinHref}{/if}" target="_blank">
                                            <svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                                                <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z">
                                                </path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="item-footer col-lg-8 col-md-6 col-sm-12 col-12 d-md-block d-none">
                                <div class="box-item-footer text-right">
                                    <h3>
                                        Easy access
                                    </h3>
                                    <ul>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">
                                                Tour
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">
                                                Purchase tracking
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/aboutIran">
                                                Introduction of Iran
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/personnel">
                                                Personnel
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/clock">
                                                Countries Clock
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/weather">
                                                meteorology
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">
                                                About Us
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/contactUs">
                                                Contact Us
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="item-footer col-12">
                                <div class="box-item-footer d-flex flex-column align-items-center">
                                    <div class="parent-tour-footer">


                                        {assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
                                        {assign var="special_tour_params" value=['type'=>'special','limit'=> '3','dateNow' => $dateNow]}
                                        {assign var='special_tours' value=$obj_main_page->getToursReservation($special_tour_params)}
                                        {foreach $special_tours as $tour}
                                        <a class="" href="javascript:">
                                            <div class="parent-tour-img-footer">
                                                <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$tour['tour_pic']}" alt="{$tour['tour_name']}">
                                                <span class="btn-main">
                                                   <i class="far fa-link">
                                                   </i>
                                                  </span>
                                            </div>
                                            <div class="caption-tour">
                                                <h4>
                                                    {$tour['tour_name']}
                                                </h4>
                                                {assign var="year" value=substr($tour['start_date'], 0, 4)}
                                                {assign var="month" value=substr($tour['start_date'], 4, 2)}
                                                {assign var="day" value=substr($tour['start_date'], 6)}
                                                <span>{$year}/{$month}/{$day}</span>
                                            </div>
                                        </a>
                                        {/foreach}

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="last_text col-12">
                <a class="last_a" href="https://www.iran-tech.com/">
                    Tourism website design
                </a>
                <p class="last_p_text">
                    : Iran technology
                </p>
            </div>
            <a class="fixicone" href="javascript:" id="scroll-top">
                <svg viewbox="0 0 384 512" xmlns="http://www.w3.org/2000/svg">
                    <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                    <path d="M363.9 330.7c-6.271 6.918-16.39 6.783-22.62 1.188L192 197.5l-149.3 134.4c-6.594 5.877-16.69 5.361-22.62-1.188C14.2 324.1 14.73 314 21.29 308.1l159.1-144c6.125-5.469 15.31-5.469 21.44 0l159.1 144C369.3 314 369.8 324.1 363.9 330.7z">
                    </path>
                </svg>
            </a>
        </footer>
    {/if}
{else}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`pwaFooter.tpl"}
{/if}