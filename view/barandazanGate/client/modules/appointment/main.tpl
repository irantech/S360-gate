{load_presentation_object filename="appointmentRecognition" assign="objRecognition"}
{load_presentation_object filename="appointmentStatus" assign="objStatus"}
{load_presentation_object filename="appointmentField" assign="objField"}

<link rel="stylesheet" href="assets/timePicker/mdtimepicker.min.css">
<section class="counseling">
    <div class="parent-counseling">
        <div class="container">
            <div class="d-flex flex-wrap parent-col-counseling">
                <div class="col-lg-7 p-0 order-responsive">
                    <div class="parent-form">
                        <div class="form-item-counseling">
                            <form id="reserve-appointment">
                                <div class="parent-input-counseling user-select">
                                    <div class="visa-input-div input-item">
                                        <label for="appointment-field">ویزا</label>
                                        <div class='parent-valid'>
                                            <select class="select2" name="appointment-field" id="appointment-field">
                                            <option value="" disabled selected>
                                                نوع ویزا
                                            </option>
                                            {foreach $objField->getAppointmentFields() as $key => $field}
                                            <option value="{$field['id']}">
                                                 ویزا {$field['title']}
                                            </option>
                                            {/foreach}
                                        </select>
                                        </div>
                                    </div>
                                    <div class="user-name-input-div input-item">
                                        <label for="appointment-name">نام و نام خانوادگی</label>
                                        <input type="text"  name="appointment-name" id="appointment-name"
                                               placeholder="نام و نام خانوادگی خود را وارد کنید">
                                        <i class="fa-light fa-user icon-input-item"></i>
                                    </div>
                                </div>
                                <div class="parent-input-counseling email-mobile">
                                    <div class="mobile-input-div input-item">
                                        <label for="appointment-mobile">موبایل</label>
                                        <input type="text"  name="appointment-mobile" id="appointment-mobile"
                                               placeholder="شماره موبایل خود را وارد کنید">
                                        <i class="fa-light fa-mobile icon-input-item"></i>
                                    </div>
                                    <div class="email-name-input-div input-item">
                                        <label for="appointment-email">ایمیل</label>
                                        <input type="text"  name="appointment-email" id="appointment-email"
                                               placeholder="ایمیل خود را وارد کنید">
                                        <i class="fa-light fa-envelope icon-input-item"></i>
                                    </div>
                                </div>
                                <div class="parent-input-counseling job-familiar">
                                    <div class="job-input-div input-item">
                                        <label for="appointment-profession">شغل</label>
                                        <input type="text"  name="appointment-profession" id="appointment-profession"
                                               placeholder="شغل  خود را وارد کنید">
                                        <i class="fa-light fa-building icon-input-item"></i>
                                    </div>
                                    <div class="familiar-input-div input-item">
                                        <label for="appointment-recognition">آشنایی با ما</label>
                                        <div class='parent-valid'>
                                           <select class="select2" name="appointment-recognition" id="appointment-recognition">
                                            <option value="" disabled selected>
                                                چگونه با ما آشنا شدید؟
                                            </option>
                                            {foreach $objRecognition->getAppointmentRecognitions() as $key=>$recognition}
                                            <option value="{$recognition['id']}">
                                                {$recognition['title']}
                                            </option>
                                            {/foreach}
                                        </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="parent-input-counseling date-hour">
                                    <div class="data-input-div input-item">
                                        <label for="appointment-date">تاریخ مشاوره</label>
                                        <input type="text"  name="appointment-date" id="appointment-date"
                                               placeholder="00/00/00" >
                                        <i class="fa-light fa-calendar-days icon-input-item"></i>
                                    </div>
                                    <div class="hour-input-div input-item">
                                        <label for="appointment-time">ساعت مشاوره</label>
                                        <input type="text"  name="appointment-time" id="appointment-time"
                                               placeholder="00:00">
                                        <i class="fa-light fa-clock icon-input-item"></i>
                                    </div>
                                </div>
                                <div class="description-div">
                                    <textarea name="appointment-comment" id="appointment-comment"  class="user-description"  cols="10" rows="3" placeholder=" توضیحات بیشتر شما"></textarea>
                                </div>
                                <button id="appointmentButton" class="btn-counseling" type="submit">ثبت درخواست
                                    <i class="fa-solid fa-arrow-left"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 p-0">
                    <div class="parent-img-text-counseling">
                        <h2>رزرو وقت مشاوره</h2>
                        <p>
                            جلسه مشاوره با هدف بهره وری بالا و بر اساس تجربه تنظیم شده و مهم ترین موضوعات در این جلسه مطرح می شود.
                            زمان مشاوره 30 دقیقه است. پرسش و پاسخ هایی درباره شرایط شما مطرح می شود. در پایان جلسه تصویر روشنی از مسیر پیش روی شما ارائه خواهد شد.
                        </p>
                        <p>
                            شما در هر زمان می توانید به راحتی با مشاوران ما در ارتباط باشید.
                        </p>
                        <div class="parent-link-phone-online">
                            <a href="tel:{$smarty.const.CLIENT_PHONE}" class="">{$smarty.const.CLIENT_PHONE}
                                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="headset" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="fa fa-fw svg-inline--fa fa-headset"><path fill="currentColor" d="M256 48C141.1 48 48 141.1 48 256v40c0 13.3-10.7 24-24 24s-24-10.7-24-24V256C0 114.6 114.6 0 256 0S512 114.6 512 256V400.1c0 48.6-39.4 88-88.1 88L313.6 488c-8.3 14.3-23.8 24-41.6 24H240c-26.5 0-48-21.5-48-48s21.5-48 48-48h32c17.8 0 33.3 9.7 41.6 24l110.4 .1c22.1 0 40-17.9 40-40V256c0-114.9-93.1-208-208-208zM144 208h16c17.7 0 32 14.3 32 32V352c0 17.7-14.3 32-32 32H144c-35.3 0-64-28.7-64-64V272c0-35.3 28.7-64 64-64zm224 0c35.3 0 64 28.7 64 64v48c0 35.3-28.7 64-64 64H352c-17.7 0-32-14.3-32-32V240c0-17.7 14.3-32 32-32h16z" class=""></path></svg>
                            </a>
                        </div>
                        <img src="assets/images/form-imgpng.png" alt="appoinment">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{literal}
    <script src="assets/timePicker/mdtimepicker.min.js"></script>
    <script src="assets/modules/js/appointment.js"></script>
{/literal}
