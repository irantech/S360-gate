{load_presentation_object filename="busPanel" assign="objResult"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-3 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href='main'>
                        مدیریت بلیط رزرواسیون اتوبوس
                    </a>
                </li>
                <li class="active">افزودن اتوبوس جدید</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <form class='d-flex w-100 flex-wrap' id="form_reservation_bus" method="post" action="">
                    <input type="hidden" name="flag" value="insert_ticket">


                    <div class='d-flex w-100'>
                        <h3 class='mb-5'>مبدا و مقصد</h3>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="origin_city" class="control-label">شهر مبدا</label><span class="star">*</span>
                        <select onchange='getStations($(this).val(),$("#origin_terminal"))'
                                data-action='required'
                                name="origin_city"
                                id="origin_city" class="select2 form-control">
                            <option value="">انتخاب کنید....</option>
                            {foreach $objResult->getCities(['*']) as $city}
                                <option value="{$city['id']}">{$city['name_fa']}</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="destination_city" class="control-label">شهر مقصد</label><span class="star">*</span>
                        <select onchange='getStations($(this).val(),$("#destination_terminal"))' name="destination_city"
                                data-action='required'
                                id="destination_city" class="select2 form-control">
                            <option value="">انتخاب کنید....</option>
                            {foreach $objResult->getCities(['*']) as $city}
                                <option value="{$city['id']}">{$city['name_fa']}</option>
                            {/foreach}
                        </select>
                    </div>


                    <div class="form-group col-sm-3">
                        <label for="origin_terminal" class="control-label">نام پایانه مبدا</label>
                        <span class="star">*</span>
                        <select name="origin_terminal"
                                data-action='required'
                                id="origin_terminal" class="select2 form-control">
                            <option value="">ابتدا مبدا را انتخاب کنید</option>

                        </select>
                        <a class='mt-1' href='stations'>تعریف پایانه</a>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="destination_terminal" class="control-label">نام پایانه مقصد</label>
                        <span class="star">*</span>
                        <select name="destination_terminal" id="destination_terminal"
                                data-action='required'
                                class="select2 form-control">



                        </select>
                        <a class='mt-1' href='stations'>تعریف پایانه</a>
                    </div>


                    <div class="form-group col-sm-12 mb-3">
                        <label class="control-label">توقف های بین راه</label>

                        <div class="row">

                            <div class="form-group m-0 col-sm-12 DynamicExtraStationData">

                                <div data-target="BaseExtraStationDataDiv" class="col-sm-12 p-0 form-group">
                                    <div class="col-md-11 p-0">
                                        <label class="control-label d-none">توقف های بین راه</label>
                                        <input data-parent="ExtraStationDataValues" data-target="body" name="ExtraStationData[0][body]" placeholder="نام ایستگاه"
                                               data-action='required'
                                               class="form-control"
                                               type="text">
                                    </div>
                                    <div class="col-md-1 pl-0">
                                        <div class="col-md-6 p-0">
                                            <button type="button" onclick="AddExtraStationData()" class="btn form-control btn-success">
                                                <span class="fa fa-plus"></span>
                                            </button>
                                        </div>
                                        <div class="col-md-6 p-0">
                                            <button onclick="RemoveExtraStationData($(this))" type="button" class="btn form-control btn-danger">
                                                <span class="fa fa-remove"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>


                    <div class='d-flex w-100'>
                        <h3 class='my-3'>اطلاعات اتوبوس</h3>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="company" class="control-label">انتخاب تعاونی</label>
                        <span class="star">*</span>
                        <select name="company" id="company"
                                data-action='required'
                                class="select2 form-control">
                            <option value="">انتخاب کنید....</option>
                            {foreach $objResult->getBaseCompanyBus() as $item}
                                <option value="{$item['id']}">{$item['name_fa']}</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="price" class="control-label">قیمت ( ریال )</label>
                        <span class="star">*</span>
                        <input type="number" autocomplete='off'
                               data-action='required'
                               class="form-control" name="price"
                               id="price" placeholder="قیمت را به ریال وارد نمائید">
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="vehicle_name" class="control-label">نام خودرو</label>
                        <span class="star">*</span>
                        <input type="text" autocomplete='off' class="form-control" name="vehicle_name"
                               data-action='required'
                               id="vehicle_name" placeholder="نام خودرو را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="chairs_count" class="control-label">تعداد صندلی ها</label>
                        <span class="star">*</span>
                        <select name="chairs_count"
                                data-action='required'
                                id="chairs_count" class="select2 form-control">
                            <option value="">انتخاب کنید....</option>
                            {foreach $objResult->getChairsArray() as $item}
                                <option value="{$item}">{$item}</option>
                            {/foreach}
                        </select>
                    </div>






                    <div class='d-flex w-100'>
                        <h3 class='my-3'>اطلاعات زمان حرکت</h3>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="move_date" class="control-label">تاریخ حرکت</label>
                        <span class="star">*</span>
                        <input type="text" autocomplete='off'
                               data-action='required'
                               class="form-control datepicker" name="move_date"
                               id="move_date" placeholder="تاریخ حرکت را وارد نمائید">
                    </div>


                    <div class="form-group col-sm-3">
                        <label for="move_time" class="control-label">ساعت حرکت</label>
                        <span class="star">*</span>
                        <input type="time" class="form-control" name="move_time"
                               data-action='required'
                               id="move_time" placeholder="ساعت حرکت را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="duration_time" class="control-label">مدت سفر</label>
                        <span class="star">*</span>
                        <input type="time" class="form-control" name="duration_time"
                               data-action='required'
                               id="duration_time" placeholder="مدت سفر را وارد نمائید">
                    </div>




                    <div class='d-flex w-100'>
                        <h3 class='my-3'>توضیحات</h3>
                    </div>


                    <div class="form-group col-sm-12">
                        <label for="description" class="control-label"> توضیحات</label>
                        <span class="star">*</span>
                        <textarea class="form-control"
                                  data-action='required'
                                  name="description"
                                  id="description" placeholder=" توضیحات را وارد نمائید"></textarea>
                    </div>


                    <div class="form-group col-sm-3">

                        <button onclick='submitNewReservationBus($(this),$("#form_reservation_bus"))'
                                type='button'
                                class='btn btn-primary'>ثبت اتوبوس</button>
                    </div>


                </form>
            </div>

        </div>
    </div>

</div>
<script type="text/javascript" src="assets/JsFiles/reservationBus.js"></script>