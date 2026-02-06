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
                            برای آگاهی از جدیدترین پیشنهادات بلیط هواپیما،تور مسافرتی و رزرو هتل های لحظه آخری در خبرنامه ما عضو شوید.
                        </p>
                    </div>
                    <label class="p-1 col-12 col-lg-6 col-md-12">
                        <span>نام و نام خانوادگی : </span>
                        <input class='full-name-js'  type="text" placeholder="نام" value="" name='full_name' id="full_name">
                    </label>
                    <label class="p-1 col-12 col-lg-6 col-md-12">
                        <span>پست الکترونیکی : </span>
                        <input class='email-js' type="email" placeholder="ایمیل" value=""   name="email" id="email" type="email">
                    </label>
                    <label class="p-1 col-12 col-lg-6 col-md-12">
                        <span>شماره موبایل : </span>
                        <input class='mobile-js' type="text" placeholder="موبایل" value=""  name="mobile" id="mobile" type="text">
                    </label>
                    <div class="p-1 col-12 col-lg-6 col-md-12 d-flex align-items-end">
                        <a class="btn btn-primary text-center  w-100 align-items-center d-flex justify-content-center"
                           id="ButSms" onclick="submitNewsLetter()"
                           href="javascript:">ثبت</a>
                    </div>
                </form>
                <div class="col-lg-4 col-md-12 col-sm12 col-12">
                    <div class="parent_qcode">
                        <p class="newsletters_p">
                            پا به پا سفر در شبکه های اجتماعی
                        </p>
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            <img src="project_files/images/qcode.png" alt="qcode">
                            {foreach $socialLinks as $key => $socialMedia}
                                {if $socialMedia['social_media'] == 'instagram'}
                                    <a href="{$socialMedia['link']}" class="btn_qcode">
                                        <i class="fa-brands fa-instagram btn_qcode_insta"></i>
                                        پا به پا سفر در اینستاگرام
                                        <i class="fa-light fa-chevron-left btn_qcode_arrow"></i>
                                    </a>
                                {/if}
                            {/foreach}
                        </div>
                        <div class="d-flex flex-wrap col-12 p-0 mt-3 align-items-center justify-content-around">
                            {foreach $socialLinks as $key => $socialMedia}
                                {if $socialMedia['social_media'] == 'telegram'}
                                    <a href="{$socialMedia['link']}" class="logo_link_code">
                                        <i class="fa-brands fa-telegram"></i>
                                    </a>
                                {/if}
                                {if $socialMedia['social_media'] == 'linkedin'}
                                    <a href="{$socialMedia['link']}" class="logo_link_code">
                                        <i class="fa-brands fa-linkedin"></i>
                                    </a>
                                {/if}
                                {if $socialMedia['social_media'] == 'twitter'}
                                    <a href="{$socialMedia['link']}" class="logo_link_code">
                                        <i class="fa-brands fa-twitter"></i>
                                    </a>
                                {/if}
                            {/foreach}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
