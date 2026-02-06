
{if $smarty.session.layout neq 'pwa'}
    {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}
        <footer class="i_modular_footer position-relative">
            <img alt="img" class="top-footer" src="project_files/images/top-footer.png" />
            <div class="but-top" id="scroll-top" style="display: block;">
                <a class="fa fa-angle-up" href="javascript:">
                </a>
            </div>
            <div class="container">
                <div class='parent-footer'>
                <div class="callUs">
                    <h6>
                        تماس با ما
                    </h6>
                    <a class="__phone_class__ SMFooterPhone" href="tel:{$smarty.const.CLIENT_PHONE}">
                        <i class="fa-light fa-phone-flip"></i>
                        {$smarty.const.CLIENT_PHONE}
                    </a>
                    <a class="__email_class__ SMFooterEmail" href="mailto:{$smarty.const.CLIENT_EMAIL}">
                        <i class="fa-light fa-envelope"></i>
                        {$smarty.const.CLIENT_EMAIL}
                    </a>
                    <p class="__address_class__ SMFooterAddress">
                        <i class="fa-light fa-location-dot"></i>
                        {$smarty.const.CLIENT_ADDRESS}
                    </p>
                </div>
                <div class="list_foo position-relative">
                    <h6>
                        دسترسی آسان
                    </h6>
                    <div class="list_foo2_a">
{*                        <a href="{$smarty.const.ROOT_ADDRESS}/gallery">*}
{*                            <i class="fa-light fa-angle-left">*}
{*                            </i>*}
{*                            گالری*}
{*                        </a>*}
                        <div class="my-div" href="javascript:">
                            <i class="fa-light fa-angle-left">
                            </i>
                            مرکز پشتیبانی آنلاین
                        </div>
                        <a href="{$smarty.const.ROOT_ADDRESS}/contactUs">
                            <i class="fa-light fa-angle-left">
                            </i>
                            انتقادات و پیشنهادات
                        </a>
                        <a href="{$smarty.const.ROOT_ADDRESS}/page/BankCardsCompany">
                            <i class="fa-light fa-angle-left">
                            </i>
                            کارت های بانکی شرکت
                        </a>
                        <a href="{$smarty.const.ROOT_ADDRESS}/page/FlightReservationTraining">
                            <i class="fa-light fa-angle-left">
                            </i>
                            آموزش رزرو پرواز
                        </a>
                    </div>
                    <div class="parent-drop">
                        <a class="__phone_class__ drop-link-phone" href="tel:{$smarty.const.CLIENT_PHONE}">
                            {$smarty.const.CLIENT_PHONE}
                        </a>
                        <a class="__mobile_class__ drop-link-phone" href="tel:{$smarty.const.CLIENT_MOBILE}">
                            {$smarty.const.CLIENT_MOBILE}
                        </a>
                    </div>

                   <div class="parent-drop">
                    <a href="tel:{$smarty.const.CLIENT_PHONE}" class="__phone_class__ drop-link-phone">
                     <span>خدمات تلفنی :</span>
                     <span>{$smarty.const.CLIENT_PHONE}</span>
                    </a>
                    <a href="tel:{$smarty.const.CLIENT_MOBILE}" class="__mobile_class__ drop-link-phone">
                     <span>درخواست پشتیبانی :</span>
                     <span>{$smarty.const.CLIENT_MOBILE}</span>
                    </a>
                   </div>

                </div>
                <div class="list_foo2">
                    <h6>
                        سایر لینک ها
                    </h6>
                    <div class="list_foo2_a">
                     <a href="https://my.ssaa.ir/portal/executive/inquery-exitban" target='_blank'>
                      <i class="fa-light fa-angle-left"></i>
                      استعلام ممنوع الخروجی
                     </a>
                     <a href="https://mehrabad.airport.ir/69" target='_blank'>
                      <i class="fa-light fa-angle-left"></i>
                      ترمینال‌های فرودگاه مهرآباد
                     </a>
                     <a href="https://sadadpsp.ir/tollpayment" target='_blank'>
                      <i class="fa-light fa-angle-left"></i>
                      عوارض خروج از کشور
                     </a>
                     <a href="{$smarty.const.ROOT_ADDRESS}/rules">
                      <i class="fa-light fa-angle-left"></i>
                      قوانین و مقررات
                     </a>
{*                        <a href="{$smarty.const.ROOT_ADDRESS}/recommendation">*}
{*                            <i class="fa-light fa-angle-left"></i>*}
{*                            سفرنامه*}
{*                        </a>*}
                   </div>
                </div>
                <div>
                    <h6>
                        مجوزها
                    </h6>
                    <div class="nameds">
                        <a href="https://www.cao.ir/paxrights" target="_blank">
                            <img alt="paxrights" src="project_files/images/certificate1.png" />
                        </a>
                        <a href="https://cao.ir/" target="_blank">
                            <img alt="cao" src="project_files/images/certificate5.png" />
                        </a>
                        <a href="https://trustseal.enamad.ir/?id=16186&amp;Code=wKP2pa9ga1xQhfQv8bLJ%22%3E"
                           referrerpolicy="origin" target="_blank">
                            <img alt="" id="wKP2pa9ga1xQhfQv8bLJ" referrerpolicy="origin"
                                 src="https://trustseal.enamad.ir/logo.aspx?id=16186&amp;Code=wKP2pa9ga1xQhfQv8bLJ"
                                 style="cursor:pointer" />
                        </a>
                        <a href="javascript:" title="تست">
                            <img alt="certificate4" src="project_files/images/certificate4.png" />
                        </a>
                    </div>
                </div>
                </div>
            </div>
            <div class="w-100 mt-5">
                <div class="copyright">
                    <div class="container">
                        <div class="copy-child">
                             <span class="ahvazgasht">
                              <i class="fa fa-copyright">
                              </i>
                              تمامی حقوق برای آژانس مسافرتی منشور صلح پارسیان است
                             </span>
                                                    <span>
                              <a href="https://www.iran-tech.com/" target="_blank">
                               طراحی سایت گردشگری
                              </a>
                              : ایران تکنولوژی
                             </span>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    {/if}
{else}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`pwaFooter.tpl"}
{/if}