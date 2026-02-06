{load_presentation_object filename="aboutUs" assign="objAbout"}
                            {assign var="about"  value=$objAbout->getData()}
                            {assign var="socialLinks"  value=$about['social_links']|json_decode:true}


                            {if $smarty.session.layout neq 'pwa'}
                                {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}
                                 <svg enable-background="new 0 0 500 250" id="wave_footer" preserveaspectratio="none" version="1.1" viewbox="0 0 500 250" x="0px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" y="0px">
<path d="M250,246.5c-97.85,0-186.344-40.044-250-104.633V250h500V141.867C436.344,206.456,347.85,246.5,250,246.5z" id="path_footer_svg"></path>
</svg>
<footer class="i_modular_footer footer">
 <div class="footer_top">
  <div class="container">
   <div class="row">
    <div class="col-xl-3 col-md-6 col-lg-3 col_foo">
     <div class="footer_widget">
      <h3 class="footer_title">
       مسیر های پر تردد داخلی از تهران
      </h3>
      <ul class="links double_links">


       {assign 'cities' ['MHD' => functions::Xmlinformation('S360MHD'),'TBZ' => functions::Xmlinformation('S360TBZ'),'AWZ' =>  functions::Xmlinformation('S360AWZ'),'AZD' => functions::Xmlinformation('S360AZD'),'KSH' =>functions::Xmlinformation('S360KSH'),'RAS' => functions::Xmlinformation('S360RAS') , 'ADU' => functions::Xmlinformation('S360ADU') , 'BND' =>  functions::Xmlinformation('S360BND')]}


       {foreach $cities as $item}
        <li>
         <a onclick="calenderFlightSearch('THR','{$item@key}')"
            data-target="#calenderBox" data-toggle="modal">
          ##S360FlightTo## {$item}
         </a>
        </li>
       {/foreach}


      </ul>
     </div>
    </div>
    <div class="col-xl-3 col-md-6 col-lg-3 col_foo">
     <div class="footer_widget">
      <h3 class="footer_title">
       مسیر های پر تردد خارجی از تهران
      </h3>
      <ul class="links double_links">

       {assign 'cities' ['ISTALL' => functions::Xmlinformation('S360ISTALL'),'DXB' => functions::Xmlinformation('S360DXB'),'BON' => functions::Xmlinformation('S360BON'),'SYD' => functions::Xmlinformation('S360SYD'),'DXBALL' => functions::Xmlinformation('S360DXBALL'),'BERALL' => functions::Xmlinformation('S360BERALL'), 'LONALL' => functions::Xmlinformation('S360YXUALL'), 'NJF' => functions::Xmlinformation('S360NJF')]}



       {foreach $cities as $item}
        <li>
         <a href="{$smarty.const.ROOT_ADDRESS}/international/1/IKA-{$item@key}/{$objDate->tomorrow()}/1-0-0">
          ##S360FlightTo## {$item}
         </a>
        </li>
       {/foreach}


      </ul>
     </div>
    </div>
    <div class="col-xl-3 col-md-6 col-lg-3 col_foo foo_contact">
     <div class="address footer_widget">
      <h3 class="footer_title">
       تماس با ما
      </h3>
      <div class="contact_info_text">
       <i class="fas fa-map-marked-alt">
       </i>
       <a class="__address_class__ SMFooterAddress">
        {$smarty.const.CLIENT_ADDRESS}
       </a>
      </div>
      <div class="contact_info_text">
       <i class="fas fa-phone">
       </i>
       <a class="__phone_class__ SMFooterPhone" href="tel:{$smarty.const.CLIENT_PHONE}" target="_top">
        {$smarty.const.CLIENT_PHONE}
       </a>
      </div>
      <div class="contact_info_text">
       <i class="fas fa-phone">
       </i>
       <a class="__mobile_class__ SMFooterPhone" href="tel:{$smarty.const.CLIENT_MOBILE}" target="_top">
        {$smarty.const.CLIENT_MOBILE}
       </a>
      </div>
      <div class="contact_info_text">
       <i class="fas fa-globe">
       </i>
       <a class="SMFooterPhone" href="https://www.parsairtravel.com/" target="_top">
        وب سایت
       </a>
      </div>
      <div class="contact_info_text">
       <i class="fas fa-envelope">
       </i>
       <a class="__email_class__ SMFooterEmail" href="mailto:{$smarty.const.CLIENT_EMAIL}" target="_top">
        {$smarty.const.CLIENT_EMAIL}
       </a>
      </div>
      <div class="contact_info_text">
       <i class="fas fa-ban">
       </i>
       <a href="{$smarty.const.ROOT_ADDRESS}/rules">
        راهنمای خرید و قوانین استرداد
       </a>
      </div>
     </div>
    </div>
    <div class="col-xl-3 col-md-6 col-lg-3 col_foo">
     <div class="col_namads">
{*      <a href="https://www.cao.ir/paxrights" rel="nofollow" target="_blank">*}
{*       <img alt="" src="project_files/images/certificate1.png"/>*}
{*      </a>*}
{*      <a href="https://www.cao.ir/" rel="nofollow" target="_blank">*}
{*       <img alt="" src="project_files/images/certificate2.png"/>*}
{*      </a>*}
{*      <a href="http://aira.ir/images/final3.pdf" rel="nofollow" target="_blank">*}
{*       <img alt="" src="project_files/images/certificate3.png"/>*}
{*      </a>*}
      <a referrerpolicy='origin' target='_blank' href='https://trustseal.enamad.ir/?id=469518&Code=cYKv1aW37BAYSIelcTiSuKuhqYneRDNJ'><img referrerpolicy='origin' src='https://trustseal.enamad.ir/logo.aspx?id=469518&Code=cYKv1aW37BAYSIelcTiSuKuhqYneRDNJ' alt='' style='cursor:pointer' Code='cYKv1aW37BAYSIelcTiSuKuhqYneRDNJ'></a>
{*      <a href="javascript" rel="nofollow" target="_blank">*}
{*       <img alt="" src="project_files/images/samandeh.jpg"/>*}
{*      </a>*}
     </div>
    </div>
    <div class="col-12">
     <div class="last_text">
      <a class="last_a" href="https://www.iran-tech.com/" target="_blank">
       طراحی سایت گردشگری
      </a>
      <p class="last_p_text">
       : ایران تکنولوژی
      </p>
     </div>
    </div>
   </div>
  </div>
 </div>
 {assign var="socialLinks"  value=$about['social_links']|json_decode:true}
                                {assign var="socialLinksArray" value=['telegram'=>'telegramHref','whatsapp'=> 'whatsappHref','instagram' => 'instagramHref','aparat' => 'aparatHref','youtube' => 'youtubeHref','facebook' => 'facebookHref','linkeDin' => 'linkeDinHref']}

                                {foreach $socialLinks as $key => $val}
                                        {assign var=$socialLinksArray[$val['social_media']] value=$val['link']}
                                {/foreach}
 <div class="__social_class__ float-sm">
  <div class="fl-fl float-gp">
   <i class="fab fa-telegram">
   </i>
   <a class="__telegram_class__ SMTelegram" href="{if $telegramHref}{$telegramHref}{/if}" target="_blank">
    به ما ملحق شو!
   </a>
  </div>
  <div class="fl-fl float-rs">
   <i class="fab fa-whatsapp">
   </i>
   <a class="__whatsapp_class__ SMWhatsApp" href="{if $whatsappHref}{$whatsappHref}{/if}" target="_blank">
    تماس با ما!
   </a>
  </div>
  <div class="fl-fl float-ig">
   <i class="fab fa-instagram">
   </i>
   <a class="__instagram_class__ SMInstageram" href="{if $instagramHref}{$instagramHref}{/if}" target="_blank">
    ما رو دنبال کن!
   </a>
  </div>
  <div class="fl-fl float-ph">
   <i class="fas fa-phone">
   </i>
   <a class="__phone_class__ SMInstageram" href="tel:{$smarty.const.CLIENT_PHONE}" target="_blank">
    {$smarty.const.CLIENT_PHONE}
   </a>
  </div>
 </div>
</footer>
                                 <a href="javascript:" id="return-to-top" title="بازگشت به بالا">
                                  <i class="fas fa-arrow-up"></i>
                                 </a>
    {/if}
                            {else}
                                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`pwaFooter.tpl"}
                            {/if}
<div class="modal fade bd-example-modal-lg modal-calender-js" id="calenderBox"
     tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
 <div class="modal-dialog modal-lg modal_center_flight">
  <div class="modal-content modal-content-js">

  </div>
 </div>
</div>