{$check_general = true}

{if $check_general}
    <section class="i_modular_newsletter newsletter">
        <div class="container">
            <div class="parent-newsletter">
                <div class="newsletter-item">
                    <img alt="newsletter-img" src="project_files/images/newss.jpg" />
                </div>
                <div class="newsletter-item">
                    <div class="parent-text-newsletter">
                        <div class="parent-icon-newsletter">
                            <i class="fa-light fa-envelope-circle-check"></i>
                            <div>
                                <h2>عضویت در خبرنامه</h2>
                                <p>برای آگاهی از پیشنهادات در خبرنامه ما عضو شوید</p>
                            </div>
                        </div>
                        <div class="parent-form-newsletter">
                            <form class="col-12 p-0 form_newsletter d-flex flex-wrap">
                                <label class="p-2 col-md-6 col-12 m-0">
                                    <i class="fa-light fa-user"></i>
                                    <input class="__name_class__ form-control w-100 full-name-js" id="NameSms"
                                           name="NameSms" placeholder="نام ..." type="text" />
                                </label>
                                <label class="p-2 col-md-6 col-12 m-0">
                                    <i class="fa-light fa-at"></i>
                                    <input class="__email_class__ form-control w-100 email-js" name="EmailSms"
                                           placeholder="ایمیل ..." type="text" />
                                </label>
                                <label class="p-2 col-md-6 col-12 m-0">
                                    <i class="fa-light fa-phone-alt"></i>
                                    <input class="__phone_class__ form-control w-100 mobile-js" id="CellSms"
                                           name="CellSms" placeholder="شماره تلفن ..." type="text" />
                                </label>
                                <label class="p-2 col-md-6 col-12 m-0">
                                    <a class="__submit_class__ fa-light fa-paper-plane btn-newsletterMain"
                                       href="javascript:" onclick="submitNewsLetter()"></a>
                                </label>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
{/if}