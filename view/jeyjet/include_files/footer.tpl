{load_presentation_object filename="aboutUs" assign="objAbout"}
{assign var="about"  value=$objAbout->getData()}
{if $smarty.session.layout neq 'pwa'}
    {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}


        <footer class='i_modular_footer'>
        <div class=" footer-des">
            <div class="container">
                <div class="row">
                    <div class="parent-footer-iran d-flex flex-wrap w-100">
                        <div class="item-footer col-lg-6 col-md-6 col-sm-12 col-12 order-foot1">
                            <div class="parent-item-footer parent-item-footer-responsive box-item-footer2">
                                <img alt="logo-img" class="__logo_class__" src="project_files/images/logo.png" />
                                <div class="child-item-footer align-items-start">
                                    آدرس:
                                    <span class="__address_class__ text-right">
                                {$smarty.const.CLIENT_ADDRESS}
                               </span>
                                </div>
                                <div class="child-item-footer">
                                    تلفن:
                                    <a class="__phone_class__" href="tel:{$smarty.const.CLIENT_PHONE}">
                                        {$smarty.const.CLIENT_PHONE}
                                    </a>
                                </div>
                                <div class="child-item-footer">
                                    موبایل:
                                    <a class="__mobile_class__" href="tel:{$smarty.const.CLIENT_MOBILE}">
                                        {$smarty.const.CLIENT_MOBILE}
                                    </a>
                                </div>
                                <div class="child-item-footer">
                                    ایمیل:
                                    <a class="__email_class__" href="mailto:{$smarty.const.CLIENT_EMAIL}">
                                        {$smarty.const.CLIENT_EMAIL}
                                    </a>
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
                                    <a href="javascript:">
                                        <img alt="namad-2" src="project_files/images/enamad.png" />
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="item-footer col-lg-3 col-md-3 col-sm-12 col-12 display-footer-none">
                            <div class="box-item-footer text-right">
                                <h3>
                                    دسترسی آسان
                                </h3>
                                <ul>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">
                                            تور
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/page/visa">
                                            ویزا
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/page/hotel">
                                            هتل
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/page/InternalFlight">
                                            پرواز داخلی
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/page/ExternalFlight">
                                            پرواز خارجی
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/page/insurance">
                                            بیمه
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="item-footer col-lg-3 col-md-3 col-sm-12 col-12 order-foot2">
                            <div class="parent-namad box-item-footer text-right">
                                <h3>
                                    ساتین پرواز
                                </h3>
                                <ul>
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
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">
                                            درباره ما
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">
                                            پیگیری خرید
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/rules">
                                            قوانین و مقررات
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/contactUs">
                                            تماس با ما
                                        </a>
                                    </li>
                                </ul>
                            </div>
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
            </div>
        </div>



                <div class=" footer-mobile">
                    <div class="container">
                        <a class="back-to-top footer__section" href="javascript:" id="scroll-top-footer">
   <span>
    بازگشت به بالا
   </span>
                            <i class="fa fa-angle-up">
                            </i>
                        </a>
                        <div class="parent-item-footer parent-item-footer-responsive">
                            <div class="img-box-footer">
                                <img alt="footer-logo" class="__logo_class__" src="project_files/images/logo.png"/>
                            </div>
                        </div>
                        <div aria-multiselectable="true" id="accordion-faq" role="tablist">
                            <div class="panel panel-default card">
                                <div class="panel-heading card-header" id="heading-faq-1" role="tab">
                                    <h4 class="panel-title mb-0 parent-accordion">
                                        <a aria-controls="Collapse-faq-1" aria-expanded="false" class="btn-link w-100 collapsed" data-parent="#accordion-faq" data-toggle="collapse" href="#Collapse-faq-1">
                                            اطلاعات تماس
                                            <i class="fa icone-arrow">
                                            </i>
                                        </a>
                                    </h4>
                                </div>
                                <div aria-labelledby="heading-faq-1" class="panel-collapse collapse" id="Collapse-faq-1" role="tabpanel" style="">
                                    <div class="parent-item-footer parent-item-footer-responsive box-item-footer2">
                                        <div class="child-item-footer align-items-start">
                                            آدرس:
                                            <span class="__address_class__ text-right">
        {$smarty.const.CLIENT_ADDRESS}
       </span>
                                        </div>
                                        <div class="child-item-footer">
                                            تلفن:
                                            <a class="__phone_class__" href="tel:{$smarty.const.CLIENT_PHONE}">
                                                {$smarty.const.CLIENT_PHONE}
                                            </a>
                                        </div>
                                        <div class="child-item-footer">
                                            موبایل:
                                            <a class="__mobile_class__" href="tel:{$smarty.const.CLIENT_MOBILE}">
                                                {$smarty.const.CLIENT_MOBILE}
                                            </a>
                                        </div>
                                        <div class="child-item-footer">
                                            ایمیل:
                                            <a class="__email_class__" href="mailto:{$smarty.const.CLIENT_EMAIL}">
                                                {$smarty.const.CLIENT_EMAIL}
                                            </a>
                                        </div>
                                        <div class="namads">
                                            <a href="https://farasa.cao.ir/sysworkflow/fa/modern/3810212626028ab03488017019616799/6464336316028ab04e3c618028352200.php">
                                                <img alt="Enamad1" src="project_files/images/certificate1.png"/>
                                            </a>
                                            <a href="https://caa.gov.ir/">
                                                <img alt="namad-1" src="project_files/images/certificate2.png"/>
                                            </a>
                                            <a href="http://www.aira.ir/">
                                                <img alt="namad-2" src="project_files/images/certificate3.png"/>
                                            </a>
                                            <a href="javascript:">
                                                <img alt="namad-2" src="project_files/images/enamad.png"/>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default card">
                                <div class="panel-heading card-header" id="heading-faq-2" role="tab">
                                    <h4 class="panel-title mb-0 parent-accordion">
                                        <a aria-controls="Collapse-faq-2" aria-expanded="false" class="btn-link w-100 collapsed" data-parent="#accordion-faq" data-toggle="collapse" href="#Collapse-faq-2">
                                            دسترسی آسان
                                            <i class="fa icone-arrow">
                                            </i>
                                        </a>
                                    </h4>
                                </div>
                                <div aria-labelledby="heading-faq-2" class="panel-collapse collapse" id="Collapse-faq-2" role="tabpanel" style="">
                                    <ul class="ul-footer-mobile">
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">
                                                تور
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/page/visa">
                                                ویزا
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/page/hotel">
                                                هتل
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/page/InternalFlight">
                                                پرواز داخلی
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/page/ExternalFlight">
                                                پرواز خارجی
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/page/insurance">
                                                بیمه
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel panel-default card">
                                <div class="panel-heading card-header" id="heading-faq-3" role="tab">
                                    <h4 class="panel-title mb-0 parent-accordion">
                                        <a aria-controls="Collapse-faq-3" aria-expanded="false" class="collapsed btn-link w-100" data-parent="#accordion-faq" data-toggle="collapse" href="#Collapse-faq-3">
                                            ساتین پرواز
                                            <i class="fa icone-arrow">
                                            </i>
                                        </a>
                                    </h4>
                                </div>
                                <div aria-labelledby="heading-faq-3" class="panel-collapse collapse" id="Collapse-faq-3" role="tabpanel">
                                    <ul class="ul-footer-mobile">
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
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">
                                                درباره ما
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">
                                                پیگیری خرید
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/rules">
                                                قوانین و مقررات
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/contactUs">
                                                تماس با ما
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        {assign var="socialLinks"  value=$about['social_links']|json_decode:true}
                        {assign var="socialLinksArray" value=['telegram'=>'telegramHref','whatsapp'=> 'whatsappHref','instagram' => 'instagramHref','aparat' => 'aparatHref','youTube' => 'youtubeHref','facebook' => 'facebookHref','linkedin' => 'linkeDinHref' , 'twitter' => 'twitterHref']}

                        {foreach $socialLinks as $key => $val}
                            {assign var=$socialLinksArray[$val['social_media']] value=$val['link']}
                        {/foreach}
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




        <div class="last_text col-12">
            <div class="container">
                <div class="parent-iran-tech">
                    <div class="parent-text-iran-tech">
{*                        <a class="last_a" href="https://www.iran-tech.com/">طراحی سایت گردشگری </a>*}
{*                        <p class="last_p_text">: ایران تکنولوژی</p>*}
                    </div>


                    <div class="footer-icon my-footer-icon">
                        <a class="fab fa-telegram footer_telegram" href="{if $telegramHref}{$telegramHref}{/if}" target="_blank"></a>
                        <a class="fab fa-instagram footer_instagram" href="{if $instagramHref}{$instagramHref}{/if}" target="_blank"></a>
                        <a class="fab fa-whatsapp footer_whatsapp" href="{if $whatsappHref}{$whatsappHref}{/if}" target="_blank"></a>
                        <a class="fa-brands fa-linkedin-in footer_linkedin" href="{if $linkeDinHref}{$linkeDinHref}{/if}" target="_blank"></a>
                    </div>
                </div>
            </div>
        </div>
        <a class="fixicone fa fa-angle-up" href="javascript:" id="scroll-top" style=""></a>
        </footer>
    {/if}
{else}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`pwaFooter.tpl"}
{/if}