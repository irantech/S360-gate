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
                            
<section class="i_modular_banner_gallery banner-demo">
    <!--    <div class="banner-owl">-->
    <!--        <img src="project_files/images/banner/s0.jpg" alt="banner-images">-->
    <!--    </div>-->
    <div class="container">
    <div class="parent-banner-demo">
    <div class="text-banner-demo">
    <h2> کشف مقاصد جدید گردشگری!</h2>
    <h2>تجربیات فراموش نشدنی و خاطره انگیز</h2>

    </div>
    <div class="search_box">
    <div class="i_modular_searchBox search_box_div">
    <ul class="__search_box_tabs__ nav" id="searchBoxTabs">{include file="./search-box/tabs-search-box.tpl"}</ul>
    <div class="__search_boxes__ tab-content" id="searchBoxContent">{include file="./search-box/boxs-search.tpl"}</div>
    </div>
    </div>
    </div>
    </div>
</section>

{include file="include_files/banner-slider.tpl"}
