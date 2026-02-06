{if $smarty.session.layout neq 'pwa'}
    {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}
        <footer class="site-border-top-main-color">

            <div class="container">

                <div class="row">


                    <div class="col-lg-4 col-md-12">
                        <div class="footer-about">
                            <p>
                                {$smarty.const.ABOUT_ME}
                            </p>
                        </div>

                    </div>
                    <div class="col-lg-4">
                        <div class="address_footer">
                            <ul>
                                <li class="address_f">
                             <span>آدرس :  <a class="" href="{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}">{$smarty.const.CLIENT_ADDRESS}</a>
                      </span>
                                </li>
                                <li class="phone_f">
                            <span>شماره تماس  :
                            <a class="" href="tel:{$smarty.const.CLIENT_PHONE}">
                                {$smarty.const.CLIENT_PHONE}
                            </a>
                                </span>
                                </li>
                                <li class="mail_f">
                            <span>E-mail :
                            <a href="mailto:{$smarty.const.CLIENT_EMAIL}">{$smarty.const.CLIENT_EMAIL}</a>
                                </span>
                                </li>
                            </ul>


                        </div>

                    </div>
                    <div class="col-lg-4 col-md-9 ">
                        <div class="footer-imgs">
                            <div class="footer-img-item"><a href="#"><img src="project_files/images/certificate1.png" alt=""></a></div>
                            <div class="footer-img-item"><a href="#"><img src="project_files/images/certificate2.png" alt=""></a></div>
                            <div class="footer-img-item"><a href="#"><img src="project_files/images/certificate3.png" alt=""></a></div>
                            <div class="footer-img-item"><a href="#"><img src="project_files/images/enamad.png" alt=""></a></div>
                            <div class="footer-img-item"><a href="#"><img src="project_files/images/samandeh.jpg" alt=""></a></div>
                        </div>
                    </div>


                </div>
            </div>

            <div class="footer-bottom">
                <div class="container">
                    <div class="row">

                        <div class="iran-tech">

                            <a href="https://www.iran-tech.com/intro" target="_blank">##OsafarTravelAgencyDesign##</a>
                            : Iran Technology
                        </div>


                        <div class="footer-social">
                            {assign var="socialLinks"  value=$about['social_links']|json_decode:true}
                            {assign var="socialLinksArray" value=['telegram'=>'telegramHref','facebook'=> 'facebookHref','instagram' => 'instagramHref', 'linkdin' => 'linkdinHref']}

                            {foreach $socialLinks as $key => $val}
                                {assign var=$socialLinksArray[$val['social_media']] value=$val['link']}
                            {/foreach}
                            <a href="{if $instagramHref}{$instagramHref}{else}javascript:;{/if}" target="_blank" class="instagram-ico" onclick="return false"></a>
                            <a href="{if $facebookHref}{$facebookHref}{else}javascript:;{/if}" target="_blank" class="facebook-ico" onclick="return false"></a>
                            <a href="{if $telegramHref}{$telegramHref}{else}javascript:;{/if}" target="_blank" class="telegram-ico" onclick="return false"></a>
                            <a href="{if $linkdinHref}{$linkdinHref}{else}javascript:;{/if}" target="_blank" class="linkedin-ico" onclick="return false"></a>
                        </div>

                    </div>
                </div>
            </div>

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
