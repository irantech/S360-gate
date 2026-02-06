<!DOCTYPE html>

<html dir="rtl" lang="fa">
{include file="include_files/header.tpl"}
<body>
{if $smarty.session.layout neq 'pwa' }{include file="include_files/menu.tpl"}{/if}
<main>
{include file="include_files/search-box.tpl"}
{include file="include_files/tours.tpl"}
{include file="include_files/news.tpl"}
{include file="include_files/about-us.tpl"}
<!--    <section class="membership">-->
<!--        <div class="container">-->
<!--            <div class="parent-membership">-->
<!--                <div class="mb-4 mb-lg-0 col-lg-6 col-12 p-0 text_newsletter">-->
<!--                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">&lt;!&ndash;! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. &ndash;&gt;<path d="M64 96H448c17.7 0 32 14.3 32 32v32.7c5.3-.5 10.6-.7 16-.7s10.7 .2 16 .7V128c0-35.3-28.7-64-64-64H64C28.7 64 0 92.7 0 128V384c0 35.3 28.7 64 64 64H360.2c-8.1-9.8-15.2-20.6-21-32H64c-17.7 0-32-14.3-32-32V207.6L208.7 337.1c28.2 20.6 66.5 20.6 94.6 0l17.1-12.5c1-16.2 4.3-31.8 9.4-46.6l-45.4 33.3c-16.9 12.4-39.9 12.4-56.8 0L32 167.9V128c0-17.7 14.3-32 32-32zM496 224a112 112 0 1 1 0 224 112 112 0 1 1 0-224zm0 256a144 144 0 1 0 0-288 144 144 0 1 0 0 288zm67.3-187.3c-6.2-6.2-16.4-6.2-22.6 0L480 353.4l-28.7-28.7c-6.2-6.2-16.4-6.2-22.6 0s-6.2 16.4 0 22.6l40 40c6.2 6.2 16.4 6.2 22.6 0l72-72c6.2-6.2 6.2-16.4 0-22.6z"/></svg>-->
<!--                    <div>-->
<!--                        <h2>عضویت در خبرنامه</h2>-->
<!--                        <p>برای آگاهی از پیشنهادات ، تخفیفات و آفر های ویژه ما در خبرنامه عضو شوید.</p>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-lg-6 col-12 p-0">-->
<!--                    <form class="col-12 p-0 form_newsletter d-flex flex-wrap">-->
<!--                        <label class="p-1 col-md-6 col-12 m-0">-->
<!--                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">&lt;!&ndash;! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. &ndash;&gt;<path d="M320 128a96 96 0 1 0 -192 0 96 96 0 1 0 192 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM32 480H416c-1.2-79.7-66.2-144-146.3-144H178.3c-80 0-145 64.3-146.3 144zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z"/></svg>-->
<!--                            <input class="form-control w-100" type="text" placeholder="نام و نام خانوادگی ...">-->
<!--                        </label>-->
<!--                        <label class="p-1 col-md-6 col-12 m-0">-->
<!--                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">&lt;!&ndash;! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. &ndash;&gt;<path d="M259.7 16.03C116.5 13.94 2.766 140.5 17.25 283.1c11.96 117.8 102.2 205.2 221.5 212.8c9.275 .5957 17.18-6.739 17.18-16.04c0-8.395-6.552-15.39-14.92-15.92c-106.1-6.828-185.7-86.38-192.7-192.5c-7.852-119.6 82.95-220.8 202.6-223.4c118.1-2.607 212.1 89.77 212.1 208.2V278.7c0 26.43-17.55 50.57-43.34 56.27c-36.37 8.039-68.67-19.59-68.67-54.64v-120.1c0-8.846-7.168-16.02-16.01-16.02c-8.838 0-16.02 7.165-16.02 16.01v17.88c-24.95-25.56-61.83-39.39-101.6-31.85C173.5 154.7 137.8 190.7 129.8 235.6c-12.72 70.86 41.68 132.8 110.2 132.8c37.39 0 70.32-18.63 90.68-46.9c16.48 30.84 50.34 51.03 88.7 46.15c44.44-5.656 76.63-45.58 76.63-90.42V256.3C495.1 122.8 392.5 17.96 259.7 16.03zM239.9 336.3c-44.13 0-80.02-35.93-80.02-80.09S195.8 176.2 239.9 176.2s80.02 35.93 80.02 80.09S284.1 336.3 239.9 336.3z"/></svg>-->
<!--                            <input class="form-control w-100" type="text" placeholder="ایمیل ...">-->
<!--                        </label>-->
<!--                        <label class="p-1 col-md-6 col-12 m-0">-->
<!--                            <svg class="svg-me-membership" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">&lt;!&ndash;! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. &ndash;&gt;<path d="M288 0H96C60.65 0 32 28.65 32 64v384c0 35.35 28.65 64 64 64h192c35.35 0 64-28.65 64-64V64C352 28.65 323.3 0 288 0zM320 448c0 17.64-14.36 32-32 32H96c-17.64 0-32-14.36-32-32V64c0-17.64 14.36-32 32-32h192c17.64 0 32 14.36 32 32V448zM224 400H160c-8.836 0-16 7.162-16 16c0 8.836 7.164 16 16 16h64c8.836 0 16-7.164 16-16C240 407.2 232.8 400 224 400z"/></svg>-->
<!--                            <input class="form-control w-100" type="text" placeholder="شماره موبایل ...">-->
<!--                        </label>-->
<!--                        <label class="p-1 col-md-6 col-12 m-0">-->
<!--                            <a href="javascript:" class="btn-newsletterMain">-->
<!--                                <span>ارسال</span>-->
<!--                            </a>-->
<!--                        </label>-->
<!--                    </form>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </section>-->
</main>
{include file="include_files/footer.tpl"}
</body>






{include file="include_files/footer_script.tpl"}
</html>