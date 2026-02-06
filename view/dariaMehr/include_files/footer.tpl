{load_presentation_object filename="aboutUs" assign="objAbout"}
{assign var="about"  value=$objAbout->getData()}
{if $smarty.session.layout neq 'pwa'}
    {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}
        <footer class="i_modular_footer">
            <div class="body-footer">
                <div class="container">
                    <div class="row">
                        <div class="parent-footer-iran d-flex flex-wrap w-100">
                            <div class="item-footer col-lg-3 col-md-3 col-sm-4 col-12 order-foot1 text-center">
                                <div class="box-item-footer text-right">
                                    <h3>
                                        دوباره گردی
                                    </h3>
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
                                        شماره تماس شرکت :
                                        <a class="__phone_class__" href="tel:02122324402">
                                            02122324402
                                        </a>
                                    </div>
                                    <div class="child-item-footer">
                                        <i class="fa-light fa-phone">
                                        </i>
                                        شماره تماس شرکت :
                                        <a class="__phone_class__" href="tel:02122324403">
                                            02122324403
                                        </a>
                                    </div>
                                    <div class="child-item-footer">
                                        <i class="fa-light fa-mobile">
                                        </i>
                                        پشتیبانی 24 ساعته:
                                        <a class="__mobile_class__" href="tel:09197828243">
                                            09197828243
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
                                </div>
                            </div>
                            <div class="item-footer col-lg-2 col-md-3 col-sm-4 col-12 display-footer-none">
                                <div class="box-item-footer text-right">
                                    <h3>
                                        دسترسی آسان
                                    </h3>
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
                                            <a href="{$smarty.const.ROOT_ADDRESS}/mag">
                                                مجله دوباره گردی
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/club">
                                                باشگاه مشتریان
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="item-footer col-lg-2 col-md-3 col-sm-4 col-12 order-foot2">
                                <div class="box-item-footer text-right">
                                    <h3>
                                        خدمات مشتریان
                                    </h3>
                                    <ul>
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
                                            <a href="{$smarty.const.ROOT_ADDRESS}/faq">
                                                سوالات متداول
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="item-footer col-lg-2 col-md-3 col-sm-4 col-12">
                                <div class="box-item-footer text-right">
                                    <h3>
                                        اطلاعات تکمیلی
                                    </h3>
                                    <ul>
                                        <li>
                                            <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/page/Licenses">
                                                مجوزها
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="item-footer col-lg-3 col-md-3 col-sm-4 col-12 order-foot1 text-center">
                                <div class="parent-item-footer parent-item-footer-responsive">
                                    <div class="img-box-footer">
                                        <img alt="footer-logo" class="__logo_class__"
                                             src="project_files/images/logo.png" />
                                    </div>
{*                                    <div class="child-item-footer">*}
{*                                        <a class="__phone_class__" href="tel:{$smarty.const.CLIENT_PHONE}">*}
{*                                            {$smarty.const.CLIENT_PHONE}*}
{*                                        </a>*}
{*                                    </div>*}
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
                                        <a class="__whatsapp_class__ fa-brands fa-youtube footer_whatsapp"
                                           href="{if $whatsappHref}{$whatsappHref}{/if}" target="_blank">
                                        </a>
                                        <a class="__aparat_class__ footer_linkedin"
                                           href="{if $aparatHref}{$aparatHref}{/if}" target="_blank">
                                            <img alt="aparat" class="icon-img" src="project_files/images/aparat.png" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-namad">
                    <div class="container">
                        <div class="parent-about-namad-footer">
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
                                <a referrerpolicy='origin' target='_blank' href='https://trustseal.enamad.ir/?id=612667&Code=o1ReQP6nXv36gRgekQJ6bkFWgHDw5tgD'><img referrerpolicy='origin' src='https://trustseal.enamad.ir/logo.aspx?id=612667&Code=o1ReQP6nXv36gRgekQJ6bkFWgHDw5tgD' alt='' style='cursor:pointer' code='o1ReQP6nXv36gRgekQJ6bkFWgHDw5tgD'></a>
                            </div>
                            <div class="about-namad">
                                <h4>
                                    درباره دوباره گردی
                                </h4>
                                <p class="__aboutUs_class__">
                                    {$htmlContent = $about['body']|strip_tags}{$htmlContent|truncate:300}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-mobile">
                <a class="back-to-top footer__section" href="javascript:">
                    <i class="fa fa-angle-up">
                    </i>
                    <span>
    بازگشت به بالا
   </span>
                </a>
                <div aria-multiselectable="true" id="accordion-faq" role="tablist">
                    <div class="panel panel-default card">
                        <div class="panel-heading card-header" id="heading-faq-1" role="tab">
                            <h4 class="panel-title mb-0 parent-accordion">
                                <a aria-controls="Collapse-faq-1" aria-expanded="false" class="btn-link w-100 collapsed"
                                   data-parent="#accordion-faq" data-toggle="collapse" href="#Collapse-faq-1">
                                    دوباره گردی
                                    <i class="fa icone-arrow">
                                    </i>
                                </a>
                            </h4>
                        </div>
                        <div aria-labelledby="heading-faq-1" class="panel-collapse collapse" id="Collapse-faq-1"
                             role="tabpanel" style="">
                            <ul class="ul-footer-mobile">
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
                                    <a href="{$smarty.const.ROOT_ADDRESS}/mag">
                                        مجله دوباره گردی
                                    </a>
                                </li>
                                <li>
                                    <a href="{$smarty.const.ROOT_ADDRESS}/club">
                                        باشگاه مشتریان
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="panel panel-default card">
                        <div class="panel-heading card-header" id="heading-faq-2" role="tab">
                            <h4 class="panel-title mb-0 parent-accordion">
                                <a aria-controls="Collapse-faq-2" aria-expanded="false" class="btn-link w-100 collapsed"
                                   data-parent="#accordion-faq" data-toggle="collapse" href="#Collapse-faq-2">
                                    خدمات مشتریان
                                    <i class="fa icone-arrow">
                                    </i>
                                </a>
                            </h4>
                        </div>
                        <div aria-labelledby="heading-faq-2" class="panel-collapse collapse" id="Collapse-faq-2"
                             role="tabpanel" style="">
                            <ul class="ul-footer-mobile">
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
                                    <a href="{$smarty.const.ROOT_ADDRESS}/faq">
                                        سوالات متداول
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel panel-default card">
                        <div class="panel-heading card-header" id="heading-faq-3" role="tab">
                            <h4 class="panel-title mb-0 parent-accordion">
                                <a aria-controls="Collapse-faq-3" aria-expanded="false" class="collapsed btn-link w-100"
                                   data-parent="#accordion-faq" data-toggle="collapse" href="#Collapse-faq-3">
                                    اطلاعات تکمیلی
                                    <i class="fa icone-arrow">
                                    </i>
                                </a>
                            </h4>
                        </div>
                        <div aria-labelledby="heading-faq-3" class="panel-collapse collapse" id="Collapse-faq-3"
                             role="tabpanel">
                            <ul class="ul-footer-mobile">
                                <li>
                                    <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/page/Licenses">
                                        مجوزها
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="footer-mobile-namad">
                    <div class="namads-mobile">
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
                <div class="parent-item-footer parent-item-footer-responsive">
                    <div class="img-box-footer">
                        <img alt="footer-logo" src="project_files/images/logo.png" />
                    </div>
                    <div class="child-item-footer align-items-start">
                        <i class="fa-light fa-location-dot">
                        </i>
                        آدرس:
                        <span class="__address_class__">
                                          تهران، خیابان کارگر شمالی، کوچه چهارم، پلاک ۸ ،ساختمان پلاتین، طبقه سوم، واحدجنوبی سمت راست
                                       </span>
                    </div>
                    <div class="child-item-footer">
                        <i class="fa-light fa-phone">
                        </i>
                        شماره تماس شرکت :
                        <a class="__phone_class__" href="tel:02122324402">
                            02122324402
                        </a>
                    </div>
                    <div class="child-item-footer">
                        <i class="fa-light fa-phone">
                        </i>
                        شماره تماس شرکت :
                        <a class="__phone_class__" href="tel:02122324403">
                            02122324403
                        </a>
                    </div>
                    <div class="child-item-footer">
                        <i class="fa-light fa-mobile">
                        </i>
                        پشتیبانی 24 ساعته:
                        <a class="__mobile_class__" href="tel:09197828243">
                            09197828243
                        </a>
                    </div>
                    <div class="child-item-footer">
                        <i class="fa-light fa-envelope">
                        </i>
                        ایمیل:
                        <a class="__email_class__" href="mailto:hijimbo@iran-tech.com">
                            hijimbo@iran-tech.com
                        </a>
                    </div>
{*                    <div class="child-item-footer">*}
{*    <span class="text-mobile-phone">*}
{*     تلفن:*}
{*    </span>*}
{*                        <a class="" href="javascript:">*}
{*                            <i class="fa-regular fa-phone icon-mobile-phone">*}
{*                            </i>*}
{*                            02188866609*}
{*                        </a>*}
{*                    </div>*}
                    <div class="__social_class__ footer-icon my-footer-icon">
                        <a class="fab fa-telegram footer_telegram" href="javascript:" target="_blank">
                        </a>
                        <a class="fab fa-instagram footer_instagram" href="javascript:" target="_blank">
                        </a>
                        <a class="fa-brands fa-youtube footer_whatsapp" href="javascript:" target="_blank">
                        </a>
                        <a class="footer_linkedin" href="javascript:" target="_blank">
                            <img alt="aparat" class="icon-img" src="project_files/images/aparat.png" />
                        </a>
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
            <a class="fixicone fa fa-angle-up" href="javascript:" id="scroll-top">
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