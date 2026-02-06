{load_presentation_object filename="aboutUs" assign="objAbout"}
{assign var="about"  value=$objAbout->getData()}

{if $smarty.session.layout neq 'pwa'}
    {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}
        <footer class="i_modular_footer {if $smarty.const.GDS_SWITCH neq 'mainPage' } footer-internalPage {/if}">
            <div class="body-footer">
                <svg fill="none" height="219" viewbox="0 0 496 219" width="496" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="248" cy="-31" r="175" stroke="url(#paint0_linear_2740_30133)" stroke-width="150">
                    </circle>
                    <defs>
                        <lineargradient gradientunits="userSpaceOnUse" id="paint0_linear_2740_30133" x1="248" x2="248"
                                        y1="-281" y2="219">
                            <stop stop-color="white" stop-opacity="0.3">
                            </stop>
                            <stop offset="1" stop-color="white" stop-opacity="0">
                            </stop>
                        </lineargradient>
                    </defs>
                </svg>
                <div class="circle-footer-parent">
   <span class="circle-footer">
   </span>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="parent-footer-iran d-flex flex-wrap">
                            <div class="item-footer col-lg-6 col-md-6 col-sm-12 col-12 display-footer-none1">
                                <div class="box-item-footer text-right">
                                    <h3>
                                        مسیر های پرتردد
                                    </h3>
                                    <ul>
                                     {assign 'cities' ['MHD' => functions::Xmlinformation('S360MHD'),'TBZ' => functions::Xmlinformation('S360TBZ'),'KSH' =>functions::Xmlinformation('S360KSH'), 'BND' =>  functions::Xmlinformation('S360BND')]}
                                     {foreach $cities as $item}
                                      <li>
                                       <a onclick="calenderFlightSearch('THR','{$item@key}')"
                                          data-target="#calenderBox" data-toggle="modal">
                                        <i class="">
                                        </i>
                                        {$item}
                                       </a>
                                      </li>
                                     {/foreach}

                                     {assign 'cities' ['ISTALL' => functions::Xmlinformation('S360ISTALL'),'DXB' => functions::Xmlinformation('S360DXB'),'SYD' => functions::Xmlinformation('S360SYD'),'DXBALL' => functions::Xmlinformation('S360DXBALL')]}

                                     {foreach $cities as $item}
                                     <li>
                                            <a target='_blank' href="{$smarty.const.ROOT_ADDRESS}/international/1/IKA-{$item@key}/{$objDate->tomorrow()}/1-0-0">
                                                <i class="">
                                                </i>
                                              {$item}
                                            </a>
                                        </li>
                                     {/foreach}
                                    </ul>
                                </div>
                            </div>
                            <div class="item-footer col-lg-6 col-md-6 col-sm-12 col-12 display-footer-none">
                                <div class="box-item-footer text-right">
                                    <h3>
                                        دسترسی آسان
                                    </h3>
                                    <ul>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">
                                                <i class="">
                                                </i>
                                                پیگیری خرید
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">
                                                <i class="">
                                                </i>
                                                درباره ما
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/contactUs">
                                                <i class="">
                                                </i>
                                                تماس با ما
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/rules">
                                                <i class="">
                                                </i>
                                                قوانین و مقررات
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/news">
                                                <i class="">
                                                </i>
                                                اخبار
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/pay">
                                                <i class="">
                                                </i>
                                                درگاه پرداخت آنلاین
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="item-footer col-lg-6 col-md-6 col-sm-12 col-12 order-foot1">
                                <div class="parent-item-footer parent-item-footer-responsive">
                                    <div class="img-box-footer">
                                        <img alt="footer-logo" src="project_files/images/logo.png" />
                                        <div class="logo-caption">
                                       <span class="sub-logo">
                                        رشنو پرواز
                                       </span>
                                                                          <span>
                                        آژانس خدماتی مسافرتی
                                       </span>
                                        </div>
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
                            <div class="item-footer col-lg-6 col-md-6 col-sm-12 col-12 order-foot2">
                                <div class="parent-namad box-item-footer text-right">
                                    <div class="child-item-footer">
                                        <div>
                                            <i class="fa-light fa-location-dot">
                                            </i>
                                            آدرس:
                                        </div>
                                        <span class="__address_class__">
              {$smarty.const.CLIENT_ADDRESS}
             </span>
                                    </div>
                                    <div class="child-item-footer">
                                        <div>
                                            <i class="fa-light fa-phone">
                                            </i>
                                            تلفن:
                                        </div>
                                        <a class="__phone_class__" href="tel:{$smarty.const.CLIENT_PHONE}">
                                            {$smarty.const.CLIENT_PHONE}
                                        </a>
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