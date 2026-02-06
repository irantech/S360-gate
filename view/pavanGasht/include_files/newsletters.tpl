{load_presentation_object filename="aboutUs" assign="objAbout"}
{assign var="about"  value=$objAbout->getData()}

<section class="newsletters">
    <div class="container">
        <div class="bg_color">
            <div class="titr_luxury d-flex align-items-center justify-content-center flex-column">
                <h4>
                    عضویت در خبرنامه
                </h4>
            </div>
            <div class="d-flex flex-wrap">
                <form class="col-lg-8 col-md-12 col-sm-12 col-12 p-0">
                    <div class="">
                        <p  class="newsletters_p">
                            برای آگاهی از جدیدترین پیشنهادات تورهای داخلی ، تورهای خارجی و تورهای لحظه آخری در خبرنامه ما عضو شوید.
                        </p>
                    </div>
                    <label class="p-1 col-12 col-lg-6 col-md-12">
                        <span>نام و نام خانوادگی : </span>
                        <input type="text" placeholder="نام" class="__name_class__ full-name-js">
                    </label>
                    <label class="p-1 col-12 col-lg-6 col-md-12">
                        <span>پست الکترونیکی : </span>
                        <input type="email" placeholder="ایمیل" class="__email_class__ email-js">
                    </label>
                    <label class="p-1 col-12 col-lg-6 col-md-12">
                        <span>شماره موبایل : </span>
                        <input type="text" placeholder="موبایل" class="__phone_class__ mobile-js">
                    </label>
                    <div class="p-1 col-12 col-lg-6 col-md-12 d-flex align-items-end">
                        <a class="__submit_class__ btn btn-primary text-center  w-100 align-items-center d-flex justify-content-center"
                           onclick="submitNewsLetter()" href="javascript:">ثبت</a>
                    </div>
                </form>
                <div class="col-lg-4 col-md-12 col-sm12 col-12">
                    <div class="parent_qcode">
                        <p class="newsletters_p">
                            آژانس خدمات مسافرت هوائی و جهانگردی در شبکه های اجتماعی
                        </p>
                        {assign var="socialLinks"  value=$about['social_links']|json_decode:true}
                        {assign var="socialLinksArray" value=['telegram'=>'telegramHref','whatsapp'=> 'whatsappHref','instagram' => 'instagramHref','aparat' => 'aparatHref','youTube' => 'youtubeHref','facebook' => 'facebookHref','linkedin' => 'linkeDinHref' , 'twitter' => 'twitterHref']}

                        {foreach $socialLinks as $key => $val}
                            {assign var=$socialLinksArray[$val['social_media']] value=$val['link']}
                        {/foreach}
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            <img src="project_files/images/qcode.png" alt="qcode">
                                    <a href="{if $instagramHref}{$instagramHref}{/if}"
                                       target="_blank" class="btn_qcode">
                                        <i class="fa-brands fa-instagram btn_qcode_insta"></i>
                                        آژانس خدمات مسافرت هوائی و جهانگردی در اینستاگرام
                                        <i class="fa-light fa-chevron-left btn_qcode_arrow"></i>
                                    </a>

                        </div>
                        <div class=" col-12 p-0 mt-3 parent-logo-link-code">
                                    <a  href='{if $telegramHref}{$telegramHref}{/if}' target='_blank' class="logo_link_code">
                                        <i class="fa-brands fa-telegram"></i>
                                    </a>
                                    <a href='{if $linkeDinHref}{$linkeDinHref}{/if}' target='_blank' class="logo_link_code">
                                        <i class="fa-brands fa-linkedin"></i>
                                    </a>
                                    <a href='{if $twitterHref}{$twitterHref}{/if}' target='_blank' class="logo_link_code">
                                        <i class="fa-brands fa-twitter"></i>
                                    </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
