{load_presentation_object filename="specialPages" assign="special_pages"}
{assign var="getLocation" value=$special_pages->getLocation()}
{assign var="getServices" value=$special_pages->getServices()}


{*<code>{$getServices['Public']|json_encode}</code>*}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">

                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">
                        خانه
                    </a>
                </li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/special_page/list">
                        صفحات ویژه
                    </a>
                </li>

                <li class="active">صفحه ی ویژه جدید</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <form data-toggle="validator" method="post" id="addSpecialPage" enctype='multipart/form-data'>
            <input type="hidden" name="className" value="specialPages">
            <input type="hidden" name="method" value="addSpecialPage">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">

                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='align-items-center d-flex flex-wrap font-bold gap-10 m-0 px-4 py-3'>
                                نحوه نمایش صفحه ویژه
                            </h4>

                            <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                  data-toggle="tooltip" data-placement="top" title=""
                                  data-original-title="مکان نمایش محتوای صفحه ویژه ی شما : در صفحه اصلی یا ایجاد صفحه مجزا"></span>

                        </div>

                        <hr class='m-0 mb-4 w-100'>

                        <div class="d-flex flex-wrap col-xs-12 p-30 gap-10">
                            <div class="plans w-100">


                                <div class="d-flex gap-10 w-100">
                                    <label class="plan basic-plan w-100 m-0" for="basic">
                                        <input checked type="radio" onchange='resetInsertToggle($(this));toggleable($(this));'
                                               value='separate'
                                               name="page_type"
                                               id="basic" />
                                        <div class="plan-content w-100">
                                            <img loading="lazy"
                                                 src="assets/images/git.png"
                                                 alt="" />
                                            <div class="plan-details">
                                                <span>مجزا</span>
                                                <p>ایجاد صفحه ی ویژه با آدرس مجزا</p>
                                            </div>
                                        </div>
                                    </label>

                                    <label class="plan complete-plan w-100 m-0" for="complete">
                                        <input type="radio" onchange='resetInsertToggle($(this));toggleable($(this))'
                                               id="complete"
                                               value='attach'
                                               name="page_type" />
                                        <div class="plan-content w-100">
                                            <img loading="lazy"
                                                 src="assets/images/link.png"
                                                 alt="" />
                                            <div class="plan-details">
                                                <span>وابسته</span>
                                                <p>
                                                    افزودن محتوا به یک صفحه ی خاص
                                                </p>
                                            </div>
                                        </div>
                                    </label>

                                </div>
                            </div>



                            <div class="attach-toggleable d-none plans w-100">


                                <div class="d-flex gap-10 w-100">
                                    <label class="plan basic-plan w-100 m-0" for="attach_type_main_page">
                                        <input checked type="radio" onchange='toggleable($(this))'
                                               value='main_page'
                                               name="attach_type"
                                               id="attach_type_main_page" />
                                        <div class="plan-content w-100">
                                            <img loading="lazy"
                                                 src="assets/images/homepage.png"
                                                 alt="" />
                                            <div class="plan-details">
                                                <span>صفحه اصلی</span>
                                                <p>ایجاد محتوا در صفحه اصلی وبسایت</p>
                                            </div>
                                        </div>
                                    </label>

                                    <label class="plan complete-plan w-100 m-0" for="attach_type_search_box">
                                        <input type="radio" onchange='toggleable($(this))'
                                               id="attach_type_search_box"
                                               value='search_box'
                                               name="attach_type" />
                                        <div class="plan-content w-100">
                                            <img loading="lazy"
                                                 src="assets/images/form.png"
                                                 alt="" />
                                            <div class="plan-details">
                                                <span>محتوای خدمات</span>
                                                <p>
                                                    نمایش محتوا در پایین شاخه های سرچ -باکس
                                                </p>
                                            </div>
                                        </div>
                                    </label>
                                    <label class="plan basic-plan w-100 m-0" for="attach_type_other_page">
                                        <input checked type="radio" onchange='toggleable($(this))'
                                               value='other_page'
                                               name="attach_type"
                                               id="attach_type_other_page" />
                                        <div class="plan-content w-100">
                                            <img loading="lazy"
                                                 src="assets/images/homepage.png"
                                                 alt="" />
                                            <div class="plan-details">
                                                <span>نمایش در صفحات جستجو</span>
                                                <p>ایجاد محتوا در جستجوی وبسایت</p>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>


                        </div>


                    </div>


                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>اطلاعات پایه</h4>
                        </div>

                        <hr class='m-0 mb-4 w-100'>

                        <div class="separate-toggleable plans w-100 ">


                            <div class="d-flex gap-10 w-100 border border-light p-4 align-items-center gap-10">
                                <div class='d-flex flex-wrap'>
                                    <input class="tgl tgl-ios"
                                           onchange='toggleable($(this))'
                                           name='has_search_box'
                                           id="has_search_box" type="checkbox"/>
                                    <label class="tgl-btn" for="has_search_box"></label>
                                </div>
                                <div class='d-flex flex-wrap'>
                                    <label for='has_search_box'>افزودن فرم جستجو ( سرچ باکس )</label>
                                </div>
                            </div>
                        </div>

                        <div class="attach-toggleable on-toggleable d-none flex-wrap py-4 w-100">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="search_box-toggleable on-toggleable d-none form-group">
                                    <label class="control-label" for="positions">سرویس</label>
                                    <select name="positions" id="positions"
                                            class="form-control select2">
                                        {foreach $getLocation as $service}
                                            <option value="{$service['MainService']}">{$service['Title']}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="separate-toggleable d-flex flex-wrap py-4 w-100">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group ">
                                    <label class="control-label" for="slug">
                                        آدرس صفحه
                                        <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                              data-toggle="tooltip" data-placement="left"
                                              title="عبارتی که در آدرس صفحه ی ویژه ایجاد میشود"></span>
                                    </label>
                                    <div class='align-items-center d-flex gap-10 justify-content-center dir-l'>
                                        <input type='text' class="form-control" disabled
                                               style='font-family: monospace;'
                                               value='{$smarty.const.CLIENT_DOMAIN}/gds/page/'>
                                        <input type="text" class="form-control"
                                               value=""
                                               name="slug" id="slug" placeholder="آدرس صفحه">
                                    </div>
                                </div>

                            </div>
                        </div>



                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="title">عنوان صفحه ویژه Title</label>
                                <input type="text" class="form-control" name="title" id="title"
                                       placeholder="روند مهاجرت در شش ماه | نام آژانس">
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="heading">عنوان صفحه ویژه H1</label>
                                <input type="text" class="form-control" name="heading" id="heading"
                                       placeholder="روند مهاجرت در شش ماه">
                            </div>
                        </div>


                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="description">متن کوتاه</label>
                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title="متن سئو، حداکثر ( 160 ) حرف"></span>
                                <textarea id='description' maxlength='160' name="description" class="form-control"
                                          placeholder="متن مربوطه"></textarea>
                            </div>
                        </div>


                        </div>

                    <div class="bg-white separate-toggleable d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>meta tag</h4>
                        </div>
                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">

                                <div class="form-group col-sm-12 DynamicAddedMeta">


                                    {assign var="AddedMeta" value=''}

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


                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>محتوای صفحه ی ویژه</h4>
                        </div>
                        <hr class='m-0 mb-4 w-100'>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="content">محتوای صفحه ی ویژه</label>
                                <textarea name="content" class="ckeditor form-control"
                                          placeholder="محتوا"></textarea>
                            </div>
                        </div>

                    </div>

                    <style>
                        .flex-column{
                            flex-direction: column;
                        }
                    </style>
                    <div class="attach-toggleable  on-toggleable d-flex flex-wrap  w-100 flex-column">

                        <div class="col-12">
                            <div class="bg-white d-flex flex-wrap rounded w-100  flex-column  other_page-toggleable  d-none  form-group">

                                {include file="{$smarty.const.FRONT_CURRENT_ADMIN}/modules/position/edit.tpl"
                                getServices=$getServices object=$special_pages}

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
                                زبان
                            </h4>
                            <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                  data-toggle="tooltip" data-placement="top" title=""
                                  data-original-title="نمایش سوالات متداول بر اساس زبان وبسایت شما"></span>
                        </div>


                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="language" class="control-label">زبان</label>
                                <select name="language" class="form-control" id="language">
                                    {foreach $languages as $value=>$title}
                                        <option value="{$value}">{$title}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>

                    </div>


                    <div class="search_box-toggleable on-toggleable d-none bg-white flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='align-items-center d-flex flex-wrap font-bold gap-10 m-0 px-4 py-3'>
                                تصویر شاخص
                            </h4>
                            <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                  data-toggle="tooltip" data-placement="top" title=""
                                  data-original-title="تصویر پشت سرچ باکس ( در صورت پشتیبانی طرح شما از تصویر پشت سرچ باکس )"></span>
                        </div>


                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group selected_image">
                                <label for="feature_image">تصویر شاخص </label>
                                <input type="file" class="form-control-file dropify" name="main_file"
                                       id="main_file"
                                       data-default-file="">

                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="feature_alt_image">تگ alt</label>
                                <input type="text" class="form-control w-100" name="main_file_alt"
                                       id="main_file_alt"
                                       value="">

                            </div>
                        </div>

                    </div>



                    <div class="separate-toggleable bg-white d-flex flex-wrap rounded w-100 ">
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
                                   ondragover="dragOverHandler(event,true);">
                                <p>تصاویر خود را انتخاب یا در کادر بکشید</p>
                            </label>
                        </div>


                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="d-flex flex-wrap form-group gap-5 w-100">
                                <label for="gallery_files" class="control-label d-none">انتخاب فایل ها</label>
                                <input onchange="dropHandler(event,true)" type='file' accept="image/*,pdf"
                                       class='d-none'
                                       multiple name='gallery_files[]' id='gallery_files'>

                                <div id='preview-gallery'></div>
                            </div>
                        </div>

                    </div>

                    <div class="separate-toggleable bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='align-items-center d-flex flex-wrap font-bold gap-10 m-0 px-4 py-3'>
                                فایل های ضمیمه
                            </h4>
                            <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                  data-toggle="tooltip" data-placement="top" title=""
                                  data-original-title="نمایش فایل های شما در انتهای صفحه ویژه"></span>
                        </div>


                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="attach_files" class="control-label">انتخاب فایل ها</label>
                                <input type='file' multiple name='attach_files[]' id='attach_files'>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
            <div class='col-12 d-flex align-items-center justify-content-center w-100 parentbtn-btn-fixed'>
                <button class="btn btn-success btn-block btn-fixed" type="submit">ذخیره</button>
            </div>
        </form>
    </div>
</div>


<script type="text/javascript" src="assets/JsFiles/special_page.js"></script>
<script src="assets/js/blog-jquery-dropzone.js"></script>
<script type="text/javascript" src="assets/modules/js/page_information/page_information_pages.js"></script>


<script type="text/javascript">

  /* function rebuildGallery(added_files) {
 const gallery_preview= $('#gallery_preview');
     gallery_preview.html('')
     added_files.forEach(function(item){

       gallery_preview.append('<img class="col-md-3" src="'+item.dataURL+'" />')

     })
   }*/

  let added_files = []
  myDropzone.on('thumbnail', function(file, dataURL) {

    console.log('file', file)
    added_files.push(file)


  })

  function setAsSelectedImage(_this, file_name) {
    const selectedImageName = $('input[name="selectedImageName"]')
    const selectedImageRow = $('input[name="selectedImageRow"]')

    $('#previews').find('.btn-actions').each(function() {
      $(this).find('.btn-primary').addClass('btn-outline')
    })
    _this.removeClass('btn-outline')
    selectedImageName.val(file_name)
  }

  $(document).ready(function() {

  })
</script>