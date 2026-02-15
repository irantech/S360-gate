{load_presentation_object filename="recommendation" assign="recommendations"}


{if !isset($smarty.get.id)}
    {header("Location: {$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/recommendation/list")}
{/if}
{assign var="recommendation" value=$recommendations->getRecommendation($smarty.get.id)}
{if !$recommendation}
    {header("Location: {$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/recommendation/list")}
{/if}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">

                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/recommendation/list">
                        لیست سفرنامه ها
                    </a>
                </li>
                <li class='active'>
                    ویرایش سفرنامه
                    <span class='font-bold underdash'>{$recommendation['fullName']}</span>
                </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <form data-toggle="validator" method="post" id="editRecommendation" enctype='multipart/form-data'>
            <input type="hidden" name="className" value="recommendation">
            <input type="hidden" name="method" value="updateRecommendation">
            <input type="hidden" name="recommendation_id" value="{$recommendation.id}">
            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">


                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>اطلاعات پایه</h4>
                        </div>

                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label class="control-label d-flex justify-content-between" for="user_information">
                                اطلاعات کابر
                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="left"
                                      title="اطلاعات مربوط به کاربر"></span>
                            </label>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="fullName">نام کاربر</label>
                                    <input type="text" class="form-control" name="fullName" id="fullName"
                                           placeholder="نام و نام خانوادگی کاربر" value="{$recommendation.fullName}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="profession">سمت کاربر</label>
                                    <input type="text" class="form-control" name="profession" id="profession"
                                           placeholder="سمت کاربر" value="{$recommendation.profession}">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="content">محتوای نظر کاربر</label>
                                <textarea name="content" class="ckeditor form-control"
                                          placeholder="محتوای مطلب">{$recommendation.content}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group ">
                                <label class="control-label" for="slug">
                                    لینک آی فریم

                                    <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                          data-toggle="tooltip" data-placement="left"
                                          title="ویدیو شما شامل لینک آیفریم باشد."></span>
                                    {include file="{$smarty.const.FRONT_CURRENT_ADMIN}/modules/iframeLink.tpl"}
                                </label>
                                <div class='align-items-center d-flex gap-10 justify-content-center dir-l'>
                                   <textarea type="text" class="form-control" name="video_link"
                                             id="video_link" placeholder=" لینک آیفریم مورد نظر">{$recommendation.video_link}</textarea>
                                </div>
                            </div>
                        </div>

                        <div data-name='service' class="bg-white d-flex flex-wrap rounded w-100 ">
                            <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                                <h4 class='align-items-center d-flex flex-wrap font-bold gap-10 m-0 px-4 py-3'>
                                    اطلاعات ویزای مربوطه
                                </h4>

                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title="نمایش در نتایج جستجو این اطلاعات"></span>

                            </div>

                            <hr class='m-0 mb-4 w-100'>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="continent">قاره</label>
                                    <select onchange='getCountries($(this))'  value="{$recommendation.continent}" name="continent" id="continent" class="form-control select2">
                                        <option value="">انتخاب کنید</option>
                                        {foreach $recommendations->getContinentList() as $continent}
                                            <option {if $continent['id'] == $recommendation.continent.id}selected{/if}
                                                    value="{$continent['id']}" >{$continent['titleFa']}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="continent">کشور</label>
                                    <select name="country"  id="country" class="form-control select2">
                                        <option value="">انتخاب کنید</option>
                                        {foreach $recommendations->getCountryListByContinentId(['continent_id' => $recommendation.continent.id]) as $country}
                                            <option {if $country['id'] == $recommendation.country.id}selected{/if}
                                                    value="{$country['id']}" >{$country['titleFa']}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>
                            <hr class=' w-100'>
                            <div data-name='positions' class='d-flex w-100 flex-wrap'>
                                <div data-name='position' class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label" for="continent">نوع ویزا</label>

                                        <select name="visa_type"
                                                id="visa_type" class="form-control select2">
                                            <option value="">انتخاب کنید</option>
                                            {foreach $recommendations->getVisaTypeList() as $visaType}
                                                <option {if $visaType['id'] == $recommendation.visa_type.id}selected{/if}
                                                        value="{$visaType['id']}">{$visaType['title']}</option>
                                            {/foreach}
                                        </select>
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
                                  data-original-title="نمایش مقاله بر اساس زبان وبسایت شما"></span>
                        </div>


                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="language" class="control-label">زبان</label>
                                <select name="language" class="form-control" id="language">
                                    {foreach $languages as $value=>$title}
                                        <option {if $value == $recommendation.language}selected{/if}
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
                                       data-default-file="{$recommendation.avatar_image}">

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


<script type="text/javascript" src="assets/JsFiles/recommendations.js"></script>