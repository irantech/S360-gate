{load_presentation_object filename="BookingReservationTicket" assign="objBooking"}
{load_presentation_object filename="members" assign="objMembers"}
{load_presentation_object filename="interactiveOffCodes" assign="objOffCode"}

{* variables needed to be set for display *}
{assign var='paymentType' value=''}
{assign var='paymentBank' value=''}
{assign var='bankTrackingCode' value=''}
{assign var='successPayment' value=''}
{assign var='errorPaymentMessage' value=''}
{assign var='offCode' value=''}

{assign var='paymentTypeBook' value=''}

{if $smarty.post.flag eq 'credit'}		{*پرداخت از طریق اعتبار*}

    {$paymentType = 'credit'}

    {if $smarty.post.factorNumber neq ''}
        {$successPayment = 'true'}
        {$objBooking->TicketBook($smarty.post.factorNumber, 'credit')}{*در جدول book مشخص میکند که پرداخت از اعتبار صورت گرفته*}
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

        {$objBooking->updateBank($smarty.post.trackingCode, $smarty.post.factorNumber)}
        {$objBooking->TicketBook($smarty.post.factorNumber, 'cash')}

        {if $objBooking->okTicket eq true}

            {* برای تثبیت استفاده خریدار از کد تخفیف *}
            {load_presentation_object filename="discountCodes" assign="objDiscountCodes"}
            {$objDiscountCodes->DiscountCodesUseConfirm($smarty.post.factorNumber)}

        {/if}

    {else}
        {$successPayment = 'false'}
        {$errorPaymentMessage = '##Sorrypayment##'}

        {$objBooking->delete_transaction_current($smarty.post.factorNumber)}
    {/if}

{else}		{*پرداخت از طریق بانکها*}

	{load_presentation_object filename="bank" assign="objBank"}
	{$objBank->initBankParams($smarty.get.bank)}
	{$objBank->executeBank('return')}

	{if $objBank->transactionStatus neq 'failed' && $objBank->trackingCode neq ''}

        {if $objBank->trackingCode eq 'member_credit'}
            {$paymentType = 'credit'}
            {$paymentTypeBook = 'member_credit'}
        {else}
            {$paymentType = 'cash'}
            {$paymentTypeBook = 'cash'}
            {$paymentBank = $objBank->bankTitle}
            {$bankTrackingCode = $objBank->trackingCode}
        {/if}
        {$successPayment = 'true'}

		{$objBooking->updateBank($objBank->trackingCode,$objBank->factorNumber)}
		{$objBooking->TicketBook($objBank->factorNumber, $paymentTypeBook)}

		{if $objBooking->okTicket eq true}

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

		{$objBooking->delete_transaction_current($objBank->factorNumber)}
	{/if}

{/if}


{* display with initialized variables *}
{if $successPayment eq 'true'}

	{if $objBooking->okTicket eq true}
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 Clr">
			<div class="main-bank-box">

				<div class="mbb-preload mbb-preload-icon">
					<img src="assets/images/pre-bank.png">
				</div>
				<h4 class="mbb-bank-title mbb-bank-title-green">
					<span>##Successpayment##      </span>
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
							<span class="pull-right">##TrackingCode## </span>
							<span class="pull-left">{$bankTrackingCode}</span>
						</p>
                    {/if}
					<p class="clearfix">
						<span class="pull-right"> ##Buydate##</span>
						<span class="pull-left">{$objFunctions->set_date_payment($objBooking->payment_date)}</span>
					</p>
					<p class="clearfix">
						<span class="pull-right"> ##Invoicenumber##</span>
						<span class="pull-left">{$objBooking->factor_number}</span>
					</p>
				</div>

                {assign var='arrRequestNumber' value=$objBooking->getRequestNumberTicket($objBooking->factor_number)}
                {foreach $arrRequestNumber as $val}
					<div class="s-u-update-popup-change">
						<div class="s-u-bank-item s-u-bank-item-tiket-print">
							<a  id="myBtn" onclick="modalListForReservationTicket('{$val['request_number']}');" class="btn btn-primary-green fa fa-eye site-border-main-color">
								<p class="s-u-bank-title">  ##Showbuy## {$val['direction']} </p>
							</a>
						</div>
						<div class="s-u-bank-item s-u-bank-item-tiket-print">
							<a href="{$smarty.const.ROOT_ADDRESS}/eReservationTicket&num={$val['request_number']}" class="btn btn-primary-green fa fa-print site-border-main-color" target="_blank">
								<p class="s-u-bank-title"> ##Print## {$val['direction']} </p>
							</a>
						</div>
						<div class="s-u-bank-item s-u-bank-item-tiket-print">
							<a href="{$smarty.const.ROOT_ADDRESS}/pdf&target=BookingReservationTicket&id={$val['request_number']}" class="btn btn-primary-green fa fa-file-pdf-o site-border-main-color" target="_blank">
								<p class="s-u-bank-title">pdf {$val['direction']}</p>
							</a>
						</div>
                        {*<div class="s-u-bank-item s-u-bank-item-tiket-print">
                            <a onclick="modalEmail('{$val['request_number']}');" class="btn btn-primary-green fa fa-envelope-o site-border-main-color" target="_blank">
                                <p class="s-u-bank-title">ارسال ایمیل</p>
                            </a>
                        </div>*}

                        {* نمایش کد ترانسفر پس از خرید موفق *}
                        {if $offCode eq ''}
                            {$offCode = $objOffCode->offCodeUse($val['ticket_info']['factor_number'], $val['ticket_info']['serviceTitle'], $val['ticket_info']['desti_airport_iata'], $val['ticket_info']['origin_airport_iata'])}
                        {/if}

					</div>
                {/foreach}

                {if $offCode neq ''}
					<div class="txtGreen txt17 marb10">

                        {assign var='code' value=$offCode['code']}
                        {assign var='title' value=$offCode['title']}
                        {functions::StrReplaceInXml(["@@CodeDiscount@@"=>$code,"@@title@@"=>$title],"AwardDiscountCode")}

					</div>
                {/if}

			</div>
		</div>
    {else}
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 Clr">
			<div class="main-bank-box">
				<div class="mbb-preload mbb-preload-icon-alert">
					<img src="assets/images/pre-bank-red.png">
				</div>
				<h4 class="mbb-bank-title mbb-bank-title-red">
					<span>##ProblemreservationTour##</span>
				</h4>
				<div class="mbb-detail">
					<p class="clearfix txtCenter">
        				{if $objResult->errorMessage neq ''}
							<span class="txtCenter">{$objResult->errorMessage}</span>
						{else}
							<span class="txtCenter">
								    {if $paymentType eq 'credit'}
                                        {functions::StrReplaceInXml(["@@PaymentType@@"=>"##Validity##","@@typeReserve@@"=>"##BookTicket##"],"ErrorReserveReturnBank")}
                                    {else}
                                        {functions::StrReplaceInXml(["@@PaymentType@@"=>"##Vajh##","@@typeReserve@@"=>"##BookTicket##"],"ErrorReserveReturnBank")}

                                    {/if}
							</span>
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
<div class="loaderPublic" style="display: none;">
	<div class="positioning-container">
		<div class="spinning-container">
			<div class="airplane-container"><span class="zmdi zmdi-airplane airplane-icon site-main-text-color"></span></div>
		</div>
	</div>

	<div class='loader'>
		<div class='loader_overlay'></div>
		<div class='loader_cogs'>
			<i class="fa fa-globe site-main-text-color-drck"></i>
		</div>
	</div>
</div>
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
                    <label>##SendEmailForOther##</label>
                </div>

				<div class="col-md-11 margin-10">
                    <input type="email" class="form-control margin-10 text-left" name="Email" id="SendForOthers">
                    <input type="hidden" class="form-control margin-10 text-left" name="factor_number" id="factor_number">
                </div>

                <div class="col-md-2">
                    <img src="assets/images/load21.gif" style="display:none; top: 10px !important; right:35px !important" class="loader-tracking" id="loaderTracking" >
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="col-md-12 text-left" >

                <input type="button" class="btn btn-success margin-10" value="##Send##"  onclick="SendHotelEmailForOther();" id="SendEmailForOther">
                <input  class="close btn btn-danger margin-10" onclick="modalEmailClose()" type="button" value="##Closing##">
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>