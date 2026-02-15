{load_presentation_object filename="reservationPublicFunctions" assign="objPublic"}
{load_presentation_object filename="reservationHotel" assign="objResult"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت هتل رزرواسیون</li>
                <li><a href="reportHotel">گزارش هتل</a></li>
                <li class="active">گزارش اتاق های هتل {$objPublic->ShowName(reservation_hotel_tb,$smarty.get.hotel)}</li>
            </ol>
        </div>
    </div>




    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>
                <p class="text-muted m-b-30 size15">تعریف بازه زمانی جدید برای همه ی اتاق ها</p>

                {assign var="archiveHotelRoomPrice" value=$objResult->getArchiveHotelRoomPrice($smarty.get.hotel)}

                <form id="FormAddHotelRoomPrices" method="post" action="{$smarty.const.rootAddress}hotel_ajax">
                    <input type="hidden" name="flag" value="insertHotelRoomPrice">
                    <input type="hidden" name="id_city" value="{$smarty.get.city}">
                    <input type="hidden" name="id_hotel" value="{$smarty.get.hotel}">
                    <input type="hidden" name="max_date" value="{$archiveHotelRoomPrice[0]['max_date']}">

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
                </form>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">گزارش اتاق های هتل</h3>
                <p class="text-muted m-b-30"></p>


                <div class="row show-grid">
                    <div class="col-md-6"><b>شهر: </b>{$objPublic->ShowName(reservation_city_tb,$smarty.get.city)}</div>
                    <div class="col-md-6"><b>هتل: </b>{$objPublic->ShowName(reservation_hotel_tb,$smarty.get.hotel)}</div>
                </div>


                {assign var="number" value="0"}
                {foreach key=key item=item from=$objResult->reportHotelRoom($smarty.get.city, $smarty.get.hotel)}

                {if $key eq 0}


                <div class="table-responsive" style="width: 100%;">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>اتاق</th>
                            <th>از تاریخ</th>
                            <th>تا تاریخ</th>
                            <th>ظرفیت کل</th>
                            <th>ظرفیت کل حداکثر خرید</th>
                            <th>ظرفیت مانده</th>
                            <th>گزارش</th>
                        </tr>
                        </thead>
                        <tbody>
                {/if}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td id="borderFlyNumber-{$item.id}">{$number}</td>

                            <td>{$objPublic->ShowName(reservation_room_type_tb, $item.id_room, 'comment')}</td>

                            <td>{$objPublic->format_Date($item.min_date)}</td>

                            <td>{$objPublic->format_Date($item.max_date)}</td>

                            <td>{$item.all_capacity}</td>

                            <td>{$item.all_maximum_capacity}</td>

                            <td>{$item.all_remaining_capacity}</td>

                            <td>
                                <a href="reportHotelRoomForUser&city={$item.id_city}&hotel={$item.id_hotel}&room={$item.id_room}" class="btn btn-success waves-effect waves-light" type="button">
                                    <span class="btn-label"><i class="fa fa-check"></i></span>کاربران
                                </a>
                            </td>

                        </tr>
                {/foreach}

                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>



</div>

<script type="text/javascript" src="assets/JsFiles/reservationHotel.js"></script>