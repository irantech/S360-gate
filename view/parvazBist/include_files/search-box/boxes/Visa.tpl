
                        {assign var="continents" value=$obj_main_page->getListContinents()}
                    <div class="__box__ tab-pane  {if $smarty.const.PAGE_TITLE eq 'visa'}active {/if}" id="Visa">
<div class="col-md-12 col-12">
<div class="row">
<form class="d_contents" data-action="://s360online.iran-tech.com/" id="gdsVisa" method="post" name="gdsVisa" target="_blank">
<div class="col-12 col_search">
<h5>
در فلای ایر تور دنیای شما هیچ مرزی ندارد
 </h5>
</div>
{include file="./sections/Visa/continent_visa.tpl"}
{include file="./sections/Visa/country_visa.tpl"}
{include file="./sections/Visa/type_visa.tpl"}
{include file="./sections/Visa/passenger_count.tpl"}
<div class="col-lg-2 col-sm-6 col-12 btn_s col_search">
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
