{load_presentation_object filename="cancellationFeeSetting" assign="objFee"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>تنظیمات</li>
                <li class="active">تنظیم جریمه کنسلی</li>
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
                <h3 class="box-title m-b-0">تنظیم جریمه کنسلی</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید تنظیمات مورد نظر خود را در سیستم ثبت نمائید</p>

                <form data-toggle="validator" id="CancellationFee" method="post">
                    <input type="hidden" name="flag" value="CancellationFeeSetting">
                    <div class="form-group col-sm-6 ">
                        <label for="AirlineIata" class="control-label">نام ایرلاین </label>
                        <select name="AirlineIata" id="AirlineIata" class="form-control select2">
                            <option value="">انتخاب کنید...</option>
                            {foreach $objFunctions->AirlineList() as $airline}
                            <option value="{$airline.abbreviation}">{$airline.name_fa}</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="TypeClass" class="control-label">شناسه نرخی</label>
                        <input type="text" class="form-control" id="TypeClass" name="TypeClass"
                               placeholder="شناسه نرخی وارد نمائید">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="ThreeDaysBefore" class="control-label">تا 12 ظهر 3 روز قبل از پرواز</label>
                        <input type="text" class="form-control" id="ThreeDaysBefore" name="ThreeDaysBefore"
                               placeholder="درصد زمان مورد نظر را وارد نمائید">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="OneDaysBefore" class="control-label">تا 12 ظهر 1 روز قبل از پرواز</label>
                        <input type="text" class="form-control" id="OneDaysBefore" name="OneDaysBefore"
                               placeholder="درصد زمان مورد نظر را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="ThreeHoursBefore" class="control-label">تا 3 ساعت قبل از پرواز</label>
                        <input type="text" class="form-control" id="ThreeHoursBefore" name="ThreeHoursBefore"
                               placeholder="درصد زمان مورد نظر را وارد نمائید">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="ThirtyMinutesAgo" class="control-label">تا 30 دقیقه قبل از پرواز</label>
                        <input type="text" class="form-control" id="ThirtyMinutesAgo" name="ThirtyMinutesAgo"
                               placeholder="درصد زمان مورد نظر را وارد نمائید">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="OfThirtyMinutesAgoToNext" class="control-label">از 30 دقیقه قبل پرواز به بعد</label>
                        <input type="text" class="form-control" id="OfThirtyMinutesAgoToNext" name="OfThirtyMinutesAgoToNext"
                               placeholder="درصد زمان مورد نظر را وارد نمائید">

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
<script type="text/javascript" src="assets/JsFiles/FeeSetting.js"></script>

