{load_presentation_object filename="reservationPublicFunctions" assign="objPublic"}
{load_presentation_object filename="reservationHotel" assign="objResult"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت هتل رزرواسیون</li>
                <li class="active">گزارش هتل</li>
            </ol>
        </div>
    </div>
    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">گزارش هتل</h3>
                <p class="text-muted m-b-30"></p>
                <div class="table-responsive" style="width: 100%;">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th style="width: 80px;">کشور</th>
                            <th style="width: 80px;">شهر</th>
                            <th>هتل</th>
                            <th>ظرفیت کل</th>
                            <th>ظرفیت کل حداکثر خرید</th>
                            <th>ظرفیت مانده</th>
                            <th>گزارش اتاق</th>
                            <th>گزارش روزانه</th>
                            <th>گزارش کلی</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {assign var="dateToday" value=$objDate->jdate("", '', '', '', 'en')}

                        {foreach key=key item=item from=$objResult->reportHotel()}
                        {$number=$number+1}

                        <tr id="del-{$item.id}">
                            <td id="borderFlyNumber-{$item.id}">{$number}</td>

                            <td>{$objPublic->ShowName(reservation_country_tb,$item.id_country)}</td>

                            <td>{$objPublic->ShowName(reservation_city_tb,$item.id_city)}</td>

                            <td>{$objPublic->ShowName(reservation_hotel_tb,$item.id_hotel)}</td>

                            <td>{if $item.max_date gt $dateToday}{$item.all_capacity}{/if}</td>

                            <td>{if $item.max_date gt $dateToday}{$item.all_maximum_capacity}{/if}</td>

                            <td>{if $item.max_date gt $dateToday}{$item.all_remaining_capacity}{/if}</td>

                            <td>
                                <a href="reportHotelRoom&city={$item.id_city}&hotel={$item.id_hotel}" class="btn btn-success waves-effect waves-light" type="button">
                                    <span class="btn-label"><i class="fa fa-check"></i></span>گزارش اتاق
                                </a>
                            </td>

                            <td>
                                {if $item.max_date gt $dateToday}
                                <a href="reportHotelRoomForDate&city={$item.id_city}&hotel={$item.id_hotel}" class="btn btn-success waves-effect waves-light" type="button">
                                    <span class="btn-label"><i class="fa fa-check"></i></span>روزها
                                </a>
                                {/if}
                            </td>

                            <td>
                                {if $item.max_date gt $dateToday}
                                <a href="reportAllHotelRooms&city={$item.id_city}&hotel={$item.id_hotel}" class="btn btn-success waves-effect waves-light" type="button">
                                    <span class="btn-label"><i class="fa fa-check"></i></span>گزارش کلی
                                </a>
                                {/if}
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


<div class="i-section">
    <div class="i-info">
        <span> ویدیو آموزشی بخش گزارش هتل </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/375/-.html" target="_blank" class="i-btn"></a>

</div>



<script type="text/javascript" src="assets/JsFiles/reservationHotel.js"></script>