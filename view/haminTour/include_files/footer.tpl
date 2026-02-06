{load_presentation_object filename="aboutUs" assign="objAbout"}
{assign var="about"  value=$objAbout->getData()}



{if $smarty.session.layout neq 'pwa'}
    {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}
        <footer class="footer">
            <div class="top-banner">
                <div class="banner-left">
                    <p>مع خدمات "همینتور" على مدار 24 ساعة وطوال أيام الأسبوع. كونوا معنا دائماً</p>
                </div>
                <div class="banner-right">
                    <p>الرد على مدار ٢٤ ساعة</p>
                </div>
            </div>
            <div class="container-fluid">
                <div class="footer-content">
                    <div class="footer-logo-section">
                        <div class="parent-about-namad">
                            <div class="col-lg-7 col-md-12 col-sm-12 col-12 logo-container">
                                <a href="https://hamintour.com">
                                    <img src="project_files/images/logo.png" alt="Hamintour Logo" class="hamintour-logo">
                                </a>
                                <p class="footer-description">
                                    موقع "همینتور" هو أحد المواقع الإلكترونية الرائدة في تقديم خدمات متنوعة للمسافرين والزوار إلى إيران. يقدم الموقع مجموعة واسعة من الخدمات التي تلبي احتياجات العملاء المختلفين بشكل احترافي ومع أسعار تنافسية، مما يجعله خياراً مفضلاً للكثيرين.
                                </p>
                            </div>
                            <div class="col-lg-5 col-md-12 col-sm-12 col-12 namad">
                                <div class="owl-carousel owl-theme owl-footer">
                                    <div class="item">
                                        <img src="project_files/images/certificate_two.png" alt="img-namad">
                                    </div>
                                    <div class="item">
                                        <img src="project_files/images/certificate_three.png" alt="img-namad">
                                    </div>
                                    <div class="item">
                                        <img src="project_files/images/certificate_one.png" alt="img-namad">
                                    </div>
                                    <div class="item">
                                        <img src="project_files/images/certificate_95.png" alt="img-namad">
                                    </div>
                                </div>
                            </div>
                        </div>
                        {assign var="socialLinks"  value=$about['social_links']|json_decode:true}
                        {assign var="socialLinksArray" value=['telegram'=>'telegramHref','whatsapp'=> 'whatsappHref','instagram' => 'instagramHref','aparat' => 'aparatHref','youTube' => 'youtubeHref','facebook' => 'facebookHref','linkedin' => 'linkeDinHref' , 'twitter' => 'twitterHref']}

                        {foreach $socialLinks as $key => $val}
                            {assign var=$socialLinksArray[$val['social_media']] value=$val['link']}
                        {/foreach}
                        <div class="social-icons col-lg-5 p-0">
                            <p>كونوا معنا</p>
                            <div class="parent-social-icons">
                                <a href="{if $twitterHref}{$twitterHref}{/if}" class="social-icon">
                                    <svg class="e-font-icon-svg e-fab-twitter" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path></svg>
                                </a>
                                <a href="{if $whatsappHref}{$whatsappHref}{/if}" class="social-icon">
                                    <svg class="e-font-icon-svg e-fab-whatsapp" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"></path></svg>
                                </a>
                                <a href="{if $telegramHref}{$telegramHref}{/if}" class="social-icon">
                                    <svg class="e-font-icon-svg e-fab-telegram" viewBox="0 0 496 512" xmlns="http://www.w3.org/2000/svg"><path d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm121.8 169.9l-40.7 191.8c-3 13.6-11.1 16.9-22.4 10.5l-62-45.7-29.9 28.8c-3.3 3.3-6.1 6.1-12.5 6.1l4.4-63.1 114.9-103.8c5-4.4-1.1-6.9-7.7-2.5l-142 89.4-61.2-19.1c-13.3-4.2-13.6-13.3 2.8-19.7l239.1-92.2c11.1-4 20.8 2.7 17.2 19.5z"></path></svg>
                                </a>
                                <a href="javascript:" class="social-icon">
                                    <svg class="e-font-icon-svg e-fab-pinterest" viewBox="0 0 496 512" xmlns="http://www.w3.org/2000/svg"><path d="M496 256c0 137-111 248-248 248-25.6 0-50.2-3.9-73.4-11.1 10.1-16.5 25.2-43.5 30.8-65 3-11.6 15.4-59 15.4-59 8.1 15.4 31.7 28.5 56.8 28.5 74.8 0 128.7-68.8 128.7-154.3 0-81.9-66.9-143.2-152.9-143.2-107 0-163.9 71.8-163.9 150.1 0 36.4 19.4 81.7 50.3 96.1 4.7 2.2 7.2 1.2 8.3-3.3.8-3.4 5-20.3 6.9-28.1.6-2.5.3-4.7-1.7-7.1-10.1-12.5-18.3-35.3-18.3-56.6 0-54.7 41.4-107.6 112-107.6 60.9 0 103.6 41.5 103.6 100.9 0 67.1-33.9 113.6-78 113.6-24.3 0-42.6-20.1-36.7-44.8 7-29.5 20.5-61.3 20.5-82.6 0-19-10.2-34.9-31.4-34.9-24.9 0-44.9 25.7-44.9 60.2 0 22 7.4 36.8 7.4 36.8s-24.5 103.8-29 123.2c-5 21.4-3 51.6-.9 71.2C65.4 450.9 0 361.1 0 256 0 119 111 8 248 8s248 111 248 248z"></path></svg>
                                </a>
                                <a href="{if $instagramHref}{$instagramHref}{/if}" class="social-icon">
                                    <svg class="e-font-icon-svg e-fab-instagram" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="footer-links">
                        <div class="col-lg-8">
                            <div class="parent-items-links">
                                <div class="items-links">
                                    <h3>خدماتنا</h3>
                                    <ul>
                                        <li><a href="https://hamintour.com/#">حجز الإقامة</a></li>
                                        <li><a href="https://hamintour.com/#">حجز الفندق</a></li>
                                        <li><a href="https://hamintour.com/#">متابعة الحجز</a></li>
                                        <li><a href="https://hamintour.com/#">الأخبار والمعلومات</a></li>
                                        <li><a href="https://hamintour.com/#">عنّا</a></li>
                                    </ul>
                                </div>
                                <div class="items-links">
                                    <h3>همینتور</h3>
                                    <ul>
                                        <li><a href="https://hamintour.com/%d9%82%d9%88%d8%a7%d9%86%db%8c%d9%86-%d8%a7%d8%b3%d8%aa%d8%ae%d8%af%d8%a7%d9%85-%d9%85%d9%86%d8%b5%d8%a9-%d9%87%d9%85%db%8c%d9%86%d8%aa%d9%88%d8%b1/">قوانين استخدام منصة "همینتور"</a></li>
                                        <li><a href="https://hamintour.com/#">قوانين استرداد الأموال</a></li>
                                        <li><a href="https://hamintour.com/#">مجلة السياحة</a></li>
                                        <li><a href="https://hamintour.com/#">الأسئلة المتكررة</a></li>
                                        <li><a href="https://hamintour.com/contact-us/">اتصل بنا</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="items-about-webSite">
                                <h3>عنواننا</h3>
                                <p class="address">عنوان المكتب: طهران، بولفار ميرداماد، زقاق حسيني، رقم 5، مبنى 5، الطابق 6</p>
                                <p class="">البريد الإلكتروني: <span class="email">info@hamintour.com</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="copyright-bar">
                    <p class="copyright">حقوق هذا التصميم محفوظة لـ <span style="font-family: 'IRANYekanX-Black',sans-serif">"همینتور"</span> وأي نسخ أو استخدام غير مصرح به يعرض للمسائلة القانونية.</p>
                    <p class="copyright">همینتور - من 2022 حتى الآن</p>
                </div>
            </div>
            <img class="bg-footer" src="project_files/images/footer_bg.png" alt="bg-footer">
        </footer>
    {/if}
{else}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`pwaFooter.tpl"}
{/if}