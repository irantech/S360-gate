{load_presentation_object filename="aboutUs" assign="objAbout"}
{assign var="about"  value=$objAbout->getData()}
{if $smarty.session.layout neq 'pwa'}
    {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}
        <footer class="i_modular_footer">
            <div class="but-top" id="scroll-top" style="display: block;">
                <a class="fa fa-angle-up" href="javascript:">
                </a>
            </div>
            <div class="container-fluid">
                <div class='row'>
                <div class="col-xl-5 col-lg-6 my-4 col-md-12 col-12 callUs">
                    <h6>
                        تماس با ما
                    </h6>
                    <div class='callUs-grid'>
                        <p>
                            <i class="fa-light fa-location-dot"></i>
                            <span class="__address_class__ address-class-footer">آدرس شعبه اول : {$smarty.const.CLIENT_ADDRESS}</span>
                        </p>
                        <p>
                            <i class="fa-light fa-location-dot"></i>
                            <span class="__address_class__ address-class-footer">آدرس شعبه دوم : بوشهر ، بندر دیر ، بلوار خلیج فارس (ساحلی)، ساختمان آریا، طبقه اول واحد یک</span>
                        </p>
                    <a href="tel:02122000092">
                        <i class="fa-light fa-phone-flip">
                        </i>
                        تلفن شعبه اول :
                        <span class="__phone_class__" href="tel:{$smarty.const.CLIENT_PHONE}">
                         {$smarty.const.CLIENT_PHONE}
                        </span>
                    </a>
                    <a href="tel:07735429002">
                        <i class="fa-light fa-phone-flip">
                        </i>
                        تلفن شعبه دوم :
                        <span class="__phone_class__" href="tel:07735429002">
                        07735429002
                        </span>
                    </a>
                        <div class='__social_class__ social'>
                            {*                        <a href='{if $whatsappHref}{$whatsappHref}{/if}' class='__whatsapp_class__'>*}
                            {*                            <img src='project_files/images/Whatsapp.png' alt='Whatsapp'>*}
                            {*                        </a>*}
                            <a href=' https://wa.me/989039038884' class=''>
                                <img src='project_files/images/Whatsapp.png' alt='Whatsapp'>
                            </a>
                            <a href='{if $telegramHref}{$telegramHref}{/if}' class='__telegram_class__'>
                                <img src='project_files/images/telegram.png' alt='telegram'>
                            </a>
                            <a href='{if $itaHref}{$itaHref}{/if}' class=''>
                                <img src='project_files/images/eita.png' alt='eita'>
                            </a>
                            <a href='{if $baleHref}{$baleHref}{/if}' class=''>
                                <img src='project_files/images/bale.png' alt='bale'>
                            </a>
                            <a href='{if $instagramHref}{$instagramHref}{/if}' class='__instagram_class__'>
                                <img src='project_files/images/instagram.png' alt='instagram'>
                            </a>
                        </div>
                        <a href="mailto:hadimeydari@gmail.com">
                        <i class="fa-light fa-envelope">
                        </i>
                        ایمیل :
                        <span class="__email_class__" href="mailto:{$smarty.const.CLIENT_EMAIL}">
                         {$smarty.const.CLIENT_EMAIL}
                        </span>
                    </a>
                    </div>
                    {assign var="socialLinks"  value=$about['social_links']|json_decode:true}
                    {assign var="socialLinksArray" value=['telegram'=>'telegramHref','whatsapp'=> 'whatsappHref','instagram' => 'instagramHref','aparat' => 'aparatHref','youTube' => 'youtubeHref','facebook' => 'facebookHref','linkedin' => 'linkeDinHref' , 'twitter' => 'twitterHref' , 'twitter' => 'twitterHref' , 'bale' => 'baleHref' , 'ita' => 'itaHref']}

                    {foreach $socialLinks as $key => $val}
                        {assign var=$socialLinksArray[$val['social_media']] value=$val['link']}
                    {/foreach}

                </div>
                <div class="col-xl-4 col-lg-6 my-4 col-md-12 col-12 list_foo">
                    <div class='row'>
                        <div class="col-lg-12 my-4 col-md-6 col-12 list_foo2">
                            <h6>
                                خدمات ما
                            </h6>
                            <div class="list_foo2_a">
                                <a href="{$smarty.const.ROOT_ADDRESS}/page/flight">
                                    <i class="fa-solid fa-circle">
                                    </i>
                                    پرواز
                                </a>
                                <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">
                                    <i class="fa-solid fa-circle">
                                    </i>
                                    تور
                                </a>
                                <a href="{$smarty.const.ROOT_ADDRESS}/page/hotel">
                                    <i class="fa-solid fa-circle">
                                    </i>
                                    هتل
                                </a>
                                <a href="{$smarty.const.ROOT_ADDRESS}/page/bus">
                                    <i class="fa-solid fa-circle">
                                    </i>
                                    اتوبوس
                                </a>
                                <a href="{$smarty.const.ROOT_ADDRESS}/page/insurance">
                                    <i class="fa-solid fa-circle">
                                    </i>
                                    بیمه
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-12 my-4 col-md-6 col-12 list_foo">
                            <h6>
                                دسترسی آسان
                            </h6>
                            <div class="list_foo2_a">
                                <a href="{$smarty.const.ROOT_ADDRESS}/mag">
                                    <i class="fa-solid fa-circle">
                                    </i>
                                    وبلاگ
                                </a>
                                <a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">
                                    <i class="fa-solid fa-circle">
                                    </i>
                                    درباره ما
                                </a>
                                <a href="{$smarty.const.ROOT_ADDRESS}/contactUs">
                                    <i class="fa-solid fa-circle">
                                    </i>
                                    تماس با ما
                                </a>
                                <a href="{$smarty.const.ROOT_ADDRESS}/rules">
                                    <i class="fa-solid fa-circle">
                                    </i>
                                    قوانین و مقررات
                                </a>
                                <a href="{$smarty.const.ROOT_ADDRESS}/UserTracking">
                                    <i class="fa-solid fa-circle">
                                    </i>
                                    پیگیری خرید
                                </a>
                                <a href="{$smarty.const.ROOT_ADDRESS}/authenticate">
                                    <i class="fa-solid fa-circle">
                                    </i>
                                    باشگاه مشتریان
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-12 my-xl-4 col-md-12 col-12 d-flex flex-xl-column flex-sm-row flex-column justify-content-around">
                    <div class='logo-footer'>
                        <a href=''>
                            <img src='project_files/images/logo-footer.png' alt='logo-footer'>
                        </a>
                        <a href=''>
                            <img src='project_files/images/logo-footer-siraf.png' alt='logo-footer'>
                        </a>
                    </div>
                    <div class='d-flex flex-column align-items-start'>
                    <h6>
                        مجوزها
                    </h6>
                    <div class="nameds">
                        <a href="https://farasa.cao.ir/sysworkflow/fa/modern/3810212626028ab03488017019616799/6464336316028ab04e3c618028352200.php"
                           target="_blank">
                            <img alt="paxrights" src="project_files/images/certificate1.png" />
                        </a>
                        <a href="https://caa.gov.ir/" target="_blank">
                            <img alt="cao" src="project_files/images/certificate5.png" />
                        </a>
                        <a referrerpolicy='origin' target='_blank' href='https://trustseal.enamad.ir/?id=532115&Code=CbIhl01cg2Efej5jAaYnqu4Ou2S9kvUi'><img referrerpolicy='origin' src='https://trustseal.enamad.ir/logo.aspx?id=532115&Code=CbIhl01cg2Efej5jAaYnqu4Ou2S9kvUi' alt='' style='cursor:pointer' code='CbIhl01cg2Efej5jAaYnqu4Ou2S9kvUi'></a>
                        <a href="http://www.aira.ir/" title="تست">
                            <img alt="certificate4" src="project_files/images/certificate4.png" />
                        </a>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="w-100">
                <div class="copyright">
                    <div class="container">
                        <div class="copy-child">
     <span class="ahvazgasht">
      <i class="fa fa-copyright">
      </i>
      تمامی حقوق برای آژانس مسافرتی فلای بوشهر محفوظ است
     </span>
                            <span>
      <a href="https://www.iran-tech.com/" target="_blank">
       طراحی و توسعه سایتهای گردشگری
      </a>
      : ایران تکنولوژی
     </span>
                        </div>
                    </div>
                </div>
            </div>
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