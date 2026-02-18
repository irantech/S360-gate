{load_presentation_object filename="galleryBanner" assign="objsliders"}

{*{$smarty.const.SOFTWARE_LANG}*}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-3 col-md-6 col-xs-12">
                <ol class="breadcrumb FloatRight">
                    <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                    <li>
                        <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/galleryBanner/list">
                            لیست بنرها
                        </a>
                    </li>
                    <li class="active">درج بنر جدید</li>
                </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <form data-toggle="validator" id="add_galleryBanner" method="post"  enctype="multipart/form-data">
            <input type='hidden' value='insertGalleryBanner' id='method' name='method'>
            <input type='hidden' value='galleryBanner' id='className' name='className'>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">

                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>افزودن بنر</h4>
                        </div>

                        <hr class='m-0 mb-4 w-100'>
                        <div class="warning" style='width: 100%;'>
                            برای افزودن بنر به نکات زیر توجه نمایید : <br />
                            1 : فرمت تصاویر   'mp4', 'jpg', 'jpe', 'jpeg', 'png'  باشد <br />
                            2 : حجم تصاویر کمتر از 2 مگ باشد <br />
                            3 : بنرهای آپلود شده به صورت پیش فرض در سایت نمایش داده خواهند شد، در صورتی که تمایل ندارید بنری نمایش داده شود از لیست بنرها بنر مورد نظر را غیرفعال نمایید <br />
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="title">عنوان بنر</label>
                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title=" عنوان بنر را وارد نمائید"></span>
                                <input type="text" class="form-control" name="title" id="title"
                                       placeholder="عنوان را وارد نمایید">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="language" class="control-label">زبان</label>
                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title="زبان مورد نظر را انتخاب نمائید"></span>
                                <select name="language" class="form-control" id="language">
                                    {foreach $languages as $value=>$title}
                                        <option value="{$value}" {if $value == $smarty.const.SOFTWARE_LANG} selected {/if}>{$title}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="description" class="control-label">توضیحات</label>
                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title=" توضیحات با توجه به طراحی سایت شما و در صورت نیاز نمایش داده می شود"></span>
                                <textarea id="description" name="description" class="form-control" rows='4'
                                          placeholder="توضیحات را وارد نمائید"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="iframe_code" class="control-label">کد آی فریم</label>
                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title=" کد آی فریم کپی شده را در این قسمت وارد نمائید"></span>
                                {include file="{$smarty.const.FRONT_CURRENT_ADMIN}/modules/iframeLink.tpl"}
                                <textarea id="iframe_code" name="iframe_code" class="form-control" rows='4'
                                          placeholder="کد آی فریم را وارد نمائید"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group ">
                                <label for="link" class="control-label">آدرس صفحه هدف</label>
                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title=" آدرس صفحه مقصد بنر را وارد نمائید"></span>
                                <input type="text" class="form-control" id="link" name="link"
                                       placeholder="آدرس صفحه هدف را وارد نمائید">
                            </div>

                        </div>



                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="pic" class="control-label">فایل</label>
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

<script type="text/javascript" src="assets/JsFiles/galleryBanner.js">

