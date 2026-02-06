{load_presentation_object filename="aboutUs" assign="objAbout"}
{assign var="about"  value=$objAbout->getData()}


<footer>
    <div class="container">
        <div class="d-flex flex-wrap">
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mar_tb p-0">
                <div class="data_phone">
                    <img src='project_files/images/logo-footer.png' alt='logo'>
                    <a href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}" class="footer_logo">

                        <div class="mr-2 mt-1">
                            <h2 class="tikland">پاوان گشت</h2>
                            <span>آژانس خدمات مسافرت هوائی و جهانگردی</span>
                        </div>
                    </a>
                    <p class="phone_num">
                        <i class="far fa-phone"></i>
                        <a href="tel:{$smarty.const.CLIENT_PHONE}" >{$smarty.const.CLIENT_PHONE}</a>
                    </p>
                    <p class="address_site">
                        <i class="far fa-map-marker"></i>
                        <span>{$smarty.const.CLIENT_ADDRESS}</span>
                    </p>
                    <p class="email_site">
                        <i class="far fa-envelope"></i>
                        <a href="mailto:{$smarty.const.CLIENT_EMAIL}">{$smarty.const.CLIENT_EMAIL}</a>
                    </p>
                </div>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-12 mar_tb p-0">
                <div class="item_footer">
                    <h4>دسترسی آسان</h4>
                    <ul class="">
                        <li>
                            <a <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">تور</a>
                        </li>
                        <li>
                            <a href="{$smarty.const.ROOT_ADDRESS}/mag">وبلاگ</a>
                        </li>
                        <li>
                            <a href="{$smarty.const.ROOT_ADDRESS}/rules">قوانین و مقررات</a>
                        </li>
                        <li>
                            <a href="{$smarty.const.ROOT_ADDRESS}/contactUs">تماس با ما</a>
                        </li>
                        <li>
                            <a href="{$smarty.const.ROOT_ADDRESS}/aboutUs">درباره ما</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mar_tb padding-mobile">
                <div class="item_footer">
                    <h4>درباره ما</h4>
                    <span class="__aboutUs_class__ text-footer-about">
                         آژانس خدمات مسافرتی و جهانگردی پاوان گشت پارسه فعالیت خود را در سال 1403 در زمینه گردشگری و ارائه خدمات و محصولات وابسته به آن آغاز کرده است. کیفیت بالا و احساس رضایت مشتریان عزیز برای گروه پاوان گشت در اولویت است.
                        <br>
                        <a class="footer-more" href="/gds/fa/aboutUs"> بیشتر</a>
                    </span>
                </div>
            </div>

            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mar_tb ">
                <div class="item_footer">
                    <div class="namads">
                        <a href="https://www.cao.ir/paxrights"><img src="project_files/images/certificate1.png" alt="Enamad1"></a>
                        <a href="https://www.cao.ir/"><img src="project_files/images/certificate2.png" alt="namad-1"></a>
                        <a href="http://aira.ir/images/final3.pdf"><img src="project_files/images/certificate3.png" alt="namad-2"></a>
                        <a referrerpolicy='origin' target='_blank' href='https://trustseal.enamad.ir/?id=592030&Code=wqXNpLiRSYoYMKS3uriy5kwG9jKhKQku'><img referrerpolicy='origin' src='https://trustseal.enamad.ir/logo.aspx?id=592030&Code=wqXNpLiRSYoYMKS3uriy5kwG9jKhKQku' alt='' style='cursor:pointer' code='wqXNpLiRSYoYMKS3uriy5kwG9jKhKQku'></a>
                        <a href="https://tehran.mcth.ir/"><img src="project_files/images/mcth.png" alt=""></a>
                        <a href="project_files/images/Scanned_Documents_3_page.jpg" target="_blank"><img src="project_files/images/Iranian Air Travel and Tourism Service Offices Association.png" alt="انجمن صنفی دفاتر خدمات مسافرت هوایی و جهانگردی ایران" title="انجمن صنفی دفاتر خدمات مسافرت هوایی و جهانگردی ایران"></a>
                        <a href="project_files/images/khdmt_hwyy_bnd_lf.pdf" target="_blank"><img src="project_files/images/National portal of country's licenses.jpg" alt="درگاه ملی مجوزهای کشور" title="درگاه ملی مجوزهای کشور"></a>
                    </div>
                    {assign var="socialLinks"  value=$about['social_links']|json_decode:true}
                    {assign var="socialLinksArray" value=['telegram'=>'telegramHref','whatsapp'=> 'whatsappHref','instagram' => 'instagramHref','aparat' => 'aparatHref','youTube' => 'youtubeHref','facebook' => 'facebookHref','linkedin' => 'linkeDinHref' , 'twitter' => 'twitterHref']}

                    {foreach $socialLinks as $key => $val}
                        {assign var=$socialLinksArray[$val['social_media']] value=$val['link']}
                    {/foreach}
                    <div class="footer_icons">
                        <a href="{if $instagramHref}{$instagramHref}{/if}" target="_blank" class="fab fa-instagram footer_instagram"></a>
                        <a  href='{if $whatsappHref}{$whatsappHref}{/if}'  target="_blank"  class="fab fa-whatsapp footer_whatsapp"></a>
                        <a  href='{if $telegramHref}{$telegramHref}{/if}'  target="_blank"  class="fab fa-telegram footer_telegram"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="last_text col-12">
        <a class="last_a"  href="https://www.iran-tech.com/" >طراحی سایت گردشگری</a>
        <p class="last_p_text">: ایران تکنولوژی</p>
    </div>
    <a href="javascript:" class="fixicone fa fa-angle-up" id="scroll-top" style=""></a>
</footer>
