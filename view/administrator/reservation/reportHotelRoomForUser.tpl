{load_presentation_object filename="reservationPublicFunctions" assign="objPublic"}
{load_presentation_object filename="reservationHotel" assign="objResult"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت هتل رزرواسیون</li>
                <li><a href="reportHotel">گزارش هتل</a></li>
                <li><a href="reportHotelRoom&city={$smarty.get.city}&hotel={$smarty.get.hotel}">گزارش اتاق های هتل</a></li>
                <li class="active">گزارش کاربران</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        </div>
    </div>
    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">گزارش کاربران</h3>
                <p class="text-muted m-b-30">

                </p>

                {assign var="number" value="0"}
                {foreach key=key item=item from=$objResult->reportHotelRoomForUser($smarty.get.city, $smarty.get.hotel, $smarty.get.room)}

                {if $key eq 0}
                <div class="row show-grid">
                    <div class="col-md-4"><b>کشور - شهر: </b>{$objPublic->ShowName(reservation_country_tb,$item.id_country)} - {$objPublic->ShowName(reservation_city_tb,$item.id_city)}</div>
                    <div class="col-md-4"><b>هتل: </b>{$objPublic->ShowName(reservation_hotel_tb, $item.id_hotel)}</div>
                    <div class="col-md-4"><b>اتاق: </b>{$objPublic->ShowName(reservation_room_type_tb, $item.id_room, 'comment')}</div>
                </div>

                <div class="table-responsive" style="width: 100%;">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>کاربر</th>
                            <th>از تاریخ</th>
                            <th>تا تاریخ</th>
                            <th>ظرفیت کل</th>
                            <th>ظرفیت کل حداکثر خرید</th>
                            <th>ظرفیت مانده</th>
                            {*<th>ثبت جدید</th>*}
                            <th>ویرایش</th>
                            <th>حذف</th>
                        </tr>
                        </thead>
                        <tbody>
                {/if}

                        {$number=$number+1}

                        <tr id="del-{$item.id}">

                            <td id="borderFlyNumber-{$item.id}">{$number}</td>

                            <td>{$objPublic->ShowName(counter_type_tb,$item.user_type)}</td>

                            <td>{$objPublic->format_Date($item.min_date)}</td>

                            <td>{$objPublic->format_Date($item.max_date)}</td>

                            <td>{$item.all_capacity}</td>

                            <td>{$item.all_maximum_capacity}</td>

                            <td>{$item.all_remaining_capacity}</td>

                            {*<td>
                                <a href="addRoomPricesForUser&id={$item.id}&sDate={$item.min_date}&eDate={$item.max_date}">
                                    <i  class="fcbtn btn btn-success btn-outline btn-1e fa fa-plus"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="ثبت جدید">

                                    </i>
                                </a>
                            </td>*}

                            <td>
                                <a href="editRoomPricesForUser&id={$item.id}&sDate={$item.min_date}&eDate={$item.max_date}">
                                    <i  class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="ویرایش">

                                    </i>
                                </a>
                            </td>

                            <td>
                                <a id="DelRoomPrices-{$item.id}" href="#" onclick="deleteRoomPricesForUser('{$item.id_city}', '{$item.id_hotel}', '{$item.id_room}', '{$item.user_type}', '{$item.min_date}', '{$item.max_date}'); return false" class="popoverBox  popover-danger" data-toggle="popover" title="حذف تغییرات" data-placement="right"
                                   data-content="حذف"> <i class="fcbtn btn btn-outline btn-danger btn-1c fa fa-trash "></i>
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