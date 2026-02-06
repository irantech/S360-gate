<div class="tab-pane" id="insurance" role="tabpanel"
	 aria-labelledby="insurance-tab">
	<div class="row">
		<form method="post" name="gds_insurance" id="gdsInsurance" class="d_contents">
			<div class="col-lg-3 col-md-4 col-sm-6 col-12 col_search">
				<div class="form-group">
					<input type="hidden" id="insurance_type" name="insurance_type" value="2">
					<select data-placeholder="نام کشور مقصد" name="destination" id="destination" class="select2 ">
						<option value="">انتخاب کنید...</option>
						{foreach $insuranceCountries as $country}
							<option value="{$country['abbr']}">{$country['persian_name']}</option>
						{/foreach}
					</select>

				</div>
			</div>

			<div class="col-lg-3 col-md-4 col-sm-6 col-12 col_search">
				<div class="form-group">
					<select data-placeholder="انتخاب مدت سفر" name="num_day"
							id="num_day" class="select2 ">
						<option value="">انتخاب کنید...</option>
						<option value="5">تا 5 روز</option>
						<option value="7">تا 7 روز</option>
						<option value="8">تا 8 روز</option>
						<option value="15">تا 15 روز</option>
						<option value="23">تا 23 روز</option>
						<option value="31">تا 31 روز</option>
						<option value="45">تا 45 روز</option>
						<option value="62">تا 62 روز</option>
						<option value="92">تا 92 روز</option>
						<option value="182">تا 182 روز</option>
						<option value="186">تا 186 روز</option>
						<option value="365">تا 365 روز</option>
					</select>
				</div>
			</div>
			<div class="col-lg-2 col-md-4 col-sm-6 col-12 col_search">
				<div class="form-group">
					<select name="number_of_adults_insurance" id="number_of_adults_insurance"
							data-placeholder="انتخاب تعداد مسافر" class="select2 ">
						<option value="">انتخاب کنید...</option>
						<option value="1"> 1</option>
						<option value="2"> 2</option>
						<option value="3"> 3</option>
						<option value="4"> 4</option>
						<option value="5"> 5</option>
						<option value="6"> 6</option>
						<option value="7"> 7</option>
						<option value="8"> 8</option>
						<option value="9"> 9</option>

					</select>
				</div>
			</div>

			<div class="nafaratbime">
				<div class="col-lg-2 col-md-4 col-sm-6 col-12 col_search search_col nafarat-bime">
					<div class="form-group">
						<input type="text" class="form-control shamsiBirthdayCalendar"
							   name="txt_went_insurance1" autocomplete='off'
							   id="txt_went_insurance1"
							   placeholder="تاریخ تولد مسافر 1">

					</div>

				</div>
			</div>


			<div class="col-lg-2 col-md-3 col-sm-6 col-12 col_search search_btn_insuranc">
				<button type="button" onclick="submitSearchInsuranceLocal()"
						class="btn theme-btn seub-btn b-0 site-bg-main-color"><span>جستجو</span></button>

			</div>

		</form>

	</div>


</div>