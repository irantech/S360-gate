    {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 social-link-parent">
                        <div class="col-xs-12 title-social">
                            <i class="fas fa-phone-volume"></i>
                            راههای ارتباط با شیدرخ

                        </div>

                        <div class="row">
                            <div class="col-lg-12 social-link">
                                <div class="icon-newtwork">
                                    <a href="https://www.linkedin.com/in/shidrokh-travel-agency-7637081b8" class="linkin">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                    <div class="lable-network">لینکدین</div>
                                </div>

                                <div class="icon-newtwork">
                                    <a href="https://www.facebook.com/shidrokhtravelagency/" class="facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <div class="lable-network">فیسبوک</div>
                                </div>
                                {load_presentation_object filename="aboutUs" assign="objAbout"}
                                {assign var="about"  value=$objAbout->getData()}
                                {assign var="socialLinks"  value=$about['social_links']|json_decode:true}
                                {foreach $socialLinks as $key => $socialMedia}

                                    {if $socialMedia['social_media'] == 'telegram'}
                                        <div class="icon-newtwork">
                                            <a href="{$socialMedia['link']}" class="SMTelegram telegram">
                                                <i class="fab fa-telegram-plane"></i>
                                            </a>
                                            <div class="lable-network">تلگرام</div>
                                        </div>
                                    {/if}
                                    {if $socialMedia['social_media'] == 'whatsapp'}
                                        <div class="icon-newtwork">
                                            <a href="{$socialMedia['link']}" class="SMWhatsApp whatsapp">
                                                <i class="fab fa-whatsapp"></i>
                                            </a>
                                            <div class="lable-network">واتساپ</div>
                                        </div>
                                    {/if}

                                    {if $socialMedia['social_media'] == 'instagram'}
                                        <div class="icon-newtwork">
                                            <a href="{$socialMedia['link']}" class="SMInstageram instagram">
                                                <i class="fab fa-instagram"></i>
                                            </a>
                                            <div class="lable-network">اینستاگرام فارسی</div>
                                        </div>
                                    {/if}
                                {/foreach}

                                <div class="icon-newtwork">
                                    <a href="https://www.instagram.com/p/CGVMsa1hGxV/?igshid=gg397t38r1mx" class="instagram">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                    <div class="lable-network">اینستاگرام انگلیسی</div>
                                </div>
                                <div class="icon-newtwork">
                                    <a href="https://instagram.com/easytravel.iran?igshid=84ylj0km2pt2" class="instagram">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                    <div class="lable-network">اینستاگرام روسی</div>
                                </div>
                                <div class="icon-newtwork">
                                    <a href="https://instagram.com/voyagefacile_en_iran?igshid=17u77dg5m2s9j" class="instagram">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                    <div class="lable-network">اینستاگرام فرانسه</div>
                                </div>

                            </div>
                            <div class="col-lg-12 links-footer d-none d-md-block">
                                <ul>
                                    <li><a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">صفحه اصلی</a></li>
                                    <li><a class="SMContactUs" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/contactus">تماس با شیدرخ</a></li>
                                    <li><a class="SMAbout" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/aboutus">درباره شیدرخ</a></li>
                                    <li><a class="" href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری خرید</a></li>
                                    <li><a class="" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/2">تور عشایر</a></li>
                                    <li><a class="" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/3">تور شکم گردی</a></li>
                                    <li><a class="" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/16">تور سالمندان</a></li>
                                    <li><a class="" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/specific/17">تور بانوان</a></li>
                                    <li><a class="SMBlog" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/blog">مجله گردشگری</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6 footer-sec-address">
                                <div class="footer-title-sec">
                                    <i class="fas fa-phone"></i>
                                    <h4>ارتباط با ما</h4>
                                </div>
                                <div class="footer-sec-info">
                                    <p class="SMFooterAddress">{$smarty.const.CLIENT_ADDRESS}</p>
                                    <p class="tell SMFooterPhone">شماره تماس :
                                        {$smarty.const.CLIENT_MOBILE}
                                    </p>
                                    <a class="SMFooterEmail" href="mailto:{$smarty.const.CLIENT_EMAIL}">{$smarty.const.CLIENT_EMAIL}</a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 footer-sec-address">

                                {*                        <div class="footer-title-sec">*}
                                {*                            <i class="fas fa-chart-bar"></i>*}
                                {*                            <h4>آمار بازدید سایت</h4>*}
                                {*                        </div>*}
                                {*                        <div class="footer-sec-info">*}
                                {*                            <div class="amar-parent">*}
                                {*                                <div> بازدید امروز: <span>624 بازدید </span></div>*}
                                {*                                <div> بازدید دیروز: <span>: 0 بازدید </span></div>*}
                                {*                                <div> بازدید ماه گذشته: <span>: 4,365 بازدید </span></div>*}
                                {*                                <div>بازدید کل: <span>827,227</span></div>*}
                                {*                            </div>*}
                                {*                        </div>*}
                                {*                        <div class="footer-sec-info2">*}
                                {*                            <a referrerpolicy="origin" target="_blank" href="https://trustseal.enamad.ir/?id=209498&amp;Code=V8JQXAzL4f22UvM7eUz8"><img referrerpolicy="origin" src="https://Trustseal.eNamad.ir/logo.aspx?id=209498&amp;Code=V8JQXAzL4f22UvM7eUz8" alt="" style="cursor:pointer" id="V8JQXAzL4f22UvM7eUz8"></a>*}
                                {*                        </div>*}

                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12 footer-sec-sale mr-auto">

                            </div>
                        </div>


                    </div>
                </div>
        </footer>
        <div class="copyright">

            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="copyright_content d-flex flex-row align-items-center">
                            <p>
                                کلیه حقوق وب سایت متعلق به <a href="https://www.iran-tech.com">شیدرخ</a> می باشد.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 iran-tech text-left">
                        <p> <a href="https://www.iran-tech.com" target="_blank"> طراحی سایت گردشگری </a>: ایران تکنولوژی </p>
                    </div>
                </div>
            </div>

        </div>
    {/if}
