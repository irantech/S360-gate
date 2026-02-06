{load_presentation_object filename="reservationTicket" assign="objResult"}
{load_presentation_object filename="reservationPublicFunctions" assign="objPublic"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت بلیط رزرواسیون</li>
                <li><a href="reportTicket">گزارش چارتر</a></li>
                <li><a href="dailyTicket&airline={$smarty.get.airline}&flyCode={$smarty.get.flyCode}">گزارش پرواز روزانه</a></li>
                <li class="active">گزارش پرواز (کاربران - کلاس نرخی)</li>
            </ol>
        </div>
    </div>
    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">گزارش پرواز (کاربران - کلاس نرخی)</h3>

                {assign var="number" value="0"}
                {foreach key=key item=item from=$objResult->charterReportFilterCounter($smarty.get.flyCode, $smarty.get.airline, $smarty.get.date)}

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
                <div class="row show-grid">
                    <div class="col-md-6"><b>روز: </b>{$objPublic->nameDayWeek($item.date)}</div>
                    <div class="col-md-6"><b>تاریخ: </b>{$objPublic->format_Date($item.date)}</div>
                </div>

                <div class="table-responsive" style="width: 100%;">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>کاربر</th>
                            <th>کلاس نرخی</th>
                            <th>ظرفیت کل</th>
                            <th>ظرفیت حداکثر خرید</th>
                            <th>ظرفیت پرشده<</th>
                            <th>ظرفیت مانده</th>
                            <th>ویرایش</th>
                            <th>حذف</th>
                        </tr>
                        </thead>
                        <tbody>
                {/if}

                        {$number=$number+1}

                        <tr id="del-{$item.id}">

                            <td id="borderFlyNumber-{$item.id}">{$number}</td>

                            <td>{$objPublic->ShowName(counter_type_tb,$item.type_user)}</td>

                            <td>{$item.vehicle_grade}</td>

                            <td>{$item.fly_total_capacity}</td>

                            <td> {$item.maximum_buy}</td>

                            <td>{$item.fly_full_capacity} <!--/ 0--></td>

                            <td>{$item.remaining_capacity}</td>

                            <td>
                                <a href="editUserTicket&id={$item.id}">
                                    <i class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil" data-toggle="tooltip"
                                       data-placement="top" title="" data-original-title="ویرایش">
                                    </i>
                                </a>
                                {*{if $item.fly_full_capacity eq 0}
                                <a href="editUserTicket&id={$item.id}">
                                    <i class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil" data-toggle="tooltip"
                                       data-placement="top" title="" data-original-title="ویرایش">
                                    </i>
                                </a>
                                {else}
                                <a onclick="return false" class="cursor-default  popoverBox  popover-default" data-toggle="popover" title="" data-placement="right"
                                   data-content="امکان ویرایش وجود ندارد" data-original-title="ویرایش">
                                    <i class="fcbtn btn btn-outline btn-default btn-1c fa fa-ban "></i>
                                </a>
                                {/if}*}
                            </td>

                            <td>
                                <a id="Del-{$item.id}" href="#"
                                   onclick="logicalDeletionTicket({$item.id}); return false"
                                   class="popoverBox  popover-danger" data-toggle="popover" title="حذف تغییرات" data-placement="right"
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

<script type="text/javascript" src="assets/JsFiles/reservationTicket.js"></script>