{load_presentation_object filename="bankList" assign="ObjBank"}

{load_presentation_object filename="servicesDiscount" assign="objServicesDiscount"}
{$objServicesDiscount->getAllServices()} {*گرفتن لیست خدمات*}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="bankList">اطلاعات بانک ها </a></li>
                <li class="active">افزودن بانک</li>
                {if $smarty.get.id neq ''}
                <li class="">{$objFunctions->ClientName($smarty.get.id)}</li>
                {/if}
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
                <h3 class="box-title m-b-0">افزودن  بانک</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید درگاه بانکی جدیدی را در سیستم ثبت نمائید</p>

                <form id="AddBank" method="post">
                    <input type="hidden" name="flag" value="insert_bank">
                    <input type="hidden" name="ClientId" id="ClientId" value="{if $smarty.get.id   neq ''}{$smarty.get.id}{/if}">

                    <div class="form-group col-sm-6 ">

                        <label for="title" class="control-label">نام بانک</label>
                        <select name="title" id="title" class="form-control select2">
                            <option value="">انتخاب کنید...</option>
                            <option value="pasargad-پاسارگاد-pasargad">بانک پاسارگاد</option>
                            <option value="mellat-ملت-mellat">بانک ملت</option>
                            <option value="keshavarzi-کشاورزی-keshavarzi">بانک کشاورزی</option>
                            <option value="irankish-تجارت-tejarat">بانک تجارت (درگاه ایران کیش)</option>
                            <option value="irankish-سپه-sepah">بانک سپه (درگاه ایران کیش)</option>
                            <option value="mabnakartaria-صادرات-saderat">بانک صادرات (درگاه مبنا کارت آریا)</option>
                            <option value="samankish-گردشگری-gardeshgari">بانک گردشگری (درگاه سامان کیش)</option>
                            <option value="samankish-سامان-saman">بانک سامان (درگاه سامان کیش)</option>
                            <option value="fanavacard-سامان-saman">بانک سامان (درگاه فن آوا کارت)</option>
                            <option value="parsian-پارسیان-parsian">بانک پارسیان </option>
                            <option value="stripe-stripe-stripe">بانک stripe</option>
                            <option value="zarin-زرین-zarin">درگاه زرین پال</option>
                            <option value="idpay-آیدیپی-idpay">درگاه آیدی پی (IDPay)</option>
                            <option value="yekpay-یکپی-yekpay">درگاه یک پی (YekPay)</option>
                            <option value="zain-زینکش-zain">درگاه خارجی زین کش</option>
                            <option value="saderat-صادرات-saderat">درگاه صادرات (Saderat)</option>
                            <option value="nextpay-نکستپی-nextpay">نکست پی (nextPay)</option>
                            <option value="sadad-ملی-sadad">ملی (sadad)</option>
                            <option value="publicBank-بانک اشتراکی-publicBank">بانک اشتراکی (publicBank)</option>
                            <option value="selfit-سلفیت-selfit">درگاه سلفیت (SELFiT)</option>
                            <option value="payStar-پی استار-payStar">پی استار</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="param1" class="control-label">نام کاربری درگاه</label>
                        <input type="text" class="form-control" id="param1" name="param1"
                               placeholder="نام کاربری درگاه را وارد نمائید" />

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="param2" class="control-label">رمز عبور درگاه</label>
                        <input type="text" class="form-control" id="param2" name="param2"
                               placeholder="رمز عبور درگاه را وارد نمائید" />
                    </div>


                    <div class="form-group col-sm-6 ">
                        <label for="param3" class="control-label">کلید خصوصی درگاه</label>
                        <textarea id="param3" name="param3" class="form-control"
                                  placeholder="کلید خصوصی درگاه را وارد نمائید"></textarea>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="param4" class="control-label">پارامتر چهارم</label>
                        <input type="text" class="form-control" id="param4" name="param4" />
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="param5" class="control-label">پارامتر پنجم</label>
                        <input type="text" class="form-control" id="param5" name="param5" />
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="param5" class="control-label">سرویس مورد نظر</label>
                        <select class="form-control" name="serviceTitle" id="serviceTitle">
                            <option value="All">همه</option>
                            {foreach $objServicesDiscount->services as $item}
                                <option value="{$item.TitleEn}">{$item.TitleFa}</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="param5" class="control-label">بانک ارزی</label>
                        <select class="form-control" name="is_currency" id="is_currency">
                            <option value="0">غیر ارزی</option>
                            <option value="1">ارزی</option>
                        </select>
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


<script type="text/javascript" src="assets/JsFiles/bankList.js"></script>

