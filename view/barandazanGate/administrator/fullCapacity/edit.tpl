{load_presentation_object filename="fullCapacity" assign="objFullCapacity"}
{assign var="info_pic" value=$objFullCapacity->getFullCapacity($smarty.get.id)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">

                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/fullCapacity/list">
                        لیست تصاویر
                    </a>
                </li>
                <li class='active'>
                    ویرایش
                    <span class='font-bold underdash'>{$info_pic['title']}</span>
                </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <form data-toggle="validator" id="edit_full_capacity" method="post"  enctype="multipart/form-data">
            <input type='hidden' value='updateFullCapacity' id='method' name='method'>
            <input type='hidden' value='fullCapacity' id='className' name='className'>
            <input type='hidden' value='{$info_pic['id']}' id='id' name='id'>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">

                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>ویرایش  {$info_pic['title']} </h4>
                        </div>
                        <p class="text-muted m-b-30"> از فرم زیر شما می توانید تصویر مورد نظر خود را در جستجوی پرواز یا اتوبوس وارد نمائید
                            <br>
                            پسوندهای مجاز برای آپلود تصویر jpeg و jpg و png می باشد
                        </p>

                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="title">عنوان</label>
                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title=" عنوان را وارد نمائید"></span>
                                <input type="text" class="form-control" name="title" id="title" value='{$info_pic['title']}'
                                       placeholder="از این قسمت می توانید عنوان را تغییر دهید">
                            </div>
                        </div>

                        {if $info_pic['type']=='pic'}
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="pic" class="control-label">تصویر</label>
                                <input type="file" name="pic" id="pic" class="dropify" data-height="100" value='{$info_pic['pic']}'
                                       data-default-file="{$info_pic['pic']}"/>
                            </div>
                        </div>
                        {else}
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 show-pic-upload">
                                <div class="form-group">
                                    <video width="200" height="160" controls>
                                        <source src="{$info_pic['pic']}" type="video/mp4">
                                        <source src="{$info_pic['pic']}" type="video/ogg">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                                <button type='button' onclick="uploadFile()">آپلود فایل</button>
                            </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 show-pic" style='display: none' >
                            <div class="form-group">
                                <label for="pic" class="control-label">فایل</label>
                                <input type="file" name="pic" id="pic" class="dropify" data-height="100" value='{$info_pic['pic']}'
                                       data-default-file="{$info_pic['pic']}"/>
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


<script type="text/javascript" src="assets/JsFiles/fullCapacity.js"></script>

<script>
  function uploadFile() {
    $(".show-pic-upload").hide();  // To hide
    $(".show-pic").show();  // To show
  }
</script>

