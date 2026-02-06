{assign var="countries" value=$obj_main_page->getCountryEntertainment()}

{assign var="langVar" value=""}
{assign var="priceVar" value=""}
{if $smarty.const.SOFTWARE_LANG neq 'fa'}
 {assign var="langVar" value="_en"}
 {assign var="priceVar" value="_en"}
{/if}
<div class="__box__ tab-pane {if  $smarty.const.GDS_SWITCH eq 'page'} active {/if}" id="Entertainment">
 <h4 class='title-searchBox-mobile'>جستجو برای تفریحات  </h4>
 <div class="d-flex flex-wrap gap-search-box">
  <div class="parent-empty-search-box"></div>
  <div class="d-flex flex-wrap w-100">
   <form data-action="https://s360online.iran-tech.com/" class="d_contents" method="post"
         name="submit_tafrih_form" id="submit_tafrih_form">
    <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
     <div class="parent-input-search-box">
      <i class="parent-svg-input-search-box">
       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M336 192c0-79.5-64.5-144-144-144S48 112.5 48 192c0 12.4 4.5 31.6 15.3 57.2c10.5 24.8 25.4 52.2 42.5 79.9c28.5 46.2 61.5 90.8 86.2 122.6c24.8-31.8 57.8-76.4 86.2-122.6c17.1-27.7 32-55.1 42.5-79.9C331.5 223.6 336 204.4 336 192zm48 0c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192zm-160 0a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm-112 0a80 80 0 1 1 160 0 80 80 0 1 1 -160 0z"/></svg>
      </i>
      <div class="caption-input-search-box">کشور مقصد خود را وارد کنید</div>
      <select data-placeholder="مقصد ( کشور )"
              name="select_entertainment_country"
              id="select_entertainment_country"
              class="select2_in entertainment-destination-country-js select2-hidden-accessible"
              onchange="getEntertainmentCities($(this))" tabindex="-1" aria-hidden="true">
       <option value="">انتخاب کنید...</option>
       {foreach $countries as $country}
        <option value='{$country['id']}'>{$country["name$langVar"]}</option>
       {/foreach}
      </select>
     </div>
    </div>
    <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
     <div class="parent-input-search-box">
      <i class="parent-svg-input-search-box">
       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M336 192c0-79.5-64.5-144-144-144S48 112.5 48 192c0 12.4 4.5 31.6 15.3 57.2c10.5 24.8 25.4 52.2 42.5 79.9c28.5 46.2 61.5 90.8 86.2 122.6c24.8-31.8 57.8-76.4 86.2-122.6c17.1-27.7 32-55.1 42.5-79.9C331.5 223.6 336 204.4 336 192zm48 0c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192zm-160 0a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm-112 0a80 80 0 1 1 160 0 80 80 0 1 1 -160 0z"/></svg>
      </i>
      <div class="caption-input-search-box">شهر مقصد خود را وارد کنید</div>
      <select data-placeholder="مقصد ( شهر )" name="select_entertainment_city" id="select_entertainment_city"
              class="select2_in  select2-hidden-accessible entertainment-city-js"
              onchange="getEntertainmentCategoriesSearchBox($(this))" tabindex="-1" aria-hidden="true">
       <option value="">انتخاب کنید...</option>
      </select></div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search p-1">
     <div class="parent-input-search-box">
      <i class="parent-svg-input-search-box">
       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M231.2 5.092C239 1.732 247.5 0 256 0C264.5 0 272.1 1.732 280.8 5.092L490.1 94.79C503.4 100.5 512 113.5 512 128C512 142.5 503.4 155.5 490.1 161.2L280.8 250.9C272.1 254.3 264.5 256 256 256C247.5 256 239 254.3 231.2 250.9L21.9 161.2C8.614 155.5 0 142.5 0 128C0 113.5 8.614 100.5 21.9 94.79L231.2 5.092zM256 48C253.1 48 251.1 48.41 250.1 49.21L66.26 128L250.1 206.8C251.1 207.6 253.1 208 256 208C258 208 260 207.6 261.9 206.8L445.7 128L261.9 49.21C260 48.41 258 48 256 48V48zM250.1 334.8C251.1 335.6 253.1 336 256 336C258 336 260 335.6 261.9 334.8L452 253.3C447.4 246.4 446.5 237.2 450.5 229.3C456.5 217.4 470.9 212.6 482.7 218.5L491.8 223.1C504.2 229.3 512 241.9 512 255.7C512 270.4 503.3 283.6 489.9 289.3L280.8 378.9C272.1 382.3 264.5 384 256 384C247.5 384 239 382.3 231.2 378.9L22.81 289.6C8.971 283.7 .0006 270.1 .0006 255C.0006 242.9 5.869 231.5 15.76 224.4L26.05 217C36.84 209.3 51.83 211.8 59.53 222.6C66.15 231.9 65.24 244.3 57.1 252.5L250.1 334.8zM59.53 350.6C66.15 359.9 65.24 372.3 57.1 380.5L250.1 462.8C251.1 463.6 253.1 464 256 464C258 464 260 463.6 261.9 462.8L452 381.3C447.4 374.4 446.5 365.2 450.5 357.3C456.5 345.4 470.9 340.6 482.7 346.5L491.8 351.1C504.2 357.3 512 369.9 512 383.7C512 398.4 503.3 411.6 489.9 417.3L280.8 506.9C272.1 510.3 264.5 512 256 512C247.5 512 239 510.3 231.2 506.9L22.81 417.6C8.971 411.7 .001 398.1 .001 383C.001 370.9 5.87 359.5 15.76 352.4L26.05 345C36.84 337.3 51.83 339.8 59.53 350.6L59.53 350.6z"/></svg>
      </i>
      <div class="caption-input-search-box">دسته بندی را انتخاب کنید</div>
      <select data-placeholder="انتخاب دسته بندی"
              name="select_entertainment_category"
              id="select_entertainment_category"
              class="select2_in  select2-hidden-accessible category-entertainment-js"
              onchange="getEntertainmentSubCategories($(this))"
              tabindex="-1" aria-hidden="true">
       <option value="">انتخاب کنید...</option>
      </select></div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search p-1">
     <div class="parent-input-search-box">
      <i class="parent-svg-input-search-box">
       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M336 56c0-4.4 3.6-8 8-8H456c4.4 0 8 3.6 8 8V216c0 13.3 10.7 24 24 24h80 16c4.4 0 8 3.6 8 8V488c0 13.3 10.7 24 24 24s24-10.7 24-24V248c0-28.2-20.9-51.6-48-55.4V120c0-13.3-10.7-24-24-24s-24 10.7-24 24v72H512V56c0-30.9-25.1-56-56-56H344c-30.9 0-56 25.1-56 56V488c0 13.3 10.7 24 24 24s24-10.7 24-24V56zm32 40v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V96c0-8.8-7.2-16-16-16H384c-8.8 0-16 7.2-16 16zm16 80c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V192c0-8.8-7.2-16-16-16H384zM368 288v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V288c0-8.8-7.2-16-16-16H384c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V288c0-8.8-7.2-16-16-16H512zM496 384v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V384c0-8.8-7.2-16-16-16H512c-8.8 0-16 7.2-16 16zM224 160c0-53-43-96-96-96c-54 0-96 43-96 96c0 6 0 11 1 16C13 190 0 214 0 240c0 45 35 80 80 80H96V480c0 18 14 32 32 32c17 0 32-14 32-32V320h16c44 0 80-35 80-80c0-26-14-50-34-64c1-5 2-10 2-16z"/></svg>
      </i>
      <div class="caption-input-search-box">تفریحات خود را انتخاب کنید</div>
      <select data-placeholder=" مجموعه تفریحات"
              name="select_entertainment_sub_category"
              id="select_entertainment_sub_category"
              class="select2_in select2-hidden-accessible sub-category-entertainment-js"
              tabindex="-1" aria-hidden="true">
       <option value="">انتخاب کنید...</option>
      </select>
     </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 col-12 btn_s col_search margin-center p-1">
     <button type="button" onclick="searchEntertainment()"
             class="btn theme-btn seub-btn b-0">
      <span>جستجو</span>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M368 208A160 160 0 1 0 48 208a160 160 0 1 0 320 0zM337.1 371.1C301.7 399.2 256.8 416 208 416C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208c0 48.8-16.8 93.7-44.9 129.1L505 471c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L337.1 371.1z"/></svg>
     </button>
    </div>
   </form>
  </div>
 </div>
</div>