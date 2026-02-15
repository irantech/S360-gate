{load_presentation_object filename="reservationPublicFunctions" assign="objPublic"}
{load_presentation_object filename="reservationHotel" assign="objResult"}

{load_presentation_object filename="reservationBasicInformation" assign="objBasic"}
{$objBasic->SelectAllWithCondition('reservation_hotel_room_prices_tb', 'id', $smarty.get.id)}

{$objResult->SelectRoomPrices($objBasic->list['id_city'], $objBasic->list['id_hotel'], $objBasic->list['id_room'], $objBasic->list['user_type'], $objBasic->list['id_same'])}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت هتل رزرواسیون</li>
                <li><a href="reportHotel">گزارش هتل</a></li>
                <li><a href="reportHotelRoom&city={$objResult->listRoomPrices_DBL['id_city']}&hotel={$objResult->listRoomPrices_DBL['id_hotel']}">گزارش اتاق های هتل</a></li>
                <li class="active">اضافه کردن اتاق</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        </div>
    </div>

    <form id="addRoomPricesForUser" method="post" action="{$smarty.const.rootAddress}hotel_ajax">
        <input type="hidden" name="flag" value="insertHotelRoomPriceUser">
        <input type="hidden" name="max_date" id="max_date" value="{$smarty.get.eDate}">

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <div class="row show-grid">
                    <div class="col-md-4">
                        <b>شهر: </b>
                        <input type="hidden" id="id_city" name="id_city" value="{$objResult->listRoomPrices_DBL['id_city']}">
                        {$objPublic->ShowName(reservation_city_tb, $objResult->listRoomPrices_DBL['id_city'])}
                    </div>
                    <div class="col-md-4">
                        <b>هتل: </b>
                        <input type="hidden" id="id_hotel" name="id_hotel" value="{$objResult->listRoomPrices_DBL['id_hotel']}">
                        {$objPublic->ShowName(reservation_hotel_tb, $objResult->listRoomPrices_DBL['id_hotel'])}
                    </div>
                    <div class="col-md-4">
                        <b>کانتر: </b>
                        <input type="hidden" id="user_type" name="user_type" value="{$objResult->listRoomPrices_DBL['user_type']}">
                        {$objPublic->ShowName(counter_type_tb, $objResult->listRoomPrices_DBL['user_type'])}
                    </div>
                </div>
                <div class="row show-grid">
                    <div class="col-md-4">
                        <b>اتاق: </b>
                        <input type="hidden" id="id_room" name="id_room" value="{$objResult->listRoomPrices_DBL['id_room']}">
                        {$objPublic->ShowName(reservation_room_type_tb, $objResult->listRoomPrices_DBL['id_room'], 'comment')}
                    </div>
                    <div class="col-md-4">
                        <b>از تاریخ: </b>
                        {$objPublic->format_Date($smarty.get.sDate)}
                    </div>
                    <div class="col-md-4">
                        <b>تا تاریخ: </b>
                        {$objPublic->format_Date($smarty.get.eDate)}
                    </div>
                </div>

            </div>
        </div>
    </div>



    <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0"></h3>

                    <p class="text-muted m-b-30 size15">تعریف بازه زمانی جدید برای همه ی اتاق ها</p>

                        <div class="form-group col-sm-4">
                            <label for="start_date" class="control-label">شروع تاریخ فروش اتاق</label>
                            <input type="text" class="form-control datepicker" name="start_date" value=""
                                   id="start_date" placeholder="تاریخ شروع برگزاری اتاق را وارد نمائید">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="end_date" class="control-label">پایان تاریخ فروش اتاق</label>
                            <input type="text" class="form-control datepicker" name="end_date" value="" id="end_date"
                                   placeholder="تاریخ پایان برگزاری اتاق را وارد نمائید">
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                                <div class="form-group  pull-right">
                                    <button type="submit" class="btn btn-primary">ارسال اطلاعات</button>
                                </div>
                            </div>
                        </div>


                </div>
            </div>
        </div>




    </form>

</div>


<script type="text/javascript" src="assets/JsFiles/reservationHotel.js"></script>
