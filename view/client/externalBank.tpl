{load_presentation_object filename="externalBankParams" assign="objParams"}
{load_presentation_object filename="country" assign="objCountry"}


{if !($smarty.get.fid) OR !($smarty.get.bank_id)}

{/if}
{assign var="factor_number" value=$smarty.get.fid}
{assign var="bank" value=$objParams->getBank($smarty.get.bank_id)}
{assign var="countries" value=$objCountry->countriesList()}
{*{assign var="countries" value=$objFunctions->sortBySubValue($countriesList,'titleEn')}*}
{*<code>{$smarty.const.ROOT_ADDRESS}</code>*}
{*<code>{$countriesList|json_encode}</code>*}
{*<code>{$countries|json_encode:256}</code>*}

<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 ">
			<form id="externalBankParams" action="" method="post" class="form-row justify-content-center">
				<div class="col-12">
					<div class="alert alert-info" role="alert">
						<p class="">##AllFieldsEnglishInput##</p>
					</div>
				</div>
				<div class="col-sm-12 col-lg-5 col-md-5">
					<img src="assets/images/bank/bank{$bank.title_en}.png" alt="{$bank.title}">
				</div>
				<input type="hidden" name="flag" value="externalBank">
				<input type="hidden" name="bank_id" value="{$smarty.get.bank_id}">
				<input type="hidden" name="factor_number" value="{$smarty.get.fid}">
				<div class="col-sm-12 col-lg-7 col-md-7">
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="first_name" class="col-form-label">##FirstName##</label>
							<input type="text" class="form-control" name="first_name" id="first_name" required="required" aria-required="true" placeholder="##firstName##">
						</div>
						<div class="form-group col-md-6">
							<label for="last_name" class="col-form-label">##LastName##</label>
							<input type="text" class="form-control" name="last_name" id="last_name" required="required" aria-required="true" placeholder="##lastName##">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="mobile" class="col-form-label">##Mobile##</label>
							<input type="text" class="form-control" name="mobile" id="mobile" required="required" aria-required="true" placeholder="##Mobile##" inputmode="number">
						</div>
						<div class="form-group col-md-6">
							<label for=email class="col-form-label">##Email##</label>
							<input type="email" class="form-control" name="email" id="email" required="required" aria-required="true" placeholder="##Email##">
						</div>
					</div>
					<hr>
					<div class="form-row">
						<div class="form-group col-md-5">
							<label for="country" class="col-form-label">##Country##</label>
							<select name="country" id="country" class="form-control select2" required="required" aria-required="true" placeholder="##Country##">
								<option value="">##Country##</option>
								{foreach $countries as $country}
								<option value="{$country.titleEn}">{if $smarty.const.SOFTWARE_LANG == 'fa'}{$country.titleFa}{else}{$country.titleEn}{/if}</option>
								{/foreach}
							</select>
							{*<input type="text" class="form-control" name="country" id="country" placeholder="##Country##">*}
						</div>
						<div class="form-group col-md-5">
							<label for="city" class="col-form-label">##City##</label>
							<input type="text" class="form-control" name="city" id="city" required="required" aria-required="true" placeholder="##City##">
						</div>
						<div class="form-group col-md-2">
							<label for="postal_code" class="col-form-label">##Postalcode##</label>
							<input type="text" class="form-control" name="postal_code" id="postal_code" required="required" aria-required="true" placeholder="##Postalcode##" inputmode="number">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-12">
							<label for="address" class="col-form-label">##Address##</label>
							<input type="text" class="form-control" name="address" id="address" required="required" aria-required="true" placeholder="##Address##">
						</div>
					</div>
					<hr>

				</div>
				<div class="col-sm-12 col-lg-7 col-md-7 form-group align-self-center justify-content-end d-flex">
					<button type="submit" class="btn btn-primary">Go to bank</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript" src="assets/js/externalBank.js"></script>