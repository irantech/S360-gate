{load_presentation_object filename="articles" assign="articles"}
{assign var="getServices" value=$articles->getServices()}


{assign var="section" value=$smarty.get.section}

<link rel="stylesheet" src="assets/css/select2.css">

{*<code>{$getServices['Public']|json_encode}</code>*}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">

                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                {if $section eq 'mag'}
                    <li>
                        <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/articles/list?section={$section}">
                            لیست مقالات
                        </a>
                    </li>
                {else}
                    <li>
                        <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/articles/list?section={$section}">
                            لیست اخبار
                        </a>
                    </li>
                {/if}
                {if $section eq 'mag'}
                    <li class="active">درج مقاله ی جدید</li>
                {else}
                    <li class="active">درج خبر جدید</li>
                {/if}
            </ol>
        </div>
    </div>
    <div class="row">
        <form data-toggle="validator" method="post" id="insertNewArticle" enctype='multipart/form-data'>
            <input type="hidden" name="className" value="articles">
            <input type="hidden" name="method" value="InsertArticle">
            <input type="hidden" name="section" value="{$section}">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">


                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>اطلاعات پایه</h4>
                        </div>

                        <hr class='m-0 mb-4 w-100'>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="title">عنوان Title</label>
                                <input type="text" class="form-control" name="title" id="title"
                                       placeholder="بهترین مکان های گردشگری | نام آژانس">
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="heading">عنوان H1</label>
                                <input type="text" class="form-control" name="heading" id="heading"
                                       placeholder="بهترین مکان های گردشگری">
                            </div>
                        </div>


                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group ">
                                <label class="control-label" for="slug">
                                    آدرس صفحه
                                    <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                          data-toggle="tooltip" data-placement="left"
                                          title="عبارتی که در آدرس مقاله ایجاد میشود"></span>
                                </label>
                                <div class='align-items-center d-flex gap-10 justify-content-center dir-l'>
                                    <input type='text' class="form-control" disabled
                                           style='font-family: monospace;'
                                           value='{$smarty.const.CLIENT_DOMAIN}{if $section eq 'mag'}/gds/mag/{else}/gds/news/{/if}'>
                                    <input type="text" class="form-control"
                                           value=""
                                           name="slug" id="slug" placeholder="آدرس صفحه">
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="description">متن کوتاه</label>
                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title="متن سئو، حداکثر ( 160 ) حرف"></span>
                                <textarea id='description' maxlength='160' name="description" class="form-control"
                                          placeholder="متن مربوطه">{$article.description}</textarea>
                            </div>
                        </div>

                        {if $section eq 'news'}
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="lead">چکیده</label>
                                    <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                          data-toggle="tooltip" data-placement="top" title=""
                                          data-original-title="چکیده خبر، حداکثر ( 255 ) حرف"></span>
                                    <textarea id='description' maxlength='255' name="lead" class="form-control"
                                              placeholder="متن مربوطه"></textarea>
                                </div>
                            </div>
                            {/if}


                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="content">متن مقاله</label>
                                <textarea name="content" class="ckeditor form-control"
                                          placeholder="محتوای مطلب"></textarea>
                            </div>
                        </div>

                    </div>


                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>meta tag</h4>
                        </div>
                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">

                                <div class="form-group col-sm-12 DynamicAddedMeta">


                                    {assign var="AddedMeta" value=''}
                                    {if $AddedMeta eq ''}
                                        {assign var="AddedMeta" value='[{"name":"","content":""}]'}
                                    {/if}

                                    {assign var="counter" value='0'}
                                    {foreach key=key item=item from=$AddedMeta|json_decode:true}
                                        <div data-target="BaseAddedMetaDiv" class="col-sm-12 p-0 form-group">
                                            <div class="col-md-3 pr-0">
                                                <input data-parent="AddedMetaValues" data-target="name"
                                                       name="AddedMeta[{$counter}][name]" placeholder="name"
                                                       class="form-control"
                                                       value="{$item.name}" type="text">
                                            </div>
                                            <div class="col-md-7 pr-0">
                                                <input data-parent="AddedMetaValues" data-target="content"
                                                       name="AddedMeta[{$counter}][content]" placeholder="content"
                                                       class="form-control"
                                                       value="{$item.content}" type="text">
                                            </div>
                                            <div class="col-md-2 d-flex gap-10 p-0">
                                                <div class="col-md-6 p-0">
                                                    <button type="button" onclick="AddAddedMeta()"
                                                            class="btn rounded form-control btn-success">
                                                        <span class="fa fa-plus"></span>
                                                    </button>
                                                </div>
                                                <div class="col-md-6 p-0">
                                                    <button onclick="RemoveAddedMeta($(this))" type="button"
                                                            class="btn rounded form-control btn-danger">
                                                        <span class="fa fa-remove"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        {assign var="counter" value=$counter+1}
                                    {/foreach}

                                </div>
                            </div>
                        </div>
                    </div>


                    {if $section eq 'mag'}

                        {include file="{$smarty.const.FRONT_CURRENT_ADMIN}/modules/position/edit.tpl"
                        getServices=$getServices object=$articles}

                    {/if}


                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">

                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='align-items-center d-flex flex-wrap font-bold gap-10 m-0 px-4 py-3'>
                                زبان
                            </h4>
                            <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                  data-toggle="tooltip" data-placement="top" title=""
                                  data-original-title="نمایش مقاله بر اساس زبان وبسایت شما"></span>
                        </div>


                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="language" class="control-label">زبان</label>
                                <select name="language" class="form-control" id="language"
                                        onchange="getCategoryChange(this)">
                                    {foreach $languages as $value=>$title}
                                        <option value="{$value}">{$title}</option>
                                    {/foreach}
                                </select>
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


                    </div>


                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='align-items-center d-flex flex-wrap font-bold gap-10 m-0 px-4 py-3'>
                                تصویر شاخص
                            </h4>
                            <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                  data-toggle="tooltip" data-placement="top" title=""
                                  data-original-title=" تصویر اصلی این مقاله"></span>
                        </div>


                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group selected_image">
                                <label for="feature_image">تصویر شاخص </label>
                                <input type="file" class="form-control-file dropify" name="feature_image"
                                       id="feature_image"
                                       data-default-file="">
                            </div>
                        </div>


                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="feature_alt_image">تگ alt</label>
                                <input type="text" class="form-control w-100" name="feature_alt_image"
                                       id="feature_alt_image"
                                       value="{$article.feature_alt_image}">

                            </div>
                        </div>


                    </div>


                    <div data-name="category" class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>


                            <h4 class='align-items-center d-flex flex-wrap font-bold gap-10 m-0 px-4 py-3'>
                                    دسته بندی
                            </h4>
                            <div class="d-flex align-items-center">
                                                     <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title="دسته بندی مقاله ی خود را انتخاب یا ایجاد کنید"></span>
                            <button onclick="removeCategory($(this))" type="button"
                                    class="btn btn-danger font-12 rounded p-1 gap-2 d-none ml-4">
                                <span class="fa fa-trash"></span>
                                حذف
                            </button>

                            </div>
                        </div>


                        <hr class='m-0 mb-4 w-100'>


                        <div class="parent-input">
                            <input type='hidden' value='' name='selected_category[]'>

                            <div data-name='categories' class="form-group form-new">
                                <input type='text'
                                       data-name='categories1'
                                       oninput='searchCategory($(this))'
                                       autocomplete='off'
                                       value=''
                                       name='categories[]' class='form-control'>

                                <div data-name='result-box'
                                     class='select-categories d-none align-items-center border flex-wrap justify-content-center p-2 rounded'>
                                </div>
                            </div>

                            <div data-name='add-more-categories'
                                 class="align-items-center border-primary d-flex flex-wrap font-bold gap-10 justify-content-center rounded w-100 h-160">
                                <button onclick='addMoreCategories($(this))' type='button'
                                        class='btn btn-default rounded d-flex flex-wrap gap-8 btn-new-style'>
                                    <span class='fa fa-plus-circle font20'></span>
                                    ثبت زیرمجموعه
                                </button>
                            </div>
                        </div>


                        <hr class=' w-100'>


                    </div>


                    <div data-name='add-more-category'
                         class="align-items-center   border-primary d-flex flex-wrap font-bold gap-10 justify-content-center rounded w-100 h-160">
                        <button onclick='addMoreCategorySection($(this))' type='button'
                                class='btn btn-default rounded d-flex flex-wrap gap-8 btn-new-style'>
                            <span class='fa fa-plus-circle font20'></span>
                            نمایش در دسته بندی های دیگر
                        </button>
                    </div>


                </div>
            </div>
            {*            <input  type='hidden' name='lang_cat' id='lang_cat' value='fa'>*}
            <div class='col-12 d-flex align-items-center justify-content-center w-100 parentbtn-btn-fixed'>
                <button class="btn btn-success btn-block btn-fixed" type="submit">ذخیره</button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" src="assets/js/select2.min.js"></script>
<script type="text/javascript" src="assets/JsFiles/articles.js"></script>
   <script src="assets/js/mag-jquery-dropzone.js"></script>
<script type="text/javascript">



   function getCategoryChange(selectObject) {
      // alert(selectObject.value)
      var value = selectObject.value
      document.getElementById("lang_cat").value = value
      // console.log(value);
      alert(value)
   }

   /* function rebuildGallery(added_files) {
  const gallery_preview= $('#gallery_preview');
      gallery_preview.html('')
      added_files.forEach(function(item){

        gallery_preview.append('<img class="col-md-3" src="'+item.dataURL+'" />')

      })
    }*/

   let added_files = []
   myDropzone.on("thumbnail", function(file, dataURL) {

      console.log("file", file)
      added_files.push(file)


   })

   function setAsSelectedImage(_this, file_name) {
      const selectedImageName = $("input[name=\"selectedImageName\"]")
      const selectedImageRow = $("input[name=\"selectedImageRow\"]")

      $("#previews").find(".btn-actions").each(function() {
         $(this).find(".btn-primary").addClass("btn-outline")
      })
      _this.removeClass("btn-outline")
      selectedImageName.val(file_name)
   }

   $(document).ready(function() {

   })
</script>