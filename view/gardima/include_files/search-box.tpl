<section class="banner-kanoun">
{*    {assign var="type_data" value=['is_active'=>1 , 'limit' =>5 , 'order' => 'ASC']}*}
{*    {assign var='banners' value=$obj_main_page->galleryBannerMain($type_data)}*}
{*    <div class="owl-carousel owl-theme owl-banner-kanoun">*}
{*        {foreach $banners as $key => $banner}*}
{*        <div class="item">*}
{*            <img src="{$banner['pic']}" alt="{$banner['title']}">*}
{*            <div class="banner-text-kanoun">*}
{*                <h5>{$banner['title']}</h5>*}
{*                <a href='{$banner['url']}'>{$banner['description']}</a>*}
{*            </div>*}
{*        </div>*}
{*        {/foreach}*}
{*    </div>*}



    <div class="container">
        <div class="search_box">
            <div class="search_box_div">
                <ul class="nav" id="searchBoxTabs">
                    {include file="./search-box/tabs-search-box.tpl"}
                </ul>
                <div class="tab-content" id="searchBoxContent">
                    {include file="./search-box/boxs-search.tpl"}
                </div>
            </div>
        </div>
    </div>
</section>