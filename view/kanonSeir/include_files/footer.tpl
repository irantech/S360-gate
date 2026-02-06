{load_presentation_object filename="aboutUs" assign="objAbout"}
                            {assign var="about"  value=$objAbout->getData()}
                            {if $smarty.session.layout neq 'pwa'}
                                {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}
                                   
<footer class="position-relative footer-gisoo i_modular_footer">
 <div class="div-footer-parent">
  <div class="container">
   <div class="d-flex flex-wrap">
    <div class="col-lg-4 col-md-6 col-sm-12 col-12 p-2">
     <div class="parent-item-footer parent-item-footer-responsive">
      <div class="img-box-footer">
       <img alt="img-logo" src="project_files/images/logo.png"/>
       <div class="text-logo-footer">
        <span>
         آژانس گردشگری
        </span>
        <h4>
         کانون سیر
        </h4>
       </div>
      </div>
      <div class="child-item-footer">
       <i class="fa-light fa-location-dot">
       </i>
       آدرس:
       <span class="__address_class__">
        {$smarty.const.CLIENT_ADDRESS}
       </span>
      </div>
      <!--                        <div class="child-item-footer">-->
      <!--                            <i class="fa-light fa-phone"></i>-->
      <!--                            تلفن:-->
      <!--                            <a href="javascript:" class="">-->
      <!--                                02166410008-->
      <!--                            </a>-->
      <!--                        </div>-->
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
      <div class="footer-icon __social_class__">
       <a class="fab fa-telegram footer_telegram __telegram_class__" href="{if $telegramHref}{$telegramHref}{/if}" target="_blank">
       </a>
       <a class="fab fa-instagram footer_instagram __instagram_class__" href="{if $instagramHref}{$instagramHref}{/if}" target="_blank">
       </a>
       <a class="fab fa-whatsapp footer_whatsapp __whatsapp_class__" href="{if $whatsappHref}{$whatsappHref}{/if}" target="_blank">
       </a>
       <a class="fa-brands fa-linkedin-in footer_linkedin __linkdin_class__" href="{if $linkeDinHref}{$linkeDinHref}{/if}" target="_blank">
       </a>
      </div>
     </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-6 p-2">
     <div class="box-item-footer text-right">
      <h3>
       خدمات
      </h3>
      <ul>
       <li>
        <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">
         <i class="fal fa-angle-left">
         </i>
         تور داخلی
        </a>
       </li>
       <li>
        <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">
         <i class="fal fa-angle-left">
         </i>
         تور خارجی
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
        <a href="{$smarty.const.ROOT_ADDRESS}/mag">
         <i class="fal fa-angle-left">
         </i>
         وبلاگ
        </a>
       </li>
      </ul>
     </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-6 p-2">
     <div class="box-item-footer text-right">
      <h3>
       دسترسی آسان
      </h3>
      <ul>
       <li>
        <a href="{$smarty.const.ROOT_ADDRESS}/rules">
         <i class="fal fa-angle-left">
         </i>
         قوانین و مقررات
        </a>
       </li>
       <li>
        <a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">
         <i class="fal fa-angle-left">
         </i>
         درباره ما
        </a>
       </li>
       <li>
        <a href="{$smarty.const.ROOT_ADDRESS}/contactUs">
         <i class="fal fa-angle-left">
         </i>
         تماس با ما
        </a>
       </li>
       <li>
        <a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">
         <i class="fal fa-angle-left">
         </i>
         پیگیری خرید
        </a>
       </li>
      </ul>
     </div>
    </div>
    <div class="col-lg-2 col-md-6 col-sm-12 col-12 p-2">
     <div class="parent-namad">
      <h3>
       مجوزها
      </h3>
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

    {/if}
                            {else}
                                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`pwaFooter.tpl"}
                            {/if}