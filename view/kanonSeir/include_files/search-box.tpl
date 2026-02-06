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
<img alt='{$banner["title"]}' class="__image_class__" src='{$banner["pic"]}'/>
<div class="banner-text-kanoun">
<h5>آژانس مسافرتی کانون سیر</h5>
<h2 class="__title_class__">{$banner['title']}</h2>
</div>
</div>
{/foreach}


</div>
<div class="i_modular_searchBox container">
<div class="search-box" id="btn-search-header-searchBox">
<div class="">
<div class="parent-search-box">
<ul class="__search_box_tabs__ nav nav-tabs" id="myTab" role="tablist">{include file="./search-box/tabs-search-box.tpl"}</ul>
<div class="__search_boxes__ tab-content" id="myTabContent">{include file="./search-box/boxs-search.tpl"}</div>
</div>
</div>
</div>
</div>
</section>
