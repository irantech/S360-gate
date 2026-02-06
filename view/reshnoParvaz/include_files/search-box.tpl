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
    <div class="owl-carousel owl-theme owl-banner-kanoun">

        {foreach $banners as $key => $banner}
            <div class="__i_modular_nc_item_class_0 item">
                <img alt='{$banner["title"]}' class="__image_class__" src='{$banner["pic"]}' />
            </div>
        {/foreach}


    </div>
    <div class="container">
        <div class="parent-text-banner">
            <h2>آژانس مسافرتی رشنو پرواز</h2>
            <p class="__title__">آسمانی پر از رویاها، سفر به دنیایی از حس‌ها و لحظه‌های بی‌نظیر </p>
        </div>
        <div class="i_modular_searchBox container search_box_div">
            <ul class="__search_box_tabs__ nav"
                id="searchBoxTabs">{include file="./search-box/tabs-search-box.tpl"}</ul>
            <div class="__search_boxes__ tab-content"
                 id="searchBoxContent">{include file="./search-box/boxs-search.tpl"}</div>
        </div>
    </div>
</section>
