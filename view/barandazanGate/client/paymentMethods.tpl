

<div class="s-u-p-factor-bank s-u-p-factor-bank-change"  id="factor_bank">
	<h4 class="site-bg-main-color site-bg-color-border-bottom">##Payment##</h4>

		{if !in_array($smarty.const.CLIENT_ID ,$objFunctions->isDemo())}
			{if $currencyPermition == '1'}
				{assign var="infoBank" value=$objFunctions->InfoBank('1')}
			{else}
				{assign var="infoBank" value=$objFunctions->InfoBank()} {* گرفتن لیست بانک ها *}
			{/if}

{*{$infoBank|var_dump}*}
			{if $memberCreditPermition == '1'}
				<div class="s-u-select-bank mart30 normal-user-payment">
					<label for="Ipaythroughthebank" class="credit-check">
						<input id="Ipaythroughthebank" type="radio" name="chkCreditUse" value="online_payment" onclick="checkMemberCredit()" checked/>##Ipaythroughthebank##
					</label>
					<label for="Iusemycredit" class="credit-check">
						<input id="Iusemycredit" type="radio" name="chkCreditUse" value="member_credit" onclick="checkMemberCredit()" /> ##Paycredit##
					</label>
					<p class="creditText mart20"></p>
				</div>
			{/if}

			{if $infoBank|count > 0 ||  $PaymentPrivateCharter724 == '1' || $PaymentSamanInsurance == '1'}
				<div class="s-u-select-bank mart30 onlinePaymentBox {if $memberCreditPermition == '1' && $PaymentSamanInsurance != '1'} hidden {/if}">
					<form>
						<div class="main-banks-logo">

							{if $PaymentPrivateCharter724 == '1' && $objFunctions->checkClientConfigurationAccess('gateWayPrivateCharter724') }
								<div class="bank-logo">
									<input type="radio" name="bank" value="privateGetWayCharter724" id="charter724" {if $infoBank|count eq 0}checked="checked"{/if}>
									<label for="charter724">
										<img src="assets/images/bank/helpi.png" alt="charter724" class="s-u-bank-logo s-u-bank-logo-bank">
									</label>
								</div>
							{elseif $PaymentSamanInsurance == '1'}
								<div class="bank-logo">
									<input type="radio" name="bank" value="PaymentSamanInsurance" id="saman" {if $infoBank|count eq 0}checked="checked"{/if}>
									<input type="hidden" name="redirectUrl" value="" id="redirectUrl">
									<label for="saman">
										<img src="assets/images/bank/helpi.png" alt="charter724" class="s-u-bank-logo s-u-bank-logo-bank">
									</label>
								</div>
							{else}
								{foreach $infoBank as $key => $bank}
									<div class="bank-logo">
										<input type="radio" name="bank" value="{$bank['bank_dir']}" id="{$bank['bank_dir']}" {if $key eq 0}checked="checked"{/if}>
										<label for="{$bank['bank_dir']}">
											<img src="assets/images/bank/bank{$bank['title_en']}.png" alt="{$bank['title']}" class="s-u-bank-logo w-100 s-u-bank-logo-bank">
										</label>
									</div>
								{/foreach}
							{/if}


						</div>
					</form>

				</div>

				{assign var="access_bank" value=$objFunctions->disableServiceBank($bankInputs['serviceType'])}
				{if $access_bank eq true}
					{if  $smarty.session.layout eq 'pwa'}
						{assign var="bankAction" value="`$smarty.const.ROOT_ADDRESS`/ChooseBank"}
						<input type="hidden" value='{$bankInputs|json_encode}' name="go_bank_app" id="go_bank_app" >
						<div class="s-u-select-update-wrapper">
							<a href="javascript:;" class="s-u-select-update s-u-select-update-change site-main-button-flat-color cashPaymentLoader" onclick='goToBankApp()'>عملیات ##Payment##</a>
						</div>
					{else}

						<div class="s-u-select-update-wrapper d-flex justify-content-center align-items-center">
							<a href="javascript:;" class="btn-form2 mx-auto go_bank_click" onclick='goToBank(this, "{$bankAction}", {$bankInputs|json_encode})'>##paymentUser##</a>
						</div>

					{/if}
				{/if}
			{else}
				<div class="s-u-select-update-wrapper">
					<a href="javascript:;" class="s-u-select-update s-u-select-update-change disabledButtonPayOnline">##Unfortunatelythereisactivebank##</a>
				</div>
			{/if}
		{else}
			<div class='py-2'>
				<p>##demoPayment##</p>
			</div>

		{/if}



{*    {/if}*}
</div>


{if $counterCreditPermition == '1'}
	<div class="s-u-p-factor-bank s-u-p-factor-bank-change marr10" >
		<h4 class="site-bg-main-color site-bg-color-border-bottom">##Paycredit##</h4>
		<div class="s-u-select-bank mart30">
			<form id="formcredit" method="post" target="_self">
				<div class="boxerFactorLogo">
					<img src="project_files/images/logo.png" alt="logo">
				</div>

			</form>
			<div class="paymentCredit">
				<p>
			##agencycredentials##
				</p>
				<span>
			{$objFunctions->CalculateCredit()}
					</span>
			</div>
		</div>
		<div class="s-u-select-update-wrapper margin-top-auto">
			<a href="javascript:;" class="mx-auto  btn-form2 creditPaymentLoader"
			   onclick='creditBuy(this, "{$creditAction}", {$creditInputs|json_encode})' id="creditpay">##Paycredit##</a>
		</div>
	</div>
{/if}
