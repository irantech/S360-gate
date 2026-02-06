{load_presentation_object filename="video" assign="objVideo"}
{assign var="info_video" value=$objVideo->getVideo($smarty.get.id)}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">

                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/video/list">
                        لیست گالری ویدئو
                    </a>
                </li>
                <li class='active'>
                    ویرایش
                    <span class='font-bold underdash'>{$info_video['title']}</span>
                </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <form data-toggle="validator" id="edit_video" method="post"  enctype="multipart/form-data">
            <input type='hidden' value='updateVideo' id='method' name='method'>
            <input type='hidden' value='video' id='className' name='className'>
            <input type='hidden' value='{$info_video['id']}' id='id' name='id'>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">

                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>ویرایش ویدئو  {$info_video['title']} </h4>
                        </div>

                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="title">عنوان ویدئو</label>
                                <input type="text" class="form-control" name="title" id="title" value='{$info_video['title']}'
                                       placeholder="از این قسمت می توانید عنوان ویدئو را تغییر دهید">
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="language" class="control-label">زبان</label>
                                <select name="language" class="form-control" id="language">
                                    {foreach $languages as $value=>$title}
                                        <option value="{$value}" {if $info_video['language'] eq $value} selected {/if}>{$title}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="iframe_code" class="control-label">کد آی فریم</label>
                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title=" کد آی فریم کپی شده را در این قسمت وارد نمائید"></span>
                                {include file="{$smarty.const.FRONT_CURRENT_ADMIN}/modules/iframeLink.tpl"}
                                <textarea id="iframe_code" name="iframe_code" class="form-control" rows='4'
                                          placeholder="کد آی فریم را وارد نمائید">{$info_video['iframe_code']}</textarea>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="description" class="control-label">توضیحات</label>
                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title=" توضیحات مورد نیاز را در این قسمت وارد نمائید"></span>
                                <textarea id="description" name="description" class="form-control ckeditor" rows='4'
                                          placeholder="توضیحات را وارد نمائید">{$info_video['description']}</textarea>
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


<script type="text/javascript" src="assets/JsFiles/video.js"></script>


