{load_presentation_object filename="currency" assign="objCurrencyList"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li> تنظیمات</li>
                <li class="active">افزودن ارز جدید</li>
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
                <h3 class="box-title m-b-0">افزودن  ارز جدید</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید ارز جدیدی را در سیستم ثبت نمائید</p>

                <form id="InsertCurrency" method="post">
                    <input type="hidden" name="flag" value="InsertCurrency">


                    <div class="form-group col-sm-6 ">

                        <label for="CurrencyTitle" class="control-label">عنوان ارز</label>
                        <input type="text" class="form-control" name="CurrencyTitle" id="CurrencyTitle" placeholder="عنوان ارز را وارد نمائید">
                    </div>
                    <div class="form-group col-sm-6 ">

                        <label for="CurrencyTitleEn" class="control-label">عنوان لاتین ارز</label>
                        <input type="text" class="form-control" name="CurrencyTitleEn" id="CurrencyTitleEn" placeholder="عنوان ارز را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="CurrencyFlag" class="control-label">نماد ارز</label>
                        <input type="file" name="CurrencyFlag" id="CurrencyFlag" class="dropify" data-height="100"
                               data-default-file="assets/plugins/images/defaultLogo.png"/>
                    </div>



                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group  pull-right">
                                <button type="submit" class="btn btn-primary">ارسال اطلاعات</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="assets/JsFiles/currency.js"></script>

