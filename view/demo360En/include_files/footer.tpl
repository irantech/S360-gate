{load_presentation_object filename="aboutUs" assign="objAbout"}
{assign var="about"  value=$objAbout->getData()}
{if $smarty.session.layout neq 'pwa'}
<footer class="i_modular_footer position-relative footer-gisoo">
    <div class="div-footer-parent">
        <div class="container">
            <div class="d-flex flex-wrap">
                <div class="col-lg-4 col-md-6 col-sm-12 col-12 p-3 ">
                    <div class="parent-item-footer parent-item-footer-responsive">
                        <div class="img-box-footer">
                            <img src="project_files/images/logo.png" alt="footer-logo">
                            <div class="text-logo-footer">
                                <span>Travel Agency</span>
                                <h4>Travel360</h4>
                            </div>
                        </div>
                        <div class="child-item-footer">
                            <i class="fa-light fa-location-dot"></i>
                            Address:
                            <span class="__address_class__">
                             {$smarty.const.CLIENT_ADDRESS_EN}
                            </span>
                        </div>
                        <div class="child-item-footer">
                            <i class="fa-light fa-phone"></i>
                            Phone:
                            <a href="tel:{$smarty.const.CLIENT_PHONE}" class="__phone_class__">
                                {$smarty.const.CLIENT_PHONE}
                            </a>
                        </div>
                        <div class="child-item-footer">
                            <i class="fa-light fa-mobile"></i>
                            Mobile:
                            <a href="tel:{$smarty.const.CLIENT_MOBILE}" class="__mobile_class__">
                                {$smarty.const.CLIENT_MOBILE}
                            </a>
                        </div>
                        <div class="child-item-footer">
                            <i class="fa-light fa-envelope"></i>
                            Email:
                            <a href="mailto:{$smarty.const.CLIENT_EMAIL}" class="__email_class__">
                                {$smarty.const.CLIENT_EMAIL}
                            </a>
                        </div>

                        {assign var="socialLinks"  value=$about['social_links']|json_decode:true}
                        {assign var="socialLinksArray" value=['telegram'=>'telegramHref','whatsapp'=> 'whatsappHref','instagram' => 'instagramHref','aparat' => 'aparatHref','youTube' => 'youtubeHref','facebook' => 'facebookHref','linkedin' => 'linkeDinHref' , 'twitter' => 'twitterHref']}

                        {foreach $socialLinks as $key => $val}
                            {assign var=$socialLinksArray[$val['social_media']] value=$val['link']}
                        {/foreach}
                        <div class="__social_class__ footer-icon">
                            <a target="_blank" href="{if $telegramHref}{$telegramHref}{/if}" class="__telegram_class__ fab fa-telegram footer_telegram"></a>
                            <a target="_blank" href="{if $instagramHref}{$instagramHref}{/if}" class="__instagram_class__ fab fa-instagram footer_instagram"></a>
                            <a target="_blank" href="{if $whatsappHref}{$whatsappHref}{/if}" class="__whatsapp_class__ fab fa-whatsapp footer_whatsapp"></a>
                            <a target="_blank" href="{if $linkeDinHref}{$linkeDinHref}{/if}" class="__linkdin_class__ fa-brands fa-linkedin-in footer_linkedin"></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-6 p-2 ">
                    <div class="box-item-footer text-right">
                        <h3>Services</h3>
                        <ul>
                            <li>
                                <a href="{$smarty.const.ROOT_ADDRESS}/page/InternalTour">
                                    <i class="fal fa-angle-left"></i>
                                    Local Tour
                                </a>
                            </li>
                            <li>
                                <a href="{$smarty.const.ROOT_ADDRESS}/page/ExternalTour">
                                    <i class="fal fa-angle-left"></i>
                                    International Tour
                                </a>
                            </li>
                            <li>
                                <a href="{$smarty.const.ROOT_ADDRESS}/page/visa">
                                    <i class="fal fa-angle-left"></i>
                                    Visa
                                </a>
                            </li>
                            <li>
                                <a href="{$smarty.const.ROOT_ADDRESS}/currency">
                                    <i class="fal fa-angle-left"></i>
                                    Currency
                                </a>
                            </li>
                            <li>
                                <a href="{$smarty.const.ROOT_ADDRESS}/pay">
                                    <i class="fal fa-angle-left"></i>
                                    E-Payment
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-6 p-2 ">
                    <div class="box-item-footer text-right">
                        <h3>Easy Access</h3>
                        <ul>
                            <li>
                                <a href="{$smarty.const.ROOT_ADDRESS}/rules">
                                    <i class="fal fa-angle-left"></i>
                                    Rules and Regulations
                                </a>
                            </li>
                            <li>
                                <a href="{$smarty.const.ROOT_ADDRESS}/mag">
                                    <i class="fal fa-angle-left"></i>
                                    Blog
                                </a>
                            </li>
                            <li>
                                <a href="{$smarty.const.ROOT_ADDRESS}/news">
                                    <i class="fal fa-angle-left"></i>
                                    News
                                </a>
                            </li>
                            <li>
                                <a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">
                                    <i class="fal fa-angle-left"></i>
                                    About Us
                                </a>
                            </li>
                            <li>
                                <a href="{$smarty.const.ROOT_ADDRESS}/contactUs">
                                    <i class="fal fa-angle-left"></i>
                                    Contact Us
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-12 col-12 p-2 ">
                    <div class="parent-namad">
                        <h3>Licenses</h3>
                        <div class="namads">
                            <a href="javascript:"><img src="project_files/images/certificate1.png" alt="Enamad1"></a>
                            <a href="javascript:"><img src="project_files/images/certificate2.png" alt="namad-1"></a>
                            <a href="javascript:"><img src="project_files/images/certificate3.png" alt="namad-2"></a>
                            <a  href="javascript:"><img src="project_files/images/enamad.png" alt="namad-2">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="last_text col-12">
        <a class="last_a" href="https://www.iran-tech.com/" target="_blank">Tourism Website Design</a>
        <p class="last_p_text">: Iran Technology</p>

    </div>
    <a href="javascript:" class="fixicone fa-solid fa-plane-up" id="scroll-top" style=""></a>
</footer>


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
