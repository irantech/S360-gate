{load_presentation_object filename="popUp" assign="objPop"}
{assign var="info_pop_up" value=$objPop->getPopUp($smarty.get.id)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">

                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/popUp/list">
                        لیست پاپ آپ
                    </a>
                </li>
                <li class='active'>
                    ویرایش
                    <span class='font-bold underdash'>{$info_pop_up['title']}</span>
                </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <form data-toggle="validator" id="edit_pop_up" method="post"  enctype="multipart/form-data">
            <input type='hidden' value='updatePopUp' id='method' name='method'>
            <input type='hidden' value='popUp' id='className' name='className'>
            <input type='hidden' value='{$info_pop_up['id']}' id='id' name='id'>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">

                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>ویرایش   {$info_pop_up['title']} </h4>
                        </div>

                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="title">عنوان </label>
                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title=" عنوان را وارد نمائید"></span>
                                <input type="text" class="form-control" name="title" id="title" value='{$info_pop_up['title']}'
                                       placeholder="از این قسمت می توانید عنوان را تغییر دهید">
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="description" class="control-label">توضیحات</label>
                                <textarea id="description" name="description" class="form-control" rows='4' maxlength="400"
                                          placeholder="توضیحات را وارد نمائید">{$info_pop_up['description']}</textarea>
                            </div>
                        </div>
                        {if $info_pop_up['type']=='pic'}
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="pic" class="control-label">تصویر</label>
                                    <input type="file" name="pic" id="pic" class="dropify" data-height="100" value='{$info_pop_up['pic']}'
                                           data-default-file="{$info_pop_up['pic']}"/>
                                </div>
                            </div>
                        {else}
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 show-pic-upload">
                                <div class="form-group">
                                    <video width="200" height="160" controls>
                                        <source src="{$info_pop_up['pic']}" type="video/mp4">
                                        <source src="{$info_pop_up['pic']}" type="video/ogg">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                                <button type='button' onclick="uploadFile()">آپلود فایل</button>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 show-pic" style='display: none' >
                                <div class="form-group">
                                    <label for="pic" class="control-label">فایل</label>
                                    <input type="file" name="pic" id="pic" class="dropify" data-height="100" value='{$info_pop_up['pic']}'
                                           data-default-file="{$info_pop_up['pic']}"/>
                                </div>
                            </div>
                        {/if}
                        {if $info_pop_up['type_mobile']=='pic_mobile'}
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="pic_mobile" class="control-label">تصویر موبایل</label>
                                    <input type="file" name="pic_mobile" id="pic_mobile" class="dropify" data-height="100" value='{$info_pop_up['pic_mobile']}'
                                           data-default-file="{$info_pop_up['pic_mobile']}"/>
                                </div>
                            </div>
                        {else}
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 show-pic-upload">
                                <div class="form-group">
                                    <video width="200" height="160" controls>
                                        <source src="{$info_pop_up['pic']}" type="video/mp4">
                                        <source src="{$info_pop_up['pic']}" type="video/ogg">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                                <button type='button' onclick="uploadFile()">آپلود فایل</button>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 show-pic" style='display: none' >
                                <div class="form-group">
                                    <label for="pic_mobile" class="control-label">فایل</label>
                                    <input type="file" name="pic_mobile" id="pic_mobile" class="dropify" data-height="100" value='{$info_pop_up['pic_mobile']}'
                                           data-default-file="{$info_pop_up['pic_mobile']}"/>
                                </div>
                            </div>
                        {/if}
                        {if $info_pop_up['type_sample']=='pic_sample'}
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="pic_sample" class="control-label">تصویر تبلت</label>
                                    <input type="file" name="pic_sample" id="pic_sample" class="dropify" data-height="100" value='{$info_pop_up['pic_sample']}'
                                           data-default-file="{$info_pop_up['pic_sample']}"/>
                                </div>
                            </div>
                        {else}
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 show-pic-upload">
                                <div class="form-group">
                                    <video width="200" height="160" controls>
                                        <source src="{$info_pop_up['pic']}" type="video/mp4">
                                        <source src="{$info_pop_up['pic']}" type="video/ogg">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                                <button type='button' onclick="uploadFile()">آپلود فایل</button>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 show-pic" style='display: none' >
                                <div class="form-group">
                                    <label for="pic_sample" class="control-label">فایل تبلت</label>
                                    <input type="file" name="pic_sample" id="pic_sample" class="dropify" data-height="100" value='{$info_pop_up['pic_sample']}'
                                           data-default-file="{$info_pop_up['pic_sample']}"/>
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


<script type="text/javascript" src="assets/JsFiles/popUp.js"></script>

<script>
  function uploadFile() {
    $(".show-pic-upload").hide();  // To hide
    $(".show-pic").show();  // To show
  }
</script>

