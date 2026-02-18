{load_presentation_object filename="introductCountry" assign="objProvince"}

{assign var="info_province" value=$objProvince->getProvince($smarty.get.id)}
{assign var="list_country" value=$objProvince->listCountry()}
{assign var="countryId" value=$info_province['country_id']}
{assign var="info_country" value=$objProvince->getCountry($countryId)}

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
                {if $countryId}
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/introductCountry/provinceList&countryId={$countryId}">
                        لیست استان های {$info_country['title']}
                    </a>
                </li>
                {/if}
                <li class='active'>
                    ویرایش
                    <span class='font-bold underdash'>{$info_province['title']}</span>
                </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <form data-toggle="validator" id="edit_province" method="post"  enctype="multipart/form-data">
            <input type='hidden' value='updateProvince' id='method' name='method'>
            <input type='hidden' value='introductCountry' id='className' name='className'>
            <input type='hidden' value='{$info_province['id']}' id='id' name='id'>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">

                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>ویرایش استان  {$info_province['title']} </h4>
                        </div>

{*                        <hr class='m-0 mb-4 w-100'>*}

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="title">نام استان </label>
                                <input type="text" class="form-control" name="title" id="title" value='{$info_province['title']}'
                                       placeholder="از این قسمت می توانید نام استان را تغییر دهید">
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group ">
                                <label for="type_vehicle" class="control-label">انتخاب کشور</label>
                                <select name="countryId" id="countryId" class="form-control">
                                    <option value="">انتخاب کنید....</option>
                                    {foreach $list_country as $key => $value}
                                        <option value="{$value.id}" {if $info_province['country_id']==$value['id']} selected {/if}>{$value['title']}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="content" class="control-label">توضیحات کوتاه</label>
                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title="در این قسمت متن کوتاهی وارد نمائید"></span>
                                <textarea id="content" name="content" class="form-control" rows='4'
                                          placeholder="توضیحات کوتاه را وارد نمائید">{$info_province['content']}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="iframe_code" class="control-label">لینک آی فریم</label>
                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title=" کد آی فریم کپی شده را در این قسمت وارد نمائید"></span>
                                <textarea id="video_url" name="video_url" class="form-control" rows='4'
                                          placeholder="لینک آی فریم را وارد نمائید">{$info_province['video_url']}</textarea>
                            </div>
                        </div>
                        {if $info_province['type']=='pic'}
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="pic" class="control-label">تصویر</label>
                                    <input type="file" name="pic" id="pic" class="dropify" data-height="100" value='{$info_province['pic_show']}'
                                           data-default-file="{$info_province['pic_show']}"/>
                                </div>
                            </div>
                        {else}
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 show-pic-upload">
                                <div class="form-group">
                                    <video width="200" height="160" controls>
                                        <source src="{$info_province['pic_show']}" type="video/mp4">
                                        <source src="{$info_province['pic_show']}" type="video/ogg">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                                <button type='button' onclick="uploadFile()">آپلود فایل</button>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 show-pic" style='display: none' >
                                <div class="form-group">
                                    <label for="pic" class="control-label">فایل</label>
                                    <input type="file" name="pic" id="pic" class="dropify" data-height="100" value='{$info_province['pic_show']}'
                                           data-default-file="{$info_province['pic_show']}"/>
                                </div>
                            </div>
                        {/if}

                        {if $info_province['type']=='pic'}
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="pic2" class="control-label">تصویر</label>
                                    <input type="file" name="pic2" id="pic2" class="dropify" data-height="100" value='{$info_province['pic_show2']}'
                                           data-default-file="{$info_province['pic_show2']}"/>
                                </div>
                            </div>
                        {else}
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 show-pic2-upload">
                                <div class="form-group">
                                    <video width="200" height="160" controls>
                                        <source src="{$info_province['pic_show2']}" type="video/mp4">
                                        <source src="{$info_province['pic_show2']}" type="video/ogg">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                                <button type='button' onclick="uploadFile2()">آپلود فایل</button>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 show-pic2" style='display: none' >
                                <div class="form-group">
                                    <label for="pic2" class="control-label">فایل</label>
                                    <input type="file" name="pic2" id="pic2" class="dropify" data-height="100" value='{$info_province['pic_show2']}'
                                           data-default-file="{$info_province['pic_show2']}"/>
                                </div>
                            </div>
                        {/if}


                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="description" class="control-label">توضیحات  </label>
                                <textarea id="description" name="description" class="form-control" rows='4'
                                          placeholder="توضیحات را وارد نمائید">{$info_province['description']}</textarea>
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
    if ($('#description').length) {
      CKEDITOR.replace('description');
    }
  })
  function uploadFile() {
    $(".show-pic-upload").hide();  // To hide
    $(".show-pic").show();  // To show
  }
  function uploadFile2() {
    $(".show-pic2-upload").hide();  // To hide
    $(".show-pic2").show();  // To show
  }
</script>
<script type="text/javascript" src="assets/JsFiles/introductCountry.js"></script>


