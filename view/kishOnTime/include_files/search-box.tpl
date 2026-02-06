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

<div class="i_modular_banner_gallery banner">
    <div class="container-fluid banner-parent"> <!--slider-->
        <div class="row">
            <div class="owl-carousel owl-theme" id="owl-banner">

                {foreach $banners as $key => $banner}
                    <div class="__i_modular_nc_item_class_0 carousel-cell item">
                        <a href="{$banner['link']}">
                            <img alt='{$banner["title"]}' class="__image_class__" height="750" src='{$banner["pic"]}'
                                 width="100%" />
                        </a>
                    </div>
                {/foreach}
            </div>
        </div>
    </div>
    <div class="i_modular_searchBox search_box">
        <div class="container">
            <div class="search_box_div">
                <ul class="__search_box_tabs__ nav"
                    id="searchBoxTabs">{include file="./search-box/tabs-search-box.tpl"}</ul>
                <div class="__search_boxes__ tab-content"
                     id="searchBoxContent">{include file="./search-box/boxs-search.tpl"}</div>
            </div>
        </div>
    </div>
    <div class="wave-bg-parent">
        <div class="wave-bg"></div>
    </div>
</div>
