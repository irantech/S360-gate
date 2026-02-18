{load_presentation_object filename="entertainment" assign="objEntertainment"}
{assign var="CorrectLevel" value=$smarty.get.level}
{if  $CorrectLevel == ''}
    {assign var="CorrectLevel" value='0'}
{/if}
{assign var="disabled" value=''}
{assign var="EntertainmentData" value=$objEntertainment->GetEntertainmentDataAdmin('','','','',$CorrectLevel,true)}
{assign var="EntertainmentAllTypeData" value=$objEntertainment->GetTypes()}
{assign var="EntertainmentTypeData" value=$objEntertainment->GetTypes($EntertainmentData['id'])}
{assign var="EntertainmentCategory" value=$objEntertainment->GetParentData('',$EntertainmentData['category_id'])}
{assign var="EntertainmentCategories" value=$objEntertainment->GetData('0')}
{assign var="EntertainmentSubCategories" value=$objEntertainment->GetData($EntertainmentCategory['CategoryId'])}
{assign var="EntertainmentSingleCategories" value=$objEntertainment->GetData('',$EntertainmentData['category_id'])}
{*{$EntertainmentData|var_dump}*}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/entertainment/main">تفریحات</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/entertainment/main&level={$EntertainmentCategory['CategoryId']}&deep=1">{$EntertainmentCategory['CategoryTitle']}</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/entertainment/EntertainmentList&level={$EntertainmentData['category_id']}">{$EntertainmentSingleCategories['CategoryTitle']}</a></li>

                <li class="active"><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/entertainment/EditEntertainment&level={$CorrectLevel}">ویرایش تفریح</a></li>


            </ol>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>

        <div class="row bg-title">
            <div class="col-lg-12">
                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/entertainment/ManageEntertainmentList"
                   class="btn btn-danger btn-outline waves-effect waves-light btn-xs">
                    <span class="btn-label ml-1 pl-2"><i class="fa fa-tags"></i></span>
                    لیست تفریحات</a>
                <a onclick="AddEntertainmentType(3)" data-toggle="modal" data-target="#ModalPublic"
                   class="btn btn-danger btn-outline waves-effect waves-light btn-xs">
                    <span class="btn-label ml-1 pl-2"><i class="fa fa-star"></i></span>
                    لیست ویژگی ها</a>
                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/entertainment/main"
                   class="btn btn-danger btn-outline waves-effect waves-light btn-xs">
                    <span class="btn-label ml-1 pl-2"><i class="fa fa-table"></i></span>
                    لیست دسته بندی</a>
            </div>
        </div>

        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">ویرایش تفریح </h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید تفریح مورد نظر را در سیستم ویرایش  نمائید</p>

                <form id="EditEntertainment" method="post">
                    <input type="hidden" name="flag" value="EditEntertainment">
                    <input type="hidden" name="id[]" value="{$CorrectLevel}">

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="title" class="control-label">نام تفریح</label>
                            <span class="star">*</span>
                            <input type="text" class="form-control" id="title" name="title[]"
                                   placeholder="نام تفریح را وارد نمائید"  value="{$EntertainmentData['title']}">
                        </div>
                        <div class="form-group col-sm-6 ">
                            <label for="title" class="control-label">نام انگلیسی تفریح</label>
                            <input type="text" class="form-control" id="title_en" name="title_en[]"
                                   placeholder="نام انگلیسی تفریح را وارد نمائید"  value="{$EntertainmentData['title_en']}">
                        </div>
                    </div>
                    <div class="col-12">
                        <h5 style="margin-bottom: 15px;">قیمت ها</h5>
                    </div>
                    <div class="row" style="border: 1px solid #ccc; padding: 15px; margin-top: 15px; border-radius: 5px; margin-bottom : 15px; background-color:#e6f0fa">
                        <div class="form-group col-sm-3">
                            <label for="price" class="control-label">قیمت مجزا تفریح</label>
                            <span class="star">*</span>
                            <input type="text" class="form-control" id="price" name="price[]"
                                   placeholder="قیمت را وارد نمائید"  value="{$EntertainmentData['price']}">

                        </div>
                        <div class="form-group col-sm-3">
                            <label for="currency_price" class="control-label">قیمت مجزای ارزی</label>
                            <input type="text" class="form-control" id="currency_price" name="currency_price[]"
                                   placeholder="قیمت ارزی را وارد نمائید"  value="{$EntertainmentData['currency_price']}">

                        </div>
                        {load_presentation_object filename="currencyEquivalent" assign="objCurrencyEquivalent"}

                        <div class="form-group col-sm-3">
                            <label for="EntertainmentCategory" class="control-label">نوع ارزی</label>
                            <select name="currency_type" id="currency_type" class="form-control ">
                                <option value="">انتخاب کنید....</option>
                                {foreach key=key item=item from=$objCurrencyEquivalent->ListCurrencyEquivalent()}
                                    <option value="{$item.CurrencyCode}" {if $item.CurrencyCode == $EntertainmentData['currency_type']} selected {/if}>{$item.CurrencyTitle}</option>
                                {/foreach}
                            </select>

                        </div>


                        <div class="form-group col-sm-3">
                            <label for="discount_price" class="control-label">تخفیف</label>
                            <input type="text" class="form-control" id="discount_price" name="discount_price[]"
                                   placeholder="قیمت را وارد نمائید"  value="{$EntertainmentData['discount_price']}">

                        </div>

                        <!-- قیمت‌های تفریح با تور -->
                        <div class="form-group col-sm-3">
                            <label for="tour_price" class="control-label">قیمت تفریح با تور</label>
                            <input type="text" class="form-control" id="tour_price" name="tour_price[]" placeholder="قیمت تور را وارد نمائید" value="{$EntertainmentData['tour_price']}">
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="tour_currency_price" class="control-label">قیمت تفریح با تور ارزی</label>
                            <input type="text" class="form-control" id="tour_currency_price" name="tour_currency_price[]"
                                   placeholder="قیمت ارزی را وارد نمائید"  value="{$EntertainmentData['tour_currency_price']}">
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="tour_currency_type" class="control-label">نوع ارز (با تور)</label>
                            <select name="tour_currency_type" id="tour_currency_type" class="form-control">
                                <option value="">انتخاب کنید....</option>
                                {foreach key=key item=item from=$objCurrencyEquivalent->ListCurrencyEquivalent()}
                                    <option value="{$item.CurrencyCode}" {if $item.CurrencyCode == $EntertainmentData['tour_currency_type']} selected {/if}>{$item.CurrencyTitle}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="tour_discount_price" class="control-label">تخفیف (با تور)</label>
                            <input type="text" class="form-control" id="tour_discount_price" name="tour_discount_price[]"
                                   placeholder="قیمت را وارد نمائید"  value="{$EntertainmentData['tour_discount_price']}">
                        </div>

                    </div>
                    <div class="row">

                        <div class="form-group col-sm-3">
                            <label for="EntertainmentCategory" class="control-label">عنوان مجموعه</label>
                            <select onchange="GetSubCategoriesOnSelectBox($(this))" class="form-control" name="" id="EntertainmentCategory">
                                {foreach key=key item=item from=$EntertainmentCategories}
                                    <option
                                            {if $item.CategoryId == $EntertainmentCategory['CategoryId']}
                                                selected
                                            {/if}
                                            value="{$item.CategoryId}">{$item.CategoryTitle}</option>
                                {/foreach}
                            </select>

                        </div>

                        <div class="form-group col-sm-3">
                            <label for="EntertainmentSubCategory" class="control-label">زیرمجموعه</label>
                            <span class="star">*</span>
                            <select class="form-control" name="category_id" id="EntertainmentSubCategory">
                                {foreach key=key item=item from=$EntertainmentSubCategories}
                                    <option
                                            {if $item.CategoryId == $EntertainmentData.CategoryId}
                                                selected
                                            {/if}
                                            value="{$item.CategoryId}-{$EntertainmentData['category_id']}">{$item.CategoryTitle}</option>
                                {/foreach}
                            </select>
                        </div>


                        <div class="form-group col-sm-3">
                            <label for="EntertainmentCountryTitle" class="control-label">کشور</label>
                            <span class="star">*</span>
                            <select onchange="getSelectBoxCities($(this).val())" class="form-control  "  name="EntertainmentCountryTitle[]" id="EntertainmentCountryTitle" >
                                {foreach key=key item=item from=$objEntertainment->getCountries(false)}
                                    <option {if $EntertainmentData['country_id'] == $item.id }selected{/if} value="{$item.id}">{$item.name}</option>
                                {/foreach}
                            </select>
                        </div>


                        <div class="form-group col-sm-3">
                            <label for="EntertainmentCityTitle" class="control-label">شهر</label>
                            <span class="star">*</span>
                            <select class="form-control  "  name="EntertainmentCityTitle[]" id="EntertainmentCityTitle" >
                                {foreach key=key item=item from=$objEntertainment->getCities(['country_id'=>$EntertainmentData['country_id'],'filter'=>false])}
                                    <option {if $EntertainmentData['city_id'] == $item.id }selected{/if} value="{$item.id}">{$item.name}</option>
                                {/foreach}
                            </select>
                        </div>


                        <div class="form-group col-sm-4">
                            <label for="EntertainmentTypes" class="control-label">ویژگی</label>
                            <select class="form-control " multiple="multiple" name="EntertainmentTypes[]" id="EntertainmentTypes" >
                                {foreach key=key item=item from=$EntertainmentAllTypeData}
                                    <option
                                            {if in_array($item.id,$EntertainmentTypeData)}
                                                selected
                                            {/if}
                                            value="{$item.id}">{$item.title}</option>
                                {/foreach}
                            </select>
                        </div>


                    </div>



                    <div class="row">

                        <div class="form-group col-sm-12 DynamicDataTable">
                            <span class="control-label mb-2 col-md-12 p-0">معرفی خدمات</span>
                            {assign var="counter" value='0'}
                            {foreach key=key item=item from=$EntertainmentData['datatable']|json_decode:true}

                            <div data-target="BaseDataTableDiv" class="col-sm-12 p-0 form-group">
                                <div class="col-md-3 pr-0">
                                    <input data-parent="DataTableValues" data-target="title" name="DataTable[{$counter}][title]" placeholder="عنوان" class="form-control"
                                           value="{$item.title}" type="text">
                                </div>
                                <div class="col-md-8">
                                    <input data-parent="DataTableValues" data-target="body" name="DataTable[{$counter}][body]" placeholder="متن نمایش" class="form-control"
                                           value="{$item.body}" type="text">
                                </div>
                                <div class="col-md-1 pl-0">
                                    <div class="col-md-6 p-0">
                                        <button type="button" onclick="AddDataTable()" class="btn form-control btn-success">
                                            <span class="fa fa-plus"></span>
                                        </button>
                                    </div>
                                    <div class="col-md-6 p-0">
                                        <button onclick="RemoveDataTable($(this))" type="button" class="btn form-control btn-danger">
                                            <span class="fa fa-remove"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                                {assign var="counter" value=$counter+1}
                            {/foreach}

                        </div>
                    </div>

                    <div class="row">

                        <div class="form-group col-sm-12">
                            <label for="description" class="control-label">توضیحات</label>
                            <span class="star">*</span>
                            <textarea  type="text" id="description" name="description[]" class="form-control ckeditor"{$disabled}>{$EntertainmentData['description'] nofilter}</textarea>
                        </div>
                    </div>

                    <div class="row">

                        <div class="form-group col-sm-12">
                            <label for="Video" class="control-label">ویدیو
                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title=" در این قسمت تنها لینک ویدئو را قرار دهید"></span>
                                {include file="{$smarty.const.FRONT_CURRENT_ADMIN}/modules/iframeLink.tpl"}
                            </label>
                            <input id="video" name="video[]" placeholder="ویدئو" class="form-control"
                                   value="{$EntertainmentData['video']}" type="text">
{*                            <textarea id="video" name="video[]" class="form-control">{$EntertainmentData['video']}</textarea>*}
                        </div>
                    </div>



                    <div class="row">

                        <div class="form-group col-lg-6 col-md-6 col-xs-6 col-sm-6">
                            <label for="pic" class="control-label">عکس شاخص</label>
                            <input type="file" name="picEntertainment" id="pic" class="dropify" data-height="100"
                                   data-default-file="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/entertainment/{$EntertainmentData['pic']}" >
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-xs-6 col-sm-6">
                            <label for="package" class="control-label">عکس پکیج</label>
                            <input type="file" name="package" id="package" class="dropify" data-height="100"
                                   data-default-file="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/entertainment/{$EntertainmentData['package']}"/>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <button type="submit" onclick="syncCKEditors()" class="btn btn-primary">ذخیره</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="assets/JsFiles/entertainment.js"></script>
<script type="text/javascript" src="assets/JsFiles/reservationBasicInformation.js"></script>
<script type="text/javascript" src="assets/JsFiles/reservationPublicFunctions.js"></script>
<script>
   function syncCKEditors() {
      for (let instance in CKEDITOR.instances) {
         CKEDITOR.instances[instance].updateElement();
      }
   }
</script>