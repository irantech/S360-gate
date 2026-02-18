{load_presentation_object filename="currencyEquivalent" assign="objCurrencyEquivalent"}

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
                    <input type="hidden" name="flag" value="InsertCurrencyEquivalent">


                    <div class="form-group col-sm-6 ">

                        <label for="CurrencyCode" class="control-label">عنوان ارز</label>
                        <select class="form-control" name="CurrencyCode" id="CurrencyCode" >
                            <option value="">انتخاب کنید...</option>
                            {foreach $objCurrencyEquivalent->ListCurrency() as $currency}
                                <option value="{$currency['CurrencyCode']}">{$currency['CurrencyTitle']}</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="EqAmount" class="control-label">مقدار معادل</label>
                        <input type="text" class="form-control" id="EqAmount" name="EqAmount"
                               placeholder="معادل ارز را به ریال وارد نمائید">

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


<script type="text/javascript" src="assets/JsFiles/currencyEquivalent.js"></script>

