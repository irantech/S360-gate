<div class="tab-pane" id="bus" role="tabpanel" aria-labelledby="bus-tab">
	<div class="row">
		<form method="post" class="d_contents" id="gds_bus" name="gds_bus">
			<div class="col-lg-4 col-md-6 col-sm-6 col-12 col_search">
				<div class="form-group">
					<select data-placeholder="نام شهر مبدأ" name="cityOrigin" style="width: 100%;" id="cityOrigin" class="select2 w-100" onchange="selectDest()">
						{foreach $busRoutes as $route}
							<option value="{$route.iataCode}">{$route.name_fa}</option>
						{/foreach}
					</select>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search">
				<div class="form-group">
					<select data-placeholder="نام شهر مقصد" name="cityDestination" style="width: 100%;" id="cityDestination"
							class="select2 w-100">
						{foreach $busRoutes as $route}
							<option value="{$route.iataCode}">{$route.name_fa}</option>
						{/foreach}
					</select>
				</div>
			</div>

			<div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search search_col">
				<div class="form-group">
					<input type="text" class="{$DeptDatePickerClass} form-control "
						   name="gds_dept_date_bus"
						   id="dateMoveBus" placeholder="تاریخ حرکت">

				</div>
			</div>


			<div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search">
				<button type="button" class="btn theme-btn seub-btn b-0 site-bg-main-color"
						onclick="submitSearchBus()"><span>جستجو</span></button>
			</div>

		</form>

	</div>
</div>

<script>
    function selectDest() {
        let thisForm = $('form[name="gds_bus"]');
        console.log(thisForm.find('#cityOrigin').val());
        thisForm.find('#cityDestination').select2('open');
    }
</script>