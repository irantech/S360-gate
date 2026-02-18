{load_presentation_object filename="servicesDiscount" assign="objServicesDiscount"}
{$objServicesDiscount->getAllServices()} {*گرفتن لیست خدمات*}

{assign var="allCities" value=$objFunctions->cityIataList()}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>خدمات ویژه</li>
                <li class="active">ورود کدهای تخفیف جدید</li>
            </ol>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>

        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">کد تخفیف جدید</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر می توانید کدهای تخفیف را از طریق فایل اکسل در سیستم ثبت نمائید</p>

                <form data-toggle="validator" id="interactiveOffCodesAdd" method="post">
                    <input type="hidden" name="flag" value="interactiveOffCodesAdd">
                    <div class="form-group col-sm-6 ">
                        <label for="title" class="control-label">عنوان تخفیف </label>
                        <input type="text" class="form-control" id="title" name="title"
                               placeholder="عنوان تخفیف را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="expireDate" class="control-label">تاریخ انقضای استفاده</label>
                        <input type="text" class="form-control datepickerOfToday" id="expireDate" name="expireDate"
                               placeholder="تاریخ انقضای استفاده را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="origin" class="control-label">خدمات با این مبدأ، می توانند از کد تخفیف استفاده کنند</label>
                        <select class="form-control select2" id="origin" name="origin[]" multiple="multiple">
                            <option value="">مبدا های مورد نظر را انتخاب نمائید</option>
                            {foreach $allCities as $city}
                                <option value="{$city.city_iata}">{$city.city_name}</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="destination" class="control-label">خدمات با این مقصد، می توانند از کد تخفیف استفاده کنند</label>
                        <select class="form-control select2" id="destination" name="destination[]" multiple="multiple">
                            <option value="">مقصدهای مورد نظر را انتخاب نمائید</option>
                            {foreach $allCities as $city}
                                <option value="{$city.city_iata}">{$city.city_name}</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group col-sm-6 ">
                        <label for="excelCodes" class="control-label">فایل اکسل شامل کدهای تخفیف </label>
                        <input type="file" class="dropify" id="excelCodes" name="excelCodes" data-height="70" />
                    </div>

                    <div class="form-group col-sm-12">
                        <p>کد تخفیف مذکور پس از خرید این خدمات به مشتری ارائه گردد:</p>

                        {foreach key=keyService item=itemService from=$objServicesDiscount->services}
                            <div class="col-sm-3">
                                <input type="checkbox" name="Check{$itemService.TitleEn}" id="Check{$itemService.TitleEn}" value="1" />
                                <label for="Check{$itemService.TitleEn}" class="control-label">{$itemService.TitleFa}</label>
                            </div>
                        {/foreach}

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

<script type="text/javascript" src="assets/JsFiles/interactiveOffCodes.js"></script>

