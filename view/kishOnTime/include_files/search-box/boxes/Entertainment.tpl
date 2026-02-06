{assign var="countries" value=$obj_main_page->getCountryEntertainment()}<div class="__box__ tab-pane {if $active} active {/if}" id="Entertainment">
<div class="col-md-12 col-12">
<div class="row">
<form class="d_contents" data-action="://s360online.iran-tech.com/" id="submit_tafrih_form" method="post" name="submit_tafrih_form">
{include file="./sections/Entertainment/country_destination.tpl"}
{include file="./sections/Entertainment/city_destination.tpl"}
{include file="./sections/Entertainment/category_entertainment.tpl"}
{include file="./sections/Entertainment/sub_category_entertainment.tpl"}
<div class="col-lg-2 col-md-4 col-sm-6 col-12 btn_s col_search margin-center p-1">
<button class="btn theme-btn seub-btn b-0" onclick="searchEntertainment()" type="button">
<span>
 جستجو
</span>
</button>
</div>
</form>
</div>
</div>
</div>
