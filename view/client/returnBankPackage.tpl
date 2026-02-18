{load_presentation_object filename="BookingHotelNew" assign="objBookingNew"}
{load_presentation_object filename="parvazBookingLocal" assign="objBookingLocal"}
{load_presentation_object filename="members" assign="objMembers"}
{load_presentation_object filename="interactiveOffCodes" assign="objOffCode"}
{* variables needed to be set for display *}
{assign var='paymentType' value=''}
{assign var='paymentBank' value=''}
{assign var='bankTrackingCode' value=''}
{assign var='successPayment' value=''}
{assign var='errorPaymentMessage' value=''}
{assign var='offCode' value=''}

{if $smarty.post.flag eq 'credit'}{*پرداخت از طریق اعتبار*}
    {$paymentType = 'credit'}
    {if $smarty.post.factorNumber neq ''}
        {$successPayment = 'true'}
        {$objBookingLocal->flightBook($smarty.post.factorNumber, 'credit')} {*در جدول book مشخص میکند که پرداخت از اعتبار صورت گرفته*}

        {if $objBookingLocal->ok_flight['TwoWay'] eq true}
            {$objBookingNew->HotelBookCredit($smarty.post.factorNumber, 'credit')}{*در جدول book مشخص میکند که پرداخت از اعتبار صورت گرفته*}
        {/if}
    {else}
        {$successPayment = 'false'}
        {$errorPaymentMessage = '##Sorrypayment##'}
    {/if}

{elseif $smarty.post.flag eq 'currencyPayment'}     {* پرداخت ارزی *}

    {$paymentType = 'currency'}
    {$paymentBank = '##currency##'}

    {if $smarty.post.trackingCode neq ''}
        {$successPayment = 'true'}
        {$bankTrackingCode = $smarty.post.trackingCode}

        {$objBookingLocal->updateBank($smarty.post.trackingCode, $smarty.post.factorNumber)}
        {$objBookingLocal->flightBook($smarty.post.factorNumber)}
        {if $objBookingLocal->ok_flight['TwoWay'] eq true}
            {$objBookingNew->updateBank($smarty.post.trackingCode, $smarty.post.factorNumber)}
            {$objBookingNew->HotelBook($smarty.post.factorNumber)}

            {* برای تثبیت استفاده خریدار از کد تخفیف *}
            {load_presentation_object filename="discountCodes" assign="objDiscountCodes"}
            {$objDiscountCodes->DiscountCodesUseConfirm($smarty.post.factorNumber)}

        {/if}

    {else}
        {$successPayment = 'false'}
        {$errorPaymentMessage = '##Sorrypayment##'}

        {$objBookingLocal->delete_transaction_current($smarty.post.factorNumber)}
    {/if}

{else}      {*پرداخت از طریق بانکها*}

    {load_presentation_object filename="bank" assign="objBank"}
    {$objBank->initBankParams($smarty.get.bank)}
    {$objBank->executeBank('return')}

    {if $objBank->transactionStatus neq 'failed' && $objBank->trackingCode neq ''}
        {if $objBank->trackingCode eq 'member_credit'}
            {$paymentType = 'credit'}
        {else}
            {$paymentType = 'cash'}
            {$paymentBank = $objBank->bankTitle}
            {$bankTrackingCode = $objBank->trackingCode}
        {/if}
        {$successPayment = 'true'}
        {$objBookingLocal->updateBank($objBank->trackingCode,$objBank->factorNumber)}
        {$objBookingLocal->flightBook($objBank->factorNumber,'Cash')}

        {if $objBookingLocal->ok_flight['TwoWay'] eq true}

            {$objBookingNew->updateBank($objBank->trackingCode, $objBank->factorNumber)}
            {$objBookingNew->HotelBook($objBank->factorNumber)}

            {* برای تثبیت استفاده خریدار از کد تخفیف *}

            {load_presentation_object filename="discountCodes" assign="objDiscountCodes"}
            {$objDiscountCodes->DiscountCodesUseConfirm($objBank->factorNumber)}

            {* برای تثبیت اعتبار کسر شده در هنگام خرید مسافر آنلاین *}
            {$objMembers->memberCreditConfirm($objBank->factorNumber, $objBank->trackingCode)}

            {* برای ثبت اعتبار تخفیف کد معرف به معرف خریدار در صورتی که اولین خرید باشد *}
            {if $objSession->IsLogin()}
                {$objMembers->addCreditToReagent()}
            {/if}

        {/if}

    {else}
        {$successPayment = 'false'}
        {$errorPaymentMessage = $objBank->failMessage}

        {$objBookingLocal->delete_transaction_current($objBank->factorNumber)}
    {/if}

{/if}

{if $successPayment eq 'true'}

    {if $objBookingNew->okHotel eq true}
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 Clr">
            <div class="main-bank-box">

                <div class="mbb-preload mbb-preload-icon">
                    <img src="assets/images/pre-bank.png">
                </div>
                <h4 class="mbb-bank-title mbb-bank-title-green">
                    <span>##Successpayment## </span>
                </h4>

                <div class="mbb-detail">
                    <p class="clearfix">
                        <span class="pull-right">
                            {if $paymentType eq 'cash'}##Agentbank## {else}##Typepayment## {/if}
                        </span>
                        <span class="pull-left">{if $paymentBank neq ''}{$paymentBank}{else}##Credit##{/if}</span>
                    </p>
                    {if $paymentType eq 'cash'}
                        <p class="clearfix">
                            <span class="pull-right"> ##TrackingCode##</span>
                            <span class="pull-left">{$bankTrackingCode}</span>
                        </p>
                    {/if}
                    {*<p class="clearfix">
                        <span class="pull-right">تاریخ خرید </span>
                        <span class="pull-left">*}{*$objFunctions->set_date_payment($objBookingNew->payment_date)*}{*</span>
					</p>*}
                    <p class="clearfix">
                        <span class="pull-right"> ##Invoicenumber##</span>
                        <span class="pull-left">{$objBookingNew->factor_number}</span>
                    </p>
                </div>

                <div class="s-u-update-popup-change">
                    {*<div class="s-u-bank-item s-u-bank-item-tiket-print">
                        <a  id="myBtn" onclick="modalListForHotel('{$objBookingNew->factor_number}');" class="btn btn-primary-green fa fa-eye site-border-main-color">
                            <p class="s-u-bank-title">مشاهده رزرو </p>
                        </a>
                    </div>*}

                    <div class="s-u-bank-item s-u-bank-item-tiket-print">
                        <a href="{$smarty.const.ROOT_ADDRESS}/{$linkView}&num={$objBookingNew->factor_number}"  class="btn btn-primary-green fa fa-print site-border-main-color" target="_blank">
                            <p class="s-u-bank-title">##Printreservation##  </p>
                        </a>
                    </div>


                    <div class="s-u-bank-item s-u-bank-item-tiket-print">
                        <a href="{$smarty.const.ROOT_ADDRESS}/pdf&target={$linkPDF}&id={$objBookingNew->factor_number}" class="btn btn-primary-green fa fa-file-pdf-o site-border-main-color" target="_blank">
                            <p class="s-u-bank-title"> ##Download## pdf </p>
                        </a>
                    </div>

                    {if $objBookingNew->type_application eq 'foreignApi'}
                        <div class="s-u-bank-item s-u-bank-item-tiket-print">
                            <a href="{$smarty.const.ROOT_ADDRESS}/pdf&target=bookhotelshow&id={$objBookingNew->factor_number}" class="btn btn-primary-green fa fa-file-pdf-o site-border-main-color" target="_blank">
                                <p class="s-u-bank-title"> ##Englishpdf## </p>
                            </a>
                        </div>
                    {else}
                        <div class="s-u-bank-item s-u-bank-item-tiket-print">
                            <a onclick="modalEmail('{$objBookingNew->factor_number}');"  class="btn btn-primary-green fa fa-envelope-o site-border-main-color" target="_blank">
                                <p class="s-u-bank-title">##Sendemail## </p>
                            </a>
                        </div>
                    {/if}

                    {* نمایش کد ترانسفر پس از خرید موفق *}
                    {*{$offCode = $objOffCode->offCodeUse($objBookingNew->hotelInfo['factor_number'], $objBookingNew->hotelInfo['serviceTitle'], $objBookingNew->hotelInfo['destination_iata'])}
                    {if $offCode neq ''}
						<div class="txtGreen txt17 marb10">تبریک؛ شما موفق به دریافت {$offCode['title']} با کد {$offCode['code']} گشتید</div>
                    {/if}*}
                </div>
            </div>
        </div>
    {else}
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 Clr">
            <div class="main-bank-box">
                <div class="mbb-preload mbb-preload-icon-alert">
                    <img src="assets/images/pre-bank-red.png">
                </div>
                <h4 class="mbb-bank-title mbb-bank-title-red">
                    <span>##ProblemreservationHotel##</span>
                </h4>
                <div class="mbb-detail">
                    <p class="clearfix txtCenter">
                        {if $objBookingNew->errorMessage neq ''}
                            <span class="txtCenter">{$objBookingNew->errorMessage}</span>
                        {else}
                            <span class="txtCenter">##Incasehotelreservationpleasecontactcompanyrefund##</span>
                        {/if}
                    </p>
                </div>
            </div>
        </div>
    {/if}

{else}
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 Clr">
        <div class="main-bank-box">
            <div class="mbb-preload mbb-preload-icon-alert">
                <img src="assets/images/pre-bank-red.png">
            </div>
            <h4 class="mbb-bank-title mbb-bank-title-red">
                <span>##Note##</span>
            </h4>
            <div class="mbb-detail">
                <p class="clearfix txtCenter">
                    <span class="txtCenter">{$errorPaymentMessage}</span>
                </p>
            </div>
        </div>
    </div>
{/if}