{assign var="countries" value=$obj_main_page->getCountryEntertainment()}<div class="__box__ tab-pane {if $active} active {/if}" id="Entertainment">
 <div class="col-md-12 col-12 h-100">
  <div class="row h-100">
   <form class="d_contents" data-action="://s360online.iran-tech.com/" id="submit_tafrih_form" method="post" name="submit_tafrih_form">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12 border-0-parent col_search">
     <div class="form-group" id="box_select_entertainment_country">
      <select aria-hidden="true" class="select2_in entertainment-destination-country-js select2-hidden-accessible" data-placeholder="انتخاب کشور مقصد" id="select_entertainment_country" name="select_entertainment_country" onchange="getEntertainmentCities($(this))" tabindex="-1">

      <option value="null">انتخاب کنید</option>
       {foreach $countries as $country}
        <option value='{$country['id']}'>{$country['name']}</option>
       {/foreach}
      </select>
     </div>
    </div>
    <div class="col-lg-2 col-md-6 col-sm-6 col-12 border-0-parent col_search">
     <div class="form-group">
      <select aria-hidden="true" onchange="getEntertainmentCategoriesSearchBox($(this))"
              class="select2_in select2-hidden-accessible entertainment-city-js" data-placeholder="انتخاب شهر مقصد" id="select_entertainment_city" name="select_entertainment_city" tabindex="-1">
       <option value="">##ChoseOption##...</option>
      </select>
     </div>
    </div>
    <div class="col-lg-2 col-md-6 col-sm-6 col-12 border-0-parent col_search">
     <div class="form-group">
      <select aria-hidden="true" class="select2_in select2-hidden-accessible category-entertainment-js"
              onchange="getEntertainmentSubCategories($(this))"
              data-placeholder="انتخاب دسته بندی" id="select_entertainment_category" name="select_entertainment_category" tabindex="-1">
       <option value="">##ChoseOption##...</option>
      </select>
     </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search pl-2">
     <div class="form-group" id="box_select_entertainment_sub_category">
      <select aria-hidden="true" class="select2_in select2-hidden-accessible sub-category-entertainment-js" data-placeholder=" مجموعه تفریحات" id="select_entertainment_sub_category" name="select_entertainment_sub_category" tabindex="-1">
       <option value="">##ChoseOption##...</option>
      </select>
     </div>
    </div>
    <div class="col-lg-2 col-md-12 col-sm-12 col-12 btn_s col_search margin-center">
     <button onclick="searchEntertainment()" class="btn theme-btn seub-btn b-0" type="button">
      جستجو
     </button>
    </div>
   </form>
  </div>
 </div>
</div>
