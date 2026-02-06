
{assign var='AdditionalData' value=$smarty.const.ADDITIONAL_DATA|json_decode:true}
{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{if $smarty.session.layout neq 'pwa'}
    {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}
        <footer>
            <div class="container-fluid">
                <div class="parent-footer-pabpa">
                    <div class="item1-footer-pabpa">
                        <div class="data_phone">
                            <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}" class="footer_logo">
                                <img src="project_files/images/logo-foot.png" alt="loggo-foot">
                            </a>
                            <p class="phone_num">
                                <i class="far fa-phone"></i>
                                <a href="tel:{$smarty.const.CLIENT_PHONE}">{$smarty.const.CLIENT_PHONE}</a>
                            </p>
                            <p class="address_site">
                                <i class="far fa-map-marker"></i>
                                شعبه اول:
                                <span>{$smarty.const.CLIENT_ADDRESS}</span>
                            </p>
                            <p>
                                <i style="font-size: 17px;" class="fal fa-mailbox"></i>
                                کد پستی:
                                <span>1481945567</span>
                            </p>
                            <p class="address_site">
                                <i class="far fa-map-marker"></i>
                                شعبه دوم:
                                <span>Turkey، Van، Serhat m.h timor pasa c.d Kaya Kent A bolok Kat 4 daire 51 van</span>
                            </p>
                            <p class="email_site">
                                <i class="far fa-envelope"></i>
                                {foreach key=key item=item from=$AdditionalData}

                                        <a href="mailto:{$smarty.const.CLIENT_EMAIL}">
                                            {if $item.title eq 'ایمیل:'}
                                                {$item.body}
                                            {/if}

                                            {if $item.title eq 'شماره واتس‌آپ و تلگرام:'}
                                                    {$item.title} {$item.body}
                                            {/if}
                                        </a>
                                {/foreach}
                            </p>
                        </div>
                    </div>
                    <div class="item2-footer-pabpa">
                        <div class="item_footer">
                            <h4>
                                تورهای چارتری پا به پا سفر
                            </h4>
                            <ul class="">
                                {assign var="internal_tour_params" value=['type'=>'','limit'=> '10','dateNow' => $dateNow,'category' => '4']}
                                {assign var='internalTours' value=$obj_main_page->getToursReservation($internal_tour_params)}
                                {foreach key=key_tour item=item_tour from=$internalTours}
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item_tour['id_same']}/{$item_tour['tour_slug']}">
                                            {$item_tour['tour_name']}
                                        </a>
                                    </li>
                                {/foreach}

                            </ul>
                        </div>
                    </div>
                    <div class="item3-footer-pabpa">
                        <div class="item_footer">
                            <h4>اطلاعات مفید</h4>
                            <ul class="">

                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/Comprehensive-information">اطلاعات جامع روادید یا ویزا     </a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/types-of-classes">انواع کلاس های پروازی    </a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/curfew-inquiry">استعلام ممنوع الخروجی     </a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/purchase-tickets">خرید اینترنتی بلیط هواپیما      </a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/Documents-passport">مدارک لازم برای پاسپورت   </a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/visa-information">تمام اطلاعات ویزای شنگن   </a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/Charter-concept">مفهوم بلیت چارتر </a></li>

                            </ul>
                        </div>
                    </div>
                    <div class="item4-footer-pabpa">
                        <div class="item_footer">
                            <h4>اطلاعات گردشگری</h4>
                            <ul>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/System-information">اطلاعات پروازهای سیستمی و چارتری   </a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/without-visa">بدون ویزا به کدام کشورها سفر کنیم  </a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/baggage-rules">قوانین بار مسافر  </a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/addresses-embassies">آدرس و تلفن سفارتخانه ها در ایران  </a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/status-crossing">مدارک لازم جهت تمدید صدور گذرنامه</a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/Fees-leaving"> عوارض خروج از کشور    </a></li>
                                <li><a href="{$smarty.const.ROOT_ADDRESS}/page/Terminals-Mehrabad">ترمینال های فرودگاه مهر آباد تهران </a></li>                            </ul>
                        </div>
                    </div>
                    <div class="item5-footer-pabpa">
                        <div class="item_footer">

                            <div class="footer_icons">
                                {foreach $socialLinks as $key => $socialMedia}
                                    {if $socialMedia['social_media'] == 'youTube'}
                                        <a href="{$socialMedia['link']}" class="fa-brands fa-youtube footer_youtube"></a>
                                    {/if}
                                    {if $socialMedia['social_media'] == 'twitter'}
                                        <a href="{$socialMedia['link']}" class="fa-brands fa-twitter footer_twitter"></a>
                                    {/if}
                                    {if $socialMedia['social_media'] == 'linkedin'}
                                        <a href="{$socialMedia['link']}" class="fa-brands fa-linkedin-in footer_linkdin"></a>
                                    {/if}
                                    {if $socialMedia['social_media'] == 'aparat'}
                                        <a href="{$socialMedia['link']}" class="fa footer_aparat">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="48px" height="48px"><path d="M 15.173828 2.609375 C 11.917119 2.5264688 8.94875 4.7335781 8.1875 8.0332031 L 7.078125 12.837891 C 10.172125 7.7938906 15.497719 4.4664844 21.386719 3.8964844 L 16.582031 2.7871094 C 16.110656 2.6782344 15.639072 2.6212187 15.173828 2.609375 z M 23.615234 7 C 16.369702 7.1611924 9.7609531 11.980828 7.6582031 19.314453 C 5.0702031 28.340453 10.289453 37.753797 19.314453 40.341797 C 28.339453 42.929797 37.753797 37.711547 40.341797 28.685547 C 42.929797 19.659547 37.711547 10.246203 28.685547 7.6582031 C 26.993172 7.1729531 25.28728 6.9628018 23.615234 7 z M 35.162109 7.078125 C 40.206109 10.172125 43.533516 15.497719 44.103516 21.386719 L 45.212891 16.582031 C 46.083891 12.811031 43.737797 9.0575 39.966797 8.1875 L 35.162109 7.078125 z M 20.191406 12.589844 C 20.456244 12.610334 20.723031 12.658375 20.988281 12.734375 C 23.111281 13.342375 24.338469 15.556687 23.730469 17.679688 C 23.122469 19.802687 20.906203 21.029875 18.783203 20.421875 C 16.660203 19.813875 15.433969 17.599562 16.042969 15.476562 C 16.575844 13.618937 18.337541 12.446412 20.191406 12.589844 z M 31.726562 15.898438 C 31.991494 15.918996 32.258063 15.966844 32.523438 16.042969 C 34.646437 16.650969 35.874625 18.865281 35.265625 20.988281 C 34.657625 23.110281 32.441359 24.338469 30.318359 23.730469 C 28.195359 23.122469 26.968172 20.908156 27.576172 18.785156 C 28.108172 16.927531 29.872041 15.754527 31.726562 15.898438 z M 24.035156 22.001953 C 25.139156 22.020953 26.017047 22.930156 25.998047 24.035156 C 25.979047 25.139156 25.069844 26.017047 23.964844 25.998047 C 22.860844 25.979047 21.982953 25.069844 22.001953 23.964844 C 22.020953 22.860844 22.930156 21.982953 24.035156 22.001953 z M 16.884766 24.126953 C 17.149697 24.147443 17.416266 24.193531 17.681641 24.269531 C 19.804641 24.877531 21.032828 27.093797 20.423828 29.216797 C 19.814828 31.339797 17.598563 32.566031 15.476562 31.957031 C 13.353562 31.349031 12.125375 29.134719 12.734375 27.011719 C 13.266375 25.154094 15.030244 23.983521 16.884766 24.126953 z M 3.8964844 26.615234 L 2.7871094 31.419922 C 1.9171094 35.190922 4.2622031 38.943453 8.0332031 39.814453 L 12.837891 40.923828 C 7.7948906 37.829828 4.4664844 32.504234 3.8964844 26.615234 z M 28.417969 27.433594 C 28.6829 27.454084 28.951422 27.502125 29.216797 27.578125 C 31.339797 28.186125 32.566031 30.400437 31.957031 32.523438 C 31.348031 34.646437 29.134719 35.873625 27.011719 35.265625 C 24.888719 34.657625 23.661531 32.443313 24.269531 30.320312 C 24.801531 28.462687 26.563447 27.290162 28.417969 27.433594 z M 40.923828 35.162109 C 37.829828 40.205109 32.504234 43.533516 26.615234 44.103516 L 31.419922 45.212891 C 35.190922 46.082891 38.943453 43.737797 39.814453 39.966797 L 40.923828 35.162109 z"/></svg>
                                        </a>
                                    {/if}
                                    {if $socialMedia['social_media'] == 'instagram'}
                                        <a href="{$socialMedia['link']}" class="fab fa-instagram footer_instagram"></a>
                                    {/if}
                                    {if $socialMedia['social_media'] == 'whatsapp'}
                                        <a href="{$socialMedia['link']}" class="fab fa-whatsapp footer_whatsapp"></a>
                                    {/if}
                                    {if $socialMedia['social_media'] == 'telegram'}
                                        <a href="{$socialMedia['link']}" class="fa fa-paper-plane footer_telegram"></a>
                                    {/if}
                                {/foreach}

                            </div>
                        </div>
                    </div>
                </div>
                <div class="parent-namad">
                    <h4>
                        مجوزها و نماد اعتماد
                    </h4>
                    <div class="namads">
                        <!--

                        <a href="https://farasa.cao.ir/sysworkflow/fa/modern/3810212626028ab03488017019616799/6464336316028ab04e3c618028352200.php"><img src="project_files/images/certificate1.png" alt="Enamad1"></a>
-->

                        <a href="https://caa.gov.ir/"><img src="project_files/images/certificate2.png" alt="namad-1"></a>

                        <!--
                        <a href="http://www.aira.ir/"><img src="project_files/images/certificate3.png" alt="namad-2"></a>
-->

                        <a referrerpolicy="origin" target="_blank" href="https://trustseal.enamad.ir/?id=319257&Code=s0gsmErE62RFJCiWQwLc"><img referrerpolicy="origin" src="https://Trustseal.eNamad.ir/logo.aspx?id=319257&Code=s0gsmErE62RFJCiWQwLc" alt="" style="cursor:pointer" id="s0gsmErE62RFJCiWQwLc"></a>
                        <a href="https://tehran.mcth.ir/">
                            <img src="project_files/images/province-tehran-logo.png" alt="ershad">
                        </a>
                        <a class="cursor-pointer">
                            <img referrerpolicy='origin' id = 'rgvjwlaowlaojxlzoeukfukz' style = 'cursor:pointer' onclick = 'window.open("https://logo.samandehi.ir/Verify.aspx?id=344186&p=xlaoaodsaodsrfthmcsigvka", "Popup","toolbar=no, scrollbars=no, location=no, statusbar=no, menubar=no, resizable=0, width=450, height=630, top=30")' alt = 'logo-samandehi' src = 'https://logo.samandehi.ir/logo.aspx?id=344186&p=qftishwlshwlnbpdaqgwwlbq' />
                        </a>

                        <a href="https://ecunion.ir/">
                            <img src="project_files/images/etehadiye.png" alt="etehadiye">
                        </a>

                        <!--

                        <a href="https://www.iata.org/">
                            <img src="project_files/images/IATA_Logo.png" alt="IATA_Logo">
                        </a>



                        <a href="http://e-tourism.ir/fa/home.php">
                            <img src="project_files/images/etourism.jpg" alt="etehadiye">
                        </a>
                        <a href="https://sadadpsp.ir/tollpayment">
                            <img src="project_files/images/sadad_logo.png" alt="etehadiye">
                        </a>
                        <a href="https://www.tccim.ir/">
                            <img src="project_files/images/logo-header.png" alt="etehadiye">
                        </a>
                        <a href="https://tehran.irannsr.org/fa/index.php">
                            <img src="project_files/images/headerLogo.png" alt="etehadiye">
                        </a>
                        <a href="https://eanjoman.ir/">
                            <img src="project_files/images/anjoman-main-logo.png" alt="etehadiye">
                        </a>
                        <a href="https://www.rai.ir/">
                            <img src="project_files/images/RAI-logo.png" alt="namad-2">
                        </a>
                        <a href="https://www.haj.ir/">
                            <img src="project_files/images/hajArm.png" alt="namad-2">
                        </a>

                        -->
                    </div>
                </div>
            </div>

            <div class="footer-bottom">

                <div class="right-text">
                    کلیه حقوق این وب سایت متعلق به آژانس مسافرتی پا به پا سفر می باشد.
                </div>
                <div class="left-text">
                    <a href="https://iran-tech.com" target="_blank">طراحی سایت گردشگری : </a>ایران تکنولوژی
                </div>

            </div>
{*            <div class="col-6">*}
{*                <p class="last_text01">*}
{*                    کلیه حقوق این وب سایت متعلق به آژانس مسافرتی پا به پا سفر می باشد.*}
{*                </p>*}
{*            </div>*}

{*            <div class="last_text col-6">*}
{*                <a class="last_a" href="https://www.iran-tech.com/">طراحی سایت گردشگری</a>*}
{*                <p class="last_p_text">: ایران تکنولوژی</p>*}
{*            </div>*}



            <a href="javascript:" class="fixicone fa fa-angle-up" id="scroll-top" style=""></a>
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
