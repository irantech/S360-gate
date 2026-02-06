{load_presentation_object filename="introductIran" assign="objItem"}
{assign var="list_cat" value=$objItem->listProvince()}
{assign var="provinceId" value=$smarty.get.provinceId}
{assign var="info_category" value=$objItem->getProvince($smarty.get.provinceId)}
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
                {if $provinceId}
                    <li>
                        <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/introductIran/itemList&provinceId={$provinceId}">
                            {$info_category['title']}
                        </a>
                    </li>
                {/if}
                <li class="active">افزودن آثار باستانی جدید</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <form data-toggle="validator" id="add_item" method="post"  enctype="multipart/form-data">
            <input type='hidden' value='insertItem' id='method' name='method'>
            <input type='hidden' value='introductIran' id='className' name='className'>
            {if $provinceId}
            <input type='hidden' value='{$provinceId}' id='provinceId' name='provinceId'>
            {/if}
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">

                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>

                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>افزودن آثار باستانی
                                {if $provinceId}
                                به استان {$info_category['title']}
                                {/if}
                            </h4>
                        </div>

                        <hr class='m-0 mb-4 w-100'>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="title">نام آثار باستانی </label>

                                <input type="text" class="form-control" name="title" id="title"
                                       placeholder="نام آثار باستانی را وارد نمایید">
                            </div>
                        </div>

                        {if !$provinceId}
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group ">
                                <label for="type_vehicle" class="control-label">انتخاب استان</label>
                                <select name="provinceId" id="provinceId" class="form-control">
                                    <option value="">انتخاب کنید....</option>
                                    {foreach $list_cat as $key => $value}
                                    <option value="{$value.id}">{$value['title']}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                        {else}
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            </div>
                        {/if}


                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="pic" class="control-label">تصویر اول</label>
                                <input type="file" name="pic" id="pic" class="dropify" data-height="100"
                                       data-default-file=""/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="pic2" class="control-label">تصویر دوم</label>
                                <input type="file" name="pic2" id="pic2" class="dropify" data-height="100"
                                       data-default-file=""/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="content" class="control-label">توضیحات کوتاه</label>
                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title="در این قسمت متن کوتاهی وارد نمائید"></span>
                                <textarea id="content" name="content" class="form-control" rows='4'
                                          placeholder="توضیحات کوتاه را وارد نمائید"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="iframe_code" class="control-label">لینک آی فریم</label>
                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title=" لینک آی فریم کپی شده را در این قسمت وارد نمائید"></span>
                                <textarea id="video_url" name="video_url" class="form-control" rows='4'
                                          placeholder="لینک آی فریم را وارد نمائید">{$info_province['video_url']}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="description" class="control-label">توضیحات </label>
                                <textarea id="description" name="description" class="form-control" rows='4'
                                          placeholder="توضیحات کوتاه را وارد نمائید"></textarea>
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
</script>
<script type="text/javascript" src="assets/JsFiles/introductIran.js">

