{load_presentation_object filename="aboutUs" assign="objAbout"}
{assign var="about"  value=$objAbout->getData()}
{if $smarty.session.layout neq 'pwa'}
    {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}


        <footer class="i_modular_footer">
            <div class="body-footer">
                <div class="container">
                    <div class="row">
                        <div class="parent-footer-iran d-flex flex-wrap w-100">
                            <div class="item-footer col-lg-2 col-md-6 col-sm-12 col-12 order-foot2">
                                <div class="parent-namad box-item-footer text-right">
                                    <h3>
                                        مجوزها
                                    </h3>
                                    <div class="namads">
                                        <a href="https://www.cao.ir/paxrights">
                                            <img alt="Enamad1" src="project_files/images/certificate1.png" />
                                        </a>
                                        <a href="https://www.cao.ir/">
                                            <img alt="namad-1" src="project_files/images/certificate2.png" />
                                        </a>
                                        <a referrerpolicy='origin' target='_blank' href='https://trustseal.enamad.ir/?id=640942&Code=sTakLDNOeRUpM5y0VrDUonOWXMk5LDs0'><img referrerpolicy='origin' src='https://trustseal.enamad.ir/logo.aspx?id=640942&Code=sTakLDNOeRUpM5y0VrDUonOWXMk5LDs0' alt='' style='cursor:pointer' code='sTakLDNOeRUpM5y0VrDUonOWXMk5LDs0'></a>
                                        <a href="javascript:">
                                            <img referrerpolicy="origin" id = 'jxlzrgvjrgvjesgtoeukesgt' style = 'cursor:pointer' onclick = 'window.open("https://logo.samandehi.ir/Verify.aspx?id=133080&p=rfthxlaoxlaoobpdmcsiobpd", "Popup","toolbar=no, scrollbars=no, location=no, statusbar=no, menubar=no, resizable=0, width=450, height=630, top=30")' alt = 'logo-samandehi' src = 'https://logo.samandehi.ir/logo.aspx?id=133080&p=nbpdqftiqftilymaaqgwlyma' />
                                        </a>
                                        <a href="http://aira.ir/images/final3.pdf">
                                            <img alt="namad-2" src="project_files/images/certificate3.png" />
                                        </a>
                                    </div>
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
                            </div>
                            <div class="item-footer col-lg-2 col-md-6 col-sm-12 col-12 display-footer-none">
                                <div class="box-item-footer text-right">
                                    <h3>
                                        دسترسی آسان
                                    </h3>
                                    <ul>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/page/flight">
                                                <i class="fal fa-angle-left">
                                                </i>
                                                پرواز
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/page/hotel">
                                                <i class="fal fa-angle-left">
                                                </i>
                                                هتل
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">
                                                <i class="fal fa-angle-left">
                                                </i>
                                                تور
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/page/bus">
                                                <i class="fal fa-angle-left">
                                                </i>
                                                اتوبوس
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/page/visa">
                                                <i class="fal fa-angle-left">
                                                </i>
                                                ویزا
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/news">
                                                <i class="fal fa-angle-left">
                                                </i>
                                                اخبار
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/contactUs">
                                                <i class="fal fa-angle-left">
                                                </i>
                                                تماس با ما
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="item-footer col-lg-4 col-md-6 col-sm-12 col-12 order-foot1">
                                <div class="parent-item-footer parent-item-footer-responsive">
                                    <div class="img-box-footer">
                                        <img alt="footer-logo" src="project_files/images/logo.png" />
                                        <div class="text-logo-footer">
                                            <h4>
          <span>
           آژانس خدماتی مسافرتی
          </span>
                                                <span>
           پارس پرواز جنوب
          </span>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="child-item-footer align-items-start">
                                        <i class="fa-light fa-location-dot">
                                        </i>
                                        آدرس:
                                        <span class="__address_class__">
         {$smarty.const.CLIENT_ADDRESS}
        </span>
                                    </div>
                                    <div class="child-item-footer">
                                        <i class="fa-light fa-phone">
                                        </i>
                                        تلفن:
                                        <a class="__phone_class__" href="tel:{$smarty.const.CLIENT_PHONE}">
                                            {$smarty.const.CLIENT_PHONE}
                                        </a>
                                    </div>
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
                            <div class="item-footer col-lg-4 col-md-6 col-sm-12 col-12 footer-display pl-4">
                                <div class="box-item-footer text-right">
                                    <h3>
                                        درباره ما
                                    </h3>
                                    <p class="__aboutUs_class__">
                                        {$htmlContent = $about['body']|strip_tags}{$htmlContent|truncate:300}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="last_text col-12">
                <a class="last_a" href="https://www.iran-tech.com/">
                    طراحی سایت گردشگری
                </a>
                <p class="last_p_text">
                    : ایران تکنولوژی
                </p>
            </div>
            <a class="fixicone fa fa-angle-up" href="javascript:" id="scroll-top" style="">
            </a>
        </footer>
    {/if}
    <div class="modal fade bd-example-modal-lg modal-calender-js" id="calenderBox"
         tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal_center_flight">
            <div class="modal-content modal-content-js">

            </div>
        </div>
    </div>
{else}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`pwaFooter.tpl"}
{/if}