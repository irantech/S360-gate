{load_presentation_object filename="faqs" assign="faqs"}
{assign var="getServices" value=$faqs->getServices()}


{assign var="section" value=$smarty.get.section}

{*<code>{$getServices['Public']|json_encode}</code>*}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">

                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/faqs/list">
                        سوالات متداول
                    </a>
                </li>

                <li class="active"> تعریف سوال متداول جدید</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <form data-toggle="validator" method="post" id="addFaq" enctype='multipart/form-data'>
            <input type="hidden" name="className" value="faqs">
            <input type="hidden" name="method" value="addFaq">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">


                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>اطلاعات پایه</h4>
                        </div>

                        <hr class='m-0 mb-4 w-100'>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="title">عنوان سوال متداول</label>
                                <input type="text" class="form-control" name="title" id="title"
                                       placeholder="عنوان ؟">
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="content">پاسخ به پرسش</label>
                                <textarea name="content" id="content" class="ckeditor form-control"
                                          placeholder="محتوا"></textarea>
                            </div>
                        </div>

                    </div>


                    {include file="{$smarty.const.FRONT_CURRENT_ADMIN}/modules/position/new.tpl"
                            getServices=$getServices object=$faqs}



                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">

                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='align-items-center d-flex flex-wrap font-bold gap-10 m-0 px-4 py-3'>
                                زبان
                            </h4>
                            <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                  data-toggle="tooltip" data-placement="top" title=""
                                  data-original-title="نمایش سوالات متداول بر اساس زبان وبسایت شما"></span>
                        </div>


                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="language" class="control-label">زبان</label>
                                <select name="language" class="form-control" id="language">
                                    {foreach $languages as $value=>$title}
                                        <option value="{$value}">{$title}</option>
                                    {/foreach}
                                </select>
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


<script type="text/javascript" src="assets/JsFiles/articles.js"></script>
<script src="assets/js/blog-jquery-dropzone.js"></script>

<script type="text/javascript">

  /* function rebuildGallery(added_files) {
 const gallery_preview= $('#gallery_preview');
     gallery_preview.html('')
     added_files.forEach(function(item){

       gallery_preview.append('<img class="col-md-3" src="'+item.dataURL+'" />')

     })
   }*/

  let added_files = []
  myDropzone.on('thumbnail', function(file, dataURL) {

    console.log('file', file)
    added_files.push(file)


  })

  function setAsSelectedImage(_this, file_name) {
    const selectedImageName = $('input[name="selectedImageName"]')
    const selectedImageRow = $('input[name="selectedImageRow"]')

    $('#previews').find('.btn-actions').each(function() {
      $(this).find('.btn-primary').addClass('btn-outline')
    })
    _this.removeClass('btn-outline')
    selectedImageName.val(file_name)
  }

  $(document).ready(function() {

  })
</script>