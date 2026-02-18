{load_presentation_object filename="currency" assign="objCurrencyList"}
{assign var="ShowInfo" value=$objCurrencyList->ShowInfo($smarty.get.id)}
<br>
<br>
<br>

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li> تنظیمات</li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/currency/currencyList">لیست ارزها</a></li>
                <li class="active">ویرایش ارز جدید</li>
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
                <h3 class="box-title m-b-0">ویرایش ارز</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید ارز جدیدی را در سیستم ثبت نمائید</p>

                <form id="EditCurrency" method="post">
                    <input type="hidden" name="flag" value="EditCurrency">
                    <input type="hidden" name="id" id="id" value="{$ShowInfo['id']}">


                    <div class="form-group col-sm-6 ">

                        <label for="CurrencyTitle" class="control-label">عنوان ارز</label>
                        <input type="text" class="form-control" name="CurrencyTitle" id="CurrencyTitle" placeholder="عنوان ارز را وارد نمائید"
                               value="{$ShowInfo['CurrencyTitle']}">
                    </div>
                    <div class="form-group col-sm-6 ">

                        <label for="CurrencyTitleEn" class="control-label">عنوان لاتین ارز</label>
                        <input type="text" class="form-control" name="CurrencyTitleEn" id="CurrencyTitleEn" value="{$ShowInfo['CurrencyTitleEn']}">
                    </div>
                    <div class="form-group col-sm-6 has-info">

                        <label for="CurrencyPrice" class="control-label">قیمت ارز </label>
                        <input type="text" class="form-control" name="CurrencyPrice" id="CurrencyPrice"
                               value="{$ShowInfo['CurrencyPrice']}">
                    </div>
                    <div class="form-group col-sm-6 has-info">

                        <label for="CurrencyShortName" class="control-label">نام کوتاه ارز </label>
                        <input type="text" class="form-control" name="CurrencyShortName" id="CurrencyShortName"
                               value="{$ShowInfo['CurrencyShortName']}">
                        <span class="help-block">برای مثال دلار : USD</span>
                    </div>



                    <div class="form-group col-sm-6">
                        <label for="CurrencyFlag" class="control-label">نماد ارز</label>
                        <input type="file" name="CurrencyFlag" id="CurrencyFlag" class="dropify" data-height="100"
                               data-default-file="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/flagCurrency/{$ShowInfo['CurrencyFlag']}"/>
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

