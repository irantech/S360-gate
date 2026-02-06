
                        {assign var="continents" value=$obj_main_page->getListContinents()}
                    <div class="__box__ tab-pane {if $active} active {/if}" id="Visa">
<div class="col-md-12 col-12">
<div class="row">
<form class="d_contents" data-action="://s360online.iran-tech.com/" id="gdsVisa" method="post" name="gdsVisa" target="_blank">
{include file="./sections/Visa/continent_visa.tpl"}
{include file="./sections/Visa/country_visa.tpl"}
{include file="./sections/Visa/type_visa.tpl"}
{include file="./sections/Visa/passenger_count.tpl"}
<div class="col-lg-2 col-md-4 col-sm-6 col-12 btn_s col_search margin-center">
<button class="btn theme-btn seub-btn b-0" onclick="searchVisa()" type="button">
<span>
 جستجو
</span>
</button>
</div>
</form>
</div>
</div>
</div>
