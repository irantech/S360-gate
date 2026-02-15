<section class="pay">
        <div class="container">
                <div class="parent-pay">
                        <div class="parent-form-pay col-lg-6 col-md-12 col-sm-12 col-12 ">
                                <h2>##S360OnlinePay##</h2>
                                <p>##PaymentShatabCards##</p>
                            <form data-toggle="validator" id="onlinePaymentAdd" method="post">
                                <input type="hidden" name="flag" value="onlinePaymentAdd">
                                <span id="amount_number_under" class='error-tracking'></span>
                                <input type="text"  id="tracking_code" name="tracking_code" onkeyup="checkTrackingCode(value)"  placeholder="##TrackingCode##...">
                                <input type="text" id="amount_number"  name="amount" readonly  placeholder="##DepositAmounted##...">
                                <input type="text"  id="name" name="name" placeholder="##YourNameFamily##...">
                                <input type="text"  id="mobile" name="mobile" placeholder="##YourMobileNumber##...">
                                <div class="item-form">
                                        <div class="login-captcha gds-l-r-error">
                                            <div class="itemCapcha"  >
                                                <input  type="number" placeholder="##Securitycode##" name="item-captcha" id="item-captcha">
                                                <img id="captchaImage" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/captcha/securimage_show.php?sid=" alt="captcha image">

                                                <a id="captchaRefresh" href="#" title="refresh image" onclick="reloadCaptcha(); return false"></a>
                                            </div>
                                        </div>
                                </div>
                                <input type="hidden" id="reason"  name="reason"  >
                                <button  class="btn-form" type="submit">ادامه و پرداخت</button>
                                </form>
                        </div>
                        <div class="parent-img col-6 p-0">
                                <div class="owl-carousel owl-theme owl-pay">
                                        <div class="item">
                                                <img src="assets/images/pay/pay.png" alt="img-pay">
                                        </div>
                                        <div class="item">
                                                <img src="assets/images/pay/pay2.png" alt="img-pay">
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
</section>
{literal}
    <script src="assets/modules/js/pay/script.js"></script>
    <script src="assets/modules/js/pay/owl.carousel.min.js"></script>
{/literal}