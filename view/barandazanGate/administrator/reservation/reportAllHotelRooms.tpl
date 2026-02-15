{load_presentation_object filename="reservationPublicFunctions" assign="objPublic"}
{load_presentation_object filename="reservationHotel" assign="objResult"}

{$objPublic->getAllCounter('all')} {*گرفتن لیست انواع کانتر*}
{$objResult->reportAllHotelRooms($smarty.get.city, $smarty.get.hotel)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت هتل رزرواسیون</li>
                <li><a href="reportHotel">گزارش هتل</a></li>
                <li class="active">گزارش کلی اتاق ها</li>
            </ol>
        </div>
    </div>

    <div class="row">
        {foreach key=key item=item from=$objResult->reportAllHotelRooms}
            <div class="col-md-3 col-xs-12 col-sm-6">
                <div class="white-box">
                    {*<h3 class="box-title m-b-0"> ویرایش اتاق ها({$key+1} )</h3>*}
                    <h4 class="m-b-1">اتاق <span class="room-name text-muted text-sm">{$item.room_name}</span> در هتل <span class="hotel-name text-megna text-sm">{$item.hotel_name}</span></h4>
                    <h6 class="box-title m-b-0"> از تاریخ {$objPublic->format_Date($item['minDate'])} تا  {$objPublic->format_Date($item['maxDate'])}</h6>
                    <div class="collapse m-t-15" aria-expanded="true"></div>
                    <hr>
                    <a href="editAllHotelRooms&idHotel={$smarty.get.hotel}&idSame={$item.id_same}">
                        <p>
                            <button type="button" class="btn btn-primary btn-circle"><i class="fa fa-list"></i></button>
                            <b>ویرایش</b>
                        </p>
                    </a>
                    <a onclick="deleteRoomPrice('{$smarty.get.hotel}', '{$item.id_same}', 'id_same')" href="#">
                        <p>
                            <button type="button" class="btn btn-danger btn-circle"><i class="fa fa-times"></i></button>
                            <b>حذف</b>
                        </p>
                    </a>
                </div>
            </div>
        {/foreach}
    </div>


</div>

<script type="text/javascript" src="assets/JsFiles/reservationPublicFunctions.js"></script>
<script type="text/javascript" src="assets/JsFiles/reservationHotel.js"></script>