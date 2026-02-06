<section class="news_main mt-5">
    <div class="container">
        <div class="news_text col-12">
            <h2 class="titel text-white">عضویت در خبرنامه</h2>
        </div>
        <form id="newsletter" class="col-12 p-0 news-letter-js"  action="" name='full_name' id="full_name" method="post">
            <label class="p-1 col-12 col-md-3">
                <span>نام و نام خانوادگی : </span>
                <input class='full-name-js'  name="NameSms" id="NameSms" type="text" placeholder="نام"  autocomplete="off">
            </label>
            <label class="p-1 col-12 col-md-3">
                <span>پست الکترونیکی : </span>
                <input name="email" id="email" type="email" placeholder="ایمیل" class='email-js'  autocomplete="off">
            </label>
            <label class="p-1 col-12 col-md-3">
                <span>شماره موبایل : </span>
                <input name="mobile" id="mobile" type="text" placeholder="موبایل" class='mobile-js'  autocomplete="off">
            </label>
            <div class="p-1 col-6 col-md-3 mb-2-5 mt-auto">
                <button type='button' class="button news-letter-js w-100" onclick="submitNewsLetter()"> ثبت </button>
            </div>
        </form>
    </div>
</section>