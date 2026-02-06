{load_presentation_object filename="bankList" assign="ObjBank"}
{$ObjBank->showedit($smarty.get.bankId,$smarty.get.ClientId)}

{load_presentation_object filename="servicesDiscount" assign="objServicesDiscount"}
{$objServicesDiscount->getAllServices()} {*گرفتن لیست خدمات*}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="bankList{if $smarty.get.ClientId neq ''}&ClientId={$smarty.get.ClientId}{/if}">اطلاعات بانک ها </a></li>
                <li class="active">ویرایش بانک</li>
                {if $smarty.get.ClientId neq ''}
                <li class="">{$objFunctions->ClientName($smarty.get.ClientId)}</li>
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
                <h3 class="box-title m-b-0">ویرایش  بانک</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید اطلاعات درپاه بانکی مورد نظر را در سیستم ویرایش نمائید</p>

                <form id="EditBank" method="post">
                    <input type="hidden" name="flag" value="editBank">
                    <input type="hidden" name="ClientId" id="ClientId" value="{if $smarty.get.ClientId   neq ''}{$smarty.get.ClientId}{/if}">
                    <input type="hidden" name="bankId" id="bankId" value="{if $smarty.get.bankId   neq ''}{$smarty.get.bankId}{/if}">

                    <div class="form-group col-sm-6 ">

                        <label for="title" class="control-label">نام بانک</label>
                        <select name="title" id="title" class="form-control">

                            <option value="">انتخاب کنید...</option>
                            <option value="pasargad-پاسارگارد-pasargad" {if $ObjBank->edit['bank_dir'] eq 'pasargad'} selected {/if}>بانک پاسارگارد</option>
                            <option value="mellat-ملت-mellat" {if $ObjBank->edit['bank_dir'] eq 'mellat'} selected {/if}>بانک ملت</option>
                            <option value="keshavarzi-کشاورزی-keshavarzi" {if $ObjBank->edit['bank_dir'] eq 'keshavarzi'} selected {/if}>بانک کشاورزی</option>
                            <option value="irankish-تجارت-tejarat" {if $ObjBank->edit['bank_dir'] eq 'irankish' && $ObjBank->edit['title_en'] eq 'tejarat'} selected {/if}>بانک تجارت (درگاه ایران کیش)</option>
                            <option value="irankish-سپه-sepah" {if $ObjBank->edit['bank_dir'] eq 'irankish' && $ObjBank->edit['title_en'] eq 'sepah'} selected {/if}>بانک سپه (درگاه ایران کیش)</option>
                            <option value="mabnakartaria-صادرات-saderat" {if $ObjBank->edit['bank_dir'] eq 'mabnakartaria' && $ObjBank->edit['title_en'] eq 'saderat'} selected {/if}>بانک صادرات (درگاه مبنا کارت آریا)</option>
                            <option value="samankish-گردشگری-gardeshgari" {if $ObjBank->edit['bank_dir'] eq 'samankish' && $ObjBank->edit['title_en'] eq 'gardeshgari'} selected {/if}>بانک گردشگری (درگاه سامان کیش)</option>
                            <option value="samankish-سامان-saman" {if $ObjBank->edit['bank_dir'] eq 'samankish' && $ObjBank->edit['title_en'] eq 'saman'} selected {/if}>بانک سامان (درگاه سامان کیش)</option>
                            <option value="fanavacard-سامان-saman" {if $ObjBank->edit['bank_dir'] eq 'fanavacard' && $ObjBank->edit['title_en'] eq 'saman'} selected {/if}>بانک سامان (درگاه فن آوا کارت)</option>
                            <option value="parsian-پارسیان-parsian" {if $ObjBank->edit['bank_dir'] eq 'parsian'} selected {/if}>بانک پارسیان </option>
                            <option value="stripe-stripe-stripe" {if $ObjBank->edit['bank_dir'] eq 'stripe'} selected {/if}>بانک stripe</option>
                            <option value="zarin-زرین-zarin"  {if $ObjBank->edit['bank_dir'] eq 'zarin'} selected {/if}>درگاه زرین پال</option>
                            <option value="idpay-آیدیپی-idpay"  {if $ObjBank->edit['bank_dir'] eq 'idpay'} selected {/if}>درگاه آیدی پی (IDPay)</option>
                            <option value="yekpay-یکپی-yekpay"  {if $ObjBank->edit['bank_dir'] eq 'yekpay'} selected {/if}>درگاه یک پی</option>
                            <option value="zain-زینکش-zain"  {if $ObjBank->edit['bank_dir'] eq 'zain'} selected {/if}>درگاه خارجی زین کش</option>
                            <option value="saderat-صادرات-saderat" {if $ObjBank->edit['bank_dir'] eq 'saderat'} selected {/if} >درگاه صادرات (Saderat)</option>
                            <option value="nextpay-نکستپی-nextpay" {if $ObjBank->edit['bank_dir'] eq 'nextPay'} selected {/if} >نکست پی (nextPay)</option>
                            <option value="sadad-سداد-sadad" {if $ObjBank->edit['bank_dir'] eq 'sadad'} selected {/if} >سداد (sadad)</option>
                            <option value="publicBank-بانک اشتراکی-publicBank" {if $ObjBank->edit['bank_dir'] eq 'publicBank'} selected {/if}>بانک اشتراکی (publicBank)</option>
                            <option value="selfit-سلفیت-selfit" {if $ObjBank->edit['bank_dir'] eq 'selfit'} selected {/if}>درگاه سلفیت (SELFiT)</option>
                            <option value="payStar-پی استار-payStar" {if $ObjBank->edit['bank_dir'] eq 'payStar'} selected {/if}>پی استار</option>

                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="param1" class="control-label">نام کاربری درگاه</label>
                        <input type="text" class="form-control" id="param1" name="param1"
                               placeholder="نام کاربری درگاه را وارد نمائید" value="{$ObjBank->edit['param1']}">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="param2" class="control-label">رمز عبور درگاه</label>
                        <input type="text" class="form-control" id="param2" name="param2"
                               placeholder="رمز عبور درگاه را وارد نمائید" value="{$ObjBank->edit['param2']}">
                    </div>


                    <div class="form-group col-sm-6 ">
                        <label for="param3" class="control-label">کلید خصوصی درگاه</label>
                        <textarea id="param3" name="param3" class="form-control"
                                  placeholder="کلید خصوصی درگاه را وارد نمائید">{$ObjBank->edit['param3']}</textarea>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="param4" class="control-label">پارامتر چهارم</label>
                        <input type="text" class="form-control" id="param4" name="param4" value="{$ObjBank->edit['param4']}">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="param5" class="control-label">پارامتر پنجم</label>
                        <input type="text" class="form-control" id="param5" name="param5" value="{$ObjBank->edit['param5']}">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="param5" class="control-label">سرویس مورد نظر</label>
                        <select class="form-control" name="serviceTitle" id="serviceTitle">
                            <option value="All" {if $ObjBank->edit['serviceTitle'] == 'All'}selected="selected"{/if}>همه</option>
                            {foreach $objServicesDiscount->services as $item}
                                <option value="{$item.TitleEn}" {if $ObjBank->edit['serviceTitle'] == {$item.TitleEn}}selected="selected"{/if}>{$item.TitleFa}</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="param5" class="control-label">بانک ارزی</label>
                        <select class="form-control" name="is_currency" id="is_currency">
                            <option value="0" {if $ObjBank->edit['is_currency'] == '0'}selected="selected"{/if}>غیر ارزی</option>
                            <option value="1" {if $ObjBank->edit['is_currency'] == '1'}selected="selected"{/if}>ارزی</option>
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

