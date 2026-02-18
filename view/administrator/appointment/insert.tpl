{load_presentation_object filename="appointmentRecognition" assign="objRecognition"}
{load_presentation_object filename="appointmentStatus" assign="objStatus"}
{load_presentation_object filename="appointmentField" assign="objField"}
<link rel="stylesheet" href="assets/timePicker/mdtimepicker.min.css">
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/appointment/list">
                        لیست درخواست های رزرو
                    </a>
                </li>
                <li class="active">درج رزرو جدید</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <form data-toggle="validator" method="post" id="storeAppointment" enctype='multipart/form-data'>
            <input type="hidden" name="className" value="appointments">
            <input type="hidden" name="method"  value="insertAppointment">
            <input type="hidden" name="is_admin" value="1">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                <div class="d-flex flex-wrap gap-10">
                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 d-flex flex-wrap">

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="field_id">نوع ویزا</label>
                                    <select  name="field_id" id="field_id" class="form-control select2">
                                        <option value="">انتخاب کنید</option>
                                        {foreach $objField->getAppointmentFields() as $field}
                                            <option value="{$field['id']}" >{$field['title']}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="fullName">نام کاربر</label>
                                    <input type="text" class="form-control" name="fullName" id="fullName"
                                           placeholder="نام و نام خانوادگی کاربر" >
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="mobile">شماره موبایل</label>
                                    <input type="text" class="form-control" name="mobile" id="mobile"
                                           placeholder="شماره موبایل" >
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="email">ایمیل</label>
                                    <input type="text" class="form-control" name="email" id="email"
                                           placeholder="ایمیل" >
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="profession">سمت کاربر</label>
                                    <input type="text" class="form-control" name="profession" id="profession"
                                           placeholder="سمت کاربر" >
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="recognition_id">آشنایی با ما</label>
                                    <select  name="recognition_id" id="recognition_id" class="form-control select2">
                                        <option value="">انتخاب کنید</option>
                                        {foreach $objRecognition->getAppointmentRecognitions() as $recognition}
                                            <option value="{$recognition['id']}" >{$recognition['title']}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="reserved_date">تاریخ مشاوره</label>
                                    <input id="reserved_date" type="text" class="form-control datepicker" name="reserved_date" autocomplete="off"
                                           placeholder="تاریخ رزرو مشاوره">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="reserved_time">ساعت مشاوره</label>
                                    <input  type="text"  class="form-control"   name="reserved_time" id="reserved_time" placeholder="ساعت رزرو مشاوره">
                                </div>
                            </div>




                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="comment">کامنت </label>
                                <textarea name="comment" class="form-control"
                                          placeholder="محتوای مطلب"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class='col-12 d-flex align-items-center justify-content-center w-100 parentbtn-btn-fixed' style="z-index:  0 !important">
                <button id='submit-button' class="btn btn-success btn-block btn-fixed" type="submit">ذخیره</button>
            </div>
        </form>
    </div>
</div>


{literal}
    <script src="assets/timePicker/mdtimepicker.min.js"></script>
    <script type="text/javascript" src="assets/JsFiles/appointment.js"></script>
{/literal}