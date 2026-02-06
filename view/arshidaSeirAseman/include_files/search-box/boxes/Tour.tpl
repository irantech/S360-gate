<div class="__box__ tab-pane {if $active} active {/if}" id="Tour">

 {include file="./sections/Tour/internal/btn_radio_internal_external.tpl"}
 <div id="internal_tour" class="_internal internal-tour-js">
  <div class="col-12">
   <div class="row">
    <form data-action="https://s360online.iran-tech.com/" class="d_contents" method="post"
          name="gdsTourLocal" id="gdsTourLocal" target="_blank">
     {include file="./sections/Tour/internal/origin_city_tour.tpl"}
     {include file="./sections/Tour/internal/destination_city_tour.tpl"}
     {include file="./sections/Tour/internal/date_teravel.tpl"}
     <div class="col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search p-1">
      <button type="button" onclick="searchInternalTour()" class="btn theme-btn seub-btn b-0">
       <span>جستجو</span></button>
     </div>
    </form>
   </div>
  </div>
 </div>
 <div id="international_tour" class="_external international-tour-js">
  <div class="col-12">
   <div class='row'>
    <form data-action="https://s360online.iran-tech.com/" class="d_contents" method="post"
          name="gdsPortalLocal" id="gdsPortalLocal" target="_blank">
     {include file="./sections/Tour/international/country_origin.tpl"}
     {include file="./sections/Tour/international/city_origin.tpl"}
     {include file="./sections/Tour/international/country_destination.tpl"}
     {include file="./sections/Tour/international/city_destination.tpl"}
     {include file="./sections/Tour/international/date_travel.tpl"}
     <div class="col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search p-1">
      <button type="button" onclick="searchInternationalTour()" class="btn theme-btn seub-btn b-0">
       <span>جستجو</span>
      </button>
     </div>
    </form>
   </div>
  </div>
 </div>
</div>