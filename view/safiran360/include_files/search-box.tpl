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
                            {assign var="services_array_json" value= '{"Flight": "Flight", "Hotel": "Hotel", "Bus": "Bus", "Insurance": "Insurance", "Tour": "Tour", "Visa": "Visa"}'}
                                            {assign var="services_array" value=$services_array_json|json_decode}
<span class="i_modular_banner_gallery">

<section class="banner-safiran">
{if $banners[0] }
<img alt="{$banners[0]['title']}" class="__i_modular_c_item_class_0 __image_class__" src="{$banners[0]['pic']}"/>
{/if}
</section>
<section class="i_modular_searchBox search_box">
<div class="container">
<div class="search_box_div">
<ul class="__search_box_tabs__ nav" id="searchBoxTabs">{include file="./search-box/tabs-search-box.tpl"}</ul>
<div class="__search_boxes__ tab-content" id="searchBoxContent">{include file="./search-box/boxs-search.tpl"}</div>
</div>
</div>
</section>
</span>
