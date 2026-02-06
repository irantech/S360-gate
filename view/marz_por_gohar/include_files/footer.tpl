{load_presentation_object filename="aboutUs" assign="objAbout"}
{assign var="about"  value=$objAbout->getData()}
{assign var="socialLinks"  value=$about['social_links']|json_decode:true}

<footer>
        <div class="body-footer">
            <div class="container">
                <div class="row">
                    <div class="parent-footer-iran d-flex flex-wrap w-100">
                        <div class="item-footer col-lg-4 col-md-6 col-sm-12 col-12  order-foot1">
                            <div class="parent-item-footer parent-item-footer-responsive">
                                <h3>تماس با ما</h3>
                                <div class="child-item-footer align-items-start">
                                    <i class="fa-light fa-location-dot"></i>
                                    آدرس:
                                    <span class="text-right">
                                                {$smarty.const.CLIENT_ADDRESS}
                                    </span>
                                </div>
                                <div class="child-item-footer">
                                    <i class="fa-light fa-phone"></i>
                                    تلفن:
                                    <a href="tel:{$smarty.const.CLIENT_PHONE}" class="">
                                        {$smarty.const.CLIENT_PHONE}
                                    </a>
                                </div>
                                <div class="child-item-footer">
                                    <i class="fa-light fa-mobile"></i>
                                    موبایل:
                                    <a href="tel:{$smarty.const.CLIENT_MOBILE}" class="">
                                        {$smarty.const.CLIENT_MOBILE}
                                    </a>
                                </div>
                                <div class="child-item-footer">
                                    <i class="fa-light fa-envelope"></i>
                                    ایمیل:
                                    <a href="mailto:{$smarty.const.CLIENT_EMAIL}" class="">
                                        {$smarty.const.CLIENT_EMAIL}
                                    </a>
                                </div>
                                <div class="footer-icon my-footer-icon">
                                    {foreach $socialLinks as $key => $socialMedia}
                                        {if $socialMedia['social_media'] == 'telegram'}
                                            <a target="_blank" href="{$socialMedia['link']}" class="fab fa-telegram footer_telegram"></a>
                                        {/if}
                                        {if $socialMedia['social_media'] == 'instagram'}
                                            <a target="_blank" href="{$socialMedia['link']}" class="fab fa-instagram footer_instagram"></a>
                                        {/if}
                                        {if $socialMedia['social_media'] == 'whatsapp'}
                                            <a target="_blank" href="{$socialMedia['link']}" class="fab fa-whatsapp footer_whatsapp"></a>
                                        {/if}
                                        {if $socialMedia['social_media'] == 'linkedin'}
                                        <a target="_blank" href="{$socialMedia['link']}" class="fa-brands fa-linkedin-in footer_linkedin"></a>
                                        {/if}
                                    {/foreach}
                                </div>
                            </div>
                        </div>
                        <div class="item-footer col-lg-4 col-md-6 col-sm-12 col-12  display-footer-none">
                            <div class="box-item-footer text-right">
                                <h3>درباره ما</h3>
                                <p>
                                    {$smarty.const.ABOUT_ME}
                                </p>
                                <a href="{$smarty.const.ROOT_ADDRESS}/aboutUs" class="SMAbout"> بیشتر  <i class="far fa-angle-right mr-1"></i></a>
                            </div>
                        </div>
                        <div class="item-footer col-lg-4 col-md-6 col-sm-12 col-12 order-foot2">
                            <div class="parent-namad box-item-footer text-right">
{*                                <h3>کدرهگیری</h3>*}
{*                                <form class="TrcBox w-100" method="get" name="FormCodeRahgiriPrj" id="FormCodeRahgiriPrj" >*}
{*                                    <div class="code" >*}
{*                                        <input id="txtsearch" aria-describedby="basic-addon1" type="text" name="CodeRahgiriTemp"   placeholder="کد رهگیری خود را وارد کنید..." >*}
{*                                        <button class="btn button-winona" type="submit">*}
{*                                            <i class="fas fa-check"></i>*}
{*                                        </button>*}
{*                                    </div>*}
{*                                </form>*}
                                <div class="namads">
                                    <a href="javascript:"><img src="project_files/images/certificate1.png" alt="Enamad1"></a>
                                    <a href="javascript:"><img src="project_files/images/certificate2.png" alt="namad-1"></a>
                                    <a href="javascript:"><img src="project_files/images/certificate3.png" alt="namad-2"></a>
                                    <a referrerpolicy='origin' target='_blank' href='https://trustseal.enamad.ir/?id=453385&Code=WylidfONSZXmKUXQpXGenPDP0lIx5xYh'><img referrerpolicy='origin' src='https://trustseal.enamad.ir/logo.aspx?id=453385&Code=WylidfONSZXmKUXQpXGenPDP0lIx5xYh' alt='' style='cursor:pointer' Code='WylidfONSZXmKUXQpXGenPDP0lIx5xYh'></a>
                                </div>
                                <div class="footer-icon icon-respancive">
                                    {foreach $socialLinks as $key => $socialMedia}
                                        {if $socialMedia['social_media'] == 'telegram'}
                                            <a target="_blank" href="{$socialMedia['link']}" class="fab fa-telegram footer_telegram"></a>
                                        {/if}
                                        {if $socialMedia['social_media'] == 'instagram'}
                                            <a target="_blank" href="{$socialMedia['link']}" class="fab fa-instagram footer_instagram"></a>
                                        {/if}
                                        {if $socialMedia['social_media'] == 'whatsapp'}
                                            <a target="_blank" href="{$socialMedia['link']}" class="fab fa-whatsapp footer_whatsapp"></a>
                                        {/if}
                                        {if $socialMedia['social_media'] == 'linkedin'}
                                            <a target="_blank" href="{$socialMedia['link']}" class="fa-brands fa-linkedin-in footer_linkedin"></a>
                                        {/if}
                                    {/foreach}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="last_text col-12">
            <a class="last_a" href="https://www.iran-tech.com/">طراحی سایت گردشگری </a>
            <p class="last_p_text">: ایران تکنولوژی</p>
        </div>
    </footer>
</body>
</html>