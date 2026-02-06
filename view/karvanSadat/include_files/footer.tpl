{load_presentation_object filename="aboutUs" assign="objAbout"}
{assign var="about"  value=$objAbout->getData()}
{if $smarty.session.layout neq 'pwa'}
    {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}
        <footer class="i_modular_footer">
            <div class="container">
                <div class="justify-content-center">
                    <div class="parent-footer-iran w-100">
                        <div class="item-footer item-footer1">
                            <div class="parent-item-footer parent-item-footer-responsive box-item-footer2">
                                <a class="__logo_class__ nav-header" >
                                    <img alt="img-logo" class="logo" src="project_files/images/logo.png" />
                                    <div class="d-flex flex-column">
                                        <h4>
                                            تجربه زیارتی متفاوت
                                        </h4>
                                        <span>
                                     مجری کاروان‌های گروهی <br> و سفر‌های انفرادی عتبات
                                    </span>
                                    </div>
                                </a>
                                <div class="child-item-footer">
                                <span class="__address_class__">
                                 {$smarty.const.CLIENT_ADDRESS}
                                </span>
                                </div>
                                {assign var='additional_data' value=$smarty.const.ADDITIONAL_DATA|json_decode:true}
                                {foreach $additional_data as $item}
                                    {if $item['type']=='mail'}
                                    <div class="child-item-footer">
                                        <a class="__email_class__ email-footer1" href="mailto:{$item['body']}">
                                            {$item['body']}
                                        </a>
                                    </div>
                                    {/if}
                                {/foreach}
                                <div class="child-item-footer">
                                    <a class="__email_class__ email-footer2" href="mailto:{$smarty.const.CLIENT_EMAIL}">
                                        {$smarty.const.CLIENT_EMAIL}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="parent-footer-iran2">
                            <div class="item-footer item-footer2">
                                <div class="box-item-footer text-right">
                                    <h3>
                                        هتل‌های عراق
                                    </h3>
                                    <ul>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/page/karbala">
                                                رزرو هتل کربلا
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/page/najaf">
                                                رزرو هتل نجف
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/page/Kadhimiya">
                                                رزرو هتل کاظمین
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/page/sameraa">
                                                رزرو هتل سامراء
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="item-footer item-footer3">
                                <div class="parent-namad box-item-footer text-right">
                                    <h3>
                                        دسترسی آسان
                                    </h3>
                                    <ul>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">
                                                کاروان‌ها
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/page/Transfer">
                                                حمل و نقل
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/mag">
                                                وبلاگ
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="item-footer item-footer4">
                                <div class="box-item-footer text-right">
                                    <h3>
                                        درباره ما
                                    </h3>
                                    <ul>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">
                                                چرا کاروان سادات
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/rules">
                                                قوانین و مقررات
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/faq">
                                                پرسش های متداول
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/page/MaaliBox">
                                                معلی باکس
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            <div class="item-footer item-footer5">
                                <div class="box-item-footer text-right contact-footer">
                                    <h3>
                                        تماس با ما
                                    </h3>
                                    <ul>
                                        <li>
                                            <div class="child-item-footer">
                                                تلفن دفتر :
                                                <a class="__phone_class__" href="tel:{$smarty.const.CLIENT_PHONE}">
                                                    {$smarty.const.CLIENT_PHONE}
                                                </a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="child-item-footer">
                                                سفر انفرادی :
                                                <a href="javascript:">
                                                    09129314538
                                                </a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="child-item-footer">
                                                کاروان‌ها :
                                                <a href="javascript:">
                                                    09209314538
                                                </a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="child-item-footer">
                                                واحد فرهنگی :
                                                <a href="javascript:">
                                                    09039314538
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="item-footer item-footer6">
                                <div class="namads my-footer-icon">
                                    <a href="https://farasa.cao.ir/sysworkflow/fa/modern/3810212626028ab03488017019616799/6464336316028ab04e3c618028352200.php">
                                        <img alt="Enamad1" src="project_files/images/certificate1.png" />
                                    </a>
                                    <a href="https://caa.gov.ir/">
                                        <img alt="namad-1" src="project_files/images/certificate2.png" />
                                    </a>
                                    <a href="https://www.aira.ir/">
                                        <img alt="namad-2" src="project_files/images/certificate3.png" />
                                    </a>
                                    <a href="javascript:">
                                        <img alt="namad-2" src="project_files/images/enamad.png" />
                                    </a>
                                    <a id="PPTrust" class='PPTrust'>
                                     <script src="https://statics.payping.ir/trust-v3.js" theme="dark" size="md"></script>
                                     </a>
                                </div>
                            </div>
                            <div class="contactusmobile item-footer8">
                                <div class="d-flex email-mob">
                                    <div class="child-item-footer">
                                        <a class="__email_class__" href="mailto:{$smarty.const.CLIENT_EMAIL}">
                                            {$smarty.const.CLIENT_EMAIL}
                                        </a>
                                    </div>
                                    <div class="child-item-footer">
                                        <a class="__email_class__" href="mailto:{$smarty.const.CLIENT_EMAIL}">
                                            {$smarty.const.CLIENT_EMAIL}
                                        </a>
                                    </div>
                                </div>
                                <div class="child-item-footer">
      <span class="__address_class__ addres-mob">
       {$smarty.const.CLIENT_ADDRESS}
      </span>
                                </div>
                            </div>
                            <div class="item-footer item-footer7">
                                {assign var="socialLinks"  value=$about['social_links']|json_decode:true}

                                {assign var="socialLinksArray" value=['telegram'=>'telegramHref','whatsapp'=> 'whatsappHref','instagram' => 'instagramHref','aparat' => 'aparatHref','youTube' => 'youtubeHref','facebook' => 'facebookHref','linkedin' => 'linkeDinHref' , 'twitter' => 'twitterHref' , 'twitter' => 'twitterHref' , 'bale' => 'baleHref' , 'ita' => 'itaHref']}

                                {foreach $socialLinks as $key => $val}
                                    {assign var=$socialLinksArray[$val['social_media']] value=$val['link']}
                                {/foreach}

                                <div class="__social_class__ social footer-icon my-footer-icon">
                                <span>
                                 در فضای مجازی:
                                </span>
                                    <a class="__telegram_class__" href="{if $telegramHref}{$telegramHref}{/if}"
                                       target="_blank">
                                        <img alt="telegram" src="project_files/images/telegram.png" />
                                    </a>
                                    <a class="__instagram_class__" href="{if $instagramHref}{$instagramHref}{/if}"
                                       target="_blank">
                                        <img alt="instagram" src="project_files/images/instagram.png" />
                                    </a>
                                    <a class="" href="{if $baleHref}{$baleHref}{/if}" target="_blank">
                                        <img alt="bale" src="project_files/images/bale.png" />
                                    </a>
                                    <a class="" href="{if $itaHref}{$itaHref}{/if}" target="_blank">
                                        <img alt="eita" src="project_files/images/eita.png" />
                                    </a>
                                    <a class="__aparat_class__" href="{if $aparatHref}{$aparatHref}{/if}"
                                       target="_blank">
                                        <img alt="aparat" src="project_files/images/aparat.png" />
                                    </a>
                                    <a class="__youtube_class__" href="{if $youtubeHref}{$youtubeHref}{/if}"
                                       target="_blank">
                                        <svg viewbox="0 0 576 512" xmlns="http://www.w3.org/2000/svg">
                                            <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                            <path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z">
                                            </path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="last_text col-12">
                <div class="container">
                    <div class="parent-iran-tech">
                        <p>
                            کپی هر محتوایی از سایت و سوشال مدیای کاروان سادات تنها با مجوز کتبی و ذکر منبع برای مقاصد
                            غیر تجاری امکان پذیر میباشد.
                        </p>
                        <div class="parent-text-iran-tech">
                            <a class="last_a" href="https://www.iran-tech.com/">
                                طراحی سایت گردشگری :
                            </a>
                            <p class="last_p_text">
                                ایران تکنولوژی
                            </p>
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


<div class="float-sm {if $smarty.const.GDS_SWITCH neq 'mainPage' } d-none {/if}">
    <a class="__telegram_class__ fl-fl float-tg" href="{if $telegramHref}{$telegramHref}{/if}">
        <img alt="telegram" src="project_files/images/telegram.png">
        <span>تلگرام</span>
        </img></a>
    <a class="__instagram_class__ fl-fl float-in" href="{if $instagramHref}{$instagramHref}{/if}">
        <img alt="telegram" src="project_files/images/instagram.png">
        <span>اینستاگرام</span>
        </img></a>
    <a class="fl-fl float-gp" href="{if $baleHref}{$baleHref}{/if}">
        <img alt="bale" src="project_files/images/bale.png">
        <span>بله</span>
        </img></a>
    <a class="fl-fl float-rs" href="{if $itaHref}{$itaHref}{/if}">
        <img alt="eita" src="project_files/images/eita.png">
        <span>ایتا</span>
        </img></a>
    <a class="__aparat_class__ fl-fl float-ig" href="{if $aparatHref}{$aparatHref}{/if}">
        <img alt="aparat" src="project_files/images/aparat.png">
        <span>آپارات</span>
        </img></a>
    <a class="__youtube_class__ fl-fl float-iy" href="{if $youtubeHref}{$youtubeHref}{/if}">
        <svg viewbox="0 0 576 512" xmlns="http://www.w3.org/2000/svg">
            <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
            <path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"></path>
        </svg>
        <span>یوتیوب</span>
    </a>
</div>