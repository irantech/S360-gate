<div class="__box__ tab-pane {if  $smarty.const.GDS_SWITCH eq 'page'}active{/if}" id="Tour">
 <div class="control-section">
  <label for="rdo-50" class="btn-radio select-type-way-js" data-type="tour-plus-hotel">
   <input checked="" type="radio" id="rdo-50" name="select-rb2" value="1" class="tour-plus-hotel-one-way-js">
   <svg width="20px" height="20px" viewBox="0 0 20 20">
    <circle cx="10" cy="10" r="9"></circle>
    <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
    <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
   </svg>
   <span>
                                     <h6>پرواز + هتل </h6>
                                     <em>بلیط + اقامت مناسب با برنامه شما</em>
                                </span>
  </label>
  <label for="rdo-40" class="btn-radio select-type-way-js" data-type="internal-tour">
   <input type="radio" id="rdo-40" name="select-rb2" value="2" class="internal-tour-one-way-js">
   <svg width="20px" height="20px" viewBox="0 0 20 20">
    <circle cx="10" cy="10" r="9"></circle>
    <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
    <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
   </svg>
   <span>
                                     <h6>تور گروهی</h6>
                                     <em>بلیط + اقامت طبق برنامه گروهی</em>
                                </span>
  </label>
 </div>
 <div id="internalTourInfo"  class="info-div">
  <div class="col-12">
   <div class="row">
    <form data-action="https://s360online.iran-tech.com/" class="d_contents"
          method="post"
          name="gdsTourLocal" id="gdsTourLocal" target="_blank" data-target="_blank">
     {include file="./sections/tour/internal/origin_city_tour.tpl"}
     {include file="./sections/tour/internal/destination_city_tour.tpl"}
     {include file="./sections/tour/internal/date_teravel.tpl"}

     <div class="col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search p-1">
      <button type="button" onclick="searchInternalTour()"
              class="btn theme-btn seub-btn b-0">
       <span>جستجو</span></button>
     </div>
    </form>
   </div>
  </div>
 </div>
 <div id="Package"   class="info-div">
  <div class="col-md-12 col-12">
   <div class="row  ">
    <form data-action="https://s360online.iran-tech.com/" method="post" data-target="_self"
          class="d_contents" id="package_form" name="package_form" >

     {include file="./sections/package/origin_search_box.tpl"}
     {include file="./sections/package/destination_search_box.tpl"}
     {include file="./sections/package/date_package.tpl"}
     {include file="./sections/package/passenger_count.tpl"}


     <div class="search_btn_div col-lg-2 col-md-3 col-sm-6 col-12 margin-center search_btn_div p-1">
      <button type="button" onclick="searchPackage('package')"
              class="btn theme-btn seub-btn b-0">
       <span>جستجو</span>
      </button>
     </div>
    </form>
   </div>
  </div>
 </div>
</div>