
<section class="title-form">
    <img src="assets/images/2-plus.png" alt="img">

    <div class="container">
        <h2>فرم ارسال مدارک {$smarty.const.CLIENT_NAME}</h2>
        <svg class="title-sum" version="1.0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2677.000000 186.000000" preserveAspectRatio="xMidYMid meet">
            <g transform="translate(0.000000,186.000000) scale(0.100000,-0.100000)" stroke="none">
                <path d="M18275 1689 c-1865 -8 -3306 -27 -4740 -64 -544 -13 -1285 -32 -1645 -40 -360 -8 -1224 -38 -1920 -65 -696 -27 -1384 -54 -1530 -60 -473 -18 -706 -30 -1975 -100 -687 -38 -1421 -79 -1630 -90 -209 -11 -445 -25 -525 -30 -185 -13 -3173 -267 -3300 -281 -321 -34 -792 -91 -832 -100 -62 -14 -131 -74 -153 -134 -25 -65 -17 -150 21 -211 37 -59 114 -106 176 -106 24 1 225 21 448 46 494 55 560 61 2040 186 652 56 1228 105 1280 111 52 5 869 52 1815 104 946 52 1752 97 1790 100 39 3 426 19 860 35 435 17 1200 46 1700 65 1242 48 4063 112 5740 130 737 8 2006 15 2819 15 l1480 0 1365 -40 c1161 -34 1500 -48 2256 -90 1719 -96 2482 -149 2620 -180 70 -16 136 -11 190 14 140 65 186 235 98 367 -41 62 -98 93 -215 118 -288 59 -1221 124 -3028 211 -707 34 -703 34 -1800 61 -443 11 -967 24 -1165 29 -198 5 -414 9 -480 8 -66 -1 -858 -5 -1760 -9z"></path>
            </g>
        </svg>
    </div>
</section>
<section class="employment-form position-relative">
    <div class="">
        <div class="parent-employment-form">
            <div class="parent-form">
                <form data-toggle="validator" id="addDocumentUser" method="post"  enctype="multipart/form-data" >
                    <input type="hidden" name="method" id='method' value="addDocuments" >
                    <input type="hidden" name="className" id='className' value="sendDocuments" >
                    <input type='hidden' name='language' id='language' value='{$smarty.const.SOFTWARE_LANG}'>

                    <div class="col-education duplicate-form-item">
                        <div class="title-Internal d-flex align-items-center justify-content-between">
                            <h5>ورود اطلاعات شخصی</h5>
                            <svg class="svg-title" width="37" height="34" viewBox="0 0 37 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="10" cy="24" r="10" fill="currentColor"></circle>
                                <circle cx="30" cy="13" r="7" fill="currentColor" fill-opacity="0.4"></circle>
                                <circle cx="15" cy="4" r="4" fill="currentColor" fill-opacity="0.7"></circle>
                            </svg>
                            <button class="plus-btn plus-3 plus3" type="button">افزودن اطلاعات شخص جدید</button>
                        </div>
                        <div class="parent-form-education duplicate-lang3 myform3">
                            <!-- <i class="fa-regular fa-xmark-large delete-item"></i>-->
                            <div class="item-input">
                                <label for="education-1">نام و نام خانوادگی</label>
                                <input type="text"  name="sendDocument[name][]" id='name' class="form-empty" placeholder="نام و نام خانوادگی شما...">
                                <i class="fa-light fa-book-open-cover icon-input-item"></i>
                            </div>
                            <div class="item-input">
                                <label for="education-3">کد ملی</label>
                                <input type="text"  name="sendDocument[national_code][]" class="form-empty" placeholder="کد ملی...">
                                <i class="fa-light fa-building-columns icon-input-item"></i>
                            </div>

                            <div class="item-input">
                                <label for="education-7">ایمیل</label>
                                <input type="text"  name="sendDocument[email][]" placeholder="ایمیل..." class="form-empty">
                                <i class="fa-light fa-star icon-input-item"></i>
                            </div>
                            <div class="item-input minus3">
                                <label for="education-8"> شماره همراه</label>
                                <input type="text"  name="sendDocument[mobile][]" placeholder="شماره همراه..." class="form-empty">
                                <i class="fa-light fa-book-open-cover icon-input-item"></i>
                            </div>



                        </div>

                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nopad ">

                        <h4 class='drop_zone-new-titr-uplod'>آپلود مدارک</h4>

                        <div class="drop_zone-new-parent-label">
                            <label for='gallery_files'
                                   id="drop_zone"
                                   class='drop_zone-new-label d-flex flex-wrap justify-content-center align-items-center  p-5 '
                                   ondrop="dropHandler(event , false , false);"
                                   ondragover="dragOverHandler(event);">
                                <p>##DropFiles##</p>
                            </label>
                        </div>


                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-0">
                            <div class="d-flex flex-wrap form-group gap-5 w-100">
                                <label for="gallery_files" class="control-label d-none">##Selectfile##</label>
                                <input onchange="dropHandler(event , false  , false)" type='file'
                                       class=' d-none'
                                       multiple  name='gallery_files[]' id='gallery_files'>

                                <div id='preview-gallery' class='drop_zone-new-parent-gallery'></div>
                            </div>
                        </div>
                    </div>
                    {*
                    <div class="item-input">
                        <div class="itemCapcha w-100" >
                            <input  type="number" placeholder="##Securitycode##" name="item-captcha" id="item-captcha">
                            <i class="icon-input-item">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M96 192V128C96 57.31 153.3 0 224 0C294.7 0 352 57.31 352 128V192H368C412.2 192 448 227.8 448 272V432C448 476.2 412.2 512 368 512H80C35.82 512 0 476.2 0 432V272C0 227.8 35.82 192 80 192H96zM128 192H320V128C320 74.98 277 32 224 32C170.1 32 128 74.98 128 128V192zM32 432C32 458.5 53.49 480 80 480H368C394.5 480 416 458.5 416 432V272C416 245.5 394.5 224 368 224H80C53.49 224 32 245.5 32 272V432z"/></svg>
                            </i>
                            <img id="captchaImage" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/captcha/securimage_show.php?sid=" alt="captcha image">
                            <a id="captchaRefresh" href="#" title="refresh image" onclick="reloadCaptcha(); return false"></a>
                        </div>
                    </div>
                    *}

                    <div class="btn-send">
                        <button type="submit" >ارسال اطلاعات</button>
                    </div>
                </form>
            </div>
            <div class="col-img">
                <div class="parent-img">
                    <img src="assets/images/2.png" alt="img">
                </div>
            </div>
        </div>
    </div>
</section>

{literal}
    <script src="assets/modules/js/sendDocuments.js"></script>
    <script src="assets/js/dropzone.js"></script>

{/literal}


