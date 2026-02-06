{load_presentation_object filename="busPanel" assign="objResult"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href='main'>
                        مدیریت بلیط رزرواسیون اتوبوس
                    </a>
                </li>
                <li class="active">لیست اتوبوس ها</li>
            </ol>
        </div>
    </div>


</div>


<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">لیست اتوبوس ها</h3>


            <div class="table-responsive">
                <table id="myTable" class="table table-striped ">
                    <thead>
                    <tr>

                        <th>ردیف</th>
                        <th>مبدا / مقصد</th>
                        <th>شرکت</th>
                        <th>تعداد صندلی / باقیمانده ها</th>
                        <th>تاریخ / ساعت حرکت</th>
                        <th>قیمت</th>
                        <th>ویرایش</th>
                        <th>حذف</th>


                    </tr>
                    </thead>
                    <tbody>
                    {assign var="data" value=$objResult->getBusReservationData([])}

                    {assign var="number" value="0"}


                    {if $data != ''}
                        {foreach key=key item=item from=$data}
                            {$number=$number+1}
                            <tr id="del-{$item.id}">

                                <td class="align-middle"><span class="badge badge-info">{$number}</span></td>
                                <td class="align-middle">{$item['origin']['name_fa']}
                                    / {$item['destination']['name_fa']}</td>
                                <td class="align-middle" data-name='station_name'>{$item['company']['name_fa']}</td>
                                <td class="align-middle">{$item['chairs_count']} / {$item['left_chairs_count']}</td>
                                <td class="align-middle">{$item['move_date']} / {$item['move_time']}</td>
                                <td class="align-middle">{$item['price']}</td>


                                <td class="align-middle">
                                    <a
                                       class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                       data-toggle="tooltip" data-placement="top" title=""
                                        {if $item['used_chairs'] neq ''}
                                            data-original-title="غیر قابل ویرایش"
                                        {else}
                                            href="edit&id={$item.id}"
                                            data-original-title="ویرایش"
                                        {/if}
                                       >
                                    </a>
                                </td>

                                <td class="align-middle">
                                    <button class="fcbtn btn btn-outline btn-danger btn-1e fa fa-trash tooltip-danger"
                                            data-toggle="tooltip" data-placement="top" title=""
                                            {if $item['used_chairs'] neq ''}
                                                disabled
                                                data-original-title="غیر قابل حذف"
                                            {else}
                                                data-original-title="حذف"
                                            {/if}
                                            onclick="adminDeleteReservationBus($(this),'{$item.id}')">
                                    </button>
                                </td>
                            </tr>
                        {/foreach}
                    {/if}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript" src="assets/JsFiles/reservationBus.js"></script>