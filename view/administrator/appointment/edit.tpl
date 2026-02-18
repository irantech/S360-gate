{load_presentation_object filename="appointments" assign="objAppointment"}
{load_presentation_object filename="appointmentField" assign="objAppointmentFiled"}
{load_presentation_object filename="appointmentRecognition" assign="objAppointmentRecognition"}
{load_presentation_object filename="appointmentStatus" assign="objAppointmentStatus"}
{load_presentation_object filename="appointmentNegotiation" assign="objAppointmentNegotiaion"}

{assign var='negotiation' value=$objAppointmentNegotiaion->getLastNegotiationById($smarty.get.id)}

{if !isset($smarty.get.id)}
    {header("Location: {$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/appointment/list")}
{/if}
{assign var="appointment" value=$objAppointment->getAppointment($smarty.get.id)}
{if !$appointment}
    {header("Location: {$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/appointment/list")}
{/if}
<link rel="stylesheet" href="assets/timePicker/mdtimepicker.min.css">
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">

                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/appointment/list">
                        لیست وقت های مشاوره
                    </a>
                </li>
                <li class='active'>
                    ویرایش وقت
                    <span class='font-bold underdash'>{$appointment['fullName']}</span>
                </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <form data-toggle="validator" method="post" id="editAppointment" enctype='multipart/form-data'>
            <input type="hidden" name="className" value="appointments">
            <input type="hidden" name="method" value="updateAppointment">
            <input type="hidden" name="appointment_id" value="{$appointment.id}">
            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">


                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>جزییات</h4>
                        </div>

                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 d-flex flex-wrap">

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="field_id">نوع ویزا</label>
                                    <select value="{$appointment.field.id}" name="field_id" id="field_id" class="form-control select2">
                                        <option value="">انتخاب کنید</option>
                                        {foreach $objAppointmentFiled->getAppointmentFields() as $field}
                                            <option {if $field['id'] == $appointment.field.id}selected{/if}
                                                    value="{$field['id']}" >{$field['title']}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="fullName">نام کاربر</label>
                                    <input type="text" class="form-control" name="fullName" id="fullName"
                                           placeholder="نام و نام خانوادگی کاربر" value="{$appointment.fullName}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="mobile">شماره موبایل</label>
                                    <input type="text" class="form-control" name="mobile" id="mobile"
                                           placeholder="سمت کاربر" value="{$appointment.mobile}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="email">ایمیل</label>
                                    <input type="text" class="form-control" name="email" id="email"
                                           placeholder="ایمیل" value="{$appointment.email}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="profession">سمت کاربر</label>
                                    <input type="text" class="form-control" name="profession" id="profession"
                                           placeholder="سمت کاربر" value="{$appointment.profession}">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="recognition_id">آشنایی با ما</label>
                                    <select value="{$appointment.recognition.id}" name="recognition_id" id="recognition_id" class="form-control select2">
                                        <option value="">انتخاب کنید</option>
                                        {foreach $objAppointmentRecognition->getAppointmentRecognitions() as $recognition}
                                            <option {if $recognition['id'] == $appointment.recognition.id}selected{/if}
                                                    value="{$recognition['id']}" >{$recognition['title']}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="reserved_date">تاریخ مشاوره</label>
                                    <input value="{$appointment.reserved_date}"
                                           id="reserved_date" type="text" class="form-control datepicker" name="reserved_date" autocomplete="off"
                                           placeholder="تاریخ رزرو مشاوره">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="reserved_time">ساعت مشاوره</label>
                                    <input  type="text" value="{$appointment.reserved_time}" class="form-control"   name="reserved_time" id="reserved_time" placeholder="ساعت رزرو مشاوره">
                                </div>
                            </div>




                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="comment">کامنت </label>
                                <textarea name="comment" class="form-control"
                                          placeholder="محتوای مطلب">{$appointment.comment}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">
                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>وضعیت رزرو</h4>
                        </div>

                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="created_at">تاریخ ثبت این درخواست</label>
                                <input type="text" class="form-control" name="created_at" id="created_at"
                                       disabled value="{$appointment.created_at}">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="status_id">وضعیت رزرو</label>
                                <select onchange="getStatusReason($(this))" value="{$appointment.status.id}" name="status_id" id="status_id" class="form-control select2">
                                    <option value="">انتخاب کنید</option>
                                    {foreach $objAppointmentStatus->getAppointmentStatusList() as $status}
                                        <option value="{$status['id']}" >{$status['title']}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="status_reason_id">دلیل</label>
                                <select  name="status_reason_id" id="status_reason_id" class="form-control select2">
                                    <option value="">انتخاب کنید</option>
                                    {foreach $objAppointmentStatus->getAppointmentStatusReasonById(['status_id' => $appointment['status_id']]) as $reason}
                                        <option value="{$reason['id']}" >{$reason['title']}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="reminder_time">تاریخ یاداوری</label>
                                <input type="text" class="form-control datepicker" name="reminder_time"

                                       id="reminder_time" placeholder="تاریخ یاداوری  را وارد نمائید">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="negotiation_comment">شرح آخرین مذاکره </label>
                                <textarea name="negotiation_comment" class="form-control" id="negotiation_comment"
                                          placeholder="شرح آخرین مذاکره"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class=' col-12 d-flex  align-items-center justify-content-center w-100 parentbtn-btn-fixed'>
                <button class="btn btn-success btn-block btn-fixed" type="submit" id="submit-button">ذخیره</button>
            </div>
        </form>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
            <div class="d-flex flex-wrap gap-10">
                <div class="bg-white d-flex flex-wrap rounded w-100 ">
                    <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                        <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>مذاکره ها</h4>
                    </div>

                    <hr class='m-0 mb-4 w-100'>

                     <div class="table-responsive w-100">
                        <table id="ticketHistory" class="table table-striped text-center">
                            <thead>
                            <tr>
                                <th class="text-center">ردیف</th>
                                <th class="text-center">وضعیت درخواست</th>
                                <th class="text-center">دلیل</th>
                                <th class="text-center">توضیحات</th>
                                <th class="text-center">تاریخ یادآوری</th>
                                <th class="text-center"> تاریخ ثبت این وضعیت</th>
                            </tr>
                            </thead>
                            <tbody>
                            {foreach $appointment['negotiation']['data'] as $key => $negotiation}
                                {$key = $key + 1}
                                <tr>
                                    <td>{$key}</td>
                                    <td>  {$negotiation['status']['title']} </td>
                                    <td>  {$negotiation['status_reason']['title']} </td>
                                    <td>  {$negotiation['comment']} </td>
                                    <td>  {$negotiation['reminder_time']} </td>
                                    <td>  {$negotiation['created_at']} </td>

                                </tr>
                            {/foreach}
                            </tbody>
                        </table>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>

{literal}
    <script src="assets/timePicker/mdtimepicker.min.js"></script>
    <script type="text/javascript" src="assets/JsFiles/appointment.js"></script>
{/literal}