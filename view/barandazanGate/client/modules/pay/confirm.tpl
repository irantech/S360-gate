{load_presentation_object filename="onlinePayment" assign="objOnlinePayment"}
{assign var="info_online_payment" value=$objOnlinePayment->getOnlinePaymentClient($smarty.get.id)}

{if $info_online_payment['id']}
<section class="pay">
    <div class="container">
        <div class="parent-pay">
            <div class="parent-form-pay col-lg-6 col-md-12 col-sm-12 col-12 ">
                <h2>##S360OnlinePay##</h2>
                <p>##ConfirmInformationClickConnectBank##</p>
                <form data-toggle="validator" id="onlinePaymentConfirm" method="post">
                    <input type="hidden" name="flag" value="onlinePaymentConfirm">
                    <input type="hidden" name="payId" value="{$info_online_payment['id']}">
                    <input type="text" id="amount_number"  name="amount" value="{$info_online_payment['amount']}ریال" disabled placeholder="##DepositAmounted##...">
                    <input type="text"  id="name" name="name" value="{$info_online_payment['name']}" disabled placeholder="##YourNameFamily##...">
                    <input type="text"  id="mobile" name="mobile" value="{$info_online_payment['phone']}" disabled placeholder="##YourMobileNumber##...">

                </form>

                <!-- bank connect -->

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 s-u-passenger-wrapper-change "
                     style="padding: 0">

                    <!-- payment methods drop down -->
                    {assign var="memberCreditPermition" value="0"}
                    {if $objSession->IsLogin() && $objMember->list['fk_counter_type_id'] == '5'}
                        {$memberCreditPermition = "1"}
                    {/if}

                    {assign var="counterCreditPermition" value="0"}
                    {if $objSession->IsLogin() && $objMember->list['fk_counter_type_id'] != '5'}
                        {$counterCreditPermition = "1"}
                    {/if}

                    {assign var="bankInputs" value=['flag' => 'check_credit_online_pay', 'requestNumber' => $info_online_payment['code'],'typeTrip' => 'onlinePayment', 'paymentPrice' => $info_online_payment['amount']]}
                    {assign var="bankAction" value="`$smarty.const.ROOT_ADDRESS`/goBankOnlinePayment"}

                    {assign var="creditInputs" value=['flag' => 'buyByCreditPackage',  'requestNumber' => $info_online_payment['code']]}
                    {assign var="creditAction" value="`$smarty.const.ROOT_ADDRESS`/returnBankOnlinePayment"}

                    <!-- payment methods drop down -->
                    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`paymentMethods.tpl"}

                </div>

                <!--BACK TO TOP BUTTON-->
                <div class="backToTop"></div>
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
{/if}