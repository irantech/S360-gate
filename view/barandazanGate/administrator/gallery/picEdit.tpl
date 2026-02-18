{load_presentation_object filename="gallery" assign="objPic"}
{assign var="info_gallery_pic" value=$objPic->getGalleryPic($smarty.get.id)}
{assign var="list_gallery_cat" value=$objPic->listGalleryCategory()}

{assign var="catId" value=$info_gallery_pic['cat_id']}
{assign var="info_gallery_category" value=$objPic->getGalleryCategory($catId)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">

                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/gallery/catList">
                        لیست دسته بندی ها
                    </a>
                </li>
                {if $catId}
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/gallery/picList&catId={$catId}">
                        {$info_gallery_category['title']}
                    </a>
                </li>
                {/if}
                <li class='active'>
                    ویرایش
                    <span class='font-bold underdash'>{$info_gallery_pic['title']}</span>
                </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <form data-toggle="validator" id="edit_gallery_pic" method="post"  enctype="multipart/form-data">
            <input type='hidden' value='updateGalleryPic' id='method' name='method'>
            <input type='hidden' value='gallery' id='className' name='className'>
            <input type='hidden' value='{$info_gallery_pic['id']}' id='id' name='id'>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">

                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>ویرایش تصویر  {$info_gallery_pic['title']} </h4>
                        </div>

                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="title">عنوان </label>
                                <input type="text" class="form-control" name="title" id="title" value='{$info_gallery_pic['title']}'
                                       placeholder="از این قسمت می توانید عنوان را تغییر دهید">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group ">
                                <label for="type_vehicle" class="control-label">انتخاب دسته بندی گالری</label>
                                <select name="catId" id="catId" class="form-control">
                                    <option value="">انتخاب کنید....</option>
                                    {foreach $list_gallery_cat as $key => $value}
                                        <option value="{$value.id}" {if $info_gallery_pic['cat_id']==$value['id']} selected {/if}>{$value['title']}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="description" class="control-label">توضیحات</label>
                                <textarea id="description" name="description" class="form-control" rows='4'
                                          placeholder="توضیحات را وارد نمائید">{$info_gallery_pic['description']}</textarea>
                            </div>
                        </div>
                        {if $info_gallery_pic['type']=='pic'}
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="pic" class="control-label">تصویر</label>
                                    <input type="file" name="pic" id="pic" class="dropify" data-height="100" value='{$info_gallery_pic['pic']}'
                                           data-default-file="{$info_gallery_pic['pic']}"/>
                                </div>
                            </div>
                        {else}
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 show-pic-upload">
                                <div class="form-group">
                                    <video width="200" height="160" controls>
                                        <source src="{$info_gallery_pic['pic']}" type="video/mp4">
                                        <source src="{$info_gallery_pic['pic']}" type="video/ogg">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                                <button type='button' onclick="uploadFile()">آپلود فایل</button>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 show-pic" style='display: none' >
                                <div class="form-group">
                                    <label for="pic" class="control-label">فایل</label>
                                    <input type="file" name="pic" id="pic" class="dropify" data-height="100" value='{$info_gallery_pic['pic']}'
                                           data-default-file="{$info_gallery_pic['pic']}"/>
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


<script type="text/javascript" src="assets/JsFiles/galleryPic.js"></script>

<script>
  function uploadFile() {
    $(".show-pic-upload").hide();  // To hide
    $(".show-pic").show();  // To show
  }
</script>

