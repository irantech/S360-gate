{load_presentation_object filename="reservationTicket" assign="objResult"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت بلیط رزرواسیون</li>
                <li><a href="reportTicket">گزارش چارتر</a></li>
                <li class="active">درصد کنسلی بلیط</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <form id="formCancellationsPercentageTickets" method="post" action="{$smarty.const.rootAddress}hotel_ajax">
                    <input type="hidden" name="flag" value="cancellationsPercentageTickets">
                    <input type="hidden" name="idSame" id="idSame" value="{$smarty.get.id}">

                    <div id="rowData">
                        <div class="col-sm-12">
                            <div class="form-group col-sm-4">
                                <label for="time_cancel_1" class="control-label">زمان مانده به ساعت حرکت پرواز</label>
                                <select name="time_cancel_1" id="time_cancel_1" class="form-control ">
                                    <option value="">انتخاب کنید</option>
                                    <option value="24">1 روز</option>
                                    <option value="42">2 روز</option>
                                    <option value="72">3 روز</option>
                                    <option value="73">+3 روز</option>
                                    {for $n=1 to 23}
                                        <option value="{$n}">{$n} ساعت</option>
                                    {/for}
                                </select>
                            </div>

                            <div class="form-group col-sm-4">
                                <label for="percent_cancel_1" class="control-label">درصد کنسلی</label>
                                <select name="percent_cancel_1" id="percent_cancel_1" class="form-control ">
                                    <option value="">انتخاب کنید</option>
                                    {for $n=5 to 100 step=5}
                                        <option value="{$n}">{$n} %</option>
                                    {/for}
                                </select>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="rowCount" id="rowCount" value="1">

                    <div class="col-sm-12">
                        <div class="form-group col-sm-4">
                            <img src="assets/css/images/add.png" onclick="insertRow()" style="width: 12%;height: auto;">
                        </div>
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
                <h3 class="box-title m-b-0">درصد کنسلی بلیط</h3>
                <p class="text-muted m-b-30">تمامی درصد کنسلی بلیط های وارد شده را در این لیست زیر میتوانید مشاهده کنید
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>زمان مانده به ساعت حرکت پرواز</th>
                            <th>درصد کنسلی</th>
                            <th>ویرایش</th>
                            <th>حذف</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="arrayTimeCancelFa" value=['24' => '1 روز', '42' => '2 روز', '72' => '3 روز', '73' => '+3 روز']}
                        {assign var="arrayTimeCancel" value=['24','42','72','73']}

                        {assign var="cancellationsPercentageTickets" value=$objResult->getCancellationsPercentageTickets($smarty.get.id)}
                        {assign var="number" value=0}
                        {foreach $cancellationsPercentageTickets as $item}

                            {$number = $number + 1}
                            <tr id="del-{$item.id}">

                                <td>{$number}</td>

                                <td>
                                    <select name="update_time_cancel_{$item['id']}" id="update_time_cancel_{$item['id']}" class="form-control">
                                        {if $item['time_cancel']|in_array:$arrayTimeCancel}
                                            <option value="{$item['time_cancel']}-{$item['type_cancel']}" selected>{$arrayTimeCancelFa[$item['time_cancel']]}</option>
                                        {else}
                                            <option value="{$item['time_cancel']}-{$item['type_cancel']}" selected>{$item['time_cancel']} ساعت</option>
                                        {/if}
                                        <option value="">----------</option>
                                        <option value="24">1 روز</option>
                                        <option value="42">2 روز</option>
                                        <option value="72">3 روز</option>
                                        <option value="73">+3 روز</option>
                                        {for $n=1 to 23}
                                            <option value="{$n}-hours">{$n} ساعت</option>
                                        {/for}
                                    </select>
                                </td>

                                <td>
                                    <select name="update_percent_cancel_{$item['id']}" id="update_percent_cancel_{$item['id']}" class="form-control">
                                        <option value="{$item['percent_cancel']}" selected>{$item['percent_cancel']} %</option>
                                        <option value="">----------</option>
                                        {for $n=5 to 100 step=5}
                                            <option value="{$n}">{$n} %</option>
                                        {/for}
                                    </select>
                                </td>

                                <td>
                                    <a href="#" onclick="editCancellationsTickets('{$item['id']}', '{$item['fk_ticket_id_same']}'); return false">
                                        <i class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                           data-toggle="tooltip" data-placement="top" title=""
                                           data-original-title="ثبت تغییرات (برای ثبت تغییرات لطفا در همین قسمت زمان و درصد کنسلی را تغییر  دهید.)">
                                        </i>
                                    </a>
                                </td>

                                <td>
                                    <a href="#" onclick="logical_deletion('{$item['id']}', 'reservation_cancellations_tickets_tb'); return false"
                                       class="popoverBox  popover-danger" data-toggle="popover" title=""
                                       data-placement="right" data-content="حذف" data-original-title="حذف تغییرات">
                                        <i class="fcbtn btn btn-outline btn-danger btn-1c fa fa-trash "></i>
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


<script>
    function insertRow() {

        var rowCount = parseInt($('#rowCount').val()) + 1;

        var optionHours = '';
        for (var i = 1; i <= 23; i++) {
            optionHours += '<option value="' + i + '-hours">' + i + ' ساعت</option>';
        }

        var optionPercent = '';
        for (var i = 5; i <= 100; i+=5) {
            optionPercent += '<option value="' + i + '">' + i + ' %</option>';
        }

        var newData = [
            '<div class="col-sm-12">' +
            '<div class="form-group col-sm-4">' +
            '<label for="time_cancel_' + rowCount + '" class="control-label">زمان مانده به ساعت حرکت پرواز</label>' +
            '<select name="time_cancel_' + rowCount + '" id="time_cancel_' + rowCount + '" class="form-control">' +
            '<option value="">انتخاب کنید</option>' +
            '<option value="24">1 روز</option>' +
            '<option value="42">2 روز</option>' +
            '<option value="72">3 روز</option>' +
            '<option value="73">+3 روز</option>' + optionHours +
            '</select>' +
            '</div>' +
            '<div class="form-group col-sm-4">' +
            '<label for="percent_cancel_' + rowCount + '" class="control-label">درصد کنسلی</label>' +
            '<select name="percent_cancel_' + rowCount + '" id="percent_cancel_' + rowCount + '" class="form-control">' +
            '<option value="">انتخاب کنید</option>'  + optionPercent +
            '</div>' +
            '</div>'
        ];


        $('#rowData').append(newData);
        $('#rowCount').val(rowCount);
    }
</script>
<script type="text/javascript" src="assets/JsFiles/reservationTicket.js"></script>
<script type="text/javascript" src="assets/JsFiles/reservationBasicInformation.js"></script>
