{if $smarty.session.layout neq 'pwa'}
    {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}
        <footer class="footer mt-5">
            <div class="container">
                <div class="best">
                    <div class="col-lg-3 my-3 col-md-6 col-12">
                        <i class="far fa-plane"></i>
                        <div>
                            <h6>رزرو بلیط</h6>
                            <span>رزرو بلیط هواپیما از معتبرترین ایرلاین ها</span>
                        </div>
                    </div>
                    <div class="col-lg-3 my-3 col-md-6 col-12">
                        <i class="far fa-user-headset"></i>
                        <div>
                            <h6>پشتیبانی ۲۴ ساعته</h6>
                            <span>پشتیبانی و همراهی ۲۴ ساعته ، ما در در تمامی مراحل سفر همراه شما هستیم</span>
                        </div>
                    </div>
                    <div class="col-lg-3 my-3 col-md-6 col-12">
                        <i class="fa fa-ticket"></i>
                        <div>
                            <h6>خرید بلیط چارتری</h6>
                            <span>خرید بلیط چارتری با بهترین قیمت</span>
                        </div>
                    </div>
                    <div class="col-lg-3 my-3 col-md-6 col-12">
                        <i class="far fa-smile"></i>
                        <div>
                            <h6>استرداد بلیط</h6>
                            <span>امکان استرداد بلیط با کمترین وقت</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 footer-main-right">
                    <ul class="flex-wrap">
                        <li class="col-sm-4 my-3 my-xs-0 col-xs-6 col-6">
                            <h6>دسترسی آسان</h6>
                            <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/aboutus">چرا با شب باد گشت؟</a>
                            <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/article">مجله شب باد گشت</a>
                            <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/rules">قوانین و مقررات</a>
                            <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/specific/21">راهنمای خرید</a>
                        </li>
                        <li class="col-sm-4 my-3 my-xs-0 col-xs-6 col-6">
                            <h6>خدمات ما</h6>
                            <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/specific/22">راهنمای استردادبلیط</a>
                            <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}/faq">پرسسش و پاسخ</a>
                            <a href="javascript:">فروش سازمانی</a>
                            <a href="javascript:">همکاری با اژانس ها</a>
                        </li>
                        <li class="col-sm-4 my-3 my-xs-0 col-xs-6 col-6">
                            <h6>دانستنیها</h6>
                            <a href="javascript:">فرصت های شغلی</a>
                            <a href="javascript:"> بلیط چارتری </a>
                        </li>
                    </ul>
                    <div class="code">
                        {*<input id="txtsearch" aria-describedby="basic-addon1" type="text" name="CodeRahgiriTemp" onfocus="{this.value='';}" onblur="if (this.value==''){this.value='کد رهگیری خود را وارد کنید...';}" value="کد رهگیری خود را وارد کنید..." autocomplete="off">*}
                        {*<button class="btn button-winona" type="submit">*}
                        {*<i class="fas fa-check"></i>*}
                        {*</button>*}
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 footer-main-left">
                    <img src="project_files/images/logo2.png" alt="logo">
                    <span>شماره تماس :<a href="tel:+{$smarty.const.CLIENT_MOBILE}" class="">{$smarty.const.CLIENT_MOBILE}</a>
                <a href="tel:{$smarty.const.CLIENT_PHONE}" class="">{$smarty.const.CLIENT_PHONE}</a>
                {assign var='additional_data' value=$smarty.const.ADDITIONAL_DATA|json_decode:true}
                        {if $additional_data}
                            {foreach $additional_data as $index => $item}
                                {if $item['body']|substr:0:2 eq '09' || $item['body']|substr:0:4 eq '+989' || $item['body']|substr:0:2 eq '02'}
                                    <a href="tel:{$item['body']}">{$item['body']}</a>
                                    {if isset($additional_data[$index + 1])} - {/if}
                                {/if}
                            {/foreach}
                        {/if}
            </span>
                    <span>ایمیل :<a href="mailto:{$smarty.const.CLIENT_EMAIL}" class="amailto">{$smarty.const.CLIENT_EMAIL}</a></span>
                    <p>آدرس : {$smarty.const.CLIENT_ADDRESS}۲</p>
                    <div class="namads">

                        <div class="col_namads">
                            <a target="_blank" rel="nofollow" href="https://www.cao.ir/paxrights"><img src="project_files/images/certificate1.png" alt=""></a>
                            <a target="_blank" rel="nofollow" href="https://www.cao.ir/"><img src="project_files/images/certificate2.png" alt=""></a>
                            <a target="_blank" rel="nofollow" href="http://aira.ir/images/final3.pdf"><img src="project_files/images/certificate3.png" alt=""></a>
                            <a target="_blank" rel="nofollow" href="https://enamad.ir/"><img src="project_files/images/enamad.png" alt=""></a>
                            <a target="_blank" rel="nofollow" href="https://samandehi.ir/Pages/HomePage.aspx"><img src="project_files/images/samandeh.jpg" alt=""></a>


                            <a target="_blank" rel="nofollow" href="https://www.rai.ir/"><img src="project_files/images/logo_F.png" alt="logo_F"></a>
                            <a target="_blank" rel="nofollow" href="https://www.haj.ir/"><img src="project_files/images/logo_F2.png" alt="logo_F2"></a>
                            <a target="_blank" rel="nofollow" href="https://www.mcth.ir/"><img src="project_files/images/logo_F3.png" alt="logo_F3"></a>

                        </div>

                    </div>
                </div>
                <div class="col-12 last">
                    <p>کلیه حقوق این سرویس (وب‌سایت و اپلیکیشن‌های موبایل) محفوظ و متعلق به شرکت سفرهای شب باد گشت می‌باشد.</p>
                    <div class="last_text">
                        <a class="last_a" href="https://www.iran-tech.com/" target="_blank">طراحی سایت گردشگری</a>
                        <p class="last_p_text">: ایران تکنولوژی</p>
                    </div>
                </div>
            </div>
            <div id="sidebar_social">
                <div class="social instagram">
                    <a class="SMInstageram"  target="_blank">
                        <p><i class="fab fa-instagram"></i></p>
                    </a>
                </div>
                <div class="social whatsapp">
                    <a class="SMWhatsapp" href="https://api.whatsapp.com/send?phone=+9892143322558" target="_blank">
                        <p><i class="fab fa-whatsapp"></i></p>
                    </a>
                </div>
                <div class="social telegram">
                    <a class="SMTelegram"  target="_blank">
                        <p><i class="fab fa-telegram-plane"></i></p>
                    </a>
                </div>
                <div class="social youtube">
                    <a class="SMYouTube"  target="_blank">
                        <p><i class="fab fa-youtube"></i></p>
                    </a>
                </div>
                <div class="social aparat">
                    <a class="SMAparat"  target="_blank">
                        <p><i class="fab fa-aparat">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 530.9 530.9" width="2500" height="2500">
                                    <style>.st0 {
                                            fill: #fff;
                                            stroke: #ccc;
                                            stroke-width: 25;
                                            stroke-miterlimit: 10
                                        }</style>
                                    <path fill="#fff"
                                          d="M348 527.8L50.5 436.9c-37.6-11.5-58.8-51.3-47.3-89L94 50.5c11.5-37.6 51.3-58.8 89-47.3L480.5 94c37.6 11.5 58.8 51.3 47.3 89l-90.9 297.5c-11.5 37.6-51.3 58.8-88.9 47.3z"></path>
                                    <circle class="st0" cx="265.5" cy="265.5" r="226.8"></circle>
                                    <circle fill="#e61557" class="st1" cx="265.5" cy="265.5" r="28.4"></circle>
                                    <path fill="#e61557" class="st1"
                                          d="M182.4 216.6c-34.3-8.2-55.4-42.6-47.3-76.8 8.2-34.3 42.6-55.4 76.8-47.3 34.3 8.2 55.4 42.6 47.3 76.8-8.1 34.2-42.5 55.4-76.8 47.3zM361.7 259.2c-34.3-8.2-55.4-42.6-47.3-76.8 8.2-34.3 42.6-55.4 76.8-47.3 34.3 8.2 55.4 42.6 47.3 76.8-8.2 34.3-42.6 55.5-76.8 47.3zM139.7 395.8c-34.3-8.2-55.4-42.6-47.3-76.8 8.2-34.3 42.6-55.4 76.8-47.3 34.3 8.2 55.4 42.6 47.3 76.8-8.1 34.3-42.5 55.5-76.8 47.3zM319 438.5c-34.3-8.2-55.4-42.6-47.3-76.8 8.2-34.3 42.6-55.4 76.8-47.3 34.3 8.2 55.4 42.6 47.3 76.8-8.1 34.3-42.5 55.5-76.8 47.3z"></path>

                                </svg>
                            </i></p>
                    </a>
                </div>
            </div>
        </footer>
    {/if}

{else}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`pwaFooter.tpl"}
{/if}