{load_presentation_object filename="visaRequestStatus" assign="objStatus"}
{load_presentation_object filename="country" assign="objCountry"}
{*{load_presentation_object filename="currency" assign="objCurrencyList"}*}
{load_presentation_object filename="currencyEquivalent" assign="objCurrencyEquivalent"}

{load_presentation_object filename="visaCategory" assign="objVisaCategory"}

{assign var="statuses" value=$objStatus->getAll()}

{assign var="continents" value=$objCountry->continentsList()}

{load_presentation_object filename="visaType" assign="objVisaType"}
{assign var="visaTypeList" value=$objVisaType->allVisaTypeList()}
<style>
    .visa-box {
        background: #f8f9fa;        /* خاکستری خیلی ملایم */
        border: 1px solid #dee2e6;  /* مرز ظریف */
        border-radius: 6px;
        padding: 15px;
        margin-bottom: 10px;
    }
</style>
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت ویزا رزرواسیون</li>
                <li><a href="visaList"> لیست ویزا ها</a></li>
                <li class="active">ویزا جدید</li>
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
                <h3 class="box-title m-b-0">ویزا جدید</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید ویزا های جدید در سیستم ثبت نمائید</p>

                <form class="d-flex flex-wrap"
                      data-toggle="validator"
                      id="visaAdd"
                      method="post" enctype="multipart/form-data">
                    <input type="hidden" name="flag" value="visaAdd">
                    <input type="hidden" name="pageType" value="admin">
                    <input type="hidden" name="visaCount" value="1">
                    <input type="hidden" name="admin" value="1">
                    <input type="hidden" name="clientID" value="{$smarty.const.CLIENT_ID}">


                    {foreach $objVisaCategory->getVisaCategoryList() as $key => $category}
                    <div class="form-check form-check-inline ml-3">
                        <input class="form-check-input" type="radio" {if $category['id'] == 1}checked{/if} name="visaCategory" id="category{$category['id']}" value="{$category['id']}">
                        <label class="form-check-label" for="category{$category['id']}">{$category['title']}</label>
                    </div>
                    {/foreach}


                    <div class="form-group col-sm-12 d-flex" style="flex-direction: row-reverse;justify-content: flex-end;">
                        <label for="OnlinePayment" class="control-label">درخواست مشتری به همراه پرداخت آنلاین</label>
                        <div style='margin-left: 10px;'>
                            <input name="OnlinePayment" id="OnlinePayment" type="checkbox" checked="checked"  data-color="#99d683" data-secondary-color="#f96262" data-size="small" {if $item.isActive eq 'yes'}checked="checked"{/if} />
                        </div>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="title" class="control-label">عنوان ویزا </label>
                        <input type="text" class="form-control" id="title" name="title[]"
                               placeholder="عنوان ویزا را وارد نمائید">
                    </div>
                    <div class="form-group col-sm-6">

                    </div>

                    <div class="form-group col-sm-6">
                        <label for="continent" class="control-label">قاره</label>
                        <select class="form-control select2" id="continent" name="continent">
                            <option value="">لطفا قاره را انتخاب نمایید</option>
                            {foreach $continents as $each}
                                <option value="{$each.id}">{$each.titleFa}</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="countryCode" class="control-label">کشور</label>
                        <select class="form-control select2" id="countryCode" name="countryCode"></select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="visa_statuses" class="control-label">وضعیت های ویزا </label>
                        <select name="visa_statuses[0][]" id="visa_statuses" class="form-control select2" placeholder="وضعیت هایی که برای کاربر قابل نمایش است را انتخاب کنید" multiple>
                            {foreach $statuses as $status}
                                <option value="{$status.id}">{$status.title}</option>
                            {/foreach}
                        </select>

                    </div>
                    <div class="form-group col-sm-12 DynamicVisaData visa-box">
                        <div class="row VisaItem" data-target="BaseVisaDataDiv">
                            <div class="form-group col-sm-3">
                                <label>نوع ویزا</label>
                                <select class="form-control" data-field="visaTypeID" name="VisaData[0][visaTypeID]">
                                    <option value="">انتخاب نوع ویزا</option>
                                    {foreach $visaTypeList as $each}
                                        <option value="{$each.id}">{$each.title}</option>
                                    {/foreach} </select></div>
                            <div class="form-group col-sm-4"><label>حداکثر اقامت</label> <input {$disabledStatus}
                                        type="text" class="form-control" data-field="maximumNation"
                                        name="VisaData[0][maximumNation]" placeholder="حداکثر اقامت را وارد نمائید"
                                        value=""></div>
                            <div class="form-group col-sm-3"><label>تعداد دفعات مجاز به استفاده</label> <input
                                        type="text" class="form-control" data-field="allowedUseNo"
                                        name="VisaData[0][allowedUseNo]"></div>
                            <div class="form-group col-sm-2 d-flex flex-column"><label>&nbsp;</label>
                                <div class="d-flex mt-4">
                                    <button type="button" class="btn btn-success mr-1" onclick="addVisaData()"><span
                                                class="fa fa-plus"></span></button>
                                    <button type="button" class="btn btn-danger" onclick="removeVisaData($(this))"><span
                                                class="fa fa-remove"></span></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--                    <div class="form-group col-sm-3">
                        <label for="visaTypeID" class="control-label">نوع ویزا</label>
                        <select class="form-control select2" id="visaTypeID" name="visaTypeID[]">
                            <option>لطفا نوع ویزا را انتخاب نمایید</option>
                            {foreach $visaTypeList as $each}
                                <option value="{$each.id}">{$each.title}</option>
                            {/foreach}
                        </select>
                    </div>-->


                    <div class="form-group col-sm-4">
                        <label for="mainCost" class="control-label">قیمت ویزا</label>
                        <input type="text" class="form-control" id="mainCost" name="mainCost[]"
                               placeholder="قیمت ویزا را وارد نمائید"  onkeyup="javascript:separator(this);">
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="visaTypeID" class="control-label">نوع ارز</label>
                        <select class="form-control select2" id="currencyType" name="currencyType[]">
                            <option value="0">ریال</option>
                            {*                            {foreach key=key item=item from=$objCurrencyList->CurrencyList()}*}
                            {*                                {if $item.IsEnable eq 'Enable'}*}
                            {*                                    <option value="{$item.CurrencyCode}">{$item.CurrencyTitle}</option>*}
                            {*                                {/if}*}
                            {*                            {/foreach}*}

                            {foreach key=key item=item from=$objCurrencyEquivalent->ListCurrencyEquivalentAdmin()}
                                <option value="{$item.CurrencyCode}" >{$item.CurrencyTitle} </option>
                                {*                                ({$item.EqAmount})*}
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="prePaymentCost" class="control-label">پیش پرداخت (ریال)</label>
                        <input type="text" class="form-control" id="prePaymentCost" name="prePaymentCost[]"
                               placeholder="پیش پرداخت را وارد نمائید" onkeyup="javascript:separator(this);">
                    </div>





                    <div class="form-group col-sm-4 ">
                        <label for="deadline" class="control-label">زمان پردازش ویزا</label>
                        <input type="text" class="form-control" id="deadline" name="deadline[]"
                               placeholder="زمان پردازش ویزا را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-4 ">
                        <label for="validityDuration" class="control-label">مدت اعتبار</label>
                        <input type="text" class="form-control" id="validityDuration" name="validityDuration[]"
                               placeholder="مدت اعتبار را وارد نمائید">
                    </div>
                    <!--                    <div class="form-group col-sm-4 ">
                                            <label for="maximumNation" class="control-label">حداکثر اقامت</label>
                                            <input type="text" class="form-control" id="maximumNation" name="maximumNation"
                                                   placeholder="حداکثر اقامت را وارد نمائید">
                                        </div>-->
                    <!--                    <div class="form-group col-sm-4 ">
                                            <label for="allowedUseNo" class="control-label">تعداد دفعات مجاز به استفاده</label>
                                            <input type="text" class="form-control" id="allowedUseNo" name="allowedUseNo[]"
                                                   placeholder="تعداد دفعات مجاز را وارد نمائید">
                                        </div>-->


                    <div class="form-group col-sm-12">
                        <label for="allowedUseNo" class="control-label">فایل ضمیمه</label>
                        <div class="w-100 d-flex flex-wrap" style="row-gap: 23px;">
                            <div onclick="addCustomFile($(this))"
                                 class="align-items-center col-md-3 plus-btn d-flex flex-wrap justify-content-center dashed-3 site-border-main-color">
                                <div class="form-group align-items-center d-flex m-0 flex-wrap justify-content-center w-100">
                                    <label for="custom_file_field" class="m-0">+</label>
                                </div>
                            </div>
                        </div>


                    </div>


                    <div class="form-group col-sm-3">
                        <label for="cover_image" class="control-label">تصویر شاخص</label>

                        <div class="upload-box">
                            <input type="file"
                                   class="file-input"
                                   name="cover_image"
                                   id="cover_image"
                                   accept="image/*">
                            <span class="upload-text">+</span>
                            <img id="imagePreview" class="image-preview" />
                        </div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="price_table" class="control-label price_table">قیمت</label>
                        <textarea class="ckeditor" id="price_table" name="price_table"></textarea>
                    </div>

                    <div class="form-group col-sm-12 d-none">
                        <label for="documents" class="control-label">مدارک</label>
                        <textarea class="setToEditor" id="documents" name="documents"></textarea>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="descriptions" class="control-label">توضیحات</label>
                        <textarea class="ckeditor descriptions" id="descriptions" name="descriptions"></textarea>
                    </div>


{*                    <div class="form-group col-sm-12">*}
{*                        <label for="descriptions" class="control-label">توضیحات</label>*}
{*                        <textarea class="ckeditor form-control" id="descriptions" name="descriptions"></textarea>*}
{*                    </div>*}


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
<script>
   $('#visaAdd, #visaEdit .submitForEditor').click(function () {
      if (tinyMCE) {
         tinyMCE.triggerSave();
      }
      if (CKEDITOR.instances['descriptions']) {
         CKEDITOR.instances['descriptions'].updateElement();
      }
      if (CKEDITOR.instances['price_table']) {
         CKEDITOR.instances['price_table'].updateElement();
      }
   });
</script>
