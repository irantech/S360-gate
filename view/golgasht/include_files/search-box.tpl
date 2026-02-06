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
{assign var="services_array_json" value= '{"Hotel": "Hotel"}'}
{assign var="services_array" value=$services_array_json|json_decode}
<section class="i_modular_banner_gallery banner-main">

{foreach $banners as $key => $banner}
<span class="__i_modular_nc_item_class_0">
<img alt='{$banner["title"]}' class="__image_class__" src='{$banner["pic"]}'/>
</span>
{/foreach}
<section class="search_box">
    <div class="i_modular_searchBox container search_box_div">
        <ul class="__search_box_tabs__ nav" id="searchBoxTabs">
            {include file="./search-box/tabs-search-box.tpl"}
        </ul>
        <div class="__search_boxes__ tab-content" id="searchBoxContent">
            {include file="./search-box/boxs-search.tpl"}
        </div>
    </div>
</section>
<svg enable-background="new 0 0 500 250" id="circle_banner" preserveaspectratio="none" version="1.1" viewbox="0 0 500 250" x="0px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" y="0px"><path d="M250,246.5c-97.85,0-186.344-40.044-250-104.633V250h500V141.867C436.344,206.456,347.85,246.5,250,246.5z" fill="#FFFFFF"></path></svg>
</section>
