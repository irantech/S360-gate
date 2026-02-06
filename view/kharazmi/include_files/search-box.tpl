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

<section class="i_modular_banner_gallery __banner_tabs__ banner-kanoun">
    <div class="owl-carousel owl-theme owl-banner-kanoun">
        {foreach $banners as $key => $banner}
        <div class="item">
            <img src="{$banner['pic']}" alt="{$banner['title']}">
        <div class="banner-text-kanoun">
        <h5>{$banner['title']}</h5>
        <h2>{$banner['description']}</h2>
        </div>
        </div>
        {/foreach}

    </div>
    <div class="container">
        <div class="i_modular_searchBox search-box" id="btn-search-header-searchBox">
            <div class="">
                <div class="parent-search-box">
                <ul class="__search_box_tabs__ nav nav-tabs" id="myTab" role="tablist">{include file="./search-box/tabs-search-box.tpl"}</ul>
                <div class="__search_boxes__ tab-content" id="myTabContent">{include file="./search-box/boxs-search.tpl"}</div>
                </div>
            </div>
        </div>
</div>
</section>
