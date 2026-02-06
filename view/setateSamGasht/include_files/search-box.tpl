{assign var="type_data" value=['is_active'=>1 , 'limit' =>10]}
{assign var='banners' value=$obj_main_page->galleryBannerMain($type_data)}


<section class="i_modular_banner_gallery banner-kanoun">
<div class="owl-carousel owl-theme owl-banner-kanoun">
    {foreach $banners as $key => $banner}
        <div class="__i_modular_nc_item_class_0 item">
            <img alt='{$banner["title"]}' class="__image_class__" src='{$banner["pic"]}' />
            <div class="banner-text-kanoun">
                <h5 class="__title__">{$banner['title']}</h5>
                <h2 class="__title_class__">{$banner['description']}</h2>
            </div>
        </div>
    {/foreach}
</div>
</section>
<section>
    <div class="i_modular_searchBox search_box">
        <div class="container search_box_div">
            <ul class="__search_box_tabs__ nav" id="searchBoxTabs"
                style="display:none">{include file="./search-box/tabs-search-box.tpl"}</ul>
            <div class="__search_boxes__ tab-content"
                 id="searchBoxContent">{include file="./search-box/boxs-search.tpl"}</div>
        </div>
    </div>
</section>
