{assign var="type_data" value=['is_active'=>1 , 'limit' =>10]}
{assign var='banners' value=$obj_main_page->galleryBannerMain($type_data)}
{if $page.files.main_file}
    {$banners = [0 => ['pic' => $page.files.main_file.src , 'title' => 'page']]}
{/if}
{*<style>*}
{*    .banner-slider-display {*}
{*        display: none !important;*}
{*    }*}
{*</style>*}
<section class="i_modular_banner_gallery banner-kanoun">
{*    <div class="img-banner "></div>*}
    <div class="titel-banner">
        <h3>پاوان گشت</h3>
        <span>آژانس خدمات مسافرت هوائی و جهانگردی</span>
    </div>
    <div class="owl-carousel owl-theme owl-banner-kanoun">

        {foreach $banners as $key => $banner}
            <a class="__i_modular_nc_item_class_0 item" {if $banner["url"] neq ''} href='{$banner["url"]}' {else} href='javascript:' {/if}>
                <img alt='{$banner["title"]}' class="__image_class__" src='{$banner["pic"]}' />
            </a>
        {/foreach}


    </div>

</section>
<section >
    <div class="i_modular_searchBox search_box   ">
        <div class="container">
            <div class="search_box_div">
                <ul class="__search_box_tabs__ nav"
                    id="searchBoxTabs">{include file="./search-box/tabs-search-box.tpl"}</ul>
                <div class="__search_boxes__ tab-content"
                     id="searchBoxContent">{include file="./search-box/boxs-search.tpl"}</div>
            </div>
        </div>
    </div>
</section>
{include file="include_files/banner-slider.tpl"}
<style>
    .banner-slider-display {
        display: none;
    }
</style>