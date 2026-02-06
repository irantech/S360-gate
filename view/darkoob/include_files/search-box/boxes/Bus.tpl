<div class="__box__ tab-pane {if  $smarty.const.GDS_SWITCH eq 'page'} active {/if}" id="Bus">
 <h4 class='title-searchBox-mobile'>جستجو برای اتوبوس</h4>
 <div class="d-flex flex-wrap gap-search-box">
  <div class="parent-empty-search-box"></div>
  <div class="d-flex flex-wrap w-100">
   <form data-action="https://s360online.iran-tech.com/" method="post" target="_blank" class="d_contents" id="gds_local_bus" name="gds_local_bus">
    <div class="col-lg-4 col-md-6 col-sm-6 col-12 col_search p-1">
     <div class="parent-input-search-box">
      <i class="parent-svg-input-search-box">
       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M336 192c0-79.5-64.5-144-144-144S48 112.5 48 192c0 12.4 4.5 31.6 15.3 57.2c10.5 24.8 25.4 52.2 42.5 79.9c28.5 46.2 61.5 90.8 86.2 122.6c24.8-31.8 57.8-76.4 86.2-122.6c17.1-27.7 32-55.1 42.5-79.9C331.5 223.6 336 204.4 336 192zm48 0c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192zm-160 0a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm-112 0a80 80 0 1 1 160 0 80 80 0 1 1 -160 0z"/></svg>
      </i>
      <div class="caption-input-search-box">مبدأ خود را وارد کنید</div>
      <select data-placeholder="مبدأ ( نام شهر)"
              name="origin_bus"
              id="origin_bus"
              class="select-route-bus-js select-origin-route-bus-js"
              tabindex="-1" aria-hidden="true"></select>
     </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12 col_search p-1">
     <div class="parent-input-search-box">
      <i class="parent-svg-input-search-box">
       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M336 192c0-79.5-64.5-144-144-144S48 112.5 48 192c0 12.4 4.5 31.6 15.3 57.2c10.5 24.8 25.4 52.2 42.5 79.9c28.5 46.2 61.5 90.8 86.2 122.6c24.8-31.8 57.8-76.4 86.2-122.6c17.1-27.7 32-55.1 42.5-79.9C331.5 223.6 336 204.4 336 192zm48 0c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192zm-160 0a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm-112 0a80 80 0 1 1 160 0 80 80 0 1 1 -160 0z"/></svg>
      </i>
      <div class="caption-input-search-box">مقصد خود را وارد کنید</div>
      <select data-placeholder="مقصد ( نام شهر)"
              name="destination_bus"
              id="destination_bus"
              class="select-route-bus-js select-destination-route-bus-js select2-hidden-accessible"
              tabindex="-1" aria-hidden="true"></select>
     </div>
    </div>
    <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col p-1">
     <div class="parent-input-search-box">
      <i class="parent-svg-input-search-box">
       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"/></svg>
      </i>
      <label for='departure_date_bus' class="caption-input-search-box">مقصد خود را وارد کنید</label>
      <input type="text"
             class="shamsiDeptCalendar departure-date-bus-js "
             name="departure_date_bus"
             id="departure_date_bus"
             placeholder="تاریخ حرکت">
     </div>
    </div>
    <div class="col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search p-1">
     <button type="button" class="btn theme-btn seub-btn b-0 "
             onclick="searchBus()">
      <span>جستجو</span>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M368 208A160 160 0 1 0 48 208a160 160 0 1 0 320 0zM337.1 371.1C301.7 399.2 256.8 416 208 416C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208c0 48.8-16.8 93.7-44.9 129.1L505 471c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L337.1 371.1z"/></svg>
     </button>
    </div>
   </form>
  </div>
 </div>
</div>