{load_presentation_object filename="aboutUs" assign="objAbout"}
 {assign var="aboutUsData" value=$objAbout->GetData($smarty.get.lang)}

{assign var="socialMediaList" value=[
    'instagram' => 'اینستاگرام' ,
    'telegram' => 'تلگرام' ,
    'linkedin' => 'لینکدین' ,
    'whatsapp' => 'واتس اپ' ,
    'twitter' => 'توییتر' ,
    'youTube' => 'یوتیوب' ,
    'pinterest' => 'پینترست',
    'ita' => 'ایتا',
    'bale' => 'بله',
    'aparat' => 'آپارات'
]}




<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="active"> درباره ی ما</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">درباره ی ما</h3>


                <form class='aboutUsUpdate' id='aboutUsUpdate' method="post" enctype='multipart/form-data'>

                    <input type='hidden' name='className' value='aboutUs'>
                    <input type='hidden' name='method' value='update'>
{*                    {if $smarty.get.lang}*}
{*                        <input type='hidden' name='lang' value='{$smarty.get.lang}'>*}
{*                    {else}*}
{*                        <input type='hidden' name='lang' value='fa'>*}
{*                    {/if}*}
                    <p class="text-muted m-b-30">اطلاعات زیر در صفحه ی
                        <a class='hover-text-underline text-megna'
                           href='https://{$smarty.const.CLIENT_DOMAIN}/gds/aboutUs' target='_blank'> درباره ی ما</a>
                        مشاهده کنید.
                    </p>
                    <div class='d-flex flex-wrap '>
                        <div class="bg-white d-flex flex-wrap rounded w-100 ">




                            <hr class='m-0 mb-4 w-100'>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="language" class="control-label">زبان</label>
                                    <select onchange='aboutUsLanguage(this.value);' name='lang' class="form-control" id="language">
                                        {foreach $languages as $value=>$title}
                                             <option {if $value eq $smarty.get.lang}selected{/if} value="{$value}">{$title}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>


                        </div>
                        <div class='d-block col-md-4 col-sm-12 form-group'>
                            <label for='title'>
                                عنوان
                            </label>
                            <input type='text' class='form-control' id='title' name='title'
                                   value="{$aboutUsData['title']}">
                        </div>
                        <div class='d-none col-md-4 col-sm-12 form-group'>
                            <label for='summary'>
                                خلاصه ی توضیحات
                            </label>
                            <textarea id='summary' name='summary' class='form-control'>{$aboutUsData['summary']}</textarea>
                        </div>
                        <div class='d-block col-md-4 col-sm-12 form-group'>

                            <div class="form-group col-sm-6">
                                <label for="banner_file" class="control-label">تصویر بنر</label>
                                <input type="file" name="banner_file" id="banner_file" class="dropify" data-height="100"
                                       data-default-file="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/aboutUs/{$aboutUsData['banner_file']}">
                                {if $aboutUsData['banner_file']}
                                <a  data-id="{$aboutUsData['id']}"  class='btn btn-primary delete-fara deleteImage' >
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                    حذف تصویر
                                </a>
                                {/if}
                            </div>



                        </div>
                        <div class='d-block col-md-12 col-sm-12 form-group'>
                            <label for='title'>
                                لینک ویدئو

                            </label>
                            <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                  data-toggle="tooltip" data-placement="top" title=""
                                  data-original-title=" در این قسمت تنها لینک ویدئو را قرار دهید"></span>
                            {include file="{$smarty.const.FRONT_CURRENT_ADMIN}/modules/iframeLink.tpl"}
                            <input type='text'  class='form-control' id='video_link' name='video_link' placeholder="در این قسمت لینک ویدئو را قرار دهید"
                                   value="{$aboutUsData['video_link']}">
                        </div>

                        <div class="form-group col-sm-12">
                            <label class="control-label">شبکه های اجتماعی</label>
                            <div class="row">

                                <div class="form-group col-sm-12 DynamicSocialLinks">

                                        {if $aboutUsData['social_links'] eq 'null'}
                                            {assign var="socialLinks" value='[{"social_media":"","link":""}]'}
                                        {else}
                                            {assign var="socialLinks" value=$aboutUsData['social_links']}
                                        {/if}

                                    {assign var="counter" value='0'}
                                    {foreach key=key item=item from=$socialLinks|json_decode:true}

                                        <div data-target="BaseSocialLinksDiv" class="col-sm-12 p-0 form-group">
                                            <div class="col-md-3 pr-0">
                                                <select data-parent="SocialLinksValues" data-target="social_media" class="form-control" name="socialLinks[{$counter}][social_media]">
                                                    <option>انتخاب کنید</option>
                                                    {foreach $socialMediaList as $key => $social}
                                                        <option {if $key == $item.social_media}selected{/if} value="{$key}">{$social}</option>
                                                    {/foreach}
                                                </select>
                                            </div>
                                            <div class="col-md-8">
                                                <input data-parent="SocialLinksValues" data-target="link" name="socialLinks[{$counter}][link]" placeholder="لینک" class="form-control text-right"
                                                       value="{$item.link}" type="text">
                                            </div>
                                            <div class="col-md-1 pl-0">
                                                <div class="col-md-6 p-0">
                                                    <button type="button" onclick="AddSocialLinks()" class="btn form-control btn-success">
                                                        <span class="fa fa-plus"></span>
                                                    </button>
                                                </div>
                                                <div class="col-md-6 p-0">
                                                    <button onclick="RemoveSocialLinks($(this))" type="button" class="btn form-control btn-danger">
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



                    <div class='d-block flex-wrap w-100'>
                    <textarea class='w-100' name='body' id='body'>{$aboutUsData['body']}</textarea>
                    </div>
                    <div class='d-block flex-wrap w-100' style='margin-top: 20px'>
                        <label for='about_title_customer_club' style='font-size: 17px; margin: 10px auto;'>
                            عنوان باشگاه مشتریان شما
                        </label>
                        <input type='text' class='form-control' id='about_title_customer_club' name='about_title_customer_club'
                               value="{$aboutUsData['about_title_customer_club']}">
                    </div>
                    <div class='d-block flex-wrap w-100' style='margin-top: 20px'>
                        <label for="about_customer_club" class="control-label" style='font-size: 17px; margin: 10px auto;'>درباره باشگاه مشتریان شما</label>
                        <textarea class='w-100' name='about_customer_club' id='about_customer_club'>{$aboutUsData['about_customer_club']}</textarea>
                    </div>
                    <div class='d-block mt-5 flex-wrap w-100'>
                        <button type='submit' class='btn submit-button btn-primary btn-block'>
                            به روز رسانی
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>
{literal}
<script>
  $(document).ready(function() {
    $('.dropify').dropify()
    if ($('#body').length) {
      CKEDITOR.replace('body');
    }
    if ($('#about_customer_club').length) {
      CKEDITOR.replace('about_customer_club');
    }
  })
</script>
<script type="text/javascript" src="assets/JsFiles/aboutUs.js"></script>
{/literal}