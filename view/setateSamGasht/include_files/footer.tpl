{load_presentation_object filename="aboutUs" assign="objAbout"}
{assign var="about"  value=$objAbout->getData()}
{if $smarty.session.layout neq 'pwa'}
    {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}
        <footer class="i_modular_footer i_modular_tours">
            <div class="body-footer">
                <div class="container">
                    <div class="row">
                        <div class="parent-footer-iran d-flex flex-wrap w-100">
                            <div class="item-footer col-lg-3 col-md-6 col-sm-12 col-12 order-foot1">
                                <div class="parent-item-footer parent-item-footer-responsive box-item-footer2">
                                    <img alt="img-logo" src="project_files/images/logo.png" />
                                    <div class="parent-about-footer box-item-footer text-right">
                                    <span class="__aboutUs_class__ text-footer-about">
                                     {$htmlContent = $about['body']|strip_tags}{$htmlContent|truncate:300}
                                    </span>
                                        <a class="{$smarty.const.ROOT_ADDRESS}/contactUs footer-more-link"
                                           href="{$smarty.const.ROOT_ADDRESS}/aboutUs">
                                            بیشتر
                                            <svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                                                <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                <path d="M447.1 256c0 13.25-10.76 24.01-24.01 24.01H83.9l132.7 126.6c9.625 9.156 9.969 24.41 .8125 33.94c-9.156 9.594-24.34 9.938-33.94 .8125l-176-168C2.695 268.9 .0078 262.6 .0078 256S2.695 243.2 7.445 238.6l176-168C193 61.51 208.2 61.85 217.4 71.45c9.156 9.5 8.812 24.75-.8125 33.94l-132.7 126.6h340.1C437.2 232 447.1 242.8 447.1 256z">
                                                </path>
                                            </svg>
                                        </a>
                                        {assign var="socialLinks"  value=$about['social_links']|json_decode:true}
                                        {assign var="socialLinksArray" value=['telegram'=>'telegramHref','whatsapp'=> 'whatsappHref','instagram' => 'instagramHref','aparat' => 'aparatHref','youTube' => 'youtubeHref','facebook' => 'facebookHref','linkedin' => 'linkeDinHref' , 'twitter' => 'twitterHref']}

                                        {foreach $socialLinks as $key => $val}
                                            {assign var=$socialLinksArray[$val['social_media']] value=$val['link']}
                                        {/foreach}
                                        <div class="__social_class__ footer-icon icon-respancive">
                                            <a class="__telegram_class__ fab fa-telegram footer_telegram"
                                               href="{if $telegramHref}{$telegramHref}{/if}" target="_blank">
                                            </a>
                                            <a class="__instagram_class__ fab fa-instagram footer_instagram"
                                               href="{if $instagramHref}{$instagramHref}{/if}" target="_blank">
                                            </a>
                                            <a class="__whatsapp_class__ fab fa-whatsapp footer_whatsapp"
                                               href="{if $whatsappHref}{$whatsappHref}{/if}" target="_blank">
                                            </a>
                                            <a class="__linkdin_class__ fa-brands fa-linkedin-in footer_linkedin"
                                               href="{if $linkeDinHref}{$linkeDinHref}{/if}" target="_blank">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="__social_class__ footer-icon my-footer-icon">
                                        <a class="__telegram_class__ fab fa-telegram footer_telegram"
                                           href="{if $telegramHref}{$telegramHref}{/if}" target="_blank">
                                        </a>
                                        <a class="__instagram_class__ fab fa-instagram footer_instagram"
                                           href="{if $instagramHref}{$instagramHref}{/if}" target="_blank">
                                        </a>
                                        <a class="__whatsapp_class__ fab fa-whatsapp footer_whatsapp"
                                           href="{if $whatsappHref}{$whatsappHref}{/if}" target="_blank">
                                        </a>
                                        <a class="__linkdin_class__ fa-brands fa-linkedin-in footer_linkedin"
                                           href="{if $linkeDinHref}{$linkeDinHref}{/if}" target="_blank">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="item-footer col-lg-3 col-md-6 col-sm-12 col-12 order-foot2">
                                <div class="box-item-footer text-right">
                                    <h3>
                                        دسترسی آسان
                                    </h3>

                                    <ul>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">
                                                <i class="fa-sharp fa-solid fa-square">
                                                </i>
                                                تور داخلی
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">
                                                <i class="fa-sharp fa-solid fa-square">
                                                </i>
                                                تور خارجی
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/mag">
                                                <i class="fa-sharp fa-solid fa-square">
                                                </i>
                                                وبلاگ
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">
                                                <i class="fa-sharp fa-solid fa-square">
                                                </i>
                                                پیگیری خرید
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/news">
                                                <i class="fa-sharp fa-solid fa-square">
                                                </i>
                                                اخبار
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/contactUs">
                                                <i class="fa-sharp fa-solid fa-square">
                                                </i>
                                                تماس با ما
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">
                                                <i class="fa-sharp fa-solid fa-square">
                                                </i>
                                                درباره ما
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/pay">
                                                <i class="fa-sharp fa-solid fa-square">
                                                </i>
                                                درگاه پرداخت آنلاین
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/rules">
                                                <i class="fa-sharp fa-solid fa-square">
                                                </i>
                                                قوانین و مقررات
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="item-footer col-lg-3 col-md-6 col-sm-12 col-12 order-foot3">
                                <div class="__tour__special__ box-item-footer">
                                    <h3>
                                        تورهای محبوب
                                    </h3>
                                    {assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
                                    {assign var="special_tour_params" value=['type'=>'special','limit'=> '5','dateNow' => $dateNow]}
                                    {assign var='special_tours' value=$obj_main_page->getToursReservation($special_tour_params)}
                                 {*     {$special_tours|var_dump}*}
                                   {if $special_tours|count > 0}
                                    <div class="parent-tour-footer">
                                        {foreach $special_tours as $tour}
                                        <a class="__i_modular_nc_item_class_0" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$tour['id']}/{$tour['tour_name_en']}">
                                            <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$tour['tour_pic']}" alt="{$tour['tour_name']}">
                                            <div class="caption-tour">
                                                <h4>{$tour['tour_name']}</h4>
                                                {assign var="year" value=substr($tour['start_date'], 0, 4)}
                                                {assign var="month" value=substr($tour['start_date'], 4, 2)}
                                                {assign var="day" value=substr($tour['start_date'], 6)}
                                                <span>{$year}/{$month}/{$day}</span>
                                            </div>
                                        </a>
                                        {/foreach}
                                    </div>
                                    {/if}
                                </div>
                            </div>
                            <div class="item-footer col-lg-3 col-md-6 col-sm-12 col-12 order-foot4">
                                <div class="box-item-footer parent-contact-information">
                                    <h3>
                                        اطلاعات تماس
                                    </h3>
                                    <div class="child-item-footer2 align-items-start">
                                        <i class="fa-light fa-location-dot">
                                        </i>
                                        آدرس:
                                        <span class="__address_class__ text-right">
                                         {$smarty.const.CLIENT_ADDRESS}
                                         </span>
                                    </div>
                                    <!--                            <div class="child-item-footer">-->
                                    <!--                                <i class="fa-light fa-phone"></i>-->
                                    <!--                                تلفن:-->
                                    <!--                                <a href="javascript:" class="">-->
                                    <!--                                    021-88535144-->
                                    <!--                                </a>-->
                                    <!--                            </div>-->
                                    <div class="child-item-footer">
                                        <i class="fa-light fa-mobile">
                                        </i>
                                        موبایل:
                                        <a class="__mobile_class__" href="tel:{$smarty.const.CLIENT_MOBILE}">
                                            {$smarty.const.CLIENT_MOBILE}
                                        </a>
                                    </div>
                                    <div class="child-item-footer">
                                        <i class="fa-light fa-envelope">
                                        </i>
                                        ایمیل:
                                        <a class="__email_class__" href="mailto:{$smarty.const.CLIENT_EMAIL}">
                                            {$smarty.const.CLIENT_EMAIL}
                                        </a>
                                    </div>
                                    <div class="namads">
                                        <a href="https://www.cao.ir/paxrights">
                                            <img alt="Enamad1" src="project_files/images/certificate1.png" />
                                        </a>
                                        <a href="https://www.cao.ir/">
                                            <img alt="namad-1" src="project_files/images/certificate2.png" />
                                        </a>
                                        <a href="http://aira.ir/images/final3.pdf">
                                            <img alt="namad-2" src="project_files/images/certificate3.png" />
                                        </a>
                                        <a href="javascript:">
                                            <img alt="namad-2" src="project_files/images/enamad.png" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="parent-last_text col-12">
                <div class="container last_text">
                    <a class="last_a" href="https://www.iran-tech.com/">
                        طراحی سایت گردشگری
                    </a>
                    <p class="last_p_text">
                        : ایران تکنولوژی
                    </p>
                </div>
            </div>
            <a class="fixicone" href="javascript:" id="scroll-top" style="">
                بالا
            </a>
        </footer>
    {/if}
{else}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`pwaFooter.tpl"}
{/if}