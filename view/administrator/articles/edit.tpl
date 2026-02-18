{load_presentation_object filename="articles" assign="articles"}
{assign var="getServices" value=$articles->getServices()}
{assign var="section" value=$smarty.get.section}

{if !isset($smarty.get.id)}
    {header("Location: {$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/articles/list")}
{/if}
{assign var="article" value=$articles->getArticle($smarty.get.id)}
{if !$article}
    {header("Location: {$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/articles/list")}
{/if}
{*<code>{$getServices['Public']|json_encode}</code>*}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">

                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/articles/list?section={$article['section']}">
                        لیست مقالات
                    </a>
                </li>
                <li class='active'>
                    ویرایش
                    <span class='font-bold underdash'>{$article['title']}</span>
                </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <form data-toggle="validator" method="post" id="editArticle" enctype='multipart/form-data'>
            <input type="hidden" name="className" value="articles">
            <input type="hidden" name="method" value="UpdateArticle">
            <input type="hidden" name="article_id" value="{$article.id}">
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
                                       placeholder="بهترین مکان های گردشگری | نام آژانس"
                                       value="{$article.title}">
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="heading">عنوان H1</label>
                                <input type="text" class="form-control" name="heading" id="heading"
                                       placeholder="بهترین مکان های گردشگری"
                                       value="{$article.heading}">
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
                                           value='{$smarty.const.CLIENT_DOMAIN}/gds/{$article['section']}/'>
                                    <input type="text" class="form-control"
                                           value="{$article.slug}"
                                           name="slug" id="slug" placeholder="آدرس صفحه">
                                </div>
                                <a href='http://{$smarty.const.CLIENT_DOMAIN}/gds/{$article['section']}/{$article.slug}'>
                                    http://{$smarty.const.CLIENT_DOMAIN}/gds/{$article['section']}/{$article.slug}
                                </a>
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
                                              placeholder="متن مربوطه">{$article.lead}</textarea>
                                </div>
                            </div>
                        {/if}

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="content">متن مقاله</label>
                                <textarea name="content" id="content" class="form-control"
                                          placeholder="محتوای مطلب">{$article.content}</textarea>
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


                                    {assign var="AddedMeta" value=$article['meta_tags']}

                                    {if $AddedMeta eq '' || !$AddedMeta}
                                        {assign var="AddedMeta" value=[['name'=>'','content'=>'']]}
                                    {/if}

                                    {assign var="counter" value='0'}
                                    {foreach key=key item=item from=$AddedMeta}
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


                    {if $article['section'] eq 'mag'}

                        {include file="{$smarty.const.FRONT_CURRENT_ADMIN}/modules/position/edit.tpl"
                        item=$article object=$articles}


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
                                <select name="language" class="form-control" id="language">
                                    {foreach $languages as $value=>$title}
                                        <option value="{$value}" {if $article['language'] == $value} selected{/if}>{$title}</option>
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

                        {if isset($article['gallery'])}
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

                                {foreach $article['gallery'] as $key=>$file}
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
                                {if $article.feature_image}
                                    <a  data-id="{$article.id}"  class='btn btn-primary delete-fara deleteArticleImage' style='float: left'>
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                        حذف تصویر
                                    </a>
                                {/if}
                                <input type="file" class="form-control-file dropify" name="feature_image"
                                       id="feature_image"
                                       data-default-file="{$article.image}">


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





                    {if isset($article['categories'])}



                        {foreach $article['categories'] as $key=>$category}
                            <div {if $key == 0 } data-name="category" {else} data-name='added-category' {/if}
                                    class="bg-white d-flex flex-wrap rounded w-100 ">


                                <div aria-expanded="false"
                                     role="button"
                                     data-target="#collapseCategory{$key+1}"
                                     aria-controls="collapseCategory{$key+1}"
                                     data-toggle="collapse"
                                     class='d-flex justify-content-between align-content-center flex-wrap w-100'>


                                    <h4 class='align-items-center d-flex flex-wrap font-bold gap-10 m-0 px-4 py-3 {if $key != 0}  w-100 justify-content-between {/if}'>
                                        {if $key == 0}
                                            <span>
                                                دسته بندی 1
                                                <span class='fa '></span>
                                            </span>
                                        {else}
                                            <span>
                                            دسته بندی {$key+1}
                                                <span class='fa '></span>
                                            </span>
                                            <button onclick="removeCategory($(this))"
                                                    type="button"
                                                    class="btn btn-danger font-12 rounded p-1 gap-2">
                                                <span class="fa fa-trash"> </span> حذف
                                            </button>
                                        {/if}
                                    </h4>
                                    {if $key == 0}
                                        <div class="d-flex align-items-center">
                                                                                        <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                                                                              data-toggle="tooltip" data-placement="top" title=""
                                                                                              data-original-title="دسته بندی مقاله ی خود را انتخاب یا ایجاد کنید"></span>
                                            <button onclick="removeCategory($(this))" type="button"
                                                    class="btn btn-danger font-12 rounded p-1 gap-2 d-block ml-4">
                                                <span class="fa fa-trash"></span>
                                                حذف
                                            </button>

                                        </div>
                                    {/if}
                                </div>
                                <div class="collapse w-100" id="collapseCategory{$key+1}">
                                    <hr class='m-0 mb-4 w-100'>
                                    <div class="parent-input">
                                        <input type='hidden' value='{$category['id']}' name='selected_category[]'>

                                        <div class='d-flex flex-wrap w-100 flex-column-reverse'>

                                            {include file="{$smarty.const.FRONT_CURRENT_ADMIN}/articles/edit_category.tpl" key=0 categories_count=count($article['categories']) category=$category}

                                        </div>


                                        <div data-name='add-more-categories'
                                             class="align-items-center border-primary d-flex flex-wrap font-bold gap-10 justify-content-center rounded w-100 h-160">
                                            <button onclick='addMoreCategories($(this))' type='button'
                                                    class='btn btn-default rounded btn-new-style d-flex flex-wrap gap-8'>
                                                <span class='fa fa-plus-circle font20'></span>
                                                ثبت زیرمجموعه
                                            </button>
                                        </div>
                                    </div>
                                    <hr class=' w-100'>
                                </div>
                            </div>
                        {/foreach}
                    {else}
                        <div data-name="category" class="bg-white d-flex flex-wrap rounded w-100 ">
                            <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>


                                <h4 class='align-items-center d-flex flex-wrap font-bold gap-10 m-0 px-4 py-3'>
                                    دسته بندی
                                </h4>

                                <div class="d-flex align-items-center">
                                    <button onclick="removeCategory($(this))" type="button"
                                            class="btn btn-danger font-12 rounded p-1 gap-2 d-none ml-3">
                                        <span class="fa fa-trash"></span>
                                        حذف
                                    </button>
                                    <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                          data-toggle="tooltip" data-placement="top" title=""
                                          data-original-title="دسته بندی مقاله ی خود را انتخاب یا ایجاد کنید"></span>
                                </div>

                            </div>


                            <hr class='m-0 mb-4 w-100'>


                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <input type='hidden' value='' name='selected_category[]'>

                                <div data-name='categories' class="form-group">
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
                                            class='btn btn-default rounded btn-new-style d-flex flex-wrap gap-8'>
                                        <span class='fa fa-plus-circle font20'></span>
                                        ثبت زیرمجموعه
                                    </button>
                                </div>
                            </div>


                            <hr class=' w-100'>


                        </div>
                    {/if}


                    <div data-name='add-more-category'
                         class="align-items-center   border-primary d-flex flex-wrap font-bold gap-10 justify-content-center rounded w-100 h-160">
                        <button onclick='addMoreCategorySection($(this))' type='button'
                                class='btn btn-default rounded d-flex btn-new-style flex-wrap gap-8'>
                            <span class='fa fa-plus-circle font20'></span>
                            نمایش در دسته بندی های دیگر
                        </button>
                    </div>


                </div>
            </div>
            <div class=' col-12 d-flex  align-items-center justify-content-center w-100 parentbtn-btn-fixed'>
                <button class="btn btn-success btn-block btn-fixed" type="submit">ذخیره</button>
            </div>
        </form>
    </div>
</div>
<script src="assets/js/dropzone.js"></script>
<script>

  $(document).ready(function() {
    setTimeout(function() {
      removeSelect2()
      initializeSelect2Search()
    }, 500)
  })
</script>
{*<script src="assets/js/jquery-dropzone.js"></script>

<script type="text/javascript">
    myDropzone.on('sending', function (file, xhr, formData) {
        formData.append('flag', 'insert_Gallery');
        formData.append('id', '{$EntertainmentData['id']}');
    });
    myDropzone.on("success", function(file, response) {
        GetEntertainmentGalleryData("{$EntertainmentData['id']}");

    });
    $(document).ready(function (){
        GetEntertainmentGalleryData("{$EntertainmentData['id']}");
    });
</script>*}

<script type="text/javascript" src="assets/JsFiles/articles.js"></script>
