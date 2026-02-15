{load_presentation_object filename="fullCapacityAdmin" assign="objFullCapacityAdmin"}
{assign var="type_data" value=['is_active'=>1]}
{assign var="list_item_admin" value=$objFullCapacityAdmin->listFullCapacityAdmin($type_data)}

{load_presentation_object filename="fullCapacity" assign="objFullCapacity"}
{assign var="info_pic" value=$objFullCapacity->getFullCapacity(1)}
{*
توضیح برای برنامه نویس
آی دی 1 نباید از جدول full_capacity_tb  حذف شود
این صفحه با آی دی یک این جدول کار می کند
*}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-3 col-md-6 col-xs-12">
                <ol class="breadcrumb FloatRight">
                    <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                    <li class="active">تغییر تصویر</li>
                </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">
                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>تغییر تصویر</h4>
                        </div>


                        <hr class='m-0 mb-4 w-100'>

                        <div class="container">
                            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 warning' >

                                <p class="text-muted m-b-30 ">
                                    <img src='assets/images/warning.png'>
                                    از این قسمت شما می توانید تصویر ظرفیت نتایج سیستم خود را تغییر دهید
                                    <br>
                                    برای تغییر تصویر می توانید یکی از تصاویر پیشنهادی ادمین را انتخاب نموده یا تصویر جدیدی آپلود نمائید
                                    <br>
                                    پسوندهای مجاز برای آپلود تصویر jpeg و jpg و png می باشد
                                </p>
                            </div>
                            <br>
                            <h4>پیشنهاد ما </h4>
                            <p>در صورت تمایل تصویر جدیدی آپلود نمائید</p>
                            <form data-toggle="validator" id="images_select"  method="post"  enctype="multipart/form-data">
                                <input type='hidden' value='changePic' id='method' name='method'>
                                <input type='hidden' value='fullCapacity' id='className' name='className'>
                                <input type='hidden' value='{$info_pic['id']}' id='id' name='id'>
                                {if $list_item_admin != ''}
                                {foreach key=key item=item from=$list_item_admin}
                                <label class="radio-inline">
                                    <input type="radio" name="item_select" value="{$item.id}" id="item_select_{$item.id}" {if $info_pic['item_select']==$item.id} checked {/if} onclick="noChangeImage()">
                                    {if $item.pic}
                                            <img src='{$item.pic}' width='100' height='100'>
                                    {/if}
                                </label>
                                {/foreach}
                                {/if}

                                <label class="radio-inline"  style='margin: 0 30px; opacity: 0.6;'>
                                    <input type="radio" name="item_select" value="pic_0" id="item_select_0" {if  $info_pic['item_select']==0} checked {/if}  onclick="uploadNewImage()">
                                        <img src='assets/images/upload.png' width='100' height='100'>

                                </label>

                                <hr>

                                <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 box-upload-fara' id="selectItem"   {if $info_pic['item_select']==0} style='display: block' {else} style='display: none' {/if}>
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label" for="title">عنوان تصویر</label>
                                            <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                                  data-toggle="tooltip" data-placement="top" title=""
                                                  data-original-title=" عنوان تصویر را وارد نمائید"></span>
                                            <input type="text" class="form-control" name="title" id="title" {if $info_pic['title']} value='{$info_pic['title']}' {/if}
                                                   placeholder="عنوان را وارد نمایید">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="pic" class="control-label">تصویر</label>
                                            <input type="file" name="pic" id="pic" {if $info_pic['pic']} value='{$info_pic['pic']}' data-default-file="{$info_pic['pic']}" {/if}
                                                   class="dropify" data-height="100" />
                                        </div>
                                    </div>
                                </div>

                                <div class='col-12 d-flex align-items-center justify-content-center w-100 parentbtn-btn-fixed'>
                                    <button class="btn btn-success btn-block btn-fixed" type="submit">ذخیره</button>
                                </div>
                            </form>
                        </div>







                        <hr class='m-0 mb-4 w-100'>

                    </div>

                </div>
            </div>


    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
</div>
<script>
  function uploadNewImage() {
    var x = document.getElementById("selectItem");

      x.style.display = "block";

  }
  function noChangeImage() {
    var x = document.getElementById("selectItem");

      x.style.display = "none";
    if ($(this).val() == 1) {
      $(this).prop('checked', true);
    }

  }
</script>

<script type="text/javascript" src="assets/JsFiles/fullCapacity.js">

