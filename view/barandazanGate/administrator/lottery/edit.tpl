{load_presentation_object filename="lottery" assign="lottery"}
{assign var="section" value=$smarty.get.section}

{if !isset($smarty.get.id)}
    {header("Location: {$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/lottery/list")}
{/if}
{assign var="lottery" value=$lottery->getLottery($smarty.get.id)}
{if !$lottery}
    {header("Location: {$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/lottery/list")}
{/if}


<style>
   .edit-style-d-none{
       display:none !important;
   }

   .existing-image{
       display: block;
   }


    .imageThumb{
        width:100% !important;
        height: 60%;
        margin-bottom:10px;
        margin:0 auto;
    }

    .dropzone-radio-shakhes{
        display:none !important;
    }

    .dropzone-parent-box{
        margin-top:10px !important;
        margin-bottom:0px !important;


    }
    .dropzone-btn-trash {
        font-size: 0 !important;
        width:0 !important;
        justify-content:center;
        margin-bottom:0 !important;
        border:none !important;
        background:white;
        padding:0;
        height: 0;
    }
    .dropzone-btn-trash i{
        color: #a40000;
        margin-top: 6px;
        margin-right: 10px;
    }
    .dropzone-parent-trash-shakkhes{
        display: flex;
        align-items:center;
        justify-content: space-between;
        flex-direction: row;
        width:100% !important;
    }
    .dropzone-btn-trash i{
        margin-left:0 !important;
    }
    #preview-gallery{
        display:grid;
        grid-template-columns: repeat(4, 1fr);
        gap:3px;
    }
</style>

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">

                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/lottery/list?section={$lottery['section']}">
                        لیست قرعه کشی ها
                    </a>
                </li>
                <li class='active'>
                    ویرایش
                    <span class='font-bold underdash'>{$lottery['title']}</span>
                </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <form data-toggle="validator" method="post" id="editLottery" enctype='multipart/form-data'>
            <input type="hidden" name="className" value="lottery">
            <input type="hidden" name="method" value="UpdateLottery">
            <input type="hidden" name="lottery_id" value="{$lottery.id}">

            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">


                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>اطلاعات پایه</h4>
                        </div>

                        <hr class='m-0 mb-4 w-100'>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="title">عنوان Title</label>
                                <input type="text" class="form-control" name="title" id="title"
                                       placeholder=""
                                       value="{$lottery.title}">
                            </div>
                        </div>


                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="content">متن</label>
                                <textarea name="description" id="description" class="form-control"
                                          placeholder="محتوای مطلب">{$lottery.description}</textarea>
                            </div>
                        </div>

                    </div>

                </div>
                {if isset($lottery['gallery'])}
                    <div class='d-flex justify-content-between align-content-center flex-wrap w-100 mt-2'>
                        <h4 class='align-items-center d-flex flex-wrap font-bold gap-10 m-0 px-4 py-3'>
                            جوایز
                        </h4>
                        <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                              data-toggle="tooltip" data-placement="top" title=""
                              data-original-title="نمایش جوایز "></span>
                    </div>
                    <hr class='m-0 mb-4 w-100'>
                    <div class='d-flex flex-wrap gap-10  p-10 w-100 '>
                        {foreach $lottery['gallery'] as $key=>$file}

                            <div class="align-items-center flex-wrap gap-10 dropzone-parent-box d-flex justify-content-between p-3 pip rounded-xl ">


                                <img class="border d-flex imageThumb rounded-xl"
                                     src='{$file['src']}'
                                     title="" width="50px" style="width:50px !important;" height="50px">

                                <div class='dropzone-parent-trash-shakkhes'>
                                    <button class='dropzone-btn-trash w-0 mb-0 remove text-danger justify-content-center'
                                            type='button'
                                            onclick='SubmitRemoveArticleGallery("{$file['id']}",$(this))'
                                            data-index="0"
                                            style="width:0 !important;"
                                    >
                                        <i class="fa fa-trash m-0" aria-hidden="true"></i>

                                    </button>
                                    <div class="prize-checkbox-wrapper existing-image" data-gallery-id="{$file['id']}">
                                        <span>جایزه</span>
                                        <input type="checkbox"
                                               class="existing-checkbox"
                                               data-gallery-id="{$file['id']}"
                                               style="margin-top:10px;"
                                               {if $file['is_prize'] == 1}checked{/if}>
                                        <input type="hidden" class="existing-prize-value" name="existing_is_prize[{$file['id']}]" value="{$file['is_prize']}">
                                    </div>
                                </div>
                            </div>
                        {/foreach}
                    </div>
                {/if}
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">


                    <div class=" d-flex bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='align-items-center d-flex flex-wrap font-bold gap-10 m-0 px-4 py-3'>
                                آپلود جوایز
                            </h4>
                            <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                  data-toggle="tooltip" data-placement="top" title=""
                                  data-original-title="تصاویر خود را انتخاب یا در کادر بکشید"></span>
                        </div>


                        <hr class='m-0 mb-4 w-100'>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for='gallery_files'
                                   id="drop_zone"
                                   class='d-flex flex-wrap justify-content-center align-items-center border-dashed border-primary p-5 w-100'
                                   ondrop="dropHandler(event,true);"
                                   ondragover="dragOverHandler(event);">
                                <p>تصاویر خود را انتخاب یا در کادر بکشید</p>
                            </label>
                        </div>


                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="d-flex flex-wrap form-group gap-5 w-100">
                                <label for="gallery_files" class="control-label d-none">انتخاب فایل ها</label>
                                <input onchange="dropHandler(event,true)" type='file' accept="image/*,pdf"
                                       class=' d-none'
                                       multiple name='gallery_files[]' id='gallery_files'>

                                <div id='preview-gallery' class="w-100"></div>
                            </div>
                        </div>


                    </div>


                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='align-items-center d-flex flex-wrap font-bold gap-10 m-0 px-4 py-3'>
                                تصویر شاخص
                            </h4>
                            <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                  data-toggle="tooltip" data-placement="top" title=""
                                  data-original-title=" تصویر اصلی این مقاله"></span>
                        </div>


                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group selected_image">
                                <label for="cover_image">تصویر شاخص </label>
                                {if $lottery.cover_image}
                                    <a  data-id="{$lottery.id}"  class='btn btn-primary delete-fara deleteArticleImage' style='float: left'>
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                        حذف تصویر
                                    </a>
                                {/if}
                                <input type="file" class="form-control-file dropify" name="cover_image"
                                       id="cover_image"
                                       data-default-file="/gds/pic/{$lottery.cover_image}">


                            </div>
                        </div>
                    </div>


                </div>

            </div>
            <div class=' col-12 d-flex  align-items-center justify-content-center w-100 parentbtn-btn-fixed'>
                <button class="btn btn-success btn-block btn-fixed" type="submit">ذخیره</button>
            </div>
        </form>
    </div>
</div>
<script src="assets/js/dropzone.js"></script>
<script>

  $(document).ready(function() {
    setTimeout(function() {
      removeSelect2()
      initializeSelect2Search()
    }, 500)
  })
</script>
<script type="text/javascript" src="assets/JsFiles/lottery.js"></script>
