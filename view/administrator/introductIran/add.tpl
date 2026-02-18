{load_presentation_object filename="introductIran" assign="objProvince"}
{assign var="languages" value=['fa'=>'فارسی','en'=>'English','ar'=>'العربیه']}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-3 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/introductIran/list">
                        لیست استان ها
                    </a>
                </li>
                <li class="active">افزودن استان جدید</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <form data-toggle="validator" id="add_province" method="post"  enctype="multipart/form-data">
            <input type='hidden' value='insertProvince' id='method' name='method'>
            <input type='hidden' value='introductIran' id='className' name='className'>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">

                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>افزودن استان</h4>
                        </div>

                        <hr class='m-0 mb-4 w-100'>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="title">نام استان </label>
                                <input type="text" class="form-control" name="title" id="title"
                                       placeholder="نام استان را وارد نمایید">
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
                                <label for="note_province" class="control-label">توضیحات کوتاه</label>
                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title="این توضیحات در لیست استان ها نمایش داده خواهد شد"></span>
                                <textarea id="note_province" name="note_province" class="form-control" rows='4'
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
                                <label for="history_province" class="control-label">تاریخچه</label>
                                <textarea id="history_province" name="history_province" class="form-control" rows='4'
                                          placeholder="تاریخچه را وارد نمائید"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="museums_province" class="control-label">موزه های استان</label>
                                <textarea id="museums_province" name="museums_province" class="form-control" rows='4'
                                          placeholder="موزه های استان را وارد نمائید"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="handicrafts_province" class="control-label">صنایع دستی استان</label>
                                <textarea id="handicrafts_province" name="handicrafts_province" class="form-control" rows='4'
                                          placeholder="صنایع دستی استان را وارد نمائید"></textarea>
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
    if ($('#history_province').length) {
      CKEDITOR.replace('history_province');
    }
    if ($('#museums_province').length) {
      CKEDITOR.replace('museums_province');
    }
    if ($('#handicrafts_province').length) {
      CKEDITOR.replace('handicrafts_province');
    }
  })
</script>
<script type="text/javascript" src="assets/JsFiles/introductIran.js">

