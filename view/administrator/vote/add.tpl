{load_presentation_object filename="vote" assign="objvote"}
{assign var="languages" value=['fa'=>'فارسی','en'=>'English','ar'=>'العربیه']}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-3 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/vote/list">
                        لیست سوالات نظرسنجی
                    </a>
                </li>
                <li class="active">سوالات نظرسنجی</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <form data-toggle="validator" id="add_vote" method="post"  enctype="multipart/form-data">
            <input type='hidden' value='insertVote' id='method' name='method'>
            <input type='hidden' value='vote' id='className' name='className'>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">

                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>پرسش جدید</h4>
                        </div>
                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="title">عنوان</label>
                                <input type="text" class="form-control" name="title" id="title"
                                       placeholder="عنوان">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="language" class="control-label">زبان</label>
                                <select name="language" class="form-control" id="language">
                                    {foreach $languages as $value=>$title}
                                        <option value="{$value}" >{$title}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                        <div class="bg-white d-flex flex-wrap rounded w-100 ">
                            <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                                <h6 class='d-flex flex-wrap font-bold m-0 py-3 px-4'> پاسخ جدید</h6>
                            </div>
                            <hr class='m-0 mb-4 w-100'>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 duplicate-form1">
                                <div class="row duplicate-item myform1">
                                    <div class="form-group col-sm-12 ">

                                        <div class="col-sm-12 p-0 form-group">
                                            <div class="col-md-6 pr-0">
                                                <input name="vote_item[question][]" placeholder="پاسخ"
                                                       class="form-control" id="vote_item_question"
                                                       type="text">
                                            </div>

                                            <div class="col-md-2 d-flex gap-10 p-0">
                                                <div class="col-md-6 p-0">
                                                    <button type="button"
                                                            class="btn rounded form-control btn-success plus1">
                                                        <span class="fa fa-plus"></span>
                                                    </button>
                                                </div>
                                                <div class="col-md-6 p-0 minus1"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
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

<script type="text/javascript" src="assets/JsFiles/vote.js">
  <script src="assets/js/mag-jquery-dropzone.js"></script>



<script>
  $(document).on('click','.plus1',function(){
    clone =$(this).closest('.duplicate-form1').find('.duplicate-item').clone();
    clone.find('input[type="text"]').val("");
    clone.removeClass('duplicate-item');
    $('.duplicate-form1').append(clone);
    clone.find(".minus1").last().append('<a type="button"\n' +
      'class="btn rounded form-control btn-danger min1">\n' +
      '<span class="fa fa-remove"></span>\n' +
      '</a>');
  });
  $(document).on('click','.min1',function(){
    $(this).closest(".myform1").remove();
  });

</script>


