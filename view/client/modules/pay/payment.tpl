{load_presentation_object filename="onlinePayment" assign="objOnline"}
{assign var='bank_list' value=$objOnline->getBankList()}
{assign var="payId" value=$smarty.const.PAY_ID}
{assign var='get_pay_data' value=$objOnline->getPayDataSite($payId)}
{*{$payId|var_dump}*}
{*{$get_pay_data["is_active"]|var_dump}*}
<section class="pay">
        <div class="">
                <div class="parent-pay">
                        <div class="parent-form-pay col-lg-6 col-md-12 col-sm-12 col-12   ">
                                <h2>##S360OnlinePay##</h2>
                                <p>##PaymentShatabCards##</p>
                            <form data-toggle="validator" id="onlinePaymentAdd" method="post" class='item-form-result'>
                                {if $payId && $get_pay_data["is_active"] eq 0}
                                <span class='error-exp'>لینک منقضی شده یا وجود ندارد</span>
                                {/if}
                                <input type="hidden" name="flag" value="onlinePaymentAdd">
                                <input type="text"  id="name" name="name" placeholder="##Namefamily##...">
                                <input type="text"  id="mobile" name="mobile" placeholder="##YourMobileNumber##...">
                                <div class='w-100 position-relative'>
                                    {if $payId}
                                    <input type="text"  id="price11" disabled  name="price11"  value="{$get_pay_data["price"]}" placeholder="##Depositamount##...">
                                    <input type="hidden"  id="price"   name="price"  value="{$get_pay_data["price"]}" placeholder="##Depositamount##...">
                                    <input type="hidden"  id="tracking_code_admin"  name="tracking_code_admin"  value="{$get_pay_data["tracking_code"]}" >
                                    {else}
                                    <input type="text"  id="price"  name="price"  placeholder="##Depositamount##...">
                                    {/if}
                                    <span class='riyal'>ریال</span>
                                </div>
                                <textarea  name="reason" id="reason" cols="5" rows="2" placeholder="توضیحات واریزی ..."></textarea>
                                <div class="item-form" style='display: block'>
                                    <div class="login-captcha gds-l-r-error">
                                        <span>
                                             <div class="itemCapcha"  >
                                            <input  type="number" placeholder="##Securitycode##" name="item-captcha" id="item-captcha">
                                            <img id="captchaImage" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/captcha/securimage_show.php?sid=" alt="captcha image">
                                            <a id="captchaRefresh" href="#" title="refresh image" onclick="reloadCaptcha(); return false"></a>
                                        </div>
                                        </span>
                                    </div>
                                </div>
                                {if $payId && $get_pay_data["is_active"] eq 0}
                                <button disabled class="btn-form btn-form-result" id="submit" type="submit" style='display: block'>
                                    <div style='display: none' class="loading-spinner"></div>
                                    <i>ادامه و پرداخت</i>
                                </button>
                                {else}
                                <button  class="btn-form btn-form-result" id="submit" type="submit" style='display: block'>
                                    <div style='display: none' class="loading-spinner"></div>
                                    <i>ادامه و پرداخت</i>
                                </button>
                                {/if}
                            </form>
                            <div class='result-pay' id="showResult" style='display: none'>

                                <div class='show-info-payment'><span>نام و نام خانوادگی:</span><span id='resultName'></span></div>
                                <div class='show-info-payment'><span>شماره همراه:</span><span id='resultMobile'></span></div>
                                <div class='show-info-payment'>
                                    <span>مبلغ:</span>
                                    <span id='resultPrice'></span>
                                    <span class='riyal'>ریال</span>
                                </div>
{*                                <div class='show-info-payment'><span>بابت:</span><span id='resultReasonPay'></span></div>*}
{*                                <div><span>کد رهگیری:</span><span id='resultCode'></span></div>*}

{*                                <input type="text" id='result_id' name="result_id" value="">*}
                                <input type="hidden" id='result_code' name="result_code" value="">
{*                                <input type="text" id='result_amount' name="result_amount" value="">*}
                                <!-- bank connect -->
                                {if $bank_list|count>0}
                                    <div class="bank_style-new">
                                        {foreach $bank_list as $key => $bank}
                                            <label class="custom-radio">
                                                <input type="radio" {if $key eq 0}checked {/if}value="{$bank['bank_dir']}" name="bank_to_pay">
                                                <span class='radio-btn'>
                                                    <svg class='svg-check' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M470.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L192 338.7 425.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>
                                                    <div class='hobbies-icon'>
                                                        <img src="assets/images/bank/bank{$bank['title_en']}.png" alt="{$bank['title']}">
                                                        <span>{$bank['title']}</span>
                                                    </div>
                                                </span>
                                            </label>
                                        {/foreach}
                                    </div>
                                    <div class='parent-pay-last'>
                                        {assign var="bankInputs" value=['serviceType' => 'onlinePayment']}
                                        {assign var="bankAction" value="`$smarty.const.ROOT_ADDRESS`/goBankOnlinePayment"}
                                        <span class='riyals'>ریال</span>
                                        <input type="text" class="input-number-last" readonly name="amount_to_pay" id="amount_to_pay" placeholder='مبلغ مورد نظر را وارد نمایید'>
                                        <button class=" cashPaymentLoader" onclick='goBankOnlinePayment("{$bankAction}",{$bankInputs|json_encode})'><i>پرداخت</i></button>
                                    </div>
                                {else}
                                    <div class="pay-error">
                                        <p>درگاه پرداخت بانک تعریف نشده است.
                                            <br>
                                            لطفا درگاه پرداخت تعریف کنید.
                                        </p>
                                    </div>
                                    <div class='parent-pay-last'>
                                        {assign var="bankInputs" value=['serviceType' => 'onlinePayment']}
                                        {assign var="bankAction" value="`$smarty.const.ROOT_ADDRESS`/goBankOnlinePayment"}
                                        <span class='riyals'>ریال</span>
                                        <input type="text" class="input-number-last" readonly name="amount_to_pay" id="amount_to_pay" placeholder='مبلغ مورد نظر را وارد نمایید'>
                                        <button class=" cashPaymentLoader" disabled><i>پرداخت</i></button>
                                    </div>
                                {/if}
                                <!--BACK TO TOP BUTTON-->
                                <div class="backToTop"></div>
                            </div>
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

    <script src="assets/modules/js/pay/payment.js"></script>
    <script src="assets/modules/js/pay/owl.carousel.min.js"></script>
{/literal}
