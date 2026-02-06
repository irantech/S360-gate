

<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">
 <div class="form-group">
  <select aria-hidden="true" class="select2_in select2-hidden-accessible international-tour-origin-city-js" data-placeholder=" ##Origincity##" id="tourOriginCityPortal" name="tourOriginCityPortal" onchange="getArrivalCitiesTour('international',this)" tabindex="-1">
   {assign var="params" value=['type'=>'international']}
   {assign var="cities_international" value=$obj_main_page->getOriginTourCities($params)}
   <option value="">##ChoseOption##...</option>
   {foreach $cities_international as $city}
    <option value="{$city['id']}">{$city['name']}</option>
   {/foreach}
  </select>
 </div>
</div>