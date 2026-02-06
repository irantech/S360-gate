{assign var="services_array_json" value= '{"Tour": "Tour", "Visa": "Visa" , "Entertainment": "Entertainment"}'}
                                            {assign var="services_array" value=$services_array_json|json_decode}
<div class="i_modular_banner_gallery search_box">
<span class="__banner_tabs__" style="display: none"></span>
<div class="i_modular_searchBox container search_box_div">

<ul class="__search_box_tabs__ nav" id="searchBoxTabs">{include file="./search-box/tabs-search-box.tpl"}</ul>
<div class="__search_boxes__ tab-content" id="searchBoxContent">{include file="./search-box/boxs-search.tpl"}</div>
</div>
</div>
{include file="include_files/banner-slider.tpl" }