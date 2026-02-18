{load_presentation_object filename="country" assign="objCountry"}
{*{load_presentation_object filename="currency" assign="objCurrencyList"}*}
{load_presentation_object filename="currencyEquivalent" assign="objCurrencyEquivalent"}
{load_presentation_object filename="visaRequestStatus" assign="objStatus"}
{load_presentation_object filename="visaCategory" assign="objVisaCategory"}
{assign var="statuses" value=$objStatus->getAll()}
{assign var="continents" value=$objCountry->continentsList()}
{load_presentation_object filename="visaType" assign="objVisaType"}
{assign var="visaTypeList" value=$objVisaType->allVisaTypeList()}
{load_presentation_object filename="visa" assign="objVisa"}
{assign var="visaInfo" value=$objVisa->getVisaByID($smarty.get.id)}
{assign var="getvisaDetail" value=$objVisa->getVisaDetail($smarty.get.id)}
{assign var="category" value=$objVisaCategory->getVisaCategoryById($visaInfo.category_id)}

{assign var="visaExpirationInfo" value=$objVisa->visaExpirationDiff($smarty.get.id)}

{assign var="selectedStatuses" value=$objVisa->getVisaStatuses($smarty.get.id)}

{assign var="visaContinent" value=$objCountry->getCountryByCode($visaInfo.countryCode)}
{assign var="visaCountries" value=$objCountry->reservationCountriesByContinentID($visaContinent.continentID)}


{if $visaInfo.agency_id == '0'}
    {assign var="disabledStatus" value=''}
{else}
    {assign var="disabledStatus" value='disabled'}
{/if}
{assign var="visaContinent" value=$objCountry->getCountryByCode($visaInfo.countryCode)}
{literal}
    <style>
    .visa-box {
        background: #f8f9fa;        /* خاکستری خیلی ملایم */
        border: 1px solid #dee2e6;  /* مرز ظریف */
        border-radius: 6px;
        padding: 15px;
        margin-bottom: 10px;
    }
    </style>
{/literal}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت ویزا رزرواسیون</li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/reservation/visaList"> لیست ویزا ها</a></li>
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

                <form data-toggle="validator" id="visaEdit" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="flag" value="visaEdit">
                    <input type="hidden" name="id" value="{$visaInfo.id}">
                    <input type="hidden" id="isEdit" value="1">
                    <div class="form-group col-sm-12 " >
                        <p>
                            نوع ویزا :

                            {$category.title}
                        </p>
                        <input type="hidden" name="visaCategory" value='{$category.id}'>
                    </div>

                    <div class="form-group col-sm-12 d-flex" style="flex-direction: row-reverse;justify-content: flex-end;">
                        <label for="OnlinePayment" class="control-label">درخواست مشتری به همراه پرداخت آنلاین</label>
                        <div style='margin-left: 10px;'>
                            <input {$disabledStatus} name="OnlinePayment" id="OnlinePayment" type="checkbox"
                                    {if $visaInfo.OnlinePayment == 'yes'} checked="checked" {/if}
                                   data-color="#99d683"
                                   data-secondary-color="#f96262" data-size="small"
                                   {if $item.isActive eq 'yes'}checked="checked"{/if} />
                        </div>
                    </div>

                    <div class="form-group col-sm-8 ">
                        <label for="title" class="control-label">عنوان ویزا </label>
                        <input {$disabledStatus} type="text" class="form-control" id="title" name="title" value="{$visaInfo.title}"
                               placeholder="عنوان ویزا را وارد نمائید">
                    </div>


                    <div class="form-group col-sm-6">
                        <label for="continent" class="control-label">قاره</label>
                        <select {$disabledStatus} class="form-control " id="continent" name="continent">
                            <option value="">لطفا قاره را انتخاب نمایید</option>
                            {foreach $continents as $each}
                                <option value="{$each.id}" {if $visaContinent.continentID eq $each.id}selected="selected"{/if}>{$each.titleFa}</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="countryCode" class="control-label">کشور</label>
                        <select {$disabledStatus} class="form-control " id="countryCode" name="countryCode">
                            {foreach $visaCountries as $eachCountry}
                                <option value="{$eachCountry.abbreviation}" {if $visaInfo.countryCode eq $eachCountry.abbreviation}selected="selected"{/if}>{$eachCountry.name}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="visa_statuses" class="control-label">وضعیت های پردازش ویزا </label> &nbsp; <a class="badge badge-xs badge-purple" target="_blank" href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/reservation/visaRequestStatusList">جدید</a>
                        <select name="visa_statuses[]" id="visa_statuses" class="form-control select2" multiple>
                            {foreach $statuses as $status}
                                <option value="{$status.id}" {if in_array($status.id, array_keys($selectedStatuses))}selected{/if}>{$status.title}</option>
                            {/foreach}
                        </select>

                    </div>
<!--                    <div class="form-group col-sm-3">
                        <label for="visaTypeID" class="control-label">نوع ویزا</label>
                        <select {$disabledStatus} class="form-control " id="visaTypeID" name="visaTypeID">
                            <option>لطفا نوع ویزا را انتخاب نمایید</option>
                            {foreach $visaTypeList as $each}
                                <option value="{$each.id}" {if $visaInfo.visaTypeID eq $each.id}selected="selected"{/if}>{$each.title}</option>
                            {/foreach}
                        </select>
                    </div>-->
                    <div class="form-group col-sm-12 DynamicVisaData visa-box">

                        {foreach $getvisaDetail as $index => $item}
                            <div class="row VisaItem" data-target="BaseVisaDataDiv">

                                <div class="form-group col-sm-3">
                                    <label>نوع ویزا</label>
                                    <select class="form-control"
                                            data-field="visaTypeID"
                                            name="VisaData[{$index}][visaTypeID]">
                                        <option value="">انتخاب نوع ویزا</option>
                                        {foreach $visaTypeList as $each}
                                            <option value="{$each.id}"
                                                    {if $each.id == $item.visa_type_id}selected{/if}>
                                                {$each.title}
                                            </option>
                                        {/foreach}
                                    </select>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label>حداکثر اقامت</label>
                                    <input type="text"
                                           class="form-control"
                                           data-field="maximumNation"
                                           name="VisaData[{$index}][maximumNation]"
                                           placeholder="حداکثر اقامت را وارد نمائید"
                                           value="{$item.maximum_nation}">
                                </div>

                                <div class="form-group col-sm-3">
                                    <label>تعداد دفعات مجاز به استفاده</label>
                                    <input type="text"
                                           class="form-control"
                                           data-field="allowedUseNo"
                                           name="VisaData[{$index}][allowedUseNo]"
                                           value="{$item.allowed_use_no}">
                                </div>

                                <div class="form-group col-sm-2 d-flex flex-column">
                                    <label>&nbsp;</label>
                                    <div class="d-flex mt-4">
                                        <button type="button"
                                                class="btn btn-success mr-1"
                                                onclick="addVisaData()">
                                            <span class="fa fa-plus"></span>
                                        </button>

                                        <button type="button"
                                                class="btn btn-danger"
                                                onclick="removeVisaData($(this))">
                                            <span class="fa fa-remove"></span>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        {/foreach}

                        {if !$getvisaDetail}
                            <!-- اگر چیزی از DB نبود، یک سطر خالی نمایش بده -->
                            <div class="row VisaItem" data-target="BaseVisaDataDiv">

                                <div class="form-group col-sm-3">
                                    <label>نوع ویزا</label>
                                    <select class="form-control"
                                            data-field="visaTypeID"
                                            name="VisaData[0][visaTypeID]">
                                        <option value="">انتخاب نوع ویزا</option>
                                        {foreach $visaTypeList as $each}
                                            <option value="{$each.id}">{$each.title}</option>
                                        {/foreach}
                                    </select>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label>حداکثر اقامت</label>
                                    <input type="text"
                                           class="form-control"
                                           data-field="maximumNation"
                                           name="VisaData[0][maximumNation]"
                                           placeholder="حداکثر اقامت را وارد نمائید">
                                </div>

                                <div class="form-group col-sm-3">
                                    <label>تعداد دفعات مجاز به استفاده</label>
                                    <input type="text"
                                           class="form-control"
                                           data-field="allowedUseNo"
                                           name="VisaData[0][allowedUseNo]">
                                </div>

                                <div class="form-group col-sm-2 d-flex flex-column">
                                    <label>&nbsp;</label>
                                    <div class="d-flex mt-4">
                                        <button type="button"
                                                class="btn btn-success mr-1"
                                                onclick="addVisaData()">
                                            <span class="fa fa-plus"></span>
                                        </button>

                                        <button type="button"
                                                class="btn btn-danger"
                                                onclick="removeVisaData($(this))">
                                            <span class="fa fa-remove"></span>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        {/if}

                    </div>




                    <div class="form-group col-sm-3 ">
                        <label for="mainCost" class="control-label">قیمت ویزا </label>
                        <input {$disabledStatus} type="text" class="form-control" id="mainCost" name="mainCost" onkeyup="javascript:separator(this);" value="{number_format($visaInfo.mainCost)}"
                               placeholder="قیمت ویزا را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-3 ">
                        <label for="prePaymentCost" class="control-label">پیش پرداخت (ریال)</label>
                        <input {$disabledStatus} type="text" class="form-control" id="prePaymentCost" name="prePaymentCost" value="{$visaInfo.prePaymentCost}"
                               placeholder="پیش پرداخت را وارد نمائید" onkeyup="javascript:separator(this);">
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="visaTypeID" class="control-label">نوع ارز</label>
                        <select {$disabledStatus} class="form-control " id="currencyType" name="currencyType">

                                <option {if $visaInfo.currencyType eq '0'} selected {/if}
                                         value="0">ریال</option>

{*                            {foreach key=key item=item from=$objCurrencyList->CurrencyList()}*}
{*                                {if $item.IsEnable eq 'Enable'}*}
{*                                    <option {if $visaInfo.currencyType eq $item.CurrencyCode} selected {/if}*}
{*                                            value="{$item.CurrencyCode}">{$item.CurrencyTitle}</option>*}
{*                                {/if}*}
{*                            {/foreach}*}

                            {foreach key=key item=item from=$objCurrencyEquivalent->ListCurrencyEquivalentAdmin()}
                                <option value="{$item.CurrencyCode}"  {if $visaInfo.currencyType eq $item.CurrencyCode} selected {/if}>{$item.CurrencyTitle} </option>
{*                                ({$item.EqAmount})*}
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-4 ">
                        <label for="maximumNation" class="control-label">حداکثر اقامت</label>
                        <input {$disabledStatus} type="text" class="form-control" id="maximumNation" name="maximumNation"
                                                 placeholder="حداکثر اقامت را وارد نمائید" value="{$visaInfo.maximumNation}">
                    </div>

                    {if $category.id eq 1 or $category_id eq 2}
                        <div class="form-group col-sm-6 ">
                        <label for="deadline" class="control-label">پلن</label>
                        <input {$disabledStatus} type="text"
                               title="{$visaExpirationInfo['result_message']['expired_at_fa']}"
                               class="form-control" id="deadline" name="deadline" value="{$visaExpirationInfo['result_message']['remainingTile']}"
                               placeholder="پلن">
                    </div>

                        <div class="form-group col-sm-6 ">
                        <label for="deadline" class="control-label">زمان پردازش ویزا</label>
                        <input {$disabledStatus} type="text" class="form-control" id="deadline" name="deadline" value="{$visaInfo.deadline}"
                               placeholder="زمان پردازش ویزا را وارد نمائید">
                    </div>

                        <div class="form-group col-sm-6 ">
                        <label for="validityDuration" class="control-label">مدت اعتبار</label>
                        <input {$disabledStatus} type="text" class="form-control" id="validityDuration" name="validityDuration" value="{$visaInfo.validityDuration}"
                               placeholder="مدت اعتبار را وارد نمائید">
                    </div>

<!--                        <div class="form-group col-sm-6 ">
                        <label for="allowedUseNo" class="control-label">تعداد دفعات مجاز به استفاده</label>
                        <input {$disabledStatus} type="text" class="form-control" id="allowedUseNo" name="allowedUseNo" value="{$visaInfo.allowedUseNo}"
                               placeholder="تعداد دفعات مجاز را وارد نمائید">
                    </div>-->
                    {/if}

                    <div class="form-group col-sm-12 ">
                        <label for="allowedUseNo" class="control-label">فایل ضمیمه</label>
                        <div class="w-100 d-flex flex-wrap" style="row-gap: 23px;">

                            {assign var="custom_file_fields" value=json_decode($visaInfo.custom_file_fields,true)}

                            {foreach $custom_file_fields as $key=>$item}
                                <div data-name="custom_file_fields" class="col-md-3 d-flex flex-wrap">
                                    <span class="fa fa-remove remove-btn" onclick="removeCustomFile($(this))"></span>
                                    <div class="form-group mb-0 w-100">
                                        <input {$disabledStatus} type="text"
                                               value="{$item}" placeholder="{$item}"
                                               class="form-control" name="custom_file_fields[]"
                                               id="custom_file_fields_{$key}">
                                    </div>
                                </div>
                            {/foreach}

                            <div onclick="addCustomFile($(this))" class="align-items-center col-md-3 plus-btn d-flex flex-wrap justify-content-center dashed-3 site-border-main-color">
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

                        <input type="hidden" name="old_cover_image" value="{$visaInfo.cover_image}">

                        <span class="upload-text">+</span>

                        {if $visaInfo.cover_image}
                            <img id="imagePreview"
                                 class="image-preview d-block"
                                 src="/gds/pic/{$visaInfo.cover_image}" />
                        {/if}
                    </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="price_table" class="control-label">قیمت</label>
                        <textarea class="price_table ckeditor" id="price_table" name="price_table">{$visaInfo.price_table}</textarea>
                    </div>
                    <div class="form-group col-sm-12 d-none">
                        <label for="documents" class="control-label">مدارک</label>
{*                        setToEditor*}
                        <textarea {$disabledStatus} class="price_table ckeditor form-control" id="documents" name="documents">{$visaInfo.documents}</textarea>
                    </div>
                    {*
                    <div class="form-group col-sm-12">
                        <label for="descriptions" class="control-label">توضیحات</label>
                        <textarea {$disabledStatus} class="ckeditor form-control" id="descriptions" name="descriptions">{$visaInfo.descriptions}</textarea>
                    </div>
                      *}

                    <div class="form-group col-sm-12">
                        <label for="descriptions" class="control-label">توضیحات</label>
                        <textarea class="ckeditor descriptions" id="descriptions" name="descriptions">{$visaInfo.descriptions}</textarea>
                    </div>

                    <div class="row  ">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <button  type="submit" class="btn btn-primary pull-right submitForEditor">ارسال اطلاعات</button>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <div class="form-group">
                                <span class="float-right">                                تایید ویزا :</span>

                                <a href="#">

                                    <div style='float: right;' onclick="visaValidate('{$visaInfo.id}'); return false;">
                                        <input type="checkbox" class="js-switch" data-color="#99d683"
                                               data-secondary-color="#f96262" data-size="small" {if $visaInfo.validate eq 'granted'}checked="checked"{/if} />
                                    </div>
                                </a>
                            </div>




                        </div>

                        <div class="form-group col-sm-12">
                            <label for="adminReview" class="control-label">یادداشت مدیریت : </label>
                            <textarea class="form-control"
                                      onchange="visaAdminReviewChange('{$visaInfo.id}',$(this).val())" id="adminReview" name="adminReview">{$visaInfo.adminReview|strip_tags}</textarea>
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