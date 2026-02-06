
<section class="i_modular_banner_gallery banner __banner_tabs__" >
<div class="i_modular_searchBox  search_box">
<div class="container search_box_div">
    {if $page.files.main_file.src && $smarty.const.GDS_SWITCH eq 'page'}
        <h2 class="__title_class__ text-banner">{$page.title}</h2>
    {else}
        {if $smarty.const.GDS_SWITCH eq 'mainPage' }
        <h2 class="__title_class__ text-banner">رزرو هواپیما  </h2>
        {/if}
    {/if}

<ul class="__search_box_tabs__ nav" id="searchBoxTabs">{include file="./search-box/tabs-search-box.tpl"}</ul>
<div class="__search_boxes__ tab-content" id="searchBoxContent">{include file="./search-box/boxs-search.tpl"}</div>
</div>
</div>
</section>
<svg enable-background="new 0 0 500 250" id="circle_banner" preserveaspectratio="none" version="1.1" viewbox="0 0 500 250" x="0px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" y="0px">
<path d="M250,246.5c-97.85,0-186.344-40.044-250-104.633V250h500V141.867C436.344,206.456,347.85,246.5,250,246.5z" fill="#FFFFFF"></path>
</svg>


{include file="include_files/banner-slider.tpl" }