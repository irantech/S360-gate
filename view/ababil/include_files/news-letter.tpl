<div class="col-lg-4 col-12 mt-lg-0 mt-3">
    <div class="newsLetters_main">
        <h3>عضو خبرنامه ابابیل 24 شوید!</h3>
        <style>


            .itemCapcha{
                display: flex;
                border: 1px solid #f2f2f2;
                border-radius: 0 12px 12px 0;
            }

            #captchaRefresh {
                width: 50px !important;
                background: url("assets/images/refresh.png") no-repeat center center;
                background-size: auto;
                background-image: url("assets/images/refresh.png");
                background-size: auto;
                margin: 10px;
            }
            .itemCapcha input {
                border: none !important;
            }
            input[type="number"]
            {
                -moz-appearance: textfield;
            }


        </style>
        <form>
            <input class="full-name-js"  name='NameSms' id="NameSms" type="text" placeholder="نام و نام خانوادگی">
            <input class="email-js"  name="EmailSms" id="EmailSms" type="email" placeholder="پست الکترونیکی">
            <input class="mobile-js"  name="CellSms" id="CellSms" type="text" placeholder="شماره موبایل">

            <div class="item-input">
                <div class="itemCapcha" >
                    <input  type="number" placeholder="##Securitycode##" class="capcha-js" name="item-captcha" id="item-captcha">
                    <img id="captchaImage" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/captcha/securimage_show.php?sid=" alt="captcha image">
                    <a id="captchaRefresh" href="#" title="refresh image" onclick="reloadCaptcha(); return false"></a>
                </div>
                <input type='hidden' name='has-capcha' class='has-capcha' value='1'>

            </div>

            <button type="button"  onclick="submitNewsLetter()" > ثبت و عضویت </button>
        </form>
    </div>
</div>

<script>
  function reloadCaptcha() {
    var capcha = amadeusPath + 'captcha/securimage_show.php?sid=' + Math.random();
    $("#captchaImage").attr("src", capcha);
  }
</script>