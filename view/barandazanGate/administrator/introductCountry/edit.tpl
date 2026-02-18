{load_presentation_object filename="introductCountry" assign="objCountry"}

{assign var="info_country" value=$objCountry->getCountry($smarty.get.id)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">

                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/introductCountry/list">
                        لیست کشورها
                    </a>
                </li>
                <li class='active'>
                    ویرایش
                    <span class='font-bold underdash'>{$info_country['title']}</span>
                </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <form data-toggle="validator" id="edit_country" method="post"  enctype="multipart/form-data">
            <input type='hidden' value='updateCountry' id='method' name='method'>
            <input type='hidden' value='introductCountry' id='className' name='className'>
            <input type='hidden' value='{$info_country['id']}' id='id' name='id'>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">

                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>ویرایش کشور  {$info_country['title']} </h4>
                        </div>

                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="title">نام کشور </label>
                                <input type="text" class="form-control" name="title" id="title" value='{$info_country['title']}'
                                       placeholder="از این قسمت می توانید نام کشور را تغییر دهید">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="language" class="control-label">زبان</label>
                                <select name="language" class="form-control" id="language">
                                    {foreach $languages as $value=>$title}
                                        <option value="{$value}" {if $info_country['language'] == $value} selected{/if}>{$title}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                        {if $info_country['type']=='pic'}
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="pic" class="control-label">تصویر</label>
                                    <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                          data-toggle="tooltip" data-placement="top" title=""
                                          data-original-title=" در صورت تمایل می توانید تصویر را تغییر دهید"></span>
                                    <input type="file" name="pic" id="pic" class="dropify" data-height="100" value='{$info_country['pic_show']}'
                                           data-default-file="{$info_country['pic_show']}"/>
                                </div>
                            </div>
                        {else}
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 show-pic-upload">
                                <div class="form-group">
                                    <video width="200" height="160" controls>
                                        <source src="{$info_country['pic_show']}" type="video/mp4">
                                        <source src="{$info_country['pic_show']}" type="video/ogg">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                                <button type='button' onclick="uploadFile()">آپلود فایل</button>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 show-pic" style='display: none' >
                                <div class="form-group">
                                    <label for="pic" class="control-label">فایل</label>
                                    <input type="file" name="pic" id="pic" class="dropify" data-height="100" value='{$info_country['pic']}'
                                           data-default-file="{$info_country['pic']}"/>
                                </div>
                            </div>
                        {/if}
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="note_1" class="control-label">توضیحات کوتاه</label>
                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title="این توضیحات در لیست کشورها نمایش داده خواهد شد"></span>
                                <textarea id="note_1" name="note_1" class="form-control" rows='4'
                                          placeholder="توضیحات کوتاه را وارد نمائید">{$info_country['note_1']}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="iframe_code" class="control-label">لینک آی فریم</label>
                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title=" لینک آی فریم کپی شده را در این قسمت وارد نمائید"></span>
                                <textarea id="video_url" name="video_url" class="form-control" rows='4'
                                          placeholder="لینک آی فریم را وارد نمائید">{$info_country['video_url']}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="note_2" class="control-label">در یک نگاه</label>
                                <textarea id="note_2" name="note_2" class="form-control" rows='4'
                                          placeholder="در یک نگاه را وارد نمائید">{$info_country['note_2']}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="note_3" class="control-label">معرفی اجمالی</label>
                                <textarea id="note_3" name="note_3" class="form-control" rows='4'
                                          placeholder="معرفی اجمالی را وارد نمائید">{$info_country['note_3']}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="note_4" class="control-label">ساختار دولتی</label>
                                <textarea id="note_4" name="note_4" class="form-control" rows='4'
                                          placeholder="ساختار دولتی کشور را وارد نمائید">{$info_country['note_4']}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="note_5" class="control-label">ساختار اقتصادی</label>
                                <textarea id="note_5" name="note_5" class="form-control" rows='4'
                                          placeholder="ساختار اقتصادی کشور را وارد نمائید">{$info_country['note_5']}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="note_6" class="control-label">ساختار ارتباطات</label>
                                <textarea id="note_6" name="note_6" class="form-control" rows='4'
                                          placeholder="ساختار ارتباطات کشور را وارد نمائید">{$info_country['note_6']}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="note_7" class="control-label">ساختار جغرافیایی</label>
                                <textarea id="note_7" name="note_7" class="form-control" rows='4'
                                          placeholder="ساختار جغرافیایی کشور را وارد نمائید">{$info_country['note_7']}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="note_8" class="control-label">ساختار حمل و نقل</label>
                                <textarea id="note_8" name="note_8" class="form-control" rows='4'
                                          placeholder="ساختار حمل و نقل کشور را وارد نمائید">{$info_country['note_8']}</textarea>
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
  function uploadFile() {
    $(".show-pic-upload").hide();  // To hide
    $(".show-pic").show();  // To show
  }
</script>
<script type="text/javascript" src="assets/JsFiles/introductCountry.js"></script>

