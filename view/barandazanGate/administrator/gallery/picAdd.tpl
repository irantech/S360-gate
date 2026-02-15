{load_presentation_object filename="gallery" assign="objPic"}
{assign var="list_gallery_cat" value=$objPic->listGalleryCategory()}
{assign var="catId" value=$smarty.get.catId}
{assign var="info_gallery_category" value=$objPic->getGalleryCategory($smarty.get.catId)}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-3 col-md-6 col-xs-12">
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
                <li class="active">افزودن تصویر جدید</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <form data-toggle="validator" id="add_gallery_pic" method="post"  enctype="multipart/form-data">
            <input type='hidden' value='insertGalleryPic' id='method' name='method'>
            <input type='hidden' value='gallery' id='className' name='className'>
            {if $catId}
            <input type='hidden' value='{$catId}' id='catId' name='catId'>
            {/if}
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">

                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>

                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>افزودن تصویر
                                {if $catId}
                                به دسته بندی {$info_gallery_category['title']}
                                {/if}
                            </h4>
                        </div>

                        <hr class='m-0 mb-4 w-100'>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="title">عنوان تصویر </label>

                                <input type="text" class="form-control" name="title" id="title"
                                       placeholder="عنوان را وارد نمایید">
                            </div>
                        </div>

                        {if !$catId}
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group ">
                                <label for="type_vehicle" class="control-label">انتخاب دسته بندی گالری</label>
                                <select name="catId" id="catId" class="form-control">
                                    <option value="">انتخاب کنید....</option>
                                    {foreach $list_gallery_cat as $key => $value}
                                    <option value="{$value.id}">{$value['title']}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                        {else}
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            </div>
                        {/if}
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="description" class="control-label">توضیحات</label>
                                <textarea id="description" name="description" class="form-control" rows='4'
                                          placeholder="توضیحات را وارد نمائید"></textarea>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="pic" class="control-label">تصویر</label>
                                <input type="file" name="pic" id="pic" class="dropify" data-height="100"
                                       data-default-file=""/>
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

<script type="text/javascript" src="assets/JsFiles/galleryPic.js">

