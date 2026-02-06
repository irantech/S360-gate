{load_presentation_object filename="country" assign="objCountry"}
{load_presentation_object filename="currency" assign="objCurrencyList"}

{assign var="continents" value=$objCountry->continentsList()}

{load_presentation_object filename="visaType" assign="objVisaType"}
{assign var="visaTypeList" value=$objVisaType->allVisaTypeList()}

{load_presentation_object filename="visa" assign="objVisa"}
{assign var="visaInfo" value=$objVisa->getVisaByID($smarty.get.id)}

{assign var="visaContinent" value=$objCountry->getCountryByCode($visaInfo.countryCode)}
{assign var="visaCountries" value=$objCountry->reservationCountriesByContinentID($visaContinent.continentID)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت ویزا رزرواسیون</li>
                <li><a href="visaList"> لیست ویزا ها</a></li>
                <li class="active">ویرایش ویزا</li>
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
                <h3 class="box-title m-b-0">ویرایش ویزا</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید ویزای مورد نظر را در سیستم ویرایش نمائید</p>

                <form data-toggle="validator" id="visaEdit" method="post">
                    <input type="hidden" name="flag" value="visaEdit">
                    <input type="hidden" name="id" value="{$visaInfo.id}">


                    <div class="form-group col-sm-12 ">
                        <label for="OnlinePayment" class="control-label">درخواست مشتری به همراه پرداخت آنلاین</label>
                        <div style='margin-top: 10px;'>
                            <input name="OnlinePayment" id="OnlinePayment" type="checkbox"
                                    {if $visaInfo.OnlinePayment == 'yes'} checked="checked" {/if}
                                   data-color="#99d683"
                                   data-secondary-color="#f96262" data-size="small"
                                   {if $item.isActive eq 'yes'}checked="checked"{/if} />
                        </div>
                    </div>

                    <div class="form-group col-sm-6 ">
                        <label for="title" class="control-label">عنوان ویزا </label>
                        <input type="text" class="form-control" id="title" name="title" value="{$visaInfo.title}"
                               placeholder="عنوان ویزا را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="continent" class="control-label">قاره</label>
                        <select class="form-control select2" id="continent" name="continent">
                            <option value="">لطفا قاره را انتخاب نمایید</option>
                            {foreach $continents as $each}
                                <option value="{$each.id}" {if $visaContinent.continentID eq $each.id}selected="selected"{/if}>{$each.titleFa}</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="countryCode" class="control-label">کشور</label>
                        <select class="form-control select2" id="countryCode" name="countryCode">
                            {foreach $visaCountries as $eachCountry}
                                <option value="{$eachCountry.abbreviation}" {if $visaInfo.countryCode eq $eachCountry.abbreviation}selected="selected"{/if}>{$eachCountry.name}</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="visaTypeID" class="control-label">نوع ویزا</label>
                        <select class="form-control select2" id="visaTypeID" name="visaTypeID">
                            <option>لطفا نوع ویزا را انتخاب نمایید</option>
                            {foreach $visaTypeList as $each}
                                <option value="{$each.id}" {if $visaInfo.visaTypeID eq $each.id}selected="selected"{/if}>{$each.title}</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group col-sm-6 ">
                        <label for="mainCost" class="control-label">قیمت ویزا (ریال)</label>
                        <input type="text" class="form-control" id="mainCost" name="mainCost" value="{$visaInfo.mainCost}"
                               placeholder="قیمت ویزا را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6 ">
                        <label for="prePaymentCost" class="control-label">پیش پرداخت (ریال)</label>
                        <input type="text" class="form-control" id="prePaymentCost" name="prePaymentCost" value="{$visaInfo.prePaymentCost}"
                               placeholder="پیش پرداخت را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="visaTypeID" class="control-label">نوع ارز</label>
                        <select class="form-control select2" id="currencyType" name="currencyType">

                                <option {if $visaInfo.currencyType eq '0'} selected {/if}
                                         value="0">ریال</option>

                            {foreach key=key item=item from=$objCurrencyList->CurrencyList()}
                                {if $item.IsEnable eq 'Enable'}
                                    <option {if $visaInfo.currencyType eq $item.id} selected {/if}
                                            value="{$item.id}">{$item.CurrencyTitle}</option>
                                {/if}
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group col-sm-6 ">
                        <label for="deadline" class="control-label">زمان تحویل</label>
                        <input type="text" class="form-control" id="deadline" name="deadline" value="{$visaInfo.deadline}"
                               placeholder="زمان تحویل را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6 ">
                        <label for="validityDuration" class="control-label">مدت اعتبار</label>
                        <input type="text" class="form-control" id="validityDuration" name="validityDuration" value="{$visaInfo.validityDuration}"
                               placeholder="مدت اعتبار را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6 ">
                        <label for="allowedUseNo" class="control-label">تعداد دفعات مجاز به استفاده</label>
                        <input type="text" class="form-control" id="allowedUseNo" name="allowedUseNo" value="{$visaInfo.allowedUseNo}"
                               placeholder="تعداد دفعات مجاز را وارد نمائید">
                    </div>


                    

                    <div class="form-group col-sm-12">
                        <label for="documents" class="control-label">مدارک</label>
                        <textarea class="setToEditor" id="documents" name="documents">{$visaInfo.documents}</textarea>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="descriptions" class="control-label">توضیحات</label>
                        <textarea class="setToEditor" id="descriptions" name="descriptions">{$visaInfo.descriptions}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary pull-right submitForEditor">ارسال اطلاعات</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/visa.js"></script>

