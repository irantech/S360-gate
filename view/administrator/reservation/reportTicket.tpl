{load_presentation_object filename="reservationTicket" assign="objResult"}
{load_presentation_object filename="reservationPublicFunctions" assign="objPublic"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>بازرگانی</li>
                <li class="active">گزارش ویرایش تجمیعی پرواز</li>
            </ol>
        </div>
    </div>
    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">گزارش پرواز</h3>
                <div class="table-responsive" style="width: 100%;">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>مبدا</th>
                            <th>مقصد</th>
                            <th>از تاریخ <br> تا تاریخ</th>
                            <th>شماره پرواز</th>
                            <th>شرکت حمل و نقل</th>
                            <th>کلاس نرخی</th>
                            <th>ساعت پرواز</th>
                            <th>ساعت فرود</th>
                            {*<th>ظرفیت کل فصل<br>ظرفیت پرشده فصل<br>ظرفیت مانده فصل</th>
                            <th>گزارش</th>
                            <th>آرشیو</th>*}
                            <th>وضعیت</th>
                            <th>درصد کنسلی</th>
                            <th>ویرایش</th>
                            {*<th>حذف</th>*}
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objResult->charterReport()}
                        {$number=$number+1}

                        {assign var="RemainingCapacity" value=""}
                        {$RemainingCapacity = $item.total_capacity-$item.total_full_capacity}
                        <tr id="del-{$item.id}">
                            <td id="borderFlyNumber-{$item.id}">{$number}</td>
                            <td>
                                {$objPublic->ShowName(reservation_country_tb,$item.origin_country)} - {$objPublic->ShowName(reservation_city_tb,$item.origin_city)}
                                <hr style="margin:3px">
                                {$objPublic->ShowName('reservation_region_tb',$item.origin_region)}
                            </td>
                            <td>
                                {$objPublic->ShowName(reservation_country_tb,$item.destination_country)} - {$objPublic->ShowName(reservation_city_tb,$item.destination_city)}
                                <hr style="margin:3px">
                                {$objPublic->ShowName('reservation_region_tb',$item.destination_region)}
                            </td>
                            <td>
                                {$objPublic->format_Date($item.minData)}
                                <hr style="margin:3px">
                                {$objPublic->format_Date($item.maxDate)}
                            </td>
                            <td>
                                {$objPublic->getFlyNumber($item.fly_code)}
                            </td>
                            <td>
                                {if $objPublic->ShowName('reservation_type_of_vehicle_tb',$item.type_of_vehicle_id) eq 'هواپیما'}
                                    {$objPublic->ShowNameBase(airline_tb,name_fa,$item.airline)}
                                {else}
                                    {$objPublic->ShowName('reservation_transport_companies_tb',$item.airline)}
                                {/if}
                            </td>
                            <td>
                                {$item.classes_list}
                            </td>
                            <td>
                                {$item.exit_hour|substr:0:5}
                            </td>
                            <td>
                                {$item.time}
                            </td>
                           {* <td>
                                {$item.total_capacity}
                                <hr style="margin:3px">
                                {$item.total_full_capacity}
                                <hr style="margin:3px">
                                {$RemainingCapacity}
                            </td>
                            <td>
                                <a href="dailyTicket&airline={$item.airline}&flyCode={$item.fly_code}&id={$item.id_same}" class="btn btn-success waves-effect waves-light" type="button">
                                    <span class="btn-label"><i class="fa fa-check"></i></span>پرواز روزانه
                                </a>
                            </td>
                            <td>
                                <a href="archiveTicket&airline={$item.airline}&flyCode={$item.fly_code}&id={$item.id_same}" class="btn btn-success waves-effect waves-light" type="button">
                                    <span class="btn-label"><i class="fa fa-eye"></i></span>مشاهده آرشیو
                                </a>
                            </td>*}
                            <td>
                                <a onclick="showFlightStatusByIdSame('{$item.id}')">
                                    <i class="fcbtn btn btn-outline btn-warning btn-1c tooltip-warning fa fa-plane"
                                       data-toggle="tooltip" data-placement="top"
                                       data-original-title="وضعیت پرواز"></i>
                                </a>
                                <hr style="margin:3px">

                                {assign var="status" value=$item.status}
                                {if $status == "Cancelled"}
                                    <div class="status-cancelled text-center" title="کنسلی">C</div>
                                {elseif $status == "Blocked"}
                                    <div class="status-blocked text-center"" title="مسدودی">&#10006;</div>
                                {elseif $status == "Actived"}
                                    <div class="status-actived text-center"" title="فعال">&#10004;</div>
                                {else}
                                    <div class="status-none text-center"" title="بدون وضعیت">-</div>
                                {/if}

                            </td>
                            <td>
                                <a href="cancellationsPercentageTickets&id={$item.id_same}"
                                   class="btn btn btn-success cursor-default"
                                   type="button"
                                   style="width: 100px !important;"
                                >
                                    <span class="btn-label"><i class="fa fa-check"></i></span>ثبت
                                </a>
                            </td>
                            <td>
                                <a href="ticketEdit&id={$item.id_same}&sDate={$item.minData}&eDate={$item.maxDate}">
                                    <i  class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="ویرایش">

                                    </i>
                                </a>
                            </td>
                            {* <td>
                                <a href="#" onclick="return false" class="cursor-default  popoverBox  popover-default"  data-toggle="popover" title="حذف شماره پرواز" data-placement="right"
                                   data-content="امکان حذف وجود ندارد"> <i class="fcbtn btn btn-outline btn-default btn-1c fa fa-ban " ></i>
                                </a>
                                <a id="DelChangePrice-{$item.id}" href="#"
                                   onclick="logicalDeletionAllTicket({$item.id_same}, {$item.origin_city}, {$item.destination_city}, {$item.airline}, {$item.fly_code}); return false"
                                   class="popoverBox  popover-danger" data-toggle="popover" title="حذف تغییرات" data-placement="right"
                                   data-content="حذف"> <i class="fcbtn btn btn-outline btn-danger btn-1c fa fa-trash "></i>
                                </a>
                            </td> *}
                        </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Flight Status Capacity Modal -->
<div id="globalOperationModal" class="modal fade" id="mainModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width:500px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="globalOperationTitle"></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="globalOperationContent">
                <!-- محتوا با جاوااسکریپت تغییر می‌کند -->
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="assets/JsFiles/reservationTicket.js"></script>
<style>
    .status-cancelled {
        color: red;
        font-weight: bold;
    }

    .status-blocked {
        color: red;
        font-size: 16px;
    }

    .status-actived {
        color: green;
        font-size: 16px;
    }

    .status-none {
        color: gray;
    }
</style>