<div class="tab-pane" id="fun" role="tabpanel" aria-labelledby="fun-tab">
	<div class="row">
		<form class="d_contents" method="post" name="entertainmentForm" id="entertainmentForm">
			<div class="col-lg-4 col-md-6 col-sm-6 col-12 col_search">
				<div class="form-group">
					<select data-placeholder=" مجموعه تفریحات" name="CategoryEntertainment"
							id="CategoryEntertainment"
							class="select2 " onchange="GetSubCategoriesOnSelectBox($(this))">
						<option value="">انتخاب کنید...</option>
						{foreach $entertainmentCategiries as $category}
							<option value="{$category['id']}">{$category['title']}</option>
						{/foreach}

					</select>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-6 col-12 col_search">
				<div class="form-group">
					<select data-placeholder="زیر مجموعه تفریحات"
							name="EntertainmentSubCategory"
							id="EntertainmentSubCategory"
							class="select2 ">
						<option value="">انتخاب کنید...</option>


					</select>
				</div>
			</div>


			<div class="col-lg-4 col-md-4 col-sm-6 col-12 btn_s col_search">
				<button type="button" onclick="submit_tafrih_form_js()"
						class="btn theme-btn seub-btn b-0 site-bg-main-color">
                                    <span>
                                    جستجو
                                </span>
				</button>
			</div>

		</form>

	</div>

</div>