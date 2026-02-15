{load_presentation_object filename="rentCar" assign="objCar"}
{assign var="info_car" value=$objCar->getRentCar($smarty.get.id)}
{assign var="list_car_cat" value=$objCar->listCategory()}
{assign var="catId" value=$info_car['cat_id']}
{assign var="info_car_category" value=$objCar->getCategory($catId)}

{assign var="list_brand" value=$objCar->listBrands()}

{assign var="list_parameter_cat" value=$objCar->listParameterCar()}
{assign var="list_parameter_item" value=$objCar->listParameterItem($smarty.get.id)}

{*{$list_parameter_item|var_dump}*}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">

                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/rentCar/catList">
                        لیست دسته بندی ها
                    </a>
                </li>
                {if $catId}
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/rentCar/carList&catId={$catId}">
                        {$info_car_category['title']}
                    </a>
                </li>
                {/if}
                <li class='active'>
                    ویرایش
                    <span class='font-bold underdash'>{$info_car['title']}</span>
                </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <form data-toggle="validator" id="edit_car" method="post"  enctype="multipart/form-data">
            <input type='hidden' value='updateRentCar' id='method' name='method'>
            <input type='hidden' value='rentCar' id='className' name='className'>
            <input type='hidden' value='{$info_car['id']}' id='id' name='id'>
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">

                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>ویرایش خودرو  {$info_car['title']} </h4>
                        </div>

{*                        <hr class='m-0 mb-4 w-100'>*}

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="title">نام خودرو </label>
                                <input type="text" class="form-control" name="title" id="title" value='{$info_car['title']}'
                                       placeholder="از این قسمت می توانید نام خودرو را تغییر دهید">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="code">کد </label>
                                <input type="text" class="form-control" name="code" id="code" value='{$info_car['code']}'
                                       placeholder="از این قسمت می توانید کد خودرو را تغییر دهید">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="price_customer">قیمت مشتری (ریال) </label>
                                <input type="text" class="form-control" name="price_customer" id="price_customer" value='{$info_car['price_customer']}'
                                       placeholder="از این قسمت می توانید قیمت مشتری را تغییر دهید">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="price_colleague">قیمت همکار (ریال) </label>
                                <input type="text" class="form-control" name="price_colleague" id="price_colleague" value='{$info_car['price_colleague']}'
                                       placeholder="از این قسمت می توانید قیمت همکار را تغییر دهید">
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group ">
                                <label for="type_vehicle" class="control-label">انتخاب دسته بندی خودرو</label>
                                <select name="catId" id="catId" class="form-control">
                                    <option value="">انتخاب کنید....</option>
                                    {foreach $list_car_cat as $key => $value}
                                        <option value="{$value.id}" {if $info_car['cat_id']==$value['id']} selected {/if}>{$value['title']}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group ">
                                <label for="brandId" class="control-label">انتخاب برند</label>
                                <select name="brandId" id="brandId" class="form-control">
                                    <option value="">انتخاب کنید....</option>
                                    {foreach $list_brand as $key => $value}
                                        <option value="{$value.id}">{$value['title']}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="content" class="control-label">توضیحات کوتاه</label>
                                <textarea id="content" name="content" maxlength='250' class="form-control" rows='4'
                                          placeholder="توضیحات کوتاه را وارد نمائید">{$info_car['content']}</textarea>
                            </div>
                        </div>


                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="description" class="control-label">توضیحات </label>
                                <textarea id="description" name="description" class="form-control" rows='4'
                                          placeholder="توضیحات را وارد نمائید">{$info_car['description']}</textarea>
                            </div>
                        </div>




                        <div class="form-group col-sm-12 has-success">
                            <div class="row">

                                <div class="form-group col-sm-12 DynamicRentCar has-success">



                                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>مشخصات خودرو</h4>
                                        </div>
                                        <hr class='m-0 mb-4 w-100'>

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="row">

                                                <div class="form-group col-sm-12 DynamicAddedItem">





                                                    {assign var="counter" value='0'}
                                                    {foreach key=key item=item from=$list_parameter_item}
                                                        <div data-target="BaseAddedItemDiv" class="col-sm-12 p-0 form-group">
                                                            <div class="col-md-3 pr-0">
                                                                <select data-parent="AddedItemValues1" data-target="parameter_cat" class="form-control" name="AddedItem[{$counter}][parameter_cat]" aria-invalid="false">
                                                                    <option>انتخاب کنید</option>
                                                                    {foreach $list_parameter_cat as $key => $value}
                                                                        <option value="{$value.id}" {if $item.parameter_cat==$value.id} selected {/if}>{$value['title']}</option>
                                                                    {/foreach}
                                                                </select>
                                                                <input data-parent="RentCarValuesHasId" data-target="hasId" name="AddedItem[{$counter}][hasId]" value="{$item.id}" type="hidden">

                                                            </div>
                                                            <div class="col-md-3 pr-0">
                                                                <input data-parent="AddedItemValues2" data-target="question"
                                                                       name="AddedItem[{$counter}][question]" placeholder="سوال"
                                                                       class="form-control"
                                                                       value="{$item.question}" type="text">
                                                            </div>
                                                            <div class="col-md-3 pr-0">
                                                                <input data-parent="AddedItemValues3" data-target="answer"
                                                                       name="AddedItem[{$counter}][answer]" placeholder="پاسخ"
                                                                       class="form-control"
                                                                       value="{$item.answer}" type="text">
                                                            </div>
                                                            <div class="col-md-2 d-flex gap-10 p-0">
{*                                                                <div class="col-md-6 p-0">*}
{*                                                                    <button type="button" onclick="AddAddedItem()"*}
{*                                                                            class="btn rounded form-control btn-success">*}
{*                                                                        <span class="fa fa-plus"></span>*}
{*                                                                    </button>*}
{*                                                                </div>*}
                                                                <div class="col-md-6 p-0">
                                                                    <button onclick="deleteParameterItem({$item.id})" type="button"
                                                                            class="btn rounded form-control btn-danger">
                                                                        <span class="fa fa-remove"></span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {assign var="counter" value=$counter+1}
                                                    {/foreach}
                                                    <div data-target="BaseAddedItemDiv" class="col-sm-12 p-0 form-group">
                                                        <div class="col-md-3 pr-0">
                                                            <select data-parent="AddedItemValues1" data-target="parameter_cat" class="form-control"  aria-invalid="false">
                                                                <option>انتخاب کنید</option>
                                                                {foreach $list_parameter_cat as $key => $value}
                                                                    <option value="{$value.id}">{$value['title']}</option>
                                                                {/foreach}
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 pr-0">
                                                            <input data-parent="AddedItemValues2" data-target="question"
                                                                   placeholder="سوال"
                                                                   class="form-control"
                                                                   type="text">
                                                        </div>
                                                        <div class="col-md-3 pr-0">
                                                            <input data-parent="AddedItemValues3" data-target="answer"
                                                                   placeholder="پاسخ"
                                                                   class="form-control"
                                                                   type="text">
                                                        </div>
                                                        <div class="col-md-2 d-flex gap-10 p-0">
                                                            <div class="col-md-6 p-0">
                                                                <button type="button" onclick="AddAddedItem()"
                                                                        class="btn rounded form-control btn-success">
                                                                    <span class="fa fa-plus"></span>
                                                                </button>
                                                            </div>
                                                            <div class="col-md-6 p-0">
                                                                <button onclick="RemoveAddedItem($(this))" type="button"
                                                                        class="btn rounded form-control btn-danger">
                                                                    <span class="fa fa-remove"></span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>

                        </div>







                    </div>

                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">


                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='align-items-center d-flex flex-wrap font-bold gap-10 m-0 px-4 py-3'>
                                تصویر شاخص
                            </h4>
                            <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                  data-toggle="tooltip" data-placement="top" title=""
                                  data-original-title=" تصویر اصلی این خودرو"></span>
                        </div>


                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group selected_image">
                                <label for="pic">تصویر شاخص </label>
                                <input type="file" class="form-control-file dropify" name="pic"
                                       id="pic"
                                       data-default-file="{$info_car.pic_show}">

                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="alt_pic">تگ alt</label>
                                <input type="text" class="form-control w-100" name="alt_pic"
                                       id="alt_pic"
                                       value="{$info_car.alt_pic}">

                            </div>
                        </div>


                    </div>


                    <div class=" d-flex bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='align-items-center d-flex flex-wrap font-bold gap-10 m-0 px-4 py-3'>
                                آپلود تصاویر ( گالری )
                            </h4>
                            <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                  data-toggle="tooltip" data-placement="top" title=""
                                  data-original-title="تصاویر خود را انتخاب یا در کادر بکشید"></span>
                        </div>


                        <hr class='m-0 mb-4 w-100'>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for='gallery_files'
                                   id="drop_zone"
                                   class='d-flex flex-wrap justify-content-center align-items-center border-dashed border-primary p-5 w-100'
                                   ondrop="dropHandler(event,true);"
                                   ondragover="dragOverHandler(event);">
                                <p>تصاویر خود را انتخاب یا در کادر بکشید</p>
                            </label>
                        </div>


                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="d-flex flex-wrap form-group gap-5 w-100">
                                <label for="gallery_files" class="control-label d-none">انتخاب فایل ها</label>
                                <input onchange="dropHandler(event,true)" type='file' accept="image/*,pdf"
                                       class=' d-none'
                                       multiple name='gallery_files[]' id='gallery_files'>

                                <div id='preview-gallery'></div>
                            </div>
                        </div>

                        {if isset($info_car['gallery'])}
                            <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                                <h4 class='align-items-center d-flex flex-wrap font-bold gap-10 m-0 px-4 py-3'>
                                    گالری
                                </h4>
                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title="نمایش گالری عکس ها "></span>
                            </div>
                            <hr class='m-0 mb-4 w-100'>
                            <div class='d-flex flex-wrap gap-10 justify-content-center p-10 w-100'>

                                {foreach $info_car['gallery'] as $key=>$file}
                                    <div class="align-items-center flex-wrap dropzone-parent-box d-flex justify-content-between p-3 pip rounded-xl w-100 ">


                                        <img class="border d-flex imageThumb rounded-xl w-25"
                                             src='{$file['src']}'
                                             title="">

                                        <div class='dropzone-parent-trash-shakkhes'>
                                            <button class='dropzone-btn-trash remove text-danger'
                                                    type='button'
                                                    onclick='SubmitRemoveArticleGallery("{$file['id']}",$(this))'
                                                    data-index="0" >
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                حذف
                                            </button>
                                            <div class='dropzone-radio-shakhes'>
                                                <label for='previous_gallery_selected{$file['id']}'>
                                                    تنظیم بعنوان شاخص
                                                </label>
                                                <input onchange='setAsSelectedGallery("{$file['src']}")' name='previous_gallery_selected'
                                                       id='previous_gallery_selected{$file['id']}'
                                                       value='{$file['id']}' type='radio'/>
                                            </div>
                                        </div>


                                        <div class='dropzone-parent-alt mt-5'>
                                            <label class='col-lg-3' for='previous_gallery_file_alts[{$file['id']}]'>
                                                متن Alt
                                            </label>
                                            <input placeholder="alt"
                                                   name="previous_gallery_file_alts[{$file['id']}]"
                                                   id="previous_gallery_file_alts[{$file['id']}]"
                                                   value="{$file['alt']}"
                                                   class="col-lg-9 dropzone-input-alt  pb-2 small text-center  text-muted  ">
                                        </div>

                                    </div>
                                {/foreach}
                            </div>
                        {/if}

                    </div>




                </div>
            </div>

            <div class='col-12 d-flex align-items-center justify-content-center w-100 parentbtn-btn-fixed'>
                <button class="btn btn-success btn-block btn-fixed" type="submit">ذخیره</button>
            </div>
        </form>
    </div>
</div>


<script type="text/javascript" src="assets/JsFiles/rentCar.js"></script>

<script>
  function uploadFile() {
    $(".show-pic-upload").hide();  // To hide
    $(".show-pic").show();  // To show
  }
</script>

