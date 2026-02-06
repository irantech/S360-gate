{load_presentation_object filename="aboutUs" assign="objAbout"}
                            {assign var="about"  value=$objAbout->getData()}
                            {assign var="socialLinks"  value=$about['social_links']|json_decode:true}


                            {if $smarty.session.layout neq 'pwa'}
                                {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}
                                   
<footer class="i_modular_footer">
 <div class="container">
  <div class="row">
   <div class="parent-footer-iran d-flex flex-wrap w-100">


    <div class="item-footer col-lg-7 col-md-7 col-sm-12 col-12 order-foot1">
     <div class="parent-item-footer parent-item-footer-responsive box-item-footer2">
      <img alt="logo-img" src="project_files/images/logo.png"/>
      <div class="child-item-footer align-items-center">
       <span class="__address_class__ text-right">
        آدرس :  {$smarty.const.CLIENT_ADDRESS}
       </span>
      </div>
      <div class='parent-phones-footer'>
      <div class="child-item-footer">
       تلفن:
       <a class="__phone_class__" href="tel:{$smarty.const.CLIENT_PHONE}">
        {$smarty.const.CLIENT_PHONE}
       </a>
      </div>


       <div class="child-item-footer">
        کارشناس فروش انتالیا و دبی با شماره:

        <a class="__mobile_class__" href="tel:09371398583">
         09371398583
        </a>
       </div>

       <div class="child-item-footer">
        کارشناس فروش اروپا با شماره:
        <a class="__phone_class__" href="tel:09019582493">
         09019582493
        </a>
       </div>

       <div class="child-item-footer">
        کارشناس فروش گرجستان باشماره:
        <a class="__phone_class__" href="tel:09379431763">
         09379431763
        </a>
       </div>

       <div class="child-item-footer">
        کارشناس فروش کشتی کروز باشماره:
        <a class="__phone_class__" href="tel:09371398583">
         09371398583
        </a>
       </div>

       <div class="child-item-footer">
        کارشناس فروش شرق اسیا باشماره:
        <a class="__phone_class__" href="tel:09379431763">
         09379431763
        </a>
       </div>

       <div class="child-item-footer">
        کارشناس تورهای داخلی با شماره:
        <a class="__phone_class__" href="tel:09374125681">
         09374125681
        </a>
       </div>


{*      <div class="child-item-footer">*}
{*       مدیریت:*}
{*       <a class="__mobile_class__" href="tel:+989158039626">*}
{*        09158039626*}
{*       </a>*}
{*      </div>*}
{*       *}
{*       <div class="child-item-footer">*}
{*        تور اقساطی<a class='city-link' href='{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-65/6-167/all/all'>دبی</a>:*}
{*        <a class="__phone_class__" href="tel:09159996282">*}
{*         09159996282*}
{*        </a>*}
{*       </div>*}
{*       *}
{*       <div class="child-item-footer">*}
{*        تور اقساطی<a class='city-link' href='{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-1/10-169/all/all'>آنتالیا</a>:*}
{*        <a class="__phone_class__" href="tel:09390553948">*}
{*         09390553948*}
{*        </a>*}
{*       </div>*}
{*       *}
{*      <div class="child-item-footer">*}
{*       تور اقساطی<a class='city-link' href='{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-1/10-168/all/all'>استانبول</a>:*}
{*       <a class="__phone_class__" href="tel:09301852919">*}
{*        09301852919*}
{*       </a>*}
{*      </div>*}
{*       *}
{*      <div class="child-item-footer">*}
{*       تور اقساطی<a class='city-link' href='{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-1/21-all/all/all/0'>گرجستان</a>:*}
{*       <a class="__phone_class__" href="tel:09055568996">*}
{*        09055568996*}
{*       </a>*}
{*      </div>*}
{*       *}
{*      <div class="child-item-footer">*}
{*       تور اقساطی<a class='city-link' href='{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-1/11-170/all/all'>مسکو</a>:*}
{*       <a class="__phone_class__" href="tel:09396885676">*}
{*        09396885676*}
{*       </a>*}
{*      </div>*}
{*       *}
{*      <div class="child-item-footer">*}
{*       پشتیبان سایت:*}
{*       <a class="__phone_class__" href="tel:09158039626">*}
{*        09158039626*}
{*       </a>*}
{*      </div>*}

      <div class="child-item-footer">
       ایمیل:
       <a class="__email_class__" href="mailto:{$smarty.const.CLIENT_EMAIL}">
        {$smarty.const.CLIENT_EMAIL}
       </a>
      </div>
      </div>
      <div class="namads">
       <a href="https://www.cao.ir/paxrights">
        <img alt="Enamad1" src="project_files/images/certificate1.png"/>
       </a>
       <a href="https://caa.gov.ir/">
        <img alt="namad-1" src="project_files/images/certificate2.png"/>
       </a>
       <a href="https://www.aira.ir/">
        <img alt="namad-2" src="project_files/images/certificate3.png"/>
       </a>
       <a referrerpolicy='origin' target='_blank' href='https://trustseal.enamad.ir/?id=483373&Code=3NZOuyQCTZLmWe7BD8DlZ8ZRMghf7zRA'><img referrerpolicy='origin' src='https://trustseal.enamad.ir/logo.aspx?id=483373&Code=3NZOuyQCTZLmWe7BD8DlZ8ZRMghf7zRA' alt='' style='cursor:pointer' Code='3NZOuyQCTZLmWe7BD8DlZ8ZRMghf7zRA'></a>
      </div>
      {assign var="socialLinks"  value=$about['social_links']|json_decode:true}
                                {assign var="socialLinksArray" value=['telegram'=>'telegramHref','whatsapp'=> 'whatsappHref','instagram' => 'instagramHref','aparat' => 'aparatHref','youtube' => 'youtubeHref','facebook' => 'facebookHref','ita' => 'itaHref']}

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
       <a class="__linkdin_class__ footer_linkedin" href="{if $itaHref}{$itaHref}{/if}" target="_blank">
        <img src='project_files/images/eitaa-icon-black.png' alt='eitaa'>
       </a>
      </div>
     </div>
    </div>


    <div class="item-footer col-lg-2 col-md-2 col-sm-12 col-12 display-footer-none">
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
        <a href="{$smarty.const.ROOT_ADDRESS}/page/visa">
         ویزا
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
       <li><a href="{$smarty.const.ROOT_ADDRESS}/currency">ارز</a></li>
      </ul>
     </div>
    </div>


    <div class="item-footer col-lg-3 col-md-3 col-sm-12 col-12 order-foot2">
     <div class="parent-namad box-item-footer text-right">
      <h3>
       ﺳﻔﯿﺮان ﺳﺮوش ﻣﻬﺮ آرﯾﺎیی
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
        <a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">
         درباره ما
        </a>
       </li>
       <li>
        <a href="{$smarty.const.ROOT_ADDRESS}/recommendation">
         سفرنامه
        </a>
       </li>
       <li>
        <a href="{$smarty.const.ROOT_ADDRESS}/rules">
         قوانین و مقررات
        </a>
       </li>
       <li>
        <a href="{$smarty.const.ROOT_ADDRESS}/contactUs">
         تماس با ما
        </a>
       </li>

       <li>
        <a href="{$smarty.const.ROOT_ADDRESS}/pay">پرداخت آنلاین</a>
       </li>
      </ul>
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
     <a class="__instagram_class__ fab fab fa-instagram footer_instagram" href="{if $instagramHref}{$instagramHref}{/if}" target="_blank">
     </a>
     <a class="__whatsapp_class__ fab fa-whatsapp footer_whatsapp" href="{if $whatsappHref}{$whatsappHref}{/if}" target="_blank">
     </a>
     <a class="__linkdin_class__ footer_linkedin" href="{if $itaHref}{$itaHref}{/if}" target="_blank">
      <img src='project_files/images/eitaa-icon-black.png' alt='eitaa'>
     </a>
    </div>
   </div>
  </div>
 </div>
 <a class="fixicone fa fa-angle-up" href="javascript:" id="scroll-top" style="">
 </a>
</footer>

    {/if}
                            {else}
                                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`pwaFooter.tpl"}
                            {/if}