{load_presentation_object filename="uploadFiles" assign="objuploads"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-3 col-md-6 col-xs-12">
                <ol class="breadcrumb FloatRight">
                    <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                    <li>
                        <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/uploadFiles/list">
                            لیست فایل ها
                        </a>
                    </li>
                    <li class="active">درج فایل جدید</li>
                </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <form data-toggle="validator" id="add_uploads" method="post"  enctype="multipart/form-data">
            <input type='hidden' value='insertUploads' id='method' name='method'>
            <input type='hidden' value='uploadFiles' id='className' name='className'>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">

                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>افزودن فایل جدید</h4>
                        </div>

                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nopad ">

                            <h4 class='drop_zone-new-titr-uplod'>آپلود فایل</h4>


                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label for='gallery_files'
                                       id="drop_zone"
                                       class='d-flex flex-wrap justify-content-center align-items-center border-dashed border-primary p-5 w-100'
                                       ondrop="dropHandlerUpload(event , false , false);"
                                       ondragover="dragOverHandlerUpload(event);">
                                    <p>تصاویر یا فایل های خود را انتخاب یا در کادر بکشید</p>
                                </label>
                            </div>



                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-0">
                                <div class="d-flex flex-wrap form-group gap-5 w-100">
                                    <label for="gallery_files" class="control-label d-none">##Selectfile##</label>
                                    <input onchange="dropHandlerUpload(event , false  , false)" type='file'
                                           class=' d-none'
                                           multiple name='gallery_files[]' id='gallery_files'>

                                    <div id='preview-gallery' class='drop_zone-new-parent-gallery'></div>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>

            <div class='col-12 d-flex align-items-center justify-content-center w-100 parentbtn-btn-fixed'>
                <button class="btn btn-success btn-block btn-fixed" type="submit" id='uploadButton'>ذخیره</button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/uploadFiles.js"></script>

