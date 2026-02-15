{load_presentation_object filename="trainBooking" assign="trainBooking"}
{load_presentation_object filename="members" assign="objMembers"}
{load_presentation_object filename="interactiveOffCodes" assign="objOffCode"}
{load_presentation_object filename="apiCodeExist" assign="apiCodeExist"}
{load_presentation_object filename="bank" assign="objBank"}
{load_presentation_object filename="Session" assign="objSession"}

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
	{$TotalPraiceWithOutDiscount=$trainBooking->TotalPriceByFactorNumberWithOutDiscount($factorNumber)}
	{assign var='updateFlag' value=["factor_number"=>$factorNumber,"type"=>"credit"]}
	{assign var="data" value=$trainBooking->GetInfoBookWithFactorNumber($factorNumber)}

	{assign var="check" value=$apiCodeExist->checkExists($data[0].requestNumber,'trainReturnBank','train')}
	{if ($check eq NULL || $check eq false)}
		{assign var="insertRequest" value=['code'=>$data[0].requestNumber,'service'=>'train','method'=>'trainReturnBank']}
		{assign var="insert" value=$apiCodeExist->insertCode($insertRequest)}

		{if $data[0]['is_registered'] eq '0' }
			{assign var="flag_change" value=$trainBooking->changeFlagTrain($updateFlag)}
		{/if}
		{*پرداخت از طریق اعتبار*}
		{$paymentType = 'credit'}
		{assign var="dataRequestRegisterDept" value=['code'=>$data[0]['requestNumber'],'TicketNumber'=>$data[0]['TicketNumber'],'typeRoute'=>'ONEWAY']}
		{if $data[0]['is_registered'] eq '0' }
			{if $data[1]['TicketNumber'] eq ''}
				{assign var="RegisterTicket" value=$trainBooking->RegisterTicket($dataRequestRegisterDept)}
				{if $RegisterTicket eq 1}
					{assign var="dataRequestGetAmuntTicket" value=['UniqueId'=>$data[0]['UniqueId'],'RequestNumber'=>$data[0]['requestNumber'],'RequestNumberReturn'=>$data[1]['requestNumber']]}
					{$TicketAmount = $trainBooking->GetTicketAmount($dataRequestGetAmuntTicket)}
					{$successPayment = 'true'}
					{$trainBooking->trainBook($factorNumber, 'credit')}
				{else}
					{assign var="updated_data" value=$trainBooking->GetInfoBookWithFactorNumber($objBank->factorNumber)}
					{if $updated_data[0]['is_registered'] eq '0'}
						{$successPayment = 'false'}
						{$errorPaymentMessage = '##Problemreservation##'}
						{$trainBooking->delete_transaction_current($factorNumber)}
						{$trainBooking->delete_credit_Agency_current($factorNumber)}
						{$trainBooking->DeleteTicket($updated_data[0])}
						{$trainBooking->cancelTicket($updated_data[0])}
						{$trainBooking->errorTrain($updated_data)}
					{/if}
				{/if}
			{else}
				{assign var="RegisterTicket" value=$trainBooking->RegisterTicket($dataRequestRegisterDept)}
				{if $data[1]['TicketNumber'] neq '' && $data[1]['is_registered'] eq '0'}
					{assign var="dataRequestRegisterReturn" value=['code'=>$data[1]['requestNumber'],'TicketNumber'=>$data[1]['TicketNumber'],'typeRoute'=>'TOWEWAY']}
					{assign var="RegisterTicketReturn" value=$trainBooking->RegisterTicket($dataRequestRegisterReturn)}
				{/if}
				{if $RegisterTicket eq 1 && $RegisterTicketReturn eq 1}  {*&& $TotalPraiceWithOutDiscount eq $TicketAmount*}
					{$successPayment = 'true'}
					{$trainBooking->trainBook($factorNumber, 'credit')}
					{*در جدول book مشخص میکند که پرداخت از اعتبار صورت گرفته*}
				{else}
					{assign var="updated_data" value=$trainBooking->GetInfoBookWithFactorNumber($objBank->factorNumber)}
					{if $updated_data[0]['is_registered'] eq '0' &&  $updated_data[1]['is_registered'] eq '0'}
						{$successPayment = 'false'}
						{$errorPaymentMessage = '##Problemreservation##'}
						{$trainBooking->delete_transaction_current($objBank->factorNumber)}
						{$trainBooking->delete_credit_Agency_current($objBank->factorNumber)}
						{$trainBooking->DeleteTicket($updated_data[0])}
						{$trainBooking->DeleteTicket($updated_data[1])}
						{$trainBooking->cancelTicket($updated_data[0])}
						{$trainBooking->cancelTicket($updated_data[1])}
						{$trainBooking->errorTrain($updated_data)}
					{/if}
				{/if}
			{/if}
		{/if}
	{else}
		{**else for checkExist**}
		<div class="userProfileInfo-messge mb-3">
			<div class="messge-login BoxErrorSearch">
				<div style="float: right;">
					<i class="fa fa-exclamation-triangle IconBoxErrorSearch"></i>
				</div>
				<div class="TextBoxErrorSearch px-4">
					<h6>اخطار بارگزاری صفحه</h6>
					<p>##UnexpectedErrorContactSupport##</p>
				</div>
			</div>
		</div>
	{/if}
{else}		{*پرداخت از طریق بانکها*}

	{load_presentation_object filename="bank" assign="objBank"}
	{$objBank->initBankParams($smarty.get.bank)}
	{$objBank->executeBank('return')}
	{assign var="factorNumber" value=$objBank->factorNumber}

	{$TotalPraiceWithOutDiscount=$trainBooking->TotalPriceByFactorNumberWithOutDiscount($factorNumber)}

	{assign var="data" value=$trainBooking->GetInfoBookWithFactorNumber($factorNumber)}
	{assign var="check" value=$apiCodeExist->checkExists($data[0].requestNumber,'trainReturnBank','train')}

	{if $check eq NULL || $check eq false}

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
				{if  $data[1]['TicketNumber'] eq ''}
					{assign var="RegisterTicket" value=$trainBooking->RegisterTicket($dataRequestRegisterDept)}
					RegisterTicket : {$RegisterTicket}
					{if $RegisterTicket eq 1}
						{assign var="dataRequestGetAmuntTicket" value=['UniqueId'=>$data[0]['UniqueId'],'RequestNumber'=>$data[0]['requestNumber'],'RequestNumberReturn'=>$data[0]['requestNumber']]}
						{$TicketAmount = $trainBooking->GetTicketAmount($dataRequestGetAmuntTicket)}
						{$trainBooking->updateBank($objBank->trackingCode,$objBank->factorNumber,'cash')}
						{$trainBooking->trainBook($objBank->factorNumber)}
					{else}
						{assign var="updated_data" value=$trainBooking->GetInfoBookWithFactorNumber($objBank->factorNumber)}

						{if $updated_data[0]['is_registered'] eq '0'}
							{$objBank->executeBank('reversal')}
							{$errorPaymentMessage = '##Problemreservation##'}
							{$trainBooking->DeleteTicket($updated_data[0])}
							{$trainBooking->cancelTicket($updated_data[0])}
							{$trainBooking->errorTrain($updated_data)}
						{/if}
					{/if}
				{else}
					{if $data[1]['TicketNumber'] neq ''  &&  $data[0]['is_registered'] eq '0' &&  $data[1]['is_registered'] eq '0'}
						{assign var="RegisterTicket" value=$trainBooking->RegisterTicket($dataRequestRegisterDept)}

						{assign var="dataRequestRegisterReturn" value=['code'=>$data[1]['requestNumber'],'TicketNumber'=>$data[1]['TicketNumber'],'typeRoute'=>'TOWEWAY']}
						
						{assign var="RegisterTicketReturn" value=$trainBooking->RegisterTicket($dataRequestRegisterReturn)}
						{if $RegisterTicket eq 1 && $RegisterTicketReturn eq 1}  {*&& $TotalPraiceWithOutDiscount eq $TicketAmount*}
							{assign var="dataRequestGetAmuntTicket" value=['UniqueId'=>$data[0]['UniqueId'],'RequestNumber'=>$data[0]['requestNumber'],'RequestNumberReturn'=>$data[0]['requestNumber']]}
							{$TicketAmount = $trainBooking->GetTicketAmount($dataRequestGetAmuntTicket)}

							{assign var="dataRequestGetAmuntTicketReturn" value=['UniqueId'=>$data[1]['UniqueId'],'RequestNumber'=>$data[1]['requestNumber'],'RequestNumberReturn'=>$data[1]['requestNumber']]}
							{$TicketAmount = $trainBooking->GetTicketAmount($dataRequestGetAmuntTicketReturn)}

							{$trainBooking->updateBank($objBank->trackingCode,$objBank->factorNumber,'cash')}
							{$trainBooking->trainBook($objBank->factorNumber)}
						{else}
							{assign var="updated_data" value=$trainBooking->GetInfoBookWithFactorNumber($objBank->factorNumber)}

							{if  $updated_data[1]['TicketNumber'] neq '' && $updated_data[0]['is_registered'] eq '0' &&  $updated_data[1]['is_registered'] eq '0'}
								{$objBank->executeBank('reversal')}
								{$successPayment = 'false'}
								{$errorPaymentMessage = '##Problemreservation##'}
								{$trainBooking->DeleteTicket($updated_data[0])}
								{$trainBooking->DeleteTicket($updated_data[1])}
								{$trainBooking->cancelTicket($updated_data[0])}
								{$trainBooking->cancelTicket($updated_data[1])}
								{$trainBooking->errorTrain($updated_data)}
							{/if}
						{/if}
					{/if}
				{/if}
			{/if}

			{if $trainBooking->okBook eq true}
			
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
			{$trainBooking->delete_transaction_current($objBank->factorNumber)}
		{/if}
		{assign var="insertRequest" value=['code'=>$data[0].requestNumber,'service'=>'train','method'=>'trainReturnBank']}
		{assign var="insert" value=$apiCodeExist->insertCode($insertRequest)}
	{elseif $check['id']}


		{if $data[0]['successfull'] eq 'book' && $data[0]['is_registered'] eq '1'}
			{assign var="RegisterTicket" value=1}
			{$trainBooking->trainBook($objBank->factorNumber)}
		{/if}
	{else}
		{**else for checkExist**}
		<div class="userProfileInfo-messge mb-3">
			<div class="messge-login BoxErrorSearch">
				<div style="float: right;">
					<i class="fa fa-exclamation-triangle IconBoxErrorSearch"></i>
				</div>
				<div class="TextBoxErrorSearch px-4">
					<h6>اخطار بارگزاری صفحه</h6>
					<p>##UnexpectedErrorContactSupport##</p>
				</div>
			</div>
		</div>
	{/if}
{/if}

{* display with initialized variables *}
{if $RegisterTicket eq 1 || $RegisterTicket eq true}  {*&& $TotalPraiceWithOutDiscount eq $TicketAmount*}
	{if $trainBooking->okBook eq true}
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 Clr">
			<div class="main-bank-box">
				<div class="mbb-preload mbb-preload-icon">
					<img alt="Bank Success" src="assets/images/pre-bank.png">
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
						<span class="pull-left">{$objFunctions->set_date_payment($trainBooking->payment_date)}</span>
					</p>
					<p class="clearfix">
						<span class="pull-right"> ##Invoicenumber##</span>
						<span class="pull-left">{$trainBooking->factorNumber}</span>
					</p>
				</div>
				<div class="s-u-update-popup-change">
					<div class="s-u-bank-item s-u-bank-item-tiket-print">
						<a  href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pdf&target=trainBooking&id={$data[0]['requestNumber']}" class="btn btn-primary-green fa fa-eye site-bg-tsxt-color-b site-bg-color-border-right site-border-main-color">
							<p class="s-u-bank-title"> ##ViewTickets##</p>
						</a>
					</div>


{*					{if $data[1]['requestNumber'] neq ''}*}
{*						<div class="s-u-bank-item s-u-bank-item-tiket-print">*}
{*							<a  href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pdf&target=trainBooking&id={$data[1]['requestNumber']}" class="btn btn-primary-green fa fa-eye site-bg-tsxt-color-b site-bg-color-border-right site-border-main-color">*}
{*								<p class="s-u-bank-title">##ViewTicketsReturn##</p>*}
{*							</a>*}
{*						</div>*}
{*					{/if}*}

					<div class="s-u-bank-item s-u-bank-item-tiket-print">
						<a onclick="modalEmail('{$trainBooking->factorNumber}');"  class="btn btn-primary-green fa fa-envelope-o site-bg-tsxt-color-b site-bg-color-border-right site-border-main-color" target="_blank">
							<p class="s-u-bank-title">##Sendemail## </p>
						</a>
					</div>

					{* نمایش کد ترانسفر پس از خرید موفق *}
					{*{$offCode = $objOffCode->offCodeUse($trainBooking->visaInfo['factor_number'], $trainBooking->visaInfo['serviceTitle'], $trainBooking->visaInfo['visa_destination_code'])}
                    {if $offCode neq ''}
                        <div class="txtGreen txt17 marb10">تبریک؛ شما موفق به دریافت {$offCode['title']} با کد {$offCode['code']} گشتید</div>
                    {/if}*}
				</div>
			</div>
		</div>
		{*		{$trainBooking->TicketReportA($TicketNumber)}*}
	{else}
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 Clr">
			<div class="main-bank-box">
				<div class="mbb-preload mbb-preload-icon-alert">
					<img alt="Bank Error" src="assets/images/pre-bank-red.png">
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
				<img alt="Bank Error" src="assets/images/pre-bank-red.png">
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
					<img alt="Loader" src="assets/images/load21.gif" style="display:none; top: 10px !important; right:35px !important" class="loader-tracking" id="loaderTracking" >
				</div>
			</div>
		</div>
		<div class="modal-footer site-bg-main-color">
			<div class="col-md-12 text-left" >
				<input type="button" class="btn btn-success margin-10" value="##Send##"  onclick="SendTrainEmailForOther();" id="SendTrainEmailForOther">
				<input  class="close btn btn-danger margin-10" onclick="modalEmailClose()" type="button" value="##Closing##">
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>