{assign var="countries" value=$obj_main_page->getCountryEntertainment()}

{assign var="langVar" value=""}
{assign var="priceVar" value=""}
{if $smarty.const.SOFTWARE_LANG neq 'fa'}
 {assign var="langVar" value="_en"}
 {assign var="priceVar" value="_en"}
{/if}

<div class="__box__ tab-pane {if  $smarty.const.GDS_SWITCH eq 'page'}active{/if}" id="Entertainment">
 <div class="col-md-12 col-12">
  <div class="row">
   <form data-action="https://s360online.iran-tech.com/" class="d_contents" method="post"
         name="submit_tafrih_form" id="submit_tafrih_form" target="_blank">
    {include file="./sections/entertainment/country_destination.tpl"}
    {include file="./sections/entertainment/city_destination.tpl"}
    {include file="./sections/entertainment/category_entertainment.tpl"}
    {include file="./sections/entertainment/sub_category_entertainment.tpl"}



    <div class="search_btn_div col-lg-2 col-md-3 col-sm-6 col-12 margin-center search_btn_div p-1">
     <button type="button" onclick="searchEntertainment()"
             class="btn theme-btn seub-btn b-0"><span>جستجو</span></button>
    </div>
   </form>
  </div>
 </div>
</div>