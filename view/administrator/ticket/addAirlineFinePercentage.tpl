{load_presentation_object filename="airline" assign="objAirline"}
{assign var=airLineiataCodes value=$objAirline->getAllIataCodes()}
{assign var=airLineFareClasses value=$objAirline->getFareClasses()}
<style>
    .fine-box {
        background: #f8f9fa;        /* خاکستری خیلی ملایم */
        border: 1px solid #dee2e6;  /* مرز ظریف */
        border-radius: 6px;
        padding: 15px;
        margin-bottom: 10px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        border-color: #888 transparent transparent transparent;
        border-style: solid;
        border-width: 5px 4px 0 4px;
        height: 0px;
        left: 50%;
        margin-left: -4px;
        margin-top: -14px;
        position: absolute;
        top: 50%;
        width: 0;
    }
</style>
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="visaList"> لیست نرخ ایرلاین ها</a></li>
                <li class="active">افزودن نرخ</li>
            </ol>
        </div>
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>

        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">نرخ جدید</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید ویزا های جدید در سیستم ثبت نمائید</p>

                <form class="d-flex flex-wrap"
                      data-toggle="validator"
                      id="fineAdd"
                      method="post" enctype="multipart/form-data">
                    <input type="hidden" name="flag" value="fineAdd">

                    <div class="form-group col-sm-6">
                        <label for="airline_iata_id" class="control-label">ایرلاین</label><span style="color:red">*</span>
                        <select class="form-control select2" id="airline_iata_id" name="airline_uniqe_iata">
                            <option value="">لطفا یاتا مورد نظر را انتخاب نمایید</option>
                            {foreach $airLineiataCodes as $airLineiataCode}
                                <option value="{$airLineiataCode.id}">{$airLineiataCode.airline_name}({$airLineiataCode.airline_uniqe_iata})</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="class_fare_id" class="control-label"> کلاس نرخی</label><span style="color:red">*</span>
                        <select name="class_fare_ids[]" id="class_fare_id" class="form-control select2 " placeholder="کلاس نرخی  را انتخاب کنید" multiple>
                            {foreach $airLineFareClasses as $airLineFareClass}
                                <option value="{$airLineFareClass.id}">{$airLineFareClass.class_name}</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group col-sm-12 DynamicFineData fine-box">
                        <div class="row FineItem" data-target="BaseFineDataDiv">
                            <div class="form-group col-sm-2"><label>از روز </label> <input
                                        type="number" class="form-control" data-field="from_day_date"
                                        name="FineData[0][from_day_date]" placeholder="از روز"
                                        value=""></div>
                            <div class="form-group col-sm-2"><label>از ساعت </label> <input
                                        type="number" class="form-control" data-field="from_hour_date"
                                        name="FineData[0][from_hour_date]" placeholder="از ساعت"
                                        value=""></div>
                            <div class="form-group col-sm-2"><label>تا روز </label> <input
                                        type="number" class="form-control" data-field="until_day_date"
                                        name="FineData[0][until_day_date]" placeholder="تا روز"
                                        value=""></div>
                            <div class="form-group col-sm-2"><label>تا ساعت </label> <input
                                        type="number" class="form-control" data-field="until_hour_date"
                                        name="FineData[0][until_hour_date]" placeholder="تا ساعت"
                                        value=""></div>
                            <p class="form-group col-sm-1" style="padding-top: 30px;">قبل از پرواز. </p>
                            <div class="form-group col-sm-2"><label>درصد جریمه </label> <input
                                        type="number" class="form-control" data-field="fine_percentage"
                                        name="FineData[0][fine_percentage]" placeholder="درصد جریمه"
                                        value=""></div>
                            <div class="form-group col-sm-1 d-flex flex-column"><label>&nbsp;</label>
                                <div class="d-flex mt-4" style="margin-top: 24px !important;">
                                    <button type="button" class="btn btn-success mr-1" onclick="addFineData()"><span
                                                class="fa fa-plus"></span></button>
                                    <button type="button" class="btn btn-danger" onclick="removeFineData($(this))"><span
                                                class="fa fa-remove"></span></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- تغییر اصلی اینجا است -->
                    <div class="form-group col-sm-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary float-left submitForEditor">ارسال اطلاعات</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/airline.js"></script>

