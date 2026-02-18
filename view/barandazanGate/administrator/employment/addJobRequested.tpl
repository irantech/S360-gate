{load_presentation_object filename="employmentRequestedJob" assign="objJob"}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-3 col-md-6 col-xs-12">
                <ol class="breadcrumb FloatRight">
                    <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                    <li>
                        <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/employment/list">
                            لیست استخدام
                        </a>
                    </li>
                    <li>
                        <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/employment/listJobRequested">
                            لیست مشاغل درخواستی
                        </a>
                    </li>
                    <li class="active">افزودن شغل جدید</li>
                </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <form data-toggle="validator" id="add_requested_job" method="post"  enctype="multipart/form-data">
            <input type='hidden' value='insertJob' id='method' name='method'>
            <input type='hidden' value='employmentRequestedJob' id='className' name='className'>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">
                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>افزودن شغل درخواستی</h4>
                        </div>
                        <hr class='m-0 mb-4 w-100'>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="title">عنوان </label>
                                <input type="text" class="form-control" name="title" id="title"
                                       placeholder="عنوان را وارد نمایید">
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
<script type="text/javascript" src="assets/JsFiles/employmentRequestedJob.js">

