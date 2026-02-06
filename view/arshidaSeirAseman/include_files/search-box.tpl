{assign var="type_data" value=['is_active'=>1 , 'limit' =>1 , 'order' => 'ASC']}
{assign var='banners' value=$obj_main_page->galleryBannerMain($type_data)}


<section class="i_modular_banner_gallery banner-safiran ">
    {if $banners}
    {foreach $banners as $key => $banner}
        <img src="{$banner['pic']}" alt="{$banner['title']}">
    {/foreach}
    {else}
{*        <img alt="img-banner" class="__image_class__" src="project_files/images/bg.jpeg" />*}
    {/if}
    <div class="search_box">
        <div class="container">
            <div class="search_box_div">
                <ul class="__search_box_tabs__ nav" id="searchBoxTabs">
                    {include file="./search-box/tabs-search-box.tpl"}
                </ul>
                <div class="tab-content" id="searchBoxContent">
                    {include file="./search-box/boxs-search.tpl"}

                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .banner-slider {
        display: none;
    }
</style>
