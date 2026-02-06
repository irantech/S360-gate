{assign var="type_data" value=['is_active'=>1 , 'limit' =>10]}
{assign var='banners' value=$obj_main_page->galleryBannerMain($type_data)}
{if $page.files.main_file}
    {$banners = [0 => ['pic' => $page.files.main_file.src , 'title' => 'page']]}
{/if}
<style>
    .banner-slider-display {
        display: none !important;
    }
</style>

<section class="i_modular_banner_gallery banner-kanoun">
    {*            <section class=" banner-ghods">*}
    {*                <img class="sub-bg1" src="project_files/images/bg-sub.png" alt="img">*}
    {*                <div class="container">*}
    {*                    <div class='parent-forc'>*}
    {*                        <h2>مسافرین گرامی*}
    {*بدلیل به روزرسانی سایت آژانس قدس گشت ،*}
    {*برای اطلاع از تورهای داخلی و خارجی تا اطلاع ثانویی*}
    {*با شماره تماس 02188753060 لطفا تماس حاصل فرمایید</h2>*}
    {*                        <p>*}
    {*                            باتشکر از شما*}
    {*مدیریت آژانس قدس گشت*}
    {*                        </p>*}
    {*                    </div>*}
    {*                    <div class="parent-div-banner-grid">*}
    {*                        <div class="__i_modular_c_item_class_0 parent-text-banner">*}
    {*                            <h2 data-aos="fade-up" >{$banners[0]['title']}</h2>*}
    {*                            <p data-aos="fade-up" >*}
    {*                                {$banners[0]['description']}*}
    {*                            </p>*}
    {*                            <a data-aos="fade-up" data-aos-offset="300" data-aos-easing="ease-in-sine"  href="{$banners[0]['link']}" class="btn-link-banner-more">*}
    {*                                اطلاعات بیشتر*}
    {*                                <i class="fa-solid fa-arrow-left"></i>*}
    {*                            </a>*}

    {*                            <img class="__image_class__ arrow-banner1" src="project_files/images/flesh.png" alt="img">*}
    {*                        </div>*}
    {*                        <div  class="parent-img-banner" >*}
    {*                                <img class="img-original" src="project_files/images/bg2.png" alt="img" data-follow="50" data-aos="fade-up" >*}
    {*                                <img class="img-sub1" src="project_files/images/abr.png" alt="img" data-follow="30" data-aos="fade-up" >*}
    {*                                <img class="img-sub2" src="project_files/images/abr.png" alt="img" data-follow="30" data-aos="fade-up" >*}
    {*                                <img class="img-sub3" src="project_files/images/abr.png" alt="img" data-follow="30" data-aos="fade-up" >*}
    {*                            </div>*}
    {*                    </div>*}
    {*                </div>*}
    {*                <video src="project_files/video/banner-ghods.mp4" autoplay loop></video>*}
    {*            </section>*}
    <div class="owl-carousel owl-theme owl-banner-kanoun">

        {foreach $banners as $key => $banner}
            <a class="__i_modular_nc_item_class_0 item" {if $banner["url"] neq ''} href='{$banner["url"]}' {else} href='javascript:' {/if}>
                <img alt='{$banner["title"]}' class="__image_class__" src='{$banner["pic"]}' />
            </a>
        {/foreach}


    </div>
    <section class="search_box" data-aos="fade-up">
        {*            <img alt="img" class="sub-bg2" src="project_files/images/flesh.png"/>*}
        <div class="container search_box_div">
            {include file="./search-box/tabs-search-box.tpl"}
            {include file="./search-box/boxs-search.tpl"}
        </div>
    </section>
</section>


