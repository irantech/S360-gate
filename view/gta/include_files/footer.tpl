{load_presentation_object filename="aboutUs" assign="objAbout"}
                            {assign var="about"  value=$objAbout->getData()}
                            {if $smarty.session.layout neq 'pwa'}
                                {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}
                                   
<footer class="i_modular_footer">
 <div class="body-footer">
  <div class="container">
   <div class="row">
    <div class="parent-footer-iran d-flex flex-wrap w-100">
     <div class="item-footer col-lg-4 col-md-6 col-sm-12 col-12 order-foot1">
      <div class="parent-item-footer parent-item-footer-responsive box-item-footer2">
       <img alt="img-logo" src="project_files/images/logo.png"/>
       <div class="parent-about-footer box-item-footer text-right">
        <span class="__aboutUs_class__ text-footer-about">
         {$htmlContent = $about['body']|strip_tags}{$htmlContent|truncate:300}
        </span>
        <a class="{$smarty.const.ROOT_ADDRESS}/contactUs footer-more-link" href="{$smarty.const.ROOT_ADDRESS}/aboutUs">
         بیشتر
         <svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
          <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
          <path d="M447.1 256c0 13.25-10.76 24.01-24.01 24.01H83.9l132.7 126.6c9.625 9.156 9.969 24.41 .8125 33.94c-9.156 9.594-24.34 9.938-33.94 .8125l-176-168C2.695 268.9 .0078 262.6 .0078 256S2.695 243.2 7.445 238.6l176-168C193 61.51 208.2 61.85 217.4 71.45c9.156 9.5 8.812 24.75-.8125 33.94l-132.7 126.6h340.1C437.2 232 447.1 242.8 447.1 256z">
          </path>
         </svg>
        </a>
       </div>
      </div>
     </div>
     <div class="item-footer col-lg-4 col-md-6 col-sm-12 col-12 order-foot2">
      <div class="box-item-footer text-right">
       <h3>
        دسترسی آسان
       </h3>
       <ul>
        <li>
         <a href="{$smarty.const.ROOT_ADDRESS}/page/flight">
          <i class="fa-sharp fa-solid fa-square">
          </i>
          پرواز
         </a>
        </li>
        <li>
         <a href="{$smarty.const.ROOT_ADDRESS}/page/hotel">
          <i class="fa-sharp fa-solid fa-square">
          </i>
          هتل
         </a>
        </li>
        <li>
         <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">
          <i class="fa-sharp fa-solid fa-square">
          </i>
          تور
         </a>
        </li>
        <li>
         <a href="{$smarty.const.ROOT_ADDRESS}/page/visa">
          <i class="fa-sharp fa-solid fa-square">
          </i>
          ویزا
         </a>
        </li>
        <li>
         <a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">
          <i class="fa-sharp fa-solid fa-square">
          </i>
          پیگیری خرید
         </a>
        </li>
        <li>
         <a href="{$smarty.const.ROOT_ADDRESS}/pay">
          <i class="fa-sharp fa-solid fa-square">
          </i>
          درگاه پرداخت آنلاین
         </a>
        </li>
        <li>
         <a href="{$smarty.const.ROOT_ADDRESS}/authenticate">
          <i class="fa-sharp fa-solid fa-square">
          </i>
          باشگاه مشتریان
         </a>
        </li>
        <li>
         <a href="{$smarty.const.ROOT_ADDRESS}/mag">
          <i class="fa-sharp fa-solid fa-square">
          </i>
          وبلاگ
         </a>
        </li>
        <li>
         <a href="{$smarty.const.ROOT_ADDRESS}/news">
          <i class="fa-sharp fa-solid fa-square">
          </i>
          اخبار
         </a>
        </li>
        <li>
         <a href="{$smarty.const.ROOT_ADDRESS}/page/travelCard">
          <i class="fa-sharp fa-solid fa-square">
          </i>
          سفر کارت (سازمانی)
         </a>
        </li>
        <li>
         <a href="{$smarty.const.ROOT_ADDRESS}/page/cargo">
          <i class="fa-sharp fa-solid fa-square">
          </i>
          کارگو
         </a>
        </li>
        <li>
         <a href="{$smarty.const.ROOT_ADDRESS}/page/EcoCamp">
          <i class="fa-sharp fa-solid fa-square">
          </i>
          اکو کمپ
         </a>
        </li>
       </ul>
      </div>
     </div>
     <div class="item-footer col-lg-4 col-md-6 col-sm-12 col-12 order-foot3">
      <div class="box-item-footer parent-contact-information">
       <h3>
        تماس با ما
       </h3>
       <div class="child-item-footer2">
        <i class="fa-light fa-location-dot">
        </i>
        <div class="width-address">
         آدرس:
         <span class="__address_class__ text-right">
          {$smarty.const.CLIENT_ADDRESS}
         </span>
        </div>
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
        <a referrerpolicy='origin' target='_blank' href='https://trustseal.enamad.ir/?id=45429&Code=WjloMlNZs9lvcTLW2azq'><img referrerpolicy='origin' src='https://trustseal.enamad.ir/logo.aspx?id=45429&Code=WjloMlNZs9lvcTLW2azq' alt='' style='cursor:pointer' code='WjloMlNZs9lvcTLW2azq'></a>
       </div>
       {assign var="socialLinks"  value=$about['social_links']|json_decode:true}
       {assign var="socialLinksArray" value=['telegram'=>'telegramHref','whatsapp'=> 'whatsappHref','instagram' => 'instagramHref','aparat' => 'aparatHref','youTube' => 'youtubeHref','facebook' => 'facebookHref','linkedin' => 'linkeDinHref' , 'twitter' => 'twitterHref' , 'twitter' => 'twitterHref' , 'bale' => 'baleHref' , 'ita' => 'itaHref']}

         {foreach $socialLinks as $key => $val}
                 {assign var=$socialLinksArray[$val['social_media']] value=$val['link']}
         {/foreach}
       <div class="__social_class__ social">
        <a class="" href="{if $baleHref}{$baleHref}{/if}" target='_blank'>
         <img alt="bale" src="project_files/images/bale.png"/>
        </a>
        <a class="" href="{if $itaHref}{$itaHref}{/if}" target='_blank'>
         <img alt="eita" src="project_files/images/eita.png"/>
        </a>
        <a class="__whatsapp_class__" href="{if $whatsappHref}{$whatsappHref}{/if}">
         <img alt="Whatsapp" src="project_files/images/Whatsapp.png"/>
        </a>
        <a class="__instagram_class__" href="{if $instagramHref}{$instagramHref}{/if}">
         <img alt="instagram" src="project_files/images/instagram.png"/>
        </a>
       </div>
      </div>
     </div>
    </div>
   </div>
   <div class="footer-img">
    <img alt="img-footer" src="project_files/images/footer_back.png"/>
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