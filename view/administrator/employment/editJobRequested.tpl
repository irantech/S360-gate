{load_presentation_object filename="employmentRequestedJob" assign="objJob"}
{assign var="info_job" value=$objJob->getRequestedJob($smarty.get.id)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">

                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/employment/list">
                        لیست استخدام
                    </a>
                </li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/employment/listJobRequested">
                        لیست مشاغل
                    </a>
                </li>
                <li class='active'>
                    ویرایش
                    <span class='font-bold underdash'>{$info_job['title']}</span>
                </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <form data-toggle="validator" id="edit_requested_job" method="post"  enctype="multipart/form-data">
            <input type='hidden' value='updateRequestedJob' id='method' name='method'>
            <input type='hidden' value='employmentRequestedJob' id='className' name='className'>
            <input type='hidden' value='{$info_job['id']}' id='id' name='id'>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">

                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>ویرایش شغل  {$info_job['title']} </h4>
                        </div>
                        <hr class='m-0 mb-4 w-100'>
                    </div>
                    <hr class='m-0 mb-4 w-100'>

                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label" for="title">عنوان </label>
                            <input type="text" class="form-control" name="title" id="title" value='{$info_job['title']}'
                                   placeholder="از این قسمت می توانید عنوان را تغییر دهید">
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


<script type="text/javascript" src="assets/JsFiles/employmentRequestedJob.js"></script>
