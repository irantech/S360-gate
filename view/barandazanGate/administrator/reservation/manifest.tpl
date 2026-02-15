{load_presentation_object filename="reservationTicket" assign="objResult"}
{load_presentation_object filename="reservationPublicFunctions" assign="objPublic"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت بلیط رزرواسیون</li>
                <li><a href="reportTicket">گزارش چارتر</a></li>
                <li class="active">مانی فست</li>
            </ol>
        </div>
    </div>
    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">لیست مسافران بلیط</h3>

                {assign var="number" value="0"}
                {foreach key=key item=item from=$objResult->manifest($smarty.get.airline, $smarty.get.flyCode, $smarty.get.date)}

                {if $key eq 0}
                <div class="row show-grid">
                    <div class="col-md-6"><b>مبدا: </b>{$item.origin_city} - ({$item.origin_airport_iata})</div>
                    <div class="col-md-6"><b>مقصد: </b>{$item.desti_city} - ({$item.desti_airport_iata})</div>
                </div>
                <div class="row show-grid">
                    <div class="col-md-3"><b>شرکت حمل و نقل: </b>{$item.airline_name}</div>
                    <div class="col-md-3"><b>شماره پرواز: </b>{$item.flight_number}</div>
                    <div class="col-md-3"><b>ساعت حرکت پرواز: </b>{$item.time_flight}</div>
                    <div class="col-md-3"><b>تاریخ حرکت پرواز: </b>{$objPublic->nameDayWeek($objResult->date_flight)} - {$objPublic->format_Date($objResult->date_flight)}</div>
                </div>

                <div class="table-responsive" style="width: 100%;">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>شماره فاکتور</th>
                            <th>نام و نام خانوادگی</th>
                            <th>نام آژانس</th>
                            <th>سن</th>
                            <th>کد ملی</th>
                            <th>تاریخ خرید</th>
                            <th>قیمت</th>
                            <th>بلیط دوطرفه</th>
                            <th>عدم حضور در سفر</th>
                        </tr>
                        </thead>
                        <tbody>
                {/if}



                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td id="borderFlyNumber-{$item.id}">{$number}</td>
                            <td>{$item.factor_number}</td>
                            <td>{$item.passenger_name} - {$item.passenger_family}</td>
                            <td>{$item.agency_name}</td>
                            <td>
                                {if $item.passenger_age eq 'Adt'}
                                بزرگسال
                                {else if $item.passenger_age eq 'Chd'}
                                کودک
                                {else if $item.passenger_age eq 'Inf'}
                                نوزاد
                                {/if}
                            </td>
                            <td>{$item.passenger_national_code}</td>
                            <td>{$objDate->jdate('Y-m-d', $item.creation_date_int)}</td>
                            <td>
                                {if $item.passenger_age eq 'Adt'}
                                    {$item.adt_price}
                                {else if $item.passenger_age eq 'Chd'}
                                    {$item.chd_price}
                                {else if $item.passenger_age eq 'Inf'}
                                    {$item.inf_price}
                                {/if}
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                {/foreach}

                        </tbody>
                    </table>
                </div>
            </div>


        </div>

    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/reservationTicket.js"></script>