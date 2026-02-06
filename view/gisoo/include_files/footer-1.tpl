{load_presentation_object filename="aboutUs" assign="objAbout"}
{assign var="about"  value=$objAbout->getData()}
{assign var="socialLinks"  value=$about['social_links']|json_decode:true}


{if $smarty.session.layout neq 'pwa'}
 {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}

  <footer class="i_modular_footer position-relative footer-gisoo">
   <div class="div-footer-parent">
    <div class="container">
     <div class="d-flex flex-wrap">
      <div class="col-lg-4 col-md-6 col-sm-12 col-12 p-2">
       <div class="parent-item-footer parent-item-footer-responsive">
        <div class="img-box-footer">
           <img  src="project_files/images/logo2.png" alt="img-logo"/>
           <img  src="project_files/images/logo.png" alt="footer-logo"/>
           <div class="text-logo-footer">
             <span>
            دفتر خدمات مسافرتی و گردشگری
           </span>
             <h4>
              گیسوی خورشید
             </h4>
           </div>
        </div>


        <div class="child-item-footer">
         <i class="fa-light fa-location-dot">
         </i>
         آدرس:
         <span class="__address_class__">
        آدرس :  {$smarty.const.CLIENT_ADDRESS}
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
        {assign var="socialLinksArray" value=['telegram'=>'telegramHref','whatsapp'=> 'whatsappHref','instagram' => 'instagramHref','aparat' => 'aparatHref','youtube' => 'youtubeHref','facebook' => 'facebookHref','linkeDin' => 'linkeDinHref']}

        {foreach $socialLinks as $key => $val}
         {assign var=$socialLinksArray[$val['social_media']] value=$val['link']}
        {/foreach}
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
          <a href="{$smarty.const.ROOT_ADDRESS}/page/visa">
           <i class="fal fa-angle-left">
           </i>
           ویزا
          </a>
         </li>
         <li>
          <a href="{$smarty.const.ROOT_ADDRESS}/page/entertainment">
           <i class="fal fa-angle-left">
           </i>
           تفریحات
          </a>
         </li>
         <li>
          <a href="{$smarty.const.ROOT_ADDRESS}/currency">
           <i class="fal fa-angle-left">
           </i>
           ارز
          </a>
         </li>
         <li>
          <a href="{$smarty.const.ROOT_ADDRESS}/pay">
           <i class="fal fa-angle-left">
           </i>
           پرداخت آنلاین
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
          <a href="{$smarty.const.ROOT_ADDRESS}/mag">
           <i class="fal fa-angle-left">
           </i>
           وبلاگ
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
          <a href="{$smarty.const.ROOT_ADDRESS}/introductIran">
           <i class="fal fa-angle-left">
           </i>
           معرفی ایران
          </a>
         </li>
         <li>
          <a href="{$smarty.const.ROOT_ADDRESS}/aboutCountry">
           <i class="fal fa-angle-left">
           </i>
           معرفی کشور ها
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
         <a href="javascript:">
          <img alt="Enamad1" src="project_files/images/certificate1.png"/>
         </a>
         <a href="javascript:">
          <img alt="namad-1" src="project_files/images/certificate2.png"/>
         </a>
         <a href="javascript:">
          <img alt="namad-2" src="project_files/images/certificate3.png"/>
         </a>
         <a referrerpolicy='origin' target='_blank' href='https://trustseal.enamad.ir/?id=459614&Code=DpMFycFCHFZxjQ9bGL5HeMPocIiur26F'><img referrerpolicy='origin' src='https://trustseal.enamad.ir/logo.aspx?id=459614&Code=DpMFycFCHFZxjQ9bGL5HeMPocIiur26F' alt='' style='cursor:pointer' Code='DpMFycFCHFZxjQ9bGL5HeMPocIiur26F'></a>
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
   <!--            <a href="javascript:" class="fixicone fa fa-angle-up" id="scroll-top"></a>-->
  </footer>
  <div class="WhatsApp-Icon">
   <a href="https://api.whatsapp.com/send?phone=+989194950621">
    <img src="project_files/images/whatsapp.png" alt="whatsapp" style="width: 40px">
   </a>
  </div>
 {/if}
{else}
 {include file="`$smarty.const.FRONT_CURRENT_CLIENT`pwaFooter.tpl"}
{/if}