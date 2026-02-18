{load_presentation_object filename="reservationTour" assign="objResult"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت تور رزرواسیون</li>
                <li><a href="reportTour">گزارش تور</a></li>
                <li class="active">آرشیو تور</li>
            </ol>
        </div>
    </div>
    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">آرشیو تور</h3>
                <div class="table-responsive" style="width: 100%;">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>تاریخ و ساعت ایجاد</th>
                            <th>نوع کانتر<br>نام کانتر</th>
                            <th>نام تور<br>کد تور</th>
                            <th>تاریخ رفت سفر<br>تاریخ برگشت سفر</th>
                            <th>چند شب<br>چند روز</th>
                            <th>وضعیت</th>
                            <th>مشاهده</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objResult->archiveReportTour()}
                            {$number=$number+1}

                            {assign var="typeMember" value=$objFunctions->infoMember($item.user_id)}
                            {assign var="infoCounterType" value=$objFunctions->infoCounterType($typeMember['fk_counter_type_id'])}

                            <tr id="del-{$item['id']}">
                                <td id="borderFlyNumber-{$item['id']}">{$number}</td>

                                <td>
                                    {$item['create_date_in']}
                                    <hr style="margin:3px">
                                    {$item['create_time_in']}
                                </td>

                                <td>
                                    {$infoCounterType['name']}
                                    <hr style="margin:3px">
                                    {$typeMember['name']} {$typeMember['family']}
                                </td>

                                <td>
                                    {$item['tour_name']}
                                    <hr style="margin:3px">
                                    {$item['tour_code']}
                                </td>

                                <td>
                                    {$objFunctions->convertDate($item['start_date'])}
                                    <hr style="margin:3px">
                                    {$objFunctions->convertDate($item['end_date'])}
                                </td>

                                <td>
                                    {$item['night']} شب
                                    <hr style="margin:3px">
                                    {$item['day']} روز
                                </td>

                                <td>
                                    {if $item['is_show'] eq ''}
                                        <a class="btn btn-warning cursor-default" onclick="return false;">ثبت جدید تور</a>
                                    {elseif $item['is_show'] eq 'yes'}
                                        <a class="btn btn-success cursor-default" onclick="return false;">نمایش در سایت</a>
                                    {elseif $item['is_show'] eq 'no'}
                                        <a class="btn btn-danger cursor-default" onclick="return false;">عدم نمایش در سایت</a>
                                    {/if}
                                </td>

                                <td>
                                    <a href="archiveDetailTour&id={$item['id_same']}" class="btn btn-success waves-effect waves-light" type="button">
                                        <span class="btn-label"><i class="fa fa-eye"></i></span>مشاهده جزئیات کامل
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
