{assign var="type_data" value=['is_active'=>1 , 'limit' =>5]}
{assign var='banners' value=$obj_main_page->galleryBannerMain($type_data)}



<section class="i_modular_banner_gallery banner banner-safiran" >
{*{if $banners[0]['iframe_code'] }*}
{*<iframe width="100%" height='100%' src="{$banners[0]['iframe_code']}" style='margin: 0 auto;'></iframe>*}
{*{elseif $banners[0]['pic']}*}
{*<video autoplay="" loop="" muted="">*}
{*<source src="{$banners[0]['pic']}" type="video/mp4"/>*}
{*  متأسفیم، مرورگر شما از این ویدیو پشتیبانی نمی کند.*}
{*</video>*}
{*  {else}*}
{*  <video autoplay="" loop="" muted="">*}
{*    <source src="project_files/images/banner.mp4" type="video/mp4"/>*}

{*    متأسفیم، مرورگر شما از این ویدیو پشتیبانی نمی کند.*}

{*  </video>*}
{*{/if}*}

<section class="banner_main">
<div class="container">
<div class="row">
<div class="col-lg-12 col-12">
<section class="i_modular_searchBox search_box">
<div class="search_box_div">
<ul class="__search_box_tabs__ nav" id="searchBoxTabs">{include file="./search-box/tabs-search-box.tpl"}</ul>
<div class="search_box_div">
<div class="__search_boxes__ tab-content" id="searchBoxContent">{include file="./search-box/boxs-search.tpl"}</div>
</div>
</div>
</section>
</div>
</div>
</div>
</section>
</section>
{include file="include_files/banner-slider.tpl"}
