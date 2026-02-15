<div class="tab-pane" id="tour" role="tabpanel" aria-labelledby="tour-tab">
	<div class="radios switches">
		<div class="switch">
			<input autocomplete="off" type="radio" class="switch-input" name="DOM_TripMode5" value="1"
				   id="tour_l">
			<label for="tour_l" class="switch-label switch-label-on"> داخلی</label>
			<input autocomplete="off" type="radio" class="switch-input" name="DOM_TripMode5" value="2"
				   id="tour_f">
			<label checked for="tour_f" class="switch-label switch-label-off">خارجی</label>
			<span class="switch-selection site-bg-main-color"></span>
		</div>

	</div>


	<div id="tour_dakheli" class="row">
		<form class="d_contents"
			  method="post" name="gds_tour"
			  id="gdsTourLocal">
			<input type="hidden" id="tourOriginCountry" value="1">
			<input type="hidden" id="tourDestinationCountry" value="1">
			<input type="hidden" id="tourOriginRegion" value="all">
			<input type="hidden" id="tourType" value="all">

			<div class="col-lg-4 col-md-6 col-sm-6 col-12 col_search">
				<div class="form-group">
					<div class="select">
						<select name="tourOriginCity" id="tourOriginCity" class="select2"
								onchange="getTourRegion('origin', 'all', 'dept')">
							<option value="all">انتخاب کنید...</option>
							{foreach $listCityDept as $city}
								<option value="{$city.id}">
									{if $smarty.const.SOFTWARE_LANG != 'fa'} {$city.name_en} {else} {$city.name} {/if}
								</option>
							{/foreach}
						</select>
					</div>
				</div>
			</div>

			<div class="col-lg-4 col-md-6 col-sm-6 col-12 col_search">
				<div class="form-group">
					<div class="select">
						<select name="tourDestinationCity" id="tourDestinationCity" class="select2"
								onchange="getTourRegion('destination', 'all', 'return')">
							<option value="all" selected="selected"> ##Destinationcity##</option>
							{foreach $listCityReturn as $city}
								<option value="{$city.id}">
									{if $smarty.const.SOFTWARE_LANG != 'fa'} {$city.name_en} {else} {$city.name} {/if}
								</option>
							{/foreach}
						</select>
					</div>
				</div>
			</div>

			<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">
				<div class="form-group">
					{assign var="year_select" value=$objFunctions->DateFunctionWithLanguage('Y',strtotime('today'))}
					{assign var="month_select" value=$objFunctions->DateFunctionWithLanguage('m',strtotime('today'))}

					<select data-placeholder="تاریخ مسافرت" id="tourStartDate" name="startDate" class="select2">
						<option value="">انتخاب کنید...</option>
						{assign var="month_select_counter" value=$month_select}
						{assign var="nextYearShowCheck" value=0}
						{assign var="i" value=1}

						{for $i=0 to 3}
							{if $month_select_counter > 12}
								{assign var="thisyear" value=strtotime('+1 year')}
								{assign var='nextYearShowCheck' value=$nextYearShowCheck+1}
							{else}
								{assign var="thisyear" value=strtotime('today')}
							{/if}
							{if $nextYearShowCheck == 0}
								{assign var="thisMonth" value=$month_select_counter}

							{else}
								{assign var="thisMonth" value=$nextYearShowCheck}

							{/if}
							{assign var="year_select" value=$objFunctions->DateFunctionWithLanguage('Y',$thisyear)}
							{assign var="thisMonthEdited" value=sprintf( "%02d", $thisMonth )}
							{if $smarty.const.SOFTWARE_LANG neq 'fa'}

								{assign var="CalenderMonthName" value=date("F", mktime(0, 0, 0, $thisMonth, 10))}
							{else}
								{assign var="CalenderMonthName" value=$objFunctions->CalenderMonthName($thisMonth)}
							{/if}
							<option value="{$year_select}-{$thisMonthEdited}-01"> {$CalenderMonthName} - {$year_select}</option>
							{*                                        {assign var=$i value=$i+1}*}
							{assign var='month_select_counter' value=$month_select_counter+1}
						{/for}

					</select>
				</div>
			</div>

			<div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search">
				<button type="button" onclick="submitSearchTourLocal(true)" class="btn theme-btn seub-btn b-0 site-bg-main-color">
					<span>جستجو</span>
				</button>
			</div>

		</form>

	</div>

	<div id="tour_khareji" class="row">
		<form class="d_contents" method="post" name="gds_tour_portal" id="gdsTourPortal">
			<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">
				<div class="form-group">
					<input type="text" class="form-control" disabled placeholder="کشور مبدا: ایران">
					<input type="hidden" value="1" name="tourOriginCountryPortal" id="tourOriginCountryPortal">

				</div>
			</div>

			<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">
				<div class="form-group">
					<select data-placeholder=" شهر مبدا" name="tourOriginCityPortal"
							id="tourOriginCityPortal" class="select2">
						<option value="">انتخاب کنید...</option>
						{foreach $listCityDept as $city}
							<option value="{$city.id}">
								{if $smarty.const.SOFTWARE_LANG != 'fa'} {$city.name_en} {else} {$city.name} {/if}
							</option>
						{/foreach}
					</select>
				</div>
			</div>

			<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">
				<div class="form-group">
					<select data-placeholder="کشور مقصد" name="tourDestinationCountryPortal"
							id="tourDestinationCountryPortal" class="select2">
						<option value="">انتخاب کنید...</option>
						{foreach $listCountryReturn as $country}
							<option value="{$country.id}">
								{if $smarty.const.SOFTWARE_LANG != 'fa'} {$country.name_en} {else} {$country.name} {/if}
							</option>
						{/foreach}

					</select>
				</div>
			</div>

			<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">
				<div class="form-group">
					<select data-placeholder="شهر مقصد" name="tourDestinationCityPortal" id="tourDestinationCityPortal" class="select2" onchange="getTourCities('destination', 'all', 'return')">
						<option value="">انتخاب کنید...</option>
						{foreach $listCityReturn as $city}
							<option value="{$city.id}">
								{if $smarty.const.SOFTWARE_LANG != 'fa'} {$city.name_en} {else} {$city.name} {/if}
							</option>
						{/foreach}
					</select>
				</div>
			</div>

			<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">
				<div class="form-group">
					{assign var="year_select" value=$objFunctions->DateFunctionWithLanguage('Y',strtotime('today'))}
					{assign var="month_select" value=$objFunctions->DateFunctionWithLanguage('m',strtotime('today'))}
					{*{$classNameStartDate}*}
					<select data-placeholder="تاریخ مسافرت" id="tourStartDatePortal"
							name="startDate" class="select2">
						<option value="">انتخاب کنید...</option>
						{assign var="month_select_counter" value=$month_select}
						{assign var="nextYearShowCheck" value=0}
						{assign var="i" value=1}

						{for $i=0 to 3}
							{if $month_select_counter > 12}
								{assign var="thisyear" value=strtotime('+1 year')}
								{assign var='nextYearShowCheck' value=$nextYearShowCheck+1}
							{else}
								{assign var="thisyear" value=strtotime('today')}
							{/if}
							{if $nextYearShowCheck == 0}
								{assign var="thisMonth" value=$month_select_counter}

							{else}
								{assign var="thisMonth" value=$nextYearShowCheck}

							{/if}
							{assign var="year_select" value=$objFunctions->DateFunctionWithLanguage('Y',$thisyear)}
							{assign var="thisMonthEdited" value=sprintf( "%02d", $thisMonth )}
							{if $smarty.const.SOFTWARE_LANG neq 'fa'}

								{assign var="CalenderMonthName" value=date("F", mktime(0, 0, 0, $thisMonth, 10))}
							{else}
								{assign var="CalenderMonthName" value=$objFunctions->CalenderMonthName($thisMonth)}
							{/if}
							<option value="{$year_select}-{$thisMonthEdited}-01"> {$CalenderMonthName} - {$year_select}</option>
							{*                                        {assign var=$i value=$i+1}*}
							{assign var='month_select_counter' value=$month_select_counter+1}
						{/for}

					</select>
				</div>
			</div>

			<div class="col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search">
				<button type="button" onclick="submitSearchTourLocal(false)" class="btn theme-btn seub-btn b-0 site-bg-main-color">
					<span>جستجو</span>
				</button>
			</div>

		</form>

	</div>
</div>