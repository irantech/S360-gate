{load_presentation_object filename="bookingTrain" assign="objBookingLocal"}
{load_presentation_object filename="members" assign="objMembers"}
{load_presentation_object filename="interactiveOffCodes" assign="objOffCode"}

{assign var="TotalPraiceWithOutDiscount" value=''}
{assign var="TicketAmount" value=''}

{* variables needed to be set for display *}
{assign var='paymentType' value=''}
{assign var='paymentBank' value=''}
{assign var='bankTrackingCode' value=''}
{assign var='successPayment' value=''}
{assign var='errorPaymentMessage' value=''}
{assign var='offCode' value=''}

{if $smarty.post.flag eq 'credit'}

    {assign var="factorNumber" value=$smarty.post.factorNumber}
    {assign var="ServiceCode" value=$smarty.post.ServiceCode}
    {assign var="TicketNumber" value=$smarty.post.ticket_number}
    {assign var="TicketNumberReturn" value=$smarty.post.ticket_number_return}
	{$TotalPraiceWithOutDiscount=$objBookingLocal->TotalPriceByFactorNumberWithOutDiscount($factorNumber)}
	{assign var='updateFlag' value=["factor_number"=>$factorNumber,"type"=>"credit"]}
		{if $data[0]['is_registered'] eq '0' }
			{$objBookingLocal->changeFlagTrain($updateFlag)}
		{/if}
    {assign var="data" value=$objBookingLocal->GetInfoBookWithFactorNumber($factorNumber)}
    {*پرداخت از طریق اعتبار*}
    {$paymentType = 'credit'}
	{assign var="dataRequestRegisterDept" value=['code'=>$data[0]['requestNumber'],'TicketNumber'=>$data[0]['TicketNumber'],'typeRoute'=>'ONEWAY']}
	{if $data[0]['is_registered'] eq '0' }

	{assign var="RegisterTicket" value=$objBookingLocal->RegisterTicket($dataRequestRegisterDept)}
	{/if}
	{if $RegisterTicket eq 1 && $data[0]['is_registered'] eq '0'}

		{assign var="dataRequestGetAmuntTicket" value=['TicketNumberDept'=>$data[0]['TicketNumber'],'TicketNumberReturn'=>$data[1]['TicketNumber'],'code'=>$data[0]['requestNumber']]}
		{$TicketAmount = $objBookingLocal->GetTicketAmount($dataRequestGetAmuntTicket)}
	{/if}

	{if $data[1]['TicketNumber'] neq '' && $data[1]['is_registered'] eq '0'}

		{assign var="dataRequestRegisterReturn" value=['code'=>$data[1]['requestNumber'],'TicketNumber'=>$data[1]['TicketNumber'],'typeRoute'=>'TOWEWAY']}
		{assign var="RegisterTicketReturn" value=$objBookingLocal->RegisterTicket($dataRequestRegisterReturn)}
	{/if}
	{if $data[1]['TicketNumber'] eq '' && $data[0]['is_registered'] eq '0'}

			{if $RegisterTicket eq 1 }
			{*&& $TotalPraiceWithOutDiscount eq $TicketAmount*}
				{$successPayment = 'true'}
				{$objBookingLocal->trainBook($factorNumber, 'credit')}{* در جدول book مشخص میکند که پرداخت از اعتبار صورت گرفته*}
			{else}

				{if $data[0]['is_registered'] eq '0'}
					{$successPayment = 'false'}
					{$errorPaymentMessage = '##Problemreservation##'}
					{$objBookingLocal->delete_transaction_current($factorNumber)}
					{$objBookingLocal->delete_credit_Agency_current($factorNumber)}
					{$objBookingLocal->DeleteTicket2($data[0])}
					{$objBookingLocal->cancelTicket($data[0])}
					{$objBookingLocal->errorTrain($data)}
				{/if}
			{/if}
	{else}

		{if $RegisterTicket eq 1 && $RegisterTicketReturn eq 1 &&  $data[0]['is_registered'] eq '0' &&  $data[1]['is_registered'] eq '0'}  {*&& $TotalPraiceWithOutDiscount eq $TicketAmount*}
			{$successPayment = 'true'}
			{$objBookingLocal->trainBook($factorNumber, 'credit')}

			{*در جدول book مشخص میکند که پرداخت از اعتبار صورت گرفته*}
		{else}
			{if $data[0]['is_registered'] eq '0' &&  $data[1]['is_registered'] eq '0'}
				{$successPayment = 'false'}
				{$errorPaymentMessage = '##Problemreservation##'}
				{$objBookingLocal->delete_transaction_current($factorNumber)}
				{$objBookingLocal->delete_credit_Agency_current($factorNumber)}
				{$objBookingLocal->DeleteTicket2($data[0])}
				{$objBookingLocal->DeleteTicket2($data[1])}
				{$objBookingLocal->cancelTicket($data[0])}
				{$objBookingLocal->cancelTicket($data[1])}
				{$objBookingLocal->errorTrain($data)}
			{/if}
		{/if}
	{/if}
{else}		{*پرداخت از طریق بانکها*}
    {load_presentation_object filename="bank" assign="objBank"}

    {$objBank->initBankParams($smarty.get.bank)}
    {$objBank->executeBank('return')}
    {assign var="factorNumber" value=$objBank->factorNumber}
    {$TotalPraiceWithOutDiscount=$objBookingLocal->TotalPriceByFactorNumberWithOutDiscount($factorNumber)}

	{assign var="data" value=$objBookingLocal->GetInfoBookWithFactorNumber($factorNumber)}

	{if $objBank->transactionStatus neq 'failed' && $objBank->trackingCode neq ''}

        {if $objBank->trackingCode eq 'member_credit'}
            {$paymentType = 'credit'}
        {else}
            {$paymentType = 'cash'}
            {$paymentBank = $objBank->bankTitle}
            {$bankTrackingCode = $objBank->trackingCode}

        {/if}
        {$successPayment = 'true'}
		{assign var="dataRequestRegisterDept" value=['code'=>$data[0]['requestNumber'],'TicketNumber'=>$data[0]['TicketNumber'],'typeRoute'=>'ONEWAY']}
		{if $data[0]['is_registered'] eq '0' }
		{assign var="RegisterTicket" value=$objBookingLocal->RegisterTicket($dataRequestRegisterDept)}
		{/if}
        {if $RegisterTicket eq 1 && $data[0]['is_registered'] eq '0'}
			{assign var="dataRequestGetAmuntTicket" value=['TicketNumberDept'=>$data[0]['TicketNumber'],'TicketNumberReturn'=>$data[1]['TicketNumber'],'code'=>$data[0]['requestNumber']]}
            {$TicketAmount = $objBookingLocal->GetTicketAmount($dataRequestGetAmuntTicket)}
        {/if}

		{if $data[1]['TicketNumber'] neq ''  && $data[1]['is_registered'] eq '0'}

			{assign var="dataRequestRegisterReturn" value=['code'=>$data[1]['requestNumber'],'TicketNumber'=>$data[1]['TicketNumber'],'typeRoute'=>'TOWEWAY']}
			{assign var="RegisterTicketReturn" value=$objBookingLocal->RegisterTicket($dataRequestRegisterReturn)}
		{/if}
        {if  $data[1]['TicketNumber'] eq ''  && $data[0]['is_registered'] eq '0'}

            {if $RegisterTicket eq 1 } {*&& $TotalPraiceWithOutDiscount eq $TicketAmount*}

                {$objBookingLocal->updateBank($objBank->trackingCode,$objBank->factorNumber,'cash')}
                {$objBookingLocal->trainBook($objBank->factorNumber)}
            {else}
				{if $data[0]['is_registered'] eq '0'}
					{$objBank->executeBank('reversal')}
					{$errorPaymentMessage = '##Problemreservation##'}
					{$objBookingLocal->DeleteTicket2($data[0])}
					{$objBookingLocal->cancelTicket($data[0])}
					{$objBookingLocal->errorTrain($data)}
				{/if}
            {/if}
        {else}

            {if $RegisterTicket eq 1 && $RegisterTicketReturn eq 1   && $data[0]['is_registered'] eq '0' &&  $data[1]['is_registered'] eq '0'}  {*&& $TotalPraiceWithOutDiscount eq $TicketAmount*}

                {$objBookingLocal->updateBank($objBank->trackingCode,$objBank->factorNumber,'cash')}
                {$objBookingLocal->trainBook($objBank->factorNumber)}
            {else}
				{if  $data[1]['TicketNumber'] neq '' && $data[0]['is_registered'] eq '0' &&  $data[1]['is_registered'] eq '0'}
					{$objBank->executeBank('reversal')}
					{$successPayment = 'false'}
					{$errorPaymentMessage = '##Problemreservation##'}
					{$objBookingLocal->DeleteTicket2($data[0])}
					{$objBookingLocal->DeleteTicket2($data[1])}
					{$objBookingLocal->cancelTicket($data[0])}
					{$objBookingLocal->cancelTicket($data[1])}
					{$objBookingLocal->errorTrain($data)}
				{/if}
            {/if}
        {/if}

        {if $objBookingLocal->okBook eq true}
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
{* display with initialized variables *}
{if $RegisterTicket eq 1 }  {*&& $TotalPraiceWithOutDiscount eq $TicketAmount*}
	{if $objBookingLocal->okBook eq true}
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
                            {if $paymentType eq 'cash'}##Agentbank##{else}##Typepayment## {/if}
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
						<span class="pull-left">{$objFunctions->set_date_payment($objBookingLocal->payment_date)}</span>
					</p>
					<p class="clearfix">
						<span class="pull-right"> ##Invoicenumber##</span>
						<span class="pull-left">{$objBookingLocal->factorNumber}</span>
					</p>
				</div>


				<div class="s-u-update-popup-change">

					<div class="s-u-bank-item s-u-bank-item-tiket-print">
						<a target="_blank" href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pdf&target=bookingTrain&id={$data[0]['requestNumber']}" class="btn btn-primary-green fa fa-eye site-bg-tsxt-color-b site-bg-color-border-right site-border-main-color">
							<p class="s-u-bank-title">{if $data[1]['requestNumber'] neq ''}##Onewayticket##{else} ##ViewTickets## {/if}</p>
						</a>
					</div>


					{if $data[1]['requestNumber'] neq ''}
					<div class="s-u-bank-item s-u-bank-item-tiket-print">
						<a target="_blank" href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pdf&target=bookingTrain&id={$data[1]['requestNumber']}" class="btn btn-primary-green fa fa-eye site-bg-tsxt-color-b site-bg-color-border-right site-border-main-color" >
							<p class="s-u-bank-title">##ViewTicketsReturn##</p>
						</a>
					</div>
					{/if}

					<div class="s-u-bank-item s-u-bank-item-tiket-print">
						<a onclick="modalEmail('{$objBookingLocal->factorNumber}');"  class="btn btn-primary-green fa fa-envelope-o site-bg-tsxt-color-b site-bg-color-border-right site-border-main-color" target="_blank">
							<p class="s-u-bank-title">##Sendemail## </p>
						</a>
					</div>

                    {* نمایش کد ترانسفر پس از خرید موفق *}
                    {*{$offCode = $objOffCode->offCodeUse($objBookingLocal->visaInfo['factor_number'], $objBookingLocal->visaInfo['serviceTitle'], $objBookingLocal->visaInfo['visa_destination_code'])}
                    {if $offCode neq ''}
                        <div class="txtGreen txt17 marb10">تبریک؛ شما موفق به دریافت {$offCode['title']} با کد {$offCode['code']} گشتید</div>
                    {/if}*}
				</div>
			</div>
		</div>
{*		{$objBookingLocal->TicketReportA($TicketNumber)}*}
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
			{*		<p class="clearfix txtCenter">
						<span class="txtCenter">
							    {if $paymentType eq 'credit'}
                                    {functions::StrReplaceInXml(["@@PaymentType@@"=>"##Validity##","@@typeReserve@@"=>"##BookTicket##"],"FinalReservationError")}
                                {else}
                                    {functions::StrReplaceInXml(["@@PaymentType@@"=>"##Vajh##","@@typeReserve@@"=>"##BookTicket##"],"FinalReservationError")}

                                {/if}
						</span>

					</p>*}
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
        <div class="modal-header site-bg-main-color">
            <span class="close CloseEmail" onclick="modalEmailClose()">&times;</span>
            <h6 class="modal-h">##Sendemailanother## </h6>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <label>##SendEmailForOther##</label>
                </div>

				<div class="col-md-11 margin-10">
                    <input type="email" class="form-control margin-10 text-left" name="Email" id="SendForOthers"> 
                    <input type="hidden" class="form-control margin-10 text-left" name="request_number" id="request_number"> 
                </div>

                <div class="col-md-2">
                    <img src="assets/images/load21.gif" style="display:none; top: 10px !important; right:35px !important" class="loader-tracking" id="loaderTracking" >    
                </div>
            </div>
        </div>
        <div class="modal-footer site-bg-main-color">
            <div class="col-md-12 text-left" >
                <input type="button" class="btn btn-success margin-10" value="##Send##"  onclick="SendVisaEmailForOther();" id="SendVisaEmailForOther">
                <input  class="close btn btn-danger margin-10" onclick="modalEmailClose()" type="button" value="##Closing##">
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>