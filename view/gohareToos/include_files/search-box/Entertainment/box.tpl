{assign var="countries" value=$obj_main_page->getCountryEntertainment()}<div class="__box__ tab-pane {if $active} active {/if}" id="Entertainment">
 <div class="empty-div">
 </div>
 <div class="col-md-12 col-12">
<div class="row">
 <form class="d_contents" data-action="://s360online.iran-tech.com/" id="submit_tafrih_form" method="post" name="submit_tafrih_form">
<div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search p-1">
 <div class="form-group">
<select aria-hidden="true" class="select2_in entertainment-destination-country-js select2-hidden-accessible" data-placeholder="انتخاب کشور مقصد" id="select_entertainment_country" name="select_entertainment_country" onchange="getEntertainmentCities($(this))" tabindex="-1">
 <option value="">##ChoseOption##...</option>
{foreach $countries as $country}
<option value='{$country['id']}'>{$country['name']}</option>
{/foreach}
</select>
 </div>
</div>
<div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search p-1">
 <div class="form-group">
<select aria-hidden="true" class="select2_in select2-hidden-accessible entertainment-city-js" data-placeholder="انتخاب شهر مقصد" id="select_entertainment_city" name="select_entertainment_city" onchange="getEntertainmentCategoriesSearchBox($(this))" tabindex="-1">
<option  value="">##ChoseOption##...</option>
</select>
 </div>
</div>
<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
 <div class="form-group">
<select aria-hidden="true" class="select2_in select2-hidden-accessible category-entertainment-js" data-placeholder="انتخاب دسته بندی" id="select_entertainment_category" name="select_entertainment_category" onchange="getEntertainmentSubCategories($(this))" tabindex="-1">
<option  value="">##ChoseOption##...</option>
</select>
 </div>
</div>
<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
 <div class="form-group">
<select aria-hidden="true" class="select2_in select2-hidden-accessible sub-category-entertainment-js" data-placeholder=" مجموعه تفریحات" id="select_entertainment_sub_category" name="select_entertainment_sub_category" tabindex="-1">
<option  value="">##ChoseOption##...</option>
</select>
 </div>
</div>
<div class="col-lg-2 col-md-4 col-sm-6 col-12 btn_s col_search margin-center p-1">
 <button class="btn theme-btn seub-btn b-0" onclick="searchEntertainment()" type="button">
<span>
 جستجو
</span>
 </button>
</div>
 </form>
</div>
 </div>
</div>
