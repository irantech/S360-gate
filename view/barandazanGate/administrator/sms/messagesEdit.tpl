{load_presentation_object filename="smsPanel" assign="objSms"}
{assign var="messageInfo" value=$objSms->getMessageByID($smarty.get.id)}
{assign var="smsUsages" value=$objSms->messageUsages()}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>پنل پیامکی</li>
                <li><a href="messages">لیست متن پیامک</a></li>
                <li class="active">ویرایش متن پیامک</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>

        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">ویرایش پیام</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید پیام های جدید جهت ارسال پیامک را در سیستم ثبت نمائید</p>

                <form data-toggle="validator" id="messageEdit" method="post">
                    <input type="hidden" name="flag" value="messageEdit" />
                    <input type="hidden" name="id" value="{$messageInfo['id']}" />

                    <div class="form-group col-sm-12 ">
                        <label class="control-label">راهنما</label>
                        <textarea class="form-control" readonly="readonly" rows="30">
  نکاتی که در متن پیامک باید رعایت گردد:
 1. برای مقادیری که باید به صورت اتوماتیک در متن پیامک ایجاد گردند، پارامترهایی در || ایجاد شده اند و شما باید از آنها در متن پیامکتان استفاده کنید.
 - نام و نام خانوادگی کاربر یا مسافر: |sms_name|
 - نام کاربری اعضا: |sms_username|
 - کد معرف اعضا: |sms_reagent_code|
 - خدمات مربوطه در هنگام خرید مانند بلیط: |sms_service|
 - شماره فاکتور خدمات: |sms_factor_number|
 - مبلغ خدمات: |sms_cost|
 - فایل pdf خدمات: |sms_pdf|
 - فایل انگلیسی pdf خدمات: |sms_pdf_en|
 - ایرلاین (مخصوص پرواز): |sms_airline|
 - مبدا (مخصوص پرواز): |sms_origin|
 - مقصد: |sms_destination|
 - شماره پرواز (مخصوص پرواز): |sms_flight_number|
 - تاریخ پرواز (مخصوص پرواز): |sms_flight_date|
 - ساعت پرواز (مخصوص پرواز): |sms_flight_time|
 - درصد جریمه کنسلی (مخصوص پرواز): |sms_flight_indemnity|
 - نام هتل (مخصوص هتل): |sms_hotel_name|
 - تاریخ ورود به هتل (مخصوص هتل): |sms_hotel_in|
 - تاریخ خروج از هتل (مخصوص هتل): |sms_hotel_out|
 - مدت اقامت در هتل (مخصوص هتل): |sms_hotel_night|
 - سرویس مورد استفاده بیمه (مخصوص بیمه): |sms_insure_type|
 - عنوان بیمه نامه (مخصوص بیمه): |sms_insure_caption|
 - تعداد روز رزرو بیمه (مخصوص بیمه): |sms_insure_duration|
 - عنوان ویزا (مخصوص ویزا): |sms_visa_title|
 - نوع ویزا (مخصوص ویزا): |sms_visa_type|
 - مدت اعتبار ویزا (مخصوص ویزا): |sms_visa_duration|
 - عنوان کد تخفیف (مخصوص کد ترانسفر): |sms_interactive_title|
 - کد تخفیف (مخصوص کد ترانسفر): |sms_interactive_code|
 - نام خودرو (مخصوص اجاره خودرو): |sms_europcar_car_name|
 - ایستگاه تحویل (مخصوص اجاره خودرو): |sms_europcar_source_station_name|
 - ایستگاه بازگشت (مخصوص اجاره خودرو): |sms_europcar_dest_station_name|
 - تاریخ تحویل (مخصوص اجاره خودرو): |sms_europcar_source_date|
 - ساعت تحویل (مخصوص اجاره خودرو): |sms_europcar_source_time|
 - تاریخ بازگشت (مخصوص اجاره خودرو): |sms_europcar_dest_date|
 - ساعت بازگشت (مخصوص اجاره خودرو): |sms_europcar_dest_time|
 - نام تور (مخصوص تور): |sms_tour_name|
 - تعداد شب تور (مخصوص تور): |sms_tour_night|
 - تعداد روز تور (مخصوص تور): |sms_tour_day|
 - شهر های تور (مخصوص تور): |sms_tour_cities|
 - تاریخ رفت تور (مخصوص تور): |sms_tour_dept_date|
 - تاریخ برگشت تور (مخصوص تور): |sms_tour_return_date|
 - نام سرویس گشت (مخصوص گشت): |sms_gasht_service_name|
 - نام شهر مقصد گشت (مخصوص گشت): |sms_gasht_city_name|
 - تاریخ گشت (مخصوص گشت): |sms_gasht_date|
 - از ساعت گشت (مخصوص گشت): |sms_gasht_start_time|
 - تا ساعت گشت (مخصوص گشت): |sms_gasht_end_time|
 - نام شهر مبدا (مخصوص اتوبوس): |sms_bus_origin_name|
 - نام شهر مقصد (مخصوص اتوبوس): |sms_bus_dest_name|
 - نام شرکت مسافربری (مخصوص اتوبوس): |sms_bus_company_name|
 - پایانه مسافربری مبدا (مخصوص اتوبوس): |sms_bus_origin_terminal|
 - تاریخ حرکت (مخصوص اتوبوس): |sms_bus_date_move|
 - ساعت حرکت (مخصوص اتوبوس): |sms_bus_time_move|
 - نام آژانس شما: |sms_agency|
 - شماره موبایل آژانس شما: |sms_agency_mobile|
 - تلفن ثابت آژانس شما: |sms_agency_phone|
 - ایمیل آژانس شما: |sms_agency_email|
 - آدرس آژانس شما: |sms_agency_address|
 - آدرس سایت شما: |sms_site_url|
 - رفتن به خط بعدی: |sms_eol|
2. در صورتیکه از مقادیر بالا در پیامک هایی که معادلی ندارند استفاده کنید، به دلیل عدم وجود معادل این مقادیر، مقداردهی نمی گردند. (به عنوان مثال مقدار |sms_cost| در پیامک تبریک تولد مفهومی ندارد و به همین صورت و بدون جایگزینی ارسال می گردد)
                        </textarea>
                    </div>

                    <div class="form-group col-sm-6 ">
                        <label for="title" class="control-label">عنوان</label>
                        <input type="text" class="form-control" id="title" name="title" value="{$messageInfo['title']}"
                               placeholder="عنوان پیامک را وارد نمائید">
                    </div>
                    <div class="form-group col-sm-6 ">
                        <label for="smsUsage" class="control-label">کاربرد</label>
                        <select id="smsUsage" name="smsUsage" class="form-control select2">
                            <option value="">کاربرد متن پیامک را وارد نمائید</option>
                            {foreach $smsUsages as $key => $value}
                                <option value="{$key}" {if $messageInfo['smsUsage'] eq $key}selected="selected"{/if}>{$value}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-6 ">
                        <label for="body" class="control-label">متن</label>
                        <textarea class="form-control" id="body" name="body" rows="5"
                                  placeholder="متن پیامک را وارد نمائید">{$messageInfo['body']}</textarea>
                    </div>
                    <div class="form-group col-sm-6 ">
                        <label class="control-label">نمونه</label>
                        <textarea class="form-control" readonly="readonly" rows="5">دوست عزیز |sms_name| با سلام|sms_eol|
رزرو |sms_service| شما به شماره فاکتور |sms_factor_number| با موفقیت رزرو شد.|sms_eol|
تاریخ رفت پرواز |sms_date_start| و تاریخ برگشت پرواز |sms_date_end| می باشد.|sms_eol|
از اینکه از خدمات ما استفاده نمودید کمال تشکر را داریم|sms_eol|
|sms_agency|</textarea>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary pull-right">ارسال اطلاعات</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript" src="assets/JsFiles/smsPanel.js"></script>