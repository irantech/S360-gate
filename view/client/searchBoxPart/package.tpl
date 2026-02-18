<div class="tab-pane" id="package" role="tabpanel"
	 aria-labelledby="package-tab">
	<div class="row  ">
		<form method="post"
			  name="gdsPackage"
			  id="gdsPackage"
			  class="d_contents">

			<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col">
				<div class="form-group">
                                    <span class="origin_start ">
                                    <input type="text" name="OriginPackage" id="OriginPackage"
										   class="form-control  inputSearchPackage"
										   placeholder="مبدأ ">
                                    </span>

					<img src="images/loader.gif" class="loaderSearch"
						 id="loaderSearch" name="loaderSearch"
						 style="display: none">
					<input type="hidden" id="departureSelected" value="" name="departureSelected">
					<input type="hidden" id="routeType" value="" name="routeType">

					<div id="ListOriginPackage" class="resultUlInputSearch"
						 style="display: none"></div>


				</div>
			</div>
			<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col">
				<div class="form-group">
					<div class="destnition_start">
						<input type="text" id="DestinationPackage" name="DestinationPackage"
							   class="inputSearchForeign form-control "
							   placeholder="مقصد ">
					</div>
					<input id="DestinationAirportPackage" class="" type="hidden"
						   value="" name="DestinationAirportPackage">
					<div id="ListPackageDestination" class="resultUlInputSearch"
						 style="display: none"></div>
					<div class="ListAirPort" id="ListPackageDestination_2">


					</div>
				</div>
			</div>
			<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col">
				<div class="form-group">
					<input type="text" class="shamsiDeptCalendarForPackage form-control "
						   name="startDateForPackage"
						   id="startDateForPackage"
						   placeholder="تاریخ رفت">

				</div>
			</div>

			<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col">
				<div class="form-group">
					<input type="text" class="shamsiReturnCalendarForPackage form-control "
						   name="endDateForPackage"
						   id="endDateForPackage" placeholder="تاریخ برگشت">

				</div>
			</div>

			<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">

				<div class="form-group">

					<div id="package_room" class="package_passenger_picker">

						<ul>
							<li><em class="number_adult_p">2</em> بزرگسال ،</li>
							<li class="li_number_baby_p"><em class="number_baby_p">0</em> کودک ،
							</li>
							<li><em class="number_room_p">1</em>اتاق</li>
						</ul>


						<div class="mypackege-rooms">
							<i class="close_room"></i>

							<div class="package_select_room">
								<div class="myroom-package-item" data-roomnumber="1">
									<div class="myroom-package-item-title">
										اتاق اول
										<span class="close">
                                                    <i class="fal fa-trash-alt"></i>
                                                </span>
									</div>
									<div class="myroom-package-item-info">
										<div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">

											<h6>بزرگسال</h6>
											(بزرگتر از ۱۲ سال)
											<div>
												<i class="addParent_p plus-nafar hotelroom-minus plus-hotelroom-bozorgsal fas fa-plus"></i>
												<input readonly="" autocomplete="off"
													   class="countParent_p" min="0" value="2"
													   max="5" type="text" name="adult_p"
													   id="adult_p"><i
														class="minusParent_p minus-nafar hotelroom-minus minus-hotelroom-bozorgsal fas fa-minus"></i>
											</div>
										</div>
										<div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
											<h6>کودک</h6>
											(کوچکتر از ۱۲ سال)

											<div>
												<i class="addChild_p plus-nafar hotelroom-minus plus-hotelroom-koodak fas fa-plus"></i>
												<input readonly="" class="countChild_p"
													   autocomplete="off" min="0" value="0" max="5"
													   type="text" name="child_p" id="child_p"><i
														class="minusChild_p minus-nafar hotelroom-minus minus-hotelroom-koodak fas fa-minus"></i>
											</div>
										</div>
										<div class="tarikh-tavalods"></div>
									</div>
								</div>
							</div>
							<div class="btn_add_room_p">
								<i class="fal fa-plus"></i>
								افزودن اتاق
							</div>

						</div>


					</div>
				</div>

			</div>
			<div class="search_btn_div col-lg-2 ">

				<button type="button" onclick="searchPackage()"
						class="btn theme-btn seub-btn b-0 site-bg-main-color">
					<span>جستجو</span>
				</button>
			</div>
		</form>
	</div>
</div>