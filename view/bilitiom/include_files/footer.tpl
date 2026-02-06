{load_presentation_object filename="aboutUs" assign="objAbout"}
{assign var="about"  value=$objAbout->getData()}
{if $smarty.session.layout neq 'pwa'}
    {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}
        <footer class="i_modular_footer">
            <div class="footer-content">
                <div class="parent-support-week-footer">
                    <div class="container box-support-week">
                        <h4>
                            پشتیبانی 24 ساعته واتس اپ
                        </h4>
                        <div class="parent-phone-support-week">
                            <a class="__whatsapp_class__" href="tel:09912259763">
                                09912259763
                            </a>
                            <i class="fa-solid fa-phone">
                            </i>
                        </div>
                    </div>
                </div>
                <div class="parent-category-footer">
                    <div class="container">
                        <div class="box-category-footer-grid">
                            <div class="box-item-category-footer">
                                <h4>
                                    خدمات مسافرتی
                                </h4>
                                <ul>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/page/hotel">
                                            رزرو هتل
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/page/internal-flight">
                                            خرید بلیط پرواز داخلی
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/page/international">
                                            خرید بلیط پرواز خارجی
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/page/internal_tour">
                                            تور داخلی
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/page/tourInternal">
                                            تور خارجی
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="box-item-category-footer">
                                <h4>
                                    امکانات
                                </h4>
                                <ul>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/page/insurance">
                                            بیمه مسافرتی
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/pay">
                                            درگاه پرداخت آنلاین
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/club">
                                            باشگاه مشتریان
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="box-item-category-footer">
                                <h4>
                                    اطلاعات بیشتر
                                </h4>
                                <ul>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">
                                            درباره ما
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/contactUs">
                                            تماس با ما
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/rules">
                                            قوانین و مقررات
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/mag">
                                            وبلاگ
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/news">
                                            اخبار
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="parent-address-social-footer">
                    <div class="container">
                        <div class="address-social-footer-grid">
                            <div class="box-address-footer">
                                <h4>
                                    ارتباط با ما
                                </h4>
                                <ul>
                                    <li>
                                        <h6>
                                            آدرس:
                                        </h6>
                                        <span class="__address_class__">
                                         {$smarty.const.CLIENT_ADDRESS}
                                        </span>
                                    </li>
                                    <li>
                                        <h6>
                                            تلفن:
                                        </h6>
                                        <a class="__mobile_class__" href="tel: {$smarty.const.CLIENT_PHONE}">
                                            {$smarty.const.CLIENT_PHONE}
                                        </a>
                                    </li>
                                    <li>
                                        <h6>
                                            ایمیل:
                                        </h6>
                                        <a class="__email_class__" href="mailto:{$smarty.const.CLIENT_EMAIL}">
                                            {$smarty.const.CLIENT_EMAIL}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="box-social-footer">
                                <div class="title-social-footer">
                                    <h3>
                                        شبکه های اجتماعی
                                    </h3>
                                    <p>
                                        با ما در ارتباط باشید
                                    </p>
                                </div>
                                {assign var="socialLinks"  value=$about['social_links']|json_decode:true}
                                {assign var="socialLinksArray" value=['telegram'=>'telegramHref','whatsapp'=> 'whatsappHref','instagram' => 'instagramHref','aparat' => 'aparatHref','youTube' => 'youtubeHref','facebook' => 'facebookHref','linkedin' => 'linkeDinHref' , 'twitter' => 'twitterHref']}

                                {foreach $socialLinks as $key => $val}
                                    {assign var=$socialLinksArray[$val['social_media']] value=$val['link']}
                                {/foreach}
                                <div class="__social_class__ footer-icon my-footer-icon2">
                                    <a class="__telegram_class__ fab fa-telegram footer_telegram"
                                       href="{if $telegramHref}{$telegramHref}{/if}" target="_blank">
                                    </a>
                                    <a class="__instagram_class__ fa-brands fa-instagram"
                                       href="{if $instagramHref}{$instagramHref}{/if}" target="_blank">
                                    </a>
                                    <a class="__whatsapp_class__ fa-brands fa-whatsapp"
                                       href="{if $whatsappHref}{$whatsappHref}{/if}" target="_blank">
                                    </a>
                                    <a class="__twitter_class__ fa-brands fa-twitter"
                                       href="{if $twitterHref}{$twitterHref}{/if}" target="_blank">
                                    </a>
                                    <a class="__linkedin_class__ fa-brands fa-linkedin"
                                       href="{if $linkeDinHref}{$linkeDinHref}{/if}" target="_blank">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="parent-about-us">
                    <div class="container">
                        <div class="about-us-grid">
                            <div class="i_modular_about_us parent-text-about-us">
                                <h2>
                                    درباره ی بیلیتیوم
                                </h2>
                                <p class="__aboutUs_class__">
                                    {$htmlContent = $about['body']|strip_tags}{$htmlContent|truncate:300}
                                </p>
                            </div>
                            <div class="namads">
                                <a href="https://farasa.cao.ir/sysworkflow/fa/modern/3810212626028ab03488017019616799/6464336316028ab04e3c618028352200.php">
                                    <img alt="Enamad1" src="project_files/images/certificate1.png" />
                                </a>
                                <a href="https://caa.gov.ir/">
                                    <img alt="namad-1" src="project_files/images/certificate2.png" />
                                </a>
                                <a href="http://www.aira.ir/">
                                    <img alt="namad-2" src="project_files/images/certificate3.png" />
                                </a>
                                <a referrerpolicy='origin' target='_blank' href='https://trustseal.enamad.ir/?id=583387&Code=URE3ozosKNkLYwA7hsKx93lhf1NX7DQV'><img referrerpolicy='origin' src='https://trustseal.enamad.ir/logo.aspx?id=583387&Code=URE3ozosKNkLYwA7hsKx93lhf1NX7DQV' alt='' style='cursor:pointer' code='URE3ozosKNkLYwA7hsKx93lhf1NX7DQV'></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="parent-iran-tech">
                <div class="container">
                    <div class="parent-text-iran-tech">
                        <a class="last_a" href="https://www.iran-tech.com/">
                            طراحی سایت گردشگری
                        </a>
                        <p class="last_p_text">
                            : ایران تکنولوژی
                        </p>
                    </div>
                </div>
            </div>
            <a class="fixicone fa fa-angle-up" href="javascript:" id="scroll-top" style="">
            </a>
        </footer>

        <div class="modal fade bd-example-modal-lg modal-calender-js" id="calenderBox"
             tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal_center_flight">
                <div class="modal-content modal-content-js">

                </div>
            </div>
        </div>
    {/if}
{else}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`pwaFooter.tpl"}
{/if}