{load_presentation_object filename="entertainment" assign="objEntertainment"}
{assign var="CorrectLevel" value=$smarty.get.level}
{if $CorrectLevel == ''}
    {assign var="CorrectLevel" value='0'}
{/if}
{assign var="EntertainmentAllTypeData" value=$objEntertainment->GetTypes()}
{assign var="EntertainmentCategory" value=$objEntertainment->GetParentData('',$CorrectLevel)}
{assign var="EntertainmentCategories" value=$objEntertainment->GetData('0')}
{assign var="EntertainmentSubCategories" value=$objEntertainment->GetData($EntertainmentCategory['CategoryId'])}
{assign var="EntertainmentSingleCategories" value=$objEntertainment->GetData('',$CorrectLevel)}
{assign var="check_offline" value=$objFunctions->checkClientConfigurationAccess('offline_entertainment')}
{assign var="check_online" value=$objFunctions->checkClientConfigurationAccess('online_entertainment')}
{load_presentation_object filename="currencyEquivalent" assign="objCurrencyEquivalent"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/entertainment/main">تفریحات</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/entertainment/main&level={$EntertainmentCategory['CategoryId']}&deep=1">{$EntertainmentCategory['CategoryTitle']}</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/entertainment/EntertainmentList&level={$CorrectLevel}">{$EntertainmentSingleCategories['CategoryTitle']}</a></li>

                <li class="active"><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/entertainment/AddEntertainment&level={$CorrectLevel}"> تفریح جدید</a></li>


            </ol>
        </div>



        <div class="row bg-title">
            <div class="col-lg-12">
                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/entertainment/EntertainmentList"
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
                <h3 class="box-title m-b-0">ثبت تفریح </h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید تفریح مورد نظر را در سیستم ثبت  نمائید</p>

                <form id="AddEntertainment" method="post">
                    <input type="hidden" name="flag" value="AddEntertainment">
                    <input type="hidden" name="pageType" value="admin[]">
{*                    {if  $check_offline eq true}*}
{*                        <input type="hidden"  id="is_request" name="is_request[]" value="true">*}
{*                    {else}*}
{*                        <input type="hidden"  id="is_request" name="is_request[]" value="false">*}
{*                    {/if}*}

                    {if $check_offline eq true  && $check_online eq true}
                        <div class='d-flex'>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_request" id="isRequest1" checked value="false">
                                <label class="form-check-label mx-3" for="isRequest1">
                                   تفریحات آنلاین
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_request" id="isRequest2"  value="true">
                                <label class="form-check-label mx-3" for="isRequest2">
                                    تفریحات آفلاین
                                </label>
                            </div>
                        </div>
                    {elseif $check_offline eq true}
                        <input type="hidden"  id="is_request" name="is_request" value="true">
                    {else}
                        <input type="hidden"  id="is_request" name="is_request" value="false">
                    {/if}
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="title" class="control-label">نام تفریح</label>
                            <span class="star">*</span>
                            <input type="text" class="form-control" id="title" name="title[]" placeholder="نام تفریح را وارد نمائید">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="title_en" class="control-label">نام انگلیسی تفریح</label>
                            <input type="text" class="form-control" id="title_en" name="title_en[]" placeholder="نام انگلیسی تفریح را وارد نمائید">
                        </div>
                    </div>
                    <div class="col-12">
                        <h5 style="margin-bottom: 15px;">قیمت ها</h5>
                    </div>
                    <div class="row" style="border: 1px solid #ccc; padding: 15px; margin-top: 15px; border-radius: 5px; margin-bottom : 15px; background-color:#e6f0fa">
                            <!-- قیمت‌های مجزا تفریح -->
                            <div class="form-group col-sm-3">
                                <label for="price" class="control-label">قیمت مجزا تفریح</label>
                                <span class="star">*</span>
                                <input type="text" class="form-control" id="price" name="price[]" placeholder="قیمت را وارد نمائید">
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="currency_price" class="control-label">قیمت مجزای ارزی</label>
                                <input type="text" class="form-control" id="currency_price" name="currency_price[]" placeholder="قیمت را وارد نمائید">
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="currency_type" class="control-label">نوع ارز</label>
                                <select name="currency_type" id="currency_type" class="form-control">
                                    <option value="">انتخاب کنید....</option>
                                    {foreach key=key item=item from=$objCurrencyEquivalent->ListCurrencyEquivalent()}
                                        <option value="{$item.CurrencyCode}">{$item.CurrencyTitle}</option>
                                    {/foreach}
                                </select>
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="discount_price" class="control-label">تخفیف</label>
                                <input type="text" class="form-control" id="discount_price" name="discount_price[]" placeholder="تخفیف را وارد نمائید">
                            </div>

                            <!-- قیمت‌های تفریح با تور -->
                            <div class="form-group col-sm-3">
                                <label for="tour_price" class="control-label">قیمت تفریح با تور</label>
                                <input type="text" class="form-control" id="tour_price" name="tour_price[]" placeholder="قیمت تور را وارد نمائید">
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="tour_currency_price" class="control-label">قیمت تفریح با تور ارزی</label>
                                <input type="text" class="form-control" id="tour_currency_price" name="tour_currency_price[]" placeholder="قیمت تور را وارد نمائید">
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="tour_currency_type" class="control-label">نوع ارز (با تور)</label>
                                <select name="tour_currency_type" id="tour_currency_type" class="form-control">
                                    <option value="">انتخاب کنید....</option>
                                    {foreach key=key item=item from=$objCurrencyEquivalent->ListCurrencyEquivalent()}
                                        <option value="{$item.CurrencyCode}">{$item.CurrencyTitle}</option>
                                    {/foreach}
                                </select>
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="tour_discount_price" class="control-label">تخفیف (با تور)</label>
                                <input type="text" class="form-control" id="tour_discount_price" name="tour_discount_price[]" placeholder="تخفیف تور را وارد نمائید">
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
                            <select class="form-control" name="category_id[]" id="EntertainmentSubCategory">
                                {foreach key=key item=item from=$EntertainmentSubCategories}
                                    <option
                                            {if $item.CategoryId == $CorrectLevel}
                                                selected
                                            {/if}
                                            value="{$item.CategoryId}-{$CorrectLevel}">{$item.CategoryTitle}</option>
                                {/foreach}
                            </select>
                        </div>


                        <div class="form-group col-sm-3">
                            <label for="EntertainmentCountryTitle" class="control-label">کشور</label>
                            <span class="star">*</span>
                            <select onchange="getSelectBoxCities($(this).val())" class="form-control  "  name="EntertainmentCountryTitle[]" id="EntertainmentCountryTitle" >
                                <option value="">انتخاب کنید</option>
                                {foreach key=key item=item from=$objEntertainment->getCountries(false)}
                                    <option value="{$item.id}">{$item.name}</option>
                                {/foreach}
                            </select>
                        </div>


                        <div class="form-group col-sm-3">
                            <label for="EntertainmentCityTitle" class="control-label">شهر</label>
                            <span class="star">*</span>
                            <select class="form-control  "  name="EntertainmentCityTitle[]" id="EntertainmentCityTitle" >

                            </select>
                        </div>

                        <div class="form-group col-sm-4">
                            <label for="EntertainmentTypes" class="control-label">ویژگی</label>
                            <select class="form-control" multiple="multiple" name="EntertainmentTypes[]" id="EntertainmentTypes" >

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

                            <div data-target="BaseDataTableDiv" class="col-sm-12 p-0 form-group">
                                <div class="col-md-3 pr-0">
                                    <input data-parent="DataTableValues" data-target="title" name="DataTable[0][title]" placeholder="عنوان" class="form-control"
                                          type="text">
                                </div>
                                <div class="col-md-8">
                                    <input data-parent="DataTableValues" data-target="body" name="DataTable[0][body]" placeholder="متن نمایش" class="form-control"
                                          type="text">
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


                        </div>
                    </div>

                    <div class="row">

                        <div class="form-group col-sm-12">
                            <label for="description" class="control-label">توضیحات</label>
                            <textarea  type="text" id="description" name="description[]" class="form-control ckeditor"{$disabled}></textarea>
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
{*                            <textarea id="video" name="video[]" class="form-control"></textarea>*}
                            <input id="video"  name="video[]" placeholder="ویدئو" class="form-control"
                                    type="text">
                        </div>
                    </div>



                    <div class="row">

                        <div class="form-group col-lg-6 col-md-6 col-xs-6 col-sm-6">
                            <label for="pic" class="control-label">عکس شاخص</label>
                            <input type="file" name="picEntertainment" id="pic" class="dropify" data-height="100">
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-xs-6 col-sm-6">
                            <label for="package" class="control-label">عکس پکیج</label>
                            <input type="file" name="package" id="package" class="dropify" data-height="100">
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">ارسال اطلاعات</button>
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