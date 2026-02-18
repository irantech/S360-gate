<div class="tab-pane" id="gasht" role="tabpanel" aria-labelledby="gasht-tab">


    <div class="radios switches">
        <div class="switch ">

            <input type="radio" class="switch-input" autocomplete="off"
                   name="gasht_switch" value="1"
                   id="gasht_" onclick="changeGashtOrTransfer(this)">
            <label for="gasht_" class="switch-label switch-label-on">گشت </label>
            <input type="radio" autocomplete="off"
                   class="switch-input"
                   name="gasht_switch" value="2"
                   id="transfer_"  onclick="changeGashtOrTransfer(this)">
            <label checked for="transfer_" class="switch-label switch-label-off">ترنسفر </label>


            <span class="switch-selection site-bg-main-color"></span>
        </div>

    </div>
    <div id="gasht_div" class="row  ">
		<input type="hidden" id="request-type" value="0">
        <form
                method="post"
                name="GashtForm"
                id="gdsGasht"

                class="d_contents">


            <div class="col-lg-4 col-md-6 col-sm-6 col-12 col_search">
                <div class="form-group">
                    <select data-placeholder="مقصد ( نام شهر)" name="destination_gasht"
                            id="destination_gasht"
                            class="select2 ">
                        <option value="">انتخاب کنید...</option>
                        {foreach $getCitiesGasht as $city}
							<option value="{$city['city_code']}">{$city['city_name']}</option>
                        {/foreach}


                    </select>
                </div>
            </div>


            <div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search ">
                <div class="form-group">
                    <input type="text"
                           name="date_gasht"
                           id="date_gasht" class="shamsiDeptCalendar form-control"
                           placeholder="تاریخ درخواست سرویس">

                </div>

            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search">
                <div class="form-group">
                    <select data-placeholder="نوع گشت  " name="gasht-type" id="gasht-type"
                            class="select2 ">
                        <option value="">انتخاب کنید...</option>

                        <option value="1">گشت انفرادی</option>
                        <option value="2">گشت گروهی</option>


                    </select>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search">
                <button type="button" onclick="submitSearchGasht()" class="btn theme-btn seub-btn b-0 site-bg-main-color">
                                    <span>
                                    جستجو
                                </span>
                </button>
            </div>

        </form>


    </div>
    <div id="transfer_div" class="row  ">

        <form
                method="post"
                name="gdsTransfer"
                id="gdsTransfer"
                class="d_contents">

            <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">
                <div class="form-group">
                    <select data-placeholder="مقصد ( نام شهر)" name="destination_transfer"
                            id="destination_transfer"
                            class="select2 ">
                        <option value="">انتخاب کنید...</option>
						{foreach $getCitiesGasht as $city}
							<option value="{$city['city_code']}">{$city['city_name']}</option>
						{/foreach}

                    </select>
                </div>
            </div>


            <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search ">
                <div class="form-group">
                    <input type="text" class="shamsiDeptCalendar form-control"
                           name="date_transfer"
                           id="date_transfer" placeholder="تاریخ درخواست سرویس">

                </div>

            </div>
            <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">
                <div class="form-group">
                    <select data-placeholder="استقبال" name="welcome-type" id="welcome-type"
                            class="select2 ">

                        <option selected="selected" value="1">استقبال</option>
                        <option value="2">بدرقه</option>
                        <option value="3">استقبال و بدرقه</option>

                    </select>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">
                <div class="form-group">
                    <select data-placeholder="نوع اتوموبیل" name="vehicle-type"
                            id="vehicle-type"
                            class="select2 ">
                        <option selected="selected" value="1">سواری</option>
                        <option value="2">ون</option>
                        <option value="3">مینی بوس</option>
                        <option value="4">اتوبوس</option>
                        <option value="5">شناور</option>

                    </select>
                </div>
            </div>


            <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">
                <div class="form-group">
                    <select data-placeholder=" فرودگاه  " name="transfer-place"
                            id="transfer-place"
                            class="select2 ">
                        <option selected="selected" value="1">فرودگاه</option>
                        <option value="2">ترمینال</option>
                        <option value="3">راه آهن</option>
                        <option value="4">بندر</option>
                    </select>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search">
                <button type="button" onclick="submitSearchGasht()"
                        class="btn theme-btn seub-btn b-0 site-bg-main-color">
                                    <span>
                                    جستجو
                                </span>
                </button>
            </div>

        </form>

    </div>


</div>