{load_presentation_object filename="bookingBusTicket" assign="objBookingBus"}
{load_presentation_object filename="members" assign="objMembers"}
{load_presentation_object filename="interactiveOffCodes" assign="objOffCode"}

{* variables needed to be set for display *}
{assign var='paymentType' value=''}
{assign var='paymentBank' value=''}
{assign var='bankTrackingCode' value=''}
{assign var='successPayment' value=''}
{assign var='factor_number' value=''}
{assign var='errorPaymentMessage' value=''}
{assign var='offCode' value=''}

{if isset($smarty.get.factorNumber) && $smarty.get.factorNumber neq ''}
	{$factor_number=$smarty.get.factorNumber}
{else}
	{$factor_number=$smarty.post.factorNumber}
{/if}


{if isset($smarty.get.PayanehaOrderCode)} {*پرداخت از طریق درگاه پایانه (wecan)*}

    {$paymentType = 'cash'}
    {$successPayment = 'true'}
    {$objBookingBus->setBookForPaymentFromPayaneha()}


{elseif $smarty.post.flag eq 'credit'}		{*پرداخت از طریق اعتبار*}

    {$paymentType = 'credit'}

    {if $factor_number neq ''}

        {$successPayment = 'true'}
        {$objBookingBus->setBook('credit',$factor_number)}{*در جدول book مشخص میکند که پرداخت از اعتبار صورت گرفته*}
    {else}
		{$objBookingBus->callFailed('credit',$factor_number,'مشکل در پرداخت اعتباری')}
        {$successPayment = 'false'}
        {$errorPaymentMessage = '##Sorrypayment##'}
    {/if}

{elseif $smarty.post.flag eq 'currencyPayment'}     {* پرداخت ارزی *}

    {$paymentType = 'currency'}
    {$paymentBank = '##currency##'}

    {if $smarty.post.trackingCode neq ''}
        {$successPayment = 'true'}
        {$bankTrackingCode = $smarty.post.trackingCode}

        {$objBookingBus->updateBank($smarty.post.trackingCode, $smarty.get.factorNumber)}
        {$objBookingBus->setBook()}

        {if $objBookingBus->statusBook eq true}

            {* برای تثبیت استفاده خریدار از کد تخفیف *}
            {load_presentation_object filename="discountCodes" assign="objDiscountCodes"}
            {$objDiscountCodes->DiscountCodesUseConfirm($smarty.get.factorNumber)}

        {/if}

    {else}
        {$successPayment = 'false'}
        {$errorPaymentMessage = '##Sorrypayment##'}
		{$objBookingBus->callFailed('arzi',$factor_number,'مشکل در پرداخت ارزی')}
        {$objBookingBus->delete_transaction_current($smarty.get.factorNumber)}
    {/if}

{else}		{*پرداخت از طریق بانکها*}


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

		{$objBookingBus->updateBank($objBank->trackingCode, $objBank->factorNumber)}
        {$objBookingBus->setBook('cash',$objBank->factorNumber)}

		{if $objBookingBus->statusBook eq true}

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

		{$objBookingBus->callFailed('cash',$factor_number,$errorPaymentMessage)}
		{$objBookingBus->delete_transaction_current($objBank->factorNumber)}
	{/if}

{/if}


{* display with initialized variables *}
{if $successPayment eq 'true'}

	{if $objBookingBus->statusBook eq true && ($objBank->factorNumber neq '' || $factor_number neq '')}
		{if isset($objBank->factorNumber) && $objBank->factorNumber neq ''}
			{assign var='finalFactorNumber' value=$objBank->factorNumber}
			{else}
			{assign var='finalFactorNumber' value=$factor_number}
		{/if}
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 Clr">
			<div class="main-bank-box">

				<div class="mbb-preload mbb-preload-icon">
					<img src="assets/images/pre-bank.png">
				</div>
				<h4 class="mbb-bank-title mbb-bank-title-green">
					<span>##Successpayment##</span>
				</h4>

				<div class="mbb-detail">
					<p class="clearfix">
                        <span class="pull-right">
                            {if $paymentType eq 'cash'}##Agentbank## {else}##Typepayment## {/if}
                        </span>
						<span class="pull-left">{if $paymentBank neq ''}{$paymentBank}{else}##Credit##{/if}</span>
					</p>

                    {if $paymentType eq 'cash' && $bankTrackingCode neq ''}
						<p class="clearfix">
							<span class="pull-right"> ##TrackingCode##</span>
							<span class="pull-left">{$bankTrackingCode}</span>
						</p>
                    {/if}

					<p class="clearfix">
						<span class="pull-right"> ##Invoicenumber##</span>
						<span class="pull-left">{$finalFactorNumber}</span>
					</p>
				</div>

				<div class="d-flex flex-wrap gap-10 justify-content-center gap-column-20">
					<a class="w-sm-12" href="{$smarty.const.ROOT_ADDRESS}/eBusTicket&num={$finalFactorNumber}">
						<button type="button" class="align-items-center btn btn-labeled btn-outline-primary d-flex font-12 justify-content-between w-100">
							<span class="btn-label"><i class="fa fa-print"></i></span>
							<span class="d-flex justify-content-center w-100">##Printreservation##</span>
						</button>
					</a>

					<a class="w-sm-12" href="{$smarty.const.ROOT_ADDRESS}/pdf&target=bookingBusShow&id={$finalFactorNumber}">
						<button type="button" class="align-items-center btn btn-labeled btn-outline-warning d-flex font-12 justify-content-between w-100">
							<span class="btn-label"><i class="fa fa-file-pdf-o"></i></span>
							<span class="d-flex justify-content-center w-100">##Download## pdf</span>
						</button>
					</a>

					<a class="w-sm-12" onclick="modalEmail('{$finalFactorNumber}');" target="_blank">
						<button type="button" class="align-items-center btn btn-labeled btn-outline-info d-flex font-12 justify-content-between w-100">
							<span class="btn-label"><i class="fa fa-envelope-o"></i></span>
							<span class="d-flex justify-content-center w-100">##Sendemail##</span>
						</button>
					</a>
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
					<span>##Problemreservation##</span>
				</h4>
				<div class="mbb-detail">
					<p class="clearfix txtCenter">
                        {if $objBookingBus->errorMessage neq ''}
							<span class="txtCenter">{$objBookingBus->errorMessage}</span>
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


{* info modal to display *}
<div id="ModalPublic" class="modal">
	<div class="modal-content" id="ModalPublicContent"></div>
</div>


{* email modal to display *}
<div id="ModalSendEmail" class="modal" >

    <!-- Modal content -->
    <div class="modal-content" style="width:56%">
        <div class="modal-header">
            <span class="close CloseEmail" onclick="modalEmailClose()">&times;</span>
            <h6 class="modal-h">##Sendemailanother##     </h6>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <label>##SendHotelToAnother##</label>
                </div>

				<div class="col-md-11 margin-10">
                    <input type="email" class="form-control margin-10 text-left" name="Email" id="SendForOthers">
                </div>

                <div class="col-md-2">
                    <img src="assets/images/load21.gif" style="display:none; top: 10px !important; right:35px !important" class="loader-tracking" id="loaderTracking" >
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="col-md-12 text-left" >
				<input type="hidden" id="typeApplication" name="typeApplication" value="busTicket">
				<input type="hidden" id="factorNumber" name="factorNumber" value="{$objBank->factorNumber}">
                <input type="button" class="btn btn-success margin-10" value="##Send##"  onclick="SendHotelEmailForOther();" id="SendEmailForOther">
                <input  class="close btn btn-danger margin-10" onclick="modalEmailClose()" type="button" value="##Closing##">
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>