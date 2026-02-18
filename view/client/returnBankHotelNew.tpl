{load_presentation_object filename="BookingHotelNew" assign="objBookingNew"}
{load_presentation_object filename="members" assign="objMembers"}
{load_presentation_object filename="interactiveOffCodes" assign="objOffCode"}
{*{$objFunctions->displayErrorLog('s360online.iran-tech.com')}*}
{* variables needed to be set for display *}
{assign var='paymentType' value=''}
{assign var='paymentBank' value=''}
{assign var='bankTrackingCode' value=''}
{assign var='successPayment' value=''}
{assign var='errorPaymentMessage' value=''}
{assign var="filename" value="`$smarty.post.factorNumber`_log_bank_hotel"}
{assign var='offCode' value=''}
<code style="display:none">{$smarty.post|json_encode}</code>
<code style="display:none">{$smarty.get|json_encode}</code>
{$objFunctions->insertLog('Starting of action in returnBankHotelNew', $filename)}
{$objFunctions->insertLog({$smarty.post|json_encode},$filename)}
{$objFunctions->insertLog({$smarty.get|json_encode},$filename)}
{$objFunctions->insertLog('=======',$filename)}
{assign var="linkView" value="ehotelLocal"}
{assign var="linkPDF" value="BookingHotelNew"}
{*$filename:{$filename}*}
{*$smarty.post:{$smarty.post|var_dump}*}
{*d1*}
{if $smarty.const.CLIENT_NAME eq '##Ahuan##'}{*For Ahuan*}
    {$linkView = 'ehotelAhuan'}
    {$linkPDF = 'hotelVoucherAhuan'}
{*d2*}
{elseif $smarty.const.CLIENT_NAME eq '##Zarvan##'}{*For Zarvan*}
    {$linkView = 'ehotelZarvan'}
    {$linkPDF = 'BookingHotelLocal'}
{*d3*}
{else}
    {$linkView = 'ehotelLocal'}
    {$linkPDF = 'BookingHotelLocal'}
{*d4*}
{/if}

{if $smarty.post.flag eq 'credit'}		{*پرداخت از طریق اعتبار*}
	<code style="display:none">is credit payment</code>
    {$objFunctions->insertLog('Payment flag is credit',$filename)}
    {$paymentType = 'credit'}
{*	<code>{$smarty.post.factorNumber}</code>*}
    {if $smarty.post.factorNumber neq ''}
        {$successPayment = 'true'}
        {$objFunctions->insertLog('successPayment is true',$filename)}
        {$objBookingNew->HotelBookCredit($smarty.post.factorNumber)}{*در جدول book مشخص میکند که پرداخت از اعتبار صورت گرفته*}
		<code style="display:none">after hotelBookCredit</code>
        {$objFunctions->insertLog('HotelBookCredit run success',$filename)}
    {else}
        {$objFunctions->insertLog('Payment error on credit',$filename)}
        {$successPayment = 'false'}
        {$errorPaymentMessage = '##Sorrypayment##'}
    {/if}
	<code style="display:none">after factornumber</code>

{elseif $smarty.post.flag eq 'currencyPayment'}     {* پرداخت ارزی *}
    {$objFunctions->insertLog('Payment flag is currencyPayment',$filename)}
    {$paymentType = 'currency'}
    {$paymentBank = '##currency##'}

    {if $smarty.post.trackingCode neq ''}
        {$successPayment = 'true'}
        {$bankTrackingCode = $smarty.post.trackingCode}

        {$objBookingNew->updateBank($smarty.post.trackingCode, $smarty.post.factorNumber)}
        {$objBookingNew->HotelBook($smarty.post.factorNumber)}

        {if $objBookingNew->okHotel eq true}

            {* برای تثبیت استفاده خریدار از کد تخفیف *}
            {load_presentation_object filename="discountCodes" assign="objDiscountCodes"}
            {$objDiscountCodes->DiscountCodesUseConfirm($smarty.post.factorNumber)}

        {/if}

    {else}
		{$objFucntion->insertLog('error on payment ',$filename)}
        {$successPayment = 'false'}
        {$errorPaymentMessage = '##Sorrypayment##'}

        {$objBookingNew->delete_transaction_current($smarty.post.factorNumber)}
    {/if}

{else}		{*پرداخت از طریق بانکها*}
    {$objFunctions->insertLog('Payment flag is cash',$filename)}
	{load_presentation_object filename="bank" assign="objBank"}
	{$objBank->initBankParams($smarty.get.bank)}
	{$objBank->executeBank('return')}
	{$objFunctions->insertLog('after executeBank return',$filename)}
	{$objFunctions->insertLog($objBank->transactionStatus,$filename)}
	{$objFunctions->insertLog($objBank->trackingCode,$filename)}
	{$objFunctions->insertLog('***********',$filename)}

	{if ($objBank->transactionStatus neq 'failed' && $objBank->trackingCode neq '') }
		{if $objBank->trackingCode eq 'member_credit'}
			{$paymentType = 'credit'}
		{else}
			{$objFunctions->insertLog('Payment transactionStatus is not failed',$filename)}
			{$paymentType = 'cash'}
			{$paymentBank = $objBank->bankTitle}
			{$bankTrackingCode = $objBank->trackingCode}
		{/if}
		{$objFunctions->insertLog('after trackingCode if check',$filename)}
        {$successPayment = 'true'}

        {$objFunctions->insertLog('Success Payment is true',$filename)}
		{$objBookingNew->updateBank($objBank->trackingCode,$objBank->factorNumber)}
        {$objFunctions->insertLog('updateBank done',$filename)}
		{$objBookingNew->HotelBook($objBank->factorNumber)}
        {$objFunctions->insertLog('HotelBook done',$filename)}

		{if $objBookingNew->okHotel eq true}

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

		{$objBookingNew->delete_transaction_current($objBank->factorNumber)}
	{/if}

{/if}
<code style="display:none">after payment flag</code>

<code class='okHotel' style="display:none">{$objBookingNew->okHotel|var_dump}</code>

{* display with initialized variables *}
{if $successPayment eq 'true'}
	<code class='okHotel successpayment' style="display:none">
		{$objBookingNew->okHotel|var_dump}
	</code>
	{if $objBookingNew->okHotel eq true}
		{if $objBookingNew->hotel_status eq 'pending'}
			<div class="row bank_box_row mx-auto">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40" >
					<div class="main-bank-box">
						<div class="mbb-preload">
							<img src="assets/images/pre-bank.png">
						</div>
						<h4 class="mbb-bank-title d-flex flex-column align-items-center">
						<span>
							##messagePrepairFlight_success##
						</span>
						<span style='line-height: 2;'>
							##messagePrepairHotelStatusFist##
							{if $objFunctions->isDemo()}
							<a href='{$smarty.const.ROOT_ADDRESS}/userBook'> ##MyTravels## </a>
								{else}
							<a href='{$smarty.const.ROOT_ADDRESS}/UserTracking'> ##TrackOrder## </a>
							{/if}
							##messagePrepairHotelStatusSecond##
						</span>
						{if $objFunctions->isDemo()}
							<a href='{$smarty.const.ROOT_ADDRESS}/userBook'>##Link## ##MyTravels##</a>
							{else}
							<a href='{$smarty.const.ROOT_ADDRESS}/UserTracking'>##Link## ##TrackOrder##</a>
						{/if}

						<div class="d-flex align-items-center justify-content-center">
							<span class="ml-3">##messagePrepairFlight_button## : </span>
							<div class="mbb-bank-btn-js mbb-bank-btn">
								<span class="fa-regular fa-copy"></span>
								<div class="factorNumber_text d-flex mr-1">{$objBookingNew->factor_number}</div>
							</div>
						</div>
						</h4>
					</div>
				</div>
			</div>
			{else}
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
						{if $objBookingNew->type_application neq 'externalApi'}
							{if $objBookingNew->payment_status eq ''}
							<div class="s-u-bank-item s-u-bank-item-tiket-print">
								<a href="{$smarty.const.ROOT_ADDRESS}/{$linkView}&num={$objBookingNew->factor_number}"  class="btn btn-primary-green fa fa-print site-border-main-color" target="_blank">
									<p class="s-u-bank-title">##Printreservation##  </p>
								</a>
							</div>
								{/if}
						{/if}
						{if $objBookingNew->type_application neq 'reservation'}

							<div class="s-u-bank-item s-u-bank-item-tiket-print">
								<a href="{$smarty.const.ROOT_ADDRESS}/{$linkView}&num={$objBookingNew->factor_number}"  class="btn btn-primary-green fa fa-print site-border-main-color" target="_blank">
									<p class="s-u-bank-title">##Printreservation##  </p>
								</a>
							</div>

						{/if}

						{if $objBookingNew->type_application eq 'externalApi'}
							<div class="s-u-bank-item s-u-bank-item-tiket-print">
								<a href="{$smarty.const.ROOT_ADDRESS}/pdf&lang=en&target=bookhotelshow&id={$objBookingNew->factor_number}" class="btn btn-primary-green fa fa-file-pdf-o site-border-main-color" target="_blank">
									<p class="s-u-bank-title"> ##GetWatcher## </p>
								</a>
							</div>
						{else}
							{if ($objBookingNew->payment_status eq '' || $objBookingNew->payment_status eq 'fullPayment')}
							<div class="s-u-bank-item s-u-bank-item-tiket-print">
								{if $objBookingNew->hotelInfo['serviceTitle'] eq 'PrivatePortalHotel'}
									<a href="https://{$smarty.const.CLIENT_DOMAIN}/gds/en/pdf&target=bookhotelshow&id={$objBookingNew->factor_number}" class="btn btn-primary-green fa fa-file-pdf-o site-border-main-color" target="_blank">
										<p class="s-u-bank-title"> ##Download## pdf </p>
									</a>
								{else}
									<a href="{$smarty.const.ROOT_ADDRESS}/pdf&target={$linkPDF}&id={$objBookingNew->factor_number}" class="btn btn-primary-green fa fa-file-pdf-o site-border-main-color" target="_blank">
										<p class="s-u-bank-title"> ##Download## pdf </p>
									</a>
								{/if}

							</div>
							{/if}
						{/if}


						{*{if  $smarty.session.layout eq 'pwa'}
                            <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}'/app/'">بازگشت به برنامه</a>
                            <div class="s-u-bank-item s-u-bank-item-tiket-print">
                                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}'/app/'"
                                   class="btn btn-primary-green fa fa-file-pdf-o site-border-main-color"
                                   target="_blank">
                                    <p class="s-u-bank-title"> ##returnToApp## </p>
                                </a>
                            </div>
                        {else}
                            {if $objBookingNew->type_application eq 'externalApi'}
                                <div class="s-u-bank-item s-u-bank-item-tiket-print">
                                    <a href="{$smarty.const.ROOT_ADDRESS}/pdf&target=bookhotelshow&id={$objBookingNew->factor_number}"
                                       class="btn btn-primary-green fa fa-file-pdf-o site-border-main-color"
                                       target="_blank">
                                        <p class="s-u-bank-title"> ##Englishpdf## </p>
                                    </a>
                                </div>
                            {else}
                                <div class="s-u-bank-item s-u-bank-item-tiket-print">
                                    <a onclick="modalEmail('{$objBookingNew->factor_number}');"
                                       class="btn btn-primary-green fa fa-envelope-o site-border-main-color"
                                       target="_blank">
                                        <p class="s-u-bank-title">##Sendemail## </p>
                                    </a>
                                </div>
                            {/if}
                        {/if}*}

						{* نمایش کد ترانسفر پس از خرید موفق *}
						{*{$offCode = $objOffCode->offCodeUse($objBookingNew->hotelInfo['factor_number'], $objBookingNew->hotelInfo['serviceTitle'], $objBookingNew->hotelInfo['destination_iata'])}
                        {if $offCode neq ''}
                            <div class="txtGreen txt17 marb10">تبریک؛ شما موفق به دریافت {$offCode['title']} با کد {$offCode['code']} گشتید</div>
                        {/if}*}
					</div>
				</div>
			</div>
		{/if}

	{else}
		{if $objBookingNew->isRequest eq 'OnRequest'}
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 Clr">
				<div class="main-bank-box">
					<div class="mbb-preload mbb-preload-icon-alert">
						<img src="assets/images/pre-bank-red.png">
					</div>
					<h4 class="mbb-bank-title mbb-bank-title-red">
						<span>##onRequestHotel##</span>
					</h4>
					<div class="mbb-detail">
						<p class="clearfix txtCenter">
							{if $objBookingNew->errorMessage neq ''}
							
								{if $objSession->IsLogin()}
									<span class="txtCenter">##onRequestHotelProccessMessageUser##</span>
								{else}
									<span class="txtCenter">##onRequestHotelProccessMessage##</span>
								{/if}
								<br>
								<span>
								  {functions::StrReplaceInXml(["@@requestNumber@@"=>$objBookingNew->factor_number],"onRequestHotelTrackingCode")}
								</span>

							{/if}
						</p>
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
<code style="display:none">after successPayment </code>

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
				<input type="hidden" id="typeApplication" name="typeApplication" value="hotel">
				<input type="hidden" id="factorNumber" name="factorNumber" value="{$objBookingNew->factor_number}">
                <input type="button" class="btn btn-success margin-10" value="##Send##"  onclick="SendHotelEmailForOther();" id="SendEmailForOther">
                <input  class="close btn btn-danger margin-10" onclick="modalEmailClose()" type="button" value="##Closing##">
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>