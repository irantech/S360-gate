{load_presentation_object filename="aboutUs" assign="objAbout"}
{assign var="about"  value=$objAbout->getData()}
{assign var="socialLinks"  value=$about['social_links']|json_decode:true}


{if $smarty.session.layout neq 'pwa'}
 {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}

  <footer class="i_modular_footer position-relative footer-gisoo">
   <div class="div-footer-parent">
    <div class="container">
     <div class="d-flex flex-wrap">
      <div class="col-lg-4 col-md-6 col-sm-12 col-12 p-0">
       <div class="parent-item-footer parent-item-footer-responsive">
        <div class="img-box-footer">
         <img alt="footer-logo" src="project_files/images/logo.png"/>
         <div class="text-logo-footer">
        <span>
         شرکت مسافرتی
        </span>
          <h4>
           آبی بال سفر
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
        <div class="__social_class__ footer-icon">
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
      <div class="col-lg-4 col-md-6 col-sm-12 col-12 p-0">
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
          <a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">
           <i class="fal fa-angle-left">
           </i>
           پیگیری خرید
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
        {assign var="socialLinks"  value=$about['social_links']|json_decode:true}
        {assign var="socialLinksArray" value=['telegram'=>'telegramHref','whatsapp'=> 'whatsappHref','instagram' => 'instagramHref','aparat' => 'aparatHref','youtube' => 'youtubeHref','facebook' => 'facebookHref','linkeDin' => 'linkeDinHref']}

        {foreach $socialLinks as $key => $val}
         {assign var=$socialLinksArray[$val['social_media']] value=$val['link']}
        {/foreach}
       </div>
      </div>
      <div class="col-lg-4 col-md-12 col-sm-12 col-12 p-0">
       <div class="parent-namad">
        <h3>
         مجوزها
        </h3>
        <div class="namads">
         <a href="https://farasa.cao.ir/sysworkflow/fa/modern/3810212626028ab03488017019616799/6464336316028ab04e3c618028352200.php">
          <img alt="Enamad1" src="project_files/images/certificate1.png"/>
         </a>
         <a href="https://www.caa.gov.ir/">
          <img alt="namad-1" src="project_files/images/certificate2.png"/>
         </a>
         <a href="https://www.aira.ir/">
          <img alt="namad-2" src="project_files/images/certificate3.png"/>
         </a>
         <a referrerpolicy='origin' target='_blank' href='https://trustseal.enamad.ir/?id=570290&Code=14SRuwSkavgA6LckM1CF9BJ3qXCXKYN6'><img referrerpolicy='origin' src='https://trustseal.enamad.ir/logo.aspx?id=570290&Code=14SRuwSkavgA6LckM1CF9BJ3qXCXKYN6' alt='' style='cursor:pointer' code='14SRuwSkavgA6LckM1CF9BJ3qXCXKYN6'></a>
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
   <a class="fixicone fa-solid fa-plane-up" href="javascript:" id="scroll-top" style="">
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