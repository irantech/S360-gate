{load_presentation_object filename="infoPages" assign="objInfoPages"}
{assign var="page" value=$objInfoPages->getInfoPageById($smarty.get.id)}

{assign var="has_destination" value=['Flight','Train','Bus','Tour']}
{*another has_destination var is in javascript*}
{if isset($page.service)}
    {assign var="listAllPositions" value=$objInfoPages->listAllPositions($page.service.service)}
    {else}
    {assign var="listAllPositions" value=$objInfoPages->listAllPositions('Flight')}
{/if}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">

                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/page_information/main">عنوان صفحات</a></li>
{*                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/page_information/list?service={$service}&type={$type}">لیست عنوان صفحات</a></li>*}
                <li class='active'>
                    ویرایش صفحه ی
                    {if isset($page.service)}
                    {$page.service.origin_name}
                    به
                    {$page.service.destination_name}

                        {else}
                    {$page.switch.title}
                    {/if}


                </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <form data-toggle="validator" method="post" id="page_information_form" enctype='multipart/form-data'>
            <input type="hidden" name="className" value="infoPages">
            <input type="hidden" name="id" value="{$page.id}">
            <input type="hidden" name="method" value="updatePageInformation">
            {*            <input type="hidden" name="page_id" value="{$faq.id}">*}
            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">


                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>اطلاعات پایه</h4>
                        </div>

                        <hr class='m-0 mb-4 w-100'>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="title">عنوان title</label>
                                <input type="text" class="form-control" name="title" id="title"
                                        value='{$page.title}'
                                       placeholder="قوانین و مقررات | ایران تکنولوژی">
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="title">عنوان h1</label>
                                <input type="text" class="form-control" name="heading" id="heading"
                                        value='{$page.heading}'
                                       placeholder="قوانین و مقررات">
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="description">متن کوتاه</label>
                                <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                      data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title="متن سئو، حداکثر ( 160 ) حرف"></span>
                                <textarea id='description' maxlength='160' name="description" class="form-control"
                                          placeholder="متن مربوطه">{$page.description}</textarea>
                            </div>
                        </div>


                    </div>


                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>meta tag</h4>
                        </div>
                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">

                                <div class="form-group col-sm-12 DynamicAddedMeta">


                                    {assign var="AddedMeta" value=$page['meta_tags']}
                                    {if $AddedMeta eq ''}
                                        {assign var="AddedMeta" value=['name'=>'','content'=>'']}
                                    {/if}

                                    {assign var="counter" value='0'}
                                    {foreach key=key item=item from=$AddedMeta}
                                        <div data-target="BaseAddedMetaDiv" class="col-sm-12 p-0 form-group">
                                            <div class="col-md-3 pr-0">
                                                <input data-parent="AddedMetaValues" data-target="name"
                                                       name="AddedMeta[{$counter}][name]" placeholder="name"
                                                       class="form-control"
                                                       value="{$item.name}" type="text">
                                            </div>
                                            <div class="col-md-7 pr-0">
                                                <input data-parent="AddedMetaValues" data-target="content"
                                                       name="AddedMeta[{$counter}][content]" placeholder="content"
                                                       class="form-control"
                                                       value="{$item.content}" type="text">
                                            </div>
                                            <div class="col-md-2 d-flex gap-10 p-0">
                                                <div class="col-md-6 p-0">
                                                    <button type="button" onclick="AddAddedMeta()"
                                                            class="btn rounded form-control btn-success">
                                                        <span class="fa fa-plus"></span>
                                                    </button>
                                                </div>
                                                <div class="col-md-6 p-0">
                                                    <button onclick="RemoveAddedMeta($(this))" type="button"
                                                            class="btn rounded form-control btn-danger">
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
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">

                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='align-items-center d-flex flex-wrap font-bold gap-10 m-0 px-4 py-3'>
                                آدرس صفحه
                            </h4>
                            <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                  data-toggle="tooltip" data-placement="top" title=""
                                  data-original-title="نمایش اطلاعات در صفحه ی مشخص شده"></span>
                        </div>


                        <hr class='m-0 mb-4 w-100'>

                        <div class="plans w-100 col-md-12">
                            <div class="d-flex flex-wrap gap-10 w-100">
                                <label class="plan basic-plan w-100 m-0" for="main_page">
                                    <input {if $page.type eq 'main'} checked {/if} type="radio" onchange='toggleable($(this));'
                                           value='main_page'
                                           name="page_type"
                                           id="main_page" />
                                    <div class="plan-content w-100 p-2">
                                        <div class="plan-details mr-42">
                                            <span style='font-size: 17px;'>صفحات داخلی</span>
                                            <p style='font-size: 11px;'>ویرایش نام صفحات داخلی</p>
                                        </div>
                                    </div>
                                </label>

                                <label class="plan complete-plan w-100 m-0" for="main_services">
                                    <input type="radio" onchange='toggleable($(this))'
                                            {if $page.type eq 'service'} checked {/if}
                                           id="main_services"
                                           value='main_services'
                                           name="page_type" />
                                    <div class="plan-content w-100 p-2">
                                        <div class="plan-details mr-42">
                                            <span style='font-size: 17px;'>صفحات نتایج جستجو</span>
                                            <p style='font-size: 11px;'>
                                                ویرایش نام صفحات نتایج جستجوی سرویس های شما
                                            </p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>


                        <div class="w-100 mt-5 {if $page.type eq 'main'} d-flex {else} d-none {/if}  flex-wrap mt-5 main_page-toggleable">
                            <div class="col-sm-12 col-xs-12 col-md-12 w-100">
                                <div class="form-group">
                                    <label class="control-label" for="switch">نام صفحه</label>
                                    <select name="switch" id="switch"
                                            class="form-control select2">
                                        <option value="" disabled>انتخاب کنید</option>
                                        {foreach $objInfoPages->getGdsSwitches() as $item}
                                            <option {if $page.switch_id eq $item['id']} selected {/if} value="{$item['id']}">{$item['title']}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="w-100 mt-5 {if $page.type eq 'service'} d-flex {else} d-none {/if} flex-wrap mt-5 main_services-toggleable">
                            <div class="col-sm-12 col-xs-12 col-md-12 w-100">
                                <div class="form-group">
                                    <label class="control-label" for="service1">سرویس</label>
                                    <select onchange="getServicePositions($(this))" name="service" id="service1"
                                            class="form-control select2">
                                        <option value="">انتخاب کنید</option>
                                        {foreach $objInfoPages->getServices() as $service}
                                            <option {if isset($page.service) && $page.service.service eq $service['MainService']} selected {/if} value="{$service['MainService']}">{$service['Title']}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>
                            <hr class=' w-100'>
                            <div data-name='positions' class='d-flex w-100 flex-wrap'>


                                <div data-name='position' class="col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="align-items-center control-label d-flex flex-wrap justify-content-between"
                                               for="origin_position">
                                            مبداء
                                            <button disabled type="button"
                                                    onclick="removePosition($(this))"
                                                    class="btn btn-default p-1 font-12 gap-2 rounded">
                                                <span class="fa fa-trash"></span>
                                                حذف
                                            </button>
                                        </label>

                                        <select name="origin_position"
                                                id="origin_position" class="form-control select2">
                                            <option value="all">مبداء</option>
                                            {foreach $listAllPositions as $value=>$position}
                                                <option {if isset($page.service) && $page.service.origin eq $value} selected {/if} value="{$value}">{$position.name}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>



                                <div data-name='position' class="col-sm-12 col-xs-12 {if isset($page.service) && !in_array($page.service.service,$has_destination)} d-none {/if}">
                                    <div class="form-group">
                                        <label class="align-items-center control-label d-flex flex-wrap justify-content-between"
                                               for="destination_position">
                                            مقاصد
                                            <button disabled type="button"
                                                    onclick="removePosition($(this))"
                                                    class="btn btn-default p-1 font-12 gap-2 rounded">
                                                <span class="fa fa-trash"></span>
                                                حذف
                                            </button>
                                        </label>

                                        <select name="destination_position"
                                                id="destination_position" class="form-control select2">
                                            <option value="all">مقاصد</option>
                                            {foreach $listAllPositions as $value=>$position}
                                                <option {if isset($page.service) && $page.service.destination eq $value} selected {/if} value="{$value}">{$position.name}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>


                            </div>
                        </div>


                    </div>


                </div>


                <div class="d-flex mt-4 flex-wrap gap-10">

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
                                        <option {if $page.language eq $value} selected {/if} value="{$value}">{$title}</option>
                                    {/foreach}
                                </select>
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
{*<script src="assets/js/jquery-dropzone.js"></script>

<script type="text/javascript">
    myDropzone.on('sending', function (file, xhr, formData) {
        formData.append('flag', 'insert_Gallery');
        formData.append('id', '{$EntertainmentData['id']}');
    });
    myDropzone.on("success", function(file, response) {
        GetEntertainmentGalleryData("{$EntertainmentData['id']}");

    });
    $(document).ready(function (){
        GetEntertainmentGalleryData("{$EntertainmentData['id']}");
    });
</script>*}

<script type="text/javascript" src="assets/modules/js/page_information/page_information.js"></script>