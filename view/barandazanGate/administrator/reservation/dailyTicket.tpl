{load_presentation_object filename="reservationTicket" assign="objResult"}
{load_presentation_object filename="reservationPublicFunctions" assign="objPublic"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت بلیط رزرواسیون</li>
                <li><a href="reportTicket">گزارش چارتر</a></li>
                <li class="active">گزارش پرواز روزانه</li>
            </ol>
        </div>
    </div>
    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">گزارش پرواز روزانه</h3>

                {assign var="number" value="0"}
                {foreach key=key item=item from=$objResult->charterReportFilterDay($smarty.get.flyCode, $smarty.get.airline, $smarty.get.id)}

                {if $key eq 0}
                <div class="row show-grid">
                    <div class="col-md-6"><b>مبدا: </b>{$objPublic->ShowName(reservation_country_tb,$item.origin_country)} - {$objPublic->ShowName(reservation_city_tb,$item.origin_city)}</div>
                    <div class="col-md-6"><b>مقصد: </b>{$objPublic->ShowName(reservation_country_tb,$item.destination_country)} - {$objPublic->ShowName(reservation_city_tb,$item.destination_city)}</div>
                </div>
                <div class="row show-grid">
                    <div class="col-md-4"><b>شرکت حمل و نقل: </b>{$objPublic->ShowNameBase(airline_tb,name_fa,$item.airline)}</div>
                    <div class="col-md-4"><b>شماره پرواز: </b>{$objPublic->getFlyNumber($item.fly_code)}</div>
                    <div class="col-md-4"><b>ساعت حرکت پرواز: </b>{$item.exit_hour}</div>
                </div>

                <div class="table-responsive" style="width: 100%;">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>روز</th>
                            <th>تاریخ</th>
                            <th>ظرفیت کل</th>
                            <th> ظرفیت پرشده<!--<br> تور / بلیط --></th>
                            <th>ظرفیت مانده</th>
                            <th>مانی فست</th>
                            <th>گزارش</th>
                        </tr>
                        </thead>
                        <tbody>
                {/if}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td id="borderFlyNumber-{$item.id}">{$number}</td>

                            <td>{$objPublic->nameDayWeek($item.date)}</td>

                            <td>{$objPublic->format_Date($item.date)}</td>

                            <td>{$item.fly_total_capacity}</td>

                            <td>{$item.fly_full_capacity} <!--/ 0--></td>

                            <td>{$item.remaining_capacity}</td>

                            <td>
                                {if $item.fly_full_capacity gt '0'}
                                <a href="manifest&airline={$item.airline}&flyCode={$item.fly_code}&date={$item.date}" class="btn btn-success waves-effect waves-light" type="button">
                                    <span class="btn-label"><i class="fa fa-check"></i></span>مشاهده
                                </a>
                                {/if}
                            </td>

                            <td>
                                <a href="userTickets&airline={$item.airline}&flyCode={$item.fly_code}&date={$item.date}" class="btn btn-success waves-effect waves-light" type="button">
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

<script type="text/javascript" src="assets/JsFiles/reservationTicket.js"></script>