{load_presentation_object filename="aboutUs" assign="objAbout"}
{assign var="about"  value=$objAbout->getData()}
{if $smarty.session.layout neq 'pwa'}
 {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}

  <footer class="i_modular_footer">
 <div class="container">
  <div class="row">
   <div class="parent-footer-iran d-flex flex-wrap w-100">
    <div class="item-footer col-lg-4 col-md-6 col-sm-12 col-12 order-foot1">
     <div class="parent-item-footer parent-item-footer-responsive box-item-footer2">
      <a class="__logo_class__ nav-header" href="__main_link_href__">
       <img alt="img-logo" class="logo" src="project_files/images/logo.png"/>
       <div class="logo-caption">
        <span class="sub-span">
         نیمبوس ایر
        </span>
        <p>
         nimbusair
        </p>
       </div>
      </a>
      <div class="child-item-footer align-items-center">
       آدرس:
       <span class="text-right">
        {$smarty.const.CLIENT_ADDRESS}
       </span>
      </div>
      <div class="child-item-footer">
       تلفن:
{*       <a class="__phone_class__" href="tel:{$smarty.const.CLIENT_PHONE}">*}
{*        {$smarty.const.CLIENT_PHONE}*}
{*       </a>*}
       <a class="__phone_class__" href="tel:02191015428">
        02191015428
       </a>
       -
       <a class="__phone_class__" href="tel:02191016428">
        02191016428
       </a>
      </div>
      <div class="child-item-footer">
       موبایل:
       <a class="__mobile_class__" href="tel:{$smarty.const.CLIENT_MOBILE}">
        {$smarty.const.CLIENT_MOBILE}
       </a>
      </div>
      <div class="child-item-footer">
       ایمیل:
       <a class="__email_class__" href="mailto:{$smarty.const.CLIENT_EMAIL}">
        {$smarty.const.CLIENT_EMAIL}
       </a>
      </div>
      <div class="namads">
       <a href="https://farasa.cao.ir/sysworkflow/fa/modern/3810212626028ab03488017019616799/6464336316028ab04e3c618028352200.php">
        <img alt="Enamad1" src="project_files/images/certificate1.png"/>
       </a>
       <a href="https://caa.gov.ir/">
        <img alt="namad-1" src="project_files/images/certificate2.png"/>
       </a>
       <a href="https://www.aira.ir/">
        <img alt="namad-2" src="project_files/images/certificate3.png"/>
       </a>
       <a referrerpolicy='origin' target='_blank' href='https://trustseal.enamad.ir/?id=605536&Code=8bC5PIqsjoKuTDfpZ4b7QUUTAORDuEJk'><img referrerpolicy='origin' src='https://trustseal.enamad.ir/logo.aspx?id=605536&Code=8bC5PIqsjoKuTDfpZ4b7QUUTAORDuEJk' alt='' style='cursor:pointer' code='8bC5PIqsjoKuTDfpZ4b7QUUTAORDuEJk'></a>
       <a href="">
        <img referrerpolicy='origin' id = 'rgvjsizpnbqefukznbqewlao' style = 'cursor:pointer' onclick = 'window.open("https://logo.samandehi.ir/Verify.aspx?id=392624&p=xlaopfvluiwkgvkauiwkaods", "Popup","toolbar=no, scrollbars=no, location=no, statusbar=no, menubar=no, resizable=0, width=450, height=630, top=30")' alt = 'logo-samandehi' src = 'https://logo.samandehi.ir/logo.aspx?id=392624&p=qftibsiyodrfwlbqodrfshwl' />
       </a>
      </div>
      {assign var="socialLinks"  value=$about['social_links']|json_decode:true}
                                {assign var="socialLinksArray" value=['telegram'=>'telegramHref','whatsapp'=> 'whatsappHref','instagram' => 'instagramHref','aparat' => 'aparatHref','youTube' => 'youtubeHref','facebook' => 'facebookHref','linkedin' => 'linkeDinHref' , 'twitter' => 'twitterHref']}

                                {foreach $socialLinks as $key => $val}
                                        {assign var=$socialLinksArray[$val['social_media']] value=$val['link']}
                                {/foreach}
      <div class="__social_class__ footer-icon my-footer-icon2">
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
    <div class="item-footer col-lg-2 col-md-3 col-sm-12 col-12 display-footer-none">
     <div class="box-item-footer text-right">
      <h3>
       دسترسی آسان
      </h3>
      <ul>
       <li>
        <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">
         تور
        </a>
       </li>
       <li>
        <a href="{$smarty.const.ROOT_ADDRESS}/page/hotel">
         هتل
        </a>
       </li>
       <li>
        <a href="{$smarty.const.ROOT_ADDRESS}/page/flight">
         پرواز
        </a>
       </li>
       <li>
        <a href="{$smarty.const.ROOT_ADDRESS}/page/bus">
         اتوبوس
        </a>
       </li>
       <li>
        <a href="{$smarty.const.ROOT_ADDRESS}/page/insurance">
         بیمه
        </a>
       </li>
      </ul>
     </div>
    </div>
    <div class="item-footer col-lg-2 col-md-3 col-sm-12 col-12 order-foot2">
     <div class="parent-namad box-item-footer text-right">
      <h3>
       آریا سورین بار ثاوا
      </h3>
      <ul>
       <li>
        <a href="{$smarty.const.ROOT_ADDRESS}/mag">
         وبلاگ
        </a>
       </li>
       <li>
        <a href="{$smarty.const.ROOT_ADDRESS}/news">
         اخبار
        </a>
       </li>
       <li>
        <a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">
         پیگیری خرید
        </a>
       </li>
       <li>
        <a href="{$smarty.const.ROOT_ADDRESS}/rules">
         قوانین و مقررات
        </a>
       </li>
       <li>
        <a href="{$smarty.const.ROOT_ADDRESS}/pay">
         درگاه پرداخت آنلاین
        </a>
       </li>
      </ul>
     </div>
    </div>
    <div class="item-footer col-lg-4 col-md-4 col-sm-12 col-12 about-footer-parent">
     <div class="box-item-footer text-right about-footer">
      <h3>
       درباره ما
      </h3>
      <p> {$htmlContent = $about['body']|strip_tags}{$htmlContent|truncate:800}  </p>
       <a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">
       بیشتر
       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-v-c294f34c=""><path d="M447.1 256c0 13.25-10.76 24.01-24.01 24.01H83.9l132.7 126.6c9.625 9.156 9.969 24.41 .8125 33.94c-9.156 9.594-24.34 9.938-33.94 .8125l-176-168C2.695 268.9 .0078 262.6 .0078 256S2.695 243.2 7.445 238.6l176-168C193 61.51 208.2 61.85 217.4 71.45c9.156 9.5 8.812 24.75-.8125 33.94l-132.7 126.6h340.1C437.2 232 447.1 242.8 447.1 256z" data-v-c294f34c=""></path></svg>
      </a>
{*      <div class="namads">*}
{*       <a href="https://farasa.cao.ir/sysworkflow/fa/modern/3810212626028ab03488017019616799/6464336316028ab04e3c618028352200.php">*}
{*        <img alt="Enamad1" src="project_files/images/certificate1.png"/>*}
{*       </a>*}
{*       <a href="https://caa.gov.ir/">*}
{*        <img alt="namad-1" src="project_files/images/certificate2.png"/>*}
{*       </a>*}
{*       <a href="https://www.aira.ir/">*}
{*        <img alt="namad-2" src="project_files/images/certificate3.png"/>*}
{*       </a>*}
{*       <a href="javascript:">*}
{*        <img alt="namad-2" src="project_files/images/enamad.png"/>*}
{*       </a>*}
{*      </div>*}

     </div>
    </div>
   </div>
  </div>
 </div>
 <div class="last_text col-12">
  <div class="container">
   <div class="parent-iran-tech">
    <div class="parent-text-iran-tech">
     <a class="last_a" href="https://www.iran-tech.com/">
      طراحی سایت گردشگری
     </a>
     <p class="last_p_text">
      : ایران تکنولوژی
     </p>
    </div>
    <div class="__social_class__ footer-icon my-footer-icon">
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