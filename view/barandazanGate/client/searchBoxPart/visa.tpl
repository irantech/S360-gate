<div class="tab-pane" id="visa" role="tabpanel" aria-labelledby="visa-tab">

	<div class="row  ">
		<form
				method="post"
				name="gdsVisa"
				id="gdsVisa"
				class="d_contents">

			<div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search">
				<div class="form-group">
					<select data-placeholder=" قاره" name="visa_continent" id="visa_continent"
							class="select2 " onchange="initCountriesOfContinent()">
						<option selected="selected" value="">انتخاب کنید...</option>
						{foreach $continents as $continent}
							<option value="{$continent['id']}">{$continent['titleFa']}</option>
							{/foreach}


					</select>
				</div>
			</div>

			<div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search">
				<div class="form-group">
					<select data-placeholder=" مقصد" name="visa_destination" id="visa_destination"
							class="select2 ">
						<option value="">انتخاب کنید...</option>


					</select>
				</div>
			</div>

			<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">
				<div class="form-group">
					<select data-placeholder=" نوع ویزا" name="visa_type"
							id="visa_type"
							class="select2 ">
						<option selected="selected" value="">نوع ویزا</option>
						{foreach $visTypeLists as $visType}
							<option value="{$visType['id']}">{$visType['title']}</option>
						{/foreach}

					</select>
				</div>
			</div>

			<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">
				<div class="select inp-s-num adt box-of-count-nafar">
					<input type="hidden" class="l-bozorgsal-2"
						   name="gds_infants_no_visa" id="adtVisa" value="1">
					<input type="hidden" class="l-kodak-2"
						   name="gds_childs_no_visa" id="chdVisa">
					<input type="hidden" class="l-nozad-2"
						   name="gds_infants_no_visa" id="infVisa">
					<div class="box-of-count-nafar-boxes">
                                        <span class="text-count-nafar">
									1 بزرگسال
									</span>
						<span class="fas fa-caret-down down-count-nafar site-color-main-color-before"></span>
					</div>
					<div class="cbox-count-nafar">
						<div class="col-xs-12 cbox-count-nafar-ch bozorg-num">
							<div class="row">
								<div class="col-xs-12 col-sm-6 col-6">
									<div class="type-of-count-nafar">
										<h6> بزرگسال </h6> (بزرگتر از ۱۲ سال)
									</div>
								</div>
								<div class="col-xs-12 col-sm-6 col-6">
									<div class="num-of-count-nafar"><i
												class="fas fa-plus counting-of-count-nafar plus-nafar"></i>
										<i class="number-count counting-of-count-nafar"
										   data-number="1" data-min="1"
										   data-value="l-bozorgsal-2">1</i>
										<i class="fas fa-minus counting-of-count-nafar minus-nafar"></i>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-12 cbox-count-nafar-ch koodak-num displayiN">
							<div class="row">
								<div class="col-xs-12 col-sm-6 col-6">
									<div class="type-of-count-nafar">
										کودک(2-12سال)
									</div>
								</div>
								<div class="col-xs-12 col-sm-6 col-6">
									<div class="num-of-count-nafar"><i
												class="fas fa-plus counting-of-count-nafar plus-nafar"></i>
										<i class="number-count counting-of-count-nafar"
										   data-number="0" data-min="0"
										   data-value="l-kodak-2">0</i>
										<i class="fas fa-minus counting-of-count-nafar minus-nafar"></i>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-12 cbox-count-nafar-ch nozad-num displayiN">
							<div class="row">
								<div class="col-xs-12 col-sm-6 col-6">
									<div class="type-of-count-nafar">
										نوزاد(0-2سال)
									</div>
								</div>
								<div class="col-xs-12 col-sm-6 col-6">
									<div class="num-of-count-nafar"><i
												class="fas fa-plus counting-of-count-nafar plus-nafar"></i>
										<i class="number-count counting-of-count-nafar"
										   data-number="0" data-min="0"
										   data-value="l-nozad-2">0</i>
										<i class="fas fa-minus counting-of-count-nafar minus-nafar"></i>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>

			<div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search">
				<button type="button" onclick="submitSearchVisa()" class="btn theme-btn seub-btn b-0 site-bg-main-color">
                                    <span>
                                    جستجو
                                </span>
				</button>
			</div>

		</form>

	</div>

</div>