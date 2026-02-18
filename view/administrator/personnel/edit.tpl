{load_presentation_object filename="personnel" assign="personnels"}

{assign var="personnel" value=$personnels->getPersonnel($smarty.get.id)}
{assign var="socialMediaList" value=[
'instagram' => 'اینستاگرام' ,
'telegram' => 'تلگرام' ,
'linkedin' => 'لینکدین' ,
'whatsapp' => 'واتس اپ' ,
'twitter' => 'توییتر' ,
'youTube' => 'یوتیوب' ,
'pinterest' => 'پینترست',
'ita' => 'ایتا',
'bale' => 'بله'
]}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">

                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/personnel/list">
                        لیست پرسنل
                    </a>
                </li>
                <li class='active'>
                    ویرایش پرسنل
                    <span class='font-bold underdash'>{$personnel['name']}</span>
                </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <form data-toggle="validator" method="post" id="editPersonnel" enctype='multipart/form-data'>
            <input type="hidden" name="className" value="personnel">
            <input type="hidden" name="method" value="updatePersonnel">
            <input type="hidden" name="personnel_id" value="{$personnel.id}">
            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">


                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>اطلاعات پایه</h4>
                        </div>

                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="name">نام کاربر</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                           placeholder="نام و نام خانوادگی کاربر" value="{$personnel.name}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="position">سمت</label>
                                    <input type="text" class="form-control" name="position" id="position"
                                           placeholder="سمت کاربر" value="{$personnel.position}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="education">تحصیلات</label>
                                    <input type="text" class="form-control" name="education" id="education"
                                           placeholder="تحصیلات کاربر" value="{$personnel.education}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="experience">سابقه</label>
                                    <input type="text" class="form-control" name="experience" id="experience"
                                           placeholder="سابقه کاربر" value="{$personnel.experience}">
                                </div>
                            </div>
                            <div class="form-group col-sm-12">
                                <label class="control-label">شبکه های اجتماعی</label>
                                <div class="row">

                                    <div class="form-group col-sm-12 DynamicSocialLinks">



                                        {assign var="socialLinks" value=$personnel.social_media}
                                        {if $socialLinks == '[]' }
                                            {assign var="socialLinks" value='[{"social_media":"","link":""}]'}
                                        {/if}

                                        {assign var="counter" value='0'}
                                        {foreach key=key item=item from=$socialLinks|json_decode:true}

                                            <div data-target="BaseSocialLinksDiv" class="col-sm-12 p-0 form-group">
                                                <div class="col-md-3 pr-0">
                                                    <select data-parent="SocialLinksValues" data-target="social_media" class="form-control" name="socialLinks[{$counter}][social_media]">
                                                        <option>انتخاب کنید</option>
                                                        {foreach $socialMediaList as $key => $social}
                                                            <option
                                                                    {if $key == $item.social_media}
                                                                        selected
                                                                    {/if}
                                                                    value="{$key}">{$social}</option>
                                                        {/foreach}
                                                    </select>
                                                </div>
                                                <div class="col-md-8">
                                                    <input data-parent="SocialLinksValues" data-target="link" name="socialLinks[{$counter}][link]" placeholder="لینک" class="form-control text-right"
                                                           value="{$item.link}" type="text">
                                                </div>
                                                <div class="col-md-1 pl-0 ">
                                                    <div class="col-md-6 p-0 pl-1">
                                                        <button type="button" onclick="AddSocialLinks()" class="btn form-control btn-success w-100 p-0">
                                                            <span class="fa fa-plus"></span>
                                                        </button>
                                                    </div>
                                                    <div class="col-md-6 p-0">
                                                        <button onclick="RemoveSocialLinks($(this))" type="button" class="btn form-control btn-danger w-100 p-0">
                                                            <span class="fa fa-remove"></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            {assign var="counter" value=$counter+1}
                                        {/foreach}

                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
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
                                  data-original-title="نمایش این پرسنل بر اساس زبان وبسایت شما"></span>
                        </div>


                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="language" class="control-label">زبان</label>
                                <select name="language" class="form-control" id="language">
                                    {foreach $languages as $value=>$title}
                                        <option {if $value == $personnel.language}selected{/if}
                                                value="{$value}">{$title}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>


                    </div>

                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='align-items-center d-flex flex-wrap font-bold gap-10 m-0 px-4 py-3'>
                                تصویر پروفایل
                            </h4>
                            <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                  data-toggle="tooltip" data-placement="top" title=""
                                  data-original-title=" تصویر پروفایل"></span>
                        </div>


                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="feature_image">تصویر پروفایل </label>
                                <input type="file" class="form-control-file dropify" name="feature_image"
                                       id="feature_image"
                                       data-default-file="{$personnel.image}">

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
<script>
  $(document).ready(function() {
    setTimeout(function() {
      removeSelect2()
      initializeSelect2Search()
    }, 500)
  })
</script>


<script type="text/javascript" src="assets/JsFiles/personnel.js"></script>