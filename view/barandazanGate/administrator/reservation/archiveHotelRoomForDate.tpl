{load_presentation_object filename="reservationPublicFunctions" assign="objPublic"}
{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{load_presentation_object filename="reservationHotel" assign="objResult"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت هتل رزرواسیون</li>
                <li><a href="reportHotel">گزارش هتل</a></li>
                <li class="active">گزارش روزها (آرشیو اتاق ها)</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">گزارش روزها (آرشیو اتاق ها)</h3>
                <p class="text-muted m-b-30">

                </p>

                {assign var="number" value="0"}
                {foreach key=key item=item from=$objResult->reportHotelRoomForDate($smarty.get.city, $smarty.get.hotel, 'archive')}

                {if $key eq 0}
                <div class="row show-grid">
                    <div class="col-md-6"><b>کشور - شهر: </b>{$objPublic->ShowName(reservation_country_tb,$item.id_country)} - {$objPublic->ShowName(reservation_city_tb,$item.id_city)}</div>
                    <div class="col-md-6"><b>هتل: </b>{$objPublic->ShowName(reservation_hotel_tb, $item.id_hotel)}</div>
                </div>

                <div class="table-responsive" style="width: 100%;">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>اتاق</th>
                            <th>کانتر</th>
                            <th>تاریخ</th>
                            <th>ظرفیت کل حداکثر خرید</th>
                            <th>پر شده</th>
                        </tr>
                        </thead>
                        <tbody>
                {/if}

                        {$number=$number+1}

                        {assign var="capacity" value=""}
                        {$capacity = $item.maximum_capacity-$item.remaining_capacity}

                        <tr id="del-{$item.id}">

                            <td id="borderFlyNumber-{$item.id}">{$number}</td>

                            <td>{$objPublic->ShowName(reservation_room_type_tb, $item.id_room, 'comment')}</td>

                            <td>{$objPublic->ShowName(counter_type_tb,$item.user_type)}</td>

                            <td>{$objPublic->format_Date($item.date)}</td>

                            <td>{$item.maximum_capacity}</td>

                            <td>{$capacity}</td>

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
<script type="text/javascript" src="assets/JsFiles/reservationBasicInformation.js"></script>