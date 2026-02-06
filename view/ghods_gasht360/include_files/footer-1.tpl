{load_presentation_object filename="aboutUs" assign="objAbout"}
{assign var="about"  value=$objAbout->getData()}
{if $smarty.session.layout neq 'pwa'}
    {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}
        <footer class="i_modular_footer">
            <div class="body-footer">
                <div class="container">
                    <div class="row">
                        <div class="parent-footer-iran d-flex flex-wrap w-100">
                            <div class="item-footer col-lg-3 col-md-12 col-sm-12 col-12  order-foot1">
                                <div class="parent-item-footer parent-item-footer-responsive box-item-footer2">
                                    <img src="project_files/images/logo.png" alt="img-logo">
                                    <div class="parent-about-footer box-item-footer text-right">
                                         <span class="__aboutUs_class__ text-footer-about">
                                           {$htmlContent = $about['body']|strip_tags}{$htmlContent|truncate:300}
                                         </span>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/aboutUs" class="__aboutUs_class_href__ footer-more-link">
                                            بیشتر
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                <path d="M447.1 256c0 13.25-10.76 24.01-24.01 24.01H83.9l132.7 126.6c9.625 9.156 9.969 24.41 .8125 33.94c-9.156 9.594-24.34 9.938-33.94 .8125l-176-168C2.695 268.9 .0078 262.6 .0078 256S2.695 243.2 7.445 238.6l176-168C193 61.51 208.2 61.85 217.4 71.45c9.156 9.5 8.812 24.75-.8125 33.94l-132.7 126.6h340.1C437.2 232 447.1 242.8 447.1 256z"></path>
                                            </svg>
                                        </a>
                                        {*        <div class="__social_class__ footer-icon icon-respancive">*}
                                        {*         <a target="_blank" href="javascript:" class="__telegram_class__ fab fa-telegram footer_telegram"></a>*}
                                        {*         <a target="_blank" href="javascript:" class="__instagram_class__ fab fa-instagram footer_instagram"></a>*}
                                        {*         <a target="_blank" href="javascript:" class="__whatsapp_class__ fab fa-whatsapp footer_whatsapp"></a>*}
                                        {*         <a target="_blank" href="javascript:" class="__linkdin_class__ fa-brands fa-linkedin-in footer_linkedin"></a>*}
                                        {*        </div>*}
                                    </div>
                                 {assign var="socialLinks"  value=$about['social_links']|json_decode:true}
                                 {assign var="socialLinksArray" value=['telegram'=>'telegramHref','whatsapp'=> 'whatsappHref','instagram' => 'instagramHref','aparat' => 'aparatHref','youTube' => 'youtubeHref','facebook' => 'facebookHref','linkedin' => 'linkeDinHref']}

                                 {foreach $socialLinks as $key => $val}
                                  {assign var=$socialLinksArray[$val['social_media']] value=$val['link']}
                                 {/foreach}
                                    <div class="__social_class__ footer-icon my-footer-icon">
                                        <a target="_blank" href="{if $telegramHref}{$telegramHref}{/if}"
                                           class="__telegram_class__ fab fa-telegram footer_telegram"></a>
                                        <a target="_blank" href="{if $instagramHref}{$instagramHref}{/if}"
                                           class="__instagram_class__ fab fa-instagram footer_instagram"></a>
                                        <a target="_blank" href="{if $whatsappHref}{$whatsappHref}{/if}"
                                           class="__whatsapp_class__ fab fa-whatsapp footer_whatsapp"></a>
                                        <a target="_blank" href="{if $linkeDinHref}{$linkeDinHref}{/if}"
                                           class="__linkdin_class__ fa-brands fa-linkedin-in footer_linkedin"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="item-footer col-lg-5 col-md-12 col-sm-12 col-12 order-foot2">
                                <div class="box-item-footer text-right">
                                    <h3>دسترسی آسان</h3>
                                    <ul>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">
                                                <i class=""></i>
                                                خدمات گروهی/انفرادی سفر
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/page/visa">
                                                <i class=""></i>
                                                خدمات ویزای توریستی/پیکاپ ویزا
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/page/hotel">
                                                <i class=""></i>
                                                هتل
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/mag">
                                                <i class=""></i>
                                                مجله گردشگری
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/rules">
                                                <i class=""></i>
                                                قوانین و مقررات قدس گشت
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">
                                                <i class=""></i>
                                                درباره ما
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/vote">
                                                <i class=""></i>
                                                نظرسنجی
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/page/CertificateAppreciation">
                                                <i class=""></i>
                                                لوح های تقدیر
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/personnel">
                                                <i class=""></i>
                                                مدیران و پرسنل
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/contactUs">
                                                <i class=""></i>
                                                ارتباط با ما
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="item-footer col-lg-4 col-md-12 col-sm-12 col-12 order-foot4">
                             <div class="box-item-footer parent-contact-information">
                              <h3>اطلاعات تماس</h3>
                              <div class="child-item-footer2">
                                     <span>
                                    <i class="fa-solid fa-location-dot"></i>
                                     </span>
                               آدرس:
                               <span class="__address_class__ text-right">
                                            {$smarty.const.CLIENT_ADDRESS}
                                </span>
                              </div>
                                  <div class="child-item-footer">
                                      <i class="fa-solid fa-mobile"></i>
                                                                    تورهای داخلی:
                                       <a href="tel:+989193267704" class="">
                                                                        09193267704
                                       </a>
                                  </div>
                                 <div class="child-item-footer">
                                  <span>
                                  <i class="fa-solid fa-mobile"></i>
                                  </span>
                                  تورهای خارجی:
                                  <a href="tel:+989190264922" class="__mobile_class__">
                                   09190264922
                                  </a>
                                 </div>
                                 <div class="child-item-footer">
                                  <span>
                                   <i class="fa-solid fa-envelope"></i>
                                  </span>
                                  ایمیل:
                                  <a href="mailto:{$smarty.const.CLIENT_EMAIL}" class="__email_class__">
                                   {$smarty.const.CLIENT_EMAIL}
                                  </a>
                                 </div>
                                   <div class="namads">
                                        <a href="https://www.cao.ir/paxrights"><img src="project_files/images/certificate1.png" alt="Enamad1"></a>
                                        <a href="https://www.cao.ir/"><img src="project_files/images/certificate2.png" alt="namad-1"></a>
                                        <a href="http://aira.ir/images/final3.pdf"><img src="project_files/images/certificate3.png" alt="namad-2"></a>
                                       <a referrerpolicy='origin' target='_blank' href='https://trustseal.enamad.ir/?id=52987&Code=3AURicS2SwbOGTtqp3xq'><img referrerpolicy='origin' src='https://trustseal.enamad.ir/logo.aspx?id=52987&Code=3AURicS2SwbOGTtqp3xq' alt='' style='cursor:pointer' code='3AURicS2SwbOGTtqp3xq'></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         <div class="last_text col-12">
          <p class="txt12 newmat ghods">
           کلیه حقوق این وب سایت متعلق به
           <a class="newblue" href="javascript:">
            آژانس مسافرتی و گردشگری قدس گشت
           </a>
           می باشد.
          </p>
          <div>
           <a class="last_a" href="https://www.iran-tech.com/">طراحی سایت گردشگری </a>
           <p class="last_p_text">: ایران تکنولوژی</p>
          </div>
         </div>
            <a href="javascript:" class="fixicone fa fa-angle-up" id="scroll-top" style=""></a>
        </footer>
    {/if}
{else}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`pwaFooter.tpl"}
{/if}
