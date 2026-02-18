{load_presentation_object filename="gallery" assign="objGalleryCategory"}
{assign var="info_gallery_category" value=$objGalleryCategory->getGalleryCategory($smarty.get.id)}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">

                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/gallery/catList">
                        لیست دسته بندی گالری
                    </a>
                </li>
                <li class='active'>
                    ویرایش
                    <span class='font-bold underdash'>{$info_gallery_category['title']}</span>
                </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <form data-toggle="validator" id="edit_gallery_category" method="post"  enctype="multipart/form-data">
            <input type='hidden' value='updateGalleryCategory' id='method' name='method'>
            <input type='hidden' value='gallery' id='className' name='className'>
            <input type='hidden' value='{$info_gallery_category['id']}' id='id' name='id'>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">

                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>ویرایش دسته بندی  {$info_gallery_category['title']} </h4>
                        </div>

                        <hr class='m-0 mb-4 w-100'>
                        <div class="bg-white d-flex flex-wrap rounded w-100 ">

                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="language">زبان </label>
                                    <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                          data-toggle="tooltip" data-placement="top" title=""
                                          data-original-title=" زبان را انتخاب نمائید"></span>
                                    <select name="language" class="form-control" id="language">
                                        {foreach $languages as $value=>$title}
                                            <option value="{$value}" {if $info_gallery_category['language'] == $value} selected{/if}>{$title}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="title">عنوان </label>
                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title=" عنوان را وارد نمائید"></span>
                                <input type="text" class="form-control" name="title" id="title" value='{$info_gallery_category['title']}'
                                       placeholder="از این قسمت می توانید عنوان را تغییر دهید">
                            </div>
                        </div>


                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="description" class="control-label">توضیحات</label>
                                <textarea id="description" name="description" class="form-control" rows='4'
                                          placeholder="توضیحات را وارد نمائید">{$info_gallery_category['description']}</textarea>
                            </div>
                        </div>
                        {if $info_gallery_category['type']=='pic'}
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="pic" class="control-label">تصویر</label>
                                    <input type="file" name="pic" id="pic" class="dropify" data-height="100" value='{$info_gallery_category['pic']}'
                                           data-default-file="{$info_gallery_category['pic']}"/>
                                </div>
                            </div>
                        {else}
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 show-pic-upload">
                                <div class="form-group">
                                    <video width="200" height="160" controls>
                                        <source src="{$info_gallery_category['pic']}" type="video/mp4">
                                        <source src="{$info_gallery_category['pic']}" type="video/ogg">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                                <button type='button' onclick="uploadFile()">آپلود فایل</button>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 show-pic" style='display: none' >
                                <div class="form-group">
                                    <label for="pic" class="control-label">فایل</label>
                                    <input type="file" name="pic" id="pic" class="dropify" data-height="100" value='{$info_gallery_category['pic']}'
                                           data-default-file="{$info_gallery_category['pic']}"/>
                                </div>
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


<script type="text/javascript" src="assets/JsFiles/galleryCategory.js"></script>

<script>
  function uploadFile() {
    $(".show-pic-upload").hide();  // To hide
    $(".show-pic").show();  // To show
  }
</script>

