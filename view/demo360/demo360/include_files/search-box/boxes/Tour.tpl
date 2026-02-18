<div class="__box__ tab-pane {if  $smarty.const.GDS_SWITCH eq 'page'} active {/if}" id="Tour">
 <h4 class='title-searchBox-mobile'>جستجو برای تورهای داخلی و خارجی</h4>
 <div class="d-flex flex-wrap gap-search-box">
  {include file="./sections/Tour/internal/btn_radio_internal_external.tpl"}

  <div id="internal_tour" class="_internal internal-tour-js w-100 internal-content-tour d_flex flex-wrap">
    <form data-action="https://s360online.iran-tech.com/" class="d_contents" method="post"
          name="gdsTourLocal" id="gdsTourLocal" target="_blank">
     {include file="./sections/Tour/internal/origin_city_tour.tpl"}
     {include file="./sections/Tour/internal/destination_city_tour.tpl"}
     {include file="./sections/Tour/internal/date_teravel.tpl"}

     <div class="col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search p-1">
      <button type="button" onclick="searchInternalTour()" class="btn theme-btn seub-btn b-0">
       <span>جستجو</span>
       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M368 208A160 160 0 1 0 48 208a160 160 0 1 0 320 0zM337.1 371.1C301.7 399.2 256.8 416 208 416C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208c0 48.8-16.8 93.7-44.9 129.1L505 471c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L337.1 371.1z"/></svg>
      </button>
     </div>
    </form>
  </div>
  <div id="international_tour" class="_external international-tour-js w-100 external-content-tour d_flex flex-wrap">
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
       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M368 208A160 160 0 1 0 48 208a160 160 0 1 0 320 0zM337.1 371.1C301.7 399.2 256.8 416 208 416C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208c0 48.8-16.8 93.7-44.9 129.1L505 471c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L337.1 371.1z"/></svg>
      </button>
     </div>
    </form>
  </div>
 </div>
</div>