{load_presentation_object filename="appointments" assign="objAppointment"}
{load_presentation_object filename="appointmentStatus" assign="objAppointmentStatus"}

{*<code>{$getCategory|json_encode}</code>*}

<div class="container-fluid">

    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>

                <li class='active'>لیست درخواست مشاوره</li>

            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">جستجوی سوابق رزرو مشاوره </h3>

                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید سوابق را در تاریخ های مورد نظرتان جستجو
                    کنید
                </p>

                <form id="filterAppointment" method="post" action="{$smarty.const.rootAddress}list"
                      autocomplete="off">

                    <div class="form-group col-sm-6">
                        <label for="to_date" class="control-label">نام درخواست کننده</label>
                        <input type="text" class="form-control" name="fullName"
                               id="fullName" value="{$smarty.post.fullName}"
                               placeholder="نام درخواست کننده را وارد نمائید">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="appointment_status" class="control-label">وضعیت رزرو</label>
                        <select name="appointment_status" id="appointment_status" class="form-control">
                            <option value="">انتخاب کنید....</option>
                            {foreach $objAppointmentStatus->getAppointmentStatusListCount() as $status}
                                <option {if $status['id'] == $smarty.post.appointment_status} selected {/if}
                                        value="{$status['id']}" >{$status['title']} ({$status['count']}) </option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="reminder_time" class="control-label">یاداوری در تاریخ</label>
                        <input type="text" class="form-control datepicker" name="reminder_time" value="{if $smarty.post.reminder_time neq ''} {$smarty.post.reminder_time}{/if}"
                               id="reminder_time" placeholder="تاریخ یاداوری را وارد نمائید">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary pull-right">شروع جستجو</button>
                    </div>




                    <div class="clearfix"></div>
                </form>
            </div>

        </div>
    </div>



    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <a class="btn btn-primary rounded div-emerald"
                   href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/appointment/insert">
                    <i class="fa fa-plus"></i>
                    ثبت رزرو وقت مشاوره
                </a>
                <div class="table-responsive table-bordered padding-15 ">
                    <table id="myTable" class="table table-striped table-hover">
                        <thead class="thead-default">
                        <tr>
                            <th>ردیف</th>
                            <th>نام و نام خانوادگی</th>
                            <th>موبایل</th>
                            <th>تاریخ درخواست</th>
                            <th>کد پیگیری</th>
                            <th>تاریخ یاداوری</th>
                            <th>مذاکرات</th>
                            <th>وضعیت رزرو</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {* {$objAppointment->getAppointments()|json_encode}*}
                        {assign var="rowNum" value=0}
                        {assign var="appointment_list" value=$objAppointment->getAppointments()}

                        {foreach $appointment_list['data'] as $appointment}
                            {$rowNum=$rowNum+1}
                            {assign var="negotiationCount" value=$appointment['negotiation']['data']|count}
                            {$negotiationCount = $negotiationCount-1}
                            <tr>
                                <td>{$rowNum}</td>
                                <td>{$appointment['fullName']}</td>
                                <td>{$appointment['mobile']}</td>
                                <td>{$appointment['created_at']}</td>
                                <td>{$appointment['tracking_code']}</td>
                                <td>
                                    {$appointment['negotiation']['data'][{$negotiationCount}]['reminder_time']}
                                    {if $appointment['negotiation']['data'][{$negotiationCount}]['reminder_time'] eq $objFunctions->timeNow()}
                                        <div class="notify"
                                             style="position: absolute !important; margin-top: -13px !important;">
                                            <span class="heartbit"></span><span class="point"></span>
                                        </div>
                                    {/if}
                                </td>
                                <td>
                                    {if $negotiationCount >= 0}
                                        <div class='d-flex flex-wrap gap-5'>
                                                <div class="badge badge-purple">
                                                    {$appointment['negotiation']['data'][{$negotiationCount}]['status']['title']}
                                                    در تاریخ
                                                    {$appointment['negotiation']['data'][{$negotiationCount}]['created_at']}
                                                </div>
                                        </div>
                                    {/if}
                                </td>
                                <td><button class="{$objAppointmentStatus->getButtonStatus($appointment['status']['id'])}">{$appointment['status']['title']}</button></td>

                                <td>
                                    <a class="btn btn-sm btn-outline gap-4 btn-primary"
                                       href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/appointment/edit?id={$appointment['id']}">
                                        <i class="fa fa-edit"></i>ویرایش </a>

                                    <button class="btn btn-sm btn-outline btn-danger deleteRecommendation"
                                            onclick='removeAppointment("{$appointment['id']}")'>
                                        <i class="fa fa-trash"></i> حذف
                                    </button>
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
{literal}
<script src="assets/timePicker/mdtimepicker.min.js"></script>
<script type="text/javascript" src="assets/JsFiles/appointment.js"></script>
{/literal}