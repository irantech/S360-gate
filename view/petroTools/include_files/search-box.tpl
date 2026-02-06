{assign var="type_data" value=['is_active'=>1 , 'limit' =>10]}
{assign var='banners' value=$obj_main_page->galleryBannerMain($type_data)}
{if $page.files.main_file}
    {$banners = [0 => ['pic' => $page.files.main_file.src , 'title' => 'page']]}
{/if}

<section class="i_modular_banner_gallery position-relative">

    <div class="banner-demo ">
        <div class="container h-100">
            <div class="parent-data-demo banner-safiran" id="bg-banner-demo">
{*                <div id="particles-js"></div>*}
                {*    <div id="large-header" class="large-header">*}
                {*        <canvas id="demo-canvas" width="1280" height="840"></canvas>*}
                {*    </div>*}
                <div class="parent-text-banner-demo">
                    <h2 id="title-banner"> </h2>
                    <p id="caption-banner">  </p>
                </div>
            </div>
        </div>
    </div>
    <div class="search_box container">
        <div class="i_modular_searchBox search_box_div">
            <ul class="__search_box_tabs__ nav"
                id="searchBoxTabs">{include file="./search-box/tabs-search-box.tpl"}</ul>
            <div class="__search_boxes__ tab-content"
                 id="searchBoxContent">{include file="./search-box/boxs-search.tpl"}</div>
        </div>
    </div>
</section>
{include file="include_files/banner-slider.tpl" }
<style>
    .banner-slider-display {
        display: none;
    }
</style>
