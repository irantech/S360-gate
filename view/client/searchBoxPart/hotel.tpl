  <div class="tab-pane" id="hotel" role="tabpanel" aria-labelledby="hotel-tab">

	<div class="radios switches">

		<div class="switch">

			<input autocomplete="off" type="radio" class="switch-input" name="hotel_switch" value="1"
				   id="hdakheli">
			<label for="hdakheli" class="switch-label switch-label-on"> ##Internal##</label>
			<input autocomplete="off" type="radio" class="switch-input" name="hotel_switch" value="2"
				   id="hkharegi">
			<label checked for="hkharegi" class="switch-label switch-label-off">##Foreign##</label>
			<span class="switch-selection site-bg-main-color"></span>

		</div>


	</div>

	<div id="hotel_dakheli" class="row  ">

		<form name="gdsHotelLocal"
			  id="gdsHotelLocal"
			  class="d_contents"
			  method="post">


			<div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search search_col">
				<div class="form-group">
                                    <span class="destnition_start">
                                         <select name="destination_city" id="destination_city" class="select2 form-control">
                                            {foreach $hotelCities as $city}
												<option value="{$city['id']}" >
													{$city[$objFunctions->ChangeIndexNameByLanguage($smarty.const.SOFTWARE_LANG,'city_name')]}
												</option>
											{/foreach}
                                        </select>
                                    </span>

				</div>
			</div>

			<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col">
				<div class="form-group">
					<input readonly type="text" class="{$classNameStartDate} form-control "
						   name="startDate"
						   id="startDate"
						   placeholder="تاریخ ورود">

				</div>
			</div>

			<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col">
				<div class="form-group">
					<input readonly type="text" class="{$classNameEndDate} form-control "
						   name="endDate"
						   id="endDate" placeholder="تاریخ خروج">

				</div>
			</div>


			<div class="col-lg-3 col-md-4 col-sm-6 col-12 col_search">
				<div class=" days-in-hotel">
					<input type="hidden" id="stayingTime" name="stayingTime"
						   value="">
					<i class="fal fa-moon"></i> مدت اقامت
					<div class="result-st">
						<em class="days" id="stayingTimeForSearch"> 0 </em>
					</div>
				</div>
			</div>

			<div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search">
				<button type="button" onclick="submitSearchHotelLocal()"
						class="btn theme-btn seub-btn b-0 site-bg-main-color">
					<span>جستجو</span></button>
			</div>

		</form>

	</div>

	<div id="hotel_khareji" class="row ">

		<form class="d_contents"
			  method="post"
			  id="gdsExternalHotel">


			<div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search search_col">
				<div class="form-group">
                                <span class="destnition_start">
                                      <input id="autoComplateSearchIN" name="autoComplateSearchIN"
											 class="inputSearchForeign form-control" type="text" value=""
											 onkeyup="searchCity()">
                               </span>
					<input id="destination_country" name="destination_country" type="hidden"
						   value="">
					<input id="destination_city_foreign" name="destination_city_foreign" type="hidden"
						   value="">

					<img src="assets/images/load.gif" id="LoaderForeignDep" name="LoaderForeignDep"
						 class="loaderSearch">
					<ul id="listSearchCity" class="ul-inputSearch-externalHotel displayiN"></ul>

				</div>
			</div>

			<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col">
				<div class="form-group">
					<input readonly type="text" class="{$classNameStartDateForiegn} form-control"
						   name="startDate"
						   id="startDateForeign" placeholder="تاریخ ورود"/>

				</div>
			</div>

			<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col">
				<div class="form-group">
					<input readonly type="text" class="{$classNameEndDateForiegn} form-control "
						   name="endDate"
						   id="endDateForeign" placeholder="تاریخ خروج">

				</div>
			</div>

			<div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search">

				<div class="form-group">

					<div class="hotel_passenger_picker">
						<input type="hidden" id="countRoom" name="countRoom" value="1">
						<ul>
							<li><em class="number_adult">2</em> بزرگسال ،</li>
							<li class="li_number_baby"><em class="number_baby">0</em> کودک ،</li>
							<li><em class="number_room">1</em>اتاق</li>
						</ul>


						<div class="myhotels-rooms">
							<i class="close_room"></i>

							<div class="hotel_select_room">
								<div class="myroom-hotel-item" data-roomnumber="1">
									<div class="myroom-hotel-item-title">
										<span class="close">    <i class="fal fa-trash-alt"></i> </span> اتاق اول
									</div>
									<div class="myroom-hotel-item-info">
										<div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">

											<h6>بزرگسال</h6>
											(بزرگتر از ۱۲ سال)
											<div>
												<i class="addParent plus-nafar hotelroom-minus plus-hotelroom-bozorgsal fas fa-plus"></i>
												<input readonly="" autocomplete="off"
													   class="countParent"
													   min="0" value="2"
													   max="5" type="number" name="adult1"
													   id="adult1"><i
														class="minusParent minus-nafar hotelroom-minus minus-hotelroom-bozorgsal fas fa-minus"></i>
											</div>
										</div>
										<div class="myroom-hotel-item-tedad my-room-hotel-bozorgsal">
											<h6>کودک</h6>
											(کوچکتر از ۱۲ سال)

											<div>
												<i class="addChild plus-nafar hotelroom-minus plus-hotelroom-koodak fas fa-plus"></i>
												<input readonly="" class="countChild" autocomplete="off"
													   min="0" value="0" max="5"
													   type="number" name="childAge1" id="childAge1"><i
														class="minusChild minus-nafar hotelroom-minus minus-hotelroom-koodak fas fa-minus"></i>
											</div>
										</div>
										<div class="tarikh-tavalods"></div>
									</div>
								</div>
							</div>
							<div class="btn_add_room">
								<i class="fal fa-plus"></i>
								افزودن اتاق
							</div>

						</div>


					</div>


				</div>

			</div>

			<div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search">
				<input type="hidden" id="stayingTimeForeign" name="stayingTimeForeign"
					   value="">
				<button onclick="submitSearchExternalHotel()" type="button"
						class="btn theme-btn seub-btn b-0 site-bg-main-color">
					<span>جستجو</span>
				</button>
			</div>


		</form>

	</div>


</div>