<div class="__box__ tab-pane {if  $smarty.const.GDS_SWITCH eq 'page'}active{/if}" id="Tour">

 <div class="empty-div"></div>
 <div id="internal_tour" class="internal-tour-js">
  <div class="col-12">
   <div class="row">
    <form data-action="https://s360online.iran-tech.com/" class="d_contents"
          method="post"
          name="gdsTourLocal" id="gdsTourLocal" target="_blank">

     {include file="./sections/tour/internal/origin_city_tour.tpl"}
     {include file="./sections/tour/internal/destination_city_tour.tpl"}
     {include file="./sections/tour/internal/date_teravel.tpl"}

     <div class="col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search p-1">
      <button type="button" onclick="searchInternalTour()" class="btn theme-btn seub-btn b-0">
       <span>بحث</span>
      </button>
     </div>
    </form>
   </div>
  </div>
 </div>

</div>