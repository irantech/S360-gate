{load_presentation_object filename="recommendation" assign="recommendation"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/recommendation/list">
                        لیست سفرنامه ها
                    </a>
                </li>
                <li class="active">درج سفرنامه جدید</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <form data-toggle="validator" method="post" id="storeRecommendation" enctype='multipart/form-data'>
            <input type="hidden" name="className" value="recommendation">
            <input type="hidden" name="method" value="storeRecommendation">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">


                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>اطلاعات پایه</h4>
                        </div>
                        <hr class='m-0 mb-4 w-100'>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label class="control-label d-flex justify-content-between" for="user_information">
                                اطلاعات کابر
                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="left"
                                      title="اطلاعات مربوط به کاربر"></span>
                            </label>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="fullName">نام کاربر</label>
                                    <input type="text" class="form-control" name="fullName" id="fullName"
                                           placeholder="نام و نام خانوادگی کاربر">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="profession">سمت کاربر</label>
                                    <input type="text" class="form-control" name="profession" id="profession"
                                           placeholder="سمت کاربر">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="content">محتوای نظر کاربر</label>
                                <textarea name="content" class="ckeditor form-control"
                                          placeholder="محتوای مطلب"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group ">
                                <label class="control-label" for="slug">
                                    لینک ویدیو
                                    <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                          data-toggle="tooltip" data-placement="left"
                                          title="ویدیو شما شامل لینک آیفریم باشد."></span>
                                    {include file="{$smarty.const.FRONT_CURRENT_ADMIN}/modules/iframeLink.tpl"}
                                </label>
                                <div class='align-items-center d-flex gap-10 justify-content-center dir-l'>

                                    <textarea type="text" class="form-control" name="video_link"
                                              id="video_link" placeholder=" لینک آیفریم مورد نظر"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div data-name='service' class="bg-white d-flex flex-wrap rounded w-100 ">
                            <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                                <h4 class='align-items-center d-flex flex-wrap font-bold gap-10 m-0 px-4 py-3'>
                                    اطلاعات ویزای مربوطه
                                </h4>

                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title="نمایش در نتایج جستجو این اطلاعات"></span>

                            </div>

                            <hr class='m-0 mb-4 w-100'>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="continent">قاره</label>
                                    <select onchange='getCountries($(this))' name="continent" id="continent" class="form-control select2">
                                        <option value="">انتخاب کنید</option>
                                        {foreach $recommendation->getContinentList() as $continent}
                                            <option value="{$continent['id']}">{$continent['titleFa']}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="continent">کشور</label>
                                    <select name="country" id="country" class="form-control select2">
                                        <option value="">انتخاب کنید</option>
                                    </select>
                                </div>
                            </div>
                            <hr class=' w-100'>
                            <div data-name='positions' class='d-flex w-100 flex-wrap'>
                                <div data-name='position' class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label" for="continent">نوع ویزا</label>

                                        <select name="visa_type"
                                                id="visa_type" class="form-control select2">
                                            <option value="">انتخاب کنید</option>
                                            {foreach $recommendation->getVisaTypeList() as $visaType}
                                                <option value="{$visaType['id']}">{$visaType['title']}</option>
                                            {/foreach}
                                        </select>
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
                                زبان
                            </h4>
                            <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                  data-toggle="tooltip" data-placement="top" title=""
                                  data-original-title="نمایش این نظر بر اساس زبان وبسایت شما"></span>
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

                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='align-items-center d-flex flex-wrap font-bold gap-10 m-0 px-4 py-3'>
                                تصویر پروفایل
                            </h4>
                            <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                  data-toggle="tooltip" data-placement="top" title=""
                                  data-original-title=" تصویر پروفایل"></span>
                        </div>


                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="feature_image">تصویر پروفایل </label>
                                <input type="file" class="form-control-file dropify" name="feature_image" id="feature_image"
                                       data-default-file="">
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


<script type="text/javascript" src="assets/JsFiles/recommendations.js"></script>
<script src="assets/js/blog-jquery-dropzone.js"></script>

<script type="text/javascript">

  /* function rebuildGallery(added_files) {
 const gallery_preview= $('#gallery_preview');
     gallery_preview.html('')
     added_files.forEach(function(item){

       gallery_preview.append('<img class="col-md-3" src="'+item.dataURL+'" />')

     })
   }*/

  let added_files=[]
  myDropzone.on('thumbnail', function(file, dataURL) {

    console.log('file',file)
    added_files.push(file)


  })
</script>