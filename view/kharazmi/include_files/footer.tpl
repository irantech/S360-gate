{load_presentation_object filename="aboutUs" assign="objAbout"}
{assign var="about"  value=$objAbout->getData()}
{if $smarty.session.layout neq 'pwa'}
 {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}
                                   
<footer class="i_modular_footer position-relative footer-gisoo">
 <div class="div-footer-parent">
  <div class="container">
   <div class="d-flex flex-wrap">
    <div class="col-lg-3 col-md-6 col-sm-12 col-12 p-2 col-1">
     <div class="parent-item-footer parent-item-footer-responsive box-item-footer">
      <!--                        <div class="img-box-footer">-->
      <!--                            <img src="project_files/images/logo-color.png" alt="img-logo">-->
      <!--                            <div class="text-logo-footer">-->
      <!--                                <span>  آژانس خدماتی مسافرتی </span>-->
      <!--                                <h4>  دانش گشت خوارزمی </h4>-->
      <!--                            </div>-->
      <!--                        </div>-->
      <h3>
       دانش گشت خوارزمی
      </h3>
      <div class="child-item-footer">
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
      {assign var="socialLinks"  value=$about['social_links']|json_decode:true}
      {assign var="socialLinksArray" value=['telegram'=>'telegramHref','whatsapp'=> 'whatsappHref','instagram' => 'instagramHref','aparat' => 'aparatHref','youTube' => 'youtubeHref','facebook' => 'facebookHref','linkedin' => 'linkeDinHref']}

      {foreach $socialLinks as $key => $val}
       {assign var=$socialLinksArray[$val['social_media']] value=$val['link']}
      {/foreach}
      <div class="footer-icon">
       <a class="__telegram_class__ fab fa-telegram footer_telegram" href="{if $telegramHref}{$telegramHref}{/if}" target="_blank">
       </a>
       <a class="__instagram_class__ fab fa-instagram footer_instagram" href="{if $instagramHref}{$instagramHref}{/if}" target="_blank">
       </a>
       <a class="__whatsapp_class__ fab fa-whatsapp footer_whatsapp" href="{if $whatsappHref}{$whatsappHref}{/if}" target="_blank">
       </a>
       <a class="__linkdin_class__ fa-brands fa-linkedin-in footer_linkedin" href="{if $linkeDinHref}{$linkeDinHref}{/if}" target="_blank">
       </a>
      </div>
     </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12 col-12 p-2 col-2">
     <div class="box-item-footer text-right">
      <h3>
       دسترسی آسان
      </h3>
      <ul>
       <li>
        <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/all-all/all/all/0">
         <i class="fa-solid fa-circle-left">
         </i>
         تور داخلی
        </a>
       </li>
       <li>
        <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">
         <i class="fa-solid fa-circle-left">
         </i>
         تور خارجی
        </a>
       </li>
       <li>
        <a href="{$smarty.const.ROOT_ADDRESS}/mag">
         <i class="fa-solid fa-circle-left">
         </i>
         وبلاگ
        </a>
       </li>
       <li>
        <a   {if $obj_main_page->isLogin()} href="{$smarty.const.ROOT_ADDRESS}/club" {else} href="{$smarty.const.ROOT_ADDRESS}/authenticate" {/if}>
        <i class="fa-solid fa-circle-left">
         </i>
         باشگاه مشتریان
        </a>
       </li>
      </ul>
     </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12 col-12 p-2 col-3">
     <div class="box-item-footer text-right">
      <h3>
       خدمات
      </h3>
      <ul>
       <li>
        <a href="{$smarty.const.ROOT_ADDRESS}/page/FeesLeavingCountry">
         <i class="fa-solid fa-circle-left">
         </i>
         عوارض خروج از کشور
        </a>
       </li>
       <li>
        <a href="{$smarty.const.ROOT_ADDRESS}/recommendation">
         <i class="fa-solid fa-circle-left">
         </i>
         سفرنامه دانش گشت
        </a>
       </li>
      </ul>
     </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12 col-12 p-2 col-4">
     <div class="box-item-footer text-right">
      <h3>درباره ما</h3>
      <img alt="img-logo" src="project_files/images/logo.png"/>
      <p>
       {$htmlContent = $about['body']|strip_tags}{$htmlContent|truncate:800}
      </p>
     </div>
    </div>
    <div class="col-12 parent-namads">
     <div class="namads">
      <a href="https://www.cao.ir/paxrights">
       <img alt="Enamad1" src="project_files/images/certificate1.png"/>
      </a>
      <a href="https://www.cao.ir/">
       <img alt="namad-1" src="project_files/images/certificate2.png"/>
      </a>
      <a href="http://aira.ir/images/final3.pdf">
       <img alt="namad-2" src="project_files/images/certificate3.png"/>
      </a>
      <a href="javascript:">
       <img alt="namad-2" src="project_files/images/enamad.png"/>
      </a>
     </div>
    </div>
    <div class="last_text col-12">
     <div class="d-flex align-items-center">
      <a class="last_a" href="https://www.iran-tech.com/">
       طراحی سایت گردشگری
      </a>
      <p class="last_p_text">
       : ایران تکنولوژی
      </p>
     </div>
     <div class="footer-icon">
      <a class="__telegram_class__ fab fa-telegram footer_telegram" href="{if $telegramHref}{$telegramHref}{/if}" target="_blank">
      </a>
      <a class="__instagram_class__ fab fa-instagram footer_instagram" href="{if $instagramHref}{$instagramHref}{/if}" target="_blank">
      </a>
      <a class="__whatsapp_class__ fab fa-whatsapp footer_whatsapp" href="{if $whatsappHref}{$whatsappHref}{/if}" target="_blank">
      </a>
      <a class="__linkdin_class__ fa-brands fa-linkedin-in footer_linkedin" href="{if $linkeDinHref}{$linkeDinHref}{/if}" target="_blank">
      </a>
     </div>
    </div>
   </div>
  </div>
  <img alt="img-map" class="map-img" src="project_files/images/dots-background.png"/>
 </div>
 <a class="fixicone fa fa-angle-up" href="javascript:" id="scroll-top">
 </a>
</footer>

    {/if}
                            {else}
                                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`pwaFooter.tpl"}
                            {/if}