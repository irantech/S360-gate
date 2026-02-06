{load_presentation_object filename="aboutUs" assign="objAbout"}
                            {assign var="about"  value=$objAbout->getData()}
                            {if $smarty.session.layout neq 'pwa'}
                                {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}

                                 <footer class="footer">
                                  <div class="footer_top">
                                   <div class="container">
                                    <div class="row">
                                     <div class="col-lg-3 col-md-6 col_foo">
                                      <div class="footer_widget">
                                       <h3 class="footer_title">
                                        معرفی
                                       </h3>
                                       <ul class="links double_links">
                                        <li>
                                         <a href="https://gardima.ir/blog">مجله گردیما </a>
                                        </li>
                                        <li>
                                         <a href="javascript:">چرا گردیما</a>
                                        </li>
                                        <li>
                                         <a href="javascript:">تماس باما </a>
                                        </li>
                                        <li>
                                         <a href="javascript:">درباره‌ ما </a>
                                        </li>
                                       </ul>
                                      </div>
                                      <div class="footer_widget">
                                       <h3 class="footer_title">
                                        خدمات مشتریان
                                       </h3>
                                       <ul class="links double_links">
                                        <li>
                                         <a href="https://gardima.ir/support ">مرکز پشتیبانی آنلاین</a>
                                        </li>
                                        <li>
                                         <a href="https://gardima.ir/why-gardima">چرا گردیما؟</a>
                                        </li>
                                        <li>
                                         <a href="https://gardima.ir/contact-us">تماس باما</a>
                                        </li>
                                        <li>
                                         <a href="https://gardima.ir/about-us">درباره‌ ما</a>
                                        </li>
                                       </ul>
                                      </div>
                                     </div>
                                     <div class="col-lg-3 col-md-6 col_foo">
                                      <div class="footer_widget">
                                       <h3 class="footer_title">
                                        اطلاعات تکمیلی
                                       </h3>
                                       <ul class="links double_links">
                                        <li>
                                         <a href="https://gardima.ir/businesses">فروش سازمانی</a>
                                        </li>
                                        <li>
                                         <a href="https://gardima.ir/partner">همکاری با آژانس‌ها</a>
                                        </li>
                                        <li>
                                         <a href="https://gardima.ir/jobs">فرصت های شغلی</a>
                                        </li>
                                        <li>
                                         <a href="https://gardima.ir/evaluate">سنجش رضایتمندی</a>
                                        </li>
                                       </ul>
                                      </div>
                                     </div>
                                     <div class="col-lg-3 col-md-6 col_foo">
                                      <div class="footer_widget">
                                       <h3 class="footer_title">
                                        اطلاعات تماس
                                       </h3>
                                       <ul class="links double_links">
                                        <li>
                                         <a href="tel:۰۲۱۹۱۶۹۱۱۳۵">تلفن پشتیبانی : ۰۲۱۹۱۶۹۱۱۳۵</a>
                                        </li>
                                       </ul>
                                      </div>
                                     </div>
                                     <div class="col-lg-3 col-md-6 col_foo d-flex align-items-end">
                                      <div class="col_namads">
                                       <a target="_blank" rel="nofollow" href="https://caa.gov.ir/">
                                        <img src="project_files/images/certificate2.png" alt="img-namad">
                                       </a>
                                       <a target="_blank" rel="nofollow" href="jhttp://www.aira.ir/">
                                        <img src="project_files/images/certificate3.png" alt="img-namad">
                                       </a>
                                       <a target="_blank" rel="nofollow" href="https://farasa.cao.ir/sysworkflow/fa/modern/3810212626028ab03488017019616799/6464336316028ab04e3c618028352200.php">
                                        <img src="project_files/images/certificate1.png" alt="img-namad">
                                       </a>
                                       <a target="_blank" rel="nofollow" href="https://logo.samandehi.ir/Verify.aspx?id=33643&p=xlaoxlaogvkaaodsxlao">
                                        <img src="project_files/images/samandehi-6e2b448a.png" alt="img-namad">
                                       </a>
                                      </div>
                                     </div>
                                    </div>
                                   </div>
                                  </div>
                                  <div class="copy-right_text">
                                   <div class="container">
                                    <div class="row">
                                     <div class="col-xl-12 d-flex flex-wrap flex-row justify-content-between align-items-center">
                                      <div class="copyright_content d-flex flex-row justify-content-center">
                                       کلیه حقوق این سرویس (وب‌سایت و اپلیکیشن‌های موبایل) محفوظ و متعلق به شرکت گردیما می‌باشد
                                      </div>
                                      <div class="mt-2 mt-lg-0 copyright_content d-flex flex-row justify-content-center">
                                       <a href="https://www.iran-tech.com/" target="_blank">
                                        طراحی سایت آژانس گردشگری
                                       </a> : ایران تکنولوژی
                                      </div>
                                     </div>
                                    </div>
                                   </div>
                                  </div>
                                 </footer>

    {/if}
                            {else}
                                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`pwaFooter.tpl"}
                            {/if}