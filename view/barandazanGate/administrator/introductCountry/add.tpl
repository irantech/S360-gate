{load_presentation_object filename="introductCountry" assign="objCountry"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-3 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/introductCountry/list">
                        لیست کشورها
                    </a>
                </li>
                <li class="active">افزودن کشور جدید</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <form data-toggle="validator" id="add_country" method="post"  enctype="multipart/form-data">
            <input type='hidden' value='insertCountry' id='method' name='method'>
            <input type='hidden' value='introductCountry' id='className' name='className'>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">

                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>افزودن کشور</h4>
                        </div>

                        <hr class='m-0 mb-4 w-100'>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="title">نام کشور </label>
                                <input type="text" class="form-control" name="title" id="title"
                                       placeholder="نام کشور را وارد نمایید">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="language" class="control-label">زبان</label>
                                <select name="language" class="form-control" id="language">
                                    {foreach $languages as $value=>$title}
                                        <option value="{$value}">{$title}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="pic" class="control-label">تصویر</label>
                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title=" تصویر مورد نظر را وارد نمائید"></span>
                                <input type="file" name="pic" id="pic" class="dropify" data-height="100"
                                       data-default-file=""/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="note_1" class="control-label">توضیحات کوتاه</label>
                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title="این توضیحات در لیست کشورها نمایش داده خواهد شد"></span>
                                <textarea id="note_1" name="note_1" class="form-control" rows='4'
                                          placeholder="توضیحات کوتاه را وارد نمائید"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="iframe_code" class="control-label">لینک آی فریم</label>
                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title=" لینک آی فریم کپی شده را در این قسمت وارد نمائید"></span>
                                <textarea id="video_url" name="video_url" class="form-control" rows='4'
                                          placeholder="لینک آی فریم را وارد نمائید"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="note_2" class="control-label">در یک نگاه</label>
                                <textarea id="note_2" name="note_2" class="form-control" rows='4'
                                          placeholder="در یک نگاه را وارد نمائید"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="note_3" class="control-label">معرفی اجمالی</label>
                                <textarea id="note_3" name="note_3" class="form-control" rows='4'
                                          placeholder="معرفی اجمالی را وارد نمائید"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="note_4" class="control-label">ساختار دولتی</label>
                                <textarea id="note_4" name="note_4" class="form-control" rows='4'
                                          placeholder="ساختار دولتی کشور را وارد نمائید"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="note_5" class="control-label">ساختار اقتصادی</label>
                                <textarea id="note_5" name="note_5" class="form-control" rows='4'
                                          placeholder="ساختار اقتصادی کشور را وارد نمائید"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="note_6" class="control-label">ساختار ارتباطات</label>
                                <textarea id="note_6" name="note_6" class="form-control" rows='4'
                                          placeholder="ساختار ارتباطات کشور را وارد نمائید"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="note_7" class="control-label">ساختار جغرافیایی</label>
                                <textarea id="note_7" name="note_7" class="form-control" rows='4'
                                          placeholder="ساختار جغرافیایی کشور را وارد نمائید"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="note_8" class="control-label">ساختار حمل و نقل</label>
                                <textarea id="note_8" name="note_8" class="form-control" rows='4'
                                          placeholder="ساختار حمل و نقل کشور را وارد نمائید"></textarea>
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
<script>
  $(document).ready(function() {
    if ($('#note_2').length) {
      CKEDITOR.replace('note_2');
    }
    if ($('#note_3').length) {
      CKEDITOR.replace('note_3');
    }
    if ($('#note_4').length) {
      CKEDITOR.replace('note_4');
    }
    if ($('#note_5').length) {
      CKEDITOR.replace('note_5');
    }
    if ($('#note_6').length) {
      CKEDITOR.replace('note_6');
    }
    if ($('#note_7').length) {
      CKEDITOR.replace('note_7');
    }
    if ($('#note_8').length) {
      CKEDITOR.replace('note_8');
    }
  })
</script>
<script type="text/javascript" src="assets/JsFiles/introductCountry.js">

