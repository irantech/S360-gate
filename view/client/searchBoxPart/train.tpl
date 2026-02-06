<div class="tab-pane" id="train" role="tabpanel" aria-labelledby="train-tab">
	<div class="switches">
		<label for="rdo_train" class="btn-radio">
			<input checked="" type="radio" id="rdo_train" name="DOM_TripMode_train" value="1"
				   class="Oneway" onclick="removeMultiple('rdo_train2')">
			<svg width="20px" height="20px" viewBox="0 0 20 20">
				<circle class="site-svg-path-color" cx="10" cy="10" r="9"></circle>
				<path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"
					  class="inner site-svg-path-color"></path>
				<path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"
					  class="outer site-svg-path-color"></path>
			</svg>
			<span>یک طرفه </span>
		</label>

		<label for="rdo_train2" class="btn-radio">

			<input type="radio" id="rdo_train2" name="DOM_TripMode_train" value="2"
				   class="multiWays TwowayTrain " onclick="createMultiple('rdo_train2')">
			<svg width="20px" height="20px" viewBox="0 0 20 20">
				<circle class="site-svg-path-color" cx="10" cy="10" r="9"></circle>
				<path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"
					  class="inner site-svg-path-color"></path>
				<path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"
					  class="outer site-svg-path-color"></path>
			</svg>
			<span>دو طرفه </span>
		</label>


	</div>

	<div class="row m-auto">

		<form class="d_contents"
			  method="post"
			  name="gds_train"
			  id="gds_train">

			<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">
				<div class="form-group">
					<select data-placeholder="مبدأ ( نام شهر)" name="origin_train" id="origin_train" class="select2">
						<option value="">انتخاب کنید...</option>
						{foreach $trainRoutes as $route}
							<option value="{$route.Code}">{$route.Name}</option>
						{/foreach}
					</select>
				</div>
			</div>

			<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">
				<div class="form-group">
					<select data-placeholder="مقصد ( نام شهر  )" name="destination_train" id="destination_train" class="select2 ">
						{foreach $trainRoutes as $route}
							<option value="{$route.Code}">{$route.Name}</option>
						{/foreach}

					</select>
				</div>
			</div>

			<div class="col-lg-4 col-md-5 col-sm-6 col-12 col_search date_search">
				<div class="form-group">
					<input readonly type="text" id="dept_date_train"
						   class="shamsiDeptCalendar in-tarikh form-control went"
						   placeholder="تاریخ رفت">

				</div>
				<div readonly class="form-group">
					<input disabled type="text" id="dept_date_train_return"
						   class="form-control shamsiReturnCalendar form-control  return_input_train"
						   placeholder="تاریخ برگشت">

				</div>
			</div>

			<div class="col-lg-2 col-md-4 col-sm-6 col-12 col_search">
				<div class="select inp-s-num adt box-of-count-nafar">
					<input type="hidden" class="l-bozorgsal"
						   name="gds_adults_no_local"
						   id="qty1"
						   value="1">
					<input type="hidden" class="l-kodak"
						   name="gds_childs_no_local"
						   id="qty2">
					<input type="hidden" class="l-nozad"
						   name="gds_infants_no_local"
						   id="qty3">
					<div class="box-of-count-nafar-boxes">
                                        <span class="text-count-nafar">
                                        1 بزرگسال ,0 کودک ,0 نوزاد
                                        </span>
						<span class="fas fa-caret-down down-count-nafar site-color-main-color-before"></span>

					</div>
					<div class="cbox-count-nafar" style="display: none;">
						<div class="col-12 cbox-count-nafar-ch bozorg-num">
							<div class="row">
								<div class="col-xs-12 col-6 col-sm-6">
									<div class="type-of-count-nafar">
										<h6> بزرگسال </h6> (بزرگتر از ۱۲ سال)
									</div>
								</div>
								<div class="col-xs-12  col-6 col-sm-6">
									<div class="num-of-count-nafar">
										<i class="fas fa-plus counting-of-count-nafar plus-nafar"></i>
										<i class="number-count counting-of-count-nafar"
										   data-number="1" data-min="1"
										   data-value="l-bozorgsal"
										   id="bozorgsal">1</i>
										<i class="fas fa-minus counting-of-count-nafar minus-nafar"></i>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 cbox-count-nafar-ch koodak-num">
							<div class="row">
								<div class="col-6 col-6 col-sm-6">
									<div class="type-of-count-nafar">
										<h6> کودک </h6>(بین 2 الی 12 سال)
									</div>
								</div>
								<div class="col-6 col-sm-6">
									<div class="num-of-count-nafar"><i
												class="fas fa-plus counting-of-count-nafar plus-nafar"></i>
										<i class="number-count counting-of-count-nafar"
										   data-number="0" data-min="0"
										   data-value="l-kodak">0</i>
										<i class="fas fa-minus counting-of-count-nafar minus-nafar"></i>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 cbox-count-nafar-ch nozad-num">
							<div class="row">
								<div class="col-6 col-sm-6">
									<div class="type-of-count-nafar">
										<h6> نوزاد </h6>(کوچکتر از 2 سال)
									</div>
								</div>
								<div class="col-6 col-sm-6">
									<div class="num-of-count-nafar"><i
												class="fas fa-plus counting-of-count-nafar plus-nafar"></i>
										<i class="number-count counting-of-count-nafar"
										   data-number="0" data-min="0"
										   data-value="l-nozad">0</i>
										<i class="fas fa-minus counting-of-count-nafar minus-nafar"></i>
									</div>
								</div>
							</div>
						</div>


						<div class="col-12 cbox-count-check d-none">
							<div class="row">

								<div class="radios textbox col-xl-12 ">

									<div class="TripTypeRadio ">
										<div class="form-group non-selectable">
											<input type="radio" value="3"
												   id="rd-check"
												   name="Type_seat_train"
												   class="form-control-rd"
												   checked="checked">
											<label for="rd-check"
												   class="form-control-rd-lbl">

												<span></span>

											</label>
											<label for="rd-check"
												   class="pointer">مسافرین
												عادی</label>
										</div>
									</div>
									<div class=" TripTypeRadio  ">
										<div class="form-group non-selectable">
											<input type="radio" value="1"
												   data-radio-type="one"
												   id="rd-check2"
												   name="Type_seat_train"
												   class="form-control-rd">
											<label for="rd-check2"
												   class="form-control-rd-lbl">
												<span></span>
											</label>
											<label for="rd-check2"
												   class="pointer">ویژه
												برادران</label>
										</div>
									</div>

									<div class=" TripTypeRadio  ">
										<div class="form-group non-selectable">
											<input type="radio" value="2"
												   data-radio-type="one"
												   id="rd-check3"
												   name="Type_seat_train"
												   class="form-control-rd">
											<label for="rd-check3"
												   class="form-control-rd-lbl">
												<span></span>
											</label>
											<label for="rd-check3"
												   class="pointer">ویژه
												خواهران</label>
										</div>
									</div>

									<div class="checkbox_coupe">
										<input type="checkbox" id="coupe">
										<label for="coupe">کوپه در بست</label>
									</div>

								</div>

							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search">
				<button type="button" onclick="submitSearchTrain()"
						class="btn theme-btn seub-btn b-0 site-bg-main-color">
                                    <span>
                                    جستجو
                                </span>
				</button>
			</div>


		</form>

	</div>

</div>