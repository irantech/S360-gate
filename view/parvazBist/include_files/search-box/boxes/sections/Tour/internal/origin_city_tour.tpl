<div class="col-lg-4 col-sm-6 col-12 col_search">
<div class="form-group">
<select aria-hidden="true" onchange="getArrivalCitiesTour('internal',this)" class="select2_in select2-hidden-accessible internal-origin-tour-js" data-placeholder="نام شهر مبدأ" id="internal_origin_tour" name="internal_origin_tour" tabindex="-1">
{assign var="cities" value=$obj_main_page->getOriginTourCities()}
 <option value="">##ChoseOption##...</option>
{foreach $cities as $city}
<option value="{$city['id']}">{$city['name']}</option>
{/foreach}
 </select>
</div>
</div>