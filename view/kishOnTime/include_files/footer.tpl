{load_presentation_object filename="aboutUs" assign="objAbout"}
{assign var="about"  value=$objAbout->getData()}
{if $smarty.session.layout neq 'pwa'}
    {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}
        <footer class="i_modular_footer">
            <div class="container">
                <div class="row">
                    <div class="row cantact">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 address">
                            <i class="fad fa-map-marker-alt">
                            </i>
                            <p class="__address_class__ SMFooterAddress">
                                {$smarty.const.CLIENT_ADDRESS}
                            </p>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 phoneNumber">
                            <i class="fas fa-phone-volume">
                            </i>
                            <a class="__phone_class__ SMFooterPhone" href="tel:{$smarty.const.CLIENT_PHONE}">
                                {$smarty.const.CLIENT_PHONE}
                            </a>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 mobile">
                            <i aria-hidden="true" class="fa fa-mobile">
                            </i>
                            <a class="__mobile_class__ SMFooterMobile" href="tel:{$smarty.const.CLIENT_MOBILE}">
                                {$smarty.const.CLIENT_MOBILE}
                            </a>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                            <a class="email" href="mailto:mozhdeh.hosseini4858@gmail.com">
                                <i class="fas fa-envelope-open-text">
                                </i>
                                <a class="__email_class__ SMFooterEmail" href="mailto:{$smarty.const.CLIENT_EMAIL}">
                                    {$smarty.const.CLIENT_EMAIL}
                                </a>
                            </a>
                        </div>
                    </div>
                    <div class="footer-network col-xs-12">
                        {assign var="socialLinks"  value=$about['social_links']|json_decode:true}
                        {assign var="socialLinksArray" value=['telegram'=>'telegramHref','whatsapp'=> 'whatsappHref','instagram' => 'instagramHref','aparat' => 'aparatHref','youTube' => 'youtubeHref','facebook' => 'facebookHref','linkedin' => 'linkeDinHref' , 'twitter' => 'twitterHref']}

                        {foreach $socialLinks as $key => $val}
                            {assign var=$socialLinksArray[$val['social_media']] value=$val['link']}
                        {/foreach}
                        <ul class="__social_class__ social-icons_top">
                            <li>
                                <a class="__facebook_class__ SMFaceBook facebook" href="{if $facebookHref}{$facebookHref}{/if}" target='_blank'>
                                    <i class="fab fa-facebook-f">
                                    </i>
                                </a>
                            </li>
                            <li>
                                <a class="SMTwitter twitter" href="{if $twitterHref}{$twitterHref}{/if}" target='_blank'>
                                    <i class="fab fa-twitter">
                                    </i>
                                </a>
                            </li>
                            <li>
                                <a class="__linkdin_class__ SMPintrest pinterest"
                                   href="{if $linkeDinHref}{$linkeDinHref}{/if}" target="_blank">
                                    <i class="fab fa-linkedin">
                                    </i>
                                </a>
                            </li>
                            <li>
                                <a class="__instagram_class__ SMInstageram instagram"
                                   href="{if $instagramHref}{$instagramHref}{/if}" target="_blank">
                                    <i class="fab fa-instagram">
                                    </i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!--            <div class="footer-icon col-xs-12 map-aita">-->
                    <div id="g-map"></div>
                </div>
            </div>
            <div class="row">
                <div class="copyright col-xs-12">
                    <a href="https://www.iran-tech.com/" target="_blank">
                        طراحی سایت آژانس گردشگری :
                    </a>
                    ایران تکنولوژی
                </div>
            </div>
            <a id="scroll-top" style="cursor: pointer; display: block;">
                <button>
                    <i aria-hidden="true" class="fa fa-chevron-up">
                    </i>
                </button>
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


